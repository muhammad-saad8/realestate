<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @param $id
 *
 * @return G5ERE_Search_Form
 */
function g5ere_get_search_form($id) {
	return new G5ERE_Search_Form($id);
}

function g5ere_get_search_builtIn_fields() {
	return array(
		'keyword',
		'type',
		'status',
		'bedrooms',
		'bathrooms',
		'rooms',
		'min-size',
		'max-size',
		'city',
		'neighborhood',
		'identity',
		'country',
		'state',
		'min-price',
		'max-price',
		'min-land',
		'max-land',
		'min-land-area',
		'max-land-area',
		'max-area',
		'min-area',
		'label',
		'garage',
		'feature',
		'property_identity',
		'price-range',
		'land-range',
		'size-range'
	);
}

add_filter('ere_search_builtIn_fields','g5ere_get_search_builtIn_fields');

function g5ere_query_string_search_form_fields() {
	$search_builtIn_fields = g5ere_get_search_builtIn_fields();
	$exclude = wp_parse_args($search_builtIn_fields,array('orderby','submit','paged','q','post_type','s'));
	$additional_fields = ere_get_search_additional_fields();
	if (!empty($additional_fields)) {
		$exclude = wp_parse_args(array_keys($additional_fields),$exclude);
	}
	g5ere_query_string_form_fields( null, $exclude );
}