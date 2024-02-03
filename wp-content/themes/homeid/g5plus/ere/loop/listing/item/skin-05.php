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
 * @var $post_attributes
 * @var $post_inner_attributes
 * @var $image_mode
 * @var $template
 * @var $placeholder
 */
$thumbnail_data = g5ere_get_property_thumbnail_data( array(
	'image_size'  => $image_size,
	'placeholder' => $placeholder
));
if ($thumbnail_data['url'] !== '') {
	$post_class .= ' g5ere__has-image-featured';
}
$post_inner_class .= ' g5ere__li-bordered g5ere__li-hover-box-shadow bg-white';
?>
<article <?php post_class( $post_class ) ?> <?php echo join(' ', $post_attributes)?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
		<?php if ( $thumbnail_data['url'] !== '' ): ?>
			<div class="g5core__post-featured g5ere__property-featured g5ere__pf-rounded">
				<?php g5ere_render_property_thumbnail_markup( array(
					'image_size'         => $image_size,
					'image_ratio' => $image_ratio,
					'image_mode' => $image_mode,
					'placeholder' => $placeholder
				) ); ?>
				<?php
				/**
				 * Hook: g5ere_after_loop_property_thumbnail.
				 *
				 * @hooked g5ere_template_loop_property_action - 5
				 * @hooked g5ere_template_loop_property_featured_label - 10
				 */
				do_action('g5ere_after_loop_property_thumbnail_skin_05');
				?>
			</div>
		<?php endif; ?>
		<div class="g5ere__property-content g5ere__loop-content">
			<div class="g5ere__lpc-top d-flex flex-wrap align-items-center justify-content-between">
				<?php
				/**
				 * Hook: g5ere_loop_property_content_top_skin_05.
				 *
				 * @hooked g5ere_template_loop_property_price - 5
				 * @hooked g5ere_template_loop_property_primary_status - 10
				 */
				do_action('g5ere_loop_property_content_top_skin_05');
				?>
			</div>
			<div class="g5ere__lpc-center">
				<?php
				/**
				 * Hook: g5ere_loop_property_content_skin_05.
				 *
				 * @hooked g5ere_template_loop_property_title - 5
				 * @hooked g5ere_template_loop_property_address - 10
				 */
				do_action('g5ere_loop_property_content_skin_05')
				?>
			</div>
			<div class="g5ere__lpc-bottom">
				<?php
				/**
				 * Hook: g5ere_loop_property_content_bottom_skin_05.
				 *
				 * @hooked g5ere_template_loop_property_meta - 5
				 */
				do_action('g5ere_loop_property_content_bottom_skin_05');
				?>
			</div>
		</div>
	</div>
</article>
