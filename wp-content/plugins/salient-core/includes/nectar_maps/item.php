<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;


// Carousel Item
return array(
  "name" => esc_html__("Carousel Item", "salient-core"),
  "base" => "item",
  "allowed_container_element" => 'vc_row',
  "is_container" => true,
  "content_element" => false,
  "params" => array(
    array(
			"type" => "fws_image",
			"heading" => esc_html__("Item Background Image", "salient-core"),
			"param_name" => "simple_slider_bg_image_url",
      "edit_field_class" => "simple_slider_specific_field vc_col-xs-12",
			"value" => "",
			"description" => esc_html__("Select an image from the media library. Only will be used for carousel styles which support it (Simple Slider)", "salient-core")
		),
    array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Item Background Image Position", "salient-core" ),
      "param_name" => "simple_slider_bg_image_position",
      "edit_field_class" => "simple_slider_specific_field vc_col-xs-12",
      "value" => array(
         esc_html__("Default (Center Center)", "salient-core" ) => "default",
         esc_html__("Left Top", "salient-core" ) => "left-top",
         esc_html__("Left Center", "salient-core" ) => "left-center",
         esc_html__("Left Bottom", "salient-core" ) => "left-bottom",
         esc_html__("Center Top", "salient-core" ) => "center-top",
         esc_html__("Center Center", "salient-core" ) => "center-center",
         esc_html__("Center Bottom", "salient-core" ) => "center-bottom",
         esc_html__("Right Top", "salient-core" ) => "right-top",
         esc_html__("Right Center", "salient-core" ) => "right-center",
         esc_html__("Right Bottom", "salient-core" ) => "right-bottom"
      )
    ),
    array(
      "type" => "colorpicker",
      "class" => "",
      "heading" => esc_html__("Default Font Color", "salient-core"),
      "param_name" => "simple_slider_font_color",
      "value" => "",
      "edit_field_class" => "simple_slider_specific_field vc_col-xs-12",
      "description" => ""
    ),
    array(
      "type" => "checkbox",
      "class" => "",
      'edit_field_class' => 'simple_slider_specific_field vc_col-xs-12 salient-fancy-checkbox',
      "heading" => esc_html__("Enable Color Overlay Gradient", "salient-core"),
      "value" => array("Yes, please" => "true" ),
      "param_name" => "simple_slider_enable_gradient",
      "description" => ""
    ),
    array(
      "type" => "colorpicker",
      "class" => "",
      "heading" => esc_html__("Color Overlay", "salient-core"),
      "param_name" => "simple_slider_color_overlay",
      "value" => "",
      "edit_field_class" => "simple_slider_specific_field col-md-6",
      "description" => ""
    ),
    array(
      "type" => "colorpicker",
      "class" => "",
      "heading" => esc_html__("Color Overlay 2", "salient-core"),
      "param_name" => "simple_slider_color_overlay_2",
      "value" => "",
      "edit_field_class" => "simple_slider_specific_field col-md-6 col-md-6-last",
      "description" => "",
    ),
    array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => "Overlay Strength",
      "edit_field_class" => "simple_slider_specific_field vc_col-xs-12",
      "param_name" => "simple_slider_overlay_strength",
      "value" => array(
        esc_html__("Light", "salient-core") => "0.3",
        esc_html__("Medium", "salient-core") => "0.5",
        esc_html__("Heavy", "salient-core") => "0.8",
        esc_html__("Very Heavy", "salient-core") => "0.95",
        esc_html__("Solid", "salient-core") => '1'
      )
    ),
    array(
      "type" => "colorpicker",
      "class" => "",
      "heading" => esc_html__("Item Background Color", "salient-core"),
      "param_name" => "simple_slider_bg_color",
      "value" => "",
      "edit_field_class" => "simple_slider_specific_field vc_col-xs-12",
      "description" => ""
    ),

    array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Item Background Loading", "salient-core"),
      "param_name" => "simple_slider_bg_image_loading",
      "edit_field_class" => "simple_slider_specific_field vc_col-xs-12",
      "value" => array(
        "Default" => "default",
        "Skip Lazy Load" => "skip-lazy-load",
        "Lazy Load" => "lazy-load",
      ),
      "description" => esc_html__("Determine whether to load the image on page load or to use a lazy load method for higher performance.", "salient-core"),
      'std' => 'default',
    ),
    
    array(
      "type" => "checkbox",
      "class" => "",
      'edit_field_class' => 'flickity_specific_field vc_col-xs-12 salient-fancy-checkbox',
      "heading" => esc_html__("Remove Flickity Carousel Item on Mobile", "salient-core"),
      "value" => array("Yes, please" => "true" ),
      "param_name" => "flickity_hide_on_mobile",
      "description" => esc_html__("Enabling this will remove this carousel item when view on mobile devices (< 1000px screen width). Note: this only will take effect when using the Flickity carousel script.", 'salient-core')
    ),

    array(
      "type" => "nectar_numerical",
      'edit_field_class' => 'flickity_specific_field vc_col-xs-12',
			"heading" => esc_html__("Flickity Item Custom Desktop Width", "salient-core"),
			"param_name" => "flickity_custom_item_width",
			"admin_label" => false,
      "placeholder" => '',
			"description" => ''
		),

    array(
      "type" => "tab_id",
      "heading" => esc_html__("ID", "salient-core"),
      "param_name" => "id"
    )
  ),
  'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
);

?>
