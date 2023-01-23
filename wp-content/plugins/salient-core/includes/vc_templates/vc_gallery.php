<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$output = $title = $source = $type = $onclick = $custom_links = $img_size = $external_img_size = $custom_links_target = $images = $custom_srcs = $el_class = $interval = '';
extract(shortcode_atts(array(
    'title' => '',
    'source' => 'media_library',
    'external_img_size' => '',
    'custom_srcs' => '',
    'type' => 'flexslider',
    'flickity_controls' => 'default',
    'flickity_box_shadow' => '',
	'flickity_touch_total_icon_color' => 'default',
	'flickity_touch_total_style' => 'default',
	'flickity_touch_total_indicator_bg_color' => '#000',
	'flickity_touch_total_indicator_icon_color' => '#fff',
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'thumbnail',
    'image_loading' => '',
		'image_grid_loading' => '',
		'image_grid_lazy_skip' => '',
    'display_title_caption' => '',
    'gallery_style' => '',
    'constrain_max_cols' => '',
    'flexible_slider_height' => '',
    'disable_auto_rotate' => '',
    'hide_arrow_navigation' => '',
    'bullet_navigation' => '',
    'masonry_style' => '',
    'bypass_image_cropping' => '',
    "flickity_desktop_columns" => "1",
    "flickity_small_desktop_columns" => "1",
    "flickity_tablet_columns" => "1",
    "flickity_phone_columns" => 'default',
    "flickity_free_scroll" => '',
    "flickity_autoplay" => '',
    "flickity_autoplay_dur" => '',
    'flickity_img_height' => '500',
    'flickity_img_small_desktop_height' => '400',
    'flickity_img_tablet_height' => '350',
    'flickity_img_mobile_height' => '300',
    'flickity_spacing' => '',
    'flickity_wrap_around' => 'wrap',
    'flickity_overflow' => 'hidden',
    'flickity_image_stagger_columns' => '',
		'flickity_image_scale_on_drag' => '',
    'flickity_image_parallax' => '',
    'item_spacing' => 'default',
    'load_in_animation' => 'none',
    'bullet_navigation_style' => 'see_through',
    'layout' => '',
    'images' => '',
    'el_class' => '',
    'interval' => '5',
    'img_size' => '600x400'
), $atts));

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

if( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
	$image_loading = 'lazy-load';
	//$image_grid_loading = 'lazy-load';
}

if( !class_exists('Salient_Portfolio') && $type == 'image_grid' ) {
  // Enqueue fallbacks.
  wp_enqueue_style( 'nectar-portfolio' );

  if( ! defined( 'NECTAR_THEME_NAME' ) ) {
    wp_enqueue_script( 'salient-portfolio-waypoints' );
  }
  wp_enqueue_script( 'isotope' );
  wp_enqueue_script( 'salient-portfolio-js' );
}

if( !class_exists('Salient_Nectar_Slider') && $type == 'nectarslider_style' ) {
  $type = 'flickity_style';
}

$el_class = $this->getExtraClass($el_class);

if(!function_exists('wp_get_attachment')) {
	function wp_get_attachment( $attachment_id ) {

		if(is_numeric($attachment_id) && $attachment_id > 0) {

      if ( defined( 'ICL_SITEPRESS_VERSION' )) {
       $attachment_id = apply_filters('wpml_object_id', $attachment_id, 'attachment', TRUE);
      }

			$attachment = get_post( $attachment_id );
      if( isset($attachment->ID) ) {
  			return array(
  				'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
  				'caption' => $attachment->post_excerpt,
  				'description' => $attachment->post_content,
  				'href' => esc_url(get_permalink( $attachment->ID )),
  				'src' => $attachment->guid,
  				'title' => $attachment->post_title,
  				'masonry_image_sizing' => get_post_meta( $attachment->ID, 'nectar_image_gal_masonry_sizing', true ),
  				'image_url' => get_post_meta( $attachment->ID, 'nectar_image_gal_url', true ),
  			);
      } else {
        return array(
  				'alt' => '',
  				'caption' => '',
  				'description' => '',
  				'href' => '',
  				'src' => '',
  				'title' => '',
  				'masonry_image_sizing' => '',
  				'image_url' => ''
  			);
      }

		} else {
			return array(
				'alt' => '',
				'caption' => '',
				'description' => '',
				'href' => '',
				'src' => '',
				'title' => '',
				'masonry_image_sizing' => '',
				'image_url' => ''
			);
		}
	}
}

