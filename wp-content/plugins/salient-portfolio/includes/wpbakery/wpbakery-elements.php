<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('vc_before_init', 'salient_portfolio_maps');

if( ! function_exists('salient_portfolio_maps') ) {
  function salient_portfolio_maps() {
    
    vc_lean_map('nectar_portfolio', null, SALIENT_PORTFOLIO_ROOT_DIR_PATH . 'includes/wpbakery/maps/nectar_portfolio.php');

    vc_lean_map('recent_projects', null, SALIENT_PORTFOLIO_ROOT_DIR_PATH . 'includes/wpbakery/maps/recent_projects.php');
    
  }
}
