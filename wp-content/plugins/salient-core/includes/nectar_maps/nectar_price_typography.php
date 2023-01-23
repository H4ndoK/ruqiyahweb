<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


$price_typography_params = array(
    array(
        "type" => "textfield",
        "heading" => esc_html__("Price Amount", "salient-core"),
        "param_name" => "price_text",
        "admin_label" => true
    ),

    array(
        "type" => "textfield",
        "heading" => esc_html__("Before Price Text", "salient-core"),
        "param_name" => "before_text",
        "edit_field_class" => "nectar-one-half",
        "description" => esc_html__('Text to display before your price e.g. a currency "$"', 'salient-core')
    ),

    array(
        'type' => 'nectar_range_slider',
        'heading' => esc_html__('Before Price Text Scale', 'salient-core'),
        'param_name' => 'before_text_scale',
        'value' => '1',
        "edit_field_class" => "nectar-one-half nectar-one-half-last",
        'options' => array(
            'min' => '0',
            'max' => '1',
            'step' => '0.1',
            'suffix' => 'x'
        ),
        'description' => ''
    ),

    array(
        "type" => "textfield",
        "heading" => esc_html__("After Price Text", "salient-core"),
        "param_name" => "after_text",
        "edit_field_class" => "nectar-one-half",
        "description" => esc_html__('Text to display before your price e.g. payment period "/month"', 'salient-core')
    ),

    array(
        'type' => 'nectar_range_slider',
        'heading' => esc_html__('After Price Text Scale', 'salient-core'),
        'param_name' => 'after_text_scale',
        'value' => '1',
        "edit_field_class" => "nectar-one-half nectar-one-half-last",
        'options' => array(
            'min' => '0',
            'max' => '1',
            'step' => '0.1',
            'suffix' => 'x'
        ),
        'description' => ''
    ),

    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        "heading" => "Text Font Style",
        "description" => esc_html__("Choose what element your text will inherit styling from", "salient-core"),
        "param_name" => "font_style",
        "value" => array(
            "Paragraph" => "p",
            "H1" => "h1",
            "H2" => "h2",
            "H3" => "h3",
            "H4" => "h4",
            "H5" => "h5",
            "H6" => "h6",
        )
    ),
    array(
        "type" => "colorpicker",
        "class" => "",
        "heading" => "Text Color",
        "param_name" => "text_color",
        "value" => "",
        "description" => esc_html__("Defaults to light or dark based on the current row text color.", "salient-core")
    ),
);

$font_size_group = SalientWPbakeryParamGroups::font_sizing_group();

$imported_groups = array($font_size_group);

foreach ($imported_groups as $group) {

    foreach ($group as $option) {
        $price_typography_params[] = $option;
    }
}

return array(
    "name" => esc_html__("Price Typography", "salient-core"),
    "base" => "nectar_price_typography",
    "icon" => "icon-wpb-pricing-table",
    "category" => esc_html__('Typography', 'salient-core'),
    "params" => $price_typography_params
);
