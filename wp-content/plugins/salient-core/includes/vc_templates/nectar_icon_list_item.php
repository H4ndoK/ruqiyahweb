<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"icon_type" => "numerical", 
	'icon_family' => 'fontawesome', 
	'icon_fontawesome' => '', 
	'icon_linea' => '', 
	'icon_iconsmind' => '', 
	'icon_steadysets' => '', 
	"header" => "", 
	"text_full_html" => 'simple',
	"text" => ""), $atts));

if( isset($_GET['vc_editable']) ) {
	$nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
	$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
} else {
	$nectar_using_VC_front_end_editor = false;
}

$icon_markup = null;

switch($icon_family) {
	case 'fontawesome':
		$icon = $icon_fontawesome;
    wp_enqueue_style( 'font-awesome' );
		break;
	case 'steadysets':
		$icon = $icon_steadysets;
		break;
	case 'linea':
		$icon = $icon_linea;
		break;
	case 'iconsmind':
		$icon = $icon_iconsmind;
		break;
	default:
		$icon = '';
		break;
}

if( $icon_family === 'linea' && $icon_type !== 'numerical' ) { 
	wp_enqueue_style('linea'); 
}

$icon_number = null;
$icon_color  = ($nectar_using_VC_front_end_editor) ? 'default' : esc_attr(strtolower($GLOBALS['nectar-list-item-icon-color']));

if( $icon_type === 'numerical' ) {
	$icon_number = ($nectar_using_VC_front_end_editor) ? '<span></span>' : '<span>'. esc_html($GLOBALS['nectar-list-item-count']) . '</span>';
}

if( !empty($icon) ) {
 	
	if( $icon_family === 'iconsmind' ) {
		
		// SVG iconsmind.
		$icon_id        = 'nectar-iconsmind-icon-'.uniqid();
		$icon_markup    = '<span class="im-icon-wrap" data-color="'.strtolower($icon_color) .'"><span>';
		$converted_icon = str_replace('iconsmind-', '', $icon);
		
    require_once( SALIENT_CORE_ROOT_DIR_PATH.'includes/icons/class-nectar-icon.php' );

    $nectar_icon_class = new Nectar_Icon(array(
    'icon_name' => $converted_icon,
    'icon_library' => 'iconsmind',
    ));
  
    $icon_markup .= $nectar_icon_class->render_icon();
		
		
		// Gradient.
		if( strtolower($icon_color) == 'extra-color-gradient-1' || strtolower($icon_color) == 'extra-color-gradient-2') {
				
				$nectar_options = get_nectar_theme_options();
				
				if( strtolower($icon_color) === 'extra-color-gradient-1' && isset($nectar_options["extra-color-gradient"]['from']) ) {
					
					$accent_gradient_from = $nectar_options["extra-color-gradient"]['from'];
					$accent_gradient_to   = $nectar_options["extra-color-gradient"]['to'];
					
				} else if( strtolower($icon_color) === 'extra-color-gradient-2' && isset($nectar_options["extra-color-gradient-2"]['from']) ) {
					
					$accent_gradient_from = $nectar_options["extra-color-gradient-2"]['from'];
					$accent_gradient_to   = $nectar_options["extra-color-gradient-2"]['to'];
					
				}
				
			  $icon_markup =  preg_replace('/(<svg\b[^><]*)>/i', '$1 fill="url(#'.$icon_id.')">', $icon_markup);
				
			  $icon_markup .= '<svg style="height:0;width:0;position:absolute;" aria-hidden="true" focusable="false">
				  <linearGradient id="'.$icon_id.'" x2="1" y2="1">
				    <stop offset="0%" stop-color="'.$accent_gradient_from.'" />
				    <stop offset="100%" stop-color="'.$accent_gradient_to.'" />
				  </linearGradient>
				</svg>';
		} 
		
		$icon_markup .= '</span></span>';
	} 
	
	else {
		
		$icon_markup = '<i class="icon-default-style '.$icon.'" data-color="'.$icon_color.'"></i>';
	}
	
	
}


$icon_output = ($icon_type === 'numerical') ? $icon_number : $icon_markup;

$text_markup = $text;
if( 'html' === $text_full_html ) {
	$text_markup = do_shortcode($content);
}

echo '<div class="nectar-icon-list-item"><div class="list-icon-holder" data-icon_type="'.esc_attr($icon_type).'">'.$icon_output.'</div><div class="content"><h4>'.wp_kses_post($header).'</h4>'.wp_kses_post($text_markup).'</div></div>';

if( !$nectar_using_VC_front_end_editor ) {
	$GLOBALS['nectar-list-item-count']++;
}

?>