<?php
/**
 * Nectar Lazy Load Images 
 *
 * 
 * @package Salient Core
 * @version 1.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Nectar Lazy Images.
 */
class NectarLazyImages {
  
  private static $instance;
  
  public static $global_option_active = false;
	
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
	 * Determines whether or not to use lazy loading data source.
	 */
  public static function activate_lazy() {
    return false;
  }

  public static function generate_image_markup($img) {
    return $img;
  }
  
}


/**
 * Initialize the NectarElAssets class
 */
NectarLazyImages::get_instance();

