<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$location        = g5ere_get_property_location();
$request_options = array();
$category        = G5ERE()->options()->get_option( 'nearby_places_map_category', '' );
$categories      = G5ERE()->settings()->get_nearby_place_map_category();
$new_categories  = array();
if ( $category != '' ) {
	foreach ( $category as $k => $v ) {
		$new_categories[ $v ] = $categories[ $v ];
	}
}

$request_options = array(
	'categories' => $new_categories,
	'rank'       => G5ERE()->options()->get_option( 'nearby_places_map_rank_by', 'default' ),
	'radius'     => G5ERE()->options()->get_option( 'nearby_places_map_radius', '5000' ),
	'limit'      => intval( G5ERE()->options()->get_option( 'nearby_places_result_limit', '3' ) )
);

$dist_unit      = G5ERE()->options()->get_option( 'yelp_distance_unit', 'miles' );
$dist_unit_text = 'mi';
if ( $dist_unit === 'kilometers' ) {
	$dist_unit_text = 'km';
}

$options = array(
	'location'       => $location,
	'request'        => $request_options,
	'placeholder'    => g5ere_get_property_placeholder_image(),
	'dist_unit'      => $dist_unit,
	'dist_unit_text' => $dist_unit_text
);


?>
<div data-toggle="nearby-places" data-options="<?php echo esc_attr( json_encode( $options ) ) ?>"
     class="g5ere__what-nearby">
</div>


