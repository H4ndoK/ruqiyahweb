<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

$el_color_list = array(
    esc_html__( "Accent Color", "salient-core") => "accent-color",
	esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
	esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
	esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2",
	esc_html__( "Black", "salient-core") => "black",
	esc_html__( "Grey", "salient-core") => "grey",
	esc_html__( "White", "salient-core") => "white",
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Star Rating", "salient-core"),
	"base" => "star_rating",
	"icon" => "icon-wpb-star",
	"category" => __('Content', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Star Rating", "salient-core"),
			"param_name" => "star_rating",
			"admin_label" => true,
			"value" => array(
				"5 Stars" => "5",
				"4.5 Stars" => "4-5",
				"4 Stars" => "4",
				"3.5 Stars" => "3-5%",
				"3 Stars" => "3",
				"2.5 Stars" => "2-5",
				"2 Stars" => "2",
				"1.5 Stars" => "1-5",
				"1 Stars" => "1",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the number of stars you would like to show", "salient-core")
		),
    array(
      "type" => "nectar_numerical",
      'edit_field_class' => 'zero-floor vc_col-xs-12',
      "heading" => esc_html__("Star Sizing",'salient-core'),
      "value" => "",
      "admin_label" => false,
      "param_name" => "sizing",
      "description" => esc_html__( 'Enter a size for your star icons. When left empty, a default of 20px will be used.', 'salient-core' )
   ),
   array(
    'type' => 'dropdown',
    'heading' => __( 'Icon Color', 'salient-core' ),
    'value' => $el_color_list,
    'save_always' => true,
    'param_name' => 'icon_color',
    "dependency" => array('element' => "icon_color_type", 'value' => array('color_scheme')),
    'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
  ),
    array(
			"type" => "textarea_html",
			"heading" => esc_html__("Text Content", "salient-core"),
			"param_name" => "content",
			"admin_label" => false,
			"description" => esc_html__("Optionally add text to display beside your star rating", "salient-core")
		),
	),
);
