<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
function g5ere_template_agency_result_count( $query_args ) {
	$per_page = $query_args['number'];
	unset( $query_args['number'] );
	unset( $query_args['offset'] );
	$total   = wp_count_terms( $query_args['taxonomy'], $query_args );
	$current = get_query_var( 'paged' ) != 0 ? get_query_var( 'paged' ) : 1;
	G5ERE()->get_template( 'loop/result-count.php', array(
		'total'    => $total,
		'per_page' => $per_page,
		'current'  => $current
	) );
}

function g5ere_template_agency_ordering() {
	$agency_sorting  = G5ERE()->settings()->get_agency_sorting();
	$default_orderby = is_search() ? 'relevance' : apply_filters( 'g5ere_default_agency_orderby', G5ERE()->options()->get_option( 'agency_sorting', 'menu_order' ) );

	$orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

	if ( is_search() ) {
		$agency_sorting = array_merge( array( 'relevance' => __( 'Relevance', 'g5-ere' ) ), $agency_sorting );
	}

	if ( ! array_key_exists( $orderby, $agency_sorting ) ) {
		$orderby = current( array_keys( $agency_sorting ) );
	}
	G5ERE()->get_template( 'loop/orderby.php', array(
		'sorting' => $agency_sorting,
		'orderby' => $orderby
	) );
}

function g5ere_template_loop_agency_title() {
	G5ERE()->get_template( 'agency/loop/title.php' );
}


