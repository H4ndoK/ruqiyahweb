<?php
/**
 * The template for displaying single portfolio post type projects.
 *
 * @package Salient Portfolio
 * @version 1.7
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$fwp = get_post_meta( $post->ID, '_nectar_portfolio_item_layout', true );

if ( empty( $fwp ) ) {
	$fwp = 'false';
}

global $post;

$bg       = get_post_meta( $post->ID, '_nectar_header_bg', true );
$bg_color = get_post_meta( $post->ID, '_nectar_header_bg_color', true );
$bg_type  = get_post_meta( $post->ID, '_nectar_slider_bg_type', true );
if ( empty( $bg_type ) ) {
	$bg_type = 'image_bg';
}


if( defined( 'NECTAR_THEME_NAME' ) ) {
	$options = get_nectar_theme_options(); 
} else {
	$options = salient_get_default_portfolio_options(); 
}


if( class_exists('Salient_Portfolio_Single_Layout') && Salient_Portfolio_Single_Layout::$is_full_width ) {
	$fwp = 'enabled';
} 

$featured_src              = ( has_post_thumbnail( $post->ID ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ) : array( 'empty' );
$full_width_portfolio      = ( ! empty( $fwp ) && $fwp == 'enabled' ) ? 'full_width_portfolio' : 'regular_portfolio';
$single_nav_pos            = ( ! empty( $options['portfolio_single_nav'] ) ) ? $options['portfolio_single_nav'] : 'after_project_2';
$subtitle                  = get_post_meta( $post->ID, '_nectar_header_subtitle', true );
$project_social_style      = get_option( 'salient_social_button_style', 'fixed' );
$portfolio_remove_comments = ( ! empty( $options['portfolio_remove_comments'] ) ) ? $options['portfolio_remove_comments'] : '0';
$theme_skin                = ( ! empty( $options['theme-skin'] ) && $options['theme-skin'] === 'ascend' ) ? 'ascend' : 'default';
$remove_single_header      = 'false';  

  
if( isset($options['portfolio_remove_single_header']) && 
    !empty($options['portfolio_remove_single_header']) && 
	  '1' === $options['portfolio_remove_single_header'] ) {
	$remove_single_header = 'true';
} 

?>

<div id="<?php echo esc_attr( $full_width_portfolio ); ?>" <?php if ( ! empty( $bg ) && $fwp !== 'enabled' || ! empty( $bg_color ) && $fwp !== 'enabled' ) { echo ' data-project-header-bg="true"'; } ?> data-featured-img="<?php echo esc_attr( $featured_src[0] ); ?>">
			
		<?php
		if( function_exists('nectar_page_header') && 'true' !== $remove_single_header ) {
			nectar_page_header( $post->ID );
		} 
		

		if ( defined( 'NECTAR_THEME_NAME' ) && empty( $bg ) && empty( $bg_color ) && $bg_type !== 'video_bg' && 'true' !== $remove_single_header ) {
			?>
			
				<div class="row project-title">
					<div class="container">
						<div class="title-wrap">
						<div class="col span_12 section-title <?php if ( empty( $options['portfolio_date'] ) || $options['portfolio_date'] == 0 ) { echo 'no-date';} ?> ">
							
							<h1><?php the_title(); ?></h1>
							<?php
							if ( ! empty( $subtitle ) || has_filter('salient_portfolio_single_subtitle') ) {
								?>
								 <span class="subheader"><?php echo wp_kses_post( apply_filters('salient_portfolio_single_subtitle', $subtitle ) ); ?></span> <?php } ?>

							<?php
							if ( $single_nav_pos == 'in_header' ) {
								nectar_project_single_controls();
							}
							?>
					 
						</div> 
					</div>
				</div> 
			</div><!--/row-->
			
		<?php } //project header ?>
		
	<div class="container-wrap" data-nav-pos="<?php echo esc_attr( $single_nav_pos ); ?>" data-rm-header="<?php echo esc_attr( $remove_single_header ); ?>">
		
		<div class="container main-content"> 
			
			<?php
			
			$enable_gallery_slider = get_post_meta( get_the_ID(), '_nectar_gallery_slider', true );
			
			do_action( 'salient_portfolio_hook_single_before_content' );
			
			?>
			
			<div class="row <?php if ( ! empty( $enable_gallery_slider ) && $enable_gallery_slider == 'on' ) { echo 'gallery-slider';} ?> ">
				
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();

						if ( function_exists( 'yoast_breadcrumb' ) ) {
							yoast_breadcrumb( '<p id="breadcrumbs" class="yoast">', '</p>' ); 
						}

						include plugin_dir_path( __FILE__ ) . 'partials/content-area.php';

						if ( $fwp != 'enabled' ) {
							include plugin_dir_path( __FILE__ ) .'partials/sidebar.php';
						}

				endwhile;
			 endif;
			?>
				
			</div>

			<?php 
			
			do_action( 'salient_portfolio_hook_single_after_content' );
			
			if ( comments_open() && $theme_skin === 'ascend' && $portfolio_remove_comments != '1' ) { ?>
						
				<div class="comments-section row">
				   <?php comments_template(); ?>
				</div>
			
			<?php } ?>  

		</div><!--/container-->

		<?php
		if ( in_array($single_nav_pos ,array('after_project_next_only','after_project_2', 'after_project')) ) {
				include plugin_dir_path( __FILE__ ) . '/partials/bottom-project-navigation.php';
		}
		if( function_exists('nectar_hook_before_container_wrap_close') ) {
			nectar_hook_before_container_wrap_close();
		}
		?>

	</div><!--/container-wrap-->

</div><!--/fullwidth-->


<?php

if ( $project_social_style == 'fixed' ) {
	
	if( function_exists('nectar_social_sharing_output') ) {
		nectar_social_sharing_output('fixed');
	}
	
}


get_footer(); ?>