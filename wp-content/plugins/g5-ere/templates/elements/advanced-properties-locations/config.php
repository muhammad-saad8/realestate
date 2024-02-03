<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

class UBE_Element_G5ERE_Advanced_Properties_Locations extends UBE_Abstracts_Elements_Grid
{

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 * @since 1.4.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return 'g5-advanced-properties-locations';
	}

	public function get_title()
	{
		return esc_html__('G5 Advanced Properties Locations', 'g5-ere');
	}

	public function get_script_depends() {
		return array(G5ERE()->assets_handle('advanced-properties-locations'));
	}

	public function get_ube_icon()
	{
		return 'eicon-map-pin';
	}

	public function get_ube_keywords()
	{
		return array('properties', 'advanced properties locations', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type', 'ube', 'g5');
	}

	protected function add_repeater_controls(\Elementor\Repeater $repeater)
	{

		$repeater->add_control('taxonomy_filter', [
			'label' => esc_html__('Taxonomy', 'g5-ere'),
			'type' => Controls_Manager::SELECT,
			'description' => esc_html__('Select taxonomy property location', 'g5-ere'),
			'options' => G5ERE()->settings()->get_property_location_taxonomy_filter(),
			'default' => 'property-city',
		]);

		$repeater->add_control(
			'property_state',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => false,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-state'
				),
				'label' => esc_html__('Narrow Province / State', 'g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter province / state by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'taxonomy_filter' => 'property-state',
				],
			]
		);

		$repeater->add_control(
			'property_city',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => false,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-city'
				),
				'label' => esc_html__('Narrow City', 'g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter city by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'taxonomy_filter' => 'property-city',
				],
			]
		);

		$repeater->add_control(
			'property_neighborhood',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => false,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'property-neighborhood'
				),
				'label' => esc_html__('Narrow Neighborhood', 'g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter neighborhood by names to narrow output.', 'g5-ere'),
				'default' => '',
				'condition' => [
					'taxonomy_filter' => 'property-neighborhood',
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__('Background Image', 'g5-ere'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		parent::register_item_custom_css_control($repeater);
	}

	protected function get_repeater_defaults()
	{
	}

	protected function print_grid_item()
	{
		$settings        = $this->get_settings_for_display();
		$item = $this->get_current_item();
		$item_key = $this->get_current_item_key();

		$taxonomy_filter = isset($item['taxonomy_filter']) ? $item['taxonomy_filter'] : 'property-city';
		$image = isset($item['image']) ? $item['image'] : array();
		$image_id = absint(isset($image['id']) ? $image['id'] : 0);
		$image_url = isset($image['url']) ? $image['url'] : '';
		$category = false;
		switch ($taxonomy_filter) {
			case "property-city":
				$property_city = isset($item['property_city']) ? $item['property_city'] : '';
				$category = get_term_by('term_id', $property_city, 'property-city', 'OBJECT');
				break;
			case "property-state":
				$property_state = isset($item['property_state']) ? $item['property_state'] : '';
				$category = get_term_by('term_id', $property_state, 'property-state', 'OBJECT');
				break;
			case 'property-neighborhood':
				$property_neighborhood = isset($item['property_neighborhood']) ? $item['property_neighborhood'] : '';
				$category = get_term_by('term_id', $property_neighborhood, 'property-neighborhood', 'OBJECT');
				break;
		}

		if (!is_a($category, 'WP_Term')) {
			return;
		}

		$category_link = get_term_link($category, $taxonomy_filter);
		$category_name = $category->name;
		$category_count = $category->count;

		if (!empty($image_url)) {
			$image_styles = array(
				sprintf('background-image :url(%s)', $image_url)
			);

			$image_size_mode = $settings['image_size_mode'] ? $settings['image_size_mode'] : 'original';
			$padding_bottom = '';
			if ($image_size_mode === 'original') {
				$padding_bottom = 100;
				if ($image_id > 0) {
					$image_arr = wp_get_attachment_image_src($image_id, 'full');
					if (is_array($image_arr)) {
						$padding_bottom = ($image_arr[2] / $image_arr[1]) * 100;
					}
				}
			} elseif (($image_size_mode !== 'custom') && ($image_size_mode !== 'custom_height')) {
				$padding_bottom = $image_size_mode;
			}

			if (!empty($padding_bottom)) {
				$image_styles[] = sprintf('padding-bottom:%s', $padding_bottom . '%');
			}

		}

		G5ERE()->get_template('elements/properties-locations/template.php', array(
			'element' => $this,
			'item_key' => $item_key,
			'taxonomy_filter' => $taxonomy_filter,
			'image_url' => $image_url,
			'category_link' => $category_link,
			'category_name' => $category_name,
			'category_count' => $category_count,
			'image_styles' => $image_styles,
		));
	}

	protected function render()
	{

		$settings = $this->get_settings_for_display();
		$wrapper_class = 'g5element__advanced-properties-location';
		$slider_enable = isset($settings['slider_enable']) ? $settings['slider_enable'] : '';
		if ($slider_enable === 'on') {
			$this->print_slider($settings, $wrapper_class);
		} else {
			$this->print_grid($settings, $wrapper_class);
		}

	}

	protected function register_controls()
	{
		$this->register_layout_controls();
		$this->register_items_section_controls();
		$this->register_style_section_controls();
		$this->register_grid_section_controls(['slider_enable!' => 'on']);
		$this->register_slider_section_controls([
			'name' => 'slider_enable',
			'operator' => '=',
			'value' => 'on'
		]);
	}

	protected function register_layout_controls()
	{
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__('Layout', 'g5-ere'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Layout', 'g5-ere'),
				'description' => esc_html__('Specify your properties location layout', 'g5-ere'),
				'options' => $this->get_config_property_locations_layout(),
				'default' => 'layout-01',
			]
		);

		$this->add_control('image_size_mode', [
			'label' => esc_html__('Image Size Mode', 'g5-ere'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'original' => esc_html__('Original', 'g5-ere'),
				'100' => '1:1',
				'133.333333333' => '4:3',
				'75' => '3:4',
				'177.777777778' => '16:9',
				'56.25' => '9:16',
				'custom' => esc_html__('Custom', 'g5-ere'),
				'custom_height' => esc_html__('Custom Height', 'g5-ere'),
			],
			'default' => 'original',
		]);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__('Width', 'g5-ere'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'image_size_mode' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .g5core__entry-thumbnail' => '--ube-banner-custom-width: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__('Height', 'g5-ere'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'image_size_mode' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .g5core__entry-thumbnail' => 'padding-bottom:calc(({{VALUE}}/var(--ube-banner-custom-width))*100%)',
				],
			]
		);

		$this->add_responsive_control(
			'image_custom_height',
			[
				'label' => esc_html__('Height', 'g5-ere'),
				'type' => Controls_Manager::NUMBER,
				'default' => 400,
				'min' => 1,
				'condition' => [
					'image_size_mode' => 'custom_height',
				],
				'selectors' => [
					'{{WRAPPER}} .g5core__entry-thumbnail' => 'height: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'slider_enable',
			[
				'label' => esc_html__('Slider', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'ube'),
				'label_off' => esc_html__('Disable', 'ube'),
				'return_value' => 'on',
				'default' => '',
			]
		);


		$this->end_controls_section();

	}

	protected function register_slider_section_controls($condition = []) {
		parent::register_slider_section_controls($condition);
		parent::register_slider_item_style_section_controls($condition);
	}

	protected function register_style_section_controls()
	{
		$this->register_style_image_section_controls();
		$this->register_style_title_section_controls();
		$this->register_style_count_section_controls();
	}


	protected function register_style_image_section_controls()
	{
		$this->start_controls_section(
			'section_design_img',
			[
				'label' => esc_html__('Image', 'g5-ere'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label' => esc_html__('Hover Effect', 'g5-ere'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'label_block' => false,
				'options' => G5ERE()->settings()->get_hover_effect(),
			]
		);
		$this->add_control(
			'hover_image_effect',
			[
				'label' => esc_html__('Hover Image Effect', 'g5-ere'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'label_block' => false,
				'options' => G5ERE()->settings()->get_hover_effect_image(),
			]
		);

		$this->end_controls_section();
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
				'selector' => '{{WRAPPER}} .g5ere__property-locations-title',

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
					'{{WRAPPER}} .g5ere__property-locations-title' => 'margin-top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .g5ere__property-locations-title' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .g5ere__property-locations-title:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_count_section_controls()
	{
		$this->start_controls_section(
			'section_design_property_count',
			[
				'label' => esc_html__('Property Count', 'g5-ere'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'property_count_typography',
				'selector' => '{{WRAPPER}} .g5ere__property-locations-count',

			]
		);
		$this->add_control(
			'property_count_spacing',
			[
				'label' => esc_html__('Spacing', 'g5-ere'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .g5ere__property-locations-count' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'property_count_color',
			[
				'label' => esc_html__('Color', 'g5-ere'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .g5ere__property-locations-count' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function get_config_property_locations_layout()
	{
		$config = apply_filters('g5ere_elementor_property_locations_layout', array(
			'layout-01' => array(
				'label' => esc_html__('Layout 01', 'g5-ere'),
				'priority' => 10,
			),
			'layout-02' => array(
				'label' => esc_html__('Layout 02', 'g5-ere'),
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

}

