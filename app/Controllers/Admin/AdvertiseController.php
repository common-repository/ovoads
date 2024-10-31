<?php

namespace Ovoads\Controllers\Admin;

use Ovoads\BackOffice\Request;
use Ovoads\Controllers\Controller;
use Ovoads\Models\AdKeyword;
use Ovoads\Models\AdReport;
use Ovoads\Models\AdSize;
use Ovoads\Models\Advertise;

class AdvertiseController extends Controller
{
    // ad list page
    public function index()
    {
        $pageTitle = "All Ads";
        $search = sanitize_text_field(ovoads_request()->search);
        if ($search != '') {
            $advertises = Advertise::searchable('title')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $advertises = Advertise::orderBy('created_at', 'desc')->paginate(20);
        }

        $this->view('admin/advertise/index', compact('pageTitle', 'advertises'));
    }

    // load ad create page
    public function create()
    {
        $pageTitle = 'Create New Ad';
        $activeKeywords = AdKeyword::where('status', 1)->get();
        $adSizes = AdSize::orderBy('created_at', 'desc')->get();
        $this->view('admin/advertise/create', compact('pageTitle', 'adSizes', 'activeKeywords'));
    }
    // ad store on database
    public function store()
    {
        $request = new Request;
        $request->validate([
            'ad_title' => 'required',
            'size_id' => 'required',
            'ad_redirect_url' => 'required',
            'ad_image' => 'required'
        ]);

        $data = [];
        $data['title'] = sanitize_text_field($request->ad_title);
        $data['ad_code'] = ovoads_trx(20);
        $data['ad_size_id'] = sanitize_text_field($request->size_id);
        $data['redirect_url'] = sanitize_text_field($request->ad_redirect_url);
        $data['ad_image'] = sanitize_text_field($request->ad_image);
        $data['keywords'] = wp_json_encode($request->keywords);

        Advertise::insert($data);

        $notify[] = ['success', 'Ad has been saved successfully.'];
        ovoads_back($notify);
    }

    // load ad edit page
    public function edit()
    {
        $request = new Request;
        $pageTitle = 'Edit Ad';
        $ad = Advertise::findOrFail($request->id);
        $adSizes = AdSize::orderBy('created_at', 'desc')->get();
        $activeKeywords = AdKeyword::where('status', 1)->get();
        $this->view('admin/advertise/edit', compact('pageTitle', 'ad', 'adSizes', 'activeKeywords'));
    }
    // update ad data
    public function update()
    {
        $request = new Request;
        $request->validate([
            'ad_title' => 'required',
            'size_id' => 'required',
            'ad_redirect_url' => 'required',

        ]);

        Advertise::where('id', $request->id)->update([
            'title' => sanitize_text_field($request->ad_title),
            'ad_size_id' => sanitize_text_field($request->size_id),
            'redirect_url' => sanitize_text_field($request->ad_redirect_url),
            'ad_image' => sanitize_text_field($request->ad_image),
            'keywords' => wp_json_encode($request->keywords) 
        ]);

        $notify[] = ['success', 'Ad has been updated successfully.'];
        ovoads_back($notify);
    }

    // ad  active inactice status
    public function status()
    {
        $request = new Request;
        $ad = Advertise::where('id', $request->id)->first();
        Advertise::where('id', $ad->id)->update([
            'status' => $ad->status == 1 ? 0 : 1
        ]);
        $notify[] = ['success', 'Ad status updated successfully'];
        ovoads_back($notify);
    }

    // ad details
    public function detail()
    {
        $request = new Request;
        $pageTitle = 'Ad Report';
        $ad = Advertise::findorFail($request->id);
        $this->view('admin/advertise/detail', compact('pageTitle', 'ad'));
    }


