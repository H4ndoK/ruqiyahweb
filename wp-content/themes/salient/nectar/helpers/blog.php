<?php
/**
 * Salient blog related functions
 *
 * @package Salient WordPress Theme
 * @subpackage helpers
 * @version 10.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Store views on blog posts.
 *
 * @since 9.0
 */
if ( ! function_exists( 'nectar_set_post_views' ) ) {

	function nectar_set_post_views() {

		global $post;

		if ( get_post_type() === 'post' && is_single() ) {

			$post_id = $post->ID;

			if ( ! empty( $post_id ) ) {

				$the_view_count = get_post_meta( $post_id, 'nectar_blog_post_view_count', true );

				if ( $the_view_count != '' ) {

					$the_view_count = intval( $the_view_count );
					$the_view_count++;
					update_post_meta( $post_id, 'nectar_blog_post_view_count', $the_view_count );

				} else {

					$the_view_count = 0;
					delete_post_meta( $post_id, 'nectar_blog_post_view_count' );
					add_post_meta( $post_id, 'nectar_blog_post_view_count', '0' );

				}
			}
		}

	}
}

add_action( 'wp_head', 'nectar_set_post_views' );



/**
 * Custom Excerpt.
 *
 * @since 13.1
 */

 if( !function_exists('nectar_estimated_reading_time') ) {
  function nectar_estimated_reading_time( $content = '') {
    $text_only = strip_tags( do_shortcode( $content ) );
    $word_count = str_word_count(  $text_only );
    $time = max(ceil( $word_count / 225 ), 1);
    return $time;
  }
 }


/**
 * Custom Excerpt.
 *
 * @since 3.0
 */
if ( ! function_exists( 'nectar_excerpt' ) ) {

	function nectar_excerpt( $limit ) {

		if ( has_excerpt() ) {
			$the_excerpt = get_the_excerpt();
			$the_excerpt = preg_replace( '/\[[^\]]+\]/', '', $the_excerpt );  // strip shortcodes, keep shortcode content
			return wp_trim_words( $the_excerpt, $limit );
		} else {
			$the_content = get_the_content();
			$the_content = preg_replace( '/\[[^\]]+\]/', '', $the_content );  // strip shortcodes, keep shortcode content
			return wp_trim_words( $the_content, $limit );
		}
	}
}




/**
 * Remove the page jump when clicking read more button
 *
 * @since 3.0
 */
function nectar_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ( $offset ) {
		$end = strpos( $link, '"', $offset );
	}
	if ( $end ) {
		$link = substr_replace( $link, '', $offset, $end - $offset );
	}
	return $link;
}
add_filter( 'the_content_more_link', 'nectar_remove_more_jump_link' );





/**
 * Remove rel attribute from the category list
 *
 * @since 3.0
 */
function nectar_remove_category_list_rel( $output ) {
	return str_replace( ' rel="category tag"', '', $output );
}

add_filter( 'wp_list_categories', 'nectar_remove_category_list_rel' );
add_filter( 'the_category', 'nectar_remove_category_list_rel' );






/**
 * Blog social sharing.
 *
 * @deprecated 10.5 Use nectar_social_sharing_output()
 * @see salient social plugin
 */
function nectar_blog_social_sharing() {
	// Output moved to "Salient Social" plugin.
}




