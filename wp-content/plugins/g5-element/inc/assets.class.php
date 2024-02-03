<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'G5Element_Assets' ) ) {
	class G5Element_Assets {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'init', array( $this, 'register_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_assets' ) );
			if ( ! is_admin() ) {
				add_action( 'template_redirect', array( $this, 'global_custom_css' ), 20 );
			}

			//add_action( 'vc_frontend_editor_render', array( $this, 'enqueueJsFrontend' ) );
		}

		public function enqueueJsFrontend() {
			wp_enqueue_script( 'slider-container-frontend-editor', G5ELEMENT()->asset_url( 'assets/frontend-editor/slider-container.min.js'), array( 'jquery' ), false, true );
		}


		public function shortcode_assets() {
			if ( G5CORE()->cache()->exists( 'g5element_shortcode_assets_list' ) ) {
				return G5CORE()->cache()->get( 'g5element_shortcode_assets_list', array() );
			}
			$shortcode_list = apply_filters( 'g5element_shortcode_assets', array(
				'banner'                            => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/banner.min.css' ),
					'js'  => '',
				),
				'button'                            => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/button.min.css' ),
					'js'  => '',
				),
				'breadcrumbs'                       => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/breadcrumbs.min.css' ),
					'js'  => '',
				),
				'client_logo'                       => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/client-logo.min.css' ),
					'js'  => '',
				),
				'counter'                           => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/counter.min.css' ),
					'js'  => G5ELEMENT()->asset_url( 'assets/shortcode-js/countUp.min.js' ),
				),
				'count_down'                        => array(
					'css'     => G5ELEMENT()->asset_url( 'assets/shortcode-css/count-down.min.css' ),
					'js'      => G5ELEMENT()->asset_url( 'assets/shortcode-js/count-down.min.js' ),
					'js_deps' => array( 'jquery-knob', 'jquery-countdown' ),
				),
				'google_map'                        => array(
					'css'     => G5ELEMENT()->asset_url( 'assets/shortcode-css/google-map.min.css' ),
					'js'      => G5ELEMENT()->asset_url( 'assets/shortcode-js/google-map.min.js' ),
					'js_deps' => array( 'gmap3' ),
				),
				'heading'                           => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/heading.min.css' ),
					'js'  => '',
				),
				'icon_box'                          => array(
					'css'     => G5ELEMENT()->asset_url( 'assets/shortcode-css/icon-box.min.css' ),
					'js'      => G5ELEMENT()->asset_url( 'assets/shortcode-js/icon-box.min.js' ),
					'js_deps' => array( 'jquery-vivus' ),
				),
				'image_box'                         => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/image-box.min.css' ),
					'js'  => '',
				),
				'layout_container'                  => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/layout-container.min.css' ),
				),
				'list'                              => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/list.min.css' ),
					'js'  => '',
				),
				'our_team'                          => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/our-team.min.css' ),
					'js'  => '',
				),
				'page_title'                        => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/page-title.min.css' ),
					'js'  => '',
				),
				'pricing_table'                     => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/pricing-table.min.css' ),
					'js'  => '',
				),
				'slider_container'                  => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/slider-container.min.css' ),
					'js'  => G5ELEMENT()->asset_url( 'assets/shortcode-js/slider-container.min.js' ),
				),
				'social_icons'                      => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/social-icons.min.css' ),
					'js'  => '',
				),
				'video'                             => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/video.min.css' ),
					'js'  => '',
				),
				'testimonial'                       => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/testimonial.min.css' ),
					'js'  => '',
				),
				'gallery'                       => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/gallery.min.css' ),
					'js'  => '',
				),
				'image_marker'                      => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/image-marker.min.css' ),
					'js'  => G5ELEMENT()->asset_url( 'assets/shortcode-js/image-marker.min.js' ),
				),
				'map_box'                           => array(
					'css'      => G5ELEMENT()->asset_url( 'assets/shortcode-css/map-box.min.css' ),
					'js'       => G5ELEMENT()->asset_url( 'assets/shortcode-js/map-box.min.js' ),
					'js_deps'  => array( 'mapbox-gl' ),
					'css_deps' => array( 'mapbox-gl' )
				),
				'bullet_one_page_scroll_navigation' => array(
					'css' => G5ELEMENT()->asset_url( 'assets/shortcode-css/bullet-one-page-scroll-navigation.min.css' ),
					'js'  => G5ELEMENT()->asset_url( 'assets/shortcode-js/bullet-one-page-scroll-navigation.min.js' ),
				),
			) );

			G5CORE()->cache()->set( 'g5element_shortcode_assets_list', $shortcode_list );

			return $shortcode_list;
		}

		public function enqueue_assets_for_shortcode( $shortcode_name ) {
			$shortcode_list = $this->shortcode_assets();
			$shortcode_src  = isset( $shortcode_list[ $shortcode_name ] ) ? $shortcode_list[ $shortcode_name ] : array();

			if ( ! empty( $shortcode_src ) ) {
				if ( isset( $shortcode_src['css'] ) && ! empty( $shortcode_src['css'] ) ) {
					wp_enqueue_style( G5ELEMENT()->assets_handle( $shortcode_name ) );
				}
				if ( isset( $shortcode_src['js'] ) && ! empty( $shortcode_src['js'] ) ) {
					wp_enqueue_script( G5ELEMENT()->assets_handle( $shortcode_name ) );
				}
			}
		}

		public function register_assets() {
			// Vendor assets
			wp_register_script( 'jquery-parallax', G5ELEMENT()->asset_url( 'assets/vendors/parallax/jquery.parallax.min.js' ), array( 'jquery' ), '1.1.3', true );
			wp_register_script( 'jquery-countdown', G5ELEMENT()->asset_url( 'assets/vendors/countdown/countdown.min.js' ), array( 'jquery' ), '2.2.0', true );
			wp_register_script( 'jquery-knob', G5ELEMENT()->asset_url( 'assets/vendors/knob/knob.min.js' ), array( 'jquery' ), '1.2.12', true );
			//wp_register_script( 'jquery-waypoints', G5ELEMENT()->asset_url( 'assets/vendors/waypoints/jquery.waypoints.min.js' ), array( 'jquery' ), '4.0.1', true );
			wp_register_script( 'gmap3', G5ELEMENT()->asset_url( 'assets/vendors/gmap3/gmap3.min.js' ), array( 'jquery' ), G5ELEMENT()->plugin_ver(), true );
			wp_register_script( 'jquery-vivus', G5ELEMENT()->asset_url( 'assets/vendors/vivus/vivus.min.js' ), array( 'jquery' ), '0.4.5', true );


			wp_register_script( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.js', array(), '0.52.0', true );
			wp_register_style( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.css', array(), '0.52.0' );
			// Shortcode assets
			foreach ( $this->shortcode_assets() as $shortcode_name => $shortcode_src ) {
				if ( ! empty( $shortcode_src ) ) {
					if ( isset( $shortcode_src['css'] ) && ! empty( $shortcode_src['css'] ) ) {
						wp_register_style( G5ELEMENT()->assets_handle( $shortcode_name ), $shortcode_src['css'],
							isset( $shortcode_src['css_deps'] ) ? $shortcode_src['css_deps'] : array(),
							G5ELEMENT()->plugin_ver() );
					}
					if ( isset( $shortcode_src['js'] ) && ! empty( $shortcode_src['js'] ) ) {
						wp_register_script( G5ELEMENT()->assets_handle( $shortcode_name ), $shortcode_src['js'],
							isset( $shortcode_src['js_deps'] ) ? $shortcode_src['js_deps'] : array( 'jquery' ),
							G5ELEMENT()->plugin_ver(), true );
					}
				}
			}

			// Plugin assets
			wp_register_style( G5ELEMENT()->assets_handle( 'vc-backend' ), G5ELEMENT()->asset_url( 'assets/css/vc-backend.min.css' ), array(), G5ELEMENT()->plugin_ver() );
			wp_register_script( G5ELEMENT()->assets_handle( 'vc-backend' ), G5ELEMENT()->asset_url( 'assets/js/vc-backend.min.js' ), array( 'jquery' ), G5ELEMENT()->plugin_ver(), true );

			wp_register_style( G5ELEMENT()->assets_handle( 'vc-frontend' ), G5ELEMENT()->asset_url( 'assets/css/vc-frontend.min.css' ), array(), G5ELEMENT()->plugin_ver() );
			wp_register_script( G5ELEMENT()->assets_handle( 'element' ), G5ELEMENT()->asset_url( 'assets/js/element.min.js' ), array( 'jquery' ), G5ELEMENT()->plugin_ver(), true );
		}


		public function enqueue_backend_assets( $hook ) {
			if ( ( ( $hook === 'post-new.php' ) || ( $hook === 'post.php' ) ) && class_exists( 'Vc_Manager' ) && Vc_Manager::getInstance()->backendEditor()->isValidPostType() ) {
				wp_enqueue_style( G5ELEMENT()->assets_handle( 'vc-backend' ) );
				wp_enqueue_script( G5ELEMENT()->assets_handle( 'vc-backend' ) );

				$id = 0;
				if ( $hook === 'post.php' ) {
					global $post;
					$id = $post->ID;
				}


				$custom_css = $this->admin_custom_css( $id );

				wp_add_inline_style( G5ELEMENT()->assets_handle( 'vc-backend' ), $custom_css );

			}
		}

		public function enqueue_assets() {
			wp_enqueue_script( 'jquery-parallax' );
			//wp_enqueue_script('jquery-waypoints');

			if ( is_singular() ) {
				global $post;
				if ( isset( $post ) && isset( $post->post_content ) ) {
					$this->enqueue_shortcode_assets( $post->post_content );
				}
			}


			$custom_css = '';

			$content_block_ids = g5core_get_content_block_ids();
			if ($content_block_ids != false) {
				foreach ( $content_block_ids as $content_block_id ) {
					if ( $content_block_id !== '' ) {

						$post_custom_css = get_post_meta( $content_block_id, '_wpb_post_custom_css', true );

						if ( ! empty( $post_custom_css ) ) {
							$custom_css .= $post_custom_css;
						}

						$shortcodes_custom_css = get_post_meta( $content_block_id, '_wpb_shortcodes_custom_css', true );
						if ( ! empty( $shortcodes_custom_css ) ) {
							$custom_css .= $shortcodes_custom_css;
						}

						$content = get_post_field( 'post_content', $content_block_id );
						G5ELEMENT()->assets()->enqueue_shortcode_assets( $content );
						wp_enqueue_style( 'js_composer_front' );
						wp_enqueue_script( 'wpb_composer_front_js' );
					}
				}
			}

			G5CORE()->custom_css()->addCss( $custom_css );


			wp_enqueue_style( G5ELEMENT()->assets_handle( 'vc-frontend' ) );
			wp_enqueue_script( G5ELEMENT()->assets_handle( 'element' ) );

			$mapbox_api_access_token = G5CORE()->options()->get_option( 'mapbox_api_access_token' );
			wp_localize_script( G5ELEMENT()->assets_handle( 'map_box' ), 'g5element_map_box_config', array(
				'accessToken' => $mapbox_api_access_token,

			) );
		}

		public function enqueue_shortcode_assets( $content ) {
			$shortcode_assets = $this->shortcode_assets();
			$pattern          = '/(\[g5element_' . implode( ')|(\[g5element_', array_keys( $shortcode_assets ) ) . ')/';

			if ( preg_match_all( $pattern, $content, $matchs ) ) {
				$shortcode_exists = array_unique( $matchs[0] );

				foreach ( $shortcode_exists as $shortcode_name ) {
					$shortcode_name = substr( $shortcode_name, 11 );

					$this->enqueue_assets_for_shortcode( $shortcode_name );
				}
			}
		}

		public function admin_custom_css( $id ) {

			if ( function_exists( 'G5CORE' ) ) {
				$prefix       = G5CORE()->meta_prefix;
				$color_preset = get_post_meta( $id, "{$prefix}color_preset", true );
				if ( ! empty( $color_preset ) ) {
					G5CORE()->options()->color()->set_preset( $color_preset );
				}
			}
			$accent_color          = G5CORE()->options()->color()->get_option( 'accent_color' );
			$accent_color_contract = g5core_color_contrast( $accent_color );

			$primary_color          = G5CORE()->options()->color()->get_option( 'primary_color' );
			$primary_color_contract = g5core_color_contrast( $primary_color );

			$secondary_color          = G5CORE()->options()->color()->get_option( 'secondary_color' );
			$secondary_color_contract = g5core_color_contrast( $secondary_color );

			$light_color          = G5CORE()->options()->color()->get_option( 'light_color' );
			$light_color_contract = g5core_color_contrast( $light_color );

			$dark_color          = G5CORE()->options()->color()->get_option( 'dark_color' );
			$dark_color_contract = g5core_color_contrast( $dark_color );

			$gray_color          = G5CORE()->options()->color()->get_option( 'gray_color' );
			$gray_color_contract = g5core_color_contrast( $gray_color );

			return <<<CUSTOM_CSS
				[data-vc-shortcode] .vc_colored-dropdown .accent {
					background-color: {$accent_color};
					color: {$accent_color_contract};
				}
				[data-vc-shortcode] .vc_colored-dropdown .primary {
					background-color: {$primary_color};
					color: {$primary_color_contract};
				}
				[data-vc-shortcode] .vc_colored-dropdown .secondary {
					background-color: {$secondary_color};
					color: {$secondary_color_contract};
				}
				[data-vc-shortcode] .vc_colored-dropdown .light {
					background-color: {$light_color};
					color: {$light_color_contract};
				}
				[data-vc-shortcode] .vc_colored-dropdown .dark {
					background-color: {$dark_color};
					color: {$dark_color_contract};
				}
				[data-vc-shortcode] .vc_colored-dropdown .gray {
					background-color: {$gray_color};
					color: {$gray_color_contract};
				}
CUSTOM_CSS;
		}

		public function global_custom_css() {
			G5CORE()->custom_css()->addCss( $this->vc_custom_site_color(), 'g5element_vc_custom_site_color' );
			G5CORE()->custom_css()->addCss( $this->vc_tab_css(), 'vc_tab_css' );
			G5CORE()->custom_css()->addCss( $this->vc_faq_css(), 'vc_faq_css' );
		}

		public function vc_custom_site_color() {
			$color_keys = array(
				'accent',
				'primary',
				'secondary',
			);
			$css        = '';
			foreach ( $color_keys as $key ) {
				$color      = G5CORE()->options()->color()->get_option( "{$key}_color" );
				$color_text = g5core_color_contrast( $color, '#fff', '#000' );

				$css .= <<<CUSTOM_CSS
					.vc_progress_bar .vc_general.vc_single_bar.vc_progress-bar-color-{$key} .vc_bar,
					.vc_progress_bar.vc_progress-bar-color-{$key} .vc_single_bar .vc_bar {
					    background-color: {$color};
					}
					.vc_progress_bar .vc_general.vc_single_bar.vc_progress-bar-color-{$key} .vc_label,
					.vc_progress_bar.vc_progress-bar-color-{$key} .vc_single_bar .vc_label {
					    color: $color_text;
					}
CUSTOM_CSS;
			}

			return $css;
		}


		private function vc_tab_css() {
			if ( is_singular() ) {
				global $post;
				if ( isset( $post ) && isset( $post->post_content ) ) {
					if ( g5element_shortcode_exists( 'vc_tta_', $post->post_content ) ) {
						$accent_color    = G5CORE()->options()->color()->get_option( 'accent_color' );
						$primary_color   = G5CORE()->options()->color()->get_option( 'primary_color' );
						$secondary_color = G5CORE()->options()->color()->get_option( 'secondary_color' );
						$custom_css      = '';
						$custom_css      .= $this->get_vc_tab_css( 'accent', $accent_color, '#f0f0f0', '#666', g5core_color_contrast( $accent_color, '#fff', '#1b1b1b' ) );
						$custom_css      .= $this->get_vc_tab_css( 'primary', $primary_color, '#f0f0f0', '#666', g5core_color_contrast( $primary_color, '#fff', '#1b1b1b' ) );
						$custom_css      .= $this->get_vc_tab_css( 'secondary', $secondary_color, '#f0f0f0', '#666', g5core_color_contrast( $secondary_color, '#fff', '#1b1b1b' ) );
						$custom_css      .= 'body.wpb-js-composer .vc_tta.vc_tta-o-no-fill .vc_tta-panels .vc_tta-panel-body {border-color: transparent;background-color: transparent;}';

						return $custom_css;
					}
				}
			}

			return '';
		}

		private function get_vc_tab_css( $color_name, $color_code, $panel_bg_color, $panel_title_color, $panel_contrast_color ) {
			$color_code_darken_10     = g5core_color_darken( $color_code, '10%' );
			$color_code_darken_15     = g5core_color_darken( $color_code, '15%' );
			$panel_bg_color_darken_10 = g5core_color_darken( $panel_bg_color, '10%' );


			return <<<CUSTOM_CSS
        body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-heading {
		border-color: {$color_code_darken_10};
		background-color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-heading:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-heading:hover {
		background-color: {$color_code_darken_10}
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title>a {
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-heading {
		border-color: {$panel_bg_color_darken_10};
		background-color: {$panel_bg_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title>a {
		color: {$panel_title_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-body {
		background-color: {$panel_bg_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-body,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-body::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-body::before {
		border-color: {$panel_bg_color_darken_10};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-controls-icon::before {
		border-color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::before {
		border-color: {$panel_title_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-tab>a {
		border-color: {$color_code_darken_10};
		background-color: $color_code;
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-tab>a:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-tab>a:hover {
		background-color: {$color_code_darken_15};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic .vc_tta-tab.vc_active>a {
		border-color: {$panel_bg_color_darken_10};
		background-color: {$panel_bg_color};
		color: {$panel_title_color};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels {
		background-color: {$panel_bg_color};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels,body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels::after,body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels::before,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels::after,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels::before {
		border-color: {$panel_bg_color_darken_10};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
		border-color: transparent;
		background-color: transparent;
	}

	@media (min-width: 768px) {
		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels {
			background-color:{$panel_bg_color};
		}

		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels::before {
			border-color: {$panel_bg_color_darken_10};
		}

		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
			border-color: transparent;
			background-color: transparent;
		}
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-heading {
		border-color: {$color_code_darken_10};
		background-color: $color_code;
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-heading:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-heading:hover {
		background-color: {$color_code_darken_10};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-title>a {
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel.vc_active .vc_tta-panel-heading {
		border-color: {$panel_bg_color_darken_10};
		background-color: {$panel_bg_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel.vc_active .vc_tta-panel-title>a {
		color: {$panel_title_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-body {
		background-color: {$panel_bg_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-body,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-body::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-panel .vc_tta-panel-body::before {
		border-color: {$panel_bg_color_darken_10};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-controls-icon::before {
		border-color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::before {
		border-color: {$panel_title_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-tab>a {
		border-color: {$color_code_darken_10};
		background-color: $color_code;
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-tab>a:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-tab>a:hover {
		background-color: {$color_code_darken_15};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern .vc_tta-tab.vc_active>a {
		border-color: {$panel_bg_color_darken_10};
		background-color: {$panel_bg_color};
		color: {$panel_title_color};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels {
		background-color: {$panel_bg_color};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels,body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels::after,body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels::before,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels::after,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels::before {
		border-color: {$panel_bg_color_darken_10};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
		border-color: transparent;
		background-color: transparent;
	}

	@media (min-width: 768px) {
		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels {
			background-color:{$panel_bg_color};
		}

		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels::before {
			border-color: {$panel_bg_color_darken_10};
		}

		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-modern.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
			border-color: transparent;
			background-color: transparent;
		}
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-heading {
		border-color: {$color_code};
		background-color: transparent;
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-heading:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-heading:hover {
		background-color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-title>a {
		color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-title>a:hover {
		color: {$panel_contrast_color}
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel.vc_active .vc_tta-panel-heading {
		border-color: {$color_code};
		background-color: transparent;
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel.vc_active .vc_tta-panel-title>a {
		color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-body {
		background-color: transparent;
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-body,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-body::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel .vc_tta-panel-body::before {
		border-color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-controls-icon::before {
		border-color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel-heading:focus .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel-heading:focus .vc_tta-controls-icon::before,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel-heading:hover .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-panel-heading:hover .vc_tta-controls-icon::before {
		border-color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::before {
		border-color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-tab>a {
		border-color: {$color_code};
		background-color: transparent;
		color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-tab>a:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-tab>a:hover {
		background-color: {$color_code};
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline .vc_tta-tab.vc_active>a {
		border-color: {$color_code};
		background-color: transparent;
		color: {$color_code};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels {
		background-color: transparent;
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels,body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels::after,body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels::before,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels::after,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels::before {
		border-color: {$color_code};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
		border-color: transparent;
		background-color: transparent;
	}

	@media (min-width: 768px) {
		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels {
			background-color:transparent;
		}

		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels::before {
			border-color: {$color_code};
		}

		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-outline.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
			border-color: transparent;
			background-color: transparent;
		}
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-heading {
		background-color: {$color_code_darken_10};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-heading:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-heading:hover {
		background-color: {$color_code_darken_15};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-title>a {
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-panel.vc_active .vc_tta-panel-heading {
		background-color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-panel.vc_active .vc_tta-panel-title>a {
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-body {
		background-color: {$color_code};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat:not(.vc_tta-o-no-fill) .vc_tta-panel-body {
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-controls-icon::before {
		border-color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::after,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::before {
		border-color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-tab>a {
		background-color: {$color_code_darken_10};
		color: {$panel_contrast_color};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-tab>a:focus,body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-tab>a:hover {
		background-color: {$color_code_darken_15};
	}

	body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat .vc_tta-tab.vc_active>a {
		background-color: {$color_code};
		color: {$panel_contrast_color};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels {
		background-color: {$color_code};
	}

	body.vc_non_responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body,.vc_tta-o-non-responsive body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
		border-color: transparent;
		background-color: transparent;
	}

	@media (min-width: 768px) {
		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels {
			background-color:{$color_code};
		}

		body.wpb-js-composer .vc_tta-color-{$color_name}.vc_tta-style-flat.vc_tta-tabs .vc_tta-panels .vc_tta-panel-body {
			border-color: transparent;
			background-color: transparent;
		}
	}


CUSTOM_CSS;

		}


		private function vc_faq_css() {
			if ( is_singular() ) {
				global $post;
				if ( isset( $post ) && isset( $post->post_content ) ) {
					if ( g5element_shortcode_exists( 'vc_toggle', $post->post_content ) ) {
						$accent_color    = G5CORE()->options()->color()->get_option( 'accent_color' );
						$primary_color   = G5CORE()->options()->color()->get_option( 'primary_color' );
						$secondary_color = G5CORE()->options()->color()->get_option( 'secondary_color' );
						$custom_css      = '';
						$custom_css      .= $this->get_vc_faq_css( 'accent', $accent_color );
						$custom_css      .= $this->get_vc_faq_css( 'primary', $primary_color );
						$custom_css      .= $this->get_vc_faq_css( 'secondary', $secondary_color );

						return $custom_css;
					}
				}
			}

			return '';
		}

		private function get_vc_faq_css( $color_name, $color_code ) {
			$color_code_darken_10  = g5core_color_darken( $color_code, '10%' );
			$color_code_lighten_10 = g5core_color_lighten( $color_code, '10%' );
			$color_code_foreground = g5core_color_contrast( $color_code );

			return <<<CSS

.vc_toggle_color_{$color_name}.vc_toggle_simple .vc_toggle_icon {
    background-color: transparent;
    border-color: transparent;
}

.vc_toggle_color_{$color_name}.vc_toggle_simple .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_simple .vc_toggle_icon::before {
    background-color: {$color_code};
}

.vc_toggle_color_{$color_name}.vc_toggle_simple.vc_toggle_color_inverted .vc_toggle_icon {
    background-color: transparent;
    border-color: transparent;
}

.vc_toggle_color_{$color_name}.vc_toggle_simple.vc_toggle_color_inverted .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_simple.vc_toggle_color_inverted .vc_toggle_icon::before {
    background-color: transparent;
}

.vc_toggle_color_{$color_name}.vc_toggle_simple .vc_toggle_title:hover .vc_toggle_icon {
    background-color: transparent;
}

.vc_toggle_color_{$color_name}.vc_toggle_simple .vc_toggle_title:hover .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_simple .vc_toggle_title:hover .vc_toggle_icon::before {
    background-color: {$color_code_lighten_10};
}

.vc_toggle_color_{$color_name}.vc_toggle_simple.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon {
    background-color: transparent;
    border-color: transparent;
}

.vc_toggle_color_{$color_name}.vc_toggle_simple.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_simple.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon::before {
    background-color: transparent;
}

.vc_toggle_color_{$color_name} .vc_toggle_icon {
    background-color: {$color_code};
    border-color: transparent;
}

.vc_toggle_color_{$color_name} .vc_toggle_icon::after,
.vc_toggle_color_{$color_name} .vc_toggle_icon::before {
    background-color: {$color_code_foreground};
}

.vc_toggle_color_{$color_name}.vc_toggle_color_inverted .vc_toggle_icon {
    background-color: transparent;
    border-color: {$color_code};
}

.vc_toggle_color_{$color_name}.vc_toggle_color_inverted .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_color_inverted .vc_toggle_icon::before {
    background-color: {$color_code};
}

.vc_toggle_color_{$color_name} .vc_toggle_title:hover .vc_toggle_icon {
    background-color: {$color_code_lighten_10};
}

.vc_toggle_color_{$color_name} .vc_toggle_title:hover .vc_toggle_icon::after,
.vc_toggle_color_{$color_name} .vc_toggle_title:hover .vc_toggle_icon::before {
    background-color: {$color_code_foreground};
}

.vc_toggle_color_{$color_name}.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon {
    background-color: transparent;
    border-color: {$color_code_lighten_10};
}

.vc_toggle_color_{$color_name}.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_color_inverted .vc_toggle_title:hover .vc_toggle_icon::before {
    background-color: {$color_code_lighten_10};
}

.vc_toggle_color_{$color_name}.vc_toggle_default .vc_toggle_icon {
    background: {$color_code};
    border-color: {$color_code_darken_10};
}

.vc_toggle_color_{$color_name}.vc_toggle_default .vc_toggle_icon::before {
    border-color: {$color_code_darken_10};
    background: {$color_code};
}

.vc_toggle_color_{$color_name}.vc_toggle_default .vc_toggle_icon::after {
    background: {$color_code};
}

.vc_toggle_color_{$color_name}.vc_toggle_default .vc_toggle_title:hover .vc_toggle_icon {
    background: {$color_code_lighten_10};
    border-color: {$color_code};
}

.vc_toggle_color_{$color_name}.vc_toggle_default .vc_toggle_title:hover .vc_toggle_icon::before {
    border-color: {$color_code};
    background: {$color_code_lighten_10};
}

.vc_toggle_color_{$color_name}.vc_toggle_default .vc_toggle_title:hover .vc_toggle_icon::after {
    background: {$color_code_lighten_10};
}

.vc_toggle_color_{$color_name}.vc_toggle_arrow .vc_toggle_icon {
    background: 0 0;
}

.vc_toggle_color_{$color_name}.vc_toggle_arrow .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_arrow .vc_toggle_icon::before {
    border-color: {$color_code};
    background: 0 0;
}

.vc_toggle_color_{$color_name}.vc_toggle_arrow .vc_toggle_title:hover .vc_toggle_icon {
    background: 0 0;
}

.vc_toggle_color_{$color_name}.vc_toggle_arrow .vc_toggle_title:hover .vc_toggle_icon::after,
.vc_toggle_color_{$color_name}.vc_toggle_arrow .vc_toggle_title:hover .vc_toggle_icon::before {
    border-color: {$color_code_lighten_10};
    background: 0 0;
}

CSS;

		}
	}
}