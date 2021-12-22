<?php 
require_once "mj-slideshow-core-functions.php";
require_once "class/class-mj-slideshow-manage.php";
require_once "class/class-mj-slideshow-manage-metadata.php";

if( !is_admin() ) 
    require_once "class/class-mj-slideshow-shortcode.php";