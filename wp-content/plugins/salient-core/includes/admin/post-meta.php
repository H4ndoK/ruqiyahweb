<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action('add_meta_boxes', 'nectar_metabox_salient_headers_post');

function nectar_metabox_salient_headers_post($post_type) {
	
	if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
		$nectar_options = get_nectar_theme_options(); 
	} else {
		$nectar_options = array(
			'transparent-header' => '',
			'blog_header_type'   => '',
			'blog_masonry_type'  => ''
		);
	}
	
  if( !function_exists('nectar_metabox_salient_post_callback') ) {
    function nectar_metabox_salient_post_callback($post,$meta_box) {
      nectar_create_meta_box( $post, $meta_box["args"] );
    }
  }
	
	
	/**
	* Post formats.
	*/
	// Gallery.
	$meta_box = array(
		'id' => 'nectar-metabox-post-gallery',
		'title' =>  esc_html__('Gallery Configuration', 'salient-core'),
		'description' => esc_html__('Once you\'ve inserted a WordPress gallery using the "Add Media" button above, you can use the gallery slider checkbox below to transform your images into a slider.', 'salient-core'),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' =>  esc_html__('Gallery Slider', 'salient-core'),
				'desc' => esc_html__('Would you like to turn your gallery into a slider?', 'salient-core'),
				'id' => '_nectar_gallery_slider',
				'type' => 'checkbox',
				'std' => 1
			)
		)
	);
	
	nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
	
	// Quote.
	$meta_box = array(
		'id' => 'nectar-metabox-post-quote',
		'title' =>  esc_html__('Quote Settings', 'salient-core'),
		'description' => '',
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' =>  esc_html__('Quote Author', 'salient-core'),
				'desc' => esc_html__('Please input the name of who your quote is from. Is left blank the post title will be used.', 'salient-core'),
				'id' => '_nectar_quote_author',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' =>  esc_html__('Quote Content', 'salient-core'),
				'desc' => esc_html__('Please type the text for your quote here.', 'salient-core'),
				'id' => '_nectar_quote',
				'type' => 'textarea',
				'std' => ''
			)
		)
	);
	
	nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
	
	// Link.
	$meta_box = array(
		'id' => 'nectar-metabox-post-link',
		'title' =>  esc_html__('Link Settings', 'salient-core'),
		'description' => '',
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' =>  esc_html__('Link URL', 'salient-core'),
				'desc' => esc_html__('Please input the URL for your link. I.e. http://www.themenectar.com', 'salient-core'),
					'id' => '_nectar_link',
					'type' => 'text',
					'std' => ''
				)
			)
		);
		nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		// Video.
		$meta_box = array(
			'id' => 'nectar-metabox-post-video',
			'title' => esc_html__('Video Settings', 'salient-core'),
			'description' => '',
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' => esc_html__('MP4 File URL', 'salient-core'),
					'desc' => esc_html__('Please upload the .m4v video file.', 'salient-core'),
					'id' => '_nectar_video_m4v',
					'type' => 'media', 
					'std' => ''
				),
				array( 
					'name' => esc_html__('OGV File URL', 'salient-core'),
					'desc' => esc_html__('Please upload the .ogv video file', 'salient-core'),
					'id' => '_nectar_video_ogv',
					'type' => 'media',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Preview Image', 'salient-core'),
					'desc' => esc_html__('Image should be at least 680px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted videos.', 'salient-core'),
					'id' => '_nectar_video_poster',
					'type' => 'file',
					'std' => ''
				),
				array(
					'name' => esc_html__('Embedded Code', 'salient-core'),
					'desc' => esc_html__('If the video is an embed rather than self hosted, enter in a Vimeo or Youtube embed code here.', 'salient-core'),
					'id' => '_nectar_video_embed',
					'type' => 'textarea',
					'std' => ''
				)
			)
		);
		nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		// Audio.
		$meta_box = array(
			'id' => 'nectar-metabox-post-audio',
			'title' =>  esc_html__('Audio Settings', 'salient-core'),
			'description' => '',
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' => esc_html__('MP3 File URL', 'salient-core'),
					'desc' => esc_html__('Please enter in the URL to the .mp3 file', 'salient-core'),
					'id' => '_nectar_audio_mp3',
					'type' => 'text',
					'std' => ''
				),
				array( 
					'name' => esc_html__('OGA File URL', 'salient-core'),
					'desc' => esc_html__('Please enter in the URL to the .ogg or .oga file', 'salient-core'),
					'id' => '_nectar_audio_ogg',
					'type' => 'text',
					'std' => ''
				)
			)
		);
		nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		
		
		// Post Configuration.
		if(!empty($nectar_options['blog_masonry_type']) && $nectar_options['blog_masonry_type'] === 'meta_overlaid' ||
		!empty($nectar_options['blog_masonry_type']) && $nectar_options['blog_masonry_type'] === 'classic_enhanced') {
			$meta_box = array(
				'id' => 'nectar-metabox-post-config',
				'title' =>  esc_html__('Post Configuration', 'salient-core'),
				'description' => esc_html__('Configure the various options for how your post will display', 'salient-core'),
				'post_type' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array( 
						'name' => esc_html__('Masonry Item Sizing', 'salient-core'),
						'desc' => esc_html__('This will only be used if you choose to display your portfolio in the masonry format', 'salient-core'),
						'id' => '_post_item_masonry_sizing',
						'type' => 'select',
						'std' => 'tall_regular',
						'options' => array(
							"regular" => esc_html__("Regular", 'salient-core'),
							"wide_tall" => esc_html__("Regular Alt", 'salient-core'),
							"large_featured" => esc_html__("Large Featured", 'salient-core')
						)
					)
				)
			);
			nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		}
		
		
		
		/**
		* Header navigation transparency.
		*/
		$meta_box = array(
			'id' => 'nectar-metabox-header-nav-transparency',
			'title' => esc_html__('Navigation Transparency', 'salient-core'),
			'description' => esc_html__('Configure the header navigation transparency.', 'salient-core'),
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' =>  esc_html__('Disable Transparency From Navigation', 'salient-core'),
					'desc' => esc_html__('You can use this option to force your navigation header to stay a solid color even if it qualifies to trigger the','salient-core') . '<a target="_blank" href="'. esc_url(admin_url('?page='.NectarThemeInfo::$theme_options_name.'&tab=17')) .'"> transparent effect</a> ' . esc_html__('you have activated in the Salient options panel.', 'salient-core'),
					'id' => '_disable_transparent_header',
					'type' => 'checkbox',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Transparent Header Navigation Color', 'salient-core'),
					'desc' => esc_html__('Choose your header navigation logo & color scheme that will be used at the top of the page when the transparent effect is active. This option pulls from the settings "Header Starting Dark Logo" & "Header Dark Text Color" in the','salient-core') . ' <a target="_blank" href="'. esc_url(admin_url('?page='.NectarThemeInfo::$theme_options_name.'&tab=17')) .'">transparency tab</a>.',
					'id' => '_force_transparent_header_color',
					'type' => 'select',
					'std' => 'light',
					'options' => array(
						"light" => esc_html__("Light (default)", 'salient-core'),
						"dark" => esc_html__("Dark", 'salient-core')
					)
				)
			)
		);
		
		if( !empty($nectar_options['transparent-header']) && $nectar_options['transparent-header'] === '1' ) {
			nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		}
		
		
		/**
		* Header settings
		*/

    $post_header_bg_color = array( 
      'name' => esc_html__('Page Header Background Color', 'salient-core'),
      'desc' => esc_html__('Set your desired page header background color if not using an image', 'salient-core'),
      'id' => '_nectar_header_bg_color',
      'type' => 'color',
      'std' => ''
    );

    $post_header_font_color = array( 
      'name' => esc_html__('Page Header Font Color', 'salient-core'),
      'desc' => esc_html__('Set your desired page header font color - will only be used if using a header bg image/color', 'salient-core'),
      'id' => '_nectar_header_font_color',
      'type' => 'color',
      'std' => ''
    );

		if( !empty($nectar_options['blog_header_type']) && $nectar_options['blog_header_type'] === 'fullscreen' ) {
			
			$header_height = null;
			
			$bg_overlay = array(
				'name' =>  esc_html__('Background Overlay', 'salient-core'),
				'desc' => esc_html__('This will add a slight overlay onto your header which will allow lighter text to be easily visible on light images ', 'salient-core'),
				'id' => '_nectar_header_overlay',
				'type' => 'checkbox',
				'std' => 1
			);
			$bg_bottom_shad = array(
				'name' =>  esc_html__('Bottom Shadow', 'salient-core'),
				'desc' => esc_html__('This will add a subtle shadow at the bottom of your header', 'salient-core'),
				'id' => '_nectar_header_bottom_shadow',
				'type' => 'checkbox',
				'std' => 1
			);
			
		} else if( !empty($nectar_options['blog_header_type']) && $nectar_options['blog_header_type'] != 'image_under' ) {
			$header_height = array( 
				'name' => esc_html__('Page Header Height', 'salient-core'),
				'desc' => esc_html__('How tall do you want your header? Don\'t include "px" in the string. e.g. 350 This only applies when you are using an image/bg color.', 'salient-core'),
				'id' => '_nectar_header_bg_height',
				'type' => 'text',
				'std' => ''
			);
			$bg_overlay = null;
			$bg_bottom_shad = null;
		} 
    else {
      $header_height = null;
      $bg_overlay = null;
			$bg_bottom_shad = null;
      $post_header_font_color = null;
      $post_header_bg_color = null;
    }
		
		$post_header_post_types = array('post');
 	  if( has_filter('nectar_metabox_post_types_post_header') ) {
 		  $post_header_post_types = apply_filters('nectar_metabox_post_types_post_header', $post_header_post_types);
 	  }
		$meta_box = array(
			'id' => 'nectar-metabox-page-header',
			'title' => esc_html__('Post Header Settings', 'salient-core'),
			'description' => esc_html__('Here you can configure how your page header will appear. ', 'salient-core'),
			'post_type' => $post_header_post_types,
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' => esc_html__('Page Header Image', 'salient-core'),
					'desc' => esc_html__('The image should be between 1600px - 2000px wide and have a minimum height of 475px for best results.', 'salient-core'),
					'id' => '_nectar_header_bg',
					'type' => 'file',
					'std' => ''
				),
				array(
					'name' =>  esc_html__('Parallax Header?', 'salient-core'),
					'desc' => esc_html__('If you would like your header to have a parallax scroll effect check this box.', 'salient-core'),
					'id' => '_nectar_header_parallax',
					'type' => 'checkbox',
					'std' => 1
				),	
				$header_height,
				array( 
					'name' => esc_html__('Background Alignment', 'salient-core'),
					'desc' => esc_html__('Please choose how you would like your header background to be aligned', 'salient-core'),
					'id' => '_nectar_page_header_bg_alignment',
					'type' => 'select',
					'std' => 'top',
					'options' => array(
						"top" => esc_html__("Top", 'salient-core'),
						"center" => esc_html__("Center", 'salient-core'),
						"bottom" => esc_html__("Bottom", 'salient-core')
					)
				),
				$post_header_bg_color,
				$post_header_font_color,
				$bg_overlay,
				$bg_bottom_shad
			)
		);
		
		if( defined( 'NECTAR_THEME_NAME' ) ) {
			nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_post_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		}
		
		
	}
	
	
	
	?>