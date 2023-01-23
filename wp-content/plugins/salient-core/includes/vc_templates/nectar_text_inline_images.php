<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
    'images' => '-1',
    'image_effect' => 'default',
    'image_size' => 'medium',
    'line_reveal_by_space_text_effect' => 'default',
    'text_content' => '',
    'font_style' => 'h1',
    'text_color' => '',
    'image_loading' => '',
    'media_type' => 'images',
    'video_1_mp4' => '',
    'video_2_mp4' => '',
    'video_3_mp4' => '',
    'video_4_mp4' => '',
  ), $atts));


/*************** IMAGES ***************/
if( 'images' === $media_type ) {

  /* Gather images into an arr */
  $images = explode( ',', $images );
  $images_markup_arr = array();

  foreach ($images as $attach_id) {

      if ($attach_id > 0) {

          if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() ||
              ( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) ) {
              
              $image_arr = wp_get_attachment_image_src($attach_id, $image_size);

              if( isset($image_arr[0]) ) {

                  $image_src    = $image_arr[0];
                  $img_dimens_w = $image_arr[1];
                  $img_dimens_h = $image_arr[2];
                  $placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($img_dimens_w).'%20'.esc_attr($img_dimens_h)."'%2F%3E";
                  
                  $alt_tag = '';
                  $wp_img_alt_tag = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
                  if (!empty($wp_img_alt_tag)) { 
                      $alt_tag = $wp_img_alt_tag;
                  }
                  
                  $images_markup_arr[] = '<img class="nectar-lazy nectar-text-inline-images__image" src="'.esc_attr($placeholder_img_src).'" data-nectar-img-src="'.esc_attr($image_src).'" alt="'.esc_attr($alt_tag).'" width="'.esc_attr($img_dimens_w).'" height="'.esc_attr($img_dimens_h).'" />';
                  
              }
              
          } 
          
          else {

              $image_src = wp_get_attachment_image_src($attach_id, $image_size);
              $image_alt = get_post_meta($attach_id, '_wp_attachment_image_alt', TRUE);

              if( $image_src ) {
                $images_markup_arr[] = '<img class="nectar-text-inline-images__image" src="'.esc_attr($image_src[0]).'" width="'.esc_attr($image_src[1]).'" height="'.esc_attr($image_src[2]).'" alt="'.esc_html($image_alt).'" />';
              }
              
          }
          
      }

  
  }

  if( count($images) == 1 && $images[0] == '-1' ) {
    for( $i=0; $i<5; $i++) {
      $place_holder_size = ( 'circle_fade_in' === $image_effect ) ? 'square' : 'wide';
      $images_markup_arr[$i] = '<img src="'.esc_attr( SALIENT_CORE_PLUGIN_PATH . '/includes/img/placeholder-'.$place_holder_size.'.jpg').'" alt="" width="100" height="100" />';
    }
    
  }

} // end images type

/*************** VIDEOS ***************/
else {

  $videos_arr = array();

  $total_video_num = 4;

  for( $j = 0; $j < $total_video_num+1; $j++ ) {

    if( isset($atts['video_'.$j.'_mp4']) && 
       !empty($atts['video_'.$j.'_mp4']) ) { 

      $videos_arr[] = $atts['video_'.$j.'_mp4']; 
    }

  }

  foreach( $videos_arr as $key => $video) {

    $video_class_names = array('video');
    $video_src_attr = ( 'lazy-load' == $image_loading ) ? 'data-nectar-video-src': 'src';
    if( 'lazy-load' == $image_loading ) {
      $video_class_names[] = 'nectar-lazy-video';
    }

    $images_markup_arr[$key] = '<video class="'.nectar_clean_classnames(implode(' ', $video_class_names)).'" width="1800" height="700" preload="auto" loop autoplay muted playsinline><source '.$video_src_attr.'="'. esc_url( $video ) .'"  type="video/mp4"></video></span>';
  }

}



/* Interpolate symbol */
$content = preg_replace_callback( '/\*/', function( $match ) use( $images_markup_arr, &$count ) {
    
    $count = ( $count ) ? $count : 0;

    $html = '<span class="image-error"></span>';

    if( isset($images_markup_arr[$count]) ) {
      $html = '<span class="nectar-text-inline-images__marker">&nbsp;'.$images_markup_arr[$count].'</span>';
    } 

    $count++;

    return $html;

}, $content, $limit = -1, $count );

// style classes.
$el_classes = array('nectar-text-inline-images','nectar-link-underline-effect');

if( function_exists('nectar_el_dynamic_classnames') ) {
	$el_classes[] = nectar_el_dynamic_classnames('nectar_text_inline_images', $atts);
} else {
	$el_classes[] = '';
}

echo '<div class="'.nectar_clean_classnames(implode(' ',$el_classes)).'"><div class="nectar-text-inline-images__inner">' . $content . '</div></div>';