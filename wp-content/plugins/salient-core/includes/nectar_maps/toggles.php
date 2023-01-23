<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Toggle Panels", "salient-core"),
	"base" => "toggles",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-ui-accordion",
	"category" => esc_html__('Interactive', 'salient-core'),
	"description" => esc_html__('jQuery toggles/accordion', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", "salient-core"),
			"param_name" => "style",
			"admin_label" => true,
			"value" => array(
				esc_html__("Default", "salient-core") => "default",
				esc_html__("Minimal", "salient-core") => "minimal",
				esc_html__("Minimal Shadow", "salient-core") => "minimal_shadow",
				esc_html__("Minimal Small", "salient-core") => "minimal_small",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the style you desire for your toggle element.", "salient-core")
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Accordion Toggles", "salient-core"),
			"param_name" => "accordion",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => esc_html__("Selecting this will make it so that only one toggle can be opened at a time.", "salient-core"),
			"value" => Array(esc_html__("Allow", "salient-core") => 'true')
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Starting Functionality", "salient-core"),
			"param_name" => "accordion_starting_functionality",
			"admin_label" => true,
			"value" => array(
				esc_html__("First Toggle Open", "salient-core") => "default",
				esc_html__("First Toggle Closed", "salient-core") => "closed",
			),
			"dependency" => Array('element' => "accordion", 'not_empty' => true),
			'save_always' => true,
		),
		array(
            "type" => "dropdown",
            "heading" => esc_html__("Border Radius", "salient-core"),
            'save_always' => true,
			"dependency" => Array('element' => "style", 'value' => array('minimal_shadow', 'default')),
            "param_name" => "border_radius",
            "value" => array(
              esc_html__("0px", "salient-core") => "none",
              esc_html__("3px", "salient-core") => "3px",
              esc_html__("5px", "salient-core") => "5px",
              esc_html__("10px", "salient-core") => "10px",
              esc_html__("15px", "salient-core") => "15px",
              esc_html__("20px", "salient-core") => "20px"),
            "description" => ''
          ),
	),
	"custom_markup" => '
	<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
	%content%
	</div>
	<div class="tab_controls">
	<a class="add_tab" title="' . esc_html__( 'Add section', 'salient-core' ) . '"><span class="vc_icon"></span> <span class="tab-label">' . esc_html__( 'Add section', 'salient-core' ) . '</span></a>
	</div>
	',
	'default_content' => '
	[toggle title="'.esc_html__('Section', "salient-core").'"][/toggle]
	[toggle title="'.esc_html__('Section', "salient-core").'"][/toggle]
	',
	'js_view' => 'VcAccordionView'
);
?>