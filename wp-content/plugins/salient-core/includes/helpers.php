<?php
/**
 * Salient Core Helpers
 *
 * @version 1.0
 */
 

  /**
  * Cleans class names
  *
  * @since 1.8
  */
  if(!function_exists('nectar_clean_classnames')) {
    function nectar_clean_classnames($str) {
      return esc_attr(trim(str_replace('  ', ' ',$str)));
    }
  }

  /**
  * Handles unit sizing for css prop
  *
  * @since 1.8
  */
  if(!function_exists('nectar_css_sizing_units')) {
    function nectar_css_sizing_units($str) {
      if( strpos($str,'vw') !== false ||
        strpos($str,'vh') !== false ||
        strpos($str,'%') !== false ||
        strpos($str,'em') !== false ) {
        return esc_attr($str);
      } 
      else {
        return intval($str) . 'px';
      }
    }
  }


  /**
  * Generates lazy loading markup
  *
  * @since 1.9
  */
  if(!function_exists('nectar_lazy_loaded_image_markup')) {
    function nectar_lazy_loaded_image_markup($id, $image_size) {
      
      // src.
      $img_src = wp_get_attachment_image_src($id, $image_size);
      if( isset($img_src[0]) ) {
        $img_src = $img_src[0];
      }

      // srcset.
      $img_srcset = '';
      $sizes = '';
      if (function_exists('wp_get_attachment_image_srcset')) {
        $img_srcset = wp_get_attachment_image_srcset($id, $image_size);
        $sizes = wp_get_attachment_image_sizes( $id, $image_size );
      }
      
      // alt.
      $alt_tag = get_post_meta( $id, '_wp_attachment_image_alt', true );
      
      // dimensions.
      $img_meta = wp_get_attachment_metadata($id);

      $width  = ( !empty($img_meta['width']) ) ? $img_meta['width'] : '100';
      $height = ( !empty($img_meta['height']) ) ? $img_meta['height'] : '100';
      
      $placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($width).'%20'.esc_attr($height)."'%2F%3E";

      return '<img class="nectar-lazy skip-lazy" src="'.$placeholder_img_src.'" alt="'.esc_attr($alt_tag).'" height="'.esc_attr($height).'" width="'.esc_attr($width).'" data-nectar-img-src="'.esc_attr($img_src).'" data-nectar-img-srcset="'.esc_attr($img_srcset).'" sizes="'.esc_attr($sizes).'" />';

    }
  }




  /**
  * Map Legacy FA Icons
  *
  * Maps old icon class names to new versions.
  *
  * @since 1.9.4
  */
  if( !function_exists('nectar_generate_shadow_css') ) {
    function nectar_generate_shadow_css($atts) {

      $style = '';

      if( isset($atts['custom_box_shadow']) && 
         !empty($atts['custom_box_shadow']) ) {
    
          $shadow_method = isset($atts['box_shadow_method']) ? $atts['box_shadow_method'] : 'default';

          // Detemerine shadow type.
         if( 'default' === $shadow_method ) {
          $shadow_base = 'box-shadow: $;';
         } else {
          $shadow_base = 'filter: drop-shadow($);';
         }

        // Parse values.  
        $parsed_values = array();
        $kaboom = explode(',', $atts['custom_box_shadow']);
        foreach($kaboom as $item) {

          $data = explode(':', $item);

          // filter doesn't support spread.
          if( 'filter' === $shadow_method && $data[0] == 'spread') {
            continue;
          }

          $parsed_values[$data[0]] = $data[1];
        }

        // Build shadow.
        foreach($parsed_values as $key => $value) {
          if( 'opacity' !== $key ) {
            $style .= $value . 'px ';
          }
          else {
            $style .= 'rgba(0,0,0,'.$value.')';
          }
        }

        // Combine base and props.
        $style = str_replace('$', $style, $shadow_base);
				
      }

      return $style;
    }
  }


