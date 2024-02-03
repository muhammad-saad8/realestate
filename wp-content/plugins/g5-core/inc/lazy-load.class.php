<?php
// Do not allow directly accessing this file.
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5Core_Lazy_Load')) {
	class G5Core_Lazy_Load {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function is_active() {
			$image_lazy_load_enable = G5CORE()->options()->get_option( 'image_lazy_load_enable' );
			return apply_filters('g5core_image_lazy_load_active', $image_lazy_load_enable === 'on' && !is_admin());
		}


		public function init() {
			add_filter('wp_get_attachment_image_attributes',array($this,'change_attachment_image_attributes'),10,3);
			add_filter('wp_get_attachment_image',array($this,'change_attachment_image'),10,5);
			add_filter('elementor/image_size/get_attachment_image_html',array($this,'change_elementor_attachment_image_html'),10,4);

			add_action( 'elementor/frontend/before_render', array($this,'elementor_lazy_load'));

			add_action('ube_gallery_metro/frontend/before_render_item',array($this,'elementor_ube_gallery_metro_lazy_load'),10,3);
			add_filter('ube_gallery_metro_item_bg_classes',array($this,'elementor_ube_gallery_metro_lazy_load_class'));
		}

		public function change_elementor_attachment_image_html($html, $settings, $image_size_key, $image_key ) {
			if ($this->is_active() && !empty($html)) {
				$image = $settings[ $image_key ];
				$size = $settings[ $image_size_key . '_size' ];
				$image_sizes = get_intermediate_image_sizes();
				$image_sizes[] = 'full';
				$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();
				$attachment_id = $image['id'];
				if (!in_array( $size, $image_sizes ) || $is_static_render_mode ) {
					$custom_dimension = $settings[ $image_size_key . '_custom_dimension' ];
					$attachment_size = [
						// Defaults sizes
						0 => null, // Width.
						1 => null, // Height.
						'bfi_thumb' => true,
						'crop' => true,
					];

					$has_custom_size = false;
					if ( ! empty( $custom_dimension['width'] ) ) {
						$has_custom_size = true;
						$attachment_size[0] = $custom_dimension['width'];
					}

					if ( ! empty( $custom_dimension['height'] ) ) {
						$has_custom_size = true;
						$attachment_size[1] = $custom_dimension['height'];
					}

					if ( ! $has_custom_size ) {
						$attachment_size = 'full';
					}


					// Use BFI_Thumb script
					// TODO: Please rewrite this code.
					require_once ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php';

					$image_src = wp_get_attachment_image_src( $attachment_id, $attachment_size );
					list( $src, $width, $height ) = $image_src;

					$output_array = array();
					preg_match_all('/(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/', $html, $output_array);
					$attributes = array(
						'class' => '',
						'src' => G5CORE()->plugin_url( 'assets/images/placeholder-transparent.png' ),
						'width' => $width,
						'height' => $height
					);

					if (isset($output_array[1]) && is_array($output_array[1]) && count($output_array[1]) > 0 ) {
						foreach ($output_array[1] as $k => $v) {
							if ($v === 'src') {
								$v = 'data-src';
							}
							$attributes[$v] = $output_array[2][$k];
						}
					}

					$attributes['class'] = 'g5core__ll-image ' . $attributes['class'];
					$image_html = g5core_build_img_tag($attributes);
					$html = g5core_build_lazy_img_tag($image_html,$width,$height);
				}
			}
			return $html;
		}

		public function change_attachment_image_attributes($attr, $attachment, $size ) {
			if ($this->is_active()) {
				$class = isset( $attr['class'] ) ? $attr['class'] : '';
				$class .= ' g5core__ll-image';
				$attr['class'] = $class;

				$src = isset( $attr['src'] ) ? $attr['src'] : '';
				if ( ! empty( $src ) ) {
					$attr['data-src'] = $src;
					$attr['src'] = G5CORE()->plugin_url( 'assets/images/placeholder-transparent.png' );
				}

				$srcset = isset( $attr['srcset'] ) ? $attr['srcset'] : '';
				if ( ! empty( $srcset ) ) {
					$attr['data-srcset'] = $srcset;
					unset( $attr['srcset'] );
				}

				$sizes = isset( $attr['sizes'] ) ? $attr['sizes'] : '';
				if ( ! empty( $sizes ) ) {
					$attr['data-sizes'] = $sizes;
					unset( $attr['sizes'] );
				}
			}
			return $attr;
		}

		public function change_attachment_image($html, $attachment_id, $size, $icon, $attr) {
			if ($this->is_active()) {
				$image         = wp_get_attachment_image_src( $attachment_id, $size );
				list( $src, $width, $height ) = $image;
				$html = g5core_build_lazy_img_tag($html,$width,$height);
			}
			return $html;
		}

		/**
		 * @param $element Elementor\Widget_Base
		 */
		public function elementor_lazy_load($element) {

			if (!$this->is_active()) {
				return;
			}
			$element_name = $element->get_name();
			switch ($element_name) {
				case 'section':
					$this->elementor_section_lazy_load($element);
					break;
				case 'column':
					$this->elementor_column_lazy_load($element);
					break;
				case 'ube-banner':
					$this->elementor_ube_banner_lazy_load($element);
					break;
			}
		}

		/**
		 * @param $element Elementor\Widget_Base
		 */
		public function elementor_section_lazy_load($element) {
			$settings = $element->get_settings_for_display();
			if ( 'classic' !== $settings['background_background'] || empty( $settings['background_image']['url'] ) ) {
				return;
			}

			$element->add_render_attribute( '_wrapper', [
				'class'    => 'g5core__ll-background',
				'data-bg' => $settings['background_image']['url'],
			] );
		}

		/**
		 * @param $element Elementor\Widget_Base
		 */
		public function elementor_column_lazy_load($element) {
			$settings = $element->get_settings_for_display();
			if ( 'classic' !== $settings['background_background'] || empty( $settings['background_image']['url'] ) ) {
				return;
			}

			$is_dom_optimization_active = Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
			$wrapper_attribute_string   = $is_dom_optimization_active ? '_widget_wrapper' : '_inner_wrapper';

			/**
			 * @see \Elementor\Element_Column::before_render()
			 */
			$element->add_render_attribute( $wrapper_attribute_string, [
				'class'    => 'g5core__ll-background',
				'data-bg' => $settings['background_image']['url'],
			] );
		}

		/**
		 * @param $element Elementor\Widget_Base
		 */
		public function elementor_ube_banner_lazy_load($element) {
			$settings = $element->get_settings_for_display();
			if ( empty( $settings['banner_image']['url'] ) ) {
				return;
			}

			$element->add_render_attribute( 'bg_attr', [
				'class'    => 'g5core__ll-background',
				'data-bg' => $settings['banner_image']['url'],
			] );
		}

		/**
		 * @param $element Elementor\Widget_Base
		 */
		public function elementor_ube_gallery_metro_lazy_load($element,$gallery_bg_setting_key, $gallery) {
			if (!$this->is_active()) {
				return;
			}
			if ( empty( $gallery['url'] ) ) {
				return;
			}
			$element->add_render_attribute( $gallery_bg_setting_key, 'data-bg', esc_url($gallery['url']));



		}

		public function elementor_ube_gallery_metro_lazy_load_class($classes) {
			if ( $this->is_active() ) {
				$classes[] = 'g5core__ll-background';
			}
			return $classes;
		}
	}
}