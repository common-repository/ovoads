<?php

use Ovoads\BackOffice\Abort;
use Ovoads\BackOffice\Facade\DB;
use Ovoads\BackOffice\Facade\Session as FacadeSession;
use Ovoads\BackOffice\Request;
use Ovoads\BackOffice\Session;
use Ovoads\BackOffice\System;
use Ovoads\Lib\OvoadsDate;

if (!function_exists('ovoads_system_details')) {
    function ovoads_system_details()
    {
        $system['prefix'] = 'wp_';
        $system['real_name'] = 'ovoads';
        $system['name'] = $system['prefix'] . 'ovoads';
        $system['version'] = '1.1';
        $system['build_version'] = '1.1.6';
        return $system;
    }
}

if (!function_exists('ovoads_system_instance')) {
    function ovoads_system_instance()
    {
        return System::getInstance();
    }
}

if (!function_exists('dd')) {
    function ovoads_dd(...$data)
    {
        foreach ($data as $item) {
            echo "<pre style='background: #001140;color: #00ff4e;padding: 20px;'>";
            print_r($item);
            echo "</pre>";
        }
        exit;
    }
}

if (!function_exists('dump')) {
    function ovoads_dump(...$data)
    {
        foreach ($data as $item) {
            echo "<pre style='background: #001140;color: #00ff4e;padding: 20px;'>";
            print_r($item);
            echo "</pre>";
        }
    }
}

if (!function_exists('ovoads_layout')) {
    function ovoads_layout($ovoads_layout)
    {
        global $systemLayout;
        $systemLayout = $ovoads_layout;
    }
}

if (!function_exists('ovoads_route')) {
    function ovoads_route($routeName)
    {
        $route = ovoads_system_instance()->route($routeName);
        return ovoads_to_object($route);
    }
}

if (!function_exists('ovoads_to_object')) {
    function ovoads_to_object($args)
    {
        if (is_array($args)) {
            return (object) array_map(__FUNCTION__, $args);
        } else {
            return $args;
        }
    }
}

if (!function_exists('ovoads_to_array')) {
    function ovoads_to_array($args)
    {
        if (is_object($args)) {
            $args = get_object_vars($args);
        }

        if (is_array($args)) {
            return array_map(__FUNCTION__, $args);
        } else {
            return $args;
        }
    }
}


if (!function_exists('ovoads_redirect')) {
    function ovoads_redirect($url, $notify = null)
    {
        if ($notify) {
            ovoads_set_notify($notify);
        }
        wp_redirect($url);
        exit;
    }
}

if (!function_exists('ovoads_key_to_title')) {
    function ovoads_key_to_title($text)
    {
        return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
    }
}

if (!function_exists('ovoads_request')) {
    function ovoads_request()
    {
        return new Request();
    }
}

if (!function_exists('ovoads_session')) {
    function ovoads_session()
    {
        return new Session();
    }
}

if (!function_exists('ovoads_back')) {
    function ovoads_back($notify = null)
    {
        if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
            $url = sanitize_text_field($_SERVER['HTTP_REFERER']);
        } else {
            $url = home_url();
        }
        ovoads_redirect($url, $notify);
    }
}

if (!function_exists('ovoads_old')) {
    function ovoads_old($key)
    {
        return FacadeSession::get('old_input_value_' . $key);
    }
}

if (!function_exists('ovoads_abort')) {
    function ovoads_abort($code = 404, $message = null)
    {
        $abort = new Abort($code, $message);
        $abort->abort();
    }
}

if (!function_exists('ovoads_query_to_url')) {
    function ovoads_query_to_url($arr)
    {
        return esc_url(add_query_arg($arr, sanitize_url(wp_unslash($_SERVER['REQUEST_URI']))));
    }
}

if (!function_exists('ovoads_set_notify')) {
    function ovoads_set_notify($data)
    {
        FacadeSession::flash('notify', $data);
    }
}

if (!function_exists('ovoads_include')) {
    function ovoads_include($view, $data = [])
    {
        extract($data);
        include OVOADS_ROOT . 'views/' . $view . '.php';
    }
}

if (!function_exists('ovoads_route_link')) {
    function ovoads_route_link($name, $format = true, $pageName = null)
    {
        $route = ovoads_to_array(ovoads_route($name));
        if (array_key_exists('query_string', $route)) {
            if (!$pageName) {
                $pageUrl = menu_page_url('ovoads', false);
            } else {
                $pageUrl = menu_page_url($pageName, false);
            }
            if ($pageName != $route['query_string']) {
                $link = $pageUrl . '&module=' . $route['query_string'];
            } else {
                $link = $pageUrl;
            }
        } else {
            $link = home_url($route['uri']);
        }
        if ($format) {
            return esc_url($link);
        }
        return $link;
    }
}