/**
 * Next/Prev post pagination output.
 *
 * @since 4.0
 */
 if( !function_exists('nectar_next_post_display') ) {

	 function nectar_next_post_display() {

		 global $post;
		 global $nectar_options;

		 $post_header_style            = ( ! empty( $nectar_options['blog_header_type'] ) ) ? $nectar_options['blog_header_type'] : 'default';
		 $post_pagination_style        = ( ! empty( $nectar_options['blog_next_post_link_style'] ) ) ? $nectar_options['blog_next_post_link_style'] : 'fullwidth_next_only';
		 $post_pagination_style_output = ( $post_pagination_style === 'contained_next_prev' ) ? 'fullwidth_next_prev' : $post_pagination_style;
		 $full_width_content_class     = ( $post_pagination_style === 'contained_next_prev' || $post_pagination_style === 'parallax_next_only' ) ? '' : 'full-width-content';
		 $blog_next_post_link_order    = ( ! empty( $nectar_options['blog_next_post_link_order'] ) ) ? $nectar_options['blog_next_post_link_order'] : 'default';
		 $blog_limit_cat               = ( isset( $nectar_options['blog_next_post_limit_cat'] ) && '1' === $nectar_options['blog_next_post_limit_cat'] ) ? true : false;
     $blog_next_post_bool          = (isset( $nectar_options['blog_next_post_link'] ) && $nectar_options['blog_next_post_link'] === '1') ? true : false;
    
		 $next_post = get_previous_post($blog_limit_cat);

     $blog_nav_attrs = '';
     $blog_nav_img_wrap_o = '';
     $blog_nav_img_wrap_c = '';

     if( 'parallax_next_only' === $post_pagination_style ) {
        $blog_nav_attrs = ' data-n-parallax-bg="true" data-parallax-speed="subtle"';
        $blog_nav_img_wrap_o = '<div class="parallax-layer-wrap"><div class="parallax-layer">';
        $blog_nav_img_wrap_c = '</div></div>';
     }

		 if ( ! empty( $next_post ) && $blog_next_post_bool ||
		 $post_pagination_style === 'contained_next_prev' && $blog_next_post_bool  ||
		 $post_pagination_style === 'fullwidth_next_prev' && $blog_next_post_bool ||
     $post_pagination_style === 'parallax_next_only' && $blog_next_post_bool ) { 
      
      $row_class = ( $post_pagination_style !== 'parallax_next_only' ) ? 'wpb_row ' : '';
			 echo '<div'.$blog_nav_attrs.' data-post-header-style="'.esc_attr( $post_header_style ).'" class="blog_next_prev_buttons vc_row-fluid '. $row_class . esc_attr( $full_width_content_class ).' standard_section" data-style="'.esc_attr( $post_pagination_style_output ).'" data-midnight="light">';

				 if ( ! empty( $next_post ) ) {
					 $bg       = get_post_meta( $next_post->ID, '_nectar_header_bg', true );
					 $bg_color = get_post_meta( $next_post->ID, '_nectar_header_bg_color', true );
				 } else {
					 $bg       = '';
					 $bg_color = '';
				 }

				 if ( $post_pagination_style == 'fullwidth_next_prev' || $post_pagination_style == 'contained_next_prev' ) {

					 // next & prev
					 if( $blog_next_post_link_order === 'reverse' ) {
						 $previous_post = get_previous_post($blog_limit_cat);
						 $next_post     = get_next_post($blog_limit_cat);
					 } else {
						 $previous_post = get_next_post($blog_limit_cat);
						 $next_post     = get_previous_post($blog_limit_cat);
					 }

					 $hidden_class = ( empty( $previous_post ) ) ? 'hidden' : null;
					 $only_class   = ( empty( $next_post ) ) ? ' only' : null;
					 echo '<ul class="controls"><li class="previous-post ' . $hidden_class . $only_class . '">';
					 
					 $global_lazy_load = false;
					 if( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
						 $global_lazy_load = true;
					 }
					 
					 if ( ! empty( $previous_post ) ) {
						 $previous_post_id = $previous_post->ID;
						 $bg               = get_post_meta( $previous_post_id, '_nectar_header_bg', true );

						 if ( ! empty( $bg ) ) {
							 
							 // page header
							 if( true === $global_lazy_load ) {
								 echo '<div class="post-bg-img" data-nectar-img-src="' . esc_html($bg) . '"></div>';
							 } else {
								 echo '<div class="post-bg-img" style="background-image: url(' . esc_html($bg) . ');"></div>';
							 }
							 
						 } elseif ( has_post_thumbnail( $previous_post_id ) ) {
							 // featured image
							 $post_thumbnail_id  = get_post_thumbnail_id( $previous_post_id );
							 $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
							 
							 if( true === $global_lazy_load ) {
								 echo '<div class="post-bg-img" data-nectar-img-src="' . esc_url( $post_thumbnail_url ) . '"></div>';
							 } else {
								 echo '<div class="post-bg-img" style="background-image: url(' . esc_url( $post_thumbnail_url ) . ');"></div>';
							 }
							 
						 }

						 echo '<a href="' . esc_url( get_permalink( $previous_post_id ) ) . '" aria-label="'. esc_attr($previous_post->post_title) .'"></a><h3><span>' . esc_html__( 'Previous Post', 'salient' ) . '</span><span class="text">' . wp_kses_post( $previous_post->post_title ) . '
						 <svg class="next-arrow" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';
					 }

					 echo '</li>';

					 $hidden_class = ( empty( $next_post ) ) ? 'hidden' : null;
					 $only_class   = ( empty( $previous_post ) ) ? ' only' : null;

					 echo '<li class="next-post ' . $hidden_class . $only_class . '">';

					 if ( ! empty( $next_post ) ) {
						 $next_post_id = $next_post->ID;
						 $bg           = get_post_meta( $next_post_id, '_nectar_header_bg', true );

						 if ( ! empty( $bg ) ) {
							 // page header
							 if( true === $global_lazy_load ) {
								 echo '<div class="post-bg-img" data-nectar-img-src="' . esc_html($bg) . '"></div>';
							 } 
							 else {
								 echo '<div class="post-bg-img" style="background-image: url(' . esc_html($bg) . ');"></div>';
							 }
							 
						 } elseif ( has_post_thumbnail( $next_post_id ) ) {
							 // featured image
							 $post_thumbnail_id  = get_post_thumbnail_id( $next_post_id );
							 $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
							 
							 if( true === $global_lazy_load ) {
								 echo '<div class="post-bg-img" data-nectar-img-src="' . esc_url( $post_thumbnail_url ) . '"></div>';
							 } 
							 else {
								 echo '<div class="post-bg-img" style="background-image: url(' . esc_url( $post_thumbnail_url ) . ');"></div>';
							 }
							 
						 }

						 echo '<a href="' . esc_url( get_permalink( $next_post_id ) ) . '" aria-label="'. esc_attr($next_post->post_title) .'"></a><h3><span>' . esc_html__( 'Next Post', 'salient' ) . '</span><span class="text">' . wp_kses_post( $next_post->post_title ) . '
						 <svg class="next-arrow" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';

					 }

					 echo '</li></ul>';

				 } else {

					$next_post = get_previous_post($blog_limit_cat);
					$hidden_class = ( empty( $next_post ) ) ? ' hidden' : '';
					
					 // next only
					 if ( ! empty( $bg ) ) {

						 // page header
						 echo ' '.$blog_nav_img_wrap_o.'<div class="post-bg-img" style="background-image: url(' . esc_url( $bg ) . ');"></div>'.$blog_nav_img_wrap_c;

					 } elseif ( !empty($next_post) && has_post_thumbnail( $next_post->ID ) ) {
						 // featured image
						 $post_thumbnail_id  = get_post_thumbnail_id( $next_post->ID );
						 $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
						 echo ' '.$blog_nav_img_wrap_o.'<div class="post-bg-img" style="background-image: url(' . esc_url( $post_thumbnail_url ) . ');"></div>'.$blog_nav_img_wrap_c;
					 }
					else {
						echo ' '.$blog_nav_img_wrap_o.'<div class="post-bg-img"></div>'.$blog_nav_img_wrap_c;
					}
					 ?>

					 <div class="col span_12 dark left<?php echo esc_html($hidden_class); ?>">
						 <div class="inner">
							 <?php
							 if( $blog_next_post_link_order === 'reverse' ) {
								 echo '<span><i>' . esc_html__( 'Previous Post', 'salient' ) . '</i></span>';
							 } else {
								 echo '<span><i>' . esc_html__( 'Next Post', 'salient' ) . '</i></span>';
							 }
							 previous_post_link( '%link', '<h3>%title</h3>', $blog_limit_cat ); ?>
						 </div>
					 </div>
					 <span class="bg-overlay"></span>
					 <span class="full-link"><?php previous_post_link( '%link', '%title', $blog_limit_cat ); ?></span>

				 <?php } ?>

			 </div>

			 <?php
		 }


	 }

 }




