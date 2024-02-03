<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property_gallery
 * @var $image_size
 * @var $image_ratio
 * @var $image_mode
 * @var $columns_gutter
 * @var $custom_class
 */
$wrapper_classes = array(
	'g5ere__single-property-gallery',
	'g5ere__spg-metro-4',
	'row',
	'no-gutters',
	"g5core__metro-gutter-{$columns_gutter}"
);

if ( $custom_class !== '' ) {
	$wrapper_classes[] = $custom_class;
}
$property_gallery_count = count( $property_gallery );
$property_display = 10;
$gallery_id    = uniqid();
$wrapper_class = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<div class="col-md-8">
		<?php
		if ( isset( $property_gallery[0] ) ) {
			g5core_render_metro_image_markup( array(
				'image_size'     => $image_size,
				'image_ratio'    => $image_ratio,
				'columns_gutter' => $columns_gutter,
				'layout_ratio'   => '6x3',
				'image_id'       => $property_gallery[0],
				'gallery_id'     => $gallery_id,
			) );
		}
		?>
	</div>
	<div class="col-md-4">
		<div class="row no-gutters">
			<?php for ( $i = 1; $i < $property_display; $i ++ ): ?>
				<?php if ( isset( $property_gallery[ $i ] ) ): ?>
					<div class="col-4">
						<?php
						$metro_args = array(
							'image_size'     => $image_size,
							'image_ratio'    => $image_ratio,
							'columns_gutter' => $columns_gutter,
							'layout_ratio'   => '1x1',
							'image_id'       => $property_gallery[ $i ],
							'gallery_id'     => $gallery_id,
						);
						if ( ( $i === ($property_display - 1) ) && ( $property_gallery_count > $property_display ) ) {
							$metro_args['view_more']      = $property_gallery_count - $property_display;
							$metro_args['display_zoom'] = false;
							$metro_args['custom_class'] = 'active';
						}
						g5core_render_metro_image_markup( $metro_args );
						?>
					</div>
				<?php endif; ?>
			<?php endfor; ?>
		</div>
	</div>
	<?php if ($property_gallery_count > $property_display): ?>
		<?php for ( $i = $property_display; $i < $property_gallery_count; $i ++ ): ?>
			<?php
			$image_full_url = '';
			$zoom_attributes      = array();
			$image_full           = wp_get_attachment_image_src( $property_gallery[ $i ], 'full' );
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
