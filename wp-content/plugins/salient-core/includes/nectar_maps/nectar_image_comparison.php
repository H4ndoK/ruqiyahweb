<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Image Comparison", "salient-core"),
	"base" => "nectar_image_comparison",
	"icon" => "icon-wpb-single-image",
	"category" => esc_html__('Media', 'salient-core'),
	"description" => esc_html__('Shows differences in two images', 'salient-core'),
	"params" => array(
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Image One", "salient-core"),
			"param_name" => "image_url",
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Image Two", "salient-core"),
			"param_name" => "image_2_url",
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", "salient-core"),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "salient-core")
		)
	)
);

?>