/**
  * Outputs icon HTML
  *
  *
  * @since 1.9.1
  */
  if( !function_exists('nectar_icon_el_output') ) {
    function nectar_icon_el_output($atts) {

      if( !isset($atts['icon_family']) ) {
        return '';
      }

      switch($atts['icon_family']) {
        case 'fontawesome':
          $icon = $atts['icon_fontawesome'];
          wp_enqueue_style( 'font-awesome' );
          break;
        case 'steadysets':
          $icon = $atts['icon_steadysets'];
          break;
        case 'linecons':
          $icon = $atts['icon_linecons'];
          wp_enqueue_style( 'vc_linecons' );
          break;
        case 'iconsmind':
          $icon = $atts['icon_iconsmind'];
          break;
        default:
          $icon = '';
          break;
      }

      if( $atts['icon_family'] !== 'none' ) {
		
        if( $atts['icon_family'] === 'iconsmind' ) {
          
          // SVG iconsmind.
          $icon_escaped = '<i><span class="im-icon-wrap"><span>';
          
          $converted_icon = str_replace('iconsmind-', '', $icon);
          $converted_icon = str_replace(".", "", $converted_icon);
          
          require_once( SALIENT_CORE_ROOT_DIR_PATH.'includes/icons/class-nectar-icon.php' );
    
          $nectar_icon_class = new Nectar_Icon(array(
            'icon_name' => $converted_icon,
            'icon_library' => 'iconsmind',
          ));
        
          $icon_escaped .= $nectar_icon_class->render_icon();
          $icon_escaped .= '</span></span></i>';
      
          
        } else {
          
          $icon_escaped = '<i class="' . esc_attr($icon) .'"></i>'; 
    
        }

        return $icon_escaped;
        
      } 

      return '';
      
    }
  }


  /**
  * CSS Animation Attributes
  *
  * @param array $atts - The attributes array.
  * @param string $stagger_element - class name of element to stagger
  *
  * @return array [class names, animation attributes]
  * @since 1.9.1
  */
  if( !function_exists('nectar_css_animation_atts') ) {
    function nectar_css_animation_atts( $atts, $stagger_element = false ) {
        
        $animation = isset($atts['css_animation']) ? $atts['css_animation'] : '';
        $delay = isset($atts['css_animation_delay']) ? $atts['css_animation_delay'] : false;
        $offset = isset($atts['css_animation_offset']) ? $atts['css_animation_offset'] : false;
        $mobile_disable = isset($atts['mobile_disable_css_animation']) ? $atts['mobile_disable_css_animation'] : false;

        $el_attrs = array();
        $el_classes = array();

        if( !empty($animation) && $animation !== 'none' ) {

          $el_classes[] = 'nectar-waypoint-el';

          // Animation name.
          $el_classes[] = 'nectar-' . $animation;

          // Stagger element selector.
          if( $stagger_element ) {
            $el_attrs[] = 'data-nectar-waypoint-el-stagger="'.esc_attr($stagger_element).'"';
          }
          
          // Animation delay.
          if( !empty($delay) ) {
              $el_attrs[] = 'data-nectar-waypoint-el-delay="'.esc_attr($delay).'"';
          }

          // Animation offset.
          if( !empty($offset) ) {
            $el_attrs[] = 'data-nectar-waypoint-el-offset="'.esc_attr($offset).'"';
          }

          // Mobile disable.
          if( !empty($mobile_disable) ) {
            $el_attrs[] = 'data-nectar-waypoint-el-mobile-disable="true"';
          }

        }
        
        $combined_props = array(
          'classes' => implode(' ', $el_classes),
          'atts' => implode(' ', $el_attrs),
        );

        // extra white space for atts.
        if( !empty($combined_props['atts']) ) {
          $combined_props['atts'] = ' ' . $combined_props['atts'];
        }

        return $combined_props;
  
    }
  }

