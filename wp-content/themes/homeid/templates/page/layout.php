<?php
/**
 * The template for displaying page content layout
 *
 * @since 1.0
 * @version 1.0
 */

while ( have_posts() ) : the_post();

	homeid_get_template( 'page/content');

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endwhile; // End of the loop.