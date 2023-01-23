<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Portfolio register post type.
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_portfolio_register' ) ) {

	function nectar_portfolio_register() {

		 $portfolio_labels = array(
			 'name'          => esc_html__( 'Portfolio', 'salient-portfolio' ),
			 'singular_name' => esc_html__( 'Portfolio Item', 'salient-portfolio' ),
			 'search_items'  => esc_html__( 'Search Portfolio Items', 'salient-portfolio' ),
			 'all_items'     => esc_html__( 'Portfolio', 'salient-portfolio' ),
			 'parent_item'   => esc_html__( 'Parent Portfolio Item', 'salient-portfolio' ),
			 'edit_item'     => esc_html__( 'Edit Portfolio Item', 'salient-portfolio' ),
			 'update_item'   => esc_html__( 'Update Portfolio Item', 'salient-portfolio' ),
			 'add_new_item'  => esc_html__( 'Add New Portfolio Item', 'salient-portfolio' ),
		 );

		global $nectar_options;
		$custom_slug = 'portfolio';

		if ( defined( 'NECTAR_THEME_NAME' ) && ! empty( $nectar_options['portfolio_rewrite_slug'] ) ) {
			$custom_slug = $nectar_options['portfolio_rewrite_slug'];
		}

		 $portolfio_menu_icon = 'dashicons-art';

		 $portfolio_slug_rewrite = apply_filters('salient_portfolio_slug_rewrite', array('slug' => $custom_slug, 'with_front' => false) );

		 $args = array(
			 'labels'             => $portfolio_labels,
			 'rewrite'            => $portfolio_slug_rewrite,
			 'singular_label'     => esc_html__( 'Project', 'salient-portfolio' ),
			 'public'             => true,
			 'publicly_queryable' => true,
			 'show_ui'            => true,
			 'hierarchical'       => false,
			 'menu_position'      => 9,
			 'menu_icon'          => $portolfio_menu_icon,
			 'supports'           => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
		 );

		register_post_type( 'portfolio', $args );
	}

}

add_action( 'init', 'nectar_portfolio_register', 0 );





/**
 * Add taxonomies to Portfolio post type.
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_add_portfolio_taxonomies' ) ) {

	function nectar_add_portfolio_taxonomies() {

		$category_labels = array(
			'name'          => esc_html__( 'Project Categories', 'salient-portfolio' ),
			'singular_name' => esc_html__( 'Project Category', 'salient-portfolio' ),
			'search_items'  => esc_html__( 'Search Project Categories', 'salient-portfolio' ),
			'all_items'     => esc_html__( 'All Project Categories', 'salient-portfolio' ),
			'parent_item'   => esc_html__( 'Parent Project Category', 'salient-portfolio' ),
			'edit_item'     => esc_html__( 'Edit Project Category', 'salient-portfolio' ),
			'update_item'   => esc_html__( 'Update Project Category', 'salient-portfolio' ),
			'add_new_item'  => esc_html__( 'Add New Project Category', 'salient-portfolio' ),
			'menu_name'     => esc_html__( 'Project Categories', 'salient-portfolio' ),
		);

		$project_type_rewrite = apply_filters('salient_portfolio_project_type_rewrite', array( 'slug' => 'project-type' ));

		register_taxonomy(
			'project-type',
			array( 'portfolio' ),
			array(
				'hierarchical' => true,
				'labels'       => $category_labels,
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => $project_type_rewrite,
			)
		);

		$attributes_labels = array(
			'name'          => esc_html__( 'Project Attributes', 'salient-portfolio' ),
			'singular_name' => esc_html__( 'Project Attribute', 'salient-portfolio' ),
			'search_items'  => esc_html__( 'Search Project Attributes', 'salient-portfolio' ),
			'all_items'     => esc_html__( 'All Project Attributes', 'salient-portfolio' ),
			'parent_item'   => esc_html__( 'Parent Project Attribute', 'salient-portfolio' ),
			'edit_item'     => esc_html__( 'Edit Project Attribute', 'salient-portfolio' ),
			'update_item'   => esc_html__( 'Update Project Attribute', 'salient-portfolio' ),
			'add_new_item'  => esc_html__( 'Add New Project Attribute', 'salient-portfolio' ),
			'new_item_name' => esc_html__( 'New Project Attribute', 'salient-portfolio' ),
			'menu_name'     => esc_html__( 'Project Attributes', 'salient-portfolio' ),
		);

		$project_attrs_rewrite = apply_filters('salient_portfolio_project_attributes_rewrite', array( 'slug' => 'project-attributes' ));

		register_taxonomy(
			'project-attributes',
			array( 'portfolio' ),
			array(
				'hierarchical' => true,
				'labels'       => $attributes_labels,
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => $project_attrs_rewrite,
			)
		);
		
			if( !get_option('salient_portfolio_permalinks_flushed') ) {
				flush_rewrite_rules();
				update_option('salient_portfolio_permalinks_flushed', 1);
			}
	}
}

add_action( 'init', 'nectar_add_portfolio_taxonomies', 0 );
