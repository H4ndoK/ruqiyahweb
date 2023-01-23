<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Column", "salient-core" ),
	"base" => "vc_column_inner",
	"class" => "",
	"icon" => "",
	"wrapper_class" => "",
	"controls" => "full",
	"allowed_container_element" => false,
	"content_element" => false,
	"is_container" => true,
	"params" => array(
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => "Enable Animation",
			"value" => array("Enable Column Animation?" => "true" ),
			"param_name" => "enable_animation",
			"description" => ""
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Animation",
			"param_name" => "animation",
			"value" => array(
				esc_html__("None", "salient-core") => "none",
				esc_html__("Fade In", "salient-core") => "fade-in",
				esc_html__("Fade In From Left", "salient-core") => "fade-in-from-left",
				esc_html__("Fade In Right", "salient-core") => "fade-in-from-right",
				esc_html__("Fade In From Bottom", "salient-core") => "fade-in-from-bottom",
				esc_html__("Grow In", "salient-core") => "grow-in",
				esc_html__("Flip In Horizontal", "salient-core") => "flip-in",
				esc_html__("Flip In Vertical", "salient-core") => "flip-in-vertical",
				esc_html__("Reveal From Right", "salient-core") => "reveal-from-right",
				esc_html__("Reveal From Bottom", "salient-core") => "reveal-from-bottom",
				esc_html__("Reveal From Left", "salient-core") => "reveal-from-left",
				esc_html__("Reveal From Top", "salient-core") => "reveal-from-top"		
			),
			"dependency" => Array('element' => "enable_animation", 'not_empty' => true)
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Animation Delay",
			"param_name" => "delay",
			"admin_label" => false,
			"description" => esc_html__("Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in \"one by one\" effect.", "salient-core"),
			"dependency" => Array('element' => "enable_animation", 'not_empty' => true)
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Boxed Column", "salient-core"),
			"value" => array("Boxed Style" => "true" ),
			"param_name" => "boxed",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => ""
		),
		
		array(
			"type" => "fws_image",
			"class" => "",
			"heading" => esc_html__("Background Image", "salient-core"),
			"param_name" => "background_image",
			"value" => "",
			"description" => "",
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Scale Background Image To Column", "salient-core"),
			"value" => array("Enable" => "true" ),
			"param_name" => "enable_bg_scale",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => "",
			"dependency" => array('element' => "background_image", 'not_empty' => true)
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Column Padding", "salient-core"),
			"param_name" => "column_padding",
			"value" => array(
				"None" => "no-extra-padding",
				"1%" => "padding-1-percent",
				"2%" => "padding-2-percent",
				"3%" => "padding-3-percent",
				"4%" => "padding-4-percent",
				"5%" => "padding-5-percent",
				"6%" => "padding-6-percent",
				"7%" => "padding-7-percent",
				"8%" => "padding-8-percent",
				"9%" => "padding-9-percent",
				"10%" => "padding-10-percent",
				"11%" => "padding-11-percent",
				"12%" => "padding-12-percent",
				"13%" => "padding-13-percent",
				"14%" => "padding-14-percent",
				"15%" => "padding-15-percent",
				"16%" => "padding-16-percent",
				"17%" => "padding-17-percent"
			),
			"description" => esc_html__("When using the full width content row type or providing a background color/image for the column, you have the option to define the amount of padding your column will receive.", "salient-core" )
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Column Padding Position",
			"param_name" => "column_padding_position",
			"value" => array(
				esc_html__('All Sides', 'salient-core') => 'all',
				esc_html__('Top', 'salient-core') => "top",
				esc_html__('Right', 'salient-core') => 'right',
				esc_html__('Left', 'salient-core') => 'left',
				esc_html__('Bottom', 'salient-core') => 'bottom',
				esc_html__('Left + Right', 'salient-core') => 'left-right',
				esc_html__('Top + Right', 'salient-core') => 'top-right',
				esc_html__('Top + Left', 'salient-core') => 'top-left',
				esc_html__('Top + Bottom', 'salient-core') => 'top-bottom',
				esc_html__('Bottom + Right', 'salient-core') => 'bottom-right',
				esc_html__('Bottom + Left', 'salient-core') => 'bottom-left',
			),
			"description" => esc_html__("Use this to fine tune where the column padding will take effect", "salient-core")
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Background Color", "salient-core"),
			"param_name" => "background_color",
			"value" => "",
			"description" => "",
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Background Color Opacity", "salient-core" ),
			"param_name" => "background_color_opacity",
			"value" => array(
				"1" => "1",
				"0.9" => "0.9",
				"0.8" => "0.8",
				"0.7" => "0.7",
				"0.6" => "0.6",
				"0.5" => "0.5",
				"0.4" => "0.4",
				"0.3" => "0.3",
				"0.2" => "0.2",
				"0.1" => "0.1",
			)
			
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Centered Content", "salient-core"),
			"value" => array("Centered Content Alignment" => "true" ),
			"param_name" => "centered_text",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => ""
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Column Link", "salient-core" ),
			"param_name" => "column_link",
			"admin_label" => false,
			"description" => esc_html__("If you wish for this column to link somewhere, enter the URL in here", "salient-core" ),
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Extra Class Name", "salient-core" ),
			"param_name" => "el_class",
			"value" => ""
		),
		
		array(
			'type' => 'dropdown',
			'save_always' => true,
			'heading' => esc_html__('Width', 'salient-core' ),
			'param_name' => 'width',
			'value' => $vc_column_width_list,
			'group' => esc_html__('Responsive Options', 'salient-core' ),
			'description' => esc_html__('Select column width.', 'salient-core' ),
			'std' => '1/1'
		),
		array(
			'type' => 'column_offset',
			'heading' => esc_html__('Responsiveness', 'salient-core' ),
			'param_name' => 'offset',
			'group' => esc_html__('Responsive Options', 'salient-core' ),
			'description' => esc_html__('Adjust column for different screen sizes. Control width, offset and visibility settings.', 'salient-core' )
		)
	),
	"js_view" => 'VcColumnView'
);

?>