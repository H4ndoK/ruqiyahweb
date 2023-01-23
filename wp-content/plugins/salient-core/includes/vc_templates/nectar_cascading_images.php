<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-cascading-images' );

$cascading_attrs = shortcode_atts(array(
  "image_1_url" => '',
  "image_1_bg_color" => "",
  "image_1_offset_x_sign" => "+",
  "image_1_offset_x" => "",
  "image_1_offset_y_sign" => "+",
  "image_1_offset_y" => "",
  "image_1_rotate_sign" => "+",
  "image_1_rotate" => "none",
  "image_1_scale" => "1",
  "image_1_animation" => "Fade In",
  "image_1_box_shadow" => "none",
  "image_1_padding" => 'auto',
  "image_1_max_width_desktop" => '100%',
  "image_1_max_width_mobile" => '100%',
	"image_1_image_width_mobile" => "default",
  "image_2_url" => '',
  "image_2_bg_color" => "",
  "image_2_offset_x_sign" => "+",
  "image_2_offset_x" => "",
  "image_2_offset_y_sign" => "+",
  "image_2_offset_y" => "",
  "image_2_rotate_sign" => "+",
  "image_2_rotate" => "none",
  "image_2_scale" => "1",
  "image_2_animation" => "Fade In",
  "image_2_box_shadow" => "none",
  "image_2_padding" => 'auto',
  "image_2_max_width_desktop" => '100%',
  "image_2_max_width_mobile" => '100%',
	"image_2_image_width_mobile" => "default",
  "image_3_url" => '',
  "image_3_bg_color" => "",
  "image_3_offset_x_sign" => "+",
  "image_3_offset_x" => "",
  "image_3_offset_y_sign" => "+",
  "image_3_offset_y" => "",
  "image_3_rotate_sign" => "+",
  "image_3_rotate" => "none",
  "image_3_scale" => "1",
  "image_3_animation" => "Fade In",
  "image_3_box_shadow" => "none",
  "image_3_padding" => 'auto',
  "image_3_max_width_desktop" => '100%',
  "image_3_max_width_mobile" => '100%',
	"image_3_image_width_mobile" => "default",
  "image_4_url" => '',
  "image_4_bg_color" => "",
  "image_4_offset_x_sign" => "+",
  "image_4_offset_x" => "",
  "image_4_offset_y_sign" => "+",
  "image_4_offset_y" => "",
  "image_4_rotate_sign" => "+",
  "image_4_rotate" => "none",
  "image_4_scale" => "1",
  "image_4_animation" => "Fade In",
  "image_4_box_shadow" => "none",
  "image_4_padding" => 'auto',
  "image_4_max_width_desktop" => '100%',
  "image_4_max_width_mobile" => '100%',
	"image_4_image_width_mobile" => "default",
  "animation_timing" => '175',
  "border_radius" => 'none',
  "image_loading" => 'default',
  "parallax_scrolling" => '',
  "parallax_scrolling_intensity" => 'subtle',
	'layer_1_parallax_scrolling' => 'no',
	'element_sizing' => 'default',
	'element_sizing_aspect' => '1-1',
	'overflow' => 'visible'
),
$atts);

// Dynamic style classes.
if( function_exists('nectar_el_dynamic_classnames') ) {
	$dynamic_el_styles = nectar_el_dynamic_classnames('nectar_cascading_images', $atts);
} else {
	$dynamic_el_styles = '';
}

$layer_1_parallax_scrolling_attr = ( 'yes' === $cascading_attrs['parallax_scrolling'] && isset($cascading_attrs['layer_1_parallax_scrolling']) ) ? ' data-layer-1-parallax="'.esc_html($cascading_attrs['layer_1_parallax_scrolling']).'"' : '';

echo '<div class="nectar_cascading_images'.esc_attr($dynamic_el_styles).'" data-border-radius="'.esc_attr($cascading_attrs['border_radius']).'" data-parallax="'.esc_attr($cascading_attrs['parallax_scrolling']).'" data-parallax-intensity="'.esc_attr($cascading_attrs['parallax_scrolling_intensity']).'"'.$layer_1_parallax_scrolling_attr.' data-animation-timing="'.esc_attr($cascading_attrs['animation_timing']).'">';

// Find largest transform val.
$transform_arr = array(0);

for( $i = 1; $i < 5; $i++ ) {
	if(!empty($cascading_attrs['image_'.$i.'_offset_x']) && $cascading_attrs['image_'.$i.'_offset_x'] != 'none') {
    $transform_arr[] = intval($cascading_attrs['image_'.$i.'_offset_x']);
  }
	if(!empty($cascading_attrs['image_'.$i.'_offset_y']) && $cascading_attrs['image_'.$i.'_offset_y'] != 'none') {
    $transform_arr[] = intval($cascading_attrs['image_'.$i.'_offset_y']);
  }
}

