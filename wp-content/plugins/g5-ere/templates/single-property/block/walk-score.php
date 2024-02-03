<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$response = g5ere_get_property_get_walk_score();
if ( $response != '' ):
	?>
    <div class="g5ere__single-block g5ere__property-block g5ere__property-block-walk-score card">
        <div class="card-header">
            <h2><?php echo esc_html__( 'Walk score', 'g5-ere' ) ?></h2>
        </div>
        <div class="card-body">
			<?php G5ERE()->get_template( 'single-property/block/data/walk-score.php' ) ?>
        </div>
    </div>
<?php endif;
