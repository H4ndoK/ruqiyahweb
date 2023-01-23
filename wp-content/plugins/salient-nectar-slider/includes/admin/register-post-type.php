<?php 

/**
 * Nectar Slider register post type
 *
 * @package Salient WordPress Theme
 * @subpackage admin
 * @version 10.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Nectar Slider register post type.
 *
 * @since 1.0
 */
if( !function_exists('nectar_slider_register') ) {
	
	function nectar_slider_register() {

		$labels = array(
			'name'          => esc_html__( 'Slides', 'salient-nectar-slider' ),
			'singular_name' => esc_html__( 'Slide', 'salient-nectar-slider' ),
			'search_items'  => esc_html__( 'Search Slides', 'salient-nectar-slider' ),
			'all_items'     => esc_html__( 'All Slides', 'salient-nectar-slider' ),
			'parent_item'   => esc_html__( 'Parent Slide', 'salient-nectar-slider' ),
			'edit_item'     => esc_html__( 'Edit Slide', 'salient-nectar-slider' ),
			'update_item'   => esc_html__( 'Update Slide', 'salient-nectar-slider' ),
			'add_new_item'  => esc_html__( 'Add New Slide', 'salient-nectar-slider' ),
			'menu_name'     => esc_html__( 'Nectar Slider', 'salient-nectar-slider' ),
		);

		 $nectarslider_menu_icon = 'dashicons-star-empty';

		 $args = array(
			 'labels'              => $labels,
			 'singular_label'      => esc_html__( 'Nectar Slider', 'salient-nectar-slider' ),
			 'public'              => false,
			 'show_ui'             => true,
			 'hierarchical'        => false,
			 'menu_position'       => 10,
			 'menu_icon'           => $nectarslider_menu_icon,
			 'exclude_from_search' => true,
			 'supports'            => false,
		 );

		register_post_type( 'nectar_slider', $args );
	}

}

add_action( 'init', 'nectar_slider_register', 0 );

/**
 * Add taxonomies to Nectar Slider.
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_add_nectar_slider_taxonomies' ) ) {

	function nectar_add_nectar_slider_taxonomies() {
		
		$slider_locations_labels = array(
			'name'          => esc_html__( 'Slider Locations', 'salient-nectar-slider' ),
			'singular_name' => esc_html__( 'Slider Location', 'salient-nectar-slider' ),
			'search_items'  => esc_html__( 'Search Slider Locations', 'salient-nectar-slider' ),
			'all_items'     => esc_html__( 'All Slider Locations', 'salient-nectar-slider' ),
			'edit_item'     => esc_html__( 'Edit Slider Location', 'salient-nectar-slider' ),
			'update_item'   => esc_html__( 'Update Slider Location', 'salient-nectar-slider' ),
			'add_new_item'  => esc_html__( 'Add New Slider Location', 'salient-nectar-slider' ),
			'new_item_name' => esc_html__( 'New Slider Location', 'salient-nectar-slider' ),
			'menu_name'     => esc_html__( 'Slider Locations', 'salient-nectar-slider' ),
		);

		register_taxonomy(
			'slider-locations',
			array( 'nectar_slider' ),
			array(
				'hierarchical' => true,
				'labels'       => $slider_locations_labels,
				'show_ui'      => true,
				'public'       => false,
				'query_var'    => true,
				'rewrite'      => array( 'slug' => 'slider-locations' ),
			)
		);
		
		if( !get_option('salient_nectar_slider_permalinks_flushed') ) {
			flush_rewrite_rules();
			update_option('salient_nectar_slider_permalinks_flushed', 1);
		}
		
	}
	
}


add_action( 'init', 'nectar_add_nectar_slider_taxonomies', 0 );
