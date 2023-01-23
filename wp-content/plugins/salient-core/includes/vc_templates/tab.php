<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$output = $title = $id = '';
extract(shortcode_atts($this->predefined_atts, $atts));


extract(shortcode_atts(array(
  'icon_family' => '',
  'icon_fontawesome' => '',
  'icon_linecons' => '',
  'icon_linea' => '',
  'icon_iconsmind' => '',
  'icon_steadysets' => '',
  'el_class' => '',
), $atts));


//icon
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
	case 'linecons':
		$icon = $icon_linecons;
		break;
	case 'iconsmind':
		$icon = $icon_iconsmind;
		break;
	default:
		$icon = '';
		break;
}

$nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;

// Check if iconsmind SVGs exist.
$svg_iconsmind = ( defined('NECTAR_THEME_DIRECTORY') && file_exists( NECTAR_THEME_DIRECTORY . '/css/fonts/svg-iconsmind/Aa.svg.php' ) ) ? true : false;

$icon_attr = ( $icon_family !== 'iconsmind' || $nectar_using_VC_front_end_editor || !$svg_iconsmind ) ? 'data-tab-icon="'.$icon.'"' : '';

$icon_markup = '';

if( $icon_family === 'iconsmind' && ! $nectar_using_VC_front_end_editor ) {
  
  // SVG iconsmind.
  $icon_id        = 'nectar-iconsmind-icon-'.uniqid();
  $icon_markup    = '<span class="im-icon-wrap tab-icon"><span>';
  $converted_icon = str_replace('iconsmind-', '', $icon);

  require_once( SALIENT_CORE_ROOT_DIR_PATH.'includes/icons/class-nectar-icon.php' );

  $nectar_icon_class = new Nectar_Icon(array(
  'icon_name' => $converted_icon,
  'icon_library' => 'iconsmind',
  ));

  $icon_markup .= $nectar_icon_class->render_icon();
  

  $icon_markup .= '</span></span>';
} else if( $icon_family === 'iconsmind' ) {
  wp_enqueue_style( 'iconsmind-core' );
} else if( $icon_family === 'linea' ) {
	wp_enqueue_style('linea'); 
}

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide clearfix', $this->settings['base'], $atts);
if( !empty($el_class) ) {
	$css_class .= ' '. $el_class;
}

if( ! isset( $GLOBALS['nectar-tabbed-inner-wrap'] ) || ! defined( 'NECTAR_THEME_NAME' ) ) {
	$GLOBALS['nectar-tabbed-inner-wrap'] = false;
}

$inner_wrap = '';
$inner_wrap_close = '';

if( $GLOBALS['nectar-tabbed-inner-wrap'] == true ) {
	$inner_wrap = '<div class="inner-wrap"><div class="inner">';
	$inner_wrap_close = '</div></div>';
}

$output .= "\n\t\t\t" . '<div id="tab-'. (empty($id) ? sanitize_title( $title ) : $id) .'" '.$icon_attr .' class="'.esc_attr($css_class).'">' . $inner_wrap . $icon_markup;
$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content) . $inner_wrap_close;
$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');

echo $output;