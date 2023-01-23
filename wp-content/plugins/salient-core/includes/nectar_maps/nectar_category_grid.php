<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$order_by_values = array(
  '',
  esc_html__('Date', 'salient-core' ) => 'date',
  esc_html__('ID', 'salient-core' ) => 'ID',
  esc_html__('Author', 'salient-core' ) => 'author',
  esc_html__('Title', 'salient-core' ) => 'title',
  esc_html__('Modified', 'salient-core' ) => 'modified',
  esc_html__('Random', 'salient-core' ) => 'rand',
  esc_html__('Menu order', 'salient-core' ) => 'menu_order',
);

$order_way_values = array(
  '',
  esc_html__('Descending', 'salient-core' ) => 'DESC',
  esc_html__('Ascending', 'salient-core' ) => 'ASC',
);

$is_admin = is_admin();


$post_types = array('Posts' => 'posts');


$blog_types = ($is_admin) ? get_categories() : array('All' => 'all');

$blog_options = array("All" => "all");

if($is_admin) {
	foreach ($blog_types as $type) {
		if(isset($type->name) && isset($type->slug)) {
			$blog_options[htmlspecialchars($type->slug)] = htmlspecialchars($type->slug);
    }
	}
} else {
	$blog_options['All'] = 'all';
}



$woo_args = array(
	'taxonomy' => 'product_cat',
);

global $woocommerce;

if($woocommerce) {

  $post_types["Products"] = 'products';

  $woo_types   = ($is_admin) ? get_categories($woo_args) : array('All' => 'all');
  $woo_options = array("All" => "all");

  if( $is_admin ) {
  	foreach ($woo_types as $type) {
  		$woo_options[$type->slug] = $type->slug;
  	}
  } else {
  	$woo_options['All'] = 'all';
  }

} else {
  $woo_options['All'] = 'all';
}


