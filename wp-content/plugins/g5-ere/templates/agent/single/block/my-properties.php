<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$query_args = G5ERE()->query()->get_agent_property_query_args();
G5CORE()->query()->query_posts( $query_args );
if ( ! G5CORE()->query()->have_posts() ) {
	G5CORE()->query()->reset_query();

	return;
}
?>
<div class="g5ere__single-block g5ere__agent-block g5ere__agent-block-my-property card">
    <div class="card-header">
        <h2><?php echo esc_html__( 'My listing', 'g5-ere' ) ?></h2>
    </div>
    <div class="card-body">
		<?php G5ERE()->get_template( 'agent/single/block/data/my-properties.php' ) ?>
    </div>
</div>
