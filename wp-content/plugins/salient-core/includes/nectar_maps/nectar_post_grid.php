<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_types = array(
  esc_html__('Blog Posts',' salient-core') => 'post',
);

$is_admin = is_admin();


// Get Post Categories.
$blog_types = ($is_admin) ? get_categories() : array('All' => 'all');

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

// Get Project Categories.

$portfolio_options = array("All" => "all");

if( class_exists('Salient_Portfolio') ) {
  
  $post_types['Portfolio'] = 'portfolio';
    
  $portfolio_types = ($is_admin) ? get_terms('project-type') : array('All' => 'all');

  if( $is_admin ) {
    
  	foreach ($portfolio_types as $type) {
  		$portfolio_options[$type->slug] = $type->slug;
  	}

  } else {
  	$portfolio_options['All'] = 'all';
  }
  
  $portfolio_options['All'] = 'all';
  
}

$post_types['Custom'] = 'custom';


$postTypesList = array();
if($is_admin) {
	$postTypes = get_post_types( array('public' => true) );
	$excludedPostTypes = array(
		'revision',
		'nav_menu_item',
		'attachment',
		'home_slider',
		'vc_grid_item',
	);
	if ( is_array( $postTypes ) && ! empty( $postTypes ) ) {
		foreach ( $postTypes as $postType ) {
			if ( ! in_array( $postType, $excludedPostTypes, true ) ) {
				$label = ucfirst( $postType );
				$postTypesList[] = array(
					$postType,
					$label,
				);
			}
		}
	}    
}

$el_color_list = array(
  esc_html__( "Black", "salient-core") => "black",
  esc_html__( "Accent Color", "salient-core") => "accent-color",
  esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
  esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
  esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
  esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
  esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);
  
