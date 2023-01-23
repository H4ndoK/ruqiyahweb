<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Default (inherit from row Text Color)", "salient-core") => "Default",
	esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3",
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Milestone", "salient-core"),
	"base" => "milestone",
	"icon" => "icon-wpb-milestone",
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Add an animated milestone', 'salient-core'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Milestone Number", "salient-core"),
			"param_name" => "number",
			"admin_label" => true,
			"description" => esc_html__("The number/count of your milestone e.g. \"13\"", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Milestone Number Inherit Font", "salient-core"),
			"param_name" => "heading_inherit",
			"value" => array(
				"Default" => "default",
				"h1" => "h1",
				"h2" => "h2",
				"h3" => "h3",
				"h4" => "h4",
				"h5" => "h5",
			),
			'save_always' => true,
			"description" => esc_html__("Please select if you would like your milestone number to inherit a font family from any heading tag", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Milestone Symbol", "salient-core"),
			"param_name" => "symbol",
			"admin_label" => false,
			"description" => esc_html__("An optional symbol to place next to the number counted to. e.g. \"%\" or \"+\"", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Milestone Symbol Position", "salient-core"),
			"param_name" => "symbol_position",
			"value" => array(
				"After Number" => "after",
				"Before Number" => "before",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the position you would like for your symbol.", "salient-core"),
			"dependency" => Array('element' => "symbol", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Milestone Subject", "salient-core"),
			"param_name" => "subject",
			"admin_label" => true,
			"description" => esc_html__("The subject of your milestones e.g. \"Projects Completed\"", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Milestone Subject Padding", "salient-core"),
			"param_name" => "subject_padding",
			"value" => array(
				"0%" => "0",
				"2%" => "2%",
				"4%" => "4%",
				"6%" => "6%",
				"8%" => "8%",
				"10%" => "10%",
			),
			'save_always' => true,
			"description" => esc_html__("Please select amount of padding you would like your subject to have", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Color", "salient-core"),
			"param_name" => "color",
			"value" => $el_color_list,
			'save_always' => true,
			'description' => esc_html__('Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Animation Effect", "salient-core"),
			"param_name" => "effect",
			"value" => array(
				esc_html__( "Count To Value", "salient-core") => "count",
				esc_html__( "Motion Blur Slide In", "salient-core") => "motion_blur"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the animation you would like your milestone to have", "salient-core")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Animation Delay", "salient-core"),
			"param_name" => "effect_delay",
			"admin_label" => false,
			"description" => esc_html__("Enter delay (in milliseconds) if needed e.g. 150.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Milestone Number Font Size", "salient-core"),
			"param_name" => "number_font_size",
			"admin_label" => false,
			"description" => esc_html__("Enter your size in pixels, the default is 62.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Milestone Symbol Font Size", "salient-core"),
			"param_name" => "symbol_font_size",
			"admin_label" => false,
			"description" => esc_html__("Enter your size in pixels.", "salient-core"),
			"dependency" => Array('element' => "symbol", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Milestone Symbol Alignment", "salient-core"),
			"param_name" => "symbol_alignment",
			"value" => array(
				"Default" => "Default",
				"Superscript" => "Superscript",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the alignment you desire for your symbol.", "salient-core"),
			"dependency" => Array('element' => "symbol", 'not_empty' => true)
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Milestone Text Alignment", "salient-core"),
			"param_name" => "milestone_alignment",
			"value" => array(
				esc_html__( "Default", "salient-core") => "default",
				esc_html__( "Left", "salient-core") => "left",
				esc_html__( "Right", "salient-core") => "right",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the alignment for your overall milestone.", "salient-core"),
		)
		
	)
);

?>