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
$agency_content = $g5ere_agency->get_content();
if (empty($agency_content)) {
	return;
}
?>
<div class="g5ere__single-block g5ere__agency-block g5ere__agency-block-overview card">
	<div class="card-header">
		<h2>
			<?php printf( __( 'About %s', 'g5-ere' ), $g5ere_agency->get_name() ); ?>
		</h2>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template( 'agency/single/block/data/overview.php' ); ?>
	</div>
</div>

