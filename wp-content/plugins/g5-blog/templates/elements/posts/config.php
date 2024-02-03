<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
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
class UBE_Element_G5Blog_Posts extends G5Blog_Abstracts_Elements_Listing {
	public function get_name() {
		return 'ube-g5-posts';
	}

	public function get_title() {
		return esc_html__( 'G5 Posts', 'g5-blog' );
	}

	public function get_ube_icon() {
		return 'eicon-post-list';
	}

	public function get_ube_keywords() {
		return array('posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5' );
	}

	public function get_script_depends() {
		return array(G5BLOG()->assets_handle('posts'));
	}

	public function get_style_depends() {
		return array();
	}

	public function render() {
		G5BLOG()->get_template( 'elements/posts/template.php', array(
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