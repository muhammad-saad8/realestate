<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
G5ERE()->options()->set_option( 'single_property_gallery_map_enable', '' )
?>
<div class="g5ere__single-block g5ere__property-block g5ere__property-block-gallery card">
	<div class="card-header">
		<h2><?php echo esc_html__( 'Gallery', 'g5-ere' ) ?></h2>
	</div>
	<div class="card-body">
		<?php g5ere_template_single_property_gallery(); ?>
	</div>
</div>