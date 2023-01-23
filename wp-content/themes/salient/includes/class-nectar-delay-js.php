<?php

/**
 * Nectar Delay JS
 *
 * 
 * @package Salient WordPress Theme
 * @version 14.1
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Nectar Lazy Images.
 */
if (!class_exists('NectarDelayJS')) {

    class NectarDelayJS
    {

        private static $instance;

        public $salient_scripts = array(
            'nectar-frontend',
            'hoverintent',
            'touchswipe',
            'jquery-easing',
            'jquery-mousewheel',
            'superfish',
            'flickity',
            'flickity-fade',
            'magnific',
            'fancyBox',
            'lottie-player',
            'nectar-lottie',
            'nectar-parallax',
            'nectar-transit',
            'fullpage',
            'vivus',
            'owl-carousel',
            'twentytwenty',
            'infinite-scroll',
            'nectar-waypoints',
            'nectar-single-product-reviews',
            'nectar-single-product',
            'nectar-fullpage',
            'nectar-testimonial-sliders',
            'wpb_composer_front_js'
        );

        public $activate_logic = false;
        public $delay_js = false;

        public function __construct()
        {
            add_action('wp', array($this, 'init'), 10);
        }  

        public function init() {
            
            $this->activate_logic = wp_is_mobile();
            $this->delay_js = false;

            // Allow filtering of script list.
            $this->salient_scripts = apply_filters('nectar_delay_js_script_list', $this->salient_scripts);

            $nectar_options = get_nectar_theme_options();
            
            // Store delay settings.
            if( isset( $nectar_options['delay-js-execution'] ) && '1' === $nectar_options['delay-js-execution'] ) {
                $this->delay_js = true;
            }
            if(  isset( $nectar_options['delay-js-execution-devices'] ) && 'all' === $nectar_options['delay-js-execution-devices'] ) {
                $this->activate_logic = true;
            }
            // Disable for front-end editor.
            $using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
            $using_VC_front_end_editor = ($using_VC_front_end_editor == 'true') ? true : false;

            if( true === $using_VC_front_end_editor ) {
                $this->activate_logic = false;
            }

            // Run delay logic.
            if( $this->delay_js && !is_admin() ) {
                
                // Enqueue assrts.
                if( $this->activate_logic ) {
                    add_action('nectar_hook_before_body_close', array($this, 'enqueue_scripts'), 20);
                    add_action('wp_enqueue_scripts', array($this, 'inline_css'), 20);
                }
                
                // Third party exclusions.
                $this->third_party_compatibility();

                // Allow top-level class to row when using full page screen rows.
                add_filter( 'nectar_using_header_section', array($this, 'nectar_header_section_check') );

                // Modifications to Salient scripts.
                add_filter( 'script_loader_tag', array($this,'mod_script_attrs'), 10 ,2 );
            }
        }

         /* Adds salient scripts to excluded
             list for various third party performnace plugins 
        */
        public function third_party_compatibility() {

            // Autooptimize - handled in mod_script_attrs 
            // WP Rocket - handled in mod_script_attrs
            // Litespeed Cache - handled in mod_script_attrs 
            // WP Asset Cleanup - handled in mod_script_attrs
            
            // W3 Total Cache  
            add_filter( 'w3tc_minify_js_script_tags', array($this, 'slice_excluded_scripts'), 10, 2); 

            // Siteground Optimizer 
            add_filter('sgo_js_minify_exclude', array($this, 'add_excluded_scripts'), 10);
            add_filter('sgo_javascript_combine_exclude', array($this, 'add_excluded_scripts'), 10);   
            
            // Clearify 
            add_filter('wmac_filter_js_dontmove', array($this, 'add_excluded_scripts'), 10); 
        }

        public function slice_excluded_scripts($scripts) {

            foreach($scripts as $key => $script) {

                foreach( $this->salient_scripts as $salient_script ) {
                    if(  strpos($script, $salient_script) !== false ) {
                        unset($scripts[$key]);
                    }
                }
            
                
            }

            return $scripts;
        }

        public function add_excluded_scripts($exclude_list) {

            foreach( $this->salient_scripts as $salient_script ) {
                $exclude_list[] = $salient_script;
            }

            return $exclude_list;
        }

        public function mod_script_attrs( $tag, $handle ){

            if ( in_array($handle, $this->salient_scripts) ) {
                
                $modded_js = str_replace( '<script', '<script data-pagespeed-no-defer data-nowprocket data-wpacu-skip data-no-optimize', $tag );

                if( $this->activate_logic ) {

                    // Chnage type.
                    $modded_js = preg_replace( '/type=(["\'])(.*?)\1/i', 'type="salientlazyscript" data-salient-lazy-$0', $modded_js, 1 );

                }
               
                return $modded_js; 
            }

            if( 'salient-delay-js' === $handle ) {

                $modded_js = str_replace( '<script', '<script data-pagespeed-no-defer data-nowprocket data-wpacu-skip data-no-optimize', $tag );
                return $modded_js;
            }

            return $tag;    
        }


        public function inline_css() {

            global $post;

            $critical_css = '';

            // Page header reveal.
            $page_header_text_effect = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_page_header_text-effect', true) : '';
		    if( 'rotate_in' === $page_header_text_effect ) {
                $critical_css .= '
                body #page-header-bg[data-text-effect="rotate_in"] .wraped span, 
                body .overlaid-content[data-text-effect="rotate_in"] .wraped span, 
                body #page-header-bg[data-text-effect="rotate_in"] .inner-wrap >*:not(.top-heading), 
                body .overlaid-content[data-text-effect="rotate_in"] .inner-wrap >*:not(.top-heading),
                body #page-header-bg[data-text-effect="rotate_in"] >div:not(.nectar-particles) .span_6 .inner-wrap >*:not(.top-heading) {
                    opacity: 1;
                    transform: none;
                }
                body #page-header-bg[data-text-effect="rotate_in"] .nectar-particles .inner-wrap:not(.shape-1) >*:not(.top-heading), 
                #ajax-content-wrap .overlaid-content[data-text-effect="rotate_in"] .inner-wrap:not(.shape-1) >*:not(.top-heading) {
                    opacity: 0;   
                }';
                
            }

            // Box roll.
            $page_header_box_roll = get_post_meta($post->ID, '_nectar_header_box_roll', true);
            if('on' === $page_header_box_roll ) {
                $critical_css .= '#ajax-content-wrap:not(.no-scroll):not(.at-content) #page-header-bg.fullscreen-header[data-alignment-v="middle"] .span_6 {
                    top: 0!important;
                }
                #ajax-content-wrap .scroll-down-wrap,
                #ajax-content-wrap #page-header-bg .nectar-particles .inner-wrap >*:not(.top-heading), 
                #ajax-content-wrap .overlaid-content .inner-wrap >*:not(.top-heading) {
                    opacity: 1;   
                    transform: none;
                }
                body #page-header-bg .nectar-particles .inner-wrap:not(.shape-1) >*:not(.top-heading), 
                #ajax-content-wrap .overlaid-content .inner-wrap:not(.shape-1) >*:not(.top-heading) {
                    opacity: 0;   
                }';
            }

            // First parallax BGs.
            $critical_css .= '.wpb_row.vc_row.top-level .column-image-bg-wrap[data-n-parallax-bg="true"] .column-image-bg,
            .wpb_row.vc_row.top-level + .wpb_row .column-image-bg-wrap[data-n-parallax-bg="true"] .column-image-bg,
            #portfolio-extra > .wpb_row.vc_row.parallax_section:first-child .row-bg {
                transform: none!important;  
                height: 100%!important;
                opacity: 1;
            }
            #portfolio-extra > .wpb_row.vc_row.parallax_section .row-bg {
                background-attachment: scroll;   
            }';

            // Fullscreen page header.
            $critical_css .= '.scroll-down-wrap.hidden {
                transform: none;
                opacity: 1;
            }';

            // Page transitions.
            $critical_css .= '#ajax-loading-screen[data-disable-mobile="0"] {
                display: none!important;
            }';

            // OCM 
            $critical_css .= 'body[data-slide-out-widget-area-style="slide-out-from-right"].material .slide_out_area_close.hide_until_rendered {
                opacity: 0;   
            }';


            // Masonry Blog/Portfolio.
            global $wp_styles;
            $enqueued_styles = array();
            foreach( $wp_styles->queue as $handle ) {
                $enqueued_styles[] = $handle;
            }

        
            // Portfolio.
            if(in_array('nectar-portfolio',$enqueued_styles)) {
                $critical_css .= $this->portfolio_grid_css();
            }

            
            wp_add_inline_style( 'main-styles', nectar_quick_minify($critical_css) );
        }


        public function enqueue_scripts() {

            $nectar_theme_version = nectar_get_theme_version();

            wp_enqueue_script(
                'salient-delay-js', 
                get_template_directory_uri() . '/js/build/nectar-delay-javascript.js', 
                array( 'jquery' ), 
                $nectar_theme_version, 
                true
            );

           
        }


        public function nectar_header_section_check($using_header_section) {
            return false;
        }


        /**
         * Initiator.
         */
        public static function get_instance()
        {
            if (!self::$instance) {
                self::$instance = new self;
            }
            return self::$instance;
        }



        public function portfolio_grid_css() {

            return '
            .portfolio-items[data-col-num="elastic"]:not(.fullwidth-constrained) {
                margin-left: -50vw;
                margin-left: calc(-50vw + var(--scroll-bar-w)/2)!important;
                left: 50%!important;
                width: 100vw;
                width: calc(100vw - var(--scroll-bar-w))!important;
            }

            @media only screen and (max-width: 999px) {
                .portfolio-items .col .inner-wrap[data-animation="fade_in"], 
                .portfolio-items:not(.carousel) .col .inner-wrap.animated {
                    transform: none;
                    opacity: 1;
                }
            }
            @media only screen and (min-width: 470px) and (max-width: 690px) {
                body .portfolio-items .col.elastic-portfolio-item.tall, 
                body .portfolio-items .col.elastic-portfolio-item.regular,
                body .portfolio-items .col.elastic-portfolio-item:not([class*="wide"]) {
                    width: 50%;
                }
            }

            @media only screen and (min-width: 691px) {
                
                body .portfolio-items {
                    display: flex;
                    flex-wrap: wrap;
                }

                body .portfolio-items .col.elastic-portfolio-item.tall, 
                body .portfolio-items .col.elastic-portfolio-item.regular,
                body .portfolio-items .col.elastic-portfolio-item:not([class*="wide"])  {
                    width: 50%;
                }
            }

            @media only screen and (min-width: 1000px) { 
                body .portfolio-items .col.elastic-portfolio-item.tall, 
                body .portfolio-items .col.elastic-portfolio-item.regular {
                    width: 33.3%;
                }
            }
            ';
        }

    }
}

$nectar_delay_js = NectarDelayJS::get_instance();