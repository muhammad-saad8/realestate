<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if ( ! class_exists( 'G5Core_Listing_Abstract', false ) ) {
	G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/listing.class.php'));
}
if (!class_exists('G5ERE_Listing_Agent')) {
	class G5ERE_Listing_Agent extends G5Core_Listing_Abstract
	{
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		protected $key_layout_settings = 'g5ere_agent_layout_settings';

		public function init() {
			add_action('g5core_agent_pagination_ajax_response',array($this,'pagination_ajax_response'),10,2);
		}

		public function pagination_ajax_response($settings,$query_args) {
			$this->render_content($query_args,$settings);
		}

		public function get_layout_settings_default() {

			return array(
				'post_layout'        => G5ERE()->options()->get_option('agent_layout','grid'),
				'item_skin'          =>  G5ERE()->options()->get_option('agent_item_skin'),
				'item_custom_class'  =>  G5ERE()->options()->get_option( 'agent_item_custom_class' ),
				'post_columns'       => array(
					'xl' => intval( G5ERE()->options()->get_option( 'agent_columns_xl' ) ),
					'lg' => intval( G5ERE()->options()->get_option( 'agent_columns_lg' ) ),
					'md' => intval( G5ERE()->options()->get_option( 'agent_columns_md' ) ),
					'sm' => intval( G5ERE()->options()->get_option( 'agent_columns_sm' ) ),
					''   => intval( G5ERE()->options()->get_option( 'agent_columns' ) ),
				),
				'columns_gutter'     => intval( G5ERE()->options()->get_option( 'agent_columns_gutter' ) ),
				'image_size'         => G5ERE()->options()->get_option( 'agent_image_size' ),
				'post_paging'        => G5ERE()->options()->get_option( 'agent_paging' ),
				'post_animation'     => G5ERE()->options()->get_option( 'agent_animation' ),
				'itemSelector'       => 'article',
				'noFoundSelector' => '.g5core__not-found',
				'cate_filter_enable' => false,
				'post_type' => 'agent',

			);
		}

		public function render_listing() {
			G5ERE()->get_template( 'agent/listing.php' );
		}

		public function get_config_layout_matrix() {
			$post_settings = $this->get_layout_settings();
			$item_skin = isset($post_settings['item_skin']) ? $post_settings['item_skin'] : 'skin-01';
			$data = apply_filters('g5ere_agent_config_layout_matrix',array(
				'grid' => array(
					'layout' => array(
						array('template' => $item_skin)
					),
				),
				'list' => array(
					'columns' => 1,
					'layout' => array(
						array('template' => $item_skin)
					),
					//'image_mode' => 'image'
				)
			));
			return $data;
		}

		public function render_toolbar() {
			G5ERE()->get_template('agent/loop/toolbar.php');
		}


	}
}