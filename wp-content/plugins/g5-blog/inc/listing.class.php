<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if ( ! class_exists( 'G5Core_Listing_Abstract', false ) ) {
    G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/listing.class.php'));
}
if (!class_exists('G5Blog_Listing')) {
    class G5Blog_Listing extends G5Core_Listing_Abstract
    {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        protected $key_layout_settings = 'g5blog_layout_settings';

        public function init() {
            add_action('g5core_post_pagination_ajax_response',array($this,'pagination_ajax_response'),10,2);
        }

        public function pagination_ajax_response($settings,$query_args) {
            $this->render_content($query_args,$settings);
        }

        public function get_layout_settings_default() {
            return array(
	            'post_layout'        => G5BLOG()->options()->get_option( 'post_layout' ),
	            'item_custom_class'  => G5BLOG()->options()->get_option( 'item_custom_class' ),
	            'post_columns'       => array(
		            'xl' => intval( G5BLOG()->options()->get_option( 'post_columns_xl' ) ),
		            'lg' => intval( G5BLOG()->options()->get_option( 'post_columns_lg' ) ),
		            'md' => intval( G5BLOG()->options()->get_option( 'post_columns_md' ) ),
		            'sm' => intval( G5BLOG()->options()->get_option( 'post_columns_sm' ) ),
		            ''   => intval( G5BLOG()->options()->get_option( 'post_columns' ) ),
	            ),
	            'columns_gutter'     => intval( G5BLOG()->options()->get_option( 'post_columns_gutter' ) ),
	            'image_size'         => G5BLOG()->options()->get_option( 'post_image_size' ),
	            'post_paging'        => G5BLOG()->options()->get_option( 'post_paging' ),
	            'post_animation'     => G5BLOG()->options()->get_option( 'post_animation' ),
	            'itemSelector'       => 'article',
	            'cate_filter_enable' => false,
	            'append_tabs'        => G5BLOG()->options()->get_option( 'append_tabs' )
            );
        }

        public function render_listing() {
            G5BLOG()->get_template( 'listing.php' );
        }

        public function get_config_layout_matrix() {

            $data = apply_filters('g5blog_config_layout_matrix',array(
                'large-image'        => array(
                    'layout'             => array(
                        array( 'template' => 'large-image'),
                    ),
                    'columns'            => 1,
                    'image_mode'         => 'image',

                ),
                'medium-image'           => array(
                    'layout'             => array(
                        array('template' => 'medium-image'),
                    ),
                    'columns'            => 1,
                ),
                'grid' => array(
                    'layout' => array(
                        array('template' => 'grid')
                    ),
                ),
                'masonry'        => array(
                    'layout'         => array(
                        array('template' => 'grid'),
                    ),
                    'image_mode'         => 'image',
                    'isotope'        => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                    ),
                ),
            ));
            return $data;
        }


    }
}