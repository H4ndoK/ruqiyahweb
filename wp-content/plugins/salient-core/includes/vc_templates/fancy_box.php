<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-fancy-box' );

$title = $el_class = $value = $label_value= $units = '';
extract(shortcode_atts(array(
	'image_url' => '',
	'link_url' => '',
	'link_new_tab' => '',
	'link_text' => '',
	'link_screen_reader' => '',
	'min_height' => '300',
	'color' => 'accent-color',
	'color_custom' => '',
	'hover_color' => 'accent-color',
	'hover_color_custom' => '',
	'box_style' => 'default',
	'hover_content' => '',
	'icon_family' => '',
	'icon_fontawesome' => '',
	'icon_linecons' => '',
	'icon_linea' => '',
	'icon_iconsmind' => '',
	'icon_steadysets' => '',
  'icon_position' => 'bottom',
	'custom_icon_image' => '',
	'icon_size' => '50',
	'secondary_content' => '',
	'box_color' => '',
	'content_color' => '#ffffff',
	'box_color_opacity' => '1',
	'color_box_hover_overlay_opacity' => 'default',
	'css' => '',
	'enable_animation' => '',
	'animation' => '',
	'enable_border' => '',
	'image_loading' => 'normal',
	'image_size' => 'full',
	'image_aspect_ratio' => '1-1',
  'bg_parallax' => '',
	'box_alignment' => 'left',
	'border_radius' => 'default',
	'hover_desc_bg_animation' => 'long_zoom',
	'parallax_hover_box_alignment' => 'middle',
	'parallax_hover_box_overlay' => '',
	'parallax_hover_box_overlay_opacity' => '0.6',
	'parallax_hover_box_overlay_opacity_hover' => '0.2',
	'delay' => ''

), $atts));

$style       = null;
$icon_markup = '';

//icon
switch($icon_family) {
	case 'fontawesome':
	$icon = $icon_fontawesome;
  wp_enqueue_style( 'font-awesome' );
	break;
	case 'steadysets':
	$icon = $icon_steadysets;
	break;
	case 'linea':
	$icon = $icon_linea;
	break;
	case 'linecons':
	$icon = $icon_linecons;
	break;
	case 'iconsmind':
	$icon = $icon_iconsmind;
	break;
	default:
	$icon = '';
	break;
}

if( $icon_family === 'linea' ) {
	wp_enqueue_style('linea');
} else if( $icon_family === 'linecons' ) {
	wp_enqueue_style( 'vc_linecons' );
}



