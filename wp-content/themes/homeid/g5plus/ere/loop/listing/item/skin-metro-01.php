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
?>
<article <?php post_class( $post_class ) ?> <?php echo join(' ', $post_attributes)?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr( $post_inner_class ); ?>">
		<div class="g5core__post-featured g5ere__property-featured g5ere__post-featured-bg-gradient">
			<?php g5ere_render_property_thumbnail_markup( array(
				'image_size'         => $image_size,
				'image_ratio' => $image_ratio,
				'image_mode' => $image_mode,
				'placeholder' => $placeholder
			) ); ?>


			<?php
			/**
			 * Hook: g5ere_after_loop_property_thumbnail_metro_01.
			 *
			 * @hooked g5ere_template_loop_property_badge - 10
			 */
			do_action('g5ere_after_loop_property_thumbnail_metro_01');
			?>

			<div class="g5ere__loop-property-actions g5ere__lpa-rounded g5ere__lpa-top-right">
				<?php
				/**
				 * Hook: g5ere_loop_property_action_skin_metro_01
				 *
				 * @hooked g5ere_template_loop_property_action_favorite - 5
				 * @hooked g5ere_template_loop_property_action_compare - 10
				 *
				 */
				do_action('g5ere_loop_property_action_skin_metro_01');
				?>
			</div>

			<div class="g5ere__property-content g5ere__loop-content">
				<div class="g5ere__lpc-top">
					<?php
					/**
					 * Hook: g5ere_loop_property_content_skin_metro_01
					 *
					 * @hooked g5ere_template_loop_property_title - 5
					 * @hooked g5ere_template_loop_property_address - 10
					 */
					do_action('g5ere_loop_property_content_skin_metro_01');
					?>
				</div>
				<div class="g5ere__lpc-bottom d-flex flex-wrap align-items-center justify-content-between">
					<?php
					/**
					 * Hook: g5ere_loop_property_content_bottom_skin_metro_01
					 *
					 * @hooked g5ere_template_loop_property_price - 5
					 * @hooked g5ere_template_loop_property_meta - 10
					 */
					do_action('g5ere_loop_property_content_bottom_skin_metro_01');
					?>
				</div>
			</div>

		</div>


	</div>
</article>
