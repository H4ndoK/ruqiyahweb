<?php 

return array(
	  "name" => esc_html__("Social Buttons", "salient-social"),
	  "base" => "social_buttons",
	  "icon" => "icon-wpb-social-buttons",
	  "category" => esc_html__('Content', 'salient-social'),
	  "description" => esc_html__('Add social buttons to any page', 'salient-social'),
	  "params" => array(
			array(
			 "type" => "dropdown",
			 "heading" => esc_html__("Social Button Style", "salient-social"),
			 "param_name" => "style",
			 "value" => array(
				 esc_html__('All visible', 'salient-social') => 'default',
				 esc_html__('Fixed to screen', 'salient-social') => 'fixed',
				 esc_html__('Show on hover', 'salient-social') => 'hover'
			 ),
			 "description" => esc_html__('Please select your social button style here', 'salient-social'),
		 ),
	 	 array(
	      "type" => 'checkbox',
	      "heading" => esc_html__("Nectar Love", "salient-social"),
	      "param_name" => "nectar_love",
				"dependency" => Array('element' => "style", 'value' => array('hover','default') ),
	      "value" => Array(esc_html__("Yes", "salient-social") => 'true')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => esc_html__("Facebook", "salient-social"),
	      "param_name" => "facebook",
	      "value" => Array(esc_html__("Yes", "salient-social") => 'true')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => esc_html__("Twitter", "salient-social"),
	      "param_name" => "twitter",
	      "value" => Array(esc_html__("Yes", "salient-social") => 'true')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => esc_html__("LinkedIn", "salient-social"),
	      "param_name" => "linkedin",
	      "value" => Array(esc_html__("Yes", "salient-social") => 'true')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => esc_html__("Pinterest", "salient-social"),
	      "param_name" => "pinterest",
	      "description" => '',
	      "value" => Array(esc_html__("Yes", "salient-social") => 'true')
	    )
	  )
	);

?>