<?php 

/**
 * Full width section shortcode.
 *
 * @since 1.0
 */
function nectar_full_width_section($atts, $content = null) {
  
  extract(shortcode_atts(array(
    "top_padding" => "40", 
    "bottom_padding" => "40", 
    'image_url'=> '', 
    'bg_pos'=> '', 
    'background_color'=> '', 
    'bg_repeat' => '', 
    'text_color' => 'light', 
    'parallax_bg' => '', 
    'class' => ''), $atts));
		
	$style                = null;
	$etxra_class          = null;
	$bg_props             = null;
	$using_image_class    = null;
	$using_bg_color_class = null;
	
	if(!empty($image_url)) {
    
		$bg_props .= 'background-image: url('. esc_url($image_url) . '); ';
		$bg_props .= 'background-position: '. $bg_pos .'; ';
		
		//for pattern bgs
		if(strtolower($bg_repeat) === 'repeat'){
			$bg_props .= 'background-repeat: '. strtolower($bg_repeat) .'; ';
			$etxra_class = 'no-cover';
		} else {
			$bg_props .= 'background-repeat: '. strtolower($bg_repeat) .'; ';
			$etxra_class = null;
		}

		$using_image_class = 'using-image';
	}
	
	if(!empty($background_color)) {
		$bg_props .= 'background-color: '. $background_color.'; ';
		$using_bg_color_class = 'using-bg-color';
	}
	
	if(strtolower($parallax_bg) === 'true'){
		$parallax_class = 'parallax_section';
	} else {
		$parallax_class = 'standard_section';
	}
	
	$style .= 'padding-top: '. $top_padding .'px; ';
	$style .= 'padding-bottom: '. $bottom_padding .'px; ';
	 
  return'
	<div id="'.uniqid("fws_").'" class="full-width-section wpb_row legacy vc_row-fluid '.$parallax_class . ' ' . $class . ' " style="'.$style.'"> 

	<div class="row-bg-wrap"> <div class="row-bg '.$using_image_class . ' ' . $using_bg_color_class . ' '. $etxra_class.'" style="'.$bg_props.'"></div> </div>

    <div class="col span_12 '.esc_attr(strtolower($text_color)).'">'.do_shortcode($content).'</div></div>';
}


add_shortcode('full_width_section', 'nectar_full_width_section');



/**
 * Image with animation shortcode.
 *
 * @since 1.0
 */
function nectar_image_with_animation($atts, $content = null) { 
  
  extract(shortcode_atts(array(
    "animation" => 'Fade In', 
    "delay" => '0', 
    "image_url" => '', 
    'alt' => '', 
    'margin_top' => '', 
    'margin_right' => '', 
    'margin_bottom' => '', 
    'margin_left' => '', 
    'alignment' => 'left', 
    'border_radius' => '', 
    'img_link_target' => '_self', 
    'img_link' => '', 
    'img_link_large' => '', 
    'box_shadow' => 'none', 
    'box_shadow_direction' => 'middle', 
    'max_width' => '100%',
    'el_class' => ''), $atts));
	
  $image_url        = apply_filters('wpml_object_id', $image_url, 'attachment');
	$parsed_animation = str_replace(" ","-",$animation);
  
	(!empty($alt)) ? $alt_tag = $alt : $alt_tag = null;
	
	$image_width  = '100';
	$image_height = '100';
	$image_srcset = null;

	if(preg_match('/^\d+$/',$image_url)){
    
		$image_src = wp_get_attachment_image_src($image_url, 'full');

		if (function_exists('wp_get_attachment_image_srcset')) {

			$image_srcset_values = wp_get_attachment_image_srcset($image_url, 'full');
			if($image_srcset_values) {
				$image_srcset = 'srcset="';
				$image_srcset .= $image_srcset_values;
				$image_srcset .= '" sizes="100vw"';
			}
		}
		
		$image_meta = wp_get_attachment_metadata($image_url);
		if(!empty($image_meta['width'])) {
      $image_width = $image_meta['width'];
    }
		if(!empty($image_meta['height'])) {
      $image_height = $image_meta['height'];
    }

		$wp_img_alt_tag = get_post_meta( $image_url, '_wp_attachment_image_alt', true );
		if(!empty($wp_img_alt_tag)) {
      $alt_tag = $wp_img_alt_tag;
    }
		$image_url = $image_src[0];
		
	}
  
  $margins = '';
	if(!empty($margin_top)) {
    
    if(strpos($margin_top,'%') !== false) {
      $margins .= 'margin-top: '.intval($margin_top).'%; ';
    } else {
      $margins .= 'margin-top: '.intval($margin_top).'px; ';
    }

	}
	if(!empty($margin_right)) {
    
    if(strpos($margin_right,'%') !== false) {
      $margins .= 'margin-right: '.intval($margin_right).'%; ';
    } else {
      $margins .= 'margin-right: '.intval($margin_right).'px; ';
    }
		
	}
	if(!empty($margin_bottom)) {
    
    if(strpos($margin_bottom,'%') !== false) {
      $margins .= 'margin-bottom: '.intval($margin_bottom).'%; ';
    } else {
      $margins .= 'margin-bottom: '.intval($margin_bottom).'px; ';
    }
		
	}
	if(!empty($margin_left)) {
    
    if(strpos($margin_left,'%') !== false) {
      $margins .= 'margin-left: '.intval($margin_left).'%;';
    } else {
      $margins .= 'margin-left: '.intval($margin_left).'px;';
    }
		
	}
  
  $margin_style_attr = '';
  
  if(!empty($margins)) {
     $margin_style_attr = 'style="'.$margins.'"';
  }
	
  
  // Attributes applied to img-with-animation-wrap.
  $wrap_image_attrs_escaped  = 'data-max-width="'.esc_attr($max_width).'" ';
  $wrap_image_attrs_escaped .= 'data-border-radius="'.esc_attr($border_radius).'"';
  
  // Attributes applied to img.
  $image_attrs_escaped  = 'data-shadow="'.esc_attr($box_shadow).'" ';
  $image_attrs_escaped .= 'data-shadow-direction="'.esc_attr($box_shadow_direction).'" ';
  $image_attrs_escaped .= 'data-delay="'.esc_attr($delay).'" ';
  $image_attrs_escaped .= 'height="'.esc_attr($image_height).'" ';
  $image_attrs_escaped .= 'width="'.esc_attr($image_width).'" ';
  $image_attrs_escaped .= 'data-animation="'.esc_attr(strtolower($parsed_animation)).'" ';
  $image_attrs_escaped .= 'src="'.esc_url($image_url).'" ';
  $image_attrs_escaped .= 'alt="'.esc_attr($alt_tag).'" ';
  $image_attrs_escaped .= $image_srcset;
  $image_attrs_escaped .= $margin_style_attr;
  
  
  
  if( !empty($img_link) || !empty($img_link_large) ){
    
    if( !empty($img_link) && empty($img_link_large) ) {
      // Link image to larger version.
      return '<div class="img-with-aniamtion-wrap '.esc_attr($alignment).'" '.$wrap_image_attrs_escaped.'>
      <div class="inner">
        <a href="'.esc_url($img_link).'" target="'.esc_attr($img_link_target).'" class="'.esc_attr($alignment).'">
          <img class="img-with-animation '.esc_attr($el_class).'" '.$image_attrs_escaped.' />
        </a>
      </div>
      </div>';
      
    } elseif(!empty($img_link_large)) {
      // Regular link image.
      return '<div class="img-with-aniamtion-wrap '.esc_attr($alignment).'" '.$wrap_image_attrs_escaped.'>
      <div class="inner">
        <a href="'.esc_url($image_url).'" class="pp '.esc_attr($alignment).'">
          <img class="img-with-animation '.esc_attr($el_class).'" '.$image_attrs_escaped.' />
        </a>
      </div>
      </div>';
    }
    
  } else {
    // No link image.
    return '<div class="img-with-aniamtion-wrap '.esc_attr($alignment).'" '.$wrap_image_attrs_escaped.'>
      <div class="inner">
        <img class="img-with-animation '.esc_attr($el_class).'" '.$image_attrs_escaped.' />
      </div>
    </div>';
  }
   
}


add_shortcode('image_with_animation', 'nectar_image_with_animation');




/**
 * Testimonial Slider shortcode.
 *
 * @since 1.0
 */
function nectar_testimonial_slider($atts, $content = null) { 
  
    extract(shortcode_atts(array("autorotate"=>''), $atts));
	
    return '<div class="col span_12 testimonial_slider" data-autorotate="'.esc_attr($autorotate).'"><div class="slides">'.do_shortcode($content).'</div></div>';
}

add_shortcode('testimonial_slider', 'nectar_testimonial_slider');



/**
 * Testimonial shortcode.
 *
 * @since 1.0
 */
