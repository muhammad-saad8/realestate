<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function g5ere_template_loop_agent_title( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'agent_link' => get_permalink(),
		'agent_name' => get_the_title()
	) );
	G5ERE()->get_template( 'agent/loop/title.php', $args );
}

function g5ere_template_loop_agent_social( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'    => false,
		'agent_id' => get_the_ID()
	) );

	$agent_id = absint( $args['agent_id'] );
	if ( $agent_id === 0 ) {
		return;
	}
	$agent_facebook_url  = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_facebook_url', true );
	$agent_twitter_url   = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_twitter_url', true );
	$agent_linkedin_url  = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_linkedin_url', true );
	$agent_pinterest_url = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_pinterest_url', true );
	$agent_instagram_url = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_instagram_url', true );
	$agent_skype         = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_skype', true );
	$agent_youtube_url   = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_youtube_url', true );
	$agent_vimeo_url     = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_vimeo_url', true );
	if ( empty( $agent_facebook_url ) && empty( $agent_twitter_url ) && empty( $agent_linkedin_url )
	     && empty( $agent_pinterest_url ) && empty( $agent_instagram_url ) && empty( $agent_skype ) &&
	     empty( $agent_youtube_url ) && empty( $agent_vimeo_url ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/social.php', wp_parse_args( $args, array(
		'agent_facebook_url'  => $agent_facebook_url,
		'agent_twitter_url'   => $agent_twitter_url,
		'agent_linkedin_url'  => $agent_linkedin_url,
		'agent_pinterest_url' => $agent_pinterest_url,
		'agent_instagram_url' => $agent_instagram_url,
		'agent_skype'         => $agent_skype,
		'agent_youtube_url'   => $agent_youtube_url,
		'agent_vimeo_url'     => $agent_vimeo_url,
	) ) );

}

function g5ere_template_loop_agent_social_has_title() {
	g5ere_template_loop_agent_social( array( 'title' => true ) );
}

function g5ere_template_loop_agent_phone( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title' => false,
		'icon'  => false,
		'phone' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_mobile_number', true )
	) );
	if ( empty( $args['phone'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/phone.php', $args );
}

function g5ere_template_loop_agent_phone_has_icon( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'icon' => true
	) );
	g5ere_template_loop_agent_phone( $args );
}

function g5ere_template_loop_agent_phone_has_title() {
	g5ere_template_loop_agent_phone( array(
		'title' => true
	) );
}


function g5ere_template_loop_agent_property() {
	$agent_user_id = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_user_id', true );
	$user          = get_user_by( 'id', $agent_user_id );
	if ( empty( $user ) ) {
		$agent_user_id = 0;
	}
	$ere_property = new ERE_Property();
	$count        = $ere_property->get_total_properties_by_user( get_the_ID(), $agent_user_id );
	G5ERE()->get_template( 'agent/loop/property.php', array( 'count' => $count ) );

}

function g5ere_template_loop_agent_description( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'description' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_description', true )
	) );

	if ( empty( $args['description'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/description.php', $args );
}

function g5ere_template_loop_agent_position( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'    => false,
		'icon'     => false,
		'position' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_position', true )
	) );
	if ( empty( $args['position'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/position.php', $args );
}

function g5ere_template_contact_agent_button_whatsapp( $property_id, $phone ) {
	$enable_whatsapp_button = G5ERE()->options()->get_option( 'contact_agent_whatsapp_button_enable', '' );
	if ($enable_whatsapp_button !== 'on') {
		return;
	}
	if (empty($phone)) {
		return;
	}

	G5ERE()->get_template( 'single-property/print/button-whatsapp.php', array(
		'property_id' => $property_id,
		'phone'       => $phone,
	) );
}

function g5ere_template_loop_agent_position_has_title() {
	g5ere_template_loop_agent_position( array( 'title' => true ) );
}

function g5ere_template_loop_agent_position_has_icon() {
	g5ere_template_loop_agent_position( array( 'icon' => true ) );
}

function g5ere_template_loop_agent_email( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title' => false,
		'icon'  => false,
		'email' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_email', true )
	) );
	if ( empty( $args['email'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/email.php', $args );
}

function g5ere_template_loop_agent_email_has_title() {
	g5ere_template_loop_agent_email( array(
		'title' => true
	) );
}

function g5ere_template_loop_agent_email_has_icon( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'icon' => true
	) );
	g5ere_template_loop_agent_email( $args );
}

function g5ere_template_loop_agent_rating() {
	$rating_data = g5ere_get_agent_rating();
	if ( $rating_data === false ) {
		return;
	}

	g5ere_template_star_rating( array(
		'rating'       => $rating_data['rating'],
		'count'        => $rating_data['count'],
		'custom_class' => 'g5ere__loop-agent-rating'
	) );
}


function g5ere_template_loop_agent_agency( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title' => false
	) );
	G5ERE()->get_template( 'agent/loop/agency.php', $args );
}

