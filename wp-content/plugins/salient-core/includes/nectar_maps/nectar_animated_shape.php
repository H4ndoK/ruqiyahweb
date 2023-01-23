<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


$nectar_animated_shape_params = array(


    array(
        'type' => 'nectar_radio_html',
        'class' => '',
        'heading' => esc_html__('Shape', 'salient-core'),
        'param_name' => 'shape',
        'options' => array(
            '<div style="clip-path: circle(50% at 50% 50%)" class="nectar-shape"></div>' => 'circle',
            '<div style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%)" class="nectar-shape"></div>' => 'triangle',
            '<div style="clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%)" class="nectar-shape"></div>' => 'parallelogram'
        ),
        'description' => '',
        'std' => 'circle',
    ),

    array(
        "type" => "colorpicker",
        "class" => "",
        "heading" => esc_html__("Shape Color",'salient-core'),
        "param_name" => "shape_color",
        "value" => ""
    ),


    array(
        "type" => "nectar_numerical",
        "class" => "",
        "heading" => '<span class="group-title">' . esc_html__("Dimensions", "salient-core") . "</span><span class='attr-title'>" . esc_html__("Width", "salient-core") . "</span>",
        "value" => "",
        "placeholder" => esc_html__("Width", 'salient-core'),
        "edit_field_class" => "nectar-one-half desktop dimensions-device-group zero-floor",
        "param_name" => "width_desktop",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Height", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Height", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "nectar-one-half nectar-one-half-last desktop dimensions-device-group zero-floor",
        "param_name" => "height_desktop",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Width", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Width", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "nectar-one-half tablet dimensions-device-group zero-floor",
        "param_name" => "width_tablet",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Height", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Height", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "nectar-one-half nectar-one-half-last tablet dimensions-device-group zero-floor",
        "param_name" => "height_tablet",
        "description" => ""
    ),
    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Width", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Width", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "nectar-one-half phone dimensions-device-group zero-floor",
        "param_name" => "width_phone",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Height", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Height", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "nectar-one-half nectar-one-half-last phone dimensions-device-group zero-floor",
        "param_name" => "height_phone",
        "description" => ""
    ),
 
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'CSS Class Name', 'salient-core' ),
        'param_name' => 'class_name',
        'description' => ''
    ),



    array(
        'type' => 'nectar_group_header',
        'class' => '',
        'heading' => esc_html__( 'Entrance Animation', 'salient-core' ),
        'param_name' => 'group_header_1',
        "edit_field_class" => "first-field",
        'group' => esc_html__('Animation'),
        'value' => ''
    ),
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Animation', 'salient-core' ),
        'param_name' => 'animation',
        'group' => esc_html__('Animation'),
        'dependency' => Array( 'element' => 'animation_type', 'value' => 'entrance' ),
        'admin_label' => true,
        'value' => array(
            esc_html__( 'None', 'salient-core' ) => 'none',
            esc_html__( 'Grow In', 'salient-core' ) => 'grow-in',
        ),
        'save_always' => true,
        'description' => esc_html__( 'Select animation type if you want this element to be animated when it enters into the browsers viewport.', 'salient-core' )
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Animation Delay', 'salient-core' ),
        'param_name' => 'animation_delay',
        'group' => esc_html__('Animation'),
        'edit_field_class' => 'nectar-one-half',
        'description' => esc_html__( 'Enter delay (in milliseconds) if needed e.g. "150"', 'salient-core' )
    ),
    array(
        "type" => "textfield",
        "class" => "",
        "group" => "Animation",
        "edit_field_class" => "nectar-one-half nectar-one-half-last",
        "heading" => esc_html__("Animation Offset", "salient-core" ),
        "param_name" => "animation_offset",
        "admin_label" => false,
        "description" => esc_html__("Optionally specify the offset from the top of the screen for when the animation will trigger. Defaults to 95%.", "salient-core"),
    ),
    array(
        "type" => 'checkbox',
        'group' => esc_html__('Animation'),
        "heading" => esc_html__("Disable Animation on Mobile", "salient-core"),
        'group' => esc_html__('Animation'),
        "param_name" => "animation_disable_mobile",
        'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
        "description" => '',
        "value" => array(esc_html__("Yes, please", "salient-core") => 'true'),
    ),

    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        'group' => esc_html__('Animation'),
        "heading" => esc_html__("Animation Easing", "salient-core"),
        "param_name" => "animation_easing",
        "value" => array(
            "Inherit From Theme Options" => "default",
            'easeInQuad'=>'easeInQuad',
            'easeOutQuad' => 'easeOutQuad',
            'easeInOutQuad'=>'easeInOutQuad',
            'easeInCubic'=>'easeInCubic',
            'easeOutCubic'=>'easeOutCubic',
            'easeInOutCubic'=>'easeInOutCubic',
            'easeInQuart'=>'easeInQuart',
            'easeOutQuart'=>'easeOutQuart',
            'easeInOutQuart'=>'easeInOutQuart',
            'easeInQuint'=>'easeInQuint',
            'easeOutQuint'=>'easeOutQuint',
            'easeInOutQuint'=>'easeInOutQuint',
            'easeInExpo'=>'easeInExpo',
            'easeOutExpo'=>'easeOutExpo',
            'easeInOutExpo'=>'easeInOutExpo',
            'easeInSine'=>'easeInSine',
            'easeOutSine'=>'easeOutSine',
            'easeInOutSine'=>'easeInOutSine',
            'easeInCirc'=>'easeInCirc',
            'easeOutCirc'=>'easeOutCirc',
            'easeInOutCirc'=>'easeInOutCirc'
        ),
    ),


    array(
        'type' => 'nectar_group_header',
        'class' => '',
        'heading' => esc_html__( 'Scroll Based Animation', 'salient-core' ),
        'param_name' => 'group_header_1',
        "edit_field_class" => "",
        'group' => esc_html__('Animation'),
        'value' => ''
    ),
    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        "heading" => esc_html__("Movement", "salient-core"),
        'group' => esc_html__('Animation'),
        'edit_field_class' => 'movement-type vc_col-xs-12',
        "param_name" => "animation_movement_type",
        "value" => array(
            esc_html__("Move Y Axis", "salient-core") => "transform_y",
            esc_html__("Move X Axis", "salient-core") => "transform_x",
        ),
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        'group' => esc_html__('Animation'),
        'edit_field_class' => 'movement-intensity vc_col-xs-12',
        "placeholder" => esc_html__("Movement Intensity ( -5 to 5 )",'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Movement Intensity", "salient-core") . "</span>",
        "value" => "",
        "param_name" => "animation_movement_intensity",
        "description" => '',
    ),

    array(
        "type" => "checkbox",
        "class" => "",
        "heading" => esc_html__("Persist Movement On Mobile", "salient-core"),
        "value" => array("Enable" => "true" ),
        "param_name" => "animation_movement_persist_on_mobile",
        'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
        "description" => '',
        'group' => esc_html__('Animation'),
    ),

);



$position_group = SalientWPbakeryParamGroups::position_group(esc_html__('Positioning', 'salient-core'));

$imported_groups = array($position_group);

foreach ($imported_groups as $group) {

    foreach ($group as $option) {
        $nectar_animated_shape_params[] = $option;
    }
}

return array(
    "name" => esc_html__("Animated Shape", "salient-core"),
    "base" => "nectar_animated_shape",
    "icon" => "icon-wpb-video-lightbox",
    "allowed_container_element" => 'vc_row',
    "weight" => '2',
    "category" => esc_html__('Content', 'salient-core'),
    "description" => esc_html__('Animated shape', 'salient-core'),
    "params" => $nectar_animated_shape_params
);
