<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="g5ere__single-block g5ere__property-block g5ere__property-block-header">
	<?php
	/**
	 * Hook: g5ere_single_property_block_header.
	 *
	 * @hooked g5ere_template_property_action - 5
	 * @hooked g5ere_template_property_meta - 10
	 * @hooked g5ere_template_property_title - 15
	 * @hooked g5ere_template_property_address - 20
	 * @hooked g5ere_template_property_price - 25
	 */
	do_action('g5ere_single_property_block_header')
	?>
</div>
