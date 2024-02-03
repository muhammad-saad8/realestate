<?php
/**
 * @param bool $the_agency
 *
 * @return G5ERE_Agency
 */

if ( ! function_exists( 'g5ere_agency_visible' ) ) {
	function g5ere_agency_visible( $agency ) {
		return is_a( $agency, 'G5ERE_Agency' ) && is_a( $agency->agency, 'WP_Term' );
	}
}

if ( ! function_exists( 'g5ere_get_agency' ) ) {
	function g5ere_get_agency( $the_agency = false ) {
		return new G5ERE_Agency( $the_agency );
	}
}


function g5ere_setup_agency_data( $agency ) {
	unset( $GLOBALS['g5ere_agency'] );

	$GLOBALS['g5ere_agency'] = g5ere_get_agency( $agency );

	return $GLOBALS['g5ere_agency'];
}

add_action( 'g5ere_loop_agency', 'g5ere_setup_agency_data' );

function g5ere_get_agency_switch_layout() {
	$agency_layout = G5ERE()->options()->get_option( 'agency_layout' );
	return isset( $_REQUEST['view'] ) ? $_REQUEST['view'] : $agency_layout;
}


function g5ere_get_loop_agency_meta() {
	$meta = array();

	$meta['office_number'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_agency_office_number_has_title',
	);

	$meta['phone'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_agency_phone_has_title',
	);

	$meta['fax'] = array(
		'priority' => 30,
		'callback' => 'g5ere_template_loop_agency_fax_has_title',
	);

	$meta['email'] = array(
		'priority' => 40,
		'callback' => 'g5ere_template_loop_agency_email_has_title',
	);

/*	$meta['licenses'] = array(
		'priority' => 50,
		'callback' => 'g5ere_template_loop_agency_licenses_has_title',
	);

	$meta['website'] = array(
		'priority' => 50,
		'callback' => 'g5ere_template_loop_agency_website_has_title',
	);*/


	$meta['social'] = array(
		'priority' => 50,
		'callback' => 'g5ere_template_loop_agency_social_has_title',
	);


	$meta = apply_filters( 'g5ere_loop_agency_meta', $meta );
	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_agency_meta() {
	$meta = array();

	$meta['office_number'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_agency_office_number_has_title',
	);

	$meta['phone'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_agency_phone_has_title',
	);

	$meta['fax'] = array(
		'priority' => 30,
		'callback' => 'g5ere_template_loop_agency_fax_has_title',
	);

	$meta['email'] = array(
		'priority' => 40,
		'callback' => 'g5ere_template_loop_agency_email_has_title',
	);

	$meta['licenses'] = array(
		'priority' => 60,
		'callback' => 'g5ere_template_loop_agency_licenses_has_title',
	);

	$meta['website'] = array(
		'priority' => 70,
		'callback' => 'g5ere_template_loop_agency_website_has_title',
	);


	$meta = apply_filters( 'g5ere_agency_meta', $meta );
	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_single_agency_tabs_content_blocks() {
	$defaults = G5ERE()->settings()->get_single_agency_tabs_content_blocks();
	$content_blocks = G5ERE()->options()->get_option( 'single_agency_tabs_content_blocks', $defaults);
	if ( ! is_array( $content_blocks ) ) {
		return false;
	}
	foreach ( $content_blocks as $key => $value ) {
		unset( $content_blocks[ $key ]['__no_value__'] );
	}

	if ( ! isset( $content_blocks['enable'] ) || empty( $content_blocks['enable'] ) ) {
		return false;
	}

	foreach ($content_blocks['enable'] as $k => $v) {
		$content_blocks['enable'][$k] = isset($defaults['enable'][$k]) ? $defaults['enable'][$k] : (isset($defaults['disable'][$k]) ? $defaults['disable'][$k] : $content_blocks['enable'][$k]);
	}

	return $content_blocks['enable'];

}

function g5ere_get_single_agency_content_blocks() {
	$content_blocks = G5ERE()->options()->get_option( 'single_agency_content_blocks', G5ERE()->settings()->get_single_agency_content_blocks() );
	if ( ! is_array( $content_blocks ) ) {
		return false;
	}
	foreach ( $content_blocks as $key => $value ) {
		unset( $content_blocks[ $key ]['__no_value__'] );
	}

	if ( ! isset( $content_blocks['enable'] ) || empty( $content_blocks['enable'] ) ) {
		return false;
	}

	if ( isset( $content_blocks['enable']['tabs'] ) ) {
		$tabs_content_blocks = g5ere_get_single_agency_tabs_content_blocks();
		if ( is_array( $tabs_content_blocks ) ) {
			foreach ( $tabs_content_blocks as $key => $value ) {
				if ( isset( $content_blocks['enable'][ $key ] ) ) {
					unset( $content_blocks['enable'][ $key ] );
				}
			}
		}
	}

	return $content_blocks['enable'];
}

function g5ere_is_single_agency() {
	$agency_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	return is_tax( 'agency', $agency_term );
}


function g5ere_is_agency_page() {
	$page_id = g5ere_get_agency_page();
	if ($page_id === 0) {
		return false;
	}
	return is_page( $page_id );
}

function g5ere_get_agency_page() {
	return ere_get_page_id('agency');
}

function g5ere_is_dashboard() {
	$dashboard_page_id = ere_get_page_id('dashboard');
	if ($dashboard_page_id === 0) {
		return false;
	}
	return is_page($dashboard_page_id);
}