<?php

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(
  array("title_labels" => 'false',
  'category' => 'all',
  'order' => 'DESC',
  'orderby' => 'date',
  'hover_shadow_type' => 'default',
  'button_color' => '',
  'bg_overlay' => '',
  'slider_size' => '600',
  'mlf_navigation_location' => 'side',
  'large_featured_padding' => '10%',
  'color_scheme' => 'light',
  'auto_rotate' => 'none',
  'slider_above_text' => '',
  'multiple_large_featured_num' => '4',
  'posts_per_page' => '4',
  'columns' => '4',
  'style' => 'default',
  'post_offset' => '0',
  'image_loading' => 'normal',
  'blog_remove_post_date' => '',
  'blog_remove_post_author' => '',
  'blog_remove_post_comment_number' => '',
  'blog_remove_post_nectar_love' => ''
), $atts));

global $post;
global $nectar_options;

if( isset($_GET['vc_editable']) ) {
  $nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
  $nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
  if( $nectar_using_VC_front_end_editor ) {
    $auto_rotate = 'none';
  }
}

$posts_page_id    = get_option('page_for_posts');
$posts_page       = get_page($posts_page_id);
$posts_page_title = $posts_page->post_title;
$posts_page_link  = get_page_uri($posts_page_id);

$recent_posts_title_text = (!empty($nectar_options['recent-posts-title'])) ? $nectar_options['recent-posts-title'] :'Recent Posts';
$recent_posts_link_text  = (!empty($nectar_options['recent-posts-link'])) ? $nectar_options['recent-posts-link'] :'View All Posts';

if( $blog_remove_post_date === 'true' ) {
  $blog_remove_post_date = '1';
}
if( $blog_remove_post_author === 'true' ) {
  $blog_remove_post_author = '1';
}
if( $blog_remove_post_comment_number === 'true' ) {
  $blog_remove_post_comment_number = '1';
}
if( $blog_remove_post_nectar_love === 'true' ) {
  $blog_remove_post_nectar_love = '1';
}

// Incase only all was selected.
if( $category === 'all' ) {
  $category = null;
}

// Get theme skin.
$stored_theme_skin = $nectar_options['theme-skin'];

if( class_exists('NectarThemeManager') ) {
	$stored_theme_skin = NectarThemeManager::$skin;
}

