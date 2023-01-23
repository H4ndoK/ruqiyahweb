<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Single project template */
add_filter( 'single_template', 'salient_set_portfolio_single_template' );

if( !function_exists('salient_set_portfolio_single_template') ) {
  function salient_set_portfolio_single_template($single_template) {
       global $post;
       if ($post->post_type === 'portfolio') {
         
         $salient_portfolio_child_single_override = ( is_child_theme() && file_exists( get_stylesheet_directory() . '/single-portfolio.php') ) ? true : false;

         if( $salient_portfolio_child_single_override ) {
           // Found in child theme.
           $single_template = get_stylesheet_directory() . '/single-portfolio.php';
         } else {
           // Load from plugin.
           $single_template = SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/frontend/single-portfolio.php';
         }

       }
       return $single_template;
  }
}


/* Taxonomy templates */
add_filter('template_include', 'salient_set_portfolio_tax_template');


if( !function_exists('salient_set_portfolio_tax_template') ) {
  
  function salient_set_portfolio_tax_template( $template ) {
    
    if( is_tax('project-type') ) {
      
      $salient_portfolio_child_tax_project_type_override = ( is_child_theme() && file_exists( get_stylesheet_directory() . '/taxonomy-project-type.php') ) ? true : false;
      
      if( $salient_portfolio_child_tax_project_type_override ) {
        // Found in child theme.
        $template = get_stylesheet_directory() . '/taxonomy-project-type.php';
      } else {
        // Load from plugin.
        $template = SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/frontend/taxonomy-project-type.php';
      }
      
    } 
    else if( is_tax('project-attributes') ) {
      $salient_portfolio_child_tax_project_attr_override = ( is_child_theme() && file_exists( get_stylesheet_directory() . '/taxonomy-project-attributes.php') ) ? true : false;
      
      if( $salient_portfolio_child_tax_project_attr_override ) {
        // Found in child theme.
        $template = get_stylesheet_directory() . '/taxonomy-project-attributes.php';
      } else {
        // Load from plugin.
        $template = SALIENT_PORTFOLIO_ROOT_DIR_PATH.'includes/frontend/taxonomy-project-attributes.php';
      }
      
    } 
    
    return $template;
  }
  
}

