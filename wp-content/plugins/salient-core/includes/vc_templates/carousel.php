<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

extract(shortcode_atts(array(
	"carousel_title" => '',
	"scroll_speed" => 'medium',
	'loop' => 'false',
	'color' => 'default',
	'flickity_fixed_content' => '',
	'flickity_formatting' => 'default',
	'flickity_controls' => 'default',
	'flickity_overflow' => 'hidden',
	'flickity_wrap_around' => 'wrap',
	'flickity_centered_cells' => 'false',
	'flickity_spacing' => 'default',
	'flickity_image_scale_on_drag' => '',
	'flickity_fixed_content_alignment' => 'default',
	'flickity_touch_total_hide_indicator' => '',
	'flickity_touch_total_icon_color' => 'default',
	'flickity_adaptive_height' => '',
	'flickity_element_spacing' => 'default',
	'flickity_autorotate_pause_on_hover' => '',
  'flickity_touch_total_style' => 'default',
  'flickity_touch_total_indicator_bg_color' => '#000',
  'flickity_touch_total_indicator_icon_color' => '#fff',
	'easing' => 'easeInExpo',
	'autorotate' => '',
	'autorotate_type' => '',
	'enable_animation' => '',
	'delay' => '',
	'autorotation_speed' => '5000',
	'ticker_speed' => 'slow',
	'column_padding' => '' ,
	'script' => 'carouFredSel',
	'desktop_cols' => '4',
	'desktop_small_cols' => '3',
	'tablet_cols' => '2',
	'mobile_cols' => '1',
	'cta_button_text' => '',
	'cta_button_url' => '',
	'cta_button_open_new_tab' => '',
	'button_color' => '',
	'enable_column_border' => '',
	'border_radius' => 'none',
	'pagination_alignment_flickity' => 'default',
	'column_color' => '',
	'desktop_cols_flickity' => '3',
	'desktop_small_cols_flickity' => '3',
	'tablet_cols_flickity' => '2',
	'phone_cols_flickity' => '1',
	'simple_slider_sizing' => 'aspect_ratio',
	'simple_slider_aspect_ratio' => '1-1',
	'simple_slider_height' => '50vh',
	'simple_slider_arrow_controls' => '',
	'simple_slider_pagination_controls' => '',
	'simple_slider_pagination_alignment' => '',
	'simple_slider_parallax' => '',
	'simple_slider_wrap' => '',
	'simple_slider_row_bg_connect' => '',
	'simple_slider_transition_type' => '',
  'simple_slider_touch_indicator' => '',
  'simple_slider_touch_indicator_bg_color' => '#000',
  'simple_slider_touch_indicator_icon_color' => '#fff'

	), $atts));

global $post;

$nectar_using_VC_front_end_editor = false;

if( isset($_GET['vc_editable']) ) {

	$nectar_using_VC_front_end_editor = sanitize_text_field($_GET['vc_editable']);
	$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
	// Limit script choices on front end editor.
	if($nectar_using_VC_front_end_editor && in_array($script, array('carouFredSel','owl_carousel')) ) {
		$script = 'flickity';
	}

}

$GLOBALS['nectar-carousel-script']       = $script;
$GLOBALS['nectar_carousel_column_color'] = $column_color;

// Legacy.
if( $script === 'carouFredSel' ) {
	wp_enqueue_script( 'caroufredsel' );
	wp_enqueue_style( 'nectar-caroufredsel' );
	?>

	<div class="carousel-wrap" data-full-width="false">
	<div class="carousel-heading">
		<div class="container">
			<h2 class="uppercase"><?php echo wp_kses_post($carousel_title); ?></h2>
			<div class="control-wrap">
				<a class="carousel-prev" href="#"><i class="fa fa-angle-left"></i></a>
				<a class="carousel-next" href="#"><i class="fa fa-angle-right"></i></a>
			</div>
		</div>
	</div>
	<ul class="row carousel" data-scroll-speed="<?php echo esc_attr($scroll_speed); ?>" data-easing="<?php echo esc_attr($easing); ?>" data-autorotate="<?php echo esc_attr($autorotate); ?>">
	<?php echo do_shortcode($content) . '</ul></div>';
}

