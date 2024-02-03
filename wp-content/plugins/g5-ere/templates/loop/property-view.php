<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$views = absint(get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_views_count', true));
if ($views === 0) return;
?>
<div class="g5ere__property-view-count">
	<i class="fal fa-eye mr-1"></i> <span><?php echo sprintf(esc_html__('%s views','g5-ere'),$views)?></span>
</div>
