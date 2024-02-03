<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function g5ere_vc_map_add_narrow_type( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '1', 'taxonomy' => 'property-type' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow Property Type', 'g5-ere' ),
		'param_name'  => 'property_type',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter property type by names to narrow output (Note: only listed property type will be displayed, divide property type with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}

function g5ere_vc_map_add_narrow_status( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '1', 'taxonomy' => 'property-status' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow Property Status', 'g5-ere' ),
		'param_name'  => 'property_status',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter property status by names to narrow output (Note: only listed property status will be displayed, divide property status with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}

function g5ere_vc_map_add_narrow_feature( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '1', 'taxonomy' => 'property-feature' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow Property Feature', 'g5-ere' ),
		'param_name'  => 'property_feature',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter property feature by names to narrow output (Note: only listed property feature will be displayed, divide property feature with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}

function g5ere_vc_map_add_narrow_label( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '1', 'taxonomy' => 'property-label' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow Property Label', 'g5-ere' ),
		'param_name'  => 'property_label',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter property label by names to narrow output (Note: only listed property label will be displayed, divide property label with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}

function g5ere_vc_map_add_narrow_state( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '1', 'taxonomy' => 'property-state' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow Province / State', 'g5-ere' ),
		'param_name'  => 'property_state',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter province / state by names to narrow output (Note: only listed province / state will be displayed, divide province / state with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}

function g5ere_vc_map_add_narrow_city( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '1', 'taxonomy' => 'property-city' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow City', 'g5-ere' ),
		'param_name'  => 'property_city',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter city by names to narrow output (Note: only listed city will be displayed, divide city with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}

function g5ere_vc_map_add_narrow_neighborhood( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '1', 'taxonomy' => 'property-neighborhood' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow Neighborhood', 'g5-ere' ),
		'param_name'  => 'property_neighborhood',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter neighborhood by names to narrow output (Note: only listed neighborhood will be displayed, divide neighborhood with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}

function g5ere_vc_map_add_filter() {
	return array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Show', 'g5-ere' ),
			'param_name' => 'show',
			'value'      => array(
				esc_html__( 'All', 'g5-ere' )             => '',
				esc_html__( 'Featured', 'g5-ere' )        => 'featured',
				esc_html__( 'New In', 'g5-ere' )          => 'new-in',
				esc_html__( 'Narrow Property', 'g5-ere' ) => 'property'
			),
			'std'        => '',
			'group'      => esc_html__( 'Property Filter', 'g5-ere' ),
		),
		g5ere_vc_map_add_narrow_type( array(
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'property' ) ),
			'group'            => esc_html__( 'Property Filter', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		) ),
		g5ere_vc_map_add_narrow_status( array(
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'property' ) ),
			'group'            => esc_html__( 'Property Filter', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		) ),
		g5ere_vc_map_add_narrow_feature( array(
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'property' ) ),
			'group'            => esc_html__( 'Property Filter', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		) ),
		g5ere_vc_map_add_narrow_label( array(
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'property' ) ),
			'group'            => esc_html__( 'Property Filter', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		) ),
		g5ere_vc_map_add_narrow_state( array(
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'property' ) ),
			'group'            => esc_html__( 'Property Filter', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		) ),
		g5ere_vc_map_add_narrow_city( array(
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'property' ) ),
			'group'            => esc_html__( 'Property Filter', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		) ),
		g5ere_vc_map_add_narrow_neighborhood( array(
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'property' ) ),
			'group'            => esc_html__( 'Property Filter', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		) ),
		array(
			'type'        => 'autocomplete',
			'heading'     => esc_html__( 'Narrow Property', 'g5-ere' ),
			'param_name'  => 'ids',
			'settings'    => array(
				'multiple'      => true,
				'sortable'      => true,
				'unique_values' => true,
			),
			'save_always' => true,
			'description' => esc_html__( 'Enter List of Property', 'g5-ere' ),
			'dependency'  => array( 'element' => 'show', 'value' => 'property' ),
			'group'       => esc_html__( 'Property Filter', 'g5-ere' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Sort by', 'g5-ere' ),
			'param_name'  => 'sorting',
			'value'       => array_flip( G5ERE()->settings()->get_property_sorting() ),
			'std'         => 'menu_order',
			'description' => esc_html__( 'Select how to sort retrieved property.', 'g5-ere' ),
			'dependency'  => array( 'element' => 'show', 'value' => array( '', 'featured' ) ),
			'group'       => esc_html__( 'Property Filter', 'g5-ere' ),
		),
	);
}

