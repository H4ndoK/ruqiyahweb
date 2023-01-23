<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
	esc_html__( "Default", "salient-core") => "Default",
	esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3"
  );
  $custom_colors = apply_filters('nectar_additional_theme_colors', array());
  $el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Section", "salient-core"),
	"base" => "toggle",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", "salient-core"),
			"param_name" => "title",
			"description" => esc_html__("Accordion section title.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Color", "salient-core"),
			"param_name" => "color",
			"admin_label" => true,
			"value" => $el_color_list,
			'save_always' => true,
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Typography",
			"param_name" => "heading_tag",
			"value" => array(
				"Default" => "default",
				"span" => "span",
				"H6" => "h6",
				"H5" => "h5",
				"H4" => "h4",
				"H3" => "h3",
				"H2" => "h2"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Typography Functionality",
			"param_name" => "heading_tag_functionality",
			"value" => array(
				"Inherit Styling Only" => "default",
				"Change HTML Tag" => "change_html_tag"
			)
		),
	),
	'js_view' => 'VcAccordionTabView'
);

?>