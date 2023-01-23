<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
  'text' => '', 
  'color' => 'accent-color',
  'display_tag' => 'body',
  'display' => 'block',
  'bg_color_custom' => '',
  'bg_color_type' => '',
  'text_color' => '',
  'padding' => '',
  'border_radius' => '',
  'margin_top' => '',
  'margin_left' => '',
  'margin_right' => '',
  'margin_bottom' => ''
), $atts));

$classes = array('nectar-badge');
$classes[] = 'nectar-inherit-'.esc_attr($display_tag);
$classes[] = 'nectar-display-'.esc_attr($display);

// Dynamic style classes.
if( function_exists('nectar_el_dynamic_classnames') ) {
    $classes[] = nectar_el_dynamic_classnames('nectar_badge', $atts);
} 

$inner_classes = array('nectar-badge__inner');

if( 'global' === $bg_color_type ) {
    $inner_classes[] = 'nectar-bg-'.esc_attr($color);
}

// Margins.
$margins = '';

if( !empty($margin_top) ) {
  $margins .= 'margin-top: '.intval($margin_top).'px; ';
}
if( !empty($margin_right) ) {
  $margins .= 'margin-right: '.intval($margin_right).'px; ';
}
if( !empty($margin_bottom) || '0' === $margin_bottom ) {
  $margins .= 'margin-bottom: '.intval($margin_bottom).'px; ';
}
if( !empty($margin_left) ) {
  $margins .= 'margin-left: '.intval($margin_left).'px;';
}

$el_atts = '';

if( 'custom' === $bg_color_type ) {
  $el_atts .= ' data-bg-color-custom="'.$bg_color_custom.'"';
}

$el_style = '';
if(!empty($margins)) {
    $el_style = ' style="'.$margins.'"';
}

echo '<div class="'.nectar_clean_classnames(implode(' ',$classes)).'"'.$el_style . $el_atts.'><div class="'.nectar_clean_classnames(implode(' ',$inner_classes)).'">' . $text . '</div></div>';
