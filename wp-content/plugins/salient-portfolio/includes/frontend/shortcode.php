<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Portfolio shortcode.
 *
 * @since 1.0
 */
if( !function_exists('nectar_portfolio_processing') ) {
	
	function nectar_portfolio_processing($atts, $content = null) {
		
		extract(shortcode_atts(array(
			"layout" => '3', 
			'category' => 'all', 
			'project_style' => '1', 
			'project_offset' => '0', 
			'bypass_image_cropping' => '', 
			'item_spacing' => 'default',
			'load_in_animation' => 'none',
			'starting_category' => '', 
			'filter_alignment' => 'default', 
			'filter_color' => 'default',
			'masonry_style' => '0', 
			'enable_sortable' => '0', 
			'pagination_type' => '', 
			'constrain_max_cols' => 'false', 
			'remove_column_padding' => 'false', 
			'horizontal_filters' => '0',
			'lightbox_only' => '0', 
			'enable_pagination' => '0', 
			'projects_per_page' => '-1'), $atts));   
			
			global $post;
			global $nectar_options;
			
			// Calculate cols.
			switch($layout){
				case '2':
				$cols = 'cols-2';
				break; 
				case '3':
				$cols = 'cols-3';
				break; 
				case '4':
				$cols = 'cols-4';
				break; 
				case 'fullwidth':
				$cols = 'elastic';
				break; 
				case 'constrained_fullwidth':
				$cols = 'elastic';
				break; 
			}
			
			switch($cols){
				case 'cols-2':
				$span_num = 'span_6';
				break; 
				case 'cols-3':
				$span_num = 'span_4';
				break; 
				case 'cols-4':
				$span_num = 'span_3';
				break; 
				case 'elastic':
				$span_num = 'elastic-portfolio-item';
				break; 
				
			}

			// Forced project style change when using delay ks.
			if( isset($nectar_options['delay-js-execution']) && 
				'1' === $nectar_options['delay-js-execution'] &&
				$project_style === '6' ) {
				
				$delay_js_devices = (isset( $nectar_options['delay-js-execution-devices'] )) ? $nectar_options['delay-js-execution-devices'] : 'mobile';

				if( wp_is_mobile() || 'all' === $delay_js_devices ) {
					$project_style = '3';
					if( $item_spacing === 'default' ) {
						$item_spacing = '15px';
					} 
				}
			}
			
			if($masonry_style === 'true' && 
			$project_style === '6' && 
			($layout != 'fullwidth' && $layout !== 'constrained_fullwidth' && $bypass_image_cropping !== 'true')) {
				
				$masonry_style = 'false';
			}
			
			$masonry_layout        = ($masonry_style === 'true') ? 'true' : 'false';
			$masonry_sizing_type   = (!empty($nectar_options['portfolio_masonry_grid_sizing']) && $nectar_options['portfolio_masonry_grid_sizing'] === 'photography') ? 'photography' : 'default';
			$constrain_col_class   = (!empty($constrain_max_cols) && $constrain_max_cols === 'true') ? ' constrain-max-cols' : null ;
			$infinite_scroll_class = null;
			
			// Disable masonry for default project style fullwidth.
			if( $project_style === '1' && $cols === 'elastic' && $bypass_image_cropping !== 'true') {
				$masonry_layout = 'false';
			}
			
			$filters_id = ($horizontal_filters === 'true') ? 'portfolio-filters-inline' : 'portfolio-filters';
			
			if($pagination_type === 'infinite_scroll' && $enable_pagination === 'true') {
				$infinite_scroll_class = ' infinite_scroll';
			}
			
			ob_start(); 
			
			if( $enable_sortable === 'true' && $horizontal_filters === 'true') {
				
				$filters_width = (!empty($nectar_options['header-fullwidth']) && $nectar_options['header-fullwidth'] === '1' && $cols == 'elastic') ? 'full-width-content ': 'full-width-section ';
				
				if($layout === 'constrained_fullwidth') {
					$filters_width = 'full-width-section';
				}
				
				?>
				<div class="<?php echo esc_attr( $filters_id ) . ' '; echo esc_attr( $filters_width );  if($layout === 'constrained_fullwidth') echo ' fullwidth-constrained '; if($span_num !== 'elastic-portfolio-item' || $layout === 'constrained_fullwidth') echo 'non-fw'; ?>" data-alignment="<?php echo esc_attr( $filter_alignment ); ?>" data-color-scheme="<?php echo strtolower( esc_attr( $filter_color ) ); ?>">
					<div class="container <?php if($span_num === 'elastic-portfolio-item') { echo 'normal-container'; } ?>">
						<?php if($filter_alignment !== 'center' && $filter_alignment !== 'left') { ?> <span id="current-category"><?php echo esc_html__( 'All', 'salient-portfolio'); ?></span> <?php } ?>
						<ul>
							<?php if($filter_alignment !== 'center' && $filter_alignment !== 'left') { ?> <li id="sort-label"><?php echo (!empty($nectar_options['portfolio-sortable-text'])) ? $nectar_options['portfolio-sortable-text'] : esc_html__( 'Sort Portfolio','salient-portfolio'); ?>:</li> <?php } ?>
								<li><a href="#" data-filter="*"><?php echo esc_html__( 'All', 'salient-portfolio'); ?></a></li>
								<?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'project-type', 'show_option_none'   => '', 'walker' => new Walker_Portfolio_Filter())); ?>
							</ul>
							<div class="clear"></div>
						</div>
					</div>
				<?php } 
				
				else if( $enable_sortable === 'true' && $horizontal_filters != 'true' ) { ?>
					<div class="<?php echo esc_attr( $filters_id );?>" data-color-scheme="<?php echo strtolower( esc_attr($filter_color ) ); ?>">
						<a href="#" data-sortable-label="<?php echo (!empty($nectar_options['portfolio-sortable-text'])) ? $nectar_options['portfolio-sortable-text'] : esc_html__( 'Sort Portfolio', 'salient-portfolio'); ?>" id="sort-portfolio"><span><?php echo (!empty($nectar_options['portfolio-sortable-text'])) ?  wp_kses_post( $nectar_options['portfolio-sortable-text'] ) : esc_html__( 'Sort Portfolio','salient-portfolio'); ?></span> <i class="fa fa-angle-down"></i></a> 
						<ul>
							<li><a href="#" data-filter="*"><?php echo esc_html__( 'All', 'salient-portfolio'); ?></a></li>
							<?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'project-type', 'show_option_none'   => '', 'walker' => new Walker_Portfolio_Filter())); ?>
						</ul>
					</div>
					<div class="clear portfolio-filter-clear"></div>
				<?php } ?>
				
				
				
				<div class="portfolio-wrap <?php if( $project_style === '1' && $span_num === 'elastic-portfolio-item') echo 'default-style ';  if($project_style === '6' && $span_num === 'elastic-portfolio-item') echo 'spaced'; ?>">
					
					<?php 
					$default_loader_class = (empty($nectar_options['loading-image']) && !empty($nectar_options['theme-skin']) && $nectar_options['theme-skin'] === 'ascend') ? 'default-loader' : null; 
					$default_loader       = (empty($nectar_options['loading-image']) && !empty($nectar_options['theme-skin']) && $nectar_options['theme-skin'] === 'ascend') ? '<span class="default-loading-icon spin"></span>' : null;?>
					
					<span class="portfolio-loading <?php echo esc_attr( $default_loader_class ); ?> <?php echo (!empty($nectar_options['loading-image-animation']) && !empty($nectar_options['loading-image'])) ? $nectar_options['loading-image-animation'] : null; ?>">  <?php echo wp_kses_post( $default_loader ); ?> </span>
					
					<?php 
					//incase only all was selected
					if($category === 'all') {
						$category = null;
					}
					
					
					?>
					
					<div class="row portfolio-items <?php if($masonry_layout === 'true') echo 'masonry-items'; else { echo 'no-masonry'; } ?> <?php if($layout == 'constrained_fullwidth') echo ' fullwidth-constrained '; echo esc_attr( $infinite_scroll_class ); ?> <?php echo esc_attr( $constrain_col_class ); ?>" <?php if($layout != 'fullwidth') echo 'data-rcp="'. esc_attr( $remove_column_padding ) .'"'; ?> data-masonry-type="<?php echo esc_attr( $masonry_sizing_type ) ; ?>" data-ps="<?php echo esc_attr($project_style); ?>" data-starting-filter="<?php echo esc_attr( $starting_category ); ?>" data-gutter="<?php echo esc_attr( $item_spacing ) ; ?>" data-categories-to-show="<?php echo esc_attr( $category ); ?>" data-bypass-cropping="<?php echo esc_attr( $bypass_image_cropping ); ?>" data-lightbox-only="<?php echo esc_attr( $lightbox_only ); ?>" data-col-num="<?php echo esc_attr( $cols ); ?>">
						<?php 
						
						
						$posts_per_page = (!empty($projects_per_page)) ? $projects_per_page : '-1';
						
						if ( get_query_var('paged') ) {
							$paged = get_query_var('paged');
						} elseif ( get_query_var('page') ) {
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}
						
						// Remove offset for pagination.
						if($enable_pagination === 'true') {
							$project_offset = '';
						}
						
						$portfolio_arr = array(
							'posts_per_page' => $posts_per_page,
							'post_type' => 'portfolio',
							'project-type'=> $category,
							'offset' => $project_offset, 
							'paged'=> $paged
						);

            $portfolio_arr = apply_filters( 'nectar_portfolio_query', $portfolio_arr );
						
						query_posts($portfolio_arr);
						
						if(have_posts()) : while(have_posts()) : the_post(); ?>
						
						<?php 
						
						$terms = get_the_terms($post->id,"project-type");
						$project_cats = NULL;
						
						if ( !empty($terms) ){
							foreach ( $terms as $term ) {
								$project_cats .= strtolower($term->slug) . ' ';
							}
						}
						
						
						global $post;
						
						$masonry_item_sizing = ($masonry_layout === 'true') ? get_post_meta($post->ID, '_portfolio_item_masonry_sizing', true) : null;
						if(empty($masonry_item_sizing) && $masonry_layout === 'true') {
							$masonry_item_sizing = 'regular';
						}
						
						$masonry_item_content_pos = get_post_meta($post->ID, '_portfolio_item_masonry_content_pos', true);
						if(empty($masonry_item_content_pos)) {
							$masonry_item_content_pos = 'middle';
						}
						
						$masonry_sizing_type = (!empty($nectar_options['portfolio_masonry_grid_sizing']) && $nectar_options['portfolio_masonry_grid_sizing'] === 'photography') ? 'photography' : 'default';
						
						// No tall size for photography.
						if($masonry_sizing_type == 'photography' && $masonry_item_sizing == 'tall') {
							$masonry_item_sizing = 'wide_tall';
						}
						
						$custom_project_link    = get_post_meta($post->ID, '_nectar_external_project_url', true);
						$the_project_link       = (!empty($custom_project_link)) ? $custom_project_link : esc_url(get_permalink());
						$project_excerpt        = get_post_meta($post->ID, '_nectar_project_excerpt', true);
						$project_image_caption  = get_post(get_post_thumbnail_id())->post_content;
						$project_image_caption  = strip_tags($project_image_caption);
						$project_accent_color   = get_post_meta($post->ID, '_nectar_project_accent_color', true);
						$project_title_color    = get_post_meta($post->ID, '_nectar_project_title_color', true);
						$project_subtitle_color = get_post_meta($post->ID, '_nectar_project_subtitle_color', true);
						$custom_project_class   = get_post_meta($post->ID, '_nectar_project_css_class', true);
						$lightbox_only_item     = get_post_meta($post->ID, '_nectar_portfolio_lightbox_only_grid_item', true);
						
						if(!empty($custom_project_class)) {
							$custom_project_class = ' ' . sanitize_text_field($custom_project_class);
						}
						
						$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
						
						if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
							
							$thumb_size = $thumb_size.'_photography';
							
							// No tall size in photography.
							if($thumb_size == 'tall_photography') {
								$thumb_size = 'wide_tall_photography';
							}
						}
						
						
						// Adaptive image sizing.
						$image_sizes = null;
						$image_srcset = null;
						
						// Still do basic check for custom thumbnail setup.
						if($masonry_layout === 'false' || $layout === '2' || $layout === '3' || $layout === '4') {
							if($layout === '2') {
								$image_sizes = 'sizes="(min-width: 1000px) 50vw, (min-width: 690px) 50vw, 100vw"';
							}
							else if($layout === '3') {
								$image_sizes = 'sizes="(min-width: 1000px) 33.3vw, (min-width: 690px) 50vw, 100vw"';
							} else if($layout === '4') {
								$image_sizes = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
							} else if($layout === 'fullwidth' && $constrain_max_cols !== 'true') {
								$image_sizes = 'sizes="(min-width: 1300px) 20vw, (min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
							} else if($layout === 'fullwidth' && $constrain_max_cols === 'true') {
								$image_sizes = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
							}
						}
						
						
						if(has_post_thumbnail()) {
							
							$featured_ID  = get_post_thumbnail_id( $post->ID );
							$image_meta   = wp_get_attachment_metadata($featured_ID);
							$regular_size = wp_get_attachment_image_src($featured_ID, $thumb_size, array('title' => ''));
							$small_size   = null;
							$large_size   = null;
							
							if($thumb_size === 'tall') {
								
								if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
									$small_size = wp_get_attachment_image_src($featured_ID, $thumb_size, array('title' => ''));
								}
								
							} else if($thumb_size === 'wide_tall') {
								
								if(!empty($image_meta['sizes']) && !empty($image_meta['sizes']['regular'])) {
									$small_size = wp_get_attachment_image_src($featured_ID,'regular', array('title' => ''));
								}
								
							} else if($thumb_size === 'wide_tall_photography') {
								
								if(!empty($image_meta['sizes']) && !empty($image_meta['sizes']['regular_photography'])) {
									$small_size = wp_get_attachment_image_src($featured_ID,'regular_photography', array('title' => ''));
								}
								
							} else if($thumb_size === 'wide' || $thumb_size === 'wide_photography' || $thumb_size === 'regular' || $thumb_size === 'regular_photography') {
								
								if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size.'_small'])) {
									$small_size = wp_get_attachment_image_src($featured_ID, $thumb_size.'_small', array('title' => ''));
								}
							}
							
							
							if($masonry_layout === 'false' || $layout === '2' || $layout === '3' || $layout === '4') {
								
								if($layout === '2') {
									$image_sizes = 'sizes="(min-width: 1000px) 50vw, (min-width: 690px) 50vw, 100vw"';
								} else if($layout === '3') {
									$image_sizes = 'sizes="(min-width: 1000px) 33.3vw, (min-width: 690px) 50vw, 100vw"';
								} else if($layout === '4') {
									$image_sizes = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
								} else if($layout === 'fullwidth' && $constrain_max_cols !== 'true') {
									$image_sizes = 'sizes="(min-width: 1300px) 20vw, (min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
								} else if($layout === 'fullwidth' && $constrain_max_cols === 'true') {
									$image_sizes = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
								}
								
								$regular_size = wp_get_attachment_image_src($featured_ID, 'portfolio-thumb', array('title' => ''));
								
								if(!empty($image_meta['sizes']) && !empty($image_meta['sizes']['portfolio-thumb_small'])) {
									$small_size = wp_get_attachment_image_src($featured_ID, 'portfolio-thumb_small', array('title' => ''));
								}
								if(!empty($image_meta['sizes']) && !empty($image_meta['sizes']['portfolio-thumb_large'])) {
									$large_size = wp_get_attachment_image_src($featured_ID, 'portfolio-thumb_large', array('title' => ''));
								}
								
								$large_size   = ($large_size) ? $large_size[0] .' 900w, ' : null; 
								$regular_size = ($regular_size) ? $regular_size[0] .' 600w, ' : null; 
								$small_size   = ($small_size) ? $small_size[0] .' 400w' : null; 
								
								$image_srcset = 'srcset="'.$large_size.$regular_size.$small_size.'"';
								
							} else if($masonry_layout == 'true' && $masonry_sizing_type != 'photography')  {
								
								if($constrain_max_cols != 'true') {
									
									// No column constraint.
									if($thumb_size == 'regular' || $thumb_size == 'tall') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 500w' : null; 
										$small_size   =  ($small_size) ? ', '. $small_size[0] .' 350w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1600px) 20vw, (min-width: 1300px) 25vw, (min-width: 1000px) 33.3vw, (min-width: 690px) 50vw, 100vw"';
										
									} else if($thumb_size == 'wide_tall') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 500w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1600px) 40vw, (min-width: 1300px) 50vw, (min-width: 1000px) 66.6vw, (min-width: 690px) 100vw, 100vw"';
									} 
									else if($thumb_size == 'wide') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 670w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1600px) 40vw, (min-width: 1300px) 50vw, (min-width: 1000px) 66.6vw, (min-width: 690px) 100vw, 100vw"';
									}
									
								} else {
									
									// Constrained to 4 cols.
									if($thumb_size === 'regular' || $thumb_size === 'tall') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 500w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 350w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
									} 
									else if($thumb_size === 'wide_tall') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 500w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1000px) 50vw, (min-width: 690px) 100vw, 100vw"';
										
									} 
									else if($thumb_size === 'wide') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 670w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1000px) 50vw, (min-width: 690px) 100vw, 100vw"';
									}
								}
								
							} else if($masonry_layout === 'true' && $masonry_sizing_type === 'photography') {
								
								if($constrain_max_cols !== 'true') {
									
									// No column constraint.
									if($thumb_size == 'regular_photography' || $thumb_size == 'tall_photography') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 450w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 350w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1600px) 16.6vw, (min-width: 1300px) 20vw, (min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
									} 
									else if($thumb_size === 'wide_tall_photography') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 450w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1600px) 33.3vw, (min-width: 1300px) 40vw, (min-width: 1000px) 50vw, 100vw"';
									} 
									else if( $thumb_size === 'wide_photography') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 700w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1600px) 33.3vw, (min-width: 1300px) 40vw, (min-width: 1000px) 50vw, 100vw"';
									}
								} else {
									// Constrained to 4 cols.
									if($thumb_size === 'regular_photography' || $thumb_size === 'tall_photography') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 450w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 350w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1000px) 20vw, (min-width: 690px) 50vw, 100vw"';
									} 
									else if($thumb_size === 'wide_tall_photography') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 450w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1000px) 40vw, (min-width: 690px) 100vw, 100vw"';
									} 
									else if($thumb_size === 'wide_photography') {
										
										$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null; 
										$small_size   = ($small_size) ? ', '. $small_size[0] .' 700w' : null; 
										$image_srcset = 'srcset="'.$regular_size.$small_size.'"';
										
										$image_sizes  = 'sizes="(min-width: 1000px) 40vw, (min-width: 690px) 100vw, 100vw"';
									}
								}
							}
						}
						
						
						
						
						?>
						
						<div class="col <?php echo esc_attr( $span_num ) . ' '. esc_attr( $masonry_item_sizing ) . esc_attr( $custom_project_class ); ?> element <?php echo esc_attr( $project_cats ); ?>"  data-project-cat="<?php echo esc_attr( $project_cats ); ?>" <?php if(!empty($project_accent_color)) { echo 'data-project-color="' . esc_attr( $project_accent_color ) .'"'; } else { echo 'data-default-color="true"';} ?> data-title-color="<?php echo esc_attr( $project_title_color ); ?>" data-subtitle-color="<?php echo esc_attr( $project_subtitle_color ); ?>">
							
							<div class="inner-wrap animated" data-animation="<?php echo esc_attr( $load_in_animation ); ?>">
								
								<?php //project style 1
								
								if($project_style == '1') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-1" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>">
										
										<?php
										
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										
										if($masonry_sizing_type == 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											// No tall size in photography.
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										// Custom thumbnail.
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" alt="'. get_the_title() .'" />';
										}
										
										else {
											
											if ( has_post_thumbnail() ) {
												
												// Create featured image with srcset.
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_width = $image_meta['sizes'][$thumb_size]['width'];
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												$image_src      = null;
												
												if($bypass_image_cropping === 'true') {
													
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												
												if(!empty($image_src)) $image_src = $image_src[0];
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
											} 
											
											// No image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} ?>
										
										<div class="work-info-bg"></div>
										<div class="work-info"> 
											
											<?php
											// Custom content.
											if($using_custom_content === 'on') {
												if(!empty($custom_project_link)) {
													echo '<a href="'. esc_attr( $the_project_link ) .'"></a>';
												}
												echo '<div class="vert-center"><div class="custom-content">' . do_shortcode($custom_content) . '</div></div></div></div>';
												// Default.
											} else { ?>
												
												<div class="vert-center">
													<?php 
													
													$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
													$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
													$video_m4v      =  get_post_meta($post->ID, '_nectar_video_m4v', true);
													
													// Video. 
													if( !empty($video_embed) || !empty($video_m4v) ) {
														
														echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
														
													} 
													
													//image
													else {
														if( isset($featured_image[0]) ) {
															echo '<a href="'. esc_url( $featured_image[0] ) .'"'; 
														} else {
															echo '<a href="#"'; 
														}
														
														
														if(!empty($project_image_caption)) {
															echo ' title="'. wp_kses_post( $project_image_caption ) .'"';
														}
														
														echo ' class="pretty_photo default-link">'.esc_html__("View Larger", 'salient-portfolio').'</a> ';
													}
													
													if( $lightbox_only !== 'true' && $lightbox_only_item !== 'on' ) {
														echo '<a class="default-link" href="' . esc_url( $the_project_link ) . '">'.esc_html__("More Details", 'salient-portfolio').'</a>'; 
													} ?>
													
												</div><!--/vert-center-->
											</div>
										</div><!--/work-item-->
										
										<div class="work-meta">
											<h4 class="title"><?php the_title(); ?></h4>
											
											<?php if(!empty($project_excerpt)) { 
												echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; 
											} 
											else if( !empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] === '1') {
												echo '<p>' . get_the_date() . '</p>';
											} ?>
											
										</div>
										<div class="nectar-love-wrap">
											<?php if( function_exists('nectar_love') ) { nectar_love(); } ?>
										</div><!--/nectar-love-wrap-->	
										
									<?php } 
									
								} // Project style 1. 
								
								
								// Project style 2.
								else if($project_style === '2') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-2" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>">
										
										<?php
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										//custom thumbnail
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" alt="'. get_the_title() .'" />';
										}
										else {
											
											if ( has_post_thumbnail() ) {
												
												//create featured image with srcset
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) { 
													$image_width = $image_meta['sizes'][$thumb_size]['width']; 
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												
												$image_src = null;
												
												if($bypass_image_cropping === 'true') {
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												
												if(!empty($image_src)) $image_src = $image_src[0];
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
												
											} 
											
											//no image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} ?>
										
										<div class="work-info-bg"></div>
										<div class="work-info">
											
											<?php
											//custom content
											if($using_custom_content == 'on') {
												if(!empty($custom_project_link)) echo '<a href="'. esc_url( $the_project_link ) .'"></a>';
												//default
											} else { ?>
												
												
												<?php if($lightbox_only != 'true' && $lightbox_only_item !== 'on' ) { ?>
													
													<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
													
												<?php } else {
													
													$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
													$video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
													$video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
													
													//video 
													if( !empty($video_embed) || !empty($video_m4v) ) {
														
														echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);	 
														
													} else { 
														
														if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
															<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
														<?php } else { ?>
															<a href="<?php echo esc_url( $featured_image[0] ); ?>" <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ).'" '; ?> class="pretty_photo"></a>  
														<?php }
														
													} 
													
												}
												
											} ?>
											
											
											<div class="vert-center">
												<?php 
												if(!empty($using_custom_content) && $using_custom_content == 'on') {
													echo '<div class="custom-content">' . do_shortcode($custom_content) . '</div>';
												} else { ?>	
													<h3><?php echo get_the_title(); ?></h3> 
													<?php if(!empty($project_excerpt)) { echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; } elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) echo '<p>' . get_the_date() . '</p>'; 
												} ?>
											</div><!--/vert-center-->
											
										</div>
									</div><!--work-item-->
									
								<?php } //project style 2 
								
								
								
								else if($project_style == '3') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-3" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>" data-text-align="<?php echo esc_attr( $masonry_item_content_pos ); ?>">
										
										<?php
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										//custom thumbnail
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" alt="'. get_the_title() .'" />';
										}
										else {
											
											if ( has_post_thumbnail() ) {
												
												//create featured image with srcset
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_width = $image_meta['sizes'][$thumb_size]['width'];
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												
												$image_src = null;
												
												if($bypass_image_cropping === 'true') {
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												
												if(!empty($image_src)) $image_src = $image_src[0];
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
												
											} 
											
											//no image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} ?>
										
										<div class="work-info-bg"></div>
										<div class="work-info">
											
											<?php
											//custom content
											if($using_custom_content === 'on') {
												if(!empty($custom_project_link)) {
													echo '<a href="'. esc_url( $the_project_link ) .'"></a>';
												}
												//default
											} else {
												
												if($lightbox_only != 'true' && $lightbox_only_item !== 'on' ) { ?>
													
													<a href="<?php echo esc_url( $the_project_link ) ; ?>"></a>
													
												<?php } else {
													
													$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
													$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
													$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
													
													//video 
													if( !empty($video_embed) || !empty($video_m4v) ) {
														
														echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
														
													} else {
														
														if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
															<a href="<?php echo esc_url( $the_project_link ) ; ?>"></a>
														<?php } else { ?>
															<a href="<?php echo esc_url( $featured_image[0] ); ?>"  <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ) .'" '; ?> class="pretty_photo"></a>
														<?php  } 
													} 
													
												} 
												
											} ?>
											
											<div class="vert-center">
												<?php 
												if(!empty($using_custom_content) && $using_custom_content === 'on') {
													echo '<div class="custom-content">' . do_shortcode($custom_content) . '</div>';
												} else { ?>	
													<h3><?php echo get_the_title(); ?> </h3> 
													<?php if(!empty($project_excerpt)) { echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; } elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) echo '<p>' . get_the_date() . '</p>'; ?>
												<?php } ?>
											</div><!--/vert-center-->
											
										</div>
									</div><!--work-item-->
									
								<?php } //project style 3 
								
								
								else if($project_style == '4') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-4" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>">
										
										<?php
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										//custom thumbnail
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" alt="'. get_the_title() .'" />';
										}
										else {
											
											if ( has_post_thumbnail() ) {
												
												//create featured image with srcset
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_width = $image_meta['sizes'][$thumb_size]['width'];
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												
												$image_src = null;
												
												if($bypass_image_cropping === 'true') {
													
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												
												if(!empty($image_src)) { 
													$image_src = $image_src[0];
												}
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
												
											} 
											
											//no image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} 
										
										if(!empty($using_custom_content) && $using_custom_content === 'on' && !empty($project_accent_color)) { 
											echo '<div class="work-info-bg"></div>';
										} ?>
										
										<div class="work-info">
											
											<?php
											
											//custom content
											if($using_custom_content === 'on') {
												if(!empty($custom_project_link)) {
													echo '<a href="'. esc_url( $the_project_link ) .'"></a>';
												}
												//default
											} else {
												
												if($lightbox_only != 'true' && $lightbox_only_item !== 'on') { ?>
													
													<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
													
												<?php } else {
													
													$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
													$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
													$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
													
													//video 
													if( !empty($video_embed) || !empty($video_m4v) ) {
														
														echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
														
													} else { 
														
														if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
															<a href="<?php echo esc_url( $the_project_link ) ; ?>"></a>
														<?php } else { ?>
															<a href="<?php echo esc_url( $featured_image[0] ); ?>" <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ) .'" '; ?> class="pretty_photo"></a>
														<?php } 
														
													} 
													
												}
												
											} 
											
											if(!empty($using_custom_content) && $using_custom_content === 'on') {
												echo '<div class="vert-center"><div class="custom-content">' . do_shortcode($custom_content) . '</div></div>';
											} else { ?>	
												
												<div class="bottom-meta">
													<h3><?php echo get_the_title(); ?> </h3> 
													<?php if(!empty($project_excerpt)) { echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; } elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) echo '<p>' . get_the_date() . '</p>'; ?>
												</div><!--/bottom-meta-->
												
											<?php } ?>
											
										</div>
									</div><!--work-item-->
									
								<?php } //project style 4 
								
								else if($project_style === '5' || $project_style === '6' && !defined( 'NECTAR_THEME_NAME' ) ) { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-3-alt" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>" data-text-align="<?php echo esc_attr( $masonry_item_content_pos ); ?>">
										
										<?php
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										//custom thumbnail
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" alt="'. get_the_title() .'" />';
										}
										else {
											
											if ( has_post_thumbnail() ) {
												
												//create featured image with srcset
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_width = $image_meta['sizes'][$thumb_size]['width'];
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												
												$image_src = null;
												
												if($bypass_image_cropping === 'true') {
													
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												if(!empty($image_src)) {
													$image_src = $image_src[0];
												}
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
												
											} 
											
											//no image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} ?>
										
										<div class="work-info-bg"></div>

											<?php 
											
											//custom content
											if($using_custom_content === 'on') {
												if(!empty($custom_project_link)) {
													echo '<a href="'. esc_url( $the_project_link ) .'"></a>';
												}
												//default
											} else {
												
												if($lightbox_only !== 'true' && $lightbox_only_item !== 'on') { ?>
													
													<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
													
												<?php } else {
													
													$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
													$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
													$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
													
													//video 
													if( !empty($video_embed) || !empty($video_m4v) ) {
														
														
														echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
														
													} else { 
														
														
														if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
															<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
														<?php } else { ?>
															<a href="<?php echo esc_url( $featured_image[0] ); ?>"  <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ) .'" '; ?> class="pretty_photo"></a>
														<?php } 
														
													}
													
												}
												
											} ?>
											
											<div class="work-info">
											<div class="vert-center">
												<?php 
												if(!empty($using_custom_content) && $using_custom_content === 'on') {
													echo '<div class="custom-content">' . do_shortcode($custom_content) . '</div>';
												} else { ?>	
													<h3><?php echo get_the_title(); ?> </h3> 
													<?php if(!empty($project_excerpt)) { echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; } elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) echo '<p>' . get_the_date() . '</p>'; ?>
													
												<?php }	?>
												
											</div><!--/vert-center-->
											
										</div>
									</div><!--work-item-->
									
								<?php } //project style 5 
								
								else if($project_style === '6') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-5" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>" data-text-align="<?php echo esc_attr( $masonry_item_content_pos ); ?>">
										
										<?php
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										$parallax_images  = get_post_meta($post->ID, '_nectar_3d_parallax_images', true); 
										
										if(!empty($parallax_images)) {
											
											echo '<div class="parallaxImg">';
											
											$images = explode( ',', $parallax_images);
											$i = 0;
											foreach ( $images as $attach_id ) {
												$i++;
												
												$img = wp_get_attachment_image_src(  $attach_id, $thumb_size );
												//add one sizer img
												if($i == 1) {
													echo '<img class="sizer skip-lazy" src="'. esc_url( $img[0] ) .'" alt="'.get_the_title().'" />';
												}
												echo '<div class="parallaxImg-layer" data-img="'. esc_url( $img[0] ) .'" Layer-'.$i.'"></div>';
												
											}
											
											echo '</div>';
											
										} 
										//no parallax images set
										else {
											
											if (!empty($custom_thumbnail)) {
												
												echo '<img class="sizer skip-lazy" src="'. esc_url( $custom_thumbnail ) .'" alt="'.get_the_title().'" />';
												
												echo '<div class="parallaxImg">';
												echo '<div class="parallaxImg-layer" data-img="'. esc_url( $custom_thumbnail ) .'"></div>';
												echo '<div class="parallaxImg-layer"><div class="bg-overlay"></div> <div class="work-meta"><div class="inner">';
												echo '	<h4 class="title"> '.get_the_title().'</h4>';
												
												if(!empty($project_excerpt)) {
													echo '<p>'. wp_kses_post( $project_excerpt ) .'</p>'; 
												}
												elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
													echo '<p>' . get_the_date() . '</p>'; 
												}
												
												echo '</div></div></div></div>';
												
											}
											
											else if ( has_post_thumbnail() ) {
												
												$thumbnail_id = get_post_thumbnail_id($post->ID);
												
												if($bypass_image_cropping === 'true') {
													$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full');
												} else {
													$thumbnail_url = wp_get_attachment_image_src($thumbnail_id,$thumb_size); 
												}
												
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
												
												if($bypass_image_cropping === 'true') {
													echo '<img class="sizer skip-lazy" src="'. esc_url( $thumbnail_url[0] ) .'" alt="'.get_the_title().'" />';
												} else {
													echo '<img class="sizer" src="' . SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/' . esc_attr( $no_image_size ) . '" alt="'.get_the_title().'" />';
												}
												
												echo '<div class="parallaxImg">';
												echo '<div class="parallaxImg-layer" data-img="'. esc_url( $thumbnail_url[0] ) .'"></div>';
												echo '<div class="parallaxImg-layer"><div class="bg-overlay"></div> <div class="work-meta"><div class="inner">';
												echo '	<h4 class="title"> '.get_the_title().'</h4>';
												
												if(!empty($project_excerpt)) {
													echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; 
												}
												elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
													echo '<p>' . get_the_date() . '</p>'; 
												}
												
												echo '</div></div></div></div>';
											} 
											
											//no image added
											else {
												switch($thumb_size) {
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
												
												echo '<img class="sizer skip-lazy" src="' . SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/' . esc_attr( $no_image_size ) . '" alt="'.get_the_title().'" />';
												
												echo '<div class="parallaxImg">';
												echo '<div class="parallaxImg-layer" data-img="'.get_template_directory_uri().'/img/'. esc_attr( $no_image_size ) .'"></div>';
												echo '<div class="parallaxImg-layer"><div class="bg-overlay"></div> <div class="work-meta"><div class="inner">';
												echo '	<h4 class="title"> '.get_the_title().'</h4>';
												
												if(!empty($project_excerpt)) {
													echo '<p>'. wp_kses_post( $project_excerpt ) .'</p>'; 
												}
												elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
													echo '<p>' . get_the_date() . '</p>';
												} 
												
												echo '</div></div></div></div>';
												
											}   
										}
										
										if($lightbox_only !== 'true' && $lightbox_only_item !== 'on') { ?>
											
											<a href="<?php echo esc_url( $the_project_link ) ; ?>"></a>
											
										<?php } else {
											
											$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
											$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
											$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
											
											//video 
											if( !empty($video_embed) || !empty($video_m4v) ) {
												
												echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
												
											} else { 
												
												
												if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
													<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
												<?php } else { ?>
													<a href="<?php echo esc_url( $featured_image[0] ); ?>"  <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ) .'" '; ?> class="pretty_photo"></a>
												<?php } 
												
											}
											
										}
										
										?>
										
										
									</div><!--work-item-->
									
									
									
								<?php } //project style 6 
								
								
								
								//project style 7
								else if($project_style === '7') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-2" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>">
										
										<?php
										
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										//custom thumbnail
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" alt="'. get_the_title() .'" />';
										}
										else {
											
											if ( has_post_thumbnail() ) {
												
												//create featured image with srcset
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_width = $image_meta['sizes'][$thumb_size]['width'];
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												
												$image_src = null;
												
												if($bypass_image_cropping === 'true') {
													
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												
												if(!empty($image_src)) $image_src = $image_src[0];
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
												
											} 
											
											//no image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} ?>
										
										<div class="work-info-bg"></div>
										<div class="work-info">
											
											<?php
											//custom content
											if($using_custom_content === 'on') {
												if(!empty($custom_project_link)) {
													echo '<a href="'. esc_url( $the_project_link ) .'"></a>';
												}
												//default
											} else { ?>
												
												
												<?php if($lightbox_only !== 'true' && $lightbox_only_item !== 'on') { ?>
													
													<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
													
												<?php } else {
													
													$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
													$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
													$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
													
													//video 
													if( !empty($video_embed) || !empty($video_m4v) ) {
														
														echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
														
													} else { 
														
														
														if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
															<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
														<?php } else { ?>
															<a href="<?php echo esc_url( $featured_image[0] ); ?>" <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ) .'" '; ?> class="pretty_photo"></a>
														<?php } 
														
													} 
													
												}
												
											} ?>
											
											
											<div class="vert-center">
												<?php 
												if(!empty($using_custom_content) && $using_custom_content === 'on') {
													echo '<div class="custom-content">' . do_shortcode($custom_content) . '</div>';
												} else { ?>	
													<h3><?php echo get_the_title(); ?></h3> 
													<?php if(!empty($project_excerpt)) { echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; } elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) echo '<p>' . get_the_date() . '</p>'; 
												} ?>
											</div><!--/vert-center-->
											
										</div>
									</div><!--work-item-->
									
								<?php } //project style 7 
								
								
								
								
								//project style 8
								else if($project_style === '8') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-2" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>">
										
										<?php
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size == 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										//custom thumbnail
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" alt="'. get_the_title() .'" />';
										}
										else {
											
											if ( has_post_thumbnail() ) {
												
												//create featured image with srcset
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_width = $image_meta['sizes'][$thumb_size]['width'];
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												
												$image_src = null;
												
												if($bypass_image_cropping === 'true') {
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												
												if(!empty($image_src)) {
													$image_src = $image_src[0];
												}
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
												
											} 
											
											//no image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} ?>
										
										<div class="work-info-bg"></div>
										<div class="work-info">
											
											<?php
											//custom content
											if($using_custom_content === 'on') {
												if(!empty($custom_project_link)) {
													echo '<a href="'. esc_url( $the_project_link ) .'"></a>';
												}
												//default
											} else { ?>
												
												
												<?php if($lightbox_only !== 'true' && $lightbox_only_item !== 'on' ) { ?>
													
													<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
													
												<?php } else {
													
													$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
													$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
													$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
													
													//video 
													if( !empty($video_embed) || !empty($video_m4v) ) {
														
														echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);	 
														
													} else { 
														
														
														if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
															<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
														<?php } else { ?>
															<a href="<?php echo esc_url( $featured_image[0] ); ?>" <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ) .'" '; ?> class="pretty_photo"></a>
														<?php } 
														
													} 
													
												}
												
											} ?>
											
											
											<div class="vert-center">
												<?php 
												if(!empty($using_custom_content) && $using_custom_content === 'on') {
													echo '<div class="custom-content">' . do_shortcode($custom_content) . '</div>';
												} else { ?>	
													<?php if(!empty($project_excerpt)) { echo '<p><span>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</span></p>'; } elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) echo '<p><span>' . get_the_date() . '</span></p>'; ?> 
													<h3><?php echo get_the_title(); ?></h3> 
													
													<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"/><line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"/></svg><span class="line"></span></span>
													
												<?php } ?>
											</div><!--/vert-center-->
											
										</div>
									</div><!--work-item-->
									
								<?php } //project style 8 
								
								
								
								else if($project_style === '9') { 
									
									$using_custom_content = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
									$custom_content       = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true); ?>
									
									<div class="work-item style-1" data-custom-content="<?php echo esc_attr( $using_custom_content ); ?>">
										
										<?php
										
										$thumb_size = (!empty($masonry_item_sizing)) ? $masonry_item_sizing : 'portfolio-thumb';
										if($masonry_sizing_type === 'photography' && !empty($masonry_item_sizing)) {
											$thumb_size = $thumb_size.'_photography';
											
											//no tall size in photography
											if($thumb_size === 'tall_photography') {
												$thumb_size = 'wide_tall_photography';
											}
										}
										
										//custom thumbnail
										$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
										
										if( !empty($custom_thumbnail) ){
											
											$image_srcset = '';
											$custom_thumbnail_id = fjarrett_get_attachment_id_from_url($custom_thumbnail); 
											
											if(!is_null($custom_thumbnail_id) && !empty($custom_thumbnail_id)) {
												
												if (function_exists('wp_get_attachment_image_srcset')) {
													
													$image_srcset_values = wp_get_attachment_image_srcset( $custom_thumbnail_id, 'full');
													if($image_srcset_values) {
														$image_srcset .= 'srcset="' . $image_srcset_values . '" ';
													}
												}
												
											}
											
											echo '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check( esc_url( $custom_thumbnail ) ).'" '. $image_srcset. $image_sizes .' alt="'. get_the_title() .'" />';
											
										}
										
										else {
											
											if ( has_post_thumbnail() ) {
												
												//create featured image with srcset
												$image_width  = null;
												$image_height = null;
												
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_width = $image_meta['sizes'][$thumb_size]['width'];
												}
												if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$thumb_size])) {
													$image_height = $image_meta['sizes'][$thumb_size]['height'];
												}
												
												$wp_img_alt_tag = get_post_meta( $featured_ID, '_wp_attachment_image_alt', true );
												
												$image_src = null;
												
												if($bypass_image_cropping === 'true') {
													$image_src = wp_get_attachment_image_src( $featured_ID, 'full');
													
													if (function_exists('wp_get_attachment_image_srcset')) {
														$image_srcset_values = wp_get_attachment_image_srcset($featured_ID, 'full');
														if($image_srcset_values) {
															$image_srcset = 'srcset="';
															$image_srcset .= $image_srcset_values;
															$image_srcset .= '"';
														}
													}
													
												} else {
													$image_src = wp_get_attachment_image_src( $featured_ID, $thumb_size);
												}
												
												if(!empty($image_src)) {
													$image_src = $image_src[0];
												}
												
												$project_featured_img = '<img class="size-'. esc_attr( $masonry_item_sizing ) .' skip-lazy" src="'. esc_url( $image_src ) .'" alt="'. esc_attr( $wp_img_alt_tag ) .'" height="'. esc_attr( $image_height ).'" width="'. esc_attr( $image_width ).'" ' . $image_srcset.' '.$image_sizes.' />';
												
												echo $project_featured_img; 
											} 
											//no image added
											else {
												nectar_default_portfolio_img_sizer( $thumb_size, get_the_title() );
											}   
											
										} ?>
										
										
										<div class="work-info"> 
											
											
											<?php if($lightbox_only != 'true' && $lightbox_only_item !== 'on') { ?>
												
												<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
												
											<?php } else {
												
												$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  							
												$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
												$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
												
												//video 
												if( !empty($video_embed) || !empty($video_m4v) ) {
													
													echo nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);	 
													
												} else { 
													
													
													if( !empty($custom_project_link) && strlen($custom_project_link) > 3 ) { ?>
														<a href="<?php echo esc_url( $the_project_link ); ?>"></a>
													<?php } else { ?>
														<a href="<?php echo esc_url( $featured_image[0] ); ?>" <?php if(!empty($project_image_caption)) echo ' title="'. wp_kses_post( $project_image_caption ) .'" '; ?> class="pretty_photo"></a>
													<?php } 
													
												} 
												
											} ?>
											
											
										</div>
										
									</div><!--work-item-->
									
									<div class="work-meta">
										<h4 class="title"><?php the_title(); ?></h4>
										
										<?php if(!empty($project_excerpt)) { echo '<p>'. wp_kses_post( do_shortcode($project_excerpt) ) .'</p>'; } elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) echo '<p>' . get_the_date() . '</p>'; ?>
										
									</div>
									
									
								<?php } //project style 9  ?>
								
								
							</div><!--/inner-wrap-->
						</div><!--/col-->
						
					<?php endwhile; endif; ?>
					
				</div><!--/portfolio-->
			</div><!--/portfolio wrap-->
			
			<?php 
			
			if( !empty($nectar_options['portfolio_extra_pagination']) && $nectar_options['portfolio_extra_pagination'] === '1' && $enable_pagination === 'true'){
				
				global $wp_query, $wp_rewrite;  
				
				$fw_pagination   = ($span_num == 'elastic-portfolio-item') ? 'fw-pagination': null;
				$masonry_padding = ($project_style != '2') ? 'alt-style-padding' : null;
				
				$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1; 
				$total_pages = $wp_query->max_num_pages;  
				
				$permalink_structure = get_option('permalink_structure');
				$query_type          = (count($_GET)) ? '&' : '?';	
				$get_compiled        = array_keys($_GET);
				$first_get_param     = reset($get_compiled); 
				
				if($first_get_param == 'paged') { 
					$query_type = '?';
				}
				
				if ($total_pages > 1) {  
					
					echo '<div id="pagination" class="'. esc_attr( $fw_pagination ).' '. esc_attr( $masonry_padding ) . esc_attr( $infinite_scroll_class ) .'" data-is-text="'.esc_html__("All items loaded", 'salient-portfolio').'">';
					
					echo paginate_links(array(  
						'base' => get_pagenum_link(1) .'%_%', 
						'format' => $query_type.'paged=%#%',
						'current' => $current,  
						'total' => $total_pages,  
					)); 
					
					echo  '</div>'; 
					
				}  
			}
			//regular pagination
			else if($enable_pagination === 'true'){
				
				$fw_pagination   = ($span_num === 'elastic-portfolio-item') ? 'fw-pagination': null;
				$masonry_padding = ($project_style === '1') ? 'alt-style-padding' : null;
				
				if( get_next_posts_link() || get_previous_posts_link() ) { 
					echo '<div id="pagination" class="'. esc_attr( $fw_pagination ) .' '. esc_attr( $masonry_padding ) . esc_attr( $infinite_scroll_class ) .'" data-is-text="'.esc_html__("All items loaded", 'salient-portfolio').'">
					<div class="prev">'.get_previous_posts_link('&laquo; Previous Entries').'</div>
					<div class="next">'.get_next_posts_link('Next Entries &raquo;','').'</div>
					</div>';
					
				}
			}  
			
			
			
			wp_reset_query();
			
			$portfolio_markup = ob_get_contents();
			
			ob_end_clean();
			
			
			return $portfolio_markup;
		}
		
	}
	
	add_shortcode('nectar_portfolio', 'nectar_portfolio_processing');
	
	
	
	
	
	
	
	//recent projects
	if( !function_exists('nectar_recent_projects') ) {
		
		function nectar_recent_projects($atts, $content = null) {
			
			extract(shortcode_atts(array(
				"title_labels" => 'false', 
				'project_style' => '', 
				'heading' => '', 
				'page_link_text' => '', 
				'display_project_excerpt' => '', 
				'custom_link_text' => '', 
				'project_offset' => '0', 
				'control_text_color' => 'dark', 
				'slider_text_color'=>'light', 
				'overlay_strength' => '0', 
				'autorotate' => '', 
				'slider_controls' => 'arrows', 
				'page_link_url' => '', 
				'hide_controls' => 'false', 
				'lightbox_only' => '0', 
				'number_to_display' => '6',
				'full_width' => 'false', 
				'category' => 'all'), $atts));   
				
				global $post; 
				global $nectar_options;
				global $nectar_love; 
				
				if( defined('NECTAR_THEME_NAME') ) {
					$nectar_options = get_nectar_theme_options(); 
				} else {
					$nectar_options = salient_get_default_portfolio_options(); 
				}
				
				
				$title_label_output         = null;
				$recent_projects_title_text = (!empty($nectar_options['carousel-title'])) ? $nectar_options['carousel-title'] : 'Recent Work';		
				$recent_projects_link_text  = (!empty($nectar_options['carousel-link'])) ? $nectar_options['carousel-link'] : 'View All Work';		
				$portfolio_link             = get_portfolio_page_link(get_the_ID()); 
				
				if(!empty($nectar_options['main-portfolio-link'])) {
					$portfolio_link = $nectar_options['main-portfolio-link'];
				}
				
				
				//project style
				if(empty($project_style) && $full_width === 'true') {
					$project_style = '2';
				} elseif(empty($project_style) && $full_width === 'false') {
					$project_style = '1';
				}
				
				
				$full_width_carousel = ($full_width == 'true') ? 'true': 'false';
				
				//incase only all was selected
				if($category === 'all') {
					$category = null;
				}
				
				$projects_to_display = (intval($number_to_display) == 0) ? '6' : $number_to_display; 
				
				if(!empty($heading)) {
					if($full_width_carousel === 'true'){
						$title_label_output = '<h2>'.$heading.'</h2>';
					} else {
						$title_label_output = '<h2>'.$heading;
						if(!empty($page_link_text)) {
							$title_label_output .= '<a href="'. $page_link_url.'" class="button"> / '. $page_link_text .'</a>';
						}
						$title_label_output .= '</h2>';
					}
				}
				
				//keep old label option to not break legacy users
				if($title_labels === 'true') { 
					$title_label_output = '<h2>'.$recent_projects_title_text;
					if(!empty($recent_projects_link_text) && strlen($recent_projects_link_text) > 2) {
						$title_label_output .= '<a href="'. $portfolio_link.'" class="button"> / '. $recent_projects_link_text .'</a>';
					}
					$title_label_output .= '</h2>';
				}
				
				$portfolio = array(
					'posts_per_page' => $projects_to_display,
					'post_type' => 'portfolio',
					'offset' => $project_offset, 
					'project-type'=> $category
				);
				
				$the_query = new WP_Query($portfolio);
				
				if(	$project_style !== 'fullscreen_zoom_slider') {
					
					if($full_width_carousel === 'true'){
						$arrow_markup = '<div class="controls"><a class="portfolio-page-link" href="'.$page_link_url.'"><i class="icon-salient-back-to-all"></i></a>
						<a class="carousel-prev" href="#"><i class="icon-salient-left-arrow-thin"></i></a>
						<a class="carousel-next" href="#"><i class="icon-salient-right-arrow-thin"></i></a></div>';
					} else {
						$arrow_markup = '<div class="control-wrap"><a class="carousel-prev" href="#"><i class="fa fa-angle-left"></i></a>
						<a class="carousel-next" href="#"><i class="fa fa-angle-right"></i></a></div>'; 
					} 
					
					if($hide_controls == 'true') {
						$arrow_markup = null;
					}
				}
				
				if ( $the_query->have_posts() && $project_style !== 'fullscreen_zoom_slider'  ) { 
					
					$default_style = ($project_style == '1') ? 'default-style' : null;
					
					$recent_projects_content = '<div class="carousel-wrap recent-work-carousel '.$default_style.'" data-ctc="'.$control_text_color.'" data-full-width="'.$full_width_carousel.'">
					
					<div class="carousel-heading"><div class="container">'.$title_label_output . $arrow_markup .'</div></div>
					
					<ul class="row portfolio-items text-align-center carousel" data-scroll-speed="800" data-easing="easeInOutQuart">';
				} 
				
				
				//standard layout
				if($project_style === '1'){
					
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							
							$project_image_caption        = get_post(get_post_thumbnail_id())->post_content;
							$project_image_caption        = strip_tags($project_image_caption);
							$project_image_caption_markup = null;
							if(!empty($project_image_caption)) {
								$project_image_caption_markup = ' title="'.$project_image_caption.'" ';
							}
							
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  
							$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
							$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
							$media          = null;
							$date           = null;
							$love           = ( function_exists('nectar_love') ) ? $nectar_love->add_love() : ''; 
							
							$custom_project_link = get_post_meta($post->ID, '_nectar_external_project_url', true);
							$the_project_link    = (!empty($custom_project_link)) ? $custom_project_link : esc_url(get_permalink());
							
							//video 
							if( !empty($video_embed) || !empty($video_m4v) ) {
								
								$media = nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);	 
								
							} 
							
							//image
							else {
								$media .= '<a href="'. $featured_image[0].'" class="pretty_photo default-link">'.esc_html__("View Larger", 'salient-portfolio').'</a> ';
							}
							
							$project_excerpt = get_post_meta($post->ID, '_nectar_project_excerpt', true);
							
							if(!empty($project_excerpt)) {
								$date = '<p>'.$project_excerpt.'</p>'; 
							} elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
								$date = '<p>' . get_the_date() . '</p>'; 
							} 
							
							$project_img = '<img src="'.SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
							if ( has_post_thumbnail() ) { 
								$project_img = get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); 
							} 
							
							//custom thumbnail
							$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
							
							if( !empty($custom_thumbnail) ){
								$project_img = '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check($custom_thumbnail).'" alt="'. get_the_title() .'" />';
							}
							
							$more_details_html = ($lightbox_only !== 'true') ? '<a class="default-link" href="' . $the_project_link . '">'.esc_html__("More Details", 'salient-portfolio').'</a>' : null; 
							
							$project_accent_color = get_post_meta($post->ID, '_nectar_project_accent_color', true);	 
							if(!empty($project_accent_color)) { 
								$project_accent_color_markup = 'data-project-color="' . $project_accent_color .'"'; 
							} else { 
								$project_accent_color_markup = 'data-default-color="true"';
							} 
							
							$project_title_color    = get_post_meta($post->ID, '_nectar_project_title_color', true);
							$project_subtitle_color = get_post_meta($post->ID, '_nectar_project_subtitle_color', true);
							$using_custom_content   = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
							$custom_content         = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true);
							
							$recent_projects_content .='<li class="col span_4" '.$project_accent_color_markup.' data-title-color="'.$project_title_color.'" data-subtitle-color="'.$project_subtitle_color.'">
							<div class="inner-wrap animated" data-animation="none">
							<div class="work-item" data-custom-content="'.$using_custom_content.'">' . $project_img . '
							
							<div class="work-info-bg"></div>
							<div class="work-info">';
							
							if($using_custom_content === 'on') {
								if(!empty($custom_project_link)) {
									echo '<a href="'.$the_project_link.'"></a>';
								}
								$recent_projects_content .= '<div class="vert-center"><div class="custom-content">' . do_shortcode($custom_content) . '</div></div>';
								//default
							} else { 
								$recent_projects_content .= '<div class="vert-center">' . $media . $more_details_html .'</div><!--/vert-center-->';
							}
							
							$recent_projects_content .= '</div>
							</div><!--work-item-->
							
							<div class="work-meta">
							<h4 class="title"> '. get_the_title() .'</h4>
							'.$date.'
							</div><div class="nectar-love-wrap">
							
							'.$love.'</div>
							
							<div class="clear"></div>
							</div>
							</li><!--/span_4-->';
							
						} 
						
					} 
					
				} 
				
				//alt project style
				elseif($project_style === '2') {
					
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							
							$project_image_caption        = get_post(get_post_thumbnail_id())->post_content;
							$project_image_caption        = strip_tags($project_image_caption);
							$project_image_caption_markup = null;
							
							if(!empty($project_image_caption)) {
								$project_image_caption_markup = ' title="'.$project_image_caption.'" ';
							} 		
							
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  
							$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
							$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
							$media          = null;
							$date           = null;
							$love           = ( function_exists('nectar_love') ) ? $nectar_love->add_love() : ''; 
							$margin         = ($full_width_carousel === 'true') ? 'no-margin' : null;
							
							$custom_project_link = get_post_meta($post->ID, '_nectar_external_project_url', true);
							$the_project_link    = (!empty($custom_project_link)) ? $custom_project_link : esc_url(get_permalink());
							$project_excerpt     = get_post_meta($post->ID, '_nectar_project_excerpt', true);
							
							if(!empty($project_excerpt)) {
								$date = '<p>'.$project_excerpt.'</p>'; 
							} elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
								$date = '<p>' . get_the_date() . '</p>'; 
							} 
							
							$project_img = '<img src="'.SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
							if ( has_post_thumbnail() ) { 
								$project_img = get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); 
							} 
							
							//custom thumbnail
							$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
							
							if( !empty($custom_thumbnail) ){
								$project_img = '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check($custom_thumbnail).'" alt="'. get_the_title() .'" />';
							}
							
							if($lightbox_only !== 'true') {
								$link_markup = '<a href="' . $the_project_link . '"></a>';
							} else {
								
								//video 
								if( !empty($video_embed) || !empty($video_m4v) ) {
									
									$link_markup = nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
									
								} 
								
								//image
								else {
									$link_markup = '<a href="'. $featured_image[0].'" '.$project_image_caption_markup.' class="pretty_photo"></a>';
								}
								
							}
							
							$project_accent_color = get_post_meta($post->ID, '_nectar_project_accent_color', true);	 
							if(!empty($project_accent_color)) { 
								$project_accent_color_markup = 'data-project-color="' . $project_accent_color .'"'; 
							} else { 
								$project_accent_color_markup = 'data-default-color="true"';
							} 
							$project_title_color    = get_post_meta($post->ID, '_nectar_project_title_color', true);
							$project_subtitle_color = get_post_meta($post->ID, '_nectar_project_subtitle_color', true);
							$using_custom_content   = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
							$custom_content         = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true);
							
							$recent_projects_content .='<li class="col span_4 '.$margin.'" '.$project_accent_color_markup.' data-title-color="'.$project_title_color.'" data-subtitle-color="'.$project_subtitle_color.'">
							
							<div class="work-item style-2" data-custom-content="'.$using_custom_content.'">' . $project_img . '
							
							<div class="work-info-bg"></div>
							<div class="work-info">
							
							'.$link_markup;
							
							if($using_custom_content === 'on') {
								if(!empty($custom_project_link)) {
									echo '<a href="'.$the_project_link.'"></a>';
								}
								$recent_projects_content .= '<div class="vert-center"><div class="custom-content">' . do_shortcode($custom_content) . '</div></div>';
								//default
							} else { 
								$recent_projects_content .= '<div class="vert-center"><h3>' . get_the_title() . '</h3> ' . $date.'</div><!--/vert-center-->';
							}
							
							$recent_projects_content .= '</div>
							</div><!--work-item-->
							
							</li><!--/span_4-->';
							
						}
						
					}
					
					
				}//full width
				
				
				elseif($project_style === '3') {
					
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							
							$project_image_caption        = get_post(get_post_thumbnail_id())->post_content;
							$project_image_caption        = strip_tags($project_image_caption);
							$project_image_caption_markup = null;
							if(!empty($project_image_caption)) {
								$project_image_caption_markup = ' title="'.$project_image_caption.'" '; 
							}
							
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  
							$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
							$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
							$media          = null;
							$date           = null;
							$love           = ( function_exists('nectar_love') ) ? $nectar_love->add_love() : ''; 
							$margin         = ($full_width_carousel === 'true') ? 'no-margin' : null;
							
							$custom_project_link = get_post_meta($post->ID, '_nectar_external_project_url', true);
							$the_project_link    = (!empty($custom_project_link)) ? $custom_project_link : esc_url(get_permalink());
							$project_excerpt     = get_post_meta($post->ID, '_nectar_project_excerpt', true);
							
							if(!empty($project_excerpt)) {
								$date = '<p>'.$project_excerpt.'</p>'; 
							} elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
								$date = '<p>' . get_the_date() . '</p>'; 
							} 
							
							$project_img = '<img src="'.SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
							if ( has_post_thumbnail() ) { 
								$project_img = get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); 
							} 
							
							//custom thumbnail
							$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
							
							if( !empty($custom_thumbnail) ){
								$project_img = '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check($custom_thumbnail).'" alt="'. get_the_title() .'" />';
							}
							
							if($lightbox_only !== 'true') {
								$link_markup = '<a href="' . $the_project_link . '"></a>';
							} else {
								
								//video 
								if( !empty($video_embed) || !empty($video_m4v) ) {
									
									$link_markup = nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
								} 
								
								//image
								else {
									$link_markup = '<a href="'. $featured_image[0].'" '.$project_image_caption_markup.' class="pretty_photo"></a>';
								}
								
							}
							
							$project_accent_color = get_post_meta($post->ID, '_nectar_project_accent_color', true);	 
							if(!empty($project_accent_color)) { 
								$project_accent_color_markup = 'data-project-color="' . $project_accent_color .'"'; 
							} else { 
								$project_accent_color_markup = 'data-default-color="true"';
							} 
							$project_title_color    = get_post_meta($post->ID, '_nectar_project_title_color', true);
							$project_subtitle_color = get_post_meta($post->ID, '_nectar_project_subtitle_color', true);
							$using_custom_content   = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
							$custom_content         = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true);
							
							$recent_projects_content .='<li class="col span_4 '.$margin.'" '.$project_accent_color_markup.' data-title-color="'.$project_title_color.'" data-subtitle-color="'.$project_subtitle_color.'">
							
							<div class="work-item style-3" data-custom-content="'.$using_custom_content.'">' . $project_img . '
							
							<div class="work-info-bg"></div>
							<div class="work-info">
							
							'.$link_markup;
							
							if(!empty($using_custom_content) && $using_custom_content === 'on') {
								if(!empty($custom_project_link)) {
									echo '<a href="'.$the_project_link.'"></a>';
								}
								$recent_projects_content .= '<div class="vert-center"><div class="custom-content">' . do_shortcode($custom_content) . '</div></div>';
								//default
							} else { 
								$recent_projects_content .= '<div class="vert-center"><h3>' . get_the_title() . '</h3>' . $date.'</div><!--/vert-center-->';
							}
							
							
							$recent_projects_content .= '</div>
							</div><!--work-item-->
							
							</li><!--/span_4-->';
							
						}
						
					}
					
				} //project style 3
				
				
				elseif($project_style === '4') {
					
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							
							$project_image_caption        = get_post(get_post_thumbnail_id())->post_content;
							$project_image_caption        = strip_tags($project_image_caption);
							$project_image_caption_markup = null;
							if(!empty($project_image_caption)) {
								$project_image_caption_markup = ' title="'.$project_image_caption.'" '; 
							}
							
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  
							$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
							$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
							$media          = null;
							$date           = null;
							$love           = ( function_exists('nectar_love') ) ? $nectar_love->add_love() : ''; 
							$margin          = ($full_width_carousel == 'true') ? 'no-margin' : null;
							
							$custom_project_link = get_post_meta($post->ID, '_nectar_external_project_url', true);
							$the_project_link    = (!empty($custom_project_link)) ? $custom_project_link : esc_url(get_permalink());
							$project_excerpt     = get_post_meta($post->ID, '_nectar_project_excerpt', true);
							
							if(!empty($project_excerpt)) {
								$date = '<p>'.$project_excerpt.'</p>'; 
							} elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
								$date = '<p>' . get_the_date() . '</p>'; 
							} 
							
							$project_img = '<img src="'.SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/no-portfolio-item-small.jpg" alt="no image added yet." />';
							if ( has_post_thumbnail() ) { 
								$project_img = get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); 
							} 
							
							//custom thumbnail
							$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
							
							if( !empty($custom_thumbnail) ){
								$project_img = '<img class="custom-thumbnail skip-lazy" src="'.nectar_ssl_check($custom_thumbnail).'" alt="'. get_the_title() .'" />';
							}
							
							if($lightbox_only !== 'true') {
								$link_markup = '<a href="' . $the_project_link . '"></a>';
							} else {
								
								//video 
								if( !empty($video_embed) || !empty($video_m4v) ) {
									
									$link_markup = nectar_portfolio_video_popup_link($post, $project_style, $video_embed, $video_m4v);
									
								} 
								
								//image
								else {
									$link_markup = '<a href="'. $featured_image[0].'" '.$project_image_caption_markup.' class="pretty_photo"></a>';
								}
								
							}
							
							$project_accent_color = get_post_meta($post->ID, '_nectar_project_accent_color', true);	 
							if(!empty($project_accent_color)) { 
								$project_accent_color_markup = 'data-project-color="' . $project_accent_color .'"'; 
							} else { 
								$project_accent_color_markup = 'data-default-color="true"';
							} 
							
							$project_title_color    = get_post_meta($post->ID, '_nectar_project_title_color', true);
							$project_subtitle_color = get_post_meta($post->ID, '_nectar_project_subtitle_color', true);
							$using_custom_content   = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item', true); 
							$custom_content         = get_post_meta($post->ID, '_nectar_portfolio_custom_grid_item_content', true);
							
							$recent_projects_content .='<li class="col span_4 '.$margin.'" '.$project_accent_color_markup.' data-title-color="'.$project_title_color.'" data-subtitle-color="'.$project_subtitle_color.'">
							
							<div class="work-item style-4" data-custom-content="'.$using_custom_content.'">' . $project_img . '
							
							<div class="work-info">
							
							'.$link_markup;
							
							if(!empty($using_custom_content) && $using_custom_content === 'on') {
								if(!empty($custom_project_link)) {
									echo '<a href="'.$the_project_link.'"></a>';
								}
								$recent_projects_content .= '<div class="vert-center"><div class="custom-content">' . do_shortcode($custom_content) . '</div></div>';
								//default
							} else { 
								$recent_projects_content .= '<div class="bottom-meta"><h3>' . get_the_title() . '</h3>' . $date.'</div><!--/bottom-meta-->';
							}
							
							$recent_projects_content .= '</div>
							</div><!--work-item-->
							
							</li><!--/span_4-->';
							
						}
						
					}
					
				} //project style 4
				
				
				if ( $the_query->have_posts() && $project_style !== 'fullscreen_zoom_slider' ) {
					$recent_projects_content .= '</ul><!--/carousel--></div><!--/carousel-wrap-->';
				}
				
				
				//fullscreen
				if($project_style === 'fullscreen_zoom_slider') {
					
					$recent_projects_content = '<div class="nectar_fullscreen_zoom_recent_projects" data-autorotate="'.$autorotate.'" data-slider-text-color="'.$slider_text_color.'" data-slider-controls="'.$slider_controls.'" data-overlay-opacity="'.$overlay_strength.'"><div class="project-slides">';
					
					$projcount = 0;
					
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							
							$project_image_caption        = get_post(get_post_thumbnail_id())->post_content;
							$project_image_caption        = strip_tags($project_image_caption);
							$project_image_caption_markup = null;
							if(!empty($project_image_caption)) {
								$project_image_caption_markup = ' title="'.$project_image_caption.'" ';
							}
							
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );  
							$video_embed    = get_post_meta($post->ID, '_nectar_video_embed', true);
							$video_m4v      = get_post_meta($post->ID, '_nectar_video_m4v', true);
							$media          = null;
							$date           = null;
							
							$custom_project_link = get_post_meta($post->ID, '_nectar_external_project_url', true);
							$the_project_link    = (!empty($custom_project_link)) ? $custom_project_link : esc_url(get_permalink());
							$project_excerpt     = get_post_meta($post->ID, '_nectar_project_excerpt', true);
							
							$fullscreen_slider_excerpt = '';
							
							if($display_project_excerpt === 'true') {
								$fullscreen_slider_excerpt = (!empty($project_excerpt)) ? '<p>'.$project_excerpt.'</p>' : '';
							}
							
							if(!empty($project_excerpt)) {
								$date = '<p>'.$project_excerpt.'</p>'; 
							} elseif(!empty($nectar_options['portfolio_date']) && $nectar_options['portfolio_date'] == 1) {
								$date = '<p>' . get_the_date() . '</p>'; 
							} 
							
							$project_img = SALIENT_PORTFOLIO_PLUGIN_PATH . '/img/no-portfolio-item-small.jpg';
							if ( has_post_thumbnail() ) { 
								$project_img = get_the_post_thumbnail_url($post->ID, 'full', array('title' => '')); 
							} 
							
							//custom thumbnail
							$custom_thumbnail = get_post_meta($post->ID, '_nectar_portfolio_custom_thumbnail', true); 
							
							if( !empty($custom_thumbnail) ){
								$project_img = nectar_ssl_check($custom_thumbnail);
							}
							
							$project_accent_color = get_post_meta($post->ID, '_nectar_project_accent_color', true);	 
							if(empty($project_accent_color)) { 
								$project_accent_color = '#000000'; 
							} 
							$project_title_color    = get_post_meta($post->ID, '_nectar_project_title_color', true);
							$project_subtitle_color = get_post_meta($post->ID, '_nectar_project_subtitle_color', true);
							$active_class           = ($projcount == 0) ? 'current': 'next';
							
							if(!empty($custom_link_text)) {
								$fullscreen_slider_link_text = $custom_link_text;
							} else {
								$fullscreen_slider_link_text = esc_html__("View Project", 'salient-portfolio');
							}
							
							$recent_projects_content .='<div class="project-slide '.$active_class.'">';
							$recent_projects_content .= '<div class="bg-outer-wrap"><div class="bg-outer"><div class="bg-inner-wrap" style="background-color: '.$project_accent_color.';"><div class="slide-bg" style="background-image:url('.$project_img.')"></div></div></div></div>';
							$recent_projects_content .= '<div class="project-info"><div class="container normal-container"><h1>'. get_the_title(). '</h1> '.$fullscreen_slider_excerpt.' <a href="'.$the_project_link.'">' . $fullscreen_slider_link_text . '</a></div></div>';
							$recent_projects_content .= '</div><!--project slide-->';
							
							$projcount++;
							
						}
						
					}
					
					if($slider_controls === 'both' || $slider_controls === 'arrows') {
						$next_prev_markup = '<div class="zoom-slider-controls"><a class="prev" href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a><a class="next" href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div>';
					} else {
						$next_prev_markup = null;
					}
					
					$recent_projects_content .= '</div><div class="container normal-container">'.$next_prev_markup.'</div></div><!--nectar_fullscreen_zoom_recent_projects-->';
				}	
				
				
				wp_reset_postdata();
				
				
				
				return $recent_projects_content; 
				
				
			}
			
		}
		
		add_shortcode('recent_projects', 'nectar_recent_projects');
