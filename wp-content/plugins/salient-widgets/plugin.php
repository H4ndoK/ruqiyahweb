<?php
/**
 * Plugin Name: Salient Widgets
 * Plugin URI: https://themenectar.com
 * Description: Adds the Salient collection of widgets.
 * Author: ThemeNectar
 * Author URI: http://themenectar.com
 * Version: 1.3
 * Text Domain: salient-widgets
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SALIENT_WIDGETS_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SALIENT_WIDGETS_PLUGIN_PATH', plugins_url( 'salient-widgets' ) );
if ( ! defined( 'SALIENT_WIDGETS_PLUGIN_VERSION' ) ) {
	define( 'SALIENT_WIDGETS_PLUGIN_VERSION', '1.3.0' );
}

class Salient_Widgets {

	static $instance = false;

	public $plugin_version = SALIENT_WIDGETS_PLUGIN_VERSION;

	private function __construct() {

		// Front end assets.
		add_action('wp_enqueue_scripts', array( $this, 'salient_widgets_enqueue_css' ),	10 );

		// Admin assets.
		add_action( 'admin_enqueue_scripts',  array( $this, 'salient_widgets_edit_scripts' ) );

		// Text domain.
		add_action( 'init', array( $this, 'salient_widgets_load_textdomain' ) );

		// Start it up.
		add_action( 'after_setup_theme', array( $this, 'init' ), 0 );

	}

	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}



	public function salient_widgets_enqueue_css() {

			wp_register_style('salient-widgets', plugins_url('/css/widget-nectar-posts.css', __FILE__),'', $this->plugin_version );

	    // Enqueue CSS files.
			if( ! defined( 'NECTAR_THEME_NAME' ) ) {
		    wp_enqueue_style( 'salient-widgets' );
			}

	}


	public function salient_widgets_edit_scripts($hook) {
		wp_enqueue_media();

		if( $hook === 'widgets.php' ) {
			wp_register_style( 'nectar-widget-admin', plugins_url('/includes/admin/css/nectar-widget-admin.css', __FILE__),'', $this->plugin_version );
			wp_enqueue_style( 'nectar-widget-admin' );

			wp_register_script( 'nectar-widget-admin', plugins_url('/includes/admin/js/nectar-widget-admin.js', __FILE__),'', $this->plugin_version );

			// Salient colors
			if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
				
				$nectar_options = get_nectar_theme_options();
				$color_arr = array(
					'color1' => $nectar_options["accent-color"],
					'color2' => $nectar_options["extra-color-1"],
					'color3' => $nectar_options["extra-color-2"],
					'color4' => $nectar_options["extra-color-3"],
					'color5' => '#000000',
					'color6' => '#ffffff'
				);
			} else {
				$color_arr = array(
					'color1' => '#000000',
					'color2' => '#ffffff',
					'color3' => '#3a67ff',
					'color4' => '#ff0050',
					'color5' => '#2de2af',
					'color6' => '#ffad33'
				);
			}
			wp_localize_script( 'nectar-widget-admin', 'nectarColors', $color_arr);

			wp_enqueue_script( 'nectar-widget-admin' );

			wp_enqueue_style( 'wp-color-picker' );
		}
	}



	public function salient_widgets_load_textdomain() {
		load_plugin_textdomain( 'salient-widgets', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}


	public function init() {

			// Before init.
			do_action( 'before_salient_widgets_init' );

			// Recent Posts Extra.
			require_once( SALIENT_WIDGETS_ROOT_DIR_PATH.'includes/admin/recent-posts-extra-widget.php' );

			// Recent portfolio items.
			if( class_exists('Salient_Portfolio') ) {
				require_once( SALIENT_WIDGETS_ROOT_DIR_PATH.'includes/admin/recent-projects-widget.php' );
			}

			// Recent portfolio items.
			require_once( SALIENT_WIDGETS_ROOT_DIR_PATH.'includes/admin/popular-posts.php' );

			// After init.
			do_action( 'salient_widgets_init' );

	}


}

// Plugin init.
$Salient_Widgets = Salient_Widgets::getInstance();
