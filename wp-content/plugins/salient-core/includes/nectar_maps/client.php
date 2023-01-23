<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

return array(
	"name" => esc_html__("Client", "salient-core"),
	"base" => "client",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Image", "salient-core"),
			"param_name" => "image",
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("URL", "salient-core"),
			"param_name" => "url",
			"description" => esc_html__("Add an optional link to your client", "salient-core")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("URL Target", "salient-core"),
			"param_name" => "url_target",
			"value" => array(
				"Open in new window" => "_blank",
				"Open in same window" => "_self",
			),
	),
		array(
			"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Client Name", "salient-core"),
			"param_name" => "name",
			"description" => esc_html__("Fill this out to keep track of which client is which in your page builder interface.", "salient-core")
		)
	),
	'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
);

?>