<?php 

/**
* Demo Importer Initialize.
*
* @since 1.0
*/


// Only load when using Salient.
if( defined( 'NECTAR_THEME_NAME' ) ) {
  
  add_action("redux/extensions/salient_redux/before", 'redux_register_nectar_demo_importer_extension_loader', 0);
  add_filter( 'wbc_importer_description', 'nectar_wbc_importer_description_text', 10 );
  add_action( 'wbc_importer_after_content_import', 'nectar_after_ecommerce_demo_import', 10, 2 );
  add_action( 'wbc_importer_after_content_import', 'nectar_after_content_import', 10, 2 );
  add_action( 'wbc_importer_before_content_import', 'nectar_before_content_import', 10, 2 );
  
}




/**
* Loads demo importer extension.
*
* @since 1.0
*/
if( ! function_exists( 'redux_register_nectar_demo_importer_extension_loader' ) ) {
  
  function redux_register_nectar_demo_importer_extension_loader( $ReduxFramework ) {
    
    $extension_class = 'ReduxFramework_Extension_wbc_importer';
    
    if( ! class_exists( $extension_class ) ) {
      
      $path       = SALIENT_DEMO_IMPORTER_ROOT_DIR_PATH . 'includes/admin/redux-extensions/';
      $folder     = 'wbc_importer';
      $class_file = $path . $folder . '/extension_' . $folder . '.php';
      $class_file = apply_filters( 'redux/extension/salient_redux/'.$folder, $class_file );
      
      if( $class_file && file_exists($class_file) ) {
        require_once( $class_file );
        $extension = new $extension_class( $ReduxFramework );
      }
      
    }
    
  }
  
}


/**
* Alter demo importer top helper text.
*
* @since 1.0
*/
if ( ! function_exists( 'nectar_wbc_importer_description_text' ) ) {
  
  function nectar_wbc_importer_description_text( $description ) {
    $message  = '<p>' . esc_html__( 'A note for users importing demos on an existing WordPress install: When the option is selected to import "Theme option settings", your current theme options will be overwritten.', 'salient-demo-importer' ) . '</p>';
    $message .= '<p>' . esc_html__( 'Ensure that you have all required plugins installed & activated for the demo you wish to import before confirming the import.', 'salient-demo-importer' ) . ' ' . esc_html__( 'For demos that require the WooCommerce plugin - do not forget to run the', 'salient-demo-importer' ) . ' ' . esc_html( 'plugin setup wizard', 'salient-demo-importer' ) . ' ' . esc_html( 'before the demo importer if you have not previously used the plugin on your site.', 'salient-demo-importer' ) . '</p>';
    $message .= '<p>'.esc_html__('Demos that are marked as ','salient-demo-importer') . '<i>' . esc_html__('Legacy','salient-demo-importer') . '</i>' . esc_html__(' do not come with a set of dummy images and instead will only import placeholders.','salient-demo-importer').'</p>';
    $message .= '<p>' . esc_html__( 'See the', 'salient-demo-importer' ) . ' <a href="//themenectar.com/docs/salient/importing-demo-content/" target="_blank">' . esc_html__( 'documentation', 'salient-demo-importer' ) . '</a> ' . esc_html__( 'if you run into trouble importing a demo.', 'salient-demo-importer' ) . '</p>';
    return $message;
  }
  
}



/**
* Update WooCommerce category thumbnail.
*
* @since 1.0
*/
if ( ! function_exists( 'nectar_update_woo_cat_thumb' ) ) {
  
  function nectar_update_woo_cat_thumb( $cat_slug, $thumb_id ) {
    
    $n_woo_category    = get_term_by( 'slug', $cat_slug, 'product_cat' );
    $n_woo_category_id = ( $n_woo_category && isset( $n_woo_category->term_id ) ) ? $n_woo_category->term_id : false;
    if ( $n_woo_category_id ) {
      update_term_meta( $n_woo_category_id, 'thumbnail_id', $thumb_id );
    }
    
  }
  
}


