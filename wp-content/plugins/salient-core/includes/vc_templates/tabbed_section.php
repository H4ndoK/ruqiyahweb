<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-tabbed-section' );

$output = $title = $interval = $el_class = '';
extract(shortcode_atts(array(
	'title' => '',
	'interval' => 0,
	'el_class' => '',
	'style' => 'default',
	'alignment' => 'left',
	'spacing' => '',
	'tab_color' => 'accent-color',
	'cta_button_text' => '',
	'cta_button_link' => '',
	'cta_button_style' => 'accent-color',
 	'full_width_line' => '',
	'icon_size' => '24',
	'tab_change_animation' => '',
	'vs_sticky_aspect' => 'default',
	'vs_navigation_width' => 'regular',
	'vs_navigation_spacing' => '15px',
	'vs_tab_spacing' => '10%',
	'vs_navigation_alignment' => 'left',
	'vs_navigation_width_2' => '25%',
	'vs_navigation_mobile_display' => 'visible',
	'vs_content_animation' => '',
	'vs_link_animation' => '',
	'vs_tab_tag' => 'p',
	'vs_text_content' => '',
	'vs_enable_cta' => '',
	'vs_cta_link' => '',
	'vs_cta_text' => '',
	'vs_cta_style' => '',
	'vs_cta_text_color' => '',
	'vs_cta_bg_color' => '',
	'vs_cta_padding_top' => '',
	'vs_cta_padding_bottom' => '',
	'vs_cta_padding_left' => '',
	'vs_cta_padding_right' => '',
	'vs_cta_heading_tag' => 'h6',
	'vs_navigation_func' => '',

), $atts));


$nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
$true_style = '';
$front_end_editor_classes = '';
$tabbed_li_classes = array('tab-item');

// Can't use vs on front-end editor.
if( $nectar_using_VC_front_end_editor && 'vertical_scrolling' === $style ) {

	$style = 'vertical_modern';
	$true_style = 'data-stored-style="vs"';

	if( $vs_sticky_aspect === 'content' ) {
		$true_style .= ' data-stored-style-aspect="content"';
		$true_style .= ' data-tab-align="'.esc_attr($vs_navigation_alignment).'" data-navigation-width="'.esc_attr($vs_navigation_width_2).'"';
		$front_end_editor_classes = '';
		$tabbed_li_classes[] = 'nectar-inherit-'.$vs_tab_tag.'';
		if( function_exists('nectar_el_dynamic_classnames') ) {
			$front_end_editor_classes = nectar_el_dynamic_classnames('tabbed_section', $atts);
		}
	} else {
		if( function_exists('nectar_el_dynamic_classnames') ) {
			$front_end_editor_classes = nectar_el_dynamic_classnames('vs_tabbed', $atts);
		}

		if( 'active_link_only' === $vs_navigation_func ) {

			$tabbed_li_classes[] = 'nectar-inherit-'.$vs_tab_tag.'';
      
			$true_style .= ' data-stored-style-aspect="active_link_only" data-navigation-width="'.esc_attr($vs_navigation_width).'"';
		}
	}

}

$el_class = $this->getExtraClass($el_class);

$element = 'wpb_tabs';

if ( 'vc_tour' === $this->shortcode) {
  $element = 'wpb_tour';
}

if( $style === 'default' || $style === 'vertical' ) {
  $icon_size = '';
}



