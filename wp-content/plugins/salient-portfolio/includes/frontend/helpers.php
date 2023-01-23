<?php
/**
 * Salient portfolio related functions
 *
 * @package Salient Portfolio
 * @subpackage helpers
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup defaults when Salient is not the active theme
 *
 * @since 1.0
 */
if( ! function_exists('salient_get_default_portfolio_options') ) {
	function salient_get_default_portfolio_options() {
		
		$default_options = array(
			'main_portfolio_layout' 			  => '3',
			'main_portfolio_project_style'  => '7',
			'main_portfolio_item_spacing'	  => '',
			'portfolio_use_masonry' 			  => '',
			'portfolio_masonry_grid_sizing' => '',
			'portfolio_pagination_type' 		=> '',
			'portfolio_inline_filters' 			=> '1',
			'header-fullwidth' 							=> '',
			'portfolio-sortable-text' 			=> '',
			'loading-image' 								=> '',
			'portfolio_loading_animation'		=> 'fade_in_from_bottom',
			'portfolio_extra_pagination' 		=> '1',
			'portfolio_pagination' 					=> '1',
			'portfolio_pagination_number' 	=> '12',
			'portfolio_date' 								=> 1,
			'portfolio_single_nav' 					=> 'after_project_2'
		);
		
		return $default_options;
	}
}


/**
 * Helper to remove jetpack lazy load from portfolio.
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_remove_lazy_load_functionality' ) ) {
	function nectar_remove_lazy_load_functionality( $attr ) {
		$attr['class'] .= ' skip-lazy';
		return $attr;
	}
}


/**
 * Check for HTTPS
 *
 * @since 1.0
 */
if( ! function_exists('nectar_ssl_check') ) {
	
	function nectar_ssl_check( $src ) {

		$nectar_is_ssl = is_ssl();

		if ( strpos( $src, 'http://' ) !== false && $nectar_is_ssl == true ) {
			$converted_start = str_replace( 'http://', 'https://', $src );
			return $converted_start;
		} else {
			return $src;
		}
	}
	
}


/**
 * Helper function to find page that contains specific string
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_get_page_by_title_search' ) ) {
	function nectar_get_page_by_title_search( $string ) {
		
		global $wpdb;

		$string = sanitize_text_field( $string );
		$title  = esc_sql( $string );
		if ( ! $title ) {
			return;
		}
		
		$query_prepared = $wpdb->prepare( 
			"SELECT * FROM {$wpdb->posts} WHERE post_title LIKE %s AND post_type = 'page' AND post_status = 'publish' LIMIT 1",
			'%' . $wpdb->esc_like($title) . '%'
		);
		
		$page = $wpdb->get_results($query_prepared);
				
		return $page;
	}
}



/**
 * Output a placeholder img.
 *
 * @since 1.0
 */
function nectar_default_portfolio_img_sizer( $thumb_size, $title = 'no image added yet.' ) {
	
	switch($thumb_size) {
		case 'wide_photography':
			$no_image_size = 'no-portfolio-item-photography-wide.jpg';
			break;
		case 'regular_photography':
			$no_image_size = 'no-portfolio-item-photography-regular.jpg';
			break;
		case 'wide_tall_photography':
			$no_image_size = 'no-portfolio-item-photography-regular.jpg';
			break;
		case 'wide':
			$no_image_size = 'no-portfolio-item-wide.jpg';
			break;
		case 'tall':
			$no_image_size = 'no-portfolio-item-tall.jpg';
			break;
		case 'regular':
			$no_image_size = 'no-portfolio-item-tiny.jpg';
			break;
		case 'wide_tall':
			$no_image_size = 'no-portfolio-item-tiny.jpg';
			break;
		default:
			$no_image_size = 'no-portfolio-item-small.jpg';
			break;
	}
	
	echo '<img class="no-img" src="' . SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/' . esc_attr( $no_image_size ) . '" alt="'. esc_attr( $title ) .'" />';
	
}



