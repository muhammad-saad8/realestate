<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function homeid_the_breadcrumbs() {
	$html_markup = '';
	// Add home link
	$html_markup .= homeid_get_breadcrumb_home();

	// Woocommerce path prefix
	if (class_exists('WooCommerce') && ((is_woocommerce() && is_archive() && !is_shop()) || is_cart() || is_checkout() || is_account_page())) {
		$html_markup .= homeid_get_woocommerce_shop_page();
	}

	if (is_singular()) {
		$post = get_post(get_queried_object_id());
		// display archive link for post type
		if (isset($post->post_type) && get_post_type_archive_link($post->post_type)) {
			$html_markup .= homeid_get_post_type_archive();
		}

		$html_markup .= homeid_get_breadcrumb_leaf_markup();
	} else {
		// Blog page is a dedicated page.
		if ( is_home() && ! is_front_page() ) {
			$posts_page         = get_option( 'page_for_posts' );
			$posts_page_title   = get_the_title( $posts_page );
			$html_markup .= homeid_get_single_breadcrumb_markup( $posts_page_title );
		}

		// Custom post types archives.
		if ( is_post_type_archive() ) {
			$html_markup .= homeid_get_post_type_archive( false );

			// Search on custom post type (e.g. Woocommerce).
			if ( is_search() ) {
				$html_markup .= homeid_get_breadcrumb_leaf_markup( 'search' );
			}
		} // Taxonomy Archives.
		elseif ( is_tax() || is_tag() || is_category() ) {
			if ( is_tag() ) { // If we have a tag archive, add the tag prefix.
				$html_markup .= esc_html__('Tag:','homeid');
			}
			$html_markup .= homeid_get_taxonomies();
			$html_markup .= homeid_get_breadcrumb_leaf_markup( 'term' );
		} // Date Archives.
		elseif ( is_date() ) {
			global $wp_locale;
			// Set variables.
			$year = get_the_date('Y');
			// Year Archive, only is a leaf.
			if ( is_year() ) {
				$html_markup .= homeid_get_breadcrumb_leaf_markup( 'year' );
			} // Month Archive, needs year link and month leaf.
			elseif ( is_month() ) {
				$html_markup .= homeid_get_single_breadcrumb_markup( $year, get_year_link( $year ) );
				$html_markup .= homeid_get_breadcrumb_leaf_markup( 'month' );
			} // Day Archive, needs year and month link and day leaf.
			elseif ( is_day() ) {
				$month      = get_the_date('m');
				$month_name = $wp_locale->get_month( $month );
				$html_markup .= homeid_get_single_breadcrumb_markup( $year, get_year_link( $year ) );
				$html_markup .= homeid_get_single_breadcrumb_markup( $month_name, get_month_link( $year, $month ) );
				$html_markup .= homeid_get_single_breadcrumb_markup( 'day' );
			}
		} // Author Archives.
		elseif ( is_author() ) {
			$html_markup .= homeid_get_breadcrumb_leaf_markup( 'author' );
		} // Search Page.
		elseif ( is_search() ) {
			$html_markup .= homeid_get_breadcrumb_leaf_markup( 'search' );
		} // 404 Page.
		elseif ( is_404() ) {
			$html_markup .= homeid_get_breadcrumb_leaf_markup( '404' );
		}
	}
	if ($html_markup) {
		$html_markup = '<ul class="breadcrumbs d-flex flex-wrap">' . $html_markup . '</ul>';
	}

	echo wp_kses_post($html_markup);
}

function homeid_get_breadcrumb_home() {
	if (!is_front_page()) {
		$output = homeid_get_single_breadcrumb_markup(esc_html__('Home','homeid'), get_home_url('/'));;
	} else {
		$output = homeid_get_single_breadcrumb_markup(esc_html__('Blog','homeid'));
	}
	return $output;
}

