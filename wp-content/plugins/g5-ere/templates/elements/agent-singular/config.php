<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5ERE_Abstracts_Elements_Listing_Agent', false)) {
	G5ERE()->load_file(G5ERE()->plugin_dir('inc/abstract/elementor-listing-agent.class.php'));
}

class UBE_Element_G5ERE_Agent_Singular extends G5ERE_Abstracts_Elements_Listing_Agent
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
		return 'g5-agent-singular';
	}

	public function get_title()
	{
		return esc_html__('G5 Agent Singular', 'g5-ere');
	}

	public function get_ube_icon()
	{
		return 'eicon-user-circle-o';
	}

	public function get_script_depends() {
		return array(G5ERE()->assets_handle('agent-singular'));
	}

	public function get_ube_keywords()
	{
		return array('agent', 'agent singular', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type', 'ube', 'g5');
	}

	public function render()
	{
		G5ERE()->get_template('elements/agent-singular/template.php', array(
			'element' => $this
		));
	}

	protected function register_controls()
	{
		$this->register_query_section_controls();
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
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
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => false,
				'data_args' => array(
					'post_type' => 'agent'
				),
				'label' => esc_html__('Narrow Agent', 'g5-ere'),
				'label_block' => true,
				'description' => esc_html__('Enter the agent you want to display', 'g5-ere'),
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_layout_section_controls()
	{
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__('Layout', 'g5-ere'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'post_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Layout', 'g5-ere'),
				'description' => esc_html__('Specify your agent singular layout', 'g5-ere'),
				'options' => $this->get_config_agent_layout(),
				'default' => 'layout-01',
			]
		);

		$this->end_controls_section();
	}

	public function get_config_agent_layout()
	{
		$config = apply_filters('g5ere_elementor_agent_singular_layout', array(
			'layout-01' => array(
				'label' => esc_html__('Layout 01', 'g5-ere'),
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

	protected function register_image_size_section_controls()
	{
		parent::register_image_size_section_controls();
		$this->update_control('post_image_size', [
			'condition' => []
		]);
	}
}