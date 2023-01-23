<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-scrolling-text' );

extract(shortcode_atts(array(
  'style' => 'default',
  'scroll_direction' => 'left',
  'scroll_speed' => 'slow',
	'outline_thickness' => 'thin',
	'text_color' => '',
  'custom_font_size' => '',
  'custom_font_size_mobile' => '',
  'background_image_url' => '',
  'background_image_height' => '30vh',
  'background_image_animation' => 'none',
  'separate_text_coloring' => '',
  'text_color_front' => '#fff',
	'text_repeat_number' => '3',
	'text_repeat_divider' => 'none',
	'text_repeat_divider_custom' => '',
	'text_repeat_divider_scale' => 'full',
	'overflow' => 'hidden'
), $atts));


// Divider.
$divider_spacing = 'false';

// Handle multiple headings.
$has_multiple_tags = '';
$tag_pattern = "/<h[1-6]>.*?<\/h[1-6]>/"; 
$tag_count = preg_match_all($tag_pattern, $content);
if($tag_count > 1) {
  $has_multiple_tags = ' has-multiple-items';
}
$content = '<div class="nectar-scrolling-text-inner__text-chunk'.$has_multiple_tags.'">'.$content.'</div>';

// Space or element between items.
if( 'space' === $text_repeat_divider ) {
	$divider_spacing = 'true';
} else if( 'custom' === $text_repeat_divider ) {
	$content = preg_replace('/(<\/h[1-6]>)/','<span class="custom" data-scale="'.esc_attr($text_repeat_divider_scale).'">'.esc_html($text_repeat_divider_custom).'</span>${1}',$content);
} else {
	$content = preg_replace('/(<\/h[1-6]>)/','<span>&nbsp;</span>${1}',$content);
}

$inner_content = '';
$text_repeat_number_int = intval($text_repeat_number);

// Text Repeats.
for( $i = 0; $i < $text_repeat_number_int; $i++ ) {
	$inner_content .= $content;
}

// Background Layer.
$background_markup = false;
$background_style = 'style="';

if( !empty($background_image_url) ) {
	
  // Image.
	if( !preg_match('/^\d+$/',$background_image_url) ) {   
	   $background_style .= 'height:'.esc_attr($background_image_height).'; background-image: url('.esc_url($background_image_url) . ');';
  } else {
    
		$bg_image_src = wp_get_attachment_image_src($background_image_url, 'full');
		$background_style .= 'height:'.esc_attr($background_image_height).'; background-image: url(\''.esc_url($bg_image_src[0]).'\'); ';
	}
  
  
  if( 'true' === $separate_text_coloring ) {
    $front_text_later = '<div class="nectar-scrolling-text-inner" style="color:'.esc_attr($text_color_front).'">'.$inner_content.'</div>';
  }

  
  $background_style .= '"';
  
  $background_markup = '<div class="background-layer row-bg-wrap" data-bg-animation="'.esc_attr($background_image_animation).'"><div class="inner row-bg"><div class="background-image" '.$background_style.'></div></div>'.$front_text_later.'</div>';
	
}

// Dynamic style classes.
if( function_exists('nectar_el_dynamic_classnames') ) {
	$dynamic_el_styles = nectar_el_dynamic_classnames('nectar_scrolling_text', $atts);
} else {
	$dynamic_el_styles = '';
}

$style_markup = null;
if( !empty($text_color) ) {
  $style_markup = ' style="color: '.esc_attr($text_color).';"';
} 

$data_attrs_escaped = 'data-style="'.esc_attr($style).'" ';
$data_attrs_escaped .= 'data-s-dir="'.esc_attr($scroll_direction).'" ';
$data_attrs_escaped .= 'data-spacing="'.esc_attr($divider_spacing).'" ';
$data_attrs_escaped .= 'data-outline-thickness="'.esc_attr($outline_thickness).'" ';
$data_attrs_escaped .= 'data-s-speed="'.esc_attr($scroll_speed).'" ';
$data_attrs_escaped .= 'data-overflow="'.esc_attr($overflow).'" ';

if( false !== $background_markup) {
  $data_attrs_escaped .= 'data-sep-text="'.esc_attr($separate_text_coloring).'" ';
  $data_attrs_escaped .= 'data-using-bg="true"';
}

echo '<div class="nectar-scrolling-text'.$dynamic_el_styles.'" '.$data_attrs_escaped.'>'.$background_markup.'<div class="nectar-scrolling-text-inner"'.$style_markup.'>' . do_shortcode($inner_content) . '</div></div>';

?>