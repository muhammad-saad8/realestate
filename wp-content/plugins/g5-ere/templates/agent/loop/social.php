<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $agent_facebook_url
 * @var $agent_twitter_url
 * @var $agent_skype
 * @var $agent_linkedin_url
 * @var $agent_pinterest_url
 * @var $agent_instagram_url
 * @var $agent_youtube_url
 * @var $agent_vimeo_url
 * @var $title
 */
$title = isset( $title ) ? $title : false;

$wrapper_classes = array(
	'g5ere__loop-agent-meta',
	'g5ere__loop-agent-social'
);
if ($title) {
	$wrapper_classes[] = 'g5ere__lam-has-title';
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<?php if ($title) : ?>
		<span class="g5ere__lam-label mr-1"><?php esc_html_e( 'Social', 'g5-ere' ) ?></span>
	<?php endif; ?>
	<ul class="g5ere__agent-social-list list-inline">
		<?php if ( ! empty( $agent_facebook_url ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Facebook','g5-ere') ?>" href="<?php echo esc_url( $agent_facebook_url ); ?>">
					<i class="fab fa-facebook-f"></i>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( ! empty( $agent_twitter_url ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Twitter','g5-ere') ?>" href="<?php echo esc_url( $agent_twitter_url ); ?>">
					<i class="fab fa-twitter"></i>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( ! empty( $agent_skype ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Skype','g5-ere') ?>" href="skype:<?php echo esc_url( $agent_skype ); ?>?call">
					<i class="fab fa-skype"></i>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( ! empty( $agent_linkedin_url ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Linkedin','g5-ere') ?>" href="<?php echo esc_url( $agent_linkedin_url ); ?>">
					<i class="fab fa-linkedin-in"></i>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( ! empty( $agent_pinterest_url ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Pinterest','g5-ere')?>" href="<?php echo esc_url( $agent_pinterest_url ); ?>">
					<i class="fab fa-pinterest-p"></i>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( ! empty( $agent_instagram_url ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Instagram','g5-ere') ?>" href="<?php echo esc_url( $agent_instagram_url ); ?>">
					<i class="fab fa-instagram"></i>
				</a></li>
		<?php endif; ?>
		<?php if ( ! empty( $agent_youtube_url ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Youtube','g5-ere') ?>" href="<?php echo esc_url( $agent_youtube_url ); ?>">
					<i class="fab fa-youtube"></i>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( ! empty( $agent_vimeo_url ) ): ?>
			<li class="list-inline-item">
				<a title="<?php echo esc_attr__('Vimeo','g5-ere') ?>" href="<?php echo esc_url( $agent_vimeo_url ); ?>">
					<i class="fab fa-vimeo-v"></i>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>