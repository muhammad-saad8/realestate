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
 * @var $post_attributes
 * @var $template
 * @var $image_mode
 * @var $placeholder
 */
$thumbnail_data = g5ere_get_agent_thumbnail_data( array(
	'image_size'  => $image_size,
	'placeholder' => $placeholder
) );
if ( $thumbnail_data['url'] !== '' ) {
	$post_class .= ' g5ere__has-image-featured';
}
$post_class .= ' g5ere__loop-skin-medium-image';
?>
<article <?php post_class( $post_class ) ?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
		<?php if ( $thumbnail_data['url'] !== '' ): ?>
			<div class="g5core__post-featured g5ere__agent-featured">
				<?php g5ere_render_agent_thumbnail_markup( array(
					'image_size'  => $image_size,
					'image_ratio' => $image_ratio,
					'image_mode'  => $image_mode,
					'placeholder' => $placeholder
				) ); ?>
			</div>
		<?php endif; ?>
		<div class="g5ere__agent-content g5ere__loop-content">
			<?php
			/**
			 * Hook: g5ere_loop_agent_list_content_skin_list_01.
			 *
			 * @hooked g5ere_template_loop_agent_title - 5
			 * @hooked g5ere_template_loop_agent_agency_has_title - 10
			 * @hooked g5ere_template_loop_agent_phone_has_icon - 15
			 * @hooked g5ere_template_loop_agent_email_has_icon - 20
			 * @hooked g5ere_template_loop_agent_address_has_icon - 25
			 * @hooked g5ere_template_loop_agent_social - 30
			 */
			do_action( 'g5ere_loop_agent_list_content_skin_list_01' );
			?>
		</div>
	</div>
</article>
