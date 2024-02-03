<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Core_Listing_Abstract')) {
    abstract class G5Core_Listing_Abstract
    {
        protected $key_layout_settings = '';

        public function &get_layout_settings()
        {

            if (isset($GLOBALS[$this->key_layout_settings]) && is_array($GLOBALS[$this->key_layout_settings])) {
                return $GLOBALS[$this->key_layout_settings];
            }
            $GLOBALS[$this->key_layout_settings] = $this->get_layout_settings_default();
            return $GLOBALS[$this->key_layout_settings];
        }

        public function get_layout_settings_default() {
            return array();
        }

        public function set_layout_settings($args)
        {
            $layout_settings = &$this->get_layout_settings();
            $layout_settings = wp_parse_args($args, $layout_settings);

        }

        public function unset_layout_settings()
        {
            unset($GLOBALS[$this->key_layout_settings]);
        }


        public function render_pagination() {
            $settings      = &$this->get_layout_settings();
            $post_paging   = $settings['post_paging'];
            $max_num_pages = G5CORE()->query()->get_max_num_pages();
            $settingId = isset($settings['settingId']) ? $settings['settingId'] : uniqid();
            $settings['settingId'] = $settingId;


            if (( ! isset( $_POST['action'] ) || empty( $_POST['action'] ) ) ) {
                $ajax_query = G5CORE()->cache()->get('g5core_ajax_query',array());
                $js_variable = array(
                    'settings' => $settings,
                    'query'    => G5CORE()->query()->get_ajax_query_vars()
                );
                foreach ($ajax_query as $k => $v) {
                    $js_variable[$k] = $v;
                }
                G5CORE()->assets()->add_js_variable($js_variable, "g5_ajax_pagination_{$settingId}");
            }
            if ( ( $max_num_pages > 1 ) && ( $post_paging !== '' ) && ( $post_paging !== 'none' ) ) {
	            $paged   =  G5CORE()->query()->query_var_paged();
                G5CORE()->get_template("paging/{$post_paging}.php", array(
                	'settingId' => $settingId,
	                'isMainQuery' => isset($settings['isMainQuery']),
	                'paged' => $paged,
	                'max_num_pages' => $max_num_pages
                ));
            }
        }

        public function render_cate() {
            $settings = &$this->get_layout_settings();
            $settingId = isset($settings['settingId']) ? $settings['settingId'] : uniqid();
            $settings['settingId'] = $settingId;
            $pagenum_link = isset($settings['pagenum_link']) ? $settings['pagenum_link'] : html_entity_decode(get_pagenum_link());
            $settings['pagenum_link'] = $pagenum_link;
	        if (( ! isset( $_POST['action'] ) || empty( $_POST['action'] ) ) ) {

                $ajax_query = G5CORE()->cache()->get('g5core_ajax_query',array());
                $js_variable = array(
                    'settings' => $settings,
                    'query'    => G5CORE()->query()->get_ajax_query_vars()
                );
                foreach ($ajax_query as $k => $v) {
                    $js_variable[$k] = $v;
                }


                G5CORE()->assets()->add_js_variable($js_variable, "g5_ajax_pagination_{$settingId}");

            }
            G5CORE()->get_template("loop/cate.php", array(
                'settingId' => $settingId,
                'pagenum_link' => $pagenum_link,
                'post_type' => isset($settings['post_type']) ? $settings['post_type'] : 'post' ,
                'taxonomy' => isset($settings['taxonomy']) ? $settings['taxonomy'] : 'category',
                'cate' => isset($settings['cate']) ? $settings['cate'] : '',
                'current_cat' => isset($settings['current_cat']) ? $settings['current_cat'] : -1,
                'append_tabs' => isset($settings['append_tabs']) ? $settings['append_tabs'] : '',
	            'cat_align' => isset($settings['cate_filter_align']) ? $settings['cate_filter_align'] : ''
            ));
        }

        public function render_tabs() {
            $settings = &$this->get_layout_settings();
            $tabs = isset($settings['tabs']) ? $settings['tabs'] : array();
            unset($settings['tabs']);
	        if (( ! isset( $_POST['action'] ) || empty( $_POST['action'] ) ) ) {
                $index = 1;
                foreach ($tabs as &$tab) {
                    $settingId = uniqid();
                    if ($index === 1) {
                        $settingId = isset($settings['settingId']) ? $settings['settingId'] : uniqid();
                        $settings['settingId'] = $settingId;
                    }
                    $query_args = $tab['query_args'];
                    $tab['settingId'] = $settingId;

                    $ajax_query = G5CORE()->cache()->get('g5core_ajax_query',array());
                    $js_variable = array(
                        'settings' => $settings,
                        'query'    => G5CORE()->query()->get_ajax_query_vars($query_args)
                    );
                    foreach ($ajax_query as $k => $v) {
                        $js_variable[$k] = $v;
                    }

                    G5CORE()->assets()->add_js_variable($js_variable, "g5_ajax_pagination_{$settingId}");
                    $index++;
                }
            }
            G5CORE()->get_template("loop/tabs.php", array(
                'tabs' => $tabs,
                'append_tabs' => isset($settings['append_tabs']) ? $settings['append_tabs'] : '',
                'cat_align' => isset($settings['cate_filter_align']) ? $settings['cate_filter_align'] : ''
            ));

        }

        public function render_toolbar() {

        }



        public function render_content($query_args = null, $settings = null) {
            if (isset($_REQUEST['settings']) && !isset($query_args)) {
	            $settings =  wp_parse_args(array(
		            'settingId' => $_REQUEST['settings']['settingId'],
		            'index' =>  isset($_REQUEST['settings']['index']) ? $_REQUEST['settings']['index'] : 0
	            ),$settings) ;
            }

            if (isset($settings['tabs']) && isset($settings['tabs'][0]['query_args'])) {
                $query_args = $settings['tabs'][0]['query_args'];
            }

            if (!isset($query_args)) {
                $settings['isMainQuery'] = true;
            }


            if (isset($settings) && is_array($settings) && (count($settings) > 0)) {
                $this->set_layout_settings($settings);
            }

            $post_settings = &$this->get_layout_settings();
            if (isset($post_settings['post_layout'])) {
	            $layout_matrix = $this->get_layout_matrix( $post_settings['post_layout'] );
	            $itemSelector = isset($layout_matrix['itemSelector']) ? $layout_matrix['itemSelector'] : '';
	            if ($itemSelector !== '') {
		            $post_settings['itemSelector'] = $itemSelector;
	            }
            }
            G5CORE()->query()->query_posts($query_args);

            if (isset($settings['cate_filter_enable']) && $settings['cate_filter_enable'] === true) {
                add_action('g5core_before_listing_wrapper', array($this, 'render_cate'));
            }

            if (isset($settings['tabs'])) {
                add_action('g5core_before_listing_wrapper', array($this, 'render_tabs'));
            }


            if (isset($settings['toolbar'])) {
	            add_action('g5core_before_listing_wrapper', array($this, 'render_toolbar'));
            }


            add_action( 'g5core_after_listing_wrapper', array( $this, 'render_pagination' ));

            $this->render_listing();


	        if (isset($settings['toolbar'])) {
		        remove_action('g5core_before_listing_wrapper', array($this, 'render_toolbar'));
	        }

            if (isset($settings['tabs'])) {
                remove_action('g5core_before_listing_wrapper', array($this, 'render_tabs'));
            }

            if (isset($settings['cate_filter_enable']) && $settings['cate_filter_enable'] === true) {
                remove_action('g5core_before_listing_wrapper', array($this, 'render_cate'));
            }


            remove_action( 'g5core_after_listing_wrapper', array( $this, 'render_pagination' ));
            if (isset($settings) && (sizeof($settings) > 0)) {
                $this->unset_layout_settings();
            }

            G5CORE()->query()->reset_query();

        }

        public function render_listing() {

        }

        public function get_config_layout_matrix() {
            return array();
        }

        public function get_layout_matrix( $layout ) {
            $matrix = $this->get_config_layout_matrix();
            return isset( $matrix[ $layout ] ) ? $matrix[ $layout ] : false;
        }
    }
}
