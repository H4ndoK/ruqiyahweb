<?php
/**
 * Salient Theme Hooks.
 *
 * @package Salient WordPress Theme
 * @subpackage hooks
 * @version 12.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * After body open tag.
 */
function nectar_hook_after_body_open() {
	do_action( 'nectar_hook_after_body_open' );
}

/**
 * Before Header Navigation.
 */
function nectar_hook_before_header_nav() {
	do_action( 'nectar_hook_before_header_nav' );
}

/**
 * After outer wrap open (#ajax-content-wrap).
 */
function nectar_hook_after_outer_wrap_open() {
	do_action( 'nectar_hook_after_outer_wrap_open' );
}

/**
 * Before page/post content begins.
 */
function nectar_hook_before_content() {
  do_action( 'nectar_hook_before_content' );
}

/**
 * After page/post content ends.
 */
function nectar_hook_after_content() {
  do_action( 'nectar_hook_after_content' );
}

/**
 * Pull right menu items.
 */
function nectar_hook_pull_right_menu_items() {
	do_action( 'nectar_hook_pull_right_menu_items' );
}

/**
 * Pull left menu items.
 */
function nectar_hook_pull_left_menu_items() {
	do_action( 'nectar_hook_pull_left_menu_items' );
}

/**
 * Before button menu items.
 */
function nectar_hook_before_button_menu_items() {
	do_action( 'nectar_hook_before_button_menu_items' );
}

/**
 * Mobile menu items.
 */
function nectar_hook_mobile_header_menu_items() {
	do_action( 'nectar_hook_mobile_header_menu_items' );
}
function nectar_hook_mobile_header_before_logo() {
	do_action( 'nectar_hook_mobile_header_before_logo' );
}

/**
 * Secondary header layout menu items.
 */
function nectar_hook_secondary_header_menu_items() {
	do_action( 'nectar_hook_secondary_header_menu_items' );
}

function nectar_hook_secondary_header_after_nav_open() {
	do_action( 'nectar_hook_secondary_header_after_nav_open' );
}

function nectar_hook_secondary_header_before_nav_close() {
	do_action( 'nectar_hook_secondary_header_before_nav_close' );
}


/**
 * Off canvas menu before menu.
 */
function nectar_hook_ocm_before_menu() {
	do_action( 'nectar_hook_ocm_before_menu' );
}

/**
 * Off canvas menu after menu.
 */
function nectar_hook_ocm_after_menu() {
	do_action( 'nectar_hook_ocm_after_menu' );
}

/**
 * Off canvas menu before secondary items.
 */
 
function nectar_hook_ocm_before_secondary_items() {
	do_action( 'nectar_hook_ocm_before_secondary_items' );
}

/**
 * Off canvas menu after secondary items.
 */
function nectar_hook_ocm_after_secondary_items() {
	do_action( 'nectar_hook_ocm_after_secondary_items' );
}

/**
 * Off canvas menu bottom meta.
 */
function nectar_hook_ocm_bottom_meta() {
	do_action( 'nectar_hook_ocm_bottom_meta' );
}

/**
 *Before footer open.
 */
function nectar_hook_before_container_wrap_close() {
	do_action( 'nectar_hook_before_container_wrap_close' );
}

/**
 *Before footer open.
 */
function nectar_hook_before_footer_open() {
	do_action( 'nectar_hook_before_footer_open' );
}

/**
 *After footer open.
 */
function nectar_hook_after_footer_open() {
	do_action( 'nectar_hook_after_footer_open' );
}

/**
 * Before footer widgets.
 */
function nectar_hook_before_footer_widget_area() {
	do_action( 'nectar_hook_before_footer_widget_area' );
}

/**
 * After footer widgets.
 */
function nectar_hook_after_footer_widget_area() {
	do_action( 'nectar_hook_after_footer_widget_area' );
}


/**
 * Before outer wrap close (#ajax-content-wrap).
 */
function nectar_hook_before_outer_wrap_close() {
	do_action( 'nectar_hook_before_outer_wrap_close' );
}


/**
 * After WP footer.
 */
function nectar_hook_after_wp_footer() {
	do_action( 'nectar_hook_after_wp_footer' );
}

/**
 * Before body close tag.
 */
function nectar_hook_before_body_close() {
	do_action( 'nectar_hook_before_body_close' );
}


?>