if ( $type === 'flexslider_style' ) {
    $el_start = '<li>';
    $el_end = '</li>';
    $slides_wrap_start = '<ul class="slides" data-d-autorotate="'.$disable_auto_rotate.'">';
    $slides_wrap_end = '</ul>';

    wp_enqueue_script('flexslider');

} else if ( $type === 'nectarslider_style' ) {


    $el_start = '';
    $el_end = '';

   	$bulk_param = ($onclick != 'link_no') ? 'false' : 'true';

   	switch ( $source ) {
		case 'media_library':
			if($img_size == 'thumbnail') {
				$slide_height = '200';
			} else if ($img_size == 'large'){
				$slide_height = '600';
			} else if ($img_size == 'full'){
				$slide_height = '1000';
			}
			else {

				if( strpos($img_size, 'x') !== false ) {
					$arr = explode("x", $img_size, 2);
					$slide_height = $arr[1];
				} else {
					$slide_height = '';
				}


			}
			break;

		case 'external_link':

			if( strpos($external_img_size, 'x') !== false ) {
				$arr = explode("x", $external_img_size, 2);
				$slide_height = $arr[1];
			} else {
				$slide_height = '';
			}

			break;
	}


	if($images == '') {
    $bullet_navigation = false;
  }
	$arrow_markup = ($hide_arrow_navigation == true) ? 'data-arrows="false"': 'data-arrows="true"';

  $autorotation_attr = ($disable_auto_rotate != 'true') ? 'data-autorotate="5500"' : '';

  if( isset($_GET['vc_editable']) ) {
  	$nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
  	$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
  } else {
  	$nectar_using_VC_front_end_editor = false;
  }

  if($nectar_using_VC_front_end_editor) {
    $autorotation_attr = '';
  }

	$slides_wrap_start .= '<div class="nectar-slider-wrap" style="height: '.$slide_height.'px" data-flexible-height="'.esc_attr($flexible_slider_height).'" data-overall_style="classic" data-button-styling="btn_with_count" data-fullscreen="false"  data-full-width="false" data-parallax="false" '.$autorotation_attr.' id="ns-id-'.uniqid().'">';
	$slides_wrap_start .=	'<div class="swiper-container" style="height: '.$slide_height.'px"  data-loop="'.esc_attr($bulk_param).'" data-height="'.esc_attr($slide_height).'" data-bullets="'.esc_attr($bullet_navigation).'" data-bullet_style="'.esc_attr($bullet_navigation_style).'" '.$arrow_markup.' data-desktop-swipe="'.esc_attr($bulk_param).'" data-settings="">';
	$slides_wrap_start .=	'<div class="swiper-wrapper">';


	$slides_wrap_end .= '</div>';

	if($hide_arrow_navigation != true) {
		$slides_wrap_end .= '<a href="" class="slider-prev"><i class="icon-salient-left-arrow"></i> <div class="slide-count"> <span class="slide-current">1</span> <i class="icon-salient-right-line"></i> <span class="slide-total"></span> </div> </a>
			     		<a href="" class="slider-next"><i class="icon-salient-right-arrow"></i> <div class="slide-count"> <span class="slide-current">1</span> <i class="icon-salient-right-line"></i> <span class="slide-total"></span> </div> </a>';
	}

	if($images != '') {
		$image_count = explode( ',', $images);
		if($bullet_navigation == true && sizeof($image_count) > 1) {
				$slides_wrap_end .= '<div class="container normal-container slider-pagination-wrap"><div class="slider-pagination"></div></div>';
		}
	}
	$slides_wrap_end .= '<div class="nectar-slider-loading"></div>';
	$slides_wrap_end .= '</div></div>';


} else if ( $type === 'flickity_style' || $type === 'flickity_static_height_style' ) {

	wp_enqueue_script( 'flickity' );
  wp_enqueue_style( 'nectar-flickity' );

  $touch_total_minimal_class = '';

  if( 'touch_total_alt' === $flickity_controls ) {
    $flickity_controls = 'touch_total';
    $touch_total_minimal_class = ' drag-indicator-only';
  }

  $flickity_attrs = '';
  if( $flickity_touch_total_style == 'solid_bg' ) {

    $flickity_attrs .= 'data-indicator-bg="'.esc_attr($flickity_touch_total_indicator_bg_color).'" ';
    $flickity_attrs .= 'data-indicator-icon="'.esc_attr($flickity_touch_total_indicator_icon_color).'" ';

  }

  if( $type === 'flickity_static_height_style' ) {

    // Limit sizes
		$wp_image_sizes = get_intermediate_image_sizes();
    if( empty($img_size) || !in_array($img_size, $wp_image_sizes) ) {
      $img_size = 'large';
    }

    // Add heights.
    $instance = uniqid("instace-");
    $flickity_img_height_css = '.wpb_gallery_slidesflickity_static_height_style .nectar-flickity.'.$instance.':not(.masonry) .flickity-slider .cell img {
      height: '. nectar_css_sizing_units($flickity_img_height) .';
    }
    @media only screen and (max-width: 1300px) {
      .wpb_gallery_slidesflickity_static_height_style .nectar-flickity.'.$instance.':not(.masonry) .flickity-slider .cell img {
        height: '. nectar_css_sizing_units($flickity_img_small_desktop_height) .';
      }
    }
    @media only screen and (max-width: 1000px) {
      .wpb_gallery_slidesflickity_static_height_style .nectar-flickity.'.$instance.':not(.masonry) .flickity-slider .cell img {
        height: '. nectar_css_sizing_units($flickity_img_tablet_height) .';
      }
    }
    @media only screen and (max-width: 690px) {
      .wpb_gallery_slidesflickity_static_height_style .nectar-flickity.'.$instance.':not(.masonry) .flickity-slider .cell img {
        height: '. nectar_css_sizing_units($flickity_img_mobile_height) .';
      }
    }';

    
    $slides_wrap_start .= '<style>'.$flickity_img_height_css .'</style>';


    $slides_wrap_start .= '<div class="nectar-flickity not-initialized ' . $instance . $touch_total_minimal_class.'" '.$flickity_attrs.' data-touch-icon-color="'.esc_attr($flickity_touch_total_icon_color).'" data-drag-scale="'.esc_attr($flickity_image_scale_on_drag).'" data-overflow="'.esc_attr($flickity_overflow).'" data-wrap="'.esc_attr($flickity_wrap_around).'" data-spacing="'.esc_attr($flickity_spacing).'" data-shadow="'.esc_attr($flickity_box_shadow).'" data-autoplay="'.esc_attr($flickity_autoplay).'" data-autoplay-dur="'.esc_attr($flickity_autoplay_dur).'" data-free-scroll="'.esc_attr($flickity_free_scroll).'" data-controls="'.esc_attr($flickity_controls).'"><div class="flickity-viewport"> <div class="flickity-slider">';

  } else {
  	$slides_wrap_start .= '<div class="nectar-flickity not-initialized'.$touch_total_minimal_class.'" '.$flickity_attrs.' data-touch-icon-color="'.esc_attr($flickity_touch_total_icon_color).'" data-stagger="'.esc_attr($flickity_image_stagger_columns).'" data-drag-scale="'.esc_attr($flickity_image_scale_on_drag).'" data-overflow="'.esc_attr($flickity_overflow).'" data-wrap="'.esc_attr($flickity_wrap_around).'" data-spacing="'.esc_attr($flickity_spacing).'" data-shadow="'.esc_attr($flickity_box_shadow).'" data-autoplay="'.esc_attr($flickity_autoplay).'" data-autoplay-dur="'.esc_attr($flickity_autoplay_dur).'" data-free-scroll="'.esc_attr($flickity_free_scroll).'" data-controls="'.esc_attr($flickity_controls).'" data-desktop-columns="'.esc_attr($flickity_desktop_columns).'" data-small-desktop-columns="'.esc_attr($flickity_small_desktop_columns).'" data-tablet-columns="'.esc_attr($flickity_tablet_columns).'" data-phone-columns="'.esc_attr($flickity_phone_columns).'"><div class="flickity-viewport"> <div class="flickity-slider">';
  }

	$slides_wrap_end .= '</div></div></div>';

} else if ( $type === 'image_grid' ) {


	//calculate cols
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


	$constrain_col_class = (!empty($constrain_max_cols) && $constrain_max_cols == 'true') ? ' constrain-max-cols' : null ;
	if( 'lazy-load' === $image_grid_loading ) {
		$load_in_animation = 'none';
	}
	$masonry_layout = ($masonry_style == 'true') ? 'true' : 'false';

	global $nectar_options;
	$masonry_sizing_type = (!empty($nectar_options['portfolio_masonry_grid_sizing']) && $nectar_options['portfolio_masonry_grid_sizing'] == 'photography') ? 'photography' : 'default';


	ob_start(); ?>


	<div class="portfolio-wrap <?php if($gallery_style == '1' && $span_num == 'elastic-portfolio-item') echo 'default-style'; ?>">

			<span class="portfolio-loading"></span>

			<div class="row portfolio-items <?php if($masonry_layout == 'true') echo 'masonry-items'; else { echo 'no-masonry'; } if($layout == 'constrained_fullwidth') echo ' fullwidth-constrained '; ?> <?php echo esc_attr( $constrain_col_class ); ?>" data-starting-filter="" data-gutter="<?php echo esc_attr( $item_spacing ); ?>" data-masonry-type="<?php echo esc_attr( $masonry_sizing_type ); ?>" data-bypass-cropping="<?php echo esc_attr( $bypass_image_cropping ); ?>"  data-ps="<?php echo esc_attr( $gallery_style ); ?>" data-loading="<?php echo esc_attr($image_grid_loading); ?>" data-categories-to-show="" data-col-num="<?php echo esc_attr( $cols ); ?>">



	<?php

	$slides_wrap_start = ob_get_contents();

	ob_end_clean();



	ob_start();

	$el_start = ob_get_contents();

	ob_end_clean();

	$el_end = '';


  $slides_wrap_end = '</div></div>';



}



