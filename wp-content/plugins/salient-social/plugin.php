<?php
/**
 * Plugin Name: Salient Social
 * Plugin URI: https://themenectar.com
 * Description: Add beautiful social sharing buttons for posts. Also includes a reusable WPBakery page builder element.
 * Author: ThemeNectar
 * Author URI: https://themenectar.com
 * Version: 1.2.2
 * Text Domain: salient-social
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SALIENT_SOCIAL_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SALIENT_SOCIAL_PLUGIN_PATH', plugins_url( 'salient-social' ) );
	
class Salient_Social {
	
	static $instance = false;
	
	public $plugin_version = '1.2.2';
		
	private function __construct() {
		
		// Front end assets.
		add_action('wp_enqueue_scripts', array( $this, 'salient_social_enqueue_css' ),	10 );
		add_action('wp_enqueue_scripts', array( $this, 'salient_social_enqueue_js' ),	10 );
		
		// Text domain.
		add_action( 'init', array( $this, 'salient_social_load_textdomain' ) );
		
		// Start it up.
		add_action( 'after_setup_theme', array( $this, 'init' ), 0 );
		
	}
	
	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
  public function using_social_el() {
		
		global $post;
		
		if( !$post ) { 
			return false; 
		}
		
		$portfolio_extra_content   = get_post_meta( $post->ID, '_nectar_portfolio_extra_content', true );
		$post_content              = $post->post_content;
    $nectar_blog_std_style     = 'featured_img_left';
    $nectar_blog_masonry_style = 'auto_meta_overlaid_spaced';
    $nectar_blog_type          = 'masonry-blog-fullwidth';

    $nectar_on_blog_archive_check = ( is_archive() || is_author() || is_category() || is_home() || is_tag() );

    if( function_exists('get_nectar_theme_options') ) {

      $nectar_options = get_nectar_theme_options();

      $nectar_blog_type          = ( isset( $nectar_options['blog_type'] ) ) ? $nectar_options['blog_type'] : 'masonry-blog-fullwidth';
      $nectar_blog_std_style     = ( isset( $nectar_options['blog_standard_type'] ) ) ? $nectar_options['blog_standard_type'] : 'featured_img_left';
	    $nectar_blog_masonry_style = ( isset( $nectar_options['blog_masonry_type'] ) ) ? $nectar_options['blog_masonry_type'] : 'auto_meta_overlaid_spaced';
    }

		
     /* Blog archives */
    if( in_array($nectar_blog_masonry_style, array('classic', 'classic_enhanced')) && 
        in_array($nectar_blog_type, array('masonry-blog-sidebar','masonry-blog-fullwidth','masonry-blog-full-screen-width')) && 
        $nectar_on_blog_archive_check ) {
          return true;
    }

    if( in_array($nectar_blog_std_style, array('classic')) && 
             in_array($nectar_blog_type, array('std-blog-sidebar','std-blog-fullwidth')) && 
             $nectar_on_blog_archive_check) {
          return true;
    }

   /* Social element */
		if ( stripos( $post_content, 'social_buttons' ) !== false ) {
				 return true;
		} 

    /* Blog elements */
    if( stripos( $post_content, '[nectar_blog' ) !== false  ) {

        if( stripos( $post_content, '_style="classic' ) !== false || 
            stripos( $post_content, '_style="inherit' ) !== false ) {
          return true;
        }

    }

    if( stripos( $post_content, '[recent_posts' ) !== false ) {
        if( stripos( $post_content, 'style="classic_enhanced' ) !== false || 
            stripos( $post_content, 'style="default' ) !== false ) {
          return true;
        }
    }

    /* Portfolio elements */
    if( stripos( $post_content, 'project_style="1"' ) !== false ||
        is_page_template( 'template-portfolio.php' ) || 
				is_post_type_archive( 'portfolio' ) || 
				is_singular( 'portfolio' ) ||  
				is_page_template( 'template-home-1.php' ) || 
				is_page_template( 'template-home-3.php' ) || 
				is_tax( 'project-attributes' ) || 
				is_tax( 'project-type' )) {
      return true;
    }
    
		
		return false;
		
	}
  
	public function salient_social_enqueue_css() {


			wp_register_style('salient-social', plugins_url('/css/style.css', __FILE__),'', $this->plugin_version );
			wp_register_style('salient-social-icons', plugins_url('/css/icons.css', __FILE__),'', $this->plugin_version );
			
	    // Enqueue CSS files.
      if( $this->using_social_el() || is_single() ) { 
        wp_enqueue_style( 'salient-social' );
        
        // Add dynamic coloring.
        $styles = salient_social_colors();
        wp_add_inline_style( 'salient-social' , $styles );
        
        // Add icons.
        if( !defined( 'NECTAR_THEME_NAME' ) ) {
          wp_enqueue_style( 'salient-social-icons' );
        }
      }
			
	}
	

	public function salient_social_enqueue_js() {
		
			wp_register_script( 'salient-social', plugins_url('/js/salient-social.js', __FILE__), array( 'jquery' ), $this->plugin_version, true );
			
			// Enqueue JS files.
      if( $this->using_social_el() || is_single() ) { 

        wp_enqueue_script( 'salient-social' );
        
        global $post;
        
        if( $post && isset($post->ID) ) {
          wp_localize_script(
            'salient-social',
            'nectarLove',
            array(
              'ajaxurl'        => esc_url( admin_url( 'admin-ajax.php' ) ),
              'postID'         => $post->ID,
              'rooturl'        => esc_url( home_url() ),
              'loveNonce'      => wp_create_nonce( 'nectar-love-nonce' ),
            )
          );
        }

      }
			
	}
	
	public function salient_social_load_textdomain() {
		load_plugin_textdomain( 'salient-social', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	public function init() {
			
			// Before init.
			do_action( 'before_salient_social_init' );
			
			require_once( SALIENT_SOCIAL_ROOT_DIR_PATH.'includes/admin/customizer.php' );
			
			require_once( SALIENT_SOCIAL_ROOT_DIR_PATH.'includes/frontend/customizer-styles.php' );
			
			if( !class_exists('NectarLove') ) {
				require_once( SALIENT_SOCIAL_ROOT_DIR_PATH.'includes/admin/nectar-love.php' );
			}
			
			if ( class_exists( 'WPBakeryVisualComposerAbstract' )) {
				require_once(  SALIENT_SOCIAL_ROOT_DIR_PATH.'includes/wpbakery/wpbakery-elements.php' );
			}
			
			require_once( SALIENT_SOCIAL_ROOT_DIR_PATH.'includes/frontend/processing.php' );

			// After init.
			do_action( 'salient_social_init' );
			
	}

	
}

// Plugin init.
$Salient_Social = Salient_Social::getInstance();