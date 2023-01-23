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
		$types_options[$type->slug] = $type->slug;
		$types_options_2[$type->slug] = $type->slug;
	}
	
	
} else {
	$types_options['All'] = 'all';
	$types_options_2['All'] = 'all';
}


if( defined('NECTAR_THEME_NAME') ) {
	
	return array(
		"name" => esc_html__("Portfolio", "salient-portfolio"),
		"base" => "nectar_portfolio",
		"weight" => 8,
		"icon" => "icon-wpb-portfolio",
		"category" => esc_html__('Query', 'salient-portfolio'),
		"description" => esc_html__('Add a portfolio element', 'salient-portfolio'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Layout", "salient-portfolio"),
				"param_name" => "layout",
				"admin_label" => true,
				"value" => array(
					esc_html__("4 Columns", "salient-portfolio") => "4",
					esc_html__("3 Columns", "salient-portfolio") => "3",
					esc_html__("2 Columns", "salient-portfolio") => "2",
					esc_html__("Fullwidth", "salient-portfolio") => "fullwidth",
					esc_html__("Constrained Fullwidth", "salient-portfolio") => "constrained_fullwidth"
				),
				"description" => esc_html__("Please select the layout you would like for your portfolio. The Constrained Fullwidth option will allow your projects to display with the same formatting options only available to full width layout, but will limit the width to your website container area.", "salient-portfolio"),
				'save_always' => true
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Constrain Max Columns to 4?", "salient-portfolio"),
				"param_name" => "constrain_max_cols",
				"description" => esc_html__("This will change the max columns to 4 (default is 5 for fullwidth). Activating this will make it easier to create a grid with no empty spaces at the end of the list on all screen sizes.", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"dependency" => Array('element' => "layout", 'value' => 'fullwidth')
			),
			array(
				"type" => "dropdown_multi",
				"heading" => esc_html__("Portfolio Categories", "salient-portfolio"),
				"param_name" => "category",
				"admin_label" => true,
				"value" => $types_options,
				'save_always' => true,
				"description" => esc_html__("Please select the categories you would like to display for your portfolio. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-portfolio")
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Starting Category", "salient-portfolio"),
				"param_name" => "starting_category",
				"admin_label" => false,
				"value" => $types_options_2,
				'save_always' => true,
				"description" => esc_html__("Please select the category you would like you're portfolio to start filtered on.", "salient-portfolio"),
				"dependency" => Array('element' => "enable_sortable", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Project Style", "salient-portfolio"),
				"param_name" => "project_style",
				"admin_label" => true,
				'save_always' => true,
				"value" => array(
					esc_html__("Meta below thumb w/ links on hover", "salient-portfolio") => "1",
					esc_html__("Meta on hover + entire thumb link", "salient-portfolio") => "2",
					esc_html__("Meta on hover w/ zoom + entire thumb link", "salient-portfolio") => "7",
					esc_html__("Meta overlaid - bottom left aligned", "salient-portfolio") => "8",
					esc_html__("Meta overlaid w/ zoom effect on hover", "salient-portfolio") => "3",
					esc_html__("Meta overlaid w/ zoom effect on hover alt", "salient-portfolio") => "5",
					esc_html__("Meta from bottom on hover + entire thumb link", "salient-portfolio") => "4",
					esc_html__("3D Parallax on hover", "salient-portfolio") => "6",
					esc_html__("Meta below thumb w/ shadow hover", "salient-portfolio") => "9"
				),
				"description" => esc_html__("Please select the style you would like your projects to display in ", "salient-portfolio")
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Item Spacing", "salient-portfolio"),
				"param_name" => "item_spacing",
				'save_always' => true,
				"value" => array(
					esc_html__("Default", "salient-portfolio") => "default",
					"1px" => "1px",
					"2px" => "2px",
					"3px" => "3px",
					"4px" => "4px",
					"5px" => "5px",
					"6px" => "6px",
					"7px" => "7px",
					"8px" => "8px",
					"9px" => "9px",
					"10px" => "10px",
					"15px" => "15px",
					"20px" => "20px"
				),
				"description" => esc_html__("Please select the spacing you would like between your items. ", "salient-portfolio")
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Masonry Style", "salient-portfolio"),
				"param_name" => "masonry_style",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__('This will allow your portfolio items to display in a masonry layout as opposed to a fixed grid. When using a fullwidth layout, project image sizes will be determined based on the size set in each project via the "Masonry Item Sizing" field.', "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Bypass Image Cropping", "salient-portfolio"),
				"param_name" => "bypass_image_cropping",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("Enabling this will cause your portfolio to bypass the default Salient image cropping which varies based on project settings/above layout selection. The result will be a traditional masonry layout rather than a structured grid.", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Enable Sortable", "salient-portfolio"),
				"param_name" => "enable_sortable",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("Checking this box will allow your portfolio to display sortable filters", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Horizontal Filters", "salient-portfolio"),
				"param_name" => "horizontal_filters",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("This will allow your filters to display horizontally instead of in a dropdown. (Only used if you enable sortable above.)", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
				"dependency" => Array('element' => "enable_sortable", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Filter Alignment", "salient-portfolio"),
				"param_name" => "filter_alignment",
				"value" => array(
					esc_html__("Default", "salient-portfolio") => "default",
					esc_html__("Centered", "salient-portfolio") => "center",
					esc_html__("Left", "salient-portfolio") => "left"
				),
				'save_always' => true,
				"dependency" => Array('element' => "horizontal_filters", 'not_empty' => true),
				"description" => esc_html__("Please select the alignment you would like for your horizontal filters", "salient-portfolio")
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Filter Color Scheme", "salient-portfolio"),
				"param_name" => "filter_color",
				"value" => array(
					esc_html__("Default", "salient-portfolio") => "default",
					esc_html__("Accent-Color", "salient-portfolio") => "accent-color",
					esc_html__("Extra-Color-1", "salient-portfolio") => "extra-color-1",
					esc_html__("Extra-Color-2", "salient-portfolio") => "extra-color-2",	
					esc_html__("Extra-Color-3", "salient-portfolio") => "extra-color-3",
					esc_html__("Accent-Color Underline", "salient-portfolio") => "accent-color-underline",
					esc_html__("Extra-Color-1 Underline", "salient-portfolio") => "extra-color-1-underline",
					esc_html__("Extra-Color-2 Underline", "salient-portfolio") => "extra-color-2-underline",	
					esc_html__("Extra-Color-3 Underline", "salient-portfolio") => "extra-color-3-underline",
					esc_html__("Black", "salient-portfolio") => "black"
				),
				'save_always' => true,
				"dependency" => Array('element' => "enable_sortable", 'not_empty' => true),
				"description" => esc_html__("Please select the color scheme you would like for your filters. Only applies to full width inline filters and regular dropdown filters", "salient-portfolio")
			),
			
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Enable Pagination", "salient-portfolio"),
				"param_name" => "enable_pagination",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("Would you like to enable pagination for this portfolio?", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Pagination Type", "salient-portfolio"),
				"param_name" => "pagination_type",
				"admin_label" => true,
				"value" => array(	
					esc_html__('Default', "salient-portfolio") => 'default',
					esc_html__('Infinite Scroll', "salient-portfolio") => 'infinite_scroll',
				),
				'save_always' => true,
				"description" => esc_html__("Please select your pagination type here.", "salient-portfolio"),
				"dependency" => Array('element' => "enable_pagination", 'not_empty' => true)
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Projects Per Page", "salient-portfolio"),
				"param_name" => "projects_per_page",
				"description" => esc_html__("How many projects would you like to display per page? If pagination is not enabled, will simply show this number of projects. Enter as a number example \"20\"", "salient-portfolio")
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Project Offset", "salient-portfolio"),
				"param_name" => "project_offset",
				"description" => esc_html__("Will not be used when \"Enable Pagination\" is on - Optionally enter a number e.g. \"2\" to offset your project by.", "salient-portfolio")
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Lightbox Only", "salient-portfolio"),
				"param_name" => "lightbox_only",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("This will remove the single project page from being accessible thus rendering your portfolio into only a gallery.", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Load In Animation", "salient-portfolio"),
				"param_name" => "load_in_animation",
				'save_always' => true,
				"value" => array(
					esc_html__("None", "salient-portfolio") => "none",
					esc_html__("Fade In", "salient-portfolio") => "fade_in",
					esc_html__("Fade In From Bottom", "salient-portfolio") => "fade_in_from_bottom",
					esc_html__("Perspective Fade In", "salient-portfolio") => "perspective"
				),
				"description" => esc_html__("Please select the style you would like your projects to display in ", "salient-portfolio")
			)
		)
	);
	
	
} 

else {
	
	
	return array(
		"name" => esc_html__("Portfolio", "salient-portfolio"),
		"base" => "nectar_portfolio",
		"weight" => 8,
		"icon" => "icon-wpb-portfolio",
		"category" => esc_html__('Nectar Elements', 'salient-portfolio'),
		"description" => esc_html__('Add a portfolio element', 'salient-portfolio'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Layout", "salient-portfolio"),
				"param_name" => "layout",
				"admin_label" => true,
				"value" => array(
					esc_html__("4 Columns", 'salient-portfolio') => "4",
					esc_html__("3 Columns", 'salient-portfolio') => "3",
					esc_html__("2 Columns", 'salient-portfolio') => "2",
					esc_html__("Fullwidth", 'salient-portfolio') => "fullwidth",
					esc_html__("Constrained Fullwidth", 'salient-portfolio') => "constrained_fullwidth"
				),
				"description" => esc_html__("Please select the layout you would like for your portfolio. The Constrained Fullwidth option will allow your projects to display with the same formatting options only available to full width layout, but will limit the width to your website container area.", "salient-portfolio"),
				'save_always' => true
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Constrain Max Columns to 4?", "salient-portfolio"),
				"param_name" => "constrain_max_cols",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("This will change the max columns to 4 (default is 5 for fullwidth). Activating this will make it easier to create a grid with no empty spaces at the end of the list on all screen sizes.", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
				"dependency" => Array('element' => "layout", 'value' => 'fullwidth')
			),
			array(
				"type" => "dropdown_multi",
				"heading" => esc_html__("Portfolio Categories", "salient-portfolio"),
				"param_name" => "category",
				"admin_label" => true,
				"value" => $types_options,
				'save_always' => true,
				"description" => esc_html__("Please select the categories you would like to display for your portfolio. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-portfolio")
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Starting Category", "salient-portfolio"),
				"param_name" => "starting_category",
				"admin_label" => false,
				"value" => $types_options_2,
				'save_always' => true,
				"description" => esc_html__("Please select the category you would like you're portfolio to start filtered on.", "salient-portfolio"),
				"dependency" => Array('element' => "enable_sortable", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Project Style", "salient-portfolio"),
				"param_name" => "project_style",
				"admin_label" => true,
				'save_always' => true,
				"value" => array(
					esc_html__("Meta below thumb w/ links on hover", "salient-portfolio") => "1",
					esc_html__("Meta on hover + entire thumb link", "salient-portfolio") => "2",
					esc_html__("Meta on hover w/ zoom + entire thumb link", "salient-portfolio") => "7",
					esc_html__("Meta overlaid - bottom left aligned", "salient-portfolio") => "8",
					esc_html__("Meta overlaid w/ zoom effect on hover", "salient-portfolio") => "3",
					esc_html__("Meta overlaid w/ zoom effect on hover alt", "salient-portfolio") => "5",
					esc_html__("Meta from bottom on hover + entire thumb link", "salient-portfolio") => "4",
					esc_html__("3D Parallax on hover", "salient-portfolio") => "6",
					esc_html__("Meta below thumb w/ shadow hover", "salient-portfolio") => "9"
				),
				"description" => esc_html__("Please select the style you would like your projects to display in ", "salient-portfolio")
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Item Spacing", "salient-portfolio"),
				"param_name" => "item_spacing",
				'save_always' => true,
				"value" => array(
					esc_html__("Default", "salient-portfolio") => "default",
					"1px" => "1px",
					"2px" => "2px",
					"3px" => "3px",
					"4px" => "4px",
					"5px" => "5px",
					"6px" => "6px",
					"7px" => "7px",
					"8px" => "8px",
					"9px" => "9px",
					"10px" => "10px",
					"15px" => "15px",
					"20px" => "20px"
				),
				"description" => esc_html__("Please select the spacing you would like between your items. ", "salient-portfolio")
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Masonry Style", "salient-portfolio"),
				"param_name" => "masonry_style",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__('This will allow your portfolio items to display in a masonry layout as opposed to a fixed grid. When using a fullwidth layout, project image sizes will be determined based on the size set in each project via the "Masonry Item Sizing" field.', "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Bypass Image Cropping", "salient-portfolio"),
				"param_name" => "bypass_image_cropping",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("Enabling this will cause your portfolio to bypass the default Salient image cropping which varies based on project settings/above layout selection. The result will be a traditional masonry layout rather than a structured grid.", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Enable Sortable", "salient-portfolio"),
				"param_name" => "enable_sortable",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("Checking this box will allow your portfolio to display sortable filters", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Horizontal Filters", "salient-portfolio"),
				"param_name" => "horizontal_filters",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("This will allow your filters to display horizontally instead of in a dropdown. (Only used if you enable sortable above.)", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true'),
				"dependency" => Array('element' => "enable_sortable", 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Filter Alignment", "salient-portfolio"),
				"param_name" => "filter_alignment",
				"value" => array(
					esc_html__("Default", "salient-portfolio") => "default",
					esc_html__("Centered", "salient-portfolio") => "center",
					esc_html__("Left", "salient-portfolio") => "left"
				),
				'save_always' => true,
				"dependency" => Array('element' => "horizontal_filters", 'not_empty' => true),
				"description" => esc_html__("Please select the alignment you would like for your horizontal filters", "salient-portfolio")
			),
			array(
				"type" => 'checkbox',
				"heading" => esc_html__("Enable Pagination", "salient-portfolio"),
				"param_name" => "enable_pagination",
				'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				"description" => esc_html__("Would you like to enable pagination for this portfolio?", "salient-portfolio"),
				"value" => Array(esc_html__("Yes, please", "salient-portfolio") => 'true')
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Projects Per Page", "salient-portfolio"),
				"param_name" => "projects_per_page",
				"description" => esc_html__("How many projects would you like to display per page? If pagination is not enabled, will simply show this number of projects. Enter as a number example \"20\"", "salient-portfolio")
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Project Offset", "salient-portfolio"),
				"param_name" => "project_offset",
				"description" => esc_html__("Will not be used when \"Enable Pagination\" is on - Optioinally enter a number e.g. \"2\" to offset your project by.", "salient-portfolio")
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Load In Animation", "salient-portfolio"),
				"param_name" => "load_in_animation",
				'save_always' => true,
				"value" => array(
					esc_html__("None", "salient-portfolio") => "none",
					esc_html__("Fade In", "salient-portfolio") => "fade_in",
					esc_html__("Fade In From Bottom", "salient-portfolio") => "fade_in_from_bottom",
					esc_html__("Perspective Fade In", "salient-portfolio") => "perspective"
				),
				"description" => esc_html__("Please select the style you would like your projects to display in ", "salient-portfolio")
			)
		)
	);
	
}



?>