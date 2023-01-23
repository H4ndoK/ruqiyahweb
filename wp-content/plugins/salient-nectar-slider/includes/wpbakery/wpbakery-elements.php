<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('vc_before_init', 'salient_nectar_slider_maps');

if( !function_exists('salient_nectar_slider_maps') ) {
  function salient_nectar_slider_maps() {
    
    vc_lean_map('nectar_slider', null, SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH . 'includes/wpbakery/maps/nectar_slider.php');
    
  }
}