function nectar_testimonial($atts, $content = null) { 
  
    extract(shortcode_atts(array(
      "name" => '', 
      "quote" => ''), $atts));
	
    return '<blockquote><p>'.wp_kses_post($quote).'</p>'. '<span>'.wp_kses_post($name).'</span></blockquote>';
}

add_shortcode('testimonial', 'nectar_testimonial');




/**
 * Heading shortcode.
 *
 * @since 1.0
 */
function nectar_heading($atts, $content = null) { 
  
  extract(shortcode_atts(array(
    "title" => 'Title', 
    "subtitle" => 'Subtitle'), $atts));
    
	$subtitle_holder = null;
	
	if($subtitle !== 'Subtitle') {
    $subtitle_holder = '<p>'.wp_kses_post($subtitle).'</p>';
  }
    return'
    <div class="col span_12 section-title text-align-center extra-padding">
		<h2>'.wp_kses_post($content).'</h2>'. $subtitle_holder .'</div><div class="clear"></div>';
}

add_shortcode('heading', 'nectar_heading');



/**
 * Divider shortcode.
 *
 * @since 1.0
 */
function nectar_divider($atts, $content = null) {  
  
    extract(shortcode_atts(array(
      "line" => 'false', 
      "custom_height" => '25', 
      "line_type" => 'No Line', 
      "line_alignment" => 'default', 
      'line_thickness' => '1', 
      'custom_line_width' => '20%', 
      'divider_color' => 'default', 
      'animate' => '', 
      'delay' => ''), $atts));
	
	if($line_type === 'Small Thick Line' || $line_type === 'Small Line' ){
    
		$height = (!empty($custom_height)) ? 'style="margin-top: '.intval($custom_height/2).'px; width: '.esc_attr($custom_line_width).'px; height: '.esc_attr($line_thickness).'px; margin-bottom: '.intval($custom_height/2).'px;"' : null;
		$divider = '<div '.$height.' data-width="'.esc_attr($custom_line_width).'" data-animate="'.esc_attr($animate).'" data-animation-delay="'.esc_attr($delay).'" data-color="'.esc_attr($divider_color).'" class="divider-small-border"></div>';
	} 
  else if($line_type === 'Full Width Line'){
		$height = (!empty($custom_height)) ? 'style="margin-top: '.intval($custom_height/2).'px; height: '.esc_attr($line_thickness).'px; margin-bottom: '.intval($custom_height/2).'px;"' : null;
		$divider = '<div '.$height.' data-width="100%" data-animate="'.esc_attr($animate).'" data-animation-delay="'.esc_attr($delay).'" data-color="'.esc_attr($divider_color).'" class="divider-border"></div>';
	} 
  else {
		$height = (!empty($custom_height)) ? 'style="height: '.intval($custom_height).'px;"' : null;
		$divider = '<div '.$height.' class="divider"></div>';
	}
	//old option
	if($line === 'true') {
    $divider = '<div class="divider-border"></div>';
  }
  return '<div class="divider-wrap" data-alignment="' . esc_attr($line_alignment) . '">'.$divider.'</div>';
  
}


add_shortcode('divider', 'nectar_divider');





/**
 * Milestone shortcode.
 *
 * @since 1.0
 */
function nectar_milestone($atts, $content = null) {  
  
  extract(shortcode_atts(array(
    "subject" => '', 
    'symbol' => '', 
    'milestone_alignment' => 'default', 
    'heading_inherit' => 'default', 
    'symbol_position' => 'after', 
    'subject_padding' => '0%',
    'symbol_alignment' => 'default', 
    'number_font_size' => '62', 
    'symbol_font_size' => '62', 
    'effect' => 'count', 
    'number' => '0', 
    'color' => 'Default'), $atts));
	
	if(!empty($symbol)) {
		$symbol_markup = 'data-symbol="'.esc_attr($symbol).'" data-symbol-alignment="'.esc_attr(strtolower($symbol_alignment)).'" data-symbol-pos="'.esc_attr($symbol_position).'" data-symbol-size="'.esc_attr($symbol_font_size).'"';
	} else {
		$symbol_markup = null;
	}

	$motion_blur          = null;
	$milestone_wrap       = null;
	$milestone_wrap_close = null;
	$span_open            = null;
	$span_close           = null;

	if($effect === 'motion_blur') {
		$motion_blur = 'motion_blur';
		$milestone_wrap = '<div class="milestone-wrap">';
		$milestone_wrap_close = '</div>';
	} else {
		$span_open = '<span>';
		$span_close = '</span>';
	}
	

	if($heading_inherit !== 'default') {
		$milestone_h_open = '<'.esc_html($heading_inherit).'>';
		$milestone_h_close = '</'.esc_html($heading_inherit).'>';
	} else {
		$milestone_h_open = null;
		$milestone_h_close = null;
	}

	$subject_padding_html_escaped = (!empty($subject_padding) && $subject_padding != '0%') ? 'style="padding: '.esc_attr($subject_padding).';"' : null;

	$number_markup  = '<div class="number '.strtolower($color).'" data-number-size="'.esc_attr($number_font_size).'">'.$milestone_h_open.$span_open.wp_kses_post($number).$span_close.$milestone_h_close.'</div>';
	$subject_markup = '<div class="subject" '.$subject_padding_html_escaped.'>'.wp_kses_post($subject).'</div>';
	
  return $milestone_wrap . '<div class="nectar-milestone '. $motion_blur . '" '. $symbol_markup.' data-ms-align="'.esc_attr($milestone_alignment).'" > '.$number_markup.' '.$subject_markup.' </div>' . $milestone_wrap_close;
}


add_shortcode('milestone', 'nectar_milestone');





/**
 * Text with icon shortcode.
 *
 * @since 1.0
 */
function nectar_text_with_icon($atts, $content = null) {  
    extract(shortcode_atts(array(
      'color'      => 'Accent-Color', 
      'icon_type'  => 'font_icon', 
      'icon'       => 'icon-glass', 
      'icon_image' => ''), $atts));
	
	$icon_markup = null;
	$output      = null;

	if($icon_type === 'font_icon'){
		$icon_markup = '<i class="icon-default-style '.esc_attr($icon).' '. esc_attr(strtolower($color)) .'"></i>';
	} else {
		$icon_markup = wp_get_attachment_image_src($icon_image, 'medium');
		if(!empty($icon_markup)) {
			
			$icon_alt    = get_post_meta($icon_image, '_wp_attachment_image_alt', true);
			$icon_markup = '<img src="'.esc_url($icon_markup[0]).'" alt="'.esc_attr($icon_alt).'" />';
      
		} else {
			$icon_markup = null;
		}
	}
	
	$output .= '<div class="iwithtext"><div class="iwt-icon"> '.$icon_markup.' </div>';
	$output .= '<div class="iwt-text"> '.do_shortcode($content).' </div><div class="clear"></div></div>';
	
  return $output;
}


add_shortcode('text-with-icon', 'nectar_text_with_icon');




/**
 * Fancy List shortcode.
 *
 * @since 1.0
 */
function nectar_fancy_list($atts, $content = null) {  
  
  extract(shortcode_atts(array(
    'color' => 'Accent-Color', 
    'alignment' => 'left' ,
    'icon_type' => 'standard_dash', 
    'icon' => 'icon-glass', 
    'enable_animation' => 'false', 
    'delay' => ''), $atts));
	
	$icon_markup = null;
	$output      = null;
	$delay       = intval($delay);

	if($icon_type === 'font_icon') {
		$icon_markup = 'data-list-icon="'.esc_attr($icon).'" data-animation="'.esc_attr($enable_animation).'" data-animation-delay="'.esc_attr($delay).'" data-color="'. esc_attr(strtolower($color)).'"';
	} else if($icon_type === 'none') {
		$icon_markup = 'data-list-icon="none" data-animation="'.esc_attr($enable_animation).'" data-animation-delay="'.esc_attr($delay).'" data-color="'. esc_attr(strtolower($color)) .'"';
	} else {
		$icon_markup = 'data-list-icon="icon-salient-thin-line" data-animation="'.esc_attr($enable_animation).'" data-animation-delay="'.esc_attr($delay).'" data-color="'. esc_attr(strtolower($color)) .'"';
	}

  $el_classes = array('nectar-fancy-ul');

  // Dyanmic classes.
  if( function_exists('nectar_el_dynamic_classnames') ) {
    $el_classes[] = nectar_el_dynamic_classnames('nectar_responsive_text', $atts);
  } else {
    $el_classes[] = '';
  }
	
	$output .= '<div class="'.implode(' ',$el_classes).'" '.$icon_markup.' data-alignment="'.esc_attr($alignment).'"> '.do_shortcode($content).' </div>';
	
  return $output;
}


add_shortcode('fancy-ul', 'nectar_fancy_list');




/**
 * Team member shortcode.
 *
 * @since 1.0
 */
