<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $g5ere_agency G5ERE_Agency
 */

global $g5ere_agency;
if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return;
}
$query_args = G5ERE()->query()->get_agency_property_query_args();
G5CORE()->query()->query_posts( $query_args );
if ( ! G5CORE()->query()->have_posts() ) {
	G5CORE()->query()->reset_query();

	return;
}
?>
<div class="g5ere__single-block g5ere__agency-block g5ere__agency-block-listing card">
    <div class="card-header">
        <h2>
			<?php esc_html_e( 'Our Listing', 'g5-ere' ); ?>
        </h2>
    </div>
    <div class="card-body">
		<?php G5ERE()->get_template( 'agency/single/block/data/listing.php' ); ?>
    </div>
</div>
