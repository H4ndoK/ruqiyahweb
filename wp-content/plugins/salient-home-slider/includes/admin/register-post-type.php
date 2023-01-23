<?php 


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Register Home Slider post type.
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_home_slider_register' ) ) {

	function nectar_home_slider_register() {

		$labels = array(
			'name'          => esc_html__( 'Slides', 'salient-home-slider' ),
			'singular_name' => esc_html__( 'Slide', 'salient-home-slider' ),
			'search_items'  => esc_html__( 'Search Slides', 'salient-home-slider' ),
			'all_items'     => esc_html__( 'All Slides', 'salient-home-slider' ),
			'parent_item'   => esc_html__( 'Parent Slide', 'salient-home-slider' ),
			'edit_item'     => esc_html__( 'Edit Slide', 'salient-home-slider' ),
			'update_item'   => esc_html__( 'Update Slide', 'salient-home-slider' ),
			'add_new_item'  => esc_html__( 'Add New Slide', 'salient-home-slider' ),
			'menu_name'     => esc_html__( 'Home Slider', 'salient-home-slider' ),
		);

		 $homeslider_menu_icon = 'dashicons-admin-home';

		 $args = array(
			 'labels'              => $labels,
			 'singular_label'      => esc_html__( 'Home Slider', 'salient-home-slider' ),
			 'public'              => true,
			 'show_ui'             => true,
			 'hierarchical'        => false,
			 'menu_position'       => 10,
			 'menu_icon'           => $homeslider_menu_icon,
			 'exclude_from_search' => true,
			 'supports'            => false,
		 );

		register_post_type( 'home_slider', $args );
	}
}

add_action( 'init', 'nectar_home_slider_register', 0 );
