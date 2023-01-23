<?php

/**
 * Reusable WPBakery parameter groups
 *
 * @version 1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('SalientWPbakeryParamGroups')) {
    class SalientWPbakeryParamGroups
    {

        static $instance = false;

        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public static function position_group($group_name, $zindex = true)
        {

            $position_arr = array(
                array(
                    'type' => 'dropdown',
                    'class' => '',
                    'group' => $group_name,
                    'edit_field_class' => 'desktop position-display-device-group',
                    'heading' => '<span class="group-title">' . esc_html__('Position', 'salient-core') . '</span>',
                    'param_name' => 'position_desktop',
                    'value' => array(
                        esc_html__('Default', 'salient-core') => 'default',
                        esc_html__('Relative', 'salient-core') => 'relative',
                        esc_html__('Absolute', 'salient-core') => 'absolute'
                    )
                ),

                array(
                    'type' => 'dropdown',
                    'class' => '',
                    'group' => $group_name,
                    'edit_field_class' => 'tablet position-display-device-group',
                    'heading' => '',
                    'param_name' => 'position_tablet',
                    'value' => array(
                        esc_html__('Inherit', 'salient-core') => 'inherit',
                        esc_html__('Relative', 'salient-core') => 'relative',
                        esc_html__('Absolute', 'salient-core') => 'absolute'
                    )
                ),

                array(
                    'type' => 'dropdown',
                    'class' => '',
                    'group' => $group_name,
                    'edit_field_class' => 'phone position-display-device-group',
                    'heading' => '',
                    'param_name' => 'position_phone',
                    'value' => array(
                        esc_html__('Inherit', 'salient-core') => 'inherit',
                        esc_html__('Relative', 'salient-core') => 'relative',
                        esc_html__('Absolute', 'salient-core') => 'absolute'
                    )
                ),

                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'edit_field_class' => 'nectar-col-25 col-25-first desktop position-device-group',
                    'heading' => '<span class="group-title">' . esc_html__('Positioning', 'salient-core') . "</span><span class='attr-title'>" . esc_html__('Top', 'salient-core') . '</span>',
                    'value' => '',
                    'placeholder' => esc_html__('Top', 'salient-core'),
                    'param_name' => 'top_position_desktop',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Bottom', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 desktop position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Bottom', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'bottom_position_desktop',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Left', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 desktop position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Left', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'left_position_desktop',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Right', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 col-25-last desktop position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Right', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'right_position_desktop',
                    'description' => ''
                ),

                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Top', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 col-25-first tablet position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Top', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'top_position_tablet',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Bottom', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 tablet position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Bottom', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'bottom_position_tablet',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Left', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 tablet position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Left', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'left_position_tablet',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Right', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 col-25-last tablet position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Right', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'right_position_tablet',
                    'description' => ''
                ),

                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Top', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 col-25-first phone position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Top', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'top_position_phone',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Bottom', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 phone position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Bottom', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'bottom_position_phone',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Left', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 phone position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Left', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'left_position_phone',
                    'description' => ''
                ),
                array(
                    'type' => 'nectar_numerical',
                    'class' => '',
                    'group' => $group_name,
                    'placeholder' => esc_html__('Right', 'salient-core'),
                    'edit_field_class' => 'nectar-col-25 col-25-last phone position-device-group',
                    'heading' => "<span class='attr-title'>" . esc_html__('Right', 'salient-core') . '</span>',
                    'value' => '',
                    'param_name' => 'right_position_phone',
                    'description' => ''
                ),


                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    'group' => $group_name,
                    "heading" => '<span class="group-title">' . esc_html__("Transform", "salient-core") . "</span><span class='attr-title'>" . esc_html__("Translate Y", "salient-core") . "</span>",
                    "value" => "",
                    "placeholder" => esc_html__("Translate Y", 'salient-core'),
                    "edit_field_class" => "nectar-one-half desktop transform-device-group",
                    "param_name" => "translate_y_desktop",
                    "description" => ""
                ),

                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    'group' => $group_name,
                    "placeholder" => esc_html__("Translate X", 'salient-core'),
                    "heading" => "<span class='attr-title'>" . esc_html__("Translate X", "salient-core") . "</span>",
                    "value" => "",
                    "edit_field_class" => "nectar-one-half nectar-one-half-last desktop transform-device-group",
                    "param_name" => "translate_x_desktop",
                    "description" => ""
                ),

                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    'group' => $group_name,
                    "placeholder" => esc_html__("Translate Y", 'salient-core'),
                    "heading" => "<span class='attr-title'>" . esc_html__("Translate Y", "salient-core") . "</span>",
                    "value" => "",
                    "edit_field_class" => "nectar-one-half tablet transform-device-group",
                    "param_name" => "translate_y_tablet",
                    "description" => ""
                ),

                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    'group' => $group_name,
                    "placeholder" => esc_html__("Translate X", 'salient-core'),
                    "heading" => "<span class='attr-title'>" . esc_html__("Translate X", "salient-core") . "</span>",
                    "value" => "",
                    "edit_field_class" => "nectar-one-half nectar-one-half-last tablet transform-device-group",
                    "param_name" => "translate_x_tablet",
                    "description" => ""
                ),
                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    'group' => $group_name,
                    "placeholder" => esc_html__("Translate Y", 'salient-core'),
                    "heading" => "<span class='attr-title'>" . esc_html__("Translate Y", "salient-core") . "</span>",
                    "value" => "",
                    "edit_field_class" => "nectar-one-half phone transform-device-group",
                    "param_name" => "translate_y_phone",
                    "description" => ""
                ),

                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    'group' => $group_name,
                    "placeholder" => esc_html__("Translate X", 'salient-core'),
                    "heading" => "<span class='attr-title'>" . esc_html__("Translate X", "salient-core") . "</span>",
                    "value" => "",
                    "edit_field_class" => "nectar-one-half nectar-one-half-last phone transform-device-group",
                    "param_name" => "translate_x_phone",
                    "description" => ""
                ),

            );

            if( $zindex ) {
                $position_arr[] = array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Z-index", "salient-core"),
					'group' => $group_name,
					"param_name" => "zindex",
					"admin_label" => false,
					"description" => esc_html__("If you want to set a custom stacking order on this element, enter it here.", "salient-core"),
				);
            }

            return $position_arr;
        }


        public static function css_animation_group($group_name)
        {
            $css_arr = array(
                array(
                    'type' => 'dropdown',
                    'class' => '',
                    'group' => $group_name,
                    "heading" => esc_html__("CSS Animation", "salient-core"),
                    'param_name' => 'css_animation',
                    'value' => array(
                        esc_html__("None", "salient-core") => "none",
                        esc_html__("Fade In", "salient-core") => "fade-in",
                        esc_html__("Fade In From Left", "salient-core") => "fade-in-from-left",
                        esc_html__("Fade In Right", "salient-core") => "fade-in-from-right",
                        esc_html__("Fade In From Bottom", "salient-core") => "fade-in-from-bottom",
                        esc_html__("Grow In", "salient-core") => "grow-in",
                    )
                ),
                array(
					"type" => "checkbox",
					"class" => "",
					'group' => $group_name,
					'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
					"heading" => esc_html__("Disable CSS Animation On Mobile", "salient-core"),
					"param_name" => "mobile_disable_css_animation",
					"value" => array(esc_html__("Yes", "salient-core") => 'true'),
				),

				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("CSS Animation Delay", "salient-core"),
					'group' => $group_name,
					"param_name" => "css_animation_delay",
					"edit_field_class" => "nectar-one-half",
					"admin_label" => false,
					"description" => esc_html__("Optionally enter a delay in milliseconds for when the CSS animation will trigger e.g. 150.", "salient-core"),
				),
				array(
					"type" => "textfield",
					"class" => "",
					'group' => $group_name,
					"edit_field_class" => "nectar-one-half nectar-one-half-last",
					"heading" => esc_html__("CSS Animation Offset", "salient-core" ),
					"param_name" => "css_animation_offset",
					"admin_label" => false,
					"description" => esc_html__("Optionally specify the offset from the top of the screen for when the CSS animation will trigger. Defaults to 95%.", "salient-core"),
				),
            );

            return $css_arr;
        }


        public static function font_sizing_group() {

            $font_sizing_arr = array(
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
                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    "heading" => esc_html__("Min Font Size", 'salient-core'),
                    "value" => "",
                    "placeholder" => '',
                    "edit_field_class" => "nectar-one-half zero-floor",
                    "param_name" => "font_size_min",
                    "description" => ""
                ),
                array(
                    "type" => "nectar_numerical",
                    "class" => "",
                    "heading" => esc_html__("Max Font Size", 'salient-core'),
                    "value" => "",
                    "placeholder" => '',
                    "edit_field_class" => "nectar-one-half zero-floor",
                    "param_name" => "font_size_max",
                    "description" => ""
                ),
            );

            return $font_sizing_arr;
            
        }

        public static function mask_group($group_name)
        {

            $alignments = array(
                esc_html__('Default (Center Center)', 'salient-core') => 'default',
                esc_html__('Left Top', 'salient-core') => 'left-top',
                esc_html__('Left Center', 'salient-core') => 'left-center',
                esc_html__('Left Bottom', 'salient-core') => 'left-bottom',
                esc_html__('Center Top', 'salient-core') => 'center-top',
                esc_html__('Center Center', 'salient-core') => 'center-center',
                esc_html__('Center Bottom', 'salient-core') => 'center-bottom',
                esc_html__('Right Top', 'salient-core') => 'right-top',
                esc_html__('Right Center', 'salient-core') => 'right-center',
                esc_html__('Right Bottom', 'salient-core') => 'right-bottom'
            );

            $mask_arr = array(
                array(
                    'group' => $group_name,
                    'type' => 'checkbox',
                    'class' => '',
                    'heading' => esc_html__('Enable Mask', 'salient-core'),
                    'param_name' => 'mask_enable',
                    'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
                    'value' => array(esc_html__('Yes', 'salient-core') => 'true'),
                    'description' => ''
                ),
                array(
                    'group' => $group_name,
                    'type' => 'nectar_radio_html',
                    'class' => '',
                    'heading' => esc_html__('Mask Shape', 'salient-core'),
                    'param_name' => 'mask_shape',
                    'options' => array(
                        '<div style="clip-path: circle(50% at 50% 50%)" class="nectar-shape"></div>' => 'circle',
                        '<div style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%)" class="nectar-shape"></div>' => 'triangle',
                        '<div style="clip-path: polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%)" class="nectar-shape"></div>' => 'parallelogram',
                        '<div style="clip-path: inset(0px 0px 0px round 100% 100% 0px 0px)" class="nectar-shape"></div>' => 'circle-rect',
                        '<div style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%)" class="nectar-shape"></div>' => 'rhombus',
                        '<svg class="svg nectar-shape" viewBox="0 0 100 98.98"><polygon points="50 6.63 57.12 0 62.07 8.37 70.77 4.01 73.17 13.44 82.74 11.7 82.39 21.43 92.06 22.46 88.98 31.69 97.97 35.4 92.42 43.39 100 49.49 92.42 55.59 97.97 63.58 88.98 67.3 92.06 76.52 82.39 77.56 82.74 87.28 73.17 85.55 70.77 94.97 62.07 90.61 57.12 98.98 50 92.35 42.88 98.98 37.93 90.61 29.23 94.97 26.83 85.55 17.26 87.28 17.61 77.56 7.94 76.52 11.02 67.3 2.02 63.58 7.58 55.59 0 49.49 7.58 43.39 2.02 35.4 11.02 31.69 7.94 22.46 17.61 21.43 17.26 11.7 26.83 13.44 29.23 4.01 37.93 8.37 42.88 0 50 6.63"/></svg>' => 'star',
                        '<div style="clip-path: polygon(50% 0%, 90% 20%, 100% 60%, 75% 100%, 25% 100%, 0% 60%, 10% 20%)" class="nectar-shape"></div>' => 'heptagon',
                        '<div style="clip-path: ellipse(25% 40% at 50% 50%);" class="nectar-shape"></div>' => 'ellipse',
                        '<svg class="svg nectar-shape" viewBox="0 0 65.71 100"><polygon points="25.48 100 25.48 59.7 0 59.7 40.23 0 40.23 40.3 65.71 40.3 25.48 100"/></svg>' => 'lightning',
                        '<div style="clip-path: circle(68.5% at 0% 0%)" class="nectar-shape"></div>' => 'circle-top-left',
                        '<div style="clip-path: circle(68.5% at 100% 0%)" class="nectar-shape"></div>' => 'circle-top-right',
                        '<div style="clip-path: circle(68.5% at 0% 100%)" class="nectar-shape"></div>' => 'circle-bottom-left',
                        '<div style="clip-path: circle(68.5% at 100% 100%)" class="nectar-shape"></div>' => 'circle-bottom-right',
                        '<div style="clip-path: polygon(20% 0%, 0% 20%, 30% 50%, 0% 80%, 20% 100%, 50% 70%, 80% 100%, 100% 80%, 70% 50%, 100% 20%, 80% 0%, 50% 30%);" class="nectar-shape"></div>' => 'x-symbol',
                        '<svg class="svg nectar-shape" viewBox="0 0 1 1"><path d="M0.5,0 C0.224,0,0,0.224,0,0.5 s0.224,0.5,0.5,0.5 c0.276,0,0.5,-0.224,0.5,-0.5 S0.776,0,0.5,0 M0.5,0.15 c0.091,0,0.165,0.074,0.165,0.165 c0,0.091,-0.074,0.165,-0.165,0.165 c-0.091,0,-0.165,-0.074,-0.165,-0.165 C0.335,0.224,0.409,0.15,0.5,0.15 M0.5,0.869 c-0.091,0,-0.175,-0.033,-0.239,-0.088 c-0.016,-0.013,-0.025,-0.033,-0.025,-0.054 c0,-0.093,0.075,-0.167,0.168,-0.167 h0.192 c0.093,0,0.167,0.074,0.167,0.167 c0,0.021,-0.009,0.04,-0.025,0.054 C0.675,0.836,0.591,0.869,0.5,0.869"></path></svg>' => 'custom',
                    ),
                    'description' => '',
                    'std' => 'circle',
                ),
                array(
                    'group' => $group_name,
                    'type' => 'fws_image',
                    'heading' => esc_html__('Image', 'salient-core'),
                    'param_name' => 'mask_custom_image',
                    'value' => '',
                    'dependency' => array('element' => 'mask_shape', 'value' => array('custom')),
                    'description' => esc_html__('Select a .png image from media library to use as a mask.', 'salient-core')
                ),
                array(
                    'group' => $group_name,
                    'type' => 'dropdown',
                    'class' => '',
                    'heading' => esc_html__('Mask Size', 'salient-core'),
                    'param_name' => 'mask_size',
                    'value' => array(
                        'Contain' => 'contain',
                        'Cover' => 'cover',
                        'Custom' => 'custom',
                    ),
                    'description' => '',
                    'std' => 'fit',
                ),
                array(
                    'group' => $group_name,
                    'type' => 'nectar_range_slider',
                    'dependency' => array('element' => 'mask_size', 'value' => array('custom')),
                    'heading' => esc_html__('Mask Scale', 'salient-core'),
                    'param_name' => 'mask_scale',
                    'value' => '100',
                    'options' => array(
                        'min' => '0',
                        'max' => '200',
                    ),
                    'description' => ''
                ),
                array(
                    'group' => $group_name,
                    'type' => 'dropdown',
                    'heading' => '<span class="group-title">' . esc_html__('Mask Alignment', 'salient-core') . '</span>',
                    'param_name' => 'mask_alignment_desktop',
                    'edit_field_class' => 'desktop mask-alignment-device-group',
                    'value' => $alignments,
                    'description' => ''
                ),
                array(
                    'group' => $group_name,
                    'type' => 'dropdown',
                    'heading' => '',
                    'param_name' => 'mask_alignment_tablet',
                    'edit_field_class' => 'tablet mask-alignment-device-group',
                    'value' => $alignments,
                    'description' => ''
                ),
                array(
                    'group' => $group_name,
                    'type' => 'dropdown',
                    'heading' => '',
                    'param_name' => 'mask_alignment_phone',
                    'edit_field_class' => 'phone mask-alignment-device-group',
                    'value' => $alignments,
                    'description' => ''
                ),

            );

            // Hide options when not in dedicated mask group
            if ('mask' !== $group_name) {
                foreach ($mask_arr as $index => $array) {
                    if ('mask_enable' !== $array['param_name'] && !isset($array['dependency'])) {
                        $mask_arr[$index]['dependency'] = array('element' => 'mask_enable', 'not_empty' => true);
                    }
                }
            }

            return $mask_arr;
        }
    }

    // init.
    global $SalientWPbakeryParamGroups;
    $SalientWPbakeryParamGroups = Salient_Core::getInstance();
}
