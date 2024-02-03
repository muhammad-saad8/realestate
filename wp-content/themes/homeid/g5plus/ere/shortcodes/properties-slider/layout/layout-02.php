<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $image_size
 * @var $image_ratio
 */

$wrapper_classes = array(
	'g5ere__property-slider-item',
);

$slider_inner_classes = array(
	'g5ere__psi-inner',
	'align-items-center',
	'row'
);

$slider_inner_class = implode(' ', $slider_inner_classes);
$wrapper_class = implode(' ', $wrapper_classes);
?>

<article <?php post_class($wrapper_class) ?> >
	<div class="<?php echo esc_attr($slider_inner_class)?>">
		<div class="col-lg-6">
			<div class="g5core__post-featured g5ere__property-featured">
				<?php g5ere_render_property_thumbnail_markup( array(
					'image_size'         => $image_size,
					'image_ratio' => $image_ratio,
					'placeholder' => 'on'
				) ); ?>
				<?php do_action('g5ere_loop_property_slider_thumbnail_layout_02'); ?>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="g5ere__property-content-inner">
				<?php
				/**
				 * Hook: g5ere_loop_property_slider_content_layout_02.
				 *
				 * @hooked g5ere_template_loop_property_title - 5
				 * @hooked g5ere_template_loop_property_address - 10
				 * @hooked g5ere_template_loop_property_excerpt - 15
				 * @hooked g5ere_template_loop_property_meta - 20
				 */
				do_action('g5ere_loop_property_slider_content_layout_02');
				?>
				<div class="g5ere__property-bottom">
					<?php
					/**
					 * Hook: g5ere_loop_property_slider_bottom_layout_02.
					 *
					 * @hooked g5ere_template_loop_property_price - 5
					 * @hooked g5ere_template_loop_property_action -10
					 */
					do_action('g5ere_loop_property_slider_bottom_layout_02');
					?>
				</div>
			</div>
		</div>
	</div>
</article>