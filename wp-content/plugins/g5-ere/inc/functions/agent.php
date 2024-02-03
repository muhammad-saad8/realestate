<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function g5ere_get_agent_switch_layout() {
	$agent_layout = G5ERE()->options()->get_option( 'agent_layout' );
	return isset( $_REQUEST['view'] ) ? $_REQUEST['view'] : $agent_layout;
}

function g5ere_get_agent_thumbnail_data( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'image_size'         => 'thumbnail',
		'animated_thumbnail' => true,
		'placeholder'        => '',
		'post'               => null
	) );


	$thumbnail_id = get_post_thumbnail_id( $args['post'] );
	$cache_id     = "thumbnail_{$thumbnail_id}_{$args['image_size']}";
	if ( ! empty( $thumbnail_id ) ) {
		$data = G5CORE()->cache()->get_cache_listing( $cache_id );
		if ( ! is_null( $data ) ) {
			return $data;
		}
	}

	$thumbnail = array(
		'id'              => '',
		'url'             => '',
		'width'           => '',
		'height'          => '',
		'alt'             => '',
		'caption'         => '',
		'description'     => '',
		'title'           => g5core_the_title_attribute( array( 'echo' => false ) ),
		'skip_smart_lazy' => false
	);


	if ( ! empty( $thumbnail_id ) ) {
		$thumbnail = g5core_get_image_data( array(
			'image_id'           => $thumbnail_id,
			'image_size'         => $args['image_size'],
			'animated_thumbnail' => $args['animated_thumbnail']
		) );

		if ( empty( $thumbnail['alt'] ) ) {
			$thumbnail['alt'] = g5core_the_title_attribute( array( 'echo' => false ) );
		}

		G5CORE()->cache()->set_cache_listing( $cache_id, $thumbnail );

		return $thumbnail;
	}

	$placeholder = $args['placeholder'] !== '' ? $args['placeholder'] : G5ERE()->options()->get_option( 'agent_placeholder_enable', 'on' );
	if ( $placeholder === 'on' ) {
		$placeholder_img    = G5ERE()->options()->get_option( 'agent_placeholder_image' );
		$placeholder_img_id = isset( $placeholder_img['id'] ) ? $placeholder_img['id'] : '';
		if ( ! empty( $placeholder_img_id ) ) {
			$thumbnail = g5core_get_image_data( array(
				'image_id'           => $placeholder_img_id,
				'image_size'         => $args['image_size'],
				'animated_thumbnail' => $args['animated_thumbnail']
			) );
			G5CORE()->cache()->set_cache_listing( $cache_id, $thumbnail );

			return $thumbnail;
		}
		$thumbnail['url'] = G5ERE()->plugin_url( 'assets/images/placeholder.png' );
		if ( preg_match( '/x/', $args['image_size'] ) ) {
			$image_size          = preg_split( '/x/', $args['image_size'] );
			$image_width         = $image_size[0];
			$image_height        = $image_size[1];
			$thumbnail['width']  = $image_width;
			$thumbnail['height'] = $image_height;
		}

	}

	if ( ! empty( $thumbnail_id ) ) {
		G5CORE()->cache()->set_cache_listing( $cache_id, $thumbnail );
	}

	return $thumbnail;
}

function g5ere_render_agent_thumbnail_markup( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'image_size'         => 'thumbnail',
		'image_ratio'        => '',
		'image_id'           => get_post_thumbnail_id(),
		'animated_thumbnail' => true,
		'display_permalink'  => true,
		'permalink'          => '',
		'image_mode'         => '',
		'placeholder'        => '',
		'post'               => null,
	) );

	$placeholder = $args['placeholder'] !== '' ? $args['placeholder'] : G5ERE()->options()->get_option( 'agent_placeholder_enable', 'on' );
	if ( $placeholder === 'on' ) {
		$args['placeholder']    = 'on';
		$placeholder_img        = G5ERE()->options()->get_option( 'agent_placeholder_image' );
		$placeholder_img_id     = isset( $placeholder_img['id'] ) ? $placeholder_img['id'] : '';
		$args['placeholder_id'] = $placeholder_img_id;
	}
	g5ere_render_thumbnail_markup( $args );
}