if( $style !== 'slider' &&
  $style !== 'slider_multiple_visible' &&
  $style !== 'single_large_featured' &&
  $style !== 'multiple_large_featured') {

    ob_start();

    if( $title_labels === 'true' ) {
      echo '<h2 class="uppercase recent-posts-title">'. wp_kses_post( $recent_posts_title_text ) .'<a href="'. $posts_page_link .'" class="button"> / '. wp_kses_post( $recent_posts_link_text ) .'</a></h2>';
    }

    $modded_style = $style;

    if( $style === 'list_featured_first_row_tall' ) {
      $modded_style = 'list_featured_first_row';
    }
    ?>

    <div class="row blog-recent columns-<?php echo esc_attr( $columns ); ?>" data-style="<?php echo esc_attr( $modded_style ); ?>" data-color-scheme="<?php echo esc_attr( $color_scheme ); ?>" data-remove-post-date="<?php echo esc_attr( $blog_remove_post_date ); ?>" data-remove-post-author="<?php echo esc_attr( $blog_remove_post_author ); ?>" data-remove-post-comment-number="<?php echo esc_attr( $blog_remove_post_comment_number ); ?>" data-remove-post-nectar-love="<?php echo esc_attr($blog_remove_post_nectar_love ); ?>">

      <?php

        $r_post_count = 0;
				
        if( $orderby !== 'view_count' ) {

          $recentBlogPosts = array(
            'showposts' => $posts_per_page,
            'category_name' => $category,
            'ignore_sticky_posts' => 1,
            'offset' => $post_offset,
            'order' => $order,
            'orderby' => $orderby,
            'tax_query' => array(
              array( 'taxonomy' => 'post_format',
              'field' => 'slug',
              'terms' => array('post-format-link'),
              'operator' => 'NOT IN'
            )
          )
        );

        } else {

          $recentBlogPosts = array(
            'showposts' => $posts_per_page,
            'category_name' => $category,
            'ignore_sticky_posts' => 1,
            'offset' => $post_offset,
            'order' => $order,
            'orderby' => 'meta_value_num',
            'meta_key' => 'nectar_blog_post_view_count',
            'tax_query' => array(
              array( 'taxonomy' => 'post_format',
              'field' => 'slug',
              'terms' => array('post-format-link'),
              'operator' => 'NOT IN'
            )
          )
        );

      }
			
			
			// Allow link posts in certian styles.
			if( $style === 'classic_enhanced' || 
			    $style === 'classic_enhanced_alt' ) {
					unset($recentBlogPosts['tax_query']);
			}


      $recent_posts_query = new WP_Query($recentBlogPosts);

      if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post();

      $r_post_count++;

      if( $columns === '4' ) {
        $col_num = 'span_3';
      } else if($columns === '3') {
        $col_num = 'span_4';
      } else if($columns === '2') {
        $col_num = 'span_6';
      } else {
        $col_num = 'span_12';
      }

      ?>

      <div <?php post_class('col'. ' '. $col_num); ?> >

        <?php

          $wp_version = floatval(get_bloginfo('version'));

          if( $style === 'default' ) {

            if( get_post_format() === 'video' ){

                $video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
                $video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
                $video_ogv = get_post_meta($post->ID, '_nectar_video_ogv', true);
                $video_poster = get_post_meta($post->ID, '_nectar_video_poster', true);

                  if( !empty($video_embed) || !empty($video_m4v) ){

                    $wp_version = floatval(get_bloginfo('version'));

                    //video embed
                    if( !empty( $video_embed ) ) {

                         echo '<div class="video">' . do_shortcode($video_embed) . '</div>';

                    }
                    //self hosted video
                    else {

                        if(!empty($video_m4v) || !empty($video_ogv)) {

                        $video_output = '[video ';

                        if(!empty($video_m4v)) { $video_output .= 'mp4="'. esc_attr($video_m4v) .'" '; }
                        if(!empty($video_ogv)) { $video_output .= 'ogv="'. esc_attr($video_ogv) .'"'; }

                        $video_output .= ' poster="'.esc_attr($video_poster).'"]';

                          echo '<div class="video">' . do_shortcode($video_output) . '</div>';
                        }

                    }

                 } // endif for if there's a video


            } //endif for post format video

            else if( get_post_format() === 'audio' ){ ?>

              <div class="audio-wrap">
                <?php

                  $audio_mp3 = get_post_meta($post->ID, '_nectar_audio_mp3', true);
                  $audio_ogg = get_post_meta($post->ID, '_nectar_audio_ogg', true);

                  if(!empty($audio_ogg) || !empty($audio_mp3)) {

                    $audio_output = '[audio ';

                    if(!empty($audio_mp3)) { $audio_output .= 'mp3="'. esc_attr($audio_mp3) .'" '; }
                    if(!empty($audio_ogg)) { $audio_output .= 'ogg="'. esc_attr($audio_ogg) .'"'; }

                    $audio_output .= ']';

                    echo do_shortcode($audio_output);
                  }
                 ?>
              </div><!--/audio-wrap-->
            <?php }

            else if( get_post_format() === 'gallery' ) {

                $gallery_ids = nectar_grab_ids_from_gallery(); ?>

                <div class="flex-gallery">
                     <ul class="slides">
                      <?php
                      foreach( $gallery_ids as $image_id ) {
                           echo '<li>' . wp_get_attachment_image($image_id, 'portfolio-thumb', false) . '</li>';
                      } ?>
                      </ul>
                   </div><!--/gallery-->

             <?php

            }

            else {

              if ( has_post_thumbnail() ) {
                echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')) . '</a>';
              }

            }

          ?>

            <div class="post-header">
              <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <span class="meta-author"><?php the_author_posts_link(); ?> </span> <span class="meta-category"> | <?php the_category(', '); ?> </span> <span class="meta-comment-count"> | <a href="<?php comments_link(); ?>">
              <?php comments_number( esc_html__( 'No Comments','salient'), esc_html__( 'One Comment','salient'), '% '. esc_html__( 'Comments','salient') ); ?></a> </span>
            </div>

            <?php
            $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 30;
            echo '<div class="excerpt">' . nectar_excerpt($excerpt_length) . '</div>';

          } // end default style

          else if( $style === 'minimal' ) { ?>

            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>"></a>
            <div class="post-header">
              <span class="meta"> <span> <?php echo get_the_date() . '</span> ' . esc_html__( 'in','salient-core'); ?> <?php the_category(', '); ?> </span>
              <h3 class="title"><?php the_title(); ?></h3>
            </div>
            <?php
              $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 30;
              echo '<div class="excerpt">' . nectar_excerpt($excerpt_length) . '</div>';
            ?>
            <span><?php echo esc_html__( 'Read More','salient'); ?> <i class="icon-button-arrow"></i></span>

          <?php } // end minimal style

          else if( $style === 'title_only' ) { ?>

            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>"></a>
            <div class="post-header">
              <span class="meta"> <?php echo get_the_date(); ?> </span>
              <h2 class="title"><?php the_title(); ?></h2>
            </div>

          <?php } // end title only style

          else if( $style === 'list_featured_first_row' || $style === 'list_featured_first_row_tall' ) { ?>

            <?php

            $list_heading_tag          = ($r_post_count <= $columns) ? 'h3' : 'h5';
            $list_featured_image_size  = ($r_post_count <= $columns) ? 'portfolio-thumb' : 'nectar_small_square';
            $list_featured_image_class = ($r_post_count <= $columns) ? 'featured' : 'small';

            echo '<a class="full-post-link" href="' . esc_url(get_permalink()) . '" aria-label="'.get_the_title().'"></a>';

            if ( has_post_thumbnail() ) {

              if( $style === 'list_featured_first_row_tall' && $r_post_count <= $columns ) {

                if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() || 
								     property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) {
                    
                  $lazy_escaped_markup = nectar_lazy_loaded_image_markup(get_post_thumbnail_id(), 'medium_featured');
      
                } else {
                  $lazy_escaped_markup = get_the_post_thumbnail($post->ID, 'medium_featured', array('title' => ''));
                }
                 echo'<a href="' . esc_url(get_permalink()) . '" aria-label="'.get_the_title().'" class="'.esc_attr($list_featured_image_class).'"><span class="post-featured-img">'.$lazy_escaped_markup.'</span></a>';
              
                } else {

                if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() || 
								     property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) {
            			
                      $lazy_thumb = nectar_lazy_loaded_image_markup(get_post_thumbnail_id(), 'regular');
                      $lazy_escaped_markup = '<span class="img-thumbnail">'.$lazy_thumb.'</span>';
            		} else {
                  $lazy_escaped_markup = '<span class="img-thumbnail">'.get_the_post_thumbnail($post->ID, $list_featured_image_size, array('title' => '')).'</span>';
                }

                echo '<a class="'.$list_featured_image_class.'" aria-label="'.get_the_title().'" href="' . esc_url(get_permalink()) . '">' . $lazy_escaped_markup . '</a>';
              }
            }
            else { echo '<a class="'.$list_featured_image_class.'" aria-label="'.get_the_title().'" href="' . esc_url(get_permalink()) . '"></a>';  }
            ?>
            <div class="post-header <?php echo esc_attr( $list_featured_image_class ); ?>">
              <?php echo '<span class="meta-category">';
              $categories = get_the_category();
              if ( ! empty( $categories ) ) {
                $output = null;
                  foreach( $categories as $category ) {
                      $output .= '<a class="'.esc_attr($category->slug).'" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
                      break;
                  }
                  echo trim( $output);
                }
              echo '</span>'; ?>
              <?php echo '<' . $list_heading_tag . '>'. get_the_title() .'</'. $list_heading_tag .'>'; ?>
            </div><!--/post-header-->

            <?php
            if($r_post_count <= $columns) {
              $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 15;
              echo '<div class="excerpt">'.nectar_excerpt($excerpt_length).'</div>';

            }

         } // end list featured row style

          else if( $style === 'classic_enhanced' || $style === 'classic_enhanced_alt' ) {

            if( $columns === '4') {
              $image_attrs =  array('title' => '', 'sizes' => '(min-width: 1300px) 25vw, (min-width: 1000px) 33vw, (min-width: 690px) 100vw, 100vw');
            } else if( $columns === '3' ) {
              $image_attrs =  array('title' => '', 'sizes' => '(min-width: 1300px) 33vw, (min-width: 1000px) 33vw, (min-width: 690px) 100vw, 100vw');
            } else if( $columns === '2' ) {
              $image_attrs =  array('title' => '', 'sizes' => '(min-width: 1600px) 50vw, (min-width: 1300px) 50vw, (min-width: 1000px) 50vw, (min-width: 690px) 100vw, 100vw');
            } else {
              $image_attrs =  array('title' => '', 'sizes' => '(min-width: 1000px) 100vw, (min-width: 690px) 100vw, 100vw');
            } ?>

            <div <?php post_class('inner-wrap'); ?>>

            <?php
						
						$classic_enhanced_perma = get_permalink();
						$post_link_url  = get_post_meta( $post->ID, '_nectar_link', true );
						$post_link_text = get_the_content();

						if ( empty( $post_link_text ) && !empty($post_link_url) ) {
							$classic_enhanced_perma = esc_url($post_link_url);
						}
						
            $post_link_target = ( get_post_format() === 'link' ) ? 'target="_blank"' : '';

            if ( has_post_thumbnail() ) {

              if( $style === 'classic_enhanced' ) {
                echo '<a href="' . esc_url($classic_enhanced_perma) . '" '.$post_link_target.' class="img-link"><span class="post-featured-img">'.get_the_post_thumbnail($post->ID, 'portfolio-thumb', $image_attrs) .'</span></a>';
              } 
							else if($style === 'classic_enhanced_alt') {
                $masonry_sizing_type = (!empty($nectar_options['portfolio_masonry_grid_sizing']) && $nectar_options['portfolio_masonry_grid_sizing'] == 'photography') ? 'photography' : 'default';
                $cea_size = ($masonry_sizing_type == 'photography') ? 'regular_photography' : 'tall';
                echo '<a href="' . esc_url($classic_enhanced_perma) . '" class="img-link" '.$post_link_target.'><span class="post-featured-img">'.get_the_post_thumbnail($post->ID, $cea_size, $image_attrs) .'</span></a>';
              }
            }

            echo '<span class="meta-category">';
            $categories = get_the_category();

            if ( ! empty( $categories ) ) {
              $output = null;
                foreach( $categories as $category ) {
                    $output .= '<a class="'.esc_attr($category->slug).'" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
                }
                echo trim( $output);
              }
            echo '</span>';

            echo '<a class="entire-meta-link" aria-label="'.get_the_title().'" href="'. esc_url($classic_enhanced_perma) .'" '.$post_link_target.'></a>'; ?>

            <div class="article-content-wrap">
              <div class="post-header">
                <span class="meta"> <?php echo get_the_date(); ?> </span>
                <h3 class="title"><?php the_title(); ?></h3>
              </div><!--/post-header-->
              <div class="excerpt">
                <?php
                $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 30;
                echo nectar_excerpt($excerpt_length);
                ?>
              </div>
            </div>

            <div class="post-meta">
              <span class="meta-author"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"> <i class="icon-default-style icon-salient-m-user"></i> <?php the_author(); ?></a> </span>

              <?php if(comments_open()) { ?>
                <span class="meta-comment-count">  <a href="<?php comments_link(); ?>">
                  <i class="icon-default-style steadysets-icon-chat-3"></i> <?php comments_number( '0', '1','%' ); ?></a>
                </span>
              <?php } ?>

              <div class="nectar-love-wrap">
                <?php if( function_exists('nectar_love') ) nectar_love(); ?>
              </div><!--/nectar-love-wrap-->
            </div>

          </div>

        <?php } // end classic enhanced style ?>

      </div><!--/col-->

      <?php endwhile; endif;
          wp_reset_postdata();
      ?>

    </div><!--/blog-recent-->

  <?php

  $recent_posts_content = ob_get_contents();

  ob_end_clean();

} // regular recent posts

