<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nectar_offset_vals_arr = array(
	"0%" => "0%",
	"5%" => "5%",
	"10%" => "10%",
	"15%" => "15%",	
	"20%" => "20%",
	"25%" => "25%",
	"30%" => "30%",
	"35%" => "35%",	
	"40%" => "40%",
	"45%" => "45%",	
	"50%" => "50%",
	"55%" => "55%",
	"60%" => "60%",
	"65%" => "65%",	
	"70%" => "70%",
	"75%" => "75%",	
	"80%" => "80%",
	"85%" => "85%",	
	"90%" => "90%",
	"95%" => "95%",	
	"100%" => "100%"
);

$nectar_scale_vals_arr = array(
	"100%" => "1",
	"110%" => "1.1",
	"120%" => "1.2",
	"130%" => "1.3",	
	"140%" => "1.4",
	"150%" => "1.5",
	"160%" => "1.6",
	"170%" => "1.7",	
	"180%" => "1.8",
	"190%" => "1.9",	
	"200%" => "2",
	"225%" => "2.25",
	"250%" => "2.5",
	"75%" => "0.75",
	"50%" => "0.5",
	"40%" => "0.4",
	"30%" => "0.3",
	"20%" => "0.2",
);

return array(
	"name" => esc_html__("Cascading Images", "salient-core"),
	"base" => "nectar_cascading_images",
	"icon" => "icon-wpb-cascading-images",
	"category" => esc_html__('Media', 'salient-core'),
	"description" => esc_html__('Animated overlapping images', 'salient-core'),
	"params" => array(
		
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Image #1", "salient-core"),
			"param_name" => "image_1_url",
			"group" => 'Layer #1',
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"group" => 'Layer #1',
			"heading" => "Layer BG Color",
			"param_name" => "image_1_bg_color",
			"value" => "",
			"description" => "Use this to set a BG color for the layer"
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_1_offset_x_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_1_offset_x",
			"edit_field_class" => "col-md-4",
			"value" => $nectar_offset_vals_arr,
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_1_offset_y_sign",
			'edit_field_class' => 'offset-y-sign',
			"edit_field_class" => "col-md-2",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_1_offset_y",
			"value" => $nectar_offset_vals_arr,
			'edit_field_class' => 'offset-y',
			"edit_field_class" => "col-md-4",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_1_rotate_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_1_rotate",
			"edit_field_class" => "col-md-4",
			"value" => array(
				"None" => "none",
				"2.5°" => "2.5",
				"5°" => "5",
				"7.5°" => "7.5",	
				"10°" => "10",
				"12.5°" => "12.5",
				"15°" => "15",
				"17.5°" => "17.5",	
				"20°" => "20"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Scale", "salient-core"),
			"param_name" => "image_1_scale",
			"value" => $nectar_scale_vals_arr,
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("CSS Animation", "salient-core"),
			"group" => 'Layer #1',
			"param_name" => "image_1_animation",
			"value" => array(
				esc_html__("Fade In", "salient-core") => "Fade In", 
				esc_html__("Fade In From Left", "salient-core") => "Fade In From Left", 
				esc_html__("Fade In From Right", "salient-core") => "Fade In From Right", 
				esc_html__("Fade In From Bottom", "salient-core") => "Fade In From Bottom", 
				esc_html__("Grow In", "salient-core") => "Grow In",
				esc_html__("Grow In Reveal", "salient-core") => "Grow In Reveal",
				esc_html__("Flip In", "salient-core") => "Flip In",
				esc_html__("None", "salient-core") => "None"
			),
			"dependency" => Array('element' => "parallax_scrolling", 'is_empty' => true),
			'save_always' => true,
			"description" => esc_html__("Select animation type if you want this layer to be animated when it enters into the browsers viewport.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Layer Padding", "salient-core"),
			'save_always' => true,
			"param_name" => "image_1_padding",
			"value" => array(
				esc_html__("Auto", "salient-core") => "auto", 
				esc_html__("None", "salient-core") => "none"
			),
			"description" => esc_html__('By default, each layer will have padding applied to it based on how offset is applied. Set this to none for more precise positioning when making use of the above
			offset values.','salient-core')
		),
		
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Box Shadow", "salient-core"),
			'save_always' => true,
			"param_name" => "image_1_box_shadow",
			"value" => array(esc_html__("None", "salient-core") => "none", esc_html__("Small Depth", "salient-core") => "small_depth", esc_html__("Medium Depth", "salient-core") => "medium_depth", esc_html__("Large Depth", "salient-core") => "large_depth", esc_html__("Very Large Depth", "salient-core") => "x_large_depth"),
			"description" => esc_html__("Select your desired image box shadow", "salient-core")
		),
		
		
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Desktop Max Image Width", "salient-core"),
			"param_name" => "image_1_max_width_desktop",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Mobile Max Image Width", "salient-core"),
			"param_name" => "image_1_max_width_mobile",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		
		array(
			"type" => "dropdown",
			"group" => 'Layer #1',
			"heading" => esc_html__("Mobile Image Width", "salient-core"),
			"param_name" => "image_1_image_width_mobile",
			"value" => array(
				"Default" => "default",
				"100%" => "100",
				"95%" => "95",
				"90%" => "90",
				"85%" => "85",
				"80%" => "80",
				"75%" => "75",	
				"70%" => "70",	
				"65%" => "65",
				"60%" => "60",
				"55%" => "55",
				"50%" => "50",
				"45%" => "45",
				"40%" => "40",
				"35%" => "35",
				"30%" => "30",
			),
			"description" => esc_html__("This allows you to tell the browser how much space your image will approximately take up. Doing so will fine-tune performance so that the optimal image size can be loaded. Value is based on a total percentage of screen width. (Will be used in image \"sizes\" attribute)", "salient-core"),
			'save_always' => true
		),
		
		array(
			"type" => "fws_image",
			"group" => 'Layer #2',
			"heading" => esc_html__("Image #2", "salient-core"),
			"param_name" => "image_2_url",
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"group" => 'Layer #2',
			"heading" => "Layer BG Color",
			"param_name" => "image_2_bg_color",
			"value" => "",
			"description" => "Use this to set a BG color for the layer"
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_2_offset_x_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_2_offset_x",
			"edit_field_class" => "col-md-4",
			"value" => $nectar_offset_vals_arr,
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_2_offset_y_sign",
			'edit_field_class' => 'offset-y-sign',
			"edit_field_class" => "col-md-2",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_2_offset_y",
			"value" => $nectar_offset_vals_arr,
			'edit_field_class' => 'offset-y',
			"edit_field_class" => "col-md-4",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_2_rotate_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_2_rotate",
			"edit_field_class" => "col-md-4",
			"value" => array(
				"None" => "none",
				"2.5°" => "2.5",
				"5°" => "5",
				"7.5°" => "7.5",	
				"10°" => "10",
				"12.5°" => "12.5",
				"15°" => "15",
				"17.5°" => "17.5",	
				"20°" => "20"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Scale", "salient-core"),
			"param_name" => "image_2_scale",
			"value" => $nectar_scale_vals_arr,
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("CSS Animation", "salient-core"),
			"group" => 'Layer #2',
			"param_name" => "image_2_animation",
			"value" => array(
				esc_html__("Fade In", "salient-core") => "Fade In", 
				esc_html__("Fade In From Left", "salient-core") => "Fade In From Left", 
				esc_html__("Fade In From Right", "salient-core") => "Fade In From Right", 
				esc_html__("Fade In From Bottom", "salient-core") => "Fade In From Bottom", 
				esc_html__("Grow In", "salient-core") => "Grow In",
				esc_html__("Grow In Reveal", "salient-core") => "Grow In Reveal",
				esc_html__("Flip In", "salient-core") => "Flip In",
				esc_html__("None", "salient-core") => "None"
			),
			"dependency" => Array('element' => "parallax_scrolling", 'is_empty' => true),
			'save_always' => true,
			"description" => esc_html__("Select animation type if you want this layer to be animated when it enters into the browsers viewport.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Layer Padding", "salient-core"),
			'save_always' => true,
			"param_name" => "image_2_padding",
			"value" => array(
				esc_html__("Auto", "salient-core") => "auto", 
				esc_html__("None", "salient-core") => "none"
			),
			"description" => esc_html__('By default, each layer will have padding applied to it based on how offset is applied. Set this to none for more precise positioning when making use of the above
			offset values.','salient-core')
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Box Shadow", "salient-core"),
			'save_always' => true,
			"param_name" => "image_2_box_shadow",
			"value" => array(esc_html__("None", "salient-core") => "none", esc_html__("Small Depth", "salient-core") => "small_depth", esc_html__("Medium Depth", "salient-core") => "medium_depth", esc_html__("Large Depth", "salient-core") => "large_depth", esc_html__("Very Large Depth", "salient-core") => "x_large_depth"),
			"description" => esc_html__("Select your desired image box shadow", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Desktop Max Image Width", "salient-core"),
			"param_name" => "image_2_max_width_desktop",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Mobile Max Image Width", "salient-core"),
			"param_name" => "image_2_max_width_mobile",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #2',
			"heading" => esc_html__("Mobile Image Width", "salient-core"),
			"param_name" => "image_2_image_width_mobile",
			"value" => array(
				"Default" => "default",
				"100%" => "100",
				"95%" => "95",
				"90%" => "90",
				"85%" => "85",
				"80%" => "80",
				"75%" => "75",	
				"70%" => "70",	
				"65%" => "65",
				"60%" => "60",
				"55%" => "55",
				"50%" => "50",
				"45%" => "45",
				"40%" => "40",
				"35%" => "35",
				"30%" => "30",
			),
			"description" => esc_html__("This allows you to tell the browser how much space your image will approximately take up. Doing so will fine-tune performance so that the optimal image size can be loaded. Value is based on a total percentage of screen width. (Will be used in image \"sizes\" attribute)", "salient-core"),
			'save_always' => true
		),
		
		array(
			"type" => "fws_image",
			"group" => 'Layer #3',
			"heading" => esc_html__("Image #3", "salient-core"),
			"param_name" => "image_3_url",
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"group" => 'Layer #3',
			"heading" => "Layer BG Color",
			"param_name" => "image_3_bg_color",
			"value" => "",
			"description" => esc_html__("Use this to set a BG color for the layer", "salient-core")
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_3_offset_x_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_3_offset_x",
			"edit_field_class" => "col-md-4",
			"value" => $nectar_offset_vals_arr,
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_3_offset_y_sign",
			'edit_field_class' => 'offset-y-sign',
			"edit_field_class" => "col-md-2",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_3_offset_y",
			"value" => $nectar_offset_vals_arr,
			'edit_field_class' => 'offset-y',
			"edit_field_class" => "col-md-4",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_3_rotate_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_3_rotate",
			"edit_field_class" => "col-md-4",
			"value" => array(
				"None" => "none",
				"2.5°" => "2.5",
				"5°" => "5",
				"7.5°" => "7.5",	
				"10°" => "10",
				"12.5°" => "12.5",
				"15°" => "15",
				"17.5°" => "17.5",	
				"20°" => "20"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Scale", "salient-core"),
			"param_name" => "image_3_scale",
			"value" => $nectar_scale_vals_arr,
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("CSS Animation", "salient-core"),
			"group" => 'Layer #3',
			"param_name" => "image_3_animation",
			"value" => array(
				esc_html__("Fade In", "salient-core") => "Fade In", 
				esc_html__("Fade In From Left", "salient-core") => "Fade In From Left", 
				esc_html__("Fade In From Right", "salient-core") => "Fade In From Right", 
				esc_html__("Fade In From Bottom", "salient-core") => "Fade In From Bottom", 
				esc_html__("Grow In", "salient-core") => "Grow In",
				esc_html__("Grow In Reveal", "salient-core") => "Grow In Reveal",
				esc_html__("Flip In", "salient-core") => "Flip In",
				esc_html__("None", "salient-core") => "None"
			),
			"dependency" => Array('element' => "parallax_scrolling", 'is_empty' => true),
			'save_always' => true,
			"description" => esc_html__("Select animation type if you want this layer to be animated when it enters into the browsers viewport.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Layer Padding", "salient-core"),
			'save_always' => true,
			"param_name" => "image_3_padding",
			"value" => array(
				esc_html__("Auto", "salient-core") => "auto", 
				esc_html__("None", "salient-core") => "none"
			),
			"description" => esc_html__('By default, each layer will have padding applied to it based on how offset is applied. Set this to none for more precise positioning when making use of the above
			offset values.','salient-core')
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Box Shadow", "salient-core"),
			'save_always' => true,
			"param_name" => "image_3_box_shadow",
			"value" => array(esc_html__("None", "salient-core") => "none", esc_html__("Small Depth", "salient-core") => "small_depth", esc_html__("Medium Depth", "salient-core") => "medium_depth", esc_html__("Large Depth", "salient-core") => "large_depth", esc_html__("Very Large Depth", "salient-core") => "x_large_depth"),
			"description" => esc_html__("Select your desired image box shadow", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Desktop Max Image Width", "salient-core"),
			"param_name" => "image_3_max_width_desktop",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Mobile Max Image Width", "salient-core"),
			"param_name" => "image_3_max_width_mobile",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #3',
			"heading" => esc_html__("Mobile Image Width", "salient-core"),
			"param_name" => "image_3_image_width_mobile",
			"value" => array(
				"Default" => "default",
				"100%" => "100",
				"95%" => "95",
				"90%" => "90",
				"85%" => "85",
				"80%" => "80",
				"75%" => "75",	
				"70%" => "70",	
				"65%" => "65",
				"60%" => "60",
				"55%" => "55",
				"50%" => "50",
				"45%" => "45",
				"40%" => "40",
				"35%" => "35",
				"30%" => "30",
			),
			"description" => esc_html__("This allows you to tell the browser how much space your image will approximately take up. Doing so will fine-tune performance so that the optimal image size can be loaded. Value is based on a total percentage of screen width. (Will be used in image \"sizes\" attribute)", "salient-core"),
			'save_always' => true
		),
		array(
			"type" => "fws_image",
			"group" => 'Layer #4',
			"heading" => esc_html__("Image #4", "salient-core"),
			"param_name" => "image_4_url",
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"group" => 'Layer #4',
			"heading" => "Layer BG Color",
			"param_name" => "image_4_bg_color",
			"value" => "",
			"description" => esc_html__("Use this to set a BG color for the layer", "salient-core")
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_4_offset_x_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Offset X", "salient-core"),
			"param_name" => "image_4_offset_x",
			"edit_field_class" => "col-md-4",
			"value" => $nectar_offset_vals_arr,
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_4_offset_y_sign",
			'edit_field_class' => 'offset-y-sign',
			"edit_field_class" => "col-md-2",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Offset Y", "salient-core"),
			"param_name" => "image_4_offset_y",
			"value" => $nectar_offset_vals_arr,
			'edit_field_class' => 'offset-y',
			"edit_field_class" => "col-md-4",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_4_rotate_sign",
			"value" => array(
				"+" => "+",
				"-" => "-"
			),
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Rotate", "salient-core"),
			"param_name" => "image_4_rotate",
			"edit_field_class" => "col-md-4",
			"value" => array(
				"None" => "none",
				"2.5°" => "2.5",
				"5°" => "5",
				"7.5°" => "7.5",	
				"10°" => "10",
				"12.5°" => "12.5",
				"15°" => "15",
				"17.5°" => "17.5",	
				"20°" => "20"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Scale", "salient-core"),
			"param_name" => "image_4_scale",
			"value" => $nectar_scale_vals_arr,
			"edit_field_class" => "col-md-2",
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("CSS Animation", "salient-core"),
			"group" => 'Layer #4',
			"param_name" => "image_4_animation",
			"value" => array(
				esc_html__("Fade In", "salient-core") => "Fade In", 
				esc_html__("Fade In From Left", "salient-core") => "Fade In From Left", 
				esc_html__("Fade In From Right", "salient-core") => "Fade In From Right", 
				esc_html__("Fade In From Bottom", "salient-core") => "Fade In From Bottom", 
				esc_html__("Grow In", "salient-core") => "Grow In",
				esc_html__("Grow In Reveal", "salient-core") => "Grow In Reveal",
				esc_html__("Flip In", "salient-core") => "Flip In",
				esc_html__("None", "salient-core") => "None"
			),
			"dependency" => Array('element' => "parallax_scrolling", 'is_empty' => true),
			'save_always' => true,
			"description" => esc_html__("Select animation type if you want this layer to be animated when it enters into the browsers viewport.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Layer Padding", "salient-core"),
			'save_always' => true,
			"param_name" => "image_4_padding",
			"value" => array(
				esc_html__("Auto", "salient-core") => "auto", 
				esc_html__("None", "salient-core") => "none"
			),
			"description" => esc_html__('By default, each layer will have padding applied to it based on how offset is applied. Set this to none for more precise positioning when making use of the above
			offset values.','salient-core')
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Box Shadow", "salient-core"),
			'save_always' => true,
			"param_name" => "image_4_box_shadow",
			"value" => array(esc_html__("None", "salient-core") => "none", esc_html__("Small Depth", "salient-core") => "small_depth", esc_html__("Medium Depth", "salient-core") => "medium_depth", esc_html__("Large Depth", "salient-core") => "large_depth", esc_html__("Very Large Depth", "salient-core") => "x_large_depth"),
			"description" => esc_html__("Select your desired image box shadow", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Desktop Max Image Width", "salient-core"),
			"param_name" => "image_4_max_width_desktop",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Mobile Max Image Width", "salient-core"),
			"param_name" => "image_4_max_width_mobile",
			"edit_field_class" => "col-md-6",
			"value" => array(
				"100%" => "100%",
				"125%" => "125%",
				"135%" => "135%",
				"150%" => "150%",
				"175%" => "175%",	
				"200%" => "200%"
			),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"group" => 'Layer #4',
			"heading" => esc_html__("Mobile Image Width", "salient-core"),
			"param_name" => "image_4_image_width_mobile",
			"value" => array(
				"Default" => "default",
				"100%" => "100",
				"95%" => "95",
				"90%" => "90",
				"85%" => "85",
				"80%" => "80",
				"75%" => "75",	
				"70%" => "70",	
				"65%" => "65",
				"60%" => "60",
				"55%" => "55",
				"50%" => "50",
				"45%" => "45",
				"40%" => "40",
				"35%" => "35",
				"30%" => "30",
			),
			"description" => esc_html__("This allows you to tell the browser how much space your image will approximately take up. Doing so will fine-tune performance so that the optimal image size can be loaded. Value is based on a total percentage of screen width. (Will be used in image \"sizes\" attribute)", "salient-core"),
			'save_always' => true
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Element Sizing", "salient-core"),
			"param_name" => "element_sizing",
			"value" => array(
				esc_html__("Default", "salient-core") => "default", 
				esc_html__("Forced Aspect Ratio", "salient-core") => "forced", 
			),
			'save_always' => true,
			"description" => esc_html__("By default, the image in layer #1 will be used for the element sizing. You can change this to force a different base size.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Aspect Ratio", "salient-core"),
			"param_name" => "element_sizing_aspect",
			"value" => array(
				esc_html__("1:1", "salient-core") => "1-1", 
				esc_html__("4:3", "salient-core") => "4-3", 
				esc_html__("3:2", "salient-core") => "2-3", 
				esc_html__("16:9", "salient-core") => "16-9", 
				esc_html__("4:5", "salient-core") => "4-5", 
			),
			"dependency" => Array('element' => "element_sizing", 'value' => array('forced')),
			'save_always' => true,
			"description" => esc_html__("By default, the image in layer #1 will be used for the element sizing. You can change this to force a different base size.", "salient-core")
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
			"description" => esc_html__("Determine whether to load the images on page load or to use a lazy load method for higher performance.", "salient-core"),
			'std' => 'default',
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Time Between Animations", "salient-core"),
			"param_name" => "animation_timing",
			"dependency" => Array('element' => "parallax_scrolling", 'is_empty' => true),
			"description" => esc_html__("Enter your desired time between animations in milliseconds, defaults to 200 if left blank", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Layer Border Radius", "salient-core"),
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
				"type" => 'checkbox',
				"heading" => esc_html__("Enable Parallax Scrolling", "salient-core"),
				"param_name" => "parallax_scrolling",
				"admin_label" => true,
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("If selected, each layer will scroll at a slightly different speed to create a parallax effect.", "salient-core") . '<br />' . esc_html__("Note: using this will disable the individual layer animations.", "salient-core"),
				"value" => Array(esc_html__("Yes", "salient-core") => 'yes')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Layer #1 Scrolling", "salient-core"),
				'save_always' => true,
				"param_name" => "layer_1_parallax_scrolling",
				"dependency" => Array('element' => "parallax_scrolling", 'not_empty' => true),
				"value" => array(
					esc_html__("No parallax scrolling", "salient-core") => "no",
					esc_html__("Enable parallax scrolling", "salient-core") => "yes",
				),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Parallax Intensity", "salient-core"),
				'save_always' => true,
				"param_name" => "parallax_scrolling_intensity",
				"dependency" => Array('element' => "parallax_scrolling", 'not_empty' => true),
				"value" => array(
					esc_html__("Subtle", "salient-core") => "subtle",
					esc_html__("Medium", "salient-core") => "medium",
					esc_html__("High", "salient-core") => "high"
				),
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Overflow Visibility", "salient-core"),
				'save_always' => true,
				"param_name" => "overflow",
				"description" => esc_html__("Controls whether images outside the sizing area will be visible or clipped. The sizing area is determined by the first layer in your cascading images, or the aspect ratio optionally defined above in the Element Sizing
field.", "salient-core"),
				"value" => array(
					esc_html__("Visible", "salient-core") => "visible",
					esc_html__("Hidden", "salient-core") => "hidden",
				)
			)
			
		)
		
	);
	
	?>