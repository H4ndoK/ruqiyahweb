<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-animated-title' );

$text = $heading_tag = $color = '';
extract(shortcode_atts(array(
	'heading_tag' => 'h6',
	'text' => '',
	'color' => 'accent-color',
	'text_color' => '#ffffff',
	'style' => ''
), $atts));

$style_tag = ( !empty($text_color) ) ? 'style="color: '.esc_attr($text_color).';"' : null; ?>

<div class="nectar-animated-title" data-style="<?php echo esc_attr($style); ?>" data-color="<?php echo strtolower(esc_attr($color)); ?>">
	<div class="nectar-animated-title-outer">
		<div class="nectar-animated-title-inner">
			<div class="wrap"><?php echo '<'.esc_html($heading_tag).' '.$style_tag.'>'.wp_kses_post($text).'</'.esc_html($heading_tag).'>'; ?></div>
		</div>
	</div>
</div>