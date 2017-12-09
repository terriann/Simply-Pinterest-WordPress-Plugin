<?php
/**
 * Plugin Name: Simply Pinterest
 * Plugin URI: https://github.com/terriann/betterpinterestplugin
 * Description: Simply Pinterest is a WordPress plugin designed to be light weight, easy to use while achieving one goal: making it easy for your visitors to share your content on Pinterest. This plugin puts a Pinterest button over the corner of each image with customizabele options making it clear & easy for your visitors to share your content with their followers.
 * Version: 1.2.1
 * Author: Terri Ann Swallow
 * Author URI: http://terriswallow.com/
 * License: GPLv2
 *
 * @package simplypinterest
 */

define( 'BPP_PLUGIN_FILE', __FILE__ );

require_once __DIR__ . '/includes/simple-pinterest-base.php';

/**
 * Load & activate front end manipulation for front end facing site only
 */
require_once __DIR__ . '/includes/simple-pinterest-plugin.php';
add_action( 'init', array( 'Simple_Pinterest_Plugin', 'init' ) );

/**
 * Load & activate admin manipulation for admin site only
 */
require_once __DIR__ . '/includes/simple-pinterest-plugin-admin.php';
add_action( 'admin_init', array( 'Simple_Pinterest_Plugin_Admin', 'admin_init' ) );
add_action( 'init', array( 'Simple_Pinterest_Plugin_Admin', 'init' ) );


add_filter( 'tiny_mce_before_init', 'change_mce_options' );
/**
 * Add img with new attributes extended_valid_elements for TinyMCE.
 *
 * @param array $init     The existing list of TinyMCE options.
 * @return array $init    The modified list of TinyMCE options.
 */
function change_mce_options( $init ) {
	// Define element and desired supported attributes.
	$ext = 'img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|id|style|nopin|data-bpp-pinhover]';

	if ( isset( $init['extended_valid_elements'] ) ) {
        // If there are already extended valid elements, add to them.
		$init['extended_valid_elements'] .= ',' . $ext;
	} else {
        // Otherwise, define new values.
		$init['extended_valid_elements'] = $ext;
	}
	return $init;
}

add_action( 'init', 'kses_allow_nopin_on_img' );
/**
 * This prevents WordPress from stripping out additional attributes from elements.
 *
 * @link https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
 *
 * @return void
 */
function kses_allow_nopin_on_img() {
	global $allowedposttags;

	$tags           = array( 'img' );
	$new_attributes = array(
		'nopin'             => true,
		'data-bpp-pinhover' => true,
	);

	foreach ( $tags as $tag ) {
		if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) ) {
            // @codingStandardsIgnoreLine
			$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
		}
	}
}                         

// @codingStandardsIgnoreStart
/**
 * Combatting tinyMCE's hatreat of all things not typical
 * https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
 * https://www.leighton.com/blog/stop-tinymce-in-wordpress-3-x-messing-up-your-html-code
 */
// This should not be released this way, it allows all kinds of HTML - I really just want to add nopin as an ATTR to img but that seems impossible....Sigh
function myformatTinyMCE( $initArray ) {
	$initArray['verify_html'] = false;
	return $initArray;
}
// add_filter('tiny_mce_before_init', 'myformatTinyMCE' );
// @codingStandardsIgnoreEnd