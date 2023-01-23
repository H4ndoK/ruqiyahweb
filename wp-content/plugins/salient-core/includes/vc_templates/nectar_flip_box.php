<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-flip-box' );

$title = $el_class = $value = $label_value= $units = '';
extract(shortcode_atts(array(
	'image_url_1' => '',
	'image_url_2' => '',
	'bg_color' => '#fff',
	'bg_color_2' => '#fff',
	'bg_color_overlay' => '',
	'bg_color_overlay_2' => '',
	'min_height' => '300',
	'text_color' => '',
	'text_color_2' => '',
	'h_text_align' => 'center',
	'v_text_align' => 'center',
	'front_content' => '',
	'box_shadow' => '',
	'image_loading' => 'normal',
	'icon_family' => 'fontawesome',
	'icon_fontawesome' => '',
	'icon_linea' => '',
	'icon_iconsmind' => '',
	'icon_steadysets' => '',
	'icon_color' => 'accent-color',
	'icon_size' => '60',
	'flip_direction' => 'horizontal-to-left'
), $atts));

$style  = '';
$style2 = '';
$front_lazy_escaped = '';
$back_lazy_escaped = '';

if( !empty($image_url_1) ) {
	
	if( !preg_match('/^\d+$/',$image_url_1) ) {
		if( 'lazy-load' === $image_loading || property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
			$front_lazy_escaped .= 'data-nectar-img-src="'.esc_url($image_url_1).'"';
		} else {          
	    $style .= 'background-image: url('.esc_url($image_url_1) . '); ';
		}
  } else  {
		$bg_image_src = wp_get_attachment_image_src($image_url_1, 'full');

		if( isset($bg_image_src[0]) ) {
			if( 'lazy-load' === $image_loading || property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active) {
				$front_lazy_escaped .= 'data-nectar-img-src="'.esc_url($bg_image_src[0]).'"';
			} else {
				$style .= 'background-image: url(\''.esc_url($bg_image_src[0]).'\'); ';
			}
		}
		
	}
	
}

if( !empty($image_url_2) ) {

	if(!preg_match('/^\d+$/',$image_url_2)) {
		if( 'lazy-load' === $image_loading || property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active) {
			$back_lazy_escaped .= 'data-nectar-img-src="'.esc_url($image_url_2).'"';
		} else {              
	    $style2 .= 'background-image: url('.esc_url($image_url_2) . '); ';
		}
		
  } else {
		$bg_image_src_2 = wp_get_attachment_image_src($image_url_2, 'full');

		if( isset($bg_image_src_2[0]) ) {
			if( 'lazy-load' === $image_loading || property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active) {
				$back_lazy_escaped .= 'data-nectar-img-src="'.esc_url($bg_image_src_2[0]).'"';
			} else {
				$style2 .= 'background-image: url(\''.esc_url($bg_image_src_2[0]).'\'); ';
			}
		}
		
	}
}

if( !empty($bg_color) ) {
	$style .= 'background-color: '.esc_attr($bg_color).'; ';
}
if( !empty($bg_color_2) ) {
	$style2 .= 'background-color: '.esc_attr($bg_color_2).'; ';
}

if( !empty($min_height) ) {
	$style .= 'min-height: '.esc_attr($min_height).'px;';
	$style2 .= 'min-height: '.esc_attr($min_height).'px;';
}


$box_link = null;
if( !empty($link_url) ) {
	$box_link = '<a '.$new_tab_markup.' href="'.esc_attr($link_url).'" class="box-link"></a>';
}

$text_link = null;
if( !empty($link_text) ) {
	$text_link = '<div class="link-text">'.wp_kses_post($link_text).'<span class="arrow"></span></div>';
}

$icon_markup = null;

switch( $icon_family ) {
	case 'fontawesome':
		$icon = $icon_fontawesome;
    wp_enqueue_style( 'font-awesome' );
		break;
	case 'steadysets':
		$icon = $icon_steadysets;
		break;
	case 'linea':
		$icon = $icon_linea;
		break;
	case 'iconsmind':
			$icon = $icon_iconsmind;
			break;
	default:
		$icon = '';
		break;
}

