<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$property_floors = g5ere_get_property_floors();
if ( $property_floors ):
	?>
    <div class="g5ere__single-block g5ere__property-block g5ere__property-block-floor-plans card">
        <div class="card-header">
            <h2><?php echo esc_html__( 'Floor Plans', 'g5-ere' ) ?></h2>
        </div>
        <div class="card-body">
			<?php G5ERE()->get_template( 'single-property/block/data/floor-plans.php' ) ?>
        </div>
    </div>
<?php endif; ?>