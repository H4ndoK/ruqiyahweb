<?php 

/**
  * Social button output. 
  *
  * Can be called in themes directly.
  *
  * @since 1.0 
  */
function nectar_social_sharing_output($style = 'default', $position = '') {
  
  global $post;
  
  // Customizer options.
  $social_style   = get_option( 'salient_social_button_style' );
  $color_override = get_option( 'salient_social_override_social_color', 'override' );
  $use_facebook   = get_option( 'salient_social_use_facebook', '1' );
  $use_twitter    = get_option( 'salient_social_use_twitter', '1' );
  $use_linkedin   = get_option( 'salient_social_use_linkedin', '1' );
  $use_pinterest  = get_option( 'salient_social_use_pinterest', '1' );
  $remove_love    = get_option( 'salient_social_remove_love', '0' );

  if( $social_style === 'fixed') {
    $style = $social_style; // Override
  }
  
  ob_start();

  echo '<div class="nectar-social '.esc_attr($style).'" data-position="'. esc_attr($position) .'" data-rm-love="'.esc_attr($remove_love).'" data-color-override="'. esc_attr($color_override) .'">';
    
    if( $style === 'hover' ) {
      echo '<span class="share-btn"> <i class="icon-default-style steadysets-icon-share"></i> '. esc_html__('Share','salient-social') . '</span>';
    } else if( $style === 'fixed' ) {
      echo '<a href="#"><i class="icon-default-style steadysets-icon-share"></i></a>';
    }
  
    echo '<div class="nectar-social-inner">';
      
      if( $style === 'default' && $remove_love !== '1' ) {
        echo nectar_love( 'return' );
      }
      
      // facebook
      if( $use_facebook === '1' ) {
        echo "<a class='facebook-share nectar-sharing' href='#' title='" . esc_attr__( 'Share this', 'salient-social' ) . "'> <i class='fa fa-facebook'></i> <span class='social-text'>" . esc_attr__( 'Share', 'salient-social' ) . "</span> </a>";
      }
      
      // twitter
      if( $use_twitter === '1' ) {
        echo "<a class='twitter-share nectar-sharing' href='#' title='" . esc_attr__( 'Tweet this', 'salient-social' ) . "'> <i class='fa fa-twitter'></i> <span class='social-text'>" . esc_attr__( 'Tweet', 'salient-social' ) . "</span> </a>";
      }
      
      // linkedIn
      if( $use_linkedin === '1' ) {
        echo "<a class='linkedin-share nectar-sharing' href='#' title='" . esc_attr__( 'Share this', 'salient-social' ) . "'> <i class='fa fa-linkedin'></i> <span class='social-text'>" . esc_attr__( 'Share', 'salient-social' ) . "</span> </a>";
      }
      
      // pinterest
      if( $use_pinterest === '1' ) {
        echo "<a class='pinterest-share nectar-sharing' href='#' title='" . esc_attr__( 'Pin this', 'salient-social' ) . "'> <i class='fa fa-pinterest'></i> <span class='social-text'>" . esc_attr__( 'Pin', 'salient-social' ) . "</span> </a>";
      }
      
    echo '</div>';
    
    if( $style === 'hover' && $remove_love !== '1' ) {
      echo '<div class="nectar-love-button">' . nectar_love( 'return' ) . '</div>';
    }
  
  echo '</div>';

  $sharing_output = ob_get_contents();
  ob_end_clean();

  echo $sharing_output; // WPCS: XSS ok.
    
}


/**
  * Adds social buttons to post when not using Salient.
  *
  * @since 1.0 
  */
