<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$map_address_url = g5ere_get_property_map_address_url();
?>
<div class="g5ere__single-block g5ere__property-block g5ere__property-block-address card">
	<div class="card-header d-flex flex-wrap justify-content-between align-items-center">
		<h2><?php echo esc_html__('Address','g5-ere') ?></h2>
		<a class="g5ere__sp-open-google-maps btn btn-sm" href="<?php echo esc_url($map_address_url)?>" target="_blank" >
			<i class="fal fa-map-marked-alt mr-1"></i> <span><?php esc_html_e( 'Open on Google Maps', 'g5-ere' ) ?></span>
		</a>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template('single-property/block/data/address.php') ?>
	</div>
</div>