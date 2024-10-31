<?php

namespace Ovoads\Hook;

use Ovoads\Controllers\ActivationController;
use Ovoads\Controllers\AdController;
use Ovoads\Controllers\Admin\AdvertiseController;
use Ovoads\Hook\AdminMenu;
use Ovoads\Lib\VerifiedPlugin;

class Hook
{

    public function init()
    {

        add_action('admin_menu', [new AdminMenu, 'menuSetting']);

        add_action('init', [new ExecuteRouter, 'execute']);
        add_filter('template_include', [new ExecuteRouter, 'includeTemplate'], 1000, 1);
        add_action('query_vars', [new ExecuteRouter, 'setQueryVar']);

        $loadAssets = new LoadAssets('admin');
        add_action('admin_enqueue_scripts', [$loadAssets, 'enqueueScripts']);
        add_action('admin_enqueue_scripts', [$loadAssets, 'enqueueStyles']);

        $loadAssets = new LoadAssets('public');
        add_action('wp_enqueue_scripts', [$loadAssets, 'enqueueScripts']);
        add_action('wp_enqueue_scripts', [$loadAssets, 'enqueueStyles']);

        if (VerifiedPlugin::check()) {
            $this->authHooks();
        }

        add_action('plugin_loaded', function () {
            load_plugin_textdomain(
                'ovoads',
                false,
                dirname(dirname(dirname(plugin_basename(__FILE__)))) . '/languages'
            );
        });

        add_filter('admin_body_class', function ($classes) {
            if (isset($_GET['page']) && $_GET['page'] == 'ovoads') {
                $classes .= ' vl-admin';
            }
            return $classes;
        });

        add_action('init', function () {
            ob_start();
        });

        add_filter('redirect_canonical', function ($redirect_url) {
            if (is_404()) {
                return false;
            }
            return $redirect_url;
        });

        add_action('wp_ajax_active-plugin', function () {
            $controller = new ActivationController;
        });


        if (ovoads_admin_plugin_page()) {
            add_filter('admin_body_class', function ($classes) {
                $classes .= ' ' . 'ovoads' . '-admin ';
                return $classes;
            });
        }
        add_filter('plugin_action_links_' . plugin_basename(OVOADS_ROOT) . '/' . 'ovoads' . '.php', function ($links) {
            if (array_key_exists('deactivate', $links)) {
                $links['a'] = '<a href="https://viserlab.com" style="color: #05eb05;font-weight: bold;" target="_blank">' . __( 'Get Support', 'ovoads' ) . '</a>';
                $links['b'] = '<a href="'.ovoads_route_link('admin.advertise.index').'">' . __( 'Advertise', 'ovoads' ) . '</a>';
            }
            ksort($links);
            return $links;
        });

        add_action("admin_footer", function () {
            ovoads_include('deactivate_modal');
        });

        add_action('admin_enqueue_scripts', function(){
            wp_enqueue_media();
        });

        add_action('admin_enqueue_scripts', function () {
            wp_localize_script('jquery', 'ajax', array(
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax_nonce'),
            ));
        });
        // add_action('wp_enqueue_scripts', function () {
        //     wp_localize_script('ads', 'myPluginData', array(
        //         'apiToken' => 'gbb3rb3i3'
        //     ));
        // });

        add_action('wp_ajax_showStatisticsOnDashboard', [new AdvertiseController, 'showStatisticsOnDashboard']);
        add_action('wp_ajax_nopriv_showStatisticsOnDashboard', [new AdvertiseController, 'showStatisticsOnDashboard']);

        add_action('wp_ajax_detailStatistic', [new AdvertiseController, 'detailStatistic']);
        add_action('wp_ajax_nopriv_detailStatistic', [new AdvertiseController, 'detailStatistic']);

        add_action('wp_ajax_ipList', [new AdvertiseController, 'ipList']);
        add_action('wp_ajax_nopriv_ipList', [new AdvertiseController, 'ipList']);
       
        add_action('init', [new AdController,'giveHeaderAccess']);
    
    }

    public function authHooks()
    {
        $authorization = new Authorization;
        add_action('after_setup_theme', [$authorization, 'removeAdminBar']);
        add_action('admin_init', [$authorization, 'redirectHome'], 1);
        add_action('wp_login_failed', [$authorization, 'authFailed']);
        add_filter('authenticate', [$authorization, 'authenticate'], 20, 3);
        add_filter('wp_authenticate_user', [$authorization, 'verifyUser'], 1);
        add_action('edit_user_profile', [$authorization, 'userProfile']);
        add_action('edit_user_profile_update', [$authorization, 'updateUserProfile']);
    }
}
