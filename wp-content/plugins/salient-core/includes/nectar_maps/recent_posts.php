<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_admin     = is_admin();
$blog_types   = ($is_admin) ? get_categories() : array('All' => 'all');
$blog_options = array("All" => "all");

if( $is_admin ) {
	foreach ($blog_types as $type) {
		if(isset($type->name) && isset($type->slug)) {
			$blog_options[htmlspecialchars($type->slug)] = htmlspecialchars($type->slug);
		}
	}
} else {
	$blog_options['All'] = 'all';
}

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
	"name" => esc_html__("Recent Posts", "salient-core"),
	"base" => "recent_posts",
	"weight" => 8,
	"icon" => "icon-wpb-recent-posts",
	"category" => esc_html__('Query', 'salient-core'),
	"description" => esc_html__('Display your recent blog posts', 'salient-core'),
	"params" => array(
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Style & Structure", "salient-core" ),
		 "param_name" => "group_header_1",
		 "edit_field_class" => "first-field",
		 "value" => ''
	  ),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", "salient-core"),
			"param_name" => "style",
			"admin_label" => true,
			"value" => array(	
				esc_html__('Default', 'salient-core') => 'default',
				esc_html__('Minimal', 'salient-core') => 'minimal',
				esc_html__('Minimal - Title Only', 'salient-core') => 'title_only',
				esc_html__('Classic Enhanced', 'salient-core') => 'classic_enhanced',
				esc_html__('Classic Enhanced Alt', 'salient-core') => 'classic_enhanced_alt',
				esc_html__('List With Featured First Row', 'salient-core') => 'list_featured_first_row',
				esc_html__('List With Tall Featured First Row ', 'salient-core') => 'list_featured_first_row_tall',
				esc_html__('Slider', 'salient-core') => 'slider',
				esc_html__('Slider Multiple Visible', 'salient-core') => 'slider_multiple_visible',
				esc_html__('Single Large Featured', 'salient-core') => 'single_large_featured',
				esc_html__('Multiple Large Featured', 'salient-core') => 'multiple_large_featured'
			),
			'save_always' => true,
			"description" => esc_html__("Please select desired style here.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Color Scheme", "salient-core"),
			"param_name" => "color_scheme",
			"admin_label" => true,
			"value" => array(	
				'Light' => 'light',
				'Dark' => 'dark',
			),
			"dependency" => Array('element' => "style", 'value' => array('classic_enhanced')),
			'save_always' => true,
			"description" => esc_html__("Please select your desired coloring here.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Slider Height", "salient-core"),
			"param_name" => "slider_size",
			"admin_label" => false,
			"dependency" => Array('element' => "style", 'value' => 'slider'),
			"description" => esc_html__("Don't include \"px\" in your string. e.g. 650", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Number Of Columns", "salient-core"),
			"param_name" => "columns",
			"admin_label" => false,
			"value" => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1'
			),
			"dependency" => Array('element' => "style", 'value' => array('default','minimal','title_only','classic_enhanced', 'classic_enhanced_alt', 'list_featured_first_row', 'list_featured_first_row_tall', 'slider_multiple_visible')),
			'save_always' => true,
			"description" => esc_html__("Please select the number of posts you would like to display.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Top/Bottom Padding", "salient-core"),
			"param_name" => "large_featured_padding",
			"admin_label" => false,
			"value" => array(
				'20%' => '20%',
				'18%' => '18%',
				'16%' => '16%',
				'14%' => '14%',
				'12%' => '12%',
				'10%' => '10%',
				'8%' => '8%',
				'6%' => '6%',
			),
			"dependency" => Array('element' => "style", 'value' => array('single_large_featured','multiple_large_featured')),
			'save_always' => true,
			"description" => esc_html__("The % value will be applied as padding to the top and bottom of your featured post(s)", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Navigation Location", "salient-core"),
			"param_name" => "mlf_navigation_location",
			"admin_label" => false,
			"value" => array(
				'On Side' => 'side',
				'On Bottom' => 'bottom',
			),
			"dependency" => Array('element' => "style", 'value' => array('multiple_large_featured')),
			'save_always' => true,
			"description" => esc_html__("Please select where you would like the navigation to display", "salient-core")
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Enable Title Labels", "salient-core"),
			"param_name" => "title_labels",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("These labels are defined by you in the \"Blog Options\" tab of your theme options panel.", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
			"dependency" => Array('element' => "style", 'value' => 'default')
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Button Color', 'salient-core' ),
			'value' => $el_color_list,
			'save_always' => true,
			'param_name' => 'button_color',
			"dependency" => Array('element' => "style", 'value' => array('single_large_featured','multiple_large_featured', 'slider_multiple_visible')),
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . __('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Hover Shadow Type', 'salient-core' ),
			'value' => array(
				"Inherit Color From Image" => "default",
				"Regular Dark" => "dark",
			),
			'save_always' => true,
			'param_name' => 'hover_shadow_type',
			"dependency" => Array('element' => "style", 'value' => array('slider_multiple_visible') ),
			"description" => esc_html__("Please select your desired shadow color that will appear when hovering over posts.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("BG Overlay", "salient-core"),
			"param_name" => "bg_overlay",
			"admin_label" => true,
			"value" => array(	
				'Solid' => 'solid_color',
				'Diagonal Gradient' => 'diagonal_gradient',
			),
			"dependency" => Array('element' => "style", 'value' => array('single_large_featured','multiple_large_featured')),
			'save_always' => true,
			"description" => esc_html__("Please select your desired BG overlay here.", "salient-core")
		),
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Query", "salient-core" ),
		 "param_name" => "group_header_2",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
	 array(
		 "type" => "dropdown_multi",
		 "heading" => esc_html__("Blog Categories", "salient-core"),
		 "param_name" => "category",
		 "admin_label" => true,
		 "value" => $blog_options,
		 'save_always' => true,
		 "description" => esc_html__("Please select the categories you would like to display in your recent posts. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-core")
	 ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Number Of Posts", "salient-core"),
			"param_name" => "posts_per_page",
			"dependency" => Array('element' => "style", 'value' => array('default','minimal','title_only','classic_enhanced', 'classic_enhanced_alt','slider', 'slider_multiple_visible', 'list_featured_first_row',  'list_featured_first_row_tall')),
			"description" => esc_html__("How many posts would you like to display? Enter as a number example \"4\"", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Number Of Posts", "salient-core"),
			"param_name" => "multiple_large_featured_num",
			"admin_label" => false,
			"value" => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
			),
			"dependency" => Array('element' => "style", 'value' => array('multiple_large_featured')),
			'save_always' => true,
			"description" => esc_html__("Please select the number of posts you would like to display.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Post Offset", "salient-core"),
			"param_name" => "post_offset",
			"description" => esc_html__("Optionally enter a number e.g. \"2\" to offset your posts by - useful for when you're using multiple styles of this element on the same page and would like them to no show duplicate posts", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Order", "salient-core"),
			"param_name" => "order",
			"admin_label" => false,
			"value" => array(
				'Descending' => 'DESC',
				'Ascending' => 'ASC',
			),
			'save_always' => true,
			"description" => esc_html__("Designates the ascending or descending order - defaults to descending", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Orderby", "salient-core"),
			"param_name" => "orderby",
			"admin_label" => false,
			"value" => array(
				'Date' => 'date',
				'Author' => 'author',
				'Title' => 'title',
				'Last Modified' => 'modified',
				'Random' => 'rand',
				'Comment Count' => 'comment_count',
				'View Count' => 'view_count'
			),
			'save_always' => true,
			"description" => esc_html__("Sort retrieved posts by parameter - defaults to date", "salient-core")
		),
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Functionality", "salient-core" ),
		 "param_name" => "group_header_3",
		 "edit_field_class" => "",
		 "value" => ''
	  ),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Auto Rotate", "salient-core"),
			"param_name" => "auto_rotate",
			"admin_label" => true,
			"value" => array(	
				'No Auto Rotate' => 'none',
				'11 Seconds' => '11000',
				'10 Seconds' => '10000',
				'9 Seconds' => '9000',
				'8 Seconds' => '8000',
				'7 Seconds' => '7000',
				'6 Seconds' => '6000',
				'5 Seconds' => '5000',
				'4 Seconds' => '4000',
				'3 Seconds' => '3000',
			),
			"dependency" => Array('element' => "style", 'value' => array('multiple_large_featured')),
			'save_always' => true,
			"description" => esc_html__("Please select your desired auto rotation timing here", "salient-core")
		),
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Loading", "salient-core"),
      "param_name" => "image_loading",
			"dependency" => Array('element' => "style", 'value' => array('list_featured_first_row','list_featured_first_row_tall','slider','slider_multiple_visible','single_large_featured','multiple_large_featured')),
      "value" => array(
        "Default" => "default",
				"Lazy Load" => "lazy-load",
				"Skip Lazy Load" => "skip-lazy-load"
      ),
			"description" => esc_html__("Determine whether to load all images on page load or to use a lazy load method for higher performance.", "salient-core"),
      'std' => 'default',
    ),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Remove Post Date", "salient-core"),
			"param_name" => "blog_remove_post_date",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("Enable this to remove the date from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Remove Post Author", "salient-core"),
			"param_name" => "blog_remove_post_author",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("Enable this to remove the author name from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Remove Comment Number", "salient-core"),
			"param_name" => "blog_remove_post_comment_number",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("Enable this to remove the comment count from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Remove Nectar Love Button", "salient-core"),
			"param_name" => "blog_remove_post_nectar_love",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("Enable this to remove the nectar love button from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		
	)
);

?>