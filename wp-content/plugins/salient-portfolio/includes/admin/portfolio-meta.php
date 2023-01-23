<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

#-----------------------------------------------------------------#
# Create the Portfolio meta boxes
#-----------------------------------------------------------------# 

if( !function_exists('nectar_metabox_portfolio_callback') ) {
	function nectar_metabox_portfolio_callback($post,$meta_box) {
		nectar_create_meta_box( $post, $meta_box["args"] );
	}
}

add_action('add_meta_boxes_portfolio', 'salient_portfolio_metabox');

if( !function_exists('salient_portfolio_metabox') ) {
	
	function salient_portfolio_metabox() {
		
		if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
			$options = get_nectar_theme_options(); 
		} else {
			$options = array(
				'transparent-header' => '0'
			);
		}
		
		
		if( class_exists('Salient_Portfolio_Single_Layout') && Salient_Portfolio_Single_Layout::$is_full_width ) {
			$extra_content_meta_desc  = '';
		} else {
			$extra_content_meta_desc  = esc_html__('Please use this section to place any extra content you would like to appear in the main content area under your portfolio item. (The above default editor is only used to populate your items sidebar content)', 'salient-portfolio');
		}
		
		#-----------------------------------------------------------------#
		# Extra Content
		#-----------------------------------------------------------------# 
		$meta_box = array(
			'id' => 'nectar-metabox-portfolio-extra',
			'title' => esc_html__('Extra Content', 'salient-portfolio'),
			'description' => $extra_content_meta_desc,
			'post_type' => 'portfolio',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' => '',
					'desc' => '',
					'id' => '_nectar_portfolio_extra_content',
					'type' => 'editor',
					'std' => ''
				),
			)
		);
		
		
		nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_portfolio_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		
		
		
		$portfolio_pages = array('default'=>'Default');
		
		// Grab all pages that are using the portfolio layout.
		$portfolio_pages_ft = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => 'page-portfolio.php'
		));
		
		if(!empty($portfolio_pages_ft)) {
			foreach($portfolio_pages_ft as $page){
				$portfolio_pages[$page->ID] = $page->post_title;
			}
		}
		
		$portfolio_pages_ft_new = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-portfolio.php'
		));
		
		if(!empty($portfolio_pages_ft_new)) {
			foreach($portfolio_pages_ft_new as $page){
				$portfolio_pages[$page->ID] = $page->post_title;
			}
		}
		
		
		// Grab all pages that contain the portfolio shortcode.
		global $wpdb;
		
		$query_prepared = $wpdb->prepare( 
			"SELECT * FROM {$wpdb->posts} WHERE post_content LIKE %s AND post_type='page'",
			'%' . $wpdb->esc_like('[nectar_portfolio') . '%'
		);
		
		$results = $wpdb->get_results($query_prepared);
		
		if( !empty($results) ) {
			foreach ($results as $result) {
				$portfolio_pages[$result->ID] = $result->post_title;
			}
		}
		
		
		#-----------------------------------------------------------------#
		# Project Configuration
		#-----------------------------------------------------------------# 
		if ( floatval(get_bloginfo('version')) < "3.6" ) {
			$meta_box = array(
				'id' => 'nectar-metabox-custom-thummbnail',
				'title' =>  esc_html__('Project Configuration', 'salient-portfolio'),
				'description' => '',
				'post_type' => 'portfolio',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array( 
						'name' => esc_html__('Full Width Portfolio Item Layout', 'salient-portfolio'),
						'desc' => esc_html__('This will remove the sidebar and allow you to use fullwidth sections and sliders', 'salient-portfolio'),
						'id' => '_nectar_portfolio_item_layout',
						'type' => 'choice_below',
						'options' => array(
							'disabled' => esc_html__('Disabled', 'salient-portfolio'),
							'enabled' => esc_html__('Enabled', 'salient-portfolio')
						),
						'std' => 'disabled'
					),
					array( 
						'name' => esc_html__('Custom Thumbnail Image', 'salient-portfolio'),
						'desc' => esc_html__('If you would like to have a separate thumbnail for your portfolio item, upload it here. If left blank, a cropped version of your featured image will be automatically used instead. This image will get no cropping from Salient and the original aspect ratio will be used.', 'salient-portfolio'),
						'id' => '_nectar_portfolio_custom_thumbnail',
						'type' => 'file',
						'std' => ''
					),
          array( 
						'name' => esc_html__('Secondary Overlaid Image', 'salient-portfolio'),
						'desc' => esc_html__('Certain styles within the Post Grid page builder element will allow for this to be overlaid on top of your featured image.', 'salient-portfolio'),
						'id' => '_nectar_portfolio_secondary_thumbnail',
						'type' => 'file',
						'std' => ''
					),
					array(
						'name' =>  esc_html__('Hide Featured Image/Video on Single Project Page?', 'salient-portfolio'),
						'desc' => esc_html__('You can choose to hide your featured image/video from automatically displaying on the top of the main project page.', 'salient-portfolio'),
						'id' => '_nectar_hide_featured',
						'type' => 'checkbox',
						'std' => 1
					),
					array( 
						'name' => esc_html__('Masonry Item Sizing', 'salient-portfolio'),
						'desc' => esc_html__('This will only be used if you choose to display your portfolio in the masonry format', 'salient-portfolio'),
						'id' => '_portfolio_item_masonry_sizing',
						'type' => 'select',
						'std' => 'tall_regular',
						'options' => array(
							"regular" => esc_html__("Regular", 'salient-portfolio'),
							"wide" => esc_html__("Wide", 'salient-portfolio'),
							"tall" => esc_html__("Tall", 'salient-portfolio'),
							"wide_tall" => esc_html__("Wide + Tall", 'salient-portfolio'),
						)
					),
					array( 
						'name' => esc_html__('Masonry Content Position', 'salient-portfolio'),
						'desc' => esc_html__('This will only be used on project styles which show the content overlaid before hover', 'salient-portfolio'),
						'id' => '_portfolio_item_masonry_content_pos',
						'type' => 'select',
						'std' => 'middle',
						'options' => array(
							"middle" => esc_html__("Middle", 'salient-portfolio'),
							"left" => esc_html__("Left", 'salient-portfolio'),
							"right" => esc_html__("Right", 'salient-portfolio'),
							"top" => esc_html__("Top", 'salient-portfolio'),
							"bottom" => esc_html__("Bottom", 'salient-portfolio')
						)
					),
					array( 
						'name' => esc_html__('External Project URL', 'salient-portfolio'),
						'desc' => esc_html__('If you would like your project to link to a custom location, enter it here (remember to include "http://")', 'salient-portfolio'),
						'id' => '_nectar_external_project_url',
						'type' => 'text',
						'std' => ''
					),
					array( 
						'name' => esc_html__('Parent Portfolio Override', 'salient-portfolio'),
						'desc' => esc_html__('This allows you to manually assign where your "Back to all" button will take the user on your single portfolio item pages.', 'salient-portfolio'),
						'id' => 'nectar-metabox-portfolio-parent-override',
						'type' => 'select',
						'options' => $portfolio_pages,
						'std' => 'default'
					),
					array( 
						'name' => esc_html__('Project Excerpt', 'salient-portfolio'),
						'desc' => esc_html__('If you would like your project to display a small excerpt of text under the title in portfolio element, enter it here.', 'salient-portfolio'),
						'id' => '_nectar_project_excerpt',
						'type' => 'text',
						'std' => ''
					)
					
					
				)
			);
		} 
		
		//wp 3.6+
		else {
			
			
			// Show gallery slider option for legacy users only if they're using it.
			global $post;
			if($post) {
				$using_gallery_slider = get_post_meta($post->ID, '_nectar_gallery_slider', true);
				if(!empty($using_gallery_slider) && $using_gallery_slider == 'on'){
					$gallery_slider = array(
						'name' =>  esc_html__('Gallery Slider', 'salient-portfolio'),
						'desc' => esc_html__('This will turn all default WordPress galleries attached to this post into a simple slider.', 'salient-portfolio'),
						'id' => '_nectar_gallery_slider',
						'type' => 'checkbox',
						'std' => 1
					);
				} else {
					$gallery_slider = null;
				}
			} else {
				$gallery_slider = null;
			}
			
			$meta_box = array(
				'id' => 'nectar-metabox-project-configuration',
				'title' =>  esc_html__('Project Configuration', 'salient-portfolio'),
				'description' => '',
				'post_type' => 'portfolio',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array( 
						'name' => esc_html__('Full Width Portfolio Item Layout', 'salient-portfolio'),
						'desc' => esc_html__('This will remove the sidebar and allow you to use fullwidth sections and sliders', 'salient-portfolio'),
						'id' => '_nectar_portfolio_item_layout',
						'type' => 'choice_below',
						'options' => array(
							'disabled' => esc_html__('Disabled', 'salient-portfolio'),
							'enabled' => esc_html__('Enabled', 'salient-portfolio')
						),
						'std' => 'disabled'
					),
					array( 
						'name' => esc_html__('Custom Content Grid Item', 'salient-portfolio'),
						'desc' => esc_html__('This will all you to place custom content using the above editor that will appear in your portfolio grid. By using this option the single project page will be disabled, however you can still link the item to a custom URL if desired.', 'salient-portfolio'),
						'id' => '_nectar_portfolio_custom_grid_item',
						'type' => 'choice_below',
						'options' => array(
							'off' => esc_html__('Disabled', 'salient-portfolio'),
							'on' => esc_html__('Enabled', 'salient-portfolio')
						),
						'std' => 'off'
					),
					array( 
						'name' => esc_html__('Custom Content Grid Item Content', 'salient-portfolio'),
						'desc' => esc_html__('Use this to populate what will display as your project content in place of the default meta info.', 'salient-portfolio'),
						'id' => '_nectar_portfolio_custom_grid_item_content',
						'type' => 'slim_editor',
						'std' => ''
					),
					array(
						'name' =>  esc_html__('Hide Featured Image/Video on Single Project Page?', 'salient-portfolio'),
						'desc' => esc_html__('You can choose to hide your featured image/video from automatically displaying on the top of the main project page.', 'salient-portfolio'),
						'id' => '_nectar_hide_featured',
						'type' => 'checkbox',
						'std' => 1
					),
					array(
						'name' =>  esc_html__('Lightbox Only Grid Item', 'salient-portfolio'),
						'desc' => esc_html__('Prevents the single project template from being used and instead opens the featured image/video in a lightbox when your project is clicked.', 'salient-portfolio'),
						'id' => '_nectar_portfolio_lightbox_only_grid_item',
						'type' => 'checkbox',
						'std' => ''
					),
					array( 
						'name' => esc_html__('Masonry Item Sizing', 'salient-portfolio'),
						'desc' => esc_html__('This will only be used if you choose to display your portfolio in the masonry format.', 'salient-portfolio'),
						'id' => '_portfolio_item_masonry_sizing',
						'type' => 'select',
						'std' => 'tall_regular',
						'options' => array(
							"regular" => esc_html__("Regular", 'salient-portfolio'),
							"wide" => esc_html__("Wide", 'salient-portfolio'),
							"tall" => esc_html__("Tall", 'salient-portfolio'),
							"wide_tall" => esc_html__("Wide + Tall", 'salient-portfolio')
						)
					),
					array( 
						'name' => esc_html__('Masonry Content Position', 'salient-portfolio'),
						'desc' => esc_html__('This will only be used on project styles which show the content overlaid before hover.', 'salient-portfolio'),
						'id' => '_portfolio_item_masonry_content_pos',
						'type' => 'select',
						'std' => 'middle',
						'options' => array(
							"middle" => esc_html__("Middle", 'salient-portfolio'),
							"left" => esc_html__("Left", 'salient-portfolio'),
							"right" => esc_html__("Right", 'salient-portfolio'),
							"top" => esc_html__("Top", 'salient-portfolio'),
							"bottom" => esc_html__("Bottom", 'salient-portfolio')
						)
					),
					$gallery_slider,
          array( 
						'name' => esc_html__('Custom Thumbnail Image', 'salient-portfolio'),
						'desc' => esc_html__('If you would like to have a separate thumbnail for your portfolio item, upload it here. If left blank, a cropped version of your featured image will be automatically used instead. The recommended dimensions are 600px by 403px.', 'salient-portfolio'),
						'id' => '_nectar_portfolio_custom_thumbnail',
						'type' => 'file',
						'std' => ''
					),
          array( 
						'name' => esc_html__('Secondary Overlaid Image', 'salient-portfolio'),
						'desc' => esc_html__('Certain styles within the Post Grid page builder element will allow for this to be overlaid on top of your featured image.', 'salient-portfolio'),
						'id' => '_nectar_portfolio_secondary_thumbnail',
						'type' => 'file',
						'std' => ''
					),
					array( 
						'name' => esc_html__('External Project URL', 'salient-portfolio'),
						'desc' => esc_html__('If you would like your project to link to a custom location, enter it here (remember to include "http://")', 'salient-portfolio'),
						'id' => '_nectar_external_project_url',
						'type' => 'text',
						'std' => ''
					),
					array( 
						'name' => esc_html__('Parent Portfolio Override', 'salient-portfolio'),
						'desc' => esc_html__('This allows you to manually assign where your "Back to all" button will take the user on your single portfolio item pages.', 'salient-portfolio'),
						'id' => 'nectar-metabox-portfolio-parent-override',
						'type' => 'select',
						'options' => $portfolio_pages,
						'std' => 'default'
					),
					array( 
						'name' => esc_html__('Project Excerpt', 'salient-portfolio'),
						'desc' => esc_html__('If you would like your project to display a small excerpt of text under the title in portfolio element, enter it here.', 'salient-portfolio'),
						'id' => '_nectar_project_excerpt',
						'type' => 'textarea',
						'std' => ''
					),
					array( 
						'name' => esc_html__('Project Accent Color', 'salient-portfolio'),
						'desc' => esc_html__('This will be used in applicable project styles in the portfolio thumbnail view.', 'salient-portfolio'),
						'id' => '_nectar_project_accent_color',
						'type' => 'color',
						'std' => ''
					),
					array( 
						'name' => esc_html__('Project Title Color', 'salient-portfolio'),
						'desc' => esc_html__('This will be used in applicable project styles in the portfolio thumbnail view.', 'salient-portfolio'),
						'id' => '_nectar_project_title_color',
						'type' => 'color',
						'std' => ''
					),
					array( 
						'name' => esc_html__('Project Date/Custom excerpt Color', 'salient-portfolio'),
						'desc' => esc_html__('This will be used in applicable project styles in the portfolio thumbnail view.', 'salient-portfolio'),
						'id' => '_nectar_project_subtitle_color',
						'type' => 'color',
						'std' => ''
					),
					array( 
						'name' => esc_html__('Custom CSS Class Name', 'salient-portfolio'),
						'desc' => esc_html__('For advanced users with css knowledge - use this to add an a specific class onto your project that can be used to target it in any portfolio element to add custom styling.', 'salient-portfolio'),
						'id' => '_nectar_project_css_class',
						'type' => 'text',
						'std' => ''
					),
					
				)
			);
			
		}//endif
		
		nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_portfolio_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		
		
		
		
		#-----------------------------------------------------------------#
		# Header Settings
		#-----------------------------------------------------------------#
		$meta_box = array(
			'id' => 'nectar-metabox-page-header',
			'title' => esc_html__('Project Header Settings', 'salient-portfolio'),
			'description' => esc_html__('Here you can configure how your page header will appear. ', 'salient-portfolio'),
			'post_type' => 'portfolio',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' => esc_html__('Background Type', 'salient-portfolio'),
					'desc' => esc_html__('Please select the background type you would like to use for your slide.', 'salient-portfolio'),
					'id' => '_nectar_slider_bg_type',
					'type' => 'choice_below',
					'options' => array(
						'image_bg' => esc_html__('Image Background', 'salient-portfolio'),
						'video_bg' => esc_html__('Video Background', 'salient-portfolio')
					),
					'std' => 'image_bg'
				),
				array( 
					'name' => esc_html__('Video WebM Upload', 'salient-portfolio'),
					'desc' => esc_html__('Browse for your WebM video file here. This will be automatically played on load so make sure to use this responsibly for enhancing your design. You must include this format & the mp4 format to render your video with cross browser compatibility. OGV is optional. Video must be in a 16:9 aspect ratio.', 'salient-portfolio'),
					'id' => '_nectar_media_upload_webm',
					'type' => 'media',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Video MP4 Upload', 'salient-portfolio'),
					'desc' => esc_html__('Browse for your mp4 video file here. See the note above for recommendations on how to properly use your video background.', 'salient-portfolio'),
					'id' => '_nectar_media_upload_mp4',
					'type' => 'media',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Video OGV Upload', 'salient-portfolio'),
					'desc' => esc_html__('Browse for your OGV video file here. See the note above for recommendations on how to properly use your video background.', 'salient-portfolio'),
					'id' => '_nectar_media_upload_ogv',
					'type' => 'media',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Preview Image', 'salient-portfolio'),
					'desc' => esc_html__('This is the image that will be seen in place of your video on mobile devices & older browsers before your video is played.', 'salient-portfolio'),
					'id' => '_nectar_slider_preview_image',
					'type' => 'file',
					'std' => ''
				),	
				array( 
					'name' => esc_html__('Page Header Image', 'salient-portfolio'),
					'desc' => esc_html__('The image should be between 1600px - 2000px wide and have a minimum height of 475px for best results.', 'salient-portfolio'),
					'id' => '_nectar_header_bg',
					'type' => 'file',
					'std' => ''
				),
				array(
					'name' =>  esc_html__('Parallax Header?', 'salient-portfolio'),
					'desc' => esc_html__('If you would like your header to have a parallax scroll effect check this box.', 'salient-portfolio'),
					'id' => '_nectar_header_parallax',
					'type' => 'checkbox',
					'std' => 1
				),	
				array( 
					'name' => esc_html__('Page Header Height', 'salient-portfolio'),
					'desc' => esc_html__('How tall do you want your header? Don\'t include "px" in the string. e.g. 350 This only applies when you are using an image/bg color.', 'salient-portfolio'),
					'id' => '_nectar_header_bg_height',
					'type' => 'text',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Fullscreen Height', 'salient-portfolio'),
					'desc' => esc_html__('Choosing this option will allow your header to always remain fullscreen on all devices/screen sizes.', 'salient-portfolio'),
					'id' => '_nectar_header_fullscreen',
					'type' => 'checkbox',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Background Alignment', 'salient-portfolio'),
					'desc' => esc_html__('Please choose how you would like your image background to be aligned', 'salient-portfolio'),
					'id' => '_nectar_page_header_bg_alignment',
					'type' => 'select',
					'std' => 'center',
					'options' => array(
						"top" => esc_html__("Top", 'salient-portfolio'),
						"center" => esc_html__("Center", 'salient-portfolio'),
						"bottom" => esc_html__("Bottom", 'salient-portfolio')
					)
				),
				array( 
					'name' => esc_html__('Page Header Background Color', 'salient-portfolio'),
					'desc' => esc_html__('Set your desired page header background color if not using an image', 'salient-portfolio'),
					'id' => '_nectar_header_bg_color',
					'type' => 'color',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Page Header Overlay Color', 'salient-portfolio'),
					'desc' => esc_html__('This will be applied on top on your page header BG image (if supplied).', 'salient-portfolio'),
					'id' => '_nectar_header_bg_overlay_color',
					'type' => 'color',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Page Header Overlay Opacity', 'salient-portfolio'),
					'desc' => '',
					'id' => '_nectar_header_bg_overlay_opacity',
					'type' => 'select',
					'std' => 'default',
					'options' => array(
						"default" => esc_html__("Default", 'salient-portfolio'),
						"0.9" => esc_html__("0.9", 'salient-portfolio'),
						"0.8" => esc_html__("0.8", 'salient-portfolio'),
						"0.7" => esc_html__("0.7", 'salient-portfolio'),
						"0.6" => esc_html__("0.6", 'salient-portfolio'),
						"0.5" => esc_html__("0.5", 'salient-portfolio'),
						"0.4" => esc_html__("0.4", 'salient-portfolio'),
						"0.3" => esc_html__("0.3", 'salient-portfolio'),
						"0.2" => esc_html__("0.2", 'salient-portfolio'),
						"0.1" => esc_html__("0.1", 'salient-portfolio'),
					)
				),
				array( 
					'name' => esc_html__('Page Header Subtitle', 'salient-portfolio'),
					'desc' => esc_html__('Enter in the page header subtitle', 'salient-portfolio'),
					'id' => '_nectar_header_subtitle',
					'type' => 'text',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Page Header Font Color', 'salient-portfolio'),
					'desc' => esc_html__('Set your desired page header font color - will only be used if using a header bg image/color', 'salient-portfolio'),
					'id' => '_nectar_header_font_color',
					'type' => 'color',
					'std' => ''
				)
			)
		);
		
		//only add header options when using Salient
		if( defined( 'NECTAR_THEME_NAME' ) ) {
			nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_portfolio_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		}
		
		
		#-----------------------------------------------------------------#
		# Header Navigation Transparency
		#-----------------------------------------------------------------#
		$meta_box = array(
			'id' => 'nectar-metabox-header-nav-transparency',
			'title' => esc_html__('Navigation Transparency', 'salient-portfolio'),
			'description' => esc_html__('Configure the header navigation transparency.', 'salient-portfolio'),
			'post_type' => 'portfolio',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' =>  esc_html__('Disable Transparency From Navigation', 'salient-portfolio'),
					'desc' => esc_html__('You can use this option to force your navigation header to stay a solid color even if it qualifies to trigger the','salient-portfolio') . '<a target="_blank" href="'. esc_url(admin_url('?page=Salient#16_section_group_li_a')) .'"> transparent effect</a> ' . esc_html__('you have activated in the Salient options panel.', 'salient-portfolio'),
					'id' => '_disable_transparent_header',
					'type' => 'checkbox',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Transparent Header Navigation Color', 'salient-portfolio'),
					'desc' => esc_html__('Choose your header navigation logo & color scheme that will be used at the top of the page when the transparent effect is active. This option pulls from the settings "Header Starting Dark Logo" & "Header Dark Text Color" in the','salient-portfolio') . ' <a target="_blank" href="'. esc_url(admin_url('?page=Salient#16_section_group_li_a')) .'">transparency tab</a>.',
					'id' => '_force_transparent_header_color',
					'type' => 'select',
					'std' => 'light',
					'options' => array(
						"light" => esc_html__("Light (default)", 'salient-portfolio'),
						"dark" => esc_html__("Dark", 'salient-portfolio')
					)
				)
			)
		);
		
		// only add header options when using Salient
		if( defined( 'NECTAR_THEME_NAME' ) && !empty($options['transparent-header']) && $options['transparent-header'] == '1' ) {
			
			if( isset($options['portfolio_remove_single_header']) && 
					!empty($options['portfolio_remove_single_header']) && 
					'1' === $options['portfolio_remove_single_header'] ) {
						
						$force_transparency = array( 
		          'name' =>  esc_html__('Force Transparency On Navigation', 'salient-core'),
		          'desc' => esc_html__('You can use this option to force your navigation header to start transparent even if it does not qualify to trigger the','salient-core') . '<a target="_blank" href="'. esc_url(admin_url('?page=Salient#16_section_group_li_a')) .'"> transparent effect</a> ' . esc_html__('you have activated in the Salient options panel.', 'salient-core'),
		          'id' => '_force_transparent_header',
		          'type' => 'checkbox',
		          'std' => ''
		        );
						
						array_unshift($meta_box['fields'], $force_transparency);
			} 
			
			nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_portfolio_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		}
		
		
		#-----------------------------------------------------------------#
		# Video 
		#-----------------------------------------------------------------#
		$meta_box = array( 
			'id' => 'nectar-metabox-portfolio-video',
			'title' => esc_html__('Video Settings', 'salient-portfolio'),
			'description' => esc_html__('If you have a video, please fill out the fields below.', 'salient-portfolio'),
			'post_type' => 'portfolio',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array( 
					'name' => esc_html__('MP4 File URL', 'salient-portfolio'),
					'desc' => esc_html__('Please upload the .mp4 video file.', 'salient-portfolio'),
					'id' => '_nectar_video_m4v',
					'type' => 'media',
					'std' => ''
				),
				array( 
					'name' => esc_html__('OGV File URL', 'salient-portfolio'),
					'desc' => esc_html__('Please upload the .ogv video file.', 'salient-portfolio'),
					'id' => '_nectar_video_ogv',
					'type' => 'media',
					'std' => ''
				),
				array( 
					'name' => esc_html__('Preview Image', 'salient-portfolio'),
					'desc' => esc_html__('Image should be at least 680px wide. Click the "Upload" button to begin uploading your image, followed by "Select File" once you have made your selection. Only applies to self hosted videos.', 'salient-portfolio'),
					'id' => '_nectar_video_poster',
					'type' => 'file',
					'std' => ''
				),
				array(
					'name' => esc_html__('Embedded Code', 'salient-portfolio'),
					'desc' => esc_html__('If the video is an embed rather than self hosted, enter in a Youtube or Vimeo embed code here. The width should be a minimum of 670px with any height.', 'salient-portfolio'),
					'id' => '_nectar_video_embed',
					'type' => 'textarea',
					'std' => ''
				)
			)
		);
		
		
		nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_portfolio_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
		
	}
	
}


