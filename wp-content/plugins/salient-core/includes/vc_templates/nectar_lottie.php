<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

extract(shortcode_atts(array(
    'json_url' => '',
    'trigger_type' => 'autoplay',
    'loop' => '',
    'trigger_offset' => '0, 1',
    'frame_constraint' => '0, 100',
    'speed' => '1',
    'preserve_aspect_ratio' => 'xMidYMid meet',
    'class_name' => '',
    'mobile_func' => 'default',
    'attach_to_element' => ''
), $atts));

// Forced defaults
if (!isset($atts['json_url'])) {
    $atts['json_url'] = SALIENT_CORE_PLUGIN_PATH ."/includes/img/lottie-default.json";
}

// Enqueue script.
wp_enqueue_script('nectar-lottie');

// style classes.
$el_classes = array('nectar-lottie-wrap');

// Custom class.
if( !empty($class_name) ) {
    $el_classes[] = $class_name;
}

$attrs_escaped = '';

// CSS animation.
$css_animation_atts = nectar_css_animation_atts($atts);
if( !empty($css_animation_atts['classes']) ) {
    $el_classes[] = $css_animation_atts['classes'];
}

// Custom Shadow.
$atts['box_shadow_method'] = 'filter'; 
$custom_shadow_markup = nectar_generate_shadow_css($atts);
if( !empty($custom_shadow_markup) ) {
    $attrs_escaped .= ' style="'.$custom_shadow_markup.'"';
}

if( function_exists('nectar_el_dynamic_classnames') ) {
	$el_classes[] = nectar_el_dynamic_classnames('nectar_lottie', $atts);
} else {
	$el_classes[] = '';
}

echo '<div class="'.nectar_clean_classnames(implode(' ',$el_classes)).'"'.$css_animation_atts['atts'].'>';
echo '<div class="nectar-lottie" data-lottie-settings="'.esc_attr(wp_json_encode($atts)).'"'.$attrs_escaped.'></div>';
echo '</div>';