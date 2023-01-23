<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$el_color_list = array(
    esc_html__( "Accent Color", "salient-core") => "Accent-Color",
	esc_html__( "Extra Color 1", "salient-core") => "Extra-Color-1",
	esc_html__( "Extra Color 2", "salient-core") => "Extra-Color-2",	
	esc_html__( "Extra Color 3", "salient-core") => "Extra-Color-3"
);
$custom_colors = apply_filters('nectar_additional_theme_colors', array());
$el_color_list = array_merge($el_color_list, $custom_colors);

return array(
	"name" => esc_html__("Team Member", "salient-core"),
	"base" => "team_member",
	"icon" => "icon-wpb-team-member",
	"category" => esc_html__('Content', 'salient-core'),
	"description" => esc_html__('Add a team member element', 'salient-core'),
	"params" => array(
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Image", "salient-core"),
			"param_name" => "image_url",
			"value" => "",
			"description" => esc_html__("Select image from media library.", "salient-core")
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Bio Image", "salient-core"),
			"param_name" => "bio_image_url",
			"value" => "",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen')),
			"description" => esc_html__("Image Size Guidelines", "salient-core") . "<br/><strong>" . esc_html__("Bio Image:", "salient-core") . "</strong>" . esc_html__("large with a portrait aspect ratio - will be shown at the full screen height at 50% of the page width.", "salient-core") . "<br/> <strong>" . esc_html__("Team Small Image:", "salient-core") . "</strong> " . esc_html__("Will display at 500x500 so ensure the image you're uploading is at least that size.", "salient-core")
		),
		array(
			"type" => "fws_image",
			"heading" => esc_html__("Bio Image", "salient-core"),
			"param_name" => "bio_alt_image_url",
			"value" => "",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen_alt')),
			"description" => esc_html__("Image Size Guidelines", "salient-core") . "<br/><strong>" . esc_html__("Bio Image:", "salient-core") . "</strong>" . esc_html__("large with a portrait aspect ratio - will be shown at the full screen height at 50% of the page width.", "salient-core") . "<br/> <strong>" . esc_html__("Team Small Image:", "salient-core") . "</strong> " . esc_html__("Will display at true aspect ratio of the image provided.", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Team Member Stlye", "salient-core"),
			"param_name" => "team_memeber_style",
			"value" => array(
				esc_html__("Meta Below", "salient-core") => "meta_below",
				esc_html__("Meta Overlaid", "salient-core") => "meta_overlaid",
				esc_html__("Meta Overlaid alt", "salient-core") => "meta_overlaid_alt",
				esc_html__("Meta Overlaid, Bio Modal", "salient-core") => "bio_fullscreen",
				esc_html__("Meta Below, Bio Modal", "salient-core") => "bio_fullscreen_alt"
			),
			'save_always' => true,
			"description" => esc_html__("Please select the style you desire for your team member.", "salient-core")
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Enable Image Parallax", "salient-core"),
			"param_name" => "bio_fullscreen_alt_parallax",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => array(esc_html__("Yes", "salient-core") => 'true'),
			"dependency" => array('element' => "team_memeber_style", 'value' => 'bio_fullscreen_alt'),
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Hide Link Arrow", "salient-core"),
			"param_name" => "bio_fullscreen_alt_hide_link_arrow",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"value" => array(esc_html__("Yes", "salient-core") => 'true'),
			"dependency" => array('element' => "team_memeber_style", 'value' => 'bio_fullscreen_alt'),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Image size", "salient-core"),
			"param_name" => "image_size",
			"description" => esc_html__("Optionally enter a custom WordPress image size. Example: \"thumbnail\", \"medium\", \"large\", \"full\".", "salient-core"),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => esc_html__("Image Loading", "salient-core"),
			"param_name" => "image_loading",
			"value" => array(
				"Default" => "default",
				"Lazy Load" => "lazy-load",
			),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('meta_overlaid','meta_overlaid_alt','bio_fullscreen','bio_fullscreen_alt')),
			"description" => esc_html__("Determine whether to load the image on page load or to use a lazy load method for higher performance.", "salient-core"),
			'std' => 'default',
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Name", "salient-core"),
			"param_name" => "name",
			"admin_label" => true,
			"description" => esc_html__("Please enter the name of your team member", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Job Position", "salient-core"),
			"param_name" => "job_position",
			"admin_label" => true,
			"description" => esc_html__("Please enter the job position for your team member", "salient-core")
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Team Member Mini Biography", "salient-core"),
			"param_name" => "team_member_mini_bio",
			"description" => esc_html__("Short text which will be shown directly under the team member image.", "salient-core"),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen_alt'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			'save_always' => true,
			"heading" => "Biography Content",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => esc_html__("If you will be adding HTML elements to your biography, choose the Text + HTML option (For full backwards compatibility, this needs to be explicitly set)", "salient-core"),
			"param_name" => "team_member_bio_full_html",
			"value" => array(
				"Simple Text (Legacy)" => "simple",
				"Text + HTML" => "html"
			)),
			
		array(
			"type" => "textarea",
			"heading" => esc_html__("Team Member Biography (Simple Text)", "salient-core"),
			"param_name" => "team_member_bio",
			"description" => esc_html__("The main text portion of your team member", "salient-core"),
			"dependency" => Array('element' => "team_member_bio_full_html", 'value' => array('simple'))
		),
		array(
			"type" => "textarea_html",
			"heading" => esc_html__("Team Member Biography (HTML Enabled)", "salient-core"),
			"param_name" => "content",
			"description" => esc_html__("The main text portion of your team member", "salient-core"),
			"dependency" => Array('element' => "team_member_bio_full_html", 'value' => array('html'))
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Description", "salient-core"),
			"param_name" => "description",
			"description" => esc_html__("The main text portion of your team member", "salient-core"),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('meta_below'))
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Social Icon", "salient-core"),
			"param_name" => "social_icon_1",
			"settings" => array( "emptyIcon" => true, "iconsPerPage" => 240 ),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Social Link", "salient-core"),
			"param_name" => "social_link_1",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => esc_html__("Please enter the URL here", "salient-core")
		),
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Social Icon 2", "salient-core"),
			"param_name" => "social_icon_2",
			"settings" => array( "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Social Link 2", "salient-core"),
			"param_name" => "social_link_2",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => esc_html__("Please enter the URL here", "salient-core")
		),
		
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Social Icon 3", "salient-core"),
			"param_name" => "social_icon_3",
			"settings" => array( "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Social Link 3", "salient-core"),
			"param_name" => "social_link_3",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => esc_html__("Please enter the URL here", "salient-core")
		),
		
		array(
			"type" => "iconpicker",
			"heading" => esc_html__("Social Icon 4", "salient-core"),
			"param_name" => "social_icon_4",
			"settings" => array( "emptyIcon" => true, "iconsPerPage" => 240),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Social Link 4", "salient-core"),
			"param_name" => "social_link_4",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('bio_fullscreen','bio_fullscreen_alt')),
			"description" => esc_html__("Please enter the URL here", "salient-core")
		),
		
		array(
			"type" => "textarea",
			"heading" => esc_html__("Social Media", "salient-core"),
			"param_name" => "social",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('meta_below')),
			"description" => esc_html__("Enter any social media links with a comma separated list. e.g. Facebook,http://facebook.com, Twitter,http://twitter.com", "salient-core")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Team Member Link Type", "salient-core"),
			"param_name" => "link_element",
			"value" => array(
				"None" => "none",
				"Image" => "image",
				"Name" => "name",	
				"Both" => "both"
			),
			'save_always' => true,
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('meta_below')),
			"description" => esc_html__("Please select how you wish to link your team member to an arbitrary URL", "salient-core")
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Team Member Link URL", "salient-core"),
			"param_name" => "link_url",
			"admin_label" => false,
			"description" => esc_html__("Please enter the URL for your team member link", "salient-core"),
			"dependency" => Array('element' => "link_element", 'value' => array('image', 'name', 'both'))
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Team Member Link URL", "salient-core"),
			"param_name" => "link_url_2",
			"admin_label" => false,
			"description" => esc_html__("Please enter the URL for your team member link", "salient-core"),
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('meta_overlaid','meta_overlaid_alt')),
		),
		array(
			"type" => "checkbox",
			"class" => "",
			'edit_field_class' => 'vc_col-xs-12 salient-fancy-checkbox',
			"heading" => "Open Team Member Link In New Tab",
			"value" => array("Yes, please" => "true" ),
			"param_name" => "team_member_link_new_tab",
			"description" => "",
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('meta_below','meta_overlaid','meta_overlaid_alt')),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Link Color", "salient-core"),
			"param_name" => "color",
			"value" => $el_color_list,
			'save_always' => true,
			"dependency" => Array('element' => "team_memeber_style", 'value' => array('meta_below')),
			'description' => esc_html__( 'Choose a color from your','salient-core') . ' <a target="_blank" href="'. esc_url(NectarThemeInfo::global_colors_tab_url()) .'"> ' . esc_html__('globally defined color scheme','salient-core') . '</a>',
		)
	)
);

?>