<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="g5ere__single-block g5ere__agent-block g5ere__agent-block-description card">
	<div class="card-header">
		<h2><?php echo esc_html__( 'About me', 'g5-ere' ) ?></h2>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template( 'agent/single/block/data/description.php' ) ?>
	</div>
</div>