return array(
  'name' => esc_html__( 'Post Grid', 'salient-core' ),
  'base' => 'nectar_post_grid',
  'icon' => 'icon-wpb-portfolio',
  "category" => esc_html__('Query', 'salient-core'),
  'weight' => 9,
  'description' => esc_html__('Show posts/projects in a stylish grid', 'salient-core' ),
  'params' => array(
    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Post Type', 'salient-core' ),
      'param_name' => 'post_type',
      'value' => $post_types,
      'save_always' => true,
      "admin_label" => true,
      'description' => esc_html__('Select the post type you wish to display the categories from.', 'salient-core' ),
    ),
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Query", "salient-core" ),
		 "param_name" => "group_header_1",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
	 	
		// cpt
	 array(
		 "type" => "dropdown",
		 "heading" => esc_html__("Select Post Type", "salient-core"),
		 "param_name" => "cpt_name",
		 'value' => $postTypesList,
		 'save_always' => true,
		 "dependency" => array('element' => "post_type", 'value' => 'custom'),
		 "description" => esc_html__("Select a custom post type to query from.", "salient-core")
	 ),
	 array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Narrow data source', 'js_composer' ),
					'param_name' => 'custom_query_tax',
					'settings' => array(
						'multiple' => true,
						'min_length' => 1,
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Enter tags or custom taxonomies for the post type.', 'salient-core' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array(
							'portfolio',
							'post',
						),
						'callback' => 'nectarPostGridCustomQueryTaxCallBack',
					),
				),
	 // cpt end
	 
    array(
      "type" => "dropdown_multi",
      "heading" => esc_html__("Project Categories", "salient-core"),
      "param_name" => "portfolio_category",
      "value" => $portfolio_options,
      'save_always' => true,
      "dependency" => array('element' => "post_type", 'value' => 'portfolio'),
      "description" => esc_html__("Please select the categories you would like to display in the grid. You can also select multiple categories if needed (ctrl + click on PC and command + click on Mac).", "salient-core")
    ),
    array(
      "type" => "dropdown_multi",
      "heading" => esc_html__("Blog Categories", "salient-core"),
      "param_name" => "blog_category",
      "value" => $blog_options,
      'save_always' => true,
      "dependency" => array('element' => "post_type", 'value' => 'post'),
      "description" => esc_html__("Please select the categories you would like to display for your blog. You can also select multiple categories if needed (ctrl + click on PC and command + click on Mac).", "salient-core")
    ),
    
		
    array(
			"type" => "textfield",
			"heading" => esc_html__("Posts Per Page", "salient-core"),
			"param_name" => "posts_per_page",
			"admin_label" => true,
			"description" => esc_html__("How many posts would you like to display per page?  Enter as a number example \"10\"", "salient-core")
		),
    
		array(
			"type" => "textfield",
			"heading" => esc_html__("Post Offset", "salient-core"),
			"param_name" => "post_offset",
			"description" => esc_html__("Optionally enter a number e.g. \"2\" to offset your posts by.", "salient-core")
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
				'Comment Count' => 'comment_count'
			),
			'save_always' => true,
			"description" => esc_html__("Sort retrieved posts by parameter - defaults to date", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Pagination", "salient-core"),
			"param_name" => "pagination",
			"admin_label" => false,
			"value" => array(
				'None' => 'none',
				'Load More' => 'load-more',
				//'Page Number Links' => 'page-numbers',
			),
			'save_always' => true
		),
		
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Load More Color', 'salient-core' ),
			'value' => $el_color_list,
			'save_always' => true,
			'dependency' => array(
				'element' => 'pagination',
				'value' => array('load-more'),
			),
			'param_name' => 'button_color',
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		
    array(
			"type" => 'checkbox',
			"heading" => esc_html__("Ignore Sticky Posts", "salient-core"),
			"param_name" => "ignore_sticky_posts",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
		),

		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Gallery Lightbox", "salient-core"),
			"param_name" => "enable_gallery_lightbox",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("This will turn your post grid into a gallery where each item links to the featured image in a lightbox rather than the single post URL.", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
		),
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Structure", "salient-core" ),
		 "param_name" => "group_header_2",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Columns', 'salient-core' ),
      'param_name' => 'columns',
      "dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image','mouse_follow_image')),
      'value' => array(
        '4' => '4',
        '3' => '3',
        '2' => '2',
        '1' => '1'
      ),
      'std' => '4',
      'save_always' => true
    ),
    
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Grid Item Spacing", "salient-core"),
      "param_name" => "grid_item_spacing",
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image','vertical_list')),
      "value" => array(
        esc_html__("None", "salient-core") => "none",
        "5px" => "5px",
        "10px" => "10px",
        "15px" => "15px",
        "25px" => "25px",
        "35px" => "35px",
        "40px" => "40px",
        "45px" => "45px",
        "2%" => "1vw",
        "4%" => "2vw",
        "6%" => "3vw",
        "8%" => "4vw",
      ),
      "description" => esc_html__("Please select the spacing you would like between your items. ", "salient-core")
    ),
    
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Grid Item Height", "salient-core"),
      "param_name" => "grid_item_height",
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image')),
      'save_always' => true,
      "value" => array(
        "Default (30%)" => "30vh",
        "40%" => "40vh",
        "50%" => "50vh",
        "60%" => "60vh",
        "75%" => "75vh"
      ),
      "description" => esc_html__("Please select the height you would like for your items to display in. The percentage is based on the viewport height that the grid is viewed on. ", "salient-core")
    ),
		
		
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Enable Sortable", "salient-core"),
			"param_name" => "enable_sortable",
			"admin_label" => true,
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes", "salient-core") => 'yes')
		),
		// cpt specific
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Add \"All\" Filter", "salient-core"),
			"param_name" => "cpt_all_filter",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "post_type", 'value' => 'custom'),
			"description" => esc_html__("By default custom queries will not include an \"All\" filter, but enabling this will add one. The \"All\" filter will show items which exist in any of your selected taxonomies, chosen in the \"Narrow data source\"
 field above.", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
		),

		
		array(
      "type" => "dropdown",
      "heading" => esc_html__("Sortable Filters Alignment", "salient-core"),
      "param_name" => "sortable_alignment",
			"dependency" => array('element' => "enable_sortable", 'value' => array('yes')),
      'save_always' => true,
      "value" => array(
        esc_html__( "Default (Top Center)", "salient-core") => "default",
				esc_html__( "Top Left", "salient-core") => "left",
        esc_html__( "Top Right", "salient-core") => "right",
        esc_html__( "Sidebar Left", "salient-core") => "sidebar_left",
        esc_html__( "Sidebar Right", "salient-core") => "sidebar_right"
      ),
    ),
		
		array(
      "type" => "dropdown",
      "heading" => esc_html__("Sortable Filters Active Color", "salient-core"),
      "param_name" => "sortable_color",
			"dependency" => array('element' => "enable_sortable", 'value' => array('yes')),
      'save_always' => true,
      "value" => array(
        esc_html__( "Default", "salient-core") => "default",
				esc_html__( "Accent Color", "salient-core") => "accent-color",
				esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
				esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
				esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
				esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
				esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
      ),
    ),
		
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Masonry Layout", "salient-core"),
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image')),
      "param_name" => "enable_masonry",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "description" => esc_html__("This will allow your items to display in a masonry layout as opposed to a fixed grid.", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Featured First Item", "salient-core"),
			"dependency" => array('callback' => 'nectarPostGridFeaturedFirstItemCallback'),
      "param_name" => "featured_top_item",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "description" => esc_html__("Enabling this will make the first item in your grid display full width on its own row.", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Grid Images", "salient-core" ),
		 "param_name" => "group_header_3",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Size", "salient-core"),
      "param_name" => "image_size",
      "value" => array(
        "Default (Large)" => "large",
				"Small" => "thumbnail",
				"Small Landscape" => "portfolio-thumb",
				"Medium" => "medium",
				"Landscape" => "portfolio-thumb_large",
        "Large Featured" => "large_featured",
				"Full" => 'full'
      ),
			"description" => esc_html__("This option allows to you control what size image will load for each item in the grid. Useful to fine tune quality based on your specific use case.", "salient-core"),
      'std' => 'large',
    ),
		
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Lock Aspect Ratio to Image Size", "salient-core"),
			"dependency" => array('element' => "grid_style", 'value' => array('content_under_image')),
      "param_name" => "aspect_ratio_image_size",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__('Note: This will disable the "Masonry Layout" option.', "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
    array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Aspect Ratio", "salient-core"),
      "param_name" => "custom_image_aspect_ratio",
      "dependency" => array('element' => "aspect_ratio_image_size", 'not_empty' => true),
      "value" => array(
        "Default (Inherit from Image Size Field)" => "default",
        "1:1" => "1-1",
				"16:9" => "16-9",
				"3:2" =>  "3-2",
				"4:3" => "4-3",
        "4:5" => "4-5",
      ),
			"description" => esc_html__("Optionally define a custom aspect ratio to display your images in.", "salient-core"),
      'std' => 'default',
    ),
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Loading", "salient-core"),
      "param_name" => "image_loading",
      "value" => array(
        "Default" => "default",
        'Skip Lazy Load' => 'skip-lazy-load',
				"Lazy Load" => "lazy-load",
      ),
			"description" => esc_html__("Determine whether to load all images on page load or to use a lazy load method for higher performance.", "salient-core"),
      'std' => 'default',
    ),
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Post animation", "salient-core"),
      "param_name" => "animation",
      "value" => array(
        "None" => "none",
				"Fade in from bottom" => "fade-in-from-bottom",
      ),
      'std' => 'none',
    ),
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Grid Content", "salient-core" ),
		 "param_name" => "group_header_4",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
	 
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Post Title Heading Tag", "salient-core"),
      "param_name" => "heading_tag",
      "value" => array(
        "Default" => "default",
				"Heading 2" => "h2",
				"Heading 3" => "h3",
				"Heading 4" => "h4",
      ),
      'std' => 'default',
    ),
		
		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Post Title Font Size", "salient-core"),
			"param_name" => "custom_font_size"
		),
		
		array(
      "type" => 'checkbox',
      "heading" => esc_html__("Add Link Mouse Indicator", "salient-core"),
      "param_name" => "enable_indicator",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "description" => esc_html__("This will add an indicator when hovering over each item ", "salient-core"),
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image')),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
		
		
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Mouse Indicator Style", "salient-core"),
      "param_name" => "mouse_indicator_style",
			"dependency" => array('element' => "enable_indicator", 'not_empty' => true),
      "value" => array(
        "Default" => "default",
        "See Through" => "see-through",
      ),
      'std' => 'default',
    ),

		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Mouse Indicator Text", "salient-core"),
      "param_name" => "mouse_indicator_text",
			"dependency" => array('element' => "enable_indicator", 'not_empty' => true),
      "value" => array(
        "View" => "view",
        "Read" => "read",
      ),
      'std' => 'view',
    ),
    
		array(
      "type" => "colorpicker",
      "class" => "",
      "heading" => "Mouse Indicator Color",
      "param_name" => "mouse_indicator_color",
      "value" => "",
			"dependency" => array('element' => "mouse_indicator_style", 'value' => 'default'),
    ),

    array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Mouse Indicator Text Color",
			"param_name" => "mouse_indicator_text_color",
			"value" => "",
      "dependency" => array('element' => "mouse_indicator_style", 'value' => 'default'),
			"description" => ''	
		),

    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Mouse Indicator Blurred BG", "salient-core"),
      "param_name" => "mouse_indicator_blurred_bg",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "description" => esc_html__("This will blur the background behind your indicator. This effect will only be visible when using semi-transparent coloring.", "salient-core"),
			"dependency" => array('element' => "mouse_indicator_style", 'value' => 'default'),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Advanced", "salient-core" ),
		 "param_name" => "group_header_5",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
	 
		array(
			"type" => "textfield",
			"heading" => esc_html__("CSS Class Name", "salient-core"),
			"param_name" => "css_class_name",
			"description" => esc_html__("Add in any extra CSS Classes that you wish to be applied to the Post Grid element.", "salient-core"),
		),
	
    
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Display Categories", "salient-core"),
      "param_name" => "display_categories",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image')),
      "group" => esc_html__("Meta Data", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
		
		array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Category Functionality', 'salient-core' ),
      'param_name' => 'category_functionality',
      'value' => array(
        esc_html__('Clickable Links', 'salient-core') => 'default',
        esc_html__('Static Text', 'salient-core') => 'static'
      ),
			"dependency" => array('element' => "display_categories", 'value' => 'yes'),
      'save_always' => true,
			"group" => esc_html__("Meta Data", "salient-core"),
    ),

    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Category Position', 'salient-core' ),
      'param_name' => 'category_position',
      'value' => array(
        esc_html__('Above Content', 'salient-core') => 'default',
        esc_html__('Below Content', 'salient-core') => 'below_title'
      ),
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image')),
      'save_always' => true,
			"group" => esc_html__("Meta Data", "salient-core"),
    ),
    
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Display Date", "salient-core"),
      "param_name" => "display_date",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "group" => esc_html__("Meta Data", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
    
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Display Excerpt", "salient-core"),
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image','vertical_list')),
      "param_name" => "display_excerpt",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "group" => esc_html__("Meta Data", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
		
  
		array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Grid Style', 'salient-core' ),
      'param_name' => 'grid_style',
      'value' => array(
        esc_html__('Content Overlaid on Featured Image', 'salient-core') => 'content_overlaid',
        esc_html__('Content Under Featured Image', 'salient-core') => 'content_under_image',
        esc_html__('Featured Image Mouse Follow on Hover', 'salient-core') => 'mouse_follow_image',
        esc_html__('Vertical List', 'salient-core') => 'vertical_list',
      ),
      'save_always' => true,
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
    ),
		
    array(
      "type" => 'dropdown',
      "heading" => esc_html__("Hover Effect", "salient-core"),
      "param_name" => "vertical_list_hover_effect",
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => array('vertical_list')),
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "value" => array(
        esc_html__("None", "salient-core") => "none",
        esc_html__("Featured Image Reveal", "salient-core") => "featured_image",
        esc_html__("Color Change", "salient-core") => "bg_color_change",
        esc_html__("Slight Move", "salient-core") => "slight_move",
      )
    ),

    array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "heading" => "Background Color on Hover",
      "param_name" => "vertical_list_bg_color_hover",
      "value" => "",
			"dependency" => array('element' => "vertical_list_hover_effect", 'value' => array('bg_color_change','featured_image'))
    ),

    array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "heading" => "Text Color on Hover",
      "param_name" => "vertical_list_text_color_hover",
      "value" => "",
			"dependency" => array('element' => "vertical_list_hover_effect", 'value' => array('bg_color_change','featured_image'))
    ),

    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Color Overlay Opacity", "salient-core"),
      "param_name" => "vertical_list_color_overlay_opacity",
			"dependency" => array('element' => "vertical_list_hover_effect", 'value' => array('featured_image')),
      "value" => array(
        "0" => "0",
        "0.1" => "0.1",
        "0.2" => "0.2",
        "0.3" => "0.3",
        "0.4" => "0.4",
        "0.5" => "0.5",
        "0.6" => "0.6",
        "0.7" => "0.7",
        "0.8" => "0.8",
        "0.9" => "0.9",
        "1" => "1"
      ),
      'std' => '0.5',
    ),

    array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "heading" => "Divider Border Color",
      "param_name" => "vertical_list_border_color",
      "value" => "",
			"dependency" => array('element' => "grid_style", 'value' => array('vertical_list')),
    ),
    
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Display Read More Button", "salient-core"),
      "param_name" => "vertical_list_read_more",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
      "dependency" => array('element' => "grid_style", 'value' => array('vertical_list'))
    ),
		array(
      "type" => 'checkbox',
      "heading" => esc_html__("Display List Numerical Counter", "salient-core"),
      "param_name" => "vertical_list_counter",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
      "dependency" => array('element' => "grid_style", 'value' => array('vertical_list'))
    ),

		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Card Design", "salient-core"),
			"param_name" => "card_design",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "grid_style", 'value' => array('content_under_image')),
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
			'description' => esc_html__( 'Change the overall look of your grid items into cards.', 'salient-core'),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
		),

		array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "heading" => "Card Item BG Color",
      "param_name" => "card_bg_color",
      "value" => "",
			"dependency" => array('element' => "card_design", 'value' => 'yes')
    ),
		
		array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "heading" => "Card Item BG Color Hover",
      "param_name" => "card_bg_color_hover",
      "value" => "",
			"dependency" => array('element' => "card_design", 'value' => 'yes')
    ),
		
    array(
			"type" => 'checkbox',
			"heading" => esc_html__("Overlay Secondary Project Image", "salient-core"),
			"param_name" => "overlay_secondary_project_image",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox custom-portfolio-dep',
			"dependency" => array('callback' => 'nectarSecondaryProjectImgCallback'),
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
			'description' => esc_html__( 'Change the overall look of your grid items into cards.', 'salient-core'),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
		),

    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Secondary Project Image Alignment', 'salient-core' ),
      'param_name' => 'overlay_secondary_project_image_align',
      "dependency" => array('element' => "overlay_secondary_project_image", 'not_empty' => true),
      'edit_field_class' => 'vc_col-xs-12 custom-portfolio-dep',
      'value' => array(
        esc_html__('Overflowing Left', 'salient-core') => 'left',
        esc_html__('Overflowing Right', 'salient-core') => 'right'
      ),
      'save_always' => true,
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core")
    ),
		
		array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Text Content Layout', 'salient-core' ),
      'param_name' => 'text_content_layout',
      'value' => array(
        esc_html__('All Top Left', 'salient-core') => 'all_top_left',
        esc_html__('All Middle', 'salient-core') => 'all_middle',
        esc_html__('All Bottom Left', 'salient-core') => 'all_bottom_left',
				esc_html__('All Bottom Left With Shadow', 'salient-core') => 'all_bottom_left_shadow'
      ),
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'description' => esc_html__( 'Select the layout for your text content.', 'salient-core')
    ),
		  
    array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "heading" => "Color Overlay",
      "param_name" => "color_overlay",
      "value" => "",
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "description" => esc_html__("Use this to set a BG color that will be overlaid on your grid items", "salient-core"),
    ),
    
    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Color Overlay Opacity", "salient-core"),
      "param_name" => "color_overlay_opacity",
			"edit_field_class" => "nectar-one-half",
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "value" => array(
        "0" => "0",
        "0.1" => "0.1",
        "0.2" => "0.2",
        "0.3" => "0.3",
        "0.4" => "0.4",
        "0.5" => "0.5",
        "0.6" => "0.6",
        "0.7" => "0.7",
        "0.8" => "0.8",
        "0.9" => "0.9",
        "1" => "1"
      ),
      'std' => '0.3',
    ),
    
    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
			"edit_field_class" => "nectar-one-half nectar-one-half-last",
      "heading" => esc_html__("Color Overlay Hover Opacity", "salient-core"),
      "param_name" => "color_overlay_hover_opacity",
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "value" => array(
        "0" => "0",
        "0.1" => "0.1",
        "0.2" => "0.2",
        "0.3" => "0.3",
        "0.4" => "0.4",
        "0.5" => "0.5",
        "0.6" => "0.6",
        "0.7" => "0.7",
        "0.8" => "0.8",
        "0.9" => "0.9",
        "1" => "1"
      ),
      'std' => '0.4',
    ),
    
    
		array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Text Align', 'salient-core' ),
      'param_name' => 'content_under_image_text_align',
      'value' => array(
        esc_html__('Left', 'salient-core') => 'left',
        esc_html__('Center', 'salient-core') => 'center',
        esc_html__('Right', 'salient-core') => 'right'
      ),
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => 'content_under_image'),
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core")
    ),
		
    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Text Color", "salient-core"),
      "param_name" => "text_color",
      "value" => array(
        esc_html__("Dark", "salient-core") => "dark",
        esc_html__("Light", "salient-core") => "light",
      ),
      'std' => 'light',
    ),
    
    array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "heading" => "Custom Text Color",
      "param_name" => "vertical_list_custom_text_color",
      "value" => "",
			"dependency" => array('element' => "grid_style", 'value' => array('vertical_list')),
      "description" => '',
    ),
    
		
		array(
			"type" => 'checkbox',
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
			"heading" => esc_html__("Post Title Contrast Over Image", "salient-core"),
			"param_name" => "post_title_overlay",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "grid_style", 'value' => 'mouse_follow_image'),
			'description' => esc_html__( 'Will cause the post title to overlay on top of the featured image when hovered.', 'salient-core'),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
		),
		
    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "heading" => "Text Color Hover",
      "param_name" => "text_color_hover",
      "value" => array(
        esc_html__("Dark", "salient-core") => "dark",
        esc_html__("Light", "salient-core") => "light",
      ),
      'std' => 'light',
    ),

		array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Text Opacity", "salient-core"),
      "param_name" => "text_opacity",
			"edit_field_class" => "nectar-one-half",
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "value" => array(
				"0.0" => "0.0",
        "0.1" => "0.1",
        "0.2" => "0.2",
        "0.3" => "0.3",
        "0.4" => "0.4",
        "0.5" => "0.5",
        "0.6" => "0.6",
        "0.7" => "0.7",
        "0.8" => "0.8",
        "0.9" => "0.9",
        "1" => "1"
      ),
      'std' => '1',
    ),
    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
			"edit_field_class" => "nectar-one-half nectar-one-half-last",
      "heading" => esc_html__("Text Hover Opacity", "salient-core"),
      "param_name" => "text_hover_opacity",
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "value" => array(
				"0.0" => "0.0",
        "0.1" => "0.1",
        "0.2" => "0.2",
        "0.3" => "0.3",
        "0.4" => "0.4",
        "0.5" => "0.5",
        "0.6" => "0.6",
        "0.7" => "0.7",
        "0.8" => "0.8",
        "0.9" => "0.9",
        "1" => "1"
      ),
      'std' => '1',
    ),
		
		
		array(
			"type" => 'checkbox',
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
			"heading" => esc_html__("Opacity Hover Animation", "salient-core"),
			"param_name" => "opacity_hover_animation",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "grid_style", 'value' => 'mouse_follow_image'),
			'description' => esc_html__( 'Will cause the post grid to dim and the hovered grid item to remain bright.', 'salient-core'),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
		),
    
    
    array(
      "type" => 'dropdown',
      "heading" => esc_html__("Hover Effect", "salient-core"),
      "param_name" => "hover_effect",
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image')),
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "value" => array(
        esc_html__("BG Zoom", "salient-core") => "zoom",
        esc_html__("Slow BG Zoom", "salient-core") => "slow_zoom",
        esc_html__("Animated Underline", "salient-core") => "animated_underline",
        esc_html__("Animated Underline Zoom", "salient-core") => "animated_underline_zoom",
				esc_html__("None", "salient-core") => "none",
      )
    ),
    
		array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => 'mouse_follow_image'),
      "heading" => esc_html__("Image Alignment", "salient-core"),
      "param_name" => "mouse_follow_image_alignment",
      "value" => array(
        "Middle on Cursor" => "middle",
        "Top Left on Cursor" => "top_left",
      ),
      'std' => 'middle',
    ),
		
		array(
      "type" => "dropdown",
      "heading" => esc_html__("Post Spacing", "salient-core"),
      "param_name" => "mouse_follow_post_spacing",
      'save_always' => true,
			"group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
			"dependency" => array('element' => "grid_style", 'value' => 'mouse_follow_image'),
      "value" => array(
        "5px" => "5px",
        "10px" => "10px",
        "15px" => "15px",
        "25px" => "25px",
				"35px" => "35px",
				"45px" => "45px",
      ),
			'std' => '25px',
    ),
		
    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Border Radius", "salient-core"),
      "dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','mouse_follow_image','content_under_image')),
      "param_name" => "border_radius",
      "value" => array(
        "None" => "none",
        "3px" => "3px",
        "5px" => "5px",
        "10px" => "10px",
        "15px" => "15px",
      ),
      'std' => 'none',
    ),
    
    
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Shadow on Hover", "salient-core"),
      "param_name" => "shadow_on_hover",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image')),
      "group" => esc_html__("Grid Item Coloring/Style", "salient-core"),
      "description" => esc_html__("This will add a shadow effect on hover to your grid items", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),
    

  ),
);
