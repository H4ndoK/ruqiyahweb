<?php
/**
 * Nectar Setting Field
 *
 * Helper class to generate setting fields
 *
 * @package Salient Core
 */

 // Exit if accessed directly
 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

 if( !class_exists('Nectar_Setting_Field') ) {

   class Nectar_Setting_Field {

     public function __construct( $id, $field = array(), $value = null ) {

       // Verify that passed type is valid.
       $this->field_type_list = array(
         'text',
         'numerical_with_units',
         'numerical',
         'numerical_dual',
         'textarea',
         'switch_toggle',
         'dropdown',
         'dropdown_dual',
         'widget_areas',
         'image',
         'icon',
         'color',
         'alignment',
         'header'
       );

       // Defaults.
       $this->defaults = array(
         'type'           => 'text',
         'category'       => 'menu-item',
         'label'          => '',
         'class'          => '',
         'default_value'  => false,
         'description'    => false,
         'options'        => false,
         'custom_attrs'   => false
       );

       $field_args = wp_parse_args( $field, $this->defaults );

       $this->default_value = $field_args['default_value'];

       // Sanitize incoming.
       $this->field_id          = esc_attr( $id );
       $this->field_type        = esc_attr( $field_args['type'] );
       $this->field_cat         = esc_attr( $field_args['category'] );
       $this->field_label       = esc_attr( $field_args['label'] );
       $this->field_description = wp_kses_post( $field_args['description'] );

       // Arrays.
       if( is_array($value) ) {
         $this->value = $this->sanitize_arr($value);
       } else {
         $this->value = esc_attr( $value );
       }

       if ( is_array( $field_args['options'] ) ) {
         $this->field_options = $this->sanitize_arr($field_args['options']);
       }
       else {
         $this->field_options = $field_args['options'];
       }

       // Custom attrs.
       $this->field_custom_attrs = '';
       $this->field_custom_attrs_arr = array();

       if ( is_array( $field_args['custom_attrs'] ) ) {
         
        $this->field_custom_attrs_arr = $this->sanitize_arr($field_args['custom_attrs']);

         foreach ( $field_args['custom_attrs'] as $attr_name => $val ) {
           $this->field_custom_attrs .= ' ' . esc_attr( $attr_name ) . '="' . esc_attr( $val ). '"';
         }
       }

       $this->render_field();

     }

     public function render_field() {

       if( in_array( $this->field_type, $this->field_type_list ) ) {

         $this->field_start();
         call_user_func( array( $this, $this->field_type ) );
         $this->field_end();

       }

     }

     public function field_start() {
       echo '<div class="setting-field nectar-setting-'. $this->field_type.'" data-cat="'.$this->field_cat.'" '.$this->field_custom_attrs.'>';
       if( 'header' === $this->field_type ) {
         echo '<h2>'.$this->field_label.'</h2>';
       } else {
         echo '<div class="field-info">'.$this->field_label;
         if( $this->field_description ) {
           echo '<span class="description">'.$this->field_description.'</span>';
         }
         echo '</div>';
       }
       echo '<div class="setting">';

     }

     public function field_end() {
        echo '</div></div> <!--/setting-field-->';
     }

     public function field_value() {

       // Arrays are already escaped.
       if( is_array( $this->value ) ) {
         return $this->value;
       }

       // Regular values.
       $value = '';

       if( $this->value ) {
         $value = $this->value;
       } else if( $this->default_value ) {
         $value = $this->default_value;
       }

       return esc_attr($value);
     }

     public function header() {
       // handled in start.
     }

     public function sanitize_arr($arr) {

       $sanitized = array();

       foreach ( $arr as $k => $v ) {
         $sanitized[sanitize_key( $k )] = sanitize_text_field( $v );
       }

       return $sanitized;
     }

     public function text() {

       $value = $this->field_value();

       // Fields which need decoding.
       if( 'menu_item_icon_custom_text' === $this->field_id ) {
         $value = esc_attr( sanitize_text_field( urldecode( $value ) ) );
       }

       echo '<input type="text" id="'.$this->field_id.'" name="'.$this->field_id.'" value="'. $value .'" />';
     }

     public function dropdown() {

       echo '<select id="'.$this->field_id.'" name="'.$this->field_id.'">';
       foreach( $this->field_options as $k => $v ) {
          $selected = ( $k == $this->field_value() ) ? ' selected' : '';
         echo '<option value="'.esc_attr($k).'"'.$selected.'>'.esc_html($v).'</option>';
       }
       echo '</select>';
     }

     public function dropdown_dual() {

       $value = $this->field_value();

       $default_o = (is_array($value) && isset($value['default'])) ? $value['default'] : '';
       $hover_o = (is_array($value) && isset($value['hover'])) ? $value['hover'] : '';

       echo '<div><span>'. esc_html__('Default Opacity','salient-core') .'</span><select id="'.$this->field_id.'-default" name="'.$this->field_id.'[default]">';
       foreach( $this->field_options as $k => $v ) {
          $selected = ( $k == $default_o ) ? ' selected' : '';
         echo '<option value="'.esc_attr($k).'"'.$selected.'>'.esc_html($v).'</option>';
       }
       echo '</select></div>';

       echo '<div><span>'. esc_html__('Hover Opacity','salient-core') .'</span><select id="'.$this->field_id.'-hover" name="'.$this->field_id.'[hover]">';
       foreach( $this->field_options as $k => $v ) {
          $selected = ( $k == $hover_o ) ? ' selected' : '';
         echo '<option value="'.esc_attr($k).'"'.$selected.'>'.esc_html($v).'</option>';
       }
       echo '</select></div>';

     }

     public function widget_areas() {

       $widget_locations = $GLOBALS['wp_registered_sidebars'];

       echo '<select id="'.$this->field_id.'" name="'.$this->field_id.'">';

       $selected = ( 'none' === $this->field_value() ) ? ' selected' : '';
       echo '<option value="none"'.$selected.'>'.esc_html__('None','salient-core').'</option>';
       foreach( $widget_locations as $location ) {

         if( isset($location['id']) && isset($location['name']) ) {
           $selected = ( $location['id'] === $this->field_value() ) ? ' selected' : '';
           echo '<option value="'.esc_attr($location['id']).'"'.$selected.'>'.esc_html($location['name']).'</option>';
         }

       }
       echo '</select>';
     }

     public function switch_toggle() {

       $selected_enable = '';
       $selected_disable = ' selected';
       $activated = '';

       if( 'on' === $this->field_value() ) {
         $selected_enable = ' selected';
         $selected_disable = '';
         $activated = ' activated';
       }

       echo '<div class="nectar-metabox-table"><div class="switch-options salient'.$activated.'">
          <label class="cb-enable'.$selected_enable.'"><span>On</span></label>
          <label class="cb-disable'.$selected_disable.'"><span>Off</span></label>
          <input type="hidden" name="'.$this->field_id.'" value="'. $this->field_value() .'">
        </div></div>';
     }

     public function icon() {

       if( $this->field_value() ) {
         $hidden = '';
         $icon_prev = '<i class="'.esc_attr($this->field_value()).'"></i>';
       } else {
         $hidden = ' hidden';
         $icon_prev = '';
       }
       echo '<div class="selected-icon'.$hidden.'"><a class="button-secondary" href="#"><span>'.$icon_prev.'</span> '.esc_html__('Remove','salient-core').'</a></div>';
       echo '<div class="nectar-icon-search"><input type="text" name="icon_search" placeholder="'.esc_attr__('Search for an icon...','salient-core').'" /></div>';
       echo '<div class="nectar-icon-container">';

       $library = isset( $this->field_custom_attrs_arr['data-library'] ) ? $this->field_custom_attrs_arr['data-library'] : 'font_awesome';

       if( $library === 'font_awesome' ) {
          $icons = nectar_font_awesome_icon_list();
          foreach ($icons as $key => $icon) {
            $active = ( $this->field_value() === $icon ) ? ' class="active"' : '';
            echo '<span'.$active.'><i class="'.esc_attr($icon).'"></i></span>';
          }
        } 
        else if( $library === 'iconsmind' ) {
          $icons = nectar_iconsmind_icon_list();
          foreach ($icons as $key => $icon) {
            $active = ( $this->field_value() === $key ) ? ' class="active"' : '';
            echo '<span'.$active.'><i class="'.esc_attr($key).'"></i></span>';
          }

        }

       echo '</div>';
       echo '<input type="hidden" name="'.$this->field_id.'" id="' . $this->field_id . '" value="' . $this->field_value() . '" />';
     }

     public function image() {

       $value = $this->field_value();

       if( is_array($value) && isset($value['url']) && !empty($value['url']) ) {
         $add_class = ' hidden';
         $remove_class = '';
       } else {
         $add_class = '';
         $remove_class = ' hidden';
       }

        $url = '';
        $id = (is_array($value) && isset($value['id'])) ? $value['id'] : '';

        // Grab actual preview based on ID to allow menu imports to function correctly.
        if( $id ) {
          $preview_image_source = wp_get_attachment_image_src($id, 'medium');
          if( isset($preview_image_source[0]) ) {
            $url = $preview_image_source[0];
          }
        }

        echo '<input type="hidden" id="' . $this->field_id . '-url" name="'.$this->field_id.'[url]" value="' . esc_attr($url) . '" />';
        echo '<input type="hidden" id="' . $this->field_id . '-id" name="'.$this->field_id.'[id]" value="' . esc_attr($id)  . '" />';
      
        echo '<div class="preview-wrap">
          <img class="nectar-media-preview'.$remove_class.'" id="' . $this->field_id . '" src="' . esc_attr($url) . '" />
          <a href="#" class="nectar-remove-btn button-secondary' . $remove_class . '" rel-id="' . $this->field_id . '"><span class="dashicons dashicons-no-alt"></span> ' . esc_html__('Remove', 'salient-core') . '</a>
        </div>';
        echo '<a href="#" data-update="' . esc_html__('Select Image', 'salient-core') . '" data-title="' . esc_html__('Choose Your Image', 'salient-core') . '" class="nectar-add-btn button-secondary' . $add_class . '" rel-id="' . $this->field_id . '"><span class="dashicons dashicons-plus-alt2"></span> ' . esc_html__('Add Image', 'salient-core') . '</a>';


     }

     public function color() {
       $value = $this->field_value();
       echo '<div class="nectar-option-colorpicker">
       <input type="text" id="'. $this->field_id .'" name="'. $this->field_id .'" value="'.$value.'" class="popup-colorpicker" data-default-color="'.$value.'"/>
       </div>';
     }

     public function alignment() {

       $value = $this->field_value();

       $selection_pos_arr = array(
         'top-left' => 'dashicons dashicons-arrow-up-alt',
         'top-center' => 'dashicons dashicons-arrow-up-alt',
         'top-right' => 'dashicons dashicons-arrow-up-alt',
         'center-left' => 'dashicons dashicons-arrow-left-alt',
         'center-center' => 'center-circle',
         'center-right' => 'dashicons dashicons-arrow-right-alt',
         'bottom-left' => 'dashicons dashicons-arrow-down-alt',
         'bottom-center' => 'dashicons dashicons-arrow-down-alt',
         'bottom-right' => 'dashicons dashicons-arrow-down-alt',
       );

       echo '<div class="selection">';
         foreach($selection_pos_arr as $pos => $icon) {
           $active_class = ( $value === $pos) ? ' active': '';
           echo '<span data-pos="'.esc_attr($pos).'" class="'. esc_attr($active_class) . '"><span class="'.esc_attr($icon).'"></span></span>';
         }
       echo '</div>';

       echo '<input type="hidden" id="' . $this->field_id . '" name="'.$this->field_id.'" value="' . esc_attr($value) . '" />';
     }


     public function numerical() {
       $value = $this->field_value();
       echo '<span class="numerical-input-wrap"><input type="text" id="' . $this->field_id . '" name="'.$this->field_id.'" placeholder="'.esc_html__('Automatic','salient-core').'" class="nectar-numerical" value="' . esc_attr($value) . '" /></span>';

     }

     public function numerical_dual() {

       $value = $this->field_value();
       echo '<div><span>'.esc_html__('Top','salient-core').'</span><span class="numerical-input-wrap"><input type="text" id="' . $this->field_id . '-top" name="'.$this->field_id.'[top]" placeholder="'.esc_html__('Automatic','salient-core').'" class="nectar-numerical" value="' . esc_attr($value['top']) . '" /></span></div>';
       echo '<div><span>'.esc_html__('Bottom','salient-core').'</span><span class="numerical-input-wrap"><input type="text" id="' . $this->field_id . '-bottom" name="'.$this->field_id.'[bottom]" placeholder="'.esc_html__('Automatic','salient-core').'" class="nectar-numerical" value="' . esc_attr($value['bottom']) . '" /></span></div>';

     }


     public function numerical_with_units() {

       $value = $this->field_value();
       echo '<span class="numerical-input-wrap"><input type="text" id="' . $this->field_id . '-number" name="'.$this->field_id.'[number]" class="nectar-numerical" value="' . esc_attr($value['number']) . '" /></span>';

       echo '<select id="'.$this->field_id.'-units" name="'.$this->field_id.'[units]">';
       foreach( $this->field_options as $k => $v ) {
          $selected = ( $k == $value['units'] ) ? ' selected' : '';
         echo '<option value="'.esc_attr($k).'"'.$selected.'>'.esc_html($v).'</option>';
       }
       echo '</select>';

     }

   }

 }