$transform_arr = max($transform_arr);

switch($transform_arr) {
	case $transform_arr <= 10:
		$divider = 1.15;
		break; 
	case $transform_arr <= 20:
		$divider = 1.35;
		break;
	case $transform_arr <= 30:
		$divider = 1.55;
		break;
	case $transform_arr <= 40:
		$divider = 1.75;
		break;
	case $transform_arr <= 50:
		$divider = 2;
		break;
	case $transform_arr <= 60:
		$divider = 2.25;
		break;
	case $transform_arr <= 70:
		$divider = 2.45;
		break;
	case $transform_arr <= 80:
		$divider = 2.7;
		break;
	case $transform_arr <= 90:
		$divider = 2.85;
		break;
	case $transform_arr < 100:
		$divider = 3;
		break;  
	default:
		$divider = 3;

}

$transform_arr = floor($transform_arr/$divider);

// Output layers.
for( $i = 1; $i < 5; $i++ ) {

	$image_url = '';
	$image_alt = null;
  $image_srcset = null;
  $image_width = false;
  $image_height = false;
  $has_dimension_data = false;
  $lazy_load_wrap_class = '';
	
	if( !empty($cascading_attrs['image_'.$i.'_url']) ) {
		
		if( !preg_match('/^\d+$/',$cascading_attrs['image_'.$i.'_url']) ) {
				
			$image_url = $cascading_attrs['image_'.$i.'_url'];
		
		} else {
      
      
      $image_meta = wp_get_attachment_metadata($cascading_attrs['image_'.$i.'_url']);
			
      if( isset($image_meta['width']) && !empty($image_meta['width']) ) {
        $image_width = $image_meta['width'];
      }
      if( isset($image_meta['height']) && !empty($image_meta['height']) ) {
        $image_height = $image_meta['height'];
      }
      if(false !== $image_height && false !== $image_width) {
        $has_dimension_data = true;
      } 
        
			$image_src = wp_get_attachment_image_src($cascading_attrs['image_'.$i.'_url'], 'full');
			if( isset($image_src[0]) ) {
				$image_url = $image_src[0];
			}
			$image_alt = get_post_meta( $cascading_attrs['image_'.$i.'_url'], '_wp_attachment_image_alt', true );
      
      // Srcset.
      if (function_exists('wp_get_attachment_image_srcset')) {
    
        $image_srcset_values = wp_get_attachment_image_srcset($cascading_attrs['image_'.$i.'_url'], 'full');
        if($image_srcset_values) {
          
          if( true === $has_dimension_data && isset($cascading_attrs['image_loading']) && NectarLazyImages::activate_lazy() && 'lazy-load' === $cascading_attrs['image_loading'] || 
					true === $has_dimension_data && property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
            $image_srcset = 'data-nectar-img-srcset="';
          } else {
            $image_srcset = 'srcset="';
          }

          $image_srcset .= $image_srcset_values;
					
					$mobile_image_vw = '100';
					
					if( isset( $cascading_attrs['image_'.$i.'_image_width_mobile'] ) && 'default' !== $cascading_attrs['image_'.$i.'_image_width_mobile'] ) {
						$mobile_image_vw = $cascading_attrs['image_'.$i.'_image_width_mobile'];
					}
					
          if($transform_arr > 20) {
            $image_srcset .= '" sizes="(min-width: 1000px) 45vw, '.esc_attr($mobile_image_vw).'vw"';
          } else {
            $image_srcset .= '" sizes="(min-width: 1000px) 55vw, '.esc_attr($mobile_image_vw).'vw"';
          }
          
        }
      }
      
		}
		
	}

	$transform_string        = null;
  $scale_string            = null;
  $img_markup              = null;
	$transform_x_sign_string = ($cascading_attrs['image_'.$i.'_offset_x_sign'] == '+') ? '': '-';
	$transform_y_sign_string = ($cascading_attrs['image_'.$i.'_offset_y_sign'] == '+') ? '': '-';
	$rotate_sign_string      = ($cascading_attrs['image_'.$i.'_rotate_sign'] == '+') ? '': '-';
	$parsed_animation        = ( 'yes' !== $cascading_attrs['parallax_scrolling'] ) ? str_replace(" ","-",$cascading_attrs['image_'.$i.'_animation']) : 'none';

	if(!empty($cascading_attrs['image_'.$i.'_offset_x'])) {
    $transform_string .='translateX('.$transform_x_sign_string . $cascading_attrs['image_'.$i.'_offset_x'].') '; 
  }
	if(!empty($cascading_attrs['image_'.$i.'_offset_y'])) {
    $transform_string .= 'translateY('.$transform_y_sign_string . $cascading_attrs['image_'.$i.'_offset_y'].') '; 
  }
	if(!empty($cascading_attrs['image_'.$i.'_rotate']) && $cascading_attrs['image_'.$i.'_rotate'] != 'none') {
    $transform_string .= 'rotate('.$rotate_sign_string . $cascading_attrs['image_'.$i.'_rotate'].'deg) ';
  }
  if(!empty($cascading_attrs['image_'.$i.'_scale']) && $cascading_attrs['image_'.$i.'_scale'] != '100%') {
    $scale_string_escaped = 'style="transform: scale('. esc_attr($cascading_attrs['image_'.$i.'_scale']).')"';
  }
  

  if(!empty($image_url)) {

    // Lazy load.
		$lazy_loading_bool = false;
		
    if( true === $has_dimension_data && isset($cascading_attrs['image_loading']) && NectarLazyImages::activate_lazy() && 'lazy-load' === $cascading_attrs['image_loading'] ||
	      true === $has_dimension_data && property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
			
			$lazy_loading_bool = true;
			$lazy_load_wrap_class = ' lazy-enabled';		
			
			$placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($image_width).'%20'.esc_attr($image_height)."'%2F%3E";	
      $img_el = '<img src="'.$placeholder_img_src.'" data-nectar-img-src="'.$image_url.'" '.$image_srcset.' height="'.esc_attr($image_height).'" width="'.esc_attr($image_width).'" class="skip-lazy nectar-lazy" alt="'.esc_attr($image_alt).'" />';
    } else {
			
			if( true === $has_dimension_data ) {
				$img_el = '<img src="'.$image_url.'" '.$image_srcset.' height="'.esc_attr($image_height).'" width="'.esc_attr($image_width).'" class="skip-lazy" alt="'.esc_attr($image_alt).'" />';
			} else {
				$img_el = '<img src="'.$image_url.'" '.$image_srcset.' class="skip-lazy" alt="'.esc_attr($image_alt).'" />';
			}
    
    }
    
		// Forced Aspect Ratio.
		if( $i === 1 && 'forced' === $cascading_attrs['element_sizing'] ) {
			
			if( true === $lazy_loading_bool ) {
				$img_markup = '<div style="-webkit-transform:'.$transform_string.'; transform:'.$transform_string.';" data-nectar-img-src="'.esc_url($image_url).'" class="img-wrap"></div>';
			} else {
				$img_markup = '<div style="-webkit-transform:'.$transform_string.'; transform:'.$transform_string.'; background-image:url('.esc_attr($image_url).')" class="img-wrap"></div>';
			}
			
		}
		// Regular.
		else {
			$img_markup = '<div style=" -webkit-transform:'.$transform_string.'; transform:'.$transform_string.';" class="img-wrap'.$lazy_load_wrap_class.'"> '.$img_el.' </div>';
		}
    
    
  }
	
	$data_has_bg_img   = (!empty($image_url)) ? 'true': 'false';
	$data_has_bg_color = (!empty($cascading_attrs['image_'.$i.'_bg_color'])) ? 'true' : 'false';
	$bg_color_markup   = ($data_has_bg_color == 'true') ? '<div class="bg-color" style=" -webkit-transform:'.$transform_string.'; -ms-transform:'.$transform_string.'; transform: '.$transform_string.'; background-color: '.$cascading_attrs['image_'.$i.'_bg_color'].';" data-has-bg-color="'.esc_attr($data_has_bg_color).'"></div>' : null;
	
	if( !empty($image_url) || $data_has_bg_color === 'true' ) {
    
    if( isset($cascading_attrs['image_'.$i.'_padding']) && 'none' === $cascading_attrs['image_'.$i.'_padding'] ) {
      $padding_amt = '0';
    } else {
      $padding_amt = $transform_arr;
    }
    $desktop_max_w = (isset($cascading_attrs['image_'.$i.'_max_width_desktop']) && !empty($cascading_attrs['image_'.$i.'_max_width_desktop']) ) ? $cascading_attrs['image_'.$i.'_max_width_desktop'] : '100%';
    $mobile_max_w = (isset($cascading_attrs['image_'.$i.'_max_width_mobile']) && !empty($cascading_attrs['image_'.$i.'_max_width_mobile']) ) ? $cascading_attrs['image_'.$i.'_max_width_mobile'] : '100%';
    
		echo '<div class="cascading-image" data-has-img="'.esc_attr($data_has_bg_img).'" style=" padding:'.$padding_amt .'%;" data-max-width="'.esc_attr($desktop_max_w).'" data-max-width-mobile="'.esc_attr($mobile_max_w).'" data-animation="'.strtolower(esc_attr($parsed_animation)).'" data-shadow="'.esc_attr($cascading_attrs['image_'.$i.'_box_shadow']).'"><div class="inner-wrap"><div class="bg-layer" data-scale="'.esc_attr($cascading_attrs['image_'.$i.'_scale']).'" '.$scale_string_escaped.'>'.$bg_color_markup . $img_markup.'</div></div></div>';
	}
  
}

echo '</div>';

?>