<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3",
	esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

// Horizontal progress bar shortcode
return array(
	"name" => esc_html__("Progress Bar",'salient-core'),
	"base" => "bar",
	"icon" => "icon-wpb-progress_bar",
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Content', 'salient-core'),
	"class" => 'three-cols',
	"description" => esc_html__('Include a horizontal progress bar', 'salient-core'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__('Title','salient-core'),
			"param_name" => "title",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__('Percentage','salient-core'),
			"param_name" => "percent",
			"description" => esc_html__('Don\'t include "%" in your string - e.g "70"', 'salient-core')
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__('Bar Color', 'salient-core'),
			"param_name" => "color",
			"value" => $el_color_list,
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		)
		
	)
);


?>