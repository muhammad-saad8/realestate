<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $comment
 * @var $args
 * @var $depth
 * @var $rating
 */
?>
<li <?php comment_class() ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID() ?>" class="g5ere__review-comment-item media">
		<div class="g5ere__review-avatar mr-3">
			<?php echo get_avatar( $comment, $args['avatar_size']); ?>
		</div>
		<div class="g5ere__review-comment-text media-body">
			<div class="g5ere__review-comment-head d-flex flex-wrap align-items-center justify-content-between">
				<h5 class="g5ere__review-comment-title mb-0"><a href="<?php echo esc_url(get_author_posts_url($comment->user_id))?>"><?php comment_author($comment->comment_ID)?></a></h5>
				<?php if ($rating > 0) {
					g5ere_template_star_rating_icon($rating);
				}  ?>
			</div>
			<div class="g5ere__review-comment-body">
				<?php if (!$comment->comment_approved): ?>
					<p><em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'g5-ere') ?></em></p>
				<?php else: ?>
					<?php comment_text() ?>
				<?php endif; ?>
			</div>
			<ul class="g5ere__review-comment-meta list-inline">
				<li class="g5ere__review-meta-date list-inline-item">
					<?php printf( _x( '%s ago', '%s = human-readable time difference', 'g5-ere' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
				</li>
				<?php if (current_user_can( 'edit_comment', $comment->comment_ID ) ): ?>
					<li class="g5ere__review-meta-edit list-inline-item">
						<?php edit_comment_link( esc_html__('Edit', 'g5-ere') ) ?>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
