<?php

    /**
     * Class that manages manipulation on the admin in wordpress
     */

    class Better_Pinterest_Plugin_Admin {

        const VERSION = '0.1';

        public static function admin_init()
        {
            // Enqueue editor things - used in post.php and pages.php
            add_action( 'wp_enqueue_editor', array( __CLASS__, 'enqueue' ), 10, 1 );
            add_action( 'print_media_templates', array( __CLASS__, 'template' ) );
        }

        public static function init()
        {
            // create custom plugin settings menu
            add_action('admin_menu', array(  __CLASS__, 'create_settings_menu' ) );
            // registeres settings so POST knows to look for them
            add_action('admin_init', array(  __CLASS__, 'register_settings' ) );
        }


        public static function enqueue( $options )
        {

            if ( $options['tinymce'] ) {
                // Note: An additional dependency "media-views" is not listed below
                // because in some cases such as /wp-admin/press-this.php the media
                // library isn't enqueued and shouldn't be. The script includes
                // safeguards to avoid errors in this situation
                wp_enqueue_script( 'advanced-pinterest-settings', plugins_url( 'scripts/advanced-pinterest-settings.js', dirname(__FILE__) ), array( 'jquery' ), self::VERSION, true );
            }
        }

        /**
         * Backbone template for advanced settings through editing an image in the visual editor for posts/pages
         * @return null
         */
        public static function template()
        {
            include( plugin_dir_path( dirname(__FILE__) ) . 'templates/advanced-pinterest-settings-tmpl.php');
        }

        /**
         * Register settings so wordpress knows to update them when editing plugin settings
         * @return null
         */
        public static function register_settings()
        {
            //register our settings
            register_setting( 'bpp-settings-group', 'bpp_color' );
            register_setting( 'bpp-settings-group', 'bpp_onhover' );
            register_setting( 'bpp-settings-group', 'bpp_corner' );
            register_setting( 'bpp-settings-group', 'bpp_size', 'intval' );
            register_setting( 'bpp-settings-group', 'bpp_lang' );
            register_setting( 'bpp-settings-group', 'bpp_count' );
        }


        public static function settings_default()
        {
            // Set default values
            self::update_option('bpp_color', 'red');
            self::update_option('bpp_onhover', 'false');
            self::update_option('bpp_corner', 'northeast');
            self::update_option('bpp_size', 20);
            self::update_option('bpp_lang', 'en');
            self::update_option('bpp_count', 'above');
        }

        public static function update_option($name, $value)
        {
            if (get_option($name) !== false) {
                update_option( $name, $new_value );
            } else {
                add_option( $name, $value);
            }
        }

        public static function settings_remove()
        {
            delete_option('bpp_color');
            delete_option('bpp_onhover');
            delete_option('bpp_corner');
            delete_option('bpp_size');
            delete_option('bpp_lang');
            delete_option('bpp_count');
        }

        /**
         * Add submenu under settings
         * @return null
         */
        public static  function create_settings_menu()
        {
            add_submenu_page( 'options-general.php', 'Better Pinterest Plugin Settings', 'Pinterest Settings', 'update_plugins', 'settings_bpp', array( __CLASS__, 'settings_page' ) );
        }

        public static function settings_page() {
            include('settings-page.php');
        }
    }