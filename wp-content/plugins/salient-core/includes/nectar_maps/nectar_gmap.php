<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"name" => esc_html__("Interactive Map", "salient-core"),
	"base" => "nectar_gmap",
	"icon" => "icon-wpb-map",
	"category" => esc_html__('Interactive', 'salient-core'),
	"description" => esc_html__('Flexible Custom Map', 'salient-core'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Map Type", "salient-core"),
			"param_name" => "map_type",
			"value" => array(
				esc_html__("Google Map", "salient-core") => "google",
				esc_html__("Leaflet (Recommended)", "salient-core") => "leaflet",
			),
			'save_always' => true,
			"description" => esc_html__("With the introduction of the new Google Maps Platform (June 2018), Dynamic Google Maps are now a premium service which require a monthly fee. Because of this, we've integrated a free open source map solution known as Leaflet. If you choose to use Google, ensure you have a valid map API key entered into Salient options panel > general settings > css/script related tab.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Map height", "salient-core"),
			"param_name" => "size",
			"description" => esc_html__('Enter map height in pixels. Example: 200.', "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Map Center Point Latitude", "salient-core"),
			"param_name" => "map_center_lat",
			"description" => esc_html__("Please enter the latitude for the maps center positioning point.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Map Center Point Longitude", "salient-core"),
			"param_name" => "map_center_lng",
			"description" => esc_html__("Please enter the longitude for the maps center positioning point.", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Map Zoom", "salient-core"),
			"param_name" => "zoom",
			'save_always' => true,
			"value" => array(esc_html__("14 - Default", "salient-core") => 14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20)
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Enable Zoom In/Out", "salient-core"),
			"param_name" => "enable_zoom",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "map_type", 'value' => array('google')),
			"description" => esc_html__("Do you want users to be able to zoom in/out on the map?", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => true),
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Marker Style", "salient-core"),
			"param_name" => "marker_style",
			"value" => array(
				esc_html__("Default Style", "salient-core") => "default",
				esc_html__("Nectar Animated", "salient-core") => "nectar",
			),
			'save_always' => true,
			"description" => esc_html__("Please select the marker style you would like. Default Style will display the standard map marker and also allow you to optionally override it with an image. Nectar Animated will use a custom Nectar CSS based marker (the modern option).", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Marker Color", "salient-core"),
			"param_name" => "nectar_marker_color",
			"value" => array(
				esc_html__( "Accent Color", "salient-core") => "accent-color",
				esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
				esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
				esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
			),
			'save_always' => true,
			"dependency" => Array('element' => "map_type", 'value' => array('google')),
			"description" => esc_html__("Please select the color for your nectar marker. Will only be used with the Nectar Animated Marker Style", "salient-core")
		),
		
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Marker Color", "salient-core"),
			"param_name" => "color",
			"value" => array(
				esc_html__( "Accent Color", "salient-core") => "accent-color",
				esc_html__( "Extra Color 1", "salient-core") => "extra-color-1",
				esc_html__( "Extra Color 2", "salient-core") => "extra-color-2",	
				esc_html__( "Extra Color 3", "salient-core") => "extra-color-3",
			),
			'save_always' => true,
			"dependency" => Array('element' => "map_type", 'value' => array('leaflet')),
			"description" => esc_html__("Please select the color for your marker.", "salient-core")
		),
		
		array(
			"type" => "attach_image",
			"heading" => esc_html__("Marker Image", "salient-core"),
			"param_name" => "marker_image",
			"value" => "",
			"description" => esc_html__("Select image from media library. Will only be used with the Default Marker Style.", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Image Width", "salient-core"),
			"param_name" => "marker_image_width",
			"dependency" => Array('element' => "map_type", 'value' => array('leaflet')),
			"description" => esc_html__("Please enter the width in px that you would like your custom marker image to display as", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Image Height", "salient-core"),
			"param_name" => "marker_image_height",
			"dependency" => Array('element' => "map_type", 'value' => array('leaflet')),
			"description" => esc_html__("Please enter the height in px that you would like your custom marker image to display as", "salient-core")
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Marker Animation", "salient-core"),
			"param_name" => "marker_animation",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "map_type", 'value' => array('google')),
			"description" => esc_html__("This will cause your markers to do a quick bounce as they load in.", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => true),
		),
		
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Greyscale Color", "salient-core"),
			"param_name" => "map_greyscale",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "map_type", 'value' => array('google')),
			"description" => esc_html__("Toggle a greyscale color scheme (will also unlock further custom options)", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => true),
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Greyscale Color", "salient-core"),
			"param_name" => "leaflet_map_greyscale",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "map_type", 'value' => array('leaflet')),
			"description" => esc_html__("Toggle a greyscale color scheme", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => true),
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Marker Description Info Window(s) Start Open", "salient-core"),
			"param_name" => "infowindow_start_open",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "map_type", 'value' => array('leaflet')),
			"description" => esc_html__("Enabling this will cause the description(s) you set for your markers to be visible to your users before they click on the marker", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => true),
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => "Map Extra Color",
			"param_name" => "map_color",
			"value" => "",
			"dependency" => Array('element' => "map_greyscale", 'not_empty' => true),
			"description" => "Use this to define a main color that will be used in combination with the greyscale option for your map"
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Ultra Flat Map", "salient-core"),
			"param_name" => "ultra_flat",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "map_greyscale", 'not_empty' => true),
			"description" => esc_html__("This removes street/landmark text & some extra details for a clean look", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => true),
		),
		array(
			"type" => 'checkbox',
			"heading" => esc_html__("Dark Color Scheme", "salient-core"),
			"param_name" => "dark_color_scheme",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"dependency" => Array('element' => "map_greyscale", 'not_empty' => true),
			"description" => esc_html__("Enable this option for a dark colored map (This will override the extra color choice)", "salient-core"),
			"value" => Array(esc_html__("Yes, please", "salient-core") => true),
		),
		
		array(
			"type" => "textarea",
			"heading" => esc_html__("Map Marker Locations", "salient-core"),
			"param_name" => "map_markers",
			"description" => esc_html__("Please enter the the list of locations you would like with a latitude|longitude|description format. Divide values with linebreaks (Enter). Example:", "salient-core") . "<br/>" . esc_html__("39.949|-75.171|Our Location", "salient-core") . '<br/>' . esc_html__("40.793|-73.954|Our Location #2", "salient-core")
		),
		
	)
);
?>