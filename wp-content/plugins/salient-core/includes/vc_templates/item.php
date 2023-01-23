<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	'simple_slider_bg_image_url' => '',
  'simple_slider_bg_image_position' => 'default',
  'simple_slider_font_color' => '',
  'simple_slider_enable_gradient' => '',
	'simple_slider_color_overlay' => '',
	'simple_slider_color_overlay_2' => '',
	'simple_slider_overlay_strength' => '',
	'simple_slider_bg_color' => '',
  'simple_slider_bg_image_loading' => 'normal'
), $atts));

if( isset($_GET['vc_editable']) ) {
	$nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
	$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
} else {
	$nectar_using_VC_front_end_editor = false;
}

// Limit script choices on front end editor
if( $nectar_using_VC_front_end_editor ) {

	$nectar_carousel_script_store = 'flickity';

	if( isset($GLOBALS['nectar-carousel-script']) && 'simple_slider' === $GLOBALS['nectar-carousel-script'] ) {
		$nectar_carousel_script_store = 'simple_slider';
	}
} else {
	$nectar_carousel_script_store = $GLOBALS['nectar-carousel-script'];
}

if( $nectar_carousel_script_store === 'carouFredSel' ) {
	echo '<li class="col span_4">' . do_shortcode($content) . '</li>';
}
else if( $nectar_carousel_script_store === 'owl_carousel' ) {
	echo '<div class="carousel-item">' . do_shortcode($content) . '</div>';
}
else if( $nectar_carousel_script_store === 'flickity' && !$nectar_using_VC_front_end_editor ) {
	$class_names = array('cell');
	if( function_exists('nectar_el_dynamic_classnames') ) {
		$class_names[] = nectar_el_dynamic_classnames('flickity_carousel_slide', $atts);
	}
	$column_bg_markup = (!empty($GLOBALS['nectar_carousel_column_color'])) ? 'style=" background-color: ' . sanitize_text_field($GLOBALS['nectar_carousel_column_color']) . ';"': '';
	echo '<div class="'.esc_attr(implode(' ', $class_names)).'"><div class="inner-wrap-outer"><div class="inner-wrap" '.$column_bg_markup.'>' . do_shortcode($content) . '</div></div></div>';
}
else if( $nectar_carousel_script_store === 'simple_slider' || $nectar_using_VC_front_end_editor ) {

	$style             = '';
	$inner_attrs       = '';
	$class_names       = array('cell');
	$inner_class_names = array('inner');

	// Image.
	if( !empty($simple_slider_bg_image_url) ) {

		$bg_image_src = '';

		if(!preg_match('/^\d+$/',$simple_slider_bg_image_url)) {
			$bg_image_src = $simple_slider_bg_image_url;
		}
		else {
			$bg_image_src = wp_get_attachment_image_src($simple_slider_bg_image_url, 'full');
			if( isset($bg_image_src[0]) ) {
				$bg_image_src = $bg_image_src[0];
			}
		}

    // Lazy loading.
		if( (property_exists('NectarLazyImages', 'global_option_active') && 
       true === NectarLazyImages::$global_option_active && 
       true !== $nectar_using_VC_front_end_editor &&
       'skip-lazy-load' !== $simple_slider_bg_image_loading) || 
       'lazy-load' ===  $simple_slider_bg_image_loading) {
			  $style .= ' data-nectar-lazy-bg data-nectar-img-src="'.esc_url($bg_image_src).'"';
		} 
    else {
			  $style .= ' style="background-image: url(\''.esc_url($bg_image_src).'\'); "';
		}

	}
	
	$parallax_layer_class = ' parallax-layer';
	
	// FE Editor Specific.
	if( true === $nectar_using_VC_front_end_editor ) {
		$inner_class_names[] = 'inner-wrap';
		$parallax_layer_class = '';
		$inner_attrs = (isset($GLOBALS['nectar_carousel_column_color']) && !empty($GLOBALS['nectar_carousel_column_color'])) ? 'style="background-color: ' . sanitize_text_field($GLOBALS['nectar_carousel_column_color']) . ';"': '';
	}

	$simple_slider_bg_color_style = '';
	
	if( !empty($simple_slider_bg_color) ) {
		$simple_slider_bg_color_style = 'style="background-color: '.esc_attr($simple_slider_bg_color).';"';
		$class_names[] = 'has-bg-color';
	}

	// Dynamic style classes.
	if( function_exists('nectar_el_dynamic_classnames') ) {
		$class_names[] = nectar_el_dynamic_classnames('simple_slider_slide', $atts);
	}

	echo '<div class="'.esc_attr(implode(" ", $class_names)).'">
		<div class="bg-layer-wrap'.esc_attr($parallax_layer_class).'" '.$simple_slider_bg_color_style.'><div class="bg-layer"'.$style.'></div>';
		if( !empty($simple_slider_color_overlay) || !empty($simple_slider_color_overlay_2) ) {
			echo '<div class="color-overlay" data-strength="'.esc_attr($simple_slider_overlay_strength).'"></div>';
		}
		echo '</div>
		<div class="'.esc_attr(implode(" ", $inner_class_names)).'" '.$inner_attrs.'>'.do_shortcode($content).'</div>
	</div>';
}

?>
