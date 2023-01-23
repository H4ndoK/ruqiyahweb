<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create metabox markup
 *
 * @since 1.0
 */
if( !function_exists('nectar_create_meta_box') ) {
		
	function nectar_create_meta_box( $post, $meta_box ) {

			if( !is_array($meta_box) ) {
				return false;
			}
			
			if( isset($meta_box['description']) && $meta_box['description'] !== '' ){
				echo '<p>'. $meta_box['description'] .'</p>';
			}
			
			wp_nonce_field( basename(__FILE__), 'nectar_meta_box_nonce' );
			
			echo '<table class="form-table nectar-metabox-table">';
			
			$count = 0;
			
			foreach( $meta_box['fields'] as $field ){
				
				if( !is_array($field) || !isset($field['id']) ) {
					continue;
				}
				
				$meta   = get_post_meta( $post->ID, $field['id'], true );
				$inline = null;
				
				if( isset($field['type']) && 
           $field['type'] !== 'editor' && 
           $field['type'] !== 'slim_editor' &&
           !is_array($meta) ) {
					$meta = wp_kses_post( $meta );
				}
				
				if( isset($field['extra']) ) { 
					$inline = true; 
				}
				
				if( $inline === null ) {
					echo '<tr class="field_'.$field['id'].'"><th><label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong>
					<span>'. $field['desc'] .'</span></label></th>';
				}
				
				
				switch( $field['type'] ){	
					
					case 'text': 
						echo '<td><input type="text" name="nectar_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. esc_attr(($meta ? $meta : $field['std'])) .'" size="30" /></td>';
					break;	
					
					case 'textarea':
						echo '<td><textarea name="nectar_meta['. $field['id'] .']" id="'. $field['id'] .'" rows="8" cols="5">'. ($meta ? $meta : $field['std']) .'</textarea></td>';
					break;
					
					case 'media_textarea':
						echo '<td><div style="display:none;" class="attr_placeholder" data-poster="" data-media-mp4="" data-media-ogv=""></div><textarea name="nectar_meta['. $field['id'] .']" id="'. $field['id'] .'" rows="8" cols="5">'. ($meta ? $meta : $field['std']) .'</textarea></td>';
					break;
					
					case 'editor' :
						$settings = array(
							'textarea_name' => 'nectar_meta['. $field['id'] .']',
							'editor_class'  => '',
							'wpautop'       => true
						);
						echo'<td>';
							wp_editor($meta, $field['id'], $settings );
						echo '</td>';
					
					break;
					
					case 'slim_editor' :
						$settings = array(
							'textarea_name' => 'nectar_meta['. $field['id'] .']',
							'editor_class'  => 'slim',
							'wpautop'       => true
						);
						echo'<td>';
							wp_editor($meta, $field['id'], $settings );
						echo '</td>';
					break;
					
					case 'file':
						if( $meta == '' ) {
							$add_class = ''; 
							$remove_class = ' hidden'; 
						} else {
							$add_class = ' hidden'; 
							$remove_class = ''; 
						}
					
						$upload_meta = ($meta) ? $meta : $field['std'];
					 
						echo '<td><input type="hidden" name="nectar_meta[' . $field['id'] . ']" id="' . $field['id'] . '" value="' . $upload_meta . '" />';
						echo '<img class="nectar-media-preview" id="' . $field['id'] . '" src="' . $upload_meta . '" />';
						echo '<a href="#" data-update="Select Image" data-title="Choose Your Image" class="nectar-add-btn button-secondary' . $add_class . '" rel-id="' . $field['id'] . '">' . esc_html__('Upload', 'salient') . '</a>';
						echo '<a href="#" class="nectar-remove-btn button-secondary' . $remove_class . '" rel-id="' . $field['id'] . '">' . esc_html__('Remove Upload', 'salient') . '</a></td>';
					break;
					
					case 'color':
						wp_enqueue_style('wp-color-picker');
						wp_enqueue_script(
							'nectar-colorpicker-js',
	            SALIENT_PORTFOLIO_PLUGIN_PATH.'/includes/assets/js/colorpicker.js',
							array('wp-color-picker'),
							time(),
							true
						);
					
						echo '<td><input type="text" id="' . $field['id'] . '" name="nectar_meta[' . $field['id'] . ']" value="' . esc_attr(($meta ? $meta : $field['std'])) . '" class=" popup-colorpicker" style="width: 70px;" data-default-color="' . esc_attr(($meta ? $meta : $field['std'])) . '"/></td>';
					break;
					
					case 'media':
						if( $meta == '' ) {
								$add_class = ''; 
								$remove_class = ' hidden'; 
						} 
						else {
								$add_class = ' hidden'; 
								$remove_class = ''; 
						}
					
						$upload_meta = ($meta) ? $meta : $field['std'];
					 
						echo '<td><input type="text" class="display_text" name="nectar_meta[' . $field['id'] . ']" id="' . $field['id'] . '" value="' . esc_attr($upload_meta) . '" />';
						echo '<a href="#" data-update="Select File" data-title="Choose Your File" class="nectar-add-media-btn button-secondary' . $add_class . '" rel-id="' . $field['id'] . '">' . esc_html__('Add Media File', 'salient') . '</a>';
						echo '<a href="#" class="nectar-remove-media-btn button-secondary' . $remove_class . '" rel-id="' . $field['id'] . '">' . esc_html__('Remove Media File', 'salient') . '</a></td>';
					break;
					
					case 'images':
						echo '<td><input type="button" class="button" name="' . $field['id'] . '" id="nectar_images_upload" value="' . $field['std'] .'" /></td>';
					break;
					
					case 'select':
						echo'<td><select name="nectar_meta['. $field['id'] .']" id="'. $field['id'] .'">';
						foreach( $field['options'] as $key => $option ){
							echo '<option value="' . $key . '"';
							if( $meta ){ 
								if( $meta == $key ) {
									echo ' selected="selected"'; 
								}
							} else {
								if( $field['std'] == $key ) {
									echo ' selected="selected"'; 
								}
							}
							echo'>'. $option .'</option>';
						}
						echo'</select></td>';
					break;
					case 'choice_below' :
					
						wp_register_style(
							'nectar-meta-jquery-ui-custom-css',
	             SALIENT_PORTFOLIO_PLUGIN_PATH.'/includes/assets/css/jquery-ui-1.10.0.custom.css',
							'',
							time(),
							'all'
						);
						wp_enqueue_style('nectar-meta-jquery-ui-custom-css');
						wp_enqueue_script(
							'nectar-button-set-js', 
		          SALIENT_PORTFOLIO_PLUGIN_PATH.'/includes/assets/js/buttonset.js', 
							array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'),
							time(),
							true
						);
						echo '<td colspan="8">';
						echo '<fieldset class="buttonset '.$field['id'].'" >';
						
						foreach( $field['options'] as $key => $option ) {
							
							echo '<input type="radio" id="nectar_meta_'. $key .'" name="nectar_meta['. $field["id"] .']" value="'. $key .'" ';
							if( $meta ){ 
								if( $meta === $key ) {
									echo ' checked="checked"'; 
								}
							} else {
								if( $field['std'] === $key ) {
									echo ' checked="checked"';
								}
							}
							echo ' /> ';
							echo '<label for="nectar_meta_'. $key .'"> '.$option.'</label>';
							
						}
						
						echo '</fieldset>';
						echo '</td>';
					break;
					
					case 'multi-select':
						echo'<td><select multiple="multiple" name="nectar_meta['. $field['id'] .'][]" id="'. $field['id'] .'">';
						
						foreach( $field['options'] as $key => $option ) {
							echo '<option value="' . esc_attr($key) . '"';
							if( $meta && is_string($meta) ){
								
								$str_to_arr = explode(', ', $meta);
								echo (is_array($str_to_arr) && in_array($key, $str_to_arr)) ? ' selected="selected"' : '';
								
								if( $meta === $key ) { 
									echo ' selected="selected"'; 
								}
							} else {
								if( $field['std'] === $key ) {
									echo ' selected="selected"'; 
								}
							}
							echo'>'. esc_html($option) .'</option>';
						}
						
						echo'</select></td>';
					break;
					
					case 'slide_alignment' :
						wp_register_style(
							'nectar-meta-jquery-ui-custom-css',
	             SALIENT_PORTFOLIO_PLUGIN_PATH.'/includes/assets/css/jquery-ui-1.10.0.custom.css',
							'',
							time(),
							'all'
						);
						wp_enqueue_style('nectar-meta-jquery-ui-custom-css');
						wp_enqueue_script(
							'nectar-button-set-js', 
	            SALIENT_PORTFOLIO_PLUGIN_PATH.'/includes/assets/js/buttonset.js', 
							array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'),
							time(),
							true
						);
						echo '<td>';
						echo '<fieldset class="buttonset">';
						
						foreach( $field['options'] as $key => $option ) {
							
							echo '<input type="radio" id="nectar_meta_'. $key .'" name="nectar_meta['. $field["id"] .']" value="'. $key .'" ';
							if( $meta ){ 
								if( $meta === $key ) {
									echo ' checked="checked"'; 
								}
							} else {
								if( $field['std'] === $key ) {
									echo ' checked="checked"';
								}
							}
							echo ' /> ';
							echo '<label for="nectar_meta_'. $key .'"> '.$option.'</label>';
							
						}
						
						echo '</fieldset>';
						echo '</td>';
					break;
					
					case 'radio':
					
						echo '<td>';
						
						foreach( $field['options'] as $key => $option ) {
							echo '<label class="radio-label"><input type="radio" name="nectar_meta['. $field['id'] .']" value="'. $key .'" class="radio"';
							if( $meta ){ 
								if( $meta === $key ) {
									echo ' checked="checked"'; 
								}
							} else {
								if( $field['std'] === $key ) {
									echo ' checked="checked"';
								}
							}
							echo ' /> '. $option .'</label> ';
						}
						
						echo '</td>';
					break;
					
					case 'slider_button_text':
						if( $field['extra'] === 'first' ) {
							$count++;
							echo '<tr><td><label><strong>Button #'.$count.'</strong> <span>Configure your button here.</span> </label></td>';
						}
						echo '<td class="inline">';
						if( $inline != null ) {
							echo '<label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong>
							<span>'. $field['desc'] .'</span></label>';
						}
						echo '<input type="text" name="nectar_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30"  />';
						echo '</td>';
					break;
					
					case 'slider_button_textarea':
						if( $field['extra'] === 'first' ){
							$count++;
							echo '<tr><td><label><strong>Button #'.$count.'</strong> <span>Configure your button here.</span> </label></td>';
						}
						echo '<td class="inline">';
						if( $inline != null ) {
							echo '<label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong>
							<span>'. $field['desc'] .'</span></label>';
						}
						echo '<textarea name="nectar_meta['. $field['id'] .']" id="'. $field['id'] .'">'.($meta ? $meta : $field['std']) .'</textarea>';
						echo '</td>';
					break;
					
					case 'slider_button_select':
						echo '<td class="inline">';
						if( $inline != null ) {
							echo '<label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong>
							<span>'. $field['desc'] .'</span></label>';
						}
						echo'<select name="nectar_meta['. $field['id'] .']" id="'. $field['id'] .'">';
						foreach( $field['options'] as $key => $option ){
							echo '<option value="' . $key . '"';
							if( $meta ){ 
								if( $meta === $key ) {
									echo ' selected="selected"'; 
								}
							} else {
								if( $field['std'] === $key ) {
									echo ' selected="selected"'; 
								}
							}
							echo'>'. $option .'</option>';
						}
						echo'</select></td>';
						if($field['extra'] === 'last'){
							echo '</tr>';
						}
					break;
					
					case 'checkbox':
						if( !empty($field['extra']) && $field['extra'] === 'first2' ){
							echo '<tr><th><label><strong>Scroll Effect</strong> <span>Choose your desired scroll effect here.</span> </label></th>';
						}
						
						echo '<td>';		 
						$val                = '';
						$activated_checkbox = '';
						$starting_disabled  = '';
						$starting_enabled   = '';
						
						if( $meta ) {
							if( $meta === 'on' ) {
								$val = ' checked="checked"';
								$activated_checkbox = 'activated';
								$starting_enabled = 'selected';
							}
							else {
								$starting_disabled = 'selected';
							}
						} else {
							if( $field['std'] === 'on' ) $val = ' checked="checked"';
						}
						
						echo '<div class="switch-options salient '.$activated_checkbox.'">';
						echo '<label class="cb-enable '.$starting_enabled.'"><span>' . esc_html__("On", 'salient') . '</span></label>';
						echo '<label class="cb-disable '.$starting_disabled.'"><span>' . esc_html__("Off", 'salient') . '</span></label>';
						echo '<input type="hidden" name="nectar_meta['. $field['id'] .']" value="off" />
						<input type="checkbox" id="'. $field['id'] .'" name="nectar_meta['. $field['id'] .']" value="on"'. $val .' /> ';
						echo '</div>';
						
						if(!empty($field['extra']) && $field['extra'] === 'first2' || 
							!empty($field['extra']) && $field['extra'] === 'last'){
							echo '<br/><br/><label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong><span>'. $field['desc'] .'</span></label>'; 
						}
						
						echo '</td>';
						
						if(!empty($field['extra']) && $field['extra'] === 'last'){
							echo '</tr>';
						}
						
					break;
					
					case 'caption_pos' :
						wp_register_style(
							'nectar-meta-jquery-ui-custom-css',
              SALIENT_PORTFOLIO_PLUGIN_PATH.'/includes/assets/css/jquery-ui-1.10.0.custom.css',
							'',
							time(),
							'all'
						);
						wp_enqueue_style('nectar-meta-jquery-ui-custom-css');
						wp_enqueue_script(
							'nectar-button-set-js', 
	            SALIENT_PORTFOLIO_PLUGIN_PATH.'/includes/assets/js/buttonset.js', 
							array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'),
							time(),
							true
						);
						
						if( $field['extra'] === 'first' ) {
							echo '<tr><td><label><strong>Slide Content Alignment</strong> <span>Configure the position for your slides content</span> </label></td>';
						}
						if( $field['extra'] === 'first2' ) {
							echo '<tr><th><label><strong>Header Content Alignment</strong> <span>Configure the position for your slides content</span> </label></th>';
						}
						echo '<td class="content-alignment"> <label><strong>'.$field['desc'].'</strong><span>Select Your Alignment</span></label>';
						echo '<fieldset class="buttonset">';
						
						foreach( $field['options'] as $key => $option ) {
							
							echo '<input type="radio" id="nectar_meta_'. $key .'" name="nectar_meta['. $field["id"] .']" value="'. $key .'" ';
							if( $meta ){ 
								if( $meta === $key ) {
									echo ' checked="checked"'; 
								}
							} else {
								if( $field['std'] === $key ) {
									echo ' checked="checked"';
								}
							}
							echo ' /> ';
							echo '<label for="nectar_meta_'. $key .'"> '.$option.'</label>';
							
						}
						
						echo '</fieldset>';
						echo '</td>';
						
						if( $field['extra'] === 'last' ){
							echo '</tr>';
						}
					
					break;
					
					case 'canvas_shape_group':
			
					
						echo '<td>
						<fieldset id="'. $field['class'].'" class="nectar-media-gallery" data-id="opt-gallery" data-type="gallery">
						<div class="screenshot">';
						
						if ( ! empty( $meta) ) {
							$ids = explode( ',', $meta);
							
							foreach ( $ids as $attachment_id ) {
								$img = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
								echo '<img class="nectar-media-preview" id="image_' . $field['id'] . '_' . $attachment_id . '" src="' . $img[0] . '" target="_blank" rel="external" />';
							}
						}
						
						echo '</div>';
						echo '<a href="#" onclick="return false;" id="edit-gal" class="gallery-attachments button button-primary">' . esc_html__( 'Add/Edit Images', 'salient' ) . '</a> ';
						echo '<a href="#" onclick="return false;" id="remove-gal" class="gallery-attachments button">' . esc_html__( 'Clear Images', 'salient' ) . '</a>';
						echo '<input type="hidden" class="gallery_values " value="' . esc_attr( $meta ) . '" name="nectar_meta['. $field["id"] .']" />
						</fieldset></td>';
						
					break;
				}
				
	
				if( $inline === null ) {
					echo '</tr>';
				}
			}
			
			echo '</table>';
	}
		
}