function g5ere_template_loop_agent_agency_has_title() {
	g5ere_template_loop_agent_agency( array( 'title' => true ) );
}

function g5ere_template_loop_agent_website( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'       => false,
		'icon'        => false,
		'website_url' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_website_url', true )
	) );

	if ( empty( $args['website_url'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/website.php', $args );
}

function g5ere_template_loop_agent_website_has_icon( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'icon' => true
	) );
	g5ere_template_loop_agent_website( $args );
}

function g5ere_template_loop_agent_website_has_title() {
	g5ere_template_loop_agent_website( array( 'title' => true ) );
}

function g5ere_template_loop_agent_fax( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'      => false,
		'icon'       => false,
		'fax_number' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_fax_number', true )
	) );
	if ( empty( $args['fax_number'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/fax.php', $args );
}

function g5ere_template_loop_agent_fax_has_title() {
	g5ere_template_loop_agent_fax( array( 'title' => true ) );
}

function g5ere_template_loop_agent_fax_has_icon() {
	g5ere_template_loop_agent_fax( array( 'icon' => true ) );
}


function g5ere_template_loop_agent_office_number( $args = array() ) {
	$args          = wp_parse_args( $args, array(
		'title' => false,
		'icon'  => false
	) );
	$office_number = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_office_number', true );
	if ( empty( $office_number ) ) {
		return;
	}
	$args = wp_parse_args( array(
		'office_number' => $office_number
	), $args );
	G5ERE()->get_template( 'agent/loop/office-number.php', $args );
}

function g5ere_template_loop_agent_office_number_has_icon() {
	g5ere_template_loop_agent_office_number( array( 'icon' => true ) );
}

function g5ere_template_loop_agent_office_number_has_title() {
	g5ere_template_loop_agent_office_number( array( 'title' => true ) );
}


function g5ere_template_loop_agent_licenses( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'    => false,
		'icon'     => false,
		'licenses' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_licenses', true )
	) );
	if ( empty( $args['licenses'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/licenses.php', $args );
}

function g5ere_template_loop_agent_licenses_has_title() {
	g5ere_template_loop_agent_licenses( array(
		'title' => true
	) );
}

function g5ere_template_loop_agent_licenses_has_icon() {
	g5ere_template_loop_agent_licenses( array(
		'icon' => true
	) );
}


function g5ere_template_loop_agent_company( $args = array() ) {
	$args    = wp_parse_args( $args, array(
		'title' => true,
		'icon'  => true
	) );
	$company = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_company', true );
	if ( empty( $company ) ) {
		return;
	}
	$args = wp_parse_args( array(
		'company' => $company,
	), $args );
	G5ERE()->get_template( 'agent/loop/company.php', $args );
}

function g5ere_template_loop_agent_company_has_icon() {
	g5ere_template_loop_agent_company( array( 'icon' => true ) );
}

function g5ere_template_loop_agent_company_has_title() {
	g5ere_template_loop_agent_company( array( 'icon' => false ) );
}


function g5ere_template_loop_agent_address( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'title'   => false,
		'icon'    => false,
		'address' => get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_office_address', true )
	) );
	if ( empty( $args['address'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/address.php', $args );
}

function g5ere_template_loop_agent_address_has_title() {
	g5ere_template_loop_agent_address( array(
		'title' => true
	) );
}

function g5ere_template_loop_agent_address_has_icon( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'icon' => true
	) );
	g5ere_template_loop_agent_address( $args );
}


function g5ere_template_ordering_agent() {
	$agent_sorting = G5ERE()->settings()->get_agent_sorting();

	$default_orderby = is_search() ? 'relevance' : apply_filters( 'g5ere_default_agent_orderby', G5ERE()->options()->get_option( 'agent_sorting', 'menu_order' ) );

	$orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

	if ( is_search() ) {
		$agent_sorting = array_merge( array( 'relevance' => __( 'Relevance', 'g5-ere' ) ), $agent_sorting );
	}

	if ( ! array_key_exists( $orderby, $agent_sorting ) ) {
		$orderby = current( array_keys( $agent_sorting ) );
	}


	G5ERE()->get_template( 'loop/orderby.php', array(
		'sorting' => $agent_sorting,
		'orderby' => $orderby
	) );
}

function g5ere_template_agent_title( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'post' => 0,
	) );
	G5ERE()->get_template( 'agent/single/title.php', $args );
}

