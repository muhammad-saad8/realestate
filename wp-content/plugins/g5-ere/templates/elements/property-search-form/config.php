<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class UBE_Element_G5ERE_Property_Search_Form extends UBE_Abstracts_Elements {

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
	public function get_name() {
		return 'g5-property-search-form';
	}

	public function get_title() {
		return esc_html__( 'G5 Property Search Form', 'g5-ere' );
	}

	public function get_ube_icon() {
		return 'eicon-search';
	}

	public function get_ube_keywords() {
		return array('properties', 'property search form', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5');
	}

	public function render() {
		G5ERE()->get_template( 'elements/property-search-form/template.php', array(
			'element' => $this
		) );
	}

	protected function register_controls() {
		$this->register_layout_section_controls();
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'search_form',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Search Form','g5-ere'),
				'description' => wp_kses_post(sprintf( __('Manager search form at <a href="%s">G5Ere Options</a>','g5-ere'),admin_url('admin.php?page=g5ere_options&section=search_forms'))),
				'options' => G5ERE()->settings()->get_search_forms(),
				'default' => '',
			]
		);

		$this->end_controls_section();
	}


}