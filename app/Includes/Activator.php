<?php

namespace Ovoads\Includes;

use Ovoads\Lib\CurlRequest;

class Activator
{
    public function activate()
    {
        if (!get_option('ovoads_installed')) {
            global $wp_rewrite, $wpdb;

            $sql = file_get_contents(OVOADS_ROOT . 'database.sql');
            $sql = str_replace('{{prefix}}', $wpdb->prefix, $sql);
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            update_option('ovoads_installed',1);
            $wp_rewrite->set_permalink_structure('/%year%/%monthnum%/%postname%/');
        }

        update_option('ovoads_is_enabled',1);

        add_role('ovoads', 'Ovoads Administrator');
        $role = get_role('administrator');
        $role->add_cap('ovoads');

        flush_rewrite_rules();
    }

    public function deactivate()
    {
        remove_role('ovoads');
        $role = get_role('administrator');
        $role->remove_cap('ovoads');
        update_option('ovoads_is_enabled',0);
    }
}
