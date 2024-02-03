<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
function g5ere_get_property_switch_layout() {
	$property_layout = G5ERE()->options()->get_option( 'post_layout' );

	return isset( $_REQUEST['view'] ) ? $_REQUEST['view'] : $property_layout;
}

function g5ere_get_property_attributes() {
	$attributes   = array();
	$attributes[] = sprintf( 'data-id="%s"', esc_attr( get_the_ID() ) );
	$attributes[] = sprintf( 'data-location="%s"', esc_attr( json_encode( g5ere_get_property_data_location_attributes() ) ) );

	return apply_filters( 'g5ere_property_loop_attributes', $attributes );
}

function g5ere_get_property_location() {
	$property_location = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_location', true );
	if ( is_array( $property_location ) && isset( $property_location['location'] ) && ! empty( $property_location['location'] ) ) {
		$property_location = explode( ',', $property_location['location'] );

		return array(
			'lat' => $property_location[0],
			'lng' => $property_location[1]
		);
	}

	return false;
}

function g5ere_get_property_data_location_attributes() {
	$location = g5ere_get_property_location();
	if ( $location ) {
		$thumb      = get_the_post_thumbnail_url( get_the_ID() );
		$address    = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_address', true );
		$marker     = g5ere_get_property_map_marker( get_the_ID() );
		$attributes = array(
			'id'       => get_the_ID(),
			'title'    => get_the_title(),
			'position' => $location,
			'url'      => get_the_permalink(),
			'thumb'    => $thumb,
			'marker'   => $marker,
			'address'  => $address
		);

		return apply_filters( 'g5ere_property_data_attributes', $attributes);
	}

	return false;
}

function g5ere_get_property_map_marker( $id ) {
	$categories     = get_the_terms( $id, 'property-type' );
	$first_category = $categories ? $categories[0] : false;
	$marker         = false;
	$marker_html    = '';
	if ( $first_category ) {
		$marker_type = get_term_meta( $first_category->term_id, G5ERE()->meta_prefix . 'marker_type', true );
		if ( $marker_type === 'icon' ) {
			$marker_icon = get_term_meta( $first_category->term_id, G5ERE()->meta_prefix . 'marker_icon', true );
			if ( ! empty( $marker_icon ) ) {
				$marker_html = sprintf( '<i class="%s"></i>', esc_attr( $marker_icon ) );
			}
		} else if ( $marker_type === 'image' ) {
			$marker_image = get_term_meta( $first_category->term_id, G5ERE()->meta_prefix . 'marker_image', true );
			if ( is_array( $marker_image ) && isset( $marker_image['url'] ) && ! empty( $marker_image['url'] ) ) {
				$marker_html = sprintf( '<img src="%s" />', esc_url( $marker_image['url'] ) );
			}
		}
		if ( $marker_html !== '' ) {
			$marker = array(
				'type' => $marker_type,
				'html' => $marker_html
			);
		}
	}

	return apply_filters('g5ere_property_map_marker',$marker,$id) ;
}

if ( ! function_exists( 'g5ere_hirarchical_options' ) ) {
	function g5ere_hirarchical_options( $taxonomy_name, $taxonomy_terms, $searched_term, $prefix = " " ) {
		if ( ! empty( $taxonomy_terms ) && taxonomy_exists( $taxonomy_name ) ) {
			foreach ( $taxonomy_terms as $term ) {

				if ( in_array( $taxonomy_name, array( 'property-neighborhood', 'property-city', 'property-state' ) ) ) {
					$parent_slug = '';
					$parent_name = '';
					if ( in_array( $taxonomy_name, array( 'property-neighborhood', 'property-city' ) ) ) {
						$parent_id       = '';
						$parent_taxonomy = '';
						switch ( $taxonomy_name ) {
							case 'property-neighborhood':
								$parent_id       = get_term_meta( $term->term_id, 'property_neighborhood_city', true );
								$parent_taxonomy = 'property-city';
								break;
							case 'property-city':
								$parent_id       = get_term_meta( $term->term_id, 'property_city_state', true );
								$parent_taxonomy = 'property-state';
								break;
						}

						if ( $parent_id !== '' ) {
							$parent_term = get_term( $parent_id, $parent_taxonomy );
							if ( is_a( $parent_term, 'WP_Term' ) ) {
								$parent_slug = $parent_term->slug;
								$parent_name = $parent_term->name;
							}
						}
					} else {
						$parent_slug = get_term_meta( $term->term_id, 'property_state_country', true );
						$parent_name = ere_get_country_by_code( $parent_slug );
					}

					echo '<option data-belong="' . esc_attr( $parent_slug ) . '" data-subtext="' . esc_attr( $parent_name ) . '" value="' . esc_attr( $term->slug ) . '"' . selected( $term->slug, $searched_term, false ) . '>' . $prefix . $term->name . '</option>';
				} else {
					echo '<option value="' . esc_attr( $term->slug ) . '"' . selected( $term->slug, $searched_term, false ) . '>' . $prefix . $term->name . '</option>';
				}

				$child_terms = get_terms( $taxonomy_name, array(
					'hide_empty' => false,
					'parent'     => $term->term_id
				) );

				if ( ! empty( $child_terms ) ) {
					g5ere_hirarchical_options( $taxonomy_name, $child_terms, $searched_term, "- " . $prefix );
				}
			}
		}
	}
}

