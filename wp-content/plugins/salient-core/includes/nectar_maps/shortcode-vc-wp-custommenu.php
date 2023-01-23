<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$custom_menus = array();
if ( 'vc_edit_form' === vc_post_param( 'action' ) && vc_verify_admin_nonce() ) {
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	if ( is_array( $menus ) && ! empty( $menus ) ) {
		foreach ( $menus as $single_menu ) {
			if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->term_id ) ) {
				$custom_menus[ $single_menu->name ] = $single_menu->term_id;
			}
		}
	}
}

return array(
	'name' => 'WP ' . esc_html__( 'Custom Menu', 'default' ),
	'base' => 'vc_wp_custommenu',
	"icon" => "icon-wpb-page-submenu",
	'category' => esc_html__( 'Content', 'salient-core' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => esc_html__('Add one of your custom menus as a widget', 'salient-core' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Widget title', 'salient-core' ),
			'param_name' => 'title',
			'description' => esc_html__('What text use as a widget title. Leave blank to use default widget title.', 'salient-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Menu', 'salient-core' ),
			'param_name' => 'nav_menu',
			'value' => $custom_menus,
			'description' => empty( $custom_menus ) ? esc_html__('Custom menus not found. Please visit the Appearance > Menus page to create new menu.', 'salient-core' ) : esc_html__('Select menu to display.', 'salient-core' ),
			'admin_label' => true,
			'save_always' => true,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'salient-core' ),
			'param_name' => 'el_class',
			'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'salient-core' ),
		),
	),
);
