<?php
/**
 * Shortcodes
 *
 * @package Salient Shortcodes
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



// -----------------------------------------------------------------#
// Shortcodes - have to load after taxonomy/post type declarations
// -----------------------------------------------------------------#

// utility function for nectar shortcode generator conditional
if ( ! function_exists( 'nectar_is_edit_page' ) ) {
	function nectar_is_edit_page( $new_edit = null ) {
		global $pagenow;
		// make sure we are on the backend
		if ( ! is_admin() ) {
			return false; }

		if ( $new_edit == 'edit' ) {
			return in_array( $pagenow, array( 'post.php' ) );
		} elseif ( $new_edit == 'new' ) { // check for new post page
			return in_array( $pagenow, array( 'post-new.php' ) );
		} else { // check for either new or edit
			return in_array( $pagenow, array( 'post.php', 'post-new.php', 'term.php' ) );
		}
	}
}


// load nectar shortcode button
if ( ! function_exists( 'nectar_shortcode_init' ) ) {
	function nectar_shortcode_init() {

		require_once SALIENT_SHORTCODES_ROOT_DIR_PATH . 'includes/admin/tinymce-class.php';

	}
}


if ( is_admin() ) {
	if ( nectar_is_edit_page() ) {

		add_action( 'init', 'nectar_shortcode_init' );

	}
}

// Add button to page
add_action( 'media_buttons', 'nectar_buttons', 100 );

if ( ! function_exists( 'nectar_buttons' ) ) {
	function nectar_buttons() {
		 echo "<a data-effect='mfp-zoom-in' class='button nectar-shortcode-generator' href='#nectar-sc-generator'><img src='" . SALIENT_SHORTCODES_PLUGIN_PATH . "/includes/assets/icons/n.png' /> " . esc_html__( 'Nectar Shortcodes', 'salient-shortcodes' ) . '</a>';
	}
}


// Shortcode Processing
if ( ! function_exists( 'nectar_shortcode_processing' ) ) {
	function nectar_shortcode_processing() {
		require_once SALIENT_SHORTCODES_ROOT_DIR_PATH . 'includes/frontend/shortcode-core.php';
		
		if ( !class_exists('WPBakeryVisualComposerAbstract') || !class_exists('Salient_Core') ) {
			require_once SALIENT_SHORTCODES_ROOT_DIR_PATH . 'includes/frontend/shortcode-elements.php';
		}
		
	}
}


add_action( 'init', 'nectar_shortcode_processing' );
