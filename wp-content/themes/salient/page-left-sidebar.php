<?php
/*template name: Sidebar - Left*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
nectar_page_header( $post->ID );

?>

<div class="container-wrap">
	
	<div class="container main-content">
		
		<div class="row">
			
			<div class="post-area col span_9 col_last">
				
				<?php

				nectar_hook_before_content(); 

				if ( have_posts() ) :
					while ( have_posts() ) :
						
						the_post();
						the_content(); 

					 endwhile;
				endif;
				
				nectar_hook_after_content();
				
				?>
				
			</div><!--/span_9-->
			
			<div id="sidebar" class="col span_3 left-sidebar">
				<?php get_sidebar(); ?>
			</div><!--/span_9-->
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->

<?php get_footer(); ?>