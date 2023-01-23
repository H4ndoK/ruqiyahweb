<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-video-lightbox' );

extract(shortcode_atts(array(
	"link_style" => "play_button", 
	'hover_effect' => 'default', 
	"font_style" => "p", 
	"video_url" => '#', 
	"link_text" => "", 
	"play_button_color" => "default", 
	"nectar_button_color" => "default", 
	'nectar_play_button_color' => 'Accent-Color', 
	'text_color' => 'default',
	'image_url' => '', 
	'image_size' => 'full',
	'border_radius' => 'none',
	'play_button_size' => 'default',
	'nectar_play_button_style' => 'default',
	'parent_hover_relationship' => '',
	'mouse_indicator_style' => 'default',
	'mouse_indicator_color' => '',
	'nofollow_link' => '',
	'box_shadow' => ''), $atts));

$wp_image_size  = ( !empty($image_size) ) ? $image_size : 'full';
$no_follow_attr = ( 'true' === $nofollow_link ) ? ' rel="nofollow" ': '';
$extra_attrs    = ($link_style === 'nectar-button') ? 'data-color-override="false"': '';


$the_link_text_escaped = ($link_style === 'nectar-button') ? wp_kses_post($link_text) : '<span class="screen-reader-text">'.esc_html__('Play Video','salient-core').'</span><span class="play"><span class="inner-wrap inner"><svg version="1.1"
	 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600px" height="800px" x="0px" y="0px" viewBox="0 0 600 800" enable-background="new 0 0 600 800" xml:space="preserve"><path fill="none" d="M0-1.79v800L600,395L0-1.79z"></path> </svg></span></span>';

$the_color = ($link_style === 'nectar-button') ? $nectar_button_color : $play_button_color;
$text_color_class = '';

if( $link_style === 'play_button_with_text' ) {
	$the_color = $nectar_play_button_color;

	if( $text_color != 'default' && in_array( $nectar_play_button_style, array('small','bordered_top')) ) {
		$text_color_class = ' text-color-'. $text_color;
	}
}



if( $link_style === 'play_button_2' || $link_style === 'play_button_mouse_follow' ) {

	  $image = null;

	  if( !empty($image_url) ) {
			
      	if( !preg_match('/^\d+$/',$image_url) ){
      		$image = '<img src="'.esc_url($image_url).'" alt="'. esc_html__('video preview', 'salient-core') .'" />';
      	} else {
					
					if( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
						$image_arr = wp_get_attachment_image_src($image_url, $wp_image_size);

						if( isset($image_arr[0]) ) {

							
							$image_src    = $image_arr[0];
							$img_dimens_w = $image_arr[1];
							$img_dimens_h = $image_arr[2];
							$placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($img_dimens_w).'%20'.esc_attr($img_dimens_h)."'%2F%3E";
							
							$alt_tag = esc_html__('video preview','salient-core');
							$wp_img_alt_tag = get_post_meta( $image_url, '_wp_attachment_image_alt', true );
							if (!empty($wp_img_alt_tag)) { 
								$alt_tag = $wp_img_alt_tag;
							}
							$image_srcset = wp_get_attachment_image_srcset($image_url, $wp_image_size);
							
							$image = '<img class="nectar-lazy" src="'.esc_attr($placeholder_img_src).'" data-nectar-img-src="'.esc_attr($image_src).'" data-nectar-img-srcset="'.esc_attr($image_srcset).'" sizes="(max-width: 1000px) 100vw, 1000px" alt="'.esc_attr($alt_tag).'" width="'.esc_attr($img_dimens_w).'" height="'.esc_attr($img_dimens_h).'" />';
						}
					} else {
						$image = wp_get_attachment_image($image_url, $wp_image_size);
					}
      		
      	}  
		}
		
	$mouse_markup = ( $link_style === 'play_button_mouse_follow' ) ? 'data-mouse-style="'.esc_attr($mouse_indicator_style).'" data-mouse-icon-color="'.esc_attr($mouse_indicator_color).'"': '';	
	echo '<div class="nectar-video-box" data-color="'.esc_attr(strtolower($nectar_play_button_color)).'" '.$mouse_markup.' data-play-button-size="'.esc_attr($play_button_size).'" data-border-radius="'.esc_attr($border_radius).'" data-hover="'.esc_attr($hover_effect).'" data-shadow="'.esc_attr($box_shadow).'"><div class="inner-wrap"><a href="'.esc_url($video_url).'" '.$no_follow_attr.'class="full-link pp"></a>'. $image;
}

$pbwt_escaped = ($link_style === 'play_button_with_text') ? '<span class="link-text"><'.esc_html($font_style).'>'.wp_kses_post($link_text).'</'.esc_html($font_style).'></span>' : null;
if( $font_style === 'nectar-btn-medium' || $font_style === 'nectar-btn-large' || $font_style === 'nectar-btn-jumbo' ) {
	$pbwt_escaped = '<span class="link-text" data-font="'.esc_attr($font_style).'">'.wp_kses_post($link_text).'</span>';
}

echo '<a href="'.esc_url($video_url).'" '.$extra_attrs.$no_follow_attr.' data-style="'. esc_attr($nectar_play_button_style) .'" data-parent-hover="'.esc_attr($parent_hover_relationship).'" data-font-style="'.esc_html($font_style).'" data-color="'.esc_attr(strtolower($the_color)).'" class="'.esc_attr($link_style).esc_attr($text_color_class).' large nectar_video_lightbox pp"><span>'.$the_link_text_escaped .$pbwt_escaped.'</span></a>';

if( $link_style === 'play_button_2' || $link_style === 'play_button_mouse_follow' ) {
	echo '</div></div>';
}

?>