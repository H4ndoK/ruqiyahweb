<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Horizontal List Item", "salient-core"),
	"base" => "nectar_horizontal_list_item",
	"icon" => "icon-wpb-nectar-horizontal-list-item",
	"allowed_container_element" => 'vc_row',
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Organize data into a clean list', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Columns",
			'save_always' => true,
			"param_name" => "columns",
			"value" => array(
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4"
			)
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Column Layout", "salient-core"),
			'save_always' => true,
			"param_name" => "column_layout_using_2_columns",
			"value" => array(
				"Even Widths" => "even",
				"60% | 40%" => "medium_first",
				"70% | 30%" => "large_first",
				"80% | 20%" => "xlarge_first",
				"30% | 70%" => "small_first",
				"40% | 60%" => "medium_last",
				"20% | 80%" => "xsmall_first",
			),
			"dependency" => Array('element' => "columns", 'value' => array('2')),
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Column Layout", "salient-core"),
			'save_always' => true,
			"param_name" => "column_layout_using_3_columns",
			"value" => array(
				"Even Widths" => "even",
				"20% | 40% | 40%" => "small_first",
				"50% | 25% | 25%" => "large_first",
				"25% | 50% | 25%" => "large_middle",
				"25% | 25% | 50%" => "large_last",	
			),
			"dependency" => Array('element' => "columns", 'value' => array('3')),
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Column Layout", "salient-core"),
			'save_always' => true,
			"param_name" => "column_layout_using_4_columns",
			"value" => array(
				"Even Widths" => "even",
				"15% | 35% | 35% | 15%" => "small_first_last",
				"35% | 35% | 15% | 15%" => "large_first",
				"35% | 15% | 35% | 15%" => "large_nth",
				"15% | 35% | 15% | 35%" => "small_nth",
			),
			"dependency" => Array('element' => "columns", 'value' => array('4')),
		),
		
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "Text Alignment <span class='row-heading'>Column One</span>",
			"param_name" => "col_1_text_align",
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			)
		),
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "<span class='row-heading'>Column Two</span>",
			"param_name" => "col_2_text_align",
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			),
			"dependency" => Array('element' => "columns", 'value' => array('2','3','4')),
		),
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "<span class='row-heading'>Column Three</span>",
			"param_name" => "col_3_text_align",
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			),
			"dependency" => Array('element' => "columns", 'value' => array('3','4')),
		),
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "<span class='row-heading'>Column Four</span>",
			"param_name" => "col_4_text_align",
			"value" => array(
				"Left" => "left",
				"Center" => "center",
				"Right" => "right"
			),
			"dependency" => Array('element' => "columns", 'value' => array('4')),
		),
		
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Column One Content", "salient-core"),
			"param_name" => "col_1_content",
			"admin_label" => true,
			"description" => esc_html__("Enter your column text here", "salient-core")
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Column Two Content", "salient-core"),
			"param_name" => "col_2_content",
			"admin_label" => true,
			"description" => esc_html__("Enter your column text here", "salient-core"),
			"dependency" => Array('element' => "columns", 'value' => array('2','3','4')),
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Column Three Content", "salient-core"),
			"param_name" => "col_3_content",
			"admin_label" => true,
			"description" => esc_html__("Enter your column text here", "salient-core"),
			"dependency" => Array('element' => "columns", 'value' => array('3','4')),
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Column Four Content", "salient-core"),
			"param_name" => "col_4_content",
			"admin_label" => true,
			"description" => esc_html__("Enter your column text here", "salient-core"),
			"dependency" => Array('element' => "columns", 'value' => array('4')),
		),
		
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "Text Element Type <span class='row-heading'>Column One</span>",
			"param_name" => "col_1_text_element",
			"value" => array(
				"Paragraph" => "p",
				"Heading 5" => "h5",
				"Heading 4" => "h4",
				"Heading 3" => "h3",
				"Heading 2" => "h2"
			)
		),
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "<span class='row-heading'>Column Two</span>",
			"param_name" => "col_2_text_element",
			"value" => array(
				"Paragraph" => "p",
				"Heading 5" => "h5",
				"Heading 4" => "h4",
				"Heading 3" => "h3",
				"Heading 2" => "h2"
			),
			"dependency" => Array('element' => "columns", 'value' => array('2','3','4')),
		),
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "<span class='row-heading'>Column Three</span>",
			"param_name" => "col_3_text_element",
			"value" => array(
				"Paragraph" => "p",
				"Heading 5" => "h5",
				"Heading 4" => "h4",
				"Heading 3" => "h3",
				"Heading 2" => "h2"
			),
			"dependency" => Array('element' => "columns", 'value' => array('3','4')),
		),
		array(
			"type" => "dropdown",
			"edit_field_class" => "col-md-2",
			'save_always' => true,
			"heading" => "<span class='row-heading'>Column Four</span>",
			"param_name" => "col_4_text_element",
			"value" => array(
				"Paragraph" => "p",
				"Heading 5" => "h5",
				"Heading 4" => "h4",
				"Heading 3" => "h3",
				"Heading 2" => "h2"
			),
			"dependency" => Array('element' => "columns", 'value' => array('4')),
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA Text", "salient-core"),
			"param_name" => "cta_1_text",
			"description" => esc_html__("Enter your CTA text here" , "salient-core"),
			"group" => "Call To Action Button"
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA Link URL", "salient-core"),
			"param_name" => "cta_1_url",
			"description" => esc_html__("Enter your URL here" , "salient-core"),
			"group" => "Call To Action Button"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("CTA Open in New Tab", "salient-core"),
			"param_name" => "cta_1_open_new_tab",
			"value" => Array(esc_html__("Yes", "salient-core") => 'true'),
			"group" => "Call To Action Button",
			"description" => ""
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA 2 Text", "salient-core"),
			"param_name" => "cta_2_text",
			"description" => esc_html__("Enter your CTA text here" , "salient-core"),
			"group" => "Call To Action Button 2"
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("CTA 2 Link URL", "salient-core"),
			"param_name" => "cta_2_url",
			"description" => esc_html__("Enter your URL here" , "salient-core"),
			"group" => "Call To Action Button 2"
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("CTA 2 Open in New Tab", "salient-core"),
			"param_name" => "cta_2_open_new_tab",
			"value" => Array(esc_html__("Yes", "salient-core") => 'true'),
			"description" => "",
			"group" => "Call To Action Button 2"
		),
		
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Inherit Font From", "salient-core"),
			'save_always' => true,
			"param_name" => "font_family",
			"value" => array(
				"p" => "p",
				"h6" => "h6",
				"h5" => "h5",
				"h4" => "h4",
				"h3" => "h3"
			)
		),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Full Item Link URL", "salient-core"),
			"param_name" => "url",
			"description" => esc_html__("Adding a URL for this will link your entire list item" , "salient-core")
		),
		
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Open Full Link In New Tab", "salient-core"),
			"param_name" => "open_new_tab",
			"value" => Array(esc_html__("Yes", "salient-core") => 'true'),
			"description" => ""
		),
		
		array(
			"type" => "dropdown",
			'save_always' => true,
			"heading" => "Style",
			"param_name" => "hover_effect",
			"value" => array(
				"Bottom Border, Color Hover Effect" => "default",
				"Bottom Border, No Hover Effect" => "none",
				"Full Border" => "full_border",
			),
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Hover Color", "salient-core"),
			"param_name" => "hover_color",
			"admin_label" => false,
			"dependency" => Array('element' => "hover_effect", 'value' => array('default','full_border')),
			"value" => array(
				"Accent-Color" => "accent-color",
				"Extra-Color-1" => "extra-color-1",
				"Extra-Color-2" => "extra-color-2",	
				"Extra-Color-3" => "extra-color-3",
				"Black" => "black",
				"White" => "white"
			),
			'save_always' => true,
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Border Radius", "salient-core"),
			'save_always' => true,
			"dependency" => Array('element' => "hover_effect", 'value' => array('full_border')),
			"param_name" => "border_radius",
			"value" => array(
				esc_html__("0px", "salient-core") => "none",
				esc_html__("3px", "salient-core") => "3px",
				esc_html__("5px", "salient-core") => "5px", 
				esc_html__("10px", "salient-core") => "10px", 
				esc_html__("15px", "salient-core") => "15px"
				)
			),	
			
			array(
				'type' => 'dropdown',
				"group" => "Icon",
				'heading' => __( 'Icon library', 'salient-core' ),
				'value' => array(
					esc_html__( 'None', 'salient-core' ) => 'none',
					esc_html__( 'Font Awesome', 'salient-core' ) => 'fontawesome',
					esc_html__( 'Iconsmind', 'salient-core' ) => 'iconsmind',
					esc_html__( 'Steadysets', 'salient-core' ) => 'steadysets',
					esc_html__( 'Linecons', 'salient-core' ) => 'linecons',
					esc_html__( 'Custom', 'salient-core' ) => 'custom',
				),
				'save_always' => true,
				'param_name' => 'icon_family',
				'description' => __( 'Select icon library.', 'salient-core' ),
			),
			array(
				'type' => 'dropdown',
				"group" => "Icon",
				'heading' => __( 'Icon Size', 'salient-core' ),
				'value' => array(
					esc_html__( 'Regular', 'salient-core' ) => 'regular',
					esc_html__( 'Small', 'salient-core' ) => 'small',
					esc_html__( 'Large', 'salient-core' ) => 'large',
					esc_html__( 'Extra Large', 'salient-core' ) => 'x_large',
				),
				'save_always' => true,
				'param_name' => 'icon_size',
			),
			array(
				"type" => "iconpicker",
				"group" => "Icon",
				"heading" => esc_html__("Icon", "salient-core"),
				"param_name" => "icon_fontawesome",
				"settings" => array( "iconsPerPage" => 240),
				"dependency" => array('element' => "icon_family", 'emptyIcon' => true, 'value' => 'fontawesome'),
				"description" => esc_html__("Select icon from library.", "salient-core")
			),
			array(
				"type" => "iconpicker",
				"group" => "Icon",
				"heading" => esc_html__("Icon", "salient-core"),
				"param_name" => "icon_iconsmind",
				"settings" => array( 'type' => 'iconsmind', 'emptyIcon' => true, "iconsPerPage" => 240),
				"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
				"description" => esc_html__("Select icon from library.", "salient-core")
			),
			array(
				"type" => "iconpicker",
				"group" => "Icon",
				"heading" => esc_html__("Icon", "salient-core"),
				"param_name" => "icon_linecons",
				"settings" => array( 'type' => 'linecons', 'emptyIcon' => true, "iconsPerPage" => 240),
				"dependency" => array('element' => "icon_family", 'value' => 'linecons'),
				"description" => esc_html__("Select icon from library.", "salient-core")
			),
			array(
				"type" => "iconpicker",
				"group" => "Icon",
				"heading" => esc_html__("Icon", "salient-core"),
				"param_name" => "icon_steadysets",
				"settings" => array( 'type' => 'steadysets', 'emptyIcon' => true, "iconsPerPage" => 240),
				"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
				"description" => esc_html__("Select icon from library.", "salient-core")
			),
			array(
				"type" => "fws_image",
				"heading" => esc_html__("Icon Image", "salient-core"),
				"param_name" => "icon_image",
				"value" => "",
				"group" => "Icon",
				"dependency" => array('element' => "icon_family", 'value' => 'custom'),
				"description" => esc_html__("Select a custom image to use as an icon.", "salient-core")
			),
		
	)
);

?>