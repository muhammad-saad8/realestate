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
 * @var $placeholder
 */
$thumbnail_data = g5ere_get_property_thumbnail_data( array(
	'image_size'  => $image_size,
	'placeholder' => $placeholder
));
if ($thumbnail_data['url'] !== '') {
	$post_class .= ' g5ere__has-image-featured';
}

$post_class .= ' g5ere__loop-skin-classic';
?>
<article <?php post_class( $post_class ) ?> <?php echo join(' ', $post_attributes)?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
		<?php if ( $thumbnail_data['url'] !== '' ): ?>
			<div class="g5core__post-featured g5ere__property-featured">
				<?php g5ere_render_property_thumbnail_markup( array(
					'image_size'         => $image_size,
					'image_ratio' => $image_ratio,
					'image_mode' => $image_mode,
					'placeholder' => $placeholder
				) ); ?>
				<?php
				/**
				 * Hook: g5ere_after_loop_property_thumbnail_skin_01.
				 *
				 * @hooked g5ere_template_loop_property_action - 5
				 * @hooked g5ere_template_loop_property_badge - 10
				 */
				do_action('g5ere_after_loop_property_thumbnail_skin_01');
				?>
			</div>
		<?php endif; ?>
		<div class="g5ere__property-content g5ere__loop-content">
			<?php
			/**
			 * Hook: g5ere_loop_property_content_skin_01.
			 *
			 * @hooked g5ere_template_loop_property_title - 5
			 * @hooked g5ere_template_loop_property_address - 10
			 * @hooked g5ere_template_loop_property_price - 15
			 * @hooked g5ere_template_loop_property_meta - 20
			 */
			do_action('g5ere_loop_property_content_skin_01');
			?>
		</div>
	</div>
</article>
