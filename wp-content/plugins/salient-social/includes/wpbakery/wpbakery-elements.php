<?php 

add_action('vc_before_init', 'salient_social_maps');

if( !function_exists('salient_social_maps') ) {
  function salient_social_maps() {
    
    vc_lean_map('social_buttons', null, SALIENT_SOCIAL_ROOT_DIR_PATH . 'includes/wpbakery/maps/salient-social.php');
    
  }
}