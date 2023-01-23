<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
  "title" => "", 
  "link_url" => "#", 
  "link_new_tab" => 'false'), $atts));

$new_tab_markup = ($link_new_tab === 'true') ? 'target="_blank"' : null;

echo '<li><a '.$new_tab_markup.' href="'.esc_url($link_url).'">'.wp_kses_post($title).'</a></li>';

?>