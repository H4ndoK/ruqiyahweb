<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$output = $el_class = $width = '';
extract(shortcode_atts(array(
    'el_class' => '',
    'width' => '1/1',
    'offset' => '',
    'css' => '',
    "boxed" => 'false',
		'zindex' => '',
    "centered_text" => 'false',
    'sticky_content' => '',
    'sticky_content_functionality' => 'js',
    'sticky_content_alignment' => 'default',
    'enable_animation' => '',
    'animation' => '',
    'column_position' => '',
    'column_padding' => 'no-extra-padding',
		'column_padding_tablet' => 'inherit',
		'column_padding_phone' => 'inherit',
    'column_padding_position'=> 'all',
    'column_padding_type' => 'default',

    'top_margin' => '',
		'top_margin_tablet' => '',
		'top_margin_phone' => '',
    'bottom_margin' => '',
		'bottom_margin_tablet' => '',
		'bottom_margin_phone' => '',

    'delay' => '0',
    'animation_offset' => '',
    'animation_easing' => 'default',
    'background_color' => '',
    'background_color_hover' => '',
    'background_hover_color_opacity' => '1',
    'background_color_opacity' => '1',
    'background_image' => '',
		'background_image_tablet' => '',
		'background_image_phone' => '',
    'background_image_loading' => '',
    'background_video_loading' => '',
		'background_image_position' => 'center center',
    'bg_image_animation' => 'none',
		'parallax_bg' => '',
	  'parallax_bg_speed' => 'fast',
    'enable_bg_scale' => '',
    'column_link' => '',
		'column_link_screen_reader' => '',
    'column_link_target' => '_self',
    'font_color' => '',
    'tablet_text_alignment' => '',
    'phone_text_alignment' => '',

    'column_parallax_intensity' => '3',
    'animation_type' => 'default',
    'persist_movement_on_mobile' => '',
    'animation_movement_type' => 'default',

    'gradient_type' => '',
		'advanced_gradient' => '',
		'advanced_gradient_angle' => '',

    'enable_gradient' => 'false',
	  'color_overlay' => '',
	  'color_overlay_2' => '',
	  'gradient_direction' => 'left_to_right',
    'overlay_strength' => '0.3',
    
    'translate_x' => '',
    'translate_y' => '',

		'border_type' => 'simple',
    'column_border_width' => 'none',
    'column_border_color' => '',
    'column_border_style' => 'solid',
    'enable_border_animation' => '',
    'border_animation_delay' => '',
    'column_shadow' => 'none',
    'custom_box_shadow' => '',
    'column_border_radius' => 'none',
    'tablet_width_inherit' => 'default',
    'video_bg'=> '',
	  'video_webm'=> '',
	  'video_mp4'=> '',
	  'video_ogv'=> '',
	  'video_image'=> '',

    'mask_enable' => '',
    'mask_shape' => '',
    'mask_custom_image' => '',

), $atts));

global $post;

$el_class         = $this->getExtraClass($el_class);
$width            = wpb_translateColumnWidthToSpan($width);
$width            = vc_column_offset_class_merge($offset, $width);
$box_border       = null;
$parsed_animation = '';

$style = 'style="';
$inner_columns_style = '';

$el_class .= ' wpb_column column_container vc_column_container col';
if( $boxed === 'true' && empty($background_image) && empty($background_color) ) {
  $el_class .= ' boxed';
  $box_border = '<span class="bottom-line"></span>';
}

if( $centered_text === 'true' ) {
  $el_class .= ' centered-text';
}

if( $sticky_content === 'true' ) {

   // JS powered.
  if( $sticky_content_functionality == 'js' ) {
    $el_class .= ' nectar-sticky-column';
  } 
  // CSS powered.
  else {

    if( 'middle' === $sticky_content_alignment ) { 
      $el_class .= ' nectar-sticky-column-css--middle';
    }
    $el_class .= ' nectar-sticky-column-css';
  }
}



