<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
if ( ! class_exists( 'G5Blog_Abstracts_Elements_Listing', false ) ) {
	G5BLOG()->load_file(G5BLOG()->plugin_dir('inc/abstract/elementor-listing.class.php'));
}

class UBE_Element_G5Blog_Posts_Slider extends G5Blog_Abstracts_Elements_Listing {

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
		return 'ube-g5-posts-slider';
	}

	public function get_title() {
		return esc_html__( 'G5 Posts Slider', 'g5-blog' );
	}

	public function get_ube_icon() {
		return 'eicon-post-slider';
	}

	public function get_ube_keywords() {
		return array('posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5', 'slider' );
	}

	public function get_script_depends() {
		return array(G5BLOG()->assets_handle('post-slider'));
	}

	public function get_style_depends() {
		return array();
	}

	public function render() {
		G5BLOG()->get_template( 'elements/posts-slider/template.php', array(
			'element' => $this
		) );
	}

	protected function register_controls() {
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_query_section_controls();
		$this->register_slider_section_controls();
		$this->register_style_section_controls();
		$this->remove_control('post_paging');
	}

	protected function register_layout_controls() {
		parent::register_layout_controls();
		$this->update_control('post_layout',[
			'options' => $this->get_config_post_slider_layout(),
			'default' => 'grid',
		]);
	}

}