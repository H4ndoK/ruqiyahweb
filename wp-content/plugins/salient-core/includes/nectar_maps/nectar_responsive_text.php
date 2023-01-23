<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$responsive_text_params = array(

    array(
        "type" => "textarea_html",
        "heading" => esc_html__("Text", "salient-core"),
        "param_name" => "content",
        "admin_label" => true,
        "description" => ''
    ),

);


$font_size_group = SalientWPbakeryParamGroups::font_sizing_group();
$imported_groups = array($font_size_group);

foreach ($imported_groups as $group) {

    foreach ($group as $option) {
        $responsive_text_params[] = $option;
    }
}


$responsive_text_params[] = array(
    "type" => "colorpicker",
    "class" => "",
    "heading" => "Text Color",
    "param_name" => "text_color",
    "value" => "",
    "description" => esc_html__("Defaults to light or dark based on the current row text color.", "salient-core")
);
$responsive_text_params[] = array(
    "type" => "textfield",
    "heading" => esc_html__("Max Width", "salient-core"),
    "param_name" => "max_width",
    "admin_label" => false,
    "description" => esc_html__("Optionally enter your desired max width.", "salient-core")
);
$responsive_text_params[] = array(
    "type" => "textfield",
    "heading" => esc_html__("Link URL", "salient-core"),
    "param_name" => "link_href",
    "description" => esc_html__("The URL that will be used for the link", "salient-core")
);
$responsive_text_params[] = array(
    'type' => 'textfield',
    'heading' => esc_html__('CSS Class Name', 'salient-core'),
    'param_name' => 'class_name',
    'description' => ''
);

return array(
    "name" => esc_html__("Responsive Text", "salient-core"),
    "base" => "nectar_responsive_text",
    "icon" => "icon-wpb-split-line-heading",
    "allowed_container_element" => 'vc_row',
    "weight" => 8,
    "category" => esc_html__('Typography', 'salient-core'),
    "description" => esc_html__('Responsive text', 'salient-core'),
    "params" => $responsive_text_params,
);
