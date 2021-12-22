<?php
/**
 * Simple Slideshow Core Functions
 *
 * General core functions available on both the front-end and admin.
 */

if( !function_exists( 'mj_get_temlpate' ) ) : 
   
    function mj_get_temlpate( $template_name, $args = array(), $template_path = '' ) {
        if( empty( $template_path ) ) :
            $template_path = MJ_SIMPLE_SLIDESHOW_PATH . '/templates/';
        endif;        
        
        $template = $template_path . $template_name;
        if ( ! file_exists( $template ) ) :
            return new WP_Error( 
                'error', 
                sprintf( 
                    __( '%s does not exist.', MJ_SIMPLE_SLIDESHOW_TEXTDOMAIN ), 
                    '<code>' . $template . '</code>' 
                ) 
            );
        endif;

        do_action( 'mj_before_template_part', $template, $args, $template_path );

        if ( ! empty( $args ) && is_array( $args ) ) :
            extract( $args );
        endif;
        include $template;

        do_action( 'mj_after_template_part', $template, $args, $template_path );
    }

endif;