if ( ! function_exists( 'g5ere_hirarchical_options_data' ) ) {
	function g5ere_hirarchical_options_data( $taxonomy_name, $taxonomy_terms, $prefix = " " ) {
		$data = [];
		if ( ! empty( $taxonomy_terms ) && taxonomy_exists( $taxonomy_name ) ) {
			foreach ( $taxonomy_terms as $term ) {

				if ( in_array( $taxonomy_name, array( 'property-neighborhood', 'property-city', 'property-state' ) ) ) {
					$parent_slug = '';
					$parent_name = '';
					if ( in_array( $taxonomy_name, array( 'property-neighborhood', 'property-city' ) ) ) {
						$parent_id       = '';
						$parent_taxonomy = '';
						switch ( $taxonomy_name ) {
							case 'property-neighborhood':
								$parent_id       = get_term_meta( $term->term_id, 'property_neighborhood_city', true );
								$parent_taxonomy = 'property-city';
								break;
							case 'property-city':
								$parent_id       = get_term_meta( $term->term_id, 'property_city_state', true );
								$parent_taxonomy = 'property-state';
								break;
						}

						if ( $parent_id !== '' ) {
							$parent_term = get_term( $parent_id, $parent_taxonomy );
							if ( is_a( $parent_term, 'WP_Term' ) ) {
								$parent_slug = $parent_term->slug;
								$parent_name = $parent_term->name;
							}
						}
					} else {
						$parent_slug = get_term_meta( $term->term_id, 'property_state_country', true );
						$parent_name = ere_get_country_by_code( $parent_slug );
					}
					$data[] = [
						'value' => $term->slug,
						'label' => $prefix . $term->name,
						'belong' => $parent_slug,
						'subtext' => $parent_name
					];
				}

				$child_terms = get_terms( $taxonomy_name, array(
					'hide_empty' => false,
					'parent'     => $term->term_id
				) );

				if ( ! empty( $child_terms ) ) {
					$child_data =  g5ere_hirarchical_options_data( $taxonomy_name, $child_terms, "- " . $prefix );
					if (!empty($child_data)) {
						$data = array_merge($child_data,$data);
					}
				}
			}
		}
		return $data;
	}
}


