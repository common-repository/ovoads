<?php

namespace Ovoads\Hook;

use Ovoads\BackOffice\AdminRequestHandler;

class AdminMenu
{
    public function menuSetting()
    {

        add_menu_page(
            esc_html__('Ovoads', 'ovoads'),
            esc_html__('Ovoads', 'ovoads'),
            'ovoads',
            ovoads_route('admin.ovoads')->query_string,
            function(){},
            ovoads_get_image(ovoads_assets('images/ovoads.svg')),
            2
        );

        add_submenu_page(
            ovoads_route('admin.ovoads')->query_string,
            esc_html__('Dashboard', 'ovoads'),
            esc_html__('Dashboard', 'ovoads'),
            'manage_options',
            ovoads_route('admin.ovoads')->query_string,
            [new AdminRequestHandler(), 'handle']
        );

        add_submenu_page(
            ovoads_route('admin.ovoads')->query_string,
            esc_html__('Manage Keywords', 'ovoads'),
            esc_html__('Manage Keywords', 'ovoads'),
            'manage_options',
            ovoads_route('admin.ad.keyword.index')->query_string,
            [new AdminRequestHandler(), 'handle']
        );

        add_submenu_page(
            ovoads_route('admin.ovoads')->query_string,
            esc_html__('Advertises', 'ovoads'),
            esc_html__('Advertises', 'ovoads'),
            'manage_options',
            ovoads_route('admin.advertise.index')->query_string,
            [new AdminRequestHandler(), 'handle']
        );
        add_submenu_page(
            ovoads_route('admin.ovoads')->query_string,
            esc_html__('Listed Domain', 'ovoads'),
            esc_html__('Listed Domain', 'ovoads'),
            'manage_options',
            ovoads_route('admin.ad.domain.index')->query_string,
            [new AdminRequestHandler(), 'handle']
        );
        add_submenu_page(
            ovoads_route('admin.ovoads')->query_string,
            esc_html__('IP Logs', 'ovoads'),
            esc_html__('IP Logs', 'ovoads'),
            'manage_options',
            ovoads_route('admin.ad.ip.log.index')->query_string,
            [new AdminRequestHandler(), 'handle']
        );
        add_submenu_page(
            ovoads_route('admin.ovoads')->query_string,
            esc_html__('Settings', 'ovoads'),
            esc_html__('Settings', 'ovoads'),
            'manage_options',
            ovoads_route('admin.setting.index')->query_string,
            [new AdminRequestHandler(), 'handle']
        );
        add_submenu_page(
            ovoads_route('admin.ovoads')->query_string,
            esc_html__('Get Support', 'ovoads'),
            esc_html__('Get Support', 'ovoads'),
            'manage_options',
            ovoads_route('admin.get.support')->query_string,
            [new AdminRequestHandler(), 'handle']
        );
    }
}
