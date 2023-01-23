<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
  "animation" => 'Fade In',
  "animation_easing" => 'default',
  "loop_animation" => 'none',
  'animation_movement_type' => 'transform_y',
  'animation_movement_intensity' => '',
  'animation_movement_persist_on_mobile' => '',
  "delay" => '0',
  "image_url" => '',
  'alt' => '',
  'margin_top' => '',
  'margin_right' => '',
  'margin_bottom' => '',
  'margin_left' => '',
	'margin_top_tablet' => '',
  'margin_right_tablet' => '',
  'margin_bottom_tablet' => '',
  'margin_left_tablet' => '',
	'margin_top_phone' => '',
  'margin_right_phone' => '',
  'margin_bottom_phone' => '',
  'margin_left_phone' => '',
  'alignment' => 'left',
  'border_radius' => '',
  'img_link_target' => '_self',
  'img_link' => '',
  'img_link_large' => '',
	'img_link_caption' => '',
  'hover_animation' => 'none',
  'hover_overlay_color' => '',
  'box_shadow' => 'none',
  'box_shadow_direction' => 'middle',
  'image_loading' => 'normal',
  'max_width' => '100%',
  'max_width_mobile' => '100%',
	'max_width_custom' => '',
  'image_size' => '',
  'custom_image_size' => '',
  'custom_sizes_attr' => '',
  'mask_enable' => '',
  'mask_shape' => '',
  'mask_custom_image' => '',
  'el_class' => ''), $atts));

  $parsed_animation = str_replace(" ","-",$animation);
  if( $loop_animation != 'none' ) {
    $parsed_animation = 'none';
  }
  (!empty($alt)) ? $alt_tag = $alt : $alt_tag = null;
  $wp_img_caption_markup_escaped = '';
  $dynamic_el_styles = '';
  $image_width  = '100';
  $image_height = '100';
  $image_srcset = null;
  $has_dimension_data = false;
  $wp_image_size = ( !empty($image_size) ) ? esc_html($image_size) : 'full';

  if( 'custom' === $image_size && !empty($custom_image_size) ) {
    $wp_image_size = esc_html($custom_image_size);
  }

  if( preg_match('/^\d+$/',$image_url) ) {

		$image_url = apply_filters('wpml_object_id', $image_url, 'attachment', TRUE);

    $image_src = wp_get_attachment_image_src($image_url, $wp_image_size);

    if (function_exists('wp_get_attachment_image_srcset')) {

      $image_srcset_values = wp_get_attachment_image_srcset($image_url, $wp_image_size);
      if($image_srcset_values) {

        if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() ||
					( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) ) {
          $image_srcset = 'data-nectar-img-srcset="';
        } else {
          $image_srcset = 'srcset="';
        }
        $image_srcset .= $image_srcset_values;

        $image_sizes = wp_get_attachment_image_sizes($image_url, $wp_image_size);
        if( !empty($custom_sizes_attr) ) {
          $image_sizes = esc_attr($custom_sizes_attr);
        } 
 
        $image_srcset .= '" sizes="'.$image_sizes.'"';
        
      }
    }


    if( 'full' === $wp_image_size ) {
      $image_meta = wp_get_attachment_metadata($image_url);

      if(isset($image_meta['width']) && !empty($image_meta['width'])) {
        $image_width = $image_meta['width'];
      }
      if(isset($image_meta['height']) && !empty($image_meta['height'])) {
        $image_height = $image_meta['height'];}

      // Needed for lazy loading.
      if( !empty($image_meta['width']) && !empty($image_meta['height']) ) {
        $has_dimension_data = true;
      }
    } 
    // custom size selected.
    else {

      if(isset($image_src[1]) && !empty($image_src[1])) {
        $image_width = $image_src[1];
      }
      if(isset($image_src[2]) && !empty($image_src[2])) {
        $image_height = $image_src[2];
        $has_dimension_data = true;
        $dynamic_el_styles .= ' custom-size';
      }
       
    }

    $wp_img_alt_tag = get_post_meta( $image_url, '_wp_attachment_image_alt', true );

		if( 'yes' === $img_link_caption && function_exists('wp_get_attachment_caption') ) {
			$wp_img_caption = wp_get_attachment_caption($image_url);
			$wp_img_caption_markup_escaped = ' title="'.esc_attr($wp_img_caption).'"';
		}

    if(!empty($wp_img_alt_tag)) {
      $alt_tag = $wp_img_alt_tag;
    }

    $image_url = ( isset($image_src[0]) ) ? $image_src[0] : '';

  }

  // Margins.
  $margins = '';

  if( !empty($margin_top) ) {

    if( strpos($margin_top,'%') !== false ) {
      $margins .= 'margin-top: '.intval($margin_top).'%; ';
    } else {
      $margins .= 'margin-top: '.intval($margin_top).'px; ';
    }

  }
  if( !empty($margin_right) ) {

    if( strpos($margin_right,'%') !== false ) {
      $margins .= 'margin-right: '.intval($margin_right).'%; ';
    } else {
      $margins .= 'margin-right: '.intval($margin_right).'px; ';
    }

  }
  if( !empty($margin_bottom) ) {

    if( strpos($margin_bottom,'%') !== false ) {
      $margins .= 'margin-bottom: '.intval($margin_bottom).'%; ';
    } else {
      $margins .= 'margin-bottom: '.intval($margin_bottom).'px; ';
    }

  }
  if( !empty($margin_left) ) {

    if( strpos($margin_left,'%') !== false ) {
      $margins .= 'margin-left: '.intval($margin_left).'%;';
    } else {
      $margins .= 'margin-left: '.intval($margin_left).'px;';
    }

  }


  $style_attrs = '';
  $inner_style_attrs = '';

  // Collect styles for main wrap.
  if( !empty($margins) ) {
    $style_attrs = ' style="'.$margins.'"';
  }

  // Attributes applied to img-with-animation-wrap.
  $wrap_image_attrs_escaped  = 'data-max-width="'.esc_attr($max_width).'" ';
	if( 'custom' === $max_width ) {
		$max_width_mobile = 'default';
	}
  $wrap_image_attrs_escaped .= 'data-max-width-mobile="'.esc_attr($max_width_mobile).'" ';
	if( !empty($border_radius) && 'none' !== $border_radius ) {
	  $wrap_image_attrs_escaped .= 'data-border-radius="'.esc_attr($border_radius).'" ';
	}
  $wrap_image_attrs_escaped .= 'data-shadow="'.esc_attr($box_shadow).'" ';
  $wrap_image_attrs_escaped .= 'data-animation="'.esc_attr(strtolower($parsed_animation)).'" ';
  $wrap_image_attrs_escaped .= $style_attrs;

  // Movement animation.
  if( !empty($animation_movement_intensity) ) {
    $dynamic_el_styles .= ' nectar-el-parallax-scroll';
    $wrap_image_attrs_escaped .= 'data-scroll-animation="true" data-scroll-animation-movement="'.esc_attr($animation_movement_type).'" data-scroll-animation-mobile="'.esc_attr($animation_movement_persist_on_mobile).'" data-scroll-animation-intensity="'.esc_attr(strtolower($animation_movement_intensity)).'" ';
  }

  if( 'true' === $mask_enable && 'custom' === $mask_shape ) {

    $mask_image_src = $mask_custom_image;

    if (preg_match('/^\d+$/', $mask_custom_image)) {
      apply_filters('wpml_object_id', $mask_image_src, 'attachment', TRUE);
      $mask_image_src = wp_get_attachment_image_src($mask_custom_image, 'full');
      $mask_image_src = (isset($mask_image_src[0])) ? $mask_image_src[0] : '';
    }

    $inner_style_attrs .= '-webkit-mask-image: url('.esc_attr($mask_image_src).');';
  }


  // Collect attributes for inner div.
  if( !empty($inner_style_attrs) ) {
    $inner_style_attrs = ' style="'.$inner_style_attrs.'"';
  }

  // Attributes applied to img.
  $image_attrs_escaped = 'data-delay="'.esc_attr($delay).'" ';
  $image_attrs_escaped .= 'height="'.esc_attr($image_height).'" ';
  $image_attrs_escaped .= 'width="'.esc_attr($image_width).'" ';
  $image_attrs_escaped .= 'data-animation="'.esc_attr(strtolower($parsed_animation)).'" ';

  if( 'none' !== $parsed_animation && !empty($animation_easing) && 'default' !== $animation_easing ) {
    $image_attrs_escaped .= 'data-animation-easing="'.esc_attr($animation_easing).'" ';
  }

	// Attributes applied to inner wrap for hover effect.
	$image_hover_attrs_escaped = '';
	if( !empty($hover_animation) && 'none' !== $hover_animation ) {
		$image_hover_attrs_escaped .= ' data-hover-animation="'.esc_attr($hover_animation).'"';
	}

  // Custom shadows.
  $custom_shadow_markup = nectar_generate_shadow_css($atts);
  if( !empty($custom_shadow_markup) ) {
    $image_hover_attrs_escaped .= ' style="'.$custom_shadow_markup.'"';
  }


  if( 'lazy-load' === $image_loading && true === $has_dimension_data && NectarLazyImages::activate_lazy() ||
	   ( true === $has_dimension_data && property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) ) {

    $el_class .= ' nectar-lazy';
    $image_attrs_escaped .= 'data-nectar-img-src="'.esc_url($image_url).'" ';

		$placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($image_width).'%20'.esc_attr($image_height)."'%2F%3E";
		$image_attrs_escaped .= 'src="'.$placeholder_img_src.'" ';
  } else {
    $image_attrs_escaped .= 'src="'.esc_url($image_url).'" ';
  }
  $image_attrs_escaped .= 'alt="'.esc_attr($alt_tag).'" ';
  $image_attrs_escaped .= $image_srcset;

  $color_overlay_markup_escaped = null;
  if( 'color-overlay' === $hover_animation && !empty($hover_overlay_color) ) {
    $color_overlay_markup_escaped = '<div class="color-overlay" style="background-color: '.esc_attr($hover_overlay_color).';"></div>';
  }

	// Dynamic style classes.
	if( function_exists('nectar_el_dynamic_classnames') ) {
		$dynamic_el_styles .= nectar_el_dynamic_classnames('image_with_animation', $atts);
	} 

  if( !empty($img_link) || !empty($img_link_large) ) {

    if( !empty($img_link) && empty($img_link_large) ) {

      $link_classes = array(esc_attr($alignment));
      if( 'lightbox' === $img_link_target ) {
        $img_link_target = '_self';
        $link_classes[] = 'pp';
        $link_classes[] = 'nectar_video_lightbox';
      }
      // Link image to larger version.
      echo '<div class="img-with-aniamtion-wrap '.esc_attr($alignment).$dynamic_el_styles.'" '.$wrap_image_attrs_escaped.'>
      <div class="inner"'.$inner_style_attrs.'>
        <div class="hover-wrap"'.$image_hover_attrs_escaped.'> '.$color_overlay_markup_escaped.'
          <div class="hover-wrap-inner">
            <a href="'.esc_url($img_link).'" target="'.esc_attr($img_link_target).'" class="'.implode(' ',$link_classes).'">
              <img class="img-with-animation skip-lazy '.esc_attr($el_class).'" '.$image_attrs_escaped.' />
            </a>
          </div>
        </div>
      </div>
      </div>';

    } elseif(!empty($img_link_large)) {
      // Regular link image.
      echo '<div class="img-with-aniamtion-wrap '.esc_attr($alignment).$dynamic_el_styles.'" '.$wrap_image_attrs_escaped.'>
      <div class="inner"'.$inner_style_attrs.'>
        <div class="hover-wrap"'.$image_hover_attrs_escaped.'> '.$color_overlay_markup_escaped.'
          <div class="hover-wrap-inner">
            <a href="'.esc_url($image_url).'" class="pp '.esc_attr($alignment).'"'.$wp_img_caption_markup_escaped.'>
              <img class="img-with-animation skip-lazy '.esc_attr($el_class).'" '.$image_attrs_escaped.' />
            </a>
          </div>
        </div>
      </div>
      </div>';
    }

  } else {
    // No link image.
    echo '<div class="img-with-aniamtion-wrap '.esc_attr($alignment).$dynamic_el_styles.'" '.$wrap_image_attrs_escaped.'>
      <div class="inner"'.$inner_style_attrs.'>
        <div class="hover-wrap"'.$image_hover_attrs_escaped.'> '.$color_overlay_markup_escaped.'
          <div class="hover-wrap-inner">
            <img class="img-with-animation skip-lazy '.esc_attr($el_class).'" '.$image_attrs_escaped.' />
          </div>
        </div>
      </div>
    </div>';
  }

?>