/**
 * Related posts output.
 *
 * @since 8.0
 */
 if( !function_exists('nectar_related_post_display') ) {

	 function nectar_related_post_display() {

		 global $post;
		 global $nectar_options;

		 $using_related_posts = ( ! empty( $nectar_options['blog_related_posts'] ) && $nectar_options['blog_related_posts'] === '1' ) ? true : false;

		 if ( $using_related_posts === false ) {
			 return;
		 }


		 $current_categories = get_the_category( $post->ID );

		 if ( $current_categories ) {

			 $category_ids = array();
			 foreach ( $current_categories as $individual_category ) {
				 $category_ids[] = $individual_category->term_id;
			 }

			 $relatedBlogPosts = array(
				 'category__in'        => $category_ids,
				 'post__not_in'        => array( $post->ID ),
				 'showposts'           => 3,
				 'ignore_sticky_posts' => 1,
			 );

			 $related_posts_query = new WP_Query( $relatedBlogPosts );
			 $related_post_count  = $related_posts_query->post_count;

			 if ( $related_post_count < 2 ) {
				 return;
			 }

			 $span_num = ( $related_post_count == 2 ) ? 'span_6' : 'span_4';

			 $related_title_text        = esc_html__( 'Related Posts', 'salient' );
			 $related_post_title_option = ( ! empty( $nectar_options['blog_related_posts_title_text'] ) ) ? wp_kses_post( $nectar_options['blog_related_posts_title_text'] ) : 'Related Posts';

			 switch ( $related_post_title_option ) {
			 case 'related_posts':
			 		$related_title_text = esc_html__( 'Related Posts', 'salient' );
			 		break;

			 case 'similar_posts':
			 		$related_title_text = esc_html__( 'Similar Posts', 'salient' );
			 		break;

			 case 'you_may_also_like':
			 		$related_title_text = esc_html__( 'You May Also Like', 'salient' );
			 		break;
			 case 'recommended_for_you':
				 $related_title_text = esc_html__( 'Recommended For You', 'salient' );
				 break;
			 }

			 $hidden_title_class = null;
			 if ( $related_post_title_option === 'hidden' ) {
				 $hidden_title_class = 'hidden';
			 }

			 $using_post_pag       = ( ! empty( $nectar_options['blog_next_post_link'] ) && $nectar_options['blog_next_post_link'] === '1' ) ? 'true' : 'false';
			 $related_post_style   = ( ! empty( $nectar_options['blog_related_posts_style'] ) ) ? esc_html( $nectar_options['blog_related_posts_style'] ) : 'material';
			 $related_post_excerpt = ( isset( $nectar_options['blog_related_posts_excerpt'] ) && '1' === $nectar_options['blog_related_posts_excerpt'] ) ? true : false;
			 
			 $global_lazy_load = false;
			 if( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
				 $global_lazy_load = true;
			 }
			 
			 echo '<div class="row vc_row-fluid full-width-section related-post-wrap" data-using-post-pagination="' . esc_attr( $using_post_pag ) . '" data-midnight="dark"> <div class="row-bg-wrap"><div class="row-bg"></div></div> <h3 class="related-title ' . $hidden_title_class . '">' . wp_kses_post( $related_title_text ) . '</h3><div class="row span_12 blog-recent related-posts columns-' . esc_attr( $related_post_count ) . '" data-style="' . esc_attr( $related_post_style ) . '" data-color-scheme="light">';
			 if ( $related_posts_query->have_posts() ) :
				 while ( $related_posts_query->have_posts() ) :
					 $related_posts_query->the_post();
					 ?>

					 <div class="col <?php echo esc_attr( $span_num ); ?>">
						 <div <?php post_class( 'inner-wrap' ); ?>>

							 <?php
							 if ( has_post_thumbnail() ) {
								 $related_image_size = ( $related_post_count == 2 ) ? 'wide_photography' : 'portfolio-thumb';
								 
								 echo '<a href="' . esc_url( get_permalink() ) . '" class="img-link"><span class="post-featured-img">';
								 
								 if( true === $global_lazy_load ) {
									 
									 $image_src = get_the_post_thumbnail_url($post->ID, $related_image_size);
									 $image_id  = get_post_thumbnail_id($post->ID);
									 
									 if( $image_src && $image_id ) {
										 
								     $image_width = ( 'wide_photography' === $related_image_size ) ? '900' : '600';
								     $image_height = ( 'wide_photography' === $related_image_size  ) ? '600' : '403';
											 
										 $wp_img_alt_tag = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
											 
										 $image_attrs_escaped = 'height="'.esc_attr($image_height).'" ';
									   $image_attrs_escaped .= 'width="'.esc_attr($image_width).'" ';
										 $image_attrs_escaped .= 'alt="'.esc_attr($wp_img_alt_tag).'" ';
										 $image_attrs_escaped .= 'data-nectar-img-src="'.esc_url($image_src).'" ';
										 
										 $placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($image_width).'%20'.esc_attr($image_height)."'%2F%3E";
										 
										 echo '<img class="nectar-lazy skip-lazy" '.$image_attrs_escaped.' src="'.$placeholder_img_src.'" />';
									 }
									 
								 } else {
									 echo get_the_post_thumbnail( $post->ID, $related_image_size, array( 'title' => '' ) ); 
								 }
								 
								 echo '</span></a>';
							 }
							 ?>

							 <?php
							 echo '<span class="meta-category">';
							 $categories = get_the_category();
							 if ( ! empty( $categories ) ) {
								 $output = null;
								 foreach ( $categories as $category ) {
									 $output .= '<a class="' . esc_attr( $category->slug ) . '" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
								 }
								 echo trim( $output );
							 }
							 echo '</span>';
							 ?>

							 <a class="entire-meta-link" href="<?php the_permalink(); ?>" aria-label="<?php echo get_the_title(); ?>"></a>

							 <div class="article-content-wrap">
								 <div class="post-header">
									 <span class="meta">
										 <?php
										 if ( $related_post_style != 'material' ) {
											 echo get_the_date();
										 }
										 ?>
									 </span>
									 <h3 class="title"><?php the_title(); ?></h3>
									 <?php if( true === $related_post_excerpt ) {
										 // Excerpt.
										 $excerpt_length = ( ! empty( $nectar_options['blog_excerpt_length'] ) ) ? intval( $nectar_options['blog_excerpt_length'] ) : 15;
	 				            echo '<div class="excerpt">';
	 				              echo nectar_excerpt( $excerpt_length );
	 				            echo '</div>';
									 } ?>
								 </div><!--/post-header-->

								 <?php
								 if ( function_exists( 'get_avatar' ) && $related_post_style === 'material' ) {
									 echo '<div class="grav-wrap">' . get_avatar( get_the_author_meta( 'email' ), 70, null, get_the_author() ) . '<div class="text"> <a href="' . get_author_posts_url( $post->post_author ) . '">' . get_the_author() . '</a><span>' . get_the_date() . '</span></div></div>';
								 }

								 ?>
							 </div>

							 <?php if ( $related_post_style != 'material' ) { ?>

								 <div class="post-meta">
									 <span class="meta-author"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"> <i class="icon-default-style icon-salient-m-user"></i> <?php the_author(); ?></a> </span>

									 <?php if ( comments_open() ) { ?>
										 <span class="meta-comment-count">  <a href="<?php comments_link(); ?>">
											 <i class="icon-default-style steadysets-icon-chat-3"></i> <?php comments_number( '0', '1', '%' ); ?></a>
										 </span>
									 <?php } ?>

								 </div>
								 <?php

							 }
							 ?>

						 </div>
					 </div>
					 <?php

				 endwhile;
			 endif;

			 echo '</div></div>';

			 wp_reset_postdata();

		 }// if has categories


		}

	}



	/**
	 * Excerpt length.
	 *
	 * @since 3.0
	 */
	if ( ! function_exists( 'excerpt_length' ) ) {
		function excerpt_length( $length ) {

			global $nectar_options;
			$excerpt_length = ( ! empty( $nectar_options['blog_excerpt_length'] ) ) ? intval( $nectar_options['blog_excerpt_length'] ) : 30;

			return $excerpt_length;
		}
	}

	add_filter( 'excerpt_length', 'excerpt_length', 999 );




	/**
	 * Custom excerpt ending characters.
	 *
	 * @since 3.0
	 */
	if ( ! function_exists( 'nectar_excerpt_more' ) ) {
		function nectar_excerpt_more( $more ) {
			return '...';
		}
	}
	add_filter( 'excerpt_more', 'nectar_excerpt_more' );




