<?php

namespace Ovoads\Controllers;

use Ovoads\BackOffice\Request;
use Ovoads\Models\AdDomainList;
use Ovoads\Models\AdReport;
use Ovoads\Models\AdSize;
use Ovoads\Models\Advertise;
use Ovoads\Lib\CurlRequest;

class AdController extends Controller
{
    // display ad where ad script pasted
    public function displayAd()
    {
        global $wpdb;
        $table_name = $wpdb->base_prefix . 'ovoads_advertises';
        $request    = new Request;

        $ip =  filter_var(@$_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        $token = get_option('ovoads_apikey');
        $currentUrl = sanitize_text_field($_SERVER['HTTP_HOST']);
        $browserType = $this->getBrowserType();
        $os = $this->getOperatingSystem();

        if ($token == '' ) {
            echo esc_html__('Invalid API Key or URL', 'ovoads');
            exit;
        }

        $ipInfoUrl = "https://ipinfo.io/$ip/json/?token=$token";
        $response = wp_remote_get($ipInfoUrl);
    
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            echo esc_html__('Error fetching ad content', 'ovoads');
            exit;
        }
    
        $response_body = wp_remote_retrieve_body($response);
        $response = json_decode($response_body);
    
        if (!$response) {
            echo esc_html__('Error decoding response', 'ovoads');
            exit;
        }

        $checkBlockedIp = AdReport::where('ip', $response->ip)->where('ip_status', 1)->first();
        if ($checkBlockedIp) {
            exit;
        }

        $ads = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $table_name WHERE `status` = %d AND `ad_size_id` = %d ORDER BY RAND()",
				1,
				$request->ad_size
			)
		);
        
        
        $domain = AdDomainList::where('domain_name', $currentUrl)->first();
        $adSize = AdSize::where('id', $request->ad_size)->first();

        if (!$ads) {
            exit;
        }
        $listedDomains = AdDomainList::where('status', 1)->get('domain_name');
        $arr = [];
        foreach ($listedDomains as $item) {
            $arr[] = $item->domain_name;
        }

        $foundedDomain = array_search($currentUrl, $arr);
        if ($foundedDomain === false) {
            exit;
        }

        $innerAdContent = '';
        foreach ($ads as $ad) {
            $adKeywords = json_decode($ad->keywords);
            $domainKeywords =  json_decode($domain->keywords);
            $exists = false;
            if ($adKeywords) {
                foreach ($adKeywords as $ad_key) {
                    if (in_array($ad_key, $domainKeywords)) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    exit;
                }
            }
            Advertise::where('ad_code', $ad->ad_code)->update([
                'impressions' => $ad->impressions + 1,
            ]);

            AdReport::insert([
                'ad_id' => $ad->id,
                'type' => 'impressions',
                'host' => $currentUrl,
                'browser' => $browserType,
                'country' => $response->country,
                'os' => $os,
                'ip' => $response->ip
            ]);

            $innerAdContent .= '
            <div style="position:relative; z-index: 0; display:inline-block;margin-left: 2px; width:' . esc_attr($adSize->width) . ';height:'. esc_attr($adSize->height) .' ">

                <a class="ad-redirect-link" data-ad="' . intval($ad->id) . '" href="' . esc_url($ad->redirect_url) . '" target="_blank" ><img src="' . ovoads_get_media_file($ad->ad_image) . '" width="' . esc_attr($adSize->width) . '" height="' . esc_attr($adSize->height) . '">
                </a>

                <strong style="background-color:#e6e6e6;position:absolute;right:0;top:0;font-size: 8px;color: #666666;padding:3px;margin-right:15px; line-height:20px;">Ad by ' . get_bloginfo() . '</strong>

                <span class="ad-inner-remove-icon" style="position:absolute;right:0;top:0;width:15px;height:26px;background-color:#f00;font-size:10px;color:#fff;border-radius:1px;cursor:pointer;display:flex;align-items: center;justify-content: center;">x</span>
                
            </div>';
        }

        echo wp_kses_post($innerAdContent);
        exit;
    }

    // update the click count
    public function updateClick()
    {
        $request = new Request;

        $ip = filter_var(@$_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        $token = get_option('ovoads_apikey');
        $currentUrl = sanitize_text_field($_SERVER['HTTP_HOST']);
        $browserType = $this->getBrowserType();
        $os = $this->getOperatingSystem();

        if (empty($token) || empty($currentUrl)) {
            echo esc_html__('Invalid API Key or URL', 'ovoads');
            exit;
        }

        $ipInfoUrl = "https://ipinfo.io/$ip/json/?token=$token";
        $response = wp_remote_get($ipInfoUrl);

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            echo esc_html__('Error fetching IP information', 'ovoads');
            exit;
        }

        $response_body = wp_remote_retrieve_body($response);
        $response = json_decode($response_body);

        if (!$response) {
            echo esc_html__('Error decoding IP information response', 'ovoads');
            exit;
        }

        $ad = Advertise::find($request->ad_id);

        if ($ad) {
            Advertise::where('id', $ad->id)->update([
                'clicks' => $ad->clicks + 1,
            ]);

            AdReport::insert([
                'ad_id'   => $ad->id,
                'type'    => 'click',
                'host'    => $currentUrl,
                'browser' => $browserType,
                'country' => $response->country,
                'os'      => $os,
                'ip'      => $ip,
            ]);
        }

        exit();
    }


    // this method call from hook
    public function giveHeaderAccess()
    {
        $request = new Request;
        if ($request->ad_code) {
            if ($request->ad_code == 'from_click') {
                $idExists = Advertise::where('id', $request->ad_id)->first();
                if ($idExists) {
                    header('Access-Control-Allow-Origin: *');
                }
            } else {
                $codeExists = Advertise::where('ad_code', $request->ad_code)->first();
                if ($codeExists) {
                    header('Access-Control-Allow-Origin: *');
                }
            }
        }
    }



    function getBrowserType() {
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES) : '';

        if (preg_match('/opr\//i', $userAgent) || !!preg_match('/opr\//i', $userAgent)) {
            return 'Opera';
        } elseif (preg_match('/edg/i', $userAgent)) {
            return 'Microsoft-Edge';
        } elseif (preg_match('/chrome|chromium|crios/i', $userAgent)) {
            return 'Google-Chrome';
        } elseif (preg_match('/firefox|fxios/i', $userAgent)) {
            return 'Mozilla-Firefox';
        } elseif (preg_match('/safari/i', $userAgent)) {
            return 'Apple Safari';
        } elseif (preg_match('/trident/i', $userAgent)) {
            return 'Microsoft-Internet-Explorer';
        } elseif (preg_match('/ucbrowser/i', $userAgent)) {
            return 'UC Browser';
        } elseif (preg_match('/samsungbrowser/i', $userAgent)) {
            return 'Samsung-Browser';
        } else {
            return 'Unknown-browser';
        }
    }

    function getOperatingSystem() {
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? htmlspecialchars($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES) : '';
        $operatingSystem = "Unknown";
    
        if (preg_match('/Windows/i', $userAgent)) {
            $operatingSystem = "Windows";
        } elseif (preg_match('/Mac/i', $userAgent)) {
            $operatingSystem = "macOS";
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $operatingSystem = "Linux";
        }
    
        return $operatingSystem;
    }


}
