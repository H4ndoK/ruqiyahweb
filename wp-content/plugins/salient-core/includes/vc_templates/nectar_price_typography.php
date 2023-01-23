<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

extract(shortcode_atts(array(
    'price_text' => '',
    'before_text' => '',
    'after_text' => '',
    'font_style' => '',
    'text_color' => '',
    'after_text_scale' => '1',
    'before_text_scale' => '1',
), $atts));

$styles = '';

// Inherit Font Styling.
$classes = array('nectar-price-typography');
if (in_array($font_style, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'))) {
    $classes[] = 'nectar-inherit-' . $font_style;
}

// Dynamic Classes
if (function_exists('nectar_el_dynamic_classnames')) {
    $classes[] = nectar_el_dynamic_classnames('nectar_price_typography', $atts);
}

// Custom coloring.
if (!empty($text_color)) {
    $styles .= 'color: ' . $text_color . ';';
}

if (!empty($styles)) {
    $styles = ' style="' . $styles . '"';
}

echo '<div class="' . nectar_clean_classnames(implode(' ', $classes)) . '"' . $styles . '>';
if (!empty($before_text)) {
    $before_text_scale = !empty($before_text_scale) ? ' style="font-size: ' . $before_text_scale . 'em;"' : '';
    echo '<span class="before-text"' . $before_text_scale . '>' . esc_html($before_text) . '</span>';
}
if (!empty($price_text) || '0' === $price_text) {
    echo '<span class="price-text">' . esc_html($price_text) . '</span>';
}
if (!empty($after_text)) {
    $after_text_scale = !empty($after_text_scale) ? ' style="font-size: ' . $after_text_scale . 'em;"' : '';
    echo '<span class="after-text"' . $after_text_scale . '>' . esc_html($after_text) . '</span>';
}
echo '</div>';