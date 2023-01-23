<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'nectar-element-clients' );

extract(shortcode_atts(array(
	"carousel" => "false", 
	"additional_padding" => "", 
	"hover_effect"=> 'opacity', 
	"fade_in_animation" => "false", 
	"columns" => '4', 
	"disable_autorotate" => 'false'), $atts));
	
$opening      = null;
$closing      = null;
$column_class = null;

switch ($columns) {
	case '2' :
	$column_class = 'two-cols';
	break;
	case '3' :
	$column_class = 'three-cols';
	break;
	case '4' :
	$column_class = 'four-cols';
	break;	
	case '5' :
	$column_class = 'five-cols';
	break;
	case '6' :
	$column_class = 'six-cols';
	break;
}

($fade_in_animation === "true") ? $animation = ' fade-in-animation' : $animation = null;

if( $carousel === "true" ) :
	
	$autorotate = (!empty($disable_autorotate) && $disable_autorotate == 'true') ? ' disable-autorotate' : null; 
	$carousel_classes = $column_class . $animation . $autorotate; ?>
	
	<div class="carousel-wrap">
		<div class="row carousel clients <?php echo esc_attr($carousel_classes); ?>" data-he="<?php echo esc_attr($hover_effect); ?>" data-additional_padding="<?php echo esc_attr($additional_padding); ?>" data-max="<?php echo esc_attr($columns); ?>">
			<?php echo do_shortcode($content); ?>
		</div>
	</div>
	
<?php else : ?>
	
	<?php $client_classes = $column_class . $animation; ?>
	
	<div class="clients no-carousel <?php echo esc_attr($client_classes); ?>" data-he="<?php echo esc_attr($hover_effect); ?>" data-additional_padding="<?php echo esc_attr($additional_padding); ?>">
		<?php echo do_shortcode($content); ?>
	</div>
	
<?php endif; ?>