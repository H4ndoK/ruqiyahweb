<?php
/**
 * Nectar Icon Class
 *
 * Used to Locate/render an icon in array segment 
 *
 * @package Salient Core
 */

 // Exit if accessed directly
 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

 if( !class_exists('Nectar_Icon') ) {

   class Nectar_Icon {

    public function __construct( $icon_props ) {
      
      // Defaults.
      $this->defaults = array(
        'icon_name'   => '',
        'icon_family' => 'iconsmind'
      );

      $args = wp_parse_args( $icon_props, $this->defaults );

      $this->icon_name       = esc_attr($args['icon_name']);
      $this->icon_family     = in_array($args['icon_family'], array('iconsmind','linea')) ? $args['icon_family'] : 'iconsmind';
      $this->icon_collection = array();
      $this->icon            = array();
      $this->letter          = '';

      // If correct icon format is passed, locate and set relevant array.
      if( !empty($this->icon_name) ) {

        $first_char = substr($this->icon_name, 0, 1);

        if( preg_match("/^[a-zA-Z]$/", $first_char) ) {
          $this->letter = strtolower($first_char);
         
          $this->set_icon_collection();
        }
        
      }
      
    }

    public function set_icon_collection() {

      include_once( SALIENT_CORE_ROOT_DIR_PATH.'includes/icons/data/'.$this->icon_family.'-'.$this->letter.'.php' );

      $icon_arr_func = 'salient_'.$this->icon_family.'_arr_'.$this->letter;

      if( function_exists($icon_arr_func) ) {
        $this->icon_collection = $icon_arr_func();
        $this->set_icon();
      }

    }


    public function set_icon() {
      $this->icon = $this->icon_collection[$this->icon_name];
    }


    public function render_icon() {

      if( !empty($this->icon) ) {
        return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="'.esc_attr($this->icon['width']).'" height="'.esc_attr($this->icon['height']).'" viewBox="0 0 '.esc_attr($this->icon['width']).' '.esc_attr($this->icon['height']).'">
        <path d="'.esc_attr($this->icon['path']).'"></path>
        </svg>';
      }

      return;

    }

   }

  }