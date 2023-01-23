<?php 

/**
 * Dropcap shortcode.
 *
 * @since 1.0
 */
function nectar_dropcap_proc($atts, $content = null) {
	  
	 extract(shortcode_atts(array("color" => ''), $atts));

	$color_str = null;
	
	if(!empty($color)) {
		$color_str = 'style=" color: '.esc_attr($color).';"'; 
	}
	
  return '<span class="nectar-dropcap" '.$color_str.'>'.wp_kses_post($content).'</span>';
}

add_shortcode('nectar_dropcap', 'nectar_dropcap_proc');


/**
 * Icon shortcode.
 *
 * @since 1.0
 */
function nectar_icon($atts, $content = null) {
  
	extract(shortcode_atts(array(
    "size" => 'large', 
    'color' => 'Accent-Color', 
    'image' => 'icon-circle', 
    'icon_size' => '64', 
    'enable_animation' => 'false', 
    'animation_delay' => '0',
    'animation_speed' => 'medium'
  ), $atts)); 
	
	if($size === 'large-2') {
		$size_class = 'icon-3x alt-style';
	} 
	else if($size === 'large') {
		$size_class = 'icon-3x';
	}
	else if($size === 'regular') {
		$size_class = 'icon-default-style';
	}  
	else if($size === 'tiny') {
		$size_class = 'icon-tiny';
	}
	else {
		$size_class = 'icon-normal'; 
	}
	
	($size === 'large') ? $border = '<i class="circle-border"></i>' : $border = ''; 
	
	// Check if iconsmind SVGs exist.
	$svg_iconsmind = ( defined('NECTAR_THEME_DIRECTORY') && file_exists( NECTAR_THEME_DIRECTORY . '/css/fonts/svg-iconsmind/Aa.svg.php' ) ) ? true : false;
	
	if( strpos($image,'.svg') !== false ) {

		//gradient loads from font family
		if(strtolower($color) === 'extra-color-gradient-1' || strtolower($color) === 'extra-color-gradient-2') {
			$converted_class = str_replace('_', '-', $image);
			$converted_class = str_replace('.svg', '', $converted_class);
			return '<i class="icon-'.$converted_class.'" data-color="'.esc_attr(strtolower($color)).'" style="font-size: '.esc_attr($icon_size).'px;"></i>';
		}
		//non gradient uses svg
		else {
			if(strtolower($animation_speed) === 'slow') {
        $animation_speed_time = 200;
      }
			if(strtolower($animation_speed) === 'medium') {
        $animation_speed_time = 150;
      }
			if(strtolower($animation_speed) === 'fast') {
        $animation_speed_time = 65;
      }

			$svg_icon = '<div class="nectar_icon_wrap"><span class="svg-icon-holder" data-size="'. esc_attr($icon_size) . '" data-animation-speed="'.esc_attr($animation_speed_time).'" data-animation="'.esc_attr($enable_animation).'" data-animation-delay="'.esc_attr($animation_delay).'" data-color="'.esc_attr(strtolower($color)) .'"><span>';
      
      ob_start();
    
    	get_template_part( 'css/fonts/svg/'. $image );
      
    	$svg_icon .= ob_get_contents();
    	ob_end_clean();
      
      $svg_icon .= '</span></span></div>';
      
			return $svg_icon;
		} 
	}
  
  else if( strpos($image,'iconsmind-') !== false && $svg_iconsmind ) {
		
  	//svg iconsmind
  	$icon_id        = 'nectar-iconsmind-icon-'.uniqid();
  	$icon_markup    = '<span class="im-icon-wrap" data-color="'.strtolower($color) .'"><span>';
  	$converted_icon = str_replace('iconsmind-', '', $image);
		
  	ob_start();
  
  	get_template_part( 'css/fonts/svg-iconsmind/'. $converted_icon .'.svg' );
  	
  	$icon_markup .=  ob_get_contents();
  	
    if($size === 'large-2') {
  		$size_px = '48px';
  	} 
  	else if($size === 'large') {
  		$size_px  = '48px';
  	}
  	else if($size === 'regular') {
  		$size_px  = '30px';
  	}  
  	else if($size === 'tiny') {
  		$size_px  = '20px';
  	}
  	else {
  		$size_px  = '48px'; 
  	}
    
  	// custom size
  	$icon_markup = preg_replace(
     array('/width="\d+"/i', '/height="\d+"/i'),
     array('width="'.$size_px.'"', 'height="'. $size_px.'"'),
     $icon_markup);
  	
  	// handle gradients
  	if( strtolower($color) === 'extra-color-gradient-1' || strtolower($color) === 'extra-color-gradient-2') {
  			
        if( defined( 'NECTAR_THEME_NAME' ) ) {
    			$nectar_options = get_nectar_theme_options();
        } else {
          $nectar_options = array();
        }
        
  			if( strtolower($color) === 'extra-color-gradient-1' && isset($nectar_options["extra-color-gradient"]['from']) ) {
  				
  				$accent_gradient_from = $nectar_options["extra-color-gradient"]['from'];
  				$accent_gradient_to = $nectar_options["extra-color-gradient"]['to'];
  				
  			} else if( strtolower($color) === 'extra-color-gradient-2' && isset($nectar_options["extra-color-gradient-2"]['from']) ) {
  				
  				$accent_gradient_from = $nectar_options["extra-color-gradient-2"]['from'];
  				$accent_gradient_to = $nectar_options["extra-color-gradient-2"]['to'];
  				
  			}
  			
  			
  		  $icon_markup =  preg_replace('/(<svg\b[^><]*)>/i', '$1 fill="url(#'.$icon_id.')">', $icon_markup);
  			
  		  $icon_markup .= '<svg style="height:0;width:0;position:absolute;" aria-hidden="true" focusable="false">
  			  <linearGradient id="'.$icon_id.'" x2="1" y2="1">
  			    <stop offset="0%" stop-color="'.$accent_gradient_from.'" />
  			    <stop offset="100%" stop-color="'.$accent_gradient_to.'" />
  			  </linearGradient>
  			</svg>';
  	} 
    
    ob_end_clean();
    
    $icon_markup .= '</span></span>';
    
    return $icon_markup;
  }
  
	else {
		
		if( strpos($image,'iconsmind-') !== false ) {
			wp_enqueue_style( 'iconsmind' );
		}
		
		$fontawesome_extra = null;
		if( strpos($image, 'fa-') !== false ) {
			$fontawesome_extra = ' fa';
		}
		return '<i class="'. $size_class . $fontawesome_extra . ' ' . $image . ' ' . esc_attr(strtolower($color)) .'">' . $border . '</i>';
	}
    
}
add_shortcode('icon', 'nectar_icon');






