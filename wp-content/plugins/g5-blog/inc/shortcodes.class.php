<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Blog_ShortCodes')) {
    class G5Blog_ShortCodes {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function init() {
            add_filter('g5element_shortcodes_list',array($this,'add_shortcodes_list'));
            add_action( 'vc_after_mapping', array($this,'auto_complete') );

            add_filter('g5element_vc_lean_map_config',array($this,'vc_lean_map_config'),10,2);
            add_filter('g5element_autoload_class_path',array($this,'change_autoload_class_path'),10,3);
            add_filter('g5element_shortcode_template',array($this,'change_shortcode_template'),10,2);

            add_filter('g5element_shortcode_listing_query_args',array($this,'set_query_args'),10,2);
        }

        public function vc_lean_map_config($vc_map_config,$key) {
            if (in_array($key,$this->get_shortcodes())) {
                $file_name = str_replace('_', '-', $key);
                $vc_map_config = G5BLOG()->locate_template("shortcodes/{$file_name}/config.php");
            }
            return $vc_map_config;
        }

        public function change_autoload_class_path($path,$shortcode,$file_name) {
            if (in_array($shortcode,$this->get_shortcodes())) {
                $path = G5BLOG()->locate_template("shortcodes/{$file_name}/{$file_name}.php");
            }
            return $path;
        }

        public function change_shortcode_template($template, $template_name) {
            if (in_array($template_name,$this->get_shortcodes())) {
                $template_name = str_replace('_', '-', $template_name);
                $template = G5BLOG()->locate_template("shortcodes/{$template_name}/template.php");
            }
            return $template;
        }

        public function get_shortcodes() {
            return array(
                'posts',
                'posts_slider'
            );
        }

        public function add_shortcodes_list($shortcodes) {
            return wp_parse_args($this->get_shortcodes(),$shortcodes);
        }

        public function get_auto_complete_fields() {
            return apply_filters('g5blog_auto_complete_fields',array(
                'g5element_posts_ids',
                'g5element_posts_slider_ids',
            ));
        }

        public function auto_complete() {
            $auto_complete_fields = $this->get_auto_complete_fields();
            foreach ($auto_complete_fields as $auto_complete_field) {
                //Filters For autocomplete param:
                add_filter( "vc_autocomplete_{$auto_complete_field}_callback", array(&$this,'post_search',), 10, 1 ); // Get suggestion(find). Must return an array
                add_filter( "vc_autocomplete_{$auto_complete_field}_render", array(&$this,'post_render',), 10, 1 ); // Render exact product. Must return an array (label,value)
            }
        }

        public function post_search( $search_string ) {
            $query = $search_string;
            $data = array();
            $args = array(
                's' => $query,
                'post_type' => 'post',
            );
            $args['vc_search_by_title_only'] = true;
            $args['numberposts'] = - 1;
            if ( 0 === strlen( $args['s'] ) ) {
                unset( $args['s'] );
            }
            add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
            $posts = get_posts( $args );
            if ( is_array( $posts ) && ! empty( $posts ) ) {
                foreach ( $posts as $post ) {
                    $data[] = array(
                        'value' => $post->ID,
                        'label' => $post->post_title,
                        'group' => $post->post_type,
                    );
                }
            }

            return $data;
        }

        function post_render( $value ) {
            $post = get_post( $value['value'] );
            return is_null( $post ) ? false : array(
                'label' => $post->post_title,
                'value' => $post->ID
            );
        }

        public function set_query_args($query_args,$atts) {
            if ($query_args['post_type'] === 'post') {
                $query_args['orderby'] = $atts['orderby'];
                $query_args['meta_key'] = ( 'meta_value' == $atts['orderby'] || 'meta_value_num' == $atts['orderby'] ) ? $atts['meta_key'] : '';

                if (!empty($atts['cat'])) {
                    $query_args['category__in'] = array_map('absint',explode(',',$atts['cat']));
                }

                if (!empty($atts['tag'])) {
                    $query_args['tag__in'] = array_map('absint',explode(',',$atts['tag']));
                }

                if ( $atts['time_filter'] !== 'none' ) {
                    $query_args['date_query'] = $this ->get_time_filter_query( $atts['time_filter'] );
                }

                if ( ! empty( $atts['ids']) ) {
                    $query_args['post__in'] = array_map('absint',explode(',',$atts['ids']));
                }
            }

            return $query_args;
        }

        public function get_time_filter_query($time_filter = null)
        {
            $date_query = array();

            switch ($time_filter) {
                // Today posts
                case 'today':
                    $date_query = array(
                        array(
                            'after' => '1 day ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Today + Yesterday posts
                case 'yesterday':
                    $date_query = array(
                        array(
                            'after' => '2 day ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Week posts
                case 'week':
                    $date_query = array(
                        array(
                            'after' => '1 week ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Month posts
                case 'month':
                    $date_query = array(
                        array(
                            'after' => '1 month ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
                // Year posts
                case 'year':
                    $date_query = array(
                        array(
                            'after' => '1 year ago', // should not escaped because will be passed to WP_Query
                        ),
                    );
                    break;
            }
            return $date_query;
        }
    }
}