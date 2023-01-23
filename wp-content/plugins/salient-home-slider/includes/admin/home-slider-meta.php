<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('add_meta_boxes', 'nectar_metabox_home_slider');

if( !function_exists('nectar_metabox_home_slider') ) {
  function nectar_metabox_home_slider(){
      
      $meta_box = array(
  		'id' => 'nectar-metabox-home-slider',
  		'title' => esc_html__('Slide Settings', 'salient-home-slider'),
  		'description' => esc_html__('If you want a full width header with background image, please fill out the fields below.', 'salient-home-slider'),
  		'post_type' => 'home_slider',
  		'context' => 'normal',
  		'priority' => 'high',
  		'fields' => array(
  			array( 
  					'name' => esc_html__('Slide Image', 'salient-home-slider'),
  					'desc' => esc_html__('The image should be between 1600px - 2000px in width and have a minimum height of 700px for best results. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection.', 'salient-home-slider'),
  					'id' => '_nectar_slider_image',
  					'type' => 'file',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Caption', 'salient-home-slider'),
  					'desc' => esc_html__('Enter in the slide caption. (should be fairly short)', 'salient-home-slider'),
  					'id' => '_nectar_slider_caption',
  					'type' => 'text',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Button Text', 'salient-home-slider'),
  					'desc' => esc_html__('If you would like a button to appear below your caption, please enter the text for it here.', 'salient-home-slider'),
  					'id' => '_nectar_slider_button',
  					'type' => 'text',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Button Link', 'salient-home-slider'),
  					'desc' => esc_html__('Please enter the URL for the button here.', 'salient-home-slider'),
  					'id' => '_nectar_slider_button_url',
  					'type' => 'text',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Slide Alignment', 'salient-home-slider'),
  					'desc' => esc_html__('Select the alignment for your caption and button.', 'salient-home-slider'),
  					'id' => '_nectar_slide_alignment',
  					'type' => 'slide_alignment',
  					'options' => array(
  						'left' => esc_html__('Left', 'salient-home-slider'),
  						'centered' => esc_html__('Centered', 'salient-home-slider'),
  						'right' => esc_html__('Right', 'salient-home-slider')
  					),
  					'std' => 'left'
  				)
  		)
  	);

    if( !function_exists('nectar_metabox_home_slider_callback')) {
      function nectar_metabox_home_slider_callback($post,$meta_box) {
        nectar_create_meta_box( $post, $meta_box["args"] );
      }
    }
    
  	nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_home_slider_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
  	
  	
  	
  	
  	
  	
  	
  	#-----------------------------------------------------------------#
  	# Video 
  	#-----------------------------------------------------------------#

      $meta_box = array(
  		'id' => 'nectar-metabox-slider-video',
  		'title' => esc_html__('Slide Video Settings', 'salient-home-slider'),
  		'description' => esc_html__('If you want to feature a video in this slide, please fill out the fields below. Your video & image should be in a 16:9 aspect ratio.', 'salient-home-slider'),
  		'post_type' => 'home_slider',
  		'context' => 'normal',
  		'priority' => 'high',
  		'fields' => array(
  			array( 
  					'name' => esc_html__('M4V File URL', 'salient-home-slider'),
  					'desc' => esc_html__('Please upload the .m4v video file. You must include both formats.', 'salient-home-slider'),
  					'id' => '_nectar_video_m4v',
  					'type' => 'media', 
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('OGV File URL', 'salient-home-slider'),
  					'desc' => esc_html__('Please upload the .ogv video file. You must include both formats.', 'salient-home-slider'),
  					'id' => '_nectar_video_ogv',
  					'type' => 'media',
  					'std' => ''
  				),
  			array( 
  					'name' => esc_html__('Preview Image', 'salient-home-slider'),
  					'desc' => esc_html__('Image should be at least 680px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted videos.', 'salient-home-slider'),
  					'id' => '_nectar_video_poster',
  					'type' => 'file',
  					'std' => ''
  				),
  			array(
  					'name' => esc_html__('Embedded Code', 'salient-home-slider'),
  					'desc' => esc_html__('If the video is an embed rather than self hosted, enter in a Vimeo or Youtube embed code here. Embeds work worse with the parallax effect, but if you must use this, Vimeo is recommended. ', 'salient-home-slider'),
  					'id' => '_nectar_video_embed',
  					'type' => 'textarea',
  					'std' => ''
  				)
  		
  		)
  	);

  	nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_home_slider_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
  	
  	
  	
  }
}

?>