<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-highlighted-text' );

$text = $color = '';

extract(shortcode_atts(array(
	'highlight_color' => '',
	'secondary_color' => '',
	'style' => 'full_text',
	'delay' => 'false',
	'outline_thickness' => 'thin',
	'underline_thickness' => 'default',
	'highlight_expansion' => 'default',
	'text_color' => '',
	'scribble_shape' => 'circle',
	'scribble_thickness' => 'thin',
	'scribble_speed' => '1.6s',
	'scribble_color' => '#000',
	'scribble_text_highlight' => '',
	'id' => ''
), $atts));

$using_custom_color = (!empty($highlight_color)) ? 'true' : 'false';

// Dynamic style classes.
if( function_exists('nectar_el_dynamic_classnames') ) {
	$dynamic_el_styles = nectar_el_dynamic_classnames('nectar_highlighted_text', $atts);
} else {
	$dynamic_el_styles = '';
}

$style_specific_attrs_escaped = '';

if( 'text_outline' === $style ) {
	$style_specific_attrs_escaped .= 'data-outline-thickness="'.esc_attr($outline_thickness).'" ';
} else {
	$style_specific_attrs_escaped .= 'data-exp="'.esc_attr($highlight_expansion).'" ';
}

if( 'regular_underline' === $style ) {
	$style_specific_attrs_escaped .= 'data-underline-thickness="'.esc_attr($underline_thickness).'" ';
}

if( !empty($id) ) {
	$style_specific_attrs_escaped .= 'data-id="'.esc_attr($id).'" ';
}

if( !empty($text_color) ) {
	$style_specific_attrs_escaped .= 'data-user-color="true" style="color: '.esc_attr($text_color).';" ';
}


$scibble_stroke = '8';
switch($scribble_thickness) {
	case 'thin':
		$scibble_stroke = ( in_array($scribble_shape, array('sketch-underline')) ) ? '3' : '8';
		break;
	case 'regular':
		$scibble_stroke = ( in_array($scribble_shape, array('sketch-underline')) ) ? '5' : '14';
		break;
	case 'thick':
		$scibble_stroke = ( in_array($scribble_shape, array('sketch-underline')) ) ? '8' : '20';
		break;
}


$scribbles = array(
	'circle' => '<svg class="nectar-scribble circle" viewBox="0 0 800 350" preserveAspectRatio="none"><path style="animation-duration: '.esc_attr($scribble_speed).';" transform="matrix(0.9791300296783447,0,0,0.9791300296783447,400,179)" stroke-linejoin="miter" fill-opacity="0" pathLength="1" stroke-miterlimit="4" stroke="'.esc_attr($scribble_color).'" stroke-opacity="1" stroke-width="'.esc_attr($scibble_stroke).'" d=" M253,-161 C253,-161 -284.78900146484375,-201.4600067138672 -376,-21 C-469,163 67.62300109863281,174.2100067138672 256,121 C564,34 250.82899475097656,-141.6929931640625 19.10700035095215,-116.93599700927734"></path></svg>',
	'sketch-underline' => '<svg class="nectar-scribble sketch-underline" viewBox="-158.17 -22.0172 289.2 53.8" preserveAspectRatio="none"><path style="animation-duration: '.esc_attr($scribble_speed).';" d="M -153.17 20.736 C -153.17 20.736 -135 -1 -118 -1 C -99 -1 -136.093 33.632 -117 26 C -105 18 -80 5 -74 1 C -51 -10 -63 9 -58.375 20.387 C -54.89 29.449 -26 3 -9 -1 C 14 -8 -17.599 24.918 1.917 22.827 C 21.434 20.735 37 3 49 0 C 62 -3 55.24 32.585 75 23 C 95 12 95 -1 114 -2" stroke="'.esc_attr($scribble_color).'" pathLength="1" stroke-width="'.esc_attr($scibble_stroke).'" fill="none"/></svg>',
	'basic-underline' => '<svg class="nectar-scribble basic-underline" viewBox="-400 -55 730 60" preserveAspectRatio="none"><path style="animation-duration: '.esc_attr($scribble_speed).';" d="m -383.25 -6 c 55.25 -22 130.75 -33.5 293.25 -38 c 54.5 -0.5 195 -2.5 401 15" stroke="'.esc_attr($scribble_color).'" pathLength="1" stroke-width="'.esc_attr($scibble_stroke).'" fill="none"/></svg>',
	'squiggle-underline' => '<svg class="nectar-scribble squiggle-underline" viewBox="-347 -30.1947 694 96.19" preserveAspectRatio="none"><path style="animation-duration: '.esc_attr($scribble_speed).';" d="M-335,54 C-335,54 -171,-58 -194,-3 C-217,52 -224.1199951171875,73.552001953125 -127,11 C-68,-27 -137,50 -33,42 C31.43899917602539,37.042999267578125 147.14700317382812,-29.308000564575195 335,2" stroke="'.esc_attr($scribble_color).'" pathLength="1" stroke-width="'.esc_attr($scibble_stroke).'" fill="none"/></svg>',
	'squiggle-underline-2' => '<svg class="nectar-scribble squiggle-underline-2" viewBox="-320 -70.8161 640.4 59.82" preserveAspectRatio="none"><path style="animation-duration: '.esc_attr($scribble_speed).';" d="M-300,-56 C-50,-72 298,-65 300,-59 C332,-53 -239,-36 -255,-27 C-271,-18 -88,-24 91,-20" stroke="'.esc_attr($scribble_color).'" pathLength="1" stroke-width="'.esc_attr(intval($scibble_stroke)/1.8).'" fill="none"/></svg>'
);

if( 'scribble' === $style ) {
	$content = str_replace("</em>", $scribbles[$scribble_shape] . '</em>', $content);
	if( 'true' === $scribble_text_highlight ) {
		$content = str_replace("<em>", '<em style="color: '.esc_attr($scribble_color).';">', $content);
	}
}


echo '<div class="nectar-highlighted-text'.esc_attr($dynamic_el_styles).'" data-style="'.esc_attr($style).'" '.$style_specific_attrs_escaped.'data-using-custom-color="'.esc_attr($using_custom_color).'" data-animation-delay="'.esc_attr($delay).'" data-color="'.esc_attr($highlight_color).'" data-color-gradient="'.esc_attr($secondary_color).'" style="">'.$content.'</div>';