<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}


return array(
	"name" => esc_html__("Scrolling Text", "salient-core"),
	"base" => "nectar_scrolling_text",
	"icon" => "icon-wpb-centered-heading",
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Typography', 'salient-core'),
	"description" => esc_html__('Animated text that scrolls', 'salient-core'),
	"params" => array(


		array(
			"type" => "dropdown",
			"heading" => esc_html__("Scrolling Direction", "salient-core"),
			"param_name" => "scroll_direction",
			"value" => array(
				esc_html__("Standard", "salient-core") => "ltr",
				esc_html__("Reverse", "salient-core") => "rtl"
			),
			"edit_field_class" => "col-md-6",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Scrolling Speed", "salient-core"),
			"param_name" => "scroll_speed",
			"value" => array(
				esc_html__("Slowest", "salient-core") => "slower",
				esc_html__("Slower", "salient-core") => "slowest",
				esc_html__("Slow", "salient-core") => "slow",
				esc_html__("Medium", "salient-core") => "medium",
				esc_html__("Fast", "salient-core") => "fast",
				esc_html__("Static", "salient-core") => "static",
			),
			"edit_field_class" => "col-md-6 col-md-6-last",
			'save_always' => true
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Text Color", "salient-core"),
			"param_name" => "text_color",
			"value" => "",
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => esc_html__("Text Content", "salient-core"),
			"param_name" => "content",
			"value" => '',
			"description" => esc_html__("Please ensure your text is using a heading tag - The text you enter will appear in a single line.", "salient-core"),
			"admin_label" => false
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Italic Style", "salient-core"),
			"param_name" => "style",
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("Text Outline", "salient-core") => "text_outline"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the style you would like for your italics. Use the \"I\" button on the editor above when highlighting text to toggle italics", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Outline Thickness", "salient-core"),
			"param_name" => "outline_thickness",
			"dependency" => array('element' => "style", 'value' => array('text_outline')),
			"value" => array(
				esc_html__("Ultra Thin", "salient-core") => "ultra-thin",
				esc_html__("Thin", "salient-core") => "thin",
				esc_html__("Regular", "salient-core") => "regular",
				esc_html__("Thick", "salient-core") => "thick",
				esc_html__("Extra Thick", "salient-core") => "extra_thick"
			),
			'save_always' => true,
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Font Size", "salient-core"),
			"param_name" => "custom_font_size",
			"edit_field_class" => "col-md-6",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Font Size Mobile", "salient-core"),
			"param_name" => "custom_font_size_mobile",
			"edit_field_class" => "col-md-6 col-md-6-last",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Number of Text Repeats", "salient-core"),
			"param_name" => "text_repeat_number",
			"value" => array(
				esc_html__("2", "salient-core") => "2",
				esc_html__("3", "salient-core") => "3",
				esc_html__("4", "salient-core") => "4",
				esc_html__("5", "salient-core") => "5",
				esc_html__("6", "salient-core") => "6",
				esc_html__("7", "salient-core") => "7",
				esc_html__("8", "salient-core") => "8",
			),
			'save_always' => true,
			"description" => esc_html__("The less/smaller text you have, the more repeats will be needed to create the infinite scrolling effect. Adjust accordingly.", "salient-core"),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Text Repeat Divider", "salient-core"),
			"param_name" => "text_repeat_divider",
			"value" => array(
				esc_html__("No Divider", "salient-core") => "none",
				esc_html__("Add Space", "salient-core") => "space",
				esc_html__("Custom Symbol", "salient-core") => "custom",
			),
			'save_always' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Text Space Amount", "salient-core"),
			"param_name" => "text_space_amount",
			"value" => array(
				esc_html__("Small", "salient-core") => "default",
				esc_html__("Medium", "salient-core") => "medium",
				esc_html__("Large", "salient-core") => "large",
			),
			"dependency" => array('element' => "text_repeat_divider", 'value' => array('space')),
			'save_always' => true,
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Text Repeat Divider", "salient-core"),
			"param_name" => "text_repeat_divider_custom",
			"dependency" => array('element' => "text_repeat_divider", 'value' => array('custom')),
			"description" => esc_html__("Add a custom entity that will be used as the divider.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Custom Text Repeat Divider Size", "salient-core"),
			"param_name" => "text_repeat_divider_scale",
			"dependency" => array('element' => "text_repeat_divider", 'value' => array('custom')),
			"value" => array(
				esc_html__("Full Scale Font Size", "salient-core") => "full",
				esc_html__("3/4 Font Size", "salient-core") => "three-fourths",
				esc_html__("1/2 Font Size", "salient-core") => "half",
			),
			'save_always' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Element Overflow Visibility", "salient-core"),
			"param_name" => "overflow",
			"value" => array(
				esc_html__("Hidden", "salient-core") => "hidden",
				esc_html__("Visible", "salient-core") => "visible",
			),
			'save_always' => true,
			"description" => ''
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Background Image", "salient-core"),
			"param_name" => "background_image_url",
			"value" => "",
			"group" => esc_html__('Background', 'salient-core'),
			"description" => esc_html__("Select a background image from the media library.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"group" => esc_html__('Background', 'salient-core'),
			"heading" => esc_html__("Background Image Animation", "salient-core"),
			"param_name" => "background_image_animation",
			"admin_label" => true,
			"value" => array(
				esc_html__("None", "salient-core") => "None",
				esc_html__("Fade In", "salient-core") => "fade-in",
				esc_html__("Fade In From Bottom", "salient-core") => "fade-in-from-bottom",
				esc_html__("Reveal Rotate From Top", "salient-core") => "ro-reveal-from-top",
				esc_html__("Reveal Rotate From Bottom", "salient-core") => "ro-reveal-from-bottom",
				esc_html__("Reveal Rotate From Left", "salient-core") => "ro-reveal-from-left",
				esc_html__("Reveal Rotate From Right", "salient-core") => "ro-reveal-from-right",
			),
			'save_always' => true,
			"description" => esc_html__("Select animation type if you want your background image to be animated when it enters into the browsers viewport.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Background Image Height", "salient-core"),
			"param_name" => "background_image_height",
			"group" => esc_html__('Background', 'salient-core'),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Separate Text Coloring When on top of Image", "salient-core"),
			"param_name" => "separate_text_coloring",
			"description" => '',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"group" => esc_html__('Background', 'salient-core'),
			"value" => array(esc_html__("Yes", "salient-core") => 'true')
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Text Color on top of Image", "salient-core"),
			"group" => esc_html__('Background', 'salient-core'),
			"param_name" => "text_color_front",
			"value" => "",
			"dependency" => array('element' => "separate_text_coloring", 'not_empty' => true)
		),

	)
);