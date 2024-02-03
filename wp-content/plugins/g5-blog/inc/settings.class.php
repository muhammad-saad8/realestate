<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Blog_Settings' ) ) {
	class G5Blog_Settings {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		public function get_shortcode_post_layout($inherit = false)
		{
			$config = apply_filters('g5blog_shortcode_post_layout', array(
				'large-image' => array(
					'label' => esc_html__('Large Image', 'g5-blog'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-large-image.png'),
					'priority' => 10,
				),
				'medium-image' => array(
					'label' => esc_html__('Medium Image', 'g5-blog'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-medium-image.png'),
					'priority' => 20,
				),
				'grid' => array(
					'label' => esc_html__('Grid', 'g5-blog'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 30,
				),
				'masonry' => array(
					'label' => esc_html__('Masonry', 'g5-blog'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-masonry.png'),
					'priority' => 40,
				),
			));

			uasort( $config, 'g5core_sort_by_order_callback' );

			if ($inherit) {
				$config = array(
					          '' => array(
						          'label' => esc_html__('Inherit', 'g5-blog'),
						          'img' => G5BLOG()->plugin_url('assets/images/theme-options/default.png'),
					          ),
				          ) + $config;
			}
			return $config;
		}


        public function get_post_layout($inherit = false)
        {
            $config = apply_filters('g5blog_options_post_layout', array(
                'large-image' => array(
                    'label' => esc_html__('Large Image', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-large-image.png'),
                    'priority' => 10,
                ),
                'medium-image' => array(
                    'label' => esc_html__('Medium Image', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-medium-image.png'),
                    'priority' => 20,
                ),
                'grid' => array(
                    'label' => esc_html__('Grid', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
                    'priority' => 30,
                ),
                'masonry' => array(
                    'label' => esc_html__('Masonry', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-masonry.png'),
                    'priority' => 40,
                ),
            ));

	        uasort( $config, 'g5core_sort_by_order_callback' );


            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'g5-blog'),
                            'img' => G5BLOG()->plugin_url('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_shortcode_post_slider_layout($inherit = false) {
            $config = apply_filters('g5blog_shortcode_post_slider_layout', array(
                'grid' => array(
                    'label' => esc_html__('Grid', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
                    'priority' => 10,
                ),
            ));
	        uasort( $config, 'g5core_sort_by_order_callback' );
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'g5-blog'),
                            'img' => G5BLOG()->plugin_url('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }


        public function get_single_post_layout($inherit = false)
        {
            $config = apply_filters('g5blog_options_single_post_layout', array(
                'layout-1' => array(
                    'label' => esc_html__('Layout 1', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-1.png'),
                    'priority' => 10,
                ),
                'layout-2' => array(
                    'label' => esc_html__('Layout 2', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-2.png'),
                    'priority' => 20,
                ),
                'layout-3' => array(
                    'label' => esc_html__('Layout 3', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-3.jpg'),
                    'priority' => 30,
                ),
                'layout-4' => array(
                    'label' => esc_html__('Layout 4', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-4.jpg'),
                    'priority' => 40,
                ),
                'layout-5' => array(
                    'label' => esc_html__('Layout 5', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-5.png'),
                    'priority' => 50,
                ),
                'layout-6' => array(
                    'label' => esc_html__('Layout 6', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-6.png'),
                    'priority' => 60,
                ),
                'layout-7' => array(
                    'label' => esc_html__('Layout 7', 'g5-blog'),
                    'img' => G5BLOG()->plugin_url('assets/images/theme-options/post-layout-7.png'),
                    'priority' => 70,
                ),

            ));
	        uasort( $config, 'g5core_sort_by_order_callback' );
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'g5-blog'),
                            'img' => G5BLOG()->plugin_url('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_single_post_related_algorithm($inherit = false)
        {
            $config = apply_filters('g5blog_options_single_post_related_algorithm', array(
                'cat' => esc_html__('by Category', 'g5-blog'),
                'tag' => esc_html__('by Tag', 'g5-blog'),
                'author' => esc_html__('by Author', 'g5-blog'),
                'cat-tag' => esc_html__('by Category & Tag', 'g5-blog'),
                'cat-tag-author' => esc_html__('by Category & Tag & Author', 'g5-blog'),
                'random' => esc_html__('Randomly', 'g5-blog')
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'g5-blog')
                    ) + $config;
            }

            return $config;

        }





        public function post_types_for_search() {
            $search_pt = array(
                'all' => esc_html__('All','g5-blog')
            );
            foreach (g5blog_post_types_active() as $key => $pt) {
                $search_pt[$key] = $pt['label'];
            }

            return $search_pt;
        }


        public function get_post_layout_has_columns() {
			return apply_filters('g5blog_post_layout_has_columns',array('grid', 'masonry'));
        }


	}
}