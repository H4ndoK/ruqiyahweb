<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = $image = $style = $color_1 = $color_2 = $hotspot_icon  = $tooltip = $tooltip_shadow = $animation = '';

wp_enqueue_style( 'nectar-image-with-hotspots' );

extract(shortcode_atts(array(
	'image' => '',
	'style' => 'color_pulse',
	'color_1' => 'Accent-Color',
	'color_2' => 'light',
	'hotspot_icon' => 'plus_sign',
	'tooltip' => 'hover',
	'tooltip_shadow' => 'none',
	'animation' => '',
), $atts));

$GLOBALS['nectar-image_hotspot-icon']         = $hotspot_icon;
$GLOBALS['nectar-image_hotspot-count']        = 1;
$GLOBALS['nectar-image_hotspot-tooltip-func'] = $tooltip;

if( $style === 'color_pulse' ) {
	$color_attr = strtolower($color_1);
}
else {
	$color_attr = strtolower($color_2);
}

$image_el    = null;
$image_class = 'no-img';

if( !empty($image) ) {
	$image_class = null;
}

echo '<div class="nectar_image_with_hotspots '.$image_class.'" data-stlye="'.esc_attr($style).'" data-hotspot-icon="'.esc_attr($hotspot_icon).'" data-size="medium" data-color="'.esc_attr($color_attr).'" data-tooltip-func="'.esc_attr($tooltip).'" data-tooltip_shadow="'.esc_attr($tooltip_shadow).'" data-animation="'.esc_attr($animation).'">';

if( !empty($image) ) {
	if( !preg_match('/^\d+$/',$image) ){
		echo '<img src="'.esc_url($image).'" alt="'. esc_html__('Hotspot Image','salient-core') . '" />';
	} else {
		
		$image = apply_filters('wpml_object_id', $image, 'attachment', TRUE);
			
		echo wp_get_attachment_image($image, 'full');
	}  
}

echo do_shortcode($content);
echo '</div>';

?>