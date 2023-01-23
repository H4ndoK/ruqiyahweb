<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"video_webm" => "", 
  'video_mp4' => '', 
  'video_lightbox_url' => '',
	"video_image" => "", 
	"el_width" => '100', 
	"el_aspect" => "169", 
	"align" => "left", 
	"hide_controls" => "", 
	'loop' => '', 
	'autoplay' => '', 
  'autoplay_func' => '',
	'border_radius' => 'none',
	'box_shadow' => '',
  'player_functionality' => '',
  'play_button_style' => '',
  'play_button_color' => '',
  'play_button_icon_color' => '',
  'rm_on_mobile' => '',
  'advanced_gradient' => '',
  'video_loading' => 'default',
  'el_id' => ''), $atts));
  
  $play_button_markup = '';

  if( 'lightbox' === $player_functionality ) {
    
    $url = (!empty($video_mp4)) ? $video_mp4 : $video_webm;
    $url = (!empty($video_lightbox_url)) ? $video_lightbox_url : $url;

    $play_button_markup = '<a href="'.esc_attr($url).'" data-play_button_color="'.esc_attr($play_button_color).'" data-play_button_icon_color="'.esc_attr($play_button_icon_color).'" class="nectar_video_lightbox_trigger pp play_button '.esc_attr($play_button_style).'"><span class="screen-reader-text">'.esc_html__('Play Video','salient-core').'</span><span class="play"><svg class="inner" version="1.1"
    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600px" height="800px" x="0px" y="0px" viewBox="0 0 600 800" enable-background="new 0 0 600 800" xml:space="preserve"><path fill="none" d="M0-1.79v800L600,395L0-1.79z"></path></svg></span></a>';
    
    $autoplay = $loop = $hide_controls = 'yes';
  }

$video_image_src = false;

if( strpos($video_image, "http") !== false ){
  $video_image_src = $video_image;
} else {
  $video_image_src = wp_get_attachment_image_src($video_image, 'full');
	if( isset($video_image_src[0]) ) {
	  $video_image_src = $video_image_src[0];
	}
}

    
$el_classes = array(
  'nectar_video_player_self_hosted',
	'wpb_video_widget',
	'wpb_content_element',
	'vc_clearfix',
	'vc_video-aspect-ratio-' . esc_attr( $el_aspect ),
	'vc_video-el-width-' . esc_attr( $el_width ),
  'vc_video-align-' . esc_attr( $align ),
);

$preview_image_bg = '';
if( 'true' === $rm_on_mobile ) {
  $el_classes[] = 'rm-on-mobile';

  if( false !== $video_image_src ) {
    $preview_image_bg = ' style="background-image: url('.esc_attr($video_image_src).');"';
  }
 
}

// Dynamic style classes.
if( function_exists('nectar_el_dynamic_classnames') ) {
	$el_classes[] = nectar_el_dynamic_classnames('nectar_video_player_self_hosted', $atts);
}

$css_class = implode( ' ', $el_classes );

$bg_overlay = '';
if( !empty($advanced_gradient) ) {
  $bg_overlay = '<div class="nectar_video_player_self_hosted__overlay" style="background:'.esc_attr($advanced_gradient).';"></div>';
}
echo '<div class="' . nectar_clean_classnames(esc_attr( $css_class )) . '" data-border-radius="'.esc_attr($border_radius).'" data-shadow="'.esc_attr($box_shadow).'">
<div class="wpb_wrapper"><div class="wpb_video_wrapper"'.$preview_image_bg.'>' . $bg_overlay . $play_button_markup;


$video_attrs_arr = array();
$video_classes_arr = array('nectar-video-self-hosted');

if( 'yes' === $loop ) {
  $video_attrs_arr[] = 'loop';
}
if( 'yes' !== $hide_controls ) {
  $video_attrs_arr[] = 'controls controlsList="nodownload"';
}
if( 'yes' === $autoplay ) {

  if( 'scroll_based' === $autoplay_func ) {
    $video_attrs_arr[] = ' muted playsinline';
    $video_classes_arr[] = 'scroll-triggered-play';
  } else {
    $video_attrs_arr[] = 'autoplay muted playsinline';
  }

}

$preload_attr = 'auto';

if( false !== $video_image_src ) {
	$preload_attr = 'metadata';
  $video_attrs_arr[] = 'poster="'.esc_attr($video_image_src).'"';
}

$video_attrs_escaped = implode( ' ', $video_attrs_arr );

if ( !('true' === $rm_on_mobile && wp_is_mobile()) ) {

  if( 'lazy-load' === $video_loading ) {

    $video_classes_arr[] = 'nectar-lazy-video';

    echo '<video width="1280" height="720" class="'.implode( ' ', $video_classes_arr ).'" preload="'.esc_attr($preload_attr).'" '.$video_attrs_escaped.'>';
    if (!empty($video_webm)) {
        echo '<source data-nectar-video-src="'. esc_url($video_webm) .'" type="video/webm">';
    }
    if (!empty($video_mp4)) {
        echo '<source data-nectar-video-src="'. esc_url($video_mp4) .'"  type="video/mp4">';
    }
    echo '</video>';

  } 
  else {

    echo '<video width="1280" height="720" class="'.implode( ' ', $video_classes_arr ).'" preload="'.esc_attr($preload_attr).'" '.$video_attrs_escaped.'>';
    if (!empty($video_webm)) {
        echo '<source src="'. esc_url($video_webm) .'" type="video/webm">';
    }
    if (!empty($video_mp4)) {
        echo '<source src="'. esc_url($video_mp4) .'"  type="video/mp4">';
    }
    echo '</video>';

  }
    
}
echo '</div></div></div>';