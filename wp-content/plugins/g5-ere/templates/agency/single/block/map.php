<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $g5ere_agency G5ERE_Agency
 */
global $g5ere_agency;
if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return;
}
$location = $g5ere_agency->get_location();
if ( $location === false ) {
	return;
}
?>
<div class="g5ere__single-block g5ere__agency-block g5ere__agency-block-map card">
	<div class="card-header">
		<h2>
			<?php esc_html_e( "Map", "g5-ere" ); ?>
		</h2>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template( 'agency/single/block/data/map.php' ); ?>
	</div>
</div>