/**
 * Portfolio single page controls.
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_project_single_controls' ) ) {

	function nectar_project_single_controls() {

			global $nectar_options;
			global $post;
			
			if( ! defined('NECTAR_THEME_NAME') ) {
				$nectar_options = array(
					'portfolio_single_nav' => 'after_project_2'
				);
			}
			
			$back_to_all_override = get_post_meta( $post->ID, 'nectar-metabox-portfolio-parent-override', true );
			if ( empty( $back_to_all_override ) ) {
				$back_to_all_override = 'default';
			}

			// attempt to find parent portfolio page - if unsuccessful default to main portfolio page
			$terms          = get_the_terms( $post->id, 'project-type' );
			$project_cat    = null;
			$portfolio_link = null;
			$single_nav_pos = ( ! empty( $nectar_options['portfolio_single_nav'] ) ) ? $nectar_options['portfolio_single_nav'] : 'in_header';
			$navigation_order = (isset($nectar_options['portfolio_single_nav_order']) && 'reverse' === $nectar_options['portfolio_single_nav_order']) ? 'reverse' : 'default';

			if ( empty( $terms ) ) {
				$terms = array(
					'1' => (object) array(
						'name' => 'nothing',
						'slug' => 'none',
					),
				);
			}

			foreach ( $terms as $term ) {
				$project_cat = strtolower( $term->name );
			}

			$page = nectar_get_page_by_title_search( $project_cat );
			
			if ( empty( $page ) ) {
				$page = array( '0' => (object) array( 'ID' => 'nothing' ) );
			}

			$page_link = verify_portfolio_page( $page[0]->ID );

			 // if a page has been found for the category
			if ( ! empty( $page_link ) && $back_to_all_override === 'default' && !in_array($single_nav_pos ,array('after_project_next_only','after_project_2')) ) {
				
				$portfolio_link = $page_link;

				?>
				 
				 <div id="portfolio-nav">
					<?php if ( !in_array($single_nav_pos ,array('after_project_next_only','after_project_2')) ) { ?>
						 <ul>
							 <li id="all-items"><a href="<?php echo esc_url( $portfolio_link ); ?>"><i class="icon-salient-back-to-all"></i></a></li>               
						 </ul>
					<?php } ?>
					<ul class="controls">                                 
				   <?php if ( $single_nav_pos === 'after_project' ) { ?>

							<?php if( 'default' === $navigation_order ) { ?>
								<li id="prev-link"><?php be_next_post_link( '%link', '<i class="fa fa-angle-left"></i> <span>' . esc_html__( 'Previous Project', 'salient-portfolio' ) . '</span>', true, null, 'project-type' ); ?></li>
								<li id="next-link"><?php be_previous_post_link( '%link', '<span>' . esc_html__( 'Next Project', 'salient-portfolio' ) . '</span><i class="fa fa-angle-right"></i>', true, null, 'project-type' ); ?></li> 
							<?php } else { ?>
								<li id="prev-link"><?php be_previous_post_link( '%link', '<span>' . esc_html__( 'Next Project', 'salient-portfolio' ) . '</span><i class="fa fa-angle-right"></i>', true, null, 'project-type' ); ?></li>
								<li id="next-link"><?php be_next_post_link( '%link', '<i class="fa fa-angle-left"></i> <span>' . esc_html__( 'Previous Project', 'salient-portfolio' ) . '</span>', true, null, 'project-type' ); ?></li> 
							<?php } ?>
					
						<?php } else { 

							if( 'default' === $navigation_order ) { ?>
								<li id="prev-link"><?php be_next_post_link( '%link', '<i class="icon-salient-left-arrow-thin"></i>', true, null, 'project-type' ); ?></li>
								<li id="next-link"><?php be_previous_post_link( '%link', '<i class="icon-salient-right-arrow-thin"></i>', true, null, 'project-type' ); ?></li> 
							<?php } else { ?>
								<li id="prev-link"><?php be_previous_post_link( '%link', '<i class="icon-salient-right-arrow-thin"></i>', true, null, 'project-type' ); ?></li>
								<li id="next-link"><?php be_next_post_link( '%link', '<i class="icon-salient-left-arrow-thin"></i>', true, null, 'project-type' ); ?></li> 
							<?php } ?>

						<?php } ?>
						
					</ul>
				</div>
				 
			<?php
		}

			 // if no category page exists
		else {

			$portfolio_link = get_portfolio_page_link( get_the_ID() );
			if ( ! empty( $nectar_options['main-portfolio-link'] ) ) {
				$portfolio_link = $nectar_options['main-portfolio-link'];
			}

			if ( $back_to_all_override != 'default' ) {
				$portfolio_link = get_page_link( $back_to_all_override );
			}

			$portfolio_nav_attrs = '';
			$portfolio_nav_img_wrap_o = '';
			$portfolio_nav_img_wrap_c = '';
			if( 'after_project_next_only' === $single_nav_pos ) {
				$portfolio_nav_attrs = ' data-n-parallax-bg="true" data-parallax-speed="fast"';
				$portfolio_nav_img_wrap_o = '<div class="parallax-layer-wrap"><div class="parallax-layer">';
				$portfolio_nav_img_wrap_c = '</div></div>';
			}
			?>
				<div id="portfolio-nav"<?php echo $portfolio_nav_attrs; ?>>
					<?php if ( !in_array($single_nav_pos ,array('after_project_next_only','after_project_2')) ) { ?>
						<ul>
							<li id="all-items"><a href="<?php echo esc_url( $portfolio_link ); ?>" title="<?php echo esc_attr__( 'Back to all projects', 'salient-portfolio' ); ?>"><i class="icon-salient-back-to-all"></i></a></li>  
						</ul>
					<?php } ?>

					<ul class="controls">    
				   <?php
					 // limited to same cat.
					if ( ! empty( $nectar_options['portfolio_same_category_single_nav'] ) && $nectar_options['portfolio_same_category_single_nav'] === '1' ) {

							// get_posts in same custom taxonomy
							$terms       = get_the_terms( $post->id, 'project-type' );
							$project_cat = null;

						if ( empty( $terms ) ) {
							$terms = array(
								'1' => (object) array(
									'name' => 'nothing',
									'slug' => 'none',
								),
							);
						}

						foreach ( $terms as $term ) {
							$project_cat = strtolower( $term->slug );
						}

							$postlist_args = array(
								'posts_per_page' => -1,
								'orderby'        => 'menu_order date',
								'order'          => 'ASC',
								'post_type'      => 'portfolio',
								'project-type'   => $project_cat,
							);
							$postlist = get_posts( $postlist_args );

							// get ids of posts retrieved from get_posts
							$ids = array();
							foreach ( $postlist as $thepost ) {
								$ids[] = $thepost->ID;
							}

							// get and echo previous and next post in the same taxonomy
							$thisindex = array_search( $post->ID, $ids );

							if( 'default' === $navigation_order ) {
								$nextid = ( isset( $ids[ $thisindex - 1 ] ) ) ? $ids[ $thisindex - 1 ] : null;
								$previd = ( isset( $ids[ $thisindex + 1 ] ) ) ? $ids[ $thisindex + 1 ] : null;
							} else {
								$nextid = ( isset( $ids[ $thisindex + 1 ] ) ) ? $ids[ $thisindex + 1 ] : null;
								$previd = ( isset( $ids[ $thisindex - 1 ] ) ) ? $ids[ $thisindex - 1 ] : null;
							}
							


						if ( ! empty( $previd ) ) {
							if ( $single_nav_pos === 'after_project' ) {
								echo '<li id="prev-link" class="from-sing"><a href="' . esc_url( get_permalink( $previd ) ) . '"><i class="fa fa-angle-left"></i><span>' . esc_html__( 'Previous Project', 'salient-portfolio' ) . '</span></a></li>';

							} elseif ( in_array($single_nav_pos ,array('after_project_next_only','after_project_2')) ) {

								$hidden_class = ( empty( $previd ) ) ? 'hidden' : null;
								$only_class   = ( empty( $nextid ) ) ? ' only' : null;
								echo '<li class="previous-project ' . $hidden_class . $only_class . '">';

								if ( ! empty( $previd ) ) {
									$previous_post_id = $previd;
									$bg               = get_post_meta( $previous_post_id, '_nectar_header_bg', true );

									if ( ! empty( $bg ) ) {
										// page header
										
										if( function_exists('nectar_options_img') ) {
											$bg = nectar_options_img($bg);
										}
										echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . esc_attr($bg) . ');"></div>'.$portfolio_nav_img_wrap_c;
									} elseif ( has_post_thumbnail( $previous_post_id ) ) {
										// featured image
										$post_thumbnail_id  = get_post_thumbnail_id( $previous_post_id );
										$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
										echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . $post_thumbnail_url . ');"></div>'.$portfolio_nav_img_wrap_c;
									}

									echo '<a href="' . esc_url( get_permalink( $previous_post_id ) ) . '"></a><h3><span>' . esc_html__( 'Previous Project', 'salient-portfolio' ) . '</span><span class="text">' . get_the_title( $previous_post_id ) . '
						<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';
								}
								echo '</li>';

							} else {
								echo '<li id="prev-link" class="from-sing"><a href="' . esc_url( get_permalink( $previd ) ) . '"><i class="icon-salient-left-arrow-thin"></i></a></li>';
							}
						}
						if ( ! empty( $nextid ) ) {

							if ( $single_nav_pos === 'after_project' ) {
								  echo '<li id="next-link" class="from-sing"><a href="' . esc_url( get_permalink( $nextid ) ) . '"><span>' . esc_html__( 'Next Project', 'salient-portfolio' ) . '</span><i class="fa fa-angle-right"></i></a></li>';

							} elseif ( in_array($single_nav_pos ,array('after_project_next_only','after_project_2')) ) {

								$hidden_class = ( empty( $nextid ) ) ? 'hidden' : null;
								$only_class   = ( empty( $previd ) ) ? ' only' : null;

								echo '<li class="next-project ' . $hidden_class . $only_class . '">';

								if ( ! empty( $nextid ) ) {
									$next_post_id = $nextid;
									$bg           = get_post_meta( $next_post_id, '_nectar_header_bg', true );

									if ( ! empty( $bg ) ) {
										// page header
										if( function_exists('nectar_options_img') ) {
											$bg = nectar_options_img($bg);
										}
										echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . esc_attr($bg) . ');"></div>'.$portfolio_nav_img_wrap_c;
									} elseif ( has_post_thumbnail( $next_post_id ) ) {
										// featured image
										$post_thumbnail_id  = get_post_thumbnail_id( $next_post_id );
										$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
										echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . esc_url( $post_thumbnail_url ) . ');"></div>'.$portfolio_nav_img_wrap_c;
									}
								}

									echo '<a href="' . esc_url( get_permalink( $next_post_id ) ) . '"></a><h3><span>' . esc_html__( 'Next Project', 'salient-portfolio' ) . '</span><span class="text">' . get_the_title( $next_post_id ) . '
							<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';

								echo '</li>';

							} else {
								echo '<li id="next-link" class="from-sing"><a href="' . esc_url( get_permalink( $nextid ) ) . '"><i class="icon-salient-right-arrow-thin"></i></a></li>';
							}
						}
					} 
					
					// Not limited to same cat.
					else {
						
			
						if ( $single_nav_pos === 'after_project' ) { 
							if( 'default' === $navigation_order ) { ?>
								<li id="prev-link"><?php next_post_link( '%link', '<i class="fa fa-angle-left"></i><span>' . esc_html__( 'Previous Project', 'salient-portfolio' ) . '</span>' ); ?></li>
								<li id="next-link"><?php previous_post_link( '%link', '<span>' . esc_html__( 'Next Project', 'salient-portfolio' ) . '</span><i class="fa fa-angle-right"></i>' ); ?></li> 
							<?php } else { ?>
								<li id="prev-link"><?php previous_post_link( '%link', '<i class="fa fa-angle-left"></i><span>' . esc_html__( 'Previous Project', 'salient-portfolio' ) . '</span>' ); ?></li>
								<li id="next-link"><?php next_post_link( '%link', '<span>' . esc_html__( 'Next Project', 'salient-portfolio' ) . '</span><i class="fa fa-angle-right"></i>' ); ?></li> 
							<?php }
						} 
						elseif ( in_array($single_nav_pos ,array('after_project_next_only','after_project_2')) ) {

							if( 'default' === $navigation_order ) {
								$previous_post = get_next_post();
								$next_post     = get_previous_post();
							} else {
								$previous_post = get_previous_post();
								$next_post     = get_next_post();
							}

							$hidden_class  = ( empty( $previous_post ) ) ? 'hidden' : null;
							$only_class    = ( empty( $next_post ) ) ? ' only' : null;
							
							$use_project_header_img = true;
							if( has_filter('salient_portfolio_pagination_use_header_img') ) {
								$use_project_header_img = apply_filters('salient_portfolio_pagination_use_header_img', $use_project_header_img);
							}
							
							echo '<li class="previous-project ' . $hidden_class . $only_class . '">';

							if ( ! empty( $previous_post ) ) {
								$previous_post_id = $previous_post->ID;
								$bg               = get_post_meta( $previous_post_id, '_nectar_header_bg', true );

								if ( ! empty( $bg ) && true === $use_project_header_img ) {
									// page header
									if( function_exists('nectar_options_img') ) {
										$bg = nectar_options_img($bg);
									}
									echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . esc_url( $bg ) . ');"></div>'.$portfolio_nav_img_wrap_c;
								} elseif ( has_post_thumbnail( $previous_post_id ) ) {
									// featured image
									$post_thumbnail_id  = get_post_thumbnail_id( $previous_post_id );
									$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
									echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . esc_url( $post_thumbnail_url ) . ');"></div>'.$portfolio_nav_img_wrap_c;
								}

									echo '<a href="' . esc_url( get_permalink( $previous_post_id ) ) . '"></a><h3><span>' . esc_html__( 'Previous Project', 'salient-portfolio' ) . '</span><span class="text">' . wp_kses_post($previous_post->post_title) . '
												<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';
							}
							echo '</li>';

							$hidden_class = ( empty( $next_post ) ) ? 'hidden' : null;
							$only_class   = ( empty( $previous_post ) ) ? ' only' : null;

							echo '<li class="next-project ' . $hidden_class . $only_class . '">';

							if ( ! empty( $next_post ) ) {
														$next_post_id = $next_post->ID;
														$bg           = get_post_meta( $next_post_id, '_nectar_header_bg', true );

								if ( ! empty( $bg ) && true === $use_project_header_img ) {
									// page header
									if( function_exists('nectar_options_img') ) {
										$bg = nectar_options_img($bg);
									}
									echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . esc_url($bg) . ');"></div>'.$portfolio_nav_img_wrap_c;
								} elseif ( has_post_thumbnail( $next_post_id ) ) {
									// featured image
									$post_thumbnail_id  = get_post_thumbnail_id( $next_post_id );
									$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
									echo $portfolio_nav_img_wrap_o.'<div class="proj-bg-img" style="background-image: url(' . esc_url($post_thumbnail_url) . ');"></div>'.$portfolio_nav_img_wrap_c;
								}
								
								echo '<a href="' . esc_url( get_permalink( $next_post_id ) ) . '"></a><h3><span>' . esc_html__( 'Next Project', 'salient-portfolio' ) . '</span><span class="text">' . wp_kses_post($next_post->post_title) . '
												<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"></line><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"></line></svg><span class="line"></span></span></h3>';
								echo '</li>';
														
							}

						} 

						else {
							?>
								<li id="prev-link">
									<?php
										if( 'default' === $navigation_order ) {
											next_post_link( '%link', '<i class="icon-salient-left-arrow-thin"></i>' ); 
										} 
										else {
											previous_post_link( '%link', '<i class="icon-salient-left-arrow-thin"></i>' );
										}
										
										if ( $single_nav_pos === 'after_project' ) {
											echo esc_html__( 'Previous Project', 'salient-portfolio' );}
										?>
									</li>
								<li id="next-link">
									<?php
									if ( $single_nav_pos === 'after_project' ) {
										echo esc_html__( 'Next Project', 'salient-portfolio' );
									}
									if( 'default' === $navigation_order ) {
										previous_post_link( '%link', '<i class="icon-salient-right-arrow-thin"></i>' ); 
									} else {
										next_post_link( '%link', '<i class="icon-salient-right-arrow-thin"></i>' ); 
									}

									?>
								</li> 
							<?php 
						} 

					} // end if not limitied to same cat.
					
					?>   
					                             
				</ul>
				
			</div>
				
			<?php
		}
	}
}



/**
 * Portfolio Exclude External / Custom Grid Content Projects From Next/Prev
 *
 * @since 1.0
 */
 if ( ! is_admin() ) {
	 
	 add_filter( 'get_previous_post_where', 'so16495117_mod_adjacent_bis' );
	 add_filter( 'get_next_post_where', 'so16495117_mod_adjacent_bis' );
	 
	 if( ! function_exists('so16495117_mod_adjacent_bis') ) {
		 function so16495117_mod_adjacent_bis( $where ) {
			 
			 global $wpdb;
			 global $post;
			 
			 // if not on project exit early
			 if ( ! is_singular( 'portfolio' ) ) {
				 return $where; }
				 
				 $excluded_projects        = array();
				 $exlcuded_projects_string = '';
				 
				 $portfolio = array(
					 'post_type'      => 'portfolio',
					 'posts_per_page' => '-1',
				 );
				 $the_query = new WP_Query( $portfolio );
				 
				 if ( $the_query->have_posts() ) {
					 while ( $the_query->have_posts() ) {
						 
						 $the_query->the_post();
						 
						 $custom_project_link    = get_post_meta( $post->ID, '_nectar_external_project_url', true );
						 $custom_content_project = get_post_meta( $post->ID, '_nectar_portfolio_custom_grid_item', true );
						 $lightbox_only_item     = get_post_meta( $post->ID, '_nectar_portfolio_lightbox_only_grid_item', true);
						 
						 if ( ! empty( $custom_project_link ) || 
						 ! empty( $custom_content_project ) && $custom_content_project === 'on' ||
					   ! empty( $lightbox_only_item ) && $lightbox_only_item === 'on' ) {
							 $excluded_projects[] = $post->ID;
						 }
					 }
					 
					 $exlcuded_projects_string = implode( ',', $excluded_projects );
					 
					 wp_reset_postdata();
					 
					 if ( ! empty( $exlcuded_projects_string ) ) {
						 return $where . " AND p.ID NOT IN ($exlcuded_projects_string)";
					 } else {
						 return $where;
					 }
				 }
				 
			 }
		 }
	 }



