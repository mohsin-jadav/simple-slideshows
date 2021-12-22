<?php
/**
 * Plugin Name: Simple Slideshows 
 * Description: A flexible plugin that allows you to create beautiful and slick sliders in your site or shop in a few seconds.
 * Author: Mohsin Jadav
 * Version: 1.0.0
 * Author URI: mailto:mohsin.jadav1@gmail.com
 */

if ( ! defined( 'MJ_SIMPLE_SLIDESHOW' ) ) :
	define( 'MJ_SIMPLE_SLIDESHOW', 'MJ_SIMPLE_SLIDESHOW' );
endif;

if ( ! defined( 'MJ_SIMPLE_SLIDESHOW_VERSION' ) ) :
	define( 'MJ_SIMPLE_SLIDESHOW_VERSION', '1.0.0' );
endif;

if ( ! defined( 'MJ_SIMPLE_SLIDESHOW_PATH' ) ) :
	define( 'MJ_SIMPLE_SLIDESHOW_PATH', plugin_dir_path( __FILE__ ) );
endif;

if ( ! defined( 'MJ_SIMPLE_SLIDESHOW_URL' ) ) {
	define( 'MJ_SIMPLE_SLIDESHOW_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN' ) ) :
	define( 'MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN', 'mj-simple-slideshow' );
endif;

// Manage wordpress backend slider and metabox
require_once "include/mj-slideshow.php";