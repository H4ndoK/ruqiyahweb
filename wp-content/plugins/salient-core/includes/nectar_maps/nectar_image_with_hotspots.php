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
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Image With Hotspots", "salient-core"),
	"base" => "nectar_image_with_hotspots",
	"weight" => 1,
	"icon" => "icon-wpb-nectar-image-withhotspots",
	"category" => esc_html__('Interactive', 'salient-core'),
	"description" => esc_html__('Add Hotspots On Your Image', 'salient-core'),
	"params" => array(
		
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => "Image",
			"value" => "",
			"param_name" => "image",
			"description" => "Choose your image that will show the hotspots. <br/> You can then click on the image in the preview area to add your hotspots in the desired locations."
		),
		array(
			"type" => "hotspot_image_preview",
			"heading" => esc_html__("Preview", "salient-core"),
			"param_name" => "preview",
			"description" => esc_html__("Click to add - Drag to move - Edit content below. Note: this preview will not reflect hotspot style choices or show tooltips. This is only used as a visual guide for positioning. Requires Salient WPBakery Page Builder v4.12 or higher.", "salient-core"),
			"value" => ''
		),	
		array(
			"type" => "textarea_html",
			"heading" => esc_html__("Hotspots", "salient-core"),
			"param_name" => "content",
			"description" => '',
		),	 
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"group" => "Style",
			"heading" => "Color",
			"admin_label" => true,
			"param_name" => "color_1",
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
			"value" => $el_color_list
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"group" => esc_html__( "Style", "salient-core"),
			"heading" => "Hotspot Icon",
			"description" => esc_html__("The icon that will be shown on the hotspots", "salient-core"),
			"param_name" => "hotspot_icon",
			"admin_label" => true,
			"value" => array(
				esc_html__( "Plus Sign", "salient-core") => "plus_sign",
				esc_html__( "Numerical", "salient-core") => "numerical"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"group" => esc_html__( "Style", "salient-core"),
			"heading" => "Tooltip Functionality",
			"param_name" => "tooltip",
			"description" => esc_html__("Select how you want your tooltips to display to the user", "salient-core"),
			"value" => array(
				"Show On Hover" => "hover",
				"Show On Click" => "click",
				"Always Show" => "always_show"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"group" => esc_html__( "Style", "salient-core"),
			"heading" => esc_html__("Tooltip Shadow", "salient-core"),
			"param_name" => "tooltip_shadow",
			"description" => esc_html__("Select the shadow size for your tooltip", "salient-core"),
			"value" => array(esc_html__("None", "salient-core") => "none", esc_html__("Small Depth", "salient-core") => "small_depth", esc_html__("Medium Depth", "salient-core") => "medium_depth", esc_html__("Large Depth", "salient-core") => "large_depth"),
		),
		array(
			"type" => 'checkbox',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Enable Animation", "salient-core"),
			"param_name" => "animation",
			"group" => esc_html__( "Style", "salient-core"),
			"description" => esc_html__("Turning this on will make your hotspots animate in when the user scrolls to the element", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		)
	)
);

?>