if( !function_exists('salient_portfolio_page_metabox') ) {
	
	function salient_portfolio_page_metabox() {
		
		#-----------------------------------------------------------------#
		# Portfolio Display Settings
		#-----------------------------------------------------------------#
		$portfolio_types = get_terms('project-type');
		
		$types_options = array("all" => "All");
		
		foreach ($portfolio_types as $type) {
			$types_options[$type->slug] = $type->name;
		}
		
		$meta_box = array(
			'id' => 'nectar-metabox-portfolio-display',
			'title' => esc_html__('Portfolio Display Settings', 'salient-portfolio'),
			'description' => esc_html__('Here you can configure which categories will display in your portfolio.', 'salient-portfolio'),
			'post_type' => 'page',
			'context' => 'side',
			'priority' => 'core',
			'fields' => array(
				array( 
					'name' => esc_html__('Portfolio Categories', 'salient-portfolio'),
					'desc' => '',
					'id' => 'nectar-metabox-portfolio-display',
					'type' => 'multi-select',
					'options' => $types_options,
					'std' => 'all'
				),
				array( 
					'name' => esc_html__('Display Sortable', 'salient-portfolio'),
					'desc' => esc_html__('Should these portfolio items be sortable?', 'salient-portfolio'),
					'id' => 'nectar-metabox-portfolio-display-sortable',
					'type' => 'checkbox',
					'std' => '1'
				)
			)
		);
		
		nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_portfolio_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
		
	}
	
}

