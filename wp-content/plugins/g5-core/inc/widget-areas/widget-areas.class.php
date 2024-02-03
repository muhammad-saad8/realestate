<?php
if (!class_exists('G5Core_Widget_Areas')) {
	class G5Core_Widget_Areas {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		protected $widget_areas = array();

		protected $version = '1.0';

		protected $widget_areas_key =  'g5core-widget-areas';

		public function init() {
			add_action('widgets_init',array($this, 'register_custom_widget_areas'),11);
			add_action( 'wp_ajax_g5core_delete_widget_area', array( $this, 'delete_widget_area' ) );
			add_action('admin_menu', array($this, 'sidebars_menu'), 20);
			add_action('wp_loaded', array($this, 'add_sidebar'));
		}

		public function sidebars_menu() {
			$parent_slug = apply_filters('gsf_admin_sidebar_parent_slug', 'g5core_welcome');

			add_submenu_page(
				$parent_slug,
				esc_html__( 'Sidebars Management', 'smart-framework' ),
				esc_html__( 'Sidebars Management', 'smart-framework' ),
				'manage_options',
				'g5core_sidebars',
				array( $this, 'sidebars_page' )
			);

			$current_page = isset( $_GET['page'] ) ? $_GET['page'] : '';
			if ( $current_page == 'g5core_sidebars' ) {
				add_action( 'admin_init', array( $this, 'enqueue' ) );
			}
		}

		public function sidebars_page() {
			include G5CORE()->plugin_dir('inc/widget-areas/views/sidebars.php');
		}

		public function enqueue() {
			wp_enqueue_script(G5CORE()->assets_handle('widget-areas'), G5CORE()->asset_url('inc/widget-areas/assets/js/widget-areas.min.js'), array('jquery'), $this->version);
			wp_enqueue_style(G5CORE()->assets_handle('widget-areas'), G5CORE()->asset_url('inc/widget-areas/assets/css/widget-areas.min.css'), array(), $this->version, 'screen');
			wp_localize_script(
				G5CORE()->assets_handle('widget-areas'),
				'g5core_widget_areas_variable',
				array(
					'ajax_url' => wp_nonce_url(admin_url('admin-ajax.php?action=g5core_delete_widget_area'), 'g5core-delete-widget-area-action', '_wpnonce'),
					'confirm_delete' => esc_html__('Are you sure to delete this widget areas?', 'g5-core')
				)
			);
		}


		public function get_widget_areas() {
			// If the single instance hasn't been set, set it now.
			if ( !empty($this->widget_areas) ) {
				return $this->widget_areas;
			}

			$db = get_option($this->widget_areas_key);
			if (!empty($db)) {
				$this->widget_areas = array_unique(array_merge($this->widget_areas, $db));
			}
			return $this->widget_areas;
		}

		public function register_custom_widget_areas() {
			// If the single instance hasn't been set, set it now.
			if ( empty($this->widget_areas) ) {
				$this->widget_areas = $this->get_widget_areas();
			}
			$args = array(
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title"><span>',
				'after_title'   => '</span></h4>',
			);
			$args = apply_filters('g5core_custom_widget_args', $args);
			if (is_array($this->widget_areas)) {
				foreach (array_unique($this->widget_areas) as $key => $value) {
					$args['class']   = 'g5core-widgets-custom';
					$args['name']    = $value;
					$args['id']      = $key;
					register_sidebar($args);
				}
			}
		}

		function save_widget_areas() {
			update_option($this->widget_areas_key,array_unique( $this->widget_areas ));
		}

		public function add_sidebar() {
			if (!isset($_POST['g5core_add_sidebar_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['g5core_add_sidebar_nonce']), 'g5core_add_sidebar_action')) {
				return;
			}
			$widget_name = $_POST['g5core-add-widget-input'];
			if (!empty($widget_name)) {
				$this->widget_areas = $this->get_widget_areas();

				$widget_name = $this->check_widget_area_name($widget_name);

				$widgetId = sanitize_key($widget_name);

				$this->widget_areas[$widgetId] = $widget_name;

				$this->save_widget_areas();

				wp_redirect($_POST['_wp_http_referer']);
				die();
			}
		}

		public function check_widget_area_name($name) {
			global $wp_registered_sidebars;
			if(empty($wp_registered_sidebars))
				return $name;

			$taken = array();
			foreach ( $wp_registered_sidebars as $widget_area ) {
				$taken[] = $widget_area['name'];
			}
			if(in_array($name, $taken)) {
				$counter  = substr($name, -1);
				if(!is_numeric($counter)) {
					$new_name = $name . " 1";
				} else {
					$new_name = substr($name, 0, -1) . ((int) $counter + 1);
				}

				$name = $this->check_widget_area_name($new_name);
			}
			return $name;
		}

		function delete_widget_area() {
			if (!check_ajax_referer('g5core-delete-widget-area-action','_wpnonce')) return;
			if(!empty($_REQUEST['name'])) {
				$name = strip_tags( ( stripslashes( $_REQUEST['name'] ) ) );
				$this->widget_areas = $this->get_widget_areas();
				if( array_key_exists($name, $this->widget_areas )) {
					unset($this->widget_areas[$name]);
					$this->save_widget_areas();
				}
				echo "widget-area-deleted";
			}
			die();
		}
	}
}