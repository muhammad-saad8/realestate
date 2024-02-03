<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Abstracts_Elements_Listing', false ) ) {
	G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/abstract/elementor-listing.class.php' ) );
}

class UBE_Element_G5ERE_Properties_Slider extends G5ERE_Abstracts_Elements_Listing {

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
		return 'g5-properties-slider';
	}

	public function get_title() {
		return esc_html__( 'G5 Properties Slider', 'g5-ere' );
	}

	public function get_ube_icon() {
		return 'eicon-slider-album';
	}

	public function get_ube_keywords() {
		return array('properties', 'properties slider', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5' , 'slider' );
	}

	public function get_script_depends() {
		return array(G5ERE()->assets_handle('properties-slider'));
	}


	public function render() {
		G5ERE()->get_template( 'elements/properties-slider/template.php', array(
			'element' => $this
		) );
	}

	protected function register_controls() {
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_query_section_controls();
		$this->register_slider_section_controls();

	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'g5-ere' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_post_count_control();
		$this->register_post_offset_control();
		$this->register_height_mode_controls();

		$this->end_controls_section();
	}

	protected function register_layout_controls() {
		$this->add_control(
			'layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Layout','g5-ere'),
				'description' => esc_html__('Specify your property slider layout','g5-ere'),
				'options' => G5ERE()->settings()->get_properties_slider_layout(),
				'default' => 'layout-01',
			]
		);
	}

	protected function register_post_count_control() {
		parent::register_post_count_control();
		$this->update_control('posts_per_page',[
			'default' => 3
		]);
	}

	protected function register_height_mode_controls() {
		$this->add_control(
			'height',
			[
				'type' => UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE,
				'label' => esc_html__('Height','g5-ere'),
				'data_type' => 'text',
				'description' => esc_html__('Enter custom height (include unit) enter value -1 to full screen', 'g5-ere'),
				'default'     => '',
			]
		);
	}

	protected function register_slider_section_controls() {
		parent::register_slider_section_controls();
		$this->remove_control('slider_rows');
		$this->remove_control('slider_center_enable');
		$this->remove_control('slider_center_padding');
	}

	protected function register_image_size_section_controls() {
		parent::register_image_size_section_controls();
		$this->update_control('post_image_size',[
			'condition' => []
		]);
	}
}