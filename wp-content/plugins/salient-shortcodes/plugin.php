<?php
/**
 * Plugin Name: Salient Shortcodes
 * Plugin URI: https://themenectar.com
 * Description: Adds the Salient collection of shortcodes with a convenient shortcode generator that is available on all instances of Tinymce editors.
 * Author: ThemeNectar
 * Author URI: http://themenectar.com
 * Version: 1.5.1
 * Text Domain: salient-shortcodes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SALIENT_SHORTCODES_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SALIENT_SHORTCODES_PLUGIN_PATH', plugins_url( 'salient-shortcodes' ) );

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'salient_shortcodes_flush_rewrites' );

function salient_shortcodes_flush_rewrites() {
	update_option('salient_shortcodes_permalinks_flushed', 0);
}
	
class Salient_Shortcodes {
	
	static $instance = false;
	
	public $plugin_version = '1.5.1';
		
	private function __construct() {
		
		// Front end assets.
		add_action('wp_enqueue_scripts', array( $this, 'salient_shortcodes_enqueue_css' ),	10 );
		add_action('wp_enqueue_scripts', array( $this, 'salient_shortcodes_enqueue_js' ),	10 );
		
		// Admin assets.
		add_action( 'admin_enqueue_scripts',  array( $this, 'salient_shortcode_edit_scripts' ) );
		
		// Text domain.
		add_action( 'init', array( $this, 'salient_shortcodes_load_textdomain' ) );
		
		// Start it up.
		add_action( 'after_setup_theme', array( $this, 'init' ), 0 );
		
	}
	
	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	

	public function salient_shortcodes_enqueue_css() {

			wp_register_style('salient-shortcodes', plugins_url('/css/style.css', __FILE__),'', $this->plugin_version );
		
	    // Enqueue CSS files.
			if( ! defined( 'NECTAR_THEME_NAME' ) && ! class_exists( 'Salient_Core' ) ) {
				wp_enqueue_style( 'salient-shortcodes-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C600%2C700&subset=latin%2Clatin-ext', false, null, 'all' );
		    wp_enqueue_style( 'salient-shortcodes' );
			}
			
	}
	
	
	public function salient_shortcodes_enqueue_js() {


			if( ! defined( 'NECTAR_THEME_NAME' ) && ! class_exists( 'Salient_Core' ) ) {
				
				wp_register_script('jquery-easing', plugins_url('/js/jquery.easing.js', __FILE__), array( 'jquery' ), $this->plugin_version );
				wp_register_script('salient-shortcodes', plugins_url('/js/init.js', __FILE__), array( 'jquery','jquery-easing' ), $this->plugin_version );
					
				wp_register_script( 'nectar-testimonial-sliders', plugins_url('/js/nectar-testimonial-slider.js', __FILE__) , array( 'jquery', 'jquery-easing' ), $this->plugin_version, true );
				wp_register_script( 'touchswipe', plugins_url('/js/touchswipe.min.js', __FILE__), array( 'jquery' ), '1.0', true );
				
				 // Enqueue JS files.
				wp_enqueue_script( 'touchswipe' );
				wp_enqueue_script( 'nectar-testimonial-sliders' );
		    wp_enqueue_script( 'salient-shortcodes' );
			}
			
	}
	
	
	public function salient_shortcode_edit_scripts() {
		
		
		wp_enqueue_style( 'wp-color-picker' );		
		wp_enqueue_script( 'wp-color-picker' );		
		
		wp_enqueue_script(
      'nectar-add-media',
      plugins_url('includes/assets/js/add-media.js', __FILE__),
      array( 'jquery' ),
      '8.5.4',
      true
    );
		
		wp_enqueue_media();
	}


	public function salient_shortcodes_load_textdomain() {
		load_plugin_textdomain( 'salient-shortcodes', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	public function init() {
			
			// Before init.
			do_action( 'before_salient_shortcodes_init' );
			
			require_once( SALIENT_SHORTCODES_ROOT_DIR_PATH.'includes/admin/shortcode-helpers.php');
			
			require_once( SALIENT_SHORTCODES_ROOT_DIR_PATH.'includes/admin/shortcodes.php');
			
			// After init.
			do_action( 'salient_shortcodes_init' );
			
	}

	
}

// Plugin init.
$Salient_Shortcodes = Salient_Shortcodes::getInstance();