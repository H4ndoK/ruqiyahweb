<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-food-item' );

extract(shortcode_atts(array(
  "style" => "default", 
  "item_name" => '', 
  'item_name_heading_tag' => 'h4', 
  "item_price" => "", 
  'item_description' => '', 
  'class' => ''), $atts));

 ?>

<div class="nectar_food_menu_item <?php echo esc_attr($class); ?>" data-style="<?php echo esc_attr($style); ?>">
  <div class="inner">
    <div class="item_name"><?php echo '<'.esc_html($item_name_heading_tag).'>'.$item_name.'</'.esc_html($item_name_heading_tag).'>'; ?></div><div class="line_spacer"></div>
    <div class="item_price"><?php echo '<'.esc_html($item_name_heading_tag).'>'.$item_price.'</'.esc_html($item_name_heading_tag).'>'; ?></div>
  </div>
  <div class="item_description"><?php echo wp_kses_post($item_description); ?></div>
</div>
