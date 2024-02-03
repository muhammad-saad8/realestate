<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $comment
 */
?>
<li class="comment byuser" id="li-comment-<?php echo esc_attr( $comment->comment_ID ) ?>">
    <div id="comment-<?php echo esc_attr( $comment->comment_ID ) ?>" class="g5ere__review-comment-item media">
        <div class="g5ere__review-avatar mr-3">
			<?php echo get_avatar( $comment, 80 ); ?>
        </div>
        <div class="g5ere__review-comment-text media-body">
            <div class="g5ere__review-comment-head d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex flex-wrap align-items-center">
                    <h5 class="g5ere__review-comment-title mb-0 mr-2">
                        <a
                                href="<?php echo esc_url( get_author_posts_url( $comment->user_id ) ) ?>"><?php comment_author( $comment->comment_ID ) ?></a>
                    </h5>
                    <div class="post-title">
						<?php esc_html_e( 'on', 'g5-ere' ) ?><a class="d-inline-block ml-1"
                                                                href="<?php echo esc_url( get_permalink( $comment->comment_post_ID ) ) ?>"><?php echo esc_html( $comment->post_title ) ?></a>
                    </div>
                </div>

				<?php if ( $comment->meta_value > 0 ) {
					g5ere_template_star_rating_icon( $comment->meta_value );
				} ?>
            </div>
            <div class="g5ere__review-comment-body">
				<?php if ( ! $comment->comment_approved ): ?>
                    <p>
                        <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'g5-ere' ) ?></em>
                    </p>
				<?php else: ?>
					<?php echo esc_html( $comment->comment_content ) ?>
				<?php endif; ?>
            </div>
            <ul class="g5ere__review-comment-meta list-inline">
                <li class="g5ere__review-meta-date list-inline-item">
					<?php printf( _x( '%s ago', '%s = human-readable time difference', 'g5-ere' ), human_time_diff( strtotime( wp_date( $comment->comment_date ) ), current_time( 'timestamp' ) ) ); ?>
                </li>
				<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ): ?>
                    <li class="g5ere__review-meta-edit list-inline-item">
                        <a class="comment-edit-link"
                           href="<?php echo esc_url( get_edit_comment_link( $comment->comment_ID ) ) ?>">
							<?php esc_html_e( 'Edit', 'g5-ere' ) ?></a>
                    </li>
				<?php endif; ?>
            </ul>
        </div>
    </div>
</li>
