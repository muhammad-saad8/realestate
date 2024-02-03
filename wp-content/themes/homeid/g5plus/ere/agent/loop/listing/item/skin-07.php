<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $image_size
 * @var $image_ratio
 * @var $post_class
 * @var $post_inner_class
 * @var $post_inner_attributes
 * @var $image_mode
 * @var $template
 * @var $placeholder
 */
$thumbnail_data = g5ere_get_agent_thumbnail_data( array(
	'image_size'  => $image_size,
	'placeholder' => $placeholder
));
if ( $thumbnail_data['url'] !== '' ) {
	$post_class .= ' g5ere__has-image-featured';
}
$post_class .= ' g5ere__loop-skin-classic';
$post_inner_class .= ' text-center';
?>
<article <?php post_class($post_class) ?>>
	<div <?php echo join(' ', $post_inner_attributes) ?> class="<?php echo esc_attr($post_inner_class); ?>">
		<?php if ($thumbnail_data['url'] !== ''): ?>
			<div class="g5core__post-featured g5ere__agent-featured g5ere__post-featured-circle">
				<?php g5ere_render_agent_thumbnail_markup(array(
					'image_size' => $image_size,
					'image_ratio' => $image_ratio,
					'image_mode' => $image_mode,
					'placeholder' => $placeholder
				)); ?>
			</div>
		<?php endif; ?>
		<div class="g5ere__agent-content g5ere__loop-content">
			<?php
			/**
			 * Hook: g5ere_loop_agent_content_skin_07.
			 *
			 * @see g5ere_template_loop_agent_title - 5
			 * @see g5ere_template_loop_agent_position - 10
			 */
			do_action('g5ere_loop_agent_content_skin_07');
			?>
		</div>
	</div>
</article>
