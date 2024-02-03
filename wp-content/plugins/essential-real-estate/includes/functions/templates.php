<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function ere_template_loop_property_price( $property_id = '' ) {
    if (is_array($property_id)) {
        $args          = wp_parse_args( $property_id, array(
            'property_id' => get_the_ID(),
        ) );
        $property_id = $args['property_id'];
    } elseif (empty($property_id)) {
        $property_id = get_the_ID();
    }
	$price            = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price', true );
	$price_short      = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_short', true );
	$price_unit       = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_unit', true );
	$price_prefix     = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_prefix', true );
	$price_postfix    = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_price_postfix', true );
	$empty_price_text = ere_get_option( 'empty_price_text' );
	ere_get_template( 'loop/property-price.php', apply_filters('ere_template_loop_property_price_args',array(
		'price'            => $price,
		'price_short'      => $price_short,
		'price_unit'       => $price_unit,
		'price_prefix'     => $price_prefix,
		'price_postfix'    => $price_postfix,
		'empty_price_text' => $empty_price_text
	)));
}

function ere_template_loop_property_title($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}
	ere_get_template('loop/property-title.php',array('property_id' => $property_id));
}

function ere_template_loop_property_location($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}
	$property_address   = get_post_meta($property_id,ERE_METABOX_PREFIX . 'property_address', TRUE);
	if (empty($property_address)) {
		return;
	}
	$property_location = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_location', true );
	if ( is_array($property_location) && isset($property_location['address'])) {
		$google_map_address_url = "http://maps.google.com/?q=" . $property_location['address'];
	} else {
		$google_map_address_url = "http://maps.google.com/?q=" . $property_address;
	}
	ere_get_template( 'loop/property-location.php', array(
		'property_address'       => $property_address,
		'google_map_address_url' => $google_map_address_url,
	));
}


function ere_template_single_property_gallery($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    ere_get_template( 'single-property/gallery.php' );
}
function ere_template_single_property_floor($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}
	$property_floor_enable = boolval(get_post_meta($property_id,ERE_METABOX_PREFIX . 'floors_enable', TRUE));
	if ($property_floor_enable === FALSE) {
		return;
	}
	$property_floors       = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'floors', true );
	if (!is_array($property_floors) && count($property_floors) == 0) {
		return;
	}

	ere_get_template( 'single-property/floors.php', array( 'property_floors' => $property_floors ) );
}

function ere_template_single_property_features($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}

    $tabs = ere_get_single_property_features_tabs($property_id);

    if ( empty( $tabs ) ) {
        return;
    }

	ere_get_template( 'single-property/features.php', array('tabs' => $tabs) );
}

function ere_template_single_property_overview($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $data = ere_get_single_property_overview($args['property_id']);
    if (empty($data)) {
        return;
    }
    ere_get_template('single-property/overview.php', array('data' => $data));
}

function ere_template_single_property_feature($args = array())
{
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $features = ere_get_property_features($args);

    if (($features === false ) || empty($features)) {
        return;
    }

    ere_get_template('single-property/feature.php',array('features' => $features));
}

function ere_template_single_property_video($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $video = ere_get_property_video($args);
    if ($video === false) {
        return;
    }
    ere_get_template('single-property/video.php',$video);
}

function ere_template_single_property_virtual_tour($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $virtual_tour =  ere_get_property_virtual_tour($args);
    if ($virtual_tour === false) {
        return;
    }
    ere_get_template('single-property/virtual-tour.php',$virtual_tour);
}

function ere_template_single_property_identity($args = array() ) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_identity = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_identity', true );
    if ( empty( $property_identity ) ) {
        $property_identity = get_the_ID();
    }

    ere_get_template('single-property/data/identity.php', array( 'property_identity' => $property_identity ));


}

function ere_template_single_property_type($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_type = get_the_term_list( $args['property_id'], 'property-type', '', ', ', '' );
    if ( $property_type === false || is_a( $property_type, 'WP_Error' ) ) {
        return;
    }
    ere_get_template( 'single-property/data/type.php', array( 'property_type' => $property_type ) );

}