function g5ere_get_property_thumbnail_data( $args = array() ) {
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
		'title'           => g5core_the_title_attribute( array( 'post' => $args['post'], 'echo' => false ) ),
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

	$placeholder = $args['placeholder'] !== '' ? $args['placeholder'] : G5ERE()->options()->get_option( 'property_placeholder_enable' );
	if ( $placeholder === 'on' ) {
		$placeholder_img    = G5ERE()->options()->get_option( 'property_placeholder_image' );
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

function g5ere_render_property_thumbnail_markup( $args = array() ) {
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

	$placeholder = $args['placeholder'] !== '' ? $args['placeholder'] : G5ERE()->options()->get_option( 'property_placeholder_enable', 'on' );
	if ( $placeholder === 'on' ) {
		$args['placeholder']    = 'on';
		$placeholder_img        = G5ERE()->options()->get_option( 'property_placeholder_image' );
		$placeholder_img_id     = isset( $placeholder_img['id'] ) ? $placeholder_img['id'] : '';
		$args['placeholder_id'] = $placeholder_img_id;
	}
	g5ere_render_thumbnail_markup( $args );
}


function g5ere_render_thumbnail_markup( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'image_size'         => 'thumbnail',
		'image_ratio'        => '',
		'image_id'           => get_post_thumbnail_id(),
		'animated_thumbnail' => true,
		'display_permalink'  => true,
		'permalink'          => '',
		'image_mode'         => '',
		'placeholder'        => '',
		'placeholder_id'     => '',
		'placeholder_url'    => G5ERE()->plugin_url( 'assets/images/placeholder.png' ),
		'post'               => null,
	) );

	$image_data = g5core_get_image_data( array(
		'image_id'           => $args['image_id'],
		'image_size'         => $args['image_size'],
		'animated_thumbnail' => $args['animated_thumbnail']
	) );

	if ( $image_data === false ) {
		$image_data = array( 'url' => '' );
	}

	if ( ( empty( $image_data['url'] ) ) && ( $args['placeholder'] === 'on' ) ) {
		if ( ! empty( $args['placeholder_id'] ) ) {
			$image_data = g5core_get_image_data( array(
				'image_id'           => $args['placeholder_id'],
				'image_size'         => $args['image_size'],
				'animated_thumbnail' => $args['animated_thumbnail']
			) );
		}

		if ( ( empty( $image_data['url'] ) ) && ( ! empty( $args['placeholder_url'] ) ) ) {
			$image_data['url']  = $args['placeholder_url'];
			$args['image_mode'] = '';
		}
	}


	if ( empty( $image_data['url'] ) ) {
		$args['image_mode'] = '';
	}


	$link = g5core_get_permalink();
	if ( $args['display_permalink'] ) {
		if ( $args['permalink'] !== '' ) {
			$link = $args['permalink'];
		}
	}

	$is_lazy_load = g5ere_lazy_load_is_active();


	ob_start();
	if ( $args['image_mode'] !== 'image' ) {
		$attributes        = array();
		$attributes_styles = array();

		if ( ! empty( $image_data['title'] ) && $args['display_permalink'] ) {
			$attributes[] = sprintf( 'title="%s"', esc_attr( $image_data['title'] ) );
		}

		$classes = array(
			'g5core__entry-thumbnail',
			'g5core__embed-responsive',
		);
		if ( empty( $args['image_ratio'] ) ) {
			if ( preg_match( '/x/', $args['image_size'] ) || ( $args['image_size'] === 'full' ) ) {
				if ( ! isset( $image_data['width'] ) && ! isset( $image_data['height'] ) ) {
					$image_sizes  = preg_split( '/x/', $args['image_size'] );
					$image_width  = isset( $image_sizes[0] ) ? intval( $image_sizes[0] ) : 0;
					$image_height = isset( $image_sizes[1] ) ? intval( $image_sizes[1] ) : 0;
				} else {
					$image_width  = $image_data['width'];
					$image_height = $image_data['height'];
				}


				if ( ( $image_width > 0 ) && ( $image_height > 0 ) ) {
					$ratio               = ( $image_height / $image_width ) * 100;
					$attributes_styles[] = sprintf( '--g5core-image-ratio : %s;', $ratio . '%' );
				}
			} else {
				$classes[] = "g5core__image-size-{$args['image_size']}";
			}
		} else {
			$classes[] = "g5core__image-size-{$args['image_ratio']}";

			if ( ! in_array( $args['image_ratio'], array( '1x1', '3x4', '4x3', '16x9', '9x16' ) ) ) {

				$image_ratio_sizes  = preg_split( '/x/', $args['image_ratio'] );
				$image_ratio_width  = isset( $image_ratio_sizes[0] ) ? intval( $image_ratio_sizes[0] ) : 0;
				$image_ratio_height = isset( $image_ratio_sizes[1] ) ? intval( $image_ratio_sizes[1] ) : 0;

				if ( ( $image_ratio_width > 0 ) && ( $image_ratio_height > 0 ) ) {
					$ratio               = ( $image_ratio_height / $image_ratio_width ) * 100;
					$attributes_styles[] = sprintf( '--g5core-image-ratio : %s;', $ratio . '%' );
				}
			}
		}


		if ( ! empty( $image_data['url'] ) ) {
			if ( $is_lazy_load ) {
				$attributes[] = sprintf( 'data-bg="%s"', esc_url( $image_data['url'] ) );
				$classes[]    = 'g5core__ll-background';
			} else {
				$attributes_styles[] = sprintf( 'background-image: url(%s)', esc_url( $image_data['url'] ) );
			}
		}

		$attributes[] = sprintf( 'style="%s"', join( ';', $attributes_styles ) );

		$attributes[] = sprintf( 'class="%s"', join( ' ', $classes ) );

		$attributes = apply_filters('g5ere_thumbnail_markup_attributes', $attributes, $args);

		if ( $args['display_permalink'] ) {
			?>
            <a <?php echo join( ' ', $attributes ) ?> href="<?php echo esc_url( $link ) ?>">
            </a>
			<?php
		} else {
			?>
            <div <?php echo join( ' ', $attributes ) ?>></div>
			<?php

		}
	} else {

		$attributes = array(
			'alt'    => $image_data['alt'],
			'width'  => $image_data['width'],
			'height' => $image_data['height'],
			'src'    => $image_data['url']
		);

		if ( $is_lazy_load ) {
			$attributes['class']    = 'g5core__ll-image';
			$attributes['src']      = G5CORE()->plugin_url( 'assets/images/placeholder-transparent.png' );
			$attributes['data-src'] = $image_data['url'];
		}

		$image_html = g5core_build_img_tag( $attributes );

		if ( $is_lazy_load ) {
			$image_html = g5core_build_lazy_img_tag( $image_html, $attributes['width'], $attributes['height'] );
		}


		if ( $args['display_permalink'] ) {
			$link_attributes = apply_filters('g5ere_thumbnail_markup_attributes', array(), $args);
			?>
            <a <?php echo join( ' ', $link_attributes ) ?> class="g5core__entry-thumbnail g5core__entry-thumbnail-image"
               href="<?php echo esc_url( $link ) ?>">
	            <?php echo $image_html; ?>
            </a>
			<?php
		} else {
			?>
            <div class="g5core__entry-thumbnail g5core__entry-thumbnail-image">
                <?php echo $image_html; ?>
            </div>
			<?php

		}
	}
	echo ob_get_clean();
}

