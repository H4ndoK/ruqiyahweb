<?php
/**
 * Plugin Name: Salient Nectar Slider
 * Plugin URI: https://themenectar.com
 * Description: A stylish & simple slider to feature content.
 * Author: ThemeNectar
 * Author URI: https://themenectar.com
 * Version: 1.7.3
 * Text Domain: salient-nectar-slider
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SALIENT_NECTAR_SLIDER_PLUGIN_PATH', plugins_url( 'salient-nectar-slider' ) );
if ( ! defined( 'SALIENT_NECTAR_SLIDER_VERSION' ) ) {
	define( 'SALIENT_NECTAR_SLIDER_VERSION', '1.7.3' );
}

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'salient_nectar_slider_flush_rewrites' );

function salient_nectar_slider_flush_rewrites() {
	update_option('salient_nectar_slider_permalinks_flushed', 0);
}

class Salient_Nectar_Slider {

	static $instance = false;

	public $plugin_version = SALIENT_NECTAR_SLIDER_VERSION;

	private function __construct() {

		// Front end assets.
		add_action('wp_enqueue_scripts', array( $this, 'salient_nectar_slider_enqueue_css' ),	10 );
		add_action('wp_enqueue_scripts', array( $this, 'salient_nectar_slider_enqueue_scripts' ),	10 );

		// Admin assets.
		add_action( 'admin_enqueue_scripts',  array( $this, 'salient_nectar_slider_metabox_scripts' ) );
		add_action( 'admin_print_styles', array( $this, 'salient_nectar_slider_metabox_styles' ) );

		// Text domain.
		add_action( 'init', array( $this, 'salient_nectar_slider_load_textdomain' ) );

		// Start it up.
		add_action( 'after_setup_theme', array( $this, 'init' ), 0 );

	}

	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}


	public function using_nectar_slider_el() {

		global $post;

		if( !$post ) { return false; }

		$portfolio_extra_content = get_post_meta( $post->ID, '_nectar_portfolio_extra_content', true );
		$post_content            = $post->post_content;

		if ( stripos( $post_content, '[nectar_slider' ) !== false || stripos( $portfolio_extra_content, '[nectar_slider' ) !== false
		|| stripos( $post_content, 'type="nectarslider_style"' ) !== false || stripos( $portfolio_extra_content, 'type="nectarslider_style"' ) !== false ) {
				return true;
		}

		return false;

	}


	public function salient_nectar_slider_enqueue_css(){

			$using_nectar_slider_el = $this->using_nectar_slider_el();

			wp_register_style('nectar-slider', plugins_url('/css/nectar-slider.css', __FILE__),'', $this->plugin_version );
			wp_register_style('nectar-slider-fonts', plugins_url('/css/nectar-slider-fonts.css', __FILE__),'', $this->plugin_version );

	    	// Enqueue CSS files.
			if ( $using_nectar_slider_el ) {
	    	wp_enqueue_style('nectar-slider');
			}

			if( ! defined( 'NECTAR_THEME_NAME' ) ) {
				wp_register_style('font-awesome', plugins_url('/css/font-awesome.min.css', __FILE__),'', $this->plugin_version );
				wp_enqueue_style('font-awesome');
				wp_enqueue_style('nectar-slider-fonts');
			}
	}



	public function salient_nectar_slider_enqueue_scripts() {

			$using_nectar_slider_el = $this->using_nectar_slider_el();

			$nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
			$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;


			wp_register_script( 'nectar-slider', plugins_url('/js/nectar-slider.js', __FILE__), array( 'jquery', 'anime' ), $this->plugin_version, true );
			wp_register_script( 'anime', plugins_url('/js/anime.js', __FILE__), array( 'jquery' ), $this->plugin_version, true );

			if( $using_nectar_slider_el || $nectar_using_VC_front_end_editor) {
				wp_enqueue_script( 'anime' );
		    wp_enqueue_script( 'nectar-slider' );
			}

			wp_localize_script('nectar-slider','nectar_theme_info', array(
				'using_salient' => ( defined( 'NECTAR_THEME_NAME' ) ) ? 'true' : 'false'
			));

	}


	public function salient_nectar_slider_metabox_styles() {
		wp_enqueue_style( 'salient-metaboxes-meta-css', plugins_url('includes/assets/css/meta.css', __FILE__) , '', $this->plugin_version );
	}

	public function salient_nectar_slider_metabox_scripts() {

		if( ! defined( 'NECTAR_THEME_NAME' ) ) {
			wp_register_script( 'salient-upload', plugins_url('includes/assets/js/meta.js', __FILE__), array( 'jquery' ), $this->plugin_version );
			wp_enqueue_script( 'salient-upload' );
		} else {
			wp_enqueue_script( 'nectar-upload' );
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script(
			'nectar-add-media',
			plugins_url('includes/assets/js/add-media.js', __FILE__),
			array( 'jquery' ),
			'8.5.4',
			true
		);
		wp_enqueue_media();

	}


	public function salient_nectar_slider_load_textdomain() {
		load_plugin_textdomain( 'salient-nectar-slider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

	public function init() {

			// If plugin is activated with old Salient theme.
			if( defined( 'NECTAR_THEME_NAME' ) ) {

				if( !function_exists('nectar_get_theme_version') ) {
					return;
				}
				if( version_compare( nectar_get_theme_version(), "10.4", "<" ) ) {
					return;
				}

			}

			// Before init.
			do_action( 'before_salient_nectar_slider_init' );

			require_once( SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH.'includes/frontend/helpers.php');

			require_once( SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH.'includes/admin/register-post-type.php');

			if( ! function_exists('nectar_create_meta_box') ) {
				require_once( SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH.'includes/admin/meta-config.php');
			}

			require_once( SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH.'includes/admin/nectar-slider-meta.php');

			if ( class_exists( 'WPBakeryVisualComposerAbstract' )) {
				require_once( SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH.'includes/wpbakery/wpbakery-elements.php' );
			}

			require_once( SALIENT_NECTAR_SLIDER_ROOT_DIR_PATH.'includes/frontend/shortcode.php');

			// After init.
			do_action( 'salient_nectar_slider_init' );

	}


}

// Plugin init.
$Salient_Nectar_Slider = Salient_Nectar_Slider::getInstance();