/**
 * New category walker for portfolio filter
 *
 * @since 1.0
 */
if ( ! class_exists('Walker_Portfolio_Filter')) {
	class Walker_Portfolio_Filter extends Walker_Category {

		function start_el( &$output, $category, $depth = 0, $args = array(), $current_object_id = 0 ) {

			extract( $args );
			$cat_slug = esc_attr( $category->slug );
			$cat_slug = apply_filters( 'list_cats', $cat_slug, $category );

			$link = '<li><a href="#" data-filter=".' . strtolower( preg_replace( '/\s+/', '-', $cat_slug ) ) . '">';

			$cat_name = esc_attr( $category->name );
			$cat_name = apply_filters( 'list_cats', $cat_name, $category );

			$link .= $cat_name;

			if ( ! empty( $category->description ) ) {
				$link .= ' <span>' . wp_kses_post($category->description) . '</span>';
			}

			$link .= '</a>';

			$output .= $link;

		}
	}
}



/**
 * Get attachment based on supplied URL.
 *
 * @since 1.0
 */
if ( ! function_exists( 'fjarrett_get_attachment_id_from_url' ) ) {
	function fjarrett_get_attachment_id_from_url( $url ) {

		// Split the $url into two parts with the wp-content directory as the separator.
		$parse_url = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

		// Get the host of the current site and the host of the $url, ignoring www.
		$this_host = str_ireplace( 'www.', '', parse_url( esc_url( home_url() ), PHP_URL_HOST ) );
		$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

		// Return nothing if there aren't any $url parts or if the current host and $url host do not match.
		if ( ! isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host != $file_host ) ) {
			return;
		}

		// Now we're going to quickly search the DB for any attachment GUID with a partial path match.
		// Example: /uploads/2013/05/test-image.jpg
		global $wpdb;

		$prefix     = $wpdb->prefix;
		$attachment = $wpdb->get_col( $wpdb->prepare( 'SELECT ID FROM ' . $prefix . 'posts WHERE guid RLIKE %s;', $parse_url[1] ) );

		return ( ! empty( $attachment ) ) ? $attachment[0] : null;
	}
}


