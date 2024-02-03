<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5ERE_Templates' ) ) {
	class G5ERE_Templates {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_filter( 'template_include', array( $this, 'template_loader' ), 15 );

			add_filter( 'ere_locate_template', array( $this, 'change_ere_locate_template' ), 10, 3 );

			add_filter( 'ere_icon_favorite', array( $this, 'change_ere_icon_favorite' ) );

			add_filter( 'ere_icon_not_favorite', array( $this, 'change_ere_icon_not_favorite' ) );

			// Admin bar menus.
			if ( apply_filters( 'g5ere_show_admin_bar_visit_property', true ) ) {
				add_action( 'admin_bar_menu', array( $this, 'admin_bar_menus' ), 31 );
			}

			add_action( 'template_redirect', array( $this, 'change_view_list' ), 30 );
			add_action( 'template_redirect', array( $this, 'change_agent_view_list' ), 30 );
			add_action( 'template_redirect', array( $this, 'change_agency_view_list' ), 30 );
			add_filter( 'template_include', array( $this, 'change_dashboard_view' ), 30 );
			add_filter( 'template_include', array( $this, 'change_agency_page' ), 30 );
			add_filter( 'g5core_locate_template', array( $this, 'change_g5core_locate_template' ), 10, 3 );
			add_filter( 'g5element_locate_template', array( $this, 'change_g5element_locate_template' ), 10, 3 );
			add_filter( 'g5core_options_header_customize', array( $this, 'header_customize' ) );
			add_filter( 'g5core_options_header_mobile_customize', array( $this, 'header_customize' ) );
			add_filter( 'g5core_page_title', array( $this, 'page_title' ) );
			add_filter( 'g5core_page_title', array( $this, 'page_title_agency_search' ) );
			add_filter( 'ube_page_title', array( $this, 'page_title' ) );
			add_filter( 'ube_page_title', array( $this, 'page_title_agency_search' ) );
			add_filter( 'comments_template', array( $this, 'change_comments_template' ) );
		}


		public function page_title( $page_title ) {
			if ( is_singular( 'property' ) || is_post_type_archive( 'property' ) ) {
				$post_type_object = get_post_type_object( 'property' );
				if ( is_a( $post_type_object, 'WP_Post_Type' ) ) {
					$page_title = $post_type_object->labels->name;
				}
			}

			if ( is_singular( 'agent' ) || is_post_type_archive( 'agent' ) || is_tax( get_object_taxonomies( 'agent' ) ) ) {
				$post_type_object = get_post_type_object( 'agent' );
				if ( is_a( $post_type_object, 'WP_Post_Type' ) ) {
					$page_title = $post_type_object->labels->name;
				}

				if ( is_tax( 'agency' ) ) {
					$page_title = esc_html__( 'Agency', 'g5-ere' );
				}

			}

			return $page_title;
		}

		public function page_title_agency_search( $page_title ) {
			if ( g5ere_is_agency_page() ) {
				if ( isset( $_REQUEST['key_word'] ) && $_REQUEST['key_word'] != '' ) {
					$key_word   = $_REQUEST['key_word'];
					$page_title = sprintf( esc_html__( 'Search Results For: %s', 'g5-ere' ), $key_word );
				}
			}

			return $page_title;
		}

		public function template_loader( $template ) {
			if ( preg_match( '/archive-property\.php$/', $template ) ) {
				return G5ERE()->locate_template( 'archive-property.php' );
			}

			if ( preg_match( '/single-property\.php$/', $template ) ) {
				return G5ERE()->locate_template( 'single-property.php' );
			}

			if ( preg_match( '/archive-agent\.php$/', $template ) ) {
				return G5ERE()->locate_template( 'archive-agent.php' );
			}


			if ( preg_match( '/single-agent\.php$/', $template ) ) {
				return G5ERE()->locate_template( 'single-agent.php' );
			}

			if ( preg_match( '/taxonomy-agency\.php$/', $template ) ) {
				return G5ERE()->locate_template( 'taxonomy-agency.php' );
			}

			if ( preg_match( '/author\.php$/', $template ) ) {
				return G5ERE()->locate_template( 'author.php' );
			}

			return $template;
		}

		public function change_ere_locate_template( $template, $template_name, $template_path ) {
			if ( strpos( $template_name, 'shortcodes' ) === 0 ) {
				return $template;
			}
			$change_template = G5ERE()->plugin_dir( 'templates/' . $template_name );
			if ( is_readable( $change_template ) ) {
				$locate_template = G5ERE()->locate_template( $template_name );
				if ( is_readable( $locate_template ) ) {
					return $locate_template;
				}

				return $change_template;
			}

			return $template;
		}

		public function change_ere_icon_favorite() {
			return 'fas fa-star';
		}

		public function change_ere_icon_not_favorite() {
			return 'fal fa-star';
		}

		public function admin_bar_menus( $wp_admin_bar ) {
			if ( ! is_admin() || ! is_admin_bar_showing() ) {
				return;
			}

			// Show only when the user is a member of this site, or they're a super admin.
			if ( ! is_user_member_of_blog() && ! is_super_admin() ) {
				return;
			}

			// Add an option to visit the store.
			$wp_admin_bar->add_node(
				array(
					'parent' => 'site-name',
					'id'     => 'view-property',
					'title'  => esc_html__( 'Visit Properties', 'g5-ere' ),
					'href'   => get_post_type_archive_link( 'property' ),
				)
			);

			$wp_admin_bar->add_node(
				array(
					'parent' => 'site-name',
					'id'     => 'view-agent',
					'title'  => esc_html__( 'Visit Agent', 'g5-ere' ),
					'href'   => get_post_type_archive_link( 'agent' ),
				)
			);

			$agency_page = g5ere_get_agency_page();
			if ( ! empty( $agency_page ) ) {
				$wp_admin_bar->add_node(
					array(
						'parent' => 'site-name',
						'id'     => 'view-agency',
						'title'  => esc_html__( 'Visit Agency', 'g5-ere' ),
						'href'   => get_the_permalink( $agency_page ),
					)
				);
			}

		}


		public function change_view_list() {
			if ( is_post_type_archive( 'property' ) || is_tax( get_object_taxonomies( 'property' ) ) ) {
				$view = g5ere_get_property_switch_layout();
				G5ERE()->options()->set_option( 'post_layout', $view );
				if ( $view === 'list' ) {
					G5ERE()->options()->set_option( 'post_layout', 'list' );
					G5ERE()->options()->set_option( 'item_skin', G5ERE()->options()->get_option( 'list_item_skin' ) );
					G5ERE()->options()->set_option( 'post_image_size', G5ERE()->options()->get_option( 'post_list_image_size' ) );
					G5ERE()->options()->set_option( 'post_image_ratio', G5ERE()->options()->get_option( 'post_list_image_ratio' ) );
				}
			}
		}


		public function change_agency_view_list() {
			if ( g5ere_is_agency_page() ) {
				$view = g5ere_get_agency_switch_layout();
				if ( $view === 'list' ) {
					G5ERE()->options()->set_option( 'agency_layout', 'list' );
					G5ERE()->options()->set_option( 'agency_item_skin', G5ERE()->options()->get_option( 'agency_list_item_skin' ) );
					G5ERE()->options()->set_option( 'agency_image_size', G5ERE()->options()->get_option( 'agent_list_image_size' ) );
					G5ERE()->options()->set_option( 'agency_image_ratio', G5ERE()->options()->get_option( 'agency_list_image_ratio' ) );
				}
			}
		}

		public function change_agency_page( $template ) {
			if ( g5ere_is_agency_page() ) {
				$template = G5ERE()->locate_template( 'archive-agency.php' );
			}

			return $template;
		}

		public function change_agent_view_list() {
			if ( is_post_type_archive( 'agent' ) || is_tax( get_object_taxonomies( 'agent' ) ) ) {
				$view = g5ere_get_agent_switch_layout();
				G5ERE()->options()->set_option( 'agent_layout', $view );
				if ( $view === 'list' ) {
					G5ERE()->options()->set_option( 'agent_item_skin', G5ERE()->options()->get_option( 'agent_list_item_skin' ) );
					G5ERE()->options()->set_option( 'agent_image_size', G5ERE()->options()->get_option( 'agent_list_image_size' ) );
					G5ERE()->options()->set_option( 'agent_image_ratio', G5ERE()->options()->get_option( 'agent_list_image_ratio' ) );
					G5ERE()->options()->set_option( 'agent_item_custom_class', G5ERE()->options()->get_option( 'agent_list_item_custom_class' ) );
				}
			}
		}

		public function change_dashboard_view( $template ) {
			$dashboard_pages = apply_filters('g5ere_page_dashboard_view',array(
				'my_properties',
				'my_invoices',
				'my_favorites',
				'my_save_search',
				'submit_property',
				'my_profile',
				'dashboard',
				'review',
			));
			$current_url = add_query_arg( '', '', get_permalink() );
			for ( $i = 0; $i < count( $dashboard_pages ); $i ++ ) {
				if ( $current_url == ere_get_permalink( $dashboard_pages[ $i ] ) ) {
					$template = G5ERE()->locate_template( 'page-template/dashboard.php' );
					return $template;

				}
			}
			return $template;
		}

		public function change_g5core_locate_template( $located, $template_name, $args ) {
			$change_template = G5ERE()->plugin_dir( 'g5core/' . $template_name );
			if ( file_exists( $change_template ) ) {
				$locate_template = locate_template(
					array(
						trailingslashit( get_stylesheet_directory() ) . 'g5plus/core/' . $template_name
					)
				);

				if ( is_readable( $locate_template ) ) {
					return $locate_template;
				}

				return $change_template;
			}

			return $located;
		}

		public function change_g5element_locate_template( $located, $template_name, $args ) {
			$change_template = G5ERE()->plugin_dir( 'g5element/' . $template_name );
			if ( file_exists( $change_template ) ) {
				$locate_template = locate_template(
					array(
						trailingslashit( get_stylesheet_directory() ) . 'g5plus/core/' . $template_name
					)
				);
				if ( is_readable( $locate_template ) ) {
					return $locate_template;
				}

				return $change_template;
			}


			return $located;
		}

		public function header_customize( $header_customize ) {
			$customize        = array(
				'ere-login'           => esc_html__( 'ERE Login', 'g5-ere' ),
				'button-add-listing'  => esc_html__( 'Button Add Listing', 'g5-ere' ),
				'button-my-favourite' => esc_html__( 'Button My Favourite', 'g5-ere' ),
			);
			$header_customize = wp_parse_args( $customize, $header_customize );

			return $header_customize;
		}

		public function change_comments_template( $template ) {
			/**
			 * @var $post WP_Post
			 */
			global $post;
			if ( is_a( $post, 'WP_Post' ) ) {
				$enable_comments_reviews = 0;
				if ( $post->post_type === 'property' ) {
					$enable_comments_reviews = absint( ere_get_option( 'enable_comments_reviews_property', 0 ) );
				} else if ( $post->post_type === 'agent' ) {
					$enable_comments_reviews = absint( ere_get_option( 'enable_comments_reviews_agent', 0 ) );
				}
				if ( $enable_comments_reviews === 2 ) {
					$template = G5ERE()->locate_template( 'global/review.php' );
				}
			}

			return $template;
		}

	}
}