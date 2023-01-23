<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = $el_class = $value = $label_value = $units = '';

extract(shortcode_atts(array(
  'animation_type' => 'default',
  'line_reveal_by_space_text_effect' => 'default',
	'text_content' => '',
	'font_style' => 'h1',
	'animation_delay' => '0',
	'max_width' => '',
  'text_color' => '',
  'font_size' => '',
	'stagger_animation' => '',
  'animation_offset' => '',
	'mobile_disable_animation' => '',
  'link_href' => '',
  'link_target' => '_self',
  'link_indicator' => '',
  'link_indicator_bg_color' => '#000',
  'link_indicator_icon_color' => '#fff',
	'content_alignment' => 'default',
	'mobile_content_alignment' => 'inherit'
), $atts));

$array = preg_split("/\r\n|\n|\r/", $content);
$heading_lines = array_filter($array);

$style_markup_escaped = null;
$font_style_markup_escaped = null;
$custom_font_size = 'false';

if(!empty($max_width) || !empty($text_color)) {

  $style_markup_escaped = 'style="';

  if( !empty($max_width) ) {
		
		if( strpos($max_width,'vh') !== false ) {
			$style_markup_escaped .= 'max-width: '. intval($max_width) .'vh;';
		} 
		else if( strpos($max_width,'vw') !== false ) {
			$style_markup_escaped .= 'max-width: '. intval($max_width) .'vw;';
		} 
		else if( strpos($max_width,'%') !== false ) {
			$style_markup_escaped .= 'max-width: '. intval($max_width) .'%;';
		} 
		else {
			$style_markup_escaped .= 'max-width: '. intval($max_width) .'px;';
		}

  }
  if( !empty($text_color) ) {
    $style_markup_escaped .= ' color: '. esc_attr($text_color) .';';
  }

  $style_markup_escaped .= '"';
}


if( !empty($font_size)) {

  if( strpos($font_size,'vw') !== false  ) {
    $font_style_markup_escaped .= 'style="font-size: '. esc_attr(floatval($font_size)) .'vw; line-height: '. esc_attr(floatval($font_size)*1.1) .'vw;"';
  } else if( strpos($font_size,'vh') !== false  ) {
    $font_style_markup_escaped .= 'style="font-size: '. esc_attr(floatval($font_size)) .'vh; line-height: '. esc_attr(floatval($font_size)*1.1) .'vh;"';
  } else {
		$multi = 1.08;
		if( 'p' === $font_style ) {
			$multi = 1.5;
		} 
    $font_style_markup_escaped .= 'style="font-size: '. esc_attr(intval($font_size)) .'px; line-height: '.esc_attr(intval($font_size)*$multi).'px;"';
  }
  $custom_font_size = 'true';

}


// Dynamic style classes.
$el_classnames = array('nectar-split-heading');

if( function_exists('nectar_el_dynamic_classnames') ) {
	$el_classnames[] = nectar_el_dynamic_classnames('split_line_heading', $atts);
} 

if( !empty($link_href) ) {
  $link_indicator_attrs = '';
  if( $link_indicator ) {
    $link_indicator_attrs = ' data-nectar-link-indicator="'.esc_attr($link_indicator).'" data-indicator-bg="'.esc_attr($link_indicator_bg_color).'" data-indicator-icon="'.esc_attr($link_indicator_icon_color).'"';
  }
  echo '<a href="'.esc_url($link_href).'" target="'.esc_attr($link_target).'"'.$link_indicator_attrs.'>';
}

echo '<div class="'. esc_attr(implode(' ', $el_classnames)).'" data-align="'.esc_attr($content_alignment).'" data-m-align="'.esc_attr($mobile_content_alignment).'" data-text-effect="'.esc_attr($line_reveal_by_space_text_effect).'" data-animation-type="'.esc_attr($animation_type).'" data-animation-delay="'.esc_attr($animation_delay).'" data-animation-offset="'.esc_attr($animation_offset).'" data-m-rm-animation="'.esc_attr($mobile_disable_animation).'" data-stagger="'.esc_attr($stagger_animation).'" data-custom-font-size="'.esc_attr($custom_font_size).'" '.$font_style_markup_escaped.'>';

if( 'default' === $animation_type ) {
	foreach($heading_lines as $k => $v) {
		echo '<div class="heading-line" '. $style_markup_escaped .'> <div>' . do_shortcode($v) . ' </div> </div>';
	}
} else if( 'line-reveal-by-space' === $animation_type || 
      'letter-fade-reveal' === $animation_type || 
      'twist-in' === $animation_type  ) {

      echo '<'.esc_html($font_style).' '. $style_markup_escaped .'>'.do_shortcode($text_content).'</'.esc_html($font_style).'>';

}

echo '</div>';

if( !empty($link_href) ) {
  echo '</a>';
}
