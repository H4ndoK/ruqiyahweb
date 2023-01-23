<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
  "line" => 'false', 
  "custom_height" => '25', 
	"custom_height_tablet" => '', 
	"custom_height_phone" => '', 
  "line_type" => 'No Line', 
  "line_alignment" => 'default', 
  'line_thickness' => '1', 
  'custom_line_width' => '20%', 
  'divider_color' => 'default', 
  'divider_opacity' => '100',
  'animate' => '', 
  'delay' => ''), $atts));
  

	// Calculate height.
	if( strpos($custom_height,'vw') !== false ) {
		$calculated_height      = intval($custom_height) . 'vw';
		$calculated_height_half = intval($custom_height)/2 . 'vw';
	} else if( strpos($custom_height,'vh') !== false ) {
		$calculated_height      = intval($custom_height) . 'vh';
		$calculated_height_half = intval($custom_height)/2 . 'vh';
	}
	else if( strpos($custom_height,'%') !== false ) {
		$calculated_height      = intval($custom_height) . '%';
		$calculated_height_half = intval($custom_height)/2 . '%';
	}
	else {
		$calculated_height      = intval($custom_height) . 'px';
		$calculated_height_half = intval($custom_height)/2 . 'px';
	}
	
  if ($line_type === 'Small Thick Line' || $line_type === 'Small Line' ) {
    $height  = (!empty($custom_height)) ? 'style="margin-top: '.esc_attr($calculated_height_half).'; width: '.esc_attr($custom_line_width).'px; height: '.esc_attr($line_thickness).'px; margin-bottom: '.esc_attr($calculated_height_half).';"' : null;
    $divider = '<div '.$height.' data-width="'.esc_attr($custom_line_width).'" data-animate="'.esc_attr($animate).'" data-animation-delay="'.esc_attr($delay).'" data-color="'.esc_attr($divider_color).'" class="divider-small-border"></div>';
  } 
  else if ($line_type === 'Full Width Line' ) {
    $height  = (!empty($custom_height)) ? 'style="margin-top: '.esc_attr($calculated_height_half).'; height: '.esc_attr($line_thickness).'px; margin-bottom: '.esc_attr($calculated_height_half).';"' : null;
    $divider = '<div '.$height.' data-width="100%" data-animate="'.esc_attr($animate).'" data-animation-delay="'.esc_attr($delay).'" data-color="'.esc_attr($divider_color).'" class="divider-border"></div>';
  } 
  else if ($line_type === 'Vertical Line' ) {
    $height  = (!empty($custom_height)) ? 'style="padding-top: '.esc_attr($calculated_height_half).'; padding-bottom: '.esc_attr($calculated_height_half).';"' : null;
    $divider = '<div '.$height.'  class="divider-vertical nectar-bg-'.esc_attr($divider_color).'"></div>';
  } 
  else {
    $height  = (!empty($custom_height)) ? 'style="height: '.esc_attr($calculated_height).';"' : null;
    $divider = '<div '.$height.' class="divider"></div>';
  }
  // old option
  if ($line === 'true') {
    $divider = '<div class="divider-border"></div>';
  }
	
	// Dynamic style classes.
	if( function_exists('nectar_el_dynamic_classnames') ) {
		$dynamic_el_styles = nectar_el_dynamic_classnames('divider', $atts);
	} else {
		$dynamic_el_styles = '';
	}

  // Opacity.
  $styles = '';
  if( !empty($divider_opacity) && $divider_opacity != '100' ) {
    $styles .= 'opacity: ' . (floatval($divider_opacity)/100) . ';';
  }
  if( !empty($styles) ) {
    $styles = ' style="' . $styles . '"';
  }
  
	
  echo '<div class="divider-wrap'.esc_attr($dynamic_el_styles).'"'.$styles.' data-alignment="' . esc_attr($line_alignment) . '">'.$divider.'</div>';

?>