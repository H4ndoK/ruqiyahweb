<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-category-grid' );

extract( shortcode_atts( array(
	'post_type' => 'posts',
	'product_category' 	=> '',
  'blog_category' 	=> '',
  'text_content_alignment' => 'top_left',
  'subtext' => 'none',
  'orderby' => '',
	'order' 	=> '',
  'grid_item_spacing' => '10px',
  'columns' => '4',
  'enable_masonry' => '',
  'color_overlay' => '',
  'color_overlay_opacity' => '',
  'color_overlay_hover_opacity' => '',
  'text_color' => 'dark',
  'text_color_hover' => 'dark',
  'custom_subtext' => '',
  'subtext_visibility' => 'always',
	'image_loading' => 'normal',
  'shadow_on_hover' => '',
  'text_style' => 'default',
	'heading_tag' => 'default',
	'grid_style' => ''
), $atts ) );

if( 'mouse_follow_image' === $grid_style ) {
	$columns = '';
	$grid_item_spacing = '';
}

echo '<div class="nectar-category-grid" data-style="'.esc_attr($grid_style).'" data-columns="'. esc_attr($columns) .'" data-h-tag="'.esc_attr($heading_tag).'" data-text-style="'.esc_attr($text_style).'" data-grid-spacing="'.esc_attr($grid_item_spacing).'" data-alignment="'.esc_attr($text_content_alignment).'" data-text-color="'.esc_attr($text_color).'" data-text-hover-color="'.esc_attr($text_color_hover).'" data-shadow-hover="'.esc_attr($shadow_on_hover).'" data-masonry="'.esc_attr($enable_masonry).'">';

// Posts
if( $post_type === 'posts' ) {

    // All categories.
    if( $blog_category === 'all' ) {

      $categories = get_categories();

      foreach( $categories as $temp_cat_obj_holder ){

            echo nectar_grid_item_markup($temp_cat_obj_holder, $atts);

       } //loop

    } //end post category all conditional

    else {

      if( empty($blog_category) ) {
				return;
			}

      $category_slug_list = explode(",", $blog_category);

      foreach( $category_slug_list as $k => $slug ) {

        $temp_cat_obj_holder = get_term_by( 'slug', $slug, 'category' );
        echo nectar_grid_item_markup($temp_cat_obj_holder, $atts);

      } //loop

    }


} //end blog post type

else if( $post_type === 'products' ) {

  // All categories.
  if( $product_category == 'all' ) {

    $grid_query = array(
      'taxonomy'   =>  'product_cat'
    );

    $categories = get_categories($grid_query);

    foreach( $categories as $temp_cat_obj_holder ){

          echo nectar_grid_item_markup($temp_cat_obj_holder, $atts);

     } //loop

  } //end product category all conditional

  else {

    if( empty($product_category) ) {
			return;
		}

    $category_slug_list = explode(",", $product_category);

    foreach($category_slug_list as $k => $slug) {

      $temp_cat_obj_holder = get_term_by( 'slug', $slug, 'product_cat' );
      echo nectar_grid_item_markup($temp_cat_obj_holder, $atts);

    } //loop

  }// end selected category conditional

}// end product post type

echo '</div>';

?>
