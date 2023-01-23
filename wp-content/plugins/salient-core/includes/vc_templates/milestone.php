<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-milestone' );

extract(shortcode_atts(array(
  "subject" => '', 
  'symbol' => '', 
  'milestone_alignment' => 'default', 
  'heading_inherit' => 'default', 
  'symbol_position' => 'after', 
  'subject_padding' => '0%',
  'symbol_alignment' => 'default', 
  'number_font_size' => '62', 
  'symbol_font_size' => '62', 
  'effect' => 'count', 
  'effect_delay' => '',
  'number' => '0', 
  'color' => 'Default'), $atts));
  
  if(!empty($symbol)) {
    $symbol_markup_escaped = 'data-symbol="'.esc_attr($symbol).'" data-symbol-alignment="'.strtolower(esc_attr($symbol_alignment)).'" data-symbol-pos="'.esc_attr($symbol_position).'" data-symbol-size="'.esc_attr($symbol_font_size).'"';
  } else {
    $symbol_markup_escaped = null;
  }
  
  $motion_blur          = null;
  $milestone_wrap       = null;
  $milestone_wrap_close = null;
  $span_open            = null;
  $span_close           = null;
  
  if( $effect === 'motion_blur' ) {
    $motion_blur    = 'motion_blur';
    $milestone_wrap = true;
    $milestone_wrap_close = true;
  } else {
    $span_open  = '<span>';
    $span_close = '</span>';
  }
  
  
  if( $heading_inherit !== 'default' ) {
    $milestone_h_open = '<'.esc_html($heading_inherit).'>';
    $milestone_h_close = '</'.esc_html($heading_inherit).'>';
  } else {
    $milestone_h_open = null;
    $milestone_h_close = null;
  }
  
  $subject_padding_html_escaped = (!empty($subject_padding) && $subject_padding !== '0%') ? 'style="padding: '.esc_attr($subject_padding).';"' : null;
  
  $number_markup_escaped  = '<div class="number '.esc_attr(strtolower($color)).'" data-number-size="'.esc_attr($number_font_size).'">'.$milestone_h_open . $span_open . wp_kses_post($number) . $span_close . $milestone_h_close.'</div>';
  $subject_markup_escaped = '<div class="subject" '.$subject_padding_html_escaped.'>'. wp_kses_post($subject) .'</div>';
  
  if( $milestone_wrap === true ) {
    echo '<div class="milestone-wrap">';
  }
  echo '<div class="nectar-milestone '. $motion_blur . '" '. $symbol_markup_escaped.' data-animation-delay="'.esc_attr($effect_delay).'" data-ms-align="'.esc_attr($milestone_alignment).'" > '.$number_markup_escaped.' '.$subject_markup_escaped.' </div>';
  if( $milestone_wrap_close ) {
    echo '</div>';
  }
  
  ?>