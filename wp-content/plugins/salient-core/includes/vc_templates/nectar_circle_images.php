<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
    'images' => '-1',
    'image_size' => 'nectar_small_square',
    'stacking_order' => 'ltr',
    'image_loading' => '',
    'animation' => '',
    'delay' => '',
    'numerical_circle' => '',
    'numerical_circle_number' => '',
    'numerical_circle_color' => '#000000',
    'numerical_circle_text_color' => '#ffffff',
    'text_content' => ''
  ), $atts));

/* Gather images into an arr */
$images = explode( ',', $images );
$images_markup_arr = array();
$i = 0;

foreach ($images as $attach_id) {
    
    $zindex = ( 'ltr' === $stacking_order ) ? 100 - $i : 'auto';

    if ($attach_id > 0) {

        if( 'lazy-load' === $image_loading && NectarLazyImages::activate_lazy() ||
            ( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active && 'skip-lazy-load' !== $image_loading ) ) {
            
            if(!preg_match('/^\d+$/',$attach_id)) {
              $image_arr = array($attach_id);
            } else {
              $image_arr = wp_get_attachment_image_src($attach_id, $image_size);
            }

            if( isset($image_arr[0]) ) {
                $image_src = $image_arr[0];
                $images_markup_arr[] = '<div class="nectar-circle-images__image nectar-circle-images__item" style="z-index: '.$zindex.';" data-nectar-img-src="'.esc_attr($image_src).'"></div>'; 
            }
            
        } 
        
        else {
            if(!preg_match('/^\d+$/',$attach_id)) {
              $image_src = array($attach_id);
            } else {
              $image_src = wp_get_attachment_image_src($attach_id, $image_size);
            }

            if( isset($image_src[0]) ) {
              $images_markup_arr[] = '<div class="nectar-circle-images__image nectar-circle-images__item" style="z-index: '.$zindex.'; background-image: url('.esc_attr($image_src[0]).');"></div>';
            }
            
        }
        
    }

  $i++;
}

if( count($images) == 1 && $images[0] == '-1' ) {
  for( $i=0; $i<4; $i++) {
    $zindex = ( 'ltr' === $stacking_order ) ? 100 - $i : 'auto';
    $place_holder_size = 'square';
    $images_markup_arr[$i] = '<div class="nectar-circle-images__image nectar-circle-images__item" style="z-index: '.$zindex.'; background-image: url('.esc_attr( SALIENT_CORE_PLUGIN_PATH . '/includes/img/placeholder-'.$place_holder_size.'.jpg').');"></div>';
  }
}

// Numerical last image
if( $numerical_circle === 'true' ) {
  $images_markup_arr[] = '<div class="nectar-circle-images__image nectar-circle-images__item nectar-circle-images--text nectar-inherit-h5" style="background-color: '.esc_attr($numerical_circle_color).'; color: '.esc_attr($numerical_circle_text_color).';"><span>'.$numerical_circle_number.'</span></div>';
}


$image_markup = '';
foreach( $images_markup_arr as $img ) {
    $image_markup .= $img;
}


// attrs
$el_classes = array('nectar-circle-images');
$el_attrs   = array('');

if( !empty($animation) && 'none' !== $animation ) {
    $el_classes[] = 'nectar-waypoint-el';
    $el_attrs[] = 'data-nectar-waypoint-el-stagger="nectar-circle-images__item"';
    $el_attrs[] = 'data-nectar-waypoint-el-offset="95%"';

    if( !empty($delay) ) {
        $el_attrs[] = 'data-nectar-waypoint-el-delay="'.esc_attr($delay).'"';
    }
}

if( function_exists('nectar_el_dynamic_classnames') ) {
	$el_classes[] = nectar_el_dynamic_classnames('nectar_circle_images', $atts);
} else {
	$el_classes[] = '';
}

if(!empty($text_content)) {
  $text_content = '<div class="nectar-circle-images__text nectar-circle-images__item">'.$text_content.'</div>';
}

echo '<div class="'.nectar_clean_classnames(implode(' ',$el_classes)).'" '.implode(' ',$el_attrs).'><div class="nectar-circle-images__inner">' . $image_markup . '</div>'.$text_content.'</div>';