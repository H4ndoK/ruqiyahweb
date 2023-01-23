<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( get_option( 'salient_core_dismiss_plugin_notice' ) !== 'true' ) {
    add_action( 'admin_notices', 'salient_core_add_dismissible_notice' );
}

function salient_core_add_dismissible_notice() { ?>
      <div class='notice nectar-dismiss-notice-salient-core nectar-bold-notice is-dismissible'>
          <h3><?php echo esc_html__('Salient Core Plugin Notice','salient-core'); ?> </h3>
          <p><?php echo esc_html__('The "Salient Core" plugin is active, but the Salient version of the WPBakery page builder is not. Please deactivate the version of the WPBakery page builder plugin you currently have active and use the Salient specific one instead if you wish to make use of the Salient core element set.','salient-core'); ?></p>
      </div>
<?php }


add_action( 'admin_enqueue_scripts', 'salient_core_admin_notice_script' );
function salient_core_admin_notice_script() {
	 
    wp_register_style( 'salient-core-admin-notice-update', SALIENT_CORE_PLUGIN_PATH . '/includes/salient-notice/css/notice.css','','1.0', false );
	  wp_register_script( 'salient-core-admin-notice-update', SALIENT_CORE_PLUGIN_PATH . '/includes/salient-notice/js/admin_notices.js','','1.0', false );
	  
	  wp_localize_script( 'salient-core-admin-notice-update', 'notice_params', array(
	      'ajaxurl' => esc_url(get_admin_url()) . 'admin-ajax.php', 
	  ));
	  
	  wp_enqueue_script(  'salient-core-admin-notice-update' );
    wp_enqueue_style(  'salient-core-admin-notice-update' );
		
}

add_action( 'wp_ajax_salient_core_dismiss_plugin_notice', 'salient_core_dismiss_plugin_notice' );

function salient_core_dismiss_plugin_notice() {
    update_option( 'salient_core_dismiss_plugin_notice', 'true' );
		wp_die();
}