$flex_fx = '';
if ( $type === 'flexslider_style' ) {
    $type = ' wpb_flexslider flex-gallery flexslider';
    $flex_fx = ' data-flex_fx="fade"';
} else if ( $type === 'nectarslider_style' ) {
    $type = 'nectarslider_style';
    $flex_fx = '';
}


if ( $images == '' && $type !== 'image_grid' ) { $images = '-1,-2,-3,-4,-5,-6'; }
else if( $images == '' && $type === 'image_grid' ) { $images = '-1,-2,-3,-4'; }

$pretty_rel_random = ''; //rel-'.rand();

if ( $onclick === 'custom_link' ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );

  /* Single link applies to all slides */
  if( $source === 'media_library') {
    $temp_images = explode( ',', $images );
    $image_length = count($temp_images);

    if( $image_length > 2 && isset($custom_links[0]) && !empty($custom_links[0]) && count($custom_links) == 1 ) {
      $stored_link = $custom_links[0];
      foreach($temp_images as $k => $v ) {
        $custom_links[$k] = $stored_link;
      }
    }

  }
}

switch ( $source ) {
	case 'media_library':
		$images = explode( ',', $images );
		break;

	case 'external_link':
		$images = vc_value_from_safe( $custom_srcs );
		$images = explode( ',', $images );

		break;
}


$i = -1;

