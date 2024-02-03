<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5ERE_Elementor')) {
	class G5ERE_Elementor
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init()
		{
			add_filter('ube_get_element_configs', array($this, 'change_ube_get_element_configs'));
			add_filter('ube_autoload_file_dir', array($this, 'change_ube_autoload_file_dir'), 10, 2);
			add_action('init', array($this, 'register_scripts'));
			add_filter('ube_element_listing_query_args', array($this, 'set_query_args'), 10, 2);
			add_filter('ube_element_listing_query_args',array($this,'set_query_agent_args'),10,2);
			add_filter( 'ube_element_listing_query_args', array( $this, 'set_query_agency_args' ), 10, 2 );
		}

		public function register_scripts()
		{
			wp_register_script(G5ERE()->assets_handle('properties'), G5ERE()->asset_url('assets/js/elements/properties.min.js'), array(), G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('properties-carousel'), G5ERE()->asset_url('assets/js/elements/properties-carousel.min.js'), array(), G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('sc-properties-slider'), G5ERE()->asset_url('assets/shortcode-js/properties-slider.min.js'), array(), G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('properties-slider'), G5ERE()->asset_url('assets/js/elements/properties-slider.min.js'), array(G5ERE()->assets_handle('sc-properties-slider')), G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('agent'),G5ERE()->asset_url('assets/js/elements/agent.min.js'),array(),G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('agent-slider'),G5ERE()->asset_url('assets/js/elements/agent-slider.min.js'),array(),G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('agent-singular'),G5ERE()->asset_url('assets/js/elements/agent-singular.min.js'),array(),G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('agency'),G5ERE()->asset_url('assets/js/elements/agency.min.js'),array(),G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('agency-slider'),G5ERE()->asset_url('assets/js/elements/agency-slider.min.js'),array(),G5ERE()->plugin_ver());
			wp_register_script(G5ERE()->assets_handle('advanced-properties-locations'),G5ERE()->asset_url('assets/js/elements/advanced-properties-locations.min.js'),array(),G5ERE()->plugin_ver());
		}


		private function get_elements()
		{
			return apply_filters('g5ere_elements', array(
				'Properties' => esc_html__('Properties', 'g5-ere'),
				'Properties_Carousel' => esc_html__('Properties Carousel', 'g5-ere'),
				'Properties_Locations' => esc_html__('Properties Locations', 'g5-ere'),
				'Properties_Slider' => esc_html__('Properties Slider', 'g5-ere'),
				'Property_Search_Form' => esc_html__('Property Search Form', 'g5-ere'),
				'Agent' => esc_html__('Agent', 'g5-ere'),
				'Agent_Search' => esc_html__('Agent Search', 'g5-ere'),
				'Agent_Singular' => esc_html__('Agent Singular', 'g5-ere'),
				'Agency_Search' => esc_html__('Agency Search', 'g5-ere'),
				'Agency' => esc_html__('Agency', 'g5-ere'),
				'Agent_Slider' => esc_html__('Agent Slider', 'g5-ere'),
				'Agency_Slider' => esc_html__('Agency Slider', 'g5-ere'),
				'Advanced_Properties_Locations' => esc_html__('Advanced Properties Locations', 'g5-ere'),

			));
		}

		public function change_ube_get_element_configs($configs)
		{

			$elements = $this->get_elements();

			$g5_elements = isset($configs['g5_elements']) ? $configs['g5_elements'] : array(
				'title' => esc_html__('G5 Elements', 'g5-ere'),
				'items' => array()
			);

			foreach ($elements as $k => $v) {
				$g5_elements['items']["G5ERE_{$k}"] = array(
					'title' => $v
				);
			}

			$configs['g5_elements'] = $g5_elements;
			return $configs;
		}

		public function change_ube_autoload_file_dir($path, $class)
		{
			$prefix = 'UBE_Element_G5ERE_';
			if (strpos($class, $prefix) === 0) {
				$file_name = substr($class, strlen($prefix));
				$file_name = str_replace('_', '-', $file_name);
				$file_name = strtolower($file_name);
				return G5ERE()->locate_template("elements/$file_name/config.php");

			}
			return $path;
		}

		public function set_query_args($query_args, $atts)
		{
			if ($query_args['post_type'] === 'property') {

				$query_args['meta_query'] = array();

				$query_args['tax_query'] = array(
					'relation' => 'AND',
				);

				if (isset($atts['sorting'])) {
					$orderby_value = explode('-', $atts['sorting']);
					$orderby = esc_attr($orderby_value[0]);
					$order = !empty($orderby_value[1]) ? $orderby_value[1] : '';

					$ordering = G5ERE()->query()->get_property_ordering_args($orderby, $order);

					$query_args['orderby'] = $ordering['orderby'];
					$query_args['order'] = $ordering['order'];


					if (isset($ordering['meta_key']) && !empty($ordering['meta_key'])) {
						$query_args['meta_key'] = $ordering['meta_key'];
					}

					if (isset($ordering['ere_orderby_featured'])) {
						$query_args['ere_orderby_featured'] = $ordering['ere_orderby_featured'];
					}

					if (isset($ordering['ere_orderby_viewed'])) {
						$query_args['ere_orderby_viewed'] = $ordering['ere_orderby_viewed'];
					}
				}


				if (!isset($atts['show'])) {
					$atts['show'] = '';
				}

				switch ($atts['show']) {
					case 'featured':
						$query_args['meta_query'][] = array(
							'key' => ERE_METABOX_PREFIX . 'property_featured',
							'value' => 1,
							'compare' => '=',
						);
						break;
					case 'new-in':
						$query_args['orderby'] = 'date ID';
						$query_args['order'] = 'DESC';
						break;
					case 'property':
						$query_args['post__in'] = array_map('absint', $atts['ids']);
						$query_args['posts_per_page'] = -1;
						$query_args['orderby'] = 'post__in';
						break;
				}

				if ($atts['show'] !== 'property') {
					$taxonomy_narrow = array(
						'property_type' => 'property-type',
						'property_status' => 'property-status',
						'property_feature' => 'property-feature',
						'property_label' => 'property-label',
						'property_state' => 'property-state',
						'property_city' => 'property-city',
						'property_neighborhood' => 'property-neighborhood',
					);

					foreach ($taxonomy_narrow as $k => $v) {
						if (!empty($atts[$k])) {
							$query_args['tax_query'][] = array(
								'taxonomy' => $v,
								//'terms'    => array_filter( explode( ',', $atts[ $k ] ), 'absint' ),
								'terms' => array_map('absint', $atts[$k]),
								'field' => 'id',
								'operator' => 'IN'
							);
						}
					}

				}
			}

			return $query_args;
		}

		public function set_query_agent_args($query_args,$atts) {
			if ($query_args['post_type'] === 'agent') {
				if ( isset( $atts['sorting'] ) ) {
					$orderby_value = explode( '-', $atts['sorting'] );
					$orderby       = esc_attr( $orderby_value[0] );
					$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';

					$ordering = G5ERE()->query_agent()->get_agent_ordering_args( $orderby, $order );

					$query_args['orderby'] = $ordering['orderby'];
					$query_args['order']   = $ordering['order'];
				}

				switch ( $atts['show'] ) {
					case 'new-in':
						$query_args['orderby'] = 'date';
						$query_args['order']   = 'DESC';
						break;
					case 'agent':
						$query_args['post__in']       = array_map('absint',$atts['ids']);
						$query_args['posts_per_page'] = - 1;
						$query_args['orderby']        = 'post__in';
						break;
				}


				if ( ! empty( $atts['agency'] ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'agency',
						//'terms'    => array_filter( explode( ',', $atts['agency'] ), 'absint' ),
						'terms' => array_map('absint',$atts['agency']),
						'field'    => 'id',
						'operator' => 'IN'
					);
				}
			}
			return $query_args;
		}

		public function set_query_agency_args( $query_args, $atts ) {
			if ( isset( $query_args['taxonomy'] ) && $query_args['taxonomy'] === 'agency' ) {
				unset( $query_args['post_type'] );
				unset( $query_args['post_status'] );
				unset( $query_args['ignore_sticky_posts'] );
				unset( $query_args['posts_per_page'] );
				unset( $query_args['no_found_rows'] );
				$query_args['number'] = $atts['posts_per_page'];
				if ( ! empty( $atts['posts_per_page'] ) ) {
					$query_args['number'] = absint( $atts['posts_per_page'] );
				}
				if ( ! empty( $atts['offset'] ) ) {
					$query_args['offset'] = absint( $atts['offset'] );
				}
				if ( isset( $atts['sorting'] ) ) {
					$orderby_value = explode( '-', $atts['sorting'] );
					$orderby       = esc_attr( $orderby_value[0] );
					$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : '';

					$ordering = G5ERE()->query_agency()->get_ordering_args_agency( $orderby, $order );

					$query_args['orderby'] = $ordering['orderby'];
					$query_args['order']   = $ordering['order'];
				}

				if ( ! empty( $atts['agency'] ) ) {
					$query_args['term_taxonomy_id'] = $atts['agency'];
					$query_args['number']           = '';
				}

			}

			return $query_args;
		}
	}
}