<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $property_address
 * @var $google_map_address_url
 */
?>
<div class="g5ere__loop-property-address">
	<a title="<?php echo esc_attr($property_address) ?>" target="_blank" href="<?php echo esc_url($google_map_address_url); ?>"><?php echo esc_html($property_address) ?></a>
</div>
