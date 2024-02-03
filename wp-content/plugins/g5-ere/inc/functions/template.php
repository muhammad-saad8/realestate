<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
function g5ere_body_class( $classes ) {
	$classes = (array) $classes;

	if ( is_singular( 'property' ) ) {
		$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
		$classes[]              = "g5ere__single-property-{$single_property_layout}";
	}
	if ( is_singular( 'agent' ) ) {
		$single_agent_layout = G5ERE()->options()->get_option( 'single_agent_layout', 'layout-01' );
		$classes[]           = "g5ere__single-agent-{$single_agent_layout}";
	}

	if ( g5ere_is_single_agency() ) {
		$single_agency_layout = G5ERE()->options()->get_option( 'single_agency_layout', 'layout-1' );
		$classes[]            = "g5ere__single-agency-{$single_agency_layout}";
	}


	if ( is_post_type_archive( 'property' ) || is_tax( get_object_taxonomies( 'property' ) ) ) {
		$map_position = G5ERE()->options()->get_option( 'map_position' );
		if ( $map_position !== 'none' && $map_position !== 'full-map' ) {
			$classes[] = 'g5ere__archive-halt-map';
		}
	}


	return array_unique( $classes );
}

function g5ere_template_modal_messenger() {
	$agent_info = false;
	if ( is_singular( 'agent' ) ) {
		$agent_info = g5ere_get_agent_info_by_id();
	} elseif ( is_singular( 'property' ) ) {
		$agent_info = g5ere_get_agent_info_by_property();
	} elseif ( g5ere_is_single_agency() ) {
		global $g5ere_agency;
		if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
			return;
		}
		$phone      = $g5ere_agency->get_mobile();
		$email      = $g5ere_agency->get_email();
		$agent_info = array(
			'phone' => $phone,
			'email' => $email
		);
	}
	if ( $agent_info == false ) {
		return;
	}

	G5ERE()->get_template( 'global/modal-messenger.php', $agent_info );
}

function g5ere_template_single_property_bottom_bar() {
	if ( ! is_singular( 'property' ) ) {
		return;
	}
	$bottom_bar_mobile = G5ERE()->options()->get_option( 'single_property_bottom_bar_mobile', 'off' );
	if ( $bottom_bar_mobile !== 'on' ) {
		return;
	}

	$info_arr = g5ere_get_agent_info_by_property();

	if ( $info_arr == false ) {
		return;
	}

	$email      = isset( $info_arr['email'] ) ? $info_arr['email'] : '';
	$phone      = isset( $info_arr['phone'] ) ? $info_arr['phone'] : '';
	$agent_link = isset( $info_arr['agent_link'] ) ? $info_arr['agent_link'] : '';
	$agent_name = isset( $info_arr['agent_name'] ) ? $info_arr['agent_name'] : '';
	$avatar_id  = isset( $info_arr['avatar_id'] ) ? $info_arr['avatar_id'] : '';
	$position   = isset( $info_arr['position'] ) ? $info_arr['position'] : '';

	if ( empty( $email ) && empty( $phone ) ) {
		return;
	}

	G5ERE()->get_template( 'single-property/bottom-bar-mobile.php', array(
		'email'      => $email,
		'phone'      => $phone,
		'agent_link' => $agent_link,
		'agent_name' => $agent_name,
		'avatar_id'  => $avatar_id,
		'position'   => $position
	) );
}


function g5ere_template_loop_property_title( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'post' => 0
	) );
	G5ERE()->get_template( 'loop/title.php', $args );
}

function g5ere_template_loop_property_address( $args = array() ) {
	$args             = wp_parse_args( $args, array(
		'property_id' => get_the_ID()
	) );
	$property_address = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_address', true );
	if ( $property_address === '' ) {
		return;
	}
	$google_map_address_url = g5ere_get_property_map_address_url( $args );
	G5ERE()->get_template( 'loop/property-address.php', array(
		'property_address'       => $property_address,
		'google_map_address_url' => $google_map_address_url
	) );
}

function g5ere_template_loop_property_excerpt() {
	G5ERE()->get_template( 'loop/property-excerpt.php' );
}

function g5ere_template_loop_property_price( $args = array() ) {
	$args             = wp_parse_args( $args, array(
		'property_id' => get_the_ID()
	) );
	$price            = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_price', true );
	$price_short      = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_price_short', true );
	$price_unit       = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_price_unit', true );
	$price_prefix     = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_price_prefix', true );
	$price_postfix    = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_price_postfix', true );
	$empty_price_text = ere_get_option( 'empty_price_text' );
	G5ERE()->get_template( 'loop/property-price.php', array(
		'price'            => $price,
		'price_short'      => $price_short,
		'price_unit'       => $price_unit,
		'price_prefix'     => $price_prefix,
		'price_postfix'    => $price_postfix,
		'empty_price_text' => $empty_price_text
	) );
}

function g5ere_template_loop_property_meta() {
	$meta = g5ere_get_loop_property_meta();
	if ( empty( $meta ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/meta/meta.php', array(
		'meta'     => $meta,
		'separate' => apply_filters( 'g5ere_loop_property_meta_separate', false )
	) );
}