$background_color_string = null;
$has_bg_color = 'false';

if(!empty($background_color)) {
	$background_color_string .= $background_color;
  $has_bg_color = 'true';
}

// column overlay attrs.
$column_bg_overlay_wrap_attrs_escaped = '';
if( 'true' === $mask_enable && 'custom' === $mask_shape ) {

  $mask_image_src = $mask_custom_image;

  if (preg_match('/^\d+$/', $mask_custom_image)) {
    apply_filters('wpml_object_id', $mask_image_src, 'attachment', TRUE);
    $mask_image_src = wp_get_attachment_image_src($mask_custom_image, 'full');
    $mask_image_src = (isset($mask_image_src[0])) ? $mask_image_src[0] : '';
  }

  $column_bg_overlay_wrap_attrs_escaped .= ' style="-webkit-mask-image: url('.esc_attr($mask_image_src).');"';
}


// Img bg.
$image_bg_markup = '';
$lazy_image_attr = '';
$image_style     = '';

$bg_img_arr = array(
	'desktop' => array(
		'src' => $background_image,
		'in_use' => true,
		'classes' => ''
	),
	'tablet' => array(
		'src' => $background_image_tablet,
		'in_use' => false,
		'classes' => ''
	),
	'phone' => array(
		'src' => $background_image_phone,
		'in_use' => false,
		'classes' => ''
	),
);

foreach( $bg_img_arr as $viewport => $image ) {

	if(!empty($bg_img_arr[$viewport]['src'])) {

			$image_style = '';
			$lazy_image_attr = '';

			// Track which mobile variants are supplied.
			if( 'desktop' === $viewport) {
				if( !empty($bg_img_arr['tablet']['src']) ) {
					$bg_img_arr[$viewport]['classes'] .= ' has-tablet';
				}
				if( !empty($bg_img_arr['phone']['src']) ) {
					$bg_img_arr[$viewport]['classes'] .= ' has-phone';
				}
			}

	    if(!preg_match('/^\d+$/',$bg_img_arr[$viewport]['src'])) {

					if( 'lazy-load' === $background_image_loading ||
					    property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $background_image_loading ) {
						$lazy_image_attr .= ' data-nectar-img-src="'.esc_url($bg_img_arr[$viewport]['src']).'"';
					} else {
						$image_style .= 'background-image: url('. esc_url($bg_img_arr[$viewport]['src']) . '); ';
					}

	    } else {

	    	$bg_image_src = wp_get_attachment_image_src($bg_img_arr[$viewport]['src'], 'full');

				if( isset($bg_image_src[0]) ) {

					if( 'lazy-load' === $background_image_loading ||
				    	 property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $background_image_loading ) {
						$lazy_image_attr .= ' data-nectar-img-src="'.esc_url($bg_image_src[0]).'"';
					} else {
						$image_style .= ' background-image: url(\''. esc_url($bg_image_src[0]) .'\'); ';
					}

				}

	    }

	    $using_bg_overlay = ( !empty($color_overlay) || !empty($color_overlay_2) ) ? 'true' : 'false';

			$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';
			$parallax_bg_attr = '';
	    $parallax_class   = '';
			if( !empty($parallax_bg) && strtolower($parallax_bg) === 'true' && 'on' !== $page_full_screen_rows ) {
				$parallax_bg_attr = 'data-n-parallax-bg="true" data-parallax-speed="'.esc_attr($parallax_bg_speed).'" ';
				$parallax_class = ' parallax-layer';
			}

	    $image_bg_markup .= '<div class="column-image-bg-wrap column-bg-layer viewport-'.esc_attr($viewport) . esc_attr($bg_img_arr[$viewport]['classes']).'" '.$parallax_bg_attr.'data-bg-pos="'.esc_attr($background_image_position).'"'.$column_bg_overlay_wrap_attrs_escaped.' data-bg-animation="'.esc_attr($bg_image_animation).'" data-bg-overlay="'.esc_attr($using_bg_overlay).'"><div class="inner-wrap">';
	    $image_bg_markup .= '<div class="column-image-bg'.esc_attr($parallax_class).'" style="'.$image_style.'"'.$lazy_image_attr.'></div>';
	    $image_bg_markup .= '</div></div>';

	} // End using BG image

} // End background loop.

