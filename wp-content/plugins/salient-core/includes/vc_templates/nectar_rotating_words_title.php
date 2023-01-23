<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-rotating-words-title' );

extract(shortcode_atts(array(
	'heading_tag' => 'h6',
  'beginning_text' => '',
  'dynamic_text' => '',
  'ending_text' => '',
	'text_color' => '',
  'font_size' => '',
	'dynamic_heading_tag' => 'default',
	'duration' => '1500',
	'mobile_display' => 'inline',
	'element_animation' => 'none',
	'element_animation_delay' => 'none'
), $atts));

// Verify Heading.
if( !in_array($heading_tag, array('h1','h2','h3','h4','h5','h6')) ) {
  $heading_tag = 'h6';
}

$nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
$nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;


// Parse dynamic text to sequence.
$dynamic_text_arr = explode(',', $dynamic_text);


$el_classnames = array('nectar-rotating-words-title');

if( function_exists('nectar_el_dynamic_classnames') ) {
	$dynamic_classnames = nectar_el_dynamic_classnames('nectar_rotating_words_title', $atts);
	if( !empty($dynamic_classnames) ) {
		$el_classnames[] = $dynamic_classnames;
	}
} 

if( $nectar_using_VC_front_end_editor && isset($el_classnames[1]) ) {
  $element_animation = 'none';
  $el_classnames[1] = str_replace('element_stagger_words','', $el_classnames[1]);
}

if( !empty($ending_text) ) {
	$el_classnames[] = 'has-ending-text';
}

$el_attrs_escaped = ' data-rotation="'.esc_attr($duration).'"';
if( 'none' !== $element_animation ) {
	$el_attrs_escaped .= ' data-delay="'.esc_attr($element_animation_delay).'"';
}

$el_attrs_escaped .= ' data-mobile="'.esc_attr($mobile_display).'"';

?>

<div class="<?php echo esc_attr(implode(' ', $el_classnames)); ?>" <?php echo $el_attrs_escaped; ?>>
  <?php

  echo '<'.esc_html($heading_tag).' class="heading">';

  if (!empty($beginning_text) ) {
		
		echo '<span class="beginning-text">';
		 
		 if( 'stagger_words' === $element_animation ) {
				$beginning_text_arr = explode(" ", $beginning_text);
				foreach ($beginning_text_arr as $k => $word) {
					echo '<span class="text-wrap"><span class="inner">'.esc_html($word).'</span></span> ';
				}
			} else {
				 echo wp_kses_post($beginning_text); 
			}
		
		echo '</span>'; 
	} 
	?>
  <span class="dynamic-words" data-inherit-heading-family="<?php echo esc_attr($dynamic_heading_tag); ?>">
    <?php
    foreach($dynamic_text_arr as $k => $word) {
      $active = $k == 0 ? 'text-wrap active' : 'text-wrap';
      echo '<span class="'.esc_attr($active).'"><span><span>'.esc_html($word).'</span></span></span>';
    }
    ?>
  </span>
  <?php if (!empty($ending_text) ) { 
		
		echo '<span class="ending-text">';
		
		if( 'stagger_words' === $element_animation ) {
			$ending_text_arr = explode(" ", $ending_text);
			foreach ($ending_text_arr as $k => $word) {
				echo '<span class="text-wrap"><span class="inner">'.esc_html($word).'</span></span> ';
			}
		} else {
			 echo wp_kses_post($ending_text); 
		}
		
		echo '</span>'; 
		
	}
  echo '</'.esc_html($heading_tag).'>'; ?>

</div>