<?php
function g5ere_get_dashboard_menu() {
	$user_id           = get_current_user_id();
	$menus             = array();
	$ere_property      = new ERE_Property();
	$total_properties  = $ere_property->get_total_my_properties( array( 'publish', 'pending', 'expired', 'hidden' ) );
	$ere_invoice       = new ERE_Invoice();
	$total_invoices    = $ere_invoice->get_total_my_invoice();
	$total_favorite    = $ere_property->get_total_favorite();
	$ere_save_search   = new ERE_Save_Search();
	$total_save_search = $ere_save_search->get_total_save_search();
	$allow_submit      = ere_allow_submit();
	$number_reviews    = g5ere_get_user_comments_count( $user_id );
	if ( ere_get_permalink( 'dashboard' ) ) {
		$menus[] = array(
			'priority' => 10,
			'label'    => esc_html__( 'Dashboards', 'g5-ere' ),
			'url'      => ere_get_permalink( 'dashboard' ),
			'icon'     => '<i class="fal fa-tachometer-alt"></i>',
			'number'   => false,
			'cat'      => 'main'
		);
	}

	if ( ere_get_permalink( 'my_properties' ) ) {
		$menus[] = array(
			'priority' => 20,
			'label'    => esc_html__( 'My Properties', 'g5-ere' ),
			'url'      => ere_get_permalink( 'my_properties' ),
			'icon'     => '<i class="fal fa-list-alt"></i>',
			'number'   => $total_properties,
			'cat'      => 'manage_listing'
		);
	}

	$paid_submission_type = ere_get_option( 'paid_submission_type', 'no' );
	if ( $paid_submission_type != 'no' && ere_get_permalink( 'my_invoices' ) ) {
		$menus[] = array(
			'priority' => 30,
			'label'    => esc_html__( 'My Invoices', 'g5-ere' ),
			'url'      => ere_get_permalink( 'my_invoices' ),
			'icon'     => '<i class="fal fa-file-invoice"></i>',
			'number'   => $total_invoices,
			'cat'      => 'manage_listing'
		);
	}
	$enable_favorite = ere_get_option( 'enable_favorite_property', 1 );
	if ( $enable_favorite == 1 && ere_get_permalink( 'my_favorites' ) ) {
		$menus[] = array(
			'priority' => 40,
			'label'    => esc_html__( 'My Favorites', 'g5-ere' ),
			'url'      => ere_get_permalink( 'my_favorites' ),
			'icon'     => '<i class="fal fa-heart"></i>',
			'number'   => $total_favorite,
			'cat'      => 'manage_listing'
		);
	}
	$enable_saved_search = ere_get_option( 'enable_saved_search', 1 );
	if ( $enable_saved_search == 1 && ere_get_permalink( 'my_save_search' ) ) {
		$menus[] = array(
			'priority' => 50,
			'label'    => esc_html__( 'My Saved Searches', 'g5-ere' ),
			'url'      => ere_get_permalink( 'my_save_search' ),
			'icon'     => '<i class="fal fa-search"></i>',
			'number'   => $total_save_search,
			'cat'      => 'manage_listing'
		);
	}
	if ( ere_get_permalink( 'review' ) ) {
		$menus[] = array(
			'priority' => 60,
			'label'    => esc_html__( 'Reviews', 'g5-ere' ),
			'url'      => ere_get_permalink( 'review' ),
			'icon'     => '<i class="fal fa-comment-dots"></i>',
			'number'   => $number_reviews,
			'cat'      => 'manage_listing'
		);
	}

	if ( $allow_submit && ere_get_permalink( 'submit_property' ) ) {
		$menus[] = array(
			'priority' => 70,
			'label'    => esc_html__( 'Submit New Property', 'g5-ere' ),
			'url'      => ere_get_permalink( 'submit_property' ),
			'icon'     => '<i class="fal fa-folder-plus"></i>',
			'number'   => false,
			'cat'      => 'manage_listing'
		);
	}
	if ( ere_get_permalink( 'my_profile' ) ) {
		$menus[] = array(
			'priority' => 80,
			'label'    => esc_html__( 'My Profile', 'g5-ere' ),
			'url'      => ere_get_permalink( 'my_profile' ),
			'icon'     => '<i class="fal fa-user"></i>',
			'number'   => false,
			'cat'      => 'manage_account'
		);
	}
	$menus[] = array(
		'priority' => 80,
		'label'    => esc_html__( 'Logout', 'g5-ere' ),
		'url'      => wp_logout_url( home_url() ),
		'icon'     => '<i class="fal fa-sign-out"></i>',
		'number'   => false,
		'cat'      => 'manage_account'
	);

	$menus = apply_filters( 'g5ere_dashboard_menu', $menus );

	uasort( $menus, 'g5ere_sort_by_order_callback' );




	return $menus;
}

function g5ere_get_category_dashboard_menu() {

	return apply_filters( 'g5ere_dashboard_menu_category', array(
		'main'           => esc_html__( 'Main', 'g5-ere' ),
		'manage_listing' => esc_html__( 'Manage Listing', 'g5-ere' ),
		'manage_account' => esc_html__( 'Manage Account', 'g5-ere' )
	) );
}

function g5ere_redirect_url_is_login($redirect_url) {
	$dashboard_url = ere_get_permalink('dashboard');
	if ($redirect_url !== false) {
		$redirect_url = $dashboard_url;
	}
	return $redirect_url;
}
add_filter('ere_redirect_url_is_login','g5ere_redirect_url_is_login');
