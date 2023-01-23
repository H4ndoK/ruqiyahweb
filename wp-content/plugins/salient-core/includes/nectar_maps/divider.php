<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Default (inherit from row Text Color)", "salient-core") => "default",
	esc_html__( "Accent Color", "salient-core") => "accent-color",
	esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
	esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
	esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2",
	esc_html__( "Black", "salient-core") => "black",
	esc_html__( "White", "salient-core") => "white"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Divider","salient-core"),
	"base" => "divider",
	"icon" => "icon-wpb-separator",
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Structure', 'salient-core'),
	"description" => esc_html__('Create space between your content', 'salient-core'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => '<span class="group-title">' . esc_html__("Dividing Height", "salient-core") . "</span>",
			"param_name" => "custom_height",
			"edit_field_class" => "desktop divider-height-device-group",
			"description" => esc_html__("If you would like to control the specific number of pixels your divider is, enter it here.", "salient-core"),
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => '',
			"param_name" => "custom_height_tablet",
			"edit_field_class" => "tablet divider-height-device-group",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => '',
			"param_name" => "custom_height_phone",
			"edit_field_class" => "phone divider-height-device-group",
			"description" => '',
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Line Type", "salient-core"),
			'save_always' => true,
			"param_name" => "line_type",
			"value" => array(
				"No Line" => "No Line",
				"Full Width Line" => "Full Width Line",
				"Small Line" => "Small Line",
        "Vertical Line" => "Vertical Line"
			)
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Line Alignment", "salient-core"),
			'save_always' => true,
			"admin_label" => false,
			"param_name" => "line_alignment",
			"dependency" => Array('element' => "line_type", 'value' => array('Small Line')),
			"value" => array(
				"Default" => "default",
				"Center" => "center",
				"Right" => "right"
			)
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Line Thickness", "salient-core"),
			"admin_label" => false,
			"param_name" => "line_thickness",
			"value" => array(
				"1px" => "1",
				"2px" => "2",
				"3px" => "3",
				"4px" => "4",
				"5px" => "5",
				"6px" => "6",
				"7px" => "7",
				"8px" => "8",
				"9px" => "9",
				"10px" => "10"
			),
			"description" => esc_html__("Please select thickness of your line ", "salient-core"),
			'save_always' => true,
			"dependency" => Array('element' => "line_type", 'value' => array('Full Width Line','Small Line'))
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"admin_label" => false,
			"class" => "",
			"heading" => esc_html__("Custom Line Width", "salient-core"),
			"param_name" => "custom_line_width",
			"dependency" => Array('element' => "line_type", 'value' => array('Small Line')),
			"description" => esc_html__("If you would like to control the specifc number of pixels that your divider is (width wise), enter it here. Don't enter \"px\", just the numnber e.g. \"20\"", "salient-core"),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Divider Color", "salient-core"),
			"param_name" => "divider_color",
			"admin_label" => false,
			"value" => $el_color_list,
			'save_always' => true,
			"dependency" => Array('element' => "line_type", 'value' => array('Full Width Line','Small Line','Vertical Line')),
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),

		array(
			'type' => 'nectar_range_slider',
			'heading' => esc_html__('Opacity', 'salient-core'),
			'param_name' => 'divider_opacity',
			'value' => '100',
			'options' => array(
				'min' => '0',
				'max' => '100',
				'step' => '1',
				'suffix' => '%'
			),
			'description' => ''
		),

		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Animate Line", "salient-core"),
			"param_name" => "animate",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("If selected, the divider line will animate in when scrolled to", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
			"dependency" => Array('element' => "line_type", 'value' => array('Full Width Line','Small Line')),
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Animation Delay", "salient-core"),
			"param_name" => "delay",
			"dependency" => Array('element' => "line_type", 'value' => array('Full Width Line','Small Line')),
			"description" => esc_html__("Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in \"one by one\" effect.", "salient-core")
		),
		
	)
);

?>