function g5ere_get_agent_rating( $args = array() ) {
	$args                          = wp_parse_args( $args, array( 'agent_id' => get_the_ID() ) );
	$enable_comments_reviews_agent = absint( ere_get_option( 'enable_comments_reviews_agent', 0 ) );
	if ( $enable_comments_reviews_agent !== 2 ) {
		return false;
	}
	$total_stars  = $count = $rating = 0;
	$agent_rating = get_post_meta( $args['agent_id'], ERE_METABOX_PREFIX . 'agent_rating', true );
	if ( ! is_array( $agent_rating ) ) {
		return array(
			'rating'      => 0,
			'count'       => 0,
			'rating_data' => array(
				1 => 0,
				2 => 0,
				3 => 0,
				4 => 0,
				5 => 0
			)
		);
	}
	for ( $i = 1; $i <= 5; $i ++ ) {
		if ( isset( $agent_rating[ $i ] ) ) {
			$count       += $agent_rating[ $i ];
			$total_stars += $agent_rating[ $i ] * $i;
		}
	}
	if ( $count > 0 ) {
		$rating = round( ( $total_stars / $count ), 2 );
	}

	return array(
		'rating'      => $rating,
		'count'       => $count,
		'rating_data' => $agent_rating
	);
}

function g5ere_get_single_agent_tabs_content_blocks() {
	$defaults = G5ERE()->settings()->get_single_agent_tabs_content_blocks();
	$content_blocks = G5ERE()->options()->get_option( 'single_agent_tabs_content_blocks', $defaults);
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

function g5ere_get_single_agent_content_blocks() {
	$content_blocks = G5ERE()->options()->get_option( 'single_agent_content_blocks', G5ERE()->settings()->get_single_agent_content_blocks() );
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
		$tabs_content_blocks = g5ere_get_single_agent_tabs_content_blocks();
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


function g5ere_get_agent_info_by_id( $agent_id = null ) {
	if ( ! isset( $agent_id ) ) {
		$agent_id = get_the_ID();
	}

	$agent_status = get_post_status( $agent_id );
	if ( ( $agent_id === 0 ) || ( $agent_status !== 'publish' ) ) {
		return false;
	}

	$email      = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_email', true );
	$agent_name = get_the_title( $agent_id );
	$avatar_id  = get_post_thumbnail_id( $agent_id );

	$agent_mobile_number  = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_mobile_number', true );
	$agent_office_address = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_office_address', true );
	$agent_website_url    = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_website_url', true );

	$agent_position = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_position', true );
	$agent_link        = get_the_permalink( $agent_id );
	$agent_description = get_post_meta( $agent_id, ERE_METABOX_PREFIX . 'agent_description', true );

	return array(
		'agent_id'             => $agent_id,
		'avatar_id'            => $avatar_id,
		'email'                => $email,
		'agent_link'           => $agent_link,
		'agent_name'           => $agent_name,
		'position'             => $agent_position,
		'phone'                => $agent_mobile_number,
		'address'              => $agent_office_address,
		'website_url'          => $agent_website_url,
		'description'          => $agent_description,
		'agent_display_option' => 'agent_info'
	);
}


function g5ere_get_agent_info_by_property( $property_id = null ) {
	if ( ! isset( $property_id ) ) {
		$property_id = get_the_ID();
	}
	$agent_display_option = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'agent_display_option', true );
	if ( $agent_display_option === 'no' ) {
		return false;
	}
	$property_agent = absint( get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_agent', true ) );
	$user_id        = $avatar_id = $email = $agent_link = $agent_name = $agent_position = $agent_mobile_number = $agent_office_address = $agent_website_url = $agent_description = $user_id = '';
	if ( $agent_display_option === 'author_info' ) {
		$post      = get_post( $property_id );
		$user_id   = $post->post_author;
		$email     = get_userdata( $user_id )->user_email;
		$user_info = get_userdata( $user_id );
		// Show Property Author Info (Get info via User. Apply for User, Agent, Seller)
		$avatar_id = get_the_author_meta( ERE_METABOX_PREFIX . 'author_picture_id', $user_id );
		if ( empty( $user_info->first_name ) && empty( $user_info->last_name ) ) {
			$agent_name = $user_info->user_login;
		} else {
			$agent_name = $user_info->first_name . ' ' . $user_info->last_name;
		}
		$agent_mobile_number  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_mobile_number', $user_id );
		$agent_office_address = get_the_author_meta( ERE_METABOX_PREFIX . 'author_office_address', $user_id );
		$agent_website_url    = get_the_author_meta( 'user_url', $user_id );

		$author_agent_id = absint( get_the_author_meta( ERE_METABOX_PREFIX . 'author_agent_id', $user_id ) );
		$agent_status    = get_post_status( $author_agent_id );
		if ( ( $author_agent_id > 0 ) && ( $agent_status == 'publish' ) ) {
			$agent_position = esc_html__( 'Property Agent', 'g5-ere' );
			$agent_link     = get_the_permalink( $author_agent_id );
		} else {
			$agent_position = esc_html__( 'Property Seller', 'g5-ere' );
			$agent_link     = get_author_posts_url( $user_id );
		}
	} elseif ( $agent_display_option === 'agent_info' ) {
		return g5ere_get_agent_info_by_id( $property_agent );
	} elseif ( $agent_display_option === 'other_info' ) {
		$email               = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_other_contact_mail', true );
		$agent_name          = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_other_contact_name', true );
		$agent_mobile_number = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_other_contact_phone', true );
		$agent_description   = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_other_contact_description', true );
	}

	if ( empty( $email ) ) {
		return false;
	}

	return array(
		'agent_id'             => $user_id,
		'avatar_id'            => $avatar_id,
		'email'                => $email,
		'agent_link'           => $agent_link,
		'agent_name'           => $agent_name,
		'position'             => $agent_position,
		'phone'                => $agent_mobile_number,
		'address'              => $agent_office_address,
		'website_url'          => $agent_website_url,
		'description'          => $agent_description,
		'agent_display_option' => $agent_display_option
	);
}

function g5ere_get_single_agent_meta() {
	$meta = array();

	$meta['phone'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_agent_phone_has_title',
	);

	$meta['email'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_agent_email_has_title',
	);

	$meta['address'] = array(
		'priority' => 30,
		'callback' => 'g5ere_template_loop_agent_address_has_title',
	);

	$meta['website'] = array(
		'priority' => 40,
		'callback' => 'g5ere_template_loop_agent_website_has_title',
	);

	$meta['company'] = array(
		'priority' => 50,
		'callback' => 'g5ere_template_loop_agent_company_has_title',
	);

	$meta['licenses'] = array(
		'priority' => 60,
		'callback' => 'g5ere_template_loop_agent_licenses_has_title',
	);


	$meta['office-number'] = array(
		'priority' => 70,
		'callback' => 'g5ere_template_loop_agent_office_number_has_title',
	);

	$meta['fax'] = array(
		'priority' => 80,
		'callback' => 'g5ere_template_loop_agent_fax_has_title',
	);

	$meta = apply_filters( 'g5ere_single_agent_meta', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_single_author_meta() {
	$meta = array();

	$meta['phone'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_author_phone_has_title',
	);

	$meta['email'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_author_email_has_title',
	);

	$meta['website'] = array(
		'priority' => 40,
		'callback' => 'g5ere_template_author_website_has_title',
	);

	$meta['fax'] = array(
		'priority' => 80,
		'callback' => 'g5ere_template_author_fax_has_title',
	);

	$meta = apply_filters( 'g5ere_author_meta', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}