    public function detailStatistic()
    {


        $request = new Request;
        if ($request->showType == 'click') {
            $adReport = AdReport::where('ad_id', $request->ad_id)->where('type', 'click')->get('browser,os,country,host');
            if ($request->duration == 'week') {
                $subDays = ovoads_date()->subWeeks(1)->toDateTime();
                $adReport = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subDays)->get('browser,os,country,host');
            } elseif ($request->duration == 'month') {
                $subMonth = ovoads_date()->subMonths(1)->toDateTime();
                $adReport = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subMonth)->get('browser,os,country,host');
            } elseif ($request->duration == 'year') {
                $subYears = ovoads_date()->subYears(1)->toDateTime();
                $adReport = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subYears)->get('browser,os,country,host');
            }
        }
        if ($request->showType == 'impression') {
            $adReport = AdReport::where('ad_id', $request->ad_id)->where('type', 'impression')->get('browser,os,country,host');
            if ($request->duration == 'week') {
                $subDays = ovoads_date()->subWeeks(1)->toDateTime();
                $adReport = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subDays)->get('browser,os,country,host');
            } elseif ($request->duration == 'month') {
                $subMonth = ovoads_date()->subMonths(1)->toDateTime();
                $adReport = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subMonth)->get('browser,os,country,host');
            } elseif ($request->duration == 'year') {
                $subYears = ovoads_date()->subYears(1)->toDateTime();
                $adReport = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subYears)->get('browser,os,country,host');
            } else {
                $adReport = AdReport::where('ad_id', $request->ad_id)->get('browser,os,country,host');
            }
        }

        $result = [];
        foreach ($adReport as $item) {
            foreach ($item as $key => $value) {
                $key = strtolower($key);
                if (!isset($result[$key])) {
                    $result[$key] = [];
                }
                if (isset($result[$key][$value])) {
                    $result[$key][$value]++;
                } else {
                    $result[$key][$value] = 1;
                }
            }
        }
        $browserNameArr = [];
        $browserCountArr = [];
        $osNameArr = [];
        $osCountArr = [];
        $countryNameArr = [];
        $countryCountArr = [];
        $hostNameArr = [];
        $hostCountArr = [];
        foreach ($result['browser'] as $name => $num) {
            $browserNameArr[] = $name;
            $browserCountArr[] = $num;
        }
        foreach ($result['os'] as $name => $num) {
            $osNameArr[] = $name;
            $osCountArr[] = $num;
        }
        foreach ($result['country'] as $name => $num) {
            $countryNameArr[] = $name;
            $countryCountArr[] = $num;
        }
        foreach ($result['host'] as $name => $num) {
            $hostNameArr[] = $name;
            $hostCountArr[] = $num;
        }
        wp_send_json([
            'browser_name' => $browserNameArr,
            'browser_count' => $browserCountArr,
            'os_name' => $osNameArr,
            'os_count' => $osCountArr,
            'country_name' => $countryNameArr,
            'country_count' => $countryCountArr,
            'host_name' => $hostNameArr,
            'host_count' => $hostCountArr
        ]);
        die;
    }

    //dashboard chart data
    public function showStatisticsOnDashboard()
    {
        $activeAdsRow = Advertise::where('status', 1)->get('clicks,impressions');
        $clicksArray = [];
        $impressionsArray = [];
        foreach ($activeAdsRow as $item) {
            $clicksArray[] = $item->clicks;
            $impressionsArray[] = $item->impressions;
        }
        wp_send_json([
            'click' => $clicksArray,
            'impression' => $impressionsArray,
            'adsRowCount' => count($activeAdsRow)
        ]);
        die;
    }

    public function ipStatus()
    {
        $request = new Request;
        $getRow = AdReport::where('id', $request->id)->first();

        // Toggle the 'ip_status' value
        $newIpStatus = $getRow->ip_status == 1 ? 0 : 1;

        AdReport::where('id', $getRow->id)->update([
            'ip_status' => $newIpStatus
        ]);

        $notify[] = ['success', 'Ip status updated successfully'];
        ovoads_back($notify);
    }

    public function ipList()
    {
        $request = new Request;

        if ($request->duration == 'week') {
            $subDays = ovoads_date()->subWeeks(1)->toDateTime();
            $adReportsIp = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subDays);
        } elseif ($request->duaration == 'month') {
            $subMonth = ovoads_date()->subMonths(1)->toDateTime();
            $adReportsIp = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subMonth);
        } elseif ($request->duration == 'year') {
            $subYears = ovoads_date()->subYears(1)->toDateTime();
            $adReportsIp = AdReport::where('ad_id', $request->ad_id)->where('created_at', '>=', $subYears);
        } else {
            $adReportsIp = AdReport::where('ad_id', $request->ad_id);
        }
        $adReportsIp = $adReportsIp->skip($request->skip)->limit(10)->get();

        $output = '';
        foreach ($adReportsIp as $r) {
            $output .= '<tr>
                    <td>' . $r->ip . '</td>
                    <td>' . $r->country . '</td>
                    <td>' . $r->host . '</td>
                    <td>' . $r->browser . '</td>
                    <td>
                        ' . ($r->ip_status == 1 ? '<a href="admin.php?page=ovoads_advertise' . ovoads_route_link('admin.ad.report.ip.status', ovoads_request()->page) . '&id=' . intval($r->id) . '" class="btn btn-sm btn-danger btn--success">Unblock</a>' : '<a href="admin.php?page=ovoads_advertise' . ovoads_route_link('admin.ad.report.ip.status', ovoads_request()->page) . '&id=' . intval($r->id) . '" class="btn btn-sm btn-danger btn--danger">Block</a>') . '
                            
                    </td>
                </tr>';
        }
        wp_send_json([
            'html' => $output,
        ]);
        die;
    }


    public function ipLogs()
    {
        $request = new Request();
        $pageTitle = 'Advertise Ip Logs';
        $search = sanitize_text_field(ovoads_request()->search);
        $ipLogs = AdReport::with(['ad'])->searchable('ip')->orderBy('created_at', 'asc')->paginate(20);
        $this->view('admin/advertise/ip-logs', compact('pageTitle', 'ipLogs'));
    }
}
