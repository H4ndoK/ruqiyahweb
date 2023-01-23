<?php 

/**
  * Salient Social customizer options.
  *
  * @param WP_Customize_Manager $wp_customize Theme Customizer object.
  */
function salient_social_register_theme_customizer( $wp_customize ) {
  

  // Create section.
	$wp_customize->add_section( 'salient_social_options', array(
			'title'     => 'Salient Social',
			'priority'  => 200
		)
	);
  
  
  if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
    $nectar_options = get_nectar_theme_options();
    $accent_color_default = $nectar_options["accent-color"];
  } else {
    $accent_color_default = '#000000';
  }
  // Accent color.
  $wp_customize->add_setting( 'salient_social_accent_color', array(
      'type'              => 'option',
      'default'     	    => $accent_color_default,
      'sanitize_callback' => 'sanitize_hex_color'
    )
  );
  
  $wp_customize->add_control(
    new WP_Customize_Color_Control($wp_customize, 'salient_social_accent_color', array(
          'label'       => esc_html__( 'Accent Color', 'salient-social' ),
          'description' => esc_html__( 'Will be used for social buttons.', 'salient-social' ),
          'section'     => 'salient_social_options',
          'settings'    => 'salient_social_accent_color'
      )
    )
  );
  
  
	// Apply accent color to all.
	$wp_customize->add_setting( 'salient_social_override_social_color', array(
      'type'              => 'option',
			'default'    	      => 'override',
			'sanitize_callback' => 'salient_social_sanitize_radioselect',
		)
	);
	$wp_customize->add_control( 'salient_social_override_social_color', array(
			'section'     => 'salient_social_options',
			'label'       => esc_html__( 'The Accent Color Will', 'salient-social' ),
      'choices'     => array(
          'override' => esc_html__('Override default branding colors','salient-social'),
          'only_when_needed' => esc_html__('Apply only where needed','salient-social')             
        ),
			'type' => 'radio'
		)
	);
  
  
  // Use Facebook.
	$wp_customize->add_setting( 'salient_social_use_facebook', array(
      'type'              => 'option',
			'default'    	      => '1',
			'sanitize_callback' => 'salient_social_sanitize_input',
		)
	);
	$wp_customize->add_control( 'salient_social_use_facebook', array(
			'section'     => 'salient_social_options',
			'label'       => esc_html__( 'Use Facebook Button', 'salient-social' ),
			'type'        => 'checkbox'
		)
	);
  
  
  // Use Twitter.
	$wp_customize->add_setting( 'salient_social_use_twitter', array(
      'type'              => 'option',
			'default'    	      => '1',
			'sanitize_callback' => 'salient_social_sanitize_input',
		)
	);
	$wp_customize->add_control( 'salient_social_use_twitter', array(
			'section'     => 'salient_social_options',
			'label'       => esc_html__( 'Use Twitter Button', 'salient-social' ),
			'type'        => 'checkbox'
		)
	);
  
  // Use LinkedIn.
	$wp_customize->add_setting( 'salient_social_use_linkedin', array(
      'type'              => 'option',
			'default'    	      => '1',
			'sanitize_callback' => 'salient_social_sanitize_input',
		)
	);
	$wp_customize->add_control( 'salient_social_use_linkedin', array(
			'section'     => 'salient_social_options',
			'label'       => esc_html__( 'Use LinkedIn Button', 'salient-social' ),
			'type'        => 'checkbox'
		)
	);

  // Use Pinterest.
  $wp_customize->add_setting( 'salient_social_use_pinterest', array(
      'type'              => 'option',
      'default'    	      => '1',
      'sanitize_callback' => 'salient_social_sanitize_input',
    )
  );
  $wp_customize->add_control( 'salient_social_use_pinterest', array(
      'section'     => 'salient_social_options',
      'label'       => esc_html__( 'Use Pinterest Button', 'salient-social' ),
      'type'        => 'checkbox'
    )
  );
  
  // Remove Nectar Love.
  $wp_customize->add_setting( 'salient_social_remove_love', array(
      'type'              => 'option',
      'default'    	      => '',
      'sanitize_callback' => 'salient_social_sanitize_input',
    )
  );
  $wp_customize->add_control( 'salient_social_remove_love', array(
      'section'     => 'salient_social_options',
      'label'       => esc_html__( 'Remove Nectar Love Button', 'salient-social' ),
      'type'        => 'checkbox'
    )
  );
  
  // Style select.
  $wp_customize->add_setting( 'salient_social_button_style', array(
          'type'              => 'option',
          'default'     	    => 'fixed',
          'sanitize_callback' => 'salient_social_sanitize_radioselect',
      )
  );
  
  // For non Salient themes.
  if( ! defined( 'NECTAR_THEME_NAME' ) ) { 

    $wp_customize->add_control( 'salient_social_button_style', array(
            'label'       => esc_html__( 'Style', 'theme_slug' ),
            'description' => esc_html__( 'Will be used for social buttons automatically added to posts.', 'salient-social' ),
            'section'     => 'salient_social_options',
            'choices' => array(
                'default' => esc_html__('All Visible','salient-social'),
                'fixed'   => esc_html__('Fixed to screen','salient-social'),
                'hover'   => esc_html__('Show on hover','salient-social')               
            ),
            'type' => 'radio'
        )
    );     
  } 
  
  else {

    $wp_customize->add_control( 'salient_social_button_style', array(
            'label'       => esc_html__( 'Style', 'theme_slug' ),
            'description' => 'For "Determined by theme settings" option:' . '<br/><br/>' . esc_html__( 'Blog posts: Determined by "Blog header type".', 'salient-social' ) . '<br/>' . esc_html__( 'Portfolio projects: Determined by use of "full width item layout".', 'salient-social' ) ,
            'section'     => 'salient_social_options',
            'choices' => array(
                'fixed'   => esc_html__('Fixed to screen','salient-social'),  
                'default' => esc_html__('Determined by theme settings','salient-social'),     
            ),
            'type' => 'radio'
        )
    ); 
    
  }
    
}



add_action( 'customize_register', 'salient_social_register_theme_customizer' );


/**
 * Checkbox Sanitzation.
 *
 */
 function salient_social_sanitize_checkbox( $input ){
    return ( isset( $input ) ? true : false );
}

/**
 * Input Sanitzation.
 *
 */
function salient_social_sanitize_input( $input ) {
	return strip_tags( stripslashes( $input ) );
} 

/**
 * Radio and Select Sanitzation.
 *
 */
function salient_social_sanitize_radioselect( $input, $setting ){
         
    $input = sanitize_key($input);

    $choices = $setting->manager->get_control( $setting->id )->choices;
                     
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
     
}
        


?>