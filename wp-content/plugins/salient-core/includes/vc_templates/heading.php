<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
  "title" => 'Title', 
  "subtitle" => 'Subtitle'), $atts));

$subtitle_holder = null;

if( $subtitle !== 'Subtitle' ) {
  $subtitle_holder = '<p>'. wp_kses_post($subtitle) .'</p>';
}
echo '<div class="col span_12 section-title text-align-center extra-padding"><h2>'. wp_kses_post($content) .'</h2>'. $subtitle_holder .'</div><div class="clear"></div>';

?>