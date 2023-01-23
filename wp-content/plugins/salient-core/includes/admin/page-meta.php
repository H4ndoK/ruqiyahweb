<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action('add_meta_boxes', 'nectar_metabox_salient_headers_page');

function nectar_metabox_salient_headers_page($post_type) {
  
  
  if( defined( 'NECTAR_THEME_NAME' ) ) {
    $nectar_options = get_nectar_theme_options(); 
  } else {
    $nectar_options = array(
      'transparent-header' => '0'
    );
  }
  
  if( !function_exists('nectar_metabox_salient_page_callback')) {
    function nectar_metabox_salient_page_callback($post,$meta_box) {
      nectar_create_meta_box( $post, $meta_box["args"] );
    }
  }
  

  /**
   * Header navigation transparency.
   */
	 $header_nav_trans_post_types = array('page');
	 if( has_filter('nectar_metabox_post_types_navigation_transparency') ) {
		 $header_nav_trans_post_types = apply_filters('nectar_metabox_post_types_navigation_transparency', $header_nav_trans_post_types);
	 }
	 
   $meta_box = array(
     'id' => 'nectar-metabox-header-nav-transparency',
     'title' => esc_html__('Header Navigation', 'salient-core'),
     'description' => esc_html__('Configure options related to the header navigation.', 'salient-core'),
     'post_type' => $header_nav_trans_post_types,
     'context' => 'normal',
     'priority' => 'high',
     'fields' => array(
      array( 
        'name' => esc_html__('Header Navigation Entrance Animation', 'salient-core'),
        'desc' => esc_html__('Optionally specify an entrance animation for your header navigation.', 'salient-core'),
        'id' => '_header_nav_entrance_animation',
        'type' => 'select',
        'std' => 'none',
        'options' => array(
          "none" => esc_html__("None", "salient-core"),
          "fade-in" => esc_html__("Fade In", "salient-core"),
          "fade-in-from-top" => esc_html__("Fade In From Top", "salient-core")
         )
        ),
        array( 
          'name' => esc_html__('Header Navigation Entrance Animation Delay', 'salient-core'),
          'desc' => esc_html__('Optionally specify a delay in milliseconds to wait before triggering the header animation e.g. 500', 'salient-core'),
          'id' => '_header_nav_entrance_animation_delay',
          'type' => 'text',
          'std' => ''
        ),
     )
   );

  

   if( isset($nectar_options['transparent-header']) && $nectar_options['transparent-header'] === '1' ) {
    $meta_box['fields'][] = array( 
      'name' =>  esc_html__('Disable Transparency From Navigation', 'salient-core'),
      'desc' => esc_html__('You can use this option to force your navigation header to stay a solid color even if it qualifies to trigger the','salient-core') . '<a target="_blank" href="'. esc_url(admin_url('?page='.NectarThemeInfo::$theme_options_name.'&tab=17')) .'"> transparent effect</a> ' . esc_html__('you have activated in the Salient options panel.', 'salient-core'),
      'id' => '_disable_transparent_header',
      'type' => 'checkbox',
      'std' => ''
    );
    $meta_box['fields'][] = array( 
      'name' =>  esc_html__('Force Transparency On Navigation', 'salient-core'),
      'desc' => esc_html__('You can use this option to force your navigation header to start transparent even if it does not qualify to trigger the','salient-core') . '<a target="_blank" href="'. esc_url(admin_url('?page='.NectarThemeInfo::$theme_options_name.'&tab=17')) .'"> transparent effect</a> ' . esc_html__('you have activated in the Salient options panel.', 'salient-core'),
      'id' => '_force_transparent_header',
      'type' => 'checkbox',
      'std' => ''
    );
    $meta_box['fields'][] = array( 
      'name' => esc_html__('Transparent Header Navigation Color', 'salient-core'),
      'desc' => esc_html__('Choose your header navigation logo & color scheme that will be used at the top of the page when the transparent effect is active. This option pulls from the settings "Header Starting Dark Logo" & "Header Dark Text Color" in the','salient-core') . ' <a target="_blank" href="'. esc_url(admin_url('?page='.NectarThemeInfo::$theme_options_name.'&tab=17')) .'">transparency tab</a>.',
      'id' => '_force_transparent_header_color',
      'type' => 'select',
      'std' => 'light',
      'options' => array(
        "light" => esc_html__("Light (default)", "salient-core"),
        "dark" => esc_html__("Dark", "salient-core")
       )
      );
   }
   
	
  if( defined( 'NECTAR_THEME_NAME' ) ) {
    nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_page_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
  }
  
  /**
   * Page full screen rows.
   */
	 $page_full_screen_rows_post_types = array('page');
	 if( has_filter('nectar_metabox_post_types_fullscreen_rows') ) {
		 $page_full_screen_rows_post_types = apply_filters('nectar_metabox_post_types_fullscreen_rows', $page_full_screen_rows_post_types);
	 }
	 
   $meta_box = array(
     'id' => 'nectar-metabox-fullscreen-rows',
     'title' => esc_html__('Page Full Screen Rows', 'salient-core'),
     'description' => esc_html__('Configure your page full screen rows.', 'salient-core'),
     'post_type' => $page_full_screen_rows_post_types,
     'context' => 'normal',
     'priority' => 'high',
     'fields' => array(
       
       array( 
         'name' => esc_html__('Activate Fullscreen Rows', 'salient-core'),
         'desc' => esc_html__('This will cause all WPBakery Page Builder rows to be fullscreen. Some functionality and options within the WPBakery Page Builder will be changed when this is active.', 'salient-core'),
         'id' => '_nectar_full_screen_rows',
         'type' => 'choice_below',
         'options' => array(
           'off' => esc_html__('Off', 'salient'),
           'on' => esc_html__('On', 'salient)')
         ),
         'std' => 'off'
       ),
       array( 
         'name' => esc_html__('Animation Between Rows', 'salient-core'),
         'desc' => esc_html__('Select your desired animation between rows', 'salient-core'),
         'id' => '_nectar_full_screen_rows_animation',
         'type' => 'select',
         'std' => 'none',
         'options' => array(
           "none" => esc_html__("Default Scroll", "salient-core"),
           /*"free-scroll" => esc_html__("Free Scroll", "salient-core"),*/
           "zoom-out-parallax" => esc_html__("Zoom Out + Parallax", "salient-core"),
           "parallax" => esc_html__("Parallax", "salient-core")
         )
       ),
       array( 
         'name' => esc_html__('Animation Speed', 'salient-core'),
         'desc' => esc_html__('Selection your desired animation speed', 'salient-core'),
         'id' => '_nectar_full_screen_rows_animation_speed',
         'type' => 'select',
         'std' => 'medium',
         'options' => array(
           "slow" => esc_html__("Slow", "salient-core"),
           "medium" => esc_html__("Medium", "salient-core"),
           "fast" => esc_html__("Fast", "salient-core")
         )
       ),
       array( 
         'name' => esc_html__('Overall BG Color', 'salient-core'),
         'desc' => esc_html__('Set your desired background color which will be seen when transitioning through rows. Defaults to #333333', 'salient-core'),
         'id' => '_nectar_full_screen_rows_overall_bg_color',
         'type' => 'color',
         'std' => ''
       ),
       array(
         'name' =>  esc_html__('Add Row Anchors to URL', 'salient-core'),
         'desc' => esc_html__('Enable this to add anchors into your URL for each row.', 'salient-core'),
         'id' => '_nectar_full_screen_rows_anchors',
         'type' => 'checkbox',
         'std' => '0'
       ),
       array(
         'name' =>  esc_html__('Disable On Mobile', 'salient-core'),
         'desc' => esc_html__('Check this to disable the page full screen rows when viewing on a mobile device.', 'salient-core'),
         'id' => '_nectar_full_screen_rows_mobile_disable',
         'type' => 'checkbox',
         'std' => '0'
       ),
       array( 
         'name' => esc_html__('Row BG Image Animation', 'salient-core'),
         'desc' => esc_html__('Select your desired row BG image animation', 'salient-core'),
         'id' => '_nectar_full_screen_rows_row_bg_animation',
         'type' => 'select',
         'std' => 'none',
         'options' => array(
           "none" => esc_html__("None", "salient-core"),
           "ken_burns" => esc_html__("Ken Burns Zoom", "salient-core")
         )
       ),
       array( 
         'name' => esc_html__('Dot Navigation', 'salient-core'),
         'desc' => esc_html__('Select your desired dot navigation style', 'salient-core'),
         'id' => '_nectar_full_screen_rows_dot_navigation',
         'type' => 'select',
         'std' => 'tooltip',
         'options' => array(
           "transparent" => esc_html__("Transparent", "salient-core"),
           "tooltip" => esc_html__("Tooltip", "salient-core"),
           "tooltip_alt" => esc_html__("Tooltip Alt", "salient-core"),
           "hidden" => esc_html__("None (Hidden)", "salient-core")
         )
       ),
       array( 
         'name' => esc_html__('Row Overflow', 'salient-core'),
         'desc' => esc_html__('Select how you would like rows to be handled that have content taller than the users window height. This only applies to desktop (mobile will automatically get scrollbars)', 'salient-core'),
         'id' => '_nectar_full_screen_rows_content_overflow',
         'type' => 'select',
         'std' => 'tooltip',
         'options' => array(
           "scrollbar" => esc_html__("Provide Scrollbar", "salient-core"),
           "hidden" => esc_html__("Hide Extra Content", "salient-core")
         )
       ),
       array( 
         'name' => esc_html__('Page Footer', 'salient-core'),
         'desc' => esc_html__('This option allows you to define what will be used for the footer after your fullscreen rows', 'salient-core'),
         'id' => '_nectar_full_screen_rows_footer',
         'type' => 'select',
         'std' => 'none',
         'options' => array(
           "default" => esc_html__("Default Footer", "salient-core"),
           "last_row" => esc_html__("Last Row", "salient-core"),
           "none" => esc_html__("None", "salient-core")
         )
       ),
     )
   );


  
  // Do not add page full screen row metabox when gutenberg is active editor
  global $current_screen;
  $current_screen = get_current_screen();
  if( method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor() ) {
    
  } else if( defined( 'NECTAR_THEME_NAME' ) ) {
	   nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_page_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
  }
  
  

  /**
   * Page Header Settings
   */
	 
	 $page_header_post_types = array('page');
	 if( has_filter('nectar_metabox_post_types_page_header') ) {
		 $page_header_post_types = apply_filters('nectar_metabox_post_types_page_header', $page_header_post_types);
	 }
	 
   $meta_box = array(
     'id' => 'nectar-metabox-page-header',
     'title' => esc_html__('Page Header Settings', 'salient-core'),
     'description' => esc_html__('Here you can configure how your page header will appear. For a full width background image behind your header text, simply upload the image below. To have a standard header just fill out the fields below and don\'t upload an image.', 'salient-core'),
     'post_type' => $page_header_post_types,
     'context' => 'normal',
     'priority' => 'high',
     'fields' => array(
       array( 
         'name' => esc_html__('Background Type', 'salient-core'),
         'desc' => esc_html__('Please select the background type you would like to use for your slide.', 'salient-core'),
         'id' => '_nectar_slider_bg_type',
         'type' => 'choice_below',
         'options' => array(
           'image_bg' => esc_html__('Image Background', 'salient-core'),
           'video_bg' => esc_html__('Video Background', 'salient-core'),
           'particle_bg' => esc_html__('HTML5 Canvas Background', 'salient-core')
         ),
         'std' => 'image_bg'
       ),
       array( 
         'name' => esc_html__('Particle Images', 'salient-core'),
         'desc' => esc_html__('Add images here that will be used to create the particle shapes.', 'salient-core'),
         'id' => '_nectar_canvas_shapes',
         'type' => 'canvas_shape_group',
         'class' => 'nectar_slider_canvas_shape',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Video WebM Upload', 'salient-core'),
         'desc' => esc_html__('Browse for your WebM video file here. This will be automatically played on load so make sure to use this responsibly for enhancing your design. You must include this format & the mp4 format to render your video with cross browser compatibility. OGV is optional. Video must be in a 16:9 aspect ratio.', 'salient-core'),
         'id' => '_nectar_media_upload_webm',
         'type' => 'media',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Video MP4 Upload', 'salient-core'),
         'desc' => esc_html__('Browse for your mp4 video file here. See the note above for recommendations on how to properly use your video background.', 'salient-core'),
         'id' => '_nectar_media_upload_mp4',
         'type' => 'media',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Video OGV Upload', 'salient-core'),
         'desc' => esc_html__('Browse for your OGV video file here. See the note above for recommendations on how to properly use your video background.', 'salient-core'),
         'id' => '_nectar_media_upload_ogv',
         'type' => 'media',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Preview Image', 'salient-core'),
         'desc' => esc_html__('This is the image that will be seen in place of your video on mobile devices if you have disabled mobile video playback in the theme options > general settings > functionality tab.', 'salient-core'),
         'id' => '_nectar_slider_preview_image',
         'type' => 'file',
         'std' => ''
       ),	
       array( 
         'name' => esc_html__('Page Header Image', 'salient-core'),
         'desc' => esc_html__('The image should be between 1600px - 2000px wide and have a minimum height of 475px for best results. Click "Browse" to upload and then "Insert into Post".', 'salient-core'),
         'id' => '_nectar_header_bg',
         'type' => 'file',
         'std' => ''
       ),
       array(
         'name' =>  esc_html__('Parallax Header', 'salient-core'),
         'desc' => esc_html__('This will cause your header to have a parallax scroll effect.', 'salient-core'),
         'id' => '_nectar_header_parallax',
         'type' => 'checkbox',
         'extra' => 'first2',
         'std' => 1
       ),	
       array(
         'name' =>  esc_html__('Box Roll Header', 'salient-core'),
         'desc' => esc_html__('This will cause your header to have a 3d box roll on scroll. (deactivated for boxed layouts)', 'salient-core'),
         'id' => '_nectar_header_box_roll',
         'type' => 'checkbox',
         'extra' => 'last',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Page Header Height', 'salient-core'),
         'desc' => esc_html__('How tall do you want your header? Don\'t include "px" in the string. e.g. 350 This only applies when you are using an image/bg color.', 'salient-core'),
         'id' => '_nectar_header_bg_height',
         'type' => 'text',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Fullscreen Height', 'salient-core'),
         'desc' => esc_html__('Choosing this option will allow your header to always remain fullscreen on all devices/screen sizes.', 'salient-core'),
         'id' => '_nectar_header_fullscreen',
         'type' => 'checkbox',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Page Header Title', 'salient-core'),
         'desc' => esc_html__('Enter in the page header title', 'salient-core'),
         'id' => '_nectar_header_title',
         'type' => 'text',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Page Header Subtitle', 'salient-core'),
         'desc' => esc_html__('Enter in the page header subtitle', 'salient-core'),
         'id' => '_nectar_header_subtitle',
         'type' => 'text',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Text Effect', 'salient-core'),
         'desc' => esc_html__('Please select your desired text effect', 'salient-core'),
         'id' => '_nectar_page_header_text-effect',
         'type' => 'select',
         'std' => 'none',
         'options' => array(
           "none" => esc_html__("None", 'salient-core'),
           "rotate_in" => esc_html__("Rotate In", 'salient-core')
         )
       ),
       array( 
         'name' => esc_html__('Shape Autorotate Timing', 'salient-core'),
         'desc' => esc_html__('Enter your desired autorotation time in milliseconds e.g. "5000". Leaving this blank will disable the functionality.', 'salient-core'),
         'id' => '_nectar_particle_rotation_timing',
         'type' => 'text',
         'std' => ''
       ),
       array(
         'name' =>  esc_html__('Disable Chance For Particle Explosion', 'salient-core'),
         'desc' => esc_html__('By default there\'s a 50% chance on autorotation that your particles will explode. Checking this box disables that.', 'salient-core'),
         'id' => '_nectar_particle_disable_explosion',
         'type' => 'checkbox',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Content Alignment', 'salient-core'),
         'desc' => esc_html__('Horizontal Alignment', 'salient-core'),
         'id' => '_nectar_page_header_alignment',
         'type' => 'caption_pos',
         'options' => array(
           'left' => esc_html__('Left', 'salient-core'),
           'center' => esc_html__('Centered', 'salient-core'),
           'right' => esc_html__('Right', 'salient-core')
         ),
         'std' => 'left',
         'extra' => 'first2'
       ),
       array( 
         'name' => esc_html__('Content Alignment', 'salient-core'),
         'desc' => esc_html__('Vertical Alignment', 'salient-core'),
         'id' => '_nectar_page_header_alignment_v',
         'type' => 'caption_pos',
         'options' => array(
           'top' => esc_html__('Top', 'salient-core'),
           'middle' => esc_html__('Middle', 'salient-core'),
           'bottom' => esc_html__('Bottom', 'salient-core')
         ),
         'std' => 'middle',
         'extra' => 'last'
       ),
       array( 
         'name' => esc_html__('Background Alignment', 'salient-core'),
         'desc' => esc_html__('Please choose how you would like your header background to be aligned', 'salient-core'),
         'id' => '_nectar_page_header_bg_alignment',
         'type' => 'select',
         'std' => 'center',
         'options' => array(
           "top" => esc_html__("Top", "salient-core"),
           "center" => esc_html__("Center", "salient-core"),
           "bottom" => esc_html__("Bottom", "salient-core")
         )
       ),
       array( 
         'name' => esc_html__('Page Header Background Color', 'salient-core'),
         'desc' => esc_html__('Set your desired page header background color if not using an image', 'salient-core'),
         'id' => '_nectar_header_bg_color',
         'type' => 'color',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Page Header Font Color', 'salient-core'),
         'desc' => esc_html__('Set your desired page header font color', 'salient-core'),
         'id' => '_nectar_header_font_color',
         'type' => 'color',
         'std' => ''
       ),
       array( 
         'name' => esc_html__('Page Header Overlay Color', 'salient-core'),
         'desc' => esc_html__('This will be applied on top on your page header BG image (if supplied).', 'salient-core'),
         'id' => '_nectar_header_bg_overlay_color',
         'type' => 'color',
         'std' => ''
       )
     )
   );
  
  if( defined( 'NECTAR_THEME_NAME' ) ) {
    nectar_reg_meta_box( $meta_box['id'], $meta_box['title'], 'nectar_metabox_salient_page_callback', $meta_box['post_type'], $meta_box['context'], $meta_box['priority'], $meta_box );
  }
}


?>