/**
* Helper for assigning menu.
*
* @since 1.4
*/
function nectar_after_demo_import_assign_menu($slug, $location) {
  
  // Get Menu locations.
  $menu_locations = get_nav_menu_locations();
    
  // Get ID of menu by name.
  $nav_menu = get_term_by('slug', $slug, 'nav_menu');
  
  if( isset($nav_menu->term_id) ) {
    
     $nav_menu_id = $nav_menu->term_id;
     
     // Set menu.
     $menu_locations[$location] = $nav_menu_id;
     set_theme_mod( 'nav_menu_locations', $menu_locations );
  }
  
}


/**
* Helper for adding hash links.
*
* @since 1.4
*/
function nectar_after_demo_import_add_hash_links($slug, $hash_links_arr) {
  
  // Get menu id
  $nav_menu = get_term_by('slug', $slug, 'nav_menu');
  
  if( isset($nav_menu->term_id) ) {
    
    // Loop and add hash links
    foreach($hash_links_arr as $hash_name => $hash_link) {
      
      $generated_menu_url = home_url( '/' ) . '#' . $hash_link;
      
      wp_update_nav_menu_item($nav_menu->term_id, 0, array(
        'menu-item-title' => esc_html($hash_name),
        'menu-item-url' => esc_url($generated_menu_url),
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom', 
      ));
      
    }
    
  }
    
  
}


/**
* Helper for assigning front page.
*
* @since 1.4
*/
function nectar_after_demo_import_assign_front($page_name) {
  
  $page = get_page_by_title($page_name);
  
  if ( $page && isset($page->ID) ) {
    update_option( 'page_on_front', $page->ID );
    update_option( 'show_on_front', 'page' );
  }
  
}


/**
* eCommerce Specific after a demo has imported.
*
* @since 1.0
*/
if ( ! function_exists( 'nectar_after_ecommerce_demo_import' ) ) {
  
  function nectar_after_ecommerce_demo_import( $demo_active_import, $demo_directory_path ) {
    
    global $woocommerce;
    
    // eCommerce Ultimate
    if ( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Ecommerce-Ultimate' ) && $woocommerce ) {
      
      // Update shop page page header.
      $shop_page_id = wc_get_page_id( 'shop' );
      if ( $shop_page_id ) {
        
        update_post_meta( $shop_page_id, '_nectar_header_bg_color', '#eaf0ff' );
        update_post_meta( $shop_page_id, '_nectar_header_title', 'All Products' );
        update_post_meta( $shop_page_id, '_nectar_header_font_color', '#000000' );
        update_post_meta( $shop_page_id, '_nectar_header_subtitle', 'Affordable designer clothing with unmatched quality' );
        update_post_meta( $shop_page_id, '_nectar_page_header_alignment', 'center' );
        update_post_meta( $shop_page_id, '_nectar_header_bg_height', '230' );
        update_post_meta( $shop_page_id, '_disable_transparent_header', 'on' );
      }
      
      // Update category thumbnails.
      nectar_update_woo_cat_thumb( 'accessories', 5688 );
      nectar_update_woo_cat_thumb( 'basic-t-shirts', 17 );
      nectar_update_woo_cat_thumb( 'casual-shirts', 29 );
      nectar_update_woo_cat_thumb( 'fresh-clothing', 18 );
      nectar_update_woo_cat_thumb( 'hipster-style', 41 );
      nectar_update_woo_cat_thumb( 'outerwear', 38 );
      nectar_update_woo_cat_thumb( 'sports-clothing', 5767 );
      
    } // end ecommerce ultimate
    
    // eCommerce Creative
    elseif ( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Ecommerce-Creative' ) && $woocommerce ) {
      
      // Update shop page page header.
      $shop_page_id = wc_get_page_id( 'shop' );
      if ( $shop_page_id ) {
        update_post_meta( $shop_page_id, '_nectar_header_title', 'The Shop' );
        update_post_meta( $shop_page_id, '_nectar_header_subtitle', 'Affordable designer clothing with unmatched quality' );
        update_post_meta( $shop_page_id, '_nectar_page_header_alignment', 'center' );
        update_post_meta( $shop_page_id, '_nectar_header_bg_height', '400' );
        update_post_meta( $shop_page_id, '_nectar_header_bg', 'http://themenectar.com/demo/salient-ecommerce-creative/wp-content/uploads/2018/08/adrian-sava-184378-unsplash.jpg' );
      }
      
      // Update category thumbnails.
      nectar_update_woo_cat_thumb( 'basic-t-shirts', 3002 );
      nectar_update_woo_cat_thumb( 'casual-shirts', 3004 );
      nectar_update_woo_cat_thumb( 'cool-clothing', 3003 );
      nectar_update_woo_cat_thumb( 'fresh-accessories', 3001 );
      nectar_update_woo_cat_thumb( 'hipster-style', 2960 );
      nectar_update_woo_cat_thumb( 'outerwear', 3060 );
      nectar_update_woo_cat_thumb( 'sport-clothing', 2970 );
      
    } // end ecommerce creative
    
    
  } // main function end
  
}



