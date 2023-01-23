<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Rotating Words Title", "salient-core"),
	"base" => "nectar_rotating_words_title",
	"icon" => "icon-wpb-nectar-gradient-text",
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Typography', 'salient-core'),
	"description" => esc_html__('Change text in an animated manner', 'salient-core'),
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
			"type" => "textarea",
			"heading" => esc_html__("Beginning Text Content", "salient-core"),
			"param_name" => "beginning_text",
			"value" => '',
			"description" => esc_html__("Static text which will be displayed before the dynamic rotating text.", "salient-core"),
			"admin_label" => false
		),
    array(
			"type" => "textarea",
			"holder" => "div",
			"heading" => esc_html__("Dynamic Text Content", "salient-core"),
			"param_name" => "dynamic_text",
			"value" => '',
			"description" => esc_html__("Dynamic text which will be animated into view sequentially. Separate each word or phrase to be animated with a comma.", "salient-core"),
		),
    array(
			"type" => "textarea",
			"heading" => esc_html__("Ending Text Content", "salient-core"),
			"param_name" => "ending_text",
			"value" => '',
			"description" => esc_html__("Static text which will be displayed after the dynamic rotating text.", "salient-core"),
			"admin_label" => false
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Seconds Between Word Rotations", "salient-core"),
			"param_name" => "duration",
			"value" => array(
				esc_html__("1.5 Seconds",'salient-core') => "1500",
				esc_html__("2 Seconds",'salient-core') => "2000",
				esc_html__("2.5 Seconds",'salient-core') => "2500",
				esc_html__("3 Seconds",'salient-core') => "3000",
				esc_html__("3.5 Seconds",'salient-core') => "3500",
				esc_html__("4 Seconds",'salient-core') => "4000",
				esc_html__("4.5 Seconds",'salient-core') => "4500",
				esc_html__("5 Seconds",'salient-core') => "5000",
				esc_html__("6 Seconds",'salient-core') => "6000",
				esc_html__("7 Seconds",'salient-core') => "7000",
				esc_html__("8 Seconds",'salient-core') => "8000",
				esc_html__("9 Seconds",'salient-core') => "9000",
			)),
    array(
      "type" => "colorpicker",
      "class" => "",
      "heading" => esc_html__("Text Color", "salient-core"),
      "param_name" => "text_color",
      "value" => "",
      "description" => esc_html__("Select the color your text will display in", "salient-core"),
    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Font Size", "salient-core"),
			"param_name" => "font_size",
			'dependency' => array(
				'element' => 'animation_type',
				'value' => array('line-reveal-by-space','letter-fade-reveal','twist-in'),
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Dynamic Text Font Family", "salient-core"),
			"param_name" => "dynamic_heading_tag",
			"value" => array(
				"Default" => "default",
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
				"heading" => esc_html__("Element Animation", "salient-core"),
				"param_name" => "element_animation",
				"description" => esc_html__("An animation that will trigger when the element is scrolled into view.", "salient-core"),
				"value" => array(
					esc_html__("None",'salient-core') => "none",
					esc_html__("Stagger Words",'salient-core') => "stagger_words",
			)),
			array(
				"type" => "dropdown",
				"class" => "",
				'save_always' => true,
				"heading" => esc_html__("Mobile Display", "salient-core"),
				"param_name" => "mobile_display",
				"description" => esc_html__("Determines how your beginning, dynamic and ending text will display on mobile devices.", "salient-core"),
				"value" => array(
					esc_html__("Inline",'salient-core') => "inline",
					esc_html__("Stacked",'salient-core') => "stacked",
			)),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Element Animation Delay", "salient-core"),
				"param_name" => "element_animation_delay",
				"description" => esc_html__("Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in \"one by one\" effect.", "salient-core")
			),

	)
);

?>