// Owl.
else if( $script === 'owl_carousel' ) {

  wp_enqueue_script('owl-carousel');
  wp_enqueue_style('nectar-owl-carousel');

	$delay = intval($delay);
	echo '<div class="owl-carousel" data-enable-animation="'.esc_attr($enable_animation).'" data-loop="'.esc_attr($loop).'"  data-animation-delay="'.esc_attr($delay).'" data-autorotate="' . esc_attr($autorotate) . '" data-autorotation-speed="'.esc_attr($autorotation_speed).'" data-column-padding="'.esc_attr($column_padding).'" data-desktop-cols="'.esc_attr($desktop_cols).'" data-desktop-small-cols="'.esc_attr($desktop_small_cols).'" data-tablet-cols="'.esc_attr($tablet_cols).'" data-mobile-cols="'.esc_attr($mobile_cols).'">';
	echo do_shortcode($content);
	echo '</div>';
}

// Flickity.
else if( $script === 'flickity' ) {

  wp_enqueue_script( 'flickity' );
  wp_enqueue_style( 'nectar-flickity' );

	if( $flickity_formatting === 'fixed_text_content_fullwidth' ) {

		echo '<div class="nectar-carousel-flickity-fixed-content" data-alignment="'.esc_attr($flickity_fixed_content_alignment).'" data-control-color="'.esc_attr($color).'"> <div class="nectar-carousel-fixed-content">';
		echo do_shortcode($flickity_fixed_content);

		if(!empty($cta_button_text)) {

			global $nectar_options;

			$button_color      = strtolower($button_color);
			$regular_btn_class = ' regular-button';
			$btn_text_markup   = '<span>'.$cta_button_text.'</span> <i class="icon-button-arrow"></i>';

			if($button_color === 'extra-color-gradient-1' || $button_color === 'extra-color-gradient-2') {
				$regular_btn_class = '';
				$btn_text_markup   = '<span class="start">'.$cta_button_text.' <i class="icon-button-arrow"></i></span><span class="hover">'.$cta_button_text.' <i class="icon-button-arrow"></i></span>';
			}

			if($nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-1') {
				$button_color    = 'm-extra-color-gradient-1';
				$btn_text_markup = '<span>'.$cta_button_text.'</span> <i class="icon-button-arrow"></i>';
			}

			else if( $nectar_options['theme-skin'] === 'material' && $button_color === 'extra-color-gradient-2') {
				$button_color    = 'm-extra-color-gradient-2';
				$btn_text_markup = '<span>'.$cta_button_text.'</span> <i class="icon-button-arrow"></i>';
			}

			$btn_target_markup = (!empty($cta_button_open_new_tab) && $cta_button_open_new_tab == 'true' ) ? 'target="_blank"' : null;

			echo '<div><a class="nectar-button large regular '. $button_color .  $regular_btn_class . ' has-icon" href="'.esc_url($cta_button_url).'" '.$btn_target_markup.' data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff">'.$btn_text_markup.'</a></div>';
		}

		echo '</div>';

	}

	// Dynamic style classes.
	$dynamic_class_names = '';
	if( function_exists('nectar_el_dynamic_classnames') ) {
		$dynamic_class_names = nectar_el_dynamic_classnames('carousel', $atts);
	}
	

  $flickity_attrs = '';

  if( $flickity_touch_total_style == 'solid_bg' ) {

    $flickity_attrs .= 'data-indicator-bg="'.esc_attr($flickity_touch_total_indicator_bg_color).'" ';
    $flickity_attrs .= 'data-indicator-icon="'.esc_attr($flickity_touch_total_indicator_icon_color).'" ';

  }

  if( 'ticker' === $autorotate_type ) {
	$flickity_attrs .= 'data-ticker-speed="'.esc_attr($ticker_speed).'" ';
  }

	echo '<div class="nectar-flickity not-initialized nectar-carousel'.esc_attr($dynamic_class_names).'" '.$flickity_attrs.'data-centered-cells="'.esc_attr($flickity_centered_cells).'" data-pause-on-hover="'.esc_attr($flickity_autorotate_pause_on_hover).'" data-touch-icon-color="'.esc_attr($flickity_touch_total_icon_color).'" data-control-color="'.esc_attr($color).'" data-overflow="'.esc_attr($flickity_overflow).'" data-r-bottom-total="'.esc_attr($flickity_touch_total_hide_indicator).'" data-drag-scale="'.esc_attr($flickity_image_scale_on_drag).'" data-wrap="'.esc_attr($flickity_wrap_around).'" data-spacing="'.esc_attr($flickity_spacing).'" data-controls="'.esc_attr($flickity_controls).'" data-pagination-alignment="'.esc_attr($pagination_alignment_flickity).'" data-adaptive-height="'.esc_attr($flickity_adaptive_height).'" data-border-radius="'.esc_attr($border_radius).'" data-column-border="'.esc_attr($enable_column_border).'" data-column-padding="'.esc_attr($column_padding).'" data-format="'.esc_attr($flickity_formatting).'" data-autoplay="'.esc_attr($autorotate).'" data-autoplay-dur="'.esc_attr($autorotation_speed).'" data-control-style="material_pagination" data-desktop-columns="'.esc_attr($desktop_cols_flickity).'" data-small-desktop-columns="'.esc_attr($desktop_small_cols_flickity).'" data-tablet-columns="'.esc_attr($tablet_cols_flickity).'" data-phone-columns="'.esc_attr($phone_cols_flickity).'" data-column-color="'.esc_attr($column_color).'">';
	echo '<div class="flickity-viewport"> <div class="flickity-slider">' . do_shortcode($content) . '</div></div>';
	echo '</div>';

	if( $flickity_formatting === 'fixed_text_content_fullwidth' ) {
		echo '</div>';
	}

}