/**
 * Bar Graph shortcode.
 *
 * @since 1.0
 */
function nectar_bar_graph($atts, $content = null) {  
    return do_shortcode($content);
}
add_shortcode('bar_graph', 'nectar_bar_graph');


/**
 * Bar shortcode.
 *
 * @since 1.0
 */
if( !function_exists('nectar_bar') ) {
	function nectar_bar($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => 'Title', 
			"percent" => '1', 
			'color' => 
			'Accent-Color', 
			'id' => ''), $atts));  
			
		$bar = '
		<div class="nectar-progress-bar">
			<p>' . wp_kses_post($title) . '</p>
			<div class="bar-wrap"><span class="'.esc_attr(strtolower($color)).'" data-width="' . esc_attr($percent) . '"> <strong><i>' . esc_attr($percent) . '</i>%</strong> </span></div>
		</div>';
	  return $bar;
	}
}

add_shortcode('bar', 'nectar_bar');




/**
 * Button shortcode.
 *
 * @since 1.0
 */
function nectar_button($atts, $content = null) {  
  
    extract(shortcode_atts(array(
			"size" => 'small', 
			"url" => '#', 
			'color' => 'Accent-Color', 
			'color_override' => '', 
			'hover_color_override' => '', 
			'hover_text_color_override' => '#fff', 
			"text" => 'Button Text', 
			'image' => '', 
			'open_new_tab' => '0'), $atts));
	
  	$target = ($open_new_tab === 'true') ? 'target="_blank"' : null;
  	
  	//icon
  	if(!empty($image) && strpos($image,'.svg') !== false) {
			
  		if(!empty($image)) { 
				$button_icon = '<img src="'.get_template_directory_uri() . '/css/fonts/svg/'.$image.'" alt="icon" />'; 
				$has_icon = ' has-icon'; 
			} else { 
				$button_icon = null; 
				$has_icon = null; 
			}
			
  	} else {

  		if(!empty($image)) { 
  			$fontawesome_extra = null; 
  			if(strpos($image, 'fa-') !== false) {
					$fontawesome_extra = 'fa '; 
				}
  			$button_icon = '<i class="' . $fontawesome_extra . $image .'"></i>'; 
				$has_icon = ' has-icon'; 
  		} 
  		else { 
				$button_icon = null; 
				$has_icon = null; 
			}
			
			if( strpos($image,'iconsmind-') !== false ) {
				wp_enqueue_style( 'iconsmind' );
			}
			
  	}
  	
  	//standard arrow icon
  	if($image === 'default-arrow') {
			$button_icon = '<i class="icon-button-arrow"></i>';
		}
  	
  	$stnd_button = null;
  	if( strtolower($color) === 'accent-color' || 
			strtolower($color) === 'extra-color-1' || 
			strtolower($color) === 'extra-color-2' || 
			strtolower($color) === 'extra-color-3') {
  		$stnd_button = " regular-button";
  	}
  	
  	$button_open_tag = '';

  	if($color === 'accent-color-tilt' || 
			$color === 'extra-color-1-tilt' || 
			$color === 'extra-color-2-tilt' || 
			$color === 'extra-color-3-tilt') {
				
  		$color = substr($color, 0, -5);
  		$color = $color . ' tilt';
  		$button_open_tag = '<div class="tilt-button-wrap"> <div class="tilt-button-inner">';
  	}

  	switch ($size) {
  		case 'small' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button small '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;
  		case 'medium' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button medium ' . esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;
  		case 'large' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button large '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;	
  		case 'jumbo' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button jumbo '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;	
  		case 'extra_jumbo' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button extra_jumbo '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;	
  	}
  	
  	$color_or                  = (!empty($color_override)) ? 'data-color-override="'. esc_attr($color_override).'" ' : 'data-color-override="false" ';	
  	$hover_color_override      = (!empty($hover_color_override)) ? ' data-hover-color-override="'. esc_attr($hover_color_override).'"' : 'data-hover-color-override="false"';
  	$hover_text_color_override = (!empty($hover_text_color_override)) ? ' data-hover-text-color-override="'. esc_attr($hover_text_color_override) .'"' :  null;	
  	$button_close_tag          = null;

  	if($color === 'accent-color tilt' || 
			$color === 'extra-color-1 tilt' || 
			$color === 'extra-color-2 tilt' || 
			$color === 'extra-color-3 tilt') {
			$button_close_tag = '</div></div>';
		}

  	if($color !== 'see-through-3d') {
			
  		if($color === 'extra-color-gradient-1' || 
      $color === 'extra-color-gradient-2' ||
       $color === 'see-through-extra-color-gradient-1' || 
       $color === 'see-through-extra-color-gradient-2') {
  			return $button_open_tag . ' href="' . esc_url($url) . '" '.$color_or.$hover_color_override.$hover_text_color_override.'><span class="start loading">' . wp_kses_post($text) . $button_icon. '</span><span class="hover">' . $text . $button_icon. '</span></a>'. $button_close_tag;
  		}
      else {
  			return $button_open_tag . ' href="' . esc_url($url) . '" '.$color_or.$hover_color_override.$hover_text_color_override.'><span>' . wp_kses_post($text) . '</span>'. $button_icon . '</a>'. $button_close_tag;
      }

  	}
    
  	else {

  		$color  = (!empty($color_override)) ? $color_override : '#ffffff';
  		$border = ($size !== 'jumbo') ? 8 : 10;
			
  		if($size ==='extra_jumbo') {
				$border = 20;
			}
  		return '
  		<div class="nectar-3d-transparent-button" data-size="'.esc_attr($size).'">
  		     <a href="'.esc_url($url).'"><span class="hidden-text">'.wp_kses_post($text).'</span>
  			<div class="inner-wrap">
  				<div class="front-3d">
  					<svg>
  						<defs>
  							<mask>
  								<rect width="100%" height="100%" fill="#ffffff"></rect>
  								<text class="mask-text button-text" fill="#000000" width="100%" text-anchor="middle">'.wp_kses_post($text).'</text>
  							</mask>
  						</defs>
  						<rect id="" fill="'.esc_attr($color).'" width="100%" height="100%" ></rect>
  					</svg>
  				</div>
  				<div class="back-3d">
  					<svg>
  						<rect stroke="'.esc_attr($color).'" stroke-width="'.esc_attr($border).'" fill="transparent" width="100%" height="100%"></rect>
  						<text class="button-text" fill="'.esc_attr($color).'" text-anchor="middle">'.wp_kses_post($text).'</text>
  					</svg>
  				</div>
  			</div>
  			</a>
  		</div>
  		';
  }
}


