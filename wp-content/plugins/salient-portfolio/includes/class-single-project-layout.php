<?php
/**
* Single Project
*
* Determines the layout for single projects
*
* @package Salient Portfolio Plugin
* @version 1.6
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}


/**
* Nectar Element Assets.
*/
class Salient_Portfolio_Single_Layout {
  
  private static $instance;
  
  public static $is_full_width  = false;
  public static $default_header = true;
  public static $using_vcv = false;
  
  public function __construct() {
    
    self::get_layout();

  }
  
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
  * Store the layout.
  */
  public static function get_layout() {
    
    // Salient is the active theme.
    if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
      
      $options = get_nectar_theme_options(); 
      
      if( isset($_GET['vcv-editable']) && '1' === sanitize_text_field($_GET['vcv-editable']) ) {
        self::$using_vcv = true;
      }

      // Page builder layout.
      if( isset($options['single_portfolio_project_layout']) && 
      !empty($options['single_portfolio_project_layout']) && 
      'page_builder' === $options['single_portfolio_project_layout'] ) {
        self::$is_full_width = true;
      }
      
      // Remove project header.
      if( isset($options['portfolio_remove_single_header']) && 
        !empty($options['portfolio_remove_single_header']) && 
      	'1' === $options['portfolio_remove_single_header'] ) {
        self::$default_header = false;
      }
      
    } // using Salient.

  }
  
}


/**
* Initialize the Salient_Portfolio_Single_Layout class
*/
Salient_Portfolio_Single_Layout::get_instance();
