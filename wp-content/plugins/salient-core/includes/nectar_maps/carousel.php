<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);
$tab_id_3 = time().'-3-'.rand(0, 100);

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

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
	"name"  => esc_html__("Carousel", 'salient-core'),
	"base" => "carousel",
	"show_settings_on_create" => true,
	"is_container" => true,
  "weight" => 8,
	"icon" => "icon-wpb-carousel",
	"category" => esc_html__('Interactive', 'salient-core'),
	"description" => esc_html__('A simple carousel for any content', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__('Carousel Type','salient-core'),
			'save_always' => true,
			"param_name" => "script",
			"value" => array(
				"Flickity" => "flickity",
				"Simple Slider" => 'simple_slider',
				"Owl Carousel" => "owl_carousel",
				"carouFredSel" => "carouFredSel",
			),
			"description" => esc_html__("carouFredSel is deprecated, but still available for legacy users who prefer it." , "salient-core")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__('Style','salient-core'),
			'save_always' => true,
			"param_name" => "flickity_formatting",
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("Fixed Text Content Fullwidth", "salient-core") => "fixed_text_content_fullwidth",
			),
			"dependency" => array('element' => "script", 'value' => 'flickity'),
			"description" => esc_html__("Select the formatting of your carousel. When using the \"Fixed Text Content Fullwidth\" format, the carousel should be the only element in your row and inside of a full (1/1) column." , 'salient-core')
		),
		array(
			"type" => "textarea",
			"holder" => "div",
			"heading" => esc_html__("Text Content", 'salient-core'),
			"param_name" => "flickity_fixed_content",
			"value" => '',
			"dependency" => array('element' => "flickity_formatting", 'value' => array('fixed_text_content_fullwidth')),
			"description" => esc_html__("Enter any text/content you would like to be shown prominently in your carousel", 'salient-core'),
			"admin_label" => false
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__('Content Alignment','salient-core'),
			'save_always' => true,
			"param_name" => "flickity_fixed_content_alignment",
			"value" => array(
				esc_html__("Left (Default)", "salient-core") => "default",
				esc_html__("Right", "salient-core") => "right",
			),
			"dependency" => array('element' => "flickity_formatting", 'value' => array('fixed_text_content_fullwidth')),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA Button Text", 'salient-core'),
			"param_name" => "cta_button_text",
			"description" => esc_html__("Enter your CTA text here" , 'salient-core'),
			"dependency" => array('element' => "flickity_formatting", 'value' => array('fixed_text_content_fullwidth'))
		),

		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA Button Link URL", 'salient-core'),
			"param_name" => "cta_button_url",
			"description" => esc_html__("Enter your URL here" , 'salient-core'),
			"dependency" => array('element' => "flickity_formatting", 'value' => array('fixed_text_content_fullwidth'))
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("CTA Button Open in New Tab", 'salient-core'),
			"param_name" => "cta_button_open_new_tab",
			"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
			"description" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "flickity_formatting", 'value' => array('fixed_text_content_fullwidth'))
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__('CTA Button Color','salient-core'),
			"param_name" => "button_color",
			"value" => $el_color_list,
			"dependency" => array('element' => "flickity_formatting", 'value' => array('fixed_text_content_fullwidth')),
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__('Columns','salient-core') . '<span>' . esc_html__('Desktop','salient-core') . '</span>',
			'save_always' => true,
			"param_name" => "desktop_cols",
			"value" => array(
				"Default (4)" => "4",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
				"7" => "7",
				"8" => "8",
			),
			"edit_field_class" => "col-md-2 vc_column",
			"dependency" => array('element' => "script", 'value' => array('owl_carousel')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "<span>" . esc_html__('Desktop Small','salient-core') . "</span>",
			'save_always' => true,
			"param_name" => "desktop_small_cols",
			"value" => array(
				"Default (3)" => "3",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
				"7" => "7",
				"8" => "8",
			),
			"edit_field_class" => "col-md-2 vc_column",
			"dependency" => array('element' => "script", 'value' => array('owl_carousel')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "<span>" . esc_html__('Tablet','salient-core') . "</span>",
			'save_always' => true,
			"param_name" => "tablet_cols",
			"value" => array(
				"Default (2)" => "2",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
			),
			"edit_field_class" => "col-md-2 vc_column",
			"dependency" => array('element' => "script", 'value' => array('owl_carousel')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "<span>" . esc_html__('Mobile','salient-core') . "</span>",
			'save_always' => true,
			"param_name" => "mobile_cols",
			"value" => array(
				"Default (1)" => "1",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
			),
			"dependency" => array('element' => "script", 'value' => array('owl_carousel')),
			"edit_field_class" => "col-md-2 vc_column",
			"description" => ''
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__('Columns','salient-core') . '<span>' . esc_html__('Desktop','salient-core') . '</span>',
			'save_always' => true,
			"param_name" => "desktop_cols_flickity",
			"value" => array(
				"Default (3)" => "3",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
				"7" => "7",
				"8" => "8",
				"9" => "9",
			),
			"edit_field_class" => "col-md-2 vc_column",
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "<span>" . esc_html__('Desktop Small','salient-core') . "</span>",
			'save_always' => true,
			"param_name" => "desktop_small_cols_flickity",
			"value" => array(
				"Default (3)" => "3",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
				"7" => "7",
				"8" => "8",
				"9" => "9",
			),
			"edit_field_class" => "col-md-2 vc_column",
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "<span>" . esc_html__('Tablet','salient-core') . "</span>",
			'save_always' => true,
			"param_name" => "tablet_cols_flickity",
			"value" => array(
				"Default (2)" => "2",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6"
			),
			"edit_field_class" => "col-md-2 vc_column",
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "<span>" . esc_html__('Phone','salient-core') . "</span>",
			'save_always' => true,
			"param_name" => "phone_cols_flickity",
			"value" => array(
				"Default (1)" => "1",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6"
			),
			"edit_field_class" => "col-md-2 vc_column",
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => ''
		),

		array(
			  "type" => "dropdown",
			  "heading" => esc_html__("Controls", "salient-core"),
			  "param_name" => "flickity_controls",
			  "value" => array(
				    esc_html__("Pagination",'salient-core') => "default",
					esc_html__("Next/Prev Arrows Overlaid",'salient-core') => "next_prev_arrows_overlaid",
					esc_html__("Touch Indicator and Total Visualized",'salient-core') => "touch_total",
					esc_html__("None",'salient-core') => "none",
				),
			  'save_always' => true,
				"dependency" => array('element' => "flickity_formatting", 'value' => array('default')),
			  "description" => esc_html__("Please select the controls you would like for your gallery ", "salient-core"),
		),

    array(
      "type" => "dropdown",
      "heading" => esc_html__("Touch Indicator Style", "salient-core"),
      "param_name" => "flickity_touch_total_style",
      "value" => array(
          esc_html__("Border Outline",'salient-core') => "default",
          esc_html__("Solid Background",'salient-core') => "solid_bg",
      ),
      'save_always' => true,
      "dependency" => array('element' => "flickity_controls", 'value' => array('touch_total')),
      "description" => '',
    ),

    array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Touch Indicator BG Color",
			"param_name" => "flickity_touch_total_indicator_bg_color",
			"value" => "",
      "dependency" => array('element' => "flickity_touch_total_style", 'value' => array('solid_bg')),
			"description" =>  esc_html__("The color of the background of your touch indicator button.", "salient-core")	  	
		),
    array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Touch Indicator Icon Color",
			"param_name" => "flickity_touch_total_indicator_icon_color",
			"value" => "",
      "dependency" => array('element' => "flickity_touch_total_style", 'value' => array('solid_bg')),
			"description" =>  esc_html__("The color of your touch indicator button icon.", "salient-core")	  	
		),

		array(
				 "type" => 'checkbox',
				 "heading" => esc_html__('Remove Bottom "Total" Indicator', "salient-core"),
				 "param_name" => "flickity_touch_total_hide_indicator",
				 "value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
				 'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				 "dependency" => array('element' => "flickity_controls", 'value' => array('touch_total')),
		 ),
		 
		 array(
 			  "type" => "dropdown",
 			  "heading" => esc_html__("Touch Indicator Icon Coloring", "salient-core"),
 			  "param_name" => "flickity_touch_total_icon_color",
 			  "value" => array(
 				    esc_html__("Automatic",'salient-core') => "default",
 						esc_html__("Light",'salient-core') => "light",
 						esc_html__("Dark",'salient-core') => "dark"
 				),
 			  'save_always' => true,
 				"dependency" => array('element' => "flickity_touch_total_style", 'value' => array('default')),
 			  "description" => '',
 		),

		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__('Control Coloring','salient-core'),
			"param_name" => "color",
			"value" => array(
				esc_html__( "Default (inherit from row Text Color)", "salient-core") => "default",
				esc_html__( "Accent Color", "salient-core") => "accent-color",
				esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
				esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",
				esc_html__( "Extra Color 3", "salient-core") => "extra-color-3"
			),
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),

		array(
			  "type" => "dropdown",
			  "heading" => esc_html__("Overflow Visibility", "salient-core"),
			  "param_name" => "flickity_overflow",
			  "value" => array(
				    "Hidden" => "hidden",
				    "Visible" => "visible",
				),
			  'save_always' => true,
			  "dependency" => array('element' => "flickity_formatting", 'value' => array('default')),
		),

		array(
			  "type" => "dropdown",
			  "heading" => esc_html__("Wrap Around Items", "salient-core"),
			  "param_name" => "flickity_wrap_around",
			  "value" => array(
				    "Wrap Around (infinite loop)" => "wrap",
				    "Do Not Wrap" => "no-wrap",
				),
				'description' => 'At the end of the items, determine if they should wrap-around to the other end for an infinite loop.',
			  'save_always' => true,
			  "dependency" => array('element' => "flickity_formatting", 'value' => array('default')),
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Pagination Alignment", 'salient-core'),
			'save_always' => true,
			"param_name" => "pagination_alignment_flickity",
			"value" => array(
				"Middle" => "default",
				"Left" => "left",
				"Right" => "right"
			),
			"dependency" => array('element' => "flickity_controls", 'value' => array('default')),
			"description" => ''
		),

		array(
			"type" => "textfield",
			"heading" => esc_html__("Carousel Title", 'salient-core'),
			"param_name" => "carousel_title",
			"dependency" => array('element' => "script", 'value' => array('carouFredSel')),
			"description" => esc_html__("Enter the title you would like at the top of your carousel (optional)" , 'salient-core')
		),

		array(
			  "type" => "dropdown",
			  "heading" => esc_html__("Item Spacing", "salient-core"),
			  "param_name" => "flickity_spacing",
			  "value" => array(
				    "Default" => "default",
				    "5px" => "5px",
				    "10px" => "10px",
						"15px" => "15px",
						"20px" => "20px",
						"30px" => "30px"
				),
			  'save_always' => true,
				"description" => 'Select the spacing that will be between each carousel item. (Applied to both sides of each item)',
			  "dependency" => array('element' => "flickity_formatting", 'value' => array('default')),
		),
		array(
				"type" => 'checkbox',
				"heading" => esc_html__("Center Carousel Columns", "salient-core"),
				"param_name" => "flickity_centered_cells",
				"description" => esc_html__("Keeps the cells centered aligned.", "salient-core"),
				"value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"dependency" => array('element' => "flickity_formatting", 'value' => array('default')),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Column Vertical Alignment", 'salient-core'),
			'save_always' => true,
			"param_name" => "flickity_column_vertical_alignment",
			"value" => array(
				"Top" => "default",
				"Middle" => "middle",
				"Bottom" => "bottom",
			),
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Column Padding", 'salient-core'),
			'save_always' => true,
			"param_name" => "column_padding",
			"value" => array(
				"None" => "0",
				"5px" => "5px",
				"10px" => "10px",
				"15px" => "15px",
				"20px" => "20px",
				"30px" => "30px",
				"40px" => "40px",
				"50px" => "50px",
				esc_html__('Custom','salient-core') => 'custom'
			),
			"dependency" => array('element' => "script", 'value' => array('owl_carousel','flickity')),
			"description" => esc_html__("Please select your desired column padding " , 'salient-core')
		),

		array(
			"type" => "nectar_numerical",
			"class" => "",
			"placeholder" => '',
			"heading" =>  esc_html__("Custom Column Padding", "salient-core"),
			"value" => "",
			"edit_field_class" => "zero-floor vc_col-xs-12",
			"param_name" => "column_padding_custom",
			"dependency" => array('element' => "column_padding", 'value' => array('custom')),
			"description" => ""
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Carousel Top/Bottom Margin", 'salient-core'),
			'save_always' => true,
			"param_name" => "flickity_element_spacing",
			"value" => array(
				"Default" => "default",
				"None" => "0",
				"10px" => "10px",
				"20px" => "20px",
				"30px" => "30px",
				"40px" => "40px",
				"50px" => "50px",
				"60px" => "60px",
				"70px" => "70px",
				"80px" => "80px"
			),
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => esc_html__("Please select your desired top/bottom margin to apply to the carousel element." , 'salient-core')
		),
		array(
				 "type" => 'checkbox',
				 "heading" => esc_html__("Subtle Item Scale When Dragging", "salient-core"),
				 "param_name" => "flickity_image_scale_on_drag",
				 "description" => esc_html__("Will cause your carousel items to shrink slightly when dragging.", "salient-core"),
				 "value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
				 'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				 "dependency" => array('element' => "flickity_formatting", 'value' => array('default')),
		 ),
		 array(
 				 "type" => 'checkbox',
 				 "heading" => esc_html__("Adaptive Height", "salient-core"),
 				 "param_name" => "flickity_adaptive_height",
 				 "description" => esc_html__("Allows your carousel to change height when switching between items with varying height.", "salient-core"),
 				 "value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
				 'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
 				 "dependency" => array('element' => "flickity_formatting", 'value' => array('default')),
		  ),
		  
		array(
			"type" => "textfield",
			"heading" => esc_html__("Transition Scroll Speed", 'salient-core'),
			"param_name" => "scroll_speed",
			"dependency" => array('element' => "script", 'value' => array('carouFredSel')),
			"description" => esc_html__("Enter in milliseconds (default is 700)" , 'salient-core')
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Loop?", 'salient-core'),
			"param_name" => "loop",
			"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "script", 'value' => array('owl_carousel')),
			"description" => ""
		),

		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Carousel Column Color", 'salient-core'),
			"param_name" => "column_color",
			"value" => "",
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Border Radius", 'salient-core'),
			'save_always' => true,
			"param_name" => "border_radius",
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"value" => array(
				esc_html__("0px", 'salient-core') => "none",
				esc_html__("3px", 'salient-core') => "3px",
				esc_html__("5px", 'salient-core') => "5px",
				esc_html__("10px", 'salient-core') => "10px",
				esc_html__("15px", 'salient-core') => "15px",
				esc_html__("20px", 'salient-core') => "20px"
			),
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Column Border", 'salient-core'),
			"value" => array("Enable?" => "true" ),
			"param_name" => "enable_column_border",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "script", 'value' => array('flickity')),
			"description" => "This add a subtle border to your columns"
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Enable Animation", 'salient-core'),
			"value" => array("Enable Animation?" => "true" ),
			"param_name" => "enable_animation",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "script", 'value' => array('owl_carousel')),
			"description" => "This will cause your list items to animate in one by one"
		),

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Animation Delay", 'salient-core'),
			"param_name" => "delay",
			"admin_label" => false,
			"description" => "",
			"dependency" => Array('element' => "enable_animation", 'not_empty' => true)
		),

		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"admin_label" => false,
			"heading" => esc_html__("Easing", 'salient-core'),
			"param_name" => "easing",
			'save_always' => true,
			"dependency" => array('element' => "script", 'value' => array('carouFredSel')),
			"value" => array(
				'linear'=>'linear',
				'swing'=>'swing',
				'easeInQuad'=>'easeInQuad',
				'easeOutQuad' => 'easeOutQuad',
				'easeInOutQuad'=>'easeInOutQuad',
				'easeInCubic'=>'easeInCubic',
				'easeOutCubic'=>'easeOutCubic',
				'easeInOutCubic'=>'easeInOutCubic',
				'easeInQuart'=>'easeInQuart',
				'easeOutQuart'=>'easeOutQuart',
				'easeInOutQuart'=>'easeInOutQuart',
				'easeInQuint'=>'easeInQuint',
				'easeOutQuint'=>'easeOutQuint',
				'easeInOutQuint'=>'easeInOutQuint',
				'easeInExpo'=>'easeInExpo',
				'easeOutExpo'=>'easeOutExpo',
				'easeInOutExpo'=>'easeInOutExpo',
				'easeInSine'=>'easeInSine',
				'easeOutSine'=>'easeOutSine',
				'easeInOutSine'=>'easeInOutSine',
				'easeInCirc'=>'easeInCirc',
				'easeOutCirc'=>'easeOutCirc',
				'easeInOutCirc'=>'easeInOutCirc',
				'easeInElastic'=>'easeInElastic',
				'easeOutElastic'=>'easeOutElastic',
				'easeInOutElastic'=>'easeInOutElastic',
				'easeInBack'=>'easeInBack',
				'easeOutBack'=>'easeOutBack',
				'easeInOutBack'=>'easeInOutBack',
				'easeInBounce'=>'easeInBounce',
				'easeOutBounce'=>'easeOutBounce',
				'easeInOutBounce'=>'easeInOutBounce',
			),
			"description" => "Select the animation easing you would like for slide transitions <a href=\"http://jqueryui.com/resources/demos/effect/easing.html\" target=\"_blank\"> Click here </a> to see examples of these."
			),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Slider Sizing Method", 'salient-core'),
				'save_always' => true,
				"dependency" => array('element' => "script", 'value' => array('simple_slider')),
				"param_name" => "simple_slider_sizing",
				"value" => array(
					esc_html__("Locked to Aspect Ratio",'salient-core') => "aspect_ratio",
					esc_html__("Percentage of Screen Height",'salient-core') => "percentage",
				),
				"description" => ''
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Slider Aspect Ratio", 'salient-core'),
				'save_always' => true,
				"param_name" => "simple_slider_aspect_ratio",
				"value" => array(
					"1:1" => "1-1",
					"4:3" => "4-3",
					"3:2" => "3-2",
					"16:9" => "16-9",
					"2:1" => "2-1",
					"4:5" => "4-5",
				),
				"dependency" => array('element' => "simple_slider_sizing", 'value' => array('aspect_ratio')),
				"description" => esc_html__("Will constrain your slides to display at a specific aspect ratio.", 'salient-core'),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Slider Height", 'salient-core'),
				'save_always' => true,
				"param_name" => "simple_slider_height",
				"value" => array(
					"Default (50%)" => "50vh",
					"20%" => "20vh",
					"25%" => "25vh",
					"30%" => "30vh",
					"35%" => "35vh",
					"40%" => "40vh",
					"45%" => "45vh",
					"50%" => "50vh",
					"55%" => "55vh",
					"60%" => "60vh",
					"65%" => "65vh",
					"70%" => "70vh",
					"75%" => "75vh",
					"80%" => "80vh",
					"85%" => "85vh",
					"90%" => "90vh",
					"95%" => "95vh",
					"100%" => "100vh"
				),
				"dependency" => array('element' => "simple_slider_sizing", 'value' => array('percentage')),
				"description" => esc_html__("Will constrain your slides to display at a flexible height based on the user's screen size.", 'salient-core'),
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Minimum Height", 'salient-core'),
				"param_name" => "simple_slider_min_height",
				"dependency" => array('element' => "script", 'value' => array('simple_slider')),
				"description" => esc_html__("Enter your desired minimum height for the slider." , 'salient-core')
			),

			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Arrow Controls", 'salient-core'),
				"param_name" => "simple_slider_arrow_controls",
				"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			  "dependency" => array('element' => "script", 'value' => array('simple_slider')),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Arrow Control Positioning", 'salient-core'),
				'save_always' => true,
				"param_name" => "simple_slider_arrow_positioning",
				"value" => array(
					esc_html__("Inside Slider", 'salient-core') => "inside",
					esc_html__("Overlapping Slider Edges", 'salient-core') => "overlapping",
				),
				"dependency" => Array('element' => "simple_slider_arrow_controls", 'not_empty' => true),
				"description" => ''
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"edit_field_class" => "col-md-6",
				"heading" => esc_html__("Arrow Button Color", 'salient-core'),
				"param_name" => "simple_slider_arrow_button_color",
				"value" => "",
				"dependency" => Array('element' => "simple_slider_arrow_controls", 'not_empty' => true),
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"edit_field_class" => "col-md-6 col-md-last",
				"heading" => esc_html__("Arrow Color", 'salient-core'),
				"param_name" => "simple_slider_arrow_color",
				"value" => "",
				"dependency" => Array('element' => "simple_slider_arrow_controls", 'not_empty' => true),
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => esc_html__("Arrow Border Color", 'salient-core'),
				"param_name" => "simple_slider_arrow_button_border_color",
				"value" => "",
				"dependency" => Array('element' => "simple_slider_arrow_controls", 'not_empty' => true),
				"description" => esc_html__('Used in the "Overlapping Slider Edges" style', 'salient-core')
			),

			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Pagination Controls", 'salient-core'),
				"param_name" => "simple_slider_pagination_controls",
				"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			  "dependency" => array('element' => "script", 'value' => array('simple_slider')),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Pagination Coloring", 'salient-core'),
				'save_always' => true,
				"param_name" => "simple_slider_pagination_coloring",
				"value" => array(
					"Automatic" => "default",
					"Light" => "light",
					"Dark" => "dark",
				),
				"dependency" => Array('element' => "simple_slider_pagination_controls", 'not_empty' => true),
				"description" => ''
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Pagination Alignment", 'salient-core'),
				'save_always' => true,
				"param_name" => "simple_slider_pagination_alignment",
				"value" => array(
					"Middle" => "default",
					"Left" => "left",
					"Right" => "right"
				),
				"dependency" => Array('element' => "simple_slider_pagination_controls", 'not_empty' => true),
				"description" => ''
			),

      array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Touch Indicator", 'salient-core'),
				"param_name" => "simple_slider_touch_indicator",
				"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			  "dependency" => array('element' => "script", 'value' => array('simple_slider')),
			),
      array(
        "type" => "colorpicker",
        "class" => "",
        "heading" => "Touch Indicator BG Color",
        "param_name" => "simple_slider_touch_indicator_bg_color",
        "value" => "",
        "dependency" => Array('element' => "simple_slider_touch_indicator", 'not_empty' => true),
        "description" =>  esc_html__("The color of the background of your touch indicator button.", "salient-core")	  	
      ),
      array(
        "type" => "colorpicker",
        "class" => "",
        "heading" => "Touch Indicator Icon Color",
        "param_name" => "simple_slider_touch_indicator_icon_color",
        "value" => "",
        "dependency" => Array('element' => "simple_slider_touch_indicator", 'not_empty' => true),
        "description" =>  esc_html__("The color of your touch indicator button icon.", "salient-core")	  	
      ),

			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Slider Transition Type", 'salient-core'),
				'save_always' => true,
				"param_name" => "simple_slider_transition_type",
				"value" => array(
					"Slide" => "slide",
					"Fade" => "fade",
				),
				"dependency" => array('element' => "script", 'value' => array('simple_slider')),
				"description" => ''
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Parallax Images", 'salient-core'),
				"param_name" => "simple_slider_parallax",
				"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"dependency" => array('element' => "simple_slider_transition_type", 'value' => array('slide')),
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Wrap Slides", 'salient-core'),
				"param_name" => "simple_slider_wrap",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"dependency" => array('element' => "script", 'value' => array('simple_slider')),
				"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
		    'description' => 'At the end of the items, determine if they should wrap-around to the other end for an infinite loop.',
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Emit slide color to row background", 'salient-core'),
				"param_name" => "simple_slider_row_bg_connect",
				"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"dependency" => array('element' => "script", 'value' => array('simple_slider')),
				"description" => esc_html__("This will alter the row background color to match the background color set on the active carousel slide.", 'salient-core'),
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Autorotate?", 'salient-core'),
				"param_name" => "autorotate",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"value" => Array(esc_html__("Yes", 'js_composer') => 'true'),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Slider Transition Type", 'salient-core'),
				'save_always' => true,
				"param_name" => "autorotate_type",
				"value" => array(
					esc_html__("Default","salient-core") => "default",
					esc_html__("Ticker Movement","salient-core") => "ticker",
				),
				"dependency" => array('element' => "autorotate", 'not_empty' => true),
				"description" => ''
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Ticker Movement Speed", 'salient-core'),
				'save_always' => true,
				"param_name" => "ticker_speed",
				"value" => array(
					esc_html__("Slow",'salient-core') => 'slow',
					esc_html__("Medium",'salient-core') => 'medium',
					esc_html__("Fast",'salient-core') => 'fast',
				),
				"dependency" => array('element' => "autorotate_type", 'value' => 'ticker'),
				"description" => ''
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Autorotation Speed", 'salient-core'),
				"param_name" => "autorotation_speed",
				"dependency" => array('element' => "autorotate_type", 'value' => array('default')),
				"description" => esc_html__("Enter in milliseconds (default is 5000)" , 'salient-core')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Pause Autorotate On Hover", "salient-core"),
				"param_name" => "flickity_autorotate_pause_on_hover",
				"description" => '',
				"value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
			    'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"dependency" => array('element' => "script", 'value' => array('flickity','simple_slider')),
			),
		),
		"custom_markup" => '
		<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
		<ul class="tabs_controls">
		</ul>
		%content%
		</div>'
		,
		'default_content' => '
		[item id="'.$tab_id_1.'"] Add Content Here [/item]
		[item id="'.$tab_id_2.'"] Add Content Here [/item]
		[item id="'.$tab_id_3.'"] Add Content Here [/item]
		',
		"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
	);

	?>
