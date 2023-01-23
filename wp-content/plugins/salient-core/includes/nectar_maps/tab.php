<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

return array(
	"name" => esc_html__("Tab", "salient-core"),
	"base" => "tab",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", "salient-core"),
			"param_name" => "title",
			"description" => esc_html__("Tab title.", "salient-core")
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'salient-core' ),
			'value' => array(
				esc_html__( 'None', 'salient-core' ) => 'none',
				esc_html__( 'Font Awesome', 'salient-core' ) => 'fontawesome',
				esc_html__( 'Iconsmind', 'salient-core' ) => 'iconsmind',
				esc_html__( 'Linea', 'salient-core' ) => 'linea',
				esc_html__( 'Steadysets', 'salient-core' ) => 'steadysets',
				esc_html__( 'Linecons', 'salient-core' ) => 'linecons',
			),
			'save_always' => true,
			'param_name' => 'icon_family',
			"description" => esc_html__("Tab Icon Library. (Only used in certain tabbed styles)", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_fontawesome",
			"settings" => array( "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'emptyIcon' => true, 'value' => 'fontawesome'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_iconsmind",
			"settings" => array( 'type' => 'iconsmind', 'emptyIcon' => true, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_linecons",
			"settings" => array( 'type' => 'linecons', 'emptyIcon' => true, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'linecons'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_steadysets",
			"settings" => array( 'type' => 'steadysets', 'emptyIcon' => true, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
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
			"type" => "textarea",
			"heading" => esc_html__("Sub Description", "salient-core"),
			"param_name" => "sub_desc",
			"description" => esc_html__("Tab sub description. (Only used in the following tab styles: Vertical Sticky Scrolling)", "salient-core")
		),
		/*array(
			"type" => "textfield",
			"heading" => esc_html__("External URL", "salient-core"),
			"param_name" => "tab_url",
			"description" => esc_html__("If you wish to have your tab link to a URL, enter it here.", "salient-core")
		),*/
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", "salient-core"),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "salient-core")
		),
		array(
			"type" => "tab_id",
			"heading" => esc_html__("Tab ID", "salient-core"),
			"param_name" => "id"
		)
	),
	'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
);

?>