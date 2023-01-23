<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"title" => 'Title',
	'heading_tag' => 'default',
	'heading_tag_functionality' => 'default',
	'color' => 'Accent-Color'), 
	$atts));

$typography_class = ( in_array($heading_tag, array('h2','h3','h4','h5','h6')) ) ? 'nectar-inherit-'.$heading_tag.' toggle-heading' : 'toggle-heading';

$heading_tag_html = 'h3';
if( 'change_html_tag' === $heading_tag_functionality && 
	in_array($heading_tag, array('h2','h3','h4','h5','h6','span')) ) {
		$heading_tag_html = $heading_tag;
}

echo '<div class="toggle '.esc_attr(strtolower($color)).'" data-inner-wrap="true">';
echo '<'.$heading_tag_html.' class="toggle-title">';
echo '<a href="#" class="'.$typography_class.'"><i class="fa fa-plus-circle"></i>'. wp_kses_post($title) .'</a>';
echo '</'.$heading_tag_html.'>';
echo '<div><div class="inner-toggle-wrap">' . do_shortcode($content) . '</div></div>';
echo '</div>';

?>
