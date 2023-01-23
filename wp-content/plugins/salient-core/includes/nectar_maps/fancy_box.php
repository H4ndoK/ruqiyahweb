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
	"name" => esc_html__("Fancy Box", "salient-core"),
	"base" => "fancy_box",
	"icon" => "icon-wpb-fancy-box",
  'weight' => '10',
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Add a fancy box element', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", "salient-core"),
			"param_name" => "box_style",
			"value" => array(
				esc_html__( "Bottom Color Bar Hover Effect", "salient-core") => "default",
				esc_html__( "Color Box Hover Effect", "salient-core") => "color_box_hover",
				esc_html__( "Color Box Basic", "salient-core") => "color_box_basic",
				esc_html__( "Parallax Hover Effect", "salient-core") => "parallax_hover",
				esc_html__( "Description on Hover", "salient-core") => "hover_desc",
				esc_html__( "Image Above Text", "salient-core") => "image_above_text_underline",
			),
			'save_always' => true,
			'description' => __( 'Choose your desired style here.', 'salient-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'js_composer' ),
			'value' => array(
				esc_html__( 'None', 'js_composer' ) => 'none',
				esc_html__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
				esc_html__( 'Iconsmind', 'js_composer' ) => 'iconsmind',
				esc_html__( 'Linea', 'js_composer' ) => 'linea',
				esc_html__( 'Steadysets', 'js_composer' ) => 'steadysets',
				esc_html__( 'Linecons', 'js_composer' ) => 'linecons',
				esc_html__( 'Custom', 'js_composer' ) => 'custom',
			),
			'save_always' => true,
			'param_name' => 'icon_family',
			"dependency" => array('element' => "box_style", 'value' => array('default','color_box_hover','color_box_basic','parallax_hover','hover_desc')),
			'description' => __( 'Select icon library.', 'js_composer' ),
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Custom Icon Image", "salient-core"),
			"param_name" => "custom_icon_image",
			"value" => "",
			"dependency" => array('element' => "icon_family", 'emptyIcon' => false, 'value' => 'custom'),
			"description" => esc_html__("Select a custom image to use as your icon from the media library.", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "js_composer"),
			"param_name" => "icon_fontawesome",
			"settings" => array( "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'emptyIcon' => false, 'value' => 'fontawesome'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "js_composer"),
			"param_name" => "icon_iconsmind",
			"settings" => array( 'type' => 'iconsmind', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "js_composer"),
			"param_name" => "icon_linea",
			"settings" => array( 'type' => 'linea', "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "icon_family", 'value' => 'linea'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "js_composer"),
			"param_name" => "icon_linecons",
			"settings" => array( 'type' => 'linecons', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'linecons'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Icon", "js_composer"),
			"param_name" => "icon_steadysets",
			"settings" => array( 'type' => 'steadysets', 'emptyIcon' => false, "iconsPerPage" => 240),
			"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
			"description" => esc_html__("Select icon from library.", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Icon Size", "js_composer"),
			"param_name" => "icon_size",
			"dependency" => array('element' => "icon_family", 'value' => array('fontawesome','iconsmind', 'linea', 'steadysets', 'linecons','custom')),
			"description" => esc_html__("Don't include \"px\" in your string. e.g. 40 - the default is 50" , "js_composer")
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Image", "salient-core"),
			"param_name" => "image_url",
			"value" => "",
			"description" => esc_html__("Select a background image from the media library.", "salient-core")
		),
		array(
      "type" => "textfield",
      "heading" => esc_html__("Image size", "salient-core"),
      "param_name" => "image_size",
      "description" => esc_html__("Optionally enter a custom WordPress image size. Example: \"thumbnail\", \"medium\", \"large\", \"full\".", "salient-core"),
		),
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Aspect Ratio", "salient-core"),
			"dependency" => array('element' => "box_style", 'value' => array('image_above_text_underline')),
      "param_name" => "image_aspect_ratio",
      "value" => array(
        "1:1" => "1-1",
				"16:9" => "16-9",
				"3:2" =>    "3-2",
				"4:3" => "4-3",
        "4:5" => "4-5",
      ),
      'std' => '1-1',
    ),
		array(
			"type" => "textarea_html",
			"heading" => esc_html__("Box Content", "salient-core"),
			"param_name" => "content",
			"admin_label" => true,
			"description" => esc_html__("Please enter the text desired for your box", "salient-core")
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Box Hover Content", "salient-core"),
			"param_name" => "hover_content",
			"admin_label" => true,
			"dependency" => array('element' => "box_style", 'value' => 'hover_desc'),
			"description" => esc_html__("Please enter the text desired for your box which will only be shown on hover", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Link URL", "salient-core"),
			"param_name" => "link_url",
			"admin_label" => false,
			"description" => esc_html__("Please enter the URL you would like for your box to link to", "salient-core")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Open Link In New Tab", "salient-core"),
			"value" => array("Yes, please" => "true" ),
			"param_name" => "link_new_tab",
			"description" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "link_url", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Link Screen Reader Text", "salient-core"),
			"param_name" => "link_screen_reader",
			"admin_label" => false,
			"dependency" => Array('element' => "link_url", 'not_empty' => true),
			"description" => 'Text to describe the link that will be used for screen reader accessibility.',
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Link Text", "salient-core"),
			"param_name" => "link_text",
			"admin_label" => false,
			"dependency" => array('element' => "box_style", 'value' => 'default'),
			"description" => esc_html__("Please enter the text that will be displayed for your box link", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => '<span class="group-title">' . esc_html__("Minimum Height", "salient-core") . "</span>",
			"param_name" => "min_height",
			"admin_label" => false,
			"edit_field_class" => "desktop fancybox-min-height-device-group",
			"description" => esc_html__("Please enter the minimum height you would like for you box. Enter in number of pixels - Don't enter \"px\", default is \"300\"", "salient-core")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => '',
			"param_name" => "min_height_tablet",
			"edit_field_class" => "tablet fancybox-min-height-device-group",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => '',
			"param_name" => "min_height_phone",
			"edit_field_class" => "phone fancybox-min-height-device-group",
			"description" => '',
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Box Color", "salient-core"),
			"param_name" => "color",
			"value" => $el_color_list,
			'save_always' => true,
			"dependency" => array('element' => "box_style", 'value' => array('default','color_box_hover')),
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Custom Box Color",
			"param_name" => "color_custom",
			"dependency" => array('element' => "box_style", 'value' => array('default','color_box_hover')),
			"value" => "",
			"description" => esc_html__('Optionally define a custom color outside of your global color scheme.', 'salient-core'),
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Hover Color", "salient-core"),
			"param_name" => "hover_color",
			"value" => array(
				esc_html__( "Accent Color", "salient-core") => "accent-color",
				esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
				esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",
				esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
			),
			'save_always' => true,
			"dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Custom Hover Color",
			"param_name" => "hover_color_custom",
			"dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
			"value" => "",
			"description" => esc_html__('Optionally define a custom color outside of your global color scheme.', 'salient-core'),
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Overlay Opacity", "salient-core"),
			"param_name" => "hover_desc_color_opacity",
			"edit_field_class" => "nectar-one-half",
			"value" => array(
				"Default" => "default",
				"0.9" => "0.9",
				"0.8" => "0.8",
				"0.7" => "0.7",
				"0.6" => "0.6",
				"0.5" => "0.5",
				"0.4" => "0.4",
				"0.3" => "0.3",
				"0.2" => "0.2",
				"0.1" => "0.1"
			),
			"dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
			"description" => '',
			'save_always' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Hover Overlay Opacity", "salient-core"),
			"param_name" => "hover_desc_hover_overlay_opacity",
			"edit_field_class" => "nectar-one-half nectar-one-half-last",
			"value" => array(
				"Default" => "default",
				"0.9" => "0.9",
				"0.8" => "0.8",
				"0.7" => "0.7",
				"0.6" => "0.6",
				"0.5" => "0.5",
				"0.4" => "0.4",
				"0.3" => "0.3",
				"0.2" => "0.2",
				"0.1" => "0.1"
			),
			"dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
			'save_always' => true,
		),

    array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Disable Movement on Hover", "salient-core"),
			"value" => array("enable" => "true" ),
			"param_name" => "disable_hover_movement",
      "dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => ""
		),
    array(
      "type" => "checkbox",
      "class" => "",
      "heading" => esc_html__("Parallax Box Image", 'salient-core'),
      "param_name" => "bg_parallax",
      "value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
      'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
    ),
    array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Icon Position", "salient-core"),
			"dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
      "param_name" => "icon_position",
      "value" => array(
        "Bottom" => "bottom",
				"Top" => "top",
      ),
      'std' => 'bottom',
    ),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Box Color", "salient-core"),
			"param_name" => "box_color",
			"value" => "",
			"dependency" => array('element' => "box_style", 'value' => array('color_box_basic')),
			"description" => esc_html__("If left blank this will default to your theme accent color.", "salient-core"),
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Content Color", "salient-core"),
			"param_name" => "content_color",
			"dependency" => array('element' => "box_style", 'value' => array('color_box_basic', 'image_above_text_underline')),
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Box Color Opacity", "salient-core"),
			"param_name" => "box_color_opacity",
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
				"0" => "0",
			),
			"dependency" => array('element' => "box_style", 'value' => array('color_box_basic')),
			"description" => esc_html__("Lowering this will allow the color to be overlaid on top of the image background (if supplied).", "salient-core"),
			'save_always' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Hover Overlay Opacity", "salient-core"),
			"param_name" => "color_box_hover_overlay_opacity",
			"value" => array(
				"Default" => "default",
				"0.9" => "0.9",
				"0.8" => "0.8",
				"0.7" => "0.7",
				"0.6" => "0.6",
				"0.5" => "0.5",
				"0.4" => "0.4",
				"0.3" => "0.3",
				"0.2" => "0.2",
				"0.1" => "0.1"
			),
			"dependency" => array('element' => "box_style", 'value' => array('color_box_hover')),
			'save_always' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Content Alignment", "salient-core"),
			"param_name" => "box_alignment",
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right",
			),
			"dependency" => array('element' => "box_style", 'value' => array('color_box_basic','color_box_hover','hover_desc')),
			'save_always' => true,
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Content Alignment", "salient-core"),
			"param_name" => "parallax_hover_box_alignment",
			"value" => array(
				"Middle" => "middle",
				"Top" => "top",
				"Bottom" => "bottom",
			),
			"dependency" => array('element' => "box_style", 'value' => array('parallax_hover')),
			'save_always' => true,
		),

		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Overlay Color", "salient-core"),
			"param_name" => "parallax_hover_box_overlay",
			"value" => "",
			"dependency" => array('element' => "box_style", 'value' => array('parallax_hover')),
			"description" => esc_html__("If left blank this will default to dark grey.", "salient-core"),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Overlay Color Opacity", "salient-core"),
			"param_name" => "parallax_hover_box_overlay_opacity",
			"value" => array(
				"Default" => "0.6",
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
				"0" => "0",
			),
			'std' => 'default',
			"dependency" => array('element' => "box_style", 'value' => array('parallax_hover')),
			'save_always' => true,
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Overlay Color Hover Opacity", "salient-core"),
			"param_name" => "parallax_hover_box_overlay_opacity_hover",
			"value" => array(
				"Default" => "0.2",
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
				"0" => "0",
			),
			'std' => 'default',
			"dependency" => array('element' => "box_style", 'value' => array('parallax_hover')),
			'save_always' => true,
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"dependency" => array('element' => "box_style", 'value' => array('color_box_hover')),
			"heading" => "Add Border",
			"value" => array("Enable Fancy Box Border?" => "true" ),
			"param_name" => "enable_border",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("This will add a minimal border to show the fancy box area before hovering", "salient-core"),
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Background Hover Animation", "salient-core"),
			"param_name" => "hover_desc_bg_animation",
			"value" => array(
				esc_html__( "Long Zoom", "salient-core") => "long_zoom",
				esc_html__( "Short Zoom", "salient-core") => "short_zoom",
				esc_html__( "None", "salient-core") => "none",
			),
			"dependency" => array('element' => "box_style", 'value' => array('hover_desc')),
			'save_always' => true
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Border Radius", "salient-core"),
			"param_name" => "border_radius",
			"value" => array(
				esc_html__( "Default", "salient-core") => "default",
				esc_html__( "5px", "salient-core") => "5px",
				esc_html__( "10px", "salient-core") => "10px",
				esc_html__( "None", "salient-core") => "none"
			),
			'save_always' => true,
			'description' => __( 'Use this option to change the box corner roundness.', 'salient-core' ),
		),

		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Loading", "salient-core"),
      "param_name" => "image_loading",
      "value" => array(
        "Default" => "default",
				"Lazy Load" => "lazy-load",
      ),
			"description" => esc_html__("Determine whether to load the image on page load or to use a lazy load method for higher performance.", "salient-core"),
      'std' => 'default',
    ),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Enable Animation", "salient-core"),
			"value" => array("Enable Box Animation?" => "true" ),
			"param_name" => "enable_animation",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => ""
		),

		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Animation", "salient-core"),
			"param_name" => "animation",
			"value" => array(
				esc_html__( "None", "salient-core") => "none",
				esc_html__( "Fade In", "salient-core") => "fade-in",
				esc_html__( "Fade In From Left", "salient-core") => "fade-in-from-left",
				esc_html__( "Fade In Right", "salient-core") => "fade-in-from-right",
				esc_html__( "Fade In From Bottom", "salient-core") => "fade-in-from-bottom",
				esc_html__( "Grow In", "salient-core") => "grow-in",
				esc_html__( "Flip In Horizontal", "salient-core") => "flip-in",
				esc_html__( "Flip In Vertical", "salient-core") => "flip-in-vertical"
			),
			"dependency" => Array('element' => "enable_animation", 'not_empty' => true)
		),

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Animation Delay", "salient-core"),
			"param_name" => "delay",
			"admin_label" => false,
			"description" => esc_html__("Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in \"one by one\" effect.", "salient-core"),
			"dependency" => Array('element' => "enable_animation", 'not_empty' => true)
		),

		array(
			'type' => 'css_editor',
			'heading' => 'Css' ,
			'param_name' => 'css',
			'group' => 'Advanced Spacing',
		)

	)
);

?>
