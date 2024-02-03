<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Dashboard' ) ) {
	class G5Core_Dashboard {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ), 1 );
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 81 );
			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));


			if (function_exists('GID')) {
				$this->install_demo()->init();
			}

            if ($this->is_dashboard_page('system')) {
                $this->system_status()->init();
            }
		}

        public function admin_enqueue() {

            if ($this->is_dashboard_page()) {
                wp_enqueue_style(G5CORE()->assets_handle('dashboard'));
            }

        }

		public function admin_menu() {
			$current_theme      = wp_get_theme();
			$current_theme_name = $current_theme->get( 'Name' );
			add_menu_page(
				$current_theme_name,
				$current_theme_name,
				'manage_options',
				'g5core_welcome',
				array( $this, 'render_content' ),
				'dashicons-lightbulb',
				30
			);

			$pages = $this->get_config_pages();
			foreach ( $pages as $key => $value ) {
			    if (isset($value['link'])) continue;
				add_submenu_page(
					'g5core_welcome',
					$value['page_title'],
					$value['menu_title'],
					'manage_options',
					"g5core_{$key}",
					$value['function_binder']
				);
			}

			add_menu_page(
				esc_html__('Theme Options','g5-core'),
				esc_html__('Theme Options','g5-core'),
				'manage_options',
				'g5core_options',
				array( $this, 'render_content' ),
				'dashicons-admin-settings',
				30
			);
		}

		public function get_config_pages() {
			$page_configs = array();
			$page_configs['welcome'] = array(
				'page_title'      => esc_html__( 'Welcome', 'g5-core' ),
				'menu_title'      => esc_html__( 'Welcome', 'g5-core' ),
				'priority'        => 10,
				'function_binder' => array($this->welcome(),'render_content'),
			);
			$page_configs['plugins'] = array(
				'page_title'      => esc_html__( 'Plugins', 'g5-core' ),
				'menu_title'      => esc_html__( 'Plugins', 'g5-core' ),
				'priority'        => 20,
				'function_binder' => array($this->plugins(),'render_content')
			);
			$page_configs['system'] = array(
				'page_title'      => esc_html__( 'System', 'g5-core' ),
				'menu_title'      => esc_html__( 'System', 'g5-core' ),
				'priority'        => 30,
				'function_binder' => array($this->system_status(),'render_content')
			);
			$page_configs['fonts_management'] = array(
				'menu_title' => esc_html__( 'Fonts Management', 'g5-core' ),
				'priority'        => 40,
				'link' => admin_url('admin.php?page=g5core_fonts_management')
			);

			$page_configs = apply_filters( 'g5core_dashboard_menu', $page_configs);
			uasort($page_configs, 'g5core_sort_by_priority');
			return $page_configs;
		}

		public function render_content() {

		}

		public function admin_bar_menu($admin_bar) {
			$current_theme = wp_get_theme();
			$current_theme_name = $current_theme->get('Name');

			$admin_bar->add_node(array(
				'id' => 'g5core-parent-welcome',
				'title' => sprintf('<span class="ab-icon"></span><span class="ab-label">%s</span>',$current_theme_name),
				'href' => admin_url("admin.php?page=g5core_welcome"),
			));

			$pages = $this->get_config_pages();

			foreach ($pages as $key => $value) {
				$href = isset($value['link']) ? $value['link'] :  admin_url("admin.php?page=g5core_{$key}");
				$admin_bar->add_node(array(
					'id' => "{$key}",
					'title' => $value['menu_title'],
					'href' => $href,
					'parent' => 'g5core-parent-welcome'
				));
			}

			$admin_bar_theme_options = apply_filters('g5core_admin_bar_theme_options', array(
				'g5core_options' => array(
					'title' => esc_html__('Settings','g5-core'),
					'permission' => 'manage_options',
				),
				'g5core_header_options' => array(
					'title' => esc_html__('Header','g5-core'),
					'permission' => 'manage_options',
				),
				'g5core_footer_options' => array(
					'title' => esc_html__('Footer','g5-core'),
					'permission' => 'manage_options',
				),
				'g5core_layout_options' => array(
					'title' => esc_html__('Layout','g5-core'),
					'permission' => 'manage_options',
				),
				'g5core_page_title_options' => array(
					'title' => esc_html__('Page Title','g5-core'),
					'permission' => 'manage_options',
				),
				'g5core_color_options' => array(
					'title' => esc_html__('Color','g5-core'),
					'permission' => 'manage_options',
				),
				'g5core_typography_options' => array(
					'title' => esc_html__('Typography','g5-core'),
					'permission' => 'manage_options',
				),
			));
			if (!empty($admin_bar_theme_options)) {
				$admin_bar->add_node(array(
					'id' => 'g5core-theme-options',
					'title' => sprintf('<span class="ab-icon"></span><span class="ab-label">%s</span>',esc_html__('Theme Options','g5-core')),
					'href' => admin_url("admin.php?page=g5core_options"),
				));

				$current_post_type = g5core_get_current_post_type();
				$content_404_block = G5CORE()->options()->get_option( 'page_404_custom' );


				if ( is_singular() || ( is_404() && ! empty( $content_404_block ) ) ) {
					$id = is_404() ? $content_404_block : get_the_ID();

					$prefix = G5CORE()->meta_prefix;

					$header_preset = get_post_meta( $id, "{$prefix}header_preset", true );
					$color_preset = get_post_meta( $id, "{$prefix}color_preset", true );
					$typography_preset = get_post_meta( $id, "{$prefix}typography_preset", true );

					if ($header_preset === '') {
						$header_preset     = G5CORE()->options()->get_option( $current_post_type . '__header_preset' );
					}
					if ($color_preset === '') {
						$color_preset      = G5CORE()->options()->get_option( $current_post_type . '__color_preset' );
					}
					if ($typography_preset === '') {
						$typography_preset = G5CORE()->options()->get_option( $current_post_type . '__typography_preset' );
					}
				}
				else {
					$header_preset     = G5CORE()->options()->get_option( $current_post_type . '__header_preset' );
					$color_preset      = G5CORE()->options()->get_option( $current_post_type . '__color_preset' );
					$typography_preset = G5CORE()->options()->get_option( $current_post_type . '__typography_preset' );
				}

				foreach ($admin_bar_theme_options as $k => $v) {
					if (user_can(get_current_user_id(), $v['permission'])) {
						$preset_arg = '';
						if ($k === 'g5core_header_options' && ($header_preset !== '')) {
							$preset_arg = "&_gsf_preset={$header_preset}";
						}
						if ($k === 'g5core_color_options' && ($color_preset !== '')) {
							$preset_arg = "&_gsf_preset={$color_preset}";
						}
						if ($k === 'g5core_typography_options' && ($typography_preset !== '')) {
							$preset_arg = "&_gsf_preset={$typography_preset}";
						}

						$admin_bar->add_node(array(
							'id' => "g5core-theme-options-{$k}",
							'title' => $v['title'],
							'href' => admin_url("admin.php?page={$k}") . $preset_arg,
							'parent' => 'g5core-theme-options'
						));
					}
				}
			}
		}

        public function system_status() {
		    return G5Core_Dashboard_System_Status::getInstance();
        }

        public function welcome() {
            return G5Core_Dashboard_Welcome::getInstance();
        }

        public function plugins() {
            return G5Core_Dashboard_Plugins::getInstance();
        }

        public function install_demo() {
			return G5Core_Dashboard_Install_Demo::getInstance();
        }

        public function is_dashboard_page($page = '') {
            global $pagenow;
            if ($pagenow === 'admin.php' && !empty($_GET['page'])) {
                $current_page = $_GET['page'];
                $current_page = preg_replace('/g5core_/','',$current_page);
                if ($page) {
                    return $current_page === $page;
                } else {
                    $pages = $this->get_config_pages();
                    return array_key_exists($current_page,$pages);
                }
            }
            return false;
        }
	}
}