foreach ( $images as $attach_id ) {

    $i++;

    switch ( $source ) {
		case 'media_library':
			 if ($attach_id > 0) {
		        $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size, 'class' => 'skip-lazy' ));
		        $fullsize_image = wp_get_attachment_image_src($attach_id, 'full');
						if( isset($fullsize_image[0]) ) {
							$post_thumbnail['p_img_fullsize'] = $fullsize_image[0];
						} else {
							$post_thumbnail['p_img_fullsize'] = '';
						}

		    }
		    else {
		        $different_kitten = 400 + $i;
		        $post_thumbnail = array();
		        $post_thumbnail['thumbnail'] = '<img src="http://placekitten.com/g/'.$different_kitten.'/300" />';
		        $post_thumbnail['p_img_large'][0] = 'http://placekitten.com/g/1024/768';
		        $post_thumbnail['p_img_fullsize'] = 'http://placekitten.com/g/1024/768';
		    }
			break;

		case 'external_link':
			$image = esc_attr( $attach_id );
			$dimensions = vc_extract_dimensions( $external_img_size );
			$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
			$post_thumbnail['thumbnail'] = '<img ' . $hwstring . ' src="' . $image . '" />';
			$post_thumbnail['p_img_large'][0] = $image;
			$post_thumbnail['p_img_fullsize'] = $image;
			break;
	}




    $thumbnail = $post_thumbnail['thumbnail'];

 		$post_thumbnail['p_img_large'][0] = $post_thumbnail['p_img_fullsize'];

    $p_img_large = $post_thumbnail['p_img_large'];
    $link_start = $link_end = '';

    if ( $onclick === 'link_image' ) {
        $link_start = '<a href="'.$p_img_large[0].'"'.$pretty_rel_random.'>';
        $link_end = '</a>';
    }
    else if ( $onclick === 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
        $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
        $link_end = '</a>';
    }

	if($type === 'nectarslider_style') {

		switch ( $source ) {
			case 'media_library':
				$img = wp_get_attachment_image_src(  $attach_id, $img_size );
				break;

			case 'external_link':
				$image = esc_attr( $attach_id );
				$dimensions = vc_extract_dimensions( $external_img_size );
				$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
				$img[0] = $image;
				break;
		}

    if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() ) {
      $thumbnail = '<div class="swiper-slide" data-bg-alignment="center" data-color-scheme="light" data-x-pos="centered" data-y-pos="middle"><div class="image-bg" data-nectar-img-src="'. $img[0].'">  &nbsp; </div>';
    } else {
      $thumbnail = '<div class="swiper-slide" data-bg-alignment="center" data-color-scheme="light" data-x-pos="centered" data-y-pos="middle"><div class="image-bg" style="background-image: url('. $img[0].');">  &nbsp; </div>';
    }


		if ( $onclick === 'link_image' ) {

					$ns_image_title = '';

					if( 'media_library' === $source ) {
						$attachment_meta = wp_get_attachment($attach_id);
						if($attach_id > 0) {
								if(!empty($attachment_meta['description'])) {
									$ns_image_title = 'title="'.esc_attr($attachment_meta['description']).'"';
								}
						}
					}

	        $slide_link = '<a class="entire-slide-link" '.$ns_image_title.' href="'.$p_img_large[0].'"'.$pretty_rel_random.'></a>';
	    }
	    else if ( $onclick === 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
	        $slide_link = '<a class="entire-slide-link ext-url-link" href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '></a>';
	    } else {
	    	$slide_link = null;
	    }

		$thumbnail .= $slide_link;

		$link_start = null;
		$link_end = null;

		$thumbnail .= '<span class="ie-fix"></span> </div><!--/swiper-slide-->';

	}


	if($type === 'flickity_style' || $type === 'flickity_static_height_style') {

    $lazy_load = 'false';

		switch ( $source ) {
			case 'media_library':
				if ($attach_id > 0) {
			        $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => (int) $attach_id, 'thumb_size' => $img_size, 'class' => 'skip-lazy nectar-lazy' ));

              if( 'lazy-load' === $image_loading && isset($post_thumbnail['thumbnail']) ) {

                $content = false;
				
				// Lazy loading svg src.
				$placeholder_img_src = '';
				if( isset($post_thumbnail['p_img_large']) && 
					isset($post_thumbnail['p_img_large'][1]) && 
					isset($post_thumbnail['p_img_large'][2]) ) {
					$placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($post_thumbnail['p_img_large'][1]).'%20'.esc_attr($post_thumbnail['p_img_large'][2])."'%2F%3E";
				}
				
				
                // Srcset.
                if( strpos($post_thumbnail['thumbnail'],'srcset') !== false ) {
                  preg_match( '/< *img[^>]*srcset *= *["\']?([^"\']*)/i', $post_thumbnail['thumbnail'], $srcset_match);
                  if($srcset_match && isset($srcset_match[1]) ) {
                    $content = preg_replace( '#<img([^>]+?)srcset=[\'"](.*)[\'"]?([^>]*)>#', '<img${1} data-nectar-img-srcset="'.esc_attr($srcset_match[1]).'"${3}>', $post_thumbnail['thumbnail'] );
                  }
                }

                // Src.
                preg_match( '/< *img[^>]*src *= *["\']?([^"\']*)/i', $post_thumbnail['thumbnail'], $src_match);
                if($src_match && isset($src_match[1]) ) {
                  if(false === $content) {
                    $content = $post_thumbnail['thumbnail'];
                  }
                  $content = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', '<img${1} src="'.$placeholder_img_src.'" data-nectar-img-src="'.esc_attr($src_match[1]).'"${3}>', $content );
                }

                if( false !== $content ) {
                  $post_thumbnail['thumbnail'] = $content;
                  $lazy_load = 'true';
                }

              }
			}
			else {
			        $post_thumbnail = array();

			        if(!empty($flickity_desktop_columns) && $flickity_desktop_columns == '3') {
			        	$post_thumbnail['thumbnail'] = '<img src="http://placehold.it/500x500" />';
				        $post_thumbnail['p_img_large'][0] = 'http://placehold.it/500x500';
			        } 
              else if(!empty($flickity_desktop_columns) && $flickity_desktop_columns == '4') {
			        	$post_thumbnail['thumbnail'] = '<img src="http://placehold.it/350x600/343537/ffffff" />';
				        $post_thumbnail['p_img_large'][0] = 'http://placehold.it/350x600/343537/ffffff';
			        } 
              else if( $type === 'flickity_static_height_style' ) {

                $random = mt_rand(0,1);
                if( $random === 1 || in_array($i, array(0,5)) ) {
                  $post_thumbnail['thumbnail'] = '<img src="http://placehold.it/800x500" />';
  				        $post_thumbnail['p_img_large'][0] = 'http://placehold.it/800x500';
                } else {
                  $post_thumbnail['thumbnail'] = '<img src="http://placehold.it/500x500" />';
  				        $post_thumbnail['p_img_large'][0] = 'http://placehold.it/500x500';
                }

              } else {
				        $post_thumbnail['thumbnail'] = '<img src="http://placehold.it/900x400" />';
				        $post_thumbnail['p_img_large'][0] = 'http://placehold.it/900x400';
				    }
			    }
				break;

			case 'external_link':
				$image = esc_attr( $attach_id );
				$dimensions = vc_extract_dimensions( $external_img_size );
				$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
				$post_thumbnail['thumbnail'] = '<img ' . $hwstring . ' src="' . $image . '" />';
				$post_thumbnail['p_img_large'][0] = $image;
				break;
		}



    if( $flickity_image_parallax == 'true' ) {
      $thumbnail = '<div class="cell" data-lazy="'.esc_attr($lazy_load).'"><div class="nectar-el-parallax-scroll" data-scroll-animation="true" data-scroll-animation-mobile="true" data-scroll-animation-intensity="-1.15" data-scroll-animation-lerp="1"><div class="vc_column-inner"><div class="img-wrap">' . $post_thumbnail['thumbnail'] . '</div></div></div>';
    }
    else {
      $thumbnail = '<div class="cell" data-lazy="'.esc_attr($lazy_load).'">' . $post_thumbnail['thumbnail'];
    }

  

		if( $display_title_caption == 'true' || $onclick === 'link_image' ) {
			if($attach_id > 0) {
				$attachment_meta = wp_get_attachment($attach_id);
			}
		}

		if ( $onclick === 'link_image' ) {

      $flickity_image_title = '';
      if($attach_id > 0) {
          if(!empty($attachment_meta['description'])) {
            $flickity_image_title = 'title="'.esc_attr($attachment_meta['description']).'"';
          }
      }

	        $slide_link = '<a class="entire-slide-link" '.$flickity_image_title.' href="'.$p_img_large[0].'"'.$pretty_rel_random.'></a>';
	    }
	    else if ( $onclick === 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
	        $slide_link = '<a class="entire-slide-link ext-url-link" href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '></a>';
	    } else {
	    	$slide_link = null;
	    }

		$thumbnail .= $slide_link;

		$link_start = null;
		$link_end = null;

		if($display_title_caption == 'true') {

			$thumbnail .= '<div class="item-meta">';

			if($attach_id > 0) {
				$thumbnail .= '<h4 class="title">'. $attachment_meta['title'] .'</h4>';
				$thumbnail .= '<p>'. $attachment_meta['caption'] .'</p>';
			 }

			$thumbnail .= '</div>';

		}

		$thumbnail .= '</div>';

	}



	if($type == 'parallax_image_grid') {

		switch ( $source ) {
			case 'media_library':
				if ($attach_id > 0) {
			        $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => (int) $attach_id, 'thumb_size' => $img_size, 'class' => 'skip-lazy' ));
			    }
			    else {
			        $post_thumbnail = array();

			        $post_thumbnail['thumbnail'] = '<img src="http://placehold.it/700x400" />';
			        $post_thumbnail['p_img_large'][0] = 'http://placehold.it/700x400';

			    }
				break;

			case 'external_link':
				$image = esc_attr( $attach_id );
				$dimensions = vc_extract_dimensions( $external_img_size );
				$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
				$post_thumbnail['thumbnail'] = '<img ' . $hwstring . ' src="' . $image . '" />';
				$post_thumbnail['p_img_large'][0] = $image;
				break;
		}



		$thumbnail = '<div class="parallax-grid-item"><div class="style-5"><div class="parallaxImg"><div class="parallaxImg-layer">' . $post_thumbnail['thumbnail'];

		$attachment_meta = wp_get_attachment($attach_id);

	   if(!empty($attachment_meta['image_url'])) {
			$thumbnail .= '<a href="'.$attachment_meta['image_url'].'"></a>';
		} else {

			$lightbox_desc = '';

			if(isset($attachment_meta['description']) && !empty($attachment_meta['description'])) {
				$lightbox_desc = 'title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"';
			}
			$thumbnail .=  '<a href="'.$p_img_large[0].'" '.$lightbox_desc.' class="default-link pretty_photo"></a>';
		}

		$thumbnail .= '</div></div></div>';

		if($display_title_caption == 'true') {

			$thumbnail .= '<div class="item-meta">';
				if($attach_id > 0) {
					$thumbnail .= '<h4 class="title">'. $attachment_meta['title'] .'</h4>';
					$thumbnail .= '<p>'. $attachment_meta['caption'] .'</p>';
				 }

			$thumbnail .= '</div>';

		}


		$link_start = null;
		$link_end = null;

		$thumbnail .= '</div>';

	}



	if( $type === 'image_grid' ) {


				ob_start();

							$attachment_meta     = wp_get_attachment($attach_id);
							$masonry_item_sizing = null;

							if( $masonry_layout == 'true' ) {

								if( !empty($attachment_meta['masonry_image_sizing']) && $bypass_image_cropping != 'true') {

									$masonry_item_sizing = $attachment_meta['masonry_image_sizing'];

									// No tall size in photography
									if($masonry_sizing_type == 'photography' && $masonry_item_sizing == 'tall') {
										$masonry_item_sizing = 'wide_tall';
									}

								} else {
									$masonry_item_sizing = 'regular';
								}

							}

							?>

							<div class="col <?php echo esc_attr( $span_num ) .' '. esc_attr( $masonry_item_sizing ); ?> element" data-project-cat="" data-default-color="true" data-title-color="" data-subtitle-color="">

							<div class="inner-wrap animated" data-animation="<?php echo esc_attr( $load_in_animation ); ?>">

							<?php

							//photography masonry sizing
							if($masonry_layout == 'true') {
								if($masonry_sizing_type == 'photography' && !empty($masonry_item_sizing)) {
									$masonry_item_sizing = $masonry_item_sizing.'_photography';

								}
							}

							//adaptive image sizing
							$image_sizes  = null;
							$image_srcset = null;

							$image_srcset_attr = ( 'lazy-load' === $image_grid_loading && $i >= 8 ) ? 'data-nectar-img-srcset': 'srcset';

							if($source == 'media_library' && $attach_id > 0) {

								$regular_size = wp_get_attachment_image_src($attach_id, $masonry_item_sizing, array('title' => ''));
								$small_size = null;
								$image_meta = wp_get_attachment_metadata($attach_id);

								if($masonry_item_sizing == 'tall') {

									if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$masonry_item_sizing])) {
										$small_size = wp_get_attachment_image_src($attach_id, $masonry_item_sizing, array('title' => ''));
									}

								} else if($masonry_item_sizing == 'wide_tall') {

									if(!empty($image_meta['sizes']) && !empty($image_meta['sizes']['regular'])) {
										$small_size = wp_get_attachment_image_src($attach_id,'regular', array('title' => ''));
									}

								} else if($masonry_item_sizing == 'wide_tall_photography') {

									if(!empty($image_meta['sizes']) && !empty($image_meta['sizes']['regular_photography'])) {
										$small_size = wp_get_attachment_image_src($attach_id,'regular_photography', array('title' => ''));
									}

								} else if($masonry_item_sizing == 'wide' || $masonry_item_sizing == 'wide_photography' || $masonry_item_sizing == 'regular' || $masonry_item_sizing == 'regular_photography') {

									if(!empty($image_meta['sizes']) && !empty($image_meta['sizes'][$masonry_item_sizing.'_small'])) {
										$small_size = wp_get_attachment_image_src($attach_id, $masonry_item_sizing.'_small', array('title' => ''));
									}
								}


								if($masonry_layout == 'false' || $layout == '3' || $layout == '4' || $layout == '2') {
									if($layout == '2') {
										$image_sizes = 'sizes="(min-width: 1000px) 50vw, (min-width: 690px) 50vw, 100vw"';
									} else if($layout == '3') {
										$image_sizes = 'sizes="(min-width: 1000px) 33.3vw, (min-width: 690px) 50vw, 100vw"';
									} else if($layout == '4') {
										$image_sizes = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
									} else if($layout == 'fullwidth' && $constrain_max_cols != 'true') {
										$image_sizes = 'sizes="(min-width: 1300px) 20vw, (min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
									} else if($layout == 'fullwidth' && $constrain_max_cols == 'true') {
										$image_sizes = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
									}

									$regular_size = ($regular_size) ? $regular_size[0] .' 600w' : null;
									$small_size = ($small_size) ? ', '. $small_size[0] .' 400w' : null;

									$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

								} else if($masonry_layout == 'true' && $masonry_sizing_type != 'photography')  {

									if($constrain_max_cols != 'true') {
										//no column constraint
										if($masonry_item_sizing == 'regular' || $masonry_item_sizing == 'tall') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 500w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 350w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1600px) 20vw, (min-width: 1300px) 25vw, (min-width: 1000px) 33.3vw, (min-width: 690px) 50vw, 100vw"';

										} else if($masonry_item_sizing == 'wide_tall') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 500w' : null;
											$image_srcset = $image_srcset_attr. '="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1600px) 40vw, (min-width: 1300px) 50vw, (min-width: 1000px) 66.6vw, (min-width: 690px) 100vw, 100vw"';
										}
										else if($masonry_item_sizing == 'wide') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 670w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1600px) 40vw, (min-width: 1300px) 50vw, (min-width: 1000px) 66.6vw, (min-width: 690px) 100vw, 100vw"';
										}

									} else {
										//constrained to 4 cols
										if($masonry_item_sizing == 'regular' || $masonry_item_sizing == 'tall') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 500w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 350w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
										} else if($masonry_item_sizing == 'wide_tall') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 500w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1000px) 50vw, (min-width: 690px) 100vw, 100vw"';

										} else if($masonry_item_sizing == 'wide') {


											$regular_size = ($regular_size) ? $regular_size[0] .' 1000w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 670w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1000px) 50vw, (min-width: 690px) 100vw, 100vw"';
										}
									}

								} else if($masonry_layout == 'true' && $masonry_sizing_type == 'photography') {

									if($constrain_max_cols != 'true') {
										//no column constraint
										if($masonry_item_sizing == 'regular_photography' || $masonry_item_sizing == 'tall_photography') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 450w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 350w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1600px) 16.6vw, (min-width: 1300px) 20vw, (min-width: 1000px) 25vw, (min-width: 690px) 50vw, 100vw"';
										} else if($masonry_item_sizing == 'wide_tall_photography') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 450w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1600px) 33.3vw, (min-width: 1300px) 40vw, (min-width: 1000px) 50vw, 100vw"';
										} else if( $masonry_item_sizing == 'wide_photography') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 700w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1600px) 33.3vw, (min-width: 1300px) 40vw, (min-width: 1000px) 50vw, 100vw"';
										}
									} else {
										//constrained to 4 cols
										if($masonry_item_sizing == 'regular_photography' || $masonry_item_sizing == 'tall_photography') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 450w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 350w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1000px) 20vw, (min-width: 690px) 50vw, 100vw"';
										} else if($masonry_item_sizing == 'wide_tall_photography') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 450w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1000px) 40vw, (min-width: 690px) 100vw, 100vw"';
										} else if($masonry_item_sizing == 'wide_photography') {

											$regular_size = ($regular_size) ? $regular_size[0] .' 900w' : null;
											$small_size = ($small_size) ? ', '. $small_size[0] .' 700w' : null;
											$image_srcset = $image_srcset_attr.'="'.$regular_size.$small_size.'"';

											$image_sizes = 'sizes="(min-width: 1000px) 40vw, (min-width: 690px) 100vw, 100vw"';
										}
									}
								}
							}


							switch ( $source ) {
								case 'media_library':
									if ($attach_id > 0) {

										$gallery_images_to_skip = (!empty($image_grid_lazy_skip) || $image_grid_lazy_skip === '0' ) ? intval($image_grid_lazy_skip) : 8;
									
										if( $masonry_layout == 'true' && $layout != '3' && $layout != '4' && $layout != '2' && $bypass_image_cropping != 'true') {

											$image_width = null;
											$image_height = null;

											if(!empty($image_meta['width'])) $image_width = $image_meta['width'];
											if(!empty($image_meta['height'])) $image_height = $image_meta['height'];

											$wp_img_alt_tag = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );

											$image_src = '';
											$image_src = wp_get_attachment_image_src($attach_id, $masonry_item_sizing);
											
											if(!empty($image_src)) {
												$image_src = $image_src[0];
											}

											$post_thumbnail = array();

											$masonry_image_sizes = array(
												'regular_width' => '500',
												'regular_height' => '500',
												'tall_width' => '500',
												'tall_height' => '1000',
												'wide_tall_width' => '1000',
												'wide_tall_height' => '1000',
												'wide_width' => '1000',
												'wide_height' => '500',
												'regular_photography_width' => '450',
												'regular_photography_height' => '600',
												'wide_photography_width' => '900',
												'wide_photography_height' => '600',
												'wide_tall_photography_width' => '900',
												'wide_tall_photography_height' => '1200',
											);

											$simulated_lazy_fade_class = ( $i < $gallery_images_to_skip ) ? ' top-level-image' : '';

											if( 'lazy-load' === $image_grid_loading && $i >= $gallery_images_to_skip ) {
												$post_thumbnail['thumbnail'] = '<img class="size-'.esc_attr($masonry_item_sizing).' skip-lazy nectar-lazy keep-calculated-size image-gallery-portfolio-item" data-nectar-img-src="'.esc_url($image_src).'" alt="'.esc_attr($wp_img_alt_tag).'" height="'.esc_attr($masonry_image_sizes[$masonry_item_sizing.'_height']).'" width="'.esc_attr($masonry_image_sizes[$masonry_item_sizing.'_width']).'" ' .$image_srcset.' '.$image_sizes.' />';
											} else {
												$post_thumbnail['thumbnail'] = '<img class="size-'.esc_attr($masonry_item_sizing).$simulated_lazy_fade_class.'" src="'.esc_url($image_src).'" alt="'.esc_attr($wp_img_alt_tag).'" height="'.esc_attr($image_height).'" width="'.esc_attr($image_width).'" ' .$image_srcset.' '.$image_sizes.' />';
											}
											
											$post_thumbnail['p_img_large'][0] = '';

										}

										else {

											 $simulated_lazy_fade_class = ( $i < $gallery_images_to_skip ) ? ' top-level-image' : '';

											$post_thumb_classes = ( 'lazy-load' === $image_grid_loading && $i >= $gallery_images_to_skip ) ? 'skip-lazy nectar-lazy image-gallery-portfolio-item' : 'skip-lazy' .  $simulated_lazy_fade_class;

											if( $masonry_layout == 'true' && $bypass_image_cropping == 'true' && 'full' !== $img_size ) {
												$img_size = 'large';
											}

											$post_thumbnail = wpb_getImageBySize(array( 'attach_id' => (int) $attach_id, 'thumb_size' => $img_size, 'class' => $post_thumb_classes ));

											// lazy.
											if( 'lazy-load' === $image_grid_loading && isset($post_thumbnail['thumbnail']) && $i >= $gallery_images_to_skip ) {

										$content = false;
										 // Srcset.
											if( strpos($post_thumbnail['thumbnail'],'srcset') !== false ) {
												preg_match( '/< *img[^>]*srcset *= *["\']?([^"\']*)/i', $post_thumbnail['thumbnail'], $srcset_match);
												if($srcset_match && isset($srcset_match[1]) ) {
												$content = preg_replace( '#<img([^>]+?)srcset=[\'"](.*)[\'"]?([^>]*)>#', '<img${1} data-nectar-img-srcset="'.esc_attr($srcset_match[1]).'"${3}>', $post_thumbnail['thumbnail'] );
												}
											}

				                // Src.
				                preg_match( '/< *img[^>]*src *= *["\']?([^"\']*)/i', $post_thumbnail['thumbnail'], $src_match);
				                if($src_match && isset($src_match[1]) ) {
				                  if(false === $content) {
				                    $content = $post_thumbnail['thumbnail'];
				                  }
				                  $content = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', '<img${1} data-nectar-img-src="'.esc_attr($src_match[1]).'"${3}>', $content );
				                }

				                if( false !== $content ) {
				                  $post_thumbnail['thumbnail'] = $content;
				                }

				              }

										}

									}
									else {
										$post_thumbnail = array();
										$post_thumbnail['thumbnail'] = '<img src="http://placehold.it/500x500" />';
										$post_thumbnail['p_img_large'][0] = 'http://placehold.it/500x500';
									}
									break;

								case 'external_link':
									$image = esc_attr( $attach_id );
									$dimensions = vc_extract_dimensions( $external_img_size );
									$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
									$post_thumbnail['thumbnail'] = '<img ' . $hwstring . ' src="' . $image . '" />';
									$post_thumbnail['p_img_large'][0] = $image;
									break;
							}


							//project style 1
							if($gallery_style == '1') { ?>

							<div class="work-item">

								<?php

								echo $post_thumbnail['thumbnail']; ?>

								<div class="work-info-bg"></div>
								<div class="work-info">

									<?php
										if($attach_id > 0) {
											$attachment_meta = wp_get_attachment($attach_id);

											if(!empty($attachment_meta['image_url'])) {
												echo '<div class="vert-center no-text"><a class="no-text" href="'.esc_url($attachment_meta['image_url']).'">'.__("View Larger", 'salient').'</a> ';
											} else {
												echo '<div class="vert-center"><a ';
												 if(!empty($attachment_meta['description'])) echo 'title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"';
												echo ' href="'.$p_img_large[0].'" class="default-link pretty_photo">'.esc_html__("View Larger", 'salient-core').'</a> ';
											} ?>
											</div><!--/vert-center-->
										<?php } ?>

								</div>
							</div><!--work-item-->

							<?php if($display_title_caption == 'true') { ?>

								<div class="work-meta">
									<?php if($attach_id > 0) {  ?>
										<h4 class="title"><?php echo wp_kses_post( $attachment_meta['title'] ); ?></h4>
										<p><?php echo wp_kses_post( $attachment_meta['caption'] ); ?></p>
									<?php } ?>
								</div>

							<?php } ?>

						<?php } //project style 1


						//project style 2
						else if($gallery_style == '2') { ?>

							<div class="work-item style-2">

								<?php
								echo $post_thumbnail['thumbnail']; ?>

								<div class="work-info-bg"></div>
								<div class="work-info">


									<?php
									if($attach_id > 0) {

										$attachment_meta = wp_get_attachment($attach_id);
										if(!empty($attachment_meta['image_url'])) { ?>
									   		 <a <?php echo 'href="'.esc_url($attachment_meta['image_url']).'"'; ?>></a>
								   		<?php } else { ?>
								   			 <a <?php echo 'href="'.esc_url($p_img_large[0]).'"';
								   			  if(!empty($attachment_meta['description'])) { echo ' title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"'; }
								   			 echo ' class="pretty_photo"'; ?>></a>
								   		<?php } ?>

										<div class="vert-center">
											<?php if($display_title_caption == 'true') { ?>

												<?php if(!empty($attachment_meta['title'])) { ?>
													<h3><?php echo wp_kses_post( $attachment_meta['title'] ); ?></h3>
												<?php } ?>
												<p><?php echo wp_kses_post( $attachment_meta['caption'] ); ?></p>

											<?php } ?>
										</div><!--/vert-center-->

									<?php } ?>


								</div>
							</div><!--work-item-->

						<?php } //project style 2



						else if($gallery_style == '3') { ?>

							<div class="work-item style-3">

								<?php
								echo $post_thumbnail['thumbnail'];

								if($attach_id > 0) {
                  $attachment_meta = wp_get_attachment($attach_id);
                }

								?>

								<div class="work-info-bg"></div>

								<?php if($attach_id > 0) { ?>

									<div class="work-info">

										<div class="vert-center">
											<?php if($display_title_caption == 'true') { ?>

												<?php if(!empty($attachment_meta['title'])) { ?>
													<h3><?php echo wp_kses_post( $attachment_meta['title'] ); ?></h3>
												<?php } ?>
												<p><?php echo wp_kses_post( $attachment_meta['caption'] ); ?></p>

											<?php } ?>
										</div><!--/vert-center-->

										<?php

										if(!empty($attachment_meta['image_url'])) { ?>
									   		 <a <?php echo 'href="'. esc_url( $attachment_meta['image_url'] ) .'"'; ?>></a>
								   		<?php } else { ?>
								   			 <a <?php echo 'href="'. esc_url( $p_img_large[0] ) .'"';
								   			  if(!empty($attachment_meta['description'])) echo ' title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"';
								   			  echo ' class="pretty_photo"'; ?>></a>
								   		<?php } ?>

									</div>

								<?php } ?>

							</div><!--work-item-->

						<?php } //project style 3


						else if($gallery_style == '4') { ?>

							<div class="work-item style-4">

								<?php
								echo $post_thumbnail['thumbnail']; ?>

								<div class="work-info">

								    <?php

								    if($attach_id > 0) {

									    $attachment_meta = wp_get_attachment($attach_id);

									    if(!empty($attachment_meta['image_url'])) { ?>
									   		 <a <?php echo 'href="'. esc_url ( $attachment_meta['image_url'] ) .'"'; ?>></a>
								   		<?php } else { ?>
								   			 <a <?php echo 'href="'. esc_url ( $p_img_large[0] ) .'"';
								   			  if(!empty($attachment_meta['description'])) echo ' title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"';
								   			  echo ' class="pretty_photo"'; ?>></a>
								   		<?php } ?>

										<div class="bottom-meta">
											<?php if($display_title_caption == 'true') { ?>

											<?php if(!empty($attachment_meta['title'])) { ?>
												<h3><?php echo wp_kses_post( $attachment_meta['title'] ); ?></h3>
											<?php } ?>
											<p><?php echo wp_kses_post( $attachment_meta['caption'] ); ?></p>

											<?php } ?>
										</div><!--/bottom-meta-->

									<?php } ?>

								</div>
							</div><!--work-item-->

						<?php } //project style 4

						else if($gallery_style == '5') { ?>

							<div class="work-item style-3-alt">

								<?php
								echo $post_thumbnail['thumbnail'];
								if($attach_id > 0) $attachment_meta = wp_get_attachment($attach_id);
								?>

								<div class="work-info-bg"></div>
								<div class="work-info">

									<div class="vert-center">
										<?php if($attach_id > 0) { ?>
											<?php if($display_title_caption == 'true') { ?>

												<?php if(!empty($attachment_meta['title'])) { ?>
													<h3><?php echo wp_kses_post( $attachment_meta['title'] ); ?></h3>
												<?php } ?>
												<p><?php echo wp_kses_post( $attachment_meta['caption'] ); ?></p>

											<?php } ?>
										<?php } ?>
									</div><!--/vert-center-->

									<?php

									if($attach_id > 0) {

										if(!empty($attachment_meta['image_url'])) { ?>
									   		 <a <?php echo 'href="'. esc_url( $attachment_meta['image_url'] ) .'"'; ?>></a>
								   		<?php } else { ?>
								   			 <a <?php echo 'href="'. esc_url( $p_img_large[0] ) .'"';
								   			  if(!empty($attachment_meta['description'])) echo ' title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"';
								   			  echo ' class="pretty_photo"'; ?>></a>
								   		<?php } ?>

								   	<?php } ?>

								</div>
							</div><!--work-item-->

						<?php } //project style 5

						//project style 2
						else if($gallery_style == '7') { ?>

							<div class="work-item style-2">

								<?php
								echo $post_thumbnail['thumbnail']; ?>

								<div class="work-info-bg"></div>
								<div class="work-info">


									<?php
									if($attach_id > 0) {

										$attachment_meta = wp_get_attachment($attach_id);
										if(!empty($attachment_meta['image_url'])) { ?>
									   		 <a <?php echo 'href="'. esc_url( $attachment_meta['image_url'] ) .'"'; ?>></a>
								   		<?php } else { ?>
								   			 <a <?php echo 'href="'. esc_url( $p_img_large[0] ) .'"';
								   			  if(!empty($attachment_meta['description'])) echo ' title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"';
								   			 echo ' class="pretty_photo"'; ?>></a>
								   		<?php } ?>

										<div class="vert-center">
											<?php if($display_title_caption == 'true') { ?>

												<?php if(!empty($attachment_meta['title'])) { ?>
													<h3><?php echo wp_kses_post( $attachment_meta['title'] ) ; ?></h3>
												<?php } ?>
												<p><?php echo wp_kses_post( $attachment_meta['caption'] ) ; ?></p>

											<?php } ?>
										</div><!--/vert-center-->

									<?php } ?>


								</div>
							</div><!--work-item-->

						<?php } //project style 7

						else if($gallery_style == '8') { ?>

							<div class="work-item style-2">

								<?php
								echo $post_thumbnail['thumbnail']; ?>

								<div class="work-info-bg"></div>
								<div class="work-info">


									<?php
									if($attach_id > 0) {

										$attachment_meta = wp_get_attachment($attach_id);
										if(!empty($attachment_meta['image_url'])) { ?>
									   		 <a <?php echo 'href="'. esc_url( $attachment_meta['image_url'] ) .'"'; ?>></a>
								   		<?php } else { ?>
								   			 <a <?php echo 'href="'. esc_url( $p_img_large[0] ) .'"';
								   			  if(!empty($attachment_meta['description'])) echo ' title="'.esc_attr(wp_kses_post($attachment_meta['description'])).'"';
								   			 echo ' class="pretty_photo"'; ?>></a>
								   		<?php } ?>

										<div class="vert-center">
											<?php if($display_title_caption == 'true') { ?>

												<p><?php echo wp_kses_post( $attachment_meta['caption'] ); ?></p>
												<?php if(!empty($attachment_meta['title'])) { ?>
													<h3><?php echo wp_kses_post( $attachment_meta['title'] ); ?></h3>
												<?php } ?>

											<?php } ?>
											<svg class="next-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 12"><line class="top" x1="23" y1="-0.5" x2="29.5" y2="6.5" stroke="#ffffff;"/>
                        <line class="bottom" x1="23" y1="12.5" x2="29.5" y2="5.5" stroke="#ffffff;"/>
                      </svg>
                      <span class="line"></span>
                    </span>

										</div><!--/vert-center-->

									<?php } ?>


								</div>
							</div><!--work-item-->

						<?php } //project style 8 ?>


						</div></div> <?php //project col / innerwrap ?>

						<?php
						$thumbnail = ob_get_contents();

						ob_end_clean();

						$link_start = null;
						$link_end = null;


	}





    $gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
}
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element'.$el_class.' clearfix', $this->settings['base'], $atts );
$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));
$output .= '<div class="wpb_gallery_slides'.$type.'" data-onclick="'.esc_attr($onclick).'" data-interval="'.esc_attr($interval).'"'.$flex_fx.'>'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div>';
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gallery');

echo $output;
