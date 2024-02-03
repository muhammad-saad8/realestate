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
$post_inner_class .= ' g5ere__li-bordered g5ere__li-hover-box-shadow bg-white';
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
			<div class="g5ere__lac-top text-center">
				<?php
				/**
				 * Hook: g5ere_loop_agent_content_top_skin_05.
				 *
				 * @see g5ere_template_loop_agent_title
				 * @see g5ere_template_loop_agent_position
				 * @see g5ere_template_loop_agent_rating
				 */
				do_action('g5ere_loop_agent_content_top_skin_05');
				?>
			</div>
			<?php
			/**
			 * Hook: g5ere_loop_agent_content_skin_05.
			 *
			 * @see g5ere_template_loop_agent_office_number_has_title
			 * @see g5ere_template_loop_agent_phone_has_title
			 * @see g5ere_template_loop_agent_fax_has_title
			 * @see g5ere_template_loop_agent_email_has_title
			 * @see g5ere_template_loop_agent_social_has_title
			 */
			do_action('g5ere_loop_agent_content_skin_05');
			?>
		</div>
	</div>
</article>
