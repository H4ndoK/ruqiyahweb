<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);

return array(
	"name"  => esc_html__("Clients Display", "salient-core"),
	"base" => "clients",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-clients",
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Show off your clients!', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Columns", "salient-core"),
			"param_name" => "columns",
			"value" => array(
				"Two" => "2",
				"Three" => "3",	
				"Four" => "4",
				"Five" => "5",
				"Six" => "6"
			),
			'save_always' => true,
			"description" => esc_html__("Please select how many columns you would like..", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Hover Effect", "salient-core"),
			"param_name" => "hover_effect",
			"value" => array(
				"Opacity Change" => "opacity",
				"Greyscale to Color" => "greyscale_to_color",	
			),
			'save_always' => true,
			"description" => esc_html__("Select your desired hover effect", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Additional Logo Padding", "salient-core"),
			"param_name" => "additional_padding",
			"value" => array(
				"None" => "none",
				"A little" => "2",	
				"Medium" => "3",
				"A lot" => "4",
			),
			'save_always' => true,
			"description" => esc_html__("Please select if you would like any additional padding between your client logos", "salient-core")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Fade In One By One?", "salient-core"),
			"value" => array("Yes, please" => "true" ),
			"param_name" => "fade_in_animation",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Turn Into Carousel", "salient-core"),
			"value" => array("Yes, please" => "true" ),
			"param_name" => "carousel",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Disable Autorotate", "salient-core"),
			"value" => array("Yes, please" => "true" ),
			"param_name" => "disable_autorotate",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "carousel", 'not_empty' => true),
			"description" => ""
		)
	),
	"custom_markup" => '
	<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
	<ul class="tabs_controls">
	</ul>
	%content%
	</div>'
	,
	'default_content' => '
	[client title="'.esc_html__('Client','salient-core').'" id="'.$tab_id_1.'"] Click the edit button to add your testimonial. [/client]
	[client title="'.esc_html__('Client','salient-core').'" id="'.$tab_id_2.'"] Click the edit button to add your testimonial. [/client]
	',
	"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
);

?>