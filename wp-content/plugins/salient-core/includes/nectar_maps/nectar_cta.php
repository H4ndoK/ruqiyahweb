<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

$el_color_list = array(
    esc_html__("Transparent", "salient-core") => "default",
	esc_html__("Accent Color", "salient-core") => "accent-color",
	esc_html__("Extra Color 1", "salient-core") => "extra-color-1",
	esc_html__("Extra Color 2", "salient-core") => "extra-color-2",
	esc_html__("Extra Color 3", "salient-core") => "extra-color-3",
	esc_html__("Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__("Color Gradient 2", "salient-core") => "extra-color-gradient-2",
	esc_html__("Black", "salient-core") => "black",
	esc_html__("White", "salient-core") => "white"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

$nectar_cta_params = array(
	array(
		"type" => "dropdown",
		"class" => "",
		'save_always' => true,
		"heading" => "Style",
		"param_name" => "btn_style",
		"admin_label" => true,
		"value" => array(
			esc_html__("See Through Button", "salient-core") => "see-through",
			esc_html__("Arrow Animation", "salient-core") => "arrow-animation",
			esc_html__("Material Button", "salient-core") => "material",
			esc_html__("Underline", "salient-core") => "underline",
			esc_html__("Text Reveal Wave", "salient-core") => "text-reveal-wave",
			esc_html__("Basic", "salient-core") => "basic",
			esc_html__("Next Section Button", "salient-core") => "next-section"
		)
	),

	array(
		"type" => "dropdown",
		"heading" => esc_html__("Button Type", "salient-core"),
		"dependency" => array('element' => "btn_style", 'value' => array('next-section')),
		"param_name" => "btn_type",
		"value" => array(
			esc_html__('Down Arrow With Border', 'salient-core') => 'down-arrow-bordered',
			esc_html__('Down Arrow with BG Color', 'salient-core') => 'down-arrow-bounce',
			esc_html__('Mouse Wheel Scroll Animation', 'salient-core') => 'mouse-wheel',
			esc_html__('Minimal Arrow Animation', 'salient-core') => 'minimal-arrow'
		),
		'save_always' => true
	),

	array(
		"type" => "dropdown",
		"class" => "",
		'save_always' => true,
		"heading" => "Display Tag",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'material', 'underline')),
		"param_name" => "heading_tag",
		"value" => array(
			"H6" => "h6",
			"H5" => "h5",
			"H4" => "h4",
			"H3" => "h3",
			"H2" => "h2",
			"H1" => "h1",
			"Paragraph" => "p",
			"Span" => "span"
		)
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
		"heading" => esc_html__("Call to action text", "salient-core"),
		"param_name" => "text",
		"admin_label" => true,
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'material', 'underline')),
		"description" => esc_html__("The text that will appear before the actual CTA link", "salient-core")
	),
	array(
		"type" => "textfield",
		"heading" => esc_html__("Link text", "salient-core"),
		"param_name" => "link_text",
		"admin_label" => true,
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'material', 'underline')),
		"description" => esc_html__("The text that will be used for the CTA link", "salient-core")
	),
	array(
		"type" => "nectar_group_header",
		"class" => "",
		"heading" => esc_html__("Coloring", "salient-core"),
		"param_name" => "group_header_2",
		"edit_field_class" => "",
		"value" => ''
	),
	array(
		'type' => 'dropdown',
		'heading' => __('CTA Background Color', 'salient-core'),
		'value' => $el_color_list,
		'save_always' => true,
		'param_name' => 'button_color',
		"description" => "",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
	),
	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "CTA Background Color Hover",
		"param_name" => "button_color_hover",
		"value" => "",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ""
	),
	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "CTA Text Color",
		"param_name" => "text_color",
		"value" => "",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'material', 'underline')),
		"description" => ""
	),
	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "CTA Text Color Hover",
		"param_name" => "text_color_hover",
		"value" => "",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'material', 'underline')),
		"description" => ""
	),
	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => esc_html__("Border Color", "salient-core"),
		"param_name" => "button_border_color",
		"value" => "",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ""
	),
	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => esc_html__("Border Color Hover", "salient-core"),
		"param_name" => "button_border_color_hover",
		"value" => "",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ""
	),
	array(
		"type" => "dropdown",
		"heading" => esc_html__("Border Thickness", "salient-core"),
		"param_name" => "button_border_thickness",
		"value" => array(
			esc_html__('0px', 'salient-core') => '0px',
			esc_html__('1px', 'salient-core') => '1px',
			esc_html__('2px', 'salient-core') => '2px',
			esc_html__('3px', 'salient-core') => '3px',
			esc_html__('4px', 'salient-core') => '4px',
		),
		'save_always' => true,
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ''
	),

	array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "Color",
		"param_name" => "next_section_color",
		"value" => "",
		"dependency" => array('element' => "btn_style", 'value' => array('next-section')),
		"description" => ""
	),
	array(
		"type" => "dropdown",
		"heading" => esc_html__("Button Animation", "salient-core"),
		"param_name" => "next_section_down_arrow_animation",
		"value" => array(
			esc_html__('Bounce', 'salient-core') => 'default',
			esc_html__('No Animation', 'salient-core') => 'none',
		),
		'save_always' => true,
		"dependency" => array('element' => "btn_type", 'value' => array('down-arrow-bounce')),
		"description" => ''
	),

	array(
		"type" => "dropdown",
		"heading" => esc_html__("Shadow", "salient-core"),
		"param_name" => "next_section_shadow",
		"value" => array(
			esc_html__('None', 'salient-core') => 'none',
			esc_html__('Add Shadow', 'salient-core') => 'add_shadow',
		),
		'save_always' => true,
		"dependency" => array('element' => "btn_type", 'value' => array('down-arrow-bordered', 'down-arrow-bounce')),
		"description" => ''
	),

	array(
		"type" => "textfield",
		"heading" => esc_html__("Link URL", "salient-core"),
		"param_name" => "url",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'material', 'underline')),
		"description" => esc_html__("The URL that will be used for the link", "salient-core")
	),
	array(
		"type" => "dropdown",
		"heading" => esc_html__("Link Type", "salient-core"),
		"param_name" => "link_type",
		"value" => array(
			esc_html__('Regular (open in same tab)', 'salient-core') => 'regular',
			esc_html__('Open In New Tab', 'salient-core') => 'new_tab',
			esc_html__('Open Video Lightbox', 'salient-core') => 'video_lightbox',
			esc_html__('Open Image Lightbox', 'salient-core') => 'image_lightbox',
		),
		'save_always' => true,
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'material', 'underline')),
		"description" => esc_html__("Please select the type of link you will be using.", "salient-core")
	),


	array(
		"type" => "nectar_group_header",
		"class" => "",
		"heading" => esc_html__("Spacing & Alignment", "salient-core"),
		"param_name" => "group_header_4",
		"edit_field_class" => "",
		"value" => ''
	),

	array(
		"type" => "dropdown",
		"heading" => '<span class="group-title">' . esc_html__("Alignment", "salient-core") . "</span>",
		"param_name" => "alignment",
		"value" => array(
			esc_html__('Left', 'salient-core') => 'left',
			esc_html__('Center', 'salient-core') => 'center',
			esc_html__('Right', 'salient-core') => 'right',
		),
		'save_always' => true,
		"edit_field_class" => "desktop alignment-device-group",
		"description" => esc_html__("Please select the desired alignment for your CTA", "salient-core")
	),

	array(
		"type" => "dropdown",
		"heading" => '',
		"param_name" => "alignment_tablet",
		"value" => array(
			esc_html__('Default', 'salient-core') => 'default',
			esc_html__('Left', 'salient-core') => 'left',
			esc_html__('Center', 'salient-core') => 'center',
			esc_html__('Right', 'salient-core') => 'right',
		),
		'save_always' => true,
		"edit_field_class" => "tablet alignment-device-group",
		"description" => esc_html__("Please select the desired alignment for your CTA", "salient-core")
	),
	array(
		"type" => "dropdown",
		"heading" => '',
		"param_name" => "alignment_phone",
		"value" => array(
			esc_html__('Default', 'salient-core') => 'default',
			esc_html__('Left', 'salient-core') => 'left',
			esc_html__('Center', 'salient-core') => 'center',
			esc_html__('Right', 'salient-core') => 'right',
		),
		'save_always' => true,
		"edit_field_class" => "phone alignment-device-group",
		"description" => esc_html__("Please select the desired alignment for your CTA", "salient-core")
	),

	array(
		"type" => "nectar_numerical",
		"heading" => esc_html__("Margin", "salient-core") . "<span>" . esc_html__("Top", "salient-core") . "</span>",
		"param_name" => "margin_top",
		"edit_field_class" => "col-md-2 no-device-group constrain_group_1",
		"placeholder" => esc_html__("Top", 'salient-core'),
		"description" => ''
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__('Constrain 1', 'salient-core'),
		'param_name' => 'constrain_group_1',
		'description' => '',
		"edit_field_class" => "no-device-group constrain-icon",
		'value' => array(esc_html__('Yes', 'salient-core') => 'yes'),
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Bottom", "salient-core") . "</span>",
		"param_name" => "margin_bottom",
		"edit_field_class" => "col-md-2 no-device-group constrain_group_1",
		"placeholder" => esc_html__("Bottom", 'salient-core'),
		"description" => ''
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Left", "salient-core") . "</span>",
		"param_name" => "margin_left",
		"edit_field_class" => "col-md-2 no-device-group constrain_group_2",
		"placeholder" => esc_html__("Left", 'salient-core'),
		"description" => ''
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__('Constrain 2', 'salient-core'),
		'param_name' => 'constrain_group_2',
		'description' => '',
		"edit_field_class" => "no-device-group constrain-icon",
		'value' => array(esc_html__('Yes', 'salient-core') => 'yes'),
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Right", "salient-core") . "</span>",
		"param_name" => "margin_right",
		"edit_field_class" => "col-md-2 no-device-group constrain_group_2",
		"placeholder" => esc_html__("Right", 'salient-core'),
		"description" => ''
	),

	array(
		"type" => "nectar_numerical",
		"heading" => esc_html__("Padding", "salient-core") . "<span>" . esc_html__("Top", "salient-core") . "</span>",
		"param_name" => "padding_top",
		"placeholder" => esc_html__("Top", 'salient-core'),
		"edit_field_class" => "col-md-2 no-device-group constrain_group_3",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ''
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__('Constrain 3', 'salient-core'),
		'param_name' => 'constrain_group_3',
		'description' => '',
		"edit_field_class" => "no-device-group constrain-icon",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		'value' => array(esc_html__('Yes', 'salient-core') => 'yes'),
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Bottom", "salient-core") . "</span>",
		"param_name" => "padding_bottom",
		"placeholder" => esc_html__("Bottom", 'salient-core'),
		"edit_field_class" => "col-md-2 no-device-group constrain_group_3",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ''
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Left", "salient-core") . "</span>",
		"param_name" => "padding_left",
		"placeholder" => esc_html__("Left", 'salient-core'),
		"edit_field_class" => "col-md-2 no-device-group constrain_group_4",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ''
	),
	array(
		'type' => 'checkbox',
		'heading' => esc_html__('Constrain 4', 'salient-core'),
		'param_name' => 'constrain_group_4',
		'description' => '',
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"edit_field_class" => "no-device-group constrain-icon",
		'value' => array(esc_html__('Yes', 'salient-core') => 'yes'),
	),
	array(
		"type" => "nectar_numerical",
		"heading" => "<span>" . esc_html__("Right", "salient-core") . "</span>",
		"param_name" => "padding_right",
		"placeholder" => esc_html__("Right", 'salient-core'),
		"edit_field_class" => "no-device-group col-md-2 constrain_group_4",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'arrow-animation', 'underline')),
		"description" => ''
	),


	array(
		"type" => "nectar_group_header",
		"class" => "",
		"heading" => esc_html__("Advanced", "salient-core"),
		"param_name" => "group_header_5",
		"edit_field_class" => "",
		"value" => ''
	),

	array(
		"type" => "dropdown",
		"heading" => '<span class="group-title">' . esc_html__("Display", "salient-core") . "</span>",
		"param_name" => "display",
		"value" => array(
			esc_html__('Block', 'salient-core') => 'block',
			esc_html__('Inline', 'salient-core') => 'inline',
		),
		'save_always' => true,
		"edit_field_class" => "desktop display-device-group",
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'material', 'arrow-animation', 'underline')),
		"description" => esc_html__("Block will cause the CTA to go a new line, while inline will allow multiple CTA's to appear on the same line.", "salient-core")
	),

	array(
		"type" => "dropdown",
		"heading" => '',
		"param_name" => "display_tablet",
		"value" => array(
			esc_html__('Inherit', 'salient-core') => 'inherit',
			esc_html__('Block', 'salient-core') => 'block',
			esc_html__('Inline', 'salient-core') => 'inline-block',
		),
		'save_always' => true,
		"edit_field_class" => "tablet display-device-group",
		"description" => esc_html__("Block will cause the CTA to go a new line, while inline will allow multiple CTA's to appear on the same line.", "salient-core")
	),
	array(
		"type" => "dropdown",
		"heading" => '',
		"param_name" => "display_phone",
		"value" => array(
			esc_html__('Inherit', 'salient-core') => 'inherit',
			esc_html__('Block', 'salient-core') => 'block',
			esc_html__('Inline', 'salient-core') => 'inline-block',
		),
		'save_always' => true,
		"edit_field_class" => "phone display-device-group",
		"description" => esc_html__("Block will cause the CTA to go a new line, while inline will allow multiple CTA's to appear on the same line.", "salient-core")
	),


	array(
		"type" => "checkbox",
		"class" => "",
		"heading" => esc_html__("Nofollow Link", "salient-core"),
		"param_name" => "nofollow",
		'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
		"dependency" => array('element' => "btn_style", 'value' => array('see-through', 'basic', 'text-reveal-wave', 'material', 'arrow-animation', 'underline')),
		"value" => array(esc_html__("Yes", "salient-core") => 'true'),
		"description" => ""
	),
	array(
		"type" => "textfield",
		"heading" => esc_html__("Extra Class Name", "salient-core"),
		"param_name" => "class",
		"description" => ''
	),

	array(
		'type' => 'dropdown',
		'heading' => __('Icon library', 'salient-core'),
		'value' => array(
			esc_html__('None', 'salient-core') => 'none',
			esc_html__('Font Awesome', 'salient-core') => 'fontawesome',
			esc_html__('Iconsmind', 'salient-core') => 'iconsmind',
			esc_html__('Steadysets', 'salient-core') => 'steadysets',
			esc_html__('Linecons', 'salient-core') => 'linecons',
		),
		'save_always' => true,
		'param_name' => 'icon_family',
		'group' => esc_html__("Icon", "salient-core"),
		"dependency" => array('element' => "btn_style", 'value' => array('basic', 'text-reveal-wave', 'underline')),
		'description' => esc_html__('Select icon library.', 'salient-core'),
	),
	array(
		"type" => "iconpicker",
		"heading" => esc_html__("Icon", "salient-core"),
		"param_name" => "icon_fontawesome",
		"settings" => array("iconsPerPage" => 240),
		'group' => esc_html__("Icon", "salient-core"),
		"dependency" => array('element' => "icon_family", 'emptyIcon' => false, 'value' => 'fontawesome'),
		"description" => esc_html__("Select icon from library.", "salient-core")
	),
	array(
		"type" => "iconpicker",
		"heading" => esc_html__("Icon", "salient-core"),
		"param_name" => "icon_iconsmind",
		"settings" => array('type' => 'iconsmind', 'emptyIcon' => false, "iconsPerPage" => 240),
		'group' => esc_html__("Icon", "salient-core"),
		"dependency" => array('element' => "icon_family", 'value' => 'iconsmind'),
		"description" => esc_html__("Select icon from library.", "salient-core")
	),
	array(
		"type" => "iconpicker",
		"heading" => esc_html__("Icon", "salient-core"),
		"param_name" => "icon_linecons",
		"settings" => array('type' => 'linecons', 'emptyIcon' => false, "iconsPerPage" => 240),
		'group' => esc_html__("Icon", "salient-core"),
		"dependency" => array('element' => "icon_family", 'value' => 'linecons'),
		"description" => esc_html__("Select icon from library.", "salient-core")
	),
	array(
		"type" => "iconpicker",
		"heading" => esc_html__("Icon", "salient-core"),
		"param_name" => "icon_steadysets",
		"settings" => array('type' => 'steadysets', 'emptyIcon' => false, "iconsPerPage" => 240),
		'group' => esc_html__("Icon", "salient-core"),
		"dependency" => array('element' => "icon_family", 'value' => 'steadysets'),
		"description" => esc_html__("Select icon from library.", "salient-core")
	),
);

$position_group = SalientWPbakeryParamGroups::position_group(esc_html__('Positioning', 'salient-core'));

$imported_groups = array($position_group);

foreach ($imported_groups as $group) {

    foreach ($group as $option) {
        $nectar_cta_params[] = $option;
    }
}

return array(
	"name" => esc_html__("Call To Action", "salient-core"),
	"base" => "nectar_cta",
	"icon" => "icon-cta",
	'weight' => '10',
	"category" => esc_html__('Interactive', 'salient-core'),
	"description" => esc_html__('minimal & animated', 'salient-core'),
	"params" => $nectar_cta_params
);
