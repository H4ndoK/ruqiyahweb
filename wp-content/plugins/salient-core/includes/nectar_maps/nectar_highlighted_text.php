<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Highlighted Text", "salient-core"),
	"base" => "nectar_highlighted_text",
	"icon" => "icon-wpb-nectar-gradient-text",
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Typography', 'salient-core'),
	"description" => esc_html__('Highlight text in an animated manner', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Color Type", "salient-core"),
			"param_name" => "color_type",
			"dependency" => Array('element' => "style", 'value' => array('regular_underline','half_text','full_text')),
			"value" => array(
				esc_html__("Regular", "salient-core") => "regular",
				esc_html__("Gradient", "salient-core") => "gradient",
			),
			'save_always' => true,
			"description" => ''
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Highlight Color", "salient-core"),
			"param_name" => "highlight_color",
			"value" => "",
			"dependency" => Array('element' => "style", 'value' => array('regular_underline','half_text','full_text','none')),
			"description" => esc_html__("If left blank this will default to a desaturated variant of your defined theme accent color.", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Highlight Color #2", "salient-core"),
			"param_name" => "secondary_color",
			"value" => "",
			"dependency" => Array('element' => "color_type", 'value' => 'gradient'),
			"description" => esc_html__("Add a second color which will be used for the gradient", "salient-core")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => esc_html__("Text Content", "salient-core"),
			"param_name" => "content",
			"value" => '',
			"description" => esc_html__("Any text that is wrapped in italics will get an animated highlight. Use the \"I\" button on the editor above when highlighting text to toggle italics.", "salient-core"),
			"admin_label" => false
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Text Color", "salient-core"),
			"param_name" => "text_color",
			"value" => "",
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Scribble Shape Color", "salient-core"),
			"param_name" => "scribble_color",
			"value" => "",
			"dependency" => Array('element' => "style", 'value' => array('scribble')),
			"description" => ''
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Highlighted Text Inherits Scribble Color", "salient-core"),
			"param_name" => "scribble_text_highlight",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "style", 'value' => array('scribble')),
			"value" => array(esc_html__("Yes", "salient-core") => 'true'),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", "salient-core"),
			"param_name" => "style",
			"value" => array(
				esc_html__("Full Text BG Cover", "salient-core") => "full_text",
				esc_html__("Fancy Underline", "salient-core") => "half_text",
				esc_html__("Regular Underline", "salient-core") => "regular_underline",
				esc_html__("Text Outline", "salient-core") => "text_outline",
				esc_html__("Hand-Drawn Scribble", "salient-core") => "scribble",
				esc_html__("None", "salient-core") => "none"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the style you would like for your highlights.", "salient-core")
		),
		array(
			'type' => 'nectar_radio_html',
			'class' => '',
			'heading' => esc_html__('Scribble Type', 'salient-core'),
			'param_name' => 'scribble_shape',
			"edit_field_class" => "two-columns vc_col-xs-12",
			'options' => array(
				'<svg class="svg nectar-shape stroke-shape animate-active" viewBox="0 0 800 350"><path transform="matrix(0.9791300296783447,0,0,0.9791300296783447,400,179)" stroke-linecap="round" stroke-linejoin="miter" fill-opacity="0" pathLength="1" stroke-miterlimit="4" stroke="rgb(49,143,255)" stroke-opacity="1" stroke-width="20" d=" M253,-161 C253,-161 -284.78900146484375,-201.4600067138672 -376,-21 C-469,163 67.62300109863281,174.2100067138672 256,121 C564,34 250.82899475097656,-141.6929931640625 19.10700035095215,-116.93599700927734"></path></svg>' => 'circle',
				'<svg class="svg nectar-shape stroke-shape animate-active" xmlns="http://www.w3.org/2000/svg" viewBox="-158.17 -22.0172 289.2 53.8"><path d="M -153.17 20.736 C -153.17 20.736 -135 -1 -118 -1 C -99 -1 -136.093 33.632 -117 26 C -105 18 -80 5 -74 1 C -51 -10 -63 9 -58.375 20.387 C -54.89 29.449 -26 3 -9 -1 C 14 -8 -17.599 24.918 1.917 22.827 C 21.434 20.735 37 3 49 0 C 62 -3 55.24 32.585 75 23 C 95 12 95 -1 114 -2" stroke="#000" pathLength="1" stroke-linecap="round" stroke-width="8" fill="none"/></svg>' => 'sketch-underline',
				'<svg class="svg nectar-shape stroke-shape animate-active" xmlns="http://www.w3.org/2000/svg" viewBox="-400 -56 730 60"><path d="m -383.25 -6 c 55.25 -22 130.75 -33.5 293.25 -38 c 54.5 -0.5 195 -2.5 401 15" stroke="#000" pathLength="1" stroke-linecap="round" stroke-width="20" fill="none"/></svg>' => 'basic-underline',
				'<svg class="svg nectar-shape stroke-shape animate-active" xmlns="http://www.w3.org/2000/svg" viewBox="-347 -30.1947 694 96.19"><path d="M-335,54 C-335,54 -171,-58 -194,-3 C-217,52 -224.1199951171875,73.552001953125 -127,11 C-68,-27 -137,50 -33,42 C31.43899917602539,37.042999267578125 147.14700317382812,-29.308000564575195 335,2" stroke="#000" pathLength="1" stroke-linecap="round" stroke-width="20" fill="none"/></svg>' => 'squiggle-underline',
				'<svg class="svg nectar-shape stroke-shape animate-active" xmlns="http://www.w3.org/2000/svg" viewBox="-320 -70.8161 640.4 59.82"><path d="M-300,-56 C-50,-72 298,-65 300,-59 C332,-53 -239,-36 -255,-27 C-271,-18 -88,-24 91,-20" stroke="#000" pathLength="1" stroke-linecap="round" stroke-width="20" fill="none"/></svg>' => 'squiggle-underline-2'
			),
			"dependency" => Array('element' => "style", 'value' => array('scribble')),
			'description' => '',
			'std' => 'circle',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Scribble Thickness", "salient-core"),
			"param_name" => "scribble_thickness",
			"value" => array(
				esc_html__("Thin", "salient-core") => "thin",
				esc_html__("Regular", "salient-core") => "regular",
				esc_html__("Thick", "salient-core") => "thick",
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('scribble')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Scribble Speed", "salient-core"),
			'edit_field_class' => 'nectar-one-half',
			"param_name" => "scribble_speed",
			"value" => array(
				esc_html__("Slow", "salient-core") => "1.8s",
				esc_html__("Medium", "salient-core") => "1.3s",
				esc_html__("Fast", "salient-core") => "0.8s",
				esc_html__("No Animation", "salient-core") => "0s",
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('scribble')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Scribble Easing", "salient-core"),
			"param_name" => "scribble_easing",
			'edit_field_class' => 'nectar-one-half nectar-one-half-last',
			"value" => array(
				esc_html__("Ease In Out", "salient-core") => "ease_in_out",
				esc_html__("Ease Out", "salient-core") => "ease_out",
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('scribble')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Highlight Color Expansion", "salient-core"),
			"param_name" => "highlight_expansion",
			"description" => esc_html__("Adjust this value as needed depending on how you would like the highlight color to align behind your text.", "salient-core"),
			"dependency" => Array('element' => "style", 'value' => array('full_text','regular_underline')),
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("Closer To Text", "salient-core") => "closer",
				esc_html__("Closest To Text", "salient-core") => "closest",
			),
			'save_always' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Outline Thickness", "salient-core"),
			"param_name" => "outline_thickness",
			"dependency" => Array('element' => "style", 'value' => array('text_outline')),
			"value" => array(
				esc_html__("Thin", "salient-core") => "thin",
				esc_html__("Regular", "salient-core") => "regular",
				esc_html__("Thick", "salient-core") => "thick",
				esc_html__("Extra Thick", "salient-core") => "extra_thick"
			),
			'save_always' => true,
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Underline Thickness", "salient-core"),
			"param_name" => "underline_thickness",
			"dependency" => Array('element' => "style", 'value' => array('regular_underline')),
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("1px", "salient-core") => "1px",
				esc_html__("2px", "salient-core") => "2px",
				esc_html__("3px", "salient-core") => "3px",
				esc_html__("4px", "salient-core") => "4px"
			),
			'save_always' => true,
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Animation Delay", "salient-core"),
			"param_name" => "delay",
			"dependency" => Array('element' => "style", 'value' => array('regular_underline','half_text','full_text','scribble')),
			"description" => esc_html__("Enter delay (in milliseconds) if needed e.g. 150.", "salient-core")
		),

		array(
			"type" => 'checkbox',
			"dependency" => Array('element' => "style", 'value' => array('regular_underline','half_text','full_text','scribble')),
			"heading" => esc_html__("Disable Animation on Mobile", "salient-core"),
			"param_name" => "disable_mobile_animation",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => '',
			"value" => array(esc_html__("Yes, please", "salient-core") => 'true'),
		),

		array(
			"type" => "textfield",
			"heading" => '<span class="group-title">' . esc_html__("Custom Font Size", "salient-core") . "</span>",
			"edit_field_class" => "desktop font-size-device-group",
			"admin_label" => true,
			"param_name" => "custom_font_size",
		),
		array(
			"type" => "textfield",
			"heading" => '',
			"edit_field_class" => "tablet font-size-device-group",
			"param_name" => "font_size_tablet",
		),
		array(
			"type" => "textfield",
			"heading" => '',
			"edit_field_class" => "phone font-size-device-group",
			"param_name" => "font_size_phone",
		),
		array(
			"type" => "textfield",
			"heading" =>  esc_html__("Custom Line Height", "salient-core"),
			"param_name" => "font_line_height",
		),

		array(
			"type" => "textfield",
			"heading" => esc_html__("Highlight ID", "salient-core"),
			"param_name" => "id",
			"description" => esc_html__("Enter an ID that will be added to your highlighted word. You can use this for targeting the highlighted word with CSS or other elements. When using multiple highlights, an integer will automatically be added on to the end of each ID in the format {id}-{number}", "salient-core")
		),
		
	)
);

?>