// Regular Tabbed
if( 'vertical_scrolling' !== $style ) {

	// Extract tab titles
	preg_match_all( '/tab [^]]+title="([^\"]+)"(\sid\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );

	$tab_titles = array();

	if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }

	$tabs_nav = '';
	$tabs_nav .= '<ul class="wpb_tabs_nav ui-tabs-nav clearfix">';
	$tab_index = 0;

	// Toggle button requires no more than two elements.
	if( $style === 'toggle_button' && count($tab_titles) > 2 ) {
		$style = 'default';
	}
	
	foreach ( $tab_titles as $tab ) {
	    
		preg_match('/title="([^\"]+)"(\sid\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );

	    if(isset($tab_matches[1][0])) {
			
			$active_class = '';

			if( $tab_index === 0 ) {
				$active_class = 'class="active-tab"';
				$tabbed_li_classes[] = 'active-tab';
			} else if( $tab_index === 1 ) {
				array_pop($tabbed_li_classes);
			}

	        $tabs_nav .= '<li class="'.implode(' ',$tabbed_li_classes).'"><a href="#tab-'. (isset($tab_matches[3][0]) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) .'" '.$active_class.'><span>' . $tab_matches[1][0] . '</span></a></li>';

	    }

		$tab_index++;

		if( $style === 'toggle_button' && $tab_index === 1) {
			$tabs_nav .= '<li class="toggle-button"><span class="toggle-button-inner nectar-color-'.strtolower($tab_color).' nectar-bg-'.strtolower($tab_color).'"><span class="circle"></span></span></li>';
		}

	}

	//cta button
	if(strlen($cta_button_text) >= 1) {
	     $tabs_nav .= '<li class="cta-button"><a class="nectar-button medium regular-button '.esc_attr($cta_button_style).'" data-color-override="false" href="'.esc_url($cta_button_link).'">' . wp_kses_post($cta_button_text) . '</a></li>';
	}

	$tabs_nav .= '</ul>'."\n";

	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim('wpb_content_element '.$el_class), $this->settings['base'], $atts);

	$output .= "\n\t".'<div class="'.$css_class.$front_end_editor_classes.'"'.$true_style.' data-interval="'.$interval.'">';
	$output .= "\n\t\t".'<div class="wpb_wrapper tabbed clearfix" data-style="'.esc_attr($style).'" data-animation="'.esc_attr($tab_change_animation).'" data-spacing="'.esc_attr($spacing).'" data-icon-size="'.esc_attr($icon_size).'" data-full-width-line="'.esc_attr($full_width_line).'" data-color-scheme="'.esc_attr(strtolower($tab_color)).'" data-alignment="'.esc_attr($alignment).'">';
	$output .= wpb_widget_title(array('title' => $title, 'extraclass' => $element.'_heading'));
	$output .= "\n\t\t\t".$tabs_nav;
	$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
	if ( 'vc_tour' == $this->shortcode) {
	    $output .= "\n\t\t\t" . '<div class="wpb_tour_next_prev_nav clearfix"> <span class="wpb_prev_slide"><a href="#prev" title="'.esc_html__('Previous slide', 'js_composer').'">'.esc_html__('Previous slide', 'salient-core').'</a></span> <span class="wpb_next_slide"><a href="#next" title="'.esc_html__('Next slide', 'salient-core').'">'.esc_html__('Next slide', 'salient-core').'</a></span></div>';
	}
	$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
	$output .= "\n\t".'</div> '.$this->endBlockComment($element);

}

