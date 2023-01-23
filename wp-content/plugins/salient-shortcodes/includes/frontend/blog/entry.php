<?php
/**
* Default Post Format Template 
*
* Used when "Minimal" standard style is selected.
*
* @version 10.1
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

global $post;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
  
  <div class="inner-wrap animated">
    
    <div class="post-content classic">
      
      <div class="post-author">

        <span class="meta-author"> <?php the_author_posts_link(); ?></span>
        
        <?php
        echo '<span class="meta-category">';
      
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
      
          echo '<span class="in">' . esc_html__( 'In', 'salient-shortcodes' ) . ' </span>';
      
          $output    = null;
          $cat_count = 0;
          foreach ( $categories as $category ) {
            $output .= '<a class="' . $category->slug . '" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
            if ( count( $categories ) > 1 && ( $cat_count + 1 ) < count( $categories ) ) {
              $output .= ', ';
            }
            $cat_count++;
          }
          echo trim( $output );
          
        }
        echo '</span>';
        ?>
      </div><!--/post-author-->
      
      <div class="content-inner">

        <div class="article-content-wrap">
          
          <div class="post-header">
            
            <h2 class="title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>

          </div><!--/post-header-->
          
          <?php
          
          // Featured image.
          $image_attrs = array(
            'title' => ''
          );
          echo '<a href="' . esc_url( get_permalink() ) . '"><span class="post-featured-img">' . get_the_post_thumbnail( $post->ID, 'full', $image_attrs ) . '</span></a>';


          // Excerpt.
          echo '<div class="excerpt">';
          the_excerpt();
          echo '</div>';
          
          echo '<a class="more-link" href="' . esc_url( get_permalink() ) . '"><span class="continue-reading">' . esc_html__( 'Read More', 'salient-shortcodes' ) . '</span></a>';
      
          ?>
          
        </div><!--article-content-wrap-->
        
      </div><!--content-inner-->
      
    </div><!--/post-content-->
    
  </div><!--/inner-wrap-->
  
</article>