function salient_social_add_to_posts( $content ) {
  
  $salient_social_markup = '';
  
  if( !is_feed() && !is_home() && !is_page() ) {
    
    $social_style = ( get_option( 'salient_social_button_style' ) ) ? get_option( 'salient_social_button_style' ) : 'default';
    
    ob_start();
    
    nectar_social_sharing_output($social_style);
    
    $salient_social_markup = ob_get_contents();
    ob_end_clean();
    
    if( $social_style === 'default' ) {
        $salient_social_markup = '<div class="sharing-default-minimal post-bottom">' . $salient_social_markup . '</div>';
    } else if( $social_style === 'hover' ) {
      $salient_social_markup = '<div class="salient-social-outer post-bottom">' . $salient_social_markup . '</div>';
    } 
    
  }
  
  $content = $content . $salient_social_markup;
  
  return $content;
  
}

// Add to posts when not using Salient.
if( !defined( 'NECTAR_THEME_NAME' ) ) {
  add_filter( 'the_content', 'salient_social_add_to_posts' );
}


/**
  * "social_buttons" shortcode/WPBakery element processing
  *
  * @since 1.0 
  */
function nectar_social_sharing_shortcode( $atts, $content = null ) {
  
  extract(shortcode_atts(array(
    'style' => 'default', 
    'nectar_love' => '', 
    'facebook' => '',
    'twitter' => '',
    'linkedin' => '',
    'pinterest' => ''
  ), $atts));   
  
  $color_override = get_option( 'salient_social_override_social_color', 'override' );
  
  ob_start();

  wp_enqueue_style( 'salient-social' );
  
  echo '<div class="nectar-social '.esc_attr($style).'" data-position="left" data-color-override="'. esc_attr($color_override) .'">';
    
    if( $style === 'hover' ) {
      echo '<span class="share-btn"> <i class="icon-default-style steadysets-icon-share"></i> '. esc_html__('Share','salient-social') . '</span>';
    } else if( $style === 'fixed' ) {
      echo '<a href="#"><i class="icon-default-style steadysets-icon-share"></i></a>';
    }
  
    echo '<div class="nectar-social-inner">';
      
      if( $style === 'default' && $nectar_love === 'true' ) {
        echo nectar_love( 'return' );
      }
      
      // facebook
      if( $facebook === 'true' ) {
        echo "<a class='facebook-share nectar-sharing' href='#' title='" . esc_attr__( 'Share this', 'salient-social' ) . "'>  <i class='fa fa-facebook'></i> <span class='social-text'>" . esc_attr__( 'Share', 'salient-social' ) . "</span> </a>";
      }
      // twitter
      if( $twitter === 'true' ) {
        echo "<a class='twitter-share nectar-sharing' href='#' title='" . esc_attr__( 'Tweet this', 'salient-social' ) . "'> <i class='fa fa-twitter'></i> <span class='social-text'>" . esc_attr__( 'Tweet', 'salient-social' ) . "</span> </a>";
      }
      
      // linkedIn
      if( $linkedin === 'true' ) {
        echo "<a class='linkedin-share nectar-sharing' href='#' title='" . esc_attr__( 'Share this', 'salient-social' ) . "'> <i class='fa fa-linkedin'></i> <span class='social-text'>" . esc_attr__( 'Share', 'salient-social' ) . "</span> </a>";
      }
      
      // pinterest
      if( $pinterest === 'true' ) {
        echo "<a class='pinterest-share nectar-sharing' href='#' title='" . esc_attr__( 'Pin this', 'salient-social' ) . "'> <i class='fa fa-pinterest'></i> <span class='social-text'>" . esc_attr__( 'Pin', 'salient-social' ) . "</span> </a>";
      }
      
    echo '</div>';
    
    if( $style === 'hover' && $nectar_love === 'true' ) {
      echo '<div class="nectar-love-button">' . nectar_love( 'return' ) . '</div>';
    }
  
  echo '</div>';

  $sharing_output = ob_get_contents();
  ob_end_clean();
  
  if( $style === 'default' ) {
    return '<div class="sharing-default-minimal">' . $sharing_output . '</div>';
  } else {
    return $sharing_output;
  }
  
  
}


add_shortcode('social_buttons', 'nectar_social_sharing_shortcode');


?>