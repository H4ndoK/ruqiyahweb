<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

$el_color_list = array(
    esc_html__("Accent Color", "salient-core") => "accent-color",
	esc_html__("Extra Color 1", "salient-core") => "extra-color-1",
	esc_html__("Extra Color 2", "salient-core") => "extra-color-2",
	esc_html__("Extra Color 3", "salient-core") => "extra-color-3",
	esc_html__("Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__("Color Gradient 2", "salient-core") => "extra-color-gradient-2"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

$badge_params = array(
	array(
		"type" => "textfield",
		"heading" => esc_html__("Badge Text", "salient-core"),
		"param_name" => "text",
		"admin_label" => true,
		"description" => esc_html__("The text that will be used for the badge.", "salient-core")
	),
	array(
		"type" => "dropdown",
		"class" => "",
		'save_always' => true,
		"heading" => esc_html__("Inherit Typography From", "salient-core"),
		"param_name" => "display_tag",
		"value" => array(
			"Body" => "body",
			"Label" => "label",
			"Italic" => "italic",
			"H6" => "h6",
			"H5" => "h5",
			"H4" => "h4",
			"H3" => "h3",
			"H2" => "h2",
			"H1" => "h1",
		)
	),
	array(
		'type' => 'dropdown',
		'heading' => __('Badge Style', 'salient-core'),
		'value' => array(
			esc_html__('Colored Background', 'salient-core') => 'default',
			esc_html__('Minimal Line', 'salient-core') => 'line',
		),
		'save_always' => true,
		'param_name' => 'badge_style',
		'description' => '',
	),
	array(
		'type' => 'dropdown',
		'heading' => __('Background color type', 'salient-core'),
		'value' => array(
			esc_html__('Global Color Scheme', 'salient-core') => 'global',
			esc_html__('Custom Color', 'salient-core') => 'custom',
		),
		'dependency' => array(
			'element' => 'badge_style',
			'value' => array('default'),
		),
		'save_always' => true,
		'param_name' => 'bg_color_type',
		'description' => '',
	),
	array(
		'type' => 'dropdown',
		'heading' => __('Badge Background Color', 'salient-core'),
		'value' => $el_color_list,
		'save_always' => true,
		'dependency' => array(
			'element' => 'bg_color_type',
			'value' => array('global', 'see-through'),
		),
		'param_name' => 'color',
		'description' => __('Choose a color from your', 'salient-core') . ' <a target="_blank" href="' . esc_url(NectarThemeInfo::global_colors_tab_url()) . '"> ' . esc_html__('globally defined color scheme', 'salient-core') . '</a>',
	),
	array(
		"type" => "colorpicker",
		"class" => "",
		'heading' => __('Badge Background Color', 'salient-core'),
		"param_name" => "bg_color_custom",
		"value" => "",
		'dependency' => array(
			'element' => 'bg_color_type',
			'value' => array('custom', 'see-through'),
		),
		"description" => '',
	),
	array(
		"type" => "colorpicker",
		"class" => "",
		'heading' => __('Badge Text Color', 'salient-core'),
		"param_name" => "text_color",
		"value" => "",
		"description" => '',
	),
	array(
		"type" => "dropdown",
		"heading" => esc_html__("Padding Amount", "salient-core"),
		'save_always' => true,
		"param_name" => "padding",
		'dependency' => array(
			'element' => 'badge_style',
			'value' => array('default'),
		),
		"value" => array(
			esc_html__("Small", "salient-core") => "small",
			esc_html__("Medium", "salient-core") => "medium",
			esc_html__("Large", "salient-core") => "large",
			esc_html__("None", "salient-core") => "none"
		)
	),

	array(
		"type" => "dropdown",
		"heading" => esc_html__("Border Radius", "salient-core"),
		'save_always' => true,
		"param_name" => "border_radius",
		'dependency' => array(
			'element' => 'badge_style',
			'value' => array('default'),
		),
		"value" => array(
			esc_html__("0px", "salient-core") => "0px",
			esc_html__("3px", "salient-core") => "3px",
			esc_html__("5px", "salient-core") => "5px",
			esc_html__("10px", "salient-core") => "10px",
			esc_html__("15px", "salient-core") => "15px",
			esc_html__("20px", "salient-core") => "20px"
		),
	),

	array(
		"type" => "nectar_numerical",
		"class" => "",
		"heading" => esc_html__("Line Width", "salient-core"),
		"value" => "",
		'dependency' => array(
			'element' => 'badge_style',
			'value' => array('line'),
		),
		"placeholder" => '',
		"param_name" => "line_width",
		"description" => ""
	),

	array(
		"type" => "dropdown",
		"heading" => esc_html__("Display", "salient-core"),
		'save_always' => true,
		"param_name" => "display",
		'dependency' => array(
			'element' => 'badge_style',
			'value' => array('default'),
		),
		"value" => array(
			esc_html__("Block", "salient-core") => "block",
			esc_html__("Inline", "salient-core") => "inline",
		)
	),
	array(
		"type" => "nectar_numerical",
		"heading" => esc_html__("Margin", "salient-core") . "<span>" . esc_html__("Top", "salient-core") . "</span>",
		"param_name" => "margin_top",
		"placeholder" => esc_html__("Top", 'salient-core'),
		"edit_field_class" => "col-md-2-first col-md-2 no-device-group constrain_group_1",
		"description" => ''
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__('Constrain 1', 'salient-core'),
		'param_name' => 'constrain_group_1',
		'description' => '',
		"edit_field_class" => "no-device-group constrain-icon",
		'value' => array(esc_html__('Yes', 'salient-core') => 'yes'),
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Bottom", "salient-core") . "</span>",
		"param_name" => "margin_bottom",
		"placeholder" => esc_html__("Bottom", 'salient-core'),
		"edit_field_class" => "col-md-2 no-device-group constrain_group_1",
		"description" => ''
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Left", "salient-core") . "</span>",
		"param_name" => "margin_left",
		"placeholder" => esc_html__("Left", 'salient-core'),
		"edit_field_class" => "col-md-2 no-device-group constrain_group_2",
		"description" => ''
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__('Constrain 2', 'salient-core'),
		'param_name' => 'constrain_group_2',
		'description' => '',
		"edit_field_class" => "no-device-group constrain-icon",
		'value' => array(esc_html__('Yes', 'salient-core') => 'yes'),
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Right", "salient-core") . "</span>",
		"param_name" => "margin_right",
		"placeholder" => esc_html__("Right", 'salient-core'),
		"edit_field_class" => "col-md-2 no-device-group constrain_group_2",
		"description" => ''
	),

);

$position_group = SalientWPbakeryParamGroups::position_group( esc_html__( 'Positioning', 'salient-core' ), false );

$imported_groups = array($position_group);

foreach ($imported_groups as $group) {

    foreach ($group as $option) {
        $badge_params[] = $option;
    }
}


return array(
	"name" => esc_html__("Badge", "salient-core"),
	"base" => "heading",
	"icon" => "icon-wpb-badge",
	"category" => esc_html__('Typography', 'salient-core'),
	"description" => esc_html__('Badge Label', 'salient-core'),
	"params" => $badge_params
);
