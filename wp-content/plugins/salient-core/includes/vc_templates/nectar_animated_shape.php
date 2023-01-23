<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"shape" => 'circle',
    "shape_color" => '#000',
    'class_name' => '',
    'animation' => 'none',
    'animation_delay' => '',
    'animation_offset' => '',
    'animation_disable_mobile' => '',
    'animation_easing' => '',
    'animation_movement_type' => '',
    'animation_movement_intensity' => '',
    'animation_movement_persist_on_mobile' => ''
), $atts));


$el_classes = array('nectar-animated-shape');
$el_classes_inner_wrap = array('nectar-animated-shape__inner_wrap');
$el_classes_inner = array('nectar-animated-shape__inner');

$inner_attributes = '';
$attributes = '';


if( function_exists('nectar_el_dynamic_classnames') ) {
	$el_classes[] = nectar_el_dynamic_classnames('nectar_animated_shape', $atts);
} 

if( !empty($class_name) ) {
    $el_classes[] = $class_name;
}


// Animations.
if( $animation !== 'none' ) {
    $el_classes_inner_wrap[] = 'nectar-waypoint-el';
}
if( !empty($animation_delay) ) {
    $attributes .= ' data-nectar-waypoint-el-delay="'.esc_attr($animation_delay).'"';
}
if( !empty($animation_offset) ) {
    $attributes .= ' data-nectar-waypoint-el-offset="'.esc_attr($animation_offset).'"';
}
if( !empty($animation_easing) ) {
    $attributes .= ' data-easing="'.esc_attr($animation_easing).'"';
}
if( !empty($animation) ) {
    $attributes .= ' data-animation="'.esc_attr($animation).'"';
}
if( !empty($atts['animation_disable_mobile']) && 'true' === $atts['animation_disable_mobile'] ) {
    $el_classes_inner_wrap[] = 'nectar-disable-mobile-animation';
}
if( !empty($animation_movement_intensity) ) {
    $el_classes_inner[] = 'nectar-el-parallax-scroll';
    $inner_attributes .= 'data-scroll-animation="true" data-scroll-animation-movement="'.esc_attr($animation_movement_type).'" data-scroll-animation-mobile="'.esc_attr($animation_movement_persist_on_mobile).'" data-scroll-animation-intensity="'.esc_attr(strtolower($animation_movement_intensity)).'" ';
}

// Shapes
$svg_output = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100" preserveAspectRatio="xMidYMid meet" style="width: 100%; height: 100%;">';
if( 'circle' === $shape ) {
    $svg_output .= '<circle cx="50" cy="50" r="50" fill="'.$shape_color.'" />';
} 
else if( 'triangle' === $shape ) {
    $svg_output .= '<polygon points="50 0, 0 100, 100 100" fill="'.$shape_color.'" />';
}
else if( 'parallelogram' === $shape ) {
    $svg_output .= '<polygon points="25 0, 100 0, 75 100, 0 100" fill="'.$shape_color.'" />';
}
$svg_output .= '</svg>';


// Output.
echo '<div class="'.nectar_clean_classnames(implode(' ',$el_classes)).'">';
echo '<div class="'.nectar_clean_classnames(implode(' ',$el_classes_inner_wrap)).'"'.$attributes.'>';
echo '<div class="'.nectar_clean_classnames(implode(' ',$el_classes_inner)).'"'.$inner_attributes.'>'.$svg_output.'</div>';
echo '</div>';
echo '</div>';

