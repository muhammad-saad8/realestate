<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="g5ere__single-block g5ere__property-block g5ere__property-block-details card">
	<div class="card-header">
		<h2><?php echo esc_html__('Details','g5-ere') ?></h2>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template('single-property/block/data/details.php') ?>
	</div>
</div>