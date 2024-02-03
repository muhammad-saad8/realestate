<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if ( ! class_exists( 'G5Blog_Templates' ) ) {
    class G5Blog_Templates
    {
        private static $_instance;

        public static function getInstance() {
            if ( self::$_instance == null ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
            $this->remove_theme_template();
            $this->add_theme_template();


        }

        public function remove_theme_template() {
            /**
             * Remove header template
             */
            remove_action( G5CORE_CURRENT_THEME . '_archive_content', G5CORE_CURRENT_THEME . '_template_archive_content', 10 );

            remove_action(G5CORE_CURRENT_THEME . '_search_content', G5CORE_CURRENT_THEME . '_template_search_content',10 );
           remove_action(G5CORE_CURRENT_THEME . '_single_content', G5CORE_CURRENT_THEME . '_template_single_content', 10);
        }

        public function add_theme_template() {
            add_action( G5CORE_CURRENT_THEME . '_archive_content', array( $this, 'archive_template' ), 10 );
            add_action(G5CORE_CURRENT_THEME . '_search_content', array($this,'search_template'),10);
            add_action(G5CORE_CURRENT_THEME . '_single_content', array($this,'single_template'), 10);

            add_action( G5CORE_CURRENT_THEME . '_before_main_content', array( $this, 'breadcrumb_template' ), 11 );
            add_action( G5CORE_CURRENT_THEME . '_before_main_content', array( $this, 'single_featured_template' ), 12 );


        }

        public function archive_template() {
            $settings = array();
            $category_filter_enable = G5BLOG()->options()->get_option('category_filter_enable');
	        $category_filter_align = G5BLOG()->options()->get_option('category_filter_align');
            $settings['cate_filter_enable'] = $category_filter_enable === 'on';
	        $settings['cate_filter_align'] = $category_filter_align;
            if (is_category()) {
                global $wp_query;
                $term = $wp_query->get_queried_object();
                $settings['current_cat'] = $term->term_id;
            }
            G5BLOG()->listing()->render_content(null,$settings);
        }

        public function search_template(){
            G5BLOG()->listing()->render_content();
        }

        public function single_template() {
            $single_post_layout = G5BLOG()->options()->get_option('single_post_layout');
            while ( have_posts() ) {
                the_post();
                G5BLOG()->get_template("single/layout/{$single_post_layout}.php",array('layout' => $single_post_layout));
            }
        }

        public function breadcrumb_template() {
            if (!is_singular('post')) return;

	        $page_title_enable = G5CORE()->options()->page_title()->get_option('page_title_enable');
	        if ($page_title_enable === 'on') {
		        return;
	        }


            $single_post_layout = G5BLOG()->options()->get_option('single_post_layout');
            if (in_array($single_post_layout,array('layout-1','layout-2','layout-3','layout-4','layout-5','layout-6'))) {
                g5blog_template_breadcrumbs();
            }
        }

        public function single_featured_template() {
            if (!is_singular('post')) return;
            $single_post_layout = G5BLOG()->options()->get_option('single_post_layout');
            if (in_array($single_post_layout,array('layout-6','layout-7'))) {
                G5BLOG()->get_template('single/featured/' . $single_post_layout . '.php', array('layout' => $single_post_layout));
            }
        }


    }
}