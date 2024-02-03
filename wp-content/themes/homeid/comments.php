<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<div class="comments-list-wrap clearfix">
			<h2 class="comments-title">
				<span>
				<?php
				comments_number(
					esc_html__( 'No Comments', 'homeid' ),
					esc_html__( 'One Comment', 'homeid' ),
					esc_html__( "% Comments", 'homeid' ) );
				?>
					</span>
			</h2>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'avatar_size' => 70,
					'short_ping'  => true
				) );
				?>
			</ol>

			<?php the_comments_pagination( array(
				'prev_text' => esc_html__('Prev', 'homeid'),
				'next_text' => esc_html__('Next', 'homeid'),
			) );
			?>
		</div>
	<?php
	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'homeid' ); ?></p>
	<?php
	endif;

	comment_form( homeid_comment_form_args() );
	?>
</div><!-- #comments -->