if( $icon_family === 'linea' ) { 
	wp_enqueue_style('linea'); 
}

if( !empty($icon) ) {
	
	if( $icon_family === 'iconsmind' ) {
		
		// SVG iconsmind.
		$icon_id        = 'nectar-iconsmind-icon-'.uniqid();
		$icon_markup    = '<span class="im-icon-wrap" data-color="'.esc_attr(strtolower($icon_color)) .'"><span>';
		$converted_icon = str_replace('iconsmind-', '', $icon);
	
		require_once( SALIENT_CORE_ROOT_DIR_PATH.'includes/icons/class-nectar-icon.php' );

		$nectar_icon_class = new Nectar_Icon(array(
		'icon_name' => $converted_icon,
		'icon_library' => 'iconsmind',
		));
	
		$icon_markup .= $nectar_icon_class->render_icon();
		
		// Custom size.
		$icon_markup = preg_replace(
	   array('/width="\d+"/i', '/height="\d+"/i'),
	   array('width="'.$icon_size.'"', 'height="'.$icon_size.'"'),
	   $icon_markup);
		
		// Handle gradients.
		if( strtolower($icon_color) === 'extra-color-gradient-1' || strtolower($icon_color) === 'extra-color-gradient-2') {
				
				$nectar_options = get_nectar_theme_options();
				
				if( strtolower($icon_color) === 'extra-color-gradient-1' && isset($nectar_options["extra-color-gradient"]['from']) ) {
					
					$accent_gradient_from = $nectar_options["extra-color-gradient"]['from'];
					$accent_gradient_to   = $nectar_options["extra-color-gradient"]['to'];
					
				} else if( strtolower($icon_color) === 'extra-color-gradient-2' && isset($nectar_options["extra-color-gradient-2"]['from']) ) {
					
					$accent_gradient_from = $nectar_options["extra-color-gradient-2"]['from'];
					$accent_gradient_to   = $nectar_options["extra-color-gradient-2"]['to'];
					
				}
				
				
			  $icon_markup =  preg_replace('/(<svg\b[^><]*)>/i', '$1 fill="url(#'.$icon_id.')">', $icon_markup);
				
			  $icon_markup .= '<svg style="height:0;width:0;position:absolute;" aria-hidden="true" focusable="false">
				  <linearGradient id="'.$icon_id.'" x2="1" y2="1">
				    <stop offset="0%" stop-color="'.$accent_gradient_to.'" />
				    <stop offset="100%" stop-color="'.$accent_gradient_from.'" />
				  </linearGradient>
				</svg>';
		} 
		 
		
		$icon_markup .= '</span></span>';
	}
	else {
		
		
		$icon_markup = '<i class="icon-default-style '.$icon.'" data-color="'.esc_attr(strtolower($icon_color)).'" style="font-size: '.esc_attr($icon_size).'px!important; line-height: '.esc_attr($icon_size).'px!important;"></i>';
	}
	
}

echo '<div class="nectar-flip-box" data-min-height="'.esc_attr($min_height).'" data-flip-direction="'.esc_attr($flip_direction).'" data-h_text_align="'.esc_attr($h_text_align).'" data-v_text_align="'.esc_attr($v_text_align).'">';
echo '<div class="flip-box-front" '.$front_lazy_escaped.' data-bg-overlay="'.esc_attr($bg_color_overlay).'" data-text-color="'.esc_attr($text_color).'" style="'.$style.'"> <div class="inner">'.$icon_markup . do_shortcode($front_content).'</div> </div>';
echo '<div class="flip-box-back" '.$back_lazy_escaped.' data-bg-overlay="'.esc_attr($bg_color_overlay_2).'" data-text-color="'.esc_attr($text_color_2).'" style="'.$style2.'"> <div class="inner">'.do_shortcode($content).'</div> </div>';
echo '</div>';
