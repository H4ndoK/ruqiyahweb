<?php
/**
 * Post categories
 *
 * @package Salient WordPress Theme
 * @subpackage Partials
 * @version 13.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<span class="meta-category nectar-inherit-label">

<?php
$categories = get_the_category();
if ( ! empty( $categories ) ) {
  $output = null;
  foreach ( $categories as $category ) {
    $output .= '<a class="' . esc_attr( $category->slug ) . ' nectar-inherit-border-radius nectar-bg-hover-accent-color" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'salient' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>';
  }
  echo apply_filters('nectar_blog_page_header_categories', trim( $output )); // WPCS: XSS ok.
}
?>
</span>