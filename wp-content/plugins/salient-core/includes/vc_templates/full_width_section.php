<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

   extract(shortcode_atts(array(
	  "type" => 'full_width_background',
	  'image_url'=> '', 
	  'bg_pos'=> '', 
	  'bg_repeat' => '', 
	  'parallax_bg' => '', 
	  'background_color'=> '', 
	  'exclude_row_header_color_inherit' => '',
	  'text_align'=> '', 
	  'vertically_center_columns' => '',
	  'video_bg'=> '', 
	  'enable_video_color_overlay'=> '', 
	  'video_overlay_color'=> '', 
	  'video_webm'=> '', 
	  'video_mp4'=> '', 
	  'video_ogv'=> '', 
	  'video_image'=> '', 
	  "top_padding" => "40", 
	  "bottom_padding" => "40",
	  'text_color' => 'light',  
	  'custom_text_color' => '',
	  'row_name' => '',
	  'full_screen_row_position' => 'middle',  
	  'class' => ''), 
	$atts));
	
	wp_enqueue_style( 'js_composer_front' );
	wp_enqueue_script( 'wpb_composer_front_js' );
	wp_enqueue_style('js_composer_custom_css');
	
  $style = null;
	$etxra_class = null;
	$bg_props = null;
	$using_image_class = null;
	$using_bg_color_class = null;
	$using_custom_text_color = null;
	
	if( !empty($image_url) ) {
		
		if( !preg_match('/^\d+$/',$image_url) ){
				
			$bg_props .= 'background-image: url('. $image_url . '); ';
			$bg_props .= 'background-position: '. $bg_pos .'; ';
		
		} else {
			$bg_image_src = wp_get_attachment_image_src($image_url, 'full');
			
			if( false !== $bg_image_src ) {
				$bg_props .= 'background-image: url('. $bg_image_src[0]. '); ';
				$bg_props .= 'background-position: '. $bg_pos .'; ';
			}
		}
		
		// For pattern bgs.
		if( strtolower($bg_repeat) === 'repeat' ){
			$bg_props .= 'background-repeat: '. strtolower($bg_repeat) .'; ';
			$etxra_class = 'no-cover';
		} else {
			$bg_props .= 'background-repeat: '. strtolower($bg_repeat) .'; ';
			$etxra_class = null;
		}

		$using_image_class = 'using-image';
	}
	
	if( !empty($background_color) ) {
		$bg_props .= 'background-color: '. $background_color.'; ';
		if($exclude_row_header_color_inherit !== 'true') {
      $using_bg_color_class = 'using-bg-color';
    }
	}
	
	if( strtolower($parallax_bg) === 'true' ){
		$parallax_class = 'parallax_section';
	} else {
		$parallax_class = 'standard_section';
	}
	
  $equal_height_class = '';
	if( strtolower($vertically_center_columns) === 'true') {
    // v11 uses CSS for vertical center option instead of JS.
    $equal_height_class = ' vc_row vc_row-o-equal-height vc_row-flex vc_row-o-content-middle ';
    $vertically_center_class = null;
	} else {
		$vertically_center_class = null;
	}
	
	global $post;
	$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';
	
	if( $page_full_screen_rows !== 'on' ) {

		$style .= 'padding-top: '. $top_padding .'px; ';
		$style .= 'padding-bottom: '. $bottom_padding .'px; ';

	}
	
	if( !empty($custom_text_color) ) {
		$style .= 'color: '. $custom_text_color .'; ';
		$using_custom_text_color = 'data-using-ctc="true"';
	}
	
	// Main class.
	if( $type === 'in_container' ) {
		
		$main_class = "";
		
	} else if( $type === 'full_width_background' ){
		
		$main_class = "full-width-section ";
		
	} else if( $type === 'full_width_content' ){
		
		$main_class = "full-width-content ";
	}
	 
	// Remove in container possibility when using fullpage.js.
	if( $page_full_screen_rows === 'on' && $type === 'in_container') {
    $main_class = "full-width-section ";
  }


  echo'<div id="'.uniqid("fws_").'" class="wpb_row legacy vc_row-fluid '. $main_class . $equal_height_class . $parallax_class . ' ' . $vertically_center_class . ' ' . $class . ' " '.$using_custom_text_color.' style="'.$style.'">';
	
	if( $page_full_screen_rows === 'on' ) {
    echo '<div class="full-page-inner-wrap-outer"><div class="full-page-inner-wrap" data-name="'.esc_attr($row_name).'" data-content-pos="'.esc_attr($full_screen_row_position).'"><div class="full-page-inner">';
  }

	// Row bg. 
	echo '<div class="row-bg-wrap"> <div class="row-bg '.$using_image_class . ' ' . $using_bg_color_class . ' '. $etxra_class.'" style="'.$bg_props.'"></div> </div>';
	
	// Video bg.
	if($video_bg) {
		
		$video_image_src = '';
			
		// Parse video image.
		if(strpos($video_image, "http") !== false){
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


	$extra_container_div         = false;
	$extra_container_div_closing = false;
  
	if( $page_full_screen_rows === 'on' && $main_class === "full-width-section ") {
    
		$extra_container_div         = true;
		$extra_container_div_closing = true;

		$pattern = get_shortcode_regex();
	
		if ( preg_match_all( '/'. $pattern .'/s', $content, $matches )  && array_key_exists( 0, $matches ))  {
    	
			if($matches[0][0]){
				if( strpos($matches[0][0],'nectar_slider') !== false && strpos($matches[0][0],'full_width="true"') !== false 
					|| strpos($matches[0][0],' type="full_width_content"') !== false && strpos($matches[0][0],'nectar_slider') !== false && strpos($matches[0][0],'[vc_column width="1/1"') !== false ) {
					$extra_container_div         = false;
					$extra_container_div_closing = false;
				}
			}
		}
    
	}
  
  if( $extra_container_div === true ) {
    echo '<div class="container">';
  }
  echo '<div class="col span_12 '.esc_attr(strtolower($text_color)).' ' . esc_attr($text_align).'">'.do_shortcode($content).'</div></div>';
  if($extra_container_div_closing === true ) {
    echo '</div>';
  }

  if( $page_full_screen_rows === 'on' ) { echo '</div></div></div><!--inner-wrap-->'; }
	
?>