<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

$el_color_list = array(
    esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3",
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Pricing Column", "salient-core"),
	"base" => "pricing_column",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", "salient-core"),
			"param_name" => "title",
			"description" => esc_html__("Please enter a title for your pricing column", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Price", "salient-core"),
			"param_name" => "price",
			"admin_label" => true,
			"description" => esc_html__("Enter the price for your column", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Currency Symbol", "salient-core"),
			"param_name" => "currency_symbol",
			"description" => esc_html__("Enter the currency symbol that will display for your price", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Interval", "salient-core"),
			"param_name" => "interval",
			"description" => esc_html__("Enter the interval for your pricing e.g. \"Per Month\" or \"Per Year\" ", "salient-core")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Highlight Column?", "salient-core"),
			"value" => array("Yes, please" => "true" ),
			"param_name" => "highlight",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Highlight Reason", "salient-core"),
			"param_name" => "highlight_reason",
			"description" => esc_html__("Enter the reason for the column being highlighted e.g. \"Most Popular\"" , "salient-core"),
			"dependency" => Array('element' => "highlight", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => "Color",
			"param_name" => "color",
			"value" => $el_color_list,
			'save_always' => true,
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "textarea_html",
			"holder" => "hidden",
			"heading" => esc_html__("Text Content", "salient-core"),
			"param_name" => "content",
			"value" => ''
		)
	),
	'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
);


?>