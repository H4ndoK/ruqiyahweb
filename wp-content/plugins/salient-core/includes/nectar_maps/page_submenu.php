<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);

return array(
	"name"  => esc_html__("Page Submenu", "salient-core"),
	"base" => "page_submenu",
	"show_settings_on_create" => true,
	"is_container" => true,
	"icon" => "icon-wpb-page-submenu",
	"category" => esc_html__('Structure', 'salient-core'),
	"description" => esc_html__('Great for animated anchors', 'salient-core'),
	"params" => array( 
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Link Alignment", "salient-core"),
			"param_name" => "alignment",
			"value" => array(
				esc_html__("Center", "salient-core") => "center",
				esc_html__("Left", "salient-core") => "left",	
				esc_html__("Right", "salient-core") => "right"
			),
			'save_always' => true,
			"description" => esc_html__("Please select your desired link alignment", "salient-core")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => "Sticky?",
			"value" => array("Yes, please" => "true" ),
			"param_name" => "sticky",
			"description" => esc_html__("This will cause your submenu to stick to the top when scrolled by", "salient-core")
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Menu BG Color", "salient-core"),
			"param_name" => "bg_color",
			"value" => "#f7f7f7",
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => esc_html__("Link Color", "salient-core"),
			"param_name" => "link_color",
			"value" => "#000000",
			"description" => ""
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
	[page_link link_url="#" title="'.esc_html__('Link','salient-core').'" id="'.$tab_id_1.'"] [/page_link]
	[page_link link_url="#" title="'.esc_html__('Link','salient-core').'" id="'.$tab_id_2.'"]  [/page_link]
	',
	"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
);


?>