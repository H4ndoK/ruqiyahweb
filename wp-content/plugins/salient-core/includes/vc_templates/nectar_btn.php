<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"size" => 'small', 
	"url" => '#', 
	'button_style' => '', 
	'button_color_2' => '', 
	'button_color' => '', 
	'color_override' => '', 
	'solid_text_color_override' => '', 
	'hover_color_override' => '', 
	'hover_text_color_override' => '#fff', 
	"text" => 'Button Text', 
	'icon_family' => '', 
	'icon_fontawesome' => '', 
	'icon_linecons' => '', 
	'icon_iconsmind' => '', 
	'icon_steadysets' => '', 
	'open_new_tab' => '0', 
	'margin_top' => '',
	'margin_right' => '',
	'margin_bottom' => '', 
	'margin_left' => '', 
	'css_animation' => '', 
	'el_class' => '', 
	'nofollow' => '',
	'button_id' => ''), $atts));


global $nectar_options;

$theme_skin = ( !empty($nectar_options['theme-skin']) ) ? $nectar_options['theme-skin'] : 'material';
if( class_exists('NectarThemeManager') ) {
	$theme_skin = NectarThemeManager::$skin;
}

$target = ($open_new_tab == 'true') ? 'target="_blank"' : null;
	
	// Icon.
	switch($icon_family) {
		case 'fontawesome':
			$icon = $icon_fontawesome;
      wp_enqueue_style( 'font-awesome' );
			break;
		case 'steadysets':
			$icon = $icon_steadysets;
			break;
		case 'linecons':
			$icon = $icon_linecons;
			wp_enqueue_style( 'vc_linecons' );
			break;
		case 'iconsmind':
			$icon = $icon_iconsmind;
			break;
		case 'default_arrow':
			$icon = 'icon-button-arrow';
			break;
		default:
			$icon = '';
			break;
	}
	
	
	$starting_custom_icon_color    = '';
	$im_starting_custom_icon_color = null;
	
	if( !empty($solid_text_color_override) && $button_style === 'regular' || !empty($solid_text_color_override) && $button_style === 'regular-tilt' ) {
		$starting_custom_icon_color    = 'style="color: '.$solid_text_color_override.';" ';
		$im_starting_custom_icon_color = $solid_text_color_override;
	}
	
	$color = ($button_style === 'regular' || $button_style === 'see-through') ? $button_color_2 : $button_color;
	
	if( !empty($icon_family) && $icon_family !== 'none' ) {
		
		if( $icon_family === 'iconsmind' ) {
			
			// SVG iconsmind.
			$icon_id = 'nectar-iconsmind-icon-'.uniqid();
			
			$button_icon_escaped = '<i><span class="im-icon-wrap"><span>';
			
			$converted_icon = str_replace('iconsmind-', '', $icon);
			$converted_icon = str_replace(".", "", $converted_icon);
			
			require_once( SALIENT_CORE_ROOT_DIR_PATH.'includes/icons/class-nectar-icon.php' );

			$nectar_icon_class = new Nectar_Icon(array(
			'icon_name' => $converted_icon,
			'icon_library' => 'iconsmind',
			));
		
			$button_icon_escaped .= $nectar_icon_class->render_icon();

			$button_icon_escaped .= '</span></span></i>';
			$has_icon     = ' has-icon'; 
			
		} else {
			
			$button_icon_escaped = '<i '.$starting_custom_icon_color.' class="' . esc_attr($icon) .'"></i>'; 
			$has_icon = ' has-icon'; 
		}
		
	} 
	else {
		$button_icon_escaped = null; 
		$has_icon = null;
	}

	
	$stnd_button = $this->getCSSAnimation( $css_animation );
	
	$custom_colors = apply_filters('nectar_additional_theme_colors', array());
	if( $custom_colors && !empty($custom_colors) ) {
		$custom_colors = array_flip($custom_colors);
	}

	if( strtolower($color) === 'accent-color' || 
		strtolower($color) === 'extra-color-1' || 
		strtolower($color) === 'extra-color-2' || 
		strtolower($color) === 'extra-color-3' || 
		isset($custom_colors[strtolower($color)])) {

		if( $button_style !== 'see-through' )	{
			$stnd_button = " " . $this->getCSSAnimation( $css_animation ) . " regular-button";
		}
	}

	if( !empty($el_class) ) {
		$stnd_button .= ' ' . $el_class;
	}
	
	if( !empty($button_id) ) {
		$button_ID_markup = 'id="' . esc_attr($button_id) .'"';
	} else {
		$button_ID_markup = null;
	}
	
	$button_open_tag_escaped = '';

	if( $button_style === 'regular-tilt' ) {
		$color = $color . ' tilt';
		$button_open_tag_escaped = '<div class="tilt-button-wrap"> <div class="tilt-button-inner">';
	}

	
	// Stop regular grad class for material skin. 
	$headerFormat = (!empty($nectar_options['header_format'])) ? $nectar_options['header_format'] : 'default';
	if( $headerFormat === 'centered-menu-bottom-bar' ) {
		$theme_skin = 'material';
	}
	
	if( $theme_skin === 'material' && $color === 'extra-color-gradient-1' ) {
		$color = 'm-extra-color-gradient-1';
	} 
	else if( $theme_skin === 'material' && $color === 'extra-color-gradient-2') {
		$color = 'm-extra-color-gradient-2';
	} 
	
	if( $color === 'extra-color-gradient-1' && 
		$button_style === 'see-through' || 
		$color === 'extra-color-gradient-2' && 
		$button_style === 'see-through') {
		$style_color = ' '. $button_style . '-'. strtolower($color);
	}
	else {
		$style_color = ' '. $button_style . ' '. strtolower($color);
	}

	// Margins.
	$margins = '';
	if( !empty($margin_top)) {
		$margins .= 'margin-top: '.intval($margin_top).'px; ';
	}
	if( !empty($margin_right)) {
		$margins .= 'margin-right: '.intval($margin_right).'px; ';
	}
	if( !empty($margin_bottom)) {
		$margins .= 'margin-bottom: '.intval($margin_bottom).'px; ';
	}
	if( !empty($margin_left)) {
		$margins .= 'margin-left: '.intval($margin_left).'px;';
	}
	
	// Custom Coloring.
	$starting_custom_color = '';
	if(!empty($solid_text_color_override) && $button_style === 'regular' || !empty($solid_text_color_override) && $button_style === 'regular-tilt') {
		$starting_custom_color = 'color: '.$solid_text_color_override.'; ';
	}
	
	if(!empty($color_override)) {
		$color_or = 'data-color-override="'. $color_override.'" ';	
		
		if($button_style === 'see-through' || $button_style === 'see-through-2') {
			$starting_custom_color .= 'border-color: '.esc_attr($color_override).'; color: '.esc_attr($color_override).';';
		} 
		else if($button_style === 'see-through-3') {
			$starting_custom_color .= 'border-color: '.esc_attr($color_override).';';
		} else {
			$starting_custom_color .= 'background-color: '.esc_attr($color_override).';';
		}

	} else {
		$color_or = 'data-color-override="false" ';	
	}
	
	// Nofollow
	$nofollow_attr = '';
	if(!empty($nofollow) && 'true' === $nofollow) {
		$nofollow_attr = ' rel="nofollow noopener"';
	}
	
	// Opening tag.	
	$button_open_tag_escaped .= '<a class="nectar-button '. esc_attr($size) . esc_attr($style_color) . esc_attr($has_icon) . esc_attr($stnd_button).'" '.$button_ID_markup . $nofollow_attr.' style="'. $margins . $starting_custom_color.'" '. $target;
	
	$hover_color_override      = (!empty($hover_color_override)) ? ' data-hover-color-override="'. esc_attr($hover_color_override) .'"' : 'data-hover-color-override="false"';
	$hover_text_color_override = (!empty($hover_text_color_override)) ? ' data-hover-text-color-override="'. esc_attr($hover_text_color_override) .'"' :  null;	
	$button_close_tag          = null;

	if( strtolower($color) === 'accent-color tilt' || 
		strtolower($color) === 'extra-color-1 tilt' || 
		strtolower($color) === 'extra-color-2 tilt' || 
		strtolower($color) === 'extra-color-3 tilt') {
		$button_close_tag = '</div></div>';
	}
	
	// Regular Button Markup
	if( $button_style !== 'see-through-3d' ) {
		
		echo $button_open_tag_escaped . ' href="' . esc_attr($url) . '" '.$color_or.$hover_color_override.$hover_text_color_override.'>';
		
		if( $color === 'extra-color-gradient-1' || $color === 'extra-color-gradient-2' ) {
			echo '<span class="start loading">' . wp_kses_post($text) . $button_icon_escaped. '</span><span class="hover">' . wp_kses_post($text) . $button_icon_escaped. '</span></a>'. $button_close_tag;
		}
		else {
			echo '<span>' . wp_kses_post($text) . '</span>'. $button_icon_escaped . '</a>'. $button_close_tag;
		}
    	
	}
	
	// 3D Button Markup
	else {

		$color  = (!empty($color_override)) ? $color_override : '#ffffff';
		$border = ($size !== 'jumbo') ? 8 : 10;
		
		if( $size === 'extra_jumbo' ){
			 $border = 20;
		}
		
		echo '
		<div class="nectar-3d-transparent-button" '.$button_ID_markup . $nofollow_attr . ' style="'.$margins.'" data-size="'.esc_attr($size).'">
		  <a href="'. esc_attr($url) .'" '. $target.' class="'.esc_attr($el_class).'"><span class="hidden-text">'.wp_kses_post($text).'</span>
			<div class="inner-wrap">
				<div class="front-3d">
					<svg>
						<defs>
							<mask>
								<rect width="100%" height="100%" fill="#ffffff"></rect>
								<text class="mask-text button-text" fill="#000000" text-anchor="middle">'.wp_kses_post($text).'</text>
							</mask>
						</defs>
						<rect fill="'.esc_attr($color).'" width="100%" height="100%" ></rect>
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


?>