<?php

    /**
     * Class that manages manipulation for the client facing side of Wordpress
     */

    class Better_Pinterest_Plugin {

        const VERSION = '0.1.6';

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
            wp_enqueue_style( 'bpp_css', plugins_url( '/styles/style.css', BPP_PLUGIN_FILE ), false, self::VERSION );
            wp_enqueue_script( 'bpp_js', plugins_url( '/scripts/script.js', BPP_PLUGIN_FILE ), array( 'jquery' ), self::VERSION );

            if(self::loadSync()){
                wp_enqueue_script( 'bpp_pinit', '//assets.pinterest.com/js/pinit.js', false, self::VERSION );
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

        public static function loadAsync()
        {
            if(get_option('bpp_load') == 'async') {
                return true;
            }

            return false;
        }

        public static function loadSync()
        {
            if(get_option('bpp_load') == 'sync') {
                return true;
            }

            return false;
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
                    'data-bpp-color' => esc_attr( get_option('bpp_color') ),
                    'data-bpp-append' => esc_attr( get_option('bpp_description_append') )
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