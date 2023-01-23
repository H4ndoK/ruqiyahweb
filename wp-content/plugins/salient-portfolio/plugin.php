<?php
/**
 * Plugin Name: Salient Portfolio
 * Plugin URI: https://themenectar.com
 * Description: Showcase your projects in a stunning manner with the Nectar Portfolio post type.
 * Author: ThemeNectar
 * Author URI: https://themenectar.com
 * Version: 1.7.2
 * Text Domain: salient-portfolio
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SALIENT_PORTFOLIO_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SALIENT_PORTFOLIO_PLUGIN_PATH', plugins_url( 'salient-portfolio' ) );
if ( ! defined( 'SALIENT_PORTFOLIO_PLUGIN_VERSION' ) ) {
	define( 'SALIENT_PORTFOLIO_PLUGIN_VERSION', '1.7.2' );
}

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'salient_portfolio_flush_rewrites' );

function salient_portfolio_flush_rewrites() {
	update_option('salient_portfolio_permalinks_flushed', 0);
}
	
class Salient_Portfolio {
	
	static $instance = false;
	
	public $plugin_version = SALIENT_PORTFOLIO_PLUGIN_VERSION;
		
	private function __construct() {
		
		// Front end assets.
		add_action('wp_enqueue_scripts', array( $this, 'salient_portfolio_enqueue_css' ),	10 );
		add_action('wp_enqueue_scripts', array( $this, 'salient_portfolio_enqueue_scripts' ),	10 );
		
		// Admin assets.
		add_action( 'admin_enqueue_scripts',  array( $this, 'salient_portfolio_metabox_scripts' ) );
		add_action( 'admin_print_styles', array( $this, 'salient_portfolio_metabox_styles' ) );
		
		// Text domain.
		add_action( 'init', array( $this, 'salient_portfolio_load_textdomain' ) );
		
		// Start it up.
		add_action( 'after_setup_theme', array( $this, 'init' ), 0 );
		
	}
	
	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	
	public function using_portfolio_el() {
		
		global $post;
		
		if( !$post ) { 
			return false; 
		}
		
		$portfolio_extra_content = get_post_meta( $post->ID, '_nectar_portfolio_extra_content', true );
		$post_content            = $post->post_content;
			
		if ( stripos( $post_content, 'nectar_portfolio' ) !== false || stripos( $portfolio_extra_content, 'nectar_portfolio' ) !== false ||
			 stripos( $post_content, 'type="image_grid"' ) !== false || stripos( $portfolio_extra_content, 'type="image_grid"' ) !== false ||
			 stripos( $post_content, "type='image_grid'" ) !== false || stripos( $portfolio_extra_content, "type='image_grid'" ) !== false ) {
				 return true;
		} 
		else {
				 return false;
		}	
		
	}
	
	
	public function using_recent_projects_el() {
		
		global $post;
		
		if( !$post ) { 
			return false; 
		}
		
		$portfolio_extra_content = get_post_meta( $post->ID, '_nectar_portfolio_extra_content', true );
		$post_content            = $post->post_content;
			
		if ( stripos( $post_content, 'recent_projects' ) !== false || stripos( $portfolio_extra_content, 'recent_projects' ) !== false ) {
				 return true;
		} 
		else {
				 return false;
		}	
		
	}
	


	public function salient_portfolio_enqueue_css(){
		
			$using_portfolio_el       = $this->using_portfolio_el();
			$using_recent_projects_el = $this->using_recent_projects_el();
		
			wp_register_style('nectar-portfolio', plugins_url('/css/portfolio.css', __FILE__),'', $this->plugin_version );
			wp_register_style('nectar-portfolio-grid', plugins_url('/css/portfolio-grid.css', __FILE__),'', $this->plugin_version );
		
	    // Enqueue CSS files.
			if ( $using_portfolio_el || 
				$using_recent_projects_el || 
				is_page_template( 'template-portfolio.php' ) || 
				is_post_type_archive( 'portfolio' ) || 
				is_singular( 'portfolio' ) ||  
				is_page_template( 'template-home-1.php' ) || 
				is_page_template( 'template-home-3.php' ) || 
				is_tax( 'project-attributes' ) || 
				is_tax( 'project-type' ) ) {
	    		wp_enqueue_style('nectar-portfolio');
			}

			if( ! defined( 'NECTAR_THEME_NAME' ) ) {
					wp_enqueue_style('nectar-portfolio-grid');
			}
	}
	
	
	
	public function salient_portfolio_enqueue_scripts() {
			
			$using_portfolio_el       = $this->using_portfolio_el();
			$using_recent_projects_el = $this->using_recent_projects_el();
			
			wp_register_script( 'imagesLoaded', plugins_url('/js/third-party/imagesLoaded.min.js', __FILE__), array( 'jquery' ), '4.1.4', true );
			wp_register_script( 'isotope', plugins_url('/js/third-party/isotope.min.js', __FILE__), array( 'jquery' ), '7.6', true );
			wp_register_script( 'touchswipe', plugins_url('/js/third-party/touchswipe.min.js', __FILE__), array( 'jquery' ), '1.0', true );
			wp_register_script( 'caroufredsel', plugins_url('/js/third-party/caroufredsel.min.js', __FILE__), array( 'jquery', 'touchswipe' ), '7.0.1', true );
			wp_register_script( 'salient-portfolio-waypoints', plugins_url('/js/third-party/waypoints.js', __FILE__), array( 'jquery' ), '4.0.1', true );
			wp_register_script( 'salient-portfolio-js', plugins_url('/js/salient-portfolio.js', __FILE__), array( 'jquery' ), $this->plugin_version, true );
			
			if( $using_portfolio_el || 
				$using_recent_projects_el || 
				is_page_template( 'template-portfolio.php' ) || 
				is_post_type_archive( 'portfolio' ) || 
				is_tax( 'project-attributes' ) || 
				is_page_template( 'template-home-1.php' ) || 
				is_page_template( 'template-home-3.php' ) || 
				is_tax( 'project-type' )) {

					wp_enqueue_script( 'imagesLoaded' );
					if( ! defined( 'NECTAR_THEME_NAME' ) ) {
						wp_enqueue_script( 'salient-portfolio-waypoints' );
					}
					wp_enqueue_script( 'isotope' );
					wp_enqueue_script( 'salient-portfolio-js' );
			}
			
			if($using_recent_projects_el || is_page_template( 'template-home-3.php' ) || is_page_template( 'template-home-1.php' ) ) {
				wp_enqueue_script( 'touchswipe' );
				wp_enqueue_script( 'caroufredsel' );
			}
			
			
			$nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
			$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
			
			if( $nectar_using_VC_front_end_editor ) {
				wp_enqueue_script( 'salient-portfolio-js' );
			}
			
			wp_localize_script('salient-portfolio-js','nectar_theme_info', array(
				'using_salient' => ( defined( 'NECTAR_THEME_NAME' ) ) ? 'true' : 'false'
			));
			
	}
	
	
	public function salient_portfolio_metabox_styles() {
		wp_enqueue_style( 'salient-metaboxes-meta-css', plugins_url('includes/assets/css/meta.css', __FILE__) , '', $this->plugin_version );
	}

	public function salient_portfolio_metabox_scripts( $hook ) {
		
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
		
		if( $this->verify_portfolio_screen($hook) ) {

			// Third Party Integration.
			if( class_exists('WPSEO_Options') ) {
				wp_register_script( 'salient-portfolio-yoast', plugins_url('includes/admin/third-party/js/yoast.js', __FILE__), array( 'jquery' ), $this->plugin_version );
				wp_enqueue_script( 'salient-portfolio-yoast' );
			}
			if( class_exists('RankMath') ) {
				wp_register_script( 'salient-portfolio-rankmath', plugins_url('includes/admin/third-party/js/rankmath.js', __FILE__), array( 'jquery', 'wp-hooks', 'rank-math-analyzer', 'underscore' ), $this->plugin_version, true );
				wp_enqueue_script( 'salient-portfolio-rankmath' );
			}

			// Portfolio admin.
			$activate_unload = apply_filters('salient_portfolio_unsaved_changes_protection', false);
			wp_enqueue_script('salient-portfolio-admin-util', plugins_url('includes/assets/js/portfolio-admin.js', __FILE__), array( 'jquery' ), $this->plugin_version);
			wp_localize_script('salient-portfolio-admin-util','salient_portfolio_admin_l10n', array(
				'save_alert' => esc_html__('Changes you made may not be saved.','salient-portfolio'),
				'activate_unload' => ($activate_unload === true) ? true : false
			));

		}
		
	}

	public function verify_portfolio_screen($hook) {

		if( function_exists('get_current_screen') ) {
			
			$screen = get_current_screen();
			
			if( 'post.php' === $hook || 'post-new.php' === $hook ) {
				
				if( is_object( $screen ) && 
				    isset( $screen->post_type ) && 
					'portfolio' == $screen->post_type && 
					current_user_can('edit_pages') ) {
					return true;
				}
				
			}
		}

		return false;
	}
	
	
	public function salient_portfolio_load_textdomain() {
		load_plugin_textdomain( 'salient-portfolio', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
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
		do_action( 'before_salient_portfolio_init' );
		
		require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/class-single-project-layout.php');
		
		require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/frontend/template-loading.php');
		
		require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/frontend/helpers.php');
		
		require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/admin/register-post-type.php');
		
		require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/admin/media.php');
		
		if( ! function_exists('nectar_create_meta_box') ) {
			require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/admin/meta-config.php');
		}
		
		require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/admin/portfolio-meta.php');
		
		if ( class_exists( 'WPBakeryVisualComposerAbstract' )) {
			require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/wpbakery/wpbakery-elements.php' );
		}
		
		require_once( SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/frontend/shortcode.php');
		
		
		// After init.
		do_action( 'salient_portfolio_init' );
		
	}

	
}

// Plugin init.
$Salient_Portfolio = Salient_Portfolio::getInstance();