// Simple Slider.
else if( $script === 'simple_slider' ) {

	$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';

	// ADD wp_enqueue_style( 'nectar-caroufredsel' ); to salient shortcodes
	$class_names = array('nectar-flickity','nectar-simple-slider');
	$attrs = array();

	$attrs[] = 'data-wrap="'.esc_attr($simple_slider_wrap).'"';
	$attrs[] = 'data-controls';
	$attrs[] = 'data-pagination="'.esc_attr($simple_slider_pagination_controls).'"';
	$attrs[] = 'data-arrows="'.esc_attr($simple_slider_arrow_controls).'"';
	$attrs[] = 'data-simple-slider-transition="'.esc_attr($simple_slider_transition_type).'"';
	$attrs[] = 'data-pause-on-hover="'.esc_attr($flickity_autorotate_pause_on_hover).'"';
  
  if( 'true' === $simple_slider_touch_indicator ) {
    $attrs[] = 'data-touch-indicator="true"';
    $class_names[] = 'drag-indicator-only';
    $attrs[] = 'data-indicator-bg="'.esc_attr($simple_slider_touch_indicator_bg_color).'"';
    $attrs[] = 'data-indicator-icon="'.esc_attr($simple_slider_touch_indicator_icon_color).'"';
  }

	if( 'true' === $simple_slider_pagination_controls ) {
		$attrs[] = 'data-pagination-alignment="'.esc_attr($simple_slider_pagination_alignment).'"';
	}
	if( 'true' ===  $simple_slider_row_bg_connect ) {
		$attrs[] = 'data-row-bg-connection="true"';
	}
	
	if( 'true' === $autorotate && !$nectar_using_VC_front_end_editor ) {
		$attrs[] = 'data-autoplay="'.esc_attr($autorotate).'"';
		$attrs[] = 'data-autoplay-dur="'.esc_attr($autorotation_speed).'"';
	}
	if( 'true' === $simple_slider_parallax && !$nectar_using_VC_front_end_editor && 'on' !== $page_full_screen_rows ) {
		$attrs[] = 'data-parallax="'.esc_attr($simple_slider_parallax).'" data-n-parallax-bg="true" data-parallax-speed="fast"';

	}

	// Dynamic style classes.
	if( function_exists('nectar_el_dynamic_classnames') ) {
		$class_names[] = nectar_el_dynamic_classnames('simple_slider', $atts);
	}

	echo '<div class="nectar-carousel"><div class="'.esc_attr(implode(" ", $class_names)).'" '.implode(" ", $attrs).'>';
	echo '<div class="flickity-viewport"><div class="flickity-slider">' . do_shortcode($content) . '</div></div>';
	echo '</div></div>';
}

?>
