<?php
/*
Plugin Name: Better Pinterest Plugin
Plugin URI: http://quiltalong.net/
Description: Creates custom post types for Quilt alongs, BOM and Link Parties
Version: 1.0
Author: Terri Ann Swallow
Author URI: http://terriswallow.com/
License: GPLv2
*/

class Better_Pinterest_Plugin {

    const VERSION = '0.1';

    public static function init()
    {
        // Enqueue frontend things
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ), 10, 1 );
        add_action( 'wp_head', array( __CLASS__, 'meta_nohover' ) );
        // Wrap the posts with the postwrapper class - JS is going to use a bunch of these data attributes
        add_filter( 'the_content', array( __CLASS__, 'wrap_post_content' ) );
    }

    public static function enqueue()
    {
        wp_enqueue_style( 'bpp_css', plugins_url( 'styles/style.css', __FILE__ ), false, self::VERSION );
        wp_enqueue_script( 'bpp_js', plugins_url( 'scripts/script.js', __FILE__ ), array( 'jquery' ), self::VERSION );
        wp_enqueue_script( 'bpp_pinit', '//assets.pinterest.com/js/pinit.js', false, self::VERSION );
    }

    /**
     * This appears to be the right way to prevent the pinterest plugin button from hovering as well
     * https://developers.pinterest.com/extension_faq/
     * @return [type] [description]
     */
    public static function meta_nohover()
    {
        echo '<meta name="pinterest" content="nohover" />';
    }

    public static function wrap_post_content( $content )
    {
        global $post;

        $attr_set = array(
                'class' => 'bpp_post_wrapper',
                'data-bpp-pinlink' => esc_attr( get_permalink($post->ID) ),
                'data-bpp-pincorner' => esc_attr( get_option('bpp_corner') ),
                'data-bpp-pinhover' => esc_attr( get_option('bpp_onhover') ),
                'data-bpp-lang' => esc_attr( get_option('bpp_lang') ),
                'data-bpp-count' => esc_attr( get_option('bpp_count') ),
                'data-bpp-size' => esc_attr( get_option('bpp_size') ),
                'data-bpp-color' => esc_attr( get_option('bpp_color') )
                );

        $attributes = array();

        foreach($attr_set as $attr => $value) {
            if(!empty($value)) {
                $attributes[] = $attr . '="' . $value . '"';
            }
        }

        $content = '<div '. implode(' ', $attributes) .'>'.$content.'</div>';
        return $content;
    }

}

add_action( 'init', array( 'Better_Pinterest_Plugin', 'init' ) );




class Better_Pinterest_Plugin_Admin {

    const VERSION = '0.1';

    public static function init()
    {
        // Enqueue editor things
        add_action( 'wp_enqueue_editor', array( __CLASS__, 'enqueue' ), 10, 1 );
        add_action( 'print_media_templates', array( __CLASS__, 'template' ) );
    }


    public static function enqueue( $options )
    {

        if ( $options['tinymce'] ) {
            // Note: An additional dependency "media-views" is not listed below
            // because in some cases such as /wp-admin/press-this.php the media
            // library isn't enqueued and shouldn't be. The script includes
            // safeguards to avoid errors in this situation
            wp_enqueue_script( 'advanced-pinterest-settings', plugins_url( 'scripts/advanced-pinterest-settings.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
        }
    }

    public static function template()
    {
        include plugins_url( 'templates/advanced-pinterest-settings-tmpl.php' , __FILE__ );
    }

}

add_action( 'init', array( 'Better_Pinterest_Plugin_Admin', 'init' ) );


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

/* Settings page  - Should be addedto Better_Pinterest_Plugin_Admin class when that work is complete */

// create custom plugin settings menu
add_action('admin_menu', 'bpp_create_menu');

function bpp_create_menu() {
    // Add submenu under settings
    add_submenu_page( 'options-general.php', 'Better Pinterest Plugin Settings', 'Pinterest Settings', 'update_plugins', 'settings_bpp', 'bpp_settings_page' );

    //call register settings function
    add_action( 'admin_init', 'bpp_register_settings' );
}


function bpp_register_settings() {
    //register our settings
    register_setting( 'bpp-settings-group', 'bpp_color' );
    register_setting( 'bpp-settings-group', 'bpp_onhover' );
    register_setting( 'bpp-settings-group', 'bpp_corner' );
    register_setting( 'bpp-settings-group', 'bpp_size' );
    register_setting( 'bpp-settings-group', 'bpp_lang' );
    register_setting( 'bpp-settings-group', 'bpp_count' );
}

function bpp_settings_page() {
?>
<div class="wrap">
<h2>Better Pinterest Plugin</h2>

<form method="post" action="options.php">
    <?php
        // this outputs the 
        settings_fields( 'bpp-settings-group' );
        // This could be moved to a constructor once the plugin is class based
        do_settings_sections( 'bpp-settings-group' );
    ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Pin it Button Color</th>
        <td>
            <input type="radio" name="bpp_color" value="red"<?php checked( 'red' == get_option('bpp_color') ); ?> /> Red<br />
            <input type="radio" name="bpp_color" value="white"<?php checked( 'white' == get_option('bpp_color') ); ?> /> White<br />
            <input type="radio" name="bpp_color" value="gray"<?php checked( 'gray' == get_option('bpp_color') ); ?> /> Gray<br />
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Pin it Button Size</th>
        <td>
            <input type="radio" name="bpp_size" value="28"<?php checked( '28' == get_option('bpp_size') ); ?> /> Large (28px)<br />
            <input type="radio" name="bpp_size" value="20"<?php checked( '20' == get_option('bpp_size') ); ?> /> Small (20px)<br />
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">Pin it Button Language</th>
        <td>
            <input type="radio" name="bpp_lang" value="en"<?php checked( 'en' == get_option('bpp_lang') ); ?> /> English<br />
            <input type="radio" name="bpp_lang" value="ja"<?php checked( 'ja' == get_option('bpp_lang') ); ?> /> Japanese<br />
        </td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Pin it Button Corner</th>
        <td>
            <input type="radio" name="bpp_corner" value="northwest"<?php checked( 'northwest' == get_option('bpp_corner') ); ?> /> Northwest (top left)<br />
            <input type="radio" name="bpp_corner" value="northeast"<?php checked( 'northeast' == get_option('bpp_corner') ); ?> /> Northeast (top right)<br />
            <input type="radio" name="bpp_corner" value="southwest"<?php checked( 'southwest' == get_option('bpp_corner') ); ?> /> Southwest (bottom left)<br />
            <input type="radio" name="bpp_corner" value="southeast"<?php checked( 'southeast' == get_option('bpp_corner') ); ?> /> Southeast (bottom right)<br />
        </td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Pin it Button Count</th>
        <td>
            <input type="radio" name="bpp_count" value="above"<?php checked( 'above' == get_option('bpp_count') ); ?> /> Above the button<br />
            <input type="radio" name="bpp_count" value="beside"<?php checked( 'beside' == get_option('bpp_count') ); ?> /> Beside the button (<em>If count is 0 no numbers show, this is a bug on the Pinterest side, not the plugin</em>)<br />
            <input type="radio" name="bpp_count" value="none"<?php checked( 'none' == get_option('bpp_count') ); ?> /> None<br />
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Hover Settings</th>
        <td>
            <input type="radio" name="bpp_onhover" value="true"<?php checked( 'true' == get_option('bpp_onhover') ); ?> /> Only show Pin it button on hover/mouseover<br />
            <input type="radio" name="bpp_onhover" value="false"<?php checked( 'false' == get_option('bpp_onhover') ); ?> /> Always show pin it button<br />
        </td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>