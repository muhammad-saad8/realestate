<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$query_args = G5ERE()->query_agent()->get_agency_agent_query_args();
G5CORE()->query()->query_posts( $query_args );
if ( ! G5CORE()->query()->have_posts() ) {
	G5CORE()->query()->reset_query();
	return;
}
?>
<div class="g5ere__single-block g5ere__agency-block g5ere__agency-block-agents card">
	<div class="card-header">
		<h2>
			<?php esc_html_e( 'Our Agents', 'g5-ere' ); ?>
		</h2>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template( 'agency/single/block/data/agents.php' )?>
	</div>
</div>
