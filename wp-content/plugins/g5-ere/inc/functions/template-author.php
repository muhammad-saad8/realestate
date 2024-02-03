<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
function g5ere_template_author_name() {
	global $wp_query;
	$curauth     = $wp_query->get_queried_object();
	$author_name = $curauth->display_name;
	G5ERE()->get_template( 'author/title.php', array( 'author_name' => $author_name ) );
}

function g5ere_template_author_social() {
	$author_id            = get_queried_object_id();
	$current_author_meta  = get_user_meta( $author_id );
	$author_facebook_url  = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_facebook_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_facebook_url' ][0] : '';
	$author_twitter_url   = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_twitter_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_twitter_url' ][0] : '';
	$author_linkedin_url  = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_linkedin_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_linkedin_url' ][0] : '';
	$author_pinterest_url = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_pinterest_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_pinterest_url' ][0] : '';
	$author_instagram_url = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_instagram_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_instagram_url' ][0] : '';
	$author_skype         = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_skype' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_skype' ][0] : '';
	$author_youtube_url   = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_youtube_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_youtube_url' ][0] : '';
	$author_vimeo_url     = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_vimeo_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_vimeo_url' ][0] : '';
	G5ERE()->get_template( 'agent/loop/social.php', wp_parse_args( $args = array(), array(
		'agent_facebook_url'  => $author_facebook_url,
		'agent_twitter_url'   => $author_twitter_url,
		'agent_linkedin_url'  => $author_linkedin_url,
		'agent_pinterest_url' => $author_pinterest_url,
		'agent_instagram_url' => $author_instagram_url,
		'agent_skype'         => $author_skype,
		'agent_youtube_url'   => $author_youtube_url,
		'agent_vimeo_url'     => $author_vimeo_url,
	) ) );
}

function g5ere_template_author_phone_has_title( $args = array() ) {
	$author_id           = get_queried_object_id();
	$current_author_meta = get_user_meta( $author_id );
	$args                = wp_parse_args( $args, array(
		'title' => true,
		'icon'  => false,
		'phone' => isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_mobile_number' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_mobile_number' ][0] : ''
	) );
	if ( empty( $args['phone'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/phone.php', $args );
}

function g5ere_template_author_email_has_title( $args = array() ) {
	$author_id = get_queried_object_id();
	$args      = wp_parse_args( $args, array(
		'title' => true,
		'icon'  => false,
		'email' => get_the_author_meta( 'user_email', $author_id )
	) );
	if ( empty( $args['email'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/email.php', $args );
}

function g5ere_template_author_website_has_title( $args = array() ) {
	$author_id           = get_queried_object_id();
	$current_author_meta = get_user_meta( $author_id );
	$args                = wp_parse_args( $args, array(
		'title'       => true,
		'icon'        => false,
		'website_url' => isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_website_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_website_url' ][0] : ''
	) );

	if ( empty( $args['website_url'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/website.php', $args );
}

function g5ere_template_author_fax_has_title( $args = array() ) {
	$author_id           = get_queried_object_id();
	$current_author_meta = get_user_meta( $author_id );
	$args                = wp_parse_args( $args, array(
		'title' => true,
		'icon'  => false
	) );
	$fax_number          = isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_fax_number' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_fax_number' ][0] : '';
	if ( empty( $fax_number ) ) {
		return;
	}
	$args = wp_parse_args( array(
		'fax_number' => $fax_number,
	), $args );
	G5ERE()->get_template( 'agent/loop/fax.php', $args );
}

function g5ere_template_loop_author_position( $args = array() ) {
	$author_id           = get_queried_object_id();
	$current_author_meta = get_user_meta( $author_id );
	$args                = wp_parse_args( $args, array(
		'title'    => false,
		'icon'     => false,
		'position' => isset( $current_author_meta[ ERE_METABOX_PREFIX . 'author_website_url' ] ) ? $current_author_meta[ ERE_METABOX_PREFIX . 'author_website_url' ][0] : ''
	) );
	if ( empty( $args['position'] ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/loop/position.php', $args );
}

function g5ere_template_author_meta() {
	$meta = g5ere_get_single_author_meta();
	if ( empty( $meta ) ) {
		return;
	}
	G5ERE()->get_template( 'agent/single/meta.php', array( 'meta' => $meta ) );
}