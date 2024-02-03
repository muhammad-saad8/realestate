<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Preview_Property' ) ) {
	class G5ERE_Preview_Property {

		private static $_instance;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		public function init() {
			add_filter( 'pre_get_posts', array( $this, 'show_public_preview' ),1 );
		}

		public function show_public_preview( $query ) {
			if (
				is_user_logged_in() &&
				$query->is_main_query() &&
				$query->is_preview() &&
				$query->is_singular() &&
				isset( $_GET['g5ere_preview'] ) &&
				isset( $query->query_vars['post_type'] ) &&
				( $query->query_vars['post_type'] === 'property' )
			) {
				if ( ! headers_sent() ) {
					nocache_headers();
				}
				add_action( 'wp_head', 'wp_no_robots' );

				add_filter( 'posts_results', array( $this, 'set_post_to_publish' ), 10 );
			}

			return $query;
		}

		public function get_preview_link( $post_id =null ) {
			return get_preview_post_link( $post_id ) . '&g5ere_preview=true';
		}

		public function set_post_to_publish( $posts ) {
			remove_filter( 'posts_results', array( $this, 'set_post_to_publish' ), 10 );
			if ( empty( $posts ) ) {
				return;
			}

			// If the post has gone live, redirect to it's proper permalink.
			$this->maybe_redirect_to_published_post( $posts[0] );

			if ( $this->is_public_preview_available( $posts[0] ) ) {
				// Set post status to publish so that it's visible.
				$posts[0]->post_status = 'publish';
				// Disable comments and pings for this post.
				add_filter( 'comments_open', '__return_false' );
				add_filter( 'pings_open', '__return_false' );
			}

			return $posts;
		}

		/**
		 * @param $post WP_Post
		 *
		 * @return bool
		 */
		private function maybe_redirect_to_published_post( $post ) {
			if ( ! in_array( $post->post_status, $this->get_published_statuses() ) ) {
				return false;
			}


			wp_redirect( get_permalink( $post->ID ), 301 );
			exit;
		}

		private function get_published_statuses() {
			$published_statuses = array( 'publish', 'private' );
			return apply_filters( 'g5ere_published_statuses', $published_statuses );
		}

		/**
		 * @param $post WP_Post
		 *
		 * @return bool
		 */
		private function is_public_preview_available( $post ) {
			if ( ! $post ) {
				return false;
			}
			if ( (int) $post->post_author !== get_current_user_id() ) {
				return false;
			}

			return true;
		}
	}
}