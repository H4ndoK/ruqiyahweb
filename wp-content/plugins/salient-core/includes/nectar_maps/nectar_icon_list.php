<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);

$el_color_list = array(
    esc_html__( "Default (inherit from row Text Color)", "salient-core") => "default",
	esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3",
	esc_html__( "Color Gradient 1", "salient-core") => "extra-color-gradient-1",
	esc_html__( "Color Gradient 2", "salient-core") => "extra-color-gradient-2"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name"  => esc_html__("Icon List", "salient-core"),
	"base" => "nectar_icon_list",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-fancy-ul",
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Create an icon list', 'salient-core'),
	"params" => array(
		
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Animate Element?",
			"value" => array("Yes, please" => "true" ),
			"param_name" => "animate",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Icon Color",
			"param_name" => "color",
			"value" => $el_color_list,
			'save_always' => true,
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Direction", "salient-core"),
			"param_name" => "direction",
			"value" => array(
				esc_html__( "Vertical", "salient-core") => "vertical",
				esc_html__( "Horizontal", "salient-core") => "horizontal"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the direction you would like your list items to display in", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Columns", "salient-core"),
			"param_name" => "columns",
			"value" => array(
				"Default (3)" => "default",
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
			),
			"dependency" => array('element' => "direction", 'value' => 'horizontal'),
			'save_always' => true,
			"description" => esc_html__("Please select the column number you desire for your icon list items", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Icon Size", "salient-core"),
			"param_name" => "icon_size",
			"value" => array(
				esc_html__( "Small", "salient-core") => "small",
				esc_html__( "Medium", "salient-core") => "medium",
				esc_html__( "Large", "salient-core") => "large"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the size you would like your list item icons to display in", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Icon Style", "salient-core"),
			"param_name" => "icon_style",
			"value" => array(
				esc_html__( "Icon Colored W/ BG", "salient-core") => "border",
				esc_html__( "Icon Colored No BG", "salient-core") => "no-border"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the style you would like your list item icons to display in", "salient-core")
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
	[nectar_icon_list_item title="'.esc_html__('List Item','salient-core').'" id="'.$tab_id_1.'"]  [/nectar_icon_list_item]
	[nectar_icon_list_item title="'.esc_html__('List Item','salient-core').'" id="'.$tab_id_2.'"] [/nectar_icon_list_item]
	',
	"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
);

?>