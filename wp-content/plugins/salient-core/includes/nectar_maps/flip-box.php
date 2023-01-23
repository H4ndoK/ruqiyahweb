<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Accent Color", "salient-core") => "accent-color",
	esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
	esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
	esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Flip Box", "salient-core"),
	"base" => "nectar_flip_box",
	"icon" => "icon-wpb-nectar-flip-box",
	"category" => esc_html__('Interactive', 'salient-core'),
	"description" => esc_html__('Add a flip box element', 'salient-core'),
	"params" => array(
		array(
			"type" => "textarea",
			"heading" => esc_html__("Front Box Content", "salient-core"),
			"param_name" => "front_content",
			"description" => esc_html__("The text that will display on the front of your flip box", "salient-core"),
			"group" => esc_html__('Front Side', 'salient-core')
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Background Image", "salient-core"),
			"param_name" => "image_url_1",
			"value" => "",
			"group" => esc_html__('Front Side', 'salient-core'),
			"description" => esc_html__("Select a background image from the media library.", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Background Color", "salient-core"),
			"group" => esc_html__('Front Side', 'salient-core'),
			"param_name" => "bg_color",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("BG Color overlay on BG Image", "salient-core"),
			"param_name" => "bg_color_overlay",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"group" => esc_html__('Front Side', 'salient-core'),
			"description" => esc_html__("Checking this will overlay your BG color on your BG image", "salient-core"),
			"value" => Array(esc_html__("Yes", "salient-core") => 'true')
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"group" => esc_html__('Front Side', 'salient-core'),
			"heading" => esc_html__("Text Color", "salient-core"),
			"param_name" => "text_color",
			"value" => array(
				"Dark" => "dark",
				"Light" => "light"
			),
			'save_always' => true
		),	 
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'js_composer' ),
			"group" => esc_html__('Front Side', 'salient-core'),
			'value' => array(
				__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
				__( 'Iconsmind', 'js_composer' ) => 'iconsmind',
				__( 'Linea', 'js_composer' ) => 'linea',
				__( 'Steadysets', 'js_composer' ) => 'steadysets',
			),
			'param_name' => 'icon_family',
			'description' => __( 'Select icon library.', 'js_composer' ),
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon Above Title", "salient-core"),
			"param_name" => "icon_fontawesome",
			"group" => esc_html__('Front Side', 'salient-core'),
			"settings" => array( "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "icon_family", 'value' => 'fontawesome'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "js_composer"),
			"param_name" => "icon_iconsmind",
			"group" => esc_html__('Front Side', 'salient-core'),
			"settings" => array( 'type' => 'iconsmind', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon Above Title", "js_composer"),
			"param_name" => "icon_linea",
			"group" => esc_html__('Front Side', 'salient-core'),
			"settings" => array( 'type' => 'linea', "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "icon_family", 'value' => 'linea'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "js_composer"),
			"param_name" => "icon_steadysets",
			"group" => esc_html__('Front Side', 'salient-core'),
			"settings" => array( 'type' => 'steadysets', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Icon Color", "salient-core"),
			"param_name" => "icon_color",
			"group" => esc_html__('Front Side', 'salient-core'),
			"value" => $el_color_list,
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "textfield",
			"group" => esc_html__('Front Side', 'salient-core'),
			"heading" => esc_html__("Icon Size", "salient-core"),
			"param_name" => "icon_size",
			"description" => esc_html__("Please enter the size for your icon. Enter in number of pixels - Don't enter \"px\", default is \"60\"", "salient-core"),
			"group" => esc_html__('Front Side', 'salient-core')
		),
		array(
			"type" => "textarea_html",
			"heading" => esc_html__("Back Box Content", "salient-core"),
			"param_name" => "content",
			"admin_label" => true,
			"group" =>  esc_html__("Back Side", "salient-core"),
			"description" => esc_html__("The content that will display on the back of your flip box", "salient-core")
		),	
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Background Image", "salient-core"),
			"param_name" => "image_url_2",
			"value" => "",
			"group" =>  esc_html__("Back Side", "salient-core"),
			"description" => esc_html__("Select a background image from the media library.", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Background Color", "salient-core"),
			"group" =>  esc_html__("Back Side", "salient-core"),
			"param_name" => "bg_color_2",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("BG Color overlay on BG Image", "salient-core"),
			"param_name" => "bg_color_overlay_2",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"group" =>  esc_html__("Back Side", "salient-core"),
			"description" => esc_html__("Checking this will overlay your BG color on your BG image", "salient-core"),
			"value" => Array(esc_html__("Yes", "js_composer") => 'true')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"group" =>  esc_html__("Back Side", "salient-core"),
			"heading" => esc_html__("Text Color", "salient-core"),
			"param_name" => "text_color_2",
			"value" => array(
				"Dark" => "dark",
				"Light" => "light"
			),
			'save_always' => true
		), 
		array(
			"type" => "textfield",
			"heading" => esc_html__("Min Height", "salient-core"),
			"param_name" => "min_height",
			"admin_label" => false,
			"group" => esc_html__("General Settings", "salient-core"),
			"description" => esc_html__("Please enter the minimum height you would like for you box.", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Horizontal Content Alignment", "salient-core"),
			"param_name" => "h_text_align",
			"group" => esc_html__("General Settings", "salient-core"),
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Vertical Content Alignment", "salient-core"),
			"param_name" => "v_text_align",
			"group" => esc_html__("General Settings", "salient-core"),
			"value" => array(
				"Top" => "top",
				"Center" => "center",
				"Bottom" => "bottom"
			)
		),
		
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Loading", "salient-core"),
      "param_name" => "image_loading",
			"group" => esc_html__("General Settings", "salient-core"),
      "value" => array(
        "Default" => "default",
				"Lazy Load" => "lazy-load",
      ),
			"description" => esc_html__("Determine whether to load the image on page load or to use a lazy load method for higher performance.", "salient-core"),
      'std' => 'default',
    ),
		
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Flip Direction", "salient-core"),
			"param_name" => "flip_direction",
			"group" => esc_html__("General Settings", "salient-core"),
			"value" => array(
				esc_html__( "Horizontal To Left", "salient-core") => "horizontal-to-left",
				esc_html__( "Horizontal To Right", "salient-core") => "horizontal-to-right",
				esc_html__( "Vertical To Bottom", "salient-core") => "vertical-to-bottom",
				esc_html__( "Vertical To Top", "salient-core") => "vertical-to-top"
			)
		)
	)
);

?>