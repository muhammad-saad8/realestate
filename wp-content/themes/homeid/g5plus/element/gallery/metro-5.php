<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $images
 * @var $image_size
 * @var $image_ratio
 * @var $image_mode
 * @var $hover_effect
 * @var $gallery_id
 * @var $columns_gutter
 * @var $columns
 * @var $post_classes
 * @var $item_inner_class
 *
 */
$wrapper_classes = array(
	"g5core__metro-gutter-{$columns_gutter}"
);
$image_display = 4;
$image_count = count($images);
$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<div class="row no-gutters">
		<div class="col-8">
			<?php
			if ( isset( $images[0] ) ) {
				g5core_render_metro_image_markup( array(
					'image_size'     => $image_size,
					'image_ratio'    => $image_ratio,
					'columns_gutter' => $columns_gutter,
					'layout_ratio'   => '2x1',
					'image_id'       => $images[0],
					'gallery_id'     => $gallery_id,
					'hover_effect' => $hover_effect,
					'custom_class' => $item_inner_class
				) );
			}
			?>
		</div>
		<div class="col-4">
			<?php
			if ( isset( $images[1] ) ) {
				g5core_render_metro_image_markup( array(
					'image_size'     => $image_size,
					'image_ratio'    => $image_ratio,
					'columns_gutter' => $columns_gutter,
					'layout_ratio'   => '1x1',
					'image_id'       => $images[1],
					'gallery_id'     => $gallery_id,
					'hover_effect' => $hover_effect,
					'custom_class' => $item_inner_class
				) );
			}
			?>
		</div>

		<?php for ( $i = 2; $i < $image_display; $i ++ ): ?>
			<?php if (isset($images[$i])): ?>
				<div class="col-6">
					<?php
					$metro_args = array(
						'image_size'     => $image_size,
						'image_ratio'    => $image_ratio,
						'columns_gutter' => $columns_gutter,
						'layout_ratio'   => '1.5x0.9',
						'image_id'       => $images[$i],
						'gallery_id'     => $gallery_id,
						'hover_effect' => $hover_effect,
						'custom_class' => $item_inner_class
					);

					if ( ( $i === ($image_display - 1) ) && ( $image_count > $image_display ) ) {
						$metro_args['view_more']      = $image_count - $image_display;
						$metro_args['display_zoom'] = false;
						$metro_args['custom_class'] = $item_inner_class . ' active';
					}
					g5core_render_metro_image_markup($metro_args);
					?>
				</div>
			<?php endif; ?>
		<?php endfor; ?>
	</div>
	<?php if ($image_count > $image_display): ?>
		<?php for ( $i = $image_display; $i < $image_count; $i ++ ): ?>
			<?php
			$image_full_url = '';
			$zoom_attributes      = array();
			$image_full           = wp_get_attachment_image_src( $images[ $i ], 'full' );
			if ( is_array( $image_full ) && isset( $image_full[0] ) ) {
				$image_full_url = $image_full[0];
			}
			$zoom_attributes[] = sprintf( 'data-gallery-id="%s"', esc_attr( $gallery_id ) );
			$zoom_attributes[] = sprintf( 'href="%s"', esc_url( $image_full_url ) );
			?>
			<a data-g5core-mfp <?php echo join( ' ', $zoom_attributes ) ?> class="d-none"></a>
		<?php endfor; ?>
	<?php endif; ?>
</div>