function g5ere_template_agent_meta() {
	$meta = g5ere_get_single_agent_meta();
	if ( empty( $meta ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/single/meta.php', array( 'meta' => $meta ) );
}

function g5ere_template_agent_rating( $args = array() ) {
	$rating_data = g5ere_get_agent_rating( $args );
	if ( $rating_data === false ) {
		return;
	}

	g5ere_template_star_rating( array(
		'rating'       => $rating_data['rating'],
		'count'        => $rating_data['count'],
		'show_count'   => true,
		'custom_class' => 'g5ere__agent-rating'
	) );
}

function g5ere_template_agent_breadcrumbs() {
	if ( ! is_singular( 'agent' ) && ! is_author() ) {
		return;
	}
	$single_agent_breadcrumb_enable = G5ERE()->options()->get_option( 'single_agent_breadcrumb_enable', 'on' );
	if ( $single_agent_breadcrumb_enable !== 'on' ) {
		return;
	}
	g5core_template_breadcrumbs( 'g5ere__single-breadcrumbs g5ere__single-agent-breadcrumbs' );
}

function g5ere_template_single_agent_head() {
	if ( ! is_singular( 'agent' ) && ! is_author() ) {
		return;
	}
	$single_agent_layout = G5ERE()->options()->get_option( 'single_agent_layout', 'layout-01' );
	if ( ! in_array( $single_agent_layout, array(
		'layout-01',
	) )
	) {
		return;
	}
	if ( is_author() ) {
		G5ERE()->get_template( "author/author-info.php" );
	} else {
		G5ERE()->get_template( "agent/single/head/{$single_agent_layout}.php" );
	}

}

function g5ere_template_single_agent_bottom_bar() {
	if ( ! is_singular( 'agent' ) ) {
		return;
	}
	$bottom_bar_mobile = G5ERE()->options()->get_option( 'single_agent_bottom_bar_mobile', 'off' );
	if ( $bottom_bar_mobile !== 'on' ) {
		return;
	}

	$email = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_email', true );
	$phone = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'agent_mobile_number', true );

	if ( empty( $email ) && empty( $phone ) ) {
		return;
	}

	G5ERE()->get_template( 'global/bottom-bar-action.php', array(
		'email' => $email,
		'phone' => $phone,
		'css'   => 'g5ere__sbb-agent'
	) );
}

function g5ere_template_single_agent_content_block() {
	$content_blocks = g5ere_get_single_agent_content_blocks();
	if ( $content_blocks === false ) {
		return;
	}
	foreach ( $content_blocks as $key => $value ) {
		G5ERE()->get_template( "agent/single/block/{$key}.php" );
	}
}


function g5ere_template_agent_contact_form( $agent_info = array() ) {
	G5ERE()->get_template( 'global/contact-form.php', $agent_info );
}

function g5ere_template_contact_agent_button() {
	G5ERE()->get_template( 'agent/single/contact-btn.php' );
}
