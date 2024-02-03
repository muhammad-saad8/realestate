<?php

use Elementor\Plugin;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Core_Assets')) {
	class G5Core_Assets {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        private $_custom_js_variable = array();

		public function init() {
		    add_action('init',array($this,'register_assets'),1);
			add_action( 'wp_enqueue_scripts', array($this, 'enqueue_assets'),9);
			add_action( 'wp_enqueue_scripts', array($this, 'dequeue_assets'),19);
			add_action('wp_footer',array($this,'render_js_variable'));
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_assets' ) );
			add_action( 'template_redirect', array( $this, 'custom_css' ),20 );
			add_filter( 'upload_mimes', array($this,'change_mime_types'));
        }

        public function register_assets(){
			// Powertip
            wp_register_style('powertip', G5CORE()->asset_url('assets/vendors/jquery.powertip/jquery.powertip.css'), array(), '1.2.0');
            wp_register_style('powertip-dark', G5CORE()->asset_url('assets/vendors/jquery.powertip/jquery.powertip-dark.min.css'), array(), '1.2.0');
	        wp_register_script('powertip', G5CORE()->asset_url('assets/vendors/jquery.powertip/jquery.powertip.min.js'), array('jquery'), '1.2.0', true);

	        // Magnific Popup
	        wp_register_style('magnific-popup', G5CORE()->asset_url('assets/vendors/magnific-popup/magnific-popup.min.css'), array(), '1.1.0');
	        wp_register_script('magnific-popup', G5CORE()->asset_url('assets/vendors/magnific-popup/jquery.magnific-popup.min.js'), array('jquery'), '1.1.0', true);

	        // Ladda
	        wp_register_style('ladda', G5CORE()->asset_url('assets/vendors/ladda/ladda-themeless.min.css'), array(), '1.0.5');
	        wp_register_script('ladda-spin', G5CORE()->asset_url('assets/vendors/ladda/spin.min.js'), array('jquery'), '1.0.5', true);
	        wp_register_script('ladda', G5CORE()->asset_url('assets/vendors/ladda/ladda.min.js'), array('jquery', 'ladda-spin'), '1.0.5', true);
	        wp_register_script('ladda-jquery', G5CORE()->asset_url('assets/vendors/ladda/ladda.jquery.min.js'), array('jquery', 'ladda'), '1.0.5', true);

	        // Parslayjs
	        wp_register_script('parsleyjs', G5CORE()->asset_url('assets/vendors/parsleyjs/parsley.min.js'), array('jquery'), '2.8.1', true);

	        // HC-Sticky
	        wp_register_script('hc-sticky', G5CORE()->asset_url('assets/vendors/hc-sticky/hc-sticky.min.js'), array('jquery'), '2.2.3', true);

	        wp_register_script('jquery-nav', G5CORE()->asset_url('assets/vendors/jquery.nav/jquery.nav.min.js'), array('jquery'), '3.0.0', true);

            wp_register_script('jquery-easing', G5CORE()->asset_url('assets/vendors/jquery.easing/jquery.easing.1.3.min.js'), array('jquery'), '1.3', true);

            wp_register_script('imagesloaded', G5CORE()->asset_url('assets/vendors/imagesloaded/imagesloaded.pkgd.min.js'), array('jquery'), '1.1.0', true);
            wp_register_script('jquery-pretty-tabs', G5CORE()->asset_url('assets/vendors/pretty-tabs/jquery.pretty-tabs.min.js'), array('jquery'), '1.0', true);
            wp_register_script('isotope', G5CORE()->asset_url('assets/vendors/isotope/isotope.pkgd.min.js'), array('jquery'), '3.0.4', true);

            wp_register_script('jquery-countdown', G5CORE()->asset_url('assets/vendors/jquery.countdown/jquery.countdown.min.js'), array('jquery'), '2.2.0', true);
            wp_register_script('jquery-cookie', G5CORE()->asset_url('assets/vendors/jquery.cookie/jquery.cookie.min.js'), array('jquery'), '1.4.1', true);

            wp_register_script('perfect-scrollbar', G5CORE()->asset_url('assets/vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'), array('jquery'), '0.6.15', true);
            wp_register_style('perfect-scrollbar',G5CORE()->asset_url('assets/vendors/perfect-scrollbar/css/perfect-scrollbar.min.css'),array(),'0.6.15');


            // bootstrap
            /*wp_register_script('slim',G5CORE()->asset_url('assets/vendors/slim/slim.min.js'),array('jquery'),'3.3.1',true);
            */
            //wp_register_script('popper',G5CORE()->asset_url('assets/vendors/popper/popper.min.js'),array('jquery'),'1.14.7',true);
            wp_register_style('bootstrap',G5CORE()->asset_url('assets/vendors/bootstrap/css/bootstrap.min.css'),array(),'4.6.0');
            //wp_register_script('bootstrap',G5CORE()->asset_url('assets/vendors/bootstrap/js/bootstrap.min.js'),array('jquery','popper'),'4.3.1',true);
	        wp_register_script( 'bootstrap', G5CORE()->asset_url( 'assets/vendors/bootstrap/js/bootstrap.bundle.min.js' ), array( 'jquery' ), '4.6.0', true );

	        wp_register_style('bootstrap-select',G5CORE()->asset_url('assets/vendors/bootstrap-select/css/bootstrap-select.min.css'),array(),'1.13.14');
	        wp_register_script('bootstrap-select',G5CORE()->asset_url('assets/vendors/bootstrap-select/js/bootstrap-select.min.js'),array('jquery','bootstrap'),'1.13.14',true);
	        wp_register_script('bootstrap-select-i18n',G5CORE()->asset_url('assets/vendors/bootstrap-select/js/i18n/defaults.min.js'),array(),'1.13.14',true);
	        wp_localize_script('bootstrap-select-i18n','bootstrap_select_i18n',array(
				'noneSelectedText' => esc_attr_x('Nothing selected','bootstrap-select-i18n','g5-core'),
		        'noneResultsText' => esc_attr_x('No results matched {0}','bootstrap-select-i18n','g5-core'),
		        'countSelectedText' => array(
		            'single'	=> esc_attr_x('{0} item selected','bootstrap-select-i18n','g5-core'),
			        'multi' => esc_attr_x('{0} items selected','bootstrap-select-i18n','g5-core')
		        ),
		        'maxOptionsText' => array(
		        	'numAll' => array(
				        'single'	=> esc_attr_x('Limit reached ({n} item max)','bootstrap-select-i18n','g5-core'),
				        'multi' => esc_attr_x('Limit reached ({n} items max','bootstrap-select-i18n','g5-core')
			        ),
			        'numGroup' => array(
				        'single'	=> esc_attr_x('Group limit reached ({n} item max)','bootstrap-select-i18n','g5-core'),
				        'multi' => esc_attr_x('Group limit reached ({n} items max)','bootstrap-select-i18n','g5-core')
			        )
		        ),
		        'selectAllText' => esc_attr_x('Select All','bootstrap-select-i18n','g5-core'),
		        'deselectAllText' => esc_attr_x('Deselect All','bootstrap-select-i18n','g5-core'),
		        'multipleSeparator' =>  esc_attr_x(', ','bootstrap-select-i18n','g5-core'),
		        'doneButtonText' => esc_attr_x('Close','bootstrap-select-i18n','g5-core'),
	        ));


            // slick slider
	        wp_register_script('slick',G5CORE()->asset_url('assets/vendors/slick/slick.min.js'),array('jquery'),'1.8.1',true);
	        wp_register_style('slick', G5CORE()->asset_url('assets/vendors/slick/slick.min.css'), array(), '1.8.1');


	        // justifiedGallery
            wp_register_script('justifiedGallery',G5CORE()->asset_url('assets/vendors/justified-gallery/jquery.justifiedGallery.min.js'),array('jquery'),'3.7.0',true);
            wp_register_style('justifiedGallery', G5CORE()->asset_url('assets/vendors/justified-gallery/justifiedGallery.min.css'), array(), '3.7.0');

            // waypoints
            wp_enqueue_script('waypoints',G5CORE()->asset_url('assets/vendors/waypoints/jquery.waypoints.min.js'),array('jquery'),'4.0.1',true);

	        wp_enqueue_script('vanilla-lazyload',G5CORE()->asset_url('assets/vendors/vanilla-lazyload/lazyload.js'),array('jquery'),'17.8.2',true);

	        // Plugin assets
	        wp_register_style(G5CORE()->assets_handle('frontend'),G5CORE()->asset_url('assets/scss/frontend.min.css'),array(),G5CORE()->plugin_ver());
	        wp_register_style(G5CORE()->assets_handle('dashboard'), G5CORE()->asset_url('assets/css/dashboard.min.css'), array(), G5CORE()->plugin_ver());
	        wp_register_style(G5CORE()->assets_handle('admin'), G5CORE()->asset_url('assets/css/admin.min.css'), array(), G5CORE()->plugin_ver());

	        wp_register_script(G5CORE()->assets_handle('editor-post-layout'),G5CORE()->asset_url('assets/js/editor-post-layout.js'),array('jquery'),G5CORE()->plugin_ver(),true);
            wp_register_script(G5CORE()->assets_handle('dashboard-system-status'), G5CORE()->asset_url('assets/js/dashboard-system-status.min.js'), array('jquery'), G5CORE()->plugin_ver(), true);
	        wp_register_script(G5CORE()->assets_handle('frontend'), G5CORE()->asset_url('assets/js/frontend.min.js'), array('jquery'), G5CORE()->plugin_ver(), true);



        }

        public function enqueue_assets() {

            wp_enqueue_script('jquery-easing');


            wp_enqueue_script('bootstrap-select');
            wp_enqueue_script('bootstrap-select-i18n');
            wp_enqueue_style('bootstrap-select');
            wp_enqueue_script('bootstrap');
            wp_enqueue_style('bootstrap');

	        wp_enqueue_style('slick');
	        wp_enqueue_script('slick');

		    wp_enqueue_style('magnific-popup');
	        wp_enqueue_script('magnific-popup');

	        wp_enqueue_style('ladda');
	        wp_enqueue_script('ladda-jquery');

	        wp_enqueue_script('parsleyjs');
	        wp_enqueue_script('hc-sticky');

	        wp_enqueue_script('perfect-scrollbar');
            wp_enqueue_style('perfect-scrollbar');


            wp_enqueue_script('imagesloaded');
            wp_enqueue_script('jquery-pretty-tabs');
            wp_enqueue_script('isotope');
            wp_enqueue_script('jquery-countdown');
            wp_enqueue_script('jquery-cookie');


            wp_enqueue_script('justifiedGallery');
            wp_enqueue_style('justifiedGallery');

            wp_enqueue_script('waypoints');

	        if (is_singular()) {
		        $content_404_block = G5CORE()->options()->get_option('page_404_custom');
		        if (is_singular() || (is_404() && !empty($content_404_block))) {
			        $id = is_404() ? $content_404_block : get_the_ID();

			        $prefix = G5CORE()->meta_prefix;
			        $is_one_page = get_post_meta($id, "{$prefix}is_one_page", true);
			        if ($is_one_page === 'on') {
				        wp_enqueue_script('jquery-nav');
			        }
		        }
	        }

	        $loading_animation = G5CORE()->options()->get_option('loading_animation');
	        if (!empty($loading_animation)) {
		        wp_enqueue_style('spinkit-' . $loading_animation, G5CORE()->asset_url("assets/vendors/spinkit/{$loading_animation}.min.css"));
	        }


	        $image_lazy_load_enable = G5CORE()->options()->get_option('image_lazy_load_enable');
	        if ($image_lazy_load_enable === 'on') {
		        wp_enqueue_script('vanilla-lazyload');
	        }



	        wp_enqueue_style(G5CORE()->assets_handle('frontend'));
	        wp_enqueue_script(G5CORE()->assets_handle('frontend'));
            wp_localize_script(G5CORE()->assets_handle('frontend'), 'g5_variable', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }

        public function dequeue_assets() {
	        //wp_deregister_style('font-awesome');
        }

        public function enqueue_backend_assets() {
	        wp_enqueue_style(G5CORE()->assets_handle('admin'));
        }

        public function add_js_variable($variable, $key)
        {
            $this->_custom_js_variable[$key] = $variable;
        }

        public function render_js_variable() {
            foreach ($this->_custom_js_variable as $key => $value) {
                wp_localize_script(
                    G5CORE()->assets_handle('frontend'),
                    $key,
                    $value
                );
            }
        }
		public function custom_css() {
			/* Image Size */
			global $_wp_additional_image_sizes;
			$custom_css = '';
			foreach (get_intermediate_image_sizes() as $_size) {
				$width = $height = 0;
				if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
					$width = get_option("{$_size}_size_w");
					$height = get_option("{$_size}_size_h");
				} elseif (isset($_wp_additional_image_sizes[$_size])) {
					$width = $_wp_additional_image_sizes[$_size]['width'];
					$height = $_wp_additional_image_sizes[$_size]['height'];
				}
				if ($height > 0 && $width > 0) {
					$ratio = ($height / $width) * 100;
					$custom_css .= <<<CSS
                .g5core__image-size-{$_size}:before {
                    padding-top: {$ratio}%;
                }
CSS;
				}
			}
			G5CORE()->custom_css()->addCss( $custom_css);
		}
		public function change_mime_types($mimes ) {
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}
	}
}