if (!function_exists('ovoads_menu_active')) {
    function ovoads_menu_active($routeName, $extra = null)
    {
        $class = 'active';
        if (!is_array($routeName)) {
            $routeName = [$routeName];
        }
        if (is_array($extra)) {
            $routeName =  array_merge($routeName, $extra);
        }
        foreach ($routeName as $key => $value) {
            $route = ovoads_route($value);
            $queryString = $route->query_string;
            $uri = $route->uri ?? '';
            if ($queryString) {
                $currentModule = isset(ovoads_request()->module) ? ovoads_request()->module : null;
                if ($currentModule == $queryString) {
                    return sanitize_html_class($class);
                } else if (!$currentModule) {
                    $currentPage = isset(ovoads_request()->page) ? ovoads_request()->page : null;
                    if ($currentPage ==  $queryString) return sanitize_html_class($class);
                }
            } else {
                $currentUri = get_query_var('ovoads_page');
                if ($currentUri == $uri) {
                    return sanitize_html_class($class);
                }
            }
        }
    }
}

if (!function_exists('ovoads_nonce_field')) {
    function ovoads_nonce_field($routeName, $isPrint = true)
    {
        $nonce = ovoads_nonce($routeName);
        if ($isPrint) {
            echo '<input type="hidden" name="nonce" value="' . esc_attr($nonce) . '">';
        } else {
            return '<input type="hidden" name="nonce" value="' . esc_attr($nonce) . '">';
        }
    }
}


if (!function_exists('ovoads_nonce')) {
    function ovoads_nonce($routeName)
    {
        $route = ovoads_to_array(ovoads_route($routeName));
        if (array_key_exists('query_string', $route)) {
            $nonceName = $route['query_string'];
        } else {
            $nonceName = $route['uri'];
        }
        return wp_create_nonce($nonceName);
    }
}

// if (!function_exists('ovoads_current_route')) {
//     function ovoads_current_route()
//     {
//         if (isset(ovoads_request()->page)) {
//             if (isset(ovoads_request()->module)) {
//                 return ovoads_request()->module;
//             } else {
//                 return ovoads_request()->page;
//             }
//         } else {
//             return home_url(get_query_var('ovoads_page'));
//         }
//     }
// }


if (!function_exists('ovoads_current_route')) {
    function ovoads_current_route()
    {
        $page = ovoads_request()->page;
        if (isset($page)) {
            $module = ovoads_request()->module;
            if (isset($module)) {
                return ovoads_request()->module;
            } else {
                return ovoads_request()->page;
            }
        } else {
            return home_url(get_query_var('ovoads_page'));
        }
    }
}


if (!function_exists('ovoads_assets')) {
    function ovoads_assets($path)
    {
        $path = 'ovoads' . '/assets/' . $path;
        $path = str_replace('//', '/', $path);
        return plugins_url($path);
    }
}

if (!function_exists('ovoads_get_image')) {
    function ovoads_get_image($image)
    {
        $checkPath = str_replace(plugin_dir_url(dirname(dirname(__FILE__))), plugin_dir_path(dirname(dirname(__FILE__))), $image);
        if (file_exists($checkPath) && is_file($checkPath)) {
            return $image;
        }
        return ovoads_assets('images/default.png');
    }
}



if (!function_exists('ovoads_check_empty')) {
    function ovoads_check_empty($data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        return empty($data);
    }
}

if (!function_exists('ovoads_allowed_html')) {
    function ovoads_allowed_html()
    {
        $arr = array(
            'span' => array(
                'class' => []
            ),
            'br' => [],
            'a' => array(
                'href' => true,
                'class' => [],
            ),
            'em' => array(),
            'b' => array(),
            'bold' => array(),
            'blockquote' => array(),
            'p' => array(),
            'li' => array(
                'class' => [],
                'id' => []
            ),
            'ol' => array(),
            'strong' => array(),
            'ul' => array(
                'id' => [],
                'class' => [], 1
            ),
            'div' => array(
                'id' => [],
                'class' => [], 1
            ),
            'img' => array(
                'src' => true
            ),
            'table' => [],
            'tr' => [],
            'td' => [],
            'i' => array(
                'class' => []
            )
        );
        return $arr;
    }
}


if (!function_exists('ovoads_show_date_time')) {
    function ovoads_show_date_time($date, $format = 'Y-m-d h:i A')
    {
        return ovoads_date()->parse($date)->toDateTime($format);
    }
}

if (!function_exists('ovoads_diff_for_humans')) {
    function ovoads_diff_for_humans($date, $to = '')
    {
        if (empty($to)) {
            $to = current_time('timestamp');
        }
        $from = strtotime($date);
        return human_time_diff($from, $to) . " ago";
    }
}


