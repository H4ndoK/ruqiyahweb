<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


$nectar_lottie_params = array(

    array(
        "type" => "nectar_lottie",
        "heading" =>  esc_html__("Lottie JSON file", "salient-core"),
        "param_name" => "json_url",
        "description" => esc_html__('Enter the URL for your Lottie JSON file. When specifying an external JSON file, ensure to only use trusted sources.', 'salient'),
    ),

    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        "heading" => esc_html__("Trigger Type", "salient-core"),
        "param_name" => "trigger_type",
        "admin_label" => true,
        "value" => array(
            esc_html__("Autoplay", 'salient-core') => "autoplay",
            esc_html__("Play When Visible", 'salient-core') => "play",
            esc_html__("Scroll Position Seek", 'salient-core') => "seek",
            esc_html__("Hover", 'salient-core') => "hover",
        ),
        "description" => '',
        'std' => 'play',
    ),

    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        "heading" => esc_html__("Hover Functionality", "salient-core"),
        "param_name" => "hover_func",
        "value" => array(
            esc_html__("Play Full Animation When Hovered", 'salient-core') => "hover",
            esc_html__("Play While Hovering / Reverse On Leave", 'salient-core') => "hold",
        ),
        'dependency' => array(
            'element' => 'trigger_type',
            'value' => array('hover')
        ),
        "description" => '',
        'std' => 'hover',
    ),

    
    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        "heading" => esc_html__("Mobile Functionality", "salient-core"),
        "param_name" => "mobile_func",
        "value" => array(
            esc_html__("Play Animation", 'salient-core') => "default",
            esc_html__("Freeze Last Frame", 'salient-core') => "last_frame",
            esc_html__("Remove Lottie Element", 'salient-core') => "remove",
        ),
        'dependency' => array(
            'element' => 'trigger_type',
            'value' => array('autoplay', 'play')
        ),
        'edit_field_class' => 'nectar-one-half nectar-one-half-last',
        "description" => '',
        'std' => 'default',
    ),

    array(
        "type" => 'checkbox',
        'dependency' => array(
            'element' => 'trigger_type',
            'value' => array('autoplay', 'play')
        ),
        "heading" => esc_html__("Loop Animation", "salient-core"),
        "param_name" => "loop",
        'edit_field_class' => 'vc_col-xs-12 nectar-one-half salient-fancy-checkbox',
        "description" => '',
        "value" => array(esc_html__("Yes, please", "salient-core") => 'true'),
    ),


    array(
        'type' => 'nectar_multi_range_slider',
        'heading' => esc_html__('Viewport Trigger Offset', 'salient-core'),
        'param_name' => 'trigger_offset',
        'value' => '0,100',
        'options' => array(
            'min' => '0',
            'max' => '100',
        ),
        'dependency' => array(
            'element' => 'trigger_type',
            'value' => array('seek', 'play')
        ),
        'description' => esc_html__('Set the percentage of the viewport that the animation will trigger and end at.', 'salient-core'),
    ),

    array(
        'type' => 'nectar_multi_range_slider',
        'heading' => esc_html__('Animation Start/End Frames', 'salient-core'),
        'param_name' => 'frame_constraint',
        'value' => '0,100',
        'options' => array(
            'min' => '0',
            'max' => '100',
        ),
        'dependency' => array(
            'element' => 'trigger_type',
            'value' => array('autoplay', 'seek', 'play')
        ),
        'description' => esc_html__('If you would like to limit the frames used in the animation, you can specify a constraint here.', 'salient-core'),
    ),


    array(
        'type' => 'nectar_range_slider',
        'heading' => esc_html__('Animation Speed', 'salient-core'),
        'param_name' => 'speed',
        'value' => '1',
        'options' => array(
            'min' => '0',
            'max' => '4',
            'step' => '0.1',
            'suffix' => 'x'
        ),
        'dependency' => array(
            'element' => 'trigger_type',
            'value' => array('autoplay', 'play', 'hover')
        ),
        'description' => ''
    ),

    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Animation Delay', 'salient-core' ),
        'param_name' => 'trigger_delay',
        'dependency' => array(
            'element' => 'trigger_type',
            'value' => array('autoplay', 'play')
        ),
        'description' => esc_html__( 'Enter delay in milliseconds to wait before starting the animation. e.g. 150.', 'salient-core' )
    ),


    array(
        "type" => "nectar_numerical",
        "class" => "",
        "heading" => '<span class="group-title">' . esc_html__("Dimensions", "salient-core") . "</span><span class='attr-title'>" . esc_html__("Width", "salient-core") . "</span>",
        "value" => "",
        "placeholder" => esc_html__("Width", 'salient-core'),
        "edit_field_class" => "col-md-6 desktop lottie-dimensions-device-group zero-floor",
        "param_name" => "width_desktop",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Height", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Height", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "col-md-6 nectar-one-half-last desktop lottie-dimensions-device-group zero-floor",
        "param_name" => "height_desktop",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Width", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Width", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "col-md-6 tablet lottie-dimensions-device-group zero-floor",
        "param_name" => "width_tablet",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Height", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Height", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "col-md-6 nectar-one-half-last tablet lottie-dimensions-device-group zero-floor",
        "param_name" => "height_tablet",
        "description" => ""
    ),
    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Width", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Width", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "col-md-6 phone lottie-dimensions-device-group zero-floor",
        "param_name" => "width_phone",
        "description" => ""
    ),

    array(
        "type" => "nectar_numerical",
        "class" => "",
        "placeholder" => esc_html__("Height", 'salient-core'),
        "heading" => "<span class='attr-title'>" . esc_html__("Height", "salient-core") . "</span>",
        "value" => "",
        "edit_field_class" => "col-md-6 nectar-one-half-last phone lottie-dimensions-device-group zero-floor",
        "param_name" => "height_phone",
        "description" => ""
    ),
    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        "heading" => esc_html__("Alignment", "salient-core"),
        "param_name" => "alignment",
        "value" => array(
            esc_html__("Left", 'salient-core') => "left",
            esc_html__("Center", 'salient-core') => "center",
            esc_html__("Right", 'salient-core') => "right",
        ),
        "description" => '',
        'std' => 'center',
    ),

    array(
        "type" => "dropdown",
        "class" => "",
        'save_always' => true,
        "heading" => esc_html__("Preserve Aspect Ratio", "salient-core"),
        "param_name" => "preserve_aspect_ratio",
        "value" => array(
            esc_html__("Yes (xMidYmid meet)", 'salient-core') => "xMidYMid meet",
            esc_html__("None", 'salient-core') => "none",
        ),
        "description" => '',
        'std' => 'xMidYMid meet',
    ),

    array(
        "type" => 'checkbox',
        "heading" => esc_html__("Enable Shadow", "salient-core"),
        "param_name" => "enable_shadow",
        'edit_field_class' => 'vc_col-xs-12 nectar-one-half salient-fancy-checkbox',
        "description" => '',
        "value" => array(esc_html__("Yes, please", "salient-core") => 'true'),
    ),

    array(
        'type' => 'nectar_box_shadow_generator',
        'heading' => esc_html__( 'Shadow', 'salient-core' ),
        'save_always' => true,
        'param_name' => 'custom_box_shadow',
        'dependency' => Array( 'element' => 'enable_shadow', 'not_empty' => true )
    ),

    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Custom CSS selector to render in', 'salient-core' ),
        'param_name' => 'attach_to_element',
        'description' => esc_html__("Optionally specify an ID or class name on your page to render this lottie element inside of.", 'salient-core')
    ),


    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'CSS Class Name', 'salient-core' ),
        'param_name' => 'class_name',
        'description' => ''
    ),

);


$position_group = SalientWPbakeryParamGroups::position_group(esc_html__('Positioning', 'salient-core'));
$css_animation_group = SalientWPbakeryParamGroups::css_animation_group(esc_html__('CSS Animation', 'salient-core'));

$imported_groups = array($position_group, $css_animation_group);

foreach ($imported_groups as $group) {

    foreach ($group as $option) {
        $nectar_lottie_params[] = $option;
    }
}

return array(
    "name" => esc_html__("Lottie Animation", "salient-core"),
    "base" => "nectar_lottie",
    "icon" => "icon-wpb-video-lightbox",
    "allowed_container_element" => 'vc_row',
    "weight" => '2',
    "category" => esc_html__('Content', 'salient-core'),
    "description" => esc_html__('Animated lottie element', 'salient-core'),
    "params" => $nectar_lottie_params
);
