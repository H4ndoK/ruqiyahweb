<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-testimonial' );

extract(shortcode_atts(array(
	'testimonial_style' => 'small_modern',
  'quote' => '',
  'image' => '',
  'name' => '',
  'subtitle' => '',
  'color' => '',
	'text_color' => '',
	'add_image_shadow' => ''
), $atts));

$bg_markup_escaped = null;
$image_icon_markup_escaped = null;

if( !empty($image) ) {

	if( preg_match('/^\d+$/',$image) ){
		$image_src = wp_get_attachment_image_src($image, 'medium');

		if(isset($image_src[0])) {
				$image = $image_src[0];
		}

	}

	$bg_markup_escaped = 'style="background-image: url('.esc_url($image).');"';

  $image_icon_markup_escaped = '<div data-shadow="' . esc_attr($add_image_shadow) . '" class="image-icon " '.$bg_markup_escaped.'></div>';

}

$open_quote  = ($testimonial_style == 'basic') ? '&#8220;' : null;
$close_quote = ($testimonial_style == 'basic') ? '&#8221;' : null;

if($testimonial_style !== 'basic' && $testimonial_style !== 'basic_left_image') {
	$open_quote = '<span class="open-quote">&#8221;</span>';
}

$text_color_style_escaped = '';
if( !empty($text_color) ) {
	$text_color_style_escaped = 'data-custom-color="true" style="color: '.esc_attr($text_color).';"';
}

$bottom_content_escaped = '';

if( !empty($name) || !empty($subtitle) ) {

	$bottom_content_escaped .= '<span class="wrap">';
	if( !empty($name) ) {
		$bottom_content_escaped .= '<span>'.wp_kses_post($name).'</span>';
	}
	if( !empty($subtitle) ) {
		$bottom_content_escaped .= '<span class="title">'.wp_kses_post($subtitle).'</span>';
	}
	$bottom_content_escaped .= '</span>';

}

echo '<blockquote class="nectar_single_testimonial" data-color="'.esc_attr(strtolower($color)).'" data-style="'.esc_attr($testimonial_style).'">';
echo '<div class="inner"'.$text_color_style_escaped.'>';
echo ' <p>'. $open_quote . wp_kses_post($quote) . $close_quote.' </p>'. $image_icon_markup_escaped .$bottom_content_escaped;
echo '</div></blockquote>';

?>
