<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class UBE_Element_G5ERE_Agency_Search extends UBE_Abstracts_Elements {

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
		return 'g5-agency-search';
	}

	public function get_title() {
		return esc_html__( 'G5 Agency Search', 'g5-ere' );
	}

	public function get_ube_icon() {
		return 'eicon-search';
	}

	public function get_ube_keywords() {
		return array('Agency', 'Agency search', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5');
	}

	public function render() {
		G5ERE()->get_template( 'elements/agency-search/template.php', array(
			'element' => $this
		) );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Wrapper', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'label_text',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => wp_kses_post(__('<i>Your agency search form.</i>', 'g5-ere')),
			]
		);

		$this->end_controls_section();
	}


}