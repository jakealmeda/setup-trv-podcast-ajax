<?php
/**
 * Plugin Name: Setup Play Podcast
 * Description: Play the Podcast entry's podcast in place upon the click of a button.
 * Version: 1.0
 * Author: Jake Almeda
 * Author URI: http://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// SHORTCODE
add_shortcode( 'setup-play-podcast', 'setup_play_podcast_ajax_main_function' );
function setup_play_podcast_ajax_main_function( $atts ) {

    // validate template name (this should be without the extension name '.php')
    //if( $atts[ 'template' ] ) {
    if( is_array( $atts ) ){

        if( array_key_exists( "template", $atts ) ) {
            $template = $atts[ 'template' ];
        }
        
    } else {
        // assign default output
        $template = 'default-trv-podcast-ajax';
    }

    // template directory
    $template_dir = plugin_dir_path( __FILE__ ).'templates/';

    return setup_starter_get_template( $template_dir, $template );

}

// GET CONTENTS OF THE TEMPLATE FILE
if( !function_exists( 'setup_starter_get_template' ) ) {
    
    function setup_starter_get_template( $template_dir, $filename ) {
        
        ob_start();
        include $template_dir.$filename.'.php';
        return ob_get_clean();

    }
    
    //include get_stylesheet_directory().'/partials/setup_starter_templates/'.$filename.'.php';
    
}

// ENQUEUE SCRIPTS
add_action( 'wp_enqueue_scripts', 'setup_trv_podcast_js_scripts' );
function setup_trv_podcast_js_scripts() {

    //$scripts = array( 'jquery-ui-core', 'jquery-effects-core', 'jquery-effects-slide', 'jquery-effects-fade', 'jquery-ui-accordion' );
    $scripts = array( 'jquery-ui-core', 'jquery-effects-core', 'jquery-effects-slide' );
    foreach ( $scripts as $value ) {
        if( !wp_script_is( $value, 'enqueued' ) ) {
            wp_enqueue_script( $value );
        }
    }

    $script_name = 'setup-play-podcast-js';

    // Register the script
    wp_register_script( $script_name, plugin_dir_url( __FILE__ ).'js/asset.js', array( 'jquery' ), '1.0.0', TRUE );

    $cpt = "podcast";
    $ss_parameters[ 'rest_url_acf' ] = rest_url( 'acf/v3/'.$cpt );
    //$ss_parameters[ 'display_fields' ] = array( 'podcast_embed', 'title' );
    $ss_parameters[ 'display_fields' ] = array( 'podcast_embed' ); //podcast_audio
    $ss_parameters[ 'ajaxurl' ] = plugin_dir_url( __FILE__ ).'ajax';

    // Localize variables to pass from PHP to JavaScript
    wp_localize_script( $script_name, 'setup_play_podcast_vars', $ss_parameters );
    
    // Enqueued script with localized data
    wp_enqueue_script( $script_name );

}