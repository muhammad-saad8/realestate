<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$virtual_tour = g5ere_get_property_virtual_tour();
if ( $virtual_tour ):
	?>
    <div class="g5ere__single-block g5ere__property-block g5ere__property-block-virtual-tour card">
        <div class="card-header">
            <h2><?php echo esc_html__( 'Virtual Tour', 'g5-ere' ) ?></h2>
        </div>
        <div class="card-body">
			<?php G5ERE()->get_template( 'single-property/block/data/virtual-tour.php' ) ?>
        </div>
    </div>
<?php endif;
