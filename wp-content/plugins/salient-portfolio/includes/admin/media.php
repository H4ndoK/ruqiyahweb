<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add image sizes.
 *
 * @since 1.0
 */
 
 if ( ! function_exists( 'salient_portfolio_add_image_sizes' ) ) {

 	function salient_portfolio_add_image_sizes() {

 		add_image_size( 'portfolio-thumb_large', 900, 604, true );
 		add_image_size( 'portfolio-thumb', 600, 403, true );
 		add_image_size( 'portfolio-thumb_small', 400, 269, true ); 			
		add_image_size( 'wide', 1000, 500, true );
		add_image_size( 'wide_small', 670, 335, true );
		add_image_size( 'regular', 500, 500, true );
		add_image_size( 'regular_small', 350, 350, true );
		add_image_size( 'tall', 500, 1000, true );
		add_image_size( 'wide_tall', 1000, 1000, true );
 	}
  
 }
 
if( ! defined( 'NECTAR_THEME_NAME' )  ) {
 add_action( 'after_setup_theme', 'salient_portfolio_add_image_sizes' );
}