<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-page-submenu' );

extract(shortcode_atts(array(
  "alignment" => "center", 
  "sticky" => "false", 
  "bg_color" => '#ffffff', 
  "link_color" => '#000000'), $atts));

global $nectar_options;

$wrapping_class = ( $alignment !== 'center' ) ?  'full-width-section' : 'full-width-content';

echo '<div class="page-submenu" data-bg-color="'.esc_attr($bg_color).'" data-sticky="'.esc_attr($sticky).'" data-alignment="'.esc_attr($alignment).'"><div class="'.$wrapping_class.'" style="background-color:'.esc_attr($bg_color).'; color: '.esc_attr($link_color).';">';
if($wrapping_class === 'full-width-section') {
  echo '<div class="container">';
}
echo '<a href="#" class="mobile-menu-link"><i class="salient-page-submenu-icon"></i>'. esc_html__('Menu','salient') .'</a><ul style="background-color:'.esc_attr($bg_color).'; color: '.esc_attr($link_color).';">'.do_shortcode($content).'</ul>';
if($wrapping_class === 'full-width-section') {
  echo '</div>';
}
echo'</div></div>';



?>