/**
 * Function to get the page link back to all portfolio items
 *
 * @since 1.0
 */
if ( ! function_exists( 'get_portfolio_page_link' ) ) {
	function get_portfolio_page_link( $post_id ) {
		
		global $wpdb;

		$post_id = sanitize_text_field( $post_id );
		
		$query_prepared = $wpdb->prepare( 
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_wp_page_template' AND meta_value = %s", 'template-portfolio.php'
		);
		
		$results = $wpdb->get_results($query_prepared);
		
		// safety net
		$page_id = null;

		foreach ( $results as $result ) {
			$page_id = $result->post_id;
		}

		return get_page_link( $page_id );
	}
}


/**
 * Verify that the page has the portfolio layout assigned
 *
 * @since 1.0
 */
if ( ! function_exists( 'verify_portfolio_page' ) ) {
	function verify_portfolio_page( $post_id ) {
		
		global $wpdb;

		$post_id = sanitize_text_field( $post_id );
		
		$query_prepared = $wpdb->prepare( 
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_wp_page_template' AND meta_value='template-portfolio.php' AND post_id = %s LIMIT 1",
			$post_id
		);
		$result = $wpdb->get_results($query_prepared);
	
		if ( ! empty( $result ) ) {
			return get_page_link( $result[0]->post_id );
		} else {
			return null;
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


/**
 * Video lightbox link
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_portfolio_video_popup_link' ) ) {

	function nectar_portfolio_video_popup_link( $post, $project_style, $video_embed, $video_m4v ) {

		$project_video_src  = null;
		$project_video_link = null;
		$video_markup       = null;

		if ( $video_embed ) {

			$project_video_src = $video_embed;

			if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $project_video_src, $video_match ) ) {

				// youtube
				$project_video_link = 'https://www.youtube.com/watch?v=' . $video_match[1];

			} elseif ( preg_match( '/player\.vimeo\.com\/video\/([0-9]*)/', $project_video_src, $video_match ) ) {

				// vimeo iframe
				$project_video_link = 'https://vimeo.com/' . $video_match[1] . '?iframe=true';

			} elseif ( preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/', $project_video_src, $video_match ) ) {

				// reg vimeo
				$project_video_link = 'https://vimeo.com/' . $video_match[5] . '?iframe=true';

			}
		} elseif ( $video_m4v ) {

			$project_video_src  = $video_m4v;
			$project_video_link = '#video-popup-' . $post->ID;

			$video_output = '[video preload="none" ';

			if ( ! empty( $video_m4v ) ) {
				$video_output .= 'mp4="' . $video_m4v . '" '; }

			$video_output .= ']';

			$video_markup = '<div id="video-popup-' . $post->ID . '" class="mfp-figure mfp-with-anim mfp-iframe-scaler"><div class="video">' . do_shortcode( $video_output ) . '</div></div>';
			
			// fancyBox3 uses raw browser player.
			global $nectar_options;
			
			if(defined('NECTAR_THEME_NAME') && ! empty( $video_m4v ) ) {
				  
				if( isset($nectar_options['lightbox_script']) && !empty($nectar_options['lightbox_script']) && $nectar_options['lightbox_script'] === 'fancybox' ) {
					$project_video_link = $video_m4v;
					$video_markup = null;
				}
			}
			
		}

		$popup_link_text = ( $project_style == '1' ) ? esc_html__( 'Watch Video', 'salient-portfolio' ) : '';

		 return $video_markup . '<a href="' . esc_url($project_video_link) . '" class="pretty_photo default-link" >' . $popup_link_text . '</a>';
		 
	}
}



/**
 * Adds a body class when removing default project header
 *
 * @since 1.6
 */
add_filter( 'body_class','salient_portfolio_single_remove_dh_bodyclass' );

function salient_portfolio_single_remove_dh_bodyclass( $classes ) {
	
	if( is_singular( 'portfolio' ) && 
	class_exists('Salient_Portfolio_Single_Layout') && 
	false === Salient_Portfolio_Single_Layout::$default_header ) {
		$classes[] = 'remove-default-project-header';
	} 
	
	return $classes;
}


/**
 * Adds a body class when removing default project header
 *
 * @since 1.7
 */
add_action('wp', 'salient_portfolio_modify_single_feed');

if( !function_exists('salient_portfolio_modify_single_feed') ) {
	function salient_portfolio_modify_single_feed() {
		if( is_singular('portfolio') ) {
			remove_action('wp_head', 'feed_links_extra', 3 );
		}
	}
}