function g5ere_template_loop_property_size() {
	$property_size = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_size', true );
	if ( $property_size === '' ) {
		return;
	}
	$measurement_units = ere_get_measurement_units();
	G5ERE()->get_template( 'loop/property-size.php', array(
		'property_size'     => $property_size,
		'measurement_units' => $measurement_units
	) );
}

function g5ere_template_property_land_size( $args = array() ) {
	$args          = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_land = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_land', true );
	if ( $property_land === '' ) {
		return;
	}
	$measurement_units_land_area = ere_get_measurement_units_land_area();
	G5ERE()->get_template( 'single-property/data/land-size.php', array(
		'property_land'               => $property_land,
		'measurement_units_land_area' => $measurement_units_land_area
	) );
}

function g5ere_template_property_garage_size( $args = array() ) {
	$args        = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$garage_size = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_garage_size', true );
	if ( $garage_size === '' ) {
		return;
	}
	$measurement_units = ere_get_measurement_units();
	G5ERE()->get_template( 'single-property/data/garage-size.php', array(
		'garage_size'       => $garage_size,
		'measurement_units' => $measurement_units
	) );
}

function g5ere_template_property_rooms( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );

	$property_rooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_rooms', true );
	if ( $property_rooms === '' ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/rooms.php', array(
		'rooms' => $property_rooms
	) );
}

