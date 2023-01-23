<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
  "layout" => 'std-blog-sidebar',
  'blog_masonry_style' => 'inherit',
  'blog_standard_style' => 'inherit',
  'auto_masonry_spacing' => '', 
  'enable_ss' => '', 
  'post_offset' => '', 
  'order' => 'DESC', 
  'orderby' => 'date', 
  'category' => 'all', 
  'enable_pagination' => 'false', 
  'load_in_animation' => 'none', 
  'posts_per_page' => '10', 
  'pagination_type' => '',
  'blog_remove_post_date' => '', 
  'blog_remove_post_author' => '',
  'blog_remove_post_comment_number' => '', 
  'blog_remove_post_nectar_love' => ''
), $atts));  


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

ob_start(); ?>

<div class="row">

 <?php 
   
   $nectar_options = get_nectar_theme_options();
   
   $masonry_class         = null;
   $infinite_scroll_class = null;
   $masonry_style_parsed  = null;
   $standard_style_parsed = null;
   $full_width_article    = ($posts_per_page == 1) ? 'full-width-article': null;
   
   if( $blog_standard_style !== 'inherit' ) {
     $blog_standard_type = $blog_standard_style;
   } else {
     $blog_standard_type = (!empty($nectar_options['blog_standard_type'])) ? $nectar_options['blog_standard_type'] : 'classic';
   }
   
   // Enqueue masonry script if selected.
   if( $layout === 'masonry-blog-sidebar' || 
   $layout === 'masonry-blog-fullwidth' || 
   $layout === 'masonry-blog-full-screen-width' ) {
     $masonry_class = 'masonry';
   }
   
   if( $pagination_type === 'infinite_scroll' && $enable_pagination === 'true' ) {
     $infinite_scroll_class = ' infinite_scroll';
   }
   
   // Store styles.
   if( $masonry_class !== null ) {
     
     if($blog_masonry_style !== 'inherit') {
       $masonry_style = $blog_masonry_style;
     } else {
       $masonry_style = ( !empty($nectar_options['blog_masonry_type']) ) ? $nectar_options['blog_masonry_type']: 'classic';
     }
     
     $masonry_style_parsed = str_replace('_', '-', $masonry_style);
     
   }
   else {
     $standard_style_parsed = str_replace('_', '-', $blog_standard_type);
     $masonry_style = null;
   }
   
   // Standard class.
   if( $blog_standard_type === 'minimal' && $layout === 'std-blog-fullwidth' ) {
     $std_minimal_class = 'standard-minimal full-width-content';
   }
   else if( $blog_standard_type === 'minimal' && $layout === 'std-blog-sidebar' ) {
     $std_minimal_class = 'standard-minimal';
   }
   else {
     $std_minimal_class = '';
   }
   
   if( $masonry_style === null && $blog_standard_type === 'featured_img_left' ) {
     $std_minimal_class = 'featured_img_left';
   }
   
   
   
   if( $layout === 'std-blog-sidebar' || $layout === 'masonry-blog-sidebar' ) {
     echo '<div class="post-area col '.$std_minimal_class.' span_9 '.$masonry_class.' '.$masonry_style.' '.$infinite_scroll_class.'" data-ams="'.esc_attr($auto_masonry_spacing).'" data-remove-post-date="'.esc_attr($blog_remove_post_date).'" data-remove-post-author="'.esc_attr($blog_remove_post_author).'" data-remove-post-comment-number="'.esc_attr($blog_remove_post_comment_number).'" data-remove-post-nectar-love="'.esc_attr($blog_remove_post_nectar_love).'"> <div class="posts-container" data-load-animation="'.esc_attr($load_in_animation).'">';
   } else {
     
     if( $layout === 'masonry-blog-full-screen-width' && $blog_masonry_style === 'auto_meta_overlaid_spaced' || 
     $layout === 'masonry-blog-full-screen-width' && $blog_masonry_style === 'meta_overlaid') { 
       echo '<div class="full-width-content blog-fullwidth-wrap meta-overlaid">'; 
     }
     else if( $layout === 'masonry-blog-full-screen-width' ) { 
       echo '<div class="full-width-content blog-fullwidth-wrap">'; 
     }
     
     echo '<div class="post-area col '.$std_minimal_class.' span_12 col_last '.$masonry_class.' '.$masonry_style.' '.$infinite_scroll_class.' '.$full_width_article.'" data-ams="'.esc_attr($auto_masonry_spacing).'" data-remove-post-date="'.esc_attr($blog_remove_post_date).'" data-remove-post-author="'.esc_attr($blog_remove_post_author).'" data-remove-post-comment-number="'.esc_attr($blog_remove_post_comment_number).'" data-remove-post-nectar-love="'.esc_attr($blog_remove_post_nectar_love).'"> <div class="posts-container" data-load-animation="'.esc_attr($load_in_animation).'">';
     
   }
   
   if ( get_query_var('paged') ) {
     $paged = get_query_var('paged');
   } elseif ( get_query_var('page') ) {
     $paged = get_query_var('page');
   } else {
     $paged = 1;
   }
   
   // In case only all was selected.
   if( $category === 'all' ) {
     $category = null;
   }
   
   // Remove offset for pagination.
   if( $enable_pagination === 'true' ) {
     $post_offset = '';
   }
   
   
   if( $orderby !== 'view_count' ) {
     
     $nectar_blog_arr = array(
       'posts_per_page' => $posts_per_page,
       'post_type'      => 'post',
       'order'          => $order,
       'orderby'        => $orderby,
       'offset'         => $post_offset,
       'category_name' => $category,
       'paged'         => $paged
     );
     
   } else {
     
     $nectar_blog_arr = array(
       'posts_per_page' => $posts_per_page,
       'post_type'      => 'post',
       'order'          => $order,
       'orderby'        => 'meta_value_num',
       'meta_key'       => 'nectar_blog_post_view_count',
       'category_name'  => $category,
       'offset'         => $post_offset,
       'paged'          => $paged
     );
     
   }

   $nectar_blog_arr = apply_filters('nectar_blog_query', $nectar_blog_arr);
   
   $nectar_blog_el_query = new WP_Query( $nectar_blog_arr );
   
   add_filter('wp_get_attachment_image_attributes','nectar_remove_lazy_load_functionality');
   
   if( $nectar_blog_el_query->have_posts() ) : while( $nectar_blog_el_query->have_posts() ) : $nectar_blog_el_query->the_post(); ?>
     
     <?php 
     
     global $more;
     $more = 0;
     
     $nectar_post_format = get_post_format();
     
     if( get_post_format() === 'image' || 
     get_post_format() === 'aside' || 
     get_post_format() === 'status' ) {
       $nectar_post_format = false;
     }
     
     // Salient is active - load from theme.
     if( defined( 'NECTAR_THEME_NAME' ) ) {
       
       // Masonry layouts.
       if( null !== $masonry_class ) {
         get_template_part( 'includes/partials/blog/styles/masonry-'.$masonry_style_parsed.'/entry', $nectar_post_format );
       }
       // Standard layouts.
       else {
         get_template_part( 'includes/partials/blog/styles/standard-'.$standard_style_parsed.'/entry', $nectar_post_format );
       }
       
     } 
     
     // Salient is not active - load from plugin.
     else {
      // Basic layout post.
      include( SALIENT_CORE_ROOT_DIR_PATH.'includes/partials/blog/entry.php' );

     }
   
   
   endwhile; endif; 
   
   remove_filter('wp_get_attachment_image_attributes','nectar_remove_lazy_load_functionality');
   
    ?>
    
    </div><!--/posts container-->
    
    <?php

    global $nectar_options;
    // Pagination.
    if( $enable_pagination === 'true'){
      
          $total_pages = $nectar_blog_el_query->max_num_pages; 
            
          if ( $total_pages > 1 ) {  
            
            $permalink_structure = get_option( 'permalink_structure' );
            $query_type          = ( count($_GET) ) ? '&' : '?';	
            $format              = empty( $permalink_structure ) ? $query_type.'paged=%#%' : 'page/%#%/';  
            $current             = ( get_query_var('paged') ) ? max( 1, get_query_var( 'paged' ) ) : max( 1, get_query_var( 'page' ) );
            
            if( defined('ICL_SITEPRESS_VERSION') ) { 
              $format  = $query_type.'paged=%#%'; 
              $current = max( 1, get_query_var( 'paged' ) );
            }
            
            echo '<div id="pagination" data-is-text="'.esc_html__("All items loaded", 'salient').'">';
             
              echo paginate_links(array(  
                  'base'    => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                  'format'  => $format,  
                  'current' => $current,  
                  'total'   => $total_pages,  
                )); 
            
            echo  '</div>'; 
          
          }  
    }
    
    wp_reset_query();
      
  ?>
  
</div><!--/post area-->

<?php if( $layout === 'masonry-blog-full-screen-width') { echo '</div>'; } ?>
  
<?php if( $layout === 'std-blog-sidebar' || $layout === 'masonry-blog-sidebar' ) { ?>
  <div id="sidebar" data-nectar-ss="<?php echo esc_attr( $enable_ss ); ?>" class="col span_3 col_last">
    <?php dynamic_sidebar('blog-sidebar'); ?>
  </div><!--/span_3-->
 <?php } ?>

</div>

<?php 

$blog_markup = ob_get_contents();

ob_end_clean();

echo $blog_markup;


?>