function g5ere_render_single_thumbnail_markup( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'image_size'        => 'thumbnail',
		'image_ratio'       => '',
		'image_id'          => '',
		'image_mode'        => '',
		'display_permalink' => false,
		'gallery_id'        => ''
	) );

	if ( empty( $args['image_id'] ) ) {
		$args['image_id'] = get_post_thumbnail_id();
	}
	echo '<div class="g5core__post-featured">';

	g5ere_render_thumbnail_markup( $args );

	$image_full_url = '';
	if ( ! empty( $args['image_id'] ) ) {
		$image_full = wp_get_attachment_image_src( $args['image_id'], 'full' );
		if ( is_array( $image_full ) && isset( $image_full[0] ) ) {
			$image_full_url = $image_full[0];

		}
	}

	$zoom_attributes = array();
	if ( ! empty( $args['gallery_id'] ) ) {
		$zoom_attributes[] = sprintf( 'data-gallery-id="%s"', esc_attr( $args['gallery_id'] ) );
	}
	$zoom_attributes[] = sprintf( 'href="%s"', esc_url( $image_full_url ) );

	if ( ! empty( $image_full_url ) ) {
		?>
        <a data-g5core-mfp <?php echo join( ' ', $zoom_attributes ) ?> class="g5core__zoom-image"><i
                    class="fas fa-expand"></i></a>
		<?php
	}
	echo '</div>';
}

function g5ere_get_loop_property_meta() {
	$meta = array();

	$meta['bedrooms'] = array(
		'title'    => esc_html__( 'Bedrooms', 'g5-ere' ),
		'priority' => 10,
		'callback' => 'g5ere_template_loop_property_bedrooms',
		'icon'     => g5ere_get_icon_svg( 'bed' )
	);


	$meta['bathrooms'] = array(
		'title'    => esc_html__( 'Bathrooms', 'g5-ere' ),
		'priority' => 20,
		'callback' => 'g5ere_template_loop_property_bathrooms',
		'icon'     => g5ere_get_icon_svg( 'bath' )
	);

	$meta['size'] = array(
		'title'    => esc_html__( 'Size', 'g5-ere' ),
		'priority' => 30,
		'callback' => 'g5ere_template_loop_property_size',
		'icon'     => g5ere_get_icon_svg( 'house-plan' )
	);

	/*	$meta['garage'] = array(
			'title' => esc_html__('Garages','g5-ere'),
			'priority' => 40,
			'callback' => 'g5ere_template_loop_property_garage',
			'icon' => g5ere_get_icon_svg('car')
		);*/

	$meta = apply_filters( 'g5ere_loop_property_meta', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );

}

