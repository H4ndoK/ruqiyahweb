<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	extract(shortcode_atts(array(
		"title"=>'Column title', 
		"highlight" => 'false', 
		"highlight_reason" => 'Most Popular', 
		'color' => 'Accent-Color', 
		"price" => "99", 
		"currency_symbol" => '$', 
		"interval" => 'Per Month'), $atts));
	
	$highlight_class        = null;
	$hightlight_reason_html = null;
	
	if( $highlight === 'true' ) {
		$highlight_class = 'highlight ' . esc_attr(strtolower($color)); 
		$hightlight_reason_html = '<span class="highlight-reason">'.wp_kses_post($highlight_reason).'</span>';
	} else {
		$highlight_class = 'no-highlight ' . esc_attr(strtolower($color)); 
	}
	
  echo'<div class="pricing-column '.$highlight_class.'">
			<h3>'.wp_kses_post($title). wp_kses_post($hightlight_reason_html) .'</h3>
          <div class="pricing-column-content">
			<h4> <span class="dollar-sign">'.wp_kses_post($currency_symbol).'</span> '.wp_kses_post($price).' </h4>
			<span class="interval">'.wp_kses_post($interval).'</span>' . do_shortcode($content) . '</div></div>';

?>