/**
 * Create metabox helper
 *
 * @since 1.0
 */
if( !function_exists('nectar_reg_meta_box') ) {
	function nectar_reg_meta_box($id, $title, $callback, $post_type, $context, $priority, $content) {
		add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $content);
	}
}


/**
 * Save metabox 
 *
 * @since 1.0
 */
if( ! function_exists('nectar_save_meta_box') ) {
	
	function nectar_save_meta_box( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		if ( !isset($_POST['nectar_meta']) || 
		!isset($_POST['nectar_meta_box_nonce']) || 
		!wp_verify_nonce( $_POST['nectar_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return;
		}
		
		if ( 'page' === $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} 
		else {
			if ( !current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		foreach( $_POST['nectar_meta'] as $key => $val ) {
			
			if( $key === '_nectar_portfolio_extra_content' ) {
				// Portfolio extra content.
				if( wp_is_post_revision($post_id) && isset( $_POST['wp-preview'] ) && 'dopreview' === $_POST['wp-preview'] ) {
					// Store preview separate.
					update_post_meta( $post_id, $key .'_preview', $val );
				} else {
					update_post_meta( $post_id, $key, $val );
				}
				
			} 
			else if( $key === '_nectar_portfolio_custom_grid_item_content' ) {
				// Custom content grid item.
				update_post_meta( $post_id, $key, $val );
			}
			else if( $key === 'nectar-metabox-portfolio-display' && is_array($val) ) {
			   // Handle multi dropdowns.	
				 $arr_to_str = implode( ", ", $val );
				 $arr_to_str = wp_kses_post( $arr_to_str );
				 update_post_meta( $post_id, $key, $arr_to_str );
			}
			else {
				$val = wp_kses_post( $val );
				update_post_meta( $post_id, $key, $val );
			}
			
		} 
		
	} //end nectar_save_meta_box.
}

add_action( 'save_post', 'nectar_save_meta_box' );

?>