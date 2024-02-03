<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $block_name
 * @var $g5ere_agency G5ERE_Agency
 */

global $g5ere_agency;

if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return;
}

$location = $g5ere_agency->get_data_location_attributes();
if ($location === false) {
	return;
}
$map_address_url = $g5ere_agency->get_map_address_url();
G5ERE()->get_template( 'map/map.php', apply_filters( 'g5ere_template_single_agency_map_args', array(
	'directions'          => true,
	'map_address_url'     => $map_address_url,
	'location_attributes' => $location,
	'wrap_class'          => 'g5ere__single-agency-map',
	'id'                  => 'g5ere__single_agency_map'
) ) );