add_action('add_meta_boxes_page', 'salient_portfolio_page_metabox');




/**
 * Preview
 *
 * Allows WP to show changes in preview when only 
 * custom metabox values have changed.
 *
 * @since 1.6
 */
add_filter('_wp_post_revision_fields', 'salient_portfolio_post_preview_fix', 10, 2);

function salient_portfolio_post_preview_fix( $fields ) {
		
		if( isset( $_POST['wp-preview'] ) && 'dopreview' === $_POST['wp-preview'] && 
				isset( $_POST['post_type'] ) && 'portfolio' === $_POST['post_type']) {
					
			$fields['_salient_portfolio_preview_changed'] = 'value other than 0';
		} 
		
		return $fields;
}

/**
 * Forces WP to save a revision, which is needed since when generating previews
 * only the title/content is taken into consideraiton.
 *
 * @since 1.7
 */
add_filter('wp_save_post_revision_check_for_changes', 'salient_portfolio_post_preview_draft_fix', 10, 3);

function salient_portfolio_post_preview_draft_fix( $return, $last_revision, $post ) {

	if( isset( $_POST['wp-preview'] ) && 'dopreview' === $_POST['wp-preview'] && 
			isset( $_POST['post_type'] ) && 'portfolio' === $_POST['post_type'] && 
		  in_array($post->post_status, array('auto-draft','draft')) ) {
				// stop compare logic and force a new version to display.
				return false;
	}
	
	return $return;
	
}

