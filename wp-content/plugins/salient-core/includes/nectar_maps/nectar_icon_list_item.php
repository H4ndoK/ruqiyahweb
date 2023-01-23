<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

return array(
	"name" => esc_html__("List Item", "salient-core"),
	"base" => "nectar_icon_list_item",
	"allowed_container_element" => 'vc_row',
	"is_container" => false,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("List Icon Type", "salient-core"),
			"param_name" => "icon_type",
			"value" => array(
				"Number" => "numerical",
				"Icon" => "icon"
			),
			'save_always' => true,
			"admin_label" => true,
			"description" => esc_html__("Please select how many columns you would like..", "salient-core")
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'salient-core' ),
			'value' => array(
				esc_html__( 'Font Awesome', 'salient-core' ) => 'fontawesome',
				esc_html__( 'Iconsmind', 'salient-core' ) => 'iconsmind',
				esc_html__( 'Linea', 'salient-core' ) => 'linea',
				esc_html__( 'Steadysets', 'salient-core' ) => 'steadysets',
			),
			"dependency" => array('element' => "icon_type", 'value' => 'icon'),
			'param_name' => 'icon_family',
			'description' => esc_html__( 'Select icon library.', 'salient-core' ),
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_fontawesome",
			"settings" => array( "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "icon_family", 'value' => 'fontawesome'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_iconsmind",
			"settings" => array( 'type' => 'iconsmind', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_linea",
			"settings" => array( 'type' => 'linea', "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "icon_family", 'value' => 'linea'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_steadysets",
			"settings" => array( 'type' => 'steadysets', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Header", "salient-core"),
			"param_name" => "header",
			"description" => esc_html__("Enter the header desired for your icon list element", "salient-core")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Content Type",
			"description" => esc_html__("If you will be adding HTML elements to your item, choose the Text + HTML option (For full backwards compatibility, this needs to be explicitly set)", "salient-core"),
			"param_name" => "text_full_html",
			"value" => array(
				"Simple Text" => "simple",
				"Text + HTML" => "html"
			)),
		array(
			"admin_label" => true,
			"type" => "textarea",
			"heading" => esc_html__("Text Content (Simple)", "salient-core"),
			"param_name" => "text",
			"description" => esc_html__("Enter the text content desired for your icon list element", "salient-core"),
			"dependency" => Array('element' => "text_full_html", 'value' => array('simple'))
		),
		array(
			"type" => "textarea_html",
			"heading" => esc_html__("Text Content (HTML Enabled)", "salient-core"),
			"param_name" => "content",
			"description" => esc_html__("Enter the text content desired for your icon list element", "salient-core"),
			"dependency" => Array('element' => "text_full_html", 'value' => array('html'))
		),
		array(
			"type" => "tab_id",
			"heading" => esc_html__("Item ID", "salient-core"),
			"param_name" => "id"
		)
		
	),
	'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
);

?>