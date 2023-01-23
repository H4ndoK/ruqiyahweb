<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
  "heading_tag" => "h3", 
  'text' => '',
  "btn_style" => "see-through", 
  'margin_top' => '',
  'margin_right' => '',
  'margin_bottom' => '', 
  'margin_left' => '', 
  'padding_top' => '',
  'padding_right' => '',
  'padding_bottom' => '', 
  'padding_left' => '', 
  'button_color' => '',
	'button_color_hover' => '',
  'btn_type' => '', 
  "link_text" => "", 
  'text_color' => '', 
  'next_section_color' => '',
  'next_section_shadow' => '',
  'next_section_down_arrow_animation' => '',
  'display' => 'block',
  'url' => '', 
  'link_type' => 'regular', 
  'alignment' => 'left', 
	'nofollow' => '',
  'icon_family' => '', 
	'icon_fontawesome' => '', 
	'icon_linecons' => '', 
	'icon_iconsmind' => '', 
	'icon_steadysets' => '', 
  'class' => '' ), $atts));

$target                 = ($link_type == 'new_tab') ? 'target="_blank"' : null;
$style                  = (!empty($text_color)) ? ' style="color: '.$text_color.';"' : '';
$bg_style               = (!empty($text_color)) ? ' style="background-color: '.$text_color.';"' : null;
$underline_border_color = $text_color;
$text_color             = (!empty($text_color)) ? 'custom' : 'std';
$nofollow_attr          = (!empty($nofollow) && 'true' === $nofollow) ? ' rel="nofollow"': '';

if( 'span' === $heading_tag ) {
	$style .= ' class="nectar-button-type"';
}

// Dynamic style classes.
if( function_exists('nectar_el_dynamic_classnames') ) {
	$dynamic_el_styles = nectar_el_dynamic_classnames('nectar_cta', $atts);
} else {
	$dynamic_el_styles = '';
}

// Margins.
$margins = '';

if( !empty($margin_top) ) {
  $margins .= 'margin-top: '.nectar_css_sizing_units($margin_top).'; ';
}
if( !empty($margin_right) ) {
  $margins .= 'margin-right: '.nectar_css_sizing_units($margin_right).'; ';
}
if( !empty($margin_bottom) ) {
  $margins .= 'margin-bottom: '.nectar_css_sizing_units($margin_bottom).'; ';
}
if( !empty($margin_left) ) {
  $margins .= 'margin-left: '.nectar_css_sizing_units($margin_left).';';
}

// Padding.
$padding = '';

if( !empty($padding_top) ) {
  $padding .= 'padding-top: '.nectar_css_sizing_units($padding_top).'; ';
}
if( !empty($padding_right) ) {
  $padding .= 'padding-right: '.nectar_css_sizing_units($padding_right).'; ';
}
if( !empty($padding_bottom) ) {
  $padding .= 'padding-bottom: '.nectar_css_sizing_units($padding_bottom).'; ';
}
if( !empty($padding_left) ) {
  $padding .= 'padding-left: '.nectar_css_sizing_units($padding_left).';';
}

$using_bg_color = ( !empty($button_color) && 'default' !== $button_color ) ? 'true' : 'false';

$style_markup = null;
$style_padding_markup = null;

if( !empty($margins) ) {
  $style_markup = 'style="'.$margins.'"';
} 
if( !empty($padding) ) {
  $style_padding_markup = 'style="'.$padding.'"';
} 

// Lightbox
$link_text_classes = '';
if( 'video_lightbox' === $link_type ) {
 $link_text_classes = ' pp nectar_video_lightbox';
} else if ( 'image_lightbox' === $link_type ) {
 $link_text_classes = ' pp';	
}

// icon.
$icon_output = nectar_icon_el_output($atts);

