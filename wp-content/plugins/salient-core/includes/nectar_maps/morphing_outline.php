<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Morphing Outline", "salient-core"),
	"base" => "morphing_outline",
	"icon" => "icon-wpb-morphing-outline",
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Wrap some text in a unqiue way to grab attention', 'salient-core'),
	"params" => array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"heading" => esc_html__("Text Content", "salient-core"),
			"param_name" => "content",
			"value" => '',
			"description" => esc_html__("Enter the text that will be wrapped here", "salient-core"),
			"admin_label" => false
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Border Thickness", "salient-core"),
			"param_name" => "border_thickness",
			"description" => esc_html__("Don't include \"px\" in your string - default is \"5\"", "salient-core"),
			"admin_label" => false
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Starting Color", "salient-core"),
			"param_name" => "starting_color",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Hover Color", "salient-core"),
			"param_name" => "hover_color",
			"value" => "",
			"description" => ""
		)
		
	)
);

?>