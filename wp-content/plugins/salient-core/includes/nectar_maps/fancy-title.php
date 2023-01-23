<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Animated Title", "salient-core"),
	"base" => "nectar_animated_title",
	"icon" => "icon-wpb-animated-heading",
	"category" => esc_html__('Typography', 'salient-core'),
	"description" => esc_html__('Add a title with animation', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Heading Tag", "salient-core"),
			"param_name" => "heading_tag",
			"value" => array(
				"H6" => "h6",
				"H5" => "h5",
				"H4" => "h4",
				"H3" => "h3",
				"H2" => "h2",
				"H1" => "h1"
			)),
			array(
				"type" => "dropdown",
				"class" => "",
				'save_always' => true,
				"heading" => esc_html__("Title Style", "salient-core"),
				"param_name" => "style",
				"admin_label" => false,
				"value" => array(
					esc_html__( "Color Strip Reveal", "salient-core") => "color-strip-reveal",
					esc_html__( "Hinge Drop", "salient-core") => "hinge-drop",
				),
				"description" => esc_html__("Gradient colors are only available for compatible effects", "salient-core")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				'save_always' => true,
				"heading" => esc_html__("Background Color", "salient-core"),
				"param_name" => "color",
				"admin_label" => false,
				"value" => $el_color_list,
				'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => esc_html__("Text Color", "salient-core"),
				"param_name" => "text_color",
				"value" => "#ffffff",
				"description" => esc_html__("Select the color your text will display in", "salient-core"),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Text Content", "salient-core"),
				"param_name" => "text",
				"admin_label" => true,
				"description" => esc_html__("Enter your fancy title text here", "salient-core")
			)
			
		)
	);
	?>