<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="g5ere__loop-property-actions">
	<?php
	/**
	 * Hook: g5ere_loop_property_action.
	 *
	 * @hooked g5ere_template_loop_property_action_view_gallery - 5
	 * @hooked g5ere_template_loop_property_action_favorite - 10
	 * @hooked g5ere_template_loop_property_action_compare - 15
	 */

	do_action('g5ere_loop_property_action');
	?>
</div>
