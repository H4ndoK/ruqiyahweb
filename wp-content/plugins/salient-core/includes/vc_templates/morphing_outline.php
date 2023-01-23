<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-morphing-outline' );

$title = $el_class = $value = $label_value= $units = '';

extract(shortcode_atts(array(
'starting_color' => '#27CFC3',
'hover_color' => '#ffffff',
'border_thickness' => '10',
), $atts));

?>

<div class="morphing-outline" data-starting-color="<?php echo esc_attr($starting_color); ?>" data-hover-color="<?php echo esc_attr($hover_color); ?>" data-border-thickness="<?php echo esc_attr($border_thickness); ?>">
  <div class="inner"><?php echo do_shortcode( wp_kses_post($content) ); ?></div>
</div>