else if( $style === 'single_large_featured' ) { //single_large_featured

  ob_start();

    if( $orderby !== 'view_count' ) {

      $recentBlogPosts = array(
        'showposts' => 1,
        'category_name' => $category,
        'ignore_sticky_posts' => 1,
        'offset' => $post_offset,
        'order' => $order,
        'orderby' => $orderby,
        'tax_query' => array(
          array( 'taxonomy' => 'post_format',
          'field' => 'slug',
          'terms' => array('post-format-link'),
          'operator' => 'NOT IN'
        )
      )
    );
    } else {

      $recentBlogPosts = array(
        'showposts' => 1,
        'category_name' => $category,
        'ignore_sticky_posts' => 1,
        'offset' => $post_offset,
        'order' => $order,
        'orderby' => 'meta_value_num',
        'meta_key' => 'nectar_blog_post_view_count',
        'tax_query' => array(
          array( 'taxonomy' => 'post_format',
          'field' => 'slug',
          'terms' => array('post-format-link'),
          'operator' => 'NOT IN'
        )
      )
    );

  }

  $recent_posts_query = new WP_Query($recentBlogPosts);

  $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';

  echo '<div id="'.uniqid('rps_').'" class="nectar-recent-posts-single_featured parallax_section" data-padding="'. esc_attr( $large_featured_padding ) .'" data-bg-overlay="'. esc_attr( $bg_overlay ) .'" data-height="'. esc_attr( $slider_size ) .'" data-animate-in-effect="'. esc_attr( $animate_in_effect ) .'" data-remove-post-date="'. esc_attr( $blog_remove_post_date ) .'" data-remove-post-author="'. esc_attr( $blog_remove_post_author ) .'" data-remove-post-comment-number="'.$blog_remove_post_comment_number.'" data-remove-post-nectar-love="'.$blog_remove_post_nectar_love.'">';

  $i = 0;
  if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>

      <?php
        $bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
        $bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
        $bg_image_id  = null;
        $featured_img = null;
        $lazy_escaped_markup = null;
        $background_markup = null;

        if( !empty($bg) ){
          //page header
          $featured_img = $bg;

        }
        elseif( has_post_thumbnail($post->ID) ) {
          $bg_image_id  = get_post_thumbnail_id($post->ID);
          $image_src    = wp_get_attachment_image_src($bg_image_id, 'full');
          $featured_img = $image_src[0];
        }

        if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() || 
				     property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) {
          $lazy_escaped_markup = 'data-nectar-img-src="'.esc_url( $featured_img ).'"';
        } else {
          $background_markup = 'background-image: url('.esc_url( $featured_img ).');';
        }

      ?>

      <div class="nectar-recent-post-slide <?php if($bg_image_id == null) echo 'no-bg-img'; ?> post-ref-<?php echo esc_attr($i); ?>">

        <div class="row-bg using-image" data-parallax-speed="fast">
          <div class="nectar-recent-post-bg" <?php echo $lazy_escaped_markup; ?> style="<?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr( $bg_color );?>; <?php } echo $background_markup; ?> "></div>
        </div>

        <?php

        echo '<div class="recent-post-container container"><div class="inner-wrap">';


            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
              $cat_output = null;
                $i = 0;
                foreach( $categories as $category ) {
                   $i++;
                   $cat_output .= '<a class="'.$category->slug.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'.esc_attr($category->slug).'">'.esc_html( $category->name ) .'</span></a>';
                   if($i > 0) break;
                }

            }


          echo '<div class="grav-wrap"><a href="'.get_author_posts_url($post->post_author).'">'.get_avatar( get_the_author_meta('email'), 70,  null, get_the_author() ). '</a><div class="text"><span>'.esc_html__( 'By','salient').' <a href="'.get_author_posts_url($post->post_author).'" rel="author">' .get_the_author().'</a></span><span> '.esc_html__( 'In','salient').'</span> '. trim( $cat_output) . '</div></div>';
          ?>

          <h2 class="post-ref-<?php echo esc_attr($i); ?>"><a href=" <?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h2>
          <?php echo '<div class="excerpt">' . nectar_excerpt(20) . '</div>';  ?>

          <?php
          //stop regular grad class for material skin
          $button_color      = strtolower($button_color);
          $regular_btn_class = ' regular-button';

          if( $button_color === 'extra-color-gradient-1' || $button_color === 'extra-color-gradient-2' ) {
            $regular_btn_class = '';
          }

          if( $stored_theme_skin === 'material' && $button_color === 'extra-color-gradient-1' ) {
            $button_color = 'm-extra-color-gradient-1';
          }
          else if( $stored_theme_skin == 'material' && $button_color === 'extra-color-gradient-2' ) {
            $button_color = 'm-extra-color-gradient-2';
          }
          ?>
          <a class="nectar-button large regular <?php echo esc_attr( $button_color ) .  esc_attr( $regular_btn_class ); ?> has-icon" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read More', 'salient'); ?></span> <i class="icon-button-arrow"></i></a>

        </div>

      </div>

    <?php $i++; ?>

  <?php endwhile; endif;

  wp_reset_postdata();

  echo '</div></div>';

  wp_reset_query();

  $recent_posts_content = ob_get_contents();

  ob_end_clean();
}

