<?php
/**
 * Salient helpers when Salient theme is not in use.
 *
 * @version 1.0
 */
 
 
 if( !function_exists('nectar_header_section_check') ) {
   
   function nectar_header_section_check() {
     return false;
   }
   
 }
 
 
 /**
  * Get theme options
  *
  * Since Salient is not active, we're going to
  * define some basic options. 
  *
  * @version 1.0
  */
 if( !function_exists('get_nectar_theme_options') ) {
   function get_nectar_theme_options() {
     return array(
       'accent-color' => '#3a67ff',
       'extra-color-1' => '#ff1053',
       'extra-color-2' => '#2AC4EA',
       'extra-color-3' => '#000',
       'extra-color-gradient' => array(
         'from' => '#3a67ff',
         'to'   => '#ff1053'
       ),
       'extra-color-gradient-2' => array(
         'from' => '#2AC4EA',
         'to'   => '#32d6ff'
       )
     );
   }
 }
 
 
 
 /**
  * Nectar excerpt
  *
  * @version 1.0
  */

 if ( ! function_exists( 'nectar_excerpt' ) ) {
 
 	function nectar_excerpt( $limit ) {
 
 		if ( has_excerpt() ) {
 			$the_excerpt = get_the_excerpt();
 			$the_excerpt = preg_replace( '/\[[^\]]+\]/', '', $the_excerpt );  // strip shortcodes, keep shortcode content
 			return wp_trim_words( $the_excerpt, $limit );
 		} else {
 			$the_content = get_the_content();
 			$the_content = preg_replace( '/\[[^\]]+\]/', '', $the_content );  // strip shortcodes, keep shortcode content
 			return wp_trim_words( $the_content, $limit );
 		}
 	}
  
 }
 
 
 
 /**
  * Grab IDs from gallery shortcode
  *
  * @since 1.0
  */
 if ( ! function_exists( 'nectar_grab_ids_from_gallery' ) ) {
 
 	function nectar_grab_ids_from_gallery() {
 		global $post;
 
 		if ( $post != null ) {
 
 			// if WP 5.0+ block editor
 			if ( function_exists( 'parse_blocks' ) ) {
 
 				if ( false !== strpos( $post->post_content, '<!-- wp:' ) ) {
 					 $post_blocks = parse_blocks( $post->post_content );
 
 					 // loop through and look for gallery
 					foreach ( $post_blocks as $key => $block ) {
 
 						// gallery block found
 						if ( isset( $block['blockName'] ) && isset( $block['innerHTML'] ) && $block['blockName'] == 'core/gallery' ) {
 
 							   preg_match_all( '/data-id="([^"]*)"/', $block['innerHTML'], $id_matches );
 
 							if ( $id_matches && isset( $id_matches[1] ) ) {
 								return $id_matches[1];
 							}
 						} //gallery block found end
 
 					} //foreach post block loop end
 
 				} //if the post appears to be using gutenberg
 
 			}
 
 			$attachment_ids          = array();
 			$pattern                 = '\[(\[?)(gallery)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
 			$ids                     = array();
 			$portfolio_extra_content = get_post_meta( $post->ID, '_nectar_portfolio_extra_content', true );
 
 			if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches ) ) {
 
 				$count = count( $matches[3] );      // in case there is more than one gallery in the post.
 				for ( $i = 0; $i < $count; $i++ ) {
 					$atts = shortcode_parse_atts( $matches[3][ $i ] );
 					if ( isset( $atts['ids'] ) ) {
 						$attachment_ids = explode( ',', $atts['ids'] );
 						$ids            = array_merge( $ids, $attachment_ids );
 					}
 				}
 			}
 
 			if ( preg_match_all( '/' . $pattern . '/s', $portfolio_extra_content, $matches ) ) {
 				$count = count( $matches[3] );
 				for ( $i = 0; $i < $count; $i++ ) {
 					$atts = shortcode_parse_atts( $matches[3][ $i ] );
 					if ( isset( $atts['ids'] ) ) {
 						$attachment_ids = explode( ',', $atts['ids'] );
 						$ids            = array_merge( $ids, $attachment_ids );
 					}
 				}
 			}
 			return $ids;
 		} else {
 			$ids = array();
 			return $ids;
 		}
 
 	}
 }
 
 