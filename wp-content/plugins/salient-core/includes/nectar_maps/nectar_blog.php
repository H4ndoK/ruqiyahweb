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
		if( isset($type->name) && isset($type->slug) ) {
			$blog_options[htmlspecialchars($type->slug)] = htmlspecialchars($type->slug);
		}
	}
	
} else {
	$blog_options['All'] = 'all';
}

return array(
	"name" => esc_html__("Blog", "salient-core"),
	"base" => "nectar_blog",
	"weight" => 8,
	"icon" => "icon-wpb-blog",
	"category" => esc_html__('Query', 'salient-core'),
	"description" => esc_html__('Display a Blog element', 'salient-core'),
	"params" => array(
		
		array(
		 "type" => "nectar_group_header",
		 "class" => "",
		 "heading" => esc_html__("Style", "salient-core" ),
		 "param_name" => "group_header_1",
		 "edit_field_class" => "first-field",
		 "value" => ''
	 ),
	 
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Layout", "salient-core"),
			"param_name" => "layout",
			"admin_label" => true,
			"value" => array(
				esc_html__('Standard Blog W/ Sidebar', 'salient-core') => 'std-blog-sidebar',
				esc_html__('Standard Blog No Sidebar', 'salient-core') => 'std-blog-fullwidth',
				esc_html__('Masonry Blog W/ Sidebar', 'salient-core') => 'masonry-blog-sidebar',
				esc_html__('Masonry Blog No Sidebar', 'salient-core') => 'masonry-blog-fullwidth',
				esc_html__('Masonry Blog Fullwidth', 'salient-core') => 'masonry-blog-full-screen-width'
			),
			'save_always' => true,
			"description" => esc_html__("Please select the layout you desire for your blog", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Masonry Layout Style", "salient-core"),
			"param_name" => "blog_masonry_style",
			"admin_label" => false,
			"value" => array(
				esc_html__('Inherit from Theme Options', 'salient-core') => 'inherit',
				esc_html__('Material Style', 'salient-core') => 'material',
				esc_html__('Classic Style', 'salient-core') => 'classic',
				esc_html__('Classic Enhanced Style', 'salient-core') => 'classic_enhanced',
				esc_html__('Meta Overlaid Style', 'salient-core') => 'meta_overlaid',
				esc_html__('Auto Masonry: Meta Overlaid Spaced', 'salient-core') => 'auto_meta_overlaid_spaced'
			),
			'save_always' => true,
			"dependency" => Array('element' => "layout", 'value' => array('masonry-blog-sidebar','masonry-blog-fullwidth','masonry-blog-full-screen-width')),
			"description" => esc_html__("Please select the style you would like your posts to use when the masonry layout is displayed", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Auto Masonry Spacing", "salient-core"),
			"param_name" => "auto_masonry_spacing",
			"admin_label" => false,
			"value" => array(
				esc_html__('4px', 'salient-core') => '4px',
				esc_html__('8px', 'salient-core') => '8px',
				esc_html__('12px', 'salient-core') => '12px',
				esc_html__('16px', 'salient-core') => '16px',
				esc_html__('20px', 'salient-core') => '20px',
			),
			'save_always' => true,
			"dependency" => Array('element' => "blog_masonry_style", 'value' => array('auto_meta_overlaid_spaced')),
			"description" => esc_html__("Please select the amount of spacing you would like for your auto masonry layout", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Standard Layout Style", "salient-core"),
			"param_name" => "blog_standard_style",
			"admin_label" => false,
			"value" => array(
				esc_html__('Inherit from Theme Options', 'salient-core') => 'inherit',
				esc_html__('Classic Style', 'salient-core') => 'classic',
				esc_html__('Minimal Style', 'salient-core') => 'minimal',
				esc_html__('Featured Image Left Style', 'salient-core') => 'featured_img_left',
			),
			'save_always' => true,
			"dependency" => Array('element' => "layout", 'value' => array('std-blog-sidebar','std-blog-fullwidth')),
			"description" => esc_html__("Please select the style you would like your posts to use when the standard layout is displayed", "salient-core")
		),
		
		array(
			"type" => 'checkbox',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Enable Sticky Sidebar", "salient-core"),
			"param_name" => "enable_ss",
			"description" => esc_html__("Would you like to have your sidebar follow down as your scroll in a sticky manner?", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
			"dependency" => Array('element' => "layout", 'value' => array('std-blog-sidebar','masonry-blog-sidebar')),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Load In Animation", "salient-core"),
			"param_name" => "load_in_animation",
			'save_always' => true,
			"value" => array(
				"None" => "none",
				"Fade In" => "fade_in",
				"Fade In From Bottom" => "fade_in_from_bottom",
				"Perspective Fade In" => "perspective"
			),
			"description" => esc_html__("Please select the loading animation you would like ", "salient-core")
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
		 "description" => esc_html__("Please select the categories you would like to display for your blog. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-core")
	 ),
		array(
			"type" => 'checkbox',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Enable Pagination", "salient-core"),
			"param_name" => "enable_pagination",
			"description" => esc_html__("Would you like to enable pagination?", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Pagination Type", "salient-core"),
			"param_name" => "pagination_type",
			"admin_label" => true,
			"value" => array(	
				'Default' => 'default',
				'Infinite Scroll' => 'infinite_scroll',
			),
			'save_always' => true,
			"description" => esc_html__("Please select your pagination type here.", "salient-core"),
			"dependency" => Array('element' => "enable_pagination", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Posts Per Page", "salient-core"),
			"param_name" => "posts_per_page",
			"description" => esc_html__("How many posts would you like to display per page? If pagination is not enabled, will simply show this number of posts. Enter as a number example \"10\"", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Post Offset", "salient-core"),
			"param_name" => "post_offset",
			"description" => esc_html__("Will not be used when \"Enable Pagination\" is on. Optionally enter a number e.g. \"2\" to offset your posts by - useful for when you're using multiple styles of this element on the same page and would like them to no show duplicate posts.", "salient-core")
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
		 "heading" => esc_html__("Meta", "salient-core" ),
		 "param_name" => "group_header_3",
		 "edit_field_class" => "",
		 "value" => ''
	 ),
		array(
			"type" => 'checkbox',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Remove Post Date", "salient-core"),
			"param_name" => "blog_remove_post_date",
			"description" => esc_html__("Enable this to remove the date from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		array(
			"type" => 'checkbox',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Remove Post Author", "salient-core"),
			"param_name" => "blog_remove_post_author",
			"description" => esc_html__("Enable this to remove the author name from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		array(
			"type" => 'checkbox',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Remove Comment Number", "salient-core"),
			"param_name" => "blog_remove_post_comment_number",
			"description" => esc_html__("Enable this to remove the comment count from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		array(
			"type" => 'checkbox',
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => esc_html__("Remove Nectar Love Button", "salient-core"),
			"param_name" => "blog_remove_post_nectar_love",
			"description" => esc_html__("Enable this to remove the nectar love button from displaying on your blog layout", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => 'true')
		),
		
	)
);

?>