<?php
/**
 * Plugin Name: Salient Home Slider
 * Plugin URI: https://themenectar.com
 * Description: The original featured content slider for Salient. (Deprecated for the more powerful Salient Nectar Slider)
 * Author: ThemeNectar
 * Author URI: https://themenectar.com
 * Version: 1.4.1
 * Text Domain: salient-home-slider
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SALIENT_HOME_SLIDER_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SALIENT_HOME_SLIDER_PLUGIN_PATH', plugins_url( 'salient-home-slider' ) );

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'salient_home_slider_flush_rewrites' );

function salient_home_slider_flush_rewrites() {
	update_option('salient_home_slider_permalinks_flushed', 0);
}
	
class Salient_Home_Slider {
	
	static $instance = false;
	
	public $plugin_version = '1.4.1';
		
	private function __construct() {
		
		// Front end assets.
		add_action('wp_enqueue_scripts', array( $this, 'salient_home_slider_enqueue_css' ),	10 );
		add_action('wp_enqueue_scripts', array( $this, 'salient_home_slider_enqueue_scripts' ),	10 );
		
		// Admin assets.
		add_action( 'admin_enqueue_scripts',  array( $this, 'salient_home_slider_metabox_scripts' ) );
		add_action( 'admin_print_styles', array( $this, 'salient_home_slider_metabox_styles' ) );
		
		// Text domain.
		add_action( 'init', array( $this, 'salient_home_slider_load_textdomain' ) );
		
		// Start it up.
		add_action( 'after_setup_theme', array( $this, 'init' ), 0 );
		
	}
	
	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	
	public function salient_home_slider_enqueue_css(){
			global $post;
			if ( ! is_object( $post ) ) {
				$post = (object) array(
					'post_content' => ' ',
					'ID'           => ' ',
				);
			}
			$template_name = get_post_meta( $post->ID, '_wp_page_template', true );
			
			wp_register_style('orbit', plugins_url('/css/orbit.css', __FILE__),'', $this->plugin_version );
		
	    // Enqueue CSS files.
			if( is_page_template( 'template-home-1.php' ) || $template_name == 'salient/template-home-1.php' ||
				 is_page_template( 'template-home-2.php' ) || $template_name == 'salient/template-home-2.php' ||
				 is_page_template( 'template-home-3.php' ) || $template_name == 'salient/template-home-3.php' ||
				 is_page_template( 'template-home-4.php' ) || $template_name == 'salient/template-home-4.php'  ) {
		    wp_enqueue_style('orbit');
			}
			
	}
	

	
	public function salient_home_slider_enqueue_scripts() {
			
			global $post;
			if ( ! is_object( $post ) ) {
				$post = (object) array(
					'post_content' => ' ',
					'ID'           => ' ',
				);
			}
			$template_name = get_post_meta( $post->ID, '_wp_page_template', true );

			$nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
			$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
			
			wp_register_script( 'orbit', plugins_url('/js/orbit.js', __FILE__), array( 'jquery' ), $this->plugin_version, true );
			wp_register_script( 'touchswipe', plugins_url('/js/touchswipe.min.js', __FILE__), array( 'jquery' ), '1.0', true );
			
			if( $nectar_using_VC_front_end_editor || is_page_template( 'template-home-1.php' ) || $template_name == 'salient/template-home-1.php' ||
				 is_page_template( 'template-home-2.php' ) || $template_name == 'salient/template-home-2.php' ||
				 is_page_template( 'template-home-3.php' ) || $template_name == 'salient/template-home-3.php' ||
				 is_page_template( 'template-home-4.php' ) || $template_name == 'salient/template-home-4.php' ) {
		    	wp_enqueue_script( 'orbit' );
					wp_enqueue_script( 'touchswipe' );
			}
			
			
	}
	
	
	public function salient_home_slider_metabox_styles() {
		wp_enqueue_style( 'salient-metaboxes-meta-css', plugins_url('includes/assets/css/meta.css', __FILE__) , '', $this->plugin_version );
	}

	public function salient_home_slider_metabox_scripts() {
		
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
	
	public function salient_home_slider_load_textdomain() {
		load_plugin_textdomain( 'salient-home-slider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
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
		do_action( 'before_salient_home_slider_init' );
		
		require_once( SALIENT_HOME_SLIDER_ROOT_DIR_PATH.'includes/frontend/helpers.php');
		
		require_once( SALIENT_HOME_SLIDER_ROOT_DIR_PATH.'includes/admin/register-post-type.php');
		
		if( ! function_exists('nectar_create_meta_box') ) {
			require_once( SALIENT_HOME_SLIDER_ROOT_DIR_PATH.'includes/admin/meta-config.php');
		}
		
		require_once( SALIENT_HOME_SLIDER_ROOT_DIR_PATH.'includes/admin/home-slider-meta.php');
		
		// After init.
		do_action( 'salient_home_slider_init' );
		
	}

	
}

// Plugin init
$Salient_Home_Slider = Salient_Home_Slider::getInstance();