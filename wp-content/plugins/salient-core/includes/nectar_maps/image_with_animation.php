<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$image_with_animation_params = array(
    array(
        'type' => 'fws_image',
        'heading' => esc_html__( 'Image', 'salient-core' ),
        'param_name' => 'image_url',
        'value' => '',
        'description' => esc_html__( 'Select image from media library.', 'salient-core' )
    ),

    array(
        'type' => 'dropdown',
        'class' => '',
        'save_always' => true,
        'admin_label' => true,
        'heading' => esc_html__( 'Image Size', 'salient-core' ),
        'param_name' => 'image_size',
        'value' => array(
            'Default (Full)' => 'full',
            'Small' => 'thumbnail',
            'Small Landscape' => 'portfolio-thumb',
            'Medium' => 'medium',
            'Medium Large' => 'medium_large',
            'Large' => 'large',
            'Landscape' => 'portfolio-thumb_large',
            'Large Square' => 'medium_featured',
            'Square' => 'regular',
            'Small Square' => 'regular_small',
            'Large Featured' => 'large_featured',
            'Custom' => 'custom'
        ),
        'description' => esc_html__( 'This option allows to you control what size image will load.', 'salient-core' ),
        'std' => 'full',
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Custom Image Size', 'salient-core' ),
        'param_name' => 'custom_image_size',
        'dependency' => Array( 'element' => 'image_size', 'value' => 'custom' ),
        'description' => esc_html__( 'Enter a custom WordPress image size name to use.', 'salient-core' )
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
        'heading' => esc_html__( 'Animation Type', 'salient-core' ),
        'param_name' => 'animation_type',
        'group' => esc_html__('Animation'),
        'value' => array(
            esc_html__( 'Triggered on Entrance', 'salient-core' ) => 'entrance',
            esc_html__( 'Looped Infinitely', 'salient-core' ) => 'looped',
        ),
        'save_always' => true,
        'description' => ''
    ),
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Animation', 'salient-core' ),
        'param_name' => 'animation',
        'group' => esc_html__('Animation'),
        'dependency' => Array( 'element' => 'animation_type', 'value' => 'entrance' ),
        'admin_label' => true,
        'value' => array(
            esc_html__( 'None', 'salient-core' ) => 'None',
            esc_html__( 'Fade In', 'salient-core' ) => 'Fade In',
            esc_html__( 'Fade In From Left', 'salient-core' ) => 'Fade In From Left',
            esc_html__( 'Fade In From Right', 'salient-core' ) => 'Fade In From Right',
            esc_html__( 'Fade In From Bottom', 'salient-core' ) => 'Fade In From Bottom',
            esc_html__( 'Grow In', 'salient-core' ) => 'Grow In',
            esc_html__( 'Slide Up', 'salient-core' ) => 'slide-up',
            esc_html__( 'Flip In Horizontal', 'salient-core' ) => 'Flip In',
            esc_html__( 'Flip In Vertical', 'salient-core' ) => 'flip-in-vertical',
            esc_html__( 'Reveal Rotate From Top', 'salient-core' ) => 'ro-reveal-from-top',
            esc_html__( 'Reveal Rotate From Bottom', 'salient-core' ) => 'ro-reveal-from-bottom',
            esc_html__( 'Reveal Rotate From Left', 'salient-core' ) => 'ro-reveal-from-left',
            esc_html__( 'Reveal Rotate From Right', 'salient-core' ) => 'ro-reveal-from-right',
        ),
        'save_always' => true,
        'description' => esc_html__( 'Select animation type if you want this element to be animated when it enters into the browsers viewport.', 'salient-core' )
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Animation Delay', 'salient-core' ),
        'param_name' => 'delay',
        'group' => esc_html__('Animation'),
        'dependency' => Array( 
            'element' => 'animation', 
            'value' => array( 
                'Fade In', 
                'Fade In From Left', 
                'Fade In From Right', 
                'Fade In From Bottom', 
                'slide-up', 
                'Grow In', 
                'Flip In', 
                'flip-in-vertical',
                'ro-reveal-from-top',
                'ro-reveal-from-bottom',
                'ro-reveal-from-left',
                'ro-reveal-from-right',
            ) 
        ),
        'edit_field_class' => 'nectar-one-half',
        'description' => esc_html__( 'Enter delay (in milliseconds) if needed e.g. "150"', 'salient-core' )
    ),
    array(
        "type" => 'checkbox',
        'group' => esc_html__('Animation'),
        'dependency' => Array( 
            'element' => 'animation', 
            'value' => array( 
                'Fade In', 
                'Fade In From Left', 
                'Fade In From Right', 
                'Fade In From Bottom', 
                'slide-up', 
                'Grow In', 
                'Flip In', 
                'flip-in-vertical',
                'ro-reveal-from-top',
                'ro-reveal-from-bottom',
                'ro-reveal-from-left',
                'ro-reveal-from-right',
            ) 
        ),
        "heading" => esc_html__("Disable Animation on Mobile", "salient-core"),
        'group' => esc_html__('Animation'),
        "param_name" => "disable_mobile_animation",
        'edit_field_class' => 'vc_col-xs-12 nectar-one-half salient-fancy-checkbox',
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
        'dependency' => Array( 
            'element' => 'animation', 
            'value' => array( 
                'Fade In', 
                'Fade In From Left', 
                'Fade In From Right', 
                'Fade In From Bottom', 
                'slide-up', 
                'Grow In', 
                'Flip In', 
                'flip-in-vertical',
                'ro-reveal-from-top',
                'ro-reveal-from-bottom',
                'ro-reveal-from-left',
                'ro-reveal-from-right',
            ) 
        ),
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
        'type' => 'dropdown',
        'group' => esc_html__('Animation'),
        'heading' => esc_html__( 'Looped Animation', 'salient-core' ),
        'param_name' => 'loop_animation',
        'dependency' => Array( 'element' => 'animation_type', 'value' => 'looped' ),
        'value' => array(
            esc_html__( 'None', 'salient-core' ) => 'none',
            esc_html__( 'Rotate', 'salient-core' ) => 'rotate',
        ),
        'save_always' => true,
        'description' => esc_html__( 'Select an optional animation that will occur infinitely in a loop.', 'salient-core' )
    ),

    array(
        'type' => 'nectar_group_header',
        'class' => '',
        'heading' => esc_html__( 'Scroll Based Animation', 'salient-core' ),
        'param_name' => 'group_header_6',
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
    

    array(
        'type' => 'nectar_group_header',
        'class' => '',
        'heading' => esc_html__( 'Hover Animation', 'salient-core' ),
        'param_name' => 'group_header_7',
        "edit_field_class" => "",
        'group' => esc_html__('Animation'),
        'value' => ''
    ),
    array(
        'type' => 'dropdown',
        'group' => esc_html__('Animation'),
        'heading' => esc_html__( 'Hover Animation', 'salient-core' ),
        'param_name' => 'hover_animation',
        'value' => array(
            esc_html__( 'None', 'salient-core' ) => 'none',
            esc_html__( 'Zoom In', 'salient-core' ) => 'zoom',
            esc_html__( 'Zoom In Crop', 'salient-core' ) => 'zoom-crop',
            esc_html__( 'Color Overlay', 'salient-core' ) => 'color-overlay',
        ),
        'save_always' => true,
        'description' => esc_html__( 'Select an optional animation that will occur when hovering over your image', 'salient-core' )
    ),
    array(
        'type' => 'colorpicker',
        'group' => esc_html__('Animation'),
        'class' => '',
        'heading' => esc_html__( 'Hover Overlay Color', 'salient-core' ),
        'param_name' => 'hover_overlay_color',
        'value' => '',
        'dependency' => Array( 'element' => 'hover_animation', 'value' => 'color-overlay' ),
        'description' => ''
    ),

    array(
        'type' => 'nectar_group_header',
        'class' => '',
        'heading' => esc_html__( 'Spacing & Alignment', 'salient-core' ),
        'param_name' => 'group_header_3',
        'edit_field_class' => '',
        'value' => ''
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => '<span class="group-title">' . esc_html__( 'Margin', 'salient-core' ) . "</span><span class='attr-title'>" . esc_html__( 'Top', 'salient-core' ) . '</span>',
        'param_name' => 'margin_top',
        'placeholder' => esc_html__( 'Top', 'salient-core' ),
        'edit_field_class' => 'col-md-2 desktop image-margin-device-group constrain_group_1',
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 1', 'salient-core' ),
        'param_name' => 'constrain_group_1',
        'description' => '',
        'edit_field_class' => 'desktop image-margin-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => "<span class='attr-title'>" . esc_html__( 'Bottom', 'salient-core' ) . '</span>',
        'param_name' => 'margin_bottom',
        'placeholder' => esc_html__( 'Bottom', 'salient-core' ),
        'edit_field_class' => 'col-md-2 desktop image-margin-device-group constrain_group_1',
        'description' => ''
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => "<span class='attr-title'>" . esc_html__( 'Left', 'salient-core' ) . '</span>',
        'param_name' => 'margin_left',
        'placeholder' => esc_html__( 'Left', 'salient-core' ),
        'edit_field_class' => 'col-md-2 col-md-2-last desktop image-margin-device-group constrain_group_2',
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 2', 'salient-core' ),
        'param_name' => 'constrain_group_2',
        'description' => '',
        'edit_field_class' => 'desktop image-margin-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => "<span class='attr-title'>" . esc_html__( 'Right', 'salient-core' ) . '</span>',
        'param_name' => 'margin_right',
        'placeholder' => esc_html__( 'Right', 'salient-core' ),
        'edit_field_class' => 'col-md-2 desktop image-margin-device-group constrain_group_2',
        'description' => ''
    ),

    array(
        'type' => 'nectar_numerical',
        'heading' => "<span class='attr-title'>" . esc_html__( 'Top', 'salient-core' ) . '</span>',
        'param_name' => 'margin_top_tablet',
        'placeholder' => esc_html__( 'Top', 'salient-core' ),
        'edit_field_class' => 'col-md-2 col-md-2-first tablet image-margin-device-group constrain_group_3',
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 3', 'salient-core' ),
        'param_name' => 'constrain_group_3',
        'description' => '',
        'edit_field_class' => 'tablet image-margin-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'placeholder' => esc_html__( 'Bottom', 'salient-core' ),
        'heading' => "<span class='attr-title'>" . esc_html__( 'Bottom', 'salient-core' ) . '</span>',
        'param_name' => 'margin_bottom_tablet',
        'edit_field_class' => 'col-md-2 tablet image-margin-device-group constrain_group_3',
        'description' => ''
    ),
    array(
        'type' => 'nectar_numerical',
        'placeholder' => esc_html__( 'Left', 'salient-core' ),
        'heading' => "<span class='attr-title'>" . esc_html__( 'Left', 'salient-core' ) . '</span>',
        'param_name' => 'margin_left_tablet',
        'edit_field_class' => 'col-md-2 col-md-2-last tablet image-margin-device-group constrain_group_4',
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 4', 'salient-core' ),
        'param_name' => 'constrain_group_4',
        'description' => '',
        'edit_field_class' => 'tablet image-margin-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'placeholder' => esc_html__( 'Right', 'salient-core' ),
        'heading' => "<span class='attr-title'>" . esc_html__( 'Right', 'salient-core' ) . '</span>',
        'param_name' => 'margin_right_tablet',
        'edit_field_class' => 'col-md-2 tablet image-margin-device-group constrain_group_4',
        'description' => ''
    ),

    array(
        'type' => 'nectar_numerical',
        'placeholder' => esc_html__( 'Top', 'salient-core' ),
        'heading' => "<span class='attr-title'>" . esc_html__( 'Top', 'salient-core' ) . '</span>',
        'param_name' => 'margin_top_phone',
        'edit_field_class' => 'col-md-2 col-md-2-first phone image-margin-device-group constrain_group_5',
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 5', 'salient-core' ),
        'param_name' => 'constrain_group_5',
        'description' => '',
        'edit_field_class' => 'phone image-margin-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'placeholder' => esc_html__( 'Bottom', 'salient-core' ),
        'heading' => "<span class='attr-title'>" . esc_html__( 'Bottom', 'salient-core' ) . '</span>',
        'param_name' => 'margin_bottom_phone',
        'edit_field_class' => 'col-md-2 phone image-margin-device-group constrain_group_5',
        'description' => ''
    ),
    array(
        'type' => 'nectar_numerical',
        'placeholder' => esc_html__( 'Left', 'salient-core' ),
        'heading' => "<span class='attr-title'>" . esc_html__( 'Left', 'salient-core' ) . '</span>',
        'param_name' => 'margin_left_phone',
        'edit_field_class' => 'col-md-2 col-md-2-last phone image-margin-device-group constrain_group_',
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 6', 'salient-core' ),
        'param_name' => 'constrain_group_6',
        'description' => '',
        'edit_field_class' => 'phone image-margin-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'placeholder' => esc_html__( 'Right', 'salient-core' ),
        'heading' => "<span class='attr-title'>" . esc_html__( 'Right', 'salient-core' ) . '</span>',
        'param_name' => 'margin_right_phone',
        'edit_field_class' => 'col-md-2 phone image-margin-device-group constrain_group_',
        'description' => ''
    ),

    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Image Alignment', 'salient-core' ),
        'save_always' => true,
        'param_name' => 'alignment',
        'value' => array( esc_html__( 'Align left', 'salient-core' ) => '', esc_html__( 'Align right', 'salient-core' ) => 'right', esc_html__( 'Align center', 'salient-core' ) => 'center' ),
        'description' => esc_html__( 'Select image alignment.', 'salient-core' )
    ),

    array(
        'type' => 'nectar_group_header',
        'class' => '',
        'heading' => esc_html__( 'Link', 'salient-core' ),
        'param_name' => 'group_header_2',
        'edit_field_class' => '',
        'value' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Link to large image?', 'salient-core' ),
        'param_name' => 'img_link_large',
        'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
        'description' => esc_html__( 'If selected, image will be linked to the bigger image.', 'salient-core' ),
        'value' => Array( esc_html__( 'Yes, please', 'salient-core' ) => 'yes' )
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Display Caption in Lightbox', 'salient-core' ),
        'param_name' => 'img_link_caption',
        'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
        'dependency' => Array( 'element' => 'img_link_large', 'not_empty' => true ),
        'value' => Array( esc_html__( 'Yes, please', 'salient-core' ) => 'yes' )
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Image link', 'salient-core' ),
        'param_name' => 'img_link',
        'description' => esc_html__( 'Enter url if you want this image to have link.', 'salient-core' ),
        'dependency' => Array( 'element' => 'img_link_large', 'is_empty' => true )
    ),
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Link Target', 'salient-core' ),
        'param_name' => 'img_link_target',
        'value' => array( 
            esc_html__( 'Same window', 'salient-core' ) => '_self', 
            esc_html__( 'New window', 'salient-core' ) => '_blank',
            esc_html__( 'Lightbox', 'salient-core' ) => 'lightbox',
        ),
        'description' => esc_html__( 'Note: only media links (images and videos) will be able to utilize the lightbox option.', 'salient-core' ),
        'dependency' => Array( 'element' => 'img_link_large', 'is_empty' => true )
    ),

    array(
        'type' => 'nectar_group_header',
        'class' => '',
        'heading' => esc_html__( 'Shadow & Rounded Edges', 'salient-core' ),
        'param_name' => 'group_header_4',
        'edit_field_class' => '',
        'value' => ''
    ),

    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Border Radius', 'salient-core' ),
        'save_always' => true,
        'param_name' => 'border_radius',
        'edit_field_class' => 'col-md-6',
        'value' => array(
            esc_html__( '0px', 'salient-core' ) => 'none',
            esc_html__( '3px', 'salient-core' ) => '3px',
            esc_html__( '5px', 'salient-core' ) => '5px',
            esc_html__( '10px', 'salient-core' ) => '10px',
            esc_html__( '15px', 'salient-core' ) => '15px',
            esc_html__( '20px', 'salient-core' ) => '20px',
            esc_html__( 'Custom', 'salient-core' ) => 'custom' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Box Shadow', 'salient-core' ),
            'save_always' => true,
            'edit_field_class' => 'col-md-6 col-md-6-last',
            'param_name' => 'box_shadow',
            'value' => array( 
                esc_html__( 'None', 'salient-core' ) => 'none', 
                esc_html__( 'Small Depth', 'salient-core' ) => 'small_depth', 
                esc_html__( 'Medium Depth', 'salient-core' ) => 'medium_depth', 
                esc_html__( 'Large Depth', 'salient-core' ) => 'large_depth', 
                esc_html__( 'Very Large Depth', 'salient-core' ) => 'x_large_depth',
                esc_html__( 'Custom', 'salient-core' ) => 'custom'  
            ),
            'description' => '',
            'dependency' => Array( 'element' => 'animation', 'value' => array( 'None', 'Fade In', 'Fade In From Left', 'Fade In From Right', 'Fade In From Bottom', 'slide-up', 'Grow In', 'Flip In', 'flip-in-vertical' ) ),
        ),

        array(
            "type" => "nectar_numerical",
            "class" => "",
            "edit_field_class" => "nectar-one-fourth",
            "heading" => '',
            "value" => "",
            "placeholder" => esc_html__("Top Left",'salient-core'),
            "param_name" => "top_left_border_radius",
            "description" => "",
            "dependency" => Array('element' => "border_radius", 'value' => array('custom'))
          ),
          array(
            "type" => "nectar_numerical",
            "class" => "",
            "placeholder" => esc_html__("Top Right",'salient-core'),
            "edit_field_class" => "nectar-one-fourth",
            "heading" => "<span class='attr-title'>" . esc_html__("Top Right", "salient-core") . "</span>",
            "value" => "",
            "param_name" => "top_right_border_radius",
            "description" => "",
            "dependency" => Array('element' => "border_radius", 'value' => array('custom'))
          ),
          array(
            "type" => "nectar_numerical",
            "class" => "",
            "placeholder" => esc_html__("Bottom Right",'salient-core'),
            "edit_field_class" => "nectar-one-fourth",
            "heading" => "<span class='attr-title'>" . esc_html__("Bottom Right", "salient-core") . "</span>",
            "value" => "",
            "param_name" => "bottom_right_border_radius",
            "description" => "",
            "dependency" => Array('element' => "border_radius", 'value' => array('custom'))
          ),
  
          array(
            "type" => "nectar_numerical",
            "class" => "",
            "placeholder" => esc_html__("Bottom Left",'salient-core'),
            "edit_field_class" => "nectar-one-fourth nectar-one-fourth-last",
            "heading" => "<span class='attr-title'>" . esc_html__("Bottom Left", "salient-core") . "</span>",
            "value" => "",
            "param_name" => "bottom_left_border_radius",
            "description" => "",
            "dependency" => Array('element' => "border_radius", 'value' => array('custom'))
          ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Shadow Method', 'salient-core' ),
            'save_always' => true,
            'param_name' => 'box_shadow_method',
            'value' => array( 
                esc_html__( 'CSS Box Shadow', 'salient-core' ) => 'default', 
                esc_html__( 'CSS Filter Drop Shadow', 'salient-core' ) => 'filter', 
            ),
            'description' => esc_html__( 'Using the CSS Filter method will connect the shadow to the image contents rather than the bounding box. When using a .png image, this will add the shadow to the edges of the elements within the .png.', 'salient-core' ),
            'dependency' => Array( 'element' => 'box_shadow', 'value' => array( 'custom' ) )
        ),
        array(
            'type' => 'nectar_box_shadow_generator',
            'heading' => esc_html__( 'Custom Box Shadow', 'salient-core' ),
            'save_always' => true,
            'param_name' => 'custom_box_shadow',
            'dependency' => Array( 'element' => 'box_shadow', 'value' => array( 'custom' ) )
        ),
        

        array(
            'type' => 'nectar_group_header',
            'class' => '',
            'heading' => esc_html__( 'Advanced', 'salient-core' ),
            'param_name' => 'group_header_5',
            'edit_field_class' => '',
            'value' => ''
        ),

        array(
            'type' => 'dropdown',
            'class' => '',
            'save_always' => true,
            'heading' => esc_html__( 'Image Loading', 'salient-core' ),
            'param_name' => 'image_loading',
            'value' => array(
                'Default' => 'default',
                'Skip Lazy Load' => 'skip-lazy-load',
                'Lazy Load' => 'lazy-load',
            ),
            'description' => esc_html__( 'Determine whether to load the image on page load or to use a lazy load method for higher performance.', 'salient-core' ),
            'std' => 'default',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Desktop Max Width', 'salient-core' ),
            'save_always' => true,
            'param_name' => 'max_width',
            'value' => array(
                esc_html__( '100%', 'salient-core' ) => '100%',
                esc_html__( '110%', 'salient-core' ) => '110%',
                esc_html__( '125%', 'salient-core' ) => '125%',
                esc_html__( '150%', 'salient-core' ) => '150%',
                esc_html__( '165%', 'salient-core' ) => '165%',
                esc_html__( '175%', 'salient-core' ) => '175%',
                esc_html__( '200%', 'salient-core' ) => '200%',
                esc_html__( '225%', 'salient-core' ) => '225%',
                esc_html__( '250%', 'salient-core' ) => '250%',
                esc_html__( '75%', 'salient-core' ) => '75%',
                esc_html__( '50%', 'salient-core' ) => '50%',
                esc_html__( 'None', 'salient-core' ) => 'none',
                esc_html__( 'Custom', 'salient-core' ) => 'custom',
            ),
            'description' => esc_html__( "Select your desired max width here - by default images are not allowed to display larger than the column they're contained in. Changing this to a higher value will allow you to create designs where your image overflows out of the column partially off screen.", 'salient-core' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Mobile Max Width', 'salient-core' ),
            'save_always' => true,
            'param_name' => 'max_width_mobile',
            'dependency' => Array( 'element' => 'max_width', 'value' => array( 'none', '50%', '75%', '100%', '110%', '125%', '150%', '165%', '175%', '200%' ) ),
            'value' => array(
                esc_html__( 'Default', 'salient-core' ) => 'default',
                esc_html__( '100%', 'salient-core' ) => '100%',
                esc_html__( '110%', 'salient-core' ) => '110%',
                esc_html__( '125%', 'salient-core' ) => '125%',
                esc_html__( '150%', 'salient-core' ) => '150%',
                esc_html__( '165%', 'salient-core' ) => '165%',
                esc_html__( '175%', 'salient-core' ) => '175%',
                esc_html__( '200%', 'salient-core' ) => '200%'
            ),
            'description' => ''
        ),
        array(
            'type' => 'textfield',
            'heading' => '<span class="group-title">' . esc_html__( 'Custom Max Width', 'salient-core' ) . '</span>',
            'param_name' => 'max_width_custom',
            'edit_field_class' => 'desktop image-custom-width-device-group',
            'dependency' => Array( 'element' => 'max_width', 'value' => array( 'custom' ) ),
            'description' => esc_html__( 'Enter a custom maximum width for your image.', 'salient-core' )
        ),
        array(
            'type' => 'textfield',
            'heading' => '',
            'param_name' => 'max_width_custom_tablet',
            'edit_field_class' => 'tablet image-custom-width-device-group',
            'dependency' => Array( 'element' => 'max_width', 'value' => array( 'custom' ) ),
            'description' => esc_html__( 'Enter a custom maximum width for your image.', 'salient-core' )
        ),
        array(
            'type' => 'textfield',
            'heading' => '',
            'param_name' => 'max_width_custom_phone',
            'edit_field_class' => 'phone image-custom-width-device-group',
            'dependency' => Array( 'element' => 'max_width', 'value' => array( 'custom' ) ),
            'description' => esc_html__( 'Enter a custom maximum width for your image.', 'salient-core' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Custom', 'salient-core' ) . ' "' . esc_html__( 'sizes', 'salient-core' )  . '" ' . esc_html__( 'Attribute', 'salient-core' ),
            'param_name' => 'custom_sizes_attr',
            'description' => esc_html__( 'Optionally define a set of media conditions (e.g. screen widths) to hint to the browser which size to download. e.g. (min-width: 400px) 400px, 100vw', 'salient-core' )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Overflow Visibility", "salient-core"),
            "param_name" => "overflow",
            "value" => array(
                  "Visible" => "visible",
                  "Hidden" => "hidden",
            )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'CSS Class Name', 'salient-core' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'salient-core' )
        )
    );

    $mask_group = SalientWPbakeryParamGroups::mask_group( esc_html__( 'Mask', 'salient-core' ) );
    $position_group = SalientWPbakeryParamGroups::position_group( esc_html__( 'Positioning', 'salient-core' ) );

    $imported_groups = array( $mask_group, $position_group );

    foreach ( $imported_groups as $group ) {

        foreach ( $group as $option ) {
            $image_with_animation_params[] = $option;
        }

    }

    $image_with_animation_map = array(
        'name' => esc_html__( 'Single Image', 'salient-core' ),
        'base' => 'image_with_animation',
        'icon' => 'icon-wpb-single-image',
        'category' => esc_html__( 'Media', 'salient-core' ),
        'weight' => 10,
        'description' => esc_html__( 'Simple image with CSS animation', 'salient-core' ),
        'params' => $image_with_animation_params
    );

    return $image_with_animation_map;