function g5ere_get_loop_property_badge() {
	$meta = array();

	$meta['featured'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_property_featured',
	);

	$meta['status'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_property_term_status',
	);

	$meta['label'] = array(
		'priority' => 30,
		'callback' => 'g5ere_template_loop_property_term_label',
	);


	$meta = apply_filters( 'g5ere_loop_property_badge', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}


function g5ere_get_loop_property_featured_label() {
	$meta = array();

	$meta['featured'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_property_featured',
	);

	$meta['label'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_property_term_label',
	);


	$meta = apply_filters( 'g5ere_loop_property_featured_label', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_loop_property_featured_status() {
	$meta = array();

	$meta['featured'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_property_featured',
	);

	$meta['status'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_property_term_status',
	);


	$meta = apply_filters( 'g5ere_loop_property_featured_status', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}


function g5ere_get_loop_property_featured() {
	$meta = array();

	$meta['featured'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_property_featured',
	);


	$meta = apply_filters( 'g5ere_loop_property_featured', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_single_property_meta() {
	$meta = array();

	$meta['featured-status'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_property_featured_status',
	);

	$meta['date'] = array(
		'priority' => 30,
		'callback' => 'g5ere_template_loop_property_date',
	);

	$meta['view'] = array(
		'priority' => 40,
		'callback' => 'g5ere_template_loop_property_view_count'
	);


	$meta = apply_filters( 'g5ere_single_property_meta', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_single_property_actions() {
	$meta = array();

	$meta['favorite'] = array(
		'priority' => 10,
		'callback' => 'g5ere_template_loop_property_action_favorite',
	);

	$meta['compare'] = array(
		'priority' => 20,
		'callback' => 'g5ere_template_loop_property_action_compare',
	);

	$meta['share'] = array(
		'priority' => 30,
		'callback' => 'g5ere_template_single_property_share'
	);

	$meta['print'] = array(
		'priority' => 40,
		'callback' => 'g5ere_template_single_property_print'
	);

	$meta = apply_filters( 'g5ere_single_property_actions', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_single_property_tabs_content_blocks() {
	$defaults = G5ERE()->settings()->get_single_property_tabs_content_blocks();
	$content_blocks = G5ERE()->options()->get_option( 'single_property_tabs_content_blocks', $defaults);
	if ( ! is_array( $content_blocks ) ) {
		return false;
	}
	foreach ( $content_blocks as $key => $value ) {
		unset( $content_blocks[ $key ]['__no_value__'] );
	}

	if ( ! isset( $content_blocks['enable'] ) || empty( $content_blocks['enable'] ) ) {
		return false;
	}

	$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
	if ( in_array( $single_property_layout, array( 'layout-1', 'layout-2', 'layout-6', 'layout-7' ) ) ) {
		unset( $content_blocks['enable']['description'] );
	}

	if ( in_array( $single_property_layout, array( 'layout-7' ) ) ) {
		unset( $content_blocks['enable']['gallery'] );
	}

	foreach ($content_blocks['enable'] as $k => $v) {
		$content_blocks['enable'][$k] = isset($defaults['enable'][$k]) ? $defaults['enable'][$k] : (isset($defaults['disable'][$k]) ? $defaults['disable'][$k] : $content_blocks['enable'][$k]);
	}


	return $content_blocks['enable'];

}

function g5ere_get_single_property_content_blocks() {
	$single_property_layout = G5ERE()->options()->get_option( 'single_property_layout', 'layout-1' );
	$content_blocks         = G5ERE()->options()->get_option( 'single_property_content_blocks', G5ERE()->settings()->get_single_property_content_blocks() );
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
		$tabs_content_blocks = g5ere_get_single_property_tabs_content_blocks();
		if ( is_array( $tabs_content_blocks ) ) {
			foreach ( $tabs_content_blocks as $key => $value ) {
				if ( isset( $content_blocks['enable'][ $key ] ) ) {
					unset( $content_blocks['enable'][ $key ] );
				}
			}
		}
	}

	if ( in_array( $single_property_layout, array( 'layout-1', 'layout-2', 'layout-6', 'layout-7' ) ) ) {
		unset( $content_blocks['enable']['description'] );
	}

	if ( in_array( $single_property_layout, array( 'layout-7' ) ) ) {
		unset( $content_blocks['enable']['gallery'] );
	}


	return $content_blocks['enable'];
}

function g5ere_get_single_property_block_address_data() {
	$meta = array();

	$property_address = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_address', true );
	if ( ! empty( $property_address ) ) {
		$meta['address'] = array(
			'priority' => 10,
			'label'    => esc_html__( 'Address', 'g5-ere' ),
			'content'  => $property_address
		);
	}

	$property_country = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_country', true );
	if ( ! empty( $property_country ) ) {
		$property_country = ere_get_country_by_code( $property_country );
		$meta['country']  = array(
			'priority' => 20,
			'label'    => esc_html__( 'Country', 'g5-ere' ),
			'content'  => $property_country
		);
	}

	$property_state = get_the_term_list( get_the_ID(), 'property-state', '', ', ', '' );
	if ( ! empty( $property_state ) ) {
		$meta['state'] = array(
			'priority' => 30,
			'label'    => esc_html__( 'Province/State', 'g5-ere' ),
			'content'  => $property_state
		);
	}


	$property_city = get_the_term_list( get_the_ID(), 'property-city', '', ', ', '' );
	if ( ! empty( $property_city ) ) {
		$meta['city'] = array(
			'priority' => 40,
			'label'    => esc_html__( 'City/Town', 'g5-ere' ),
			'content'  => $property_city
		);
	}

	$property_neighborhood = get_the_term_list( get_the_ID(), 'property-neighborhood', '', ', ', '' );
	if ( ! empty( $property_neighborhood ) ) {
		$meta['neighborhood'] = array(
			'priority' => 50,
			'label'    => esc_html__( 'Neighborhood', 'g5-ere' ),
			'content'  => $property_neighborhood
		);
	}

	$property_zip = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_zip', true );
	if ( ! empty( $property_zip ) ) {
		$meta['zip'] = array(
			'priority' => 50,
			'label'    => esc_html__( 'Postal code/ZIP', 'g5-ere' ),
			'content'  => $property_zip
		);
	}


	$meta = apply_filters( 'g5ere_single_property_block_address', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_property_map_address_url( $args = array() ) {
	$args              = wp_parse_args( $args, array(
		'property_id' => get_the_ID()
	) );
	$property_address  = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_address', true );
	$property_location = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_location', true );
	if ( $property_location && isset( $property_location['address'] ) && ! empty( $property_location['address'] ) ) {
		$google_map_address_url = "//maps.google.com/?q=" . $property_location['address'];
	} else {
		$google_map_address_url = "//maps.google.com/?q=" . $property_address;
	}

	return $google_map_address_url;
}

function g5ere_get_single_property_block_overview_data( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$meta = array();

	$meta['property_id'] = array(
		'priority'    => 10,
		'label'       => esc_html__( 'ID', 'g5-ere' ),
		'callback'    => 'g5ere_template_property_identity',
		'icon'        => g5ere_get_icon_svg( 'real-estate' ),
		'property_id' => $args['property_id']
	);

	$meta['type'] = array(
		'priority'    => 20,
		'label'       => esc_html__( 'Type', 'g5-ere' ),
		'callback'    => 'g5ere_template_property_type',
		'icon'        => g5ere_get_icon_svg( 'text-editor' ),
		'property_id' => $args['property_id']
	);


	$meta['bedrooms'] = array(
		'label'       => esc_html__( 'Bedrooms', 'g5-ere' ),
		'priority'    => 30,
		'callback'    => 'g5ere_template_property_bedrooms',
		'icon'        => g5ere_get_icon_svg( 'bed' ),
		'property_id' => $args['property_id']
	);


	$meta['bathrooms'] = array(
		'label'       => esc_html__( 'Bathrooms', 'g5-ere' ),
		'priority'    => 40,
		'callback'    => 'g5ere_template_property_bathrooms',
		'icon'        => g5ere_get_icon_svg( 'bath' ),
		'property_id' => $args['property_id']
	);

	$meta['garage'] = array(
		'label'       => esc_html__( 'Garages', 'g5-ere' ),
		'priority'    => 50,
		'callback'    => 'g5ere_template_property_garage',
		'icon'        => g5ere_get_icon_svg( 'garage' ),
		'property_id' => $args['property_id']
	);

	$meta['size'] = array(
		'label'       => esc_html__( 'Size', 'g5-ere' ),
		'priority'    => 60,
		'callback'    => 'g5ere_template_property_size',
		'icon'        => g5ere_get_icon_svg( 'house-plan' ),
		'property_id' => $args['property_id']
	);

	$meta['land-size'] = array(
		'label'       => esc_html__( 'Land Size', 'g5-ere' ),
		'priority'    => 70,
		'callback'    => 'g5ere_template_property_land_size',
		'icon'        => g5ere_get_icon_svg( 'interface' ),
		'property_id' => $args['property_id']
	);


	$meta['property-year'] = array(
		'label'       => esc_html__( 'Year Built', 'g5-ere' ),
		'priority'    => 80,
		'icon'        => g5ere_get_icon_svg( 'year' ),
		'callback'    => 'g5ere_template_property_year',
		'property_id' => $args['property_id']
	);


	$meta = apply_filters( 'g5ere_single_property_block_overview', $meta );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );

}


function g5ere_get_single_property_block_details_data( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$meta = array();

	$meta['property_id'] = array(
		'priority'    => 10,
		'label'       => esc_html__( 'Property ID', 'g5-ere' ),
		'callback'    => 'g5ere_template_property_identity',
		'property_id' => $args['property_id']
	);

	$meta['price'] = array(
		'label'       => esc_html__( 'Price', 'g5-ere' ),
		'priority'    => 20,
		'callback'    => 'g5ere_template_property_price',
		'property_id' => $args['property_id']
	);

	$meta['type'] = array(
		'priority'    => 30,
		'label'       => esc_html__( 'Property Type', 'g5-ere' ),
		'callback'    => 'g5ere_template_property_type',
		'property_id' => $args['property_id']
	);


	$meta['status'] = array(
		'priority'    => 40,
		'label'       => esc_html__( 'Property Status', 'g5-ere' ),
		'callback'    => 'g5ere_template_property_status',
		'property_id' => $args['property_id']
	);


	$meta['label'] = array(
		'priority'    => 40,
		'label'       => esc_html__( 'Property Label', 'g5-ere' ),
		'callback'    => 'g5ere_template_property_label',
		'property_id' => $args['property_id']
	);


	$meta['rooms'] = array(
		'label'       => esc_html__( 'Rooms', 'g5-ere' ),
		'priority'    => 50,
		'callback'    => 'g5ere_template_property_rooms',
		'property_id' => $args['property_id']
	);

	$meta['bedrooms'] = array(
		'label'       => esc_html__( 'Bedrooms', 'g5-ere' ),
		'priority'    => 50,
		'callback'    => 'g5ere_template_property_bedrooms',
		'property_id' => $args['property_id']
	);


	$meta['bathrooms'] = array(
		'label'       => esc_html__( 'Bathrooms', 'g5-ere' ),
		'priority'    => 60,
		'callback'    => 'g5ere_template_property_bathrooms',
		'property_id' => $args['property_id']
	);


	$meta['property_year'] = array(
		'label'       => esc_html__( 'Year Built', 'g5-ere' ),
		'priority'    => 70,
		'callback'    => 'g5ere_template_property_year',
		'property_id' => $args['property_id']
	);

	$meta['size'] = array(
		'label'       => esc_html__( 'Size', 'g5-ere' ),
		'priority'    => 80,
		'callback'    => 'g5ere_template_property_size',
		'property_id' => $args['property_id']
	);

	$meta['land-size'] = array(
		'label'       => esc_html__( 'Land area', 'g5-ere' ),
		'priority'    => 90,
		'callback'    => 'g5ere_template_property_land_size',
		'property_id' => $args['property_id']
	);

	$meta['garage'] = array(
		'label'       => esc_html__( 'Garages', 'g5-ere' ),
		'priority'    => 100,
		'callback'    => 'g5ere_template_property_garage',
		'property_id' => $args['property_id']
	);

	$meta['garage-size'] = array(
		'label'       => esc_html__( 'Garage area', 'g5-ere' ),
		'priority'    => 110,
		'callback'    => 'g5ere_template_property_garage_size',
		'property_id' => $args['property_id']
	);


	$additional_fields = ere_render_additional_fields();
	foreach ( $additional_fields as $key => $field ) {
		$property_field         = get_post_meta( $args['property_id'], $field['id'], true );
		$property_field_content = $property_field;
		if ( $field['type'] == 'checkbox_list' ) {
			$property_field_content = '';
			if ( is_array( $property_field ) ) {
				foreach ( $property_field as $value => $v ) {
					$property_field_content .= $v . ', ';
				}
			}
			$property_field_content = rtrim( $property_field_content, ', ' );
		}
		if ( $field['type'] === 'textarea' ) {
			$property_field_content = wpautop( $property_field_content );
		}
		if ( ! empty( $property_field_content ) ) {
			$meta[ $field['id'] ] = array(
				'label'    => $field['title'],
				'content'  => '<span>' . $property_field_content . '</span>',
				'priority' => 200,
			);
		}
	}

	$additional_features = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'additional_features', true );
	if ( $additional_features > 0 ) {
		$additional_feature_title = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'additional_feature_title', true );
		$additional_feature_value = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'additional_feature_value', true );
		for ( $i = 0; $i < $additional_features; $i ++ ) {
			if ( ! empty( $additional_feature_title[ $i ] ) && ! empty( $additional_feature_value[ $i ] ) ) {
				$meta[ sanitize_title( $additional_feature_title[ $i ] ) ] = array(
					'label'    => $additional_feature_title[ $i ],
					'content'  => '<span>' . $additional_feature_value[ $i ] . '</span>',
					'priority' => 300,
				);
			}
		}
	}


	$meta = apply_filters( 'g5ere_single_property_block_details', $meta, $args );

	uasort( $meta, 'g5ere_sort_by_order_callback' );

	$meta = array_map( 'g5ere_content_callback', $meta );

	return array_filter( $meta, 'g5ere_filter_content_callback' );
}

function g5ere_get_property_features( $args = array() ) {
	$args     = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$features = get_the_terms( $args['property_id'], 'property-feature' );

	if ( is_a( $features, 'WP_Error' ) ) {
		return false;
	}

	return $features;
}


function g5ere_get_property_floors( $args = array() ) {
	$args                  = wp_parse_args( $args, array(
		'property_id' => get_the_ID(),
	) );
	$property_floor_enable = absint( get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'floors_enable', true ) );
	if ( $property_floor_enable !== 1 ) {
		return false;
	}
	$property_floors = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'floors', true );
	if ( ! is_array( $property_floors ) || count( $property_floors ) === 0 ) {
		return false;
	}

	return $property_floors;
}

function g5ere_get_property_meta() {
	$property_id        = get_the_ID();
	$property_meta_data = get_post_custom( $property_id );

	return $property_meta_data;

}

function g5ere_get_property_video() {
	$property_video       = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_video_url', true );
	if ($property_video == '') {
		return false;
	}
	$property_video_image = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_video_image', true );
	return array(
		'video_url'   => $property_video,
		'video_image' => $property_video_image
	);

}

function g5ere_get_property_virtual_tour() {
	$property_id                = get_the_ID();
	$property_image_360         = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_image_360', true );
	$property_image_360         = ( isset( $property_image_360 ) && is_array( $property_image_360 ) ) ? $property_image_360['url'] : '';
	$property_virtual_tour      = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_virtual_tour', true );
	$property_virtual_tour_type = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_virtual_tour_type', true );
	if ( empty( $property_virtual_tour_type ) ) {
		$property_virtual_tour_type = '0';
	}
	if ( ! empty( $property_virtual_tour ) || $property_image_360 != '' ) {
		return array(
			'property_image_360'         => $property_image_360,
			'property_virtual_tour'      => $property_virtual_tour,
			'property_virtual_tour_type' => $property_virtual_tour_type
		);
	}

	return false;

}

function g5ere_get_property_get_attachments() {
	$property_attachment_arg = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_attachments', false );
	$property_attachments    = ( isset( $property_attachment_arg ) && is_array( $property_attachment_arg ) && count( $property_attachment_arg ) > 0 ) ? $property_attachment_arg[0] : '';
	$property_attachments    = explode( '|', $property_attachments );
	$property_attachments    = array_unique( $property_attachments );

	return $property_attachments;

}

function g5ere_get_property_get_walk_score() {
	$property_id       = get_the_ID();
	$walkscore_api_key = ere_get_option( 'walk_score_api_key', '' );
	$response_result   = '';
	if ( $walkscore_api_key != '' ) {
		$location = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_location', true );
		if ( ! empty( $location ) ) {
			list( $lat, $lng ) = explode( ',', $location['location'] );
			$address  = $location['address'];
			$address  = urlencode( $address );
			$response = wp_remote_get( "http://api.walkscore.com/score?format=json&transit=1&bike=1&address=$address&lat=$lat&lon=$lng&wsapikey=$walkscore_api_key" );
			if ( is_array( $response ) ) {
				$response_result = json_decode( $response['body'], true );
			}
		}
	}

	return $response_result;

}

function g5ere_get_review_data() {
	global $post;
	if ( ! is_a( $post, 'WP_Post' ) || ( ! in_array( $post->post_type, array( 'property', 'agent' ) ) ) ) {
		return false;
	}

	global $wpdb;
	$current_user = wp_get_current_user();
	$user_id      = $current_user->ID;
	$meta_key     = 'property_rating';
	$action       = 'ere_property_submit_review_ajax';
	$name         = 'property_id';
	if ( $post->post_type === 'agent' ) {
		$meta_key = 'agent_rating';
		$action   = 'ere_agent_submit_review_ajax';
		$name     = 'agent_id';
	}
	$my_review = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->comments as comment INNER JOIN $wpdb->commentmeta AS meta WHERE comment.comment_post_ID = %d AND comment.user_id = %d  AND meta.meta_key = %s AND meta.comment_id = comment.comment_ID ORDER BY comment.comment_ID DESC", get_the_ID(), $user_id, $meta_key ) );

	return array(
		'rating' => isset( $my_review->meta_value ) ? intval( $my_review->meta_value ) : 5,
		'review' => isset( $my_review->comment_content ) ? $my_review->comment_content : '',
		'action' => $action,
		'name'   => $name
	);
}

function g5ere_get_rating_data() {
	global $post;
	if ( ! is_a( $post, 'WP_Post' ) || ( ! in_array( $post->post_type, array( 'property', 'agent' ) ) ) ) {
		return false;
	}
	$meta_key = 'property_rating';
	if ( $post->post_type === 'agent' ) {
		$meta_key = 'agent_rating';
	}
	$total_stars = $count = $rating = 0;
	$rating_data = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . $meta_key, true );
	if ( ! is_array( $rating_data ) ) {
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
		if ( isset( $rating_data[ $i ] ) ) {
			$count       += $rating_data[ $i ];
			$total_stars += $rating_data[ $i ] * $i;
		}
	}
	if ( $count > 0 ) {
		$rating = round( ( $total_stars / $count ), 2 );
	}

	return array(
		'rating'      => $rating,
		'count'       => $count,
		'rating_data' => $rating_data
	);
}


function g5ere_yelp_query_api( $term, $location ) {

	$api_key      = G5ERE()->options()->get_option( 'yelp_api_key' );
	$result_limit = G5ERE()->options()->get_option( 'nearby_places_result_limit' );

	$query_url = add_query_arg(
		array(
			'term'     => $term,
			'location' => $location,
			'limit'    => $result_limit,
			'sort_by'  => 'distance'
		),
		'https://api.yelp.com/v3/businesses/search'
	);

	$args = array(
		'user-agent' => '',
		'headers'    => array(
			'authorization' => 'Bearer ' . $api_key,
		),
	);

	$response = wp_safe_remote_get( $query_url, $args );
	if ( is_wp_error( $response ) ) {
		return false;
	}

	if ( ! empty( $response['body'] ) && is_ssl() ) {
		$response['body'] = str_replace( 'http:', 'https:', $response['body'] );
	}

	return json_decode( $response['body'] );
}

function g5ere_get_user_comments_count( $uid ) {
	global $wpdb;
	$sql = "SELECT COUNT(*) as total
            FROM {$wpdb->comments} as c  
            JOIN {$wpdb->posts} as p ON p.ID = c.comment_post_ID 
            JOIN {$wpdb->commentmeta} AS meta on meta.comment_id = c.comment_ID
            WHERE c.comment_approved = '1' 
            AND p.post_status ='publish'   
            AND p.post_type ='property'           
            AND p.post_author = %d
            AND meta.meta_key = %s
            ORDER BY c.comment_date DESC";

	$comments = $wpdb->get_var( $wpdb->prepare( $sql, $uid, 'property_rating' ) );

	return $comments;
}

function g5ere_get_user_comments_limit( $uid, $limit, $offset ) {
	global $wpdb;
	$sql = "SELECT *
            FROM {$wpdb->comments} as c  
            JOIN {$wpdb->posts} as p ON p.ID = c.comment_post_ID 
            JOIN {$wpdb->commentmeta} AS meta on meta.comment_id = c.comment_ID
            WHERE c.comment_approved = '1' 
            AND p.post_status ='publish'   
            AND p.post_type ='property'             
            AND p.post_author = %d
            AND meta.meta_key = %s
            ORDER BY c.comment_date DESC
            LIMIT %d OFFSET %d 
            ";

	$comments = $wpdb->get_results( $wpdb->prepare( $sql, $uid, 'property_rating', $limit, $offset ) );

	return $comments;
}

function g5ere_get_property_permalink( $post ) {
	$status = get_post_status( $post );
	if ( $status === 'pending' ) {
		$link = G5ERE()->preview_property()->get_preview_link( $post );
	} else {
		$link = get_the_permalink( $post );
	}

	return $link;
}

function g5ere_get_property_placeholder_image() {
	$placeholder_image_url = G5ERE()->plugin_url( 'assets/images/placeholder.png' );
	$placeholder           = G5ERE()->options()->get_option( 'property_placeholder_enable' );
	if ( $placeholder === 'on' ) {
		$placeholder_image = G5ERE()->options()->get_option( 'property_placeholder_image' );
		if ( is_array( $placeholder_image ) && isset( $placeholder_image['url'] ) && ! empty( $placeholder_image['url'] ) ) {
			$placeholder_image_url = $placeholder_image['url'];
		}
	}

	return $placeholder_image_url;
}