else if( $style === 'multiple_large_featured' ) { //multiple_large_featured

  ob_start();

  if( $orderby !== 'view_count' ) {

    $recentBlogPosts = array(
      'showposts' => $multiple_large_featured_num,
      'category_name' => $category,
      'ignore_sticky_posts' => 1,
      'offset' => $post_offset,
      'order' => $order,
      'orderby' => $orderby,
      'tax_query' => array(
        array( 'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => array('post-format-link'),
        'operator' => 'NOT IN'
      )
    )
  );
  } else {

    $recentBlogPosts = array(
      'showposts' => $multiple_large_featured_num,
      'category_name' => $category,
      'ignore_sticky_posts' => 1,
      'offset' => $post_offset,
      'order' => $order,
      'orderby' => 'meta_value_num',
      'meta_key' => 'nectar_blog_post_view_count',
      'tax_query' => array(
        array( 'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => array('post-format-link'),
        'operator' => 'NOT IN'
      )
    )
  );

  }

  $recent_posts_query = new WP_Query($recentBlogPosts);

  $button_color      = strtolower($button_color);
  $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';

  echo '<div id="'.uniqid('rps_').'" class="nectar-recent-posts-single_featured multiple_featured parallax_section" data-button-color="'. esc_attr( $button_color ) .'" data-nav-location="'. esc_attr( $mlf_navigation_location ) .'" data-bg-overlay="'. esc_attr( $bg_overlay ) .'" data-padding="'. esc_attr( $large_featured_padding ) .'" data-autorotate="'. esc_attr( $auto_rotate ) .'" data-height="'. esc_attr( $slider_size ) .'" data-animate-in-effect="'. esc_attr( $animate_in_effect ) .'" data-remove-post-date="'. esc_attr( $blog_remove_post_date ) .'" data-remove-post-author="'. esc_attr( $blog_remove_post_author ) .'" data-remove-post-comment-number="'. esc_attr( $blog_remove_post_comment_number ) .'" data-remove-post-nectar-love="'. esc_attr( $blog_remove_post_nectar_love ) .'">';

  $i = 0;
  if( $recent_posts_query->have_posts() ) : while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>

      <?php
        $bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
        $bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
        $bg_image_id  = null;
        $featured_img = null;
        $background_markup = null;
        $lazy_escaped_markup = null;

        if( !empty($bg) ) {
          //page header
          $featured_img = $bg;

        } elseif( has_post_thumbnail($post->ID) ) {
          $bg_image_id  = get_post_thumbnail_id($post->ID);
          $image_src    = wp_get_attachment_image_src($bg_image_id, 'full');
					if( $image_src != false ) {
						$featured_img = $image_src[0];
					} else {
						$featured_img = '';
					}

        }

        if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() || 
				    property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) {
          $lazy_escaped_markup = 'data-nectar-img-src="'.esc_url( $featured_img ).'"';
        } else {
          $background_markup = 'background-image: url('.esc_url( $featured_img ).');';
        }

      ?>

      <div class="nectar-recent-post-slide <?php if($bg_image_id == null) echo 'no-bg-img'; ?> <?php if($i == 0) echo 'active'; ?> post-ref-<?php echo esc_attr($i); ?>">

        <div class="row-bg using-image" data-parallax-speed="fast">
          <div class="nectar-recent-post-bg" <?php echo $lazy_escaped_markup; ?> style="<?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr($bg_color);?>; <?php } echo $background_markup; ?> "></div>
        </div>

        <?php

        echo '<div class="recent-post-container container"><div class="inner-wrap">';

            $categories = get_the_category();

            if ( ! empty( $categories ) ) {
              $cat_output = null;
              $i = 0;
              foreach( $categories as $category ) {
                $i++;
                $cat_output .= '<a class="'.$category->slug.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'.$category->slug.'">'.esc_html( $category->name ) .'</span></a>';
                if($i > 0) {
                  break;
                }
              }

            }


          echo '<div class="grav-wrap"><a href="'.get_author_posts_url($post->post_author).'">'.get_avatar( get_the_author_meta('email'), 70,  null, get_the_author() ). '</a><div class="text"><span>'.esc_html__( 'By','salient').' <a href="'.get_author_posts_url($post->post_author).'" rel="author">' .get_the_author().'</a></span><span> '.esc_html__( 'In','salient').'</span> '. trim( $cat_output) . '</div></div>';
          ?>

          <h2 class="post-ref-<?php echo esc_attr($i); ?>"><a href="<?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h2>

          <?php
          
          if( has_action('nectar_recent_posts_multiple_large_featured_after_title') ) {
            echo '<div class="custom-content">';
            do_action('nectar_recent_posts_multiple_large_featured_after_title');
            echo '</div>';
          }
         

          //stop regular grad class for material skin
          $regular_btn_class = ' regular-button';

          if($button_color === 'extra-color-gradient-1' || $button_color === 'extra-color-gradient-2') {
            $regular_btn_class = '';
          }
          if($stored_theme_skin === 'material' && $button_color === 'extra-color-gradient-1') {
            $button_color = 'm-extra-color-gradient-1';
          }
          else if( $stored_theme_skin === 'material' && $button_color === 'extra-color-gradient-2') {
            $button_color = 'm-extra-color-gradient-2';
          }
          ?>
          <a class="nectar-button large regular <?php echo esc_attr($button_color) .  esc_attr($regular_btn_class); ?> has-icon" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read Article', 'salient-core'); ?> </span><i class="icon-button-arrow"></i></a>


          </div><!--/inner-wrap-->

        </div><!--/recent-post-container-->

      </div><!--/nectar-recent-post-slide-->

    <?php $i++; ?>

  <?php endwhile; endif;

  wp_reset_postdata();

  echo '</div>';

  wp_reset_query();

  $recent_posts_content = ob_get_contents();

  ob_end_clean();
}