if( !empty($icon) ) {

	$color_attr = 'data-color="'.esc_attr(strtolower($color)).'"';

	if( $icon_family === 'iconsmind' ) {

		// SVG iconsmind.
		$icon_id             = 'nectar-iconsmind-icon-'.uniqid();
		$icon_markup         = '<span class="im-icon-wrap" data-color="'.esc_attr(strtolower($color)) .'"><span>';
		$converted_icon_name = str_replace('iconsmind-', '', $icon);
	
		require_once( SALIENT_CORE_ROOT_DIR_PATH.'includes/icons/class-nectar-icon.php' );

		$nectar_icon_class = new Nectar_Icon(array(
		  'icon_name' => $converted_icon_name,
		  'icon_library' => 'iconsmind',
		));
	  
		$icon_markup .= $nectar_icon_class->render_icon();

		// Custom size.
		$icon_markup = preg_replace(
			array('/width="\d+"/i', '/height="\d+"/i'),
			array('width="'.$icon_size.'"', 'height="'.$icon_size.'"'),
			$icon_markup);

			// Handle custom colors.
			if($box_style == 'color_box_basic' && !empty($content_color) ) {
				$icon_markup =  preg_replace('/(<svg\b[^><]*)>/i', '$1 fill="'.$content_color.'">', $icon_markup);
			}
			// Gradient.
			if( strtolower($color) === 'extra-color-gradient-1' || strtolower($color) === 'extra-color-gradient-2') {

				$nectar_options = get_nectar_theme_options();

				if( strtolower($color) === 'extra-color-gradient-1' && isset($nectar_options["extra-color-gradient"]['from']) ) {

					$accent_gradient_from = $nectar_options["extra-color-gradient"]['from'];
					$accent_gradient_to   = $nectar_options["extra-color-gradient"]['to'];

				} else if( strtolower($color) === 'extra-color-gradient-2' && isset($nectar_options["extra-color-gradient-2"]['from']) ) {

					$accent_gradient_from = $nectar_options["extra-color-gradient-2"]['from'];
					$accent_gradient_to   = $nectar_options["extra-color-gradient-2"]['to'];

				}

				$icon_markup =  preg_replace('/(<svg\b[^><]*)>/i', '$1 fill="url(#'.$icon_id.')">', $icon_markup);

				$icon_markup .= '<svg style="height:0;width:0;position:absolute;" aria-hidden="true" focusable="false">
				<linearGradient id="'.$icon_id.'" x2="1" y2="1">
				<stop offset="0%" stop-color="'.$accent_gradient_from.'" />
				<stop offset="100%" stop-color="'.$accent_gradient_to.'" />
				</linearGradient>
				</svg>';
			}

			$icon_markup .= '</span></span>';
		}

		else {

		

			$icon_markup = '<i class="icon-default-style '.$icon.'" '.$color_attr.' style="font-size: '.esc_attr($icon_size).'px!important; line-height: '.esc_attr($icon_size).'px!important;"></i>';

			// Needs two for fancy gradient hover.
			if($box_style == 'color_box_hover' && strtolower($color) === 'extra-color-gradient-2' || $box_style === 'color_box_hover' && strtolower($color) === 'extra-color-gradient-1') {
				$icon_markup .= '<i class="icon-default-style hover-only '.$icon.'" data-color="white" style="font-size: '.esc_attr($icon_size).'px!important; line-height: '.esc_attr($icon_size).'px!important;"></i>';
			}

		}

	}

	// Custom Icon.
	if( $icon_family === 'custom' && !empty($custom_icon_image) ) {

		if(preg_match('/^\d+$/',$custom_icon_image)) {

			$icon_image_src = wp_get_attachment_image_src($custom_icon_image, 'full');

			if( isset($icon_image_src[0]) ) {

				$wp_icon_alt_tag = get_post_meta( $custom_icon_image, '_wp_attachment_image_alt', true );

				if( 'lazy-load' === $image_loading ||
				 (property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active) ) {
					$icon_markup = '<img style="max-width: '.intval($icon_size).'px;" class="fancy-box-custom-icon nectar-lazy" alt="'.esc_html($wp_icon_alt_tag).'" data-nectar-img-src="'.esc_url($icon_image_src[0]).'" />';
				} else {
					$icon_markup = '<img style="max-width: '.intval($icon_size).'px;" class="fancy-box-custom-icon" alt="'.esc_html($wp_icon_alt_tag).'" src="'. esc_url($icon_image_src[0]).'" />';
				}

			}

		}

	}

  $min_height_with_unit = intval($min_height) . 'px';

  $allowed_units = array('vh','vw','%');

  foreach( $allowed_units as $unit ) {
    if( strpos( $min_height, $unit ) !== false) {
      $min_height_with_unit = intval($min_height). $unit;
    }
  }
  


	$new_tab_markup  = ($link_new_tab == true) ? 'target="_blank"' : null;
	$using_img_class = null;
	$bg_image_src    = array('0' => '');

  $wp_image_size = ( !empty($image_size) ) ? esc_attr($image_size) : 'full';

	if( !empty($image_url) ) {

		$using_img_class = 'using-img';

		if(!preg_match('/^\d+$/',$image_url)){

			$bg_image_src = $image_url;
			if( 'lazy-load' === $image_loading ||
				(property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active) ) {
				$style .= ' data-nectar-img-src="'.esc_url($bg_image_src).'"';
			} else {
				$style .= ' style="background-image: url(\''.esc_url($bg_image_src).'\'); "';
			}


		} else {

			$bg_image_src = wp_get_attachment_image_src($image_url, $wp_image_size);

			if( isset($bg_image_src[0]) ) {
				if( 'lazy-load' === $image_loading ||
				 (property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active) ) {
					$style .= ' data-nectar-img-src="'.esc_url($bg_image_src[0]).'"';
				} else {
					$style .= ' style="background-image: url(\''.esc_url($bg_image_src[0]).'\'); "';
				}

			}

		}

	}

	$style2 = '';

	if( $box_style === 'color_box_basic' && !empty($box_color) ) {
		$color = $box_color;
	}

	if( !empty($box_color) && $box_style === 'color_box_basic' || !empty($content_color) && $box_style === 'color_box_basic') {

		$basic_box_coloring = '';

		if( !empty($box_color) ) {
			$basic_box_coloring .= ' background-color: '.esc_attr($box_color).';';
		}
		if( !empty($content_color) ) {
			$style2 = 'style="color: '.esc_attr($content_color).';"';
		}

		if( $style == null ) {
			$style = 'style="'.$basic_box_coloring.'"';
		}
		else {

			if( 'lazy-load' === $image_loading ||
			( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active) ) {
				$style .= ' style="'.$basic_box_coloring.'"';
			} else {
				// Remove the ending quotation first since it's already closed.
				$style = substr($style,0,-1);
				$style .= $basic_box_coloring .'"';
			}


		}

	}

	$box_link = null;
	if(!empty($link_url)) {
		$link_sr_text = (!empty($link_screen_reader)) ? 'aria-label="'.esc_html($link_screen_reader).'" ' : '';
		$box_link = '<a '.$new_tab_markup.' href="'.esc_attr($link_url).'" '.$link_sr_text.'class="box-link"></a>';
	}

	$text_link = null;
	if(!empty($link_text)) {
		$text_link = '<div class="link-text">'.$link_text.'<span class="arrow"></span></div>';
	}

	$extra_wrap_open = $extra_wrap_close = $extra_wrap_open2 = $extra_wrap_close2 = null;
	if( $box_style === 'color_box_hover' ) {
		$extra_wrap_open = '<div class="inner-wrap">';
		$extra_wrap_open2 = '<div class="box-inner-wrap">';
		$extra_wrap_close = $extra_wrap_close2 ='</div>';

	}

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

	$parsed_animation = '';

	if(!empty($animation) && $animation !== 'none' && $enable_animation === 'true') {
		$css_class .= ' has-animation';

		$parsed_animation = str_replace(" ","-",$animation);
		$delay = intval($delay);
	}

	// Dynamic style classes.
	if( function_exists('nectar_el_dynamic_classnames') ) {
		$dynamic_el_styles = nectar_el_dynamic_classnames('nectar_fancy_box', $atts);
	} else {
		$dynamic_el_styles = '';
	}

  // Parallax attrs
  $parallax_attr = '';

  if( $bg_parallax === 'true' ) {
    $parallax_attr = ' data-n-parallax-bg="true" data-parallax-speed="subtle"';
  }


	// Main Output.
	if( $box_style === 'parallax_hover' ) {

		if(!preg_match('/^\d+$/',$image_url)){
			$parallax_bg_img = $image_url;
		} else {

			$parallax_bg_img = '';
			if( isset($bg_image_src[0]) ) {
				$parallax_bg_img = $bg_image_src[0];
			}
			
		}

		$output = '<div class="nectar-fancy-box style-5 '.$using_img_class.' '.$css_class.esc_attr($dynamic_el_styles).'" data-align="'.esc_attr($parallax_hover_box_alignment).'" data-overlay-opacity="'.esc_attr($parallax_hover_box_overlay_opacity).'" data-overlay-opacity-hover="'.esc_attr($parallax_hover_box_overlay_opacity_hover).'" data-style="'. esc_attr($box_style) .'" data-border-radius="'. esc_attr($border_radius) .'" data-animation="'.strtolower(esc_attr($parsed_animation)).'" data-delay="'.esc_attr($delay).'" data-color="'.strtolower(esc_attr($color)).'">';

		$output .= $box_link;
		$output .= '<div class="parallaxImg">';
		$output .= '<div class="parallaxImg-layer" data-img="'.esc_url($parallax_bg_img).'"></div>';
		$output .= '<div class="parallaxImg-layer"> <div class="meta-wrap" style="min-height: '.esc_attr($min_height_with_unit).'"><div class="inner">';
		$output .= $icon_markup . wp_kses_post($content);
		$output .= '</div> </div></div></div>';
		$output .= '</div>';

	} else if( $box_style === 'hover_desc' ) {

		$hover_only_content = '';
		if( !empty($hover_content) ) {
			$hover_only_content = '<div class="hover-content">' . $hover_content . '</div>';
		}

		$output = '<div class="nectar-fancy-box '.$using_img_class.' '.$css_class.esc_attr($dynamic_el_styles).'"'.$parallax_attr.' style="min-height: '.esc_attr($min_height_with_unit).'" data-style="'. esc_attr($box_style) .'" data-border-radius="'. esc_attr($border_radius) .'" data-animation="'.strtolower(esc_attr($parsed_animation)).'" data-bg-animation="'.esc_attr($hover_desc_bg_animation).'" data-border="'.esc_attr($enable_border).'" data-delay="'.esc_attr($delay).'" data-alignment="'.esc_attr($box_alignment).'" data-color="'.strtolower($hover_color).'" '.$style2.'>';
		
    /* Parallax bg */
    if( $bg_parallax === 'true' ) {
      $output .= '<div class="parallax-layer"><div class="box-bg" '.$style.'></div></div>';
    } else {
      $output .=  '<div class="box-bg" '.$style.'></div>';
    }

    /* Top icon pos */
    $icon_markup_top = '';
    if( $icon_position === 'top' ) {
      $icon_markup_top = $icon_markup;
      $icon_markup = '';
    }
    
    $output .=  '<div class="inner">'.$icon_markup_top.'<div class="heading-wrap">' . $icon_markup .$extra_wrap_open . wp_kses_post($content) . '</div>' . wp_kses_post($hover_only_content) . $extra_wrap_close. '</div> '.$text_link.' '.$box_link.' </div>';
   
	}
	else if( $box_style === 'image_above_text_underline' ) {

		if( intval($min_height) == 300 ) {
			$style_escaped = '';
		} else {
			$style_escaped = 'style="min-height: '.esc_attr($min_height_with_unit). '"';
		}
		$output = '<div class="nectar-fancy-box nectar-underline '.$using_img_class.' '.$css_class.esc_attr($dynamic_el_styles).'" '.$style_escaped.' data-style="'. esc_attr($box_style) .'" data-border-radius="'. esc_attr($border_radius) .'" data-animation="'.strtolower(esc_attr($parsed_animation)).'" data-delay="'.esc_attr($delay).'" data-alignment="'.esc_attr($box_alignment).'">';
		$output .= '<div class="image-wrap"><div class="box-bg" '.$style.'></div></div>
		<div class="text">' . wp_kses_post($content) . '</div>'.$text_link.' '.$box_link.'
		</div>';

	}
	else {

		$output = '<div class="nectar-fancy-box '.$using_img_class.' '.$css_class.esc_attr($dynamic_el_styles).'" data-style="'. esc_attr($box_style) .'" data-animation="'.strtolower(esc_attr($parsed_animation)).'" data-hover-o="'.esc_attr($color_box_hover_overlay_opacity).'" data-border-radius="'. esc_attr($border_radius) .'" data-border="'.esc_attr($enable_border).'" data-box-color-opacity="'.esc_attr($box_color_opacity).'" data-delay="'.esc_attr($delay).'" data-alignment="'.esc_attr($box_alignment).'" data-color="'.strtolower($color).'" '.$style2.'>';
		$output .= $extra_wrap_open2 . '<div class="box-bg" '.$style.'></div> <div class="inner" style="min-height: '.esc_attr($min_height_with_unit).'">'.$extra_wrap_open . $icon_markup . wp_kses_post($content) . $extra_wrap_close. '</div> '.$text_link.' '.$box_link. $extra_wrap_close2 .' </div>';

	}

	echo do_shortcode($output);