function nectar_team_member($atts, $content = null) {
	
    extract(shortcode_atts(array(
      "description"  => '', 
      'team_member_bio' => '',
      'team_memeber_style' => '', 
      'color' => 'Accent-Color', 
      'name' => 'Name', 
      'job_position' => '', 
      'image_url' => '', 
      'bio_image_url' => '', 
      'social' => '', 
      'social_icon_1' => '', 
      'social_link_1' => '', 
      'social_icon_2' => '', 
      'social_link_2' => '', 
      'social_icon_3' => '', 
      'social_link_3' => '', 
      'social_icon_4' => '', 
      'social_link_4' => '', 
      'link_element' => 'none', 
      'link_url' => '', 
      'link_url_2' => '',
      'team_member_link_new_tab' => ''), $atts));
	
	$html = null;
  $link_new_tab_markup = ($team_member_link_new_tab == 'true') ? 'target="_blank"': '';

  
	//fullscreen bio
    if($team_memeber_style === 'bio_fullscreen') {

    	$bio_image_url_src = null;
    	$team_alt          = null;

    	if(!empty($bio_image_url)){
	    	$bio_image_url_src = $bio_image_url;

	    	if(preg_match('/^\d+$/',$bio_image_url)){
				$bio_image_src = wp_get_attachment_image_src($bio_image_url, 'full');
				$bio_image_url_src = $bio_image_src[0];
			}
		}

		if(!empty($image_url)){
				
			if(preg_match('/^\d+$/',$image_url)){
				$team_alt  = get_post_meta( $image_url, '_wp_attachment_image_alt', true );
				$image_src = wp_get_attachment_image_src($image_url, 'regular');
				$image_url = $image_src[0];
			}
			
		}
     
     $social_markup = '<div class="bottom_meta">';
     
     for($i=1; $i<5; $i++) {
        if(isset($atts['social_icon_'.$i]) && !empty($atts['social_icon_'.$i])) {
          
          $social_link_url = ( !empty($atts['social_link_'.$i]) ) ? $atts['social_link_'.$i] : '';
          
          $social_markup .= '<a href="'.esc_url($social_link_url).'" target="_blank"><i class="icon-default-style '.esc_attr($atts['social_icon_'.$i]).'"></i>'.'</a>';
        }
     }
     $social_markup .= '</div>';
     
    	$html .= '<div class="team-member" data-style="'.esc_attr($team_memeber_style).'">
    	<div class="team-member-image"><img src="'.esc_url($image_url).'" alt="'.esc_attr($team_alt).'" width="500" height="500" /></div>
    	<div class="team-member-overlay"></div>
    	<div class="team-meta"><h3>' . wp_kses_post($name) . '</h3><p>' . wp_kses_post($job_position) . '</p><div class="arrow-end fa fa-angle-right"></div><div class="arrow-line"></div></div>
    	<div class="nectar_team_bio_img" data-img-src="'.esc_url($bio_image_url_src).'"></div>
    	<div class="nectar_team_bio">'.$team_member_bio.  $social_markup .'</div>
    	</div>';

    	return str_replace("\r\n", '', $html);
    }
		


	$html .= '<div class="team-member" data-style="'.$team_memeber_style.'">';
	
	if($team_memeber_style === 'meta_overlaid' || $team_memeber_style === 'meta_overlaid_alt'){
		
		$html .= '<div class="team-member-overlay"></div>';
		
		if(!empty($image_url)){
				
				if(preg_match('/^\d+$/',$image_url)){
					$image_src = wp_get_attachment_image_src($image_url, 'portfolio-thumb');
					$image_url = $image_src[0];
				}
				
				//image link
				if(!empty($link_url_2)){
					$html .= '<a href="'.esc_url($link_url_2).'" '.$link_new_tab_markup.'></a> <div class="team-member-image" style="background-image: url('.esc_url($image_url).');"></div>';
				} else {
					$html .= '<div class="team-member-image" style="background-image: url('.esc_url($image_url).');"></div>';
				}
				
			}
			else {
				//image link
				if(!empty($link_url_2)){
					$html .= '<a href="'.$link_url_2.'" '.$link_new_tab_markup.'></a><div class="team-member-image" style="background-image: url('. NECTAR_FRAMEWORK_DIRECTORY . 'assets/img/team-member-default.jpg);"></div>';
				} else {
					$html .= '<div class="team-member-image" style="background-image: url('. NECTAR_FRAMEWORK_DIRECTORY . 'assets/img/team-member-default.jpg);"></div>';
				}
		
			}
			
			//name link
			$html .= '<div class="team-meta">';
			$html .= '<h3>' . wp_kses_post($name) . '</h3>';
			$html .= '<p>' . wp_kses_post($job_position) . '<p>';
			$html .= '</div>';
			
	} else {
		
		if(!empty($image_url)){
			
			$team_alt = $name;
			
			if(preg_match('/^\d+$/',$image_url)){
				$image_src = wp_get_attachment_image_src($image_url, 'full');
				$team_alt  = get_post_meta( $image_url, '_wp_attachment_image_alt', true );
				$image_url = $image_src[0];
			}
			
			//image link
			if($link_element === 'image' || $link_element === 'both'){
				$html .= '<a href="'.esc_url($link_url).'" '.$link_new_tab_markup.'><img alt="'.esc_attr($team_alt).'" src="' . esc_url($image_url) .'" title="' . esc_attr($name) . '" /></a>';
			} else {
				$html .= '<img alt="'.esc_attr($team_alt).'" src="' . esc_url($image_url) .'" title="' . esc_attr($name) . '" />';
			}
			
		}
		else {
			//image link
			if($link_element === 'image' || $link_element === 'both'){
				$html .= '<a href="'.esc_url($link_url).'" '.$link_new_tab_markup.'><img alt="'.esc_attr($name).'" src="' . NECTAR_FRAMEWORK_DIRECTORY . 'assets/img/team-member-default.jpg" title="' . esc_attr($name) . '" /></a>';
			} else {
				$html .= '<img alt="'.esc_attr($name).'" src="' . NECTAR_FRAMEWORK_DIRECTORY . 'assets/img/team-member-default.jpg" title="' . esc_attr($name) . '" />';
			}
	
		}
		
		//name link
		if($link_element === 'name' || $link_element === 'both'){
			$html .= '<h4 class="light"><a class="'.esc_attr(strtolower($color)).'" href="'.esc_url($link_url).'" '.$link_new_tab_markup.'>' . wp_kses_post($name) . '</a></h4>';
		} else {
			$html .= '<h4 class="light">' . wp_kses_post($name) . '</h4>';
		}
	
		$html .= '<div class="position">' . wp_kses_post($job_position) . '</div>';
		$html .= '<p class="description">' . wp_kses_post($description) . '</p>';
		
		if (!empty($social) && strlen($social) > 1) {
			 
       $social     = str_replace(array("\r\n", "\r", "\n", "<br/>", "<br />"), " ", $social);
	     $social_arr = explode(",", $social);
			 

			 $html .= '<ul class="social '.strtolower($color).'">';
          
	        for ($i = 0 ; $i < count($social_arr) ; $i = $i + 2) {
	         	
            if(isset($social_arr[$i + 1])) {	
              
  					  $target        = null;
  	         	$url_host      = parse_url($social_arr[$i + 1], PHP_URL_HOST);
  				    $base_url_host = parse_url(get_template_directory_uri(), PHP_URL_HOST);
              
  				    if($url_host != $base_url_host || empty($url_host)) {
  				    	$target = 'target="_blank"';
  				    }
  					 
  	         $html .=  "<li><a ".$target." href='" . esc_url($social_arr[$i + 1]) . "'>" . $social_arr[$i] . "</a></li>";   
           }
           
	       }
         
			 $html .= '</ul>'; 
       
	     }
		
     }
	
	$html .= '</div>';
	
	return str_replace("\r\n", '', $html);
	 
}


add_shortcode('team_member', 'nectar_team_member');





/**
 * Carousel shortcode.
 *
 * @since 1.0
 */
function nectar_carousel($atts, $content = null) {  
  
  wp_enqueue_style( 'nectar-caroufredsel' );
  wp_enqueue_script( 'caroufredsel' );
  
  extract(shortcode_atts(array(
    "carousel_title" => 'Title', 
    "scroll_speed" => 'medium', 
    'easing' => 'easeInExpo'), $atts));
	
	$carousel_html = null;
	$carousel_html .= '
	<div class="carousel-wrap" data-full-width="false">
	<div class="carousel-heading">
		<div class="container">
			<h2 class="uppercase">'. wp_kses_post($carousel_title) .'</h2>
				<div class="control-wrap">
					<a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
					<a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
				</div>
		</div>
	</div>
	</span><ul class="row carousel" data-scroll-speed="' . esc_attr($scroll_speed) . '" data-easing="' . esc_attr($easing) . '">';
	
  return $carousel_html . do_shortcode($content) . '</ul></div>';
}

