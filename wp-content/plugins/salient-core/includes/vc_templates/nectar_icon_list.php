<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-icon-list' );

extract(shortcode_atts(array(
  "columns" => "", 
  "direction" => 'vertical', 
  "columns" => '3', "animate" => "", 
  "color" => 'default', 
  'icon_size' => '', 
  'icon_style' => 'border'), $atts));

$GLOBALS['nectar-list-item-count']      = 1;
$GLOBALS['nectar-list-item-icon-color'] = esc_attr($color);
$GLOBALS['nectar-list-item-icon-style'] = esc_attr($icon_style);

echo '<div class="nectar-icon-list" data-icon-color="'.esc_attr(strtolower($color)).'" data-icon-style="'.esc_attr($icon_style).'" data-columns="'.esc_attr($columns).'" data-direction="'.esc_attr($direction).'" data-icon-size="'.esc_attr($icon_size).'" data-animate="'.esc_attr($animate).'">'.do_shortcode($content).'</div>';

?>