<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Abstracts_Elements_Listing', false ) ) {
	G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/abstract/elementor-listing.class.php' ) );
}

class UBE_Element_G5ERE_Properties_Carousel extends G5ERE_Abstracts_Elements_Listing {

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
		return 'g5-properties-carousel';
	}

	public function get_title() {
		return esc_html__( 'G5 Properties Carousel', 'g5-ere' );
	}

	public function get_ube_icon() {
		return 'eicon-post-slider';
	}

	public function get_ube_keywords() {
		return array('properties', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5' , 'slider' );
	}

	public function get_script_depends() {
		return array(G5ERE()->assets_handle('properties-carousel'));
	}


	public function render() {
		G5ERE()->get_template( 'elements/properties-carousel/template.php', array(
			'element' => $this
		) );
	}

	protected function register_controls() {
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_query_section_controls();
		$this->register_slider_section_controls();
		$this->register_style_section_controls();
	}

	protected function register_layout_section_controls() {
		parent::register_layout_section_controls();
		$this->remove_control('post_layout');
		$this->remove_control('list_item_skin');
		$this->update_control('post_columns',[
			'condition' => []
		]);
		$this->update_control('columns_gutter',[
			'condition' => []
		]);
		$this->remove_control('post_paging');
		$this->update_control('item_skin',[
			'condition' => []
		]);
	}

	protected function register_image_size_section_controls() {
		parent::register_image_size_section_controls();
		$this->update_control('post_image_size',[
			'condition' => []
		]);
	}


}