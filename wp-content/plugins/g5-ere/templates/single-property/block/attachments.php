<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$attachments = g5ere_get_property_get_attachments();
if ( ! empty( $attachments[0] ) ):
	?>
    <div class="g5ere__single-block g5ere__property-block g5ere__property-block-attachments card">
        <div class="card-header">
            <h2><?php echo esc_html__( 'Attachments', 'g5-ere' ) ?></h2>
        </div>
        <div class="card-body">
			<?php G5ERE()->get_template( 'single-property/block/data/attachments.php' ) ?>
        </div>
    </div>
<?php endif; ?>