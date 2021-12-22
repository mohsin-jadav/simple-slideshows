<?php 
/**
 * Metabox handling class
 */

if( ! class_exists( 'Mj_slider_init' ) ) :

    class Mj_slider_init {
        private $screens;
        private $metaKey;

        function __construct() {
            $this->metaKey = 'mj_slideshow_image_ids';
            $this->screens = array( 
                'mj_slideshow'
            );

            $this->event_handler();
        }

        public function event_handler(){
            add_action( 'add_meta_boxes', [ $this, 'intialize_slideshow_metabox' ], 10 );
            add_action( 'save_post', [ $this, 'save_slideshow_metadata' ] );
        }

        public function intialize_slideshow_metabox() {
            foreach( $this->screens as $screen ) :
                add_meta_box(
                    'mj-slideshow-metabox',
                    esc_html__( 'Slides', MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN ),
                    array( $this, 'genrate_slideshow_metabox' ),
                    $screen,
                    'normal',
                    'high'
                );
            endforeach;
        }

        public function genrate_slideshow_metabox( $slideshow ){
            $imageIDs = get_post_meta( $slideshow->ID, $this->metaKey, true );
            if( !empty( $imageIDs ) ) :
                $images = get_posts( 
                    array(
                        'post_type' => 'attachment',
                        'orderby' => 'post__in',
                        'order' => 'ASC',
                        'post__in' => $imageIDs,
                        'numberposts' => -1,
                        'post_mime_type' => 'image'
                    ) 
                );
            else :
                $images = array();
            endif;
            
            mj_get_temlpate(
                'metabox/slides.php',
                array(
                    'metaKey' => $this->metaKey,
                    'imageIDs' => $imageIDs,
                    'images'   => $images
                )
            );
        }

        public function save_slideshow_metadata( $slideshow_ID ){
            if ( ! isset( $_POST['mj_slideshow_metabox_nonce'] ) || empty( $slideshow_ID ) ) :
                return;
            endif;

            update_post_meta( $slideshow_ID, $this->metaKey, $_POST[$this->metaKey] );
            return $slideshow_ID;
        }


    }
    new Mj_slider_init();
endif;