<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Blog_Assets')) {
	class G5Blog_Assets {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}


		public function init() {
		    add_action('init',array($this,'register_assets'));
			add_action( 'wp_enqueue_scripts', array($this, 'enqueue_assets'));
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_assets'));
            add_action( 'template_redirect', array( $this, 'custom_css' ),20 );
        }

        public function register_assets(){
		    wp_register_script(G5BLOG()->assets_handle('post-format'),G5BLOG()->asset_url('assets/js/post-format.min.js'),array('jquery'),G5BLOG()->plugin_ver(),true);
            wp_register_script(G5BLOG()->assets_handle('frontend'),G5BLOG()->asset_url('assets/js/frontend.min.js'),array('jquery'),G5BLOG()->plugin_ver(),true);
            wp_register_style(G5BLOG()->assets_handle('frontend'),G5BLOG()->asset_url('assets/scss/frontend.min.css'),array(),G5BLOG()->plugin_ver());

		}

        public function enqueue_assets() {
            wp_enqueue_style(G5BLOG()->assets_handle('frontend'));
            wp_enqueue_script(G5BLOG()->assets_handle('frontend'));
        }

        public function admin_enqueue_assets() {
            if (g5blog_is_admin_post()) {
                wp_enqueue_script(G5BLOG()->assets_handle('post-format'));
            }
        }

        public function custom_css() {
            /* Image Size */
            $content_padding = wp_parse_args( G5CORE()->options()->layout()->get_option( 'content_padding' ), array(
                'top'    => '0',
                'bottom' => '0',
            ) );

            if (isset($content_padding['top']) && ($content_padding['top'] !== '')) {
	            $custom_css =<<<CSS
            .g5blog__single-layout-6 .g5core-page-title + .g5blog__single-featured{
                padding-top: {$content_padding['top']}px;
            }
CSS;
	            G5CORE()->custom_css()->addCss( $custom_css);
            }


        }
	}
}