else if( $style === 'slider_multiple_visible' ) { //slider multiple visible

  ob_start();

  if($orderby != 'view_count') {
    $recentBlogPosts = array(
      'showposts' => $posts_per_page,
      'category_name' => $category,
      'ignore_sticky_posts' => 1,
      'offset' => $post_offset,
      'order' => $order,
      'orderby' => $orderby,
      'tax_query' => array(
        array( 'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => array('post-format-link'),
        'operator' => 'NOT IN'
      )
    )
  );
  } else {

    $recentBlogPosts = array(
      'showposts' => $posts_per_page,
      'category_name' => $category,
      'ignore_sticky_posts' => 1,
      'offset' => $post_offset,
      'order' => $order,
      'orderby' => 'meta_value_num',
      'meta_key' => 'nectar_blog_post_view_count',
      'tax_query' => array(
        array( 'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => array('post-format-link'),
        'operator' => 'NOT IN'
      )
    )
  );

  }

  $recent_posts_query = new WP_Query($recentBlogPosts);

  $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';

  echo '<div class="nectar-recent-posts-slider_multiple_visible" data-columns="'.esc_attr($columns).'" data-height="'.esc_attr($slider_size).'" data-shadow-hover-type="'.esc_attr($hover_shadow_type).'" data-animate-in-effect="'.esc_attr($animate_in_effect).'" data-remove-post-date="'.esc_attr($blog_remove_post_date).'" data-remove-post-author="'.esc_attr($blog_remove_post_author).'" data-remove-post-comment-number="'.esc_attr($blog_remove_post_comment_number).'" data-remove-post-nectar-love="'.esc_attr($blog_remove_post_nectar_love).'">';
  echo '<div class="nectar-recent-posts-slider-inner"><div class="flickity-viewport"><div class="flickity-slider">';

  $i = 0;

  if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>

      <?php
        $bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
        $bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
        $bg_image_id  = null;
        $featured_img = null;
        $lazy_escaped_markup = null;
        $background_markup = null;

        if( has_post_thumbnail($post->ID) ) {
          $bg_image_id  = get_post_thumbnail_id($post->ID);
          $image_src    = wp_get_attachment_image_src($bg_image_id, 'medium_featured');
          $featured_img = $image_src[0];
        }

        if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() || 
				    property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) {
          $lazy_escaped_markup = 'data-nectar-img-src="'.esc_url( $featured_img ).'"';
        } else {
          $background_markup = 'background-image: url('.esc_url( $featured_img ).');';
        }

      ?>

      <div class="nectar-recent-post-slide <?php if($bg_image_id == null) echo 'no-bg-img'; ?> post-ref-<?php echo esc_attr($i); ?>">

        <div class="nectar-recent-post-bg-wrap"><div class="nectar-recent-post-bg" <?php echo $lazy_escaped_markup; ?> style="<?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr($bg_color);?>; <?php } echo $background_markup; ?> "> </div></div>
        <div class="nectar-recent-post-bg-blur" <?php echo $lazy_escaped_markup; ?> style="<?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr($bg_color) ;?>; <?php } echo $background_markup; ?>"> </div>

        <?php

        echo '<div class="recent-post-container container"><div class="inner-wrap">';

        echo '<span class="strong">';
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
              $output = null;
                foreach( $categories as $category ) {
                    $output .= '<a class="'. esc_attr( $category->slug ).'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'. esc_attr( $category->slug ) .'">'.esc_html( $category->name ) .'</span></a>';
                }
                echo trim( $output);
            }
          echo '</span>'; ?>

          <h3 class="post-ref-<?php echo esc_attr($i); ?>"><a href=" <?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h3>

          <?php

          do_action('nectar_recent_posts_multiple_visible_after_title');

          //stop regular grad class for material skin
          $button_color = strtolower($button_color);
          $regular_btn_class = ' regular-button';

          if($button_color === 'extra-color-gradient-1' || $button_color === 'extra-color-gradient-2') {
            $regular_btn_class = '';
          }

          if($stored_theme_skin === 'material' && $button_color === 'extra-color-gradient-1') {
            $button_color = 'm-extra-color-gradient-1';
          }
          else if( $stored_theme_skin === 'material' && $button_color === 'extra-color-gradient-2') {
            $button_color = 'm-extra-color-gradient-2';
          }
          ?>

          <?php if( $stored_theme_skin == 'material') { ?>
            <a class="nectar-button large regular  <?php echo esc_attr($button_color) .  esc_attr($regular_btn_class); ?>" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read Article','salient-core'); ?> </span></a>
          <?php } else { ?>
            <a class="nectar-button large regular  <?php echo esc_attr($button_color) .  esc_attr($regular_btn_class); ?> has-icon" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read Article','salient-core'); ?> </span><i class="icon-button-arrow"></i></a>
          <?php } ?>

        </div>

      </div>


      </div>

    <?php $i++; ?>

  <?php endwhile; endif;

  wp_reset_postdata();

  echo '</div></div></div></div>';

  wp_reset_query();

  $recent_posts_content = ob_get_contents();

  ob_end_clean();
}


