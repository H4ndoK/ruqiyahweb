<?php
/**
 * Nectar Widget Locations
 *
 *
 * @package Salient Core
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists('NectarWidgetLocations') ) {

  class NectarWidgetLocations {

    private static $instance;
    private static $is_visible = false;
		private static $locations = array();

    /**
    * Initiator.
    */
    public static function get_instance() {
      if ( !self::$instance ) {
        self::$instance = new self;
      }
      return self::$instance;
    }

    /**
    * Singleton Constructor.
    */
    private function __construct() {

			// Get data.
			add_action( 'after_setup_theme', array( $this, 'get_custom_widget_locations' ), 10 );
			add_action( 'sidebar_admin_setup', array( $this, 'get_custom_widget_visibility' ) );

			// Register widget locations.
			add_action( 'widgets_init', array( $this, 'register_custom_widget_locations' ), 20 );

      if ( is_admin() ) {

				if( current_user_can('administrator') ) {
					add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_assets' ) );
	        add_action( 'widgets_admin_page', array( $this, 'custom_widget_location_content' ), 9);
				}

				// Save.
				add_action( 'wp_ajax_nectar_custom_widget_locations_save', array($this, 'save_custom_widget_locations' ) );
				add_action( 'wp_ajax_nectar_custom_widget_locations_vis_save', array($this, 'save_custom_widget_locations_visibility' ) );

				// Remove.
				add_action( 'wp_ajax_nectar_custom_widget_location_remove', array($this, 'remove_custom_widget_location' ) );
      }

    }

		/**
		* Enqueue assets.
		*/
		public function enqueue_assets($hook) {

			global $Salient_Core;

			if ($hook === 'widgets.php') {
				// JS
				wp_register_script( 'nectar-admin-wp-widget-locations', SALIENT_CORE_PLUGIN_PATH . '/includes/widget-locations/js/nectar-widget-locations-admin.js', array( 'jquery' ), $Salient_Core->plugin_version );

				//// Translations.
				wp_localize_script( 'nectar-admin-wp-widget-locations', 'nectar_widgets_i18n', array(
				 	'confirm_delete' => esc_html__( 'Are you sure you want to delete this widget location?', 'salient-core' )
					)
				);

				//// Nonce.
				wp_localize_script( 'nectar-admin-wp-widget-locations', 'nectar_widgets',
					array(
						'ajaxurl' => admin_url('admin-ajax.php'),
						'nonce'   => wp_create_nonce('nectar_custom_widget_locations_ajax_nonce')
					)
				);

        wp_enqueue_script( 'nectar-admin-wp-widget-locations' );

				// CSS
				wp_enqueue_style( 'nectar-admin-wp-widget-locations', SALIENT_CORE_PLUGIN_PATH . '/includes/widget-locations/css/nectar-widget-locations-admin.css', '', $Salient_Core->plugin_version );

			}

		}


		/**
		* Registers sidebar areas.
		*/
		public function register_custom_widget_locations() {

			if( empty(self::$locations) ) {
				return;
			}

			foreach (self::$locations as $key => $location) {

				register_sidebar(
					array(
						'name'          => esc_html(stripslashes($location['name'])),
						'id'            => sanitize_title_with_dashes($location['id']),
						'description'   => esc_html(stripslashes($location['desc'])),
						'before_widget' => '<div id="%1$s" class="widget %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h4>',
						'after_title'   => '</h4>',
					)
				);
			}

		}


		/**
		* Get visibility.
		*/
		public function get_custom_widget_visibility() {

			$visible = get_option( 'salient_custom_widget_locations_visible', false );
			if( !$visible || 'true' === $visible ) {
				self::$is_visible = true;
			}
		}

		/**
		* Get locations.
		*/
		public function get_custom_widget_locations() {

			$custom_locations = '';
			$widget_locations = get_option( 'salient_custom_widget_locations', array() );

			// Ensure it's always an arr.
			if ( ! is_array( $widget_locations ) ) {
				$widget_locations = array();
			}

			self::$locations = $widget_locations;

		}


		/**
		* Save visibility.
		*/
		public function save_custom_widget_locations_visibility() {

			// Access Level.
			if( !current_user_can('administrator') ) {
					die ( 'Only an administrator can access these settings.');
			}

			// Verify Nonce.
			$nonce = $_POST['nonce'];

			if ( ! wp_verify_nonce( $nonce, 'nectar_custom_widget_locations_ajax_nonce' ) ) {
				die ( 'Invalid Nonce!');
			}

			$visible = ( 'true' === sanitize_text_field($_POST['open']) ) ? 'true' : '';

			update_option( 'salient_custom_widget_locations_visible', $visible );

			wp_die();

    }

		/**
		* Save locations.
		*/
		public function save_custom_widget_locations() {

			$return = array();

			// Access Level.
			if( !current_user_can('administrator') ) {

					$return['message'] = esc_html__('Only an administrator can access these settings.','salient-core');
					wp_send_json($return);

					wp_die();
			}

			// Verify Nonce.
			$nonce = $_POST['nonce'];

			if ( ! wp_verify_nonce( $nonce, 'nectar_custom_widget_locations_ajax_nonce' ) ) {

				$return['message'] = esc_html__('Invalid Nonce','salient-core');
				wp_send_json($return);

				wp_die();
			}

			$name = sanitize_text_field( $_POST['name'] );
			$desc = sanitize_text_field( $_POST['desc'] );

			foreach (self::$locations as $key => $location) {
				// If a location already exists, skip.
				if( isset($location['name']) && $name === $location['name'] ) {

					$return['message'] = esc_html__('Location already exists','salient-core');
					wp_send_json($return);

					wp_die();
				}

			}

			// Update.
			self::$locations[] = array(
				'name' => $name,
				'desc' => $desc,
				'id' => 'salient-'.sanitize_title_with_dashes($name)
			);

			update_option( 'salient_custom_widget_locations', self::$locations );

			$return['message'] = 'success';
			wp_send_json($return);

			wp_die();

		}

		/**
		* Remove a single location.
		*/
		public function remove_custom_widget_location() {

			$return = array();

			// Access Level.
			if( !current_user_can('administrator') ) {

					$return['message'] = esc_html__('Only an administrator can access these settings.','salient-core');
					wp_send_json($return);

					wp_die();
			}

			// Verify Nonce.
			$nonce = $_POST['nonce'];

			if ( ! wp_verify_nonce( $nonce, 'nectar_custom_widget_locations_ajax_nonce' ) ) {

				$return['message'] = esc_html__('Invalid Nonce!','salient-core');
				wp_send_json($return);

				wp_die();
			}

			$id = sanitize_text_field( $_POST['id'] );


			foreach( self::$locations as $key => $location ) {
				if( $id === $location['id'] ) {
					unset( self::$locations[$key] );
				}
			}
			self::$locations = array_values(self::$locations);

			update_option( 'salient_custom_widget_locations', self::$locations );

			$return['message'] = 'success';
			wp_send_json($return);

			wp_die();

    }


	  /**
	  * Markup.
	  */
    public function custom_widget_location_content() {

			$closed_class = ( self::$is_visible ) ? '' : ' closed';
			$location_num_class = '';

			if( count(self::$locations) == 0 ) {
				$location_num_class = ' no-locations';
			} else if( count(self::$locations) == 1 ) {
				$location_num_class = ' single-location';
			}


      echo '<div class="nectar-custom-widget-locations'.esc_attr($closed_class).'">
				<h2>'.esc_html__('Salient Custom Widget Locations').'<button type="button" class="toggle-button"><span class="toggle-indicator"></span></button></h2>
				<div class="inner-wrap">
				<p>'.esc_html__('You can use the form below to add new custom widget locations. These locations can then be called in the page builder through the "Widgetised Sidebar" element, or through assigning them to mega menus in Appearence > Menus.','salient-core').'</p>
				<div class="inner">
				<div class="left">
					<h4>'.esc_html__('Add New Widget Location','salient-core').'</h4>
					<form class="nectar-user-defined-widget-locations">
						<span>
							<label for="widget_location_name">'.esc_html__('Location Name','salient-core').'</label>
							<input type="text" id="widget_location_name" name="widget_location_name" />
						</span>
						<span>
							<label for="widget_location_desc">'.esc_html__('Location Description','salient-core').'</label>
							<input type="text" id="widget_location_desc" name="widget_location_desc" />
						</span>
						<span>
							<button type="button" class="add-new-button">
							<span>
								<span>'.esc_html__('Add New Location','salient-core').'</span>
								<span>'.esc_html__('Saving...','salient-core').'</span>
							</span>
							</button>
						</span>
					</form>
				</div>

					<div class="right">
						<h4>'.esc_html__('Custom Locations','salient-core').'</h4>
			      <div class="custom-widget-location-list'.$location_num_class .'">
							'.$this->custom_widget_location_grid_content().'
						</div>
					</div>

			   </div>
				</div>
      </div>';
    }

		public function custom_widget_location_grid_content() {

			$custom_locations = '';

			if( !empty(self::$locations) ) {
				foreach (self::$locations as $key => $location) {
					$custom_locations .= '<div class="location" data-id="'.esc_html($location['id']).'">
						<div class="icon"></div>
						<h3>'.esc_html(stripslashes($location['name'])).'</h3>
						<span>'.esc_html(stripslashes($location['desc'])).'</span>
						<a href="#" class="remove"><span class="dashicons dashicons-no-alt"></span>'.esc_html__('Remove','salient-core').'</a>
					</div>';
				}
			}

			else {
				$custom_locations = '<div class="no-locations">
				<h3>'.esc_html__('No Custom Locations Defined','salient-core').'</h3>
				<span>'.esc_html__('You can add some using the form on your left.','salient-core').'</span>
				</div>';
			}

			return $custom_locations;

		}


  }

  /**
  * Initialize
  */
  NectarWidgetLocations::get_instance();

}
