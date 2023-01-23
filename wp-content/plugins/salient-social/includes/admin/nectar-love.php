<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NectarLove {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_nectar-love', array( &$this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_nectar-love', array( &$this, 'ajax' ) );
	}

	function enqueue_scripts() {

		wp_enqueue_script( 'jquery' );

	}
	

	function ajax( $post_id ) {

		// update
		if ( isset( $_POST['loves_id'] ) ) {
			$loves_id = sanitize_text_field( $_POST['loves_id'] );
			$post_id  = str_replace( 'nectar-love-', '', $loves_id );
			echo $this->love_post( $post_id, 'update' ); // WPCS: XSS ok.
		}

		// get
		else {
			$loves_id = sanitize_text_field( $_POST['loves_id'] );
			$post_id  = str_replace( 'nectar-love-', '', $loves_id );
			echo $this->love_post( $post_id, 'get' ); // WPCS: XSS ok.
		}

		exit;
	}


	function love_post( $post_id, $action = 'get' ) {
		if ( ! is_numeric( $post_id ) ) {
			return;
		}

		switch ( $action ) {

			case 'get':
				$love_count = get_post_meta( $post_id, '_nectar_love', true );
				if ( ! $love_count ) {
					$love_count = 0;
					add_post_meta( $post_id, '_nectar_love', $love_count, true );
				}

				return '<span class="nectar-love-count">' . esc_html( $love_count ) . '</span>';
			break;

			case 'update':
				if ( ! isset( $_POST['love_nonce'] ) ) {
					return;
				}

				$love_count = get_post_meta( $post_id, '_nectar_love', true );
				if ( isset( $_COOKIE[ 'nectar_love_' . $post_id ] ) ) {
					return esc_html( $love_count );
				}

				$love_count++;
				update_post_meta( $post_id, '_nectar_love', $love_count );
				setcookie( 'nectar_love_' . $post_id, $post_id, time() * 20, '/' );

				return '<span class="nectar-love-count">' . esc_html( $love_count ) . '</span>';
			break;

		}
	}


	function add_love() {
		global $post;

		$output = $this->love_post( $post->ID );

		$class = 'nectar-love';
		$title = esc_html__( 'Love this', 'salient-social' );
		if ( isset( $_COOKIE[ 'nectar_love_' . $post->ID ] ) ) {
			$class = 'nectar-love loved';
			$title = esc_html__( 'You already love this!', 'salient-social' );
		}


		$heart_icon = '<i class="icon-salient-heart-2"></i>';

		if ( isset( $_COOKIE[ 'nectar_love_' . $post->ID ] ) ) {
			$heart_icon = '<i class="icon-salient-heart-2 loved"></i>';
		}

		return '<a href="#" class="' . esc_attr($class) . '" id="nectar-love-' . $post->ID . '" title="' . esc_attr($title) . '"> ' . $heart_icon . '<span class="love-text">' . esc_html__( 'Love', 'salient-social' ) . '</span><span class="total_loves">' . $output . '</span></a>';

	}

}


global $nectar_love;
$nectar_love = new NectarLove();

// get the ball rollin'
if( !function_exists('nectar_love') ) {
	
	function nectar_love( $return = '' ) {

		global $nectar_love;

		if ( $return === 'return' ) {
			return $nectar_love->add_love();
		} else {
			echo $nectar_love->add_love(); // WPCS: XSS ok.
		}

	}
	
}

