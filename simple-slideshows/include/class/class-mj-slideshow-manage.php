<?php
/**
 * Manage slider post type
 */


if( ! class_exists( 'Mj__slideshow_manage' ) ) :

    class Mj__slideshow_manage {

        function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_action( 'init', [ $this, 'register_post_type' ], 10 );
            add_action( 'admin_enqueue_scripts', [ $this, 'include_admin_assets' ], 10 );

            add_action( 'after_setup_theme', [ $this, 'genrate_slideshow_thumbnail_after_setup_theme' ], 10 );
            add_filter( 'image_size_names_choose', [ $this, 'add_slideshow_thumbnail_for_js_response' ], 10, 1 );

            add_filter( 'manage_mj_slideshow_posts_columns', [ $this, 'shortcode_column' ] );
            add_action( 'manage_mj_slideshow_posts_custom_column', [ $this, 'shortcode_column_value' ], 10, 2);

        }

        public function include_admin_assets() {
            $screen = get_current_screen();
            if( $screen->post_type == 'mj_slideshow' ) :
                wp_enqueue_script( 'jquery-ui-core' );
                wp_enqueue_script( 'jquery-ui-widget' );
                wp_enqueue_script( 'jquery-ui-sortable' );

                if ( ! did_action( 'wp_enqueue_media' ) )
                    wp_enqueue_media();

                wp_enqueue_script( 'mj-admin-core-admin-functions', MJ_SIMPLE_SLIDESHOW_URL . 'assets/js/mj-core-admin-functions.js', array(), MJ_SIMPLE_SLIDESHOW_VERSION, true );
                wp_enqueue_style( 'mj-admin-core-style', MJ_SIMPLE_SLIDESHOW_URL . 'assets/css/mj-admin-core-style.css', array(), MJ_SIMPLE_SLIDESHOW_VERSION );
            endif;            
        }

        public function genrate_slideshow_thumbnail_after_setup_theme() {
            add_image_size( 'mj_slideshow_thumbnail', 250, 130, true );
            add_theme_support( 'editor-styles' );
            add_theme_support( 'align-wide' );
        }

        public function add_slideshow_thumbnail_for_js_response( $sizes ) {
			$sizes['mj_slideshow_thumbnail'] = __( 'MJ Slideshow Thumbnail' );
            return $sizes;
        }
        
        public static function register_post_type() {
            $args = array(
                'label'               => esc_html__( 'Slideshow', MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN ),
                'labels'              => esc_html__( 'Slideshows', MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN ),
                'supports'            => array( 'title', 'thumbnail' ),
                'hierarchical'        => true,
                'public'              => true,
                'show_ui'             => true,
                'show_in_rest'        => true,
                'show_in_menu'        => true,
                'menu_position'       => 10,
                'menu_icon'           => 'dashicons-slides',
                'show_in_admin_bar'   => false,
                'show_in_nav_menus'   => false,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'capability_type'     => 'page',
            );
            register_post_type( 'mj_slideshow', $args );
        }

        public function shortcode_column( $columns ) {
            $offset = array_search( 'date', array_keys( $columns ) );
            return array_merge(
                array_slice($columns, 0, $offset), 
                ['shortcode' => __( 'Shortcode', MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN )], 
                array_slice($columns, $offset, null)
            );
        }

        public function shortcode_column_value( $columnKey, $slideshow_ID ) {
            if( $columnKey == 'shortcode' ) :
                echo sprintf( "<pre>[MJ__SlideShow slideshow_id='%d']</pre>", $slideshow_ID );
            endif;
        }
    }
    new Mj__slideshow_manage();
endif;