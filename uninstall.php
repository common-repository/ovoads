<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

function ovoads_uninstall(){
    global $wpdb;

    $tables = $wpdb->get_results(
        $wpdb->prepare(
            "SHOW TABLES LIKE %s",
            $wpdb->esc_like( $wpdb->prefix ) . 'ovoads%'
        ),
        ARRAY_N
    );
    if ( $tables ) {
        foreach ( $tables as $table ) {
            $wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS %s", $table[0] ) );
        }
    }


    delete_option('ovoads_installed');
    delete_option('ovoads_is_enabled');

    flush_rewrite_rules();
}

ovoads_uninstall();