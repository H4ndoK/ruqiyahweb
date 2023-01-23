<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-testimonial' );

extract(shortcode_atts(array(
  "autorotate"=> '', 
  "disable_height_animation" => '',
  'style' => 'default', 
  'color' => '', 
  'star_rating_color' => 'accent-color', 
  'slider_controls' => 'default',
  'enable_shadow' => '',
  'custom_box_shadow' => '',
  'add_border' => ''), $atts));

if( ! defined( 'NECTAR_THEME_NAME' ) ) {
  $style = 'default';
}


$height_animation_class = '';

if( $disable_height_animation === 'true' ) { 
  $height_animation_class = ' disable-height-animation'; 
}

$GLOBALS['nectar-testimonial-slider-style'] = $style;

$flickity_markup_opening = ($style == 'multiple_visible' || $style == 'multiple_visible_minimal') ? '<div class="flickity-viewport"> <div class="flickity-slider">' : '';
$flickity_markup_closing = ($style == 'multiple_visible' || $style == 'multiple_visible_minimal') ? '</div></div>' : '';

// Dynamic style classes.
$el_classnames = array('testimonial_slider','span_12','col');

if( function_exists('nectar_el_dynamic_classnames') ) {
	$el_classnames[] = nectar_el_dynamic_classnames('testimonial_slider', $atts);
} 

$attributes = '';
$attributes .= 'data-color="'.esc_attr($color).'" ';  
$attributes .= 'data-rating-color="'.esc_attr($star_rating_color).'" '; 
$attributes .= 'data-controls="'.esc_attr($slider_controls).'" '; 
$attributes .= 'data-add-border="'.esc_attr($add_border).'" ';
$attributes .= 'data-autorotate="'.esc_attr($autorotate).'" '; 
$attributes .= 'data-style="'.esc_attr($style).'" ';

if( 'multiple_visible' === $style && 'true' === $enable_shadow ) {
  $attributes .= 'data-shadow="'.esc_attr(nectar_generate_shadow_css($atts)).'"';
}

echo '<div class="'. nectar_clean_classnames(implode(' ', $el_classnames)) . $height_animation_class.'" '.$attributes.'><div class="slides">'.$flickity_markup_opening.do_shortcode($content).$flickity_markup_closing.'</div></div>';

?>