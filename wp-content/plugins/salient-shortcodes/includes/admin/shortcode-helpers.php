<?php 

/**
 * Extract the IDs from a gallery el.
 *
 * @since 1.0
 */
if ( ! function_exists( 'nectar_grab_ids_from_gallery' ) ) {

	function nectar_grab_ids_from_gallery() {
		global $post;

		if ( $post != null ) {

			// WP 5.0+ block editor
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

