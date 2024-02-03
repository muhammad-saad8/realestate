<?php
if ( ! class_exists( 'G5Core_Options_Abstract', false ) ) {
    G5CORE()->load_file(G5CORE()->plugin_dir('inc/abstract/options.class.php'));
}
if (!class_exists('G5Blog_Options')) {
	class G5Blog_Options extends G5Core_Options_Abstract {
		protected $option_name = 'g5blog_options';

		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}

		public function init_default() {
			return array (
                'category_filter_enable' => '',
                'category_filter_align' => '',
                'append_tabs' => '',
                'post_layout' => 'large-image',
                'excerpt_enable' => 'on',
                'post_columns_gutter' => '30',
                'post_columns_xl' => 3,
                'post_columns_lg' => 3,
                'post_columns_md' => 2,
                'post_columns_sm' => 2,
                'post_columns' => 1,
                'post_image_size' => 'full',
                'post_image_width' =>
                    array (
                        'width' => '400',
                        'height' => '',
                    ),
                'post_image_ratio' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'posts_per_page' => '',
                'post_paging' => 'pagination',
                'post_animation' => 'none',
                'single_post_layout' => 'layout-1',
                'single_post_tag_enable' => 'on',
                'single_post_share_enable' => 'on',
                'single_post_navigation_enable' => 'on',
                'single_post_author_info_enable' => 'on',
                'single_post_related_enable' => '',
                'single_post_related_algorithm' => 'cat',
                'single_post_related_per_page' => 6,
                'single_post_related_columns_gutter' => '30',
                'single_post_related_columns_xl' => 3,
                'single_post_related_columns_lg' => 3,
                'single_post_related_columns_md' => 2,
                'single_post_related_columns_sm' => 2,
                'single_post_related_columns' => 1,
                'single_post_related_paging' => 'slider',
                'custom_search_listing_enable' => '',
                'search_post_layout' => 'large-image',
                'search_post_columns_gutter' => '30',
                'search_post_columns_xl' => 3,
                'search_post_columns_lg' => 3,
                'search_post_columns_md' => 2,
                'search_post_columns_sm' => 2,
                'search_post_columns' => 1,
                'search_post_image_size' => 'full',
                'search_post_image_width' =>
                    array (
                        'width' => '400',
                        'height' => '',
                    ),
                'search_posts_per_page' => '',
                'search_post_paging' => 'pagination',
            );
		}
	}
}