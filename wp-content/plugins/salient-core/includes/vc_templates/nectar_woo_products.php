<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop;

extract( shortcode_atts( array(
	'product_type' => 'all',
	'per_page' 	=> '12',
	'columns' 	=> '4',
	'carousel' 	=> 'false',
	'category' 	=> 'all',
	'controls_on_hover' => 'false',
	'orderby' => 'date',
	'order' => 'DESC',
	'pagination' => '',
	'script' => 'carouFredSel',
	'flickity_controls' => 'bottom-pagination',
	'flickity_heading_tag' => 'h2',
	'flickity_heading_text' => '',
	'flickity_link_text' => '',
	'flickity_link_url' => '',
	'flickity_wrap' => '',
	'flickity_item_animation' => 'none',
	'flickity_mobile_column_width' => '100%',
	'flickity_overflow' => '',
	'flickity_image_scale_on_drag' => '',
	'flickity_group_cells' => 'default',
	'item_shadow' => '',
	'autorotate' => '',
	'autorotation_speed' => '5000'
), $atts ) );

// Incase only all was selected.
if( $category === 'all' ) {
	$category = null;
}

if( $product_type === 'all' ) {

	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'orderby'             => $orderby,
		'order'               => $order,
		'posts_per_page' 		  => $per_page,
		'product_cat'         => $category,
		'meta_query'          => WC()->query->get_meta_query(),
		'tax_query'           => WC()->query->get_tax_query(),
	);

}
else if( $product_type === 'sale') {

	$args = array(
		'posts_per_page'	=> $per_page,
		'no_found_rows'  => 1,
		'orderby'        => $orderby,
		'order'          => $order,
		'post_status'    => 'publish',
		'post_type'      => 'product',
		'product_cat'    => $category,
		'meta_query'     => WC()->query->get_meta_query(),
		'tax_query'      => WC()->query->get_tax_query(),
		'post__in'       => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
	);

}
else if( $product_type === 'featured' ) {

	$meta_query  = WC()->query->get_meta_query();
	$tax_query   = WC()->query->get_tax_query();
	$tax_query[] = array(
		'taxonomy' => 'product_visibility',
		'field'    => 'name',
		'terms'    => 'featured',
		'operator' => 'IN',
	);

	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'orderby'             => $orderby,
		'order'               => $order,
		'ignore_sticky_posts' => 1,
		'product_cat'         => $category,
		'posts_per_page' 	    => $per_page,
		'meta_query'          => $meta_query,
		'tax_query'           => $tax_query,
	);


}
else if( $product_type === 'best_selling' ) {

	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'orderby'             => $orderby,
		'order'               => $order,
		'product_cat'         => $category,
		'posts_per_page'		  => $per_page,
		'meta_key'            => 'total_sales',
		'orderby'             => 'meta_value_num',
		'meta_query'          => WC()->query->get_meta_query(),
		'tax_query'           => WC()->query->get_tax_query(),
	);


}


// Using pagination option.
if( $pagination === '1' ) {

	$shortcode_attrs = '';

	if( !empty($product_type) && $product_type === 'best_selling' ) {
		$shortcode_attrs .= 'best_selling ';
	}
	elseif( !empty($product_type) && $product_type === 'sale' ) {
		$shortcode_attrs .= 'on_sale ';
	}
	elseif( !empty($product_type) && $product_type === 'featured' ) {
		$shortcode_attrs .= 'visibility="featured" ';
	}

	if( !empty($per_page) ) {
		$shortcode_attrs .= 'limit="'.esc_attr($per_page).'" ';
	}

	if( !empty($columns) ) {
		$shortcode_attrs .= 'columns="'.esc_attr($columns).'" ';
	}

	if( !empty($category) ) {
		$shortcode_attrs .= 'category="'.esc_attr($category).'" ';
	}

	if( !empty($orderby) ) {
		$shortcode_attrs .= 'orderby="'.esc_attr($orderby).'" ';
	}

	if( !empty($order) ) {
		$shortcode_attrs .= 'order="'.esc_attr($order).'" ';
	}

	// Use regular shortcode to handle query.
	echo do_shortcode('[products paginate="true" '.$shortcode_attrs.']');

}

// No pagination.
else {

	if( isset($_GET['vc_editable']) ) {
		$nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
		$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
		// Limit script choices on front end editor
		if($nectar_using_VC_front_end_editor && $script !== 'flickity') {
			$script = 'flickity';
		}
		if($nectar_using_VC_front_end_editor) {
			$flickity_item_animation = 'none';
		}
		
	}

	ob_start();

	$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts, $type = '' ) );

	if( $carousel !== '1' && $columns === 'dynamic' || $carousel === '1' && $script !== 'flickity' && $columns === 'dynamic' ) {
		$columns = 4;
	}

	$woocommerce_loop['columns'] = $columns;

	if ( $products->have_posts() ) : ?>

		<?php if( $carousel === '1' && $script === 'carouFredSel' ) { 
			wp_enqueue_script( 'caroufredsel' );
			wp_enqueue_style( 'nectar-caroufredsel' );
			?>
			<div class="carousel-wrap products-carousel" data-controls="<?php echo esc_attr( $controls_on_hover ); ?>">
		<?php	} ?>

		<?php if( $carousel === '1' && $script === 'flickity' ) { ?>
			<div class="nectar-woo-flickity" data-wrap="<?php echo esc_attr( $flickity_wrap ); ?>" data-drag-scale="<?php echo esc_attr($flickity_image_scale_on_drag); ?>" data-animation="<?php echo esc_attr($flickity_item_animation); ?>" data-group-columns="<?php echo esc_attr($flickity_group_cells); ?>" data-overflow="<?php echo esc_attr($flickity_overflow); ?>" data-mobile-col-width="<?php echo esc_attr($flickity_mobile_column_width); ?>" data-autorotate="<?php echo esc_attr( $autorotate ); ?>" data-autorotate-speed="<?php echo esc_attr( $autorotation_speed ); ?>" data-item-shadow="<?php echo esc_attr( $item_shadow ); ?>" data-controls="<?php echo esc_attr( $flickity_controls ); ?>">

		<?php
				if( $flickity_controls === 'arrows-and-text' || $flickity_controls === 'arrows-overlaid' ) {

					echo '<div class="nectar-woo-carousel-top">';
					if( $flickity_controls === 'arrows-and-text' ) {
						echo '<'.esc_html($flickity_heading_tag).'>'.wp_kses_post($flickity_heading_text).'</'.esc_html($flickity_heading_tag).'>';
					}

					if( strlen($flickity_link_text) > 0 ) {
						echo '<a href="'.esc_url($flickity_link_url).'">'.wp_kses_post($flickity_link_text).'</a>';
					}

					echo '</div>';
				}
		} ?>

		<?php wc_get_template( 'loop/loop-start.php' ); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php 
        $woocommerce_loop['columns'] = 4;
        wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php  wc_get_template( 'loop/loop-end.php' ); ?>

		<?php if($carousel == '1') { ?> </div> <?php } ?>

	<?php endif;

	wp_reset_postdata();

	echo '<div class="woocommerce columns-' . esc_attr($columns) . '">' . ob_get_clean() . '</div>';

} // No pagination.

?>