function ere_template_single_property_status($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_status = get_the_term_list( $args['property_id'], 'property-status', '', ', ', '' );
    if ( $property_status === false || is_a( $property_status, 'WP_Error' ) ) {
        return;
    }

    ere_get_template( 'single-property/data/status.php', array( 'property_status' => $property_status ) );
}

function ere_template_single_property_rooms($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_rooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_rooms', true );
    if ( $property_rooms === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/rooms.php', array(
        'rooms' => $property_rooms
    ) );
}

function ere_template_single_property_bedrooms($args = array()){
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_bedrooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_bedrooms', true );
    if ( $property_bedrooms === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/bedrooms.php', array( 'property_bedrooms' => $property_bedrooms ) );
}

function ere_template_single_property_bathrooms($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_bathrooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_bathrooms', true );
    if ( $property_bathrooms === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/bathrooms.php', array( 'property_bathrooms' => $property_bathrooms ) );
}

function ere_template_single_property_year($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_year = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_year', true );
    if ( $property_year === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/year.php', array( 'property_year' => $property_year ) );
}

function ere_template_single_property_size($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_size = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_size', true );
    if ( $property_size === '' ) {
        return;
    }
    $measurement_units = ere_get_measurement_units();
    ere_get_template( 'single-property/data/size.php', array(
        'property_size'     => $property_size,
        'measurement_units' => $measurement_units
    ) );
}

function ere_template_single_property_land_size($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_land = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_land', true );
    if ( $property_land === '' ) {
        return;
    }
    $measurement_units_land_area = ere_get_measurement_units_land_area();
    ere_get_template( 'single-property/data/land-size.php', array(
        'property_land'               => $property_land,
        'measurement_units_land_area' => $measurement_units_land_area
    ) );
}

function ere_template_single_property_label($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_label = get_the_term_list( $args['property_id'], 'property-label', '', ', ', '' );
    if ( $property_label === false || is_a( $property_label, 'WP_Error' ) ) {
        return;
    }
    ere_get_template( 'single-property/data/label.php', array( 'property_label' => $property_label ) );
}
function ere_template_single_property_garage($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_garage = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_garage', true );
    if ( $property_garage === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/garage.php', array( 'property_garage' => $property_garage ) );
}

function ere_template_single_property_garage_size($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $garage_size = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_garage_size', true );
    if ( $garage_size === '' ) {
        return;
    }
    $measurement_units = ere_get_measurement_units();
    ere_get_template( 'single-property/data/garage-size.php', array(
        'garage_size'       => $garage_size,
        'measurement_units' => $measurement_units
    ) );
}

function ere_template_property_search_form($atts = array(),$css_class_field = '', $css_class_half_field = '', $show_status_tab = true) {
    $args = array(
        'atts' => $atts,
        'show_status_tab'        => $show_status_tab,
        'css_class_field'      => $css_class_field,
        'css_class_half_field' => $css_class_half_field,
    );
    ere_get_template('property/search-form.php', $args);
}

function ere_template_property_map_search($extend_class) {
    $map_id = 'ere_result_map-'.rand();
    ere_get_template('property/search-map.php',array(
        'extend_class' => $extend_class,
        'map_id' => $map_id
    ));
}

function ere_template_loop_property_action($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-action.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_action_view_gallery($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_gallery = ere_get_property_gallery_image($property_id);
    $total_image = 0;
    if ($property_gallery) {
        $total_image = count($property_gallery);
    }
    ere_get_template( 'loop/property-action/view-gallery.php', array(
        'property_id'       => $property_id,
        'total_image' => $total_image
    ));

}

function ere_template_loop_property_action_favorite($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $enable_favorite_property = ere_get_option( 'enable_favorite_property', '1' );
    if (!filter_var($enable_favorite_property, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }

    global $current_user;
    wp_get_current_user();
    $key = false;
    $user_id = $current_user->ID;
    $my_favorites = get_user_meta($user_id, ERE_METABOX_PREFIX . 'favorites_property', true);
    if (!empty($my_favorites)) {
        $key = array_search($property_id, $my_favorites);
    }
    $icon_favorite = apply_filters('ere_icon_favorite','fa fa-star') ;
    $icon_not_favorite = apply_filters('ere_icon_not_favorite','fa fa-star-o');

    if ($key !== false) {
        $icon_class = $icon_favorite;
        $title = esc_attr__('It is my favorite', 'essential-real-estate');
    } else {
        $icon_class = $icon_not_favorite;
        $title = esc_attr__('Add to Favorite', 'essential-real-estate');
    }


    ere_get_template( 'loop/property-action/favorite.php', array(
        'property_id'       => $property_id,
        'icon_class' => $icon_class,
        'title' => $title,
        'icon_favorite' => $icon_favorite,
        'icon_not_favorite' => $icon_not_favorite
    ));
}

function ere_template_loop_property_action_compare($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $enable_compare_properties =  ere_get_option( 'enable_compare_properties', '1' );
    if (!filter_var($enable_compare_properties, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }

    ere_get_template( 'loop/property-action/compare.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_thumbnail($args = array())
{
    $args = wp_parse_args($args,array(
        'property_id'       => get_the_ID(),
        'image_size' => '',
        'extra_classes' => ''
    ));

    ere_get_template('loop/property-thumbnail.php', array(
        'property_id' => $args['property_id'],
        'image_size' => $args['image_size'],
        'extra_classes' => $args['extra_classes']
    ));
}

function ere_template_loop_property_image($args = array()) {
    $args = wp_parse_args($args,array(
        'property_id'       => get_the_ID(),
        'image_size' => '',
        'image_size_default' => ere_get_loop_property_image_size_default()
    ));
    ere_get_template('loop/property-image.php',array(
        'property_id'       => $args['property_id'],
        'image_size' => $args['image_size'],
        'image_size_default' => $args['image_size_default']
    ));

}


function ere_template_loop_property_featured_label($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }

    $property_badge = ere_get_loop_property_featured_label($args['property_id']);
    if ( empty( $property_badge ) ) {
        return;
    }

    ere_get_template('loop/property-badge.php', array(
        'badge' => $property_badge,
        'extra_classes' => 'ere__lpb-featured-label'
    ));

}

function ere_template_loop_property_term_status($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }

    $property_item_status = get_the_terms( $args['property_id'], 'property-status' );
    if ( $property_item_status === false || is_a( $property_item_status, 'WP_Error' ) ) {
        return;
    }

    ere_get_template('loop/property-term-status.php', array(
        'property_item_status' => $property_item_status
    ));

}

function ere_template_loop_property_featured($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }
    $property_featured = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_featured', true );
    if ( !filter_var($property_featured, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }
    ere_get_template('loop/property-featured.php');
}

function ere_template_loop_property_term_label($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }
    $property_term_label = get_the_terms( $args['property_id'], 'property-label' );
    if ( $property_term_label === false || is_a( $property_term_label, 'WP_Error' ) ) {
        return;
    }

    ere_get_template('loop/property-term-label.php', array(
        'property_term_label' => $property_term_label
    ));

}

function ere_template_loop_property_link($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-link.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_excerpt($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $excerpt            = get_the_excerpt($property_id);
    if (empty($excerpt)) {
        return;
    }
    ere_get_template( 'loop/property-excerpt.php', array(
        'excerpt'       => $excerpt,
    ));
}

function ere_template_loop_property_meta($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    ere_get_template( 'loop/property-meta.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_info($property_id = '', $layout = 'layout-1') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    ere_get_template( 'loop/property-info.php', array(
        'property_id'       => $property_id,
        'layout' => $layout
    ));
}

function ere_template_loop_property_info_layout_2($property_id = '') {
    ere_template_loop_property_info($property_id,'layout-2');
}

function ere_template_heading($args = array()) {
    $args = wp_parse_args($args, array(
            'heading_text_align' => '',
            'heading_title' => '',
            'heading_sub_title' => '',
            'color_scheme' => '',
            'extra_classes' => array()
        ));
    if (empty($args['heading_title']) && empty($args['heading_sub_title'])) {
        return;
    }
    ere_get_template('global/heading.php', $args);
}

function ere_template_loop_property_type($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-type.php', array(
        'property_id'       => $property_id,
    ));

}

function ere_template_loop_property_agent($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $agent_info = ere_get_agent_info_of_property($property_id);
    if ($agent_info === false) {
        return;
    }
    ere_get_template( 'loop/property-agent.php',$agent_info);

}

function ere_template_loop_property_date($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-date.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_size($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_size = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_size', true );
    if ( $property_size === '' ) {
        return;
    }
    $measurement_units = ere_get_measurement_units();
    ere_get_template( 'loop/property-size.php', array(
        'property_size'     => $property_size,
        'measurement_units' => $measurement_units
    ) );
}

function ere_template_loop_property_bedrooms($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $property_bedrooms = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_bedrooms', true );
    if ( $property_bedrooms === '' ) {
        return;
    }
    ere_get_template( 'loop/property-bedrooms.php', array( 'property_bedrooms' => $property_bedrooms ) );
}

function ere_template_loop_property_bathrooms($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $property_bathrooms = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_bathrooms', true );
    if ( $property_bathrooms === '' ) {
        return;
    }
    ere_get_template( 'loop/property-bathrooms.php', array( 'property_bathrooms' => $property_bathrooms ) );
}

function ere_template_loop_property_garages($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $property_garage = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_garage', true );
    if ( $property_garage === '' ) {
        return;
    }
    ere_get_template( 'loop/property-garage.php', array( 'property_garage' => $property_garage ) );
}

function ere_template_archive_property_action() {
    ere_get_template('archive-property/action.php');
}

function ere_template_archive_property_heading($total_post = 0, $taxonomy_title = '', $agent_id = 0, $author_id = 0 ) {
    ere_get_template( 'archive-property/heading.php', array(
        'total_post'     => $total_post,
        'taxonomy_title' => $taxonomy_title,
        'agent_id'       => $agent_id,
        'author_id'      => $author_id
    ) );
}

function ere_template_archive_property_action_status() {
    if (!(is_post_type_archive('property') || is_page('properties')) && !is_tax(get_object_taxonomies('property'))) {
        return;
    }
    ere_get_template('archive-property/actions/status.php');
}

function ere_template_archive_property_action_switch_layout() {
    ere_get_template('archive-property/actions/switch-layout.php');
}

function ere_template_archive_property_action_orderby() {
    ere_get_template('archive-property/actions/orderby.php');
}

function ere_template_property_advanced_search_form($parameters,$search_query) {
    $enable_advanced_search_form = ere_get_option( 'enable_advanced_search_form', '1' );
    if (!filter_var($enable_advanced_search_form, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }

    $property_price_field_layout = ere_get_option( 'advanced_search_price_field_layout', '0' );
    $property_size_field_layout  = ere_get_option( 'advanced_search_size_field_layout', '0' );
    $property_land_field_layout  = ere_get_option( 'advanced_search_land_field_layout', '0' );
    $shortcode_attr = array(
        'layout'                   => "tab",
        'column'                   => 3,
        'color_scheme'             => "color-dark",
        'status_enable'            => "true",
        'type_enable'              => "true",
        'keyword_enable'           => "true",
        'title_enable'             => "true",
        'address_enable'           => "true",
        'country_enable'           => "true",
        'state_enable'             => "true",
        'city_enable'              => "true",
        'neighborhood_enable'      => "true",
        'rooms_enable'             => "true",
        'bedrooms_enable'          => "true",
        'bathrooms_enable'         => "true",
        'price_enable'             => "true",
        'price_is_slider'          => ( $property_price_field_layout == '1' ) ? 'true' : 'false',
        'area_enable'              => "true",
        'area_is_slider'           => ( $property_size_field_layout == '1' ) ? 'true' : 'false',
        'land_area_enable'         => "true",
        'land_area_is_slider'      => ( $property_land_field_layout == '1' ) ? 'true' : 'false',
        'label_enable'             => "true",
        'garage_enable'            => "true",
        'property_identity_enable' => "true",
        'other_features_enable'    => "true",
    );
    $additional_fields      = ere_get_search_additional_fields();
    foreach ( $additional_fields as $k => $v ) {
        $shortcode_attr["{$k}_enable"] = "true";
    }
    $enable_saved_search = ere_get_option('enable_saved_search', 1);
    ere_get_template('property/advanced-search-form.php', array(
        'atts' => $shortcode_attr,
        'enable_saved_search' => $enable_saved_search,
        'parameters' => $parameters,
        'search_query' => $search_query
    ));
}



