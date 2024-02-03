<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $rating
 * @var $review
 * @var $action
 * @var $name
 */
?>
<div class="comment-respond g5ere__review-form-wrap">
	<h3 class="comment-reply-title g5ere__review-title"><span><?php echo esc_html__('Write A Review','g5-ere')?></span></h3>
	<form action="#" method="post" novalidate>
		<?php if (!is_user_logged_in()): ?>
			<p class="must-log-in"><?php echo wp_kses_post(__('You must be <a href="#" data-toggle="modal" data-target="#ere_signin_modal">logged in</a> to post a review','g5-ere')) ?></p>
		<?php else: ?>
			<div class="form-group">
				<div class="g5ere__rate-input">
					<?php for ($i = 5; $i > 0; $i--): ?>
						<input type="radio" id="star-<?php echo esc_attr($i)?>" name="rating" value="<?php echo esc_attr($i)?>" <?php checked($i,$rating) ?>>
						<label for="star-<?php echo esc_attr($i)?>" class="mb-0 mr-1 lh-1"><i class="fas fa-star"></i></label>
					<?php endfor; ?>
				</div>
			</div>
			<div class="form-group">
				<textarea required class="form-control" rows="5" name="message" placeholder="<?php esc_attr_e( 'Your Review', 'g5-ere' ); ?>"><?php echo esc_textarea( $review ) ?></textarea>
				<div class="invalid-feedback"><?php esc_html_e( 'Please enter your review!', 'g5-ere' ); ?></div>
			</div>
			<button type="submit" class="g5ere__submit-rating btn btn-accent"><?php echo esc_html__('Submit Review','g5-ere')?></button>
			<?php wp_nonce_field( 'ere_submit_review_ajax_nonce', 'ere_security_submit_review' ); ?>
			<input type="hidden" name="action" value="<?php echo esc_attr( $action ) ?>">
			<input type="hidden" name="<?php echo esc_attr( $name ) ?>" value="<?php the_ID(); ?>">
		<?php endif; ?>
	</form>
</div>
