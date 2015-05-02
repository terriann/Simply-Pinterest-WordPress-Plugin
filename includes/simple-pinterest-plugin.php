<?php

    /**
     * Class that manages manipulation for the client facing side of Wordpress
     */

    class Simple_Pinterest_Plugin extends Simple_Pinterest_Base {

        public static function init()
        {
            // Enqueue frontend things
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ), 10, 1 );
            add_action( 'wp_head', array( __CLASS__, 'meta_nohover' ) );


            add_filter( 'the_content', array( __CLASS__, 'wrap_post_content' ) );
        }

        public static function enqueue()
        {
            wp_enqueue_style( 'spp_css', plugins_url( '/styles/style.css', SPP_PLUGIN_FILE ), false, self::VERSION );
            if(self::loadjQuery()){
                wp_enqueue_script( 'spp_js', plugins_url( '/scripts/script.js', SPP_PLUGIN_FILE ), array( 'jquery' ), self::VERSION );
            }

            if(self::loadSync()){
                wp_enqueue_script( 'spp_pinit', '//assets.pinterest.com/js/pinit.js', false, self::VERSION );
            } elseif(self::loadAsync()) {
                add_action( 'wp_footer', array(__CLASS__, 'async_script'));
            }
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

        public static function async_script()
        {
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

        public static function loadjQuery()
        {
            if(get_option('spp_load_jq') === 'nojquery') {
                return false;
            }

            return true;
        }
        public static function loadAsync()
        {
            if(get_option('spp_load') == 'async') {
                return true;
            }

            return false;
        }

        public static function loadSync()
        {
            if(get_option('spp_load') == 'sync') {
                return true;
            }

            return false;
        }

        /**
         * Check to see if this is an allowed page type for the wrapper to go onto
         * @return bool
         */
        public static function checkType($type) {
            $options = get_option('spp_pagetype');

            if(is_array($options) && in_array($type, $options)) {
                return true;
            }

            return false;
        }

        public static function wrap_post_content( $content )
        {
            global $post;

            // Check page type allowed
            if(    (is_home() && !self::checkType('home'))
                || (is_archive() && !self::checkType('archives'))
                || (is_search() && !self::checkType('search'))
                || (is_page() && !self::checkType('pages'))
                || (is_single() && !self::checkType('posts')) ) {

                return $content;
            }

            if( get_post_meta( $post->ID, 'spp_disable_pinit', true ) ) {
                return $content;
            }


            $attr_set = array(
                    'class' => 'spp_post_wrapper',
                    'data-spp-pinlink' => esc_attr( get_permalink($post->ID) ),
                    'data-spp-pincorner' => esc_attr( get_option('spp_corner') ),
                    'data-spp-pinhover' => esc_attr( get_option('spp_onhover') ),
                    'data-spp-lang' => esc_attr( get_option('spp_lang') ),
                    'data-spp-count' => esc_attr( get_option('spp_count') ),
                    'data-spp-size' => esc_attr( get_option('spp_size') ),
                    'data-spp-color' => esc_attr( get_option('spp_color') ),
                    'data-spp-append' => esc_attr( get_option('spp_description_append') )
                    );

            if('important' == get_option('spp_important')) {
                $attr_set['data-spp-important'] = '1';
            }

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
