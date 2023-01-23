<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"image" => "",
	"url" => '#',
	"url_target" => '_blank',
	"alt" => ""), $atts));

$img_dimens   = false;
$img_dimens_w = null;
$img_dimens_h = null;
$img_dimens_o = '';
$img_attrs    = '';

(!empty($alt)) ? $alt_tag = $alt : $alt_tag = esc_html__('client','salient');

if (preg_match('/^\d+$/',$image) ) {

	$wp_img_alt_tag = get_post_meta( $image, '_wp_attachment_image_alt', true );
	if (!empty($wp_img_alt_tag)) {
		$alt_tag = $wp_img_alt_tag;
	}

	$image_src = wp_get_attachment_image_src($image, 'full');
	$image     = $image_src[0];

	$img_dimens   = true;
	$img_dimens_w = $image_src[1];
	$img_dimens_h = $image_src[2];
	$img_dimens_o = ' width="'.esc_attr($img_dimens_w).'" height="'.esc_attr($img_dimens_h).'"';

	// Lazy loading.
	if( property_exists('NectarLazyImages', 'global_option_active') && true === NectarLazyImages::$global_option_active ) {

		$placeholder_img_src = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20".esc_attr($img_dimens_w).'%20'.esc_attr($img_dimens_h)."'%2F%3E";
		$img_attrs .= ' data-nectar-img-src="'.esc_url($image).'" class="nectar-lazy"';
		$image = $placeholder_img_src;
	}

}

// Output.
if (!empty($url) && $url !== 'none' && $url !== '#') : ?>
	<div><a href="<?php echo esc_attr( $url ); ?>" target="<?php echo esc_attr($url_target); ?>">
		<?php echo '<img src="'.esc_attr( $image ).'" alt="'.esc_attr( $alt_tag ).'"'.$img_dimens_o . $img_attrs.' />'; ?>
	</a></div>
<?php else : ?>
	<div class="no-link">
		<?php echo '<img src="'.esc_attr( $image ).'" alt="'.esc_attr( $alt_tag ).'"'.$img_dimens_o . $img_attrs.' />'; ?>
	</div>
<?php endif; ?>
