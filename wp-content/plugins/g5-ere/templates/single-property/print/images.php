<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$property_gallery = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_images', true );
if ( ! empty( $property_gallery ) ) :
	$property_gallery = explode( '|', $property_gallery );
	?>
    <div class="g5ere__property-print-block g5ere__property-print-block-gallery">
        <h3 class="g5ere__property-print-block-title">
			<?php esc_html_e( 'Property images', 'g5-ere' ) ?>
        </h3>
		<?php
		foreach ( $property_gallery as $image ) {
			g5ere_render_thumbnail_markup( array(
				'image_size'        => 'full',
				'image_ratio'       => '',
				'image_mode'        => 'image',
				'image_id'          => $image,
				'display_permalink' => false
			) );
		} ?>
    </div>
<?php endif; ?>