$using_custom_font_color = '';
if( !empty($font_color) ) {
  $style .= ' color: '.$font_color.';';
  $using_custom_font_color = 'data-cfc="true" ';
}

// Margins.
if( !empty($top_margin) ) {
    // class for neg margin to adjust z-index
    if( strpos($top_margin,'-' ) !== false) {
        $el_class .= ' neg-marg';
    }
    // actual margin proc
    if( strpos($top_margin,'%' ) !== false) {
        $style .= 'margin-top: '. esc_attr($top_margin) .'; ';
    } 
    else if( strpos($top_margin,'vh' ) !== false) {
      $style .= 'margin-top: '. floatval($top_margin) .'vh; ';
    }
    else if( strpos($top_margin,'vw' ) !== false) {
      $style .= 'margin-top: '. floatval($top_margin) .'vw; ';
    }
    else {
        $style .= 'margin-top: '. intval($top_margin) .'px; ';
    }
}
if( !empty($bottom_margin) ) {
    if( strpos($bottom_margin,'%' ) !== false){
        $style .= 'margin-bottom: '. esc_attr($bottom_margin) .'; ';
    } 
    else if( strpos($bottom_margin,'vh' ) !== false){
      $style .= 'margin-bottom: '. floatval($bottom_margin) .'vh; ';
    } 
    else if( strpos($bottom_margin,'vw' ) !== false){
      $style .= 'margin-bottom: '. floatval($bottom_margin) .'vw; ';
    } 
    else {
        $style .= 'margin-bottom: '. intval($bottom_margin) .'px; ';
    }
}

// Z-index
if( isset($zindex) && !empty($zindex) ) {
	$style .= 'z-index: '. intval($zindex) .'; ';
}

// Custom shadows.
if( 'custom' === $column_shadow ) {
  if( 'true' === $mask_enable) {
    $atts['box_shadow_method'] = 'filter'; 
  }
  $custom_shadow_markup = nectar_generate_shadow_css($atts);
  if( !empty($custom_shadow_markup) ) {
    $inner_columns_style.= $custom_shadow_markup;
  }
}

// Transforms.
if( !empty($translate_y) || !empty($translate_x) ) {

    $inner_columns_style .= 'transform: ';
    
    if( !empty($translate_y) ) {
        if( strpos($translate_y,'%' ) !== false){
          $inner_columns_style .= ' translateY('. intval($translate_y) .'%)';
        }
        else if( strpos($translate_y,'vh' ) !== false ) {
          $inner_columns_style .= ' translateY('. intval($translate_y) .'vh)';
        }
        else {
          $inner_columns_style .= ' translateY('. intval($translate_y) .'px)';
        }
    }

    if( !empty($translate_x) ) {
        if( strpos($translate_x,'%' ) !== false){
          $inner_columns_style .= ' translateX('. intval($translate_x) .'%)';
        }
        else if( strpos($translate_x,'vh' ) !== false ) {
          $inner_columns_style .= ' translateX('. intval($translate_x) .'vh)';
        }
        else {
          $inner_columns_style .= ' translateX('. intval($translate_x) .'px)';
        }
    }
    $inner_columns_style .= ';';

}


if( empty($background_color) && 
  empty($background_image) && 
  empty($font_color) && 
  empty($zindex) && 
  empty($top_margin) && 
  empty($bottom_margin) ) {
    $style = '';
} else {
  $style .= '"';
}

$using_bg = (!empty($background_image) || !empty($background_color)) ? 'data-using-bg="true"': null;


$active_animation_offset = false;
$active_animation_easing = false;

