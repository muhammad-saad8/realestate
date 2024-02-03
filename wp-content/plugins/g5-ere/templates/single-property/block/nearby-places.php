<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$property_id = get_the_ID();
$location = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_location', true );
if ( ! empty( $location ) ):
	?>
    <div class="g5ere__single-block g5ere__property-block g5ere__property-block-nearby-places card">
        <div class="card-header">
            <h2><?php echo esc_html__( 'Nearby Places', 'g5-ere' ) ?></h2>
        </div>
        <div class="card-body">
			<?php G5ERE()->get_template( 'single-property/block/data/nearby-places.php' ) ?>
        </div>
    </div>
<?php endif; ?>