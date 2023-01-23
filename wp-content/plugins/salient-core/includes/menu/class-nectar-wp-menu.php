<?php
/**
 * Nectar Menu
 *
 * Adds custom functionality to Menus
 * section of the WP admin
 *
 * @package Salient Core
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists('NectarWPMenu') ) {

  class NectarWPMenu {

    private static $instance;

    public function __construct() {

			if( current_user_can('administrator') ) {
      	add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_assets' ) );
				add_action( 'admin_footer', array( $this, 'nectar_menu_item_modal_markup' ) );
			}

			add_action( 'wp_ajax_nectar_menu_item_settings', array($this, 'nectar_menu_item_settings' ) );
			add_action( 'wp_ajax_nectar_menu_item_settings_save', array($this, 'nectar_menu_item_settings_save' ) );


    }

    /**
		 * Initiator.
		 */
	  public static function get_instance() {
			if ( !self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

    public function enqueue_assets($hook) {

			global $Salient_Core;

      if ($hook === 'nav-menus.php') {

        // JS
        wp_register_script( 'nectar-admin-wp-menu', SALIENT_CORE_PLUGIN_PATH . '/includes/menu/js/nectar-menu-admin.js', array( 'jquery' ), $Salient_Core->plugin_version);

			  //// Translations.
				$translation_arr = array(
          'edit_button_text' => esc_html__( 'Salient Menu Item Options', 'salient-core' ),
					'saving' => esc_html__( 'Saving...', 'salient-core' ),
					'error' => esc_html__( 'Error Saving', 'salient-core' ),
					'success' => esc_html__( 'Saved Successfully', 'salient-core' ),
        );
        wp_localize_script( 'nectar-admin-wp-menu', 'nectar_menu_i18n', $translation_arr );


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
				//// Localize.
				wp_localize_script( 'nectar-admin-wp-menu', 'nectar_menu',
					array(
						'ajaxurl' => admin_url('admin-ajax.php'),
						'nonce'   => wp_create_nonce('nectar_menu_settings_ajax_nonce'),
						'colors'  => $color_arr
					)
				);

        wp_enqueue_script( 'nectar-admin-wp-menu' );

        // CSS
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome-legacy.min.css'); 
				wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'nectar-admin-wp-menu', SALIENT_CORE_PLUGIN_PATH . '/includes/menu/css/nectar-menu-admin.css', '', $Salient_Core->plugin_version );

      } // Endif on nav-menus.

    }

		/**
		 * Get settings.
		 */
		public function nectar_menu_item_settings() {

			// Access Level.
			if( !current_user_can('administrator') ) {
					die ( 'Only an administrator can access these settings.');
      }

			// Verify Nonce.
    	$nonce = $_POST['nonce'];

    	if ( ! wp_verify_nonce( $nonce, 'nectar_menu_settings_ajax_nonce' ) ) {
        die ( 'Invalid Nonce!');
			}

			// Grab post.
			$parent_id       = (int) sanitize_text_field( $_POST['parent_id'] );
			$menu_item_depth = (int) sanitize_text_field( $_POST['menu_item_depth'] );
			$menu_item_id    = (int) sanitize_text_field( $_POST['menu_item_id'] );

			$nectar_menu_item_settings = Nectar_WP_Menu_Settings::get_settings();

			foreach( $nectar_menu_item_settings as $id => $field ) {

				$max_depth = isset($field['max_depth']) ? (int) $field['max_depth'] : 100;
				$min_depth = isset($field['min_depth']) ? (int) $field['min_depth'] : 0;

				if( $menu_item_depth > $max_depth && -1 !== $max_depth ||
				    $menu_item_depth < $min_depth ) {
					continue;
				}

		    $options = maybe_unserialize( get_post_meta( $menu_item_id, 'nectar_menu_options', true ) );

				$value = ( isset($options[$id]) ) ? $options[$id] : false;

				if( !$value ) {
					$value = ( isset( $field['default_value'] ) ) ? $field['default_value'] : null;
				}

		    new Nectar_Setting_Field( $id, $field, $value );
		  }

			wp_die();

		}

		/**
		 * Save.
		 */
		public function nectar_menu_item_settings_save() {

			$result = array();

			// Access Level.
			if( !current_user_can('administrator') ) {

				$result['type'] = 'fail';
				wp_send_json($result);

				die ( 'Only an administrator can access these settings.');

			}

			// Verify Nonce.
			$nonce = $_POST['nonce'];

    	if ( ! wp_verify_nonce( $nonce, 'nectar_menu_settings_ajax_nonce' ) ) {

				$result['type'] = 'fail';
				wp_send_json($result);

        die ( 'Invalid Nonce!');
			}


			// Sanitize and get setup data for saving.
			$menu_id = (int) sanitize_text_field( $_POST['id'] );

			$menu_options = array();

			/*
			Widget area options
			'menu_item_widget_area'                   => 'regular',
			'menu_item_widget_area_marign'            => 'regular',*/

			$options_arr = array(
				'enable_mega_menu'                        => 'regular',
				'mega_menu_width'                         => 'regular',
				'mega_menu_alignment'                     => 'regular',
				'disable_mega_menu_title'                 => 'regular',
				'mega_menu_bg_img'                        => 'array',
				'mega_menu_bg_img_alignment'              => 'regular',
				'mega_menu_padding'                       => 'default',
				'menu_item_column_width'                  => 'regular',
			  'menu_item_column_padding'                => 'regular',
				'menu_item_column_bg_color'               => 'regular',
				'menu_item_bg_img'                        => 'array',
				'menu_item_bg_img_alignment'              => 'regular',
				'menu_item_icon_type'                     => 'regular',
				'menu_item_icon_custom'                   => 'array',
				'menu_item_icon'                          => 'regular',
        'menu_item_icon_iconsmind'                => 'regular',
				'menu_item_icon_custom_border_radius'     => 'regular',
				'menu_item_link_bg_type'                  => 'regular',
				'menu_item_link_bg_img_custom'            => 'array',
				'menu_item_link_height'                   => 'array',
				'menu_item_link_content_alignment'        => 'regular',
				'menu_item_link_label'                    => 'regular',
				'menu_item_link_color_overlay'            => 'regular',
				'menu_item_link_color_overlay_fade'       => 'regular',
				'menu_item_link_color_overlay_opacity'    => 'array',
				'menu_item_link_typography'               => 'regular',
				'menu_item_link_text_color_type'          => 'regular',
				'menu_item_link_coloring_custom_text'     => 'regular',
				'menu_item_link_coloring_custom_text_h'   => 'regular',
				'menu_item_link_coloring_custom_desc'     => 'regular',
				'menu_item_link_coloring_custom_text_p'   => 'regular',
				'menu_item_link_coloring_custom_text_h_p' => 'regular',
				'menu_item_link_coloring_custom_label'    => 'regular',
				'menu_item_link_bg_hover'                 => 'regular',
				'menu_item_link_bg_style'                 => 'regular',
				'menu_item_link_padding'                  => 'regular',
				'menu_item_link_border_radius'            => 'regular',
				'menu_item_link_margin'                   => 'array',
				'menu_item_icon_position'                 => 'regular',
				'menu_item_icon_size'                     => 'regular',
				'menu_item_hide_menu_title'               => 'regular',
				'menu_item_icon_custom_text'              => 'regular',
				'menu_item_icon_spacing'                  => 'regular',
				'menu_item_persist_mobile_header'         => 'regular',
				'menu_item_hide_menu_title_modifier'      => 'regular',
		'menu_item_link_link_style'               => 'regular',
		'menu_item_link_link_text_style'               => 'regular',
        'menu_item_ocm_image'                     => 'array'
			);

			foreach ($options_arr as $param_name => $type) {

				if( isset($_POST['options'][$param_name]) &&
				    !empty($_POST['options'][$param_name]) ) {

					// Array Values.
					if( 'array' === $type ) {

						if( isset($_POST['options'][$param_name]) && is_array($_POST['options'][$param_name]) ) {

							$menu_options[$param_name] = array();

							foreach ($_POST['options'][$param_name] as $key => $value) {
								$menu_options[$param_name][sanitize_key($key)] = sanitize_text_field($value);
							}

						}

					}
					// Regular Values.
					else {

						// Encoded.
						if( 'menu_item_icon_custom_text' === $param_name ) {
							$menu_options[$param_name] = urlencode( sanitize_text_field( $_POST['options'][$param_name] ) );
						} else {
							$menu_options[$param_name] = sanitize_text_field( $_POST['options'][$param_name] );
						}

					}

				} // End option isset.

			}


			update_post_meta($menu_id, 'nectar_menu_options', $menu_options);

			// Generate and write CSS.
			Nectar_WP_Menu_Style_Manager::write_css();


			$result['type'] = 'success';
			wp_send_json($result);

			wp_die();

		}


		/**
		 * Modal Markup
		 */
		public function nectar_menu_item_modal_markup() {

			if( !function_exists('get_current_screen') ) {
				return;
			}

			$current_screen = get_current_screen();

			if ( $current_screen && property_exists( $current_screen, 'base') ) {
				if ( 'nav-menus' === $current_screen->base ) {
					echo '<div id="nectar-menu-settings-modal-wrap" class="loading">
					<div id="nectar-menu-settings-modal">
					<div class="header">
						<div class="row">
							<h2>"<span class="menu-item-name"></span>" '.esc_html__('Options','salient-core').'</h2>
							<div class="categories">
								<a href="#" data-rel="mega-menu"><span>'.esc_html__('Mega Menu', 'salient-core').'</span></a>
								<a href="#" data-rel="menu-item"><span>'.esc_html__('Menu Item', 'salient-core').'</span></a>
								<a href="#" data-rel="menu-icon"><span>'.esc_html__('Icon', 'salient-core').'</span></a>
							</div>
							<a href="#" class="close-modal"><div class="dashicons dashicons-no-alt"></div></a>
						</div>
					</div>
					<div class="nectar-menu-settings-inner">
						<form class="menu-options-form"></form>
					</div>
					<div class="bottom-controls">
						<a href="#" class="close-modal">'.esc_html__('Close','salient-core').'</a>
						<a href="#" class="save">
							<span class="inner">
								<span class="default">'.esc_html__('Save Changes','salient-core').'</span>
								<span class="dynamic"></span>
							</span>
						</a>
					</div>
					<div class="loading-wrap"><div class="dashicons dashicons-admin-generic"></div></div>
					</div>
					<div id="nectar-menu-settings-overlay"></div>
					</div>';
				}
			}

		}

  }

  // Init class.
  NectarWPMenu::get_instance();

}