if( !empty($animation) && $animation !== 'none' && $enable_animation === 'true' ) {

     $el_class .= ' has-animation';

     $parsed_animation = str_replace(" ","-",$animation);
     $delay = intval($delay);
     $active_animation_offset = true;
     $active_animation_easing = true;
}

if( $column_padding_type !== 'advanced' ) {
  $el_class .= ' '. $column_padding;
}

$border_html = null;

if( 'advanced' === $border_type) {
	$column_border_width = 'none';
}

if( !empty($column_border_width) && $column_border_width !== 'none' ) {

    // regular border when using border radius
    if((strpos($column_border_radius, 'px') !== false || $column_border_radius == 'custom') && 'true' !== $enable_border_animation) {

      $inner_columns_style .= 'border: '. esc_attr($column_border_width).' '.esc_attr($column_border_style).' '.esc_attr($column_border_color).';';

    } else {

        $column_border_markup = 'border: '. esc_attr($column_border_width).' solid rgba(255,255,255,0); ';

        $inner_columns_style .= $column_border_markup;

        $border_html = '<span class="border-wrap" style="border-color: '.esc_attr($column_border_color).';"><span class="border-top"></span><span class="border-right"></span><span class="border-bottom"></span><span class="border-left"></span></span>';
    }

} else {
    $column_border_markup = null;
}

$column_overlay_style = '';

if(!empty($background_color_string)) {

  $column_overlay_style = ' style="';

  if(!empty($background_color_opacity)) {
    $column_overlay_style .= 'opacity: '.esc_attr($background_color_opacity).'; ';
  }
  $column_overlay_style .= 'background-color: '.esc_attr($background_color_string).';';
  $column_overlay_style .= '"';

}


// Column color overlay layer.
$column_overlay_layer_style = null;
$column_overlay_layer_markup = null;

if( !empty($color_overlay) || 
    !empty($color_overlay_2) ||
    'advanced' === $gradient_type ) {

  $column_overlay_layer_style = 'style="';
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
      $column_overlay_layer_style .= 'background:'.esc_attr($advanced_gradient).';';
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
          $column_overlay_layer_style .= 'background: linear-gradient('. $gradient_direction_deg .',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 75%);  opacity: '. esc_attr($overlay_strength). '; ';
        }

        else if($color_overlay === 'transparent' || $color_overlay === 'rgba(255,255,255,0.001)') {
          $column_overlay_layer_style .= 'background: linear-gradient('. $gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
        }

        else if( $color_overlay !== 'transparent' && $color_overlay_2 !== 'transparent') {
          $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('. $gradient_direction_deg . ',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
        }

      }
      else if( $gradient_direction === 'left_to_right' ) {

        if( $color_overlay === 'transparent' || $color_overlay === 'rgba(255,255,255,0.001)' ) {
          $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
        }

        if( $color_overlay_2 === 'transparent' || $color_overlay_2 === 'rgba(255,255,255,0.001)' ) {
          if( $overlay_strength === '1' ) {
            $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 25%,' . $color_overlay_2 . ' 100%);  opacity: '. esc_attr($overlay_strength) .'; ';
          } else {
            $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg .',' . $color_overlay . ' 10%,' . $color_overlay_2 . ' 75%);  opacity: '. esc_attr($overlay_strength) .'; ';
          }

        }

        if( $color_overlay !== 'transparent' && $color_overlay_2 !== 'transparent') {
          $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg.',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
        }
      }

			else if( $gradient_direction === 'radial' ) {
				$column_overlay_layer_style .= 'background: '. $color_overlay .'; background: radial-gradient(50% 50% at 50% 50%,' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
			}

      else {
        $column_overlay_layer_style .= 'background: '. $color_overlay .'; background: linear-gradient('.$gradient_direction_deg.',' . $color_overlay . ' 0%,' . $color_overlay_2 . ' 100%);  opacity: '.esc_attr($overlay_strength).'; ';
      }


  }

  // No gradient.
  else {

      if( !empty($color_overlay) ) {
        $column_overlay_layer_style .= 'background-color:' . $color_overlay . ';  opacity: '.esc_attr($overlay_strength).'; ';
      }

  }

  $column_overlay_layer_style .= '"';

  $column_overlay_layer_markup = '<div class="column-overlay-layer" '.$column_overlay_layer_style.'></div>';
}


