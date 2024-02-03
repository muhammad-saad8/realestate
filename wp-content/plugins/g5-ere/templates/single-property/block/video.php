<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$video = g5ere_get_property_video();
if (!$video) {
	return;
}
?>
<div class="g5ere__single-block g5ere__property-block g5ere__property-block-video card">
	<div class="card-header">
		<h2><?php echo esc_html__( 'Video', 'g5-ere' ) ?></h2>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template( 'single-property/block/data/video.php' ) ?>
	</div>
</div>
