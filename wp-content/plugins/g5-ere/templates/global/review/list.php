<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="comments-list-wrap g5ere__review-list-wrap">
	<h2 class="comments-title g5ere__review-title">
			<span>
				<?php comments_number(
					esc_html__( 'No Reviews', 'g5-ere' ),
					esc_html__( 'One Review', 'g5-ere' ),
					esc_html__( "% Reviews", 'g5-ere' ) );
				?>
			</span>
	</h2>
	<ol class="comment-list g5ere__review-list list-unstyled">
		<?php
		wp_list_comments( apply_filters('g5ere_review_list_args',array(
			'avatar_size' => 80,
			'max_depth' => 1,
			'callback' => 'g5ere_review_list_comment_callback'
		) ) );
		?>
	</ol>
	<?php the_comments_pagination( array(
		'prev_text' => esc_html__('Prev', 'g5-ere'),
		'next_text' => esc_html__('Next', 'g5-ere'),
	) );
	?>
</div>
