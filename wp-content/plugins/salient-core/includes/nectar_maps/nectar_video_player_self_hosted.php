<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


return array(
	"name" => esc_html__("Self Hosted Video Player", "salient-core"),
	"base" => "nectar_video_player_self_hosted",
	"icon" => "icon-wpb-video-lightbox",
	'weight' => 6,
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Media', 'salient-core'),
	"description" => esc_html__('Self Hosted Video', 'salient-core'),
	"params" => array(
    
    array(
      "type" => "nectar_attach_video",
      "class" => "",
      "heading" => esc_html__("Video WebM File URL", "salient-core"),
      "value" => "",
      "param_name" => "video_webm",
      "description" => esc_html__("You must include this format & the mp4 format to render your video with cross browser compatibility.", "salient-core")
    ),

    array(
      "type" => "nectar_attach_video",
      "class" => "",
      "heading" => esc_html__("Video MP4 File URL", "salient-core"),
      "value" => "",
      "param_name" => "video_mp4",
      "description" => esc_html__("Enter the URL for your mp4 video file here", "salient-core")
    ),
    array(
      "type" => "fws_image",
      "class" => "",
      "heading" => esc_html__("Video Preview Image", "salient-core"),
      "value" => "",
      "param_name" => "video_image",
      "description" => "",
    ),
    
    array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Video Width', 'js_composer' ),
			'param_name' => 'el_width',
			'value' => array(
				'100%' => '100',
				'90%' => '90',
				'80%' => '80',
				'70%' => '70',
				'60%' => '60',
				'50%' => '50',
				'40%' => '40',
				'30%' => '30',
				'20%' => '20',
				'10%' => '10',
			),
			'description' => esc_html__( 'Select video width (percentage).', 'js_composer' ),
		),
		array(
			'type' => 'dropdown',
			"heading" => '<span class="group-title">' . esc_html__("Video Aspect Ratio", "salient-core") . "</span>",
			'param_name' => 'el_aspect',
      "edit_field_class" => "desktop video-aspect-ratio-device-group",
			'value' => array(
				'16:9' => '169',
				'4:3' => '43',
        '1:1' => '11',
				'2.35:1' => '235',
        '9:16' => '916',
			),
      "admin_label" => true,
			'description' => esc_html__( 'Select video aspect ratio.', 'js_composer' ),
		),

    array(
			'type' => 'dropdown',
			"heading" => '',
			'param_name' => 'el_aspect_tablet',
      "edit_field_class" => "tablet video-aspect-ratio-device-group",
			'value' => array(
        'Inherit' => 'inherit',
				'16:9' => '169',
				'4:3' => '43',
        '1:1' => '11',
				'2.35:1' => '235',
        '9:16' => '916',
			),
			'description' => esc_html__( 'Select video aspect ratio.', 'js_composer' ),
		),

    array(
			'type' => 'dropdown',
			"heading" => '',
			'param_name' => 'el_aspect_phone',
      "edit_field_class" => "phone video-aspect-ratio-device-group",
			'value' => array(
        'Inherit' => 'inherit',
				'16:9' => '169',
				'4:3' => '43',
        '1:1' => '11',
				'2.35:1' => '235',
        '9:16' => '916',
			),
			'description' => esc_html__( 'Select video aspect ratio.', 'js_composer' ),
		),

    

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment', 'js_composer' ),
			'param_name' => 'align',
			'description' => esc_html__( 'Select video alignment.', 'js_composer' ),
			'value' => array(
				esc_html__( 'Left', 'js_composer' ) => 'left',
				esc_html__( 'Right', 'js_composer' ) => 'right',
				esc_html__( 'Center', 'js_composer' ) => 'center',
			),
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Replace With Image on Mobile", "salient-core"),
			"param_name" => "rm_on_mobile",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => array(esc_html__("Yes", "salient-core") => 'true'),
			"dependency" => array('element' => "icon_family", 'value' => 'linea'),
			"description" => "This will render the \"Video Preview Image\" only when viewed on a mobile device for higher performance."
		),
    array(
			"type" => "dropdown",
			"heading" => esc_html__("Player Functionality", "salient-core"),
			"param_name" => "player_functionality",
			"value" => array(
				"Standard Video Player" => "default",
				"Lightbox Trigger" => "lightbox",
			),
			'save_always' => true,
			"description" => esc_html__("Determines the functionality of your video player element.", "salient-core")	  
		),
    array(
			"type" => "textfield",
			"heading" => esc_html__("Lightbox Video URL", "salient-core"),
			"param_name" => "video_lightbox_url",
			"admin_label" => false,
      "dependency" => Array('element' => "player_functionality", 'value' => array('lightbox')),
			"description" => esc_html__("The URL to your video that will be shown in the lightbox when clicked (if left blank, the above supplied .mp4/.webm will be used). The URL should be on Youtube or Vimeo e.g. https://vimeo.com/118023315 or https://www.youtube.com/watch?v=6oTurM7gESE etc.", "salient-core")
		),
    array(
			"type" => "dropdown",
			"heading" => esc_html__("Play Button Style", "salient-core"),
			"param_name" => "play_button_style",
			"value" => array(
				esc_html__("Default", "salient-core")	=> "default",
				esc_html__("Follow Mouse", "salient-core") => "follow_mouse",
			),
			'save_always' => true,
			"dependency" => Array('element' => "player_functionality", 'value' => array('lightbox')),
			"description" => esc_html__("Determines the functionality of your video player element.", "salient-core")	  
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Hide Play Button Until Hovered", "salient-core"),
			"param_name" => "play_button_hide",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
     	 "dependency" => Array('element' => "play_button_style", 'value' => array('follow_mouse')),
		),
    array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Play Button Color",
			"param_name" => "play_button_color",
			"value" => "",
      "dependency" => Array('element' => "player_functionality", 'value' => array('lightbox')),
			"description" =>  esc_html__("The color of the background of your play button.", "salient-core")	  	
		),
    array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Play Button Icon Color",
			"param_name" => "play_button_icon_color",
			"value" => "",
      "dependency" => Array('element' => "player_functionality", 'value' => array('lightbox')),
			"description" => esc_html__("The color of your play button icon.", "salient-core")	  
		),

    array(
			"type" => 'checkbox',
			"heading" => esc_html__("Hide Controls", "salient-core"),
			"param_name" => "hide_controls",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
      "dependency" => Array('element' => "player_functionality", 'value' => array('default')),
		),
    array(
			"type" => 'checkbox',
			"heading" => esc_html__("Loop Video", "salient-core"),
			"param_name" => "loop",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
      "dependency" => Array('element' => "player_functionality", 'value' => array('default')),
		),
    array(
			"type" => 'checkbox',
			"heading" => esc_html__("Autoplay Video", "salient-core"),
			"param_name" => "autoplay",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
      "dependency" => Array('element' => "player_functionality", 'value' => array('default')),
      'description' => esc_html__( 'This will automatically mute the video as well.', 'js_composer' ),
		),
    array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Autoplay functionality', 'js_composer' ),
			'param_name' => 'autoplay_func',
			'value' => array(
				'Start Playing Immediately' => 'default',
				'Start Playing When Scrolled Into View' => 'scroll_based',
			),
      "dependency" => Array('element' => "autoplay", 'not_empty' => true),
			'description' => esc_html__( 'Select how the autoplay should function.', 'js_composer' ),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__( 'Element ID', 'js_composer' ),
			'param_name' => 'el_id',
			'description' => sprintf( esc_html__( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'js_composer' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"dependency" => Array('element' => "autoplay", 'not_empty' => true),
			"heading" => esc_html__("Video Loading", "salient-core"),
			"param_name" => "video_loading",
			"value" => array(
				  "Default" => "default",
				"Lazy Load" => "lazy-load",
			),
				  "description" => esc_html__("Determine whether to load the video on page load or to use a lazy load method for higher performance.", "salient-core"),
			'std' => 'default',
		  ),
    array(
		"type" => "dropdown",
		"heading" => esc_html__("Border Radius", "salient-core"),
		'save_always' => true,
		"param_name" => "border_radius",
		"value" => array(
			esc_html__("0px", "salient-core") => "none",
			esc_html__("3px", "salient-core") => "3px",
			esc_html__("5px", "salient-core") => "5px", 
			esc_html__("10px", "salient-core") => "10px", 
			esc_html__("15px", "salient-core") => "15px", 
			esc_html__("20px", "salient-core") => "20px"),
		),	
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Box Shadow", "salient-core"),
			'save_always' => true,
			"param_name" => "box_shadow",
			"value" => array(esc_html__("None", "salient-core") => "none", esc_html__("Small Depth", "salient-core") => "small_depth", esc_html__("Medium Depth", "salient-core") => "medium_depth", esc_html__("Large Depth", "salient-core") => "large_depth", esc_html__("Very Large Depth", "salient-core") => "x_large_depth"),
			"description" => esc_html__("Select your desired image box shadow", "salient-core"),
			"dependency" => Array('element' => "animation", 'value' => array('None','Fade In','Fade In From Left','Fade In From Right','Fade In From Bottom','Grow In', 'Flip In', 'flip-in-vertical')),
		),

    array(
      "type" => "nectar_gradient_selection",
      "class" => "",
      "group" => "Color Overlay",
      "edit_field_class" => "generate-color-overlay-preview vc_col-xs-12",
      "heading" => '',
      "param_name" => "advanced_gradient",
      "value" => "",
      "description" => ''
    ),

    array(
      "type" => "nectar_radio_tab_selection",
      "class" => "",
      'save_always' => true,
      "group" => "Color Overlay",
      "edit_field_class" => "nectar-one-half",
      "heading" => esc_html__("Gradient Type", "salient-core"),
      "param_name" => "advanced_gradient_display_type",
      "options" => array(
        esc_html__("Linear", "salient-core") => "linear",
        esc_html__("Radial", "salient-core") => "radial",
      ),
    ),

    array(
      "type" => "nectar_angle_selection",
      "class" => "",
      "edit_field_class" => "nectar-one-half nectar-one-half-last",
      "group" => "Color Overlay",
      "heading" => esc_html__("Gradient Angle", "salient-core"),
      "param_name" => "advanced_gradient_angle",
      "value" => "",
      "dependency" => Array('element' => "advanced_gradient_display_type", 'value' => array('linear')),
      "description" => ''
    ),
    array(
      "type" => "dropdown",
      "edit_field_class" => "nectar-one-half nectar-one-half-last",
      "class" => "",
      "group" => "Color Overlay",
      "heading" => esc_html__("Gradient Position", "salient-core"),
      "param_name" => "advanced_gradient_radial_position",
      "dependency" => Array('element' => "advanced_gradient_display_type", 'value' => array('radial')),
      'value' => array(
        esc_html__("Center", "salient-core") => "center", 
        esc_html__("Top Left", "salient-core") => "top left",
        esc_html__("Top", "salient-core") => "top",
        esc_html__("Top Right", "salient-core") => "top right",
        esc_html__("Right", "salient-core") => "right",
        esc_html__("Bottom Right", "salient-core") => "bottom right",
        esc_html__("Bottom", "salient-core") => "bottom",
        esc_html__("Bottom Left", "salient-core") => "bottom left",
        esc_html__("Left", "salient-core") => "left",
      )
    ),

    
	)
);

?>