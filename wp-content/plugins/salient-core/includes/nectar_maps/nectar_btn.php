<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3",
	esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Button", "salient-core"),
	"base" => "nectar_btn",
	"icon" => "icon-wpb-btn",
	"category" => esc_html__('Interactive', 'salient-core'),
	"weight" => 9,
	"description" => esc_html__('Add a button', 'salient-core'),
	"params" => array(
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Text", "salient-core"),
			"param_name" => "text",
			"admin_label" => true,
			"description" => esc_html__("The text for your button." , "salient-core")
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Size', 'salient-core' ),
			'value' => array(
				esc_html__( 'Small', 'salient-core' ) => 'small',
				esc_html__( 'Medium', 'salient-core' ) => 'medium',
				esc_html__( 'Large', 'salient-core' ) => 'large',
				esc_html__( 'Jumbo', 'salient-core' ) => 'jumbo',
				esc_html__( 'Extra Jumbo', 'salient-core' ) => 'extra_jumbo',
			),
			'save_always' => true,
			'param_name' => 'size',
			'description' => __( 'Select your button size.', 'salient-core' ),
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
			"edit_field_class" => "no-device-group constrain-icon",
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
			"edit_field_class" => "no-device-group constrain-icon",
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
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Link", "salient-core" ),
		 "param_name" => "group_header_1",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
	 
		array(
			"type" => "textfield",
			"heading" => esc_html__("Link URL", "salient-core"),
			"param_name" => "url",
			"description" => esc_html__("The link for your button." , "salient-core")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Open Link In New Tab?", "salient-core"),
			"param_name" => "open_new_tab",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes", "salient-core") => 'true'),
			"description" => ""
		),
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Styling", "salient-core" ),
		 "param_name" => "group_header_2",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
	 
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'salient-core' ),
			'value' => array(
				esc_html__( 'Regular', 'salient-core' ) => 'regular',
				esc_html__( 'Regular With Tilt', 'salient-core' ) => 'regular-tilt',
				esc_html__( 'See Through', 'salient-core' ) => 'see-through',
				esc_html__( 'See Through Solid On Hover', 'salient-core' ) => 'see-through-2',
				esc_html__( 'See Through Solid On Hover Alt', 'salient-core' ) => 'see-through-3',
				esc_html__( 'See Through 3D', 'salient-core' ) => 'see-through-3d',
			),		
			'save_always' => true,
			'param_name' => 'button_style',
			'description' => __( 'Select your button style.', 'salient-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Button Color', 'salient-core' ),
			'value' => array(
				esc_html__( "Accent Color", "salient-core") => "Accent-Color",
				esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
				esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
				esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3",
			),
			'dependency' => array(
				'element' => 'button_style',
				'value' => array('regular-tilt'),
			),
			'save_always' => true,
			'param_name' => 'button_color',
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Button Color', 'salient-core' ),
			'value' => $el_color_list,
			'save_always' => true,
			'dependency' => array(
				'element' => 'button_style',
				'value' => array('regular','see-through'),
			),
			'param_name' => 'button_color_2',
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Button Color Override",
			"param_name" => "color_override",
			"value" => "",
			"description" => "won't take effect on gradient colored btns",	
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Button Text Color Override",
			"param_name" => "solid_text_color_override",
			"dependency" => array('element' => "button_style", 'value' => array('regular','regular-tilt')),
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Hover BG Color",
			"param_name" => "hover_color_override",
			"dependency" => array('element' => "button_style", 'value' => array('see-through-2','see-through-3')),
			"value" => "",
			"description" => ""
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Hover Text Color', 'salient-core' ),
			'value' => array(
				esc_html__( 'Light', 'salient-core' ) => '#ffffff',
				esc_html__( 'Dark', 'salient-core' ) => '#000000'
			),
			'save_always' => true,
			'param_name' => 'hover_text_color_override',
			"dependency" => array('element' => "button_style", 'value' => array('see-through-2','see-through-3')),
			'description' => esc_html__( 'Select the color that will be used for the text on hover', 'salient-core' ),
		),
		array(
			'type' => 'animation_style',
			'heading' => 'CSS Animation',
			'param_name' => 'css_animation'
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'salient-core' ),
			'value' => array(
				esc_html__( 'None', 'salient-core' ) => 'none',
				esc_html__( 'Default Arrow', 'salient-core' ) => 'default_arrow',
				esc_html__( 'Font Awesome', 'salient-core' ) => 'fontawesome',
				esc_html__( 'Iconsmind', 'salient-core' ) => 'iconsmind',
				esc_html__( 'Steadysets', 'salient-core' ) => 'steadysets',
				esc_html__( 'Linecons', 'salient-core' ) => 'linecons',
			),
			'save_always' => true,
			'param_name' => 'icon_family',
			"dependency" => array('element' => "button_style", 'value' => array('regular','regular-tilt','see-through','see-through-2','see-through-3')),
			'description' => esc_html__( 'Select icon library.', 'salient-core' ),
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_fontawesome",
			"settings" => array( "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'emptyIcon' => false, 'value' => 'fontawesome'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_iconsmind",
			"settings" => array( 'type' => 'iconsmind', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_linecons",
			"settings" => array( 'type' => 'linecons', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'linecons'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "salient-core"),
			"param_name" => "icon_steadysets",
			"settings" => array( 'type' => 'steadysets', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
			"description" => esc_html__("Select icon from library.", "salient-core")
		),
		
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Advanced", "salient-core" ),
		 "param_name" => "group_header_3",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
	 array(
		 "type" => "checkbox",
		 "class" => "",
		 "heading" => esc_html__("Nofollow Link", "salient-core"),
		 "param_name" => "nofollow",
		 'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
		 "value" => Array(esc_html__("Yes", "salient-core") => 'true'),
		 "description" => ""
	 ),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Extra Class Name",
			"param_name" => "el_class",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Button ID",
			"param_name" => "button_id",
			"value" => "",
			"description" => esc_html__("Use this field to add an optional ID onto your button.", "salient-core")
		),
	)
);

?>