// Video bg.
$video_markup = null;
$video_image_src = '';

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


  if( !empty($video_image_src) ) {
    $video_markup .= '
    <div class="mobile-video-image column-video column-bg-layer" style="background-image: url('. esc_url( $video_image_src ) .')"></div>';
  }
  $video_markup .= '
  <div class="nectar-video-wrap column-video column-bg-layer"'.$column_bg_overlay_wrap_attrs_escaped.'>';
      
    if( 'lazy-load' === $background_video_loading ) {

      $video_markup .= '<video class="nectar-video-bg nectar-lazy-video" width="1800" height="700" preload="auto" loop autoplay muted playsinline>';
      if(!empty($video_webm)) { $video_markup .= '<source data-nectar-video-src="'. esc_url( $video_webm ) .'" type="video/webm">'; }
      if(!empty($video_mp4)) { $video_markup .= '<source data-nectar-video-src="'. esc_url( $video_mp4 ) .'"  type="video/mp4">'; }
      if(!empty($video_ogv)) { $video_markup .= '<source data-nectar-video-src="'. esc_url( $video_ogv ) .'" type="video/ogg">'; }
      $video_markup .= '</video>';

    }  else {
      $video_markup .= '
      <video class="nectar-video-bg" width="1800" height="700" preload="auto" loop autoplay muted playsinline>';

        if(!empty($video_webm)) { $video_markup .= '<source src="'. esc_url( $video_webm ) .'" type="video/webm">'; }
        if(!empty($video_mp4)) { $video_markup .= '<source src="'. esc_url( $video_mp4 ) .'"  type="video/mp4">'; }
        if(!empty($video_ogv)) { $video_markup .= '<source src="'. esc_url( $video_ogv ) .'" type="video/ogg">'; }

      $video_markup .='</video>';
    }
     

   $video_markup .= '</div>';

}

$column_link_sr_text = (!empty($column_link_screen_reader)) ? '<span class="screen-reader-text">'.esc_html($column_link_screen_reader).'</span>' : '';

$column_link_class = 'column-link';
if( $column_link_target == 'lightbox' ) {
  $column_link_target = '_self';
  $column_link_class .= ' pp';
}
$column_link_html = (!empty($column_link)) ? '<a class="'.$column_link_class.'" target="'.esc_attr($column_link_target).'" href="'.esc_attr($column_link).'">'.$column_link_sr_text.'</a>' : null;
$css_class        = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$column_data_attrs = ' ';

if( !empty($tablet_width_inherit) && 'default' !== $tablet_width_inherit ) {
	$column_data_attrs  .= 'data-t-w-inherits="'. esc_attr($tablet_width_inherit).'" ';
}

if( !empty($column_border_radius) && 'none' !== $column_border_radius && 'custom' !== $column_border_radius ) {
	$column_data_attrs .= 'data-border-radius="'.esc_attr($column_border_radius).'" ';
}

$using_shadow = false;
if( !empty($column_shadow) && 'none' !== $column_shadow ) {
	$using_shadow = true;
	$column_data_attrs .= 'data-shadow="'.esc_attr($column_shadow).'" ';
}

if( 'none' !== $column_border_width ) {
	$column_data_attrs .= 'data-border-animation="'.esc_attr($enable_border_animation).'" ';
	$column_data_attrs .= 'data-border-animation-delay="'.esc_attr($border_animation_delay).'" ';
	$column_data_attrs .= 'data-border-width="'.esc_attr($column_border_width).'" ';
	$column_data_attrs .= 'data-border-style="'.esc_attr($column_border_style).'" ';
	$column_data_attrs .= 'data-border-color="'.esc_attr($column_border_color).'" ';
}

