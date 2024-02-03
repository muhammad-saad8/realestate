<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;

if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5Core_Elements_Listing_Abstract', false)) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/elementor-listing.class.php'));
}

abstract class G5ERE_Abstracts_Elements_Listing_Agency extends G5Core_Elements_Listing_Abstract
{
	protected function register_layout_section_controls()
	{
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__('Layout', 'g5-ere'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_skin_controls();
		$this->register_list_skin_controls();
		$this->register_item_custom_class_controls();
		$this->register_columns_controls();
		$this->register_columns_gutter_controls();

		$this->register_post_count_control();
		$this->register_post_offset_control();
		$this->register_post_paging_controls();
		$this->register_post_animation_controls();

		$this->end_controls_section();
	}

	protected function register_style_section_controls()
	{
		$this->register_style_title_section_controls();
		$this->register_style_address_section_controls();
		$this->register_style_meta_section_controls();
		$this->register_style_social_section_controls();
	}

	protected function register_style_title_section_controls()
	{
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__('Title', 'g5-ere'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-agency-title',

			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__('Spacing', 'g5-ere'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('title_color_tabs');

		$this->start_controls_tab('title_color_normal',
			[
				'label' => esc_html__('Normal', 'g5-ere'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('title_color_hover',
			[
				'label' => esc_html__('Hover', 'g5-ere'),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-title:hover, {{WRAPPER}} .g5ere__loop-agency-title:hover a' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_address_section_controls()
	{
		$this->start_controls_section(
			'section_design_address',
			[
				'label' => esc_html__('Address', 'g5-ere'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'address_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-agency-address',

			]
		);

		$this->add_control(
			'address_spacing',
			[
				'label' => esc_html__('Spacing', 'g5-ere'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-address' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('address_color_tabs');

		$this->start_controls_tab('address_color_normal',
			[
				'label' => esc_html__('Normal', 'g5-ere'),
			]
		);

		$this->add_control(
			'address_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-address' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('address_color_hover',
			[
				'label' => esc_html__('Hover', 'g5-ere'),
			]
		);


		$this->add_control(
			'address_hover_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-address:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_meta_section_controls()
	{
		$this->start_controls_section(
			'section_design_meta',
			[
				'label' => esc_html__('Meta', 'g5-ere'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_style_label_meta',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Label', 'ube' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_label_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-agency-meta:not(.g5ere__loop-agency-address) .g5ere__lam-label',

			]
		);


		$this->add_control(
			'meta_label_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-meta:not(.g5ere__loop-agency-address) .g5ere__lam-label' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'heading_style_content_meta',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Content', 'ube' ),
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_content_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-agency-meta:not(.g5ere__loop-agency-address) .g5ere__lam-content',

			]
		);


		$this->add_control(
			'meta_content_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-agency-meta:not(.g5ere__loop-agency-address) .g5ere__lam-content' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_social_section_controls()
	{
		$this->start_controls_section(
			'section_design_social',
			[
				'label' => esc_html__('Social', 'g5-ere'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->start_controls_tabs('social_color_tabs');

		$this->start_controls_tab('social_color_normal',
			[
				'label' => esc_html__('Normal', 'g5-ere'),
			]
		);

		$this->add_control(
			'social_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__agency-social-list a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'social_background_color',
			[
				'label' => esc_html__('Background Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .g5ere__agency-social-list a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'social_group_border',
				'selector' => '{{WRAPPER}} .g5ere__agency-social-list a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('social_color_hover',
			[
				'label' => esc_html__('Hover', 'g5-ere'),
			]
		);


		$this->add_control(
			'social_hover_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__agency-social-list a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'social_background_color_hover',
			[
				'label' => esc_html__('Background Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .g5ere__agency-social-list a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'social_group_border_hover',
				'selector' => '{{WRAPPER}} .g5ere__agency-social-list a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_layout_controls()
	{
		$this->add_control(
			'post_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Agency Layout', 'g5-ere'),
				'description' => esc_html__('Specify your agency layout', 'g5-ere'),
				'options' => $this->get_config_agency_layout(),
				'default' => 'grid',
			]
		);
	}


	protected function register_skin_controls()
	{
		$this->add_control(
			'item_skin',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Item Skin', 'g5-ere'),
				'description' => esc_html__('Specify your agency item skin', 'g5-ere'),
				'options' => $this->get_config_agency_skins(),
				'default' => 'skin-01',
				'condition' => [
					'post_layout' => 'grid'
				]
			]
		);
	}

	protected function register_list_skin_controls()
	{
		$this->add_control(
			'list_item_skin',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Item Skin', 'g5-ere'),
				'description' => esc_html__('Specify your agency item skin', 'g5-ere'),
				'options' => $this->get_config_agency_list_skins(),
				'default' => 'skin-list-01',
				'condition' => [
					'post_layout' => 'list'
				]
			]
		);
	}

	protected function register_item_custom_class_controls()
	{
		$this->add_control(
			'item_custom_class',
			[
				'label' => esc_html__('Item Css Classes', 'g5-ere'),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Add custom css classes to item', 'g5-ere'),
				'default' => '',
			]
		);
	}

	protected function register_columns_gutter_controls()
	{
		parent::register_columns_gutter_controls();
		$this->update_control('columns_gutter', [
			'condition' => [
				'post_layout' => 'grid'
			]
		]);
	}

	protected function register_image_size_section_controls()
	{
		parent::register_image_size_section_controls();
		$this->update_control('post_image_size', [
			'default' => 'full'
		]);
	}

	protected function register_query_section_controls()
	{
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__('Query', 'g5-ere'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Show', 'g5-ere'),
				'options' => [
					'' => esc_html__('All', 'g5-ere'),
					'agency' => esc_html__('Narrow agency', 'g5-ere')
				],
				'default' => ''
			]

		);

		$this->register_agency_controls();

		$this->register_sorting_controls();

		$this->end_controls_section();


	}

	protected function register_agency_controls()
	{
		$this->add_control(
			'agency',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'agency'
				),
				'label' => esc_html__('Narrow Agency', 'g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter agency by names to narrow output (Note: only listed agency will be displayed, divide agency with linebreak (Enter)).', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => '',
				],
			]
		);
	}

	protected function register_sorting_controls()
	{
		$this->add_control(
			'sorting',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sort by', 'g5-ere'),
				'description' => esc_html__('Select how to sort retrieved agency.', 'g5-ere'),
				'options' => G5ERE()->settings()->get_agency_sorting(),
				'default' => 'menu_order',
			]
		);
	}


	public function get_config_agency_layout()
	{
		$config = apply_filters('g5ere_elementor_agency_layout', array(
			'grid' => array(
				'label' => esc_html__('Grid', 'g5-ere'),
				'priority' => 10,
			),
			'list' => array(
				'label' => esc_html__('List', 'g5-ere'),
				'priority' => 20,
			),
		));
		uasort($config, 'g5core_sort_by_order_callback');
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;
	}

	public function get_config_agency_skins()
	{
		$config = apply_filters('g5ere_elementor_agency_skins', array(
			'skin-01' => array(
				'label' => esc_html__('Skin 01', 'g5-ere'),
				'priority' => 10,
			),
		));
		uasort($config, 'g5core_sort_by_order_callback');
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;
	}

	public function get_config_agency_list_skins()
	{
		$config = apply_filters('g5ere_elementor_agency_list_skins', array(
			'skin-list-01' => array(
				'label' => esc_html__('Skin 01', 'g5-ere'),
				'priority' => 10,
			),
		));
		uasort($config, 'g5core_sort_by_order_callback');
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;
	}
}