if (!function_exists('ovoads_auth')) {
    function ovoads_auth()
    {
        include_once(ABSPATH . 'wp-includes/pluggable.php');
        if (is_user_logged_in()) {
            return (object)[
                'user' => wp_get_current_user(),
                'meta' => get_user_meta(wp_get_current_user()->ID)
            ];
        }
        return false;
    }
}

if (!function_exists('ovoads_trx')) {
    function ovoads_trx($length = 12)
    {
        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[wp_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('ovoads_asset')) {
    function ovoads_asset($path)
    {
        $path = 'ovoads' . '/assets/' . $path;
        $path = str_replace('//', '/', $path);
        return plugins_url($path);
    }
}


if (!function_exists('ovoads_title_to_key')) {
    function ovoads_title_to_key($text)
    {
        return strtolower(str_replace(' ', '_', $text));
    }
}

if (!function_exists('ovoads_encrypt')) {
    function ovoads_encrypt($string)
    {
        return base64_encode($string);
    }
}

if (!function_exists('ovoads_decrypt')) {
    function ovoads_decrypt($string)
    {
        return base64_decode($string);
    }
}



if (!function_exists('ovoads_paginate')) {
    function ovoads_paginate($num = 20)
    {
        return intval($num);
    }
}


if (!function_exists('ovoads_date')) {
    function ovoads_date()
    {
        return new OvoadsDate();
    }
}

if (!function_exists('ovoads_str_limit')) {
    function ovoads_str_limit($str, $length = 100, $end = '...')
    {

        if (mb_strwidth($str, 'UTF-8') <= $length) {
            return $str;
        }

        return rtrim(mb_strimwidth($str, 0, $length, '', 'UTF-8')) . $end;
    }
}

if (!function_exists('ovoads_db_prefix')) {
    function ovoads_db_prefix()
    {
        return DB::tablePrefix();
    }
}

if (!function_exists('ovoads_db_wpdb')) {
    function ovoads_db_wpdb()
    {
        return DB::wpdb();
    }
}

if (!function_exists('ovoads_active_user')) {
    function ovoads_active_user($userId)
    {
        $active = get_user_meta($userId, 'ovoads_ban');
        if ($active == 0) {
            return false;
        }
        return 1;
    }
}


if (!function_exists('ovoads_stack')) {
    function ovoads_stack($hookName)
    {
        do_action($hookName);
    }
}

if (!function_exists('ovoads_push')) {
    function ovoads_push($hookName, $param)
    {
        add_action($hookName, function () use ($param) {
            echo wp_kses_post($param);
        });
    }
}

if (!function_exists('ovoads_topnav')) {
    function ovoads_topnav($key, $pageName)
    {
        $response = wp_remote_get(OVOADS_ROOT . 'views/admin/partials/topnav.json');

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $json = json_decode($body);

        if ($json === null) {
            return;
        }

        $navs = $json->$key;

        $html = '';
        foreach ($navs as $nav) {
            $html .= '<li class="' . ovoads_menu_active($nav->route, isset($nav->extra) ? $nav->extra : null) . '">
                        <a href="' . ovoads_route_link( $nav->route, pageName: $pageName ) . '">
                            <i class="' . $nav->icon . '"></i>
                            <span class="menu-title">' . printf(esc_html__('%s', 'ovoads'), esc_html($nav->name)) . '</span>
                        </a>
                    </li>';
        }
        ovoads_push('ovoads_topnav', $html);
    }
}


if (!function_exists('ovoads_admin_plugin_page')) {
    function ovoads_admin_plugin_page()
    {
        $pageName = ovoads_request()->page;
        if ($pageName) {
            $pluginPage = explode('_', $pageName)[0];
            if ($pluginPage == 'ovoads') {
                return true;
            } else {
                return false;
            }
        }
    }
}


if (!function_exists('ovoads_get_media_file')) {
    function ovoads_get_media_file($postId)
    {
        $upload_dir = wp_upload_dir();
        $attachment_path = get_post_meta($postId, '_wp_attached_file', true);
        if ($attachment_path) {
            return $upload_dir['baseurl'] . '/' . $attachment_path;
        }
        return false;
    }
}

if (!function_exists('ovoads_number_format')) {
    function ovoads_number_format($number)
    {
        if ($number >= 1000000) { // format equal to greater than millions
            return number_format($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) { // format equal or greater than kilo
            return number_format($number / 1000, 1) . 'k';
        } else {
            return $number; // no format
        }
    }
}

if (!function_exists('ovoform_admin_top')) {
    function ovoads_admin_top($pageTitle, $html = null){
        ovoads_include('admin/layouts/top', compact('pageTitle', 'html'));
    }
}

if (!function_exists('ovoform_admin_bottom')) {
    function ovoads_admin_bottom(){
        ovoads_include('admin/layouts/bottom');
    }
}