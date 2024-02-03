<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('HOMEID_CORE_AGENT')) {
	class HOMEID_CORE_AGENT
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == null) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{
			add_filter('g5ere_options_agent_skins', array($this, 'change_options_agent_skins'));
			add_filter('g5ere_shortcode_agent_layout', array($this, 'change_shortcode_agent_layout'));
			add_filter('g5ere_agent_config_layout_matrix', array($this, 'change_agent_config_layout_matrix'));
			add_action('template_redirect', array($this, 'demo_layout'), 15);
			add_action('template_redirect', array($this, 'change_single_agent_layout'), 15);
			add_action('pre_get_posts', array($this, 'post_per_pages'));
			add_filter( 'g5ere_widget_contact_agent_layout', array( $this, 'change_widget_contact_agent_layout' ) );
		}

		public function change_widget_contact_agent_layout( $config ) {
			return wp_parse_args( array(
				'layout-02' => array(
					'label' => esc_html__( 'Layout 02', 'homeid' ),
					'img'   => get_parent_theme_file_uri('assets/images/theme-options/agent-contact-skin-2.png')
				),
			), $config );
		}

		public function change_options_agent_skins($layout)
		{
			return wp_parse_args(array(
				'skin-02' => array(
					'label' => esc_html__('Skin 02', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/theme-options/agent-grid-skin-02.png'),
				),
				'skin-03' => array(
					'label' => esc_html__('Skin 03', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/theme-options/agent-grid-skin-03.png'),
				),
				'skin-04' => array(
					'label' => esc_html__('Skin 04', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/theme-options/agent-grid-skin-04.png'),
				),
				'skin-05' => array(
					'label' => esc_html__('Skin 05', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/theme-options/agent-grid-skin-05.png'),
				),
				'skin-06' => array(
					'label' => esc_html__('Skin 06', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/theme-options/agent-grid-skin-06.png'),
				),
				'skin-07' => array(
					'label' => esc_html__('Skin 07', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/theme-options/agent-grid-skin-07.png'),
				),
			), $layout);
		}

		public function change_shortcode_agent_layout($config)
		{
			return wp_parse_args(array(
				'creative' => array(
					'label' => esc_html__('Creative', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/theme-options/agent-layout-creative.png'),
				),
			), $config);
		}

		public function change_agent_config_layout_matrix($config)
		{
			return wp_parse_args(array(
				'creative' => array('itemSelector' => '.g5core__listing-blocks'),
			), $config);
		}

		public function change_single_agent_layout()
		{
			if (!function_exists('G5CORE') || !function_exists('G5ERE') || !is_singular('agent')) {
				return;
			}

			$layout = isset($_REQUEST['single_agent_layout']) ? $_REQUEST['single_agent_layout'] : '';

			$sidebar = isset($_REQUEST['agent_sidebar']) ? $_REQUEST['agent_sidebar'] : '';
			if (!empty($sidebar)) {
				G5CORE()->options()->layout()->set_option('sidebar', $sidebar);
			}

			if ($layout == '02') {
				$content_block = array(
					"enable" => array(
						'description' => esc_html__('Description', 'homeid'),
						'my-properties' => esc_html__('My Properties', 'homeid'),
						'review' => esc_html__('Reviews', 'homeid'),
						'other-agent' => esc_html__('Other Agent', 'homeid'),
					)
				);
				G5CORE()->options()->layout()->set_option('site_layout', 'left');
				G5ERE()->options()->set_option('single_agent_layout', 'layout-02');
				G5ERE()->options()->set_option('single_agent_content_blocks', $content_block);
			}
			if ($layout == '03') {
				$content_block = array(
					"enable" => array(
						'tabs' => esc_html__('Tabs Content', 'homeid'),
					)
				);
				$tabs_block = array(
					"enable" => array(
						'my-properties' => esc_html__('My Properties', 'homeid'),
						'review' => esc_html__('Reviews', 'homeid'),
						'other-agent' => esc_html__('Other Agent', 'homeid'),
					)
				);
				G5CORE()->options()->layout()->set_option('site_layout', 'right');
				G5ERE()->options()->set_option('single_agent_layout', 'layout-01');
				G5ERE()->options()->set_option('single_agent_content_block_style', 'style-03');
				G5ERE()->options()->set_option('single_agent_content_blocks', $content_block);
				G5ERE()->options()->set_option('single_agent_tabs_content_blocks', $tabs_block);
			}
		}

		public function demo_layout()
		{
			if (!function_exists('G5CORE') || !function_exists('G5ERE')) {
				return;
			}

			$page_title = isset($_REQUEST['agent_page_title']) ? $_REQUEST['agent_page_title'] : '';
			if (!empty($page_title)) {
				$ajax_query = G5CORE()->cache()->get('g5core_ajax_query', array());
				$ajax_query['agent_page_title'] = $page_title;
				G5CORE()->cache()->set('g5core_ajax_query', $ajax_query);
				G5CORE()->options()->page_title()->set_option('page_title_content_block', $page_title);
			}

			$agent_layout = isset($_REQUEST['agent_layout']) ? $_REQUEST['agent_layout'] : '';
			$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : '';
			switch ($agent_layout) {
				case 'full-width-grid-1':
					G5CORE()->options()->layout()->set_option('site_layout', 'none');
					G5ERE()->options()->set_option('agent_layout', 'grid');
					G5ERE()->options()->set_option('agent_item_skin', 'skin-01');
					G5ERE()->options()->set_option('agent_columns_xl', '4');
					G5ERE()->options()->set_option('agent_columns_lg', '3');
					G5ERE()->options()->set_option('agent_columns_md', '2');
					G5ERE()->options()->set_option('agent_columns_sm', '2');
					G5ERE()->options()->set_option('agent_columns', '1');
					G5ERE()->options()->set_option('agent_image_size', 'full');
					G5ERE()->options()->set_option('agent_image_ratio', array(
						'width' => 27,
						'height' => 34
					));
					G5CORE()->options()->color()->set_option('site_background_color', array(
						'background_color' => '#fff'
					));
					break;
				case 'full-width-grid-2':
					G5CORE()->options()->layout()->set_option('site_layout', 'none');
					G5ERE()->options()->set_option('agent_layout', 'grid');
					G5ERE()->options()->set_option('agent_item_skin', 'skin-02');
					G5ERE()->options()->set_option('agent_columns_xl', '4');
					G5ERE()->options()->set_option('agent_columns_lg', '3');
					G5ERE()->options()->set_option('agent_columns_md', '2');
					G5ERE()->options()->set_option('agent_columns_sm', '2');
					G5ERE()->options()->set_option('agent_columns', '1');
					G5ERE()->options()->set_option('agent_image_size', 'full');
					G5ERE()->options()->set_option('agent_image_ratio', array(
						'width' => 1,
						'height' => 1
					));
					G5CORE()->options()->color()->set_option('site_background_color', array(
						'background_color' => '#fff'
					));
					break;
				case 'full-width-grid-3':
					G5CORE()->options()->layout()->set_option('site_layout', 'none');
					G5ERE()->options()->set_option('agent_layout', 'grid');
					G5ERE()->options()->set_option('agent_item_skin', 'skin-04');
					G5ERE()->options()->set_option('agent_columns_xl', '4');
					G5ERE()->options()->set_option('agent_columns_lg', '3');
					G5ERE()->options()->set_option('agent_columns_md', '2');
					G5ERE()->options()->set_option('agent_columns_sm', '2');
					G5ERE()->options()->set_option('agent_columns', '1');
					G5ERE()->options()->set_option('agent_image_size', 'full');
					G5ERE()->options()->set_option('agent_image_ratio', array(
						'width' => 1,
						'height' => 1
					));
					G5CORE()->options()->color()->set_option('site_background_color', array(
						'background_color' => '#fff'
					));
					break;
				case 'full-width-grid-4':
					G5CORE()->options()->layout()->set_option('site_layout', 'none');
					G5ERE()->options()->set_option('agent_layout', 'grid');
					G5ERE()->options()->set_option('agent_item_skin', 'skin-05');
					G5ERE()->options()->set_option('agent_columns_xl', '3');
					G5ERE()->options()->set_option('agent_columns_lg', '2');
					G5ERE()->options()->set_option('agent_columns_md', '2');
					G5ERE()->options()->set_option('agent_columns_sm', '1');
					G5ERE()->options()->set_option('agent_columns', '1');
					G5ERE()->options()->set_option('agent_image_size', 'full');
					G5ERE()->options()->set_option('agent_image_ratio', array(
						'width' => 1,
						'height' => 1
					));
					G5CORE()->options()->color()->set_option('site_background_color', array(
						'background_color' => '#f8f8f8'
					));
					break;
				case 'left-sidebar-grid':
					G5CORE()->options()->layout()->set_option('site_layout', 'left');
					G5ERE()->options()->set_option('agent_layout', 'grid');
					G5ERE()->options()->set_option('agent_item_skin', 'skin-04');
					G5ERE()->options()->set_option('agent_columns_xl', '3');
					G5ERE()->options()->set_option('agent_columns_lg', '2');
					G5ERE()->options()->set_option('agent_columns_md', '2');
					G5ERE()->options()->set_option('agent_columns_sm', '2');
					G5ERE()->options()->set_option('agent_columns', '1');
					G5ERE()->options()->set_option('agent_image_size', 'full');
					G5ERE()->options()->set_option('agent_image_ratio', array(
						'width' => 1,
						'height' => 1
					));
					G5CORE()->options()->color()->set_option('site_background_color', array(
						'background_color' => '#fff'
					));
					break;
				case 'right-sidebar-grid':
					G5CORE()->options()->layout()->set_option('site_layout', 'right');
					G5ERE()->options()->set_option('agent_layout', 'grid');
					G5ERE()->options()->set_option('agent_item_skin', 'skin-01');
					G5ERE()->options()->set_option('agent_columns_xl', '3');
					G5ERE()->options()->set_option('agent_columns_lg', '2');
					G5ERE()->options()->set_option('agent_columns_md', '2');
					G5ERE()->options()->set_option('agent_columns_sm', '2');
					G5ERE()->options()->set_option('agent_columns', '1');
					G5ERE()->options()->set_option('agent_image_size', 'full');
					G5ERE()->options()->set_option('agent_image_ratio', array(
						'width' => 27,
						'height' => 34
					));
					G5CORE()->options()->color()->set_option('site_background_color', array(
						'background_color' => '#fff'
					));
					break;
			}
		}

		public function post_per_pages($query)
		{
			if (!function_exists('G5CORE') || !function_exists('G5ERE')) {
				return;
			}
			if (!is_admin() && $query->is_main_query()) {
				$agent_layout = isset($_REQUEST['agent_layout']) ? $_REQUEST['agent_layout'] : '';
				switch ($agent_layout) {
					case 'full-width-grid-1':
					case 'full-width-grid-2':
					case 'full-width-grid-3':
					case 'full-width-grid-4':
						G5ERE()->options()->set_option('agent_per_page', 12);
						break;
					case 'left-sidebar-grid':
						G5ERE()->options()->set_option('agent_per_page', 9);
						break;
					case 'right-sidebar-grid':
						G5ERE()->options()->set_option('agent_per_page', 9);
						break;
				}
			}
		}
	}
}