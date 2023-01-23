<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Food Menu Item", "salient-core"),
	"base" => "nectar_food_menu_item",
	"icon" => "icon-wpb-food-menu",
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Create restaurant menus', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Style", "salient-core"),
			"param_name" => "style",
			"value" => array(
				esc_html__('Default', 'salient-core') => 'default',
				esc_html__('Line From Name To Price', 'salient-core') => 'line_between'
			),
			'save_always' => true,
			"description" => esc_html__("Please select the desired style for your item", "salient-core")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"description" => esc_html__("The item name", "salient-core"),
			"heading" => esc_html__("Item Name", "salient-core"),
			"admin_label" => true,
			"param_name" => "item_name"
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Item Price", "salient-core"),
			"param_name" => "item_price",
			"admin_label" => true,
			"description" => esc_html__("The price of your item - include the currency symbol of your choosing i.e. \"$29\"", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Item Name Heading Tag", "salient-core"),
			"param_name" => "item_name_heading_tag",
			"value" => array(
				'H3' => 'h3',
				'H4' => 'h4',
				'H5' => 'h5',
				'H6' => 'h6'
			),
			'save_always' => true,
			"description" => esc_html__("Please select the desired heading tag for your item name", "salient-core")
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Item Description", "salient-core"),
			"param_name" => "item_description",
			"description" => esc_html__("Please enter description for your item", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Extra Class Name", "salient-core"),
			"param_name" => "class",
			"description" => ''
		),
	)
);

?>