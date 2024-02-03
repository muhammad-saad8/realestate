<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$service     = G5ERE()->options()->get_option( 'nearby_places_service', 'google' );
$map_service = G5ERE()->options()->get_option( 'map_service', 'google' );
if ( $service == 'yelp' || $map_service != 'google' ) {
	G5ERE()->get_template( 'single-property/block/data/nearby-places/yelp.php' );
} elseif ( $service != 'yelp' ) {
	G5ERE()->get_template( 'single-property/block/data/nearby-places/map.php' );
}

add_action( 'wp_footer', 'g5ere_google_nearby_place_items_template' );

