<?php

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'elementor/document/after_save', 'g5core_elementor_document_after_save', 10, 2 );
function g5core_elementor_document_after_save( $obj, $data ) {
	if ( is_a( $obj, 'Elementor\Core\Kits\Documents\Kit' ) ) {
		$map_colors = array(
			'primary'     => 'primary_color',
			'secondary'   => 'secondary_color',
			'text'        => 'site_text_color',
			'accent'      => 'accent_color',
			'border'      => 'border_color',
			'dark'        => 'dark_color',
			'light'       => 'light_color',
			'gray'        => 'gray_color',
			'muted'       => 'caption_color',
			'placeholder' => 'placeholder_color',
		);

		$system_colors = isset( $data['settings']['system_colors'] ) ? $data['settings']['system_colors'] : array();

		$color_options = get_option( G5CORE()->options()->color()->get_option_name(), array() );

		foreach ( $map_colors as $k => $v ) {
			$current_color = array();
			foreach ( $system_colors as $cl ) {
				if ( $cl['_id'] === $k ) {
					$current_color = $cl;
					break;
				}
			}
			if ( isset( $current_color['color'] ) ) {
				$color_options[ $v ] = $current_color['color'];
			}
		}

		update_option( G5CORE()->options()->color()->get_option_name(), $color_options );
	}
}

$color_options_name = G5Core_Config_Color_Options::getInstance()->options_name();
add_action( "gsf_after_change_options/{$color_options_name}", 'g5core_elementor_after_change_options_color', 10, 2 );
function g5core_elementor_after_change_options_color( $options, $preset ) {
	if ( $preset === '' ) {
		$map_colors = array(
			'primary'     => 'primary_color',
			'secondary'   => 'secondary_color',
			'text'        => 'site_text_color',
			'accent'      => 'accent_color',
			'border'      => 'border_color',
			'dark'        => 'dark_color',
			'light'       => 'light_color',
			'gray'        => 'gray_color',
			'muted'       => 'caption_color',
			'placeholder' => 'placeholder_color',
		);


		if ( class_exists( 'Elementor\Plugin' ) ) {
			$kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();

			$kit              = Elementor\Plugin::$instance->documents->get( $kit_id );
			$meta_key         = Elementor\Core\Settings\Page\Manager::META_KEY;
			$kit_raw_settings = $kit->get_meta( $meta_key );

			if ( ! isset( $kit_raw_settings['system_colors'] ) ) {
				return;
			}

			foreach ( $map_colors as $k => $v ) {
				if ( isset( $options[ $v ] ) ) {
					foreach ( $kit_raw_settings['system_colors'] as &$cl ) {
						if ( $cl['_id'] === $k ) {
							$cl['color'] = $options[ $v ];
						}
					}
				}
			}

			$kit->update_meta( $meta_key, $kit_raw_settings );

			$post_css = Elementor\Core\Files\CSS\Post::create( $kit_id );
			$post_css->delete();
		}
	}
}

function g5core_elementor_enqueue_assets_content_block() {
	if ( ! class_exists( 'Elementor\Plugin' ) ) {
		return;
	}
	$content_block_ids = g5core_get_content_block_ids();
	if ( $content_block_ids === false ) {
		return;
	}
	$is_built_with_elementor = false;
	foreach ( $content_block_ids as $post_id ) {
		if ( $post_id !== '' ) {
			$document = Elementor\Plugin::$instance->documents->get( $post_id );
			if ( $document && $document->is_built_with_elementor() ) {
				$is_built_with_elementor = true;
				if ( class_exists( 'Elementor\Core\Files\CSS\Post' ) ) {
					$css_file = Elementor\Core\Files\CSS\Post::create( $post_id );
					if ( ! empty( $css_file ) ) {
						$css_file->enqueue();
					}
				}

			}
		}
	}

	if ( $is_built_with_elementor ) {
		Elementor\Plugin::$instance->frontend->enqueue_styles();
	}
}

add_action( 'wp_enqueue_scripts', 'g5core_elementor_enqueue_assets_content_block' );

function g5core_elementor_before_get_builder_content($document) {
	$data = $document->get_elements_data();
	if ( !empty( $data ) ) {
		Elementor\Plugin::$instance->frontend->start_excerpt_flag('');
	}
}

function g5core_elementor_after_get_builder_content() {
	Elementor\Plugin::$instance->frontend->end_excerpt_flag( '' );
}

function g5core_elementor_get_builder_content_for_display( $id ) {
	if ( ! class_exists( 'Elementor\Plugin' ) ) {
		return false;
	}
	$document = Plugin::$instance->documents->get_doc_for_frontend( $id );

	if ( ! $document || ! $document->is_built_with_elementor() ) {
		return false;
	}

	add_action( 'elementor/frontend/before_get_builder_content', 'g5core_elementor_before_get_builder_content' );
	add_action( 'elementor/frontend/get_builder_content', 'g5core_elementor_after_get_builder_content' );

	$content = Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id, false );

	remove_action( 'elementor/frontend/before_get_builder_content', 'g5core_elementor_before_get_builder_content' );
	remove_action( 'elementor/frontend/get_builder_content', 'g5core_elementor_after_get_builder_content' );

	return $content;
}


function g5core_elementor_custom_css() {
	$custom_css = <<<CSS
.elementor-column-gap-default > .elementor-row > .elementor-column > .elementor-element-populated > .elementor-widget-wrap,
.elementor-column-gap-default > .elementor-column > .elementor-element-populated {
	padding: 15px;
}
CSS;

	wp_add_inline_style( 'elementor-frontend', $custom_css );
}

add_action( 'elementor/frontend/after_enqueue_styles', 'g5core_elementor_custom_css' );


add_filter( 'ube_system_colors', 'g5core_change_ube_system_colors' );
function g5core_change_ube_system_colors( $colors ) {
	$map_colors = array(
		'primary'     => 'primary_color',
		'secondary'   => 'secondary_color',
		'text'        => 'site_text_color',
		'accent'      => 'accent_color',
		'border'      => 'border_color',
		'dark'        => 'dark_color',
		'light'       => 'light_color',
		'gray'        => 'gray_color',
		'muted'       => 'caption_color',
		'placeholder' => 'placeholder_color'
	);

	foreach ( $colors as $k => $cl ) {
		if ( isset( $cl['_id'] ) && isset( $map_colors[ $cl['_id'] ] ) ) {
			$key       = $map_colors[ $cl['_id'] ];
			$new_color = G5CORE()->options()->color()->get_option( $key, '' );
			if ( $new_color ) {
				$colors[ $k ]['color'] = $new_color;
			}
		}
	}

	return $colors;
}

function g5core_elementor_disable_lazy_load($is_active) {
	if ( class_exists( '\Elementor\Plugin' ) && (\Elementor\Plugin::$instance !== null) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		$is_active = false;
	}
	return $is_active;
}
add_filter('g5core_image_lazy_load_active','g5core_elementor_disable_lazy_load');