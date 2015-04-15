<?php
/*
Plugin Name: Better Pinterest Plugin
Plugin URI: https://github.com/terriann/betterpinterestplugin
Description: A better pinterest plugin.
Version: 0.1.6
Author: Terri Ann Swallow
Author URI: http://terriswallow.com/
License: GPLv2
*/

define('BPP_PLUGIN_FILE', __FILE__);

/**
 * Load & activate front end manipulation for front end facing site only
 */
require_once( dirname(__FILE__) . '/includes/better-pinterest-plugin.php' );
add_action( 'init', array( 'Better_Pinterest_Plugin', 'init' ) );


/**
 * Load & activate admin manipulation for admin site only
 *
 * @todo check if this should just be wrapped in is_admin() rather than relying on admin_init?
 */
require_once( dirname(__FILE__) . '/includes/better-pinterest-plugin-admin.php' );
add_action( 'admin_init', array( 'Better_Pinterest_Plugin_Admin', 'admin_init' ) );

// Some things apparently need to be called on init not admin_init....Grrr wordpress
add_action('init', array( 'Better_Pinterest_Plugin_Admin', 'init' ) );

// When the plugin is activated, set defaults
register_activation_hook( __FILE__, array( 'Better_Pinterest_Plugin_Admin', 'settings_default' ) );
// When the plugin is deactivated, remove options from database
register_deactivation_hook( __FILE__, array( 'Better_Pinterest_Plugin_Admin', 'settings_remove' ) );



/* Combatting tinyMCE's hatreat of all things not typical 
https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
https://www.leighton.com/blog/stop-tinymce-in-wordpress-3-x-messing-up-your-html-code
*/
// This should not be released this way, it allows all kinds of HTML - I really just want to add nopin as an ATTR to img but that seems impossible....Sigh
function myformatTinyMCE($initArray) {
    $initArray['verify_html'] = false;
    return $initArray;
}
add_filter('tiny_mce_before_init', 'myformatTinyMCE' );



// This prevents wordpress from stripping out additional attributes on elements - This code seems good to go.
add_action( 'init', 'kses_allow_nopin_on_img' );
/**
 * Prevent Kses from eatting nopin attribute
 * Source: https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
 * @return null
 */
function kses_allow_nopin_on_img()
{
    global $allowedposttags;
 
    $tags = array( 'img' );
    $new_attributes = array( 'nopin' => true );
 
    foreach( $tags as $tag ) {
        if( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) ) {
            $allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
        }
    }
}