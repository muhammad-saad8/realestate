<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $image_size
 */
$post_class = array(
	'g5ere__widget-property-item',
	'g5ere__widget-property-skin-02',
	'g5ere__property-skin-modern'
);
?>
<article <?php post_class( $post_class ) ?> >
	<div class="g5ere__property-item-inner">
		<div class="g5core__post-featured g5ere__property-featured g5ere__post-featured-bg-gradient">
			<?php g5ere_render_property_thumbnail_markup( array(
				'image_size'         => $image_size,
				'placeholder' => 'on'
			) );

			/**
			 * Hook: g5ere_widget_property_after_thumbnail_skin_02.
			 *
			 * @hookded g5ere_template_loop_property_featured_status - 15
			 */
			do_action( 'g5ere_widget_property_after_thumbnail_skin_02' );

			?>
			<div class="g5ere__property-content g5ere__loop-content">
				<?php
				/**
				 * Hook: g5ere_widget_property_content_skin_02.
				 *
				 * @hooked g5ere_template_loop_property_title - 5
				 * @hooked g5ere_template_loop_property_price - 10
				 */
				do_action('g5ere_widget_property_content_skin_02');
				?>
			</div>
		</div>

	</div>
</article>
