<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	'section_type' => 'image',
	'image' => '',
	'video_mp4' => '',
	'video_webm' => '',
	'video_fit' => 'cover',
	'video_alignment' => 'default',
	'video_functionality' => 'loop'
), $atts));


$media_asset = '';
$video = '';
$count = isset($GLOBALS['nectar-sticky-media-section-count']) ? $GLOBALS['nectar-sticky-media-section-count'] : 0;

$nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;

if($nectar_using_VC_front_end_editor) {
	$count = 1;
}

// Section Type
//// Image.
if( 'image' === $section_type ) {

	$image_src = '';

	if( preg_match('/^\d+$/', $image) ) {
		$image_arr = wp_get_attachment_image_src($image, 'full');

		if (isset($image_arr[0])) {
			$image_src = $image_arr[0];
		}
	} 
	else {
		$image_src = $image;
	}

	// Lazy load.
	if( $count != 0 ) {
		$media_asset = 'data-nectar-img-src="'.esc_attr($image_src).'"';
	} else {
		$media_asset = ' style="background-image:url('.esc_attr($image_src).')"';
	}
	
} 

//// Video.
else if( 'video' === $section_type  ) {
	
	$video_classes = array('fit-'.esc_attr($video_fit));

	if( 'cover' === $video_fit ) {
		$video_classes[] = 'align-'.esc_attr($video_alignment);
	}
	
	$loop_attr = 'loop';

	if('no-loop' === $video_functionality) {
		$loop_attr = '';
		$video_classes[] = 'no-loop';
	}

	// Lazy load.
    //if ($count != 0) {

		$video_classes[] = 'nectar-lazy-video';

		$video = '<video width="1800" height="700" preload="auto" '.$loop_attr.' muted playsinline class="'.nectar_clean_classnames(implode(' ',$video_classes)).'">';
        if (!empty($video_webm)) { $video .= '<source data-nectar-video-src="'. esc_url($video_webm) .'" type="video/webm">'; }
		if (!empty($video_mp4)) { $video .= '<source data-nectar-video-src="'. esc_url($video_mp4) .'"  type="video/mp4">'; }
		$video .= '</video>';
    // } else {
	// 	$video = '<video width="1800" height="700" preload="auto" '.$loop_attr.' muted playsinline class="'.nectar_clean_classnames(implode(' ',$video_classes)).'">';
	// 	if (!empty($video_webm)) { $video .= '<source src="'. esc_url($video_webm) .'" type="video/webm">'; }
	// 	if (!empty($video_mp4)) { $video .= '<source src="'. esc_url($video_mp4) .'"  type="video/mp4">'; }
	// 	$video .= '</video>';
		
	// }
	
}

$featured_media = '<div class="nectar-sticky-media-content__media-wrap"><div class="nectar-sticky-media-section__media"'.$media_asset.' data-type="'.$section_type.'">'.$video.'</div></div>';

$GLOBALS['nectar-sticky-media-section-count'] = $count + 1;

echo '<div class="nectar-sticky-media-section__content-section">' . $featured_media . do_shortcode($content) . '</div>';