function g5ere_vc_map_agent_add_filter() {
	return array(
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Show', 'g5-ere' ),
			'param_name'       => 'show',
			'value'            => array(
				esc_html__( 'All', 'g5-ere' )          => '',
				esc_html__( 'New In', 'g5-ere' )       => 'new-in',
				esc_html__( 'Narrow Agent', 'g5-ere' ) => 'agent'
			),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'std'              => '',
			'group'            => esc_html__( 'Agent Filter', 'g5-ere' ),
		),
		g5ere_vc_map_add_narrow_agency( array(
			'group'      => esc_html__( 'Agent Filter', 'g5-ere' ),
			'dependency' => array( 'element' => 'show', 'value_not_equal_to' => array( 'agent' ) ),
		) ),

		array(
			'type'        => 'autocomplete',
			'heading'     => esc_html__( 'Narrow Agent', 'g5-ere' ),
			'param_name'  => 'ids',
			'settings'    => array(
				'multiple'      => true,
				'sortable'      => true,
				'unique_values' => true,
			),
			'save_always' => true,
			'description' => esc_html__( 'Enter List of Agent', 'g5-ere' ),
			'dependency'  => array( 'element' => 'show', 'value' => 'agent' ),
			'group'       => esc_html__( 'Agent Filter', 'g5-ere' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Sort by', 'g5-ere' ),
			'param_name'       => 'sorting',
			'value'            => array_flip( G5ERE()->settings()->get_agent_sorting() ),
			'std'              => 'menu_order',
			'description'      => esc_html__( 'Select how to sort retrieved agent.', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'group'            => esc_html__( 'Agent Filter', 'g5-ere' ),
			'dependency'       => array( 'element' => 'show', 'value_not_equal_to' => array( 'agent', 'new-in' ) ),
		),
	);
}

function g5ere_vc_map_agency_add_filter() {
	return array(
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Show', 'g5-ere' ),
			'param_name'       => 'show',
			'value'            => array(
				esc_html__( 'All', 'g5-ere' )           => '',
				esc_html__( 'Narrow Agency', 'g5-ere' ) => 'agency'
			),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'std'              => '',
			'group'            => esc_html__( 'Agency Filter', 'g5-ere' ),
		),
		g5ere_vc_map_add_narrow_agency( array(
			'group'      => esc_html__( 'Agency Filter', 'g5-ere' ),
			'dependency' => array( 'element' => 'show', 'value' => array( 'agency' ) ),
		) ),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Sort by', 'g5-ere' ),
			'param_name'       => 'sorting',
			'value'            => array_flip( G5ERE()->settings()->get_agency_sorting() ),
			'std'              => 'menu_order',
			'description'      => esc_html__( 'Select how to sort retrieved agency.', 'g5-ere' ),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'group'            => esc_html__( 'Agency Filter', 'g5-ere' ),
		),
	);
}


function g5ere_vc_map_add_narrow_agency( $args = array() ) {
	$category   = array();
	$categories = get_categories( array( 'hide_empty' => '0', 'taxonomy' => 'agency' ) );
	if ( is_array( $categories ) ) {
		foreach ( $categories as $cat ) {
			$category[ $cat->name ] = $cat->term_id;
		}
	}
	$default = array(
		'type'        => 'g5element_selectize',
		'heading'     => esc_html__( 'Narrow Agency', 'g5-ere' ),
		'param_name'  => 'agency',
		'value'       => $category,
		'multiple'    => true,
		'description' => esc_html__( 'Enter agency by names to narrow output (Note: only listed agency will be displayed, divide agency with linebreak (Enter)).', 'g5-ere' ),
		'std'         => ''
	);
	$default = array_merge( $default, $args );

	return $default;
}