return array(
  'name' => __( 'Category Grid', 'salient-core' ),
  'base' => 'nectar_category_grid',
  'icon' => 'icon-wpb-portfolio',
  "category" => esc_html__('Query', 'salient-core'),
  'description' => esc_html__('Show categories in a stylish grid', 'salient-core' ),
  'params' => array(
    array(
      'type' => 'dropdown',
      'heading' => __( 'Post Type', 'salient-core' ),
      'param_name' => 'post_type',
      'value' => $post_types,
      'save_always' => true,
      "admin_label" => true,
      'description' => esc_html__('Select the post type you wish to display the categories from.', 'salient-core' ),
    ),
    array(
      "type" => "dropdown_multi",
      "heading" => esc_html__("Product Categories", "salient-core"),
      "param_name" => "product_category",
      "admin_label" => true,
      "value" => $woo_options,
      'save_always' => true,
      "dependency" => array('element' => "post_type", 'value' => 'products'),
      "description" => esc_html__("Please select the categories you would like to display in the grid. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-core")
    ),
    array(
      "type" => "dropdown_multi",
      "heading" => esc_html__("Blog Categories", "salient-core"),
      "param_name" => "blog_category",
      "admin_label" => true,
      "value" => $blog_options,
      'save_always' => true,
      "dependency" => array('element' => "post_type", 'value' => 'posts'),
      "description" => esc_html__("Please select the categories you would like to display for your blog. You can select multiple categories too (ctrl + click on PC and command + click on Mac).", "salient-core")
    ),

    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Text Content Alignment', 'salient-core' ),
      'param_name' => 'text_content_alignment',
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      'value' => array(
        esc_html__('Top Left', 'salient-core') => 'top_left',
        esc_html__('Top Middle', 'salient-core') => 'top_middle',
        esc_html__('Top Right', 'salient-core') => 'top_right',
        esc_html__('Middle', 'salient-core') => 'middle',
        esc_html__('Bottom Left', 'salient-core') => 'bottom_left',
        esc_html__('Bottom Middle', 'salient-core') => 'bottom_middle',
        esc_html__('Bottom Right', 'salient-core') => 'bottom_right',
      ),
      'save_always' => true,
      'description' => esc_html__( 'Select the alignment of your text content.', 'salient-core')
    ),

		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Category Title Heading Tag", "salient-core"),
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
      'type' => 'dropdown',
      'heading' => esc_html__( 'Subtext', 'salient-core' ),
      'param_name' => 'subtext',
      'value' => array(
        esc_html__('None', 'salient-core') => 'none',
        esc_html__('Category Item Count', 'salient-core') => 'cat_item_count',
        esc_html__('Custom', 'salient-core') => 'custom',
      ),
      'save_always' => true,
      'description' => esc_html__( 'Select what will display under the category names.', 'salient-core')
    ),
    array(
      "type" => "textfield",
      "heading" => esc_html__("Text Content", "salient-core"),
      "param_name" => "custom_subtext",
      "admin_label" => true,
      "dependency" => array('element' => "subtext", 'value' => 'custom'),
      "description" => esc_html__("Enter custom text that will be shown below each category title", "salient-core")
    ),


    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Columns', 'salient-core' ),
      'param_name' => 'columns',
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
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
      "heading" => esc_html__("Item Spacing", "salient-core"),
      "param_name" => "grid_item_spacing",
      'save_always' => true,
      "value" => array(
        "None" => "none",
        "5px" => "5px",
        "10px" => "10px",
        "15px" => "15px",
        "25px" => "25px"
      ),
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "description" => esc_html__("Please select the spacing you would like between your items. ", "salient-core")
    ),


    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Masonry Layout", "salient-core"),
      "param_name" => "enable_masonry",
      'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "description" => esc_html__("This will allow your category items to display in a masonry layout as opposed to a fixed grid", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes'),
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
    ),

    array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Loading", "salient-core"),
      "param_name" => "image_loading",
      "value" => array(
        "Default" => "default",
				"Lazy Load" => "lazy-load",
      ),
			"description" => esc_html__("Determine whether to load all images on page load or to use a lazy load method for higher performance.", "salient-core"),
      'std' => 'default',
    ),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Grid Style', 'salient-core' ),
			'param_name' => 'grid_style',
			'value' => array(
				esc_html__('Content Overlaid on Featured Image', 'salient-core') => 'content_overlaid',
				esc_html__('Featured Image Mouse Follow on Hover', 'salient-core') => 'mouse_follow_image',
			),
			'save_always' => true,
			"group" => esc_html__("Item Coloring/Style", "salient-core"),
		),

    array(
      "type" => "colorpicker",
      "class" => "",
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      "heading" => "Color Overlay",
      "param_name" => "color_overlay",
      "value" => "",
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      "description" => esc_html__("Use this to set a BG color that will be overlaid on your grid items", "salient-core"),
    ),

    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Color Overlay Opacity", "salient-core"),
      "param_name" => "color_overlay_opacity",
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
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      'std' => '0.3',
    ),

    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Color Overlay Hover Opacity", "salient-core"),
      "param_name" => "color_overlay_hover_opacity",
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
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      'std' => '0.4',
    ),

		array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Image Aspect Ratio", "salient-core"),
			"dependency" => array('element' => "grid_style", 'value' => 'mouse_follow_image'),
      "param_name" => "image_aspect_ratio",
      "value" => array(
        "1:1" => "1-1",
				"16:9" => "16-9",
				"4:3" => "4-3",
        "4:5" => "4-5",
      ),
      'std' => '1-1',
    ),

    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => esc_html__("Text Color", "salient-core"),
      "param_name" => "text_color",
      "value" => array(
        "Dark" => "dark",
        "Light" => "light",
      ),
      'std' => 'light',
    ),

    array(
      "type" => "dropdown",
      "class" => "",
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      'save_always' => true,
      "heading" => "Text Color Hover",
      "param_name" => "text_color_hover",
      "value" => array(
        "Dark" => "dark",
        "Light" => "light",
      ),
      'std' => 'light',
    ),

    array(
      "type" => 'checkbox',
      "heading" => esc_html__("Shadow on Hover", "salient-core"),
      "param_name" => "shadow_on_hover",
			"dependency" => array('element' => "grid_style", 'value' => 'content_overlaid'),
      'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      "description" => esc_html__("This will add a shadow effect on hover to your grid items", "salient-core"),
      "value" => Array(esc_html__("Yes, please", "salient-core") => 'yes')
    ),

    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Subtext Visibility', 'salient-core' ),
      'param_name' => 'subtext_visibility',
      "group" => esc_html__("Item Coloring/Style", "salient-core"),
      'value' => array(
        'Always Shown' => 'always',
        'Shown on Hover' => 'on_hover',
      ),
      'save_always' => true
    ),


  ),
);

  ?>