/**
 * Grab IDs from gallery shortcode
 *
 * @since 5.0
 */
if ( ! function_exists( 'nectar_grab_ids_from_gallery' ) ) {

	function nectar_grab_ids_from_gallery() {
		global $post;

		if ( $post != null ) {

			// if WP 5.0+ block editor
			if ( function_exists( 'parse_blocks' ) ) {

				if ( false !== strpos( $post->post_content, '<!-- wp:' ) ) {
					 $post_blocks = parse_blocks( $post->post_content );

					 // loop through and look for gallery
					foreach ( $post_blocks as $key => $block ) {

						// gallery block found
						if ( isset( $block['blockName'] ) && isset( $block['innerHTML'] ) && $block['blockName'] == 'core/gallery' ) {

							   preg_match_all( '/data-id="([^"]*)"/', $block['innerHTML'], $id_matches );

							if ( $id_matches && isset( $id_matches[1] ) ) {
								return $id_matches[1];
							}
						} //gallery block found end

					} //foreach post block loop end

				} //if the post appears to be using gutenberg

			}

			$attachment_ids          = array();
			$pattern                 = '\[(\[?)(gallery)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
			$ids                     = array();
			$portfolio_extra_content = get_post_meta( $post->ID, '_nectar_portfolio_extra_content', true );

			if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches ) ) {

				$count = count( $matches[3] );      // in case there is more than one gallery in the post.
				for ( $i = 0; $i < $count; $i++ ) {
					$atts = shortcode_parse_atts( $matches[3][ $i ] );
					if ( isset( $atts['ids'] ) ) {
						$attachment_ids = explode( ',', $atts['ids'] );
						$ids            = array_merge( $ids, $attachment_ids );
					}
				}
			}

			if ( preg_match_all( '/' . $pattern . '/s', $portfolio_extra_content, $matches ) ) {
				$count = count( $matches[3] );
				for ( $i = 0; $i < $count; $i++ ) {
					$atts = shortcode_parse_atts( $matches[3][ $i ] );
					if ( isset( $atts['ids'] ) ) {
						$attachment_ids = explode( ',', $atts['ids'] );
						$ids            = array_merge( $ids, $attachment_ids );
					}
				}
			}
			return $ids;
		} else {
			$ids = array();
			return $ids;
		}

	}
}


/**
 * Fixing filtering for shortcodes
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_shortcode_empty_paragraph_fix' ) ) {
	function nectar_shortcode_empty_paragraph_fix( $content ) {
		$array = array(
			'<p>['    => '[',
			']</p>'   => ']',
			']<br />' => ']',
		);

		$content = strtr( $content, $array );
		return $content;
	}
}

add_filter( 'the_content', 'nectar_shortcode_empty_paragraph_fix' );




/**
 * Remove default entry class position
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_remove_hentry_cssclass' ) ) {
	function nectar_remove_hentry_cssclass( $classes ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		return $classes;
	}
}
add_filter( 'post_class', 'nectar_remove_hentry_cssclass' );