/**
  * Map Legacy FA Icons
  *
  * Maps old icon class names to new versions.
  *
  * @since 1.9.1
  */
  if( !function_exists('nectar_svg_shape_divider') ) {
    
    function nectar_svg_shape_divider($shape_type, $shape_divider_color) {

      switch( $shape_type ) {
        case 'curve' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"> <path d="M 0 0 c 0 0 200 50 500 50 s 500 -50 500 -50 v 101 h -1000 v -100 z"></path> </svg>';
          break;
        case 'curve_asym' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"> <path d="M0 100 C 20 0 50 0 100 100 Z"></path> </svg>';
          break;
        case 'curve_asym_2' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"> <path d="M0 100 C 50 0 80 0 100 100 Z"></path> </svg>';
          break;
        case 'tilt' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"> <polygon points="104 10 0 0 0 10"></polygon> </svg>';
          break;
        case 'tilt_alt' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"> <polygon points="100 10 100 0 -4 10"></polygon> </svg>';
          break;
        case 'triangle' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"> <polygon points="501 53.27 0.5 0.56 0.5 100 1000.5 100 1000.5 0.66 501 53.27"/></svg>';
          break;
        case 'fan' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1003.92 91" preserveAspectRatio="none"> <polygon class="cls-1" points="502.46 46.31 1 85.67 1 91.89 1002.91 91.89 1002.91 85.78 502.46 46.31"/><polygon class="cls-2" points="502.46 45.8 1 0 1 91.38 1002.91 91.38 1002.91 0.1 502.46 45.8"/><rect class="cls-3" y="45.81" width="1003.92" height="46.09"/>
          </svg>';
          break;
        case 'waves' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300" preserveAspectRatio="none"> <path d="M 1000 300 l 1 -230.29 c -217 -12.71 -300.47 129.15 -404 156.29 c -103 27 -174 -30 -257 -29 c -80 1 -130.09 37.07 -214 70 c -61.23 24 -108 15.61 -126 10.61 v 22.39 z"></path> </svg>';
          break;
        case 'speech' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"> <path d="M 0 45.86 h 458 c 29 0 42 19.27 42 19.27 s 13 -19.27 42.74 -19.27 h 457.26 v 54.14 h -1000 z"></path>  </svg>';
          break;
        case 'straight_section' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"> <polygon points="104 10, 104 0, 0 0, 0 10"></polygon> </svg>';
          break;
        case 'clouds' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"> <path d="M 983.71 4.47 a 56.19 56.19 0 0 0 -37.61 14.38 a 15.24 15.24 0 0 0 -25.55 -0.55 a 40.65 40.65 0 0 0 -55.45 13 a 15.63 15.63 0 0 0 -22.69 1.52 a 73.82 73.82 0 0 0 -98.57 27.91 a 14.72 14.72 0 0 0 -9.31 0.55 a 26.13 26.13 0 0 0 -42.63 1.92 a 39.08 39.08 0 0 0 -47 10.08 a 18.45 18.45 0 0 0 -34.18 -0.45 a 12.21 12.21 0 0 0 -14.23 0.9 a 11.47 11.47 0 0 0 -16.59 -6 a 47.2 47.2 0 0 0 -66.12 -4.07 a 21.32 21.32 0 0 0 -26.48 -4.91 a 15 15 0 0 0 -29 -7.79 a 10.47 10.47 0 0 0 -14 5.13 a 31.55 31.55 0 0 0 -50.68 12.32 a 23 23 0 0 0 -28.69 -5.34 a 54.54 54.54 0 0 0 -89.93 5.71 a 16.3 16.3 0 0 0 -22.71 2.3 a 33.41 33.41 0 0 0 -44.93 9.65 a 17.72 17.72 0 0 0 -9.79 -2.94 h -0.22 a 29 29 0 0 0 -39.66 -12.26 a 75.24 75.24 0 0 0 -94 -12.19 a 22.91 22.91 0 0 0 -14.78 -5.34 h -0.69 a 33 33 0 1 0 -52.53 31.55 h -29.69 v 143.45 h 79.5 v -57.21 a 75.26 75.26 0 0 0 132.93 -46.7 a 28.88 28.88 0 0 0 12.78 -6.86 a 17.61 17.61 0 0 0 12.79 0 a 33.41 33.41 0 0 0 63.93 -7.44 a 54.56 54.56 0 0 0 101.57 18.56 v 7.65 h 140.21 a 47.23 47.23 0 0 0 79.55 -15.88 l 51.25 1.95 a 39.07 39.07 0 0 0 67.12 2.55 l 29.76 1.13 a 73.8 73.8 0 0 0 143.76 -16.75 h 66.17 a 56.4 56.4 0 1 0 36.39 -99.53 z"></path>  </svg>';
          break;
        case 'waves_opacity' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300" preserveAspectRatio="none">  <path d="M 850.23 235.79 a 1.83 1.83 0 0 0 -0.8 -3.24 c -10.23 -2 -53.38 -23.41 -97.44 -43.55 c -244.99 -112 -337.79 97.38 -432.99 104 c -115 8 -217 -87 -330 -37 c 0 0 9 15 9 42 v -1 h 849 l 2 -55 s -2.87 -3 1.23 -6.21 z"></path>  <path d="M 1000 300 l 1 -230.29 c -217 -12.71 -300.47 129.15 -404 156.29 c -103 27 -174 -30 -257 -29 c -80 1 -130.09 37.07 -214 70 c -61.23 24 -108 15.61 -126 10.61 v 22.39 z"></path> </svg>';
          break;
        case 'waves_opacity_alt' :
          echo '<svg class="nectar-shape-divider" aria-hidden="true" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300" preserveAspectRatio="none">
          <path d="M 1000 299 l 2 -279 c -155 -36 -310 135 -415 164 c -102.64 28.35 -149 -32 -232 -31 c -80 1 -142 53 -229 80 c -65.54 20.34 -101 15 -126 11.61 v 54.39 z"></path> <path d="M 1000 286 l 2 -252 c -157 -43 -302 144 -405 178 c -101.11 33.38 -159 -47 -242 -46 c -80 1 -145.09 54.07 -229 87 c -65.21 25.59 -104.07 16.72 -126 10.61 v 22.39 z"></path> <path d="M 1000 300 l 1 -230.29 c -217 -12.71 -300.47 129.15 -404 156.29 c -103 27 -174 -30 -257 -29 c -80 1 -130.09 37.07 -214 70 c -61.23 24 -108 15.61 -126 10.61 v 22.39 z"></path>
           </svg>';
          break;
        case 'curve_opacity' :
          echo '<svg class="nectar-shape-divider" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"> <path d="M 0 14 s 88.64 3.48 300 36 c 260 40 514 27 703 -10 l 12 28 l 3 36 h -1018 z"></path> <path d="M 0 45 s 271 45.13 500 32 c 157 -9 330 -47 515 -63 v 86 h -1015 z"></path> <path d="M 0 58 s 188.29 32 508 32 c 290 0 494 -35 494 -35 v 45 h -1002 z"></path> </svg>';
          break;
        case 'mountains' :
          echo '<svg class="nectar-shape-divider" fill="'.esc_attr($shape_divider_color).'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300" preserveAspectRatio="none">
          <path d="M 1014 264 v 122 h -808 l -172 -86 s 310.42 -22.84 402 -79 c 106 -65 154 -61 268 -12 c 107 46 195.11 5.94 275 137 z"></path>   <path d="M -302 55 s 235.27 208.25 352 159 c 128 -54 233 -98 303 -73 c 92.68 33.1 181.28 115.19 235 108 c 104.9 -14 176.52 -173.06 267 -118 c 85.61 52.09 145 123 145 123 v 74 l -1306 10 z"></path>
          <path d="M -286 255 s 214 -103 338 -129 s 203 29 384 101 c 145.57 57.91 178.7 50.79 272 0 c 79 -43 301 -224 385 -63 c 53 101.63 -62 129 -62 129 l -107 84 l -1212 12 z"></path>
          <path d="M -24 69 s 299.68 301.66 413 245 c 8 -4 233 2 284 42 c 17.47 13.7 172 -132 217 -174 c 54.8 -51.15 128 -90 188 -39 c 76.12 64.7 118 99 118 99 l -12 132 l -1212 12 z"></path>
          <path d="M -12 201 s 70 83 194 57 s 160.29 -36.77 274 6 c 109 41 184.82 24.36 265 -15 c 55 -27 116.5 -57.69 214 4 c 49 31 95 26 95 26 l -6 151 l -1036 10 z"></path> </svg>';
          break;

      }
    }

  }


 /**
  * Map Legacy FA Icons
  *
  * Maps old icon class names to new versions.
  *
  * @since 1.7
  */
  if( !function_exists('nectar_map_legacy_fa_icon_classes') ) {
    
    function nectar_map_legacy_fa_icon_classes() {
      
      $legacy_fa_map = array(	
        'icon-ban-circle'             => 'icon-ban',
        'icon-bar-chart'              => 'icon-bar-chart-o',
        'icon-beaker'                 => 'icon-flask',
        'icon-bell'                   => 'icon-bell-o',
        'icon-bell-alt'               => 'icon-bell',
        'icon-bitbucket-sign'         => 'icon-bitbucket-square',
        'icon-bookmark-empty'         => 'icon-bookmark-o',
        'icon-calendar-empty'         => 'icon-calendar-o',
        'icon-check-empty'            => 'icon-square-o',
        'icon-check-minus'            => 'icon-minus-square-o',
        'icon-check-sign'             => 'icon-check-square',
        'icon-check'                  => 'icon-check-square-o',
        'icon-chevron-sign-down'      => 'icon-chevron-down',
        'icon-chevron-sign-down'      => 'icon-chevron-down',
        'icon-chevron-sign-left'      => 'icon-chevron-left',
        'icon-chevron-sign-right'     => 'icon-chevron-right',
        'icon-chevron-sign-up'        => 'icon-chevron-up',
        'icon-circle-arrow-down'      => 'icon-arrow-circle-down',
        'icon-circle-arrow-left'      => 'icon-arrow-circle-left',
        'icon-circle-arrow-right'     => 'icon-arrow-circle-right',
        'icon-circle-arrow-up'        => 'icon-arrow-circle-up',
        'icon-circle-blank'           => 'icon-circle-o',
        'icon-cny'                    => 'icon-rmb',
        'icon-collapse-alt'           => 'icon-minus-square-o',
        'icon-collapse-top'           => 'icon-caret-square-o-up',
        'icon-collapse'               => 'icon-caret-square-o-down',
        'icon-comment-alt'            => 'icon-comment-o',
        'icon-comments-alt'           => 'icon-comments-o',
        'icon-copy'                   => 'icon-files-o',
        'icon-cut'                    => 'icon-scissors',
        'icon-dashboard'              => 'icon-tachometer',
        'icon-double-angle-down'      => 'icon-angle-double-down',
        'icon-double-angle-left'      => 'icon-angle-double-left',
        'icon-double-angle-right'     => 'icon-angle-double-right',
        'icon-double-angle-up'        => 'icon-angle-double-up',
        'icon-download'               => 'icon-arrow-circle-o-down',
        'icon-download-alt'           => 'icon-download',
        'icon-edit-sign'              => 'icon-pencil-square',
        'icon-edit'                   => 'icon-pencil-square-o',
        'icon-ellipsis-horizontal'    => 'icon-ellipsis-h',
        'icon-ellipsis-vertical'      => 'icon-ellipsis-v',
        'icon-envelope-alt'           => 'icon-envelope-o',
        'icon-exclamation-sign'       => 'icon-exclamation-circle',
        'icon-expand-alt'             => 'icon-plus-square-o',
        'icon-expand'                 => 'icon-caret-square-o-right',
        'icon-external-link-sign'     => 'icon-external-link-square',
        'icon-eye-close'              => 'icon-eye-slash',
        'icon-eye-open'               => 'icon-eye',
        'icon-facebook-sign'          => 'icon-facebook-square',
        'icon-facetime-video'         => 'icon-video-camera',
        'icon-file-alt'               => 'icon-file-o',
        'icon-file-text-alt'          => 'icon-file-text-o',
        'icon-flag-alt'               => 'icon-flag-o',
        'icon-folder-close-alt'       => 'icon-folder-o',
        'icon-folder-close'           => 'icon-folder',
        'icon-folder-open-alt'        => 'icon-folder-open-o',
        'icon-food '                  => 'icon-cutlery',
        'icon-frown'                  => 'icon-frown-o',
        'icon-fullscreen'             => 'icon-arrows-alt',
        'icon-github-sign'            => 'icon-github-square',
        'icon-google-plus-sign'       => 'icon-google-plus-square',
        'icon-group'                  => 'icon-users',
        'icon-h-sign'                 => 'icon-h-square',
        'icon-hand-down'              => 'icon-hand-o-down',
        'icon-hand-left'              => 'icon-hand-o-left',
        'icon-hand-right'             => 'icon-hand-o-right',
        'icon-hand-up'                => 'icon-hand-o-up',
        'icon-hdd'                    => 'icon-hdd-o',
        'icon-heart-empty'            => 'icon-heart-o',
        'icon-hospital'               => 'icon-hospital-o',
        'icon-indent-left'            => 'icon-outdent',
        'icon-indent-right'           => 'icon-indent',
        'icon-info-sign'              => 'icon-info-circle',
        'icon-keyboard'               => 'icon-keyboard-o',
        'icon-legal'                  => 'icon-gavel',
        'icon-lemon'                  => 'icon-lemon-o',
        'icon-lightbulb'              => 'icon-lightbulb-o',
        'icon-linkedin-sign'          => 'icon-linkedin-square',
        'icon-meh'                    => 'icon-meh-o',
        'icon-microphone-off'         => 'icon-microphone-slash',
        'icon-minus-sign-alt'         => 'icon-minus-square',
        'icon-minus-sign'             => 'icon-minus-circle',
        'icon-mobile-phone'           => 'icon-mobile',
        'icon-moon'                   => 'icon-moon-o',
        'icon-move'                   => 'icon-arrows',
        'icon-off'                    => 'icon-power-off',
        'icon-ok-circle'              => 'icon-check-circle-o',
        'icon-ok-sign'                => 'icon-check-circle',
        'icon-ok'                     => 'icon-check',
        'icon-paper-clip'             => 'icon-paperclip',
        'icon-paste'                  => 'icon-clipboard',
        'icon-phone-sign'             => 'icon-phone-square',
        'icon-picture'                => 'icon-picture-o',
        'icon-pinterest-sign'         => 'icon-pinterest-square',
        'icon-play-circle'            => 'icon-play-circle-o',
        'icon-play-sign'              => 'icon-play-circle',
        'icon-plus-sign-alt'          => 'icon-plus-square',
        'icon-plus-sign'              => 'icon-plus-circle',
        'icon-pushpin'                => 'icon-thumb-tack',
        'icon-question-sign'          => 'icon-question-circle',
        'icon-remove-circle'          => 'icon-times-circle-o',
        'icon-remove-sign'            => 'icon-times-circle',
        'icon-remove'                 => 'icon-times',
        'icon-reorder'                => 'icon-bars',
        'icon-resize-full'            => 'icon-expand',
        'icon-resize-horizontal'      => 'icon-arrows-h',
        'icon-resize-small'           => 'icon-compress',
        'icon-resize-vertical'        => 'icon-arrows-v',
        'icon-rss-sign'               => 'icon-rss-square',
        'icon-save'                   => 'icon-floppy-o',
        'icon-screenshot'             => 'icon-crosshairs',
        'icon-share-alt'              => 'icon-share',
        'icon-share-sign'             => 'icon-share-square',
        'icon-share'                  => 'icon-share-square-o',
        'icon-sign-blank'             => 'icon-square',
        'icon-signin'                 => 'icon-sign-in',
        'icon-signout'                => 'icon-sign-out',
        'icon-smile'                  => 'icon-smile-o',
        'icon-sort-by-alphabet-alt'   => 'icon-sort-alpha-desc',
        'icon-sort-by-alphabet'       => 'icon-sort-alpha-asc',
        'icon-sort-by-attributes-alt' => 'icon-sort-amount-desc',
        'icon-sort-by-attributes'     => 'icon-sort-amount-asc',
        'icon-sort-by-order-alt'      => 'icon-sort-numeric-desc',
        'icon-sort-by-order'          => 'icon-sort-numeric-asc',
        'icon-sort-down'              => 'icon-sort-desc',
        'icon-sort-up'                => 'icon-sort-asc',
        'icon-stackexchange'          => 'icon-stack-overflow',
        'icon-star-empty'             => 'icon-star-o',
        'icon-star-half-empty'        => 'icon-star-half-o',
        'icon-sun'                    => 'icon-sun-o',
        'icon-thumbs-down-alt'        => 'icon-thumbs-o-down',
        'icon-thumbs-up-alt'          => 'icon-thumbs-o-up',
        'icon-time'                   => 'icon-clock-o',
        'icon-trash'                  => 'icon-trash-o',
        'icon-tumblr-sign'            => 'icon-tumblr-square',
        'icon-twitter-sign'           => 'icon-twitter-square',
        'icon-unlink'                 => 'icon-chain-broken',
        'icon-upload'                 => 'icon-arrow-circle-o-up',
        'icon-upload-alt'             => 'icon-upload',
        'icon-warning-sign'           => 'icon-exclamation-triangle',
        'icon-xing-sign'              => 'icon-xing-square',
        'icon-youtube-sign'           => 'icon-youtube-square',
        'icon-zoom-in'                => 'icon-search-plus',
        'icon-zoom-out'               => 'icon-search-minus'
      );
      
      return $legacy_fa_map;
      
    }
    
  }
 