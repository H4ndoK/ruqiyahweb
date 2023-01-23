<?php

if ( !defined( 'ABSPATH') ) {
	exit('Direct script access denied.');
}

if( ! function_exists('nectar_load_recent_posts_css') ) {
	function nectar_load_recent_posts_css() {
	    wp_enqueue_style( 'nectar-widget-posts' );
	}
}

if( ! function_exists('Recent_Posts_Extra_init') ) {
	function Recent_Posts_Extra_init() {
		register_widget('Recent_Posts_Extra_Widget');
	}
}

add_action('widgets_init', 'Recent_Posts_Extra_init');

if( ! class_exists('Recent_Posts_Extra_Widget') ) {
	
	class Recent_Posts_Extra_Widget extends WP_Widget {

		function __construct() {
			$widget_ops = array('classname' => 'recent_posts_extra_widget', 'description' => esc_html__( "The most recent posts on your site, including post thumbnails & dates.",'salient-widgets'));
			parent::__construct('recent-posts-extra', esc_html__('Nectar Recent Posts Extra','salient-widgets'), $widget_ops);
			$this->alt_option_name = 'recent_posts_extra_widget';
			
			if(is_active_widget(false, false, $this->id_base)) {
				 add_action('wp_enqueue_scripts', 'nectar_load_recent_posts_css');
			}

			add_action( 'save_post', array(&$this, 'flush_widget_cache') );
			add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
			add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
		}

		function widget($args, $instance) {
			
			$cache = wp_cache_get('recent_posts_extra_widget', 'widget');

			if ( !is_array($cache) )
				$cache = array();

			if ( isset($cache[$args['widget_id']]) ) {
				echo wp_kses_post( $cache[$args['widget_id']] ); // WPCS: XSS ok.
				return;
			}

			ob_start();
			extract($args);

			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
			$post_style = isset($instance['style']) ? $instance['style'] : 'Featured Image Left';
			if(!empty($post_style)) $post_style = strtolower(preg_replace('/[\s-]+/', '-',$post_style));

			$category = isset($instance['category']) ? $instance['category'] : ''; 

			if ( !$number = (int) $instance['number'] ) {
				$number = 10;
			}
			else if ( $number < 1 ) {
				$number = 1;
			}
			else if ( $number > 15 ) {
				$number = 15;
			}

			if(!empty($category) && $category != 'All') {
				
				$recent_post_widget_query = array( 
					'post_type' => 'post', 
					'category_name' => $category, 
					'showposts' => $number, 
					'nopaging' => 0, 
					'post_status' => 'publish'
				);

				$recent_post_widget_query = apply_filters('salient_recent_posts_widget_query', $recent_post_widget_query);

				$r = new WP_Query($recent_post_widget_query);
					
			} else {

				$recent_post_widget_query = array(
					'showposts' => $number, 
					'nopaging' => 0, 
					'post_status' => 'publish'
				);

				$recent_post_widget_query = apply_filters('salient_recent_posts_widget_query', $recent_post_widget_query);

				$r = new WP_Query($recent_post_widget_query);
			}

			
			if ($r->have_posts()) :
	?>
			<?php echo wp_kses_post( $before_widget ); // WPCS: XSS ok. ?>
			<?php if ( $title ) echo wp_kses_post( $before_title ) . wp_kses_post( $title ) . wp_kses_post( $after_title ); // WPCS: XSS ok. ?>
				
			<ul class="nectar_blog_posts_recent_extra nectar_widget" data-style="<?php echo esc_attr( $post_style ); ?>">
				
			<?php  while ($r->have_posts()) : $r->the_post(); 
			
					global $post;
					$post_featured_img_class = (has_post_thumbnail() && $post_style !== 'minimal-counter') ? 'class="has-img"' : '';
					$post_featured_img       = null;
					
					if(has_post_thumbnail()) {
						
						if($post_style === 'hover-featured-image') {
							$post_featured_img = '<div class="popular-featured-img" style="background-image: url(' . get_the_post_thumbnail_url($post->ID, 'portfolio-thumb', array('title' => '')) . ');"></div>';
				
						} else if($post_style === 'featured-image-left') {
							$post_featured_img = '<span class="popular-featured-img">'. get_the_post_thumbnail($post->ID, 'portfolio-widget', array('title' => '')) . '</span>';

						}
					}
					
					$post_border_circle = ($post_style === 'minimal-counter') ? '<div class="arrow-circle"> <svg aria-hidden="true" width="38" height="38"> <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="19" cy="19" r="18"></circle> </svg>  </div>' : null;
					
					$post_link = get_permalink();
					$target_markup = '';
					
					if( get_post_format() === 'link' ) {
						
						$post_link_format_url = get_post_meta( $post->ID, '_nectar_link', true );
						$post_link_text = get_the_content();
						
						if ( empty($post_link_text) && !empty($post_link_format_url) ) {
							$post_link = esc_url($post_link_format_url);
							$target_markup = ' target="_blank"';
						}
						
					}
					echo '<li '.$post_featured_img_class.'><a href="'. esc_url($post_link) .'"'.$target_markup.'> '.$post_featured_img. $post_border_circle. '<span class="meta-wrap"><span class="post-title">' . get_the_title() . '</span> <span class="post-date">' . get_the_date() . '</span></span></a></li>';  // WPCS: XSS ok.

			 endwhile; ?>
			</ul>
			<?php echo wp_kses_post( $after_widget );  // WPCS: XSS ok. ?>
	<?php
				wp_reset_query();  // Restore global post data stomped by the_post().
			endif;

			$cache[$args['widget_id']] = ob_get_flush();
			wp_cache_add('recent_posts_extra_widget', $cache, 'widget');
		}

		function update( $new_instance, $old_instance ) {
			$instance             = $old_instance;
			$instance['title']    = strip_tags($new_instance['title']);
			$instance['style']    = strip_tags($new_instance['style']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['number']   = (int) $new_instance['number'];
			$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['recent_posts_extra_widget']) ) {
				delete_option('recent_posts_extra_widget');
			}

			return $instance;
		}

		function flush_widget_cache() {
			wp_cache_delete('recent_posts_extra_widget', 'widget');
		}

		function form( $instance ) {
			
			$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
			
			$instance['style']    = ( isset($instance['style']) ) ? esc_attr($instance['style']) : 'Featured Image Left';
			$instance['category'] = ( isset($instance['category']) ) ? esc_attr($instance['category']) : 'All';

			if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) {
				$number = 5;
			}
			else if ( $number < 1 ) {
				$number = 1;
			}
			else if ( $number > 15 ) {
				$number = 15;
			}

	?>	
			<p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'salient-widgets'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_attr_e( 'Style:', 'salient-widgets' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" class="widefat" style="width:100%;">	
					<option <?php if ( esc_attr__( 'Hover Featured Image', 'salient-widgets' ) === $instance['style'] ) { echo 'selected="selected"'; } ?>><?php esc_attr_e( 'Hover Featured Image', 'salient-widgets' ); ?></option>
					<option <?php if ( esc_attr__( 'Minimal Counter', 'salient-widgets' ) === $instance['style'] ) { echo 'selected="selected"'; } ?>><?php esc_attr_e( 'Minimal Counter', 'salient-widgets' ); ?></option>
					<option <?php if ( esc_attr__( 'Featured Image Left', 'salient-widgets' ) === $instance['style'] ) { echo 'selected="selected"'; } ?>><?php esc_attr_e( 'Featured Image Left', 'salient-widgets' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_attr_e( 'Category:', 'salient-widgets' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" class="widefat" style="width:100%;">	

					<option <?php if ( esc_attr__( 'All', 'salient-widgets' ) === $instance['category'] ) { echo 'selected="selected"'; } ?>><?php esc_attr_e( 'All', 'salient-widgets' ); ?></option>

					<?php 

						$blog_types = get_categories();

						foreach ($blog_types as $type) {
							
							if(isset($type->name) && isset($type->slug)) {
								$blog_options[htmlspecialchars($type->name)] = htmlspecialchars($type->slug);
								?>
								<option <?php if ( htmlspecialchars($type->slug) === $instance['category'] ) { echo 'selected="selected"'; } ?> value="<?php echo htmlspecialchars($type->slug); ?>"><?php echo htmlspecialchars($type->name); ?></option>
								<?php
							}
						}
						

					?>
					
				</select>
			</p>

			<p><label for="<?php echo esc_attr( $this->get_field_id('number') ); ?>"><?php _e('Number of posts to show:', 'salient-widgets'); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="2" /><br />
			<small><?php echo esc_html__('(at most 15)', 'salient-widgets'); ?></small></p>
	<?php
		}
	}
}

?>