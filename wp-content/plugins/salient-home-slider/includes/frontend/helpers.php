<?php


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Edit columns for Home Slider
 *
 * @since 1.0
 */
add_filter( 'manage_edit-home_slider_columns', 'edit_columns_home_slider' );

if( !function_exists('edit_columns_home_slider') ) {
	function edit_columns_home_slider( $columns ) {
		$column_thumbnail = array( 'thumbnail' => 'Thumbnail' );
		$column_caption   = array( 'caption' => 'Caption' );
		$columns          = array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
		$columns          = array_slice( $columns, 0, 2, true ) + $column_caption + array_slice( $columns, 2, null, true );
		return $columns;
	}
}


add_action( 'manage_home_slider_posts_custom_column', 'home_slider_custom_columns', 10, 2 );

/**
 * Add content to edit columns for Home Slider
 *
 * @since 1.0
 */
if( !function_exists('home_slider_custom_columns') ) {
	function home_slider_custom_columns( $portfolio_columns, $post_id ) {

		switch ( $portfolio_columns ) {
			case 'thumbnail':
				$thumbnail = get_post_meta( $post_id, '_nectar_slider_image', true );

				if ( ! empty( $thumbnail ) ) {
					echo '<a href="' . esc_url( get_admin_url() ) . 'post.php?post=' . $post_id . '&action=edit"><img class="slider-thumb" src="' . $thumbnail . '" /></a>';
				} else {
					echo '<a href="' . esc_url( get_admin_url() ) . 'post.php?post=' . $post_id . '&action=edit"><img class="slider-thumb" src="' . SALIENT_HOME_SLIDER_PLUGIN_PATH . '/img/slider-default-thumb.jpg" /></a>' .
						 '<strong><a class="row-title" href="' . esc_url( get_admin_url() ) . 'post.php?post=' . $post_id . '&action=edit">No image added yet</a></strong>';
				}
				break;

			case 'caption':
				$caption = get_post_meta( $post_id, '_nectar_slider_caption', true );
				echo wp_kses_post( $caption );
				break;

			default:
				break;
		}
	}
}


add_action( 'admin_menu', 'nectar_home_slider_ordering' );

/**
 * Add Home Slider "order" submenu.
 *
 * @since 1.0
 */
if( !function_exists('nectar_home_slider_ordering') ) {
	function nectar_home_slider_ordering() {
		add_submenu_page(
			'edit.php?post_type=home_slider',
			'Order Slides',
			'Order',
			'edit_pages',
			'slide-order',
			'nectar_home_slider_order_page'
		);
	}
}


/**
 * Home Slider "order" page content
 *
 * @since 1.0
 */
if( !function_exists('nectar_home_slider_order_page') ) {
	function nectar_home_slider_order_page(){ ?>
		
		<div class="wrap">
			<h2><?php echo esc_html__( 'Sort Slides', 'salient-home-slider' ); ?></h2>
			<p><?php echo esc_html__( 'Simply drag the slide up or down and they will be saved in that order.', 'salient-home-slider' ); ?></p>
		<?php
		$slides = new WP_Query(
			array(
				'post_type'      => 'home_slider',
				'posts_per_page' => -1,
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
			)
		);
		?>
		<?php if ( $slides->have_posts() ) : ?>
			
			<?php wp_nonce_field( basename( __FILE__ ), 'nectar_meta_box_nonce' ); ?>
			
			<table class="wp-list-table widefat fixed posts" id="sortable-table">
				<thead>
					<tr>
						<th class="column-order"><?php echo esc_html__( 'Order', 'salient-home-slider' ); ?></th>
						<th class="manage-column column-thumbnail"><?php echo esc_html__( 'Image', 'salient-home-slider' ); ?></th>
						<th class="manage-column column-caption"><?php echo esc_html__( 'Caption', 'salient-home-slider' ); ?></th>
					</tr>
				</thead>
				<tbody data-post-type="home_slider">
				<?php
				while ( $slides->have_posts() ) :
					$slides->the_post();
					?>
					<tr id="post-<?php the_ID(); ?>">
						<td class="column-order"><img src="<?php echo SALIENT_HOME_SLIDER_PLUGIN_PATH . '/img/sortable.png'; ?>" alt="Move Icon" width="25" height="25" class="" /></td>
						<td class="thumbnail column-thumbnail">
							<?php
							global $post;
							$thumbnail = get_post_meta( $post->ID, '_nectar_slider_image', true );

							if ( ! empty( $thumbnail ) ) {
								echo '<img class="slider-thumb" src="' . $thumbnail . '" />';
							} else {
								echo '<img class="slider-thumb" src="' . SALIENT_HOME_SLIDER_PLUGIN_PATH . '/img/slider-default-thumb.jpg" />' .
									 '<strong>No image added yet</strong>';
							}
							?>
							
						</td>
						<td class="caption column-caption">
							<?php
							$caption = get_post_meta( $post->ID, '_nectar_slider_caption', true );
							echo wp_kses_post( $caption );
							?>
						</td>
					</tr>
				<?php endwhile; ?>
				</tbody>
				<tfoot>
					<tr>
						<th class="column-order"><?php echo esc_html__( 'Order', 'salient-home-slider' ); ?></th>
						<th class="manage-column column-thumbnail"><?php echo esc_html__( 'Image', 'salient-home-slider' ); ?></th>
						<th class="manage-column column-caption"><?php echo esc_html__( 'Caption', 'salient-home-slider' ); ?></th>
					</tr>
				</tfoot>

			</table>

		<?php else : ?>

			<p><?php echo esc_html__('No slides found, why not', 'salient-home-slider') . ' <a href="' . esc_url( admin_url('post-new.php?post_type=home_slider') ) .'">' . esc_html__('create one?', 'salient-home-slider') .'</a>'; ?></p>

		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

		</div><!-- .wrap -->
		
		<?php
	}
}


