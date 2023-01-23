<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_admin = is_admin();

$woo_args = array(
	'taxonomy' => 'product_cat',
);

$woo_types       = ($is_admin) ? get_categories($woo_args) : array('All' => 'all');
$woo_options     = array("All" => "all");
$order_by_values = array(
	'',
	esc_html__( 'Date', 'salient-core' ) => 'date',
	esc_html__( 'ID', 'salient-core' ) => 'ID',
	esc_html__( 'Author', 'salient-core' ) => 'author',
	esc_html__( 'Title', 'salient-core' ) => 'title',
	esc_html__( 'Modified', 'salient-core' ) => 'modified',
	esc_html__( 'Random', 'salient-core' ) => 'rand',
	esc_html__( 'Comment count', 'salient-core' ) => 'comment_count',
	esc_html__( 'Menu order', 'salient-core' ) => 'menu_order',
);

$order_way_values = array(
	'',
	esc_html__( 'Descending', 'salient-core' ) => 'DESC',
	esc_html__( 'Ascending', 'salient-core' ) => 'ASC',
);

if( $is_admin ) {
	foreach ($woo_types as $type) {
		$woo_options[$type->name] = $type->slug;
	}
} else {
	$woo_options['All'] = 'all';
}

////recent products
return array(
  "name" => esc_html__("WooCommerce Products", "salient-core"),
  "base" => "nectar_woo_products",
  "weight" => 8,
  "icon" => "icon-wpb-recent-products",
  "category" => esc_html__('Content', 'salient-core'),
  "description" => esc_html__('Display your products', 'salient-core'),
  "params" => array(
  	array(
	  "type" => "dropdown",
	  "heading" => esc_html__("Product Type", "salient-core"),
	  "param_name" => "product_type",
	  "value" => array(
	  	'All' => 'all',
	  	'Sale Only' => 'sale',
	  	'Featured Only' => 'featured',
	  	'Best Selling Only' => 'best_selling'
	  ),
	  'save_always' => true,
	  "description" => esc_html__("Please select the type of products you would like to display.", "salient-core")
	),
	array(
	  "type" => "dropdown_multi",
	  "heading" => esc_html__("Product Categories", "salient-core"),
	  "param_name" => "category",
	  "admin_label" => true,
	  "value" => $woo_options,
	  'save_always' => true,
	  "description" => esc_html__("Please select the categories you would like to display in your products. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-core")
	),
	array(
	  "type" => "dropdown",
	  "heading" => esc_html__("Number Of Columns", "salient-core"),
	  "param_name" => "columns",
	  "value" => array(
	  	'4' => '4',
	  	'3' => '3',
	  	'2' => '2',
	  	'1' => '1',
			'Dynamic' => 'dynamic',
	  ),
		'std' => '4',
	  'save_always' => true,
	  "description" => esc_html__("Please select the number of columns you would like to display. \"Dynamic\" will only be used on flickity full width carousels", "salient-core")
	),
	array(
		'type' => 'dropdown',
		'heading' => __( 'Mobile Column Width', 'salient-core' ),
		'param_name' => 'flickity_mobile_column_width',
		'value' => array(
			'100%' => '100%',
			'75%' => '75%',
			'66%' => '66%',
			'50%' => '50%',
		),
		'std' => '100%',
		'save_always' => true,
		"dependency" => array('element' => "script", 'value' => "flickity"),
		'description' => '',
	),
	array(
      "type" => "textfield",
      "heading" => esc_html__("Number Of Products", "salient-core"),
      "param_name" => "per_page",
       "admin_label" => true,
      "description" => esc_html__("How many posts would you like to display? Enter as a number example \"4\"", "salient-core")
    ),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'salient-core' ),
			'param_name' => 'orderby',
			'value' => $order_by_values,
			'std' => 'date',
			'save_always' => true,
			'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'salient-core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Sort order', 'salient-core' ),
			'param_name' => 'order',
			'value' => $order_way_values,
			'std' => 'DESC',
			'save_always' => true,
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'salient-core' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
		),
		array(
      "type" => 'checkbox',
      "heading" => esc_html__("Enable Pagination", "salient-core"),
      "param_name" => "pagination",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "description" => esc_html__("Would you like to enable pagination for this product display? (requires WooCommerce 3.2+)", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => true),
    ),

    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Enable Carousel Display", "salient-core"),
      "param_name" => "carousel",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "description" => esc_html__("This will override your column choice - Will not be used when Enable Pagination is on.", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => true),
    ),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Carousel Script",
			'save_always' => true,
			"param_name" => "script",
			"value" => array(
				"Flickity" => "flickity",
				"carouFredSel" => "carouFredSel",
			),
			"dependency" => array('element' => "carousel", 'value' => "1"),
			"description" => '<strong>' . esc_html__('Flickity is reccomended over carouFredSel', 'salient-core') . '</strong> ' . esc_html__('however, carouFredSel is still available for legacy users who prefer it.' , 'salient-core')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Carousel Wrap Products",
			'save_always' => true,
			"param_name" => "flickity_wrap",
			"value" => array(
				"Wrap" => "wrap",
				"No Wrap" => "no-wrap"
			),
			"dependency" => Array('element' => "script", 'value' => "flickity"),
			"description" => esc_html('At the end of the items, determine if they should wrap-around to the other end for an infinite loop.','salient-core')
		),
		array(
			  "type" => "dropdown",
			  "heading" => esc_html__("Carousel Overflow Visibility", "salient-core"),
			  "param_name" => "flickity_overflow",
			  "value" => array(
				    "Hidden" => "hidden",
				    "Visible" => "visible",
				),
			  'save_always' => true,
			  "dependency" => Array('element' => "script", 'value' => "flickity"),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Carousel Controls",
			'save_always' => true,
			"param_name" => "flickity_controls",
			"value" => array(
				esc_html__("Bottom Pagination",'salient-core') => "bottom-pagination",
				esc_html__("Next/Prev Arrows and Text",'salient-core') => "arrows-and-text",
				esc_html__("Next/Prev Arrows Overlaid",'salient-core') => "arrows-overlaid",
				esc_html__("Touch Indicator",'salient-core') => 'touch_indicator'
			),
			"dependency" => Array('element' => "script", 'value' => "flickity"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Carousel Group Items",
			'save_always' => true,
			"param_name" => "flickity_group_cells",
			"value" => array(
				esc_html__("Default",'salient-core') => "default",
				esc_html__("Display Columns With No Overflow",'salient-core') => "no-overflow",
				esc_html__("Display Columns With Overflow",'salient-core') => "overflow",
			),
			"dependency" => Array('element' => "script", 'value' => "flickity"),
			"description" => esc_html__("Control how your columns with align within the carousel.",'salient-core')
		),
		array(
				 "type" => 'checkbox',
				 "heading" => esc_html__("Carousel Subtle Item Scale When Dragging", "salient-core"),
				 "param_name" => "flickity_image_scale_on_drag",
				 "description" => esc_html__("Will cause your carousel items to shrink slightly when dragging.", "salient-core"),
				 "value" => Array(esc_html__("Yes, please", "salient-core") => 'true'),
				 'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
				 "dependency" => Array('element' => "script", 'value' => "flickity"),
		 ),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Carousel Animation', 'salient-core' ),
			'param_name' => 'flickity_item_animation',
			"dependency" => Array('element' => "script", 'value' => "flickity"),
			'value' => array(
				'None' => 'none',
				'Fade In Side' => 'fade-in-side',
				'Fade In Bottom' => 'fade-in-bottom',
			),
			'std' => 'DESC',
			'save_always' => true,
			'description' => esc_html__( 'Optionally choose to animate your products when scrolled into view.', 'salient-core' ),
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Carousel Autorotate", "salient-core"),
			"param_name" => "autorotate",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => Array(esc_html__("Yes", "salient-core") => 'true'),
			"dependency" => Array('element' => "script", 'value' => "flickity"),
			"description" => ""
		),
	array(
			"type" => "textfield",
			"heading" => esc_html__("Autorotation Speed", "salient-core"),
			"param_name" => "autorotation_speed",
			"dependency" => Array('element' => "autorotate", 'not_empty' => true),
			"description" => esc_html__("Enter in milliseconds (default is 5000)" , "salient-core")
		),
		array(
			"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Carousel Heading Text", "salient-core"),
			"param_name" => "flickity_heading_text",
			"dependency" => Array('element' => "flickity_controls", 'value' => "arrows-and-text"),
			"description" => esc_html__("Enter the heading text here.", "salient-core")
		),
		array(
		"type" => "dropdown",
		"class" => "",
		'save_always' => true,
		"heading" => "Carousel Heading Tag",
		"param_name" => "flickity_heading_tag",
		"dependency" => Array('element' => "flickity_controls", 'value' => "arrows-and-text"),
		"value" => array(
			"H2" => "h2",
			"H3" => "h3",
			"H4" => "h4",
			"H5" => "h5",
			"H6" => "h6",
		)),
		array(
			"admin_label" => false,
			"type" => "textfield",
			"heading" => esc_html__("Carousel Link Text", "salient-core"),
			"param_name" => "flickity_link_text",
			"dependency" => Array('element' => "flickity_controls", 'value' => "arrows-and-text"),
			"description" => esc_html__("If you'd like a link to be displayed under your heading text, enter the text for it here.", "salient-core")
		),
		array(
			"admin_label" => false,
			"type" => "textfield",
			"heading" => esc_html__("Carousel Link URL", "salient-core"),
			"param_name" => "flickity_link_url",
			"dependency" => Array('element' => "flickity_controls", 'value' => "arrows-and-text"),
			"description" => esc_html__("Enter the URL for your optional link.", "salient-core")
		),
		array(
      "type" => 'checkbox',
      "heading" => esc_html__("Add Item Shadow", "salient-core"),
      "param_name" => "item_shadow",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "dependency" => Array('element' => "script", 'value' => "flickity"),
      "description" => esc_html__("This will add a small shadow to each item within the carousel", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => true),
    ),
    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Enable Controls On Hover", "salient-core"),
      "param_name" => "controls_on_hover",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "dependency" => Array('element' => "script", 'value' => "carouFredSel"),
      "description" => esc_html__("This will add buttons for additional user control over your product carousel", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => true),
    )
  )
);

?>
