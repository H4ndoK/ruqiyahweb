<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

   extract(shortcode_atts(array(
	"type" => 'in_container',
	'bg_image'=> '',
	'bg_image_tablet' => '',
	'bg_image_phone' => '',
	'bg_image_animation' => 'none',
	'bg_image_animation_delay' => '',
	'background_image_mobile_hidden' => '',
	'clip_path_animation_type' => '',
	'background_image_loading' => '',
	'background_video_loading' => '',
	'bg_position'=> '',
	'bg_position_x' => '50%',
	'bg_position_y' => '50%',
	'bg_repeat' => '',
	'parallax_bg' => '',
	'parallax_bg_speed' => 'fast',
	'bg_color'=> '',
	'exclude_row_header_color_inherit' => '',
	'text_align'=> '',
	'vertically_center_columns' => '',

	'mouse_based_parallax_bg' => '',
	'layer_one_image' => '',
	'layer_two_image' => '',
	'layer_three_image' => '',
	'layer_four_image' => '',
	'layer_five_image' => '',

	'layer_one_strength' => '.20',
	'layer_two_strength' => '.40',
	'layer_three_strength' => '.60',
	'layer_four_strength' => '.80',
	'layer_five_strength' => '1.00',
	'scene_position' => '',
	'mouse_sensitivity' => '10',

	'video_bg'=> '',
	'enable_video_color_overlay'=> '',
	'video_overlay_color'=> '',
	'video_external'=> '',
	'video_webm'=> '',
	'video_mp4'=> '',
	'video_ogv'=> '',
	'video_image'=> '',
	'video_mute' => '',

	"top_padding" => "0",
	"top_padding_tablet" => "",
	"top_padding_phone" => "",
	"bottom_padding" => "0",
	"bottom_padding_phone" => "",
	"bottom_padding_tablet" => "",

	'translate_x' => '',
	'translate_x_tablet' => '',
	'translate_x_phone' => '',
	'translate_y' => '',
	'translate_y_tablet' => '',
	'translate_y_phone' => '',

	'text_color' => 'dark',
	'custom_text_color' => '',
	'id' => '',
	'class' => '',
	'full_height' => '',
	'columns_placement' => 'middle',
	'column_margin' => 'default',

	'column_direction' => 'default',
	'column_direction_tablet' => 'default',
	'column_direction_phone' => 'default',

	'animated_gradient_bg' => '',
	'animated_gradient_bg_color_1' => '',
	'animated_gradient_bg_color_2' => '',
	'animated_gradient_bg_blending_mode' => 'linear',
	'animated_gradient_bg_speed' => 'slow',
	'gradient_type' => '',
	'advanced_gradient' => '',
	'advanced_gradient_angle' => '',

	'enable_gradient' => 'false',
	'color_overlay' => '',
	'color_overlay_2' => '',
	'gradient_direction' => 'left_to_right',
	'overlay_strength' => '0.3',
	'equal_height' => '',
	'content_placement' => '',
	'row_name' => '',
	'full_screen_row_position' => 'middle',
	'disable_ken_burns' => '',
	'disable_element' => '',

	'row_border_radius' => 'none',
	'row_border_radius_applies' => 'bg',
	'enable_shape_divider' => '',
	'shape_type' => '',
	'shape_divider_color' => '',
	'shape_divider_bring_to_front' => '',
	'shape_divider_position' => '',
	'shape_divider_height' => '50',
	'shape_divider_height_tablet' => '',
	'shape_divider_height_phone' => '',
	'zindex' => '',
	'sticky_row' => '',
	'sticky_row_alignment' => 'top',

	),
	$atts));

  global $post;

	// CSS perspective.
	$css_perspective_class = '';

  // Top level row class.
  $top_level_class = '';

  if( in_the_loop() ) {

    if( !isset($GLOBALS['nectar_vc_row_count']) ) {
      $GLOBALS['nectar_vc_row_count'] = 0;
    }
    $GLOBALS['nectar_vc_row_count']++;

    if( !is_single() && $GLOBALS['nectar_vc_row_count'] == 1 && isset($post->ID) ) {

      $nectar_page_header_bool = nectar_header_section_check($post->ID);
      if( $nectar_page_header_bool == false ) {

        $top_level_class .= 'top-level ';

        if ( isset( $content ) && strpos( $content, '[nectar_slider' ) !== false && strpos( $content, 'full_width="true"' ) !== false ) {
          $top_level_class .= 'full-width-ns ';
        }

      }

    }
		
		if( isset( $content ) && isset($post->ID) ) {
			
			// Global Section
			if( strpos( $content, '[nectar_global_section' ) !== false ) {
				$top_level_class .= 'has-global-section ';
			}
			
			// CSS perspective
			if( strpos( $content, '"flip-in-vertical"' ) !== false ||
			    strpos( $content, '"slight-twist"' ) !== false ) {

				 // Prevent if using incompatible el.
				 if( strpos( $content, 'sticky="true"' ) === false &&
				     strpos( $content, '"vertical_scrolling"' ) === false ) {
					  	$css_perspective_class = ' flip-in-vertical-wrap';
				 }

			} // element exists that needs perspective.
		} // content is set.

  }


	wp_enqueue_style( 'js_composer_front' );
	wp_enqueue_script( 'wpb_composer_front_js' );
	wp_enqueue_style( 'js_composer_custom_css' );

	if( $mouse_based_parallax_bg === 'true' ) {
		wp_enqueue_script('nectar-parallax');
	}

  $style = '';
  $using_image_class = '';
  $row_bg_classes = array('row-bg-wrap');
  $using_custom_text_color = null;

  $nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
  $nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;

	// Force full width BG if using shape divider and in container.
	if( $enable_shape_divider === 'true' && $type === 'in_container' ) {
		$type = 'full_width_background';
	}

	$disable_class = '';
	if ( 'yes' !== $disable_element ) {

		if( $this->shortcode == 'vc_row_inner' ) {
      $text_color = null;
    }
		
		$bg_img_arr = array(
			'desktop' => array(
				'src' => $bg_image,
				'lazy_src' => '',
				'props' => '',
				'classes' => '',
				'in_use' => true
			),
			'tablet' => array(
				'src' => $bg_image_tablet,
				'lazy_src' => '',
				'props' => '',
				'classes' => '',
				'in_use' => false
			),
			'phone' => array(
				'src' => $bg_image_phone,
				'lazy_src' => '',
				'props' => '',
				'classes' => '',
				'in_use' => false
			),
		);
		

		foreach( $bg_img_arr as $viewport => $image ) {

			if( !empty($bg_img_arr[$viewport]['src']) ) {
				
					$bg_img_arr[$viewport]['in_use'] = true;
					
					// BG img src.
					if(!preg_match('/^\d+$/',$bg_img_arr[$viewport]['src'])) {
		
						if( 'lazy-load' === $background_image_loading || 
						     property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $background_image_loading ) {
							$bg_img_arr[$viewport]['lazy_src'] .= ' data-nectar-img-src="'.esc_url($bg_img_arr[$viewport]['src']).'"';
						}	else {
							$bg_img_arr[$viewport]['props'] .= 'background-image: url('. esc_url($bg_img_arr[$viewport]['src']) . '); ';
						}
		
					}
					else {
						$bg_image_src = wp_get_attachment_image_src($bg_img_arr[$viewport]['src'], 'full');
		
						if( isset($bg_image_src[0]) ) {
		
							if( 'lazy-load' === $background_image_loading || 
							    property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $background_image_loading ) {
								$bg_img_arr[$viewport]['lazy_src'] .= ' data-nectar-img-src="'.esc_url($bg_image_src[0]).'"';
							}	else {
								$bg_img_arr[$viewport]['props'] .= 'background-image: url('. esc_url($bg_image_src[0]) . '); ';
							}
		
						}
		
					}


				// Custom bg pos.
				if( 'custom' === $bg_position ) {
					$bg_img_arr[$viewport]['props'] .= 'background-position: '. esc_attr(intval($bg_position_x)) .'% '. esc_attr(intval($bg_position_y)) .'%; ';
				} else {
					$bg_img_arr[$viewport]['props'] .= 'background-position: '. esc_attr($bg_position) .'; ';
				}


				// Pattern bgs.
				if(strtolower($bg_repeat) === 'repeat'){
					$bg_img_arr[$viewport]['props'] .= 'background-repeat: '. esc_attr(strtolower($bg_repeat)) .'; ';
					$bg_img_arr[$viewport]['classes'] .= ' no-cover';
				} else {
					$bg_img_arr[$viewport]['props'] .= 'background-repeat: '. esc_attr(strtolower($bg_repeat)) .'; ';
				}

				$using_image_class = ' using-image';
			}

			if( !empty($bg_color) ) {

				$bg_img_arr[$viewport]['props'] .= 'background-color: '. esc_attr($bg_color).'; ';

				if( $exclude_row_header_color_inherit !== 'true' ) {
					$bg_img_arr[$viewport]['classes'] .= ' using-bg-color';
				} else {
					$bg_img_arr[$viewport]['classes'] .= ' using-bg-color-excluded';
				}

			}
			
		} // End bg prop loop.
		if( true === $bg_img_arr['tablet']['in_use'] ) {
			 $bg_img_arr['desktop']['classes'] .= ' has-tablet';
		}
		if( true === $bg_img_arr['phone']['in_use'] ) {
			 $bg_img_arr['desktop']['classes'] .= ' has-phone';
		}
		
		
	$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';
	$page_full_screen_rows_animation = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows_animation', true) : '';

    // Disable unneeded BG animations.
    if( $video_bg && !empty($video_webm) || $video_bg && !empty($video_mp4) || $video_bg && !empty($video_external) ) {
      if( strtolower($parallax_bg) === 'true' ) {
        $parallax_bg = '';
      }
      if( $bg_image_animation === 'zoom-out-reveal' || $bg_image_animation === 'slight-zoom-out-reveal' ) {
        $bg_image_animation = 'none';
      }
    }


		if( strtolower($parallax_bg) === 'true' && $page_full_screen_rows !== 'on' ){
			$parallax_class = 'parallax_section';
			$parallax_speed = 'data-parallax-speed="'.esc_attr($parallax_bg_speed).'"';
		} else {
			$parallax_class = '';
			$parallax_speed = null;
		}

		$vertically_center_class = null;

		if( $type === 'full_width_content' && $equal_height !== 'yes' ) {
			// v12.5+ uses CSS for all
			$equal_height = 'yes';

			if( strtolower($vertically_center_columns) === 'true' ) {
				$content_placement = 'middle';
			} else {
				$content_placement = 'top';
			}

		}
		else if( strtolower($vertically_center_columns) === 'true' && $equal_height !== 'yes' ) {
      // v11+ uses CSS for vertical center option instead of JS.
      $equal_height = 'yes';
      $content_placement = 'middle';
		}



		$row_percent_padding_attr = '';

		if( $page_full_screen_rows !== 'on' ) {

			if( strpos($top_padding,'%') !== false ) {

        $leading_zero = (intval($top_padding) < 10) ? '0' : '';
        $row_percent_padding_attr .= 'data-top-percent="'. esc_attr($top_padding) .'" ';
				$style .= 'padding-top: calc(100vw * 0.'. $leading_zero . intval($top_padding) .'); ';
			} else {
				$style .= 'padding-top: '. intval($top_padding) .'px; ';
			}

			if( strpos($bottom_padding,'%') !== false ) {

        $leading_zero = (intval($bottom_padding) < 10) ? '0' : '';
        $row_percent_padding_attr .= 'data-bottom-percent="'.esc_attr($bottom_padding).'" ';
				$style .= 'padding-bottom: calc(100vw * 0.'. $leading_zero . intval($bottom_padding) .'); ';

			} else {
				$style .= 'padding-bottom: '. intval($bottom_padding) .'px; ';
			}


      // z-index.
      if( !empty($zindex) ) {
         $style .= ' z-index: '.esc_attr($zindex).';';
      }

		}

		$midnight_color = $text_color;

		if( $text_color === 'custom' && !empty($custom_text_color) ) {
			$midnight_color = 'dark';
			$style .= 'color: '. esc_attr($custom_text_color) .'; ';
			$using_custom_text_color = 'data-using-ctc="true"';
		}

		// Row type class.
		if( $type === 'in_container' ) {
			$main_class = "";
		}
    else if( $type === 'full_width_background' ){
			$main_class = "full-width-section ";
		}
    else if( $type === 'full_width_content' ){
			$main_class = "full-width-content ";
		}

		// Remove in container possibility when using fullpage.js.
		if( $page_full_screen_rows === 'on' && $type === 'in_container') {
      		$main_class = "full-width-section ";
			}
			
		if( $page_full_screen_rows === 'on' && $page_full_screen_rows_animation === 'none' && !empty($bg_color) ) {
			$style .= 'background-color: '.esc_attr($bg_color).';';
		}


		// Remove ken burns when using fullpage.js.
		$disable_ken_burns_class = null;

		if( $page_full_screen_rows === 'on' && !empty($disable_ken_burns) && $disable_ken_burns === 'yes' ) {
			$disable_ken_burns_class = ' disable_ken_burns';
		}

		// Equal height column option.
		if( $equal_height === 'yes' || $nectar_using_VC_front_end_editor && strtolower($vertically_center_columns) === 'true' ) {
			$equal_height_class = ' vc_row-o-equal-height vc_row-flex ';
    }
		else {
		 	$equal_height_class = '';
    }

		if ( ! empty( $content_placement ) ) {
			$equal_height_class .= ' vc_row-o-content-' . $content_placement.' ';
		}

		// Row full height option.
		if ( ! empty( $full_height ) && $page_full_screen_rows != 'on' ) {
			$main_class .= 'vc_row-o-full-height ';
			if ( ! empty( $columns_placement ) ) {

				$equal_height_class = ' vc_row-o-equal-height vc_row-flex ';

				if ( ! empty( $content_placement ) ) {
					$equal_height_class .= ' vc_row-o-content-' . $content_placement.' ';
				}

				$main_class .= 'vc_row-o-columns-' . $columns_placement . ' ';

			}
		}


		$row_id = (!empty($id) && $page_full_screen_rows !== 'on') ? $id: uniqid("fws_");

		$fullscreen_anchor_id = null;
		if( $page_full_screen_rows === 'on' && !empty($id) ) {
			$fullscreen_anchor_id = 'data-fullscreen-anchor-id="'.$id.'"';
		}

		$midnight_attr = 'data-midnight="'.esc_attr(strtolower($midnight_color)).'"';

		// Border radius
		$border_radius_attrs = '';
		if( !empty($row_border_radius) && 'none' != $row_border_radius ) {
			$border_radius_attrs = ' data-br="'.esc_attr($row_border_radius).'" data-br-applies="'.esc_attr($row_border_radius_applies).'"';
		}

		// Scroll based animation.
		$json_animation_attrs = '';
		if( 'scroll' === $clip_path_animation_type ) {

			$inner_selector = ( isset($atts['clip_path_animation_applies']) && 'row' === $atts['clip_path_animation_applies']) ? '' : '.row-bg-layer';
			
			$animation_atts = array_merge(
				$atts, 
				array(
					'animation_inner_selector' => $inner_selector
				)
			);
			$animations = new NectarAnimations($animation_atts);
			$json_animation_attrs = 'data-nectar-animate-settings="'.esc_attr($animations->json).'" ';
		}

		// Animated gradient
		if( 'true' === $animated_gradient_bg ) {

			$gradient_color = $animated_gradient_bg_color_1;
			if( empty( $animated_gradient_bg_color_1 ) && defined( 'NECTAR_THEME_NAME' ) ) {
				$gradient_color = NectarThemeManager::$colors['accent-color']['value'];
			}
			
			$row_bg_classes[] = 'has-animated-gradient';

			$animated_gradient_bg_attrs = array(
				'color_1' => $gradient_color,
				'color_2' => $animated_gradient_bg_color_2,
				'speed' => $animated_gradient_bg_speed,
				'blending_mode' => $animated_gradient_bg_blending_mode
			);
			$json_animation_attrs .= 'data-nectar-animated-gradient-settings="'.esc_attr(wp_json_encode($animated_gradient_bg_attrs)).'" ';
		}

		// Dynamic style classes.
		if( function_exists('nectar_el_dynamic_classnames') ) {
			$dynamic_el_styles = nectar_el_dynamic_classnames('row', $atts);
		} else {
			$dynamic_el_styles = '';
		}

    $bg_mobile_hidden = ( !empty($background_image_mobile_hidden) ) ? ' data-bg-mobile-hidden="'.esc_attr($background_image_mobile_hidden).'"' : '';
	
	if( $bg_image_animation === 'slight-zoom-out-reveal' ) {
		$bg_image_animation = 'zoom-out-reveal';
		$main_class .= 'bg-animation--slight ';
	}

	$css_classes_combined = 'wpb_row vc_row-fluid vc_row '. $top_level_class . $main_class . $disable_class . $equal_height_class . $parallax_class . $vertically_center_class . ' '. $class . $dynamic_el_styles;
	

	// Begin row output.
	if( $page_full_screen_rows !== 'on' && 
	    'true' === $sticky_row ) {
		$sticky_div_style = '';
		if( !empty($zindex) ) {
			$sticky_div_style .= ' style="z-index: '.esc_attr($zindex).';"';
		}
		echo '<div class="nectar-sticky-row-wrap nectar-sticky-row-wrap--'.esc_attr($sticky_row_alignment).'"'.$sticky_div_style.'>';
	}
	   echo'
		<div id="'. esc_attr($row_id) .'" '.$fullscreen_anchor_id . $border_radius_attrs .' data-column-margin="'.esc_attr($column_margin).'" '.$midnight_attr.' '.$row_percent_padding_attr . $json_animation_attrs . $bg_mobile_hidden. ' class="'.nectar_clean_classnames($css_classes_combined).'" '.$using_custom_text_color.' style="'.$style.'">';

		if( $page_full_screen_rows === 'on' ) {
      echo '<div class="full-page-inner-wrap-outer"><div class="full-page-inner-wrap" data-name="'.esc_attr($row_name).'" data-content-pos="'.esc_attr($full_screen_row_position).'"><div class="full-page-inner">';
    }

	// Row bg.
	$using_bg_overlay = ( !empty($color_overlay) || !empty($color_overlay_2) ) ? 'true' : 'false';
	$base_bg_color_style = '';

	if( !empty($bg_color) && in_array($bg_image_animation, array('fade-in','clip-path')) ) {
		$base_bg_color_style = 'style="background-color: '. esc_attr($bg_color).';" ';
	}
	
	echo '<div class="'.nectar_clean_classnames(implode(' ',$row_bg_classes)).'" data-bg-animation="'.esc_attr($bg_image_animation).'" data-bg-animation-delay="'.esc_attr($bg_image_animation_delay).'" data-bg-overlay="'.esc_attr($using_bg_overlay).'"><div class="inner-wrap row-bg-layer' . $using_image_class . '" '.$base_bg_color_style.'>';
	
		foreach( $bg_img_arr as $viewport => $image ) {
			if( true === $image['in_use'] ) {
				echo '<div class="row-bg viewport-'. esc_attr($viewport) . $using_image_class . $disable_ken_burns_class . esc_attr($image['classes']).'" '.$parallax_speed.' style="'.$image['props'].'"'.$image['lazy_src'].'></div>';
			}
		}

    echo '</div>';

    // Row color overlay.
    $row_overlay_style = null;

	if( !empty($color_overlay) || 
		!empty($color_overlay_2) || 
		'advanced' === $gradient_type) {

      $row_overlay_style = 'style="';
      $gradient_direction_deg = '90deg';

      if(empty($color_overlay)) {
        $color_overlay = 'transparent';
      }
      if(empty($color_overlay_2)) {
        $color_overlay_2 = 'transparent';
      }

      // Legacy option conversion.
      if( $overlay_strength === 'image_trans' ) {
  			$overlay_strength = '1';
      }

      switch($gradient_direction) {
        case 'left_to_right' :
          $gradient_direction_deg = '90deg';
          break;
        case 'left_t_to_right_b' :
          $gradient_direction_deg = '135deg';
          break;
        case 'left_b_to_right_t' :
          $gradient_direction_deg = '45deg';
          break;
        case 'top_to_bottom' :
          $gradient_direction_deg = 'to bottom';
          break;
      }

	  if( 'advanced' === $gradient_type ) {
		if( !empty($advanced_gradient) ) {
			$row_overlay_style .= 'background:'.esc_attr($advanced_gradient).';';
		}
	  }
      else if( $enable_gradient === 'true' ) {

    			if($color_overlay !== 'transparent' && $color_overlay_2 === 'transparent') {
            $color_overlay_2 = 'rgba(255,255,255,0.001)';
          }
    			if($color_overlay === 'transparent' && $color_overlay_2 !== 'transparent') {
            $color_overlay = 'rgba(255,255,255,0.001)';
          }

    			if( $gradient_direction === 'top_to_bottom' ) {

    				if($color_overlay_2 === 'transparent' || $color_overlay_2 === 'rgba(255,255,255,0.001)') {
    					$row_overlay_style .= 'background: linear-gradient('. $gradient_direction_deg .',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 75%);  opacity: '. esc_attr($overlay_strength). '; ';
    				}

    				else if($color_overlay === 'transparent' || $color_overlay === 'rgba(255,255,255,0.001)') {
    					$row_overlay_style .= 'background: linear-gradient('. $gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
    				}

    				else if( $color_overlay !== 'transparent' && $color_overlay_2 !== 'transparent') {
    				  $row_overlay_style .= 'background: '. $color_overlay .'; background: linear-gradient('. $gradient_direction_deg . ',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
    				}

    			}
    			else if( $gradient_direction === 'left_to_right' ) {

    				if( $color_overlay === 'transparent' || $color_overlay === 'rgba(255,255,255,0.001)' ) {
    					$row_overlay_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
    				}

            if( $color_overlay_2 === 'transparent' || $color_overlay_2 === 'rgba(255,255,255,0.001)' ) {
              if( $overlay_strength === '1' ) {
                $row_overlay_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
              } else {
                $row_overlay_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 10%,' . $color_overlay_2 . ' 75%);  opacity: '. esc_attr($overlay_strength) .'; ';
              }

    				}

    				if( $color_overlay !== 'transparent' && $color_overlay_2 !== 'transparent') {
    					$row_overlay_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg.',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
    				}
    			}

					else if( $gradient_direction === 'radial' ) {
						$row_overlay_style .= 'background: '. $color_overlay .'; background: radial-gradient(50% 50% at 50% 50%,' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
					}

    			else {
    				$row_overlay_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg.',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
    			}


  		}

      // No gradient.
      else {

    			if( !empty($color_overlay) ) {
    				$row_overlay_style .= 'background-color:' . $color_overlay . ';  opacity: '.esc_attr($overlay_strength).'; ';
    			}

  		}

      $row_overlay_style .= '"';

    }

		if( !empty($row_overlay_style) ) {
	    echo '<div class="row-bg-overlay row-bg-layer" '. $row_overlay_style .'></div>';
		}
    echo '</div>';

		// Mouse based parallax layer.
		if( $mouse_based_parallax_bg === 'true' ) {

	        echo '<ul class="nectar-parallax-scene row-bg-layer" data-scene-position="'.esc_attr($scene_position).'" data-scene-strength="'.esc_attr($mouse_sensitivity).'">';
	        echo '<li class="layer" data-depth="0.00"></li>';

	        if( !empty($layer_one_image) ) {

	        	if( !preg_match('/^\d+$/',$layer_one_image) ) {
	        		$layer_one_image_src = $layer_one_image;
	        	} else {
	        		$layer_one_image_src = wp_get_attachment_image_src($layer_one_image, 'full');
	        		$layer_one_image_src = $layer_one_image_src[0];
	        	}

	        	echo '<li class="layer" data-depth="'.esc_attr($layer_one_strength).'"><div style="background-image:url(\''. esc_url($layer_one_image_src) .'\');"></div></li>';
	        }

	        if( !empty($layer_two_image) ) {

	        	if( !preg_match('/^\d+$/',$layer_two_image) ) {
	        		$layer_two_image_src = $layer_two_image;
	        	} else {
	        		$layer_two_image_src = wp_get_attachment_image_src($layer_two_image, 'full');
	        		$layer_two_image_src = $layer_two_image_src[0];
	        	}

	        	echo '<li class="layer" data-depth="'.esc_attr($layer_two_strength).'"><div style="background-image:url(\''. esc_url($layer_two_image_src) .'\');"></div></li>';
	        }

	        if( !empty($layer_three_image) ) {

	        	if( !preg_match('/^\d+$/',$layer_three_image) ) {
	        		$layer_three_image_src = $layer_three_image;
	        	} else {
	        		$layer_three_image_src = wp_get_attachment_image_src($layer_three_image, 'full');
	        		$layer_three_image_src = $layer_three_image_src[0];
	        	}

	        	echo '<li class="layer" data-depth="'.esc_attr($layer_three_strength).'"><div style="background-image:url(\''. esc_url($layer_three_image_src) .'\');"></div></li>';
	        }

	        if( !empty($layer_four_image) ) {

	        	if( !preg_match('/^\d+$/',$layer_four_image) ) {
	        		$layer_four_image_src = $layer_four_image;
	        	} else {
	        		$layer_four_image_src = wp_get_attachment_image_src($layer_four_image, 'full');
	        		$layer_four_image_src = $layer_four_image_src[0];
	        	}

	        	echo '<li class="layer" data-depth="'.esc_attr($layer_four_strength).'"><div style="background-image:url(\''. esc_url($layer_four_image_src) .'\');"></div></li>';
	        }
	        if( !empty($layer_five_image) ) {

	        	if(!preg_match('/^\d+$/',$layer_five_image)){
	        		$layer_five_image_src = $layer_five_image;
	        	} else {
	        		$layer_five_image_src = wp_get_attachment_image_src($layer_five_image, 'full');
	        		$layer_five_image_src = $layer_five_image_src[0];
	        	}

	        	echo '<li class="layer" data-depth="'.esc_attr($layer_five_strength).'"><div style="background-image:url(\''. esc_url($layer_five_image_src) .'\');"></div></li>';
	        }
	        echo '</ul>';

	        global $nectar_options;
	        $loading_animation    = (!empty($nectar_options['loading-image-animation']) && !empty($nectar_options['loading-image'])) ? $nectar_options['loading-image-animation'] : null;
    			$default_loader       = (empty($nectar_options['loading-image']) && !empty($nectar_options['theme-skin']) && $nectar_options['theme-skin'] === 'ascend') ? '<span class="default-loading-icon spin"></span>' : null;
    			$default_loader_class = (empty($nectar_options['loading-image']) && !empty($nectar_options['theme-skin']) && $nectar_options['theme-skin'] === 'ascend') ? 'default-loader' : null;


		}

		// Video bg layer.
		if( $video_bg ) {

			// Parse video image.
			if( strpos($video_image, "http") !== false ){
				$video_image_src = $video_image;
			} else if( preg_match('/^\d+$/', $video_image) ) {
        
				$video_image_src = wp_get_attachment_image_src($video_image, 'full');
        if( isset($video_image_src[0]) ) {
          $video_image_src = $video_image_src[0];
        }
				
			}

			if( $enable_video_color_overlay !== 'true' ) {
        $video_overlay_color = null;
      }
      ?>

			<div class="video-color-overlay row-bg-layer" data-color="<?php echo esc_attr( $video_overlay_color ); ?>"></div>
      <?php if( isset($video_image_src) && !empty($video_image_src) ) : ?>
			     <div class="mobile-video-image" style="background-image: url(<?php echo esc_url( $video_image_src ); ?>)"></div>
      <?php endif; ?>

			<div class="nectar-video-wrap row-bg-layer" data-bg-alignment="<?php echo esc_attr( $bg_position ); ?>">
				<div class="nectar-video-inner">
        <?php
				if( !empty($video_external) && vc_extract_youtube_id( $video_external ) ) {
					wp_enqueue_script( 'vc_youtube_iframe_api_js' );
					echo '<div class="nectar-youtube-bg"><span>'.$video_external.'</span></div>';
				} else {

					if( 'lazy-load' === $background_video_loading ) {
						echo '<video class="nectar-video-bg nectar-lazy-video" width="1800" height="700" preload="auto" loop autoplay muted playsinline>';
						if(!empty($video_webm)) { echo '<source data-nectar-video-src="'. esc_url( $video_webm ) .'" type="video/webm">'; }
						if(!empty($video_mp4)) { echo '<source data-nectar-video-src="'. esc_url( $video_mp4 ) .'"  type="video/mp4">'; }
						if(!empty($video_ogv)) { echo '<source data-nectar-video-src="'. esc_url( $video_ogv ) .'" type="video/ogg">'; }
						echo '</video>';
					} 
					else {
						echo '<video class="nectar-video-bg" width="1800" height="700" preload="auto" loop autoplay muted playsinline>';
						if(!empty($video_webm)) { echo '<source src="'. esc_url( $video_webm ) .'" type="video/webm">'; }
						if(!empty($video_mp4)) { echo '<source src="'. esc_url( $video_mp4 ) .'"  type="video/mp4">'; }
						if(!empty($video_ogv)) { echo '<source src="'. esc_url( $video_ogv ) .'" type="video/ogg">'; }
						echo '</video>';
					}
					
				}
        ?>
    		</div>
			 </div>

			<?php


		}


		$extra_container_div         = false;
		$extra_container_div_closing = false;

		if( $page_full_screen_rows === 'on' && $main_class === "full-width-section ") {

			$extra_container_div = true;
			$extra_container_div_closing = true;

			$pattern = get_shortcode_regex();

			if ( preg_match_all( '/'. $pattern .'/s', $content, $matches )  && array_key_exists( 0, $matches ))  {

				if($matches[0][0]){
					if( strpos($matches[0][0],'nectar_slider') !== false && strpos($matches[0][0],'full_width="true"') !== false
						|| strpos($matches[0][0],' type="full_width_content"') !== false && strpos($matches[0][0],'nectar_slider') !== false && strpos($matches[0][0],'[vc_column width="1/1"') !== false ) {
						$extra_container_div = false;
						$extra_container_div_closing = false;
					}
				}
			}
		}


    // Shape divider layer.
		if( $enable_shape_divider === 'true' ) {

      $shape_divider_length = ($shape_divider_position === 'both') ? 2 : 1;
      $shape_divider_pos    = ($shape_divider_position === 'both') ? array('top','bottom') : array($shape_divider_position);

      for( $i = 0; $i < $shape_divider_length; $i++ ) {

   			$shape_divider_height_val = (!empty($shape_divider_height) ) ? 'style=" height:'.intval($shape_divider_height) . 'px;"' : 'style=" height: 50px;"';

        // Percent height.
        $using_percent_shape_divider_attr = '';
        if( strpos($shape_divider_height,'%') !== false ) {
          $using_percent_shape_divider_attr = 'data-using-percent-val="true"';
          $shape_divider_height_val = 'style=" height:'.intval($shape_divider_height) . '%;"';
        }

        $no_bg_color_class = (empty($shape_divider_color)) ? 'no-color ': '';

   			echo '<div class="nectar-shape-divider-wrap '.$no_bg_color_class.'" '. $shape_divider_height_val .' '.$using_percent_shape_divider_attr.' data-height="'.esc_attr($shape_divider_height).'" data-front="'. esc_attr( $shape_divider_bring_to_front ).'" data-style="'. esc_attr( $shape_type ).'" data-position="'. esc_attr( $shape_divider_pos[$i] ) .'" >';
         nectar_svg_shape_divider($shape_type, $shape_divider_color);
  			echo '</div>';

      } // top or bottom loop

	} // using shape divider.


    if( $extra_container_div === true ) {
      echo '<div class="container">';
    }
    echo '<div class="row_col_wrap_12 col span_12 '. esc_attr(strtolower($text_color)) .' '. esc_attr($text_align) . esc_attr($css_perspective_class).'">'. do_shortcode($content) .'</div></div>';
    if($extra_container_div_closing === true) {
      echo '</div>';
	}
	
	if( $page_full_screen_rows !== 'on' && 
	    'true' === $sticky_row ) {
		echo '</div>';
	}

	if( $page_full_screen_rows === 'on' ) {
      echo '</div></div></div><!--inner-wrap-->';
    }

	} // end disable row option.

?>