function g5ere_template_loop_agency_address( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'title'                  => false,
		'icon'                   => false,
		'address'                => $g5ere_agency->get_address(),
		'google_map_address_url' => $g5ere_agency->get_map_address_url()
	) );
	if ( empty( $args['address'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/loop/address.php', $args );
}

function g5ere_template_loop_agency_address_has_title( $args = array() ) {
	g5ere_template_loop_agency_address( wp_parse_args( $args, array(
		'title' => true
	) ) );
}

function g5ere_template_loop_agency_address_has_icon( $args = array() ) {
	g5ere_template_loop_agency_address( wp_parse_args( $args, array(
		'icon' => true
	) ) );
}


function g5ere_template_loop_agency_office_number( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}

	$args          = wp_parse_args( $args, array(
		'title' => false,
		'icon'  => false
	) );
	$office_number = $g5ere_agency->get_office_number();
	if ( empty( $office_number ) ) {
		return;
	}
	$args = wp_parse_args( array(
		'office_number' => $office_number
	), $args );
	G5ERE()->get_template( 'agency/loop/office-number.php', $args );
}

function g5ere_template_loop_agency_office_number_has_icon() {
	g5ere_template_loop_agency_office_number( array( 'icon' => true ) );
}

function g5ere_template_loop_agency_office_number_has_title() {
	g5ere_template_loop_agency_office_number( array( 'title' => true ) );
}

function g5ere_template_loop_agency_phone( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	$args = wp_parse_args( $args, array(
		'title' => false,
		'icon'  => false,
		'phone' => $g5ere_agency->get_mobile()
	) );
	if ( empty( $args['phone'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/loop/phone.php', $args );
}

function g5ere_template_loop_agency_phone_has_icon( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'icon' => true
	) );
	g5ere_template_loop_agency_phone( $args );
}

function g5ere_template_loop_agency_phone_has_title( $args = array() ) {
	g5ere_template_loop_agency_phone( wp_parse_args( $args, array(
		'title' => true
	) ) );
}

function g5ere_template_loop_agency_fax( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	$args = wp_parse_args( $args, array(
		'title'      => false,
		'icon'       => false,
		'fax_number' => $g5ere_agency->get_fax_number()
	) );
	if ( empty( $args['fax_number'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/loop/fax.php', $args );
}

function g5ere_template_loop_agency_fax_has_title() {
	g5ere_template_loop_agency_fax( array( 'title' => true ) );
}

function g5ere_template_loop_agency_fax_has_icon() {
	g5ere_template_loop_agency_fax( array( 'icon' => true ) );
}

function g5ere_template_loop_agency_email( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	$args = wp_parse_args( $args, array(
		'title' => false,
		'icon'  => false,
		'email' => $g5ere_agency->get_email()
	) );
	if ( empty( $args['email'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/loop/email.php', $args );
}

function g5ere_template_loop_agency_email_has_title() {
	g5ere_template_loop_agency_email( array(
		'title' => true
	) );
}

function g5ere_template_loop_agency_email_has_icon( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'icon' => true
	) );
	g5ere_template_loop_agency_email( $args );
}

function g5ere_template_loop_agency_social( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	$args = wp_parse_args( $args, array(
		'title'  => false,
		'social' => $g5ere_agency->get_social()
	) );

	if ( empty( $args['social'] ) ) {
		return;
	}

	G5ERE()->get_template( 'agency/loop/social.php', $args );
}

function g5ere_template_loop_agency_social_has_title() {
	g5ere_template_loop_agency_social( array( 'title' => true ) );
}


function g5ere_template_loop_agency_licenses( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	$args = wp_parse_args( $args, array(
		'title'    => false,
		'icon'     => false,
		'licenses' => $g5ere_agency->get_licenses()
	) );
	if ( empty( $args['licenses'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/loop/licenses.php', $args );
}

function g5ere_template_loop_agency_licenses_has_title( $args = array() ) {
	g5ere_template_loop_agency_licenses( wp_parse_args( $args, array(
		'title' => true
	) ) );
}

function g5ere_template_loop_agency_licenses_has_icon( $args = array() ) {
	g5ere_template_loop_agency_licenses( wp_parse_args( $args, array(
		'icon' => true
	) ) );
}

function g5ere_template_loop_agency_website( $args = array() ) {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	$args = wp_parse_args( $args, array(
		'title'       => false,
		'icon'        => false,
		'website_url' => $g5ere_agency->get_website_url()
	) );

	if ( empty( $args['website_url'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/loop/website.php', $args );
}

function g5ere_template_loop_agency_website_has_icon( $args = array() ) {
	g5ere_template_loop_agency_website( wp_parse_args( $args, array(
		'icon' => true
	) ) );
}

function g5ere_template_loop_agency_website_has_title( $args = array() ) {
	g5ere_template_loop_agency_website( wp_parse_args( $args, array( 'title' => true ) ) );
}

function g5ere_template_loop_agency_description() {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	$description = $g5ere_agency->get_description();
	G5ERE()->get_template( 'agency/loop/description.php', array( 'description' => $description ) );
}

function g5ere_template_agency_title() {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/single/title.php', array( 'title' => $g5ere_agency->get_name() ) );
}

function g5ere_template_loop_agency_meta() {
	$meta = g5ere_get_loop_agency_meta();
	if ( empty( $meta ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/loop/meta.php', array( 'meta' => $meta ) );
}

function g5ere_template_agency_meta() {
	$meta = g5ere_get_agency_meta();
	if ( empty( $meta ) ) {
		return;
	}
	G5ERE()->get_template( 'agency/single/meta.php', array( 'meta' => $meta ) );
}


function g5ere_template_single_agency_content_block() {
	$content_blocks = g5ere_get_single_agency_content_blocks();
	if ( $content_blocks === false ) {
		return;
	}
	foreach ( $content_blocks as $key => $value ) {
		G5ERE()->get_template( "agency/single/block/{$key}.php" );
	}
}

function g5ere_template_single_agency_head() {
	if ( ! g5ere_is_single_agency() ) {
		return;
	}
	$single_agency_layout = G5ERE()->options()->get_option( 'single_agency_layout', 'layout-1' );
	if ( ! in_array( $single_agency_layout, array( 'layout-1' ) ) ) {
		return;
	}
	G5ERE()->get_template( "agency/single/head/{$single_agency_layout}.php" );

}

function g5ere_template_single_agency_head_layout_02() {
	$single_agency_layout = G5ERE()->options()->get_option( 'single_agency_layout', 'layout-1' );
	if ( ! in_array( $single_agency_layout, array( 'layout-2' ) ) ) {
		return;
	}
	G5ERE()->get_template( "agency/single/head/layout-2.php" );
}

function g5ere_template_breadcrumbs_single_agency() {
	$agency_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	if ( ! is_tax( 'agency', $agency_term ) ) {
		return;
	}
	$single_agency_breadcrumb_enable = G5ERE()->options()->get_option('single_agency_breadcrumb_enable','on');
	if ($single_agency_breadcrumb_enable !== 'on') {
		return;
	}
	g5core_template_breadcrumbs( 'g5ere__single-breadcrumbs g5ere__single-agency-breadcrumbs' );
}


function g5ere_template_agency_contact_form() {
	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}
	G5ERE()->get_template( 'global/contact-form.php', array(
		'email' => $g5ere_agency->get_email(),
		'phone' => $g5ere_agency->get_mobile(),
	) );
}

function g5ere_template_single_agency_bottom_bar() {
	if ( ! g5ere_is_single_agency() ) {
		return;
	}
	$bottom_bar_mobile = G5ERE()->options()->get_option( 'single_agency_bottom_bar_mobile', 'off' );
	if ( $bottom_bar_mobile !== 'on' ) {
		return;
	}

	global $g5ere_agency;
	if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
		return;
	}

	$email = $g5ere_agency->get_email();
	$phone = $g5ere_agency->get_mobile();

	if ( empty( $email ) && empty( $phone ) ) {
		return;
	}

	G5ERE()->get_template( 'global/bottom-bar-action.php', array(
		'email' => $email,
		'phone' => $phone,
		'css' => 'g5ere__sbb-agency'
	) );
}