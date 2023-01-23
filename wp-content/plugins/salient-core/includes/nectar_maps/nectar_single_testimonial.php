<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Default (inherit from row Text Color)", "salient-core") => "Default",
	esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3",
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Single Testimonial", "salient-core"),
	"base" => "nectar_single_testimonial",
	"icon" => "icon-nectar-single-testimonial",
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Styled Quotes', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", "salient-core"),
			"param_name" => "testimonial_style",
			"value" => array(
				esc_html__("Small Modern", "salient-core") => "small_modern",
				esc_html__("Big Bold", "salient-core") => "bold",
				esc_html__("Basic", "salient-core") => "basic",
				esc_html__("Basic - Left Image", "salient-core") => "basic_left_image",
			),
			'save_always' => true,
			'description' => esc_html__( 'Choose your desired style here.', 'salient-core' ),
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Quote", "salient-core"),
			"param_name" => "quote",
			"description" => esc_html__("The testimonial quote", "salient-core")
		),
		array(
			"type" => "fws_image",
			"class" => "",
			"heading" => "Image",
			"value" => "",
			"param_name" => "image",
			"description" => esc_html__("Add an optional image for the person/company who supplied the testimonial", "salient-core")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Add Shadow To Image", "salient-core"),
			"value" => array("Yes, please" => "true" ),
			"param_name" => "add_image_shadow",
			"dependency" => Array('element' => "image", 'not_empty' => true),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Name", "salient-core"),
			"param_name" => "name",
			"admin_label" => true,
			"description" => esc_html__("Name or source of the testimonial", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Subtitle", "salient-core"),
			"param_name" => "subtitle",
			"admin_label" => false,
			"description" => esc_html__("The optional subtitle that will follow the testimonial name", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Text Color",
			"param_name" => "text_color",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Added Color", "salient-core"),
			"param_name" => "color",
			"value" => $el_color_list,
			'save_always' => true,
			"dependency" => array('element' => "testimonial_style", 'value' => array('small_modern','bold')),
			'description' => esc_html__('Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		
	)
);

?>