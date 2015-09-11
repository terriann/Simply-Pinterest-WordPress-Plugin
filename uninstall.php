<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

define('BPP_PLUGIN_FILE', __FILE__);

require_once( dirname(__FILE__) . '/includes/simple-pinterest-base.php' );
require_once( dirname(__FILE__) . '/includes/simple-pinterest-plugin-admin.php' );

// When the plugin is uninstalled, remove options from database

Simple_Pinterest_Plugin_Admin::settings_remove();