add_shortcode('button', 'nectar_button');




/**
 * 1/2 Column shortcode.
 *
 * @since 1.0
 */
function nectar_one_half( $atts, $content = null ) {
	
  extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_6' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div>';

}

add_shortcode('one_half', 'nectar_one_half');


/**
 * 1/2 Column last shortcode.
 *
 * @since 1.0
 */
function nectar_one_half_last( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_6 col_last' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">' . $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_half_last', 'nectar_one_half_last');



/**
 * 1/3 Column shortcode.
 *
 * @since 1.0
 */
function nectar_one_third( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}

  return '<div class="col span_4' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div>';
}

add_shortcode('one_third', 'nectar_one_third');


/**
 * 1/3 Column Last shortcode.
 *
 * @since 1.0
 */
function nectar_one_third_last( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; $box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_4 col_last' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_third_last', 'nectar_one_third_last');


/**
 * 2/3 Column shortcode.
 *
 * @since 1.0
 */
function nectar_two_thirds( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
	$parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_8' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div>';
}

add_shortcode('two_thirds', 'nectar_two_thirds');


/**
 * 2/3 Column Last shortcode.
 *
 * @since 1.0
 */
function nectar_two_thirds_last( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_8 col_last' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('two_thirds_last', 'nectar_two_thirds_last');



/**
 * 1/4 Column shortcode.
 *
 * @since 1.0
 */
function nectar_one_fourth( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_3' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'nectar_one_fourth');


/**
 * 1/4 Column Last shortcode.
 *
 * @since 1.0
 */
function nectar_one_fourth_last( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
	$parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_3 col_last' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'nectar_one_fourth_last');


/**
 * 3/4 Column shortcode.
 *
 * @since 1.0
 */
function nectar_three_fourths( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
	$parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
    return '<div class="col span_9' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div>';
}

add_shortcode('three_fourths', 'nectar_three_fourths');


/**
 * 3/4 Column Last shortcode.
 *
 * @since 1.0
 */
function nectar_three_fourths_last( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
	$parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
    return '<div class="col span_9 col_last' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fourths_last', 'nectar_three_fourths_last');



/**
 * 1/6 Column shortcode.
 *
 * @since 1.0
 */
function nectar_one_sixth( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
    return '<div class="col span_2' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'nectar_one_sixth');


/**
 * 1/6 Column Last shortcode.
 *
 * @since 1.0
 */
function nectar_one_sixth_last( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
	$parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
    return '<div class="col span_2 col_last' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_sixth_last', 'nectar_one_sixth_last');


/**
 * 5/6 Column shortcode.
 *
 * @since 1.0
 */
function nectar_five_sixths( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
    return '<div class="col span_10' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixths', 'nectar_five_sixths');


/**
 * 5/6 Column Last shortcode.
 *
 * @since 1.0
 */
function nectar_five_sixths_last( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
  $parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
  return '<div class="col span_10 col_last' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}

add_shortcode('five_sixths_last', 'nectar_five_sixths_last');



/**
 * 1/1 Column shortcode.
 *
 * @since 1.0
 */
function nectar_one_whole( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"boxed"         => 'false', 
		"centered_text" => 'false', 
		"animation"     => '', 
		"delay"         => '0'), $atts));
	
	$column_classes   = null;
	$box_border       = null;
	$parsed_animation = null;	
	
	if($boxed === 'true') { 
		$column_classes .= ' boxed'; 
		$box_border = '<span class="bottom-line"></span>'; 
	}
	
	if($centered_text === 'true') {
		$column_classes .= ' centered-text';
	}
	
	if(!empty($animation)) {
		 $column_classes .= ' has-animation';
		
		 $parsed_animation = str_replace(" ","-",$animation);
		 $delay            = intval($delay);
	}
	
    return '<div class="col span_12' . esc_attr($column_classes) . '" data-animation="'.esc_attr(strtolower($parsed_animation)).'" data-delay="'.esc_attr($delay).'">'. $box_border . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_whole', 'nectar_one_whole');


?>