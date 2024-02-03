<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$options = apply_filters('g5ere_property_map_options',array('_popup' => true));
?>
<div class="g5ere__property-explore-map">
	<div class="g5ere__property-explore-map-inner">
		<div id="g5ere__property_explore_map" class="g5ere__map-canvas"  data-options="<?php echo esc_attr(wp_json_encode($options)); ?>"></div>
	</div>
</div>