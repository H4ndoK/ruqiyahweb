<?php
/**
 * Salient Nectar Slider Shortcode
 *
 * @package Salient Nectar Slider
 * @subpackage frontend helpers
 * @version 10.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nectar Slider shortcode.
 *
 * @since 1.0
 */
if( !function_exists('nectar_slider_processing') ) {
	
	function nectar_slider_processing($atts, $content = null) {
		
		extract(shortcode_atts(array(
			"arrow_navigation" => 'false', 
			"autorotate" => '', 
			"tablet_header_font_size" => "auto", 
			"tablet_caption_font_size" => "auto", 
			"phone_header_font_size" => "auto", 
			"phone_caption_font_size" => "auto", 
			"button_sizing" => 'regular', 
			"slider_button_styling" => 'btn_with_count', 
			"overall_style" => 'classic', 
			"slider_transition" => 'swipe', 
			"flexible_slider_height" => '', 
			"min_slider_height" => '', 
			"loop" => 'false', 
			'fullscreen' => 'false', 
			'heading_tag' => 'default',
			"bullet_navigation" => 'false', 
			"bullet_navigation_style" => 'see_through', 
			"disable_parallax_mobile" => '', 
			"bullet_navigation_position" => 'bottom', 
			"caption_transition" => 'fade_in_from_bottom', 
			"parallax" => 'false', 
			"parallax_style" => "parallax_bg_and_content", 
			"bg_animation" => "none", 
			"full_width" => '', 
			"slider_height" => '650', 
			"desktop_swipe" => 'false', 
			'image_loading' => 'normal',
			"location" => ''), $atts));   
	    
	  if($overall_style === 'directional') {
	    $desktop_swipe = 'false';
	  }
	    
	  if( isset($_GET['vc_editable']) ) {
	  	$nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
	  	$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
	  } else {
	  	$nectar_using_VC_front_end_editor = false;
	  }
	  
	  if($nectar_using_VC_front_end_editor) {
	    $autorotate = '';
	  }
		
		if( ! defined( 'NECTAR_THEME_NAME' ) ) {
			$full_width = '';
		}
	      
		$slider_config = array(
		  'slider_height'              => $slider_height,
		  'full_width'                 => $full_width,
		  'flexible_slider_height'     => $flexible_slider_height,
		  'min_slider_height'          => $min_slider_height,
		  'autorotate'                 => $autorotate,
		  'arrow_navigation'           => $arrow_navigation,
		  'bullet_navigation'          => $bullet_navigation,
		  'bullet_navigation_style'    => $bullet_navigation_style,
	    'bullet_navigation_position' => $bullet_navigation_position,
		  'desktop_swipe'              => $desktop_swipe,
		  'parallax'                   => $parallax,
	    'parallax_style'             => $parallax_style,
	    'disable_parallax_mobile'    => $disable_parallax_mobile,
		  'slider_transition'          => $slider_transition,
		  'overall_style'              => $overall_style,
		  'slider_button_styling'      => $slider_button_styling,
		  'loop'                       => $loop,
			'image_loading'              => $image_loading,
		  'fullscreen'                 => $fullscreen,
		  'button_sizing'              => $button_sizing,
			'heading_tag'                => $heading_tag,
		  'location'                   => $location,
	    'bg_animation'               => $bg_animation,
	    'caption_transition'         => $caption_transition,
		  "tablet_header_font_size"    => $tablet_header_font_size,
		  "tablet_caption_font_size"   => $tablet_caption_font_size,
		  "phone_header_font_size"     => $phone_header_font_size,
		  "phone_caption_font_size"    => $phone_caption_font_size
		);
	  
		 
		return do_shortcode(nectar_slider_display($slider_config));
	}
	
}

add_shortcode('nectar_slider', 'nectar_slider_processing');