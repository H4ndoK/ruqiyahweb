<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Centered Heading", "salient-core"),
	"base" => "heading",
	"icon" => "icon-wpb-centered-heading",
	"category" => esc_html__('Typography', 'salient-core'),
	"description" => esc_html__('Simple heading', 'salient-core'),
	"params" => array(
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => esc_html__("Heading", "salient-core"),
			"param_name" => "content",
			"value" => ''
		), 
		array(
			"type" => "textfield",
			"heading" => esc_html__("Subtitle", "salient-core"),
			"param_name" => "subtitle",
			"description" => esc_html__("The subtitle text under the main title", "salient-core")
		)
	)
);

?>