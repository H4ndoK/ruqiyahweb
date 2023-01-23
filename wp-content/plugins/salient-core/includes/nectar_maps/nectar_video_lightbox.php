<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    "Accent Color" => "Default-Accent-Color",
	"Extra Color 1" => "Extra-Color-1",
	"Extra Color 2" => "Extra-Color-2",	
	"Extra Color 3" => "Extra-Color-3"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Video Lightbox", "salient-core"),
	"base" => "nectar_video_lightbox",
	'weight' => 6,
	"icon" => "icon-wpb-video-lightbox",
	"category" => esc_html__('Media', 'salient-core'),
	"description" => esc_html__('Add a video lightbox link', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Link Style", "salient-core"),
			"param_name" => "link_style",
			"value" => array(
				"Play Button" => "play_button",
				"Play Button With text" => "play_button_with_text",
				"Play Button With Image" => "play_button_2",
				"Play Button With Image - Mouse Follow" => "play_button_mouse_follow",
				"Nectar Button" => "nectar-button"
			),
			'save_always' => true,
			"admin_label" => true,
			"description" => esc_html__("Please select your link style", "salient-core")	  
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Video URL", "salient-core"),
			"param_name" => "video_url",
			"admin_label" => false,
			"description" => esc_html__("The URL to your video on Youtube or Vimeo e.g. https://vimeo.com/118023315 or https://www.youtube.com/watch?v=6oTurM7gESE etc.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Play Button Color", "salient-core"),
			"param_name" => "nectar_play_button_color",
			"value" => $el_color_list,
			'save_always' => true,
			"dependency" => array('element' => "link_style", 'value' => array("play_button_2","play_button_with_text")),
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Play Button Style", "salient-core"),
			"param_name" => "nectar_play_button_style",
			"value" => array(
				"Colored Button Pulse" => "default",
				"Button Bordered Small" => "small",
				"Button Bordered Top" => "bordered_top"
			),
			'save_always' => true,
			"dependency" => array('element' => "link_style", 'value' => array("play_button_with_text")),
			'description' => __( 'Choose the style that your play button with display in. Note that the "Button Bordered Small" style will not use the above color scheme.','salient-core'),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Text Color", "salient-core"),
			"param_name" => "text_color",
			"value" => array(
				"Default" => "default",
				"White" => "white",
				"Black" => "black"
			),
			'save_always' => true,
			"dependency" => array('element' => "nectar_play_button_style", 'value' => array("small","bordered_top")),
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Video Preview Image", "salient-core"),
			"param_name" => "image_url",
			"value" => "",
			"dependency" => array('element' => "link_style", 'value' => array("play_button_2", "play_button_mouse_follow")),
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
      "type" => "textfield",
      "heading" => esc_html__("Image size", "salient-core"),
      "param_name" => "image_size",
      "description" => esc_html__("Optionally enter a custom WordPress image size. Example: \"thumbnail\", \"medium\", \"large\", \"full\".", "salient-core"),
      "dependency" => array('element' => "link_style", 'value' => array("play_button_2", "play_button_mouse_follow")),
		),
		array(
			"type" => "dropdown",
			"dependency" => array('element' => "link_style", 'value' => "play_button_2"),
			"heading" => esc_html__("Hover Effect", "salient-core"),
			'save_always' => true,
			"param_name" => "hover_effect",
			"value" => array(esc_html__("Zoom BG Image", "salient-core") => "defaut", esc_html__("Zoom Button", "salient-core") => "zoom_button"),
			"description" => esc_html__("Select your desired hover effect", "salient-core")
		),
		array(
			"type" => "dropdown",
			"dependency" => array('element' => "link_style", 'value' => "play_button_2"),
			"heading" => esc_html__("Box Shadow", "salient-core"),
			'save_always' => true,
			"param_name" => "box_shadow",
			"value" => array(esc_html__("None", "salient-core") => "none", esc_html__("Small Depth", "salient-core") => "small_depth", esc_html__("Medium Depth", "salient-core") => "medium_depth", esc_html__("Large Depth", "salient-core") => "large_depth", esc_html__("Very Large Depth", "salient-core") => "x_large_depth"),
			"description" => esc_html__("Select your desired image box shadow", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Border Radius", "salient-core"),
			'save_always' => true,
			"dependency" => array('element' => "link_style", 'value' => array("play_button_2")),
			"param_name" => "border_radius",
			"value" => array(
				esc_html__("0px", "salient-core") => "none",
				esc_html__("3px", "salient-core") => "3px",
				esc_html__("5px", "salient-core") => "5px", 
				esc_html__("10px", "salient-core") => "10px", 
				esc_html__("15px", "salient-core") => "15px", 
				esc_html__("20px", "salient-core") => "20px"
			),
		),	
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Play Button Size", "salient-core"),
			'save_always' => true,
			"dependency" => array('element' => "link_style", 'value' => array("play_button_2")),
			"param_name" => "play_button_size",
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("Larger", "salient-core") => "larger")
			),	
			
			array(
	      "type" => "dropdown",
	      "class" => "",
	      'save_always' => true,
	      "heading" => esc_html__("Mouse Indicator Style", "salient-core"),
	      "param_name" => "mouse_indicator_style",
				"dependency" => array('element' => "link_style", 'value' => "play_button_mouse_follow"),
	      "value" => array(
	        "Default" => "default",
					"See Through Contrast" => "see_through_contrast",
	        "Solid Color" => "solid_color",
	      ),
	      'std' => 'default',
	    ),
			array(
	      "type" => "colorpicker",
	      "class" => "",
	      "heading" => "Mouse Indicator Color",
	      "param_name" => "mouse_indicator_color",
	      "value" => "",
				"dependency" => array('element' => "mouse_indicator_style", 'value' => 'solid_color'),
	    ),
			
			array(
				"type" => "textfield",
				"heading" => esc_html__("Link Text", "salient-core"),
				"param_name" => "link_text",
				"admin_label" => false,
				"dependency" => array('element' => "link_style", 'value' => array("nectar-button","play_button_with_text")),
				"description" => esc_html__("The text that will be displayed for your link", "salient-core")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				'save_always' => true,
				"heading" => "Text Font Style",
				"dependency" => array('element' => "link_style", 'value' => array("play_button_with_text")),
				"description" => esc_html__("Choose what element your link text will inherit styling from", "salient-core"),
				"param_name" => "font_style",
				"value" => array(
					"Paragraph" => "p",
					"H6" => "h6",
					"H5" => "h5",
					"H4" => "h4",
					"H3" => "h3",
					"H2" => "h2",
					"H1" => "h1",
					"Button - Medium" => "nectar-btn-medium",
					"Button - Large" => "nectar-btn-large",
					"Button - Jumbo" => "nectar-btn-jumbo"
				)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Color", "salient-core"),
				"param_name" => "nectar_button_color",
				"value" => array(
					"Accent Color" => "Default-Accent-Color",
					"Extra Color 1" => "Default-Extra-Color-1",
					"Extra Color 2" => "Default-Extra-Color-2",	
					"Extra Color 3" => "Default-Extra-Color-3",
					"Transparent Accent Color" =>  "Transparent-Accent-Color",
					"Transparent Extra Color 1" => "Transparent-Extra-Color-1",
					"Transparent Extra Color 2" => "Transparent-Extra-Color-2",	
					"Transparent Extra Color 3" => "Transparent-Extra-Color-3"
				),
				'save_always' => true,
				"dependency" => array('element' => "link_style", 'value' => "nectar-button"),
				'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Parent Row BG Hover Relationship", "salient-core"),
				"param_name" => "parent_hover_relationship",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"dependency" => array('element' => "link_style", 'value' => array("play_button", "nectar-button", "play_button_with_text")),
				"description" => esc_html__("Enable this to cause your parent row BG to zoom in slightly when hovering over the video lightbox button", "salient-core"),
				"value" => Array(esc_html__("Yes, please", "salient-core") => true),
			),
      array(
        "type" => "checkbox",
        "class" => "",
        "heading" => esc_html__("Nofollow Link", "salient-core"),
        "param_name" => "nofollow_link",
        'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
        "value" => Array(esc_html__("Yes", "salient-core") => 'true'),
        "description" => ""
      ),
			
		)
	);
	
	?>