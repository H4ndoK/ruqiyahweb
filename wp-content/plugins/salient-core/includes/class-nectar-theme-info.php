<?php
/**
 * Nectar Theme Info
 *
 * 
 * @package Salient Core
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nectar Theme Info.
 */
class NectarThemeInfo {
  
  private static $instance;
  public static $theme_options_name = 'Salient';
  
  /**
	 * Initiator.
	 */
  public static function get_instance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
  
  /**
	 * Constructor.
	 */
  public function __construct() {
		if( is_admin() ) {
      
      $theme = wp_get_theme(); 
	    
      if( $theme->exists() ) {
        self::$theme_options_name = sanitize_html_class( $theme->get( 'Name' ) );
      }
      
		}
  }
  
  public static function global_colors_tab_url() {
    return esc_url( admin_url() .'?page='.self::$theme_options_name.'&tab=6' );
  }

  
}


/**
 * Initialize the NectarThemeInfo class
 */
NectarThemeInfo::get_instance();
