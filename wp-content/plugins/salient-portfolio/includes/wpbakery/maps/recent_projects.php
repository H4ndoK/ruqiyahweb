<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_admin = is_admin();

$portfolio_types = ($is_admin) ? get_terms('project-type') : array('All' => 'all');

$types_options = array("All" => "all");
$types_options_2 = array("Default" => "default");

if($is_admin) {
	foreach ($portfolio_types as $type) {
		$types_options[$type->name] = $type->slug;
		$types_options_2[$type->name] = $type->slug;
	}
	
} else {
	$types_options['All'] = 'all';
	$types_options_2['All'] = 'all';
}

return array(
	"name" => esc_html__("Recent Projects", "salient-portfolio"),
	"base" => "recent_projects",
	"weight" => 8,
	"icon" => "icon-wpb-recent-projects",
	"category" => esc_html__('Query', 'salient-portfolio'),
	"description" => esc_html__('Show off some recent projects', 'salient-portfolio'),
	"params" => array(
		array(
			"type" => "dropdown_multi",
			"heading" => esc_html__("Portfolio Categories", "salient-portfolio"),
			"param_name" => "category",
			"admin_label" => true,
			"value" => $types_options,
			'save_always' => true,
			"description" => esc_html__("Please select the categories you would like to display for your recent projects carousel. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-portfolio")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Project Style", "salient-portfolio"),
			"param_name" => "project_style",
			"admin_label" => true,
			"value" => array(
				esc_html__("Meta below thumb w/ links on hover", "salient-portfolio") => "1",
				esc_html__("Meta on hover + entire thumb link", "salient-portfolio") => "2",
				esc_html__("Title overlaid w/ zoom effect on hover", "salient-portfolio") => "3",
				esc_html__("Meta from bottom on hover + entire thumb link", "salient-portfolio") => "4",
				esc_html__("Fullscreen Zoom Slider", "salient-portfolio") => 'fullscreen_zoom_slider'
			),
			'save_always' => true,
			"description" => esc_html__("Please select the style you would like your projects to display in ", "salient-portfolio")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Slider Controls", "salient-portfolio"),
			"param_name" => "slider_controls",
			"admin_label" => true,
			"dependency" => Array('element' => "project_style", 'value' => array('fullscreen_zoom_slider')),
			"value" => array(
				esc_html__("Prev/Nect Arrows", "salient-portfolio") => "arrows",
				esc_html__("Pagination Lines", "salient-portfolio") => "pagination",
				esc_html__("Both", "salient-portfolio") => "both",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the controls you would like your slider to use ", "salient-portfolio")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Slider Text Color", "salient-portfolio"),
			"param_name" => "slider_text_color",
			"dependency" => Array('element' => "project_style", 'value' => array('fullscreen_zoom_slider')),
			"admin_label" => true,
			"value" => array(
				esc_html__("Light", "salient-portfolio") => "light",
				esc_html__("Dark", "salient-portfolio") => "dark"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the color scheme that will be used for your slider text/controls ", "salient-portfolio")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Overlay Strength", "salient-portfolio"),
			"param_name" => "overlay_strength",
			"admin_label" => true,
			"value" => array(
				"0" => "0",
				"0.1" => "0.1",
				"0.2" => "0.2",
				"0.3" => "0.3",
				"0.4" => '0.4',
				"0.5" => '0.5',
				"0.6" => '0.6',
				"0.7" => '0.7',
				"0.8" => '0.8',
				"0.9" => '0.9',
				"1" => '1'
			),
			'save_always' => true,
			"dependency" => Array('element' => "project_style", 'value' => array('fullscreen_zoom_slider')),
			"description" => esc_html__("Please select the strength you would like for the image color overlay on your projects ", "salient-portfolio")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Link Text", "salient-portfolio"),
			"param_name" => "custom_link_text",
			"value" => '',
			"dependency" => Array('element' => "project_style", 'value' => array('fullscreen_zoom_slider')),
			"description" => esc_html__("The default text is \"View Project\". If you would like to use alternate text, enter it here.", "salient-portfolio")
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Display Project Excerpt", "salient-portfolio"),
			"param_name" => "display_project_excerpt",
			"description" => esc_html__("This will add the project excerpt below the project title on your slider", "salient-portfolio"),
			"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "project_style", 'value' => array('fullscreen_zoom_slider')),
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Auto rotate", "salient-portfolio"),
			"param_name" => "autorotate",
			"value" => '',
			"dependency" => Array('element' => "project_style", 'value' => array('fullscreen_zoom_slider')),
			"description" => esc_html__("If you would like this to auto rotate, enter the rotation speed in miliseconds here. i.e 5000", "salient-portfolio")
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Full Width Carousel", "salient-portfolio"),
			"param_name" => "full_width",
			"description" => esc_html__("This will make your carousel extend the full width of the page.", "salient-portfolio"),
			"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "project_style", 'value' => array('1','2','3','4')),
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Heading Text", "salient-portfolio"),
			"param_name" => "heading",
			"description" => esc_html__("Enter any text you would like for the heading of your carousel", "salient-portfolio"),
			"dependency" => Array('element' => "project_style", 'value' => array('1','2','3','4'))
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Page Link Text", "salient-portfolio"),
			"param_name" => "page_link_text",
			"description" => esc_html__("This will be the text that is in a link leading users to your desired page (will be omitted for full width carousels and an icon will be used instead)", "salient-portfolio"),
			"dependency" => Array('element' => "project_style", 'value' => array('1','2','3','4'))
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Page Link URL", "salient-portfolio"),
			"param_name" => "page_link_url",
			"description" => esc_html__("Enter portfolio page URL you would like to link to. Remember to include \"http://\"!", "salient-portfolio"),
			"dependency" => Array('element' => "project_style", 'value' => array('1','2','3','4'))
		),	
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Controls & Text Color", "salient-portfolio"),
			"param_name" => "control_text_color",
			"value" => array(
				esc_html__("Dark", "salient-portfolio") => "dark",
				esc_html__("Light", "salient-portfolio") => "light",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the color you desire for your carousel controls/heading text.", "salient-portfolio"),
			"dependency" => Array('element' => "project_style", 'value' => array('1','2','3','4'))
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Hide Carousel Controls", "salient-portfolio"),
			"param_name" => "hide_controls",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("Checking this box will remove the controls from your carousel", "salient-portfolio"),
			"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
			"dependency" => Array('element' => "project_style", 'value' => array('1','2','3','4'))
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Number of Projects To Show", "salient-portfolio"),
			"param_name" => "number_to_display",
			"description" => esc_html__("Enter as a number example \"6\"", "salient-portfolio")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Project Offset", "salient-portfolio"),
			"param_name" => "project_offset",
			"description" => esc_html__("Optionally enter a number e.g. \"2\" to offset your projects by", "salient-portfolio")
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Lightbox Only", "salient-portfolio"),
			"param_name" => "lightbox_only",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("This will remove the single project page from being accessible thus rendering your portfolio into only a gallery.", "salient-portfolio"),
			"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
			"dependency" => Array('element' => "project_style", 'value' => array('1','2','3','4'))
		)
	)
);

?>