add_shortcode('carousel', 'nectar_carousel');


function nectar_carousel_item($atts, $content = null) {  
    return '<li class="col span_4">' . do_shortcode($content) . '</li>';
}

add_shortcode('item', 'nectar_carousel_item');



/**
 * Clients shortcode.
 *
 * @since 1.0
 */
function nectar_clients($atts, $content = null) { 
   
  extract(shortcode_atts(array(
    "carousel" => "false", 
    "fade_in_animation" => "false", 
    "columns" => '4'), $atts));
	
	$opening      = null;
	$closing      = null;
	$column_class = null;
	
	switch ($columns) {
		case '2' :
			$column_class = 'two-cols';
			break;
		case '3' :
			$column_class = 'three-cols';
			break;
		case '4' :
			$column_class = 'four-cols';
			break;	
		case '5' :
			$column_class = 'five-cols';
			break;
		case '6' :
			$column_class = 'six-cols';
			break;
	}
	
	($fade_in_animation == "true") ? $animation = 'fade-in-animation' : $animation = null ;
	
	if($carousel === "true"){
		$opening .= '<div class="carousel-wrap"><div class="row carousel clients '.esc_attr($column_class).' ' .esc_attr($animation).'" data-max="'.esc_attr($columns).'">';
		$closing .= '</div></div>';
	}
	else{
		$opening .= '<div class="clients no-carousel '.esc_attr($column_class).' ' .esc_attr($animation).'">';
		$closing .= '</div>';
	}
	
  return $opening . do_shortcode($content) . $closing;
}

add_shortcode('clients', 'nectar_clients');


/**
 * Client shortcode.
 *
 * @since 1.0
 */
function nectar_client($atts, $content = null) {
	extract(shortcode_atts(array(
    "image" => "", 
    "url" => '#',
    "alt" => ""), $atts));
    
	$client_content   = null;
	$image_dimensions = null;
	
	if(preg_match('/^\d+$/',$image)){
		$image_src        = wp_get_attachment_image_src($image, 'full');
		$image            = $image_src[0];
		$image_dimensions = 'width="'.$image_src[1].'" height="'.$image_src[2].'"';
	}

	(!empty($alt)) ? $alt_tag = $alt : $alt_tag = 'client';
  
	if(!empty($url) && $url !== 'none'){
		$client_content = '<div><a href="'.esc_url($url).'" target="_blank"><img src="'.esc_url($image).'" '.$image_dimensions.' alt="'.esc_attr($alt_tag).'" /></a></div>';
	}  
	else {
		$client_content = '<div><img src="'.esc_url($image).'" '.$image_dimensions.' alt="'.esc_attr($alt_tag).'" /></div>';
	}
  
  return $client_content;
}

add_shortcode('client', 'nectar_client');




/**
 * Pricing Table shortcode.
 *
 * @since 1.0
 */
function nectar_pricing_table($atts, $content = null) {  
  
  extract(shortcode_atts(array(
    "columns" => '4', 
    "style" => "default"), $atts));
	$column_class = null;
	
	switch ($columns) {
		case '2' :
			$column_class = 'two-cols';
			break;
		case '3' :
			$column_class = 'three-cols';
			break;
		case '4' :
			$column_class = 'four-cols';
			break;	
		case '5' :
			$column_class = 'five-cols';
			break;
	}
	
  return '<div class="row pricing-table '.esc_attr($column_class).'" data-style="'.esc_attr($style).'">' . do_shortcode($content) . '</div>';
}

add_shortcode('pricing_table', 'nectar_pricing_table');


/**
 * Pricing column shortcode.
 *
 * @since 1.0
 */
function nectar_pricing_column($atts, $content = null) {
  
	extract(shortcode_atts(array(
    "title"=>'Column title', 
    "highlight" => 'false', 
    "highlight_reason" => 'Most Popular', 
    'color' => 'Accent-Color', 
    "price" => "99", 
    "currency_symbol" => '$', 
    "interval" => 'Per Month'), $atts));
	
	$highlight_class        = null;
	$hightlight_reason_html = null;
	
	if($highlight === 'true') {
		$highlight_class        = 'highlight ' . strtolower($color); 
		$hightlight_reason_html = '<span class="highlight-reason">'.wp_kses_post($highlight_reason).'</span>';
	}
	
    return '<div class="pricing-column '.esc_attr($highlight_class).'">
  			<h3>'.wp_kses_post($title). $hightlight_reason_html .'</h3>
            <div class="pricing-column-content">
				<h4> <span class="dollar-sign">'.wp_kses_post($currency_symbol).'</span>'.wp_kses_post($price).' </h4>
				<span class="interval">'.wp_kses_post($interval).'</span>' . do_shortcode($content) . '</div></div>';
}

add_shortcode('pricing_column', 'nectar_pricing_column');




/**
 * Tabbed section shortcode.
 *
 * @since 1.0
 */
function nectar_tabs($atts, $content = null) {
  
  $GLOBALS['tab_count'] = 0;
  
	do_shortcode( $content );
	
	if( is_array( $GLOBALS['tabs'] ) ){
		
		foreach( $GLOBALS['tabs'] as $tab ){
			$tabs[]  = '<li><a href="#'.$tab['id'].'">'.wp_kses_post($tab['title']).'</a></li>';
			$panes[] = '<div id="'.esc_attr($tab['id']).'">'.$tab['content'].'</div>';
		}
		
		$return = '<div class="tabbed vc_clearfix"><ul>'.implode( "\n", $tabs ).'</ul>'.implode( "\n", $panes )."</div>\n";
	}
	return $return;
}

add_shortcode('tabbed_section', 'nectar_tabs');


/**
 * Tab shortcode.
 *
 * @since 1.0
 */
function nectar_tab( $atts, $content ){
  
	extract(shortcode_atts(array( 
    'title' => '%d', 
    'id' => '%d'), $atts));
	
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array(
		'title' => sprintf( $title, $GLOBALS['tab_count'] ),
		'content' =>  do_shortcode($content),
		'id' =>  $id );
	
	$GLOBALS['tab_count']++;
}

add_shortcode( 'tab', 'nectar_tab' );





/**
 * Accordion shortcode.
 *
 * @since 1.0
 */
function nectar_toggles($atts, $content = null) { 
  
	extract(shortcode_atts(array(
    "accordion" => 'false', 
    'style' => 'default'), $atts));  
	
	($accordion == 'true') ? $accordion_class = 'accordion': $accordion_class = null;
  
  return '<div class="toggles '.$accordion_class.'" data-style="'.esc_attr($style).'">' . do_shortcode($content) . '</div>'; 
}


add_shortcode('toggles', 'nectar_toggles');


/**
 * Toggle shortcode.
 *
 * @since 1.0
 */
function nectar_toggle($atts, $content = null) {
  
	extract(shortcode_atts(array(
    "title" => 'Title', 
    'color' => 'Accent-Color'), $atts)); 
   
  return '<div class="toggle '.esc_attr(strtolower($color)).'"><h3><a href="#"><i class="icon-plus-sign"></i>'. wp_kses_post($title) .'</a></h3><div>' . do_shortcode($content) . '</div></div>';
}

add_shortcode('toggle', 'nectar_toggle');





/**
 * Blog shortcode.
 *
 * @since 1.0
 */