function homeid_get_single_breadcrumb_markup($title, $link = '', $separator = true, $micro_data = true)
{
	$micro_data_item_scope = $micro_data_url = $micro_data_title = $separator_markup = '';
	if ($micro_data) {
		$micro_data_item_scope = 'itemscope itemtype="http://data-vocabulary.org/Breadcrumb"';
		$micro_data_url = 'itemprop="url"';
		$micro_data_title = 'itemprop="title"';
	}

	$breadcrumb_content = '<span ' . $micro_data_title . '>' . $title . '</span>';
	if ($link) {
		$breadcrumb_content = '<a ' . $micro_data_url . ' href="' . esc_url($link) . '">' . $breadcrumb_content . '</a>';
	}

	if ($separator) {
		$separator_markup = '<li class="breadcrumb-sep">/</li>';
	}

	$output = '<li ' . $micro_data_item_scope . '>' . $breadcrumb_content . '</li>' . $separator_markup;
	return $output;
}

function homeid_get_woocommerce_shop_page($linked = true) {
	$post_type = 'product';
	$post_type_object = get_post_type_object($post_type);
	$shop_page_markup = '';
	$link = '';
	if (isset($post_type_object) && class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
		// Get shop page id and then its name.
		$shop_page_name = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';

		// Use the archive name if no shop page was set.
		if (!$shop_page_name) {
			$shop_page_name = $post_type_object->labels->name;
		}

		// Check if the breadcrumb should be linked.
		if ($linked) {
			$link = get_post_type_archive_link($post_type);
		}

		$shop_page_markup = homeid_get_single_breadcrumb_markup($shop_page_name, $link);
	}

	return $shop_page_markup;
}

function homeid_get_post_type_archive($linked = true) {
	global $wp_query;
	$post_type = $wp_query->query_vars['post_type'];
	if (!$post_type) {
		$post_type = get_post_type();
	}

	$post_type_object = get_post_type_object($post_type);
	if (!is_object($post_type_object)) return '';

	// Woocommerce
	if (($post_type === 'product') && class_exists('WooCommerce')) {
		$woocommerce_shop_page = homeid_get_woocommerce_shop_page($linked);
		return $woocommerce_shop_page;
	}


	$archive_title = $post_type_object->name;
	if (isset($post_type_object->label) && !empty($post_type_object->label)) {
		$archive_title = $post_type_object->label;
	} elseif (isset($post_type_object->labels->menu_name) && !empty($post_type_object->labels->menu_name)) {
		$archive_title = $post_type_object->labels->menu_name;
	}


	$link = '';
	if ($linked) {
		$link = get_post_type_archive_link($post_type);
	}
	if ($post_type === 'post') {
		$archive_title = esc_html__( 'Blog', 'homeid' );
	}

	if (trailingslashit($link) === trailingslashit(home_url('/'))) {
		return '';
	}

	return homeid_get_single_breadcrumb_markup($archive_title, $link);
}

function homeid_get_breadcrumb_leaf_markup($object_type = '') {
	global $wp_query, $wp_locale;
	$post = get_post(get_queried_object_id());
	switch ( $object_type ) {
		case 'term':
			$term  = $wp_query->get_queried_object();
			$title = $term->name;
			break;
		case 'year':
			$title = esc_html( get_the_date('Y') );
			break;
		case 'month':
			$title = $wp_locale->get_month( get_the_date('m') );
			break;
		case 'day':
			$title = get_the_date('d');
			break;
		case 'author':
			$user  = $wp_query->get_queried_object();
			$title = $user->display_name;
			break;
		case 'search':
			$title = esc_html__('Search:','homeid') . ' ' . esc_html( get_search_query() );
			break;
		case '404':
			$title = esc_html__('Page Not Found','homeid');
			break;
		default:
			$title = get_the_title( $post->ID );
			break;
	}

	return '<li class="breadcrumb-leaf">' . $title . '</li>';
}

function homeid_get_taxonomies() {
	global $wp_query;
	$term = $wp_query->get_queried_object();
	$terms_markup = '';

	// Make sure we have hierarchical taxonomy and parents.
	if ( 0 != $term->parent && is_taxonomy_hierarchical( $term->taxonomy ) ) {
		$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
		$term_ancestors = array_reverse( $term_ancestors );
		// Loop through ancestors to get the full tree.
		foreach ( $term_ancestors as $term_ancestor ) {
			$term_object   = get_term( $term_ancestor, $term->taxonomy );
			$terms_markup .= homeid_get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
		}
	}

	return $terms_markup;
}