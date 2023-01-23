<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$el_color_list = array(
    esc_html__( 'Accent Color', 'salient-core' ) => 'Accent-Color',
    esc_html__( 'Extra Color 1', 'salient-core' ) => 'Extra-Color-1',
    esc_html__( 'Extra Color 2', 'salient-core' ) => 'Extra-Color-2',
    esc_html__( 'Extra Color 3', 'salient-core' ) => 'Extra-Color-3',
    esc_html__( 'Color Gradient 1', 'salient-core' ) => 'extra-color-gradient-1',
    esc_html__( 'Color Gradient 2', 'salient-core' ) => 'extra-color-gradient-2',
    esc_html__( 'Black', 'salient-core' ) => 'black',
    esc_html__( 'Grey', 'salient-core' ) => 'grey',
    esc_html__( 'White', 'salient-core' ) => 'white',
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

$icon_params = array(

    array(
        'type' => 'dropdown',
        'heading' => __( 'Icon library', 'salient-core' ),
        'value' => array(
            esc_html__( 'Font Awesome', 'salient-core' ) => 'fontawesome',
            esc_html__( 'Iconsmind', 'salient-core' ) => 'iconsmind',
            esc_html__( 'Linea', 'salient-core' ) => 'linea',
            esc_html__( 'Steadysets', 'salient-core' ) => 'steadysets',
            esc_html__( 'Linecons', 'salient-core' ) => 'linecons',
        ),
        'save_always' => true,
        'param_name' => 'icon_family',
        'description' => __( 'Select icon library.', 'salient-core' ),
    ),
    array(
        'type' => 'iconpicker',
        'heading' => esc_html__( 'Icon', 'salient-core' ),
        'param_name' => 'icon_fontawesome',
        'settings' => array( 'iconsPerPage' => 240 ),
        'dependency' => array( 'element' => 'icon_family', 'emptyIcon' => false, 'value' => 'fontawesome' ),
        'description' => esc_html__( 'Select icon from library.', 'salient-core' )
    ),
    array(
        'type' => 'iconpicker',
        'heading' => esc_html__( 'Icon', 'salient-core' ),
        'param_name' => 'icon_iconsmind',
        'settings' => array( 'type' => 'iconsmind', 'emptyIcon' => false, 'iconsPerPage' => 240 ),
        'dependency' => array( 'element' => 'icon_family', 'value' => 'iconsmind' ),
        'description' => esc_html__( 'Select icon from library.', 'salient-core' )
    ),
    array(
        'type' => 'iconpicker',
        'heading' => esc_html__( 'Icon', 'salient-core' ),
        'param_name' => 'icon_linea',
        'settings' => array( 'type' => 'linea', 'emptyIcon' => true, 'iconsPerPage' => 240 ),
        'dependency' => Array( 'element' => 'icon_family', 'value' => 'linea' ),
        'description' => esc_html__( 'Select icon from library.', 'salient-core' )
    ),
    array(
        'type' => 'iconpicker',
        'heading' => esc_html__( 'Icon', 'salient-core' ),
        'param_name' => 'icon_linecons',
        'settings' => array( 'type' => 'linecons', 'emptyIcon' => false, 'iconsPerPage' => 240 ),
        'dependency' => array( 'element' => 'icon_family', 'value' => 'linecons' ),
        'description' => esc_html__( 'Select icon from library.', 'salient-core' )
    ),
    array(
        'type' => 'iconpicker',
        'heading' => esc_html__( 'Icon', 'salient-core' ),
        'param_name' => 'icon_steadysets',
        'settings' => array( 'type' => 'steadysets', 'emptyIcon' => false, 'iconsPerPage' => 240 ),
        'dependency' => array( 'element' => 'icon_family', 'value' => 'steadysets' ),
        'description' => esc_html__( 'Select icon from library.', 'salient-core' )
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Icon Size', 'salient-core' ),
        'param_name' => 'icon_size',
        'description' => esc_html__( "Don't include px in your string. e.g. 40 - the default is 50", 'salient-core' )
    ),
    array(
        'type' => 'checkbox',
        'class' => '',
        'heading' => esc_html__( 'Enable Animation', 'salient-core' ),
        'param_name' => 'enable_animation',
        'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'true' ),
        'dependency' => array( 'element' => 'icon_family', 'value' => 'linea' ),
        'description' => 'This will cause the icon to appear to draw itself. <strong>Will not activate when using a gradient color.</strong>'
    ),
    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Animation Delay', 'salient-core' ),
        'param_name' => 'animation_delay',
        'dependency' => array( 'element' => 'enable_animation', 'not_empty' => true ),
        'description' => esc_html__( 'Enter delay (in milliseconds) if needed e.g. 150. This parameter comes in handy when creating the animate in \'one by one\' effect.', 'salient-core' )
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Animation Speed', 'salient-core' ),
        'value' => array(
            esc_html__( 'Slow', 'salient-core' ) => 'slow',
            esc_html__( 'Medium', 'salient-core' ) => 'medium',
            esc_html__( 'fast', 'salient-core' ) => 'fast'
        ),
        'save_always' => true,
        'param_name' => 'animation_speed',
        'dependency' => array( 'element' => 'enable_animation', 'not_empty' => true ),
        'description' => esc_html__( 'Select how fast you would like your icon to animate', 'salient-core' ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Icon Style', 'salient-core' ),
        'value' => array(
            esc_html__( 'Icon Only', 'salient-core' ) => 'default',
            esc_html__( 'Border Basic', 'salient-core' ) => 'border-basic',
            esc_html__( 'Border W/ Hover Animation', 'salient-core' ) => 'border-animation',
            esc_html__( 'Soft Color Background', 'salient-core' ) => 'soft-bg',
            esc_html__( 'Solid Color Background W/ Shadow', 'salient-core' ) => 'shadow-bg'
        ),
        'save_always' => true,
        'param_name' => 'icon_style',
        'description' => esc_html__( 'Select your button style.', 'salient-core' ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Icon Border Thickness', 'salient-core' ),
        'value' => array(
            esc_html__( '1px', 'salient-core' ) => '1px',
            esc_html__( '2px', 'salient-core' ) => '2px',
            esc_html__( '3px', 'salient-core' ) => '3px',
            esc_html__( '4px', 'salient-core' ) => '4px',
            esc_html__( '5px', 'salient-core' ) => '5px'
        ),
        'std' => '2px',
        'dependency' => array( 'element' => 'icon_style', 'value' => array( 'border-basic', 'border-animation' ) ),
        'save_always' => true,
        'param_name' => 'icon_border_thickness',
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Icon Coloring', 'salient-core' ),
        'value' => array(
            esc_html__( 'Global Color Scheme', 'salient-core' ) => 'color_scheme',
            esc_html__( 'Custom', 'salient-core' ) => 'custom'
        ),
        'std' => 'color_scheme',
        'save_always' => true,
        'param_name' => 'icon_color_type',
    ),
    array(
        'type' => 'dropdown',
        'heading' => __( 'Icon Color', 'salient-core' ),
        'value' => $el_color_list,
        'save_always' => true,
        'param_name' => 'icon_color',
        'dependency' => array( 'element' => 'icon_color_type', 'value' => array( 'color_scheme' ) ),
        'description' => esc_html__( 'Choose a color from your', 'salient-core' ) . ' <a target="_blank" href="'. esc_url( NectarThemeInfo::global_colors_tab_url() ) .'"> ' . esc_html__( 'globally defined color scheme', 'salient-core' ) . '</a>',
    ),

    array(
        'type' => 'colorpicker',
        'class' => '',
        'heading' => 'Icon Color',
        'param_name' => 'icon_color_custom',
        'dependency' => array( 'element' => 'icon_color_type', 'value' => array( 'custom' ) ),
        'value' => '',
        'description' => esc_html__( 'Choose a custom color for your icon, outside of the global color scheme', 'salient-core' ),
    ),

    array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Link URL', 'salient-core' ),
        'param_name' => 'url',
        'description' => esc_html__( 'The link for your button.', 'salient-core' )
    ),

    array(
        'type' => 'checkbox',
        'class' => '',
        'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
        'heading' => esc_html__( 'Open Link In New Tab?', 'salient-core' ),
        'param_name' => 'open_new_tab',
        'value' => Array( esc_html__( 'Yes', 'salient-core' ) => 'true' ),
        'description' => ''
    ),
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Icon Padding', 'salient-core' ),
        'value' => array(
            esc_html__( '5px', 'salient-core' ) => '5px',
            esc_html__( '10px', 'salient-core' ) => '10px',
            esc_html__( '15px', 'salient-core' ) => '15px',
            esc_html__( '20px', 'salient-core' ) => '20px',
            esc_html__( '25px', 'salient-core' ) => '25px',
            esc_html__( '30px', 'salient-core' ) => '30px',
            esc_html__( '35px', 'salient-core' ) => '35px',
            esc_html__( '40px', 'salient-core' ) => '40px',
            esc_html__( '45px', 'salient-core' ) => '45px',
            esc_html__( '50px', 'salient-core' ) => '50px',
            esc_html__( '0px', 'salient-core' ) => '0px',
        ),
        'std' => '20px',
        'save_always' => true,
        'param_name' => 'icon_padding',
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => esc_html__( 'Margin', 'salient-core' ) . '<span>' . esc_html__( 'Top', 'salient-core' ) . '</span>',
        'param_name' => 'margin_top',
        'edit_field_class' => 'col-md-2 no-device-group constrain_group_1',
        'placeholder' => esc_html__( 'Top', 'salient-core' ),
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 1', 'salient-core' ),
        'param_name' => 'constrain_group_1',
        'description' => '',
        'edit_field_class' => 'no-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => '<span>' . esc_html__( 'Bottom', 'salient-core' ) . '</span>',
        'param_name' => 'margin_bottom',
        'edit_field_class' => 'col-md-2 no-device-group constrain_group_1',
        'placeholder' => esc_html__( 'Bottom', 'salient-core' ),
        'description' => ''
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => '<span>' . esc_html__( 'Left', 'salient-core' ) . '</span>',
        'param_name' => 'margin_left',
        'edit_field_class' => 'col-md-2 no-device-group constrain_group_2',
        'placeholder' => esc_html__( 'Left', 'salient-core' ),
        'description' => ''
    ),
    array(
        'type' => 'checkbox',
        'heading' => esc_html__( 'Constrain 2', 'salient-core' ),
        'param_name' => 'constrain_group_2',
        'description' => '',
        'edit_field_class' => 'no-device-group constrain-icon',
        'value' => array( esc_html__( 'Yes', 'salient-core' ) => 'yes' ),
    ),
    array(
        'type' => 'nectar_numerical',
        'heading' => '<span>' . esc_html__( 'Right', 'salient-core' ) . '</span>',
        'param_name' => 'margin_right',
        'edit_field_class' => 'col-md-2 no-device-group constrain_group_2',
        'placeholder' => esc_html__( 'Right', 'salient-core' ),
        'description' => ''
    ),
    array(
        'type' => 'textfield',
        'class' => '',
        'heading' => esc_html__( 'Z-Index', 'salient-core' ),
        'param_name' => 'zindex',
        'description' => esc_html__( 'If you want to set a custom stacking order on this icon, enter it here.', 'salient-core' ),
        'value' => ''
    ),
    array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Pointer Events', 'salient-core' ),
        'param_name' => 'pointer_events',
        'description' => esc_html__( 'Optionally control whether the user should be able to interact with this icon.', 'salient-core' ),
        'value' => array(
            'All' => 'all',
            'None' => 'none',
        ),
        'save_always' => true
    )

);

$position_group = SalientWPbakeryParamGroups::position_group( esc_html__( 'Positioning', 'salient-core' ), false );

$imported_groups = array( $position_group );

foreach ( $imported_groups as $group ) {

    foreach ( $group as $option ) {
        $icon_params[] = $option;
    }

}

$icon_map = array(
    'name' => esc_html__( 'Icon', 'salient-core' ),
    'base' => 'nectar_icon',
    'icon' => 'icon-wpb-icons',
    'category' => __( 'Content', 'salient-core' ),
    'weight' => 2,
    'description' => __( 'Add a icon', 'salient-core' ),
    'params' => $icon_params
);

return $icon_map;

?>