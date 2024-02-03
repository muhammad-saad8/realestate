<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
function g5core_get_image_sizes() {
	$data = G5CORE()->cache()->get( 'image_sizes' );
	if ( ! is_null( $data ) ) {
		return $data;
	}
	$data = apply_filters( 'g5core_image_sizes', array() );
	G5CORE()->cache()->set( 'image_sizes', $data );

	return $data;
}


function g5core_get_image_dimension( $image_size = 'thumbnail' ) {
	$cache_key = "image_dimension_{$image_size}";
	$data      = G5CORE()->cache()->get( $cache_key );
	if ( ! is_null( $data ) ) {
		return $data;
	}

	global $_wp_additional_image_sizes;
	$width  = '';
	$height = '';

	$image_sizes = g5core_get_image_sizes();
	if ( array_key_exists( $image_size, $image_sizes ) ) {
		$image_size = $image_sizes[ $image_size ];
	}


	if ( preg_match( '/x/', $image_size ) ) {
		$image_size = preg_split( '/x/', $image_size );
		$width      = $image_size[0];
		$height     = $image_size[1];
	} elseif ( in_array( $image_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
		$width  = intval( get_option( $image_size . '_size_w' ) );
		$height = intval( get_option( $image_size . '_size_h' ) );
	} elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {
		$width  = intval( $_wp_additional_image_sizes[ $image_size ]['width'] );
		$height = intval( $_wp_additional_image_sizes[ $image_size ]['height'] );
	}

	if ( $width !== '' && $height !== '' ) {
		$data = array(
			'width'  => $width,
			'height' => $height
		);
	} else {
		$data = false;
	}
	G5CORE()->cache()->set( $cache_key, $data );

	return $data;
}

function g5core_get_metro_image_size( $image_size_base = '300x300', $layout_ratio = '1x1', $columns_gutter = 0 ) {
	$image_width         = 0;
	$image_height        = 0;
	$layout_ratio_width  = 1;
	$layout_ratio_height = 1;
	$columns_gutter      = intval( $columns_gutter );
	$width               = 0;
	$height              = 0;

	$image_size_base_dimension = g5core_get_image_dimension( $image_size_base );
	if ( $image_size_base_dimension ) {
		$image_width  = $image_size_base_dimension['width'];
		$image_height = $image_size_base_dimension['height'];
	}

	if ( preg_match( '/x/', $layout_ratio ) ) {
		$layout_ratio        = preg_split( '/x/', $layout_ratio );
		$layout_ratio_width  = isset( $layout_ratio[0] ) ? floatval( $layout_ratio[0] ) : 0;
		$layout_ratio_height = isset( $layout_ratio[1] ) ? floatval( $layout_ratio[1] ) : 0;
	}

	if ( ( $image_width > 0 ) && ( $image_height > 0 ) ) {
		$width  = ( $layout_ratio_width - 1 ) * $columns_gutter + $image_width * $layout_ratio_width;
		$height = ( $layout_ratio_height - 1 ) * $columns_gutter + $image_height * $layout_ratio_height;
	}

	if ( ( $width > 0 ) && ( $height > 0 ) ) {
		return "{$width}x{$height}";
	}

	return $image_size_base;
}

function g5core_get_metro_image_ratio( $image_ratio_base = '1x1', $layout_ratio = '1x1' ) {
	$layout_ratio_width  = 1;
	$layout_ratio_height = 1;

	$image_ratio_base_width  = 1;
	$image_ratio_base_height = 1;


	if ( preg_match( '/x/', $layout_ratio ) ) {
		$layout_ratio        = preg_split( '/x/', $layout_ratio );
		$layout_ratio_width  = isset( $layout_ratio[0] ) ? floatval( $layout_ratio[0] ) : 0;
		$layout_ratio_height = isset( $layout_ratio[1] ) ? floatval( $layout_ratio[1] ) : 0;
	}

	if ( preg_match( '/x/', $image_ratio_base ) ) {
		$image_ratio_base        = preg_split( '/x/', $image_ratio_base );
		$image_ratio_base_width  = isset( $image_ratio_base[0] ) ? floatval( $image_ratio_base[0] ) : 0;
		$image_ratio_base_height = isset( $image_ratio_base[1] ) ? floatval( $image_ratio_base[1] ) : 0;
	}

	if ( ( $layout_ratio_width > 0 )
	     && ( $layout_ratio_height > 0 )
	     && ( $image_ratio_base_width > 0 )
	     && ( $image_ratio_base_height > 0 ) ) {
		$image_ratio_width  = $image_ratio_base_width * $layout_ratio_width;
		$image_ratio_height = $image_ratio_base_height * $layout_ratio_height;

		return "{$image_ratio_width}x{$image_ratio_height}";
	}

	return $image_ratio_base;
}

function g5core_get_thumbnail_data( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'image_size'         => 'thumbnail',
		'animated_thumbnail' => true,
		'placeholder'        => '',
		'first_image_as_post_thumbnail' => '',
		'default_thumbnail_image' => '',
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
	$first_image_as_post_thumbnail = $args['first_image_as_post_thumbnail'] !== '' ? $args['first_image_as_post_thumbnail'] : G5CORE()->options()->get_option( 'first_image_as_post_thumbnail' );
	if ( $first_image_as_post_thumbnail === 'on' ) {
		global $post;
		if ( isset( $post->post_content ) ) {
			if ( preg_match( "'<\s*img\s.*?src\s*=\s*
						([\"\'])?
						(?(1) (.*?)\\1 | ([^\s\>]+))'isx", $post->post_content, $matched ) ) {

				$thumbnail['url'] = esc_url( $matched[2] );
				G5CORE()->cache()->set_cache_listing( $cache_id, $thumbnail );

				return $thumbnail;
			}
		}

	}
	$placeholder = $args['placeholder'] !== '' ? $args['placeholder'] : G5CORE()->options()->get_option( 'default_thumbnail_placeholder_enable' );
	if ( $placeholder === 'on' ) {
		$placeholder_img    = $args['default_thumbnail_image'] !== '' ? $args['default_thumbnail_image'] : G5CORE()->options()->get_option( 'default_thumbnail_image' );
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
		$thumbnail['url'] = G5CORE()->plugin_url( 'assets/images/placeholder.png' );
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

function g5core_get_image_data( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'image_id'           => '',
		'image_size'         => 'thumbnail',
		'animated_thumbnail' => true
	) );
	if ( empty( $args['image_id'] ) ) {
		return false;
	}
	$cache_key = "image_{$args['image_id']}_{$args['image_size']}";
	$data      = G5CORE()->cache()->get( $cache_key );
	if ( ! is_null( $data ) ) {
		return $data;
	}

	$output = array(
		'id'              => $args['image_id'],
		'url'             => '',
		'width'           => '',
		'height'          => '',
		'alt'             => get_post_meta( $args['image_id'], '_wp_attachment_image_alt', true ),
		'title'           => g5core_the_title_attribute( array( 'echo' => false ) ),
		'caption'         => '',
		'description'     => '',
		'skip_smart_lazy' => false
	);


	if ( empty( $output['alt'] ) ) {
		$output['alt'] = g5core_the_title_attribute( array( 'echo' => false ) );
	}

	$image_sizes = g5core_get_image_sizes();
	if ( array_key_exists( $args['image_size'], $image_sizes ) ) {
		$size             = preg_split( '/x/', $image_sizes[ $args['image_size'] ] );
		$image_width      = isset( $size[0] ) ? intval( $size[0] ) : 0;
		$image_height     = isset( $size[1] ) ? intval( $size[1] ) : 0;
		$img              = G5CORE()->image_resize()->resize( array(
			'image_id' => $args['image_id'],
			'width'    => $image_width,
			'height'   => $image_height
		) );
		$output['url']    = $img['url'];
		$output['width']  = $img['width'];
		$output['height'] = $img['height'];


	} elseif ( preg_match( '/x/', $args['image_size'] ) ) {
		$size         = preg_split( '/x/', $args['image_size'] );
		$image_width  = isset( $size[0] ) ? intval( $size[0] ) : 0;
		$image_height = isset( $size[1] ) ? intval( $size[1] ) : 0;

		$img = G5CORE()->image_resize()->resize( array(
			'image_id' => $args['image_id'],
			'width'    => $image_width,
			'height'   => $image_height
		) );

		$output['url']    = $img['url'];
		$output['width']  = $img['width'];
		$output['height'] = $img['height'];
	} else {
		$img = wp_get_attachment_image_src( $args['image_id'], $args['image_size'] );
		if ( $img ) {
			$output['url']    = $img[0];
			$output['width']  = $img[1];
			$output['height'] = $img[2];
		}
	}

	if ( ! empty( $output['url'] ) && $args['animated_thumbnail'] ) {
		$file_type = wp_check_filetype( $output['url'] );
		if ( $file_type['ext'] === 'gif' ) {
			$img = wp_get_attachment_image_src( $args['image_id'], 'full' );
			if ( $img ) {
				$output['url']             = $img[0];
				$output['width']           = $img[1];
				$output['height']          = $img[2];
				$output['skip_smart_lazy'] = true;
			}
		}
	}

	$img_post = get_post( $args['image_id'] );

	if ( ! is_null( $img_post ) ) {
		$thumbnail['alt']         = get_post_meta( $args['image_id'], '_wp_attachment_image_alt', true );
		$thumbnail['caption']     = $img_post->post_excerpt;
		$thumbnail['description'] = $img_post->post_content;
	}

	G5CORE()->cache()->set( $cache_key, $output );

	return $output;

}

function g5core_render_thumbnail_markup( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'image_size'         => 'thumbnail',
		'image_ratio'        => '',
		'image_id'           => '',
		'animated_thumbnail' => true,
		'display_permalink'  => true,
		'image_mode'         => '',
		'post'               => null,
		'placeholder'        => '',
		'default_thumbnail_image' => '',
		'first_image_as_post_thumbnail' => '',
		'gallery_id'         => ''
	) );

	if ( ! empty( $args['image_id'] ) ) {
		$image_data = g5core_get_image_data( array(
			'image_id'           => $args['image_id'],
			'image_size'         => $args['image_size'],
			'animated_thumbnail' => $args['animated_thumbnail']
		) );
	} else {
		$image_data = g5core_get_thumbnail_data( array(
			'image_size'         => $args['image_size'],
			'animated_thumbnail' => $args['animated_thumbnail'],
			'post'               => $args['post'],
			'placeholder'        => $args['placeholder'],
			'default_thumbnail_image' => $args['default_thumbnail_image']
		) );


	}


	if ( ! $image_data || empty( $image_data['url'] ) ) {
		return '';
	}

	$is_lazy_load = G5Core_Lazy_Load::getInstance()->is_active();

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

		if ( $args['display_permalink'] ) {
			?>
			<a <?php echo join( ' ', $attributes ) ?> href="<?php g5core_the_permalink($args['post']) ?>">
			</a>
			<?php
		} else {
			?>
			<div <?php echo join( ' ', $attributes ) ?>>
				<?php
				$image_full_url = '';
				if ( ! empty( $image_data['id'] ) ) {
					$image_full = wp_get_attachment_image_src( $image_data['id'], 'full' );
					if ( is_array( $image_full ) && isset( $image_full[0] ) ) {
						$image_full_url = $image_full[0];

					}
				}
				$zoom_attributes = array();
				if ( ! empty( $args['gallery_id'] ) ) {
					$zoom_attributes[] = sprintf( 'data-gallery-id="%s"', esc_attr( $args['gallery_id'] ) );
				}

				$zoom_attributes[] = sprintf( 'href="%s"', esc_url( $image_full_url ) );

				?>

				<?php if ( ! empty( $image_full_url ) ): ?>
					<a data-g5core-mfp <?php echo join( ' ', $zoom_attributes ) ?> class="g5core__zoom-image"><i
								class="fas fa-expand"></i></a>
				<?php endif; ?>
			</div>
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
			?>
			<a class="g5core__entry-thumbnail g5core__entry-thumbnail-image" href="<?php g5core_the_permalink($args['post']) ?>">
				<?php echo $image_html; ?>
			</a>
			<?php
		} else {
			?>
			<div class="g5core__entry-thumbnail g5core__entry-thumbnail-image">
				<?php echo $image_html; ?>
				<?php
				$image_full_url = '';
				if ( ! empty( $image_data['id'] ) ) {
					$image_full = wp_get_attachment_image_src( $image_data['id'], 'full' );
					if ( is_array( $image_full ) && isset( $image_full[0] ) ) {
						$image_full_url = $image_full[0];

					}
				}
				$zoom_attributes = array();
				if ( ! empty( $args['gallery_id'] ) ) {
					$zoom_attributes[] = sprintf( 'data-gallery-id="%s"', esc_attr( $args['gallery_id'] ) );
				}

				$zoom_attributes[] = sprintf( 'href="%s"', esc_url( $image_full_url ) );

				?>

				<?php if ( ! empty( $image_full_url ) ): ?>
					<a data-g5core-mfp <?php echo join( ' ', $zoom_attributes ) ?> class="g5core__zoom-image"><i
								class="fas fa-expand"></i></a>
				<?php endif; ?>
			</div>
			<?php

		}
	}
	echo ob_get_clean();
}


function g5core_render_metro_image_markup( $args = array() ) {
	if ( $args['image_ratio'] === '' ) {
		$image_size_dimension = g5core_get_image_dimension( $args['image_size'] );
		if ( $image_size_dimension ) {
			$args['image_ratio'] = "{$image_size_dimension['width']}x{$image_size_dimension['height']}";
		}
	}

	$args = wp_parse_args( $args, array(
		'image_size'        => 'thumbnail',
		'image_ratio'       => '1x1',
		'image_id'          => '',
		'columns_gutter'    => 0,
		'layout_ratio'      => '1x1',
		'gallery_id'        => '',
		'display_permalink' => false,
		'display_zoom'      => true,
		'hover_effect'      => ''
	) );

	if ( empty( $args['image_id'] ) ) {
		$args['image_id'] = get_post_thumbnail_id();
	}


	$current_image_size         = g5core_get_metro_image_size( $args['image_size'], $args['layout_ratio'], $args['columns_gutter'] );
	$current_image_ratio_width  = 1;
	$current_image_ratio_height = 1;
	if ( preg_match( '/x/', $args['image_ratio'] ) ) {
		$image_ratio_sizes          = preg_split( '/x/', $args['image_ratio'] );
		$current_image_ratio_width  = isset( $image_ratio_sizes[0] ) ? intval( $image_ratio_sizes[0] ) : 1;
		$current_image_ratio_height = isset( $image_ratio_sizes[1] ) ? intval( $image_ratio_sizes[1] ) : 1;
	}

	if ( preg_match( '/x/', $args['layout_ratio'] ) ) {
		$layout_ratio               = preg_split( '/x/', $args['layout_ratio'] );
		$layout_ratio_width         = isset( $layout_ratio[0] ) ? floatval( $layout_ratio[0] ) : 1;
		$layout_ratio_height        = isset( $layout_ratio[1] ) ? floatval( $layout_ratio[1] ) : 1;
		$current_image_ratio_width  = $current_image_ratio_width * $layout_ratio_width;
		$current_image_ratio_height = $current_image_ratio_height * $layout_ratio_height;
	}
	$current_image_ratio = "{$current_image_ratio_width}x{$current_image_ratio_height}";

	$image_data = g5core_get_image_data( array(
		'image_id'   => $args['image_id'],
		'image_size' => $current_image_size
	) );

	/*if (($image_data === false) || (empty($image_data['url']))) {
		return;
	}*/

	$current_image_ratio_class = str_replace( '.', '-', "g5core__image-size-{$current_image_ratio}" );

	$wrapper_classes = array(
		'g5core__embed-responsive',
		'g5core__post-featured',
		'g5core__metro',
		$current_image_ratio_class
	);

	if ( isset( $args['custom_class'] ) && ( ! empty( $args['custom_class'] ) ) ) {
		$wrapper_classes[] = $args['custom_class'];
	}

	if ( ! in_array( $current_image_ratio, array( '1x1', '3x4', '4x3', '16x9', '9x16' ) ) ) {
		if ( ( $current_image_ratio_width > 0 ) && ( $current_image_ratio_height > 0 ) ) {
			$ratio      = ( $current_image_ratio_height / $current_image_ratio_width ) * 100;
			$custom_css = <<<CSS
                .{$current_image_ratio_class}:before{
                    padding-top: {$ratio}%;
                }
CSS;
			G5CORE()->custom_css()->addCss( $custom_css, $current_image_ratio_class );
		}
	}

	$images_attributes = array();
	$images_classes    = array(
		'g5core__entry-thumbnail',
		'w-100',
		'h-100'
	);
	if ( ! empty( $image_data['url'] ) ) {
		if ( G5Core_Lazy_Load::getInstance()->is_active() ) {
			$images_attributes[] = sprintf( 'data-bg="%s"', esc_url( $image_data['url'] ) );
			$images_classes[]           = 'g5core__ll-background';
		} else {
			$images_attributes[] = sprintf( 'style="background-image: url(%s);"', esc_url( $image_data['url'] ) );
		}

	}
	$images_attributes[] = sprintf('class="%s"', join(' ', $images_classes));

	$wrapper_class = implode( ' ', $wrapper_classes );
	ob_start();
	?>
	<div class="<?php echo esc_attr( $wrapper_class ) ?>">
		<div class="g5core__metro-inner">
			<?php if ( ! empty( $args['hover_effect'] ) ): ?>
			<div class="g5core__post-featured-effect effect-<?php echo esc_attr( $args['hover_effect'] ) ?> w-100 h-100">
				<?php endif; ?>
				<div <?php echo join( ' ', $images_attributes ) ?>>
					<?php
					/**
					 * Hook: g5core_metro_content.
					 *
					 *
					 * @hooked g5core_template_image_zoom - 5
					 * @hooked g5core_template_metro_link - 10
					 * @hooked g5core_template_metro_content - 10
					 */
					do_action( 'g5core_metro_content', $args );
					?>
				</div>
				<?php if ( ! empty( $args['hover_effect'] ) ): ?>
			</div>
		<?php endif; ?>

		</div>
	</div>
	<?php
	echo ob_get_clean();

}

function g5core_template_image_zoom( $args ) {
	if ( isset( $args['display_zoom'] ) && ( $args['display_zoom'] ) ) {
		$image_full_url  = '';
		$zoom_attributes = array();
		if ( ! empty( $args['image_id'] ) ) {
			$image_full = wp_get_attachment_image_src( $args['image_id'], 'full' );
			if ( is_array( $image_full ) && isset( $image_full[0] ) ) {
				$image_full_url = $image_full[0];

			}
		}
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
	}
}

function g5core_build_img_tag( $attributes = array() ) {
	if ( empty( $attributes['src'] ) ) {
		return '';
	}

	$attributes_str = '';
	if ( ! empty( $attributes ) ) {
		foreach ( $attributes as $attribute => $value ) {
			if ( '' === $value ) {
				continue;
			}
			$attributes_str .= ' ' . sprintf( '%s="%s"', $attribute, esc_attr( $value ) );
		}
	}
	$image = '<img ' . $attributes_str . '>';

	return $image;
}

function g5core_build_lazy_img_tag( $img_html, $width, $height, $extra_classes = '' ) {
	$lazy_height = '100';
	$lazy_width  = '100%';
	$classes     = 'g5core__lazy-image';

	if ( ! empty( $extra_classes ) ) {
		$classes .= ' ' . $extra_classes;
	}

	if ( isset( $width ) && '' !== $width ) {
		$lazy_width = $width . 'px';

		if ( isset( $height ) && '' !== $height ) {
			$lazy_height = g5core_calculate_percentage( $height, $width );
		}
	}

	$image_style = "--g5-lazy-image-width: {$lazy_width};";
	$image_style .= "--g5-lazy-image-height: {$lazy_height}%;";

	return '<span class="' . $classes . '" style="' . $image_style . '">' . $img_html . '</span>';
}

function g5core_lazy_load_safe_style_css( $styles ) {
	$styles[] = '--g5-lazy-image-width';
	$styles[] = '--g5-lazy-image-height';

	return $styles;
}

add_filter( 'safe_style_css', 'g5core_lazy_load_safe_style_css' );