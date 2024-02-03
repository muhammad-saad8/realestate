<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/options.class.php'));
}
if (!class_exists('G5Core_Options')) {
	class G5Core_Options extends G5Core_Options_Abstract {
		//protected $option_name = 'g5core_options';

		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}

		public function __construct() {
			$this->option_name = G5CORE()->options_name();
		}

		public function init_default() {
			return array (
				'back_to_top' => 'on',
				'google_map_api_key' => 'AIzaSyB_RmOPuQi5SzCecy6SyHn8M0HJtxvs2gY',
				'default_thumbnail_placeholder_enable' => '',
				'default_thumbnail_image' =>
					array (
						'id' => 0,
						'url' => '',
					),
				'first_image_as_post_thumbnail' => '',
				'search_post_types' =>
					array (
						0 => 'all',
					),
				'search_ajax_enable' => '',
				'search_popup_result_amount' => 8,
				'maintenance_mode' => 'off',
				'maintenance_mode_page' => '',
				'loading_animation' => '',
				'loading_logo' =>
					array (
						'id' => 0,
						'url' => '',
					),
				'loading_animation_bg_color' => '',
				'spinner_color' => '',
				'page_404_custom' => '',
				'social_networks' =>
					array (
						0 =>
							array (
								'social_name' => 'Facebook',
								'social_id' => 'social-facebook',
								'social_icon' => 'fab fa-facebook',
								'social_link' => '',
								'social_color' => '#3b5998',
							),
						1 =>
							array (
								'social_name' => 'Twitter',
								'social_id' => 'social-twitter',
								'social_icon' => 'fab fa-twitter',
								'social_link' => '',
								'social_color' => '#1da1f2',
							),
						2 =>
							array (
								'social_name' => 'Pinterest',
								'social_id' => 'social-pinterest',
								'social_icon' => 'fab fa-pinterest',
								'social_link' => '',
								'social_color' => '#bd081c',
							),
						3 =>
							array (
								'social_name' => 'Dribbble',
								'social_id' => 'social-dribbble',
								'social_icon' => 'fab fa-dribbble',
								'social_link' => '',
								'social_color' => '#00b6e3',
							),
						4 =>
							array (
								'social_name' => 'LinkedIn',
								'social_id' => 'social-linkedin',
								'social_icon' => 'fab fa-linkedin',
								'social_link' => '',
								'social_color' => '#0077b5',
							),
						5 =>
							array (
								'social_name' => 'Vimeo',
								'social_id' => 'social-vimeo',
								'social_icon' => 'fab fa-vimeo',
								'social_link' => '',
								'social_color' => '#1ab7ea',
							),
						6 =>
							array (
								'social_name' => 'Tumblr',
								'social_id' => 'social-tumblr',
								'social_icon' => 'fab fa-tumblr',
								'social_link' => '',
								'social_color' => '#35465c',
							),
						7 =>
							array (
								'social_name' => 'Skype',
								'social_id' => 'social-skype',
								'social_icon' => 'fab fa-skype',
								'social_link' => '',
								'social_color' => '#00aff0',
							),
						9 =>
							array (
								'social_name' => 'Flickr',
								'social_id' => 'social-flickr',
								'social_icon' => 'fab fa-flickr',
								'social_link' => '',
								'social_color' => '#ff0084',
							),
						10 =>
							array (
								'social_name' => 'YouTube',
								'social_id' => 'social-youTube',
								'social_icon' => 'fab fa-youtube',
								'social_link' => '',
								'social_color' => '#cd201f',
							),
						11 =>
							array (
								'social_name' => 'Instagram',
								'social_id' => 'social-instagram',
								'social_icon' => 'fab fa-instagram',
								'social_link' => '',
								'social_color' => '#405de6',
							),
						12 =>
							array (
								'social_name' => 'GitHub',
								'social_id' => 'social-gitHub',
								'social_icon' => 'fab fa-github',
								'social_link' => '',
								'social_color' => '#4078c0',
							),
						13 =>
							array (
								'social_name' => 'Behance',
								'social_id' => 'social-behance',
								'social_icon' => 'fab fa-behance',
								'social_link' => '',
								'social_color' => '#1769ff',
							),
						14 =>
							array (
								'social_name' => 'Sound Cloud',
								'social_id' => 'social-soundCloud',
								'social_icon' => 'fab fa-soundcloud',
								'social_link' => '',
								'social_color' => '#ff8800',
							),
						15 =>
							array (
								'social_name' => 'RSS Feed',
								'social_id' => 'social-rss',
								'social_icon' => 'fa fa-rss',
								'social_link' => '',
								'social_color' => '#f26522',
							),
						16 =>
							array (
								'social_name' => 'Email',
								'social_id' => 'social-email',
								'social_icon' => 'fa fa-envelope',
								'social_link' => '',
								'social_color' => '#464646',
							),
					),
				'custom_css' => '',
				'custom_js' => '',
				'single_social_share' =>
					array (
						'facebook' => 'facebook',
						'twitter' => 'twitter',
						'linkedin' => 'linkedin',
						'tumblr' => 'tumblr',
						'pinterest' => 'pinterest',
					),
			);
		}

		//////////////////////////////////////////////////////////////////////////////
		// Other options
		//////////////////////////////////////////////////////////////////////////////

		/**
		 * @return G5Core_Options_Header
		 */
		public function header() {
			return G5Core_Options_Header::getInstance();
		}

		/**
		 * @return G5Core_Options_Footer
		 */
		public function footer() {
			return G5Core_Options_Footer::getInstance();
		}

		/**
		 * @return G5Core_Options_Layout
		 */
		public function layout() {
			return G5Core_Options_Layout::getInstance();
		}

		/**
		 * @return G5Core_Options_Page_Title
		 */
		public function page_title() {
			return G5Core_Options_Page_Title::getInstance();
		}

		/**
		 * @return G5Core_Options_Typography
		 */
		public function typography() {
			return G5Core_Options_Typography::getInstance();
		}

		/**
		 * @return G5Core_Options_Color
		 */
		public function color() {
			return G5Core_Options_Color::getInstance();
		}

	}
}