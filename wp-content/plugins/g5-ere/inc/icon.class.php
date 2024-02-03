<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5ERE_Icon')) {
	class G5ERE_Icon {
		private static $_instance;
		public static function get_instance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter('gsf_font_icon_svg',array($this,'add_font_icon_svg'));
			add_filter('g5core_get_icon_svg_config',array($this,'add_icon_svg_config'));
		}

		public function get_svg($icon) {
			return sprintf('<i class="svg-icon svg-icon-g5ere_%s"></i>',$icon);
		}

		public function add_font_icon_svg($icons) {
			return wp_parse_args($this->get_icons(), $icons) ;
		}

		public function add_icon_svg_config($svg_config) {
			$icons =  $this->get_icons();
			$icon_config = array();
			foreach ($icons as $k => $v) {
				$icon_config[] = "svg-icon svg-icon-{$k}";
			}
			$svg_config[] = array("id" => "ere","title" => esc_html__('Real Estate','g5-ere'),'icons' => $icon_config);
			return $svg_config;
		}

		public function get_icons() {
			$icons =  wp_cache_get('g5ere_svg_icon','g5ere');
			if ($icons) {
				return $icons;
			}
			$icons = array();
			$files =  list_files(G5ERE()->plugin_dir('assets/svg'));
			foreach ($files as $file) {
				$k = basename($file,'.svg');
				$content = @file_get_contents($file);

				$content = str_replace('<svg','<svg id="g5ere_'. $k .'"',$content);
				$icons["g5ere_{$k}"] = $content;
			}
			$icons =  apply_filters('g5ere_svg_icons',$icons);

			wp_cache_add('g5ere_svg_icon',$icons,'g5ere');

			return $icons;
		}
	}
}