<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);
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
	"name"  => esc_html__("Tabs", "salient-core"),
	"base" => "tabbed_section",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-ui-tab-content",
	"category" => esc_html__('Interactive', 'salient-core'),
	"description" => esc_html__('Tabbed content', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", "salient-core"),
			"param_name" => "style",
			"admin_label" => true,
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("Material", "salient-core") => "material",
				esc_html__("Minimal", "salient-core") => "minimal",
				esc_html__("Minimal Alt", "salient-core") => "minimal_alt",
				esc_html__("Minimal Flexible Width", "salient-core") => "minimal_flexible",
				esc_html__("Toggle Button", "salient-core") => "toggle_button",
				esc_html__("Vertical", "salient-core") => "vertical",
				esc_html__("Vertical Material", "salient-core") => "vertical_modern",
				esc_html__("Vertical Sticky Scrolling", "salient-core") => "vertical_scrolling",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the style you desire for your tabbed element.", "salient-core")
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Tab Change Animation", "salient-core"),
			"param_name" => "tab_change_animation",
			"admin_label" => false,
			"value" => array(
				esc_html__("Fade",'salient-core') => 'fade',
				esc_html__("None",'salient-core') => "none"
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('minimal','default', 'minimal_alt', 'material', 'toggle_button')),
			"description" => ''
		),

		array(
			"type" => "nectar_group_header",
			"class" => "",
			"heading" => esc_html__("Create exactly two tabs to display in the toggle format. If more than two tabs exist, the Toggle Button style will not be utilized.", "salient-core"),
			"param_name" => "toggle_button_info_box",
			"edit_field_class" => "info-box",
			"value" => '',
			"dependency" => Array('element' => "style", 'value' => array('toggle_button')),
		),

		array(
			"type" => "nectar_radio_tab_selection",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Sticky Aspect", "salient-core"),
			"param_name" => "vs_sticky_aspect",
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"options" => array(
				esc_html__("Tab Links", "salient-core") => "default",
				esc_html__("Tab Content", "salient-core") => "content",
			),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Alignment", "salient-core"),
			"param_name" => "alignment",
			"admin_label" => false,
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('minimal','default', 'minimal_alt', 'material')),
			"description" => esc_html__("Please select your tabbed alignment", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Spacing", "salient-core"),
			"param_name" => "spacing",
			"admin_label" => false,
			"value" => array(
				"Default" => "default",
				"15px" => "side-15px",
				"20px" => "side-20px",
				"25px" => "side-25px",
				"30px" => "side-30px",
				"35px" => "side-35px",
				"40px" => "side-40px",
				"45px" => "side-45px"
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('minimal','default', 'minimal_alt',  'material')),
			"description" => esc_html__("Please select your desired spacing", "salient-core")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Tab Color",
			"param_name" => "tab_color",
			"value" => $el_color_list
		),

		
		array(
			"type" => "textfield",
			"edit_field_class" => "nectar-one-half",
			"heading" => esc_html__("Custom Font Size", "salient-core"),
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"param_name" => "vs_font_size",
		),
		array(
			"type" => "textfield",
			"edit_field_class" => "nectar-one-half nectar-one-half-last",
			"heading" => esc_html__("Custom Sub Description Font Size", "salient-core"),
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"param_name" => "vs_sub_desc_font_size",
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Tab Content Animation", "salient-core"),
			"param_name" => "vs_content_animation",
			"edit_field_class" => "nectar-one-half",
			"admin_label" => false,
			"value" => array(
				esc_html__("Fade",'salient-core') => "fade",
				esc_html__("Slide Reveal",'salient-core') => "slide_reveal",
				esc_html__("Slide Reveal Zoom",'salient-core') => "slide_reveal_zoom",
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('content')),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Tab Link Animation", "salient-core"),
			"param_name" => "vs_link_animation",
			"edit_field_class" => "nectar-one-half nectar-one-half-last",
			"admin_label" => false,
			"value" => array(
				esc_html__("Opacity Change",'salient-core') => "opacity",
        esc_html__("Animated Underline",'salient-core') => "underline",
				esc_html__("Text Outline Fill",'salient-core') => "outline_fill"
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('content')),
		),
    array(
			"type" => "dropdown",
			"heading" => esc_html__("Underline Distance From Text", "salient-core"),
			"param_name" => "vs_link_underline_distance",
			"description" => esc_html__("Adjust this value as needed depending on how you would like the underline positioned relative to the text.", "salient-core"),
			"dependency" => Array('element' => "vs_link_animation", 'value' => array('underline')),
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("Closer To Text", "salient-core") => "closer",
				esc_html__("Closest To Text", "salient-core") => "closest",
			),
			'save_always' => true,
		),

		array(
			"type" => "dropdown",
			"heading" => esc_html__("Navigation Side", "salient-core"),
			"param_name" => "vs_navigation_alignment",
			"admin_label" => false,
			"value" => array(
				esc_html__( "Left", "salient-core") => "left",
				esc_html__( "Right", "salient-core") => "right",
			),
			"edit_field_class" => "nectar-one-half",
			'save_always' => true,
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('content')),
		),
		array(
			"type" => "dropdown",
			"edit_field_class" => "nectar-one-half nectar-one-half-last",
			"heading" => esc_html__("Navigation Width", "salient-core"),
			"param_name" => "vs_navigation_width_2",
			"admin_label" => false,
			"value" => array(
				"25%" => "25%",
				"30%" => "30%",
				"35%" => "35%",
				"40%" => "40%",
				"45%" => "45%",
				"50%" => "50%",
				"55%" => "55%",
				"60%" => "60%",
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('content')),
		),

    array(
			"type" => "dropdown",
			"heading" => esc_html__("Navigation Functionality", "salient-core"),
			"param_name" => "vs_navigation_func",
			"admin_label" => false,
			"value" => array(
				"All Links Visible" => "default",
				"Only Active Link Visible" => "active_link_only",
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('default')),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Navigation Width", "salient-core"),
			"param_name" => "vs_navigation_width",
			"admin_label" => false,
			"value" => array(
				"Regular" => "regular",
				"Wide" => "wide",
				"Narrow" => "narrow"
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('default')),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Navigation Item Spacing", "salient-core"),
			"param_name" => "vs_navigation_spacing",
			"admin_label" => false,
			"value" => array(
				"15px" => "15px",
				"20px" => "20px",
				"25px" => "25px",
				"30px" => "30px",
				"35px" => "35px",
				"40px" => "40px",
				"45px" => "45px",
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_navigation_func", 'value' => array('default')),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Navigation Item Mobile Display", "salient-core"),
			"param_name" => "vs_navigation_mobile_display",
			"admin_label" => false,
			"value" => array(
				"Visible Above Each Section" => "visible",
				"Hidden" => "hidden",
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_navigation_func", 'value' => array('default')),
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Tab Spacing", "salient-core"),
			"param_name" => "vs_tab_spacing",
			"admin_label" => false,
			"value" => array(
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
        '10px' => '10px',
        '20px' => '20px',
        "None" => "0%",
			),
			'save_always' => true,
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('default')),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Tab Link Element", "salient-core"),
			"param_name" => "vs_tab_tag",
			"admin_label" => false,
			"value" => array(
				"Inherit from Body" => "p",
				"Heading 6" => "h6",
			  "Heading 5" => "h5",
				"Heading 4" => "h4",
				"Heading 3" => "h3",
				"Heading 2" => "h2",
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling' ,'hover_based'))
		),
    array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Tab Link Spacing", "salient-core"),
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('content')),
			"param_name" => "vs_tab_link_spacing",
		),

    array(
			"type" => "textarea",
			"holder" => "hidden",
			"heading" => esc_html__("Text Content", "salient-core"),
			"param_name" => "vs_text_content",
			"dependency" => Array('element' => "vs_sticky_aspect", 'value' => array('content')),
			"value" => '',
			"description" => esc_html__("Text to display before the tab links.", "salient-core"),
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Enable CTA Button", "salient-core"),
			"param_name" => "vs_enable_cta",
			"group" => esc_html__('Call to action','salient-core'),
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => array(esc_html__("Yes", "salient-core") => 'true'),
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"description" => ""
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA button text", "salient-core"),
			"param_name" => "vs_cta_text",
			"group" => esc_html__('Call to action','salient-core'),
			"admin_label" => false,
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA button link", "salient-core"),
			"param_name" => "vs_cta_link",
			"group" => esc_html__('Call to action','salient-core'),
			"description" => esc_html__("Enter a URL for your button link here", "salient-core"),
			"admin_label" => false,
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
		),

		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "CTA Style",
			"param_name" => "vs_cta_style",
			"group" => esc_html__('Call to action','salient-core'),
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"value" => array(
				esc_html__("See Through Button", "salient-core") => "see-through",
				esc_html__("Arrow Animation", "salient-core") => "arrow-animation",
				esc_html__("Underline", "salient-core") => "underline",
				esc_html__("Text Reveal Wave", "salient-core") => "text-reveal-wave",
			)
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "CTA Text Color",
			"param_name" => "vs_cta_text_color",
			"group" => esc_html__('Call to action','salient-core'),
			"value" => "",
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"description" => ""
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'CTA Background Color', 'salient-core' ),
			'value' => array(
				esc_html__( "Transparent", "salient-core") => "default",
				esc_html__( "Accent Color", "salient-core") => "accent-color",
				esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
				esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",
				esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
				esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
				esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2",
				esc_html__( "Black", "salient-core") => "black",
				esc_html__( "White", "salient-core") => "white"
			),
			'save_always' => true,
			'param_name' => 'vs_cta_bg_color',
			"description" => "",
			"group" => esc_html__('Call to action','salient-core'),
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
		),

    array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => "CTA Display Tag",
      "group" => esc_html__('Call to action','salient-core'),
      "dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
      "param_name" => "vs_cta_heading_tag",
      "value" => array(
        "H6" => "h6",
        "H5" => "h5",
        "H4" => "h4",
        "H3" => "h3",
        "H2" => "h2",
        "H1" => "h1",
        "Paragraph" => "p",
        "Span" => "span"
      )),
		
		array(
			"type" => "nectar_numerical",
			"heading" => esc_html__("Padding", "salient-core") . "<span>" . esc_html__("Top", "salient-core") . "</span>",
			"param_name" => "vs_cta_padding_top",
			"group" => esc_html__('Call to action','salient-core'),
			"placeholder" => esc_html__("Top",'salient-core'),
			"edit_field_class" => "col-md-2 no-device-group constrain_group_1",
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"description" => ''
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Constrain 1', 'salient-core' ),
			'param_name' => 'constrain_group_1',
			'description' => '',
			"group" => esc_html__('Call to action','salient-core'),
			"edit_field_class" => "no-device-group constrain-icon",
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
		),
		array(
			"type" => "nectar_numerical",
			"heading" => "<span>" . esc_html__("Bottom", "salient-core") . "</span>",
			"param_name" => "vs_cta_padding_bottom",
			"group" => esc_html__('Call to action','salient-core'),
			"placeholder" => esc_html__("Bottom",'salient-core'),
			"edit_field_class" => "col-md-2 no-device-group constrain_group_1",
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"description" => ''
		),
		array(
			"type" => "nectar_numerical",
			"heading" => "<span>" . esc_html__("Left", "salient-core") . "</span>",
			"param_name" => "vs_cta_padding_left",
			"group" => esc_html__('Call to action','salient-core'),
			"placeholder" => esc_html__("Left",'salient-core'),
			"edit_field_class" => "col-md-2 no-device-group constrain_group_2",
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"description" => ''
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Constrain 2', 'salient-core' ),
			'param_name' => 'constrain_group_2',
			'description' => '',
			"group" => esc_html__('Call to action','salient-core'),
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"edit_field_class" => "no-device-group constrain-icon",
			'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
		),
		array(
			"type" => "nectar_numerical",
			"heading" => "<span>" . esc_html__("Right", "salient-core") . "</span>",
			"param_name" => "vs_cta_padding_right",
			"group" => esc_html__('Call to action','salient-core'),
			"placeholder" => esc_html__("Right",'salient-core'),
			"edit_field_class" => "no-device-group col-md-2 constrain_group_2",
			"dependency" => Array('element' => "style", 'value' => array('vertical_scrolling')),
			"description" => ''
		),

		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Optional CTA button", "salient-core"),
			"param_name" => "cta_button_text",
			"description" => esc_html__("If you wish to include an optional CTA button on your tabbed nav, enter the text here", "salient-core"),
			"admin_label" => false,
			"dependency" => Array('element' => "style", 'value' => array('minimal','minimal_alt'))
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA button link", "salient-core"),
			"param_name" => "cta_button_link",
			"description" => esc_html__("Enter a URL for your button link here", "salient-core"),
			"admin_label" => false,
			"dependency" => Array('element' => "style", 'value' => array('minimal','minimal_alt'))
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("CTA Button Color", "salient-core"),
			"param_name" => "cta_button_style",
			"admin_label" => false,
			"value" => array(
				"Accent Color" => "accent-color",
				"Extra Color 1" => "extra-color-1",
				"Extra Color 2" => "extra-color-2",
				"Extra Color 3" => "extra-color-3"
			),
			'save_always' => true,
			'description' => __( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
			"dependency" => Array('element' => "style", 'value' => array('minimal','minimal_alt'))
		),
		
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Full width divider line", "salient-core"),
			"param_name" => "full_width_line",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("This will cause the line that separates the tab links their content to display the full width of the screen.", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
			"dependency" => Array('element' => "style", 'value' => array('material'))
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Icon Font Size", "salient-core"),
			"param_name" => "icon_size",
			"admin_label" => false,
			"value" => array(
				"24px" => "24",
				"26px" => "26",
				"28px" => "28",
				"30px" => "30",
				"32px" => "32",
				"34px" => "34",
				"36px" => "36",
			),
			'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('minimal','minimal_alt','material','minimal_flexible')),
			'description' => esc_html__( 'Select the size you would like the optional tab icons to display in - Thin border sets like "Iconsmind" and "Linea" are better suited to display at higher values.', 'salient-core' ),
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", "salient-core"),
			"param_name" => "el_class",
			"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "salient-core")
		)
	),
	"custom_markup" => '
	<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
	<ul class="tabs_controls">
	</ul>
	%content%
	</div>'
	,
	'default_content' => '
	[tab title="'.esc_html__('Tab','salient-core').'" id="'.$tab_id_1.'"] I am text block. Click edit button to change this text. [/tab]
	[tab title="'.esc_html__('Tab','salient-core').'" id="'.$tab_id_2.'"] I am text block. Click edit button to change this text. [/tab]
	',
	"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
);
?>