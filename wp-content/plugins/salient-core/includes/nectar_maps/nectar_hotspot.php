<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Nectar Hotspot", "salient-core"),
	"base" => "nectar_hotspot",
	"allowed_container_element" => 'vc_row',
	"content_element" => false,
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Position",
			"param_name" => "position",
			"value" => array(
				"top" => "top",
				"right" => "right",
				"bottom" => "bottom",
				"left" => "left",
			)),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Left", "salient-core"),
				"param_name" => "left"
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Top", "salient-core"),
				"param_name" => "top"
			),
			array(
				"type" => "textarea_html",
				"heading" => esc_html__("Content", "salient-core"),
				"param_name" => "content",
				"description" => '',
			)
		)
		
	);
	
	?>