<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

   extract(shortcode_atts(array(
	  "type" => 'in_container',
	  'bg_image'=> '', 
	  'background_image_mobile_hidden' => '',
	  'bg_position'=> '', 
	  'bg_repeat' => '', 
	  'parallax_bg' => '', 
	  'parallax_bg_speed' => 'slow',
	  'bg_color'=> '', 
	  'exclude_row_header_color_inherit' => '',
	  'text_align'=> '', 
	  'vertically_center_columns' => '',
	  
	  'mouse_based_parallax_bg' => '',
	  'layer_one_image' => '',
	  'layer_two_image' => '',
	  'layer_three_image' => '',
	  'layer_four_image' => '',
	  'layer_five_image' => '',

	  'layer_one_strength' => '.20',
	  'layer_two_strength' => '.40',
	  'layer_three_strength' => '.60',
	  'layer_four_strength' => '.80',
	  'layer_five_strength' => '1.00',
	  'scene_position' => '',
	  'mouse_sensitivity' => '10',
    
    'disable_element' => '',
	  'video_bg'=> '', 
	  'enable_video_color_overlay'=> '', 
	  'video_overlay_color'=> '', 
	  'video_webm'=> '', 
	  'video_mp4'=> '', 
	  'video_ogv'=> '', 
	  'video_image'=> '', 
	  
	  "top_padding" => "", 
	  "bottom_padding" => "",
	  'text_color' => 'dark',  
	  'custom_text_color' => '',  
	  'id' => '',
	  'el_id' => '',
	  'equal_height' => '',
	  'content_placement' => '',
	  'column_margin' => 'default',
		
		'column_direction' => 'default',
		'column_direction_tablet' => 'default',
		'column_direction_phone' => 'default',
		
	  'css' => '',
	  'class' => '',
    'translate_x' => '',
    'translate_y' => '',
		'zindex' => ''
  ), 
	$atts));
	
	wp_enqueue_style( 'js_composer_front' );
	wp_enqueue_script( 'wpb_composer_front_js' );
	wp_enqueue_style('js_composer_custom_css');
	
	if($mouse_based_parallax_bg == 'true') {
		wp_enqueue_script('nectar-parallax');
	}
	
  $style = null;
  $bg_props = null;
	$etxra_class = null;
	$using_image_class = null;
	$using_bg_color_class = null;
	$using_custom_text_color = null;
	$css_perspective_class = '';
	
	global $post;
		
	if( in_the_loop() && isset($post->ID) ) {
    
		// CSS perspective
		if( isset( $content ) ) {
			
			if( strpos( $content, '"flip-in-vertical"' ) !== false || 
			    strpos( $content, '"slight-twist"' ) !== false ) {
				 
				 // Prevent if using incompatible el.
				 if( strpos( $content, 'sticky="true"' ) === false && 
				     strpos( $content, '"vertical_scrolling"' ) === false ) {
					  	$css_perspective_class = ' flip-in-vertical-wrap';
				 }
				 
			} // element exists that needs perspective.
		} // content is set.
    
  }

  
  if ( 'yes' !== $disable_element ) {
  
    	if($this->shortcode == 'vc_row_inner') {
        $text_color = '';
      }
    	
    	if(!empty($bg_image)) {

    		if(!preg_match('/^\d+$/',$bg_image)){
    				
    			$bg_props .= 'background-image: url('. esc_url($bg_image) . '); ';
    			$bg_props .= 'background-position: '. esc_attr($bg_position) .'; ';
    		
    		} else {
    			$bg_image_src = wp_get_attachment_image_src($bg_image, 'full');
    			
    			$bg_props .= 'background-image: url('. esc_url($bg_image_src[0]) . '); ';
    			$bg_props .= 'background-position: '. esc_attr($bg_position) .'; ';
    		}
    		
    		// For pattern bgs.
    		if(strtolower($bg_repeat) === 'repeat'){
    			$bg_props .= 'background-repeat: '. esc_attr(strtolower($bg_repeat)) .'; ';
    			$etxra_class = ' no-cover';
    		} else {
    			$bg_props .= 'background-repeat: '. esc_attr(strtolower($bg_repeat)) .'; ';
    			$etxra_class = null;
    		}

    		$using_image_class = ' using-image';
    	}

    	if( !empty($bg_color) ) {
    		$bg_props .= 'background-color: '. esc_attr($bg_color).'; ';
    		if($exclude_row_header_color_inherit != 'true') {
          $using_bg_color_class = ' using-bg-color';
        }
    	}
    	
    	if( strtolower($parallax_bg) === 'true' ){
    		$parallax_class = ' parallax_section';
    		$parallax_speed = 'data-parallax-speed="'.esc_attr($parallax_bg_speed).'"';
    	} else {
    		$parallax_class = '';
    		$parallax_speed = null;
    	}
    	
    	if(strtolower($vertically_center_columns) === 'true'){
    		$vertically_center_class = ' vertically-align-columns';
    	} else {
    		$vertically_center_class = null;
    	}
    	

    	if( strpos($top_padding,'%') !== false || 
			strpos($top_padding,'vh') !== false || 
			strpos($top_padding,'vw') !== false || 
			strpos($top_padding,'em') !== false) {
    		$style .= 'padding-top: '. esc_attr($top_padding) .'; ';
    	} 
			else if( !empty($top_padding) ) {	
    		$style .= 'padding-top: '. esc_attr(intval($top_padding)) .'px; ';
    	}

    	if( strpos($bottom_padding,'%') !== false || 
			strpos($bottom_padding,'vh') !== false || 
			strpos($bottom_padding,'vw') !== false || 
			strpos($bottom_padding,'em') !== false) {
    		$style .= 'padding-bottom: '. esc_attr($bottom_padding) .'; ';
    	} 
			else if( !empty($bottom_padding) ) {	
    		$style .= 'padding-bottom: '. esc_attr(intval($bottom_padding)) .'px; ';
    	}
      
    
			
			// z-index.
      if( !empty($zindex) ) {
         $style .= ' z-index: '.esc_attr($zindex).';';
      }


    	if( $text_color === 'custom' && !empty($custom_text_color) ) {
    		$style .= 'color: '. esc_attr($custom_text_color) .'; ';
    		$using_custom_text_color = 'data-using-ctc="true"';
    	}
    	

    	if( $type === 'in_container' ) {
    		$main_class = "";
    		
    	} else if( $type === 'full_width_background' ){
    		$main_class = "full-width-section ";
    		
    	} else if( $type === 'full_width_content' ){
    		$main_class = "full-width-content ";
    	}

    	// Equal height.
    	if( $equal_height === 'yes' ) {
    		$equal_height_class = ' vc_row-o-equal-height vc_row-flex';
      }
    	else {
    	 	$equal_height_class = '';
      }

    	 if ( ! empty( $content_placement ) ) {
    		$equal_height_class .= ' vc_row-o-content-' . $content_placement;
    	}
    		 
    	 
    	$row_id    = (!empty($el_id)) ? $el_id: uniqid("fws_");
    	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
    	
			// Dynamic style classes.
			if( function_exists('nectar_el_dynamic_classnames') ) {
				$dynamic_el_styles = nectar_el_dynamic_classnames('inner_row', $atts);
			} else {
				$dynamic_el_styles = '';
			}
			
			$bg_mobile_hidden = ( !empty($background_image_mobile_hidden) ) ? ' data-bg-mobile-hidden="'.esc_attr($background_image_mobile_hidden).'" ' : '';
			
			$user_css_class = '';
			if( !empty($css_class) ) {
				$user_css_class = ' ' . $css_class;
			}
		
			$css_classes_combined = 'wpb_row vc_row-fluid vc_row inner_row '. $main_class . $equal_height_class . $parallax_class . $user_css_class . $vertically_center_class . ' '. $class . $dynamic_el_styles;

      echo '<div id="'.$row_id.'" data-midnight="'.esc_attr(strtolower($text_color)).'" data-column-margin="'.esc_attr($column_margin).'"'.$bg_mobile_hidden.' class="'.nectar_clean_classnames($css_classes_combined).'" '.$using_custom_text_color.' style="'.$style.'">';
    	
    	// Row bg. 
			$row_bg_style_markup = (!empty($bg_props)) ? ' style="'.$bg_props.'"' : '';
    	echo '<div class="row-bg-wrap"> <div class="row-bg'.$using_image_class . $using_bg_color_class . $etxra_class.'" '.$parallax_speed . $row_bg_style_markup.'></div> </div>';

    	// Mouse based parallax.
    	if( $mouse_based_parallax_bg === 'true' ) {

            echo '<ul class="nectar-parallax-scene" data-scene-position="'.esc_attr($scene_position).'" data-scene-strength="'.esc_attr($mouse_sensitivity).'">';
            echo '<li class="layer" data-depth="0.00"></li>';

            if( !empty($layer_one_image) ) {
              
            	if(!preg_match('/^\d+$/',$layer_one_image)){
            		$layer_one_image_src = $layer_one_image;
            	} else {
            		$layer_one_image_src = wp_get_attachment_image_src($layer_one_image, 'full');
            		$layer_one_image_src = $layer_one_image_src[0];
            	}  

            	echo '<li class="layer" data-depth="'.esc_attr($layer_one_strength).'"><div style="background-image:url(\''. esc_url($layer_one_image_src) .'\');"></div></li>';
            }
            
            if( !empty($layer_two_image) ) {

            	if(!preg_match('/^\d+$/',$layer_two_image)){
            		$layer_two_image_src = $layer_two_image;
            	} else {
            		$layer_two_image_src = wp_get_attachment_image_src($layer_two_image, 'full');
            		$layer_two_image_src = $layer_two_image_src[0];
            	}  

            	echo '<li class="layer" data-depth="'.esc_attr($layer_two_strength).'"><div style="background-image:url(\''. esc_url($layer_two_image_src) .'\');"></div></li>';
            }
            if( !empty($layer_three_image) ) {

            	if(!preg_match('/^\d+$/',$layer_three_image)){
            		$layer_three_image_src = $layer_three_image;
            	} else {
            		$layer_three_image_src = wp_get_attachment_image_src($layer_three_image, 'full');
            		$layer_three_image_src = $layer_three_image_src[0];
            	}  

            	echo '<li class="layer" data-depth="'.esc_attr($layer_three_strength).'"><div style="background-image:url(\''. esc_url($layer_three_image_src) .'\');"></div></li>';
            }
            if( !empty($layer_four_image) ) {

            	if(!preg_match('/^\d+$/',$layer_four_image)){
            		$layer_four_image_src = $layer_four_image;
            	} else {
            		$layer_four_image_src = wp_get_attachment_image_src($layer_four_image, 'full');
            		$layer_four_image_src = $layer_four_image_src[0];
            	}  

            	echo '<li class="layer" data-depth="'.esc_attr($layer_four_strength).'"><div style="background-image:url(\''. esc_url($layer_four_image_src) .'\');"></div></li>';
            }
            if( !empty($layer_five_image) ) {

            	if(!preg_match('/^\d+$/',$layer_five_image)){
            		$layer_five_image_src = $layer_five_image;
            	} else {
            		$layer_five_image_src = wp_get_attachment_image_src($layer_five_image, 'full');
            		$layer_five_image_src = $layer_five_image_src[0];
            	}  

            	echo '<li class="layer" data-depth="'.esc_attr($layer_five_strength).'"><div style="background-image:url(\''. esc_url($layer_five_image_src) .'\');"></div></li>';
            }
            echo '</ul>';

        global $nectar_options;
        $loading_animation    = (!empty($nectar_options['loading-image-animation']) && !empty($nectar_options['loading-image'])) ? $nectar_options['loading-image-animation'] : null; 
    		$default_loader       = (empty($nectar_options['loading-image']) && !empty($nectar_options['theme-skin']) && $nectar_options['theme-skin'] == 'ascend') ? '<span class="default-loading-icon spin"></span>' : null;
    		$default_loader_class = (empty($nectar_options['loading-image']) && !empty($nectar_options['theme-skin']) && $nectar_options['theme-skin'] == 'ascend') ? 'default-loader' : null;

        echo '<div class="nectar-slider-loading '.$default_loader_class.'"> <span class="loading-icon '.$loading_animation.'"> '.$default_loader.'  </span> </div>';
    	}

    	// Video bg.
      if($video_bg) {
    		
				$video_image_src = '';
				
    		// Parse video image.
    		if(strpos($video_image, "http://") !== false){
    			$video_image_src = $video_image;
    		} else if( preg_match('/^\d+$/', $video_image) ) {
    			$video_image_src = wp_get_attachment_image_src($video_image, 'full');
    			$video_image_src = $video_image_src[0];
    		}
    		
    		if( $enable_video_color_overlay !== 'true' ) { 
          $video_overlay_color = null; 
        }
        
        ?>
        
    		<div class="video-color-overlay" data-color="<?php echo esc_attr($video_overlay_color); ?>"></div>
    		<div class="mobile-video-image" style="background-image: url(<?php echo esc_url($video_image_src); ?>)"></div>
    		<div class="nectar-video-wrap">
    			<video class="nectar-video-bg" width="1800" height="700" <?php if(!empty($video_image)) { echo 'poster="'.esc_url($video_image_src).'"'; } ?> controls="controls" preload="auto" loop autoplay muted playsinline>';
            <?php 
    		    if(!empty($video_webm)) { echo '<source type="video/webm" src="'.esc_url($video_webm).'">'; }
    		    if(!empty($video_mp4)) { echo '<source type="video/mp4" src="'.esc_url($video_mp4).'">'; }
    		    if(!empty($video_ogv)) { echo '<source type="video/ogg" src="'.esc_url($video_ogv).'">'; }
            ?>
    			</video>
    		</div>
    		
    	<?php }
    	
        echo '<div class="row_col_wrap_12_inner col span_12 '. esc_attr(strtolower($text_color)) .' '. esc_attr($text_align) . esc_attr($css_perspective_class) . '">'.do_shortcode($content).'</div></div>';
  
  } //disable row
    	
?>