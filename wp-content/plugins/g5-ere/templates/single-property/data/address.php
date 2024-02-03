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
<div class="g5ere__property-address">
	<a title="<?php echo esc_attr($property_address) ?>" target="_blank" href="<?php echo esc_url($google_map_address_url); ?>"><i class="fal fa-map-marker-alt mr-1"></i> <?php echo esc_attr($property_address) ?></a>
</div>
