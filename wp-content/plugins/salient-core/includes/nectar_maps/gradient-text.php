<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Gradient Text", "salient-core"),
	"base" => "nectar_gradient_text",
	"icon" => "icon-wpb-nectar-gradient-text",
	"category" => esc_html__('Typography', 'salient-core'),
	"description" => esc_html__('Add text with gradient coloring', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Heading Tag", "salient-core"),
			"param_name" => "heading_tag",
			"value" => array(
				"H1" => "h1",
				"H2" => "h2",
				"H3" => "h3",
				"H4" => "h4",
				"H5" => "h5",
				"H6" => "h6"
			)),
			array(
				"type" => "dropdown",
				"class" => "",
				'save_always' => true,
				"heading" => esc_html__("Text Color", "salient-core"),
				"param_name" => "color",
				"admin_label" => false,
				"value" => array(
					esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
					esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
				),
				'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . __('globally defined color scheme','salient-core') . '</a> <br/> Will fallback to the first color of the gradient on non webkit browsers.',
			),
			array(
				"type" => "dropdown",
				"class" => "",
				'save_always' => true,
				"heading" => esc_html__("Gradient Direction", "salient-core"),
				"param_name" => "gradient_direction",
				"admin_label" => false,
				"value" => array(
					esc_html__( "Horizontal", "salient-core") => "horizontal",
					esc_html__( "Diagonal", "salient-core") => "diagonal"
				),
				"description" => esc_html__("Select your desired gradient direction", "salient-core"),
			),
			array(
				"type" => "textarea",
				"heading" => esc_html__("Text Content", "salient-core"),
				"param_name" => "text",
				"admin_label" => true,
				"description" => esc_html__("The text that will display with gradient coloring", "salient-core")
			),
			array(
				"type" => "nectar_numerical",
				"heading" => esc_html__("Margin", "salient-core") . "<span>" . esc_html__("Top", "salient-core") . "</span>",
				"param_name" => "margin_top",
				"placeholder" => esc_html__("Top",'salient-core'),
				"edit_field_class" => "col-md-2 no-device-group constrain_group_1",
				"description" => ''
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Constrain 1', 'salient-core' ),
				'param_name' => 'constrain_group_1', 
				'description' => '',
				"edit_field_class" => "constrain-icon no-device-group",
				'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
			),
			array(
				"type" => "nectar_numerical",
				"heading" => "<span>" . esc_html__("Bottom", "salient-core") . "</span>",
				"param_name" => "margin_bottom",
				"placeholder" => esc_html__("Bottom",'salient-core'),
				"edit_field_class" => "col-md-2 no-device-group constrain_group_1",
				"description" => ''
			),
			
			array(
				"type" => "nectar_numerical",
				"heading" => "<span>" . esc_html__("Left", "salient-core") . "</span>",
				"param_name" => "margin_left",
				"placeholder" => esc_html__("Left",'salient-core'),
				"edit_field_class" => "col-md-2 no-device-group constrain_group_2",
				"description" => ''
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Constrain 2', 'salient-core' ),
				'param_name' => 'constrain_group_2', 
				'description' => '',
				"edit_field_class" => "constrain-icon no-device-group",
				'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
			),
			array(
				"type" => "nectar_numerical",
				"heading" => "<span>" . esc_html__("Right", "salient-core") . "</span>",
				"param_name" => "margin_right",
				"placeholder" => esc_html__("Right",'salient-core'),
				"edit_field_class" => "col-md-2 no-device-group constrain_group_2",
				"description" => ''
			),
		)
	);
	?>