// Vertical scrolling.
else {

	preg_match_all( '/\[tab[^]]+title="([^\"]+)"[^]]+/i', $content, $matches, PREG_OFFSET_CAPTURE );
	$tab_titles = array();

	if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }

	$opening_tag = null;
	$closing_tag = null;

	$acceptable_tags = array('p','h6','h5','h4','h3','h2');

	if( !empty($vs_tab_tag) && in_array($vs_tab_tag, $acceptable_tags) ) {
    	$link_animation_class = ( $vs_link_animation === 'underline' && $vs_sticky_aspect === 'content' ) ? ' nectar-link-underline' : '';
		$opening_tag = '<' . $vs_tab_tag . ' class="tab-nav-heading nectar-bg-pseudo-'.esc_attr(strtolower($tab_color)). $link_animation_class.'">';
		$closing_tag = '</' . $vs_tab_tag . '>';
	}

	$current_selected_item = '';
  $text_content = '';
	if( $vs_sticky_aspect == 'content' ) {
		$current_selected_item = '<div class="scrolling-tab-nav-current-item"></div>';

    if( !empty($vs_text_content) ) {
      $text_content = '<div class="tab-text-content">'.do_shortcode($vs_text_content).'</div>';
    }
    
	} 
  else {
    if( $vs_navigation_func == 'active_link_only' ) {
      $current_selected_item = '';

      $total_count = count($tab_titles);
      $total_list = '';
      for($i=1; $i<$total_count + 1; $i++) {
        $total_list .= '<span style="top: '.(($i-1) * 100).'%">'.$i.'</span>';
	  }
	  
	  $starting_tab_title = '';

	  preg_match('/title="([^\"]+)"(\sid\=\"([^\"]+)\"){0,1}/i', $tab_titles[0][0], $tab_title_match, PREG_OFFSET_CAPTURE );
      if (isset($tab_title_match[1][0]) && !empty($vs_tab_tag) && in_array($vs_tab_tag, $acceptable_tags) ) {
		$starting_tab_title = '<' . $vs_tab_tag . ' class="tab-nav-heading"><a href="#">' . $tab_title_match[1][0] . '</a></' . $vs_tab_tag . '>';
      }
      $current_selected_item .= '<div class="scrolling-tab-nav-total nectar-inherit-label"><span class="current"><span class="inner">'.$total_list.'</span></span><span class="sep">/</span><span class="total">'.$total_count.'</span></div>';
      $current_selected_item .= '<div class="scrolling-tab-nav-current-item">'.$starting_tab_title.'</div>';
    }
    
  }

	$vs_navigation_escaped = '<div class="scrolling-tab-nav"><div class="line"></div>'.$text_content.$current_selected_item.'<ul class="wpb_tabs_nav ui-tabs-nav" data-spacing="'.esc_attr($vs_navigation_spacing).'">';

  $tab_index = 0;
  
	foreach ( $tab_titles as $tab ) {

	    preg_match('/title="([^\"]+)"(\sid\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
			preg_match('/sub_desc="([^\"]+)"/i', $tab[0], $tab_sub_desc_matches, PREG_OFFSET_CAPTURE );

	    if(isset($tab_matches[1][0])) {

					$tab_qid = uniqid("tab_");
					$sub_desc = ( isset($tab_sub_desc_matches[1]) ) ? $tab_sub_desc_matches[1] : false;
          $active_class = ( $tab_index === 0 ) ? ' active-tab' : '';

	        $vs_navigation_escaped .= '<li class="menu-item'.$active_class.'"><div class="menu-content">';
					$vs_navigation_escaped .= $opening_tag.'<a class="skip-hash" href="#'. esc_attr( $tab_qid ) .'"><span>' . $tab_matches[1][0] . '</span></a>'.$closing_tag;

					if( $sub_desc ) {
						$vs_navigation_escaped .= '<a class="sub-desc skip-hash" href="#'. esc_attr( $tab_qid ) .'">' . $sub_desc[0] . '</a>';
					}

					$vs_navigation_escaped .= '</div></li>';

          $tab_index++;
	    }
	}

	$cta = '';
	if( 'true' === $vs_enable_cta ) {
		$cta = do_shortcode('[nectar_cta btn_style="'.esc_attr($vs_cta_style).'" heading_tag="'.esc_attr($vs_cta_heading_tag).'" text_color="'.esc_attr($vs_cta_text_color).'" button_color="'.esc_attr($vs_cta_bg_color).'" link_type="regular"  alignment="left" display="block" link_text="'.esc_attr($vs_cta_text).'" url="'.esc_attr($vs_cta_link).'" padding_top="'.esc_attr($vs_cta_padding_top).'" padding_bottom="'.esc_attr($vs_cta_padding_bottom).'" padding_left="'.esc_attr($vs_cta_padding_left).'" padding_right="'.esc_attr($vs_cta_padding_right).'"]');
	}

	$vs_navigation_escaped .= '</ul>'.$cta.'</div>';

	$extra_class = (!empty($el_class)) ? ' ' . $el_class : '';
	
	$scrolling_tab_content_classes = array('scrolling-tab-content');

	if( $vs_sticky_aspect == 'content' ) {

		// Dynamic style classes.
		$el_classes = '';
		if( function_exists('nectar_el_dynamic_classnames') ) {
			$el_classes = nectar_el_dynamic_classnames('tabbed_section', $atts);
		}
		
		$GLOBALS['nectar-tabbed-inner-wrap'] = true;
		$output .= '<div class="nectar-sticky-tabs'.$el_classes.esc_attr($extra_class).'" data-tab-align="'.esc_attr($vs_navigation_alignment).'" data-navigation-width="'.esc_attr($vs_navigation_width_2).'" data-nav-tag="'.esc_attr($vs_tab_tag).'" data-color-scheme="'.esc_attr(strtolower($tab_color)).'">';
	} 
	else {

    // Dynamic style classes.
		$el_classes = '';
		if( function_exists('nectar_el_dynamic_classnames') ) {
			$el_classes = nectar_el_dynamic_classnames('vs_tabbed', $atts);
		}

		$output .= '<div class="nectar-scrolling-tabs'.$el_classes.esc_attr($extra_class).'" data-m-display="'.esc_attr($vs_navigation_mobile_display).'" data-nav-tag="'.esc_attr($vs_tab_tag).'" data-tab-spacing="'.esc_attr($vs_tab_spacing).'" data-navigation-width="'.esc_attr($vs_navigation_width).'" data-color-scheme="'.esc_attr(strtolower($tab_color)).'">';
	}
	
	$output .= $vs_navigation_escaped;
	$output .= '<div class="'.implode( ' ', $scrolling_tab_content_classes ).'">' . wpb_js_remove_wpautop($content) . '</div>';
	$output .= '</div>';
}

echo $output;
