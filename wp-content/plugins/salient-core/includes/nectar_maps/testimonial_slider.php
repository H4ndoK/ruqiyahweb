<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

$el_color_list = array(
  "Inherit (from row Text Color)" => "default",
  "Accent Color + Light Text" => "accent-color-light",
  "Extra Color 1 + Light Text" => "extra-color-1-light",
  "Extra Color 2 + Light Text" => "extra-color-2-light",
  "Extra Color 3 + Light Text" => "extra-color-3-light",
  "Accent Color + Dark Text" => "accent-color-dark",
  "Extra Color 1 + Dark Text" => "extra-color-1-dark",
  "Extra Color 2 + Dark Text" => "extra-color-2-dark",
  "Extra Color 3 + Dark Text" => "extra-color-3-dark"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
  "name"  => esc_html__("Testimonial Slider", "salient-core"),
  "base" => "testimonial_slider",
  "show_settings_on_create" => false,
  "is_container" => true,
  "icon" => "icon-wpb-testimonial-slider",
  "category" => esc_html__('Interactive', 'salient-core'),
  "description" => esc_html__('An appealing testmonial slider.', 'salient-core'),
  "params" => array(
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Style", "salient-core"),
      "param_name" => "style",
      "admin_label" => false,
      "value" => array(
        esc_html__("Basic (Default)", "salient-core") => "default",
        esc_html__("Minimal", "salient-core") => "minimal",
        esc_html__("Multiple Visible", "salient-core") => "multiple_visible",
        esc_html__("Multiple Visible Minimal", "salient-core") => "multiple_visible_minimal",
      ),
      'save_always' => true,
      "description" => esc_html__("Please select the style for your testimonial slider", "salient-core")
    ),
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Color", "salient-core"),
      "param_name" => "color",
      "admin_label" => false,
      "value" => $el_color_list,
      'save_always' => true,
      "dependency" => Array('element' => "style", 'value' => array('multiple_visible')),
      'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
    ),
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Star Rating Color", "salient-core"),
      "param_name" => "star_rating_color",
      "admin_label" => false,
      "value" => array(
				esc_html__( "Accent Color", "salient-core") => "accent-color",
				esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
				esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
				esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
				esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
				esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
      ),
      'save_always' => true,
      "dependency" => Array('element' => "style", 'value' => array('multiple_visible_minimal','minimal','default')),
      'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
    ),
    array(
      "type" => "checkbox",
      "class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "heading" => "Add Border To Testimonials",
      "value" => array("Yes, please" => "true" ),
      "param_name" => "add_border",
      "dependency" => Array('element' => "style", 'value' => array('multiple_visible_minimal')),
      "description" => esc_html__("This will add a slight border to your testimonials", "salient-core")
    ),
    array(
      "type" => "textfield",
      "heading" => esc_html__("Auto-Rotate", "salient-core"),
      "param_name" => "autorotate",
      "value" => '',
      "description" => esc_html__("If you would like this to autorotate, enter the rotation speed in milliseconds here. i.e 5000", "salient-core")
    ),
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Controls", "salient-core"),
      "param_name" => "slider_controls",
      "value" => array(
        esc_html__("Pagination",'salient-core') => "default",
        esc_html__("Next/Prev Arrows",'salient-core') => "next_prev_arrows",
      ),
      'save_always' => true,
      "dependency" => array('element' => "style", 'value' => array('multiple_visible','multiple_visible_minimal')),
      "description" => ''
  ),
    array(
      "type" => "checkbox",
      "class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "heading" => "Disable height animation",
      "value" => array("Yes, please" => "true" ),
      "param_name" => "disable_height_animation",
      "dependency" => Array('element' => "style", 'value' => array('default','minimal')),
      "description" => esc_html__("Your testimonial slider will animate the height of itself to match the height of the testimonial being shown - this will remove that and simply set the height equal to the tallest testimonial to allow your content below to remain stagnant instead of moving up/down.", "salient-core")
    ),
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Testimonial Border Radius", "salient-core"),
      'save_always' => true,
      "param_name" => "flickity_border_radius",
      "dependency" => Array('element' => "style", 'value' => array('multiple_visible','multiple_visible_minimal')),
      "value" => array(
        esc_html__("Default", "salient-core") => "default",
        esc_html__("0px", "salient-core") => "0px",
        esc_html__("3px", "salient-core") => "3px",
        esc_html__("5px", "salient-core") => "5px",
        esc_html__("10px", "salient-core") => "10px",
        esc_html__("15px", "salient-core") => "15px",
        esc_html__("20px", "salient-core") => "20px",
        esc_html__("50px", "salient-core") => "50px",
      ),
      "description" => ''
    ),
    array(
      "type" => "checkbox",
      "class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
      "heading" => "Add Shadow To Active Testimonial",
      "value" => array("Yes, please" => "true" ),
      "param_name" => "enable_shadow",
      "dependency" => Array('element' => "style", 'value' => array('multiple_visible')),
    ),
    array(
      'type' => 'nectar_box_shadow_generator',
      'heading' => esc_html__( 'Shadow', 'salient-core' ),
      'param_name' => 'custom_box_shadow',
      'save_always' => true,
      'dependency' => Array( 'element' => 'enable_shadow', 'not_empty' => true ) 
  ),
    array(
      "type" => "nectar_numerical",
      "class" => "",
      "heading" => esc_html__("Custom Testimonial Width Desktop", "salient-core"),
      "value" => "",
      "edit_field_class" => "vc_col-xs-12 zero-floor",
      "dependency" => Array('element' => "style", 'value' => array('multiple_visible','multiple_visible_minimal')),
      "param_name" => "custom_width_desktop",
      "description" => ""
  ),
    array(
			"type" => "textfield",
			"heading" => '<span class="group-title">' . esc_html__("Custom Font Size", "salient-core") . "</span>",
      "edit_field_class" => "desktop font-size-device-group",
			"param_name" => "font_size_desktop",
		),
    array(
			"type" => "textfield",
			"heading" => '',
      "edit_field_class" => "tablet font-size-device-group",
			"param_name" => "font_size_tablet",
		),
    array(
			"type" => "textfield",
			"heading" => '',
      		"edit_field_class" => "phone font-size-device-group",
			"param_name" => "font_size_phone",
		),
		array(
			"type" => "textfield",
			"heading" =>  esc_html__("Custom Line Height", "salient-core"),
			"param_name" => "font_line_height",
		),
  ),
  "custom_markup" => '
  <div class="wpb_tabs_holder wpb_holder vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>'
  ,
  'default_content' => '
  [testimonial title="'.esc_html__('Testimonial','salient-core').'" id="'.$tab_id_1.'"] Click the edit button to add your testimonial. [/testimonial]
  [testimonial title="'.esc_html__('Testimonial','salient-core').'" id="'.$tab_id_2.'"] Click the edit button to add your testimonial. [/testimonial]
  ',
  "js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
);

?>