else { //slider


  ob_start();

  if($orderby !== 'view_count') {

    $recentBlogPosts = array(
      'showposts' => $posts_per_page,
      'category_name' => $category,
      'ignore_sticky_posts' => 1,
      'offset' => $post_offset,
      'order' => $order,
      'orderby' => $orderby,
      'tax_query' => array(
        array( 'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => array('post-format-link'),
        'operator' => 'NOT IN'
      )
    )
  );

  } else {

    $recentBlogPosts = array(
      'showposts' => $posts_per_page,
      'category_name' => $category,
      'ignore_sticky_posts' => 1,
      'offset' => $post_offset,
      'order' => $order,
      'orderby' => 'meta_value_num',
      'meta_key' => 'nectar_blog_post_view_count',
      'tax_query' => array(
        array( 'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => array('post-format-link'),
        'operator' => 'NOT IN'
      )
    )
  );
  }

  $recent_posts_query = new WP_Query($recentBlogPosts);


  $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';
  echo '<div class="nectar-recent-posts-slider" data-height="'.esc_attr($slider_size).'" data-animate-in-effect="'.esc_attr($animate_in_effect).'" data-remove-post-date="'.esc_attr($blog_remove_post_date).'" data-remove-post-author="'.esc_attr($blog_remove_post_author).'" data-remove-post-comment-number="'.esc_attr($blog_remove_post_comment_number).'" data-remove-post-nectar-love="'.esc_attr($blog_remove_post_nectar_love).'">';
  echo '<div class="nectar-recent-posts-slider-inner generate-markup">';

  $i = 0;

  if( $recent_posts_query->have_posts() ) : while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>

      <?php
        $bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
        $bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
        $bg_image_id  = null;
        $featured_img = null;
        $lazy_escaped_markup = null;
        $background_markup = null;

        if( !empty($bg) ){
          //page header
          $featured_img = $bg;

        } elseif( has_post_thumbnail($post->ID) ) {
          $bg_image_id  = get_post_thumbnail_id($post->ID);
          $image_src    = wp_get_attachment_image_src($bg_image_id, 'full');
          $featured_img = $image_src[0];
        }

        if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() || 
				     property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) {
          $lazy_escaped_markup = 'data-nectar-img-src="'.esc_url( $featured_img ).'"';
        } else {
          $background_markup = 'background-image: url('.esc_url( $featured_img ).');';
        }


      ?>

      <div class="nectar-recent-post-slide <?php if($bg_image_id == null) echo 'no-bg-img'; ?> post-ref-<?php echo esc_attr($i); ?>">

        <div class="nectar-recent-post-bg" <?php echo $lazy_escaped_markup; ?> style="<?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr( $bg_color ) ;?>; <?php } echo $background_markup; ?> "> </div>

        <?php

        echo '<div class="recent-post-container container"><div class="inner-wrap">';

        echo '<span class="strong">';
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
              $output = null;
                foreach( $categories as $category ) {
                    $output .= '<a class="'.esc_attr($category->slug).'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'. esc_attr( $category->slug ) .'">'.esc_html( $category->name ) .'</span></a>';
                }
                echo trim( $output);
            }
          echo '</span>'; ?>

          <h2 class="post-ref-<?php echo esc_attr($i); ?>"><a href=" <?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h2>

        </div>

      </div>

      </div>

    <?php $i++; ?>

  <?php endwhile; endif;

  wp_reset_postdata();

  echo '</div></div>';

  wp_reset_query();

  $recent_posts_content = ob_get_contents();

  ob_end_clean();
}


echo $recent_posts_content;

?>
