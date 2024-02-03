<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Abstracts_Elements_Listing', false ) ) {
	G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/abstract/elementor-listing.class.php' ) );
}

class UBE_Element_G5ERE_Properties extends G5ERE_Abstracts_Elements_Listing {

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
		return 'g5-properties';
	}

	public function get_title() {
		return esc_html__( 'G5 Properties', 'g5-ere' );
	}

	public function get_ube_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_ube_keywords() {
		return array('properties', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5' );
	}

	public function get_script_depends() {
		return array(G5ERE()->assets_handle('properties'));
	}


	public function render() {
		G5ERE()->get_template( 'elements/properties/template.php', array(
			'element' => $this
		) );
	}
	protected function register_controls() {
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_query_section_controls();
		$this->register_style_section_controls();
	}
}