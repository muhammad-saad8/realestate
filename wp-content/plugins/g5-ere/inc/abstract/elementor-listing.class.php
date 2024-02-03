<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Elements_Listing_Abstract', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/elementor-listing.class.php'));
}
abstract class G5ERE_Abstracts_Elements_Listing extends G5Core_Elements_Listing_Abstract {
	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'g5-ere' ),
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
		$this->register_cate_filter_controls();

		$this->end_controls_section();
	}

	protected function register_layout_controls() {
		$this->add_control(
			'post_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Property Layout','g5-ere'),
				'description' => esc_html__('Specify your property layout','g5-ere'),
				'options' => $this->get_config_property_layout(),
				'default' => 'grid',
			]
		);
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'g5-ere' ),
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
					'featured' => esc_html__('Featured', 'g5-ere'),
					'new-in' => esc_html__('New In', 'g5-ere'),
					'property' => esc_html__('Narrow Property', 'g5-ere')
				],
				'default' => ''
			]

		);

		$this->register_property_type_controls();

		$this->register_property_status_controls();

		$this->register_property_feature_controls();

		$this->register_property_label_controls();

		$this->register_property_state_controls();

		$this->register_property_city_controls();

		$this->register_property_neighborhood_controls();

		$this->register_property_ids_controls();

		$this->register_sorting_controls();

		$this->end_controls_section();
	}

	protected function register_property_type_controls() {
		$this->add_control(
			'property_type',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-type'
				),
				'label' => esc_html__('Narrow Property Type','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter property type by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => 'property',
				],
			]
		);
	}

	protected function register_property_status_controls() {
		$this->add_control(
			'property_status',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-status'
				),
				'label' => esc_html__('Narrow Property Status','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter property status by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => 'property',
				],
			]
		);
	}

	protected function register_property_feature_controls() {
		$this->add_control(
			'property_feature',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-feature'
				),
				'label' => esc_html__('Narrow Property Feature','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter property feature by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => 'property',
				],
			]
		);
	}

	protected function register_property_label_controls() {
		$this->add_control(
			'property_label',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-label'
				),
				'label' => esc_html__('Narrow Property Label','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter property label by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => 'property',
				],
			]
		);
	}

	protected function register_property_state_controls() {
		$this->add_control(
			'property_state',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-state'
				),
				'label' => esc_html__('Narrow Province / State','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter province / state by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => 'property',
				],
			]
		);
	}

	protected function register_property_city_controls() {
		$this->add_control(
			'property_city',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-city'
				),
				'label' => esc_html__('Narrow City','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter city by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => 'property',
				],
			]
		);
	}

	protected function register_property_neighborhood_controls() {
		$this->add_control(
			'property_neighborhood',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-neighborhood'
				),
				'label' => esc_html__('Narrow Neighborhood','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter neighborhood by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show!' => 'property',
				],
			]
		);
	}

	protected function register_property_ids_controls() {
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'data_args' => array(
					'post_type' => 'property'
				),
				'label' => esc_html__('Narrow Property','g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Property', 'g5-ere'),
				'default' => '',
				'condition' => [
					'show' => 'property',
				],
			]
		);

	}

	protected function register_sorting_controls() {
		$this->add_control(
			'sorting',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sort by', 'g5-ere'),
				'description' => esc_html__('Select how to sort retrieved property.', 'g5-ere'),
				'options'     =>G5ERE()->settings()->get_property_sorting(),
				'default' => 'menu_order',
				'condition' => [
					'show' => ['','featured'],
				],
			]
		);


	}


	protected function register_skin_controls() {
		$this->add_control(
			'item_skin',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Item Skin', 'g5-ere'),
				'description' => esc_html__('Specify your property item skin', 'g5-ere'),
				'options' => $this->get_config_property_skins(),
				'default' => 'skin-01',
				'condition' => [
					'post_layout' => 'grid'
				]
			]
		);
	}

	protected function register_list_skin_controls() {
		$this->add_control(
			'list_item_skin',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Item Skin', 'g5-ere'),
				'description' => esc_html__('Specify your property item skin', 'g5-ere'),
				'options' => $this->get_config_property_list_skins(),
				'default' => 'skin-list-01',
				'condition' => [
					'post_layout' => 'list'
				]
			]
		);
	}

	protected function register_item_custom_class_controls() {
		$this->add_control(
			'item_custom_class',
			[
				'label' => esc_html__( 'Item Css Classes', 'g5-ere' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Add custom css classes to item','g5-ere'),
				'default' => '',
			]
		);
	}

	protected function register_columns_gutter_controls() {
		parent::register_columns_gutter_controls();
		$this->update_control('columns_gutter',[
			'condition' => [
				'post_layout' => 'grid'
			]
		]);
	}

	protected function register_cate_filter_controls() {
		$this->add_control(
			'taxonomy_filter_enable',
			[
				'label' => esc_html__( 'Taxonomy Tabs', 'g5-ere' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-ere' ),
				'label_off' => esc_html__( 'Hide', 'g5-ere' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control('taxonomy_filter',[
			'label' =>  esc_html__('Taxonomy','g5-ere'),
			'type' => Controls_Manager::SELECT,
			'options' => G5ERE()->settings()->get_property_taxonomy_filter(),
			'default' => 'property-status',
			'condition' => [
				'taxonomy_filter_enable' => 'on'
			]
		]);

		$this->add_control(
			'taxonomy_filter_align',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Taxonomy Tabs Align','g5-ere'),
				'options' => G5CORE()->settings()->get_category_filter_align(),
				'default' => '',
				'condition' => [
					'taxonomy_filter_enable' => 'on',
				],
			]
		);

		$this->add_control(
			'append_tabs',
			[
				'label' => esc_html__( 'Append Taxonomy', 'g5-ere' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Change where the taxonomy are attached (Selector, htmlString, Array, Element, jQuery object)', 'g5-ere' ),
				'default' => '',
				'condition' => [
					'taxonomy_filter_enable' => 'on',
				],
			]
		);

	}

	protected function register_image_size_section_controls() {
		parent::register_image_size_section_controls();
		$this->update_control('post_image_size',[
			'default' => 'full'
		]);
	}
	protected function register_style_section_controls() {
		$this->register_style_title_section_controls();
		$this->register_style_address_section_controls();
		$this->register_style_price_section_controls();
		$this->register_style_excerpt_section_controls();
		$this->register_style_meta_section_controls();
	}

	protected function register_style_title_section_controls() {
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__( 'Title', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-property-title',

			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-ere' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'title_color_tabs');

		$this->start_controls_tab( 'title_color_normal',
			[
				'label' => esc_html__( 'Normal', 'g5-ere' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover',
			[
				'label' => esc_html__( 'Hover', 'g5-ere' ),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-title:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_address_section_controls() {
		$this->start_controls_section(
			'section_design_address',
			[
				'label' => esc_html__( 'Address', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'address_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-property-address',

			]
		);

		$this->add_control(
			'address_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-ere' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-address' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'address_color_tabs');

		$this->start_controls_tab( 'address_color_normal',
			[
				'label' => esc_html__( 'Normal', 'g5-ere' ),
			]
		);

		$this->add_control(
			'address_color',
			[
				'label' => esc_html__( 'Color', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-address' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'address_color_hover',
			[
				'label' => esc_html__( 'Hover', 'g5-ere' ),
			]
		);


		$this->add_control(
			'address_hover_color',
			[
				'label' => esc_html__( 'Color', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-address:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_price_section_controls() {
		$this->start_controls_section(
			'section_design_price',
			[
				'label' => esc_html__( 'Price', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-property-price',

			]
		);

		$this->add_control(
			'price_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-ere' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-price' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'price_postfix_color',
			[
				'label' => esc_html__( 'Color Prefix', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__lpp-postfix' => 'color: {{VALUE}} !important;',
				],
			]
		);



		$this->end_controls_section();
	}

	protected function register_style_excerpt_section_controls() {
		$this->start_controls_section(
			'section_design_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .g5ere__property-excerpt',

			]
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-ere' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5ere__property-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => esc_html__( 'Color', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__property-excerpt' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function register_style_meta_section_controls() {
		$this->start_controls_section(
			'section_design_meta',
			[
				'label' => esc_html__( 'Meta', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'selector' => '{{WRAPPER}} .g5ere__loop-property-meta span',

			]
		);


		$this->add_control(
			'meta_color',
			[
				'label' => esc_html__( 'Color', 'g5-ere' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__loop-property-meta span' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();
	}



	public function get_config_property_layout()
	{
		$config = apply_filters('g5ere_elementor_property_layout', array(
			'grid' => array(
				'label' => esc_html__('Grid', 'g5-ere'),
				'priority' => 10,
			),
			'list' => array(
				'label' => esc_html__('List', 'g5-ere'),
				'priority' => 20,
			),
		));
		uasort( $config, 'g5core_sort_by_order_callback' );
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;
	}

	public function get_config_property_skins() {
		$config = apply_filters('g5ere_elementor_property_skins', array(
			'skin-01' => array(
				'label' => esc_html__('Skin 01', 'g5-ere'),
				'priority' => 10,
			),
		));
		uasort( $config, 'g5core_sort_by_order_callback' );
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;
	}

	public function get_config_property_list_skins() {
		$config = apply_filters('g5ere_elementor_property_list_skins', array(
			'skin-list-01' => array(
				'label' => esc_html__('Skin 01', 'g5-ere'),
				'priority' => 10,
			),
		));
		uasort( $config, 'g5core_sort_by_order_callback' );
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;
	}


}