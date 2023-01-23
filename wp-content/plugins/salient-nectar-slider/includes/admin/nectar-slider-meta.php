<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('add_meta_boxes', 'nectar_metabox_nectar_slider');

if( !function_exists('nectar_metabox_nectar_slider') ) {
  
  function nectar_metabox_nectar_slider(){
      
      $meta_box = array(
  		'id' => 'nectar-metabox-nectar-slider',
  		'title' => esc_html__('Slide Settings', 'salient-nectar-slider'),
  		'description' => esc_html__('Please fill out & configure the fields below to create your slide. The only mandatory field is the "Slide Image".', 'salient-nectar-slider'),
  		'post_type' => 'nectar_slider',
  		'context' => 'normal',
  		'priority' => 'high',
  		'fields' => array(
  		
  			array( 
  					'name' => esc_html__('Background Type', 'salient-nectar-slider'),
  					'desc' => esc_html__('Please select the background type you would like to use for your slide.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_bg_type',
  					'type' => 'choice_below',
  					'options' => array(
  						'image_bg' => esc_html__('Image Background', 'salient-nectar-slider'),
  						'video_bg' => esc_html__('Video Background', 'salient-nectar-slider')
  					),
  					'std' => 'image_bg'
  				),
  			array( 
  					'name' => esc_html__('Slide Image', 'salient-nectar-slider'),
  					'desc' => esc_html__('Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_image',
  					'type' => 'file',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Video WebM Upload', 'salient-nectar-slider'),
  					'desc' => esc_html__('Browse for your WebM video file here. This will be automatically played on load so make sure to use this responsibly for enhancing your design, rather than annoy your user. e.g. A video loop with no sound. You must include this format & the mp4 format to render your video with cross browser compatibility. OGV is optional. Video must be in a 16:9 aspect ratio.', 'salient-nectar-slider'),
  					'id' => '_nectar_media_upload_webm',
  					'type' => 'media',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Video MP4 Upload', 'salient-nectar-slider'),
  					'desc' => esc_html__('Browse for your mp4 video file here. See the note above for recommendations on how to properly use your video background.', 'salient-nectar-slider'),
  					'id' => '_nectar_media_upload_mp4',
  					'type' => 'media',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Video OGV Upload', 'salient-nectar-slider'),
  					'desc' => esc_html__('Browse for your OGV video file here.<br/>  See the note above for recommendations on how to properly use your video background.', 'salient-nectar-slider'),
  					'id' => '_nectar_media_upload_ogv',
  					'type' => 'media',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Preview Image', 'salient-nectar-slider'),
  					'desc' => esc_html__('This is the image that will be seen in place of your video on mobile devices & older browsers before your video is played.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_preview_image',
  					'type' => 'file',
  					'std' => ''
  				),
  			array(
  					'name' =>  esc_html__('Add texture overlay to background', 'salient-nectar-slider'),
  					'desc' => esc_html__('If you would like a slight texture overlay on your background, activate this option.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_video_texture',
  					'type' => 'checkbox',
  	                'std' => 1
  				),
        	
  			
  			array( 
  					'name' => esc_html__('Background Alignment', 'salient-nectar-slider'),
  					'desc' => esc_html__('Please choose how you would like your slides background to be aligned', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_slide_bg_alignment',
  					'type' => 'select',
  					'std' => 'center',
  					'options' => array(
  						"top" => "Top",
  				  		 "center" => esc_html__("Center", 'salient-nectar-slider'),
  				  		 "bottom" => esc_html__("Bottom", 'salient-nectar-slider')
  					)
  				),
  				
  			array( 
  					'name' => esc_html__('Slide Font Color', 'salient-nectar-slider'),
  					'desc' => esc_html__('This gives you an easy way to make sure your text is visible regardless of the background.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_slide_font_color',
  					'type' => 'select',
  					'std' => '',
  					'options' => array(
  						'light' => esc_html__('Light', 'salient-nectar-slider'),
  						'dark' => esc_html__('Dark', 'salient-nectar-slider')
  					)
  				),
  				
  			array( 
  					'name' => esc_html__('Heading', 'salient-nectar-slider'),
  					'desc' => esc_html__('Please enter in the heading for your slide.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_heading',
  					'type' => 'text',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Caption', 'salient-nectar-slider'),
  					'desc' => esc_html__('If you have a caption for your slide, enter it here', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_caption',
  					'type' => 'textarea',
  					'std' => ''
  				),
  			array(
  					'name' =>  esc_html__('Caption Background', 'salient-nectar-slider'),
  					'desc' => esc_html__('If you would like to add a semi transparent background to your caption, activate this option.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_caption_background',
  					'type' => 'checkbox',
  	                'std' => ''
  				),	
          
          array( 
    					'name' => esc_html__('Slide Content Desktop Width', 'salient-nectar-slider'),
    					'desc' => esc_html__('Relative to the site content container', 'salient-nectar-slider'),
    					'id' => '_nectar_slider_slide_content_width_desktop',
    					'type' => 'select',
    					'std' => '',
    					'options' => array(
    						'auto' => esc_html__('Auto', 'salient-nectar-slider'),
    						'90%' => '90%',
                '80%' => '80%',
                '70%' => '70%',
                '60%' => '60%',
                '50%' => '50%'
    					)
    				),
          
            array( 
      					'name' => esc_html__('Slide Content Tablet Width', 'salient-nectar-slider'),
      					'desc' => esc_html__('Relative to the site content container', 'salient-nectar-slider'),
      					'id' => '_nectar_slider_slide_content_width_tablet',
      					'type' => 'select',
      					'std' => '',
      					'options' => array(
      						'auto' => esc_html__('Auto', 'salient-nectar-slider'),
      						'90%' => '90%',
                  '80%' => '80%',
                  '70%' => '70%',
                  '60%' => '60%',
                  '50%' => '50%'
      					)
      				),
            
          array( 
    					'name' => esc_html__('Background Overlay Color', 'salient-nectar-slider'),
    					'desc' => esc_html__('This will be applied on top on your BG image (if supplied).', 'salient-nectar-slider'),
    					'id' => '_nectar_slider_bg_overlay_color',
    					'type' => 'color',
    					'std' => ''
    				),
  			array( 
  					'name' => esc_html__('Insert Down Arrow That Leads to Content Below?', 'salient-nectar-slider'),
  					'desc' => esc_html__('This is particularly useful when using tall sliders to let the user know there\'s content underneath.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_down_arrow',
  					'type' => 'checkbox',
  					'std' => ''
  				),	
  			array( 
  					'name' => esc_html__('Link Type', 'salient-nectar-slider'),
  					'desc' => esc_html__('Please select how you would like to link your slide.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_link_type',
  					'type' => 'choice_below',
  					'options' => array(
  						'button_links' => esc_html__('Button Links', 'salient-nectar-slider'),
  						'full_slide_link' => esc_html__('Full Slide Link', 'salient-nectar-slider')
  					),
  					'std' => 'button_links'
  				),	
  			array( 
  					'name' => esc_html__('Button Text', 'salient-nectar-slider'),
  					'desc' => esc_html__('Enter the text for your button here.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button',
  					'type' => 'slider_button_textarea',
  					'std' => '',
  					'extra' => 'first'
  				),
  			array( 
  					'name' => esc_html__('Button Link', 'salient-nectar-slider'),
  					'desc' => esc_html__('Enter a URL here.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button_url',
  					'type' => 'slider_button_textarea',
  					'std' => '',
  					'extra' => 'inline'
  				),
  			array( 
  					'name' => esc_html__('Button Style', 'salient-nectar-slider'),
  					'desc' => esc_html__('Desired button style', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button_style',
  					'type' => 'slider_button_select',
  					'std' => '',
  					'options' => array(
  						'solid_color' => esc_html__('Solid Color BG', 'salient-nectar-slider'),
  						'solid_color_2' => esc_html__('Solid Color BG W/ Tilt Hover', 'salient-nectar-slider'),
  						'transparent' => esc_html__('Transparent With Border', 'salient-nectar-slider'),
  						'transparent_2' => esc_html__('Transparent W/ Solid BG Hover', 'salient-nectar-slider')
  					),
  					'extra' => 'inline'
  				),
  			array( 
  					'name' => esc_html__('Button Color', 'salient-nectar-slider'),
  					'desc' => esc_html__('Desired color', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button_color',
  					'type' => 'slider_button_select',
  					'std' => '',
  					'options' => array(
  						'primary-color' => esc_html__('Primary Color', 'salient-nectar-slider'),
  						'extra-color-1' => esc_html__('Extra Color #1', 'salient-nectar-slider'),
  						'extra-color-2' => esc_html__('Extra Color #2', 'salient-nectar-slider'),
  						'extra-color-3' => esc_html__('Extra Color #3', 'salient-nectar-slider'),
              "extra-color-gradient-1" => esc_html__("Color Gradient 1", 'salient-nectar-slider'),
      		 		"extra-color-gradient-2" => esc_html__("Color Gradient 2", 'salient-nectar-slider'),
              "white" => esc_html__("White & Black Text", 'salient-nectar-slider')
  					),
  					'extra' => 'last'
  				),
  				
  			
  			array( 
  					'name' => esc_html__('Button Text', 'salient-nectar-slider'),
  					'desc' => esc_html__('Enter the text for your button here.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button_2',
  					'type' => 'slider_button_textarea',
  					'std' => '',
  					'extra' => 'first'
  				),
  			array( 
  					'name' => esc_html__('Button Link', 'salient-nectar-slider'),
  					'desc' => esc_html__('Enter a URL here.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button_url_2',
  					'type' => 'slider_button_textarea',
  					'std' => '',
  					'extra' => 'inline'
  				),
  			array( 
  					'name' => esc_html__('Button Style', 'salient-nectar-slider'),
  					'desc' => esc_html__('Desired button style', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button_style_2',
  					'type' => 'slider_button_select',
  					'std' => '',
  					'options' => array(
  						'solid_color' => esc_html__('Solid Color Background', 'salient-nectar-slider'),
  						'solid_color_2' => esc_html__('Solid Color BG W/ Tilt Hover', 'salient-nectar-slider'),
  						'transparent' => esc_html__('Transparent With Border', 'salient-nectar-slider'),
  						'transparent_2' => esc_html__('Transparent W/ Solid BG Hover', 'salient-nectar-slider')
  					),
  					'extra' => 'inline'
  				),
  			array( 
  					'name' => esc_html__('Button Color', 'salient-nectar-slider'),
  					'desc' => esc_html__('Desired color', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_button_color_2',
  					'type' => 'slider_button_select',
  					'std' => '',
  					'options' => array(
  						'primary-color' => esc_html__('Primary Color', 'salient-nectar-slider'),
  						'extra-color-1' => esc_html__('Extra Color #1', 'salient-nectar-slider'),
  						'extra-color-2' => esc_html__('Extra Color #2', 'salient-nectar-slider'),
  						'extra-color-3' => esc_html__('Extra Color #3', 'salient-nectar-slider'),
              "extra-color-gradient-1" => esc_html__("Color Gradient 1", 'salient-nectar-slider'),
      		 		"extra-color-gradient-2" => esc_html__("Color Gradient 2", 'salient-nectar-slider'),
              "white" => esc_html__("White & Black Text", 'salient-nectar-slider')
  					),
  					'extra' => 'last'
  				),
  				
  			array( 
  					'name' => esc_html__('Slide Link', 'salient-nectar-slider'),
  					'desc' => esc_html__('Please enter your URL that will be used to link the slide.', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_entire_link',
  					'type' => 'text',
  					'std' => ''
  				),
  				
  			array( 
  					'name' => esc_html__('Slide Video Popup', 'salient-nectar-slider'),
  					'desc' => esc_html__('Enter in an embed code from Youtube or Vimeo that will be used to display your video in a popup. (You can also use the WordPress video shortcode)', 'salient-nectar-slider'),
  					'id' => '_nectar_slider_video_popup',
  					'type' => 'textarea',
  					'std' => ''
  				),
  				
  			array( 
  					'name' => esc_html__('Slide Content Alignment', 'salient-nectar-slider'),
  					'desc' => esc_html__('Horizontal Alignment', 'salient-nectar-slider'),
  					'id' => '_nectar_slide_xpos_alignment',
  					'type' => 'caption_pos',
  					'options' => array(
  						'left' => esc_html__('Left', 'salient-nectar-slider'),
  						'centered' => esc_html__('Centered', 'salient-nectar-slider'),
  						'right' => esc_html__('Right', 'salient-nectar-slider')
  					),
  					'std' => 'left',
  					'extra' => 'first'
  				),
  				
  			array( 
  					'name' => esc_html__('Slide Content Alignment', 'salient-nectar-slider'),
  					'desc' => esc_html__('Vertical Alignment', 'salient-nectar-slider'),
  					'id' => '_nectar_slide_ypos_alignment',
  					'type' => 'caption_pos',
  					'options' => array(
  						'top' => esc_html__('Top', 'salient-nectar-slider'),
  						'middle' => esc_html__('Middle', 'salient-nectar-slider'),
  						'bottom' => esc_html__('Bottom', 'salient-nectar-slider')
  					),
  					'std' => 'middle',
  					'extra' => 'last'
  				),
  			array( 
  				'name' => esc_html__('Extra Class Name', 'salient-nectar-slider'),
  				'desc' => esc_html__('If you would like to enter a custom class name to this slide for css purposes, enter it here.', 'salient-nectar-slider'),
  				'id' => '_nectar_slider_slide_custom_class',
  				'type' => 'text',
  				'std' => ''
  			)
  		)
  	);

    if( !function_exists('nectar_metabox_nectar_slider_callback')) {
      function nectar_metabox_nectar_slider_callback($post,$meta_box) {
        nectar_create_meta_box( $post, $meta_box["args"] );
      }
    }
      
  	nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_nectar_slider_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
  	
  	
  }

}