// Material style.
if( $btn_style === 'material' ) {
  
  echo '<div class="nectar-cta '. esc_attr( $class ).esc_attr($dynamic_el_styles).'" data-style="'.esc_attr($btn_style).'" data-alignment="'.esc_attr($alignment).'" data-display="'. esc_attr($display) .'" data-text-color="'.esc_attr($text_color).'" '.$style_markup.'>';
  echo '<'.esc_html($heading_tag).'> <span class="text">'.wp_kses_post($text).' </span>';
  echo  '<span class="link_wrap" '.$style.'><a '.$target . $nofollow_attr .' class="link_text'.esc_attr($link_text_classes).'" href="'.esc_url($url).'">'.wp_kses_post($link_text).'<span class="circle" '.$bg_style.'></span><span class="arrow"></span></a></span>'; 
  echo '</'.esc_html($heading_tag).'></div>';
} 
// See through.
else if( $btn_style === 'see-through' ) {
  echo '<div class="nectar-cta '.$class . esc_attr($dynamic_el_styles).'" data-color="'. esc_attr($button_color) .'" data-using-bg="'.esc_attr($using_bg_color).'" data-style="'.esc_attr($btn_style).'" data-display="'. esc_attr($display) .'" data-alignment="'.esc_attr($alignment).'" data-text-color="'.esc_attr($text_color).'" '.$style_markup.'>';
  echo '<'.esc_html($heading_tag). $style.'> <span class="text">'.wp_kses_post($text).' </span>';
  echo  '<span class="link_wrap" '.$style_padding_markup.'><a '.$target . $nofollow_attr .' class="link_text'.esc_attr($link_text_classes).'" href="'.esc_url($url).'">'.wp_kses_post($link_text).'<span class="arrow"></span></a></span>'; 
  echo '</'.esc_html($heading_tag).'></div>';
} 
// Arrow Animation.
else if( $btn_style === 'arrow-animation' ) {
  echo '<div class="nectar-cta '.$class .esc_attr($dynamic_el_styles) .'" data-color="'. esc_attr($button_color) .'" data-using-bg="'.esc_attr($using_bg_color).'" data-style="'.esc_attr($btn_style).'" data-display="'. esc_attr($display) .'" data-alignment="'.esc_attr($alignment).'" data-text-color="'.esc_attr($text_color).'" '.$style_markup.'>';
  echo '<'.esc_html($heading_tag). $style.'>';
  echo  '<span class="link_wrap" '.$style_padding_markup.'><a '.$target . $nofollow_attr .' class="link_text'.esc_attr($link_text_classes).'" href="'.esc_url($url).'"><span class="text">'.wp_kses_post($link_text) .'</span>'; 
  echo '<svg class="next-arrow" aria-hidden="true" width="20px" height="25px" viewBox="0 0 50 80" xml:space="preserve">
  <polyline stroke="#ffffff" stroke-width="9" fill="none" stroke-linecap="round" stroke-linejoin="round" points="0, 0 45, 40 0, 80"/>
  </svg>  ';
  echo '<span class="line" '.$bg_style.'></span> </a></span>';
  echo '</'.esc_html($heading_tag).'></div>';
} 
else if( $btn_style === 'basic' || $btn_style === 'text-reveal-wave' ) {

  if( $btn_style === 'text-reveal-wave' ) {
    $link_text = preg_replace("/([^\\s>])(?!(?:[^<>]*)?>)/u","<span class=\"char\">$1</span>",$link_text);
  }

	echo '<div class="nectar-cta '.$class .esc_attr($dynamic_el_styles) .'" data-color="'. esc_attr($button_color) .'" data-using-bg="'.esc_attr($using_bg_color).'" data-style="'.esc_attr($btn_style).'" data-display="'. esc_attr($display) .'" data-alignment="'.esc_attr($alignment).'" data-text-color="'.esc_attr($text_color).'" '.$style_markup.'>';
  echo '<'.esc_html($heading_tag). $style.'>';
  echo  '<span class="link_wrap" '.$style_padding_markup.'>'.$icon_output.'<a '.$target . $nofollow_attr .' class="link_text'.esc_attr($link_text_classes).'" href="'.esc_url($url).'"><span class="text">'.wp_kses_post($link_text) .'</span>'; 
  echo '</a></span></'.esc_html($heading_tag).'></div>';
}
// Next section link.
else if( $btn_style === 'next-section' ) {
  
  $using_next_section_color = 'false';
  $next_section_color_style = null;
  $next_section_track_ball_color_style = null;
  
  if( !empty($next_section_color) ) {
    $using_next_section_color = 'true';
  }
  
  if( $btn_type === 'down-arrow-bounce' ) {
    
		$dark_arrow_color = '';
		
    if( !empty($next_section_color) ) {
			$dark_arrow_color = ( '#ffffff' === $next_section_color ) ? ' dark-arrow' : '';
      $next_section_color_style = 'style="background-color: '.esc_attr($next_section_color).';"';
    }
    echo '<div class="nectar-next-section-wrap bounce'.esc_attr($dynamic_el_styles).'" '.$style_markup.' data-animation="'.esc_attr($next_section_down_arrow_animation).'" data-shad="'.esc_attr($next_section_shadow).'" data-align="'.esc_attr($alignment).'" data-custom-color="'.esc_attr($using_next_section_color).'"><a href="#" '.$next_section_color_style.' class="nectar-next-section skip-hash"> <i class="fa fa-angle-down'.esc_attr($dark_arrow_color).'"></i> </a></div>';
  } 
  else if( $btn_type === 'down-arrow-bordered' ) {
    
    if( !empty($next_section_color) ) {
      $next_section_color_style = 'style="border-color: '.esc_attr($next_section_color).'; color: '.esc_attr($next_section_color).';"';
    }
    echo '<div class="nectar-next-section-wrap down-arrow-bordered'.esc_attr($dynamic_el_styles).'" '.$style_markup.' data-shad="'.esc_attr($next_section_shadow).'" data-align="'.esc_attr($alignment).'" data-custom-color="'.esc_attr($using_next_section_color).'"><div class="inner" '.$next_section_color_style.'><a href="#" class="nectar-next-section skip-hash"><i class="fa fa-angle-down top"></i><i class="fa fa-angle-down"></i></a></div></div>';
  } 
  else if( $btn_type === 'mouse-wheel' ) {
    if( !empty($next_section_color) ) {
      $stroke_color = $next_section_color;
      $next_section_color_style = 'style="border-color: '.esc_attr($next_section_color).'; color: '.esc_attr($next_section_color).';"';
      $next_section_track_ball_color_style = 'style="background-color: '.esc_attr($next_section_color).';"';
    } else {
      $stroke_color = '#ffffff';
    }
    echo '<div class="nectar-next-section-wrap mouse-wheel'.esc_attr($dynamic_el_styles).'" '.$style_markup.' data-align="'.esc_attr($alignment).'" data-custom-color="'.esc_attr($using_next_section_color).'"><a href="#" '.$next_section_color_style.' class="nectar-next-section skip-hash"><svg class="nectar-scroll-icon" viewBox="0 0 30 45" enable-background="new 0 0 30 45">
          <path class="nectar-scroll-icon-path" fill="none" stroke="'.esc_attr($stroke_color).'" stroke-width="2" stroke-miterlimit="10" d="M15,1.118c12.352,0,13.967,12.88,13.967,12.88v18.76  c0,0-1.514,11.204-13.967,11.204S0.931,32.966,0.931,32.966V14.05C0.931,14.05,2.648,1.118,15,1.118z"></path>
        </svg><span class="track-ball" '.$next_section_track_ball_color_style.'></span></a></div>';
  }
  
  else if ( $btn_type === 'minimal-arrow' ) {
    
    if( !empty($next_section_color) ) {
      $stroke_color = $next_section_color;
    } else {
      $stroke_color = '#ffffff';
    }
    
    echo '<div class="nectar-next-section-wrap minimal-arrow'.esc_attr($dynamic_el_styles).'" '.$style_markup.' data-align="'.esc_attr($alignment).'" data-custom-color="'.esc_attr($using_next_section_color).'">
    <a href="#" class="nectar-next-section skip-hash">
      <svg class="next-arrow" width="40px" height="68px" viewBox="0 0 40 50" xml:space="preserve">
      <path stroke="'.esc_attr($stroke_color).'" stroke-width="2" fill="none" d="M 20 0 L 20 51"></path>
      <polyline stroke="'.esc_attr($stroke_color).'" stroke-width="2" fill="none" points="12, 44 20, 52 28, 44"></polyline>
      </svg>
    </a>
  </div>';
  }
  
} 

// All others.
else {

  $cta_text = (!empty($text)) ? '<span class="text">'.wp_kses_post($text).' </span>' : '';
  echo '<div class="nectar-cta '.esc_attr($class) .esc_attr($dynamic_el_styles) .'" data-color="'. esc_attr($button_color) .'" data-using-bg="'.esc_attr($using_bg_color).'" data-display="'. esc_attr($display) .'" data-style="'.esc_attr($btn_style).'" data-alignment="'.esc_attr($alignment).'" data-text-color="'.esc_attr($text_color).'" '.$style_markup.'>';
  echo '<'.esc_html($heading_tag). $style.'> '.$cta_text;
  $border_color_attr = (!empty($underline_border_color)) ? 'style="border-color: '.esc_attr($underline_border_color).';"' : '';
  echo  '<span class="link_wrap" '.$style_padding_markup.'>'.$icon_output.'<a '.$target . $nofollow_attr .' class="link_text'.esc_attr($link_text_classes).'" '.$border_color_attr.' href="'.esc_url($url).'">'.wp_kses_post($link_text).'</a></span>'; 
  echo '</'.esc_html($heading_tag).'></div>';
}


?>