<?php 

/**
 * Frontend color styles.
 *
 * @since 1.0
 */
function salient_social_colors() {
  
  if( defined( 'NECTAR_THEME_NAME' ) && function_exists('get_nectar_theme_options') ) {
    $nectar_options = get_nectar_theme_options();
    $accent_color_default = $nectar_options["accent-color"];
  } else {
    $accent_color_default = '#000000';
  }
  
  $salient_social_color = get_option( 'salient_social_accent_color', $accent_color_default );  
  
  // Background colors
  $css = '
  .sharing-default-minimal .nectar-love.loved,
  body .nectar-social[data-color-override="override"].fixed > a:before, 
  body .nectar-social[data-color-override="override"].fixed .nectar-social-inner a,
  .sharing-default-minimal .nectar-social[data-color-override="override"] .nectar-social-inner a:hover,
  .nectar-social.vertical[data-color-override="override"] .nectar-social-inner a:hover {
    background-color: '.$salient_social_color.';
  }';
  
  // Border colors
  $css .= '
  .nectar-social.hover .nectar-love.loved,
  .nectar-social.hover > .nectar-love-button a:hover,
  .nectar-social[data-color-override="override"].hover > div a:hover,
  #single-below-header .nectar-social[data-color-override="override"].hover > div a:hover,
  .nectar-social[data-color-override="override"].hover .share-btn:hover,
  .sharing-default-minimal .nectar-social[data-color-override="override"] .nectar-social-inner a {
    border-color: '.$salient_social_color.';
  }';
  
  // Text colors
  $css .= '
  #single-below-header .nectar-social.hover .nectar-love.loved i,
  #single-below-header .nectar-social.hover[data-color-override="override"] a:hover,
  #single-below-header .nectar-social.hover[data-color-override="override"] a:hover i,
  #single-below-header .nectar-social.hover .nectar-love-button a:hover i,
  .nectar-love:hover i,
  .hover .nectar-love:hover .total_loves,
  .nectar-love.loved i,
  .nectar-social.hover .nectar-love.loved .total_loves,
  .nectar-social.hover .share-btn:hover, 
  .nectar-social[data-color-override="override"].hover .nectar-social-inner a:hover,
  .nectar-social[data-color-override="override"].hover > div:hover span,
  .sharing-default-minimal .nectar-social[data-color-override="override"] .nectar-social-inner a:not(:hover) i,
  .sharing-default-minimal .nectar-social[data-color-override="override"] .nectar-social-inner a:not(:hover) {
    color: '.$salient_social_color.';
  }';
  
  return $css;
  
}

?>