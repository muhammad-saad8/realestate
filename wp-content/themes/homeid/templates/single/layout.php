<?php
/**
 * The template for displaying single content layout
 *
 * @since 1.0
 * @version 1.0
 */

while ( have_posts() ) : the_post();

	homeid_get_template( 'post/content', array('post_format' => get_post_format()));


	homeid_get_template('post/entry-author');



	if (get_post_type() !== 'attachment') {

		homeid_get_template('post/navigation');


	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endwhile; // End of the loop.