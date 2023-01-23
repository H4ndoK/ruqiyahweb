<?php
/**
 * Menu Item Styles
 *
 * @package Salient Core
 */

 // Exit if accessed directly
 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

 if( !class_exists('Nectar_WP_Menu_Style_Manager') ) {

   class Nectar_WP_Menu_Style_Manager {

     private static $instance;

     public static $upload_dir;
     public static $upload_url;

     public static $theme_options_name = 'Salient';


     private function __construct() {

       if( is_admin() ) {

         $theme = wp_get_theme();

         if( $theme->exists() ) {
           self::$theme_options_name = sanitize_html_class( $theme->get( 'Name' ) );
         }

       }

       $this->set_content_locations();
       $this->actions();
       $this->filters();

     }

     /**
      * Stores the WP uploads dir and
      * destination for menu css file.
      *
      * @since 1.8
      */
     public function set_content_locations() {

       $upload_dir = wp_upload_dir();

       self::$upload_dir = trailingslashit( $upload_dir['basedir'] ) . 'salient/';
       self::$upload_url = trailingslashit( $upload_dir['baseurl'] ) . 'salient/';

     }


     /**
      * Adds WP actions.
      *
      * @since 1.8
      */
     public function actions() {

       add_action( 'init', array( $this, 'version_compare' ) );
       add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );

       // Menu CSS generation.
       //// When updating featured images.
       add_action( 'save_post', array( $this, 'write_css' ) );
       add_action( 'edited_category', array( $this, 'write_css' ) );
       add_action( 'edit_product_cat', array( $this, 'write_css' ) );

       //// Saving theme options.
       add_action( 'redux/options/salient_redux/saved', array( $this, 'write_css' ) );

       //// General transient trigger.
       add_action( 'admin_init', array( $this, 'check_transient' ) );


     }

     public static function check_transient() {

       if( false !== get_transient('salient_menu_css_regenerate') ) {
         self::write_css();
         delete_transient('salient_menu_css_regenerate');

       }


     }

     /**
      * Adds WP filters.
      *
      * @since 1.8
      */
     public function filters() {

       add_filter('nav_menu_item_title',  array( $this, 'menu_markup' ) , 9, 4 );

     }


     /**
      * Adds markup needed for extended menu items &
      * adds widget areas to menu items
      *
      * @since 1.8
      */
      public static function menu_markup( $title, $item, $args, $depth ) {

        $menu_item_options = maybe_unserialize( get_post_meta( $item->ID, 'nectar_menu_options', true ) );

        // Needed for widget append.
        //$args->before = '';
        //$args->after = '';

        // Menu Item Settings.
        if( $depth > 0 ) {

          // Has options saved.
          if( !empty($menu_item_options) ) {

            // See if the menu item will be an extended item.
            if( isset($menu_item_options['menu_item_link_bg_type']) &&
            'none' !== $menu_item_options['menu_item_link_bg_type'] ) {

              // Typography.
              $custom_type = (isset($menu_item_options['menu_item_link_typography'])) ? $menu_item_options['menu_item_link_typography'] : 'default';

              if( !defined( 'NECTAR_THEME_NAME' ) ) {
                $title = '<span class="title inherit-'.esc_attr($custom_type).'"><span class="menu-title-text">' . $title . '</span></span>';
              } else {
                $title = '<span class="title inherit-'.esc_attr($custom_type).'">' . $title . '</span>';
              }

              // Desc.
              $item_desc = (isset($item->description) && !empty($item->description)) ? '<span class="menu-item-desc">' . wp_kses_post($item->description) . '</span>' : '';

              // Style.
              $color_overlay_markup = ( isset($menu_item_options['menu_item_link_color_overlay']) && !empty($menu_item_options['menu_item_link_color_overlay']) ) ? '<div class="color-overlay"></div>' : '';
              $hover_class = ( isset($menu_item_options['menu_item_link_bg_hover']) && !empty($menu_item_options['menu_item_link_bg_hover']) ) ? ' hover-' . $menu_item_options['menu_item_link_bg_hover'] : '';
              $style_class = ( isset($menu_item_options['menu_item_link_bg_style']) && !empty($menu_item_options['menu_item_link_bg_style']) ) ? ' style-' . $menu_item_options['menu_item_link_bg_style'] : '';

              // Markup.
              $title = '<div class="nectar-ext-menu-item'.esc_attr($style_class).'"><div class="image-layer-outer'.esc_attr($hover_class).'"><div class="image-layer"></div>'.$color_overlay_markup.'</div><div class="inner-content">'.$title . $item_desc .'</div></div>' ;

            }

          }

        } // end extended item.

        // Widget Location.
        /*
        if( $depth == 1 && isset($item->menu_item_parent) && isset($item->ID) ) {

          $parent_menu_item_options = maybe_unserialize( get_post_meta( $item->menu_item_parent, 'nectar_menu_options', true ) );

          // Parent is using megamenu.
          if( isset($parent_menu_item_options ['enable_mega_menu']) && 'on' === $parent_menu_item_options ['enable_mega_menu'] ) {


            // Has options saved.
            if( !empty($menu_item_options) ) {

              // Remove title.
              if( isset($menu_item_options['disable_mega_menu_title']) && 'on' === $menu_item_options['disable_mega_menu_title'] ) {
                $title = '<span class="remove-menu-item-title"></span>' . $title;
              }

              // Widget area set.
              if( isset($menu_item_options['menu_item_widget_area']) && !empty($menu_item_options['menu_item_widget_area']) &&
              'none' !== $menu_item_options['menu_item_widget_area'] && isset($args->theme_location) ) {

                if( 'top_nav' === $args->theme_location ||
                'top_nav_pull_left' === $args->theme_location ||
                'top_nav_pull_right' === $args->theme_location ||
                'secondary_nav' === $args->theme_location	) {

                  // Query for widget location.
                  ob_start();
                  dynamic_sidebar( sanitize_text_field($menu_item_options['menu_item_widget_area']) );
                  $sidebar = ob_get_contents();
                  ob_end_clean();

                  $widget_margin = 'default';
                  if( isset($menu_item_options['menu_item_widget_area_marign']) && !empty($menu_item_options['menu_item_widget_area_marign']) ) {
                    $widget_margin = $menu_item_options['menu_item_widget_area_marign'];
                  }

                  $args->after = '<div class="widget-area-active" data-margin="'.esc_attr($widget_margin).'">' . $sidebar . '</div>';

                }
              }


            }

          } // Parent is using megamenu.

        } // Direct children only.
        */

        return $title;

      }


    /**
     * Generates the selectors for a menu item based
     * on theme options.
     *
     * @since 1.8
     */
    public static function menu_item_css_selector($nectar_options, $rule) {

      $new_rule = '#header-outer nav ' . $rule;

      if( isset($nectar_options['header-slide-out-widget-area-image-display']) &&
          'default' === $nectar_options['header-slide-out-widget-area-image-display'] ) {

        $mobile_menu_selector = ( isset($nectar_options['header-slide-out-widget-area-style']) && 'simple' === $nectar_options['header-slide-out-widget-area-style'] ) ? '#mobile-menu' : '#slide-out-widget-area';

        $new_rule .= ', ' . $mobile_menu_selector . ' ' . $rule;

      }

      return $new_rule;

    }

    /**
     * Base styles
     *
     * @since 1.8
     */
     public static function menu_base_css() {

       // Structure.
       $css = '
       #header-outer .nectar-ext-menu-item .image-layer-outer,
       #header-outer .nectar-ext-menu-item .image-layer,
       #header-outer .nectar-ext-menu-item .color-overlay,
       #slide-out-widget-area .nectar-ext-menu-item .image-layer-outer,
       #slide-out-widget-area .nectar-ext-menu-item .color-overlay,
       #slide-out-widget-area .nectar-ext-menu-item .image-layer {
       	position: absolute;
       	top: 0;
       	left: 0;
       	width: 100%;
       	height: 100%;
       	overflow: hidden;
       }

       .nectar-ext-menu-item .inner-content {
       	position: relative;
       	z-index: 10;
        width: 100%;
       }

       .nectar-ext-menu-item .image-layer {
       	background-size: cover;
       	background-position: center;
        transition: opacity 0.25s ease 0.1s;
       }
       #header-outer nav .nectar-ext-menu-item .image-layer:not(.loaded) {
         background-image: none!important;
       }
       #header-outer nav .nectar-ext-menu-item .image-layer {
         opacity: 0;
       }
       #header-outer nav .nectar-ext-menu-item .image-layer.loaded {
         opacity: 1;
       }

       .nectar-ext-menu-item span[class*="inherit-h"] + .menu-item-desc {
       	margin-top: 0.4rem;
       }

       #mobile-menu .nectar-ext-menu-item .title,
       #slide-out-widget-area .nectar-ext-menu-item .title,
       .nectar-ext-menu-item .menu-title-text,
       .nectar-ext-menu-item .menu-item-desc {
       	position: relative;
       }

       .nectar-ext-menu-item .menu-item-desc {
       	display: block;
        line-height: 1.4em;
       }

       body #slide-out-widget-area .nectar-ext-menu-item .menu-item-desc {
       	line-height: 1.4em;
       }

       #mobile-menu .nectar-ext-menu-item .title,
       #slide-out-widget-area .nectar-ext-menu-item:not(.style-img-above-text) .title,
       .nectar-ext-menu-item:not(.style-img-above-text) .menu-title-text,
       .nectar-ext-menu-item:not(.style-img-above-text) .menu-item-desc,
       .nectar-ext-menu-item:not(.style-img-above-text) i:before,
       .nectar-ext-menu-item:not(.style-img-above-text) .svg-icon {
       	color: #fff;
       }

       #mobile-menu .nectar-ext-menu-item.style-img-above-text .title {
         color: inherit;
       }

       .sf-menu li ul li a .nectar-ext-menu-item .menu-title-text:after {
         display: none;
       }

       .menu-item .widget-area-active[data-margin="default"] > div:not(:last-child) {
       	margin-bottom: 20px;
       }
       ';

       // Hover styles.
       $css .= '
       .nectar-ext-menu-item .color-overlay {
         transition: opacity 0.5s cubic-bezier(.15,.75,.5,1);
       }

       .nectar-ext-menu-item:hover .hover-zoom-in-slow .image-layer {
         transform: scale(1.15);
         transition: transform 4s cubic-bezier(0.1,0.2,.7,1);
       }

       .nectar-ext-menu-item:hover .hover-zoom-in-slow .color-overlay{
         transition: opacity 1.5s cubic-bezier(.15,.75,.5,1);
       }

       .nectar-ext-menu-item .hover-zoom-in-slow .image-layer {
         transition: transform 0.5s cubic-bezier(.15,.75,.5,1);
       }

       .nectar-ext-menu-item .hover-zoom-in-slow .color-overlay {
         transition: opacity 0.5s cubic-bezier(.15,.75,.5,1);
       }

       .nectar-ext-menu-item:hover .hover-zoom-in .image-layer {
         transform: scale(1.12);
       }

       .nectar-ext-menu-item .hover-zoom-in .image-layer {
         transition: transform 0.5s cubic-bezier(.15,.75,.5,1);
       }
       .nectar-ext-menu-item {
          display: flex;
          text-align: left;
        }
       ';

       if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
         $nectar_options = get_nectar_theme_options();
       } else {
         $nectar_options = array('header-slide-out-widget-area-image-display' => 'default');
       }

       if( isset($nectar_options['header-slide-out-widget-area-image-display']) &&
          'remove_images' === $nectar_options['header-slide-out-widget-area-image-display'] ) {
         $css .= '#slide-out-widget-area .nectar-ext-menu-item .title,
         #slide-out-widget-area .nectar-ext-menu-item .menu-item-desc,
         #slide-out-widget-area .nectar-ext-menu-item .menu-title-text,
         #mobile-menu .nectar-ext-menu-item .title,
         #mobile-menu .nectar-ext-menu-item .menu-item-desc,
         #mobile-menu .nectar-ext-menu-item .menu-title-text {
           color: inherit!important;
         }
         #slide-out-widget-area .nectar-ext-menu-item,
         #mobile-menu .nectar-ext-menu-item {
            display: block;
          }
         #slide-out-widget-area.fullscreen-alt .nectar-ext-menu-item,
         #slide-out-widget-area.fullscreen .nectar-ext-menu-item {
            text-align: center;
         }';
       } else {
        $css .= '
         .rtl .nectar-ext-menu-item {
           text-align: right;
         }';
       }


       // Styles.
       //// Image above text.
       $css .= '
       #header-outer .nectar-ext-menu-item.style-img-above-text .image-layer-outer,
       #slide-out-widget-area .nectar-ext-menu-item.style-img-above-text .image-layer-outer {
         position: relative;
       }
       #header-outer .nectar-ext-menu-item.style-img-above-text,
       #slide-out-widget-area .nectar-ext-menu-item.style-img-above-text {
         flex-direction: column;
       }
       ';

       return $css;

     }


     /**
      * Creates the dyanmic styles for each
      * menu location passed in.
      *
      * @since 1.8
      */
     public static function menu_dynamic_css($menu_object) {

       if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
         $nectar_options = get_nectar_theme_options();
       } else {
         $nectar_options = array(
           'accent-color' => '#000',
           'extra-color-1' => '#000',
           'extra-color-gradient' => '#000',
           'header-slide-out-widget-area-style' => 'slide-out-from-right',
           'header-dropdown-hover-effect' => 'color_change',
           'header_format' => 'default',
           'header-hover-effect' => 'animated_underline',
           'header-slide-out-widget-area-image-display' => 'default',
           'use-logo' => 'false',
           'mobile-logo-height' => '28'
         );
       }

  		 $menu_items = wp_get_nav_menu_items($menu_object);

  		 $menu_item_css = '';

       // No menu itmes found.
       if( false === $menu_items ) {
         return $menu_item_css;
       }

  		 foreach( $menu_items as $item ) {

         if( !isset($item->ID) ) {
           continue;
         }

         $menu_item_options = maybe_unserialize( get_post_meta( $item->ID, 'nectar_menu_options', true ) );

         // Menu item has nectar options saved.
         if( $menu_item_options && !empty($menu_item_options) ) {


         // Icon Sizing.
         if( isset($menu_item_options['menu_item_icon_size']) &&
             !empty($menu_item_options['menu_item_icon_size']) ) {

             $menu_item_css .= '#header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon,
             #slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon {
               font-size: '.intval($menu_item_options['menu_item_icon_size']).'px;
               line-height: 1;
             }
             #header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon.svg-icon svg,
             #slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon.svg-icon svg{
              height: '.intval($menu_item_options['menu_item_icon_size']).'px;
              width: '.intval($menu_item_options['menu_item_icon_size']).'px;
            }';

             $menu_item_css .= '#header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon-img,
             #header-outer #header-secondary-outer li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon-img,
             #slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon-img {
               width: '.intval($menu_item_options['menu_item_icon_size']).'px;
             }';

           }

           // Icon Border Radius.
           if( isset($menu_item_options['menu_item_icon_custom_border_radius']) &&
               !empty($menu_item_options['menu_item_icon_custom_border_radius']) ) {
                 $menu_item_css .= 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon-img {
                   border-radius: '.intval($menu_item_options['menu_item_icon_custom_border_radius']).'px;
                 }';
           }


           // Coloring.
           //// Label Badge Coloring.
           $label_badge_color = ( isset($menu_item_options['menu_item_link_coloring_custom_label']) && !empty($menu_item_options['menu_item_link_coloring_custom_label']) ) ? $menu_item_options['menu_item_link_coloring_custom_label'] : false;
           if( $label_badge_color &&
                isset($menu_item_options['menu_item_link_text_color_type']) &&
               'custom' === $menu_item_options['menu_item_link_text_color_type'] ) {

               $menu_item_css .= '
               #header-outer li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-label {
                 color: '.esc_attr($label_badge_color) .';
               }
               #header-outer li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-label:before {
                 background-color: '.esc_attr($label_badge_color) .';
               }
               ';

            }

           //// Parent Only
           if( !$item->menu_item_parent ) {

              $menu_item_color_parent_type = 'auto';
              if( isset($menu_item_options['menu_item_link_text_color_type']) &&
                  'custom' === $menu_item_options['menu_item_link_text_color_type'] ) {
                  $menu_item_color_parent_type = 'custom';
              }

              $p_text_color = false;

              if( 'custom' === $menu_item_color_parent_type ) {

                $p_text_color = ( isset($menu_item_options['menu_item_link_coloring_custom_text_p']) && !empty($menu_item_options['menu_item_link_coloring_custom_text_p']) ) ? $menu_item_options['menu_item_link_coloring_custom_text_p'] : false;
                $p_text_hover_color = ( isset($menu_item_options['menu_item_link_coloring_custom_text_h_p']) && !empty($menu_item_options['menu_item_link_coloring_custom_text_h_p']) ) ? $menu_item_options['menu_item_link_coloring_custom_text_h_p'] : false;

                if( $p_text_color ) {
                  $menu_item_css .= '
                  #header-outer:not(.transparent) li.menu-item-'.esc_attr($item->ID) .' > a > .menu-title-text {
                    color: '.esc_attr($p_text_color) .';
                    transition: color 0.25s ease;
                  }
                  
                  #header-outer:not(.transparent) .menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style-button-border"] > a,
                  #header-outer .menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style"]:not([class*="menu-item-btn-style-button-border"]) > a,
                  #header-outer #top .sf-menu .menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style"]:not([class*="menu-item-btn-style-button-border"]) > a,
                  #header-outer.transparent nav > ul.sf-menu .menu-item.menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style"]:not([class*="menu-item-btn-style-button-border"]) > a,
                  #header-outer.transparent #top nav > ul.sf-menu .menu-item.menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style"]:not([class*="menu-item-btn-style-button-border"]) > a,
                  #header-outer #top nav .sf-menu > .menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style"]:not([class*="menu-item-btn-style-button-border"]).sfHover:not(#social-in-menu) > a {
                    color: '.esc_attr($p_text_color) .'!important;
                  }';

                }

                if( $p_text_hover_color ) {

                  if( isset($nectar_options['header-hover-effect']) &&
                      'animated_underline' === $nectar_options['header-hover-effect'] ) {

                        $menu_item_css .= '
                        #header-outer[data-lhe="animated_underline"]:not(.transparent) #top nav > ul > li.menu-item-'.esc_attr($item->ID) .' > a > .menu-title-text:after {
                          border-color: '.esc_attr($p_text_hover_color) .';
                        }';

                  }

                  $menu_item_css .= '
                  #header-outer:not(.transparent) li.menu-item-'.esc_attr($item->ID) .' > a:hover > .menu-title-text,
                  body #header-outer[data-has-menu="true"]:not(.transparent) #top li.menu-item-'.esc_attr($item->ID) .'[class*="current"] > a  > i.nectar-menu-icon,
                  #header-outer:not(.transparent) li.menu-item-'.esc_attr($item->ID) .'[class*="current"] > a > .menu-title-text {
                    color: '.esc_attr($p_text_hover_color) .'!important;
                  }
                  
                  #header-outer .menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style-button"] > a:hover,
                  #header-outer #top nav .sf-menu li.menu-item.menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style-button"] > a:hover,
                  #header-outer .menu-item-'.esc_attr($item->ID) .'[class*="current"][class*="menu-item-btn-style-button"] > a,
                  #header-outer #top nav .sf-menu li.menu-item.menu-item-'.esc_attr($item->ID) .'[class*="current"][class*="menu-item-btn-style-button"] > a {
                    color: '.esc_attr($p_text_hover_color) .'!important;
                  }';

                }

              }

              // Megamenu padding.
              // Mega Megu Col Padding.
              if( isset($menu_item_options['mega_menu_padding']) &&
                  !empty($menu_item_options['mega_menu_padding']) &&
                  in_array($menu_item_options['mega_menu_padding'], array('5px','10px','15px','20px','25px')) ) {

                    $menu_item_css .= '#header-outer nav >ul >.megamenu.nectar-megamenu-menu-item.menu-item-'.esc_attr($item->ID) .' >.sub-menu {
                     padding: '.esc_attr($menu_item_options['mega_menu_padding']).';
                    }';
              }

              // Button Styling.
              if( isset($menu_item_options['menu_item_link_link_style']) && 'default' !== $menu_item_options['menu_item_link_link_style']) {

                $mobile_logo_height	= (!empty($nectar_options['use-logo']) && !empty($nectar_options['mobile-logo-height'])) ? intval($nectar_options['mobile-logo-height']) : 24;
                $mobile_padding_mod = ( $mobile_logo_height < 38 ) ? 10 : 0;

                $underscore_pos = strrpos($menu_item_options['menu_item_link_link_style'], "_");

                $button_type = (strrpos($menu_item_options['menu_item_link_link_style'], "border") > 0) ? 'bordered' : 'regular';
                $button_color_var = substr($menu_item_options['menu_item_link_link_style'], $underscore_pos+1);
                $button_gradient = false;

                $button_coloring = '#000';
                if( in_array($button_color_var, array('accent-color','extra-color-1','extra-color-gradient')) && isset($nectar_options[$button_color_var]) ) {

                  $button_coloring = $nectar_options[$button_color_var];

                  // Gradient.
                  if( is_array($button_coloring) && isset($button_coloring['to']) ) {

                    if( in_array($menu_item_options['menu_item_link_link_style'], array('button-animated_extra-color-gradient','button-border-animated_extra-color-gradient','button-border-white-animated_extra-color-gradient')) ) {
                      $button_gradient = true;
                      $button_coloring = 'linear-gradient(90deg, ' . $button_coloring['to'] . ', '. $button_coloring['from'] . ', '.$button_coloring['to'] .')';
                    } else {
                      $button_coloring = 'linear-gradient(90deg, ' . $button_coloring['to'] . ', '. $button_coloring['from'] . ')';
                    }

 
                  }

                }
               
                // Button Core.
                $menu_item_css .= '
                @media only screen and (max-width: 999px) {
                  body #header-outer #logo {
                  position: relative;
                   margin: '.esc_attr($mobile_padding_mod).'px 0;
                  }
            
                  body #header-space {
                    height: '. (intval($mobile_logo_height) + 24 + ($mobile_padding_mod*2)) .'px;
                  }

                  body[data-button-style^="rounded"] #header-outer .menu-item-'.esc_attr($item->ID) .' > a {
                    border-left-width: 15px;
                    border-right-width: 15px;
                  }
                  body[data-button-style^="rounded"] #header-outer .menu-item-'.esc_attr($item->ID) .' > a:before,
                  body[data-button-style^="rounded"] #header-outer .menu-item-'.esc_attr($item->ID) .' > a:after {
                    left: -15px;
                    width: calc(100% + 30px);
                  }
                }

                @media only screen and (min-width: 1000px) {
                  body #header-outer .menu-item-'.esc_attr($item->ID) .' > a {
                    border-left-width: 24px;
                    border-right-width: 24px;
                  }
                  body #header-outer #header-secondary-outer .menu-item-'.esc_attr($item->ID) .' > a {
                    border-left: 12px solid transparent;
                    border-right: 12px solid transparent;
                  }
               
                  body #header-outer .menu-item-'.esc_attr($item->ID) .' > a:before,
                  body #header-outer .menu-item-'.esc_attr($item->ID) .' > a:after {
                    left: -24px;
                    width: calc(100% + 48px);
                  }

                  #header-outer #header-secondary-outer .menu-item-'.esc_attr($item->ID) .' > a:before,
                  #header-outer #header-secondary-outer .menu-item-'.esc_attr($item->ID) .' > a:after {
                    left: -12px;
                    width: calc(100% + 24px);
                  }
                }

                #header-outer .menu-item-'.esc_attr($item->ID) .' > a {
                  border: 12px solid transparent;
                  opacity: 1!important;
                }

               
 
                #header-outer #header-secondary-outer .menu-item-'.esc_attr($item->ID) .' > a {
                  border-top: 0;
                  border-bottom: 0;
                }

                #header-outer #top li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon {
                  transition: none;
                }
                
                body #header-outer[data-has-menu][data-format] header#top nav ul.sf-menu li.menu-item.menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style"] > a *:not(.char),
                body #header-outer[data-has-menu][data-format] header#top nav ul.sf-menu li.menu-item.menu-item-'.esc_attr($item->ID) .'[class*="menu-item-btn-style"] > a:hover *:not(.char) {
                  color: inherit!important;
                  transition: none;
                  opacity: 1;
                }';

                if( !$p_text_color ) {

                  if( 'regular' === $button_type ) {
                    $menu_item_css .= '
                    #header-outer .menu-item-'.esc_attr($item->ID) .' > a,
                    #header-outer #top nav .menu-item-'.esc_attr($item->ID) .' > a,
                    #header-outer.transparent nav > ul.sf-menu .menu-item.menu-item-'.esc_attr($item->ID) .' > a,
                    #header-outer.transparent #top nav > ul.sf-menu .menu-item.menu-item-'.esc_attr($item->ID) .' > a {
                      color: #fff!important;
                    }';
                  }
                  else {
                    $menu_item_css .= '
                    #header-outer .menu-item-'.esc_attr($item->ID) .' > a:hover,
                    #header-outer #top nav .sf-menu li.menu-item.menu-item-'.esc_attr($item->ID) .' > a:hover,
                    #header-outer .menu-item-'.esc_attr($item->ID) .'[class*="current"] > a,
                    #header-outer #top nav .sf-menu li.menu-item.menu-item-'.esc_attr($item->ID) .'[class*="current"] > a {
                      color: #fff!important;
                    }';
                  }
                

                  $menu_item_css .= '
                    #header-outer[data-has-menu="true"].transparent #top nav ul.sf-menu li.menu-item-'.esc_attr($item->ID) .' > a:hover .nectar-menu-icon {
                      color: #fff!important;
                    }';
                }

                $menu_item_css .= '
                #header-outer .menu-item-'.esc_attr($item->ID) .' > a:before,
                #header-outer .menu-item-'.esc_attr($item->ID) .' > a:after {
                  position: absolute;
                  top: 50%!important;
                  left: -12px;
                  width: calc(100% + 24px);
                  height: calc(100% + 24px);
                  content: "";
                  display: block;
                  z-index: -1;
                  transform-origin: top;
                  transform: translateY(-50%)!important;
                  transition: opacity .45s cubic-bezier(0.25, 1, 0.33, 1), transform .45s cubic-bezier(0.25, 1, 0.33, 1), border-color .45s cubic-bezier(0.25, 1, 0.33, 1), color .45s cubic-bezier(0.25, 1, 0.33, 1), background-color .45s cubic-bezier(0.25, 1, 0.33, 1), box-shadow .45s cubic-bezier(0.25, 1, 0.33, 1);
                }

                #header-outer #header-secondary-outer .menu-item-'.esc_attr($item->ID) .' > a:after,
                #header-outer #header-secondary-outer .menu-item-'.esc_attr($item->ID) .' > a:before {
                  height: calc(100% + 12px);
                }

                #header-outer .menu-item-'.esc_attr($item->ID) .' > a:after {
                  opacity: 0;
                  transition: opacity 0.3s ease, transform 0.3s ease;
                }

                #header-outer .menu-item-'.esc_attr($item->ID) .' > a .menu-title-text:after {
                  display: none!important;
                }
               ';

               // Button styles.
               if( 'regular' === $button_type ) {

                  $menu_item_css .= '
                  #header-outer .menu-item-'.esc_attr($item->ID) .' > a {
                    color: #fff;
                  }
                  #header-outer .menu-item-'.esc_attr($item->ID) .' > a:before {
                    background: '.esc_attr($button_coloring).';
                  }
                  #header-outer .menu-item-'.esc_attr($item->ID) .' > a:hover:after,
                  #header-outer .menu-item-'.esc_attr($item->ID) .'[class*="current"] > a:after {
                    opacity: 1;
                  }';

                  if( $button_gradient ) {
                    $menu_item_css .= '
                    @keyframes nectarBtnGradientScroll {
                      0% {
                        background-position: 0% 50%;
                      }
                      100% {
                        background-position: 1300% 50%;
                      }
                    }
                    
                    #header-outer .menu-item-'.esc_attr($item->ID) .' > a:before {
                      background-size: 1300%;
                      animation: nectarBtnGradientScroll 40s linear infinite;
                    }
                    ';
                  }
                  
               } else if( 'bordered' === $button_type ) {

                $menu_item_css .= '
                  #header-outer .menu-item-'.esc_attr($item->ID) .' > a:before {
                    border: 1px solid;
                    opacity: 0.25;
                    box-sizing: border-box;
                  }
                  #header-outer .menu-item-'.esc_attr($item->ID) .' > a:after {
                    background: '.esc_attr($button_coloring).';
                  }
                  #header-outer .menu-item-'.esc_attr($item->ID) .' > a:hover,
                  #header-outer .menu-item-'.esc_attr($item->ID) .'[class*="current"] > a {
                    color: #fff;
                  }
                  #header-outer .menu-item-'.esc_attr($item->ID) .' > a:hover:after,
                  #header-outer .menu-item-'.esc_attr($item->ID) .'[class*="current"] > a:after {
                    opacity: 1;
                  }';

                  // White BG
                  if( 'button-border-white-animated_extra-color-gradient' === $menu_item_options['menu_item_link_link_style'] ) {
                    $menu_item_css .= '
                    #header-outer #top nav .sf-menu .menu-item.menu-item-'.esc_attr($item->ID) .':not([class*="current"]) > a:not(:hover),
                    #header-outer .sf-menu .menu-item.menu-item-'.esc_attr($item->ID) .':not([class*="current"]) > a:not(:hover) {
                      color: #000!important;
                    }
                    #header-outer .sf-menu .menu-item-'.esc_attr($item->ID) .':not([class*="current"]) > a:before {
                      background-color: #fff;
                      opacity: 1;
                      border-color: rgba(0,0,0,0.1);
                    }';
                  }

                  if( $button_gradient ) {
                    $menu_item_css .= '
                    @keyframes nectarBtnGradientScroll {
                      0% {
                        background-position: 0% 50%;
                      }
                      100% {
                        background-position: 1300% 50%;
                      }
                    }
                    
                    #header-outer .menu-item-'.esc_attr($item->ID) .' > a:after {
                      background-size: 1300%;
                      animation: nectarBtnGradientScroll 30s linear infinite;
                    }';
                  }

               }
               
              }

           }

    			 ////////// Dropdown only items.
    			 if( $item->menu_item_parent ) {

               $mobile_menu_style = ( isset($nectar_options['header-slide-out-widget-area-style']) ) ? $nectar_options['header-slide-out-widget-area-style'] : '#slide-out-widget-area';
    					 $mobile_menu_id    = ( 'simple' === $mobile_menu_style ) ? '#mobile-menu' : '#slide-out-widget-area';

                 // Mega Megu Col Width.
                 if( isset($menu_item_options['menu_item_column_width']) &&
                     !empty($menu_item_options['menu_item_column_width']) ) {

                       $menu_item_css .= '#header-outer .sf-menu > .nectar-megamenu-menu-item > ul.sub-menu > li.menu-item-'.esc_attr($item->ID) .'.megamenu-column-width-'.esc_attr(intval($menu_item_options['menu_item_column_width'])).' {
                        width: '.esc_attr(intval($menu_item_options['menu_item_column_width'])).'%;
                        flex: none;
                       }';
                 }

                 // Mega Megu Col Padding.
                 if( isset($menu_item_options['menu_item_column_padding']) &&
                     !empty($menu_item_options['menu_item_column_padding']) &&
                     in_array($menu_item_options['menu_item_column_padding'], array('15px','20px','25px','30px','35px','40px')) ) {

                       $menu_item_css .= '#header-outer nav >ul >.megamenu.nectar-megamenu-menu-item >.sub-menu > li.menu-item-'.esc_attr($item->ID) .'.megamenu-column-padding-'.esc_attr($menu_item_options['menu_item_column_padding']).' {
                        padding: '.esc_attr($menu_item_options['menu_item_column_padding']).';
                       }';
                 }

                 // Mega Megu Col BG Color.
                 if( isset($menu_item_options['menu_item_column_bg_color']) &&
                     !empty($menu_item_options['menu_item_column_bg_color']) ) {

                       $menu_item_css .= '#header-outer nav >ul >.megamenu.nectar-megamenu-menu-item >.sub-menu > li.menu-item-'.esc_attr($item->ID) .' {
                        background-color: '.esc_attr($menu_item_options['menu_item_column_bg_color']).';
                       }';
                 }

                 // Icon Alignment.
                 $icon_margin_target = 'right';

                 if( isset($menu_item_options['menu_item_icon_position']) &&
                     !empty($menu_item_options['menu_item_icon_position']) &&
                     'above' === $menu_item_options['menu_item_icon_position'] ) {

                    $icon_margin_target = 'bottom';

                     $menu_item_css .= '#header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon,
                     #header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon-img {
                       top: 0;
                       display: block;
                       margin: 0 0 5px 0;
                       text-align: inherit;
                     }
                     #header-outer header li li.menu-item-'.esc_attr($item->ID) .' > a {
                       display: inline-block;
                     }';

                     // When the item is in a dropdown, we need to handle the alignment.
                     if( isset($menu_item_options['menu_item_link_content_alignment']) &&
                        !empty($menu_item_options['menu_item_link_content_alignment']) ) {

                         $alignment = $menu_item_options['menu_item_link_content_alignment'];

                         if( strpos($alignment, '-center') !== false ) {
                           $menu_item_css .= '#header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .nectar-menu-icon-img {
                             margin: 0 auto 5px auto;
                           }';
                         }
                         else if( strpos($alignment, '-right') !== false ) {
                           $menu_item_css .= '#header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .nectar-menu-icon-img {
                             margin-left: auto;
                           }';
                         }

                       }
                 }

                 // Icon Spacing.
                 if( isset($menu_item_options['menu_item_icon_spacing']) &&
                     !empty($menu_item_options['menu_item_icon_spacing']) ) {

                   $menu_item_css .= '#header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon,
                   #header-outer header li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon-img,
                   #header-secondary-outer li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon,
                   #header-secondary-outer li.menu-item-'.esc_attr($item->ID) .' > a .nectar-menu-icon-img {
                     margin-'.esc_attr($icon_margin_target).': '.intval($menu_item_options['menu_item_icon_spacing']).'px;
                   }';


                 }

                 // Menu Item Margin.
                 if( isset($menu_item_options['menu_item_link_margin']) ) {

                     $marign_top = ( isset($menu_item_options['menu_item_link_margin']['top']) && strlen($menu_item_options['menu_item_link_margin']['top']) > 0 ) ? $menu_item_options['menu_item_link_margin']['top'] : false;
                     $marign_bottom = ( isset($menu_item_options['menu_item_link_margin']['bottom']) && strlen($menu_item_options['menu_item_link_margin']['bottom']) > 0) ? $menu_item_options['menu_item_link_margin']['bottom'] : false;

                     if( false !== $marign_top || false !== $marign_bottom ) {

                           $menu_item_css .= '#header-outer nav li.menu-item-'.esc_attr($item->ID) .' > a {';

                             if( false !== $marign_top ) {
                               $menu_item_css .= 'margin-top: '.intval($marign_top) .'px;';
                             }
                             if( false !== $marign_bottom ) {
                               $menu_item_css .= 'margin-bottom: '.intval($marign_bottom) .'px;';
                             }

                           $menu_item_css .= '}';

                     }

                 }

    	 					// Menu Item Custom Coloring.
    						$menu_item_color_type = 'auto';
    						if( isset($menu_item_options['menu_item_link_text_color_type']) &&
     						 	  'custom' === $menu_item_options['menu_item_link_text_color_type'] ) {
    								$menu_item_color_type = 'custom';
    						}

    	 					if( 'custom' === $menu_item_color_type ) {

    	 							$text_color = ( isset($menu_item_options['menu_item_link_coloring_custom_text']) && !empty($menu_item_options['menu_item_link_coloring_custom_text']) ) ? $menu_item_options['menu_item_link_coloring_custom_text'] : false;
    	 							$text_hover_color = ( isset($menu_item_options['menu_item_link_coloring_custom_text_h']) && !empty($menu_item_options['menu_item_link_coloring_custom_text_h']) ) ? $menu_item_options['menu_item_link_coloring_custom_text_h'] : false;
    	 							$desc_color = ( isset($menu_item_options['menu_item_link_coloring_custom_desc']) && !empty($menu_item_options['menu_item_link_coloring_custom_desc']) ) ? $menu_item_options['menu_item_link_coloring_custom_desc'] : false;

    	 							if( $text_color ) {
    	 								$menu_item_css .= '
                      #header-outer li.menu-item-'.esc_attr($item->ID) .' > a .menu-title-text,
    	 								li.menu-item-'.esc_attr($item->ID) .' > a i:before,
                      li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item:not(.style-img-above-text) .menu-title-text,
                      li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item i:before,
                      li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .svg-icon {
    	 									color: '.esc_attr($text_color) .';
    	 								}';

                      // mobile.
                      if( '#mobile-menu' === $mobile_menu_id ) {
                        $menu_item_css .= '#mobile-menu li.menu-item-'.esc_attr($item->ID) .' > a .title,
                         #mobile-menu li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .title {
      	 									color: '.esc_attr($text_color) .';
      	 								}';
                      } else {
                        $menu_item_css .= '#slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item:not(.style-img-above-text) .title {
      	 									color: '.esc_attr($text_color) .';
      	 								}';
                      }

    	 							}


    	 							if( $text_hover_color ) {

    	 								if( isset($nectar_options['header-dropdown-hover-effect']) &&
    	 							      'animated_underline' === $nectar_options['header-dropdown-hover-effect'] ) {

    	 									$menu_item_css .= '#header-outer li.menu-item-'.esc_attr($item->ID) .' > a .menu-title-text:after {
    	 										background-color: '.esc_attr($text_hover_color) .';
    	 									}
                        #header-outer li.menu-item-'.esc_attr($item->ID).' .nectar-ext-menu-item .menu-title-text {
                          background-image: linear-gradient(to right, '.esc_attr($text_hover_color).' 0%, '.esc_attr($text_hover_color).' 100%);
                        }';

                        // mobile.
                        if( '#mobile-menu' === $mobile_menu_id ) {
                          $menu_item_css .= '#mobile-menu li.menu-item-'.esc_attr($item->ID) .' > a:hover .title {
      	 										color: '.esc_attr($text_hover_color) .';
      	 									}';
                        } else if ( 'default' === $nectar_options['header-slide-out-widget-area-image-display'] ) {
                          $menu_item_css .= '#slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a:hover .nectar-ext-menu-item:not(.style-img-above-text) .title {
      	 										color: '.esc_attr($text_hover_color) .';
      	 									}
                          #slide-out-widget-area li.menu-item-'.esc_attr($item->ID).' .nectar-ext-menu-item:not(.style-img-above-text) .menu-title-text {
                            background-image: linear-gradient(to right, '.esc_attr($text_hover_color).' 0%, '.esc_attr($text_hover_color).' 100%);
                          }';
                        }

    	 								}
    	 								else {
    	 									$menu_item_css .= '
                        #header-outer li.menu-item-'.esc_attr($item->ID) .' > a:hover .menu-title-text,
                        li.menu-item-'.esc_attr($item->ID) .' > a:hover .nectar-ext-menu-item:not(.style-img-above-text) .menu-title-text,
    	 									#menu-item-'.esc_attr($item->ID) .' > a:hover i:before,
                        #menu-item-'.esc_attr($item->ID) .' > a:hover .svg-icon {
    	 										color: '.esc_attr($text_hover_color) .';
    	 									}';

                        // mobile.
                        if( '#mobile-menu' === $mobile_menu_id ) {
                          $menu_item_css .= '#mobile-menu li.menu-item-'.esc_attr($item->ID) .' > a:hover .title {
                            color: '.esc_attr($text_hover_color) .';
                          }';
                        } else if( 'default' === $nectar_options['header-slide-out-widget-area-image-display'] ) {
                          $menu_item_css .= '#slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a:hover .nectar-ext-menu-item:not(.style-img-above-text) .title {
                            color: '.esc_attr($text_hover_color) .';
                          }';
                        }

    	 								}

    	 							}


    	 							if( $desc_color ) {
    	 								$menu_item_css .= '#header-outer li.menu-item-'.esc_attr($item->ID) .' > a .menu-item-desc,
                      li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item:not(.style-img-above-text) .menu-item-desc {
    	 									color: '.esc_attr($desc_color) .';
    	 								}
                      body #header-outer #top nav .sf-menu ul li.menu-item-'.esc_attr($item->ID) .' > a .item_desc,
                      body #header-outer #top nav .sf-menu ul li.menu-item-'.esc_attr($item->ID) .':hover > a .item_desc {
                        color: '.esc_attr($desc_color) .'!important;
                      }';
    	 							}

    	 					}


    			 		 // Menu Item Image.
    					 if( isset($menu_item_options['menu_item_link_bg_type']) &&
    	 						'none' !== $menu_item_options['menu_item_link_bg_type'] ) {

    							 $image_type = $menu_item_options['menu_item_link_bg_type'];
    					 } else {
    						 // Skip this item and check the next. All settings below are only used if an image is present.
    						 continue;
    					 }


    					 //// Featured Image.
    					 $image_active = false;

    					 if( 'featured_image' === $image_type ) {

    						 // ---- Post Category Taxonomy.
    						 if( isset($item->type) &&
    						 isset($item->object) &&
    						 isset($item->url) &&
    						 !empty($item->url) &&
    						 'taxonomy' === $item->type &&
    						 'category' === $item->object ) {

    							 $category_url_array = explode('/', rtrim($item->url, '/'));
    							 if( false === $category_url_array ) {
    								 continue;
    							 }
    							 $category_url_segment = array_slice($category_url_array, -1)[0];
    							 $category_term = get_term_by('slug', $category_url_segment, 'category');

    							 // Category found.
    							 if( $category_term && isset($category_term->term_id) ) {

    								 $term_options = get_option( 'taxonomy_'.$category_term->term_id );
    								 if( false === $term_options || !isset($term_options['category_thumbnail_image']) )	{
    									 continue;
    								 }

    								 $cat_thumb_img_url = $term_options['category_thumbnail_image'];

    								 if( $cat_thumb_img_url && !empty($cat_thumb_img_url)) {

    									 // Get the image ID.
    									 $cat_image_id = attachment_url_to_postid($cat_thumb_img_url);
    									 if( $cat_image_id ) {

    										 //Get the image src.
    										 $cat_thumb_img_src = wp_get_attachment_image_src( $cat_image_id, 'large');

    										 if( isset($cat_thumb_img_src[0]) ) {
    											 $image_active = true;

    											 $menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .image-layer') . '{
    												 background-image: url("'.esc_attr($cat_thumb_img_src[0]).'");
    											 }';


    										 }

    									 }

    								 }

    							 }

    						 }

    						 // ---- Product Category Taxonomy.
    						 else if( isset($item->type) &&
    						 isset($item->object) &&
    						 isset($item->url) &&
    						 !empty($item->url) &&
    						 'taxonomy' === $item->type &&
    						 'product_cat' === $item->object) {

    							 $category_url_array = explode('/', rtrim($item->url, '/'));
    							 if( false === $category_url_array ) {
    								 continue;
    							 }

    							 $category_url_segment = array_slice($category_url_array, -1)[0];
    							 $category_term = get_term_by('slug', $category_url_segment, 'product_cat');

    							 if( $category_term && isset($category_term->term_id) ) {

    								 $product_cat_thumbnail_id = get_term_meta( $category_term->term_id, 'thumbnail_id', true );
    								 if( $product_cat_thumbnail_id ) {

    									 $product_cat_thumbnail_src = wp_get_attachment_image_src( $product_cat_thumbnail_id, 'large');
    									 if( $product_cat_thumbnail_src && isset($product_cat_thumbnail_src[0]) ) {
    										 $image_active = true;

                         $menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .image-layer') . '{
                           background-image: url("'.esc_attr($product_cat_thumbnail_src[0]).'");
                         }';

    									 }

    								 }

    							 }

    						 }

    						 // ---- Single post/project/product.
    						 else if( isset($item->url) && !empty($item->url) && function_exists('url_to_postid') ) {

    							 $post_id = url_to_postid($item->url);

    							 if($post_id) {

    								 $featured_image = get_the_post_thumbnail_url($post_id);

    								 if( $featured_image ) {

    									 $image_active = true;

                       $menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .image-layer') . '{
                         background-image: url("'.esc_attr($featured_image).'");
                       }';

    								 } // Featured image located.

    							 } // The post ID wase found.

    						 } // URL set.

    					 }

    					 //// Custom Image.
    					 else if( isset($menu_item_options['menu_item_link_bg_img_custom']) &&
    					     isset($menu_item_options['menu_item_link_bg_img_custom']['id']) &&
    					     !empty($menu_item_options['menu_item_link_bg_img_custom']['id']) ) {

    							 $bg_image_src = wp_get_attachment_image_src($menu_item_options['menu_item_link_bg_img_custom']['id'], 'large');
    			 				 if( isset($bg_image_src[0]) ) {

    								 $image_active = true;

                     $menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .image-layer') . '{
                       background-image: url("'.esc_attr($bg_image_src[0]).'");
                     }';

    							 }

    				 	 }

    					 /// If there's no image, bail out.
    					 if( false === $image_active ) {

    							if( 'auto' === $menu_item_color_type ) {
    								$menu_item_css .= 'li.menu-item-'.esc_attr($item->ID) .' > a .menu-title-text,
    								'.$mobile_menu_id.' li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .title,
    								li.menu-item-'.esc_attr($item->ID) .' > a i:before,
    								li.menu-item-'.esc_attr($item->ID) .' > a .menu-item-desc,
                    li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .menu-title-text,
                    li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item i:before,
    								li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .menu-item-desc {
    									color: inherit;
    								}';

    							}

    						 continue;
    					 }


               /******* All items below this point are only applied when a BG is set *******/

               $image_style = (isset($menu_item_options['menu_item_link_bg_style'])) ? $menu_item_options['menu_item_link_bg_style'] : 'default';

               // Left header needs to display items block and some default padding.
               if( 'default' === $image_style && isset($nectar_options['header_format']) && 'left-header' === $nectar_options['header_format'] ) {
                 $menu_item_css .= 'body[data-header-format="left-header"] #header-outer nav ul li ul li.menu-item-'.esc_attr($item->ID) .' > a {
                   display: block;
                   padding-left: 10px;
                   padding-right: 10px;
                 }';
               }

               // Default height for img above text.
               if( 'img-above-text' === $image_style ) {
                 $menu_item_css .= ' li.menu-item-'.esc_attr($item->ID) .' > a .image-layer-outer {
                   height: 75px;
                   margin-bottom: 20px;
                 }';
               }

    					 // Mobile menu specific.
    					 $menu_item_css .= $mobile_menu_id . ' li.menu-item-'.esc_attr($item->ID) .' > a:after {
                 visibility: hidden;
               }';

    					 if( 'default' === $nectar_options['header-slide-out-widget-area-image-display'] && '#mobile-menu' === $mobile_menu_id ) {

                 // Only add padding when using BG style.
                 if( 'img-above-text' !== $image_style ) {
                   $menu_item_css .= '#header-outer #mobile-menu li.menu-item-'.esc_attr($item->ID) .' > a {
                     padding: 20px;
                   }';
                 }
                 else {
                   $menu_item_css .= '#header-outer #mobile-menu li.menu-item-'.esc_attr($item->ID) .' > a {
                     padding: 20px 0px!important;
                   }';
                 }

    					 } // end using simple ocm.

               else if( 'default' === $nectar_options['header-slide-out-widget-area-image-display'] ) {

    						 $menu_item_css .= '#slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a {
                   display: block;
                   width: 100%;
                 }';

                 // Only add padding when using BG style.
                 if( 'img-above-text' !== $image_style ) {
                   $menu_item_css .= '#slide-out-widget-area li.menu-item-'.esc_attr($item->ID) .' > a {
                     padding: 20px!important;
                   }';
                 } else {

                   // Fullscreen OCM still needs the padding.
                   if( 'fullscreen' === $mobile_menu_style || 'fullscreen-alt' === $mobile_menu_style ) {
                     $menu_item_css .= '#slide-out-widget-area.'.esc_attr($mobile_menu_style).' li.menu-item-'.esc_attr($item->ID) .' > a {
                       padding: 20px!important;
                     }';
                   }
                   else if( 'fullscreen-split' === $mobile_menu_style ) {
                     $menu_item_css .= '#slide-out-widget-area.'.esc_attr($mobile_menu_style).' li.menu-item-'.esc_attr($item->ID) .' > a {
                       padding: 20px 0!important;
                     }';
                   }

                 }

    					 } // end using regular ocm.

    					 // Menu Item Height.
    					 if( isset($menu_item_options['menu_item_link_height']) &&
    					     isset($menu_item_options['menu_item_link_height']['number']) &&
    					     !empty($menu_item_options['menu_item_link_height']['number']) ) {

                   if( 'img-above-text' === $image_style ) {

                     $menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .image-layer-outer') . '{
                       min-height: '.intval($menu_item_options['menu_item_link_height']['number']) . esc_attr($menu_item_options['menu_item_link_height']['units']) . ';
                     }';

                   }
                   else {
                     $menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item') . '{
      								 min-height: '.intval($menu_item_options['menu_item_link_height']['number']) . esc_attr($menu_item_options['menu_item_link_height']['units']) . ';
      							 }';
                   }

    				 	 }
    					 // Menu Item Padding.
    					if( isset($menu_item_options['menu_item_link_padding']) &&
    							!empty($menu_item_options['menu_item_link_padding']) &&
    						  'default' !== $menu_item_options['menu_item_link_padding'] ) {

                  // Desktop.
    							$menu_item_css .= '#header-outer nav .menu-item-'.esc_attr($item->ID) .' > a,
                  #header-outer nav #menu-item-'.esc_attr($item->ID) .' > a {
    								padding: '.intval($menu_item_options['menu_item_link_padding']) .'px!important;
    							}';

                  // Mobile.
                  if( 'img-above-text' !== $image_style &&
                      'default' === $nectar_options['header-slide-out-widget-area-image-display'] ) {

                    $mobile_only_ext_menu_item_padding = intval($menu_item_options['menu_item_link_padding']);

                    if( in_array($mobile_menu_style, array('slide-out-from-right','slide-out-from-right-hover','fullscreen-split')) &&
                        intval($menu_item_options['menu_item_link_padding']) > 30 ) {
                      $mobile_only_ext_menu_item_padding = 30;
                    }
                    $menu_item_css .= $mobile_menu_id . ' li.menu-item-'.esc_attr($item->ID) .' > a {
      								padding: '. $mobile_only_ext_menu_item_padding .'px!important;
      							}';
                  }

    					}


              // Menu Item Border Radius.
              if( isset($menu_item_options['menu_item_link_border_radius']) &&
                  !empty($menu_item_options['menu_item_link_border_radius']) &&
                  in_array($menu_item_options['menu_item_link_border_radius'], array('3px','5px','7px','10px')) ) {

                    $menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .image-layer-outer') . ' {';
                     $menu_item_css .= 'border-radius: '.esc_attr($menu_item_options['menu_item_link_border_radius']).';
                    }';
              }


    					// Content Alignment.
    					$degree = '270';
    					if( isset($menu_item_options['menu_item_link_content_alignment']) &&
    							!empty($menu_item_options['menu_item_link_content_alignment']) ) {

    							$alignment = $menu_item_options['menu_item_link_content_alignment'];
    							$menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item') . ' {';

    								if( 'top-left' === $alignment ) {
    									$menu_item_css .= 'align-items: flex-start; justify-content: flex-start;';
    									$degree = '360';
    								}
    								else if( 'top-center' === $alignment ) {
    									$menu_item_css .= 'align-items: flex-start; justify-content: center; text-align: center;';
    									$degree = '360';
    								}
    								else if( 'top-right' === $alignment ) {
    									$menu_item_css .= 'align-items: flex-start; justify-content: flex-end; text-align: right;';
    									$degree = '360';
    								}
    								else if( 'center-left' === $alignment ) {
    									$menu_item_css .= 'align-items: center; justify-content: flex-start; text-align: left;';
    									$degree = '270';
    								}
    								else if( 'center-center' === $alignment ) {
    									$menu_item_css .= 'align-items: center; justify-content: center; text-align: center;';
    									$degree = '225';
    								}
    								else if( 'center-right' === $alignment ) {
    									$menu_item_css .= 'align-items: center; justify-content: flex-end; text-align: right;';
    									$degree = '90';
    								}
    								else if( 'bottom-left' === $alignment ) {
    									$menu_item_css .= 'align-items: flex-end; justify-content: flex-start; text-align: left;';
    									$degree = '180';
    								}
    								else if( 'bottom-center' === $alignment ) {
    									$menu_item_css .= 'align-items: flex-end; justify-content: center; text-align: center;';
    									$degree = '180';
    								}
    								else if( 'bottom-right' === $alignment ) {
    									$menu_item_css .= 'align-items: flex-end; justify-content: flex-end; text-align: right;';
    									$degree = '180';
    								}

    							$menu_item_css .= '}';

                  // OCM with image above text.
                  if( 'img-above-text' === $image_style &&
                      'default' === $nectar_options['header-slide-out-widget-area-image-display']) {

                    if( 'fullscreen' === $mobile_menu_style ||
                        'fullscreen-alt' === $mobile_menu_style ) {

                      $menu_item_css .= '
                      #slide-out-widget-area.'.esc_attr($mobile_menu_style).' li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .inner-content {
                        margin: 0 auto;
                      }
                      #slide-out-widget-area.'.esc_attr($mobile_menu_style).' li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item {
                        align-items: center; justify-content: center; text-align: center;
                      }';

                    }

                    else {
                      $menu_item_css .= $mobile_menu_id.' li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item {
                        align-items: flex-start; justify-content: flex-start; text-align: left;
                      }';
                    }

                  }

    					}

    					// Color Overlay.
    					if(  isset($menu_item_options['menu_item_link_color_overlay']) &&
    							!empty($menu_item_options['menu_item_link_color_overlay']) ) {

    						if( isset($menu_item_options['menu_item_link_color_overlay_fade']) &&
                    'on' === $menu_item_options['menu_item_link_color_overlay_fade'] ) {
    							$menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .color-overlay') . '{
    									background: linear-gradient('.esc_attr($degree).'deg, transparent, '.esc_attr($menu_item_options['menu_item_link_color_overlay']).');';
    						} else {
    							$menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a .nectar-ext-menu-item .color-overlay') . '{
    									background-color: '.esc_attr($menu_item_options['menu_item_link_color_overlay']).';';
    						}

    						$default_o = '0.4';
    						if( isset($menu_item_options['menu_item_link_color_overlay_opacity']) &&
    						    isset($menu_item_options['menu_item_link_color_overlay_opacity']['default']) &&
    						    !empty($menu_item_options['menu_item_link_color_overlay_opacity']['default']) ) {
    							$default_o = str_replace('-','.',$menu_item_options['menu_item_link_color_overlay_opacity']['default']);
    						}
    						$hover_o = '0.6';
    						if( isset($menu_item_options['menu_item_link_color_overlay_opacity']) &&
    						    isset($menu_item_options['menu_item_link_color_overlay_opacity']['hover']) &&
    						    !empty($menu_item_options['menu_item_link_color_overlay_opacity']['hover'])  ) {
    								$hover_o = str_replace('-','.',$menu_item_options['menu_item_link_color_overlay_opacity']['hover']);
    						}

    						$menu_item_css .= 'opacity: '.esc_attr($default_o) .';';

    						$menu_item_css .= '}';


    						$menu_item_css .= self::menu_item_css_selector($nectar_options, 'li.menu-item-'.esc_attr($item->ID) .' > a:hover .nectar-ext-menu-item .color-overlay') .' {
    							opacity: '.esc_attr($hover_o).';
    						}';


    					}

            } // dropdown only.

  			 } // nectar menu options are set.

  		 } // menu item loop.

  		 return $menu_item_css;

     }



     /**
      * Loops through all menu locations
      * and gathers the needed CSS for each.
      *
      * @since 1.8
      */
      public static function generate_all_css() {

        // Base CSS.
        $css = self::menu_base_css();

        $locations = get_nav_menu_locations();
        $stored_locations = array();

        // Dynamic CSS.
        if( $locations && !empty($locations) ) {

          foreach ($locations as $location => $id ) {

            if( $id && !isset($stored_locations[$id]) ) {
              $css .= self::menu_dynamic_css($id);
              $stored_locations[$id] = true;
            }

          }

        }

        return self::minify_css( $css );

      }



     /**
      * Write the dynamic css
      * to an external file.
      *
      * @since 1.8
      */
     public static function write_css() {

          // Generate the styles.
       		$css = self::generate_all_css();

       		global $wp_filesystem;

       		if ( empty($wp_filesystem) ) {
       			require_once( ABSPATH . 'wp-admin/includes/file.php' );
       		}

          $upload_dir = wp_upload_dir(); // For context.

       		WP_Filesystem( false, $upload_dir['basedir'], true );

          // Create the dir.
          if( !$wp_filesystem->is_dir( self::$upload_dir ) ) {
              $wp_filesystem->mkdir( self::$upload_dir );
          }

       		// Write the file.
          $file_chmod = ( defined('FS_CHMOD_FILE') ) ? FS_CHMOD_FILE : false;

     			if( !$wp_filesystem->put_contents( self::$upload_dir . 'menu-dynamic.css', $css, $file_chmod)) {
     				// Filesystem can not write.
     				update_option('salient_menu_dynamic_css_success', 'false');
     			} else {
     				update_option('salient_menu_dynamic_css_success', 'true');
     			}

       		// Update version number for cache busting.
       		$random_number = rand( 0, 99999 );
       		update_option('salient_menu_dynamic_css_version', $random_number);

     }



     /**
      * Check if FS has access to
      * determine how to load CSS.
      *
      * @since 1.8
      */
     public static function fs_access() {

       $file_location = self::$upload_dir . 'menu-dynamic.css';

       if ( 'true' === get_option('salient_menu_dynamic_css_success') && is_file( $file_location ) ) {
         return true;
       }

       return false;
     }


     /**
      * Enqueues the dynamic CSS on the front.
      *
      * @since 1.8
      */
     public static function enqueue_css() {

       /* FS has write access, enqueue ext.
          Ext writing also need to be disabled when WPML is active,
          due to the menu ID manipulation.
       */
       if ( true === self::fs_access() && !class_exists( 'SitePress' ) ) {

           $stylesheet_url = self::$upload_url . 'menu-dynamic.css';

           $protocol = is_ssl() ? 'https://' : 'http://';

           // Handle https.
           $stylesheet_url = str_replace( array( "http://", "https://" ), $protocol, $stylesheet_url );

           // Get version num.
           $version_num = ( !get_option('salient_menu_dynamic_css_version') ) ? rand( 0, 99999 ) : get_option('salient_menu_dynamic_css_version');

           wp_enqueue_style( 'salient-wp-menu-dynamic', $stylesheet_url, '', $version_num );

       }

       // Fallback to internal css.
       else {

         $css = self::generate_all_css();

         if( !empty($css) ) {

           $css = self::minify_css($css);

           wp_register_style( 'salient-wp-menu-dynamic-fallback', false );
            wp_enqueue_style( 'salient-wp-menu-dynamic-fallback' );
            wp_add_inline_style( 'salient-wp-menu-dynamic-fallback', $css );

         }

       }


     }



     /**
      * Quick minify for CSS
      *
      * @since 1.8
      */
     public static function minify_css( $css ) {

       	$css = preg_replace( '/\s+/', ' ', $css );

       	$css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );

       	$css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );

       	$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

       	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

       	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

       	return trim( $css );

     }


     /**
      * If the salient core plugin has
      * been updated, rewrite the CSS.
      *
      * @since 1.8
      */
     public static function version_compare() {

       if( SALIENT_CORE_VERSION !== get_option('salient_core_stored_version') ) {
         self::write_css();
         update_option('salient_core_stored_version', SALIENT_CORE_VERSION);
       }

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


   }

   // Init class.
   Nectar_WP_Menu_Style_Manager::get_instance();

}