add_action( 'edit_form_after_title', 'salient_portfolio_post_preview_field' );

function salient_portfolio_post_preview_field($post) {
	 if( isset( $post->post_type ) && 'portfolio' === $post->post_type ) {
		  echo '<input type="hidden" name="_salient_portfolio_preview_changed" value="0">';
	 }
  
}


/**
 * Default WPBakery template 
 *
 * Different logic is needed from the default
 * since the portfolio content is a custom metabox.
 *
 * @since 1.6
 */
 function salient_portfolio_insert_new_project($post_id, $post, $update) {
	
	 if (false === $update && 
	 'portfolio' === $post->post_type && 
	 'auto-draft' === $post->post_status && 
	 empty(get_post_meta( $post_id, '_salient_project_initialized' )) ) {
		 
		 $salient_project_extra_content = get_post_meta( $post_id, '_nectar_portfolio_extra_content' );
		 
		 if( empty($salient_project_extra_content) && 
		 class_exists( 'WPBakeryVisualComposerAbstract' ) &&
		 class_exists( 'Vc_Setting_Post_Type_Default_Template_Field' ) ) {
			 
			 $template_settings = new Vc_Setting_Post_Type_Default_Template_Field( 'general', 'default_template_post_type' );
			 $new_post_content = $template_settings->getTemplateByPostType( 'portfolio' );
			 
			 if ( null !== $new_post_content ) {
				 update_post_meta( $post_id, '_nectar_portfolio_extra_content', $new_post_content ); 
			 }	
			 
		 } // Make sure VC Class exists.
		 
		 // run only once	
		 update_post_meta( $post_id, '_salient_project_initialized', true ); 
		 
	 }
	 
 }
 
 add_action( 'wp_insert_post', 'salient_portfolio_insert_new_project', 10, 3 );


 /**
  * Edit project body class
  *
  * Add a specific class when using the theme option
  * for page builder layout.
  *
  * @since 1.6
  */
	add_filter('admin_body_class', 'salient_portfolio_edit_project_admin_body_class');
	
	function salient_portfolio_edit_project_admin_body_class($classes) {
		
	    global $post;

	    if( isset($post) && 
			isset($post->post_type) && 
			'portfolio' === $post->post_type && 
			class_exists('Salient_Portfolio_Single_Layout') &&
			Salient_Portfolio_Single_Layout::$is_full_width ) {
				
		    $classes .= ' salient-portfolio-page-builder-layout ';

	    } // on portfolio post type.
	
	    return $classes;
	}
