<?php
/**
 * Simple_Pinterest_Plugin File Doc Comment
 *
 * @category  Simple_Pinterest_Plugin
 * @package   SimplyPinterest
 * @author    Terri Ann Swallow
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.terrianncreative.com/
 */

/**
 * Simple_Pinterest_Plugin class is a collection of utility methods
 * around supporting Simply Pinterest in the WordPress client facing site.
 *
 * @category  Class
 * @package   SimplyPinterest
 * @author    Terri Ann Swallow
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.terrianncreative.com/
 */
class Simple_Pinterest_Plugin extends Simple_Pinterest_Base {

	/**
	 * Actions and filters to run on WordPress init() hook
	 *
	 * @return void
	 */
	public static function init() {
		// Enqueue frontend things.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ), 10, 1 );
		add_action( 'wp_head', array( __CLASS__, 'meta_nohover' ) );

		add_filter( 'the_content', array( __CLASS__, 'wrap_post_content' ) );
	}

	/**
	 * Enqueues script and styles
	 *
	 * @return void
	 */
	public static function enqueue() {
		wp_enqueue_style( 'bpp_css', plugins_url( '/styles/style.css', BPP_PLUGIN_FILE ), false, self::VERSION );
		if ( self::loadjQuery() ) {
			wp_enqueue_script( 'bpp_js', plugins_url( '/scripts/script.js', BPP_PLUGIN_FILE ), array( 'jquery' ), self::VERSION );
		}

		if ( self::loadSync() ) {
			wp_enqueue_script( 'bpp_pinit', '//assets.pinterest.com/js/pinit.js', false, self::VERSION );
		} elseif ( self::loadAsync() ) {
			add_action( 'wp_footer', array( __CLASS__, 'async_script' ) );
		}
	}

	/**
	 * Prevent the Pinterest browser extension from causing multiple pin interactions.
	 *
	 * This appears to be the right way to prevent the pinterest plugin button from hovering as well.
	 *
	 * @link https://developers.pinterest.com/extension_faq/
	 *
	 * @return void
	 */
	public static function meta_nohover() {
		echo '<meta name="pinterest" content="nohover" />';
	}

	/**
	 * Asyncronous Pinterest script.
	 *
	 * @return void
	 */
	public static function async_script() {
		echo '<script type="text/javascript">';
		echo "(function(d){
            var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
            p.type = 'text/javascript';
            p.async = true;
            p.src = '//assets.pinterest.com/js/pinit.js';
            f.parentNode.insertBefore(p, f);
        }(document));
        </script>";
	}

	/**
	 * Whether to load jQuery based on settings.
	 *
	 * @return bool
	 */
	public static function loadjQuery() {
		if ( 'nojquery' === get_option( 'bpp_load_jq' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Whether to load Asyncrously based on settings.
	 *
	 * @return bool
	 */
	public static function loadAsync() {
		if ( 'async' === get_option( 'bpp_load' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Whether to load syncrously based on settings.
	 *
	 * @return bool
	 */
	public static function loadSync() {
		if ( 'sync' === get_option( 'bpp_load' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check to see if this is an allowed page type for the wrapper to go onto.
	 *
	 * @param string $type   Indicates what page type.
	 * @return bool
	 */
	public static function checkType( $type ) {
		$options = get_option( 'bpp_pagetype' );

		if ( is_array( $options ) && in_array( $type, $options, true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Add wrapper around the content so images contained within this block know what their settings should be.
	 *
	 * @param string $content   The content of the current post.
	 * @return string
	 */
	public static function wrap_post_content( $content ) {
		global $post;

		// Check page type allowed.
		if ( ( is_home() && ! self::checkType( 'home' ) )
			|| ( is_archive() && ! self::checkType( 'archives' ) )
			|| ( is_search() && ! self::checkType( 'search' ) )
			|| ( is_page() && ! self::checkType( 'pages' ) )
			|| ( is_single() && ! self::checkType( 'posts' ) ) ) {

			return $content;
		}

		if ( get_post_meta( $post->ID, 'bpp_disable_pinit', true ) ) {
			return $content;
		}

		$attr_set = array(
			'class'               => 'bpp_post_wrapper',
			'data-bpp-pinlink'    => esc_attr( get_permalink( $post->ID ) ),
			'data-bpp-pincorner'  => esc_attr( get_option( 'bpp_corner' ) ),
			'data-bpp-pinhover'   => esc_attr( get_option( 'bpp_onhover' ) ),
			'data-bpp-lang'       => esc_attr( get_option( 'bpp_lang' ) ),
			'data-bpp-count'      => esc_attr( get_option( 'bpp_count' ) ),
			'data-bpp-zero-count' => esc_attr( get_option( 'bpp_zero_count' ) ),
			'data-bpp-size'       => esc_attr( get_option( 'bpp_size' ) ),
			'data-bpp-color'      => esc_attr( get_option( 'bpp_color' ) ),
			'data-bpp-append'     => esc_attr( get_option( 'bpp_description_append' ) ),
		);

		if ( 'important' === get_option( 'bpp_important' ) ) {
			$attr_set['data-bpp-important'] = '1';
		}

		if ( 'true' === get_option( 'bpp_mobile' ) ) {
			$attr_set['data-bpp-mobile'] = '1';
		}

		$attributes = array();

		foreach ( $attr_set as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$attributes[] = $attr . '="' . $value . '"';
			}
		}

		$content = '<div ' . implode( ' ', $attributes ) . '>' . $content . '</div>';
		return $content;
	}

}
