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
abstract class G5Blog_Abstracts_Elements_Listing extends G5Core_Elements_Listing_Abstract {


	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'g5-blog' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_item_custom_class_controls();
		$this->register_excerpt_controls();
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
				'label' => esc_html__('Post Layout','g5-blog'),
				'description' => esc_html__('Specify your post layout','g5-blog'),
				'options' => $this->get_config_post_layout(),
				'default' => 'grid',
			]
		);
	}

	protected function register_excerpt_controls() {
		$this->add_control(
			'excerpt_enable',
			[
				'label' => esc_html__( 'Show Excerpt', 'g5-blog' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-blog' ),
				'label_off' => esc_html__( 'Hide', 'g5-blog' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);
	}

	protected function register_columns_gutter_controls() {
		parent::register_columns_gutter_controls();
		$this->update_control('columns_gutter',[
			'condition' => [
				'post_layout' => G5BLOG()->settings()->get_post_layout_has_columns(),
			],
		]);
	}

	protected function register_columns_controls() {
		parent::register_columns_controls();
		$this->update_control('post_columns',[
			'condition' => [
				'post_layout' => G5BLOG()->settings()->get_post_layout_has_columns(),
			],
		]);
	}


	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'g5-blog' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_cat_controls();
		$this->register_tag_controls();
		$this->register_post_ids_controls();
		$this->register_order_by_controls();
		$this->register_meta_key_controls();
		$this->register_order_controls();
		$this->register_time_filter_controls();

		$this->end_controls_section();
	}

	protected function register_cat_controls() {
		$this->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'label' => esc_html__('Narrow Category','g5-blog'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'g5-blog'),
				'default' => '',
			]
		);

	}

	protected function register_tag_controls() {
		$this->add_control(
			'tag',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'post_tag'
				),
				'label' => esc_html__('Narrow Tag','g5-blog'),
				'label_block' => true,
				'description' => esc_html__('Enter tags by names to narrow output.', 'g5-blog'),
				'default' => '',
			]
		);
	}

	protected function register_post_ids_controls() {
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'label' => esc_html__('Narrow Post','g5-blog'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Posts', 'g5-blog'),
				'default' => '',
			]
		);
	}

	protected function register_order_by_controls() {
		$this->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'g5-blog'),
				'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'g5-blog'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'g5-blog'),
					'ID' => esc_html__('Order by post ID', 'g5-blog'),
					'author' => esc_html__('Author', 'g5-blog'),
					'title' => esc_html__('Title', 'g5-blog'),
					'modified' => esc_html__('Last modified date', 'g5-blog'),
					'parent' => esc_html__('Post/page parent ID', 'g5-blog'),
					'comment_count' => esc_html__('Number of comments', 'g5-blog'),
					'menu_order' => esc_html__('Menu order/Page Order', 'g5-blog'),
					'meta_value' => esc_html__('Meta value', 'g5-blog'),
					'meta_value_num' => esc_html__('Meta value number', 'g5-blog'),
					'rand' => esc_html__('Random order', 'g5-blog'),
				),
				'default' => 'date',
			]
		);
	}

	protected function register_order_controls() {
		$this->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'g5-blog'),
				'description' => esc_html__('Select sorting order.', 'g5-blog'),
				'options'     => array(
					'DESC' => esc_html__('Descending', 'g5-blog'),
					'ASC' => esc_html__('Ascending', 'g5-blog'),
				),
				'default' => 'DESC',
			]
		);
	}

	protected function register_meta_key_controls() {
		$this->add_control(
			'meta_key',
			[
				'label' => esc_html__( 'Meta key', 'g5-blog' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Input meta key for grid ordering','g5-blog'),
				'default' => '',
				'condition' => [
					'orderby' => ['meta_value', 'meta_value_num'],
				],
			]
		);
	}

	protected function register_time_filter_controls() {
		$this->add_control(
			'time_filter',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Time Filter', 'g5-blog'),
				'options'     => array(
					'none' => esc_html__('No Filter', 'g5-blog'),
					'today' => esc_html__('Today Posts', 'g5-blog'),
					'yesterday' => esc_html__('Today + Yesterday Posts', 'g5-blog'),
					'week' => esc_html__('This Week Posts', 'g5-blog'),
					'month' => esc_html__('This Month Posts', 'g5-blog'),
					'year' => esc_html__('This Year Posts', 'g5-blog')
				),
				'default' => 'none',
			]
		);
	}

	protected function register_style_section_controls() {
		$this->register_style_title_section_controls();
		$this->register_style_meta_section_controls();
		$this->register_style_excerpt_section_controls();
	}

	protected function register_style_title_section_controls() {
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__( 'Title', 'g5-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .g5blog__post-title',
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-blog' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5blog__post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( 'title_color_tabs' );

		$this->start_controls_tab( 'title_color_normal',
			[
				'label' => esc_html__( 'Normal', 'g5-blog' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'g5-blog' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5blog__post-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover',
			[
				'label' => esc_html__( 'Hover', 'g5-blog' ),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'g5-blog' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5blog__post-title:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_meta_section_controls() {
		$this->start_controls_section(
			'section_design_meta',
			[
				'label' => esc_html__( 'Meta', 'g5-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'selector' => '{{WRAPPER}} .g5blog__post-meta',
			]
		);

		$this->add_control(
			'meta_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-blog' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5blog__post-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->start_controls_tabs( 'meta_color_tabs' );

		$this->start_controls_tab( 'meta_color_normal',
			[
				'label' => esc_html__( 'Normal', 'g5-blog' ),
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => esc_html__( 'Color', 'g5-blog' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.g5blog__post-meta li > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'meta_color_hover',
			[
				'label' => esc_html__( 'Hover', 'g5-blog' ),
			]
		);


		$this->add_control(
			'meta_hover_color',
			[
				'label' => esc_html__( 'Color', 'g5-blog' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.g5blog__post-meta li > a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_excerpt_section_controls() {
		$this->start_controls_section(
			'section_design_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'g5-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'excerpt_enable' => 'on',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .g5blog__post-excerpt',
			]
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label' => esc_html__( 'Spacing', 'g5-blog' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5blog__post-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => esc_html__( 'Color', 'g5-blog' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5blog__post-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_config_post_layout()
	{
		$config = apply_filters('g5blog_elementor_post_layout', array(
			'large-image' => array(
				'label' => esc_html__('Large Image', 'g5-blog'),
				'priority' => 10,
			),
			'medium-image' => array(
				'label' => esc_html__('Medium Image', 'g5-blog'),
				'priority' => 20,
			),
			'grid' => array(
				'label' => esc_html__('Grid', 'g5-blog'),
				'priority' => 30,
			),
			'masonry' => array(
				'label' => esc_html__('Masonry', 'g5-blog'),
				'priority' => 40,
			),
		));

		uasort( $config, 'g5core_sort_by_order_callback' );


		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;

	}

	public function get_config_post_slider_layout()
	{

		$config = apply_filters('g5blog_elementor_post_slider_layout', array(
			'grid' => array(
				'label' => esc_html__('Grid', 'g5-blog'),
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
