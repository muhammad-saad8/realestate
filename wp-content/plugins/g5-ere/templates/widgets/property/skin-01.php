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
	'g5ere__widget-property-skin-01',
	'g5ere__loop-skin-medium-image'
);

$thumbnail_data = g5ere_get_property_thumbnail_data( array(
	'image_size'  => $image_size,
	'placeholder' => false
));
if ($thumbnail_data['url'] !== '') {
	$post_class[] = 'g5ere__has-image-featured';
}

?>
<article <?php post_class( $post_class ) ?> >
	<div class="g5ere__property-item-inner g5ere__loop-item-inner">
		<?php if ( $thumbnail_data['url'] !== '' ): ?>
			<div class="g5core__post-featured g5ere__property-featured">
				<?php g5ere_render_property_thumbnail_markup( array(
					'image_size'         => $image_size,
				) ); ?>
			</div>
		<?php endif; ?>
		<div class="g5ere__property-content g5ere__loop-content">
			<?php
			/**
			 * Hook: g5ere_widget_property_content_skin_01.
			 *
			 * @hooked g5ere_template_loop_property_title - 5
			 * @hooked g5ere_template_loop_property_price - 10
			 */
			do_action('g5ere_widget_property_content_skin_01');
			?>
		</div>
	</div>
</article>
