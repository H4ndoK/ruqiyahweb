<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-team-member' );

extract(shortcode_atts(array(
  "description" => '', 
	'team_member_bio_full_html' => 'simple',
  'team_member_bio' => '',
	'team_member_mini_bio' => '',
  'team_memeber_style' => '', 
  'color' => 'Accent-Color', 
  'name' => 'Name', 
  'job_position' => '', 
  'image_url' => '', 
  'bio_image_url' => '',
  'bio_alt_image_url' => '', 
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
  'image_loading' => 'default',
  'image_size' => '',
  'bio_fullscreen_alt_parallax' => '',
  'bio_fullscreen_alt_hide_link_arrow' => '',
  'team_member_link_new_tab' => ''), $atts));
  
  $html = null;
  $link_new_tab_markup = ($team_member_link_new_tab == 'true') ? 'target="_blank"': '';
  
  
  // Fullscreen bio style.
  if( $team_memeber_style === 'bio_fullscreen' || $team_memeber_style === 'bio_fullscreen_alt' ) {
    
    $bio_image_url_src = null;
    $team_alt = null;
    
    if( !empty($bio_image_url) &&  $team_memeber_style === 'bio_fullscreen' ){
      
      $bio_image_url_src = $bio_image_url;
      
      if(preg_match('/^\d+$/',$bio_image_url)){
        $bio_image_src     = wp_get_attachment_image_src($bio_image_url, 'full');

        if( isset($bio_image_src[0]) ) {
          $bio_image_url_src = $bio_image_src[0];
        }
        
      }
    } 
    else if ( !empty($bio_alt_image_url) && $team_memeber_style === 'bio_fullscreen_alt' ) {
      
      $bio_image_url_src = $bio_alt_image_url;
      
      if(preg_match('/^\d+$/',$bio_alt_image_url)){
        $bio_image_src     = wp_get_attachment_image_src($bio_alt_image_url, 'full');

        if( isset($bio_image_src[0]) ) {
           $bio_image_url_src = $bio_image_src[0];
        }
       
      }
      
    }
    
    $image_height = '100';
    $image_width  = '100';
    $has_dimension_data = false;
    
    if( !empty($image_url) ){
      
      if( preg_match('/^\d+$/',$image_url) ){
        
        $team_alt  = get_post_meta( $image_url, '_wp_attachment_image_alt', true );
        
        if($team_memeber_style === 'bio_fullscreen_alt') {
					$wp_image_size = ( !empty($image_size) ) ? esc_attr($image_size) : 'large';
          $image_src = wp_get_attachment_image_src($image_url, $wp_image_size);
        } else {
					$wp_image_size = ( !empty($image_size) ) ? esc_attr($image_size) : 'regular';
          $image_src = wp_get_attachment_image_src($image_url, $wp_image_size);
        }
        
        $image_meta   = wp_get_attachment_metadata($image_url);
        if( !empty($image_meta['width']) && !empty($image_meta['height'])) {
          $image_width  = (!empty($image_size) && !empty($image_src[1])) ? $image_src[1] : $image_meta['width'];
          $image_height = (!empty($image_size) && !empty($image_src[2])) ? $image_src[2] : $image_meta['height'];
          $has_dimension_data = true;
        }
        
				$image_url = ( isset($image_src[0]) ) ? $image_src[0] : '';

      }
      
    }
    
    // Lazy load.
    if( 'lazy-load' === $image_loading && true === $has_dimension_data || 
		    true === $has_dimension_data && property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
			
			if( $team_memeber_style === 'bio_fullscreen' && empty($image_size) ) {
				$image_width = 500;
				$image_height = 500;
			}
			
			$placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($image_width).'%20'.esc_attr($image_height)."'%2F%3E";	
			
			
      $img_src_escaped = 'class="nectar-lazy" src="'.$placeholder_img_src.'" data-nectar-img-src="'.esc_url($image_url).'" width="'.esc_attr($image_width).'" height="'.esc_attr($image_height).'"';
    } 
    else {
      $img_src_escaped = 'src="'.esc_url($image_url).'" width="500" height="500"';
    }
    
    

    $social_markup = '<div class="bottom_meta">';
    for( $i = 1; $i < 5; $i++) {
      
      if( isset($atts['social_icon_'.$i]) && !empty($atts['social_icon_'.$i]) ) {
        
        $social_link_url = ( !empty($atts['social_link_'.$i]) ) ? $atts['social_link_'.$i] : '';
        $social_markup .= '<a href="'.esc_url($social_link_url).'" target="_blank"><i class="icon-default-style '.esc_attr($atts['social_icon_'.$i]).'"></i>'.'</a>';
        
      }
    }
    $social_markup .= '</div>';
    
    $team_heading = '<h3>' . wp_kses_post($name) . '</h3>';
    $team_desc    = '<p>' . wp_kses_post($job_position) . '</p>';
    
    if( $team_memeber_style === 'bio_fullscreen_alt') {

      $cta = '';
      if ('true' !== $bio_fullscreen_alt_hide_link_arrow) {

          $cta = '<div class="nectar-cta" data-color="default" data-using-bg="false" data-style="arrow-animation" data-display="block" data-alignment="left"><span class="link_wrap"><a class="link_text" href="#"><svg class="next-arrow" width="20px" height="25px" viewBox="0 0 50 80" xml:space="preserve">
        <polyline stroke="#000000" stroke-width="9" fill="none" stroke-linecap="round" stroke-linejoin="round" points="0, 0 45, 40 0, 80"></polyline>
        </svg><span class="line" style="background-color: #000;"></span> </a></span></div>';
      }
  
      $team_meta_markup_escaped = '<h5>' . wp_kses_post($job_position) . '</h5><h3>' . wp_kses_post($name) . '</h3><p>' . wp_kses_post($team_member_mini_bio) . '</p>' . $cta;
    } else {
      $team_meta_markup_escaped = '<h3>' . wp_kses_post($name) . '</h3><p>' . wp_kses_post($job_position) . '</p><div class="arrow-end fa fa-angle-right"></div><div class="arrow-line"></div>';
    }
    
		if( 'html' === $team_member_bio_full_html ) {
			$main_bio_markup = do_shortcode(wpb_js_remove_wpautop($content, true));
		} else {
			$main_bio_markup = wp_kses_post($team_member_bio);
    }
    
    // Parallax attrs
    $parallax_attr = '';

    if( $bio_fullscreen_alt_parallax === 'true' ) {
      $parallax_attr = ' data-n-parallax-bg="true" data-parallax-speed="subtle"';
    }
		
    $html .= '<div class="team-member"'.$parallax_attr.' data-style="'.esc_attr($team_memeber_style).'">';

    if( 'true' === $bio_fullscreen_alt_parallax ) {
      $html .= '<div class="team-member-image"><div class="team-member-image-inner"><div class="nectar-el-parallax-scroll" data-scroll-animation="true" data-scroll-animation-mobile="true" data-scroll-animation-intensity="-0.7" data-scroll-animation-lerp="1"><div class="vc_column-inner"><img '.$img_src_escaped.' alt="'.esc_attr($team_alt).'" /></div></div></div></div>';
    } else {
      $html .= '<div class="team-member-image"><div class="team-member-image-inner"><img '.$img_src_escaped.' alt="'.esc_attr($team_alt).'" /></div></div>';
    }
    
    $html .= '<div class="team-member-overlay"></div>
    <div class="team-meta">'.$team_meta_markup_escaped.'</div>
    <div class="nectar_team_bio_img" data-img-src="'.esc_attr($bio_image_url_src).'"></div>
    <div class="nectar_team_bio">'.$main_bio_markup . $social_markup .'</div>
    </div>';
    
  }
  
  
  
  if( $team_memeber_style !== 'bio_fullscreen' && $team_memeber_style !== 'bio_fullscreen_alt' ) {
    
    $html .= '<div class="team-member" data-style="'.$team_memeber_style.'">';
    
    if( $team_memeber_style === 'meta_overlaid' || $team_memeber_style === 'meta_overlaid_alt' ) {
      
      $html .= '<div class="team-member-overlay"></div>';
      
      if( !empty($image_url) ){
        
        if(preg_match('/^\d+$/',$image_url)){
					$wp_image_size = ( !empty($image_size) ) ? esc_attr($image_size) : 'portfolio-thumb';
          $image_src = wp_get_attachment_image_src($image_url, $wp_image_size);
          $image_url = $image_src[0];
        }
        
        //Lazy load.
        if( 'lazy-load' === $image_loading || 
				     property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {
          $source_escaped = 'data-nectar-img-src="'.esc_url($image_url).'"';
        } else {
          $source_escaped = 'style="background-image: url('.esc_url($image_url).');"';
        }
        
        // Image link.
        if(!empty($link_url_2)){
          $html .= '<a href="'.esc_url($link_url_2).'" '.$link_new_tab_markup.'></a> <div class="team-member-image" '.$source_escaped.'></div>';
        } else {
          $html .= '<div class="team-member-image" '.$source_escaped.'></div>';
        }
        
      }
      else {
        // Image link.
        if(!empty($link_url_2)){
          $html .= '<a href="'.esc_url($link_url_2).'" '.$link_new_tab_markup.'></a><div class="team-member-image" style="background-image: url('. SALIENT_CORE_PLUGIN_PATH . '/includes/img/team-member-default.jpg);"></div>';
        } else {
          $html .= '<div class="team-member-image" style="background-image: url('. SALIENT_CORE_PLUGIN_PATH . '/includes/img/team-member-default.jpg);"></div>';
        }
        
      }
      
      // Name link.
      $html .= '<div class="team-meta">';
      $html .= '<h3>' . wp_kses_post($name) . '</h3>';
      $html .= '<p>' . wp_kses_post($job_position) . '<p>';
      $html .= '</div>';
      
    } else {
      
      if(!empty($image_url)){
        
        $team_alt = $name;
        
        if( preg_match('/^\d+$/',$image_url) ) {
					$wp_image_size = ( !empty($image_size) ) ? esc_attr($image_size) : 'full';
          $image_src = wp_get_attachment_image_src($image_url, $wp_image_size);
          $team_alt  = get_post_meta( $image_url, '_wp_attachment_image_alt', true );
          
          if( isset($image_src[0])) {
            $image_url = $image_src[0];
          }
          
        }
        
        // Image link.
        if($link_element === 'image' || $link_element === 'both') {
          $html .= '<a href="'.esc_url($link_url).'" '.$link_new_tab_markup.'><img alt="'.esc_attr($team_alt).'" src="' . esc_url($image_url) .'" title="' . esc_attr($name) . '" /></a>';
        } else {
          $html .= '<img alt="'.esc_attr($team_alt).'" src="' . esc_url($image_url) .'" title="' . esc_attr($name) . '" />';
        }
        
      }
      else {
        // Image link.
        if($link_element === 'image' || $link_element === 'both'){
          $html .= '<a href="'.esc_url($link_url).'" '.$link_new_tab_markup.'><img alt="'.esc_attr($name).'" src="' . SALIENT_CORE_PLUGIN_PATH . '/includes/img/team-member-default.jpg" title="' . esc_attr($name) . '" /></a>';
        } else {
          $html .= '<img alt="'.esc_attr($name).'" src="' . SALIENT_CORE_PLUGIN_PATH . '/includes/img/team-member-default.jpg" title="' . esc_attr($name) . '" />';
        }
        
      }
      
      // Name link.
      if($link_element === 'name' || $link_element === 'both'){
        $html .= '<h4 class="light"><a class="'.strtolower($color).'" href="'.esc_url($link_url).'" '.$link_new_tab_markup.'>' . wp_kses_post($name) . '</a></h4>';
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
          
          if( isset($social_arr[$i + 1]) ) {	
            $target        = null;
            $url_host      = parse_url($social_arr[$i + 1], PHP_URL_HOST);
            $base_url_host = parse_url(get_template_directory_uri(), PHP_URL_HOST);
            
            if( $url_host != $base_url_host || empty($url_host) ) {
              $target = 'target="_blank"';
            }
            
            $html .=  "<li><a ".$target." href='" . esc_url($social_arr[$i + 1]) . "'>" . $social_arr[$i] . "</a></li>";   
          }
          
        }
        
        $html .= '</ul>'; 
        
      }
      
    }
    
    $html .= '</div>';
  
  } // not fullscreen bio
  
  echo str_replace("\r\n", '', $html);
  
  ?>