add_action( 'admin_enqueue_scripts', 'home_slider_enqueue_scripts' );

/**
 * Home Slider enqueue admin assets.
 *
 * @since 1.0
 */
if( !function_exists('home_slider_enqueue_scripts') ) {
	function home_slider_enqueue_scripts() {
		global $typenow;
		if ( 'home_slider' === $typenow ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'nectar-reorder', SALIENT_HOME_SLIDER_PLUGIN_PATH . '/includes/assets/js/nectar-reorder.js' );
		}
		wp_register_script( 'chosen', SALIENT_HOME_SLIDER_PLUGIN_PATH . '/includes/assets/js/chosen/chosen.jquery.min.js', array( 'jquery' ), '8.0.1', true );
		wp_register_style( 'chosen', SALIENT_HOME_SLIDER_PLUGIN_PATH . '/includes/assets/css/chosen/chosen.css', array(), '8.0.1', 'all' );
		wp_enqueue_style( 'chosen' );
		wp_enqueue_script( 'chosen' );
	}
}


add_action( 'wp_ajax_nectar_update_slide_order', 'nectar_update_slide_order' );

/**
 * Home Slider update order callback.
 *
 * @since 1.0
 */
if( !function_exists('nectar_update_slide_order') ) {
	function nectar_update_slide_order() {

			global $wpdb;

			$post_type = sanitize_text_field( $_POST['postType'] );
			$order     = isset( $_POST['order'] ) ? (array) $_POST['order'] : array();
			$order     = array_map( 'esc_attr', $order );

		if ( ! isset( $_POST['nectar_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['nectar_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		foreach ( $order as $menu_order => $post_id ) {
			$post_id    = intval( str_ireplace( 'post-', '', $post_id ) );
			$menu_order = intval( $menu_order );

			wp_update_post(
				array(
					'ID'         => stripslashes( htmlspecialchars( $post_id ) ),
					'menu_order' => stripslashes( htmlspecialchars( $menu_order ) ),
				)
			);
		}

			die( '1' );
	}
}

/**
 * set the Home Slider order in admin correctly.
 *
 * @since 1.0
 */
if( !function_exists('set_home_slider_admin_order') ) {
	function set_home_slider_admin_order( $wp_query ) {

		$post_type = ( isset( $wp_query->query['post_type'] ) ) ? $wp_query->query['post_type'] : '';

		if ( $post_type === 'home_slider' ) {

			$wp_query->set( 'orderby', 'menu_order' );
			$wp_query->set( 'order', 'ASC' );
		}

	}
}

if ( is_admin() ) {
	add_filter( 'pre_get_posts', 'set_home_slider_admin_order' );
}
