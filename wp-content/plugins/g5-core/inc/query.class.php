<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Core_Query')) {
    class G5Core_Query
    {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_cache( $key, $default = null ) {
            global $g5core_query_cache;
            return isset( $g5core_query_cache[ $key ] ) ? $g5core_query_cache[ $key ] : $default;
        }

        public function set_cache( $key, $data ) {
            global $g5core_query_cache;
            $g5core_query_cache[ $key ] = $data;
        }

        public function delete_cache( $key ) {
            global $g5core_query_cache;
            if (isset($g5core_query_cache[ $key ])) {
                unset($g5core_query_cache[ $key ]);
            }
        }

        public function flush_cache() {
            global $g5core_query_cache;
            $g5core_query_cache = null;
        }

        public function query_posts($query = null){
            $this->flush_cache();
            if (isset($query) && (!isset($GLOBALS['g5core_query']))) {
                $GLOBALS['g5core_query'] = new WP_Query();
                $GLOBALS['g5core_query']->query($query);
            }
        }

        public function reset_query(){
	        unset($GLOBALS['g5core_query']);
	        wp_reset_postdata();
        }

        public function reset_postdata() {
            $this->get_query()->reset_postdata();
        }

        public function get_query() {
            global $g5core_query;
            if ( ! is_a( $g5core_query, 'WP_Query' ) ) {
                global $wp_query;
                $g5core_query = &$wp_query;
            }
            return $g5core_query;
        }

        public function query_var_paged() {
            return $this->get_query()->get( 'page' ) ? intval( $this->get_query()->get( 'page' ) ) : ($this->get_query()->get( 'paged' ) ? intval( $this->get_query()->get( 'paged' ) ) : 1);
        }

        public function have_posts() {
            $have_posts = true;
            if ($this->get_cache('g5core_block_posts_count') !== null) {
                if ( $this->get_cache( 'g5core_block_posts_counter', 1 ) > $this->get_cache( 'g5core_block_posts_count' ) ) {
                    $have_posts = false;
                } else {
                    if ( $this->get_query()->current_post + 1 < $this->get_query()->post_count ) {
                        $have_posts = true;
                    } else {
                        $have_posts = false;
                    }
                }
            }


            if ($have_posts) {
                $have_posts = $this->get_query()->current_post + 1 < $this->get_query()->post_count;
            }

            return $have_posts;
        }

        public function the_post() {

            if ( $this->get_cache('g5core_block_posts_count') !== null ) {
                $group_post_counter = absint( $this->get_cache( 'g5core_block_posts_counter', 1 ) ) + 1;
                $this->set_cache( 'g5core_block_posts_counter', $group_post_counter);
            }

            $this->get_query()->the_post();
        }

        public function get_max_num_pages(){
            $offset = !empty($this->get_query()->get('original_offset')) ? $this->get_query()->get('original_offset') : $this->get_query()->get('offset') ;
            if (!empty($offset)) {
                return ceil( ( $this->get_query()->found_posts - intval($offset)  ) / intval($this->get_query()->get('posts_per_page')));
            }

            return $this->get_query()->max_num_pages;
        }

        public function get_total_block() {

            if ( $this->get_cache('g5core_block_posts_count') !== null ) {
                $post_count = $this->get_query()->post_count;
                return ceil($post_count / absint($this->get_cache('g5core_block_posts_count')));
            }
            return 1;
        }


        public function get_ajax_query_vars($query_args = null){
            if (!isset($query_args)) {
                $query_args = $this->get_query()->query_vars;
            }

            // remove empty vars
            foreach ($query_args as $_a => $_v ) {
                if ( is_array( $_v ) ) {
                    if ( count( $_v ) === 0 ) {
                        unset( $query_args[ $_a ] );
                    }
                } else {
                    if ( empty( $_v ) || $_v === 0 ) {
                        unset( $query_args[ $_a ] );
                    }
                }
            }


            if (!isset($query_args['paged'])) {
                $query_args['paged']   =  get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : (get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1);
            }

            if (isset($query_args['tag__in'])) {
                unset($query_args['tag_id']);
            }

            if (isset($query_args['category__in'])) {
                unset($query_args['cat']);
                unset($query_args['category_name']);
                unset($query_args['term']);
                unset($query_args['taxonomy']);
            }

            if (isset($query_args['author__in'])) {
                unset($query_args['author']);
            }



            // Remove extra vars
            unset( $query_args['suppress_filters'] );
            unset( $query_args['cache_results'] );
            unset( $query_args['update_post_term_cache'] );
            unset( $query_args['update_post_meta_cache'] );
            unset( $query_args['comments_per_page'] );
            unset( $query_args['no_found_rows'] );
            unset( $query_args['search_orderby_title'] );
            unset($query_args['lazy_load_term_meta']);
            return $query_args;
        }

        public function parse_ajax_query($query = array()) {

            if (!isset($query['post_status'])) {
                $query['post_status'] = 'publish';
            }

            if (!isset($query['paged'])) {
                $query['paged'] = 1;
            }

            global $paged;
            $paged = $query['paged'];

            return $query;

        }

		public function get_main_tax_query() {
			$tax_query = isset( $this->get_query()->tax_query, $this->get_query()->tax_query->queries ) ? $this->get_query()->tax_query->queries : array();
			return $tax_query;
		}

		public function get_main_meta_query() {
			$args       = $this->get_query()->query_vars;
			$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();
			return $meta_query;
		}

	    public function get_main_search_query_sql() {
		    global $wpdb;

		    $args         = $this->get_query()->query_vars;
		    $search_terms = isset( $args['search_terms'] ) ? $args['search_terms'] : array();
		    $sql          = array();

		    foreach ( $search_terms as $term ) {
			    // Terms prefixed with '-' should be excluded.
			    $include = '-' !== substr( $term, 0, 1 );

			    if ( $include ) {
				    $like_op  = 'LIKE';
				    $andor_op = 'OR';
			    } else {
				    $like_op  = 'NOT LIKE';
				    $andor_op = 'AND';
				    $term     = substr( $term, 1 );
			    }

			    $like = '%' . $wpdb->esc_like( $term ) . '%';
			    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			    $sql[] = $wpdb->prepare( "(($wpdb->posts.post_title $like_op %s) $andor_op ($wpdb->posts.post_excerpt $like_op %s) $andor_op ($wpdb->posts.post_content $like_op %s))", $like, $like, $like );
		    }

		    if ( ! empty( $sql ) && ! is_user_logged_in() ) {
			    $sql[] = "($wpdb->posts.post_password = '')";
		    }

		    return implode( ' AND ', $sql );
	    }
    }
}