function g5ere_template_loop_property_bedrooms() {
	$property_bedrooms = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_bedrooms', true );
	if ( $property_bedrooms === '' ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-bedrooms.php', array( 'property_bedrooms' => $property_bedrooms ) );
}


function g5ere_template_loop_property_bathrooms() {
	$property_bathrooms = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_bathrooms', true );
	if ( $property_bathrooms === '' ) {
		return;
	}

	G5ERE()->get_template( 'loop/property-bathrooms.php', array(
		'property_bathrooms' => $property_bathrooms
	) );
}

function g5ere_template_loop_property_garage() {
	$property_garage = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_garage', true );
	if ( $property_garage === '' ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-garage.php', array( 'property_garage' => $property_garage ) );
}

function g5ere_template_loop_property_badge_featured() {
	$property_featured = g5ere_get_loop_property_featured();
	if ( empty( $property_featured ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-badge.php', array(
		'badge' => $property_featured,
		'class' => 'g5ere__lpb-featured'
	) );
}

function g5ere_template_loop_property_featured_status() {
	$property_status = g5ere_get_loop_property_featured_status();
	if ( empty( $property_status ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-badge.php', array(
		'badge' => $property_status,
		'class' => 'g5ere__lpb-featured-status'
	) );
}

function g5ere_template_loop_property_status() {
	$property_item_status = get_the_terms( get_the_ID(), 'property-status' );
	if ( $property_item_status === false || is_a( $property_item_status, 'WP_Error' ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-status.php', array(
		'property_item_status' => $property_item_status
	) );
}

function g5ere_template_loop_property_primary_status() {
	$property_item_status = get_the_terms( get_the_ID(), 'property-status' );
	if ( $property_item_status === false || is_a( $property_item_status, 'WP_Error' ) ) {
		return;
	}
	$status = current( $property_item_status );
	G5ERE()->get_template( 'loop/property-primary-status.php', array(
		'status' => $status
	) );
}

function g5ere_template_loop_property_term_status() {
	$property_item_status = get_the_terms( get_the_ID(), 'property-status' );
	if ( $property_item_status === false || is_a( $property_item_status, 'WP_Error' ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-term-status.php', array(
		'property_item_status' => $property_item_status
	) );
}

function g5ere_template_loop_property_action() {
	G5ERE()->get_template( 'loop/property-actions.php' );
}

function g5ere_template_loop_property_action_view_gallery() {
	$property_gallery_Id = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_images', true );
	if ( $property_gallery_Id === '' ) {
		return;
	}
	$property_gallery_Id = explode( '|', $property_gallery_Id );
	$property_gallery    = array();
	foreach ( $property_gallery_Id as $image_id ) {
		$image_src = wp_get_attachment_image_src( $image_id, 'full' );
		if ( is_array( $image_src ) ) {
			$property_gallery[] = $image_src[0];
		}
	}
	$property_gallery_count = count( $property_gallery );
	if ( $property_gallery_count === 0 ) {
		return;
	}
	G5ERE()->get_template( 'loop/view-gallery.php', array(
		'property_gallery_count' => $property_gallery_count,
		'property_gallery'       => $property_gallery
	) );
}

function g5ere_template_loop_property_action_favorite() {
	if ( function_exists( 'ere_template_hooks' ) ) {
		ere_template_hooks()->property_favorite();
	}
}

function g5ere_template_loop_property_action_compare() {
	if ( function_exists( 'ere_template_hooks' ) ) {
		ere_template_hooks()->property_compare();
	}
}


function g5ere_template_loop_property_featured() {
	$property_featured = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_featured', true );
	if ( $property_featured !== '1' ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-featured.php' );
}

function g5ere_template_loop_property_term_label() {
	$property_term_label = get_the_terms( get_the_ID(), 'property-label' );
	if ( $property_term_label === false || is_a( $property_term_label, 'WP_Error' ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-term-label.php', array( 'property_term_label' => $property_term_label ) );
}

function g5ere_template_loop_property_label() {
	$property_term_label = get_the_terms( get_the_ID(), 'property-label' );
	if ( $property_term_label === false || is_a( $property_term_label, 'WP_Error' ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-label.php', array( 'property_term_label' => $property_term_label ) );
}

function g5ere_template_loop_property_badge() {
	$property_badge = g5ere_get_loop_property_badge();
	if ( empty( $property_badge ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-badge.php', array(
		'badge' => $property_badge
	) );
}


function g5ere_template_loop_property_featured_label() {
	$property_label = g5ere_get_loop_property_featured_label();
	if ( empty( $property_label ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-badge.php', array(
		'badge' => $property_label,
		'class' => 'g5ere__lpb-featured-label'
	) );
}

function g5ere_template_result_count() {
	$total    = G5CORE()->query()->get_query()->found_posts;
	$per_page = G5CORE()->query()->get_query()->get( 'posts_per_page' );
	$current  = max( 1, G5CORE()->query()->query_var_paged() );
	G5ERE()->get_template( 'loop/result-count.php', array(
		'total'    => $total,
		'per_page' => $per_page,
		'current'  => $current
	) );
}

function g5ere_template_save_search() {
	if ( ! is_post_type_archive( 'property' ) || ! is_search() ) {
		return;
	}
	G5ERE()->get_template( 'loop/save-search-btn.php' );
}

function g5ere_template_modal_save_search() {
	if ( ! is_post_type_archive( 'property' ) ) {
		return;
	}
	$parameters   = G5ERE()->query()->get_parameters();
	$search_query = G5ERE()->query()->get_property_query_args();

	G5ERE()->get_template( 'global/save-search-modal.php',
		array(
			'parameters'   => is_array( $parameters ) ? implode( ',', $parameters ) : $parameters,
			'search_query' => $search_query
		) );
}

function g5ere_template_ordering() {
	$property_sorting = G5ERE()->settings()->get_property_sorting();

	$default_orderby = is_search() ? 'relevance' : apply_filters( 'g5ere_default_property_orderby', G5ERE()->options()->get_option( 'property_sorting', 'menu_order' ) );

	$orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

	if ( is_search() ) {
		$property_sorting = array_merge( array( 'relevance' => __( 'Relevance', 'g5-ere' ) ), $property_sorting );
	}

	if ( ! array_key_exists( $orderby, $property_sorting ) ) {
		$orderby = current( array_keys( $property_sorting ) );
	}
	G5ERE()->get_template( 'loop/orderby.php', array(
		'sorting' => $property_sorting,
		'orderby' => $orderby
	) );
}


function g5ere_template_loop_begin_property_map() {
	$map_position = G5ERE()->options()->get_option( 'map_position' );
	if ( ! in_array( $map_position, array( 'half-map-left', 'half-map-right' ) ) ) {
		return;
	}
	if ( ! is_post_type_archive( 'property' ) && ! is_tax( get_object_taxonomies( 'property' ) ) ) {
		return;
	}
	echo '<div class="g5ere__property-halt-map ' . $map_position . '">';
}

function g5ere_template_loop_end_property_map() {
	$map_position = G5ERE()->options()->get_option( 'map_position' );
	if ( ! in_array( $map_position, array( 'half-map-left', 'half-map-right' ) ) ) {
		return;
	}
	if ( ! is_post_type_archive( 'property' ) && ! is_tax( get_object_taxonomies( 'property' ) ) ) {
		return;
	}
	echo '</div>';
}


function g5ere_template_loop_property_map() {
	$map_position = G5ERE()->options()->get_option( 'map_position' );
	if ( $map_position === 'none' ) {
		return;
	}
	if ( ! is_post_type_archive( 'property' ) && ! is_tax( get_object_taxonomies( 'property' ) ) ) {
		return;
	}
	G5ERE()->get_template( 'loop/map.php' );
}

function g5ere_template_header_advanced_search() {
	$advanced_search_enable = G5CORE()->options()->header()->get_option( 'advanced_search_enable' );
	if ( $advanced_search_enable !== 'on' ) {
		return;
	}
	$advanced_search_form = G5CORE()->options()->header()->get_option( 'advanced_search_form' );
	if ( $advanced_search_form === '' ) {
		return;
	}
	$advanced_search_layout      = G5CORE()->options()->header()->get_option( 'advanced_search_layout', 'boxed' );
	$advanced_search_sticky      = G5CORE()->options()->header()->get_option( 'advanced_search_sticky' );
	$advanced_search_css_classes = G5CORE()->options()->header()->get_option( 'advanced_search_css_classes' );
	G5ERE()->get_template( "header/advanced-search.php", array(
		'advanced_search_form'   => $advanced_search_form,
		'advanced_search_layout' => $advanced_search_layout,
		'advanced_search_sticky' => $advanced_search_sticky,
		'css_classes'            => $advanced_search_css_classes
	) );


}

function g5ere_template_header_advanced_search_mobile() {
	$advanced_search_enable = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_enable' );
	if ( $advanced_search_enable !== 'on' ) {
		return;
	}

	$advanced_search_form = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_form' );
	if ( $advanced_search_form === '' ) {
		return;
	}


	$advanced_search_layout      = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_layout', 'boxed' );
	$advanced_search_sticky      = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_sticky' );
	$advanced_search_css_classes = G5CORE()->options()->header()->get_option( 'advanced_search_mobile_css_classes' );
	G5ERE()->get_template( "header/advanced-search-mobile.php", array(
		'advanced_search_form'   => $advanced_search_form,
		'advanced_search_layout' => $advanced_search_layout,
		'advanced_search_sticky' => $advanced_search_sticky,
		'css_classes'            => $advanced_search_css_classes
	) );
}

function g5ere_template_header_search_form_mobile( $id ) {
	$search_form = g5ere_get_search_form( $id );
	if ( $search_form->data === null ) {
		return;
	}
	$prefix                 = $search_form->prefix;
	$other_features         = $search_form->other_features;
	$price_range_slider     = $search_form->price_range_slider;
	$size_range_slider      = $search_form->size_range_slider;
	$land_area_range_slider = $search_form->land_area_range_slider;
	$search_fields          = $search_form->get_get_search_fields_mobile();

	G5ERE()->get_template( "search-form/mobile.php", array(
		'search_fields'          => $search_fields,
		'other_features'         => $other_features,
		'price_range_slider'     => $price_range_slider,
		'size_range_slider'      => $size_range_slider,
		'land_area_range_slider' => $land_area_range_slider,
		'data'                   => $search_form,
		'prefix'                 => $prefix
	) );
}


function g5ere_template_search_form( $id ) {
	$search_form = g5ere_get_search_form( $id );
	if ( $search_form->data === null ) {
		return;
	}
	$prefix                 = $search_form->prefix;
	$search_style           = $search_form->search_style;
	$search_tabs            = $search_form->search_tabs;
	$advanced_filters       = $search_form->advanced_filters;
	$other_features         = $search_form->other_features;
	$price_range_slider     = $search_form->price_range_slider;
	$size_range_slider      = $search_form->size_range_slider;
	$land_area_range_slider = $search_form->land_area_range_slider;
	$search_fields          = $search_form->search_fields;
	$submit_button_position = $search_form->submit_button_position;
	if ( ! is_array( $search_fields ) || ( ! isset( $search_fields['top'] ) && ! isset( $search_fields['bottom'] ) ) || ( empty( $search_fields['top'] ) && empty( $search_fields['bottom'] ) ) ) {
		return;
	}

	if ( $search_tabs === 'on' || $search_tabs === 'on-all-status' ) {
		foreach ( $search_fields as $k => $v ) {
			if ( isset( $search_fields[ $k ]['status'] ) ) {
				unset( $search_fields[ $k ]['status'] );
			}
		}
	}

	if ( ! isset( $search_fields['top'] ) || empty( $search_fields['top'] ) ) {
		$submit_button_position = 'bottom';
	}

	if ( ! isset( $search_fields['bottom'] ) || empty( $search_fields['bottom'] ) ) {
		$submit_button_position = 'top';
	}

	G5ERE()->get_template( "search-form/{$search_style}.php", array(
		'search_style'           => $search_style,
		'search_tabs'            => $search_tabs,
		'search_fields'          => $search_fields,
		'other_features'         => $other_features,
		'advanced_filters'       => $advanced_filters,
		'price_range_slider'     => $price_range_slider,
		'size_range_slider'      => $size_range_slider,
		'land_area_range_slider' => $land_area_range_slider,
		'submit_button_position' => $submit_button_position,
		'data'                   => $search_form,
		'prefix'                 => $prefix,
		'auto_complete_enable'   => true
	) );
}

function g5ere_template_archive_advanced_search( $settings ) {
	if ( ! isset( $settings['isMainQuery'] ) ) {
		return;
	}
	if ( ! isset( $settings['post_type'] ) || $settings['post_type'] !== 'property' ) {
		return;
	}
	$advanced_search = G5ERE()->options()->get_option( 'advanced_search_enable' );
	if ( $advanced_search !== 'on' ) {
		return;
	}
	$advanced_search_form = G5ERE()->options()->get_option( 'advanced_search_form' );
	if ( $advanced_search_form === '' ) {
		return;
	}
	$advanced_search_css_classes = G5ERE()->options()->get_option( 'advanced_search_css_classes' );
	G5ERE()->get_template( "loop/advanced-search.php", array(
		'advanced_search_form' => $advanced_search_form,
		'css_classes'          => $advanced_search_css_classes
	) );

}

function g5ere_template_single_property_head() {
	if ( ! is_singular( 'property' ) ) {
		return;
	}
	$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
	if ( ! in_array( $single_property_layout, array(
		'layout-1',
		'layout-2',
		'layout-3',
		'layout-4',
		'layout-5',
		'layout-8',
		'layout-9'
	) )
	) {
		return;
	}
	G5ERE()->get_template( "single-property/head/{$single_property_layout}.php" );
}


function g5ere_template_single_property_block_gallery() {
	$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
	if ( ! in_array( $single_property_layout, array( 'layout-7' ) ) ) {
		return;
	}
	g5ere_template_single_property_gallery();
}

function g5ere_template_single_property_gallery() {
	$property_gallery = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_images', true );
	if ( empty( $property_gallery ) ) {
		return;
	}
	$property_gallery = explode( '|', $property_gallery );
	if ( ! is_array( $property_gallery ) || ( count( $property_gallery ) === 0 ) ) {
		return;
	}
	$property_gallery_layout = G5ERE()->options()->get_option( 'single_property_gallery_layout', 'slider' );
	$image_size              = G5ERE()->options()->get_option( 'single_property_gallery_image_size', 'large' );
	$image_ratio             = '';
	$image_mode              = '';
	if ( $image_size === 'full' ) {
		$_image_ratio = G5ERE()->options()->get_option( 'single_property_gallery_image_ratio' );
		if ( is_array( $_image_ratio ) ) {
			$_image_ratio_width  = isset( $_image_ratio['width'] ) ? absint( $_image_ratio['width'] ) : 0;
			$_image_ratio_height = isset( $_image_ratio['height'] ) ? absint( $_image_ratio['height'] ) : 0;
			if ( ( $_image_ratio_width > 0 ) && ( $_image_ratio_height > 0 ) ) {
				$image_ratio = "{$_image_ratio_width}x{$_image_ratio_height}";
			}
		}
		if ( $image_ratio === '' ) {
			$image_mode = 'image';
		}
	}

	$columns_gutter = absint( G5ERE()->options()->get_option( 'single_property_gallery_columns_gutter' ) );

	$map_enable   = G5ERE()->options()->get_option( 'single_property_gallery_map_enable', 'on' );
	$custom_class = G5ERE()->options()->get_option( 'single_property_gallery_custom_class' );

	$slick_options = array();
	if ( in_array( $property_gallery_layout, array( 'slider', 'carousel', 'thumbnail' ) ) ) {
		$slider_pagination_enable = G5ERE()->options()->get_option( 'single_property_gallery_slider_pagination_enable', 'on' );
		$slider_navigation_enable = G5ERE()->options()->get_option( 'single_property_gallery_slider_navigation_enable', '' );
		$slider_autoplay_enable   = G5ERE()->options()->get_option( 'single_property_gallery_slider_autoplay_enable', '' );
		$slider_autoplay_timeout  = intval( G5ERE()->options()->get_option( 'single_property_gallery_slider_autoplay_timeout', '' ) );
		$slider_center_enable     = G5ERE()->options()->get_option( 'single_property_gallery_slider_center_enable', 'on' );
		$slider_center_padding    = G5ERE()->options()->get_option( 'single_property_gallery_slider_center_padding', 'on' );


		$slick_options = array(
			'arrows'   => $slider_navigation_enable === 'on',
			'dots'     => $slider_pagination_enable === 'on',
			'autoplay' => $slider_autoplay_enable === 'on'
		);

		if ( ( $slider_autoplay_enable === 'on' ) && ( $slider_autoplay_timeout > 0 ) ) {
			$slick_options['autoplaySpeed'] = $slider_autoplay_timeout;
		}


		if ( $property_gallery_layout === 'slider' || $property_gallery_layout === 'thumbnail' ) {
			$slick_options['slidesToScroll'] = 1;
			$slick_options['slidesToShow']   = 1;
		}


		if ( $property_gallery_layout === 'carousel' ) {
			$slick_options['centerMode'] = $slider_center_enable === 'on';
			if ( ( $slider_center_enable === 'on' ) && ( $slider_center_padding !== '' ) ) {
				$slick_options['centerPadding'] = $slider_center_padding;
			}

			if ( $slider_center_enable === 'on' ) {
				$slick_options['infinite'] = true;
			}


			$slides_to_show    = absint( G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show', 3 ) );
			$slides_to_show_lg = absint( G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_lg', '' ) );
			$slides_to_show_md = absint( G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_md', '' ) );
			$slides_to_show_sm = absint( G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_sm', '' ) );
			$slides_to_show_xs = absint( G5ERE()->options()->get_option( 'single_property_gallery_slides_to_show_xs', '' ) );


			if ( $slides_to_show_lg == 0 ) {
				$slides_to_show_lg = $slides_to_show;
			}
			if ( $slides_to_show_md == 0 ) {
				$slides_to_show_md = $slides_to_show_lg;
			}
			if ( $slides_to_show_sm == 0 ) {
				$slides_to_show_sm = $slides_to_show_md;
			}
			if ( $slides_to_show_xs == 0 ) {
				$slides_to_show_xs = $slides_to_show_sm;
			}

			$slick_options['slidesToShow']   = $slides_to_show;
			$slick_options['slidesToScroll'] = $slides_to_show;
			$slick_options['responsive']     = array();

			if ( $slides_to_show_lg > 0 ) {
				$slick_options['responsive'][] = array(
					'breakpoint' => 1200,
					'settings'   => array(
						'slidesToShow'   => $slides_to_show_lg,
						'slidesToScroll' => $slides_to_show_lg,
						'centerMode'     => false,
						'centerPadding'  => '0px',
					)
				);
			}

			if ( $slides_to_show_md > 0 ) {
				$slick_options['responsive'][] = array(
					'breakpoint' => 992,
					'settings'   => array(
						'slidesToShow'   => $slides_to_show_md,
						'slidesToScroll' => $slides_to_show_md,
						'centerMode'     => false,
						'centerPadding'  => '0px',
					)
				);
			}

			if ( $slides_to_show_sm > 0 ) {
				$slick_options['responsive'][] = array(
					'breakpoint' => 768,
					'settings'   => array(
						'slidesToShow'   => $slides_to_show_sm,
						'slidesToScroll' => $slides_to_show_sm,
						'centerMode'     => false,
						'centerPadding'  => '0px',
					)
				);
			}

			if ( $slides_to_show_xs > 0 ) {
				$slick_options['responsive'][] = array(
					'breakpoint' => 576,
					'settings'   => array(
						'slidesToShow'   => $slides_to_show_xs,
						'slidesToScroll' => $slides_to_show_xs,
						'centerMode'     => false,
						'centerPadding'  => '0px',
					)
				);
			}
		}
		$slick_options = apply_filters( "g5ere_single_property_gallery_{$property_gallery_layout}_slick_options", $slick_options );
	}

	if ( in_array( $property_gallery_layout, array( 'metro-1', 'metro-2', 'metro-3', 'metro-4' ) ) ) {
		$image_size   = G5ERE()->options()->get_option( 'single_property_gallery_metro_image_size', 'large' );
		$image_ratio  = '';
		$image_mode   = '';
		$_image_ratio = G5ERE()->options()->get_option( 'single_property_gallery_metro_image_ratio' );
		if ( is_array( $_image_ratio ) ) {
			$_image_ratio_width  = isset( $_image_ratio['width'] ) ? absint( $_image_ratio['width'] ) : 0;
			$_image_ratio_height = isset( $_image_ratio['height'] ) ? absint( $_image_ratio['height'] ) : 0;
			if ( ( $_image_ratio_width > 0 ) && ( $_image_ratio_height > 0 ) ) {
				$image_ratio = "{$_image_ratio_width}x{$_image_ratio_height}";
			}
		}
		if ( $image_ratio === '' ) {
			$image_mode = '1x1';
		}
	}


	if ( $map_enable === 'on' ) {
		G5ERE()->get_template( 'single-property/gallery/gallery.php', array(
			'property_gallery_layout' => $property_gallery_layout,
			'property_gallery'        => $property_gallery,
			'image_size'              => $image_size,
			'image_ratio'             => $image_ratio,
			'image_mode'              => $image_mode,
			'columns_gutter'          => $columns_gutter,
			'custom_class'            => $custom_class,
			'slick_options'           => $slick_options
		) );
	} else {
		G5ERE()->get_template( "single-property/gallery/{$property_gallery_layout}.php", array(
			'property_gallery' => $property_gallery,
			'image_size'       => $image_size,
			'image_ratio'      => $image_ratio,
			'image_mode'       => $image_mode,
			'columns_gutter'   => $columns_gutter,
			'custom_class'     => $custom_class,
			'slick_options'    => $slick_options
		) );
	}

}

function g5ere_template_single_property_featured_image() {
	G5ERE()->get_template( 'single-property/featured-image.php' );
}

function g5ere_template_single_property_full_map() {
	if ( ! is_singular( 'property' ) ) {
		return;
	}
	$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
	if ( ! in_array( $single_property_layout, array( 'layout-6', 'layout-7' ) ) ) {
		return;
	}
	$single_property_map_enable = G5ERE()->options()->get_option( 'single_property_map_enable' );
	if ( $single_property_map_enable !== 'on' ) {
		return;
	}
	G5ERE()->options()->set_option( 'single_property_gallery_map_enable', '' );
	g5ere_template_single_property_map();
}

function g5ere_template_single_property_map() {
	$location = g5ere_get_property_data_location_attributes();
	if ( ! $location ) {
		return;
	}

	$map_address_url = g5ere_get_property_map_address_url();
	G5ERE()->get_template( 'map/map.php', apply_filters( 'g5ere_template_single_property_map_args', array(
		'directions'          => true,
		'map_address_url'     => $map_address_url,
		'location_attributes' => $location,
		'wrap_class'          => 'g5ere__single-property-map',
		//'id'                  => 'g5ere__single_property_map',
		'el_class'            => 'g5ere__single-property-map-canvas'
	) ) );
}


function g5ere_template_breadcrumbs() {
	$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
	if ( ! in_array( $single_property_layout, array(
		'layout-6',
		'layout-7',
	) )
	) {
		return;
	}
	g5ere_template_single_property_breadcrumbs();
}

function g5ere_template_single_property_breadcrumbs() {
	if ( ! is_singular( 'property' ) ) {
		return;
	}
	$single_property_breadcrumb_enable = G5ERE()->options()->get_option( 'single_property_breadcrumb_enable', 'on' );
	if ( $single_property_breadcrumb_enable !== 'on' ) {
		return;
	}
	g5core_template_breadcrumbs( 'g5ere__single-breadcrumbs g5ere__single-property-breadcrumbs' );
}


function g5ere_template_single_property_block_header() {
	G5ERE()->get_template( 'single-property/block/header.php' );
}

function g5ere_template_single_agency_layout_01() {
	G5ERE()->get_template( 'agency/single/layout/layout-01.php' );
}


function g5ere_template_property_meta() {
	$meta = g5ere_get_single_property_meta();
	if ( empty( $meta ) ) {
		return;
	}
	G5ERE()->get_template( 'single-property/meta/meta.php', array( 'meta' => $meta ) );
}

function g5ere_template_loop_property_date() {
	$single_property_date_enable = G5ERE()->options()->get_option( 'single_property_date_enable', 'on' );
	if ( $single_property_date_enable !== 'on' ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-date.php' );
}

function g5ere_template_loop_property_view_count() {
	$single_property_view_enable = G5ERE()->options()->get_option( 'single_property_view_enable', 'on' );
	if ( $single_property_view_enable !== 'on' ) {
		return;
	}
	G5ERE()->get_template( 'loop/property-view.php' );
}

function g5ere_template_property_action() {
	$actions = g5ere_get_single_property_actions();
	if ( empty( $actions ) ) {
		return;
	}
	G5ERE()->get_template( 'single-property/actions/actions.php', array( 'actions' => $actions ) );
}

function g5ere_template_single_property_share() {
	$single_property_share_enable = G5ERE()->options()->get_option( 'single_property_share_enable', 'on' );
	if ( $single_property_share_enable !== 'on' ) {
		return;
	}
	$social_share = g5core_get_social_share();
	if ( ! $social_share ) {
		return;
	}
	G5ERE()->get_template( 'single-property/actions/share.php', array( 'social_share' => $social_share ) );
}

function g5ere_template_single_property_print() {
	$single_property_print_enable = G5ERE()->options()->get_option( 'single_property_print_enable', 'on' );
	if ( $single_property_print_enable !== 'on' ) {
		return;
	}
	G5ERE()->get_template( 'single-property/actions/print.php' );
}

function g5ere_template_property_title( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'post' => 0,
	) );
	G5ERE()->get_template( 'single-property/data/title.php', $args );
}

function g5ere_template_property_title_print( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'post' => 0,
	) );
	G5ERE()->get_template( 'single-property/print/title.php', $args );
}

function g5ere_template_property_title_address_open() {
	echo '<div class="g5ere__property-title-address">';
}

function g5ere_template_property_title_price_open() {
	echo '<div class="g5ere__property-title-price">';
}

function g5ere_template_property_action_meta_open() {
	echo '<div class="g5ere__property-meta-action">';
}

function g5ere_template_tag_div_close() {
	echo '</div>';
}

function g5ere_template_single_property_content_block() {
	$content_blocks = g5ere_get_single_property_content_blocks();
	if ( $content_blocks === false ) {
		return;
	}
	foreach ( $content_blocks as $key => $value ) {
		G5ERE()->get_template( "single-property/block/{$key}.php" );
	}
}

function g5ere_template_single_property_content_block_two_columns() {
	$content_blocks = g5ere_get_single_property_content_blocks();
	if ( $content_blocks === false ) {
		return;
	}
	G5ERE()->get_template( "single-property/layout/two-columns.php", array( 'content_blocks' => $content_blocks ) );
}

function g5ere_single_property_block_description() {
	$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
	if ( in_array( $single_property_layout, array( 'layout-1', 'layout-2', 'layout-6', 'layout-7' ) ) ) {
		G5ERE()->get_template( "single-property/block/description.php" );
	}
}

function g5ere_template_property_identity( $args = array() ) {
	$args              = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_identity = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_identity', true );
	if ( empty( $property_identity ) ) {
		$property_identity = get_the_ID();
	}
	G5ERE()->get_template( 'single-property/data/identity.php', array( 'property_identity' => $property_identity ) );
}

function g5ere_template_property_type( $args = array() ) {
	$args          = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_type = get_the_term_list( $args['property_id'], 'property-type', '', ', ', '' );
	if ( $property_type === false || is_a( $property_type, 'WP_Error' ) ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/type.php', array( 'property_type' => $property_type ) );
}

function g5ere_template_property_status( $args = array() ) {
	$args            = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_status = get_the_term_list( $args['property_id'], 'property-status', '', ', ', '' );
	if ( $property_status === false || is_a( $property_status, 'WP_Error' ) ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/status.php', array( 'property_status' => $property_status ) );
}

function g5ere_template_property_label( $args = array() ) {
	$args           = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_label = get_the_term_list( $args['property_id'], 'property-label', '', ', ', '' );
	if ( $property_label === false || is_a( $property_label, 'WP_Error' ) ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/label.php', array( 'property_label' => $property_label ) );
}

function g5ere_template_property_bedrooms( $args = array() ) {
	$args              = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_bedrooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_bedrooms', true );
	if ( $property_bedrooms === '' ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/bedrooms.php', array( 'property_bedrooms' => $property_bedrooms ) );
}


function g5ere_template_property_bathrooms( $args = array() ) {
	$args               = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_bathrooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_bathrooms', true );
	if ( $property_bathrooms === '' ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/bathrooms.php', array( 'property_bathrooms' => $property_bathrooms ) );
}

function g5ere_template_property_price( $args = array() ) {
	$args             = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_id      = $args['property_id'];
	$price            = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price', true );
	$price_short      = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_short', true );
	$price_unit       = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_unit', true );
	$price_prefix     = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_prefix', true );
	$price_postfix    = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_postfix', true );
	$empty_price_text = ere_get_option( 'empty_price_text' );
	G5ERE()->get_template( 'single-property/data/price.php', array(
		'price'            => $price,
		'price_short'      => $price_short,
		'price_unit'       => $price_unit,
		'price_prefix'     => $price_prefix,
		'price_postfix'    => $price_postfix,
		'empty_price_text' => $empty_price_text
	) );
}

function g5ere_template_property_year( $args = array() ) {
	$args          = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_year = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_year', true );
	if ( $property_year === '' ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/year.php', array( 'property_year' => $property_year ) );
}

function g5ere_template_property_size( $args = array() ) {
	$args          = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_size = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_size', true );
	if ( $property_size === '' ) {
		return;
	}
	$measurement_units = ere_get_measurement_units();
	G5ERE()->get_template( 'single-property/data/size.php', array(
		'property_size'     => $property_size,
		'measurement_units' => $measurement_units
	) );
}

function g5ere_template_property_garage( $args = array() ) {
	$args            = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_garage = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_garage', true );
	if ( $property_garage === '' ) {
		return;
	}
	G5ERE()->get_template( 'single-property/data/garage.php', array( 'property_garage' => $property_garage ) );
}

function g5ere_template_property_address( $args = array() ) {
	$args             = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_address = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_address', true );
	if ( $property_address === '' ) {
		return;
	}
	$google_map_address_url = g5ere_get_property_map_address_url( $args );
	G5ERE()->get_template( 'single-property/data/address.php', array(
		'property_address'       => $property_address,
		'google_map_address_url' => $google_map_address_url
	) );
}

function g5ere_template_star_rating( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'rating'       => 0,
		'count'        => 0,
		'show_count'   => false,
		'custom_class' => ''
	) );
	if ( 0 < $args['count'] ) {
		/* translators: 1: rating 2: rating count */
		$label = sprintf( _n( 'Rated %1$s out of 5 based on %2$s customer rating', 'Rated %1$s out of 5 based on %2$s customer ratings', absint( $args['count'] ), 'g5-ere' ), $args['rating'], $args['count'] );
	} else {
		/* translators: %s: rating */
		$label = sprintf( esc_html__( 'Rated %s out of 5', 'g5-ere' ), $args['rating'] );
	}
	$args['label'] = $label;

	G5ERE()->get_template( 'global/rating.php', $args );
}


function g5ere_template_star_rating_icon( $rating = 5 ) {
	G5ERE()->get_template( 'global/rating-icon.php', array( 'rating' => $rating ) );
}

function g5ere_template_single_property_contact_info( $agent_info ) {
	if ( ! isset( $agent_info ) ) {
		$agent_info = g5ere_get_agent_info_by_property();
	}
	if ( $agent_info === false ) {
		return;
	}
	G5ERE()->get_template( 'single-property/contact/contact-info.php', array( 'agent_info' => $agent_info ) );
}

function g5ere_template_property_agent_property( $layout ) {
	if ( is_singular( 'property' ) && $layout == 'layout-02' ) {
		$info_arr = g5ere_get_agent_info_by_property();
		extract( $info_arr );
		/**
		 * @var $agent_id
		 * @var $agent_name
		 * @var $agent_link
		 */
		$ere_property = new ERE_Property();
		$count        = $ere_property->get_total_properties_by_user( $agent_id, $agent_id );
		G5ERE()->get_template( 'widgets/contact/property.php', array(
			'count'      => $count,
			'agent_name' => $agent_name,
			'agent_link' => $agent_link
		) );
	}

}


function g5ere_review_list_comment_callback( $comment, $args, $depth ) {
	global $post;
	if ( ! is_a( $post, 'WP_Post' ) ) {
		return;
	}
	$meta_key = '';
	switch ( $post->post_type ) {
		case 'property':
			$meta_key = 'property_rating';
			break;
		case 'agent':
			$meta_key = 'agent_rating';
			break;
	}

	$rating = absint( get_comment_meta( $comment->comment_ID, $meta_key, true ) );
	G5ERE()->get_template( 'global/comment.php', array(
		'comment' => $comment,
		'args'    => $args,
		'depth'   => $depth,
		'rating'  => $rating
	) );
}

function g5ere_template_message() {
	G5ERE()->get_template( 'global/message.php' );
}

function g5ere_google_nearby_place_items_template() {
	$service     = G5ERE()->options()->get_option( 'nearby_places_service', 'google' );
	$map_service = G5ERE()->options()->get_option( 'map_service', 'google' );
	if ( ! is_singular( 'property' ) ) {
		return;
	}
	if ( $service == 'yelp' ) {
		return;
	}
	if ( $map_service != 'google' ) {
		return;
	}
	G5ERE()->get_template( 'single-property/google-nearby-place/items.php' );

}

function g5ere_mortgage_calculator_output_template() {
	if ( ! is_singular( 'property' ) ) {
		return;
	}
	G5ERE()->get_template( 'global/mc-output.php' );
}

function g5ere_template_dashboard_section_overview() {
	G5ERE()->get_template( 'dashboards/overview.php' );
}

function g5ere_template_custom_search_field( $key, $args = array() ) {
	$field = ere_get_search_additional_field( $key );
	if ( $field === false ) {
		return;
	}
	$args      = wp_parse_args( $args, array(
		'prefix'          => '',
		'css_class_field' => '',
		'field'           => $field
	) );
	$type      = isset( $field['field_type'] ) ? $field['field_type'] : 'text';
	$file_type = $type;
	if ( $type === 'textarea' ) {
		$file_type = 'text';
	}

	if ( $type === 'checkbox_list' || $type === 'radio' ) {
		$file_type = 'select';
	}
	G5ERE()->get_template( "search-fields/type/{$file_type}.php", $args );

}