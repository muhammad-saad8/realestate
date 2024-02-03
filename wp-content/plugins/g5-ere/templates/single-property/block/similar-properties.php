<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$query_args = G5ERE()->query()->get_similar_property_query();
G5CORE()->query()->query_posts($query_args);
if (!G5CORE()->query()->have_posts()) {
	G5CORE()->query()->reset_query();
	return;
}

?>
<div class="g5ere__single-block g5ere__property-block g5ere__property-block-similar card">
	<div class="card-header">
		<h2><?php echo esc_html__( 'Similar Homes You May Like', 'g5-ere' ) ?></h2>
	</div>
	<div class="card-body">
		<?php G5ERE()->get_template( 'single-property/block/data/similar-properties.php') ?>
	</div>
</div>