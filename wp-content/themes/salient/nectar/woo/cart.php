<?php
/**
 * Salient WooCommerce Cart
 *
 * @package Salient WordPress Theme
 * @version 13.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists('Nectar_Woo_Cart') ) {
	
	class Nectar_Woo_Cart {

	  private static $instance;

	  private function __construct() {

	      $this->hooks();

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

	  /**
		 * Adds actions/filters.
		 */
	  public function hooks() {

	    global $nectar_options;

	    // Empty Mini Cart Content.
	    if( isset($nectar_options['ajax-cart-style']) &&
	        'slide_in_click' === $nectar_options['ajax-cart-style'] ) {
	      add_action( 'woocommerce_after_mini_cart', array($this, 'empty_minicart_buttons'), 10);
	    }


			// Mini Cart QTY AJAX.
	    add_action( 'wp_ajax_nectar_minicart_update_quantity', array($this, 'update_cart_quantity' ) );
	    add_action( 'wp_ajax_nopriv_nectar_minicart_update_quantity', array($this, 'update_cart_quantity' ) );

			// Single Product AJAX Add to Cart
			if( isset($nectar_options['ajax-add-to-cart']) && '1' === $nectar_options['ajax-add-to-cart']) {

				add_action( 'wp_ajax_nectar_ajax_add_to_cart', array($this, 'add_to_cart' ) );
		    add_action( 'wp_ajax_nopriv_nectar_ajax_add_to_cart', array($this, 'add_to_cart' ) );

			}

	  }


	  /**
		 * Adds in the WooCommerce minicart buttons
	   * even when the cart is empty.
		 */
	  public static function empty_minicart_buttons() {

			if( WC()->cart->is_empty() ) {

				echo '<div class="nectar-inactive"><p class="woocommerce-mini-cart__total total">';
					do_action( 'woocommerce_widget_shopping_cart_total' );
				echo '</p>';

				do_action('woocommerce_widget_shopping_cart_buttons');
				echo '</div>';
			}

		}

	  /**
		 * AJAX callback to update the minicart quantity.
		 */
	  public static function update_cart_quantity() {

			if( !isset($_POST['quantity']) || !isset($_POST['item_key']) || !function_exists('WC') ) {
				wp_die();
			}

			$quantity = absint( $_POST['quantity'] );
			$item_key = sanitize_text_field( $_POST['item_key'] );

	    WC()->cart->set_quantity( $item_key, $quantity );

			wp_send_json( array(
	      'item' => WC()->cart->get_cart_item($item_key),
	      'subtotal' => WC()->cart->get_cart_subtotal(),
	      'item_count' => WC()->cart->get_cart_contents_count()
	    ) );

	    wp_die();

	  }

		/**
		 * AJAX callback for add to cart.
		 */
		 public static function add_to_cart() {

			 if( !isset($_POST['add-to-cart']) || !function_exists('WC') ) {
				 wp_die();
			 }

			 // Triggers WooCommerce to add to the cart.
			 $product_id = absint( $_POST['add-to-cart'] );

			 // Check for errors to output.
			 $error_notices = wc_get_notices('error');
			 wc_clear_notices();

			 if( empty($error_notices) ) {
				 do_action( 'woocommerce_ajax_added_to_cart', $product_id );
			 }

			 // Get updated fragments.
			 ob_start();
			 woocommerce_mini_cart();
			 $mini_cart = ob_get_clean();

			 $data = array(
				 'fragments' => apply_filters(
					 'woocommerce_add_to_cart_fragments',
					 array(
						 'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
					 )
				 ),
				 'cart_hash' => WC()->cart->get_cart_hash(),
				 'notices' => $error_notices
			 );

			 // Send the data.
			 wp_send_json( $data );

			 wp_die();

		 }


	}
	
}

/**
 * Initialize the Nectar_Woo_Cart class
 */
Nectar_Woo_Cart::get_instance();
