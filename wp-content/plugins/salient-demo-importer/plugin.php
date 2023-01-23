<?php
/**
 * Plugin Name: Salient Demo Importer
 * Plugin URI: https://themenectar.com
 * Description: Easily import the live demos of Salient into your own setup. Adds a "Demo Importer" tab into the Salient theme options panel. 
 * Author: ThemeNectar
 * Author URI: https://themenectar.com
 * Version: 1.5
 * Text Domain: salient-demo-importer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SALIENT_DEMO_IMPORTER_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SALIENT_DEMO_IMPORTER_PLUGIN_PATH', plugins_url( 'salient-demo-importer' ) );

if ( ! defined( 'SALIENT_DEMO_IMPORTER_VERSION' ) ) {
    define( 'SALIENT_DEMO_IMPORTER_VERSION', '1.5.0' );
}

class Salient_Demo_Importer {
	
	static $instance = false;

	public $plugin_version = SALIENT_DEMO_IMPORTER_VERSION;

		
	private function __construct() {
		
		// Text domain.
		add_action( 'init', array( $this, 'salient_demo_importer_load_textdomain' ) );
		
		// Start it up.
		add_action( 'redux/extensions/before', array( $this, 'init' ), 10 );
		
	}
	
	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	
	public function salient_demo_importer_load_textdomain() {
		load_plugin_textdomain( 'salient-demo-importer', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	
	public function init() {
			
			// Before init.
			do_action( 'before_salient_demo_importer_init' );
			
			// Load Demo Importer.
			require_once( SALIENT_DEMO_IMPORTER_ROOT_DIR_PATH. 'includes/admin/demo-importer-init.php');
			
			// After init.
			do_action( 'salient_demo_importer_init' );
			
	}

	
}

// Plugin init.
$Salient_Demo_Importer = Salient_Demo_Importer::getInstance();