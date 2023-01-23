<?php
/**
 * Menu Item Settings
 *
 * @package Salient Core
 */

 // Exit if accessed directly
 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

 if( !class_exists('Nectar_WP_Menu_Settings') ) {

   class Nectar_WP_Menu_Settings {

     private static $instance;

     public static $settings;
     public static $theme_options_name = 'Salient';

     public function __construct() {

       if( is_admin() ) {
         $theme = wp_get_theme();

         if( $theme->exists() ) {
           self::$theme_options_name = sanitize_html_class( $theme->get( 'Name' ) );
         }
       }

       self::$settings = array(
         /************* mega menu *************/
        'enable_mega_menu' => array(
          'type'          => 'switch_toggle',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Enable Mega Menu','salient-core'),
          'description'   => esc_html__('Turns your dropdown into a megamenu. All submenu items will display horizontally.','salient-core'),
          'max_depth' => '0',
          'default_value' => '0'
        ),
        'mega_menu_width' => array(
          'type'          => 'dropdown',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Width','salient-core'),
          'description'   => esc_html__('By default, a mega menu will occupy 100% width relative to the header container.','salient-core'),
          'default_value' => 'full',
          'max_depth' => '0',
          'options' => array(
            '100' => esc_html__('100% Header Width','salient-core'),
            '75' => esc_html__('x3 Regular Dropdown','salient-core'),
            '50' => esc_html__('x2 Regular Dropdown','salient-core')
          )
        ),
        'mega_menu_alignment' => array(
          'type'          => 'dropdown',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Alignment','salient-core'),
          'description'   => esc_html__('Determines how your megamenu will align when the width is less than 100%.','salient-core'),
          'default_value' => 'left',
          'max_depth' => '0',
          'options' => array(
            'left' => esc_html__('Left','salient-core'),
            'middle' => esc_html__('Middle','salient-core'),
            'right' => esc_html__('Right','salient-core'),
          )
        ),
        'disable_mega_menu_title' => array(
          'type'          => 'switch_toggle',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Disable Mega Menu Item Title','salient-core'),
          'description'   => esc_html__('This will toggle the menu item title at the top of your mega menu column.','salient-core'),
          'max_depth' => '1',
          'min_depth'     => '1',
          'default_value' => '0'
        ),
        'mega_menu_bg_img' => array(
          'type'          => 'image',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Background Image','salient-core'),
          'description'   => esc_html__('This will be set behind the entire mega menu as the background.','salient-core'),
          'max_depth' => '0',
          'min_depth' => '0',
          'default_value' => array(
            'id' => '',
            'url' => ''
          )
        ),
        'mega_menu_bg_img_alignment' => array(
          'type'          => 'dropdown',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Background Image Alignment','salient-core'),
          'description'   => esc_html__('Select how your mega menu background image will align.','salient-core'),
          'default_value' => 'center',
          'max_depth' => '0',
          'options' => array(
            'center' => esc_html__('Center','salient-core'),
            'left' => esc_html__('Left','salient-core'),
            'right' => esc_html__('Right','salient-core'),
            'top_left' => esc_html__('Top Left','salient-core'),
            'top_center' => esc_html__('Top Center','salient-core'),
            'top_right' => esc_html__('Top Right','salient-core'),
            'bottom_left' => esc_html__('Bottom Left','salient-core'),
            'bottom_center' => esc_html__('Bottom Center','salient-core'),
            'bottom_right' => esc_html__('Bottom Right','salient-core'),
          )
        ),
        'menu_item_column_width' => array(
          'type'          => 'numerical',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Column Width','salient-core'),
          'description'   => esc_html__('When this item is used in a mega menu, this will determine the percentage space that it occupies. You can leave this field blank to have the width automatically determined.','salient-core'),
          'default_value' => '',
          'custom_attrs'    => array(
            'data-ceil' => '100',
            'data-units' => 'percent'
          ),
          'max_depth' => '1',
          'min_depth'     => '1',
        ),
        'menu_item_column_padding' => array(
          'type'          => 'dropdown',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Column Padding','salient-core'),
          'description'   => esc_html__('Select the amount of column padding to use.','salient-core'),
          'default_value' => 'default',
          'max_depth' => '1',
          'min_depth'     => '1',
          'options' => array(
            'default' => esc_html__('Default','salient-core'),
            '15px' => esc_html__('15px','salient-core'),
            '20px' => esc_html__('20px','salient-core'),
            '25px' => esc_html__('25px','salient-core'),
            '30px' => esc_html__('30px','salient-core'),
            '35px' => esc_html__('35px','salient-core'),
            '40px' => esc_html__('40px','salient-core'),
            'none' => esc_html__('None','salient-core')
          )
        ),
        'menu_item_bg_img' => array(
          'type'          => 'image',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Column Background Image','salient-core'),
          'description'   => esc_html__('This will be set as the menu item background when this menu item is used inside of a megamenu.','salient-core'),
          'max_depth' => '1',
          'min_depth' => '1',
          'default_value' => array(
            'id' => '',
            'url' => ''
          )
        ),
        'menu_item_bg_img_alignment' => array(
          'type'          => 'dropdown',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Column Background Image Alignment','salient-core'),
          'description'   => esc_html__('Select how your menu item background image will align.','salient-core'),
          'default_value' => 'center',
          'max_depth' => '1',
          'min_depth' => '1',
          'options' => array(
            'center' => esc_html__('Center','salient-core'),
            'left' => esc_html__('Left','salient-core'),
            'right' => esc_html__('Right','salient-core'),
            'top_left' => esc_html__('Top Left','salient-core'),
            'top_center' => esc_html__('Top Center','salient-core'),
            'top_right' => esc_html__('Top Right','salient-core'),
            'bottom_left' => esc_html__('Bottom Left','salient-core'),
            'bottom_center' => esc_html__('Bottom Center','salient-core'),
            'bottom_right' => esc_html__('Bottom Right','salient-core'),
          )
        ),
        'menu_item_column_bg_color' => array(
          'type'           => 'color',
          'category'      => 'mega-menu',
          'label'          => esc_html__('Mega Menu Column Background Color','salient-core'),
          'description'    => 'This will be set as the menu item background when this menu item is used inside of a megamenu.',
          'default_value'  => '',
          'max_depth' => '1',
          'min_depth' => '1',
        ),
        'mega_menu_padding' => array(
          'type'          => 'dropdown',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Padding','salient-core'),
          'description'   => esc_html__('Select the amount of padding to apply to your megamenu.','salient-core'),
          'default_value' => 'default',
          'max_depth' => '0',
          'options' => array(
            'default' => esc_html__('Default (none)','salient-core'),
            '5px' => esc_html__('5px','salient-core'),
            '10px' => esc_html__('10px','salient-core'),
            '15px' => esc_html__('15px','salient-core'),
            '20px' => esc_html__('20px','salient-core'),
            '25px' => esc_html__('25px','salient-core'),
          )
        ),
        /*'menu_item_widget_area' => array(
          'type'          => 'widget_areas',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Column Widget Location','salient-core'),
          'description'   => esc_html__('Items inside of a mega menu can optionally select a widget location to display instead of the default menu item link.','salient-core'),
          'max_depth' => '1',
          'min_depth' => '1',
          'default_value' => ''
        ),
        'menu_item_widget_area_marign' => array(
          'type'          => 'dropdown',
          'category'      => 'mega-menu',
          'label'         => esc_html__('Mega Menu Column Widget Margin','salient-core'),
          'description'   => esc_html__('Select the amount of space to add between each widget','salient-core'),
          'default_value' => 'default',
          'max_depth' => '1',
          'min_depth'     => '1',
          'options' => array(
            'default' => esc_html__('Default (20px)','salient-core'),
            'none' => esc_html__('None','salient-core'),
          )
        ),*/


         /************* menu item *************/
         'menu_item_link_bg_header' => array(
           'type'          => 'header',
           'label'         => esc_html__('Image','salient-core'),
           'max_depth' => '-1',
           'min_depth' => '1',
           'custom_attrs'    => array(
             'data-flush-header' => 'true',
           ),
         ),
         'menu_item_link_bg_type' => array(
           'type'           => 'dropdown',
           'category'       => 'menu-item',
           'label'          => esc_html__('Image Type','salient-core'),
           'description'    => esc_html__('Specify if you would like this menu item to use an image.','salient-core'),
           'custom_attrs'    => array(
             'data-toggles' => 'menu_item_link_bg_img',
           ),
           'default_value'  => 'none',
           'max_depth' => '-1',
           'min_depth' => '1',
           'options'        => array(
             'none'         => esc_html__('None','salient-core'),
             'custom'       => esc_html__('Custom','salient-core'),
             'featured_image' => esc_html__('Featured Image','salient-core')
           )
         ),
         'menu_item_link_bg_img_custom' => array(
           'type'          => 'image',
           'category'      => 'menu-item',
           'label'         => esc_html__('Menu Item Image','salient-core'),
           'description'   => esc_html__('Optionally set a custom image for your menu item.','salient-core'),
           'max_depth' => '-1',
           'min_depth' => '1',
           'default_value' => array(
             'id' => '',
             'url' => ''
           )
         ),
         'menu_item_link_bg_style' => array(
           'type'           => 'dropdown',
           'category'       => 'menu-item',
           'label'          => esc_html__('Image Style','salient-core'),
           'description'    => esc_html__('Determines how the image will be used in your menu item.','salient-core'),
           'default_value'  => 'default',
           'max_depth' => '-1',
           'min_depth' => '1',
           'options'        => array(
             'default' => esc_html__('Image Behind Menu Text','salient-core'),
             'img-above-text' => esc_html__('Image Above Menu Text','salient-core')
           )
         ),
         'menu_item_link_bg_hover' => array(
           'type'           => 'dropdown',
           'category'       => 'menu-item',
           'label'          => esc_html__('Image Hover','salient-core'),
           'description'    => esc_html__('Define a hover effect for your menu item image.','salient-core'),
           'default_value'  => 'default',
           'max_depth' => '-1',
           'min_depth' => '1',
           'options'        => array(
             'default' => esc_html__('Default','salient-core'),
             'zoom-in' => esc_html__('Zoom In','salient-core'),
             'zoom-in-slow' => esc_html__('Zoom In Slow','salient-core')
           )
         ),
         'menu_item_link_color_overlay' => array(
           'type'           => 'color',
           'category'       => 'menu-item',
           'label'          => esc_html__('Color Overlay','salient-core'),
           'description'    => 'Adds a color to your menu item image.',
           'default_value'  => '#000000',
           'max_depth' => '-1',
           'min_depth' => '1'
         ),
         'menu_item_link_color_overlay_fade' => array(
           'type'          => 'switch_toggle',
           'category'       => 'menu-item',
           'label'         => esc_html__('Fade Overlay To Transparent','salient-core'),
           'description'   => esc_html__('This will turn your color overlay into a gradient that fades to transparent, following the text alignment.','salient-core'),
           'max_depth' => '-1',
           'min_depth' => '1'
         ),
         'menu_item_link_color_overlay_opacity' => array(
           'type'           => 'dropdown_dual',
           'category'       => 'menu-item',
           'label'          => esc_html__('Overlay Opacity','salient-core'),
           'description'    => esc_html__('Control the strength of your color overlay.','salient-core'),
           'default_value'  => array(
             'default' => '0-4',
             'hover' => '0-6'
           ),
           'max_depth' => '-1',
           'min_depth' => '1',
           'options'        => array(
             '1' => esc_html__('1','salient-core'),
             '0-9' => esc_html__('0.9','salient-core'),
             '0-8' => esc_html__('0.8','salient-core'),
             '0-7' => esc_html__('0.7','salient-core'),
             '0-6' => esc_html__('0.6','salient-core'),
             '0-5' => esc_html__('0.5','salient-core'),
             '0-4' => esc_html__('0.4','salient-core'),
             '0-3' => esc_html__('0.3','salient-core'),
             '0-2' => esc_html__('0.2','salient-core'),
             '0-1' => esc_html__('0.1','salient-core'),
             '0-0' => esc_html__('0','salient-core')
           )
         ),

         'menu_item_link_content_alignment' => array(
           'type'           => 'alignment',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Text Alignment','salient-core'),
           'description'    => 'Determines where your menu text will align when using a menu image.',
           'default_value'  => 'center-left',
           'max_depth' => '-1',
           'min_depth' => '1'
         ),

         'menu_item_link_height' => array(
           'type'          => 'numerical_with_units',
           'category'      => 'menu-item',
           'label'         => esc_html__('Menu Item Height','salient-core'),
           'description'   => esc_html__('Set a custom height for your menu item when using a menu image. Leave blank for the standard auto height.','salient-core'),
           'default_value' => array(
             'number' => '',
             'units' => 'px'
           ),
           'max_depth' => '-1',
           'min_depth' => '1',
           'options' => array(
             'px' => esc_html__('px','salient-core'),
             'vh' => esc_html__('vh','salient-core'),
           )
         ),
         'menu_item_link_padding' => array(
           'type'          => 'dropdown',
           'category'      => 'menu-item',
           'label'         => esc_html__('Menu Item Padding','salient-core'),
           'description'   => esc_html__('Select the amount of padding to apply to your menu item link when using a menu image.','salient-core'),
           'default_value' => 'default',
           'max_depth' => '-1',
           'min_depth' => '1',
           'options' => array(
             'default' => esc_html__('Default','salient-core'),
             '15px' => esc_html__('15px','salient-core'),
             '20px' => esc_html__('20px','salient-core'),
             '25px' => esc_html__('25px','salient-core'),
             '30px' => esc_html__('30px','salient-core'),
             '35px' => esc_html__('35px','salient-core'),
             '40px' => esc_html__('40px','salient-core'),
             '45px' => esc_html__('45px','salient-core'),
           )
         ),
         'menu_item_link_border_radius' => array(
           'type'          => 'dropdown',
           'category'      => 'menu-item',
           'label'         => esc_html__('Menu Item Border Radius','salient-core'),
           'description'   => esc_html__('This allows you to round the corners of your menu item link when using a menu image.','salient-core'),
           'default_value' => 'default',
           'max_depth' => '-1',
           'min_depth' => '1',
           'options' => array(
             'default' => esc_html__('None','salient-core'),
             '3px' => esc_html__('3px','salient-core'),
             '5px' => esc_html__('5px','salient-core'),
             '7px' => esc_html__('7px','salient-core'),
             '10px' => esc_html__('10px','salient-core'),
           )
         ),

         'menu_item_link_text_header' => array(
           'type'          => 'header',
           'label'         => esc_html__('Text','salient-core'),
           'max_depth' => '-1',
           'min_depth' => '0',
         ),

         'menu_item_link_typography' => array(
           'type'           => 'dropdown',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Title Inherits Typography From','salient-core'),
           'description'    => esc_html__('Specify the font settings that the menu item should inherit from. These settings are defined by you in the','salient-core') . ' <a href="'. esc_url( admin_url() .'?page='.self::$theme_options_name.'&tab=10' ) .'" target="_blank">' .esc_html__('Salient options panel.','salient-core') . '</a>',
           'default_value'  => 'none',
           'max_depth' => '-1',
           'min_depth' => '1',
           'options'        => array(
             'default' => esc_html__('Default (Navigation Font)','salient-core'),
             'h2' => esc_html__('Heading 2 Font','salient-core'),
             'h3' => esc_html__('Heading 3 Font','salient-core'),
             'h4' => esc_html__('Heading 4 Font','salient-core'),
             'h5' => esc_html__('Heading 5 Font','salient-core'),
             'h6' => esc_html__('Heading 6 Font','salient-core')
           )
         ),
         'menu_item_hide_menu_title' => array(
           'type'          => 'switch_toggle',
           'category'       => 'menu-item',
           'label'         => esc_html__('Hide Menu Item Title Text','salient-core'),
           'description'   => esc_html__('This will hide your menu item text, but keep the link.','salient-core'),
           'max_depth'     => '-1',
           'custom_attrs'    => array(
            'data-toggles' => 'menu_item_hide_menu_title_modifier',
           ),
           'default_value' => '0'
         ),
         'menu_item_hide_menu_title_modifier' => array(
          'type'           => 'dropdown',
          'category'       => 'menu-item',
          'label'          => esc_html__('Hide Menu Item Title Text Functionality','salient-core'),
          'description'    => esc_html__('Fine-tune when your menu item text will be hidden.','salient-core'),
          'default_value'  => 'all',
          'max_depth'  => '-1',
          'options'        => array(
            'all'          => esc_html__('Hidden in all viewports','salient-core'),
            'mobile-only'       => esc_html__('Hidden on mobile only','salient-core'),
          )
        ),

         'menu_item_persist_mobile_header' => array(
          'type'          => 'switch_toggle',
          'category'       => 'menu-item',
          'label'         => esc_html__('Persist In Mobile Navigation Header','salient-core'),
          'description'   => esc_html__('This will cause the link to remain visible in your mobile header navigation instead of the default location within the off canvas menu.','salient-core'),
          'max_depth'     => '0',
          'default_value' => '0'
        ),
         'menu_item_link_margin' => array(
           'type'          => 'numerical_dual',
           'category'      => 'menu-item',
           'label'         => esc_html__('Menu Item Margin','salient-core'),
           'description'   => esc_html__('Select the amount of margin to apply to your menu item link.','salient-core'),
           'default_value'  => array(
             'top' => '',
             'bottom' => ''
           ),
           'custom_attrs'    => array(
             'data-units' => 'px'
           ),
           'max_depth' => '-1',
           'min_depth' => '1',
         ),

         'menu_item_link_label' => array(
           'type'          => 'text',
           'category'      => 'menu-item',
           'label'         => esc_html__('Menu Item Label','salient-core'),
           'description'   => esc_html__('Add an optional label which will display next to the menu item text. ','salient-core'),
           'default_value' => '',
           'max_depth' => '-1',
         ),

         'menu_item_link_link_style' => array(
          'type'           => 'dropdown',
          'category'       => 'menu-item',
          'label'          => esc_html__('Menu Item Link Button Style','salient-core'),
          'description'    => esc_html__('Choose a style for your menu item.','salient-core'),
          'max_depth' => '0',
          'options'        => array(
              'default'      => esc_html__('Default','salient-core'),
              'button_accent-color'  => esc_html__('Button Accent Color','salient-core'),
              'button_extra-color-1'  => esc_html__('Button Extra Color #1','salient-core'),
              'button_extra-color-gradient'  => esc_html__('Button Gradient Color','salient-core'),
              'button-animated_extra-color-gradient'  => esc_html__('Button Gradient Color Animated','salient-core'),
              'button-border_accent-color'  => esc_html__('Button Bordered Accent Color','salient-core'),
              'button-border_extra-color-1'  => esc_html__('Button Bordered Extra Color #1','salient-core'),
              'button-border_extra-color-gradient'  => esc_html__('Button Bordered Gradient','salient-core'),
              'button-border-animated_extra-color-gradient'  => esc_html__('Button Bordered Gradient Animated','salient-core'),
              'button-border-white-animated_extra-color-gradient'  => esc_html__('Button Bordered White BG Gradient Animated','salient-core'),
            )
          ),

          'menu_item_link_link_text_style' => array(
            'type'           => 'dropdown',
            'category'       => 'menu-item',
            'label'          => esc_html__('Menu Item Link Text Hover','salient-core'),
            'description'    => esc_html__('Optionally set a link hover animation.','salient-core'),
            'max_depth' => '0',
            'options'        => array(
                'default'      => esc_html__('Default','salient-core'),
                'text-reveal-wave'  => esc_html__('Text Reveal Wave','salient-core'),
              )
            ),

         'menu_item_link_text_color_type' => array(
           'type'           => 'dropdown',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Text Coloring','salient-core'),
           'description'    => esc_html__('Select how your menu item text should be colored.','salient-core'),
           'custom_attrs'    => array(
             'data-toggles' => 'menu_item_link_coloring',
           ),
           'default_value'  => 'default',
           'max_depth' => '-1',
           'options'        => array(
             'default'      => esc_html__('Default (Automatic)','salient-core'),
             'custom'       => esc_html__('Custom Coloring','salient-core'),
           )
         ),
         'menu_item_link_coloring_custom_text' => array(
           'type'           => 'color',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Title Color','salient-core'),
           'description'    => 'The color used for your menu item title.',
           'default_value'  => '#ffffff',
           'max_depth' => '-1',
           'min_depth' => '1'
         ),
         'menu_item_link_coloring_custom_text_h' => array(
           'type'           => 'color',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Title Color Hover','salient-core'),
           'description'    => 'The color used for your menu item title on hover.',
           'default_value'  => '#ffffff',
           'max_depth' => '-1',
           'min_depth' => '1'
         ),

         'menu_item_link_coloring_custom_text_p' => array(
           'type'           => 'color',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Title Color','salient-core'),
           'description'    => 'The color used for your menu item title.',
           'default_value'  => '#000000',
           'max_depth' => '0',
         ),
         'menu_item_link_coloring_custom_text_h_p' => array(
           'type'           => 'color',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Title Color Hover','salient-core'),
           'description'    => 'The color used for your menu item title on hover.',
           'default_value'  => '#777777',
           'max_depth' => '0',
         ),

         'menu_item_link_coloring_custom_desc' => array(
           'type'           => 'color',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Description Color','salient-core'),
           'description'    => 'The color used for your menu item description.',
           'default_value'  => '#ffffff',
           'max_depth' => '-1',
           'min_depth' => '1'
         ),
         'menu_item_link_coloring_custom_label' => array(
           'type'           => 'color',
           'category'       => 'menu-item',
           'label'          => esc_html__('Menu Item Label','salient-core'),
           'description'    => 'The color used for your menu item label',
           'default_value'  => '#999999',
           'max_depth' => '-1',
         ),


         /************* icons  *************/
        'menu_item_icon_type' => array(
          'type'           => 'dropdown',
          'category'       => 'menu-icon',
          'label'          => esc_html__('Icon Type','salient-core'),
          'description'    => '',
          'custom_attrs'    => array(
            'data-icon-container'            => 'menu_item_icon',
            'data-iconsmind-container'       => 'menu_item_icon_iconsmind',
            'data-icon-custom'               => 'menu_item_icon_custom',
            'data-icon-custom-text'          => "menu_item_icon_custom_text",
            'data-icon-custom-border-radius' => "menu_item_icon_custom_border_radius"
          ),
          'default_value'  => 'font_awesome',
          'max_depth' => '-1',
          'options'          => array(
            'font_awesome'   => esc_html__('Font Awesome','salient-core'),
            'iconsmind'      => esc_html__('Iconsmind','salient-core'),
            'custom'         => esc_html__('Custom Image','salient-core'),
            'custom_text'    => esc_html__('Custom Text (Emoji)','salient-core')
          )
        ),
        'menu_item_icon_size' => array(
          'type'          => 'numerical',
          'category'       => 'menu-icon',
          'label'         => esc_html__('Menu Icon Size','salient-core'),
          'description'   => esc_html__('Define a custom size for your icon. Leave this blank for the default value.','salient-core'),
          'default_value' => '',
          'custom_attrs'    => array(
            'data-ceil' => '100',
            'data-units' => 'px'
          ),
          'max_depth' => '-1',
        ),
        'menu_item_icon_position' => array(
          'type'           => 'dropdown',
          'category'       => 'menu-icon',
          'label'          => esc_html__('Menu Icon Position','salient-core'),
          'description'    => esc_html__('Determines where the menu icon will be aligned relative to the text. (Only applies to submenu items)','salient-core'),
          'default_value'  => 'default',
          'max_depth' => '-1',
          'options'        => array(
            'default' => esc_html__('Next To Text','salient-core'),
            'above' => esc_html__('Above Text','salient-core'),
          )
        ),
        'menu_item_icon_spacing' => array(
          'type'          => 'numerical',
          'category'       => 'menu-icon',
          'label'         => esc_html__('Menu Icon Spacing','salient-core'),
          'description'   => esc_html__('Define a custom amount of spacing between your icon and menu item text. Leave this blank for the default value. (Only applies to submenu items)','salient-core'),
          'default_value' => '',
          'custom_attrs'    => array(
            'data-ceil' => '50',
            'data-units' => 'px'
          ),
          'max_depth' => '-1',
        ),
        'menu_item_icon_custom' => array(
          'type'          => 'image',
          'category'       => 'menu-icon',
          'label'         => esc_html__('Custom Icon Selection','salient-core'),
          'description'   => esc_html__('Upload a custom icon to display next to the menu item title. You can select the size which menu icons will display at in the','salient-core') . ' <a href="'. esc_url( admin_url() .'?page='.self::$theme_options_name.'&tab=13' ) .'" target="_blank">' .esc_html__('Salient options panel.','salient-core') . '</a>',
          'max_depth' => '-1',
          'default_value' => array(
            'id' => '',
            'url' => ''
          )
        ),

        'menu_item_icon_custom_border_radius' => array(
          'type'          => 'numerical',
          'category'      => 'menu-icon',
          'label'         => esc_html__('Menu Icon Border Radius','salient-core'),
          'description'   => esc_html__('This allows you to round the corners of your icon image.','salient-core'),
          'default_value' => '',
          'max_depth' => '-1',
          'custom_attrs'    => array(
            'data-ceil' => '100',
            'data-units' => 'px'
          ),
        ),

        'menu_item_icon_custom_text' => array(
          'type'          => 'text',
          'category'      => 'menu-icon',
          'label'         => esc_html__('Menu Icon Text (Emoji)','salient-core'),
          'description'   => esc_html__('Add in a symbol or emoji to display as the icon next to your menu title.','salient-core') . '<br/><br/><strong>' . esc_html__('To add an Emoji:','salient-core') . '</strong><br/><br/>'. esc_html__('Windows: On your keyboard, press and hold the Windows button and either the period (.) or semicolon (;)','salient-core') . '<br/><br/>'. esc_html__('Mac: On your keyboard, press Command + Control + Space','salient-core'),
          'default_value' => '',
          'max_depth' => '-1',
        ),
        'menu_item_icon' => array(
          'type'          => 'icon',
          'category'       => 'menu-icon',
          'label'         => esc_html__('Font Icon Selection','salient-core'),
          'description'   => esc_html__('Select an icon to display next to the menu item title. You can select the size which menu icons will display at in the','salient-core') . ' <a href="'. esc_url( admin_url() .'?page='.self::$theme_options_name.'&tab=13' ) .'" target="_blank">' .esc_html__('Salient options panel.','salient-core') . '</a>',
          'max_depth' => '-1',
          'custom_attrs'    => array(
            'data-library' => 'font_awesome',
          ),
          'default_value' => ''
        ),
        'menu_item_icon_iconsmind' => array(
          'type'          => 'icon',
          'category'       => 'menu-icon',
          'label'         => esc_html__('Font Icon Selection','salient-core'),
          'description'   => esc_html__('Select an icon to display next to the menu item title. You can select the size which menu icons will display at in the','salient-core') . ' <a href="'. esc_url( admin_url() .'?page='.self::$theme_options_name.'&tab=13' ) .'" target="_blank">' .esc_html__('Salient options panel.','salient-core') . '</a>',
          'max_depth' => '-1',
          'custom_attrs'    => array(
            'data-library' => 'iconsmind',
          ),
          'default_value' => ''
        ),
      );

      
       /************* Off canvas menu  *************/
       $nectar_options = array();
      if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
        $nectar_options = get_nectar_theme_options();
      }

      if( isset($nectar_options['header-slide-out-widget-area-style']) && 
          $nectar_options['header-slide-out-widget-area-style'] === 'fullscreen-inline-images' ) {

            self::$settings['menu_item_ocm_header'] = array(
              'type'          => 'header',
              'category'       => 'menu-item',
              'label'         => esc_html__('Off Canvas Menu','salient-core'),
              'max_depth' => '0'
            );
            self::$settings['menu_item_ocm_image'] = array(
              'type'          => 'image',
              'category'       => 'menu-item',
              'label'         => esc_html__('Off Canvas Menu Image','salient-core'),
              'description'   => esc_html__('Upload an image to display for your menu item when this menu is assigned to the Off Canvas Navigation Menu location.','salient-core'),
              'max_depth' => '0',
              'default_value' => array(
                'id' => '',
                'url' => ''
              )
            );
        } // End OCM conditional.

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
     * Returns the settings.
     */
     public static function get_settings() {
       return self::$settings;
     }

   }

   // Init class.
   Nectar_WP_Menu_Settings::get_instance();

}