/**
* Disable additional image sizes for demos which do not need them.
*
* @since 1.2
*/
if( !function_exists('nectar_before_content_import') ) {
  function nectar_before_content_import( $demo_active_import, $demo_directory_path ) {
    if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Ecommerce-Robust' ) ) {
      add_filter( 'intermediate_image_sizes_advanced', 'nectar_disable_additional_image_sizes', 10, 2 );
    }
  }
}

if( !function_exists('nectar_disable_additional_image_sizes') ) {
  function nectar_disable_additional_image_sizes( $sizes, $image_meta ) {

    $sizes_to_remove = array(
      'portfolio-thumb_large',
      'portfolio-thumb_small',
      'portfolio-thumb',
      'portfolio-widget',
      'nectar_small_square',
      'wide', 
      'wide_small', 
      'regular', 
      'regular_small', 
      'tall', 
      'wide_tall', 
      'wide_photography',
      'medium_featured',
      'large_featured',
      'medium',
    );
    
    foreach( $sizes_to_remove as $size ) {
      if( isset($sizes[$size]) ) {
        unset( $sizes[$size] ); 
      }
    }
    
    return $sizes;
  } 
} 


/**
* General after a demo has imported.
*
* Assigns menus and front.
*
* @since 1.4
*/
if( !function_exists('nectar_after_content_import') ) {
  
  function nectar_after_content_import( $demo_active_import, $demo_directory_path ) {
    
    // Architect.
    if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'SaaS' ) ) {
      nectar_after_demo_import_assign_menu('saas-main-navigation', 'top_nav');
      nectar_after_demo_import_assign_menu('saas-pull-right', 'top_nav_pull_right');
      nectar_after_demo_import_assign_front('SaaS Landing');

      $hash_links = array(
        'Our values' => 'intro',
        'Why Salient?' => 'testimonials',
        'How it works' => 'how-it-works'
      );
      nectar_after_demo_import_add_hash_links('saas-main-navigation', $hash_links);

    }

    // Architect.
    if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Architect' ) ) {
      nectar_after_demo_import_assign_menu('salient-architect-main-menu', 'off_canvas_nav');
      nectar_after_demo_import_assign_menu('salient-architect-top-menu', 'top_nav_pull_right');
      nectar_after_demo_import_assign_front('Salient Architect Landing');
    }

    // Resort.
    if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Resort' ) ) {
      nectar_after_demo_import_assign_menu('salient-resort-main-menu', 'off_canvas_nav');
      nectar_after_demo_import_assign_menu('salient-resort-side-buttons', 'top_nav_pull_right');
      nectar_after_demo_import_assign_front('Salient Resort Landing');
    }

    // eCommerce Robust
    if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Ecommerce-Robust' ) ) {
      
      // Generate Menu CSS.
      if( class_exists('Nectar_WP_Menu_Style_Manager') ) {
        set_transient( 'salient_menu_css_regenerate', 1, 60 );
      }
      
      // Assign menu/front.
      nectar_after_demo_import_assign_menu('ecommerce-robust', 'top_nav_pull_left');
      nectar_after_demo_import_assign_menu('ecommerce-robust-right-side', 'top_nav_pull_right');
      nectar_after_demo_import_assign_front('eCommerce Robust Landing');
      
      // Update category thumbnails.
      nectar_update_woo_cat_thumb( 'accessories', 1437 );
      nectar_update_woo_cat_thumb( 'cosmetics', 1442 );
      nectar_update_woo_cat_thumb( 'skincare', 1439 );
      nectar_update_woo_cat_thumb( 'supplements', 832 );
      nectar_update_woo_cat_thumb( 'anti-acne', 834 );
      nectar_update_woo_cat_thumb( 'cleanse', 839 );
      nectar_update_woo_cat_thumb( 'exfoliators', 835 );
      nectar_update_woo_cat_thumb( 'extracts', 1440 );
      nectar_update_woo_cat_thumb( 'moisturize', 836 );

      
    }
    
    // Wellness
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Wellness' ) ) {
      
      nectar_after_demo_import_assign_menu('wellness-off-canvas-menu', 'off_canvas_nav');
      nectar_after_demo_import_assign_front('Wellness - Home');
      
      $hash_links = array(
        'Home' => 'home',
        'Services' => 'services',
        'Our Story' => 'story',
        'Pricing' => 'pricing'
      );
      nectar_after_demo_import_add_hash_links('wellness-off-canvas-menu', $hash_links);
    }
    // Nonprofit
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Nonprofit' ) ) {
      
      nectar_after_demo_import_assign_menu('nonprofit-menu', 'off_canvas_nav');
      nectar_after_demo_import_assign_front('Nonprofit Landing');
      
      $hash_links = array(
        'Introduction' => 'home',
        'Philosophy' => 'philosophy',
        'Testimonials' => 'testimonials',
        'Areas of Impact' => 'impact'
      );
      nectar_after_demo_import_add_hash_links('nonprofit-menu', $hash_links);
    }
    // Business 3
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Business-3' ) ) {
      
      nectar_after_demo_import_assign_menu('business-3-main-menu', 'top_nav');
      nectar_after_demo_import_assign_menu('business-3-right-menu', 'top_nav_pull_right');
      nectar_after_demo_import_assign_front('Business Landing');
    }
    // Corporate 3
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Corporate-3' ) ) {
      
      nectar_after_demo_import_assign_menu('corporate-3', 'top_nav');
      nectar_after_demo_import_assign_front('Corporate 3 Landing');
    }
    // Freelance Portfolio
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Freelance-Portfolio' ) ) {
      
      nectar_after_demo_import_assign_menu('freelance-portfolio-menu', 'off_canvas_nav');
      nectar_after_demo_import_assign_front('Freelance Portfolio - Home');
    }
    // eCommerce Ultimate
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Ecommerce-Ultimate' ) ) {
      
      nectar_after_demo_import_assign_menu('ecommerce-ultimate-main-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('eCommerce Ultimate Home Page');
    }
    
    // eCommerce Creative
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Ecommerce-Creative' ) ) {
      
      nectar_after_demo_import_assign_menu('ecommerce-creative-main-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('eCommerce Creative Home Page');
    }
    
    // Blog Dark
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Dark-Blog' ) ) {
      nectar_after_demo_import_assign_front('Blog Dark Landing');
    }
    
    // Corporate 2
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Corporate-2' ) ) {
      
      nectar_after_demo_import_assign_menu('corporate-2-nav', 'top_nav');
      nectar_after_demo_import_assign_front('Corporate 2 Landing');
    }
    
    // Blog Ultimate
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Blog-Ultimate' ) ) {
      
      nectar_after_demo_import_assign_menu('blog-ultimate-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('Ultimate Blog Landing');
    }
    
    // Corporate Creative
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Corporate-Creative' ) ) {
      
      nectar_after_demo_import_assign_menu('corporate-creative-nav', 'top_nav');
      nectar_after_demo_import_assign_front('Corporate Creative Landing');
    }
    
    // Blog Magazine
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Blog-Magazine' ) ) {
      
      nectar_after_demo_import_assign_menu('magazine-blog-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('Magazine Blog Landing');
    }
    
    // Business 2
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Business-2' ) ) {
      
      nectar_after_demo_import_assign_menu('business-2-nav', 'off_canvas_nav');
      nectar_after_demo_import_assign_front('Business 2 Landing');
    }
    
    // Startup
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Company-Startup' ) ) {
      
      nectar_after_demo_import_assign_menu('startup-menu', 'top_nav');
      nectar_after_demo_import_assign_menu('startup-right-pull-menu', 'top_nav_pull_right');
      nectar_after_demo_import_assign_front('Startup Home');
    }
    
    // Fullscreen Portfolio
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Fullscreen Portfolio Slider' ) ) {
      
      nectar_after_demo_import_assign_menu('slider-portfolio-menu', 'top_nav');
      nectar_after_demo_import_assign_front('Home - Slider Portfolio');
    }
    
    // Band
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Band' ) ) {
      
      nectar_after_demo_import_assign_menu('band-menu', 'top_nav');
      nectar_after_demo_import_assign_front('Band Home Page');
    }
    
    // Minimal Portfolio
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Minimal Portfolio' ) ) {
      
      nectar_after_demo_import_assign_menu('minimal-portfolio-menu', 'top_nav');
      nectar_after_demo_import_assign_front('Home - Minimal Portfolio');
    }
    
    // Corporate
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Corporate' ) ) {
      
      nectar_after_demo_import_assign_menu('corporate-main-nav', 'top_nav');
      nectar_after_demo_import_assign_front('Home');
    }
    
    // Agency
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Agency' ) ) {
      
      nectar_after_demo_import_assign_menu('main-nav', 'off_canvas_nav');
      nectar_after_demo_import_assign_front('Home - Default');
    }
    
    // Restaurant
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Restaurant' ) ) {
      
      nectar_after_demo_import_assign_menu('restaurant-menu', 'top_nav');
      nectar_after_demo_import_assign_front('Restaurant - Home Page');
    }
    
    // Business
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Business' ) ) {
      
      nectar_after_demo_import_assign_menu('business-demo', 'top_nav');
      nectar_after_demo_import_assign_front('Home');
    }
    
    // Landing Service
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Landing Service' ) ) {
      
      nectar_after_demo_import_assign_menu('service-demo', 'top_nav');
      nectar_after_demo_import_assign_front('Home - Service Demo');
    }
    
    // Photography
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Photography' ) ) {
      
      nectar_after_demo_import_assign_menu('photography-menu', 'top_nav');
      nectar_after_demo_import_assign_front('Featured');
    }
    
    // Landing Product
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Landing Product' ) ) {
      
      nectar_after_demo_import_assign_menu('product-landing-demo', 'off_canvas_nav');
      nectar_after_demo_import_assign_front('Home - Product Landing Demo');
    }
    
    // App
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'App' ) ) {
      
      nectar_after_demo_import_assign_menu('app-demo', 'off_canvas_nav');
      nectar_after_demo_import_assign_front('Home - App Demo');
    }
    
    // Simple Blog
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Simple Blog' ) ) {
      
      nectar_after_demo_import_assign_menu('simple-blog-main-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('Home - Landing Page');
    }
    
    // Old School Ecommerce
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Old-School-Ecommerce' ) ) {
      
      nectar_after_demo_import_assign_menu('top-nav', 'top_nav');
      nectar_after_demo_import_assign_front('Home');
    }
    
    // One Page
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'One-Page' ) ) {
      
      nectar_after_demo_import_assign_menu('header', 'top_nav');
      nectar_after_demo_import_assign_front('Home ');
    }
    
    // Ascend
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Ascend' ) ) {
      
      nectar_after_demo_import_assign_menu('ascend-main-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('Home - Landing Page');
    }
    
    // Frostwave
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Frostwave' ) ) {
      
      nectar_after_demo_import_assign_menu('frostwave-main-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('Home - Landing Page');
    }
    
    // Old School Classic
    else if( isset( $demo_directory_path ) && strpos( $demo_directory_path, 'Old-School-All-Purpose' ) ) {
      
      nectar_after_demo_import_assign_menu('main-navigation', 'top_nav');
      nectar_after_demo_import_assign_front('Home - Landing Page');
    }

    
  }
  
}