<?php
/**
 * Manage slider post type
 */


if( ! class_exists( 'Mj__slideshow_shortcode' ) ) :

    class Mj__slideshow_shortcode {

        function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_shortcode( 'MJ__SlideShow', [ $this, 'genrate_slideshow_Shortcode' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'slideshow_enqueue_frontend_assets' ], 10 );
        }

        public function slideshow_enqueue_frontend_assets() {
            wp_enqueue_style( 'swiper-bundle.min--css', MJ_SIMPLE_SLIDESHOW_URL . 'assets/css/swiper-bundle.min.css', array(), MJ_SIMPLE_SLIDESHOW_VERSION );
            
            wp_enqueue_script( 'swiper-bundle.min--js', MJ_SIMPLE_SLIDESHOW_URL . 'assets/js/swiper-bundle.min.js', array(), MJ_SIMPLE_SLIDESHOW_VERSION, true );

            wp_enqueue_script( 'mj-slideshow-init--js', MJ_SIMPLE_SLIDESHOW_URL . 'assets/js/mj-slideshow-init.js', array(), MJ_SIMPLE_SLIDESHOW_VERSION, true );            
        }

        public function genrate_slideshow_Shortcode( $args ) {
            $slideshow_ID = !empty( $args['slideshow_id'] ) && isset( $args['slideshow_id'] ) ? $args['slideshow_id'] : '';
            if( empty( $slideshow_ID ) ) :
                echo __( "Error, 404 not found!", MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN ); 
                return; 
            endif;

            $imageIDs = get_post_meta( $slideshow_ID, 'mj_slideshow_image_ids', true );
            if( empty( $imageIDs ) ) :
                echo __( "Error, Please insert atleast one slide!", MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN );
                return;
            endif;

            $slides = get_posts( 
                array(
                    'post_type' => 'attachment',
                    'orderby' => 'post__in',
                    'order' => 'ASC',
                    'post__in' => $imageIDs,
                    'numberposts' => -1,
                    'post_mime_type' => 'image'
                ) 
            );
            
            $slideshowAttr = array(
                "navigation" => array(
                    'nextEl'  => ".swiper-" . $slideshow_ID . "-next",
                    'prevEl'  => ".swiper-" . $slideshow_ID . "-prev",
                )
            );

            ob_start();
            mj_get_temlpate(
                'frontend/slideshow.php',
                array(
                    'slides'        => $slides,
                    'slideshow_ID'  => $slideshow_ID,
                    'slideshow_main_class' => 'mj__slideshow--' . $slideshow_ID,
                    'slideshowAttr'    => json_encode( $slideshowAttr )
                )
            );
            return ob_get_clean();
        }
    }
    new Mj__slideshow_shortcode();
endif;