if( $video_bg ) {
	$column_data_attrs .= 'data-video-bg="true" ';
}

if( !empty($color_overlay) || !empty($color_overlay_2) ) {
  $column_data_attrs .= 'data-overlay-color="true" ';
}

if( !empty($enable_bg_scale) ) {
	$column_data_attrs .= 'data-bg-cover="'.esc_attr($enable_bg_scale).'" ';
}

$column_data_attrs .= 'data-padding-pos="'. esc_attr($column_padding_position) .'" ';
$column_data_attrs .= 'data-has-bg-color="'.esc_attr($has_bg_color).'" ';
$column_data_attrs .= 'data-bg-color="'.esc_attr($background_color_string).'" ';
$column_data_attrs .= 'data-bg-opacity="'.esc_attr($background_color_opacity).'" ';

if( !empty($background_color_hover) ) {
	$column_data_attrs .= 'data-hover-bg="'.esc_attr($background_color_hover).'" ';
	$column_data_attrs .= 'data-hover-bg-opacity="'.esc_attr($background_hover_color_opacity).'" ';
}

$column_data_attrs .= 'data-animation="'.esc_attr(strtolower($parsed_animation)).'" ';
$column_data_attrs .= 'data-delay="'.esc_attr($delay).'" ';

if( $active_animation_offset && !empty($animation_offset) ) {
  $column_data_attrs .= 'data-animation-offset="'.esc_attr($animation_offset).'" ';
}

if( $active_animation_easing && !empty($animation_easing) && 'default' !== $animation_easing ) {
  $column_data_attrs .= 'data-animation-easing="'.esc_attr($animation_easing).'" ';
}

if( $animation_type == 'parallax' ) {
  $column_data_attrs .= 'data-scroll-animation="true" data-scroll-animation-movement="'.esc_attr($animation_movement_type).'" data-scroll-animation-mobile="'.esc_attr($persist_movement_on_mobile).'" data-scroll-animation-intensity="'.esc_attr(strtolower($column_parallax_intensity)).'" ';
}


// Col BG layers.
$col_bg_combined_output = $column_link_html . $border_html . $image_bg_markup . $video_markup;


if( !empty($column_overlay_layer_markup) || !empty($column_overlay_style) || true === $using_shadow || !empty($background_color_hover) ) {
	$col_bg_combined_output .= '<div class="column-bg-overlay-wrap column-bg-layer" data-bg-animation="'.esc_attr($bg_image_animation).'"'.$column_bg_overlay_wrap_attrs_escaped.'><div class="column-bg-overlay"'.$column_overlay_style.'></div>'.$column_overlay_layer_markup.'</div>';
}

$nectar_use_modern_grid = ( function_exists('nectar_use_flexbox_grid') && true === nectar_use_flexbox_grid() ) ? true : false;


// Dynamic style classes.
if( function_exists('nectar_el_dynamic_classnames') ) {
	$dynamic_el_styles = nectar_el_dynamic_classnames('column', $atts);
} else {
	$dynamic_el_styles = '';
}

// Output.
$output .= "\n\t".'<div '.$style.' class="'.esc_attr($css_class) . $dynamic_el_styles. '" '. $using_custom_font_color . $using_bg . $column_data_attrs . '>';

if( false === $nectar_use_modern_grid ) {
  $output .= $col_bg_combined_output;
}

$column_inner_style_parsed = '';

if( !empty($inner_columns_style) ) {
  $column_inner_style_parsed = 'style="'.$inner_columns_style.'"';
}
$output .= "\n\t\t".'<div class="vc_column-inner" '.$column_inner_style_parsed.'>';

if( true === $nectar_use_modern_grid ) {
  $output .= $col_bg_combined_output;
}

// Content wrapper.
$output .= "\n\t\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');

$output .= "\n\t\t".'</div>';

$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;