function nectar_blog_processing($atts, $content = null) {
	
  extract(shortcode_atts(array(
    "layout" => 'std-blog-sidebar', 
    'blog_masonry_style' => 'inherit', 
    'auto_masonry_spacing' => '', 
    'auto_masonry_spacing' => '', 
    'blog_standard_style' => 'inherit', 
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
     
     if( defined( 'NECTAR_THEME_NAME' ) ) {
       $nectar_options = get_nectar_theme_options();
     } else {
       $nectar_options = array();
     }
     
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
       
       if( $layout === 'masonry-blog-full-screen-width' && 
       $blog_masonry_style === 'auto_meta_overlaid_spaced' || 
       $layout === 'masonry-blog-full-screen-width' && 
       $blog_masonry_style === 'meta_overlaid') { 
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
     
     // Incase only all was selected.
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
       
       // Salient is active.
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
       else {
         
         // Basic layout post.
          include( SALIENT_SHORTCODES_ROOT_DIR_PATH.'includes/frontend/blog/entry.php');

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
              
              echo '<div id="pagination" data-is-text="'.esc_html__("All items loaded", 'salient-shortcodes').'">';
               
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
  
  return $blog_markup;
	
}


add_shortcode('nectar_blog', 'nectar_blog_processing');





/**
 * Recent Posts shortcode.
 *
 * @since 1.0
 */
function nectar_recent_posts($atts, $content = null) {
	extract(shortcode_atts(
    array("title_labels" => 'false',  
    'category' => 'all', 
    'order' => 'DESC', 
    'orderby' => 'date', 
    'hover_shadow_type' => 'default', 
    'button_color' => '', 
    'bg_overlay' => '', 
    'slider_size' => '600', 
    'mlf_navigation_location' => 'side', 
    'large_featured_padding' => '10%', 
    'color_scheme' => 'light',
    'auto_rotate' => 'none', 
    'slider_above_text' => '', 
    'multiple_large_featured_num' => '4', 
    'posts_per_page' => '4', 
    'columns' => '4', 
    'style' => 'default', 
    'post_offset' => '0',
    'blog_remove_post_date' => '', 
    'blog_remove_post_author' => '',
    'blog_remove_post_comment_number' => '', 
    'blog_remove_post_nectar_love' => ''
  ), $atts));  
	
	global $post;  
	global $nectar_options;
  
  if( isset($_GET['vc_editable']) ) {
  	$nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
  	$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
    if($nectar_using_VC_front_end_editor) {
      $auto_rotate = 'none';
    }
  }
	
	$posts_page_id           = get_option('page_for_posts');
	$posts_page              = get_page($posts_page_id);
	$posts_page_title        = $posts_page->post_title;
	$posts_page_link         = get_page_uri($posts_page_id);
	$recent_posts_title_text = (!empty($nectar_options['recent-posts-title'])) ? $nectar_options['recent-posts-title'] :'Recent Posts';		
	$recent_posts_link_text  = (!empty($nectar_options['recent-posts-link'])) ? $nectar_options['recent-posts-link'] :'View All Posts';		
	
  if($blog_remove_post_date === 'true') { 
    $blog_remove_post_date = '1'; 
  }
  if($blog_remove_post_author === 'true') { 
    $blog_remove_post_author = '1'; 
  }
  if($blog_remove_post_comment_number === 'true') { 
    $blog_remove_post_comment_number = '1'; 
  }
  if($blog_remove_post_nectar_love === 'true') { 
    $blog_remove_post_nectar_love = '1'; 
  }
  
	//incase only all was selected
	if($category === 'all') {
		$category = null;
	}
	
	if($style !== 'slider' && 
  $style !== 'slider_multiple_visible' && 
  $style !== 'single_large_featured' && 
  $style !== 'multiple_large_featured') {

			ob_start(); 
			
			if( $title_labels == 'true' ) {
        echo '<h2 class="uppercase recent-posts-title">'. wp_kses_post( $recent_posts_title_text ) .'<a href="'. esc_url( $posts_page_link ) .'" class="button"> / '. wp_kses_post( $recent_posts_link_text ) .'</a></h2>';
      }
      
			$modded_style = $style;
      
      if($style === 'list_featured_first_row_tall') {
        $modded_style = 'list_featured_first_row';
      }
      ?>
			<div class="row blog-recent columns-<?php echo esc_attr( $columns ); ?>" data-style="<?php echo esc_attr( $modded_style ); ?>" data-color-scheme="<?php echo esc_attr( $color_scheme ); ?>" data-remove-post-date="<?php echo esc_attr( $blog_remove_post_date ); ?>" data-remove-post-author="<?php echo esc_attr( $blog_remove_post_author ); ?>" data-remove-post-comment-number="<?php echo esc_attr( $blog_remove_post_comment_number ); ?>" data-remove-post-nectar-love="<?php echo esc_attr($blog_remove_post_nectar_love ); ?>">
				
				<?php 
          
          $r_post_count = 0;

          if($orderby !== 'view_count') {
            
            $recentBlogPosts = array(
  			      'showposts' => $posts_per_page,
  			      'category_name' => $category,
  			      'ignore_sticky_posts' => 1,
  			      'offset' => $post_offset,
              'order' => $order,
              'orderby' => $orderby,
  			      'tax_query' => array(
  		              array( 'taxonomy' => 'post_format',
  		                  'field' => 'slug',
  		                  'terms' => array('post-format-link'),
  		                  'operator' => 'NOT IN'
  		                  )
  		              )
  			    );
            
          } else {

            $recentBlogPosts = array(
  			      'showposts' => $posts_per_page,
  			      'category_name' => $category,
  			      'ignore_sticky_posts' => 1,
  			      'offset' => $post_offset,
              'order' => $order,
              'orderby' => 'meta_value_num',
              'meta_key' => 'nectar_blog_post_view_count',
  			      'tax_query' => array(
  		              array( 'taxonomy' => 'post_format',
  		                  'field' => 'slug',
  		                  'terms' => array('post-format-link'),
  		                  'operator' => 'NOT IN'
  		                  )
  		              )
  			    );
            
          }
          
			    

				$recent_posts_query = new WP_Query($recentBlogPosts);  

				if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post();  

        $r_post_count++;
        
				if($columns === '4') {
					$col_num = 'span_3';
				} else if($columns === '3') {
					$col_num = 'span_4';
				} else if($columns === '2') {
					$col_num = 'span_6';
				} else {
					$col_num = 'span_12';
				}
				
				?>

				<div <?php post_class('col'. ' '. $col_num); ?> >
					
					<?php 
						
						$wp_version = floatval(get_bloginfo('version'));
						
						if($style == 'default') {

							if(get_post_format() == 'video'){

									$video_embed   = get_post_meta($post->ID, '_nectar_video_embed', true);
								   $video_m4v    = get_post_meta($post->ID, '_nectar_video_m4v', true);
								   $video_ogv    = get_post_meta($post->ID, '_nectar_video_ogv', true); 
								   $video_poster = get_post_meta($post->ID, '_nectar_video_poster', true); 
								  
								    if( !empty($video_embed) || !empty($video_m4v) ){
				
						        $wp_version = floatval(get_bloginfo('version'));
												
									  //video embed
									  if( !empty( $video_embed ) ) {
										
							        echo '<div class="video">' . do_shortcode($video_embed) . '</div>';
										
							      } 
							          //self hosted video pre 3-6
							    else if( !empty($video_m4v) && $wp_version < "3.6") {
							        	
							      echo '<div class="video">'; 
    							               
    								echo '</div>'; 
    										 
    							  } 
							          //self hosted video post 3-6
							          else if($wp_version >= "3.6"){
						
							        	  if(!empty($video_m4v) || !empty($video_ogv)) {
							        		
											  $video_output = '[video ';
											
											  if(!empty($video_m4v)) { $video_output .= 'mp4="'. esc_url($video_m4v) .'" '; }
											  if(!empty($video_ogv)) { $video_output .= 'ogv="'. esc_url($video_ogv) .'"'; }
											
											  $video_output .= ' poster="'.esc_attr($video_poster).'"]';
											
							        		  echo '<div class="video">' . do_shortcode($video_output) . '</div>';	
							        	  }
							          }
									
								   } // endif for if there's a video
									
				
							    
							} //endif for post format video
							
							else if(get_post_format() === 'audio'){ ?>
								<div class="audio-wrap">		
									<?php 
									if ( $wp_version < "3.6" ) {
									    //nectar_audio($post->ID);
									} 
									else {
										$audio_mp3 = get_post_meta($post->ID, '_nectar_audio_mp3', true);
									  $audio_ogg = get_post_meta($post->ID, '_nectar_audio_ogg', true); 
										
										if(!empty($audio_ogg) || !empty($audio_mp3)) {
								        	
											$audio_output = '[audio ';
											
											if(!empty($audio_mp3)) { $audio_output .= 'mp3="'. esc_url($audio_mp3) .'" '; }
											if(!empty($audio_ogg)) { $audio_output .= 'ogg="'. esc_url($audio_ogg) .'"'; }
											
											$audio_output .= ']';
											
							        		echo  do_shortcode($audio_output);	
							        	}
									} ?>
								</div><!--/audio-wrap-->
							<?php }
							
							else if(get_post_format() == 'gallery'){
								
								if ( $wp_version < "3.6" ) {
									
									if ( has_post_thumbnail() ) { echo get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')); }
									
								}
								
								else {
									
									$gallery_ids = nectar_grab_ids_from_gallery(); ?>
						
									<div class="flex-gallery"> 
											 <ul class="slides">
											 	<?php 
												foreach( $gallery_ids as $image_id ) {
												     echo '<li>' . wp_get_attachment_image($image_id, 'portfolio-thumb', false) . '</li>';
												} ?>
									    	</ul>
								   	 </div><!--/gallery-->

						   <?php }
										
							}
							
							else {
								if ( has_post_thumbnail() ) { echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_post_thumbnail($post->ID, 'portfolio-thumb', array('title' => '')) . '</a>'; }
							}
					
						?>

							<div class="post-header">
								<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>	
								<span class="meta-author"><?php the_author_posts_link(); ?> </span> <span class="meta-category"> | <?php the_category(', '); ?> </span> <span class="meta-comment-count"> | <a href="<?php comments_link(); ?>">
								<?php comments_number( esc_html__( 'No Comments','salient-shortcodes'), esc_html__( 'One Comment','salient-shortcodes'), '% '. esc_html__( 'Comments','salient-shortcodes') ); ?></a> </span>
							</div><!--/post-header-->
							
							<?php 
              $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 30; 
							echo '<div class="excerpt">' . nectar_excerpt($excerpt_length) . '</div>';

						} // default style
						else if($style === 'minimal') { ?>

							<a href="<?php the_permalink(); ?>"></a>
							<div class="post-header">
								<span class="meta"> <span> <?php echo get_the_date() . '</span> ' . esc_html__( 'in','salient-shortcodes'); ?> <?php the_category(', '); ?> </span> 
								<h3 class="title"><?php the_title(); ?></h3>	
							</div><!--/post-header-->
							<?php 
                $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 30; 
  							echo '<div class="excerpt">' . nectar_excerpt($excerpt_length) . '</div>';
              ?>
							<span><?php echo esc_html__( 'Read More','salient'); ?> <i class="icon-button-arrow"></i></span>

						<?php } else if($style == 'title_only') { ?>

							<a href="<?php the_permalink(); ?>"></a>
							<div class="post-header">
								<span class="meta"> <?php echo get_the_date(); ?> </span> 
								<h2 class="title"><?php the_title(); ?></h2>	
							</div><!--/post-header-->

						<?php } 
            
            else if($style === 'list_featured_first_row' || $style === 'list_featured_first_row_tall') { ?>
              
              <?php 
              
              $list_heading_tag          = ($r_post_count <= $columns) ? 'h3' : 'h5';
              $list_featured_image_size  = ($r_post_count <= $columns) ? 'portfolio-thumb' : 'nectar_small_square';
              $list_featured_image_class = ($r_post_count <= $columns) ? 'featured' : 'small';
              
              echo '<a class="full-post-link" href="' . esc_url(get_permalink()) . '"></a>';
              
              if ( has_post_thumbnail() ) { 
                if($style === 'list_featured_first_row_tall' && $r_post_count <= $columns){
                   echo'<a href="' . esc_url(get_permalink()) . '" class="'.$list_featured_image_class.'"><span class="post-featured-img" style="background-image: url('.get_the_post_thumbnail_url($post->ID, 'regular', array('title' => '')).');"></span></a>'; 
                } else {
                  echo '<a class="'.$list_featured_image_class.'" href="' . esc_url(get_permalink()) . '">' . get_the_post_thumbnail($post->ID, $list_featured_image_size, array('title' => '')) . '</a>'; 
                }
              }
              else { echo '<a class="'.$list_featured_image_class.'" href="' . esc_url(get_permalink()) . '"></a>';  }
              ?>
							<div class="post-header <?php echo esc_attr( $list_featured_image_class ); ?>">
								
                <?php echo '<span class="meta-category">';
  							$categories = get_the_category();
  							if ( ! empty( $categories ) ) {
  								$output = null;
  							    foreach( $categories as $category ) {
  							        $output .= '<a class="'.$category->slug.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
  							        break;
                    }
  							    echo trim( $output);
  								}
  							echo '</span>'; ?>
								<?php echo '<' . $list_heading_tag . '> <a href="'.esc_url(get_permalink()).'">'. get_the_title() .'</a></'. $list_heading_tag .'>'; ?>
                  
							</div><!--/post-header-->
              
              <?php 
              if($r_post_count <= $columns) {
                $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 15; 
                echo '<div class="excerpt">'.nectar_excerpt($excerpt_length).'</div>';
              
              }

					 } 

						else if($style === 'classic_enhanced' || $style === 'classic_enhanced_alt') { 

							if($columns === '4') {
								$image_attrs =  array('title' => '', 'sizes' => '(min-width: 1300px) 25vw, (min-width: 1000px) 33vw, (min-width: 690px) 100vw, 100vw');
							} else if($columns === '3') {
								$image_attrs =  array('title' => '', 'sizes' => '(min-width: 1300px) 33vw, (min-width: 1000px) 33vw, (min-width: 690px) 100vw, 100vw');
							} else if($columns === '2') {
								$image_attrs =  array('title' => '', 'sizes' => '(min-width: 1600px) 50vw, (min-width: 1300px) 50vw, (min-width: 1000px) 50vw, (min-width: 690px) 100vw, 100vw');
							} else {
								$image_attrs =  array('title' => '', 'sizes' => '(min-width: 1000px) 100vw, (min-width: 690px) 100vw, 100vw');
							} ?>

							<div <?php post_class('inner-wrap'); ?>>

							<?php
              
              $post_link_target = (get_post_format() === 'link') ? 'target="_blank"' : '';
                
							if ( has_post_thumbnail() ) { 
								if($style === 'classic_enhanced') {
									echo '<a href="' . esc_url(get_permalink()) . '" '.$post_link_target.' class="img-link"><span class="post-featured-img">'.get_the_post_thumbnail($post->ID, 'portfolio-thumb', $image_attrs) .'</span></a>'; 
								} else if($style === 'classic_enhanced_alt') {
									$masonry_sizing_type = (!empty($nectar_options['portfolio_masonry_grid_sizing']) && $nectar_options['portfolio_masonry_grid_sizing'] == 'photography') ? 'photography' : 'default';
									$cea_size = ($masonry_sizing_type == 'photography') ? 'regular_photography' : 'tall';
									echo '<a href="' . esc_url(get_permalink()) . '" class="img-link" '.$post_link_target.'><span class="post-featured-img">'.get_the_post_thumbnail($post->ID, $cea_size, $image_attrs) .'</span></a>'; 
								}
							} ?>

							<?php
							echo '<span class="meta-category">';
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								$output = null;
							    foreach( $categories as $category ) {
							        $output .= '<a class="'.$category->slug.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
							    }
							    echo trim( $output);
								}
							echo '</span>'; 
							
              echo '<a class="entire-meta-link" href="'. esc_url(get_permalink()) .'" '.$post_link_target.'></a>'; ?>	

							<div class="article-content-wrap">
								<div class="post-header">
									<span class="meta"> <?php echo get_the_date(); ?> </span> 
									<h3 class="title"><?php the_title(); ?></h3>	
								</div><!--/post-header-->
								<div class="excerpt">
									<?php 
                  $excerpt_length = (!empty($nectar_options['blog_excerpt_length'])) ? intval($nectar_options['blog_excerpt_length']) : 30; 
    							echo nectar_excerpt($excerpt_length);
                  ?>
								</div>
							</div>
							
							<div class="post-meta">
								<span class="meta-author"> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"> <i class="icon-default-style icon-salient-m-user"></i> <?php the_author(); ?></a> </span> 
								
								<?php if(comments_open()) { ?>
									<span class="meta-comment-count">  <a href="<?php comments_link(); ?>">
										<i class="icon-default-style steadysets-icon-chat-3"></i> <?php comments_number( '0', '1','%' ); ?></a>
									</span>
								<?php } ?>
								
								<div class="nectar-love-wrap">
									<?php if( function_exists('nectar_love') ) { 
                    nectar_love();
                  } ?>
								</div><!--/nectar-love-wrap-->	
							</div>

						</div>

						<?php }  ?>
					
				</div><!--/col-->
				
				<?php endwhile; endif; 
					  wp_reset_postdata();
				?>
		
			</div><!--/blog-recent-->
		
		<?php

		$recent_posts_content = ob_get_contents();
		
		ob_end_clean();
	
	} // regular recent posts
  
  else if($style === 'single_large_featured') { //single_large_featured
 
    ob_start(); 
      
      if($orderby !== 'view_count') {
        
        $recentBlogPosts = array(
          'showposts' => 1,
          'category_name' => $category,
          'ignore_sticky_posts' => 1,
          'offset' => $post_offset,
          'order' => $order,
          'orderby' => $orderby,
          'tax_query' => array(
                array( 'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-link'),
                    'operator' => 'NOT IN'
                    )
                )
        );
    } else {
      
        $recentBlogPosts = array(
          'showposts' => 1,
          'category_name' => $category,
          'ignore_sticky_posts' => 1,
          'offset' => $post_offset,
          'order' => $order,
          'orderby' => 'meta_value_num',
          'meta_key' => 'nectar_blog_post_view_count',
          'tax_query' => array(
                array( 'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-link'),
                    'operator' => 'NOT IN'
                    )
                )
        );
      
    }
 
    $recent_posts_query = new WP_Query($recentBlogPosts);  
 
 
    $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';
    
    echo '<div id="'.uniqid('rps_').'" class="nectar-recent-posts-single_featured parallax_section" data-padding="'. esc_attr( $large_featured_padding ) .'" data-bg-overlay="'. esc_attr( $bg_overlay ) .'" data-height="'. esc_attr( $slider_size ) .'" data-animate-in-effect="'. esc_attr( $animate_in_effect ) .'" data-remove-post-date="'. esc_attr( $blog_remove_post_date ) .'" data-remove-post-author="'. esc_attr( $blog_remove_post_author ) .'" data-remove-post-comment-number="'.$blog_remove_post_comment_number.'" data-remove-post-nectar-love="'.$blog_remove_post_nectar_love.'">';

    $i = 0;
    if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>
 
        <?php 
          $bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
          $bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
          $bg_image_id  = null;
          $featured_img = null;
          
          if(!empty($bg)){
            //page header
            $featured_img = $bg;
 
          } elseif(has_post_thumbnail($post->ID)) {
            $bg_image_id  = get_post_thumbnail_id($post->ID);
            $image_src    = wp_get_attachment_image_src($bg_image_id, 'full');
            $featured_img = $image_src[0];
          }
 
 
        ?>
 
        <div class="nectar-recent-post-slide <?php if($bg_image_id == null) echo 'no-bg-img'; ?> post-ref-<?php echo esc_attr($i); ?>">
 
          <div class="row-bg using-image" data-parallax-speed="fast"><div class="nectar-recent-post-bg" style=" <?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr( $bg_color );?>; <?php } ?> background-image: url(<?php echo esc_url( $featured_img ) ;?>);" > </div></div>
 
          <?php 
 
          echo '<div class="recent-post-container container"><div class="inner-wrap">';

          
              $categories = get_the_category();
              if ( ! empty( $categories ) ) {
                $cat_output = null;
                  $i = 0;
                  foreach( $categories as $category ) {
                     $i++;
                     $cat_output .= '<a class="'.$category->slug.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'.$category->slug.'">'.esc_html( $category->name ) .'</span></a>';
                     if($i > 0) {
                       break;  
                     }
                  }
    
              }
          
            
            echo '<div class="grav-wrap"><a href="'.get_author_posts_url($post->post_author).'">'.get_avatar( get_the_author_meta('email'), 70,  null, get_the_author() ). '</a><div class="text"><span>'.esc_html__( 'By','salient-shortcodes').' <a href="'.get_author_posts_url($post->post_author).'" rel="author">' .get_the_author().'</a></span><span> '.esc_html__( 'In','salient-shortcodes').'</span> '. trim( $cat_output) . '</div></div>'; 
            ?>
          
            <h2 class="post-ref-<?php echo esc_attr($i); ?>"><a href=" <?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h2>
            <?php echo '<div class="excerpt">' . nectar_excerpt(20) . '</div>';  ?>
          
            <?php 
            //stop regular grad class for material skin 
            $button_color      = strtolower($button_color);
            $regular_btn_class = ' regular-button';
            
            if($button_color === 'extra-color-gradient-1' || $button_color === 'extra-color-gradient-2') {
              $regular_btn_class = '';
            }
            
          	if($nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-1') {
          		$button_color = 'm-extra-color-gradient-1';
          	} else if( $nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-2') {
          		$button_color = 'm-extra-color-gradient-2';
          	} 
            ?>
            <a class="nectar-button large regular <?php echo esc_attr( $button_color ) .  esc_attr( $regular_btn_class ); ?> has-icon" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read More', 'salient'); ?></span> <i class="icon-button-arrow"></i></a>
            
          
          </div>
            
 
        </div>
 
        <?php $i++; ?>
 
    <?php endwhile; endif; 
 
        wp_reset_postdata();
  
     echo '</div></div>';
 
    wp_reset_query();
    
    $recent_posts_content = ob_get_contents();
    
    ob_end_clean();
  }
  
  else if($style === 'multiple_large_featured') { //multiple_large_featured
 
    ob_start(); 
      
      if($orderby !== 'view_count') {
        $recentBlogPosts = array(
          'showposts' => $multiple_large_featured_num,
          'category_name' => $category,
          'ignore_sticky_posts' => 1,
          'offset' => $post_offset,
          'order' => $order,
          'orderby' => $orderby,
          'tax_query' => array(
                array( 'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-link'),
                    'operator' => 'NOT IN'
                    )
                )
        );
      } else {
        
        $recentBlogPosts = array(
          'showposts' => $multiple_large_featured_num,
          'category_name' => $category,
          'ignore_sticky_posts' => 1,
          'offset' => $post_offset,
          'order' => $order,
          'orderby' => 'meta_value_num',
          'meta_key' => 'nectar_blog_post_view_count',
          'tax_query' => array(
                array( 'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-link'),
                    'operator' => 'NOT IN'
                    )
                )
        );
        
      }
    $recent_posts_query = new WP_Query($recentBlogPosts);  
 
    $button_color = strtolower($button_color);
    $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';
    echo '<div id="'.uniqid('rps_').'" class="nectar-recent-posts-single_featured multiple_featured parallax_section" data-button-color="'. esc_attr( $button_color ) .'" data-nav-location="'. esc_attr( $mlf_navigation_location ) .'" data-bg-overlay="'. esc_attr( $bg_overlay ) .'" data-padding="'. esc_attr( $large_featured_padding ) .'" data-autorotate="'. esc_attr( $auto_rotate ) .'" data-height="'. esc_attr( $slider_size ) .'" data-animate-in-effect="'. esc_attr( $animate_in_effect ) .'" data-remove-post-date="'. esc_attr( $blog_remove_post_date ) .'" data-remove-post-author="'. esc_attr( $blog_remove_post_author ) .'" data-remove-post-comment-number="'. esc_attr( $blog_remove_post_comment_number ) .'" data-remove-post-nectar-love="'. esc_attr( $blog_remove_post_nectar_love ) .'">';

    $i = 0;
    if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>
 
        <?php 
          $bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
          $bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
          $bg_image_id  = null;
          $featured_img = null;
          
          if(!empty($bg)){
            //page header
            $featured_img = $bg;
 
          } elseif(has_post_thumbnail($post->ID)) {
            $bg_image_id  = get_post_thumbnail_id($post->ID);
            $image_src    = wp_get_attachment_image_src($bg_image_id, 'full');
            $featured_img = $image_src[0];
          }
 
 
        ?>
 
        <div class="nectar-recent-post-slide <?php if($bg_image_id == null) echo 'no-bg-img'; ?> <?php if($i == 0) echo 'active'; ?> post-ref-<?php echo esc_attr($i); ?>">
 
          <div class="row-bg using-image" data-parallax-speed="fast"><div class="nectar-recent-post-bg" style=" <?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr($bg_color);?>; <?php } ?> background-image: url(<?php echo esc_url( $featured_img );?>);" > </div></div>
 
          <?php 
 
          echo '<div class="recent-post-container container"><div class="inner-wrap">';

          
              $categories = get_the_category();
              if ( ! empty( $categories ) ) {
                $cat_output = null;
                  $i = 0;
                  foreach( $categories as $category ) {
                     $i++;
                     $cat_output .= '<a class="'.$category->slug.'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'.$category->slug.'">'.esc_html( $category->name ) .'</span></a>';
                      if($i > 0) {
                        break;  
                      }
                  }
    
              }
          
            
            echo '<div class="grav-wrap"><a href="'.get_author_posts_url($post->post_author).'">'.get_avatar( get_the_author_meta('email'), 70,  null, get_the_author() ). '</a><div class="text"><span>'.esc_html__( 'By','salient-shortcodes').' <a href="'.get_author_posts_url($post->post_author).'" rel="author">' .get_the_author().'</a></span><span> '.esc_html__( 'In','salient-shortcodes').'</span> '. trim( $cat_output) . '</div></div>'; 
            ?>
          
            <h2 class="post-ref-<?php echo esc_attr($i); ?>"><a href="<?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h2>
            
            <?php 
            //stop regular grad class for material skin 
            $regular_btn_class = ' regular-button';
            
            if($button_color === 'extra-color-gradient-1' || $button_color === 'extra-color-gradient-2') {
              $regular_btn_class = '';
            }
            
          	if($nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-1') {
          		$button_color = 'm-extra-color-gradient-1';
          	} else if( $nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-2') {
          		$button_color = 'm-extra-color-gradient-2';
          	} 
            ?>
            <a class="nectar-button large regular <?php echo esc_attr($button_color) .  esc_attr($regular_btn_class); ?> has-icon" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read Article', 'salient-shortcodes'); ?> </span><i class="icon-button-arrow"></i></a>
            
          
          </div></div></div>
 
        <?php $i++; ?>
 
    <?php endwhile; endif; 
 
        wp_reset_postdata();
     echo '</div>';
 
    wp_reset_query();
    
    $recent_posts_content = ob_get_contents();
    
    ob_end_clean();
  }
  
  
  else if($style === 'slider_multiple_visible') { //slider multiple visible
 
    ob_start(); 
      
      if($orderby != 'view_count') {
          $recentBlogPosts = array(
            'showposts' => $posts_per_page,
            'category_name' => $category,
            'ignore_sticky_posts' => 1,
            'offset' => $post_offset,
            'order' => $order,
            'orderby' => $orderby,
            'tax_query' => array(
                  array( 'taxonomy' => 'post_format',
                      'field' => 'slug',
                      'terms' => array('post-format-link'),
                      'operator' => 'NOT IN'
                      )
                  )
          );
    } else {
        
        $recentBlogPosts = array(
          'showposts' => $posts_per_page,
          'category_name' => $category,
          'ignore_sticky_posts' => 1,
          'offset' => $post_offset,
          'order' => $order,
          'orderby' => 'meta_value_num',
          'meta_key' => 'nectar_blog_post_view_count',
          'tax_query' => array(
                array( 'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-link'),
                    'operator' => 'NOT IN'
                    )
                )
        );
      
    }
    $recent_posts_query = new WP_Query($recentBlogPosts);  
 
 
    $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';
    echo '<div class="nectar-recent-posts-slider_multiple_visible" data-columns="'.$columns.'" data-height="'.$slider_size.'" data-shadow-hover-type="'.$hover_shadow_type.'" data-animate-in-effect="'.$animate_in_effect.'" data-remove-post-date="'.$blog_remove_post_date.'" data-remove-post-author="'.$blog_remove_post_author.'" data-remove-post-comment-number="'.$blog_remove_post_comment_number.'" data-remove-post-nectar-love="'.$blog_remove_post_nectar_love.'">';

    echo '<div class="nectar-recent-posts-slider-inner"><div class="flickity-viewport"><div class="flickity-slider">'; 
    $i = 0;
    if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>
 
        <?php 
          $bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
          $bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
          $bg_image_id  = null;
          $featured_img = null;
          
          if(has_post_thumbnail($post->ID)) {
            $bg_image_id  = get_post_thumbnail_id($post->ID);
            $image_src    = wp_get_attachment_image_src($bg_image_id, 'medium_featured');
            $featured_img = $image_src[0];
          }
 
 
        ?>
 
        <div class="nectar-recent-post-slide <?php if($bg_image_id == null) echo 'no-bg-img'; ?> post-ref-<?php echo esc_attr($i); ?>">
 
          <div class="nectar-recent-post-bg-wrap"><div class="nectar-recent-post-bg"  style=" <?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr($bg_color);?>; <?php } ?> background-image: url(<?php echo esc_url($featured_img);?>);" > </div></div>
          <div class="nectar-recent-post-bg-blur"  style=" <?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr($bg_color) ;?>; <?php } ?> background-image: url(<?php echo esc_url($featured_img) ;?>);" > </div>
 
          <?php 
 
          echo '<div class="recent-post-container container"><div class="inner-wrap">';
 
          echo '<span class="strong">';
              $categories = get_the_category();
              if ( ! empty( $categories ) ) {
                $output = null;
                  foreach( $categories as $category ) {
                      $output .= '<a class="'. esc_attr( $category->slug ).'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'. esc_attr( $category->slug ) .'">'.esc_html( $category->name ) .'</span></a>';
                  }
                  echo trim( $output);
              }
            echo '</span>'; ?>
          
            <h3 class="post-ref-<?php echo esc_attr($i); ?>"><a href=" <?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h3>
            
            
            <?php 
            //stop regular grad class for material skin 
            $button_color      = strtolower($button_color);
            $regular_btn_class = ' regular-button';
            
            if($button_color === 'extra-color-gradient-1' || $button_color === 'extra-color-gradient-2') {
              $regular_btn_class = '';
            }
            
          	if($nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-1') {
          		$button_color = 'm-extra-color-gradient-1';
          	} else if( $nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-2') {
          		$button_color = 'm-extra-color-gradient-2';
          	} 
            ?>
            
            <?php if(!empty($nectar_options['theme-skin']) && $nectar_options['theme-skin'] === 'material') { ?>
              <a class="nectar-button large regular  <?php echo esc_attr($button_color) .  esc_attr($regular_btn_class); ?>" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read Article','salient-shortcodes'); ?> </span></a>
            <?php } else { ?>
                <a class="nectar-button large regular  <?php echo esc_attr($button_color) .  esc_attr($regular_btn_class); ?> has-icon" href="<?php echo esc_url(get_permalink()); ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff" ><span><?php echo esc_html__( 'Read Article','salient-shortcodes'); ?> </span><i class="icon-button-arrow"></i></a>
            <?php } ?>
            
          </div>
          
        </div>
            
 
        </div>
 
        <?php $i++; ?>
 
    <?php endwhile; endif; 
 
        wp_reset_postdata();
  
     echo '</div></div></div></div>';
 
    wp_reset_query();
    
    $recent_posts_content = ob_get_contents();
    
    ob_end_clean();
  }
  
  
	else { //slider


		ob_start(); 
			
      if($orderby !== 'view_count') {
        
  	    $recentBlogPosts = array(
  	      'showposts' => $posts_per_page,
  	      'category_name' => $category,
  	      'ignore_sticky_posts' => 1,
  	      'offset' => $post_offset,
          'order' => $order,
          'orderby' => $orderby,
  	      'tax_query' => array(
                array( 'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-link'),
                    'operator' => 'NOT IN'
                    )
                )
  	    ); 
    } else {
      
        $recentBlogPosts = array(
          'showposts' => $posts_per_page,
          'category_name' => $category,
          'ignore_sticky_posts' => 1,
          'offset' => $post_offset,
          'order' => $order,
          'orderby' => 'meta_value_num',
          'meta_key' => 'nectar_blog_post_view_count',
          'tax_query' => array(
                array( 'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-link'),
                    'operator' => 'NOT IN'
                    )
                )
        );
    }

		$recent_posts_query = new WP_Query($recentBlogPosts);  


	   $animate_in_effect = (!empty($nectar_options['header-animate-in-effect'])) ? $nectar_options['header-animate-in-effect'] : 'none';
		echo '<div class="nectar-recent-posts-slider" data-height="'.esc_url($slider_size).'" data-animate-in-effect="'.esc_url($animate_in_effect).'" data-remove-post-date="'.esc_url($blog_remove_post_date).'" data-remove-post-author="'.esc_url($blog_remove_post_author).'" data-remove-post-comment-number="'.esc_url($blog_remove_post_comment_number).'" data-remove-post-nectar-love="'.esc_url($blog_remove_post_nectar_love).'">';

		echo '<div class="nectar-recent-posts-slider-inner generate-markup">'; 
		$i = 0;
    
		if( $recent_posts_query->have_posts() ) :  while( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post(); global $post; ?>

				<?php 
					$bg           = get_post_meta($post->ID, '_nectar_header_bg', true);
					$bg_color     = get_post_meta($post->ID, '_nectar_header_bg_color', true);
					$bg_image_id  = null;
					$featured_img = null;
					
					if(!empty($bg)){
						//page header
						$featured_img = $bg;

					} elseif(has_post_thumbnail($post->ID)) {
						$bg_image_id  = get_post_thumbnail_id($post->ID);
						$image_src    = wp_get_attachment_image_src($bg_image_id, 'full');
						$featured_img = $image_src[0];
					}


				?>

				<div class="nectar-recent-post-slide <?php if($bg_image_id == null) { echo 'no-bg-img'; } ?> post-ref-<?php echo esc_attr($i); ?>">

					<div class="nectar-recent-post-bg"  style=" <?php if(!empty($bg_color)) { ?> background-color: <?php echo esc_attr( $bg_color ) ;?>; <?php } ?> background-image: url(<?php echo esc_url($featured_img) ;?>);" > </div>

					<?php 

					echo '<div class="recent-post-container container"><div class="inner-wrap">';

					echo '<span class="strong">';
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								$output = null;
							    foreach( $categories as $category ) {
							        $output .= '<a class="'.esc_attr($category->slug).'" href="' . esc_url( get_category_link( $category->term_id ) ) . '"><span class="'. esc_attr( $category->slug ) .'">'.esc_html( $category->name ) .'</span></a>';
							    }
							    echo trim( $output);
							}
						echo '</span>'; ?>
					
						<h2 class="post-ref-<?php echo esc_attr($i); ?>"><a href=" <?php echo esc_url(get_permalink()); ?>" class="full-slide-link"> <?php echo the_title(); ?> </a></h2> 
					</div></div>
						
				</div>

				<?php $i++; ?>

		<?php endwhile; endif; 

			wp_reset_postdata();
	
		 echo '</div></div>';

		wp_reset_query();
		
		$recent_posts_content = ob_get_contents();
		
		ob_end_clean();
	}


	return $recent_posts_content;

}
add_shortcode('recent_posts', 'nectar_recent_posts');



?>