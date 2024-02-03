<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Core_Post_Type' ) ) {
	class G5Core_Post_Type {

		/**
		 * Content Block Post type
		 *
		 * @var string
		 */
		private $content_block_post_type = 'g5core_content';

		/**
		 * Xmenu Mega Post type
		 *
		 * @var string
		 */
		private $xmenu_mega_post_type = 'g5core_xmenu_mega';


		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {

			// register post-type
			add_filter( 'gsf_register_post_type', array( $this, 'register_post_type' ) );

			// add filter category
			add_action( 'restrict_manage_posts', array( $this, 'add_content_type_filter' ) );
			add_filter( 'parse_query', array( $this, 'add_content_type_filter_query' ) );

			add_filter( 'single_template', array( $this, 'single_template' ) );

			add_filter( 'gsf_meta_box_config', array( $this, 'define_meta_box' ) );

			add_filter( 'manage_' . $this->get_content_block_post_type() . '_posts_columns', array(
				$this,
				'content_type_posts_columns'
			) );

			add_action( 'manage_' . $this->get_content_block_post_type() . '_posts_custom_column', array($this, 'content_type_column_value'), 10, 2);

			add_filter('g5core_meta_box_layout_post_types',array($this,'change_post_types_apply_meta_box'));
			add_filter('g5core_meta_box_header_post_types',array($this,'change_post_types_apply_meta_box'));
			add_filter('g5core_meta_box_footer_post_types',array($this,'change_post_types_apply_meta_box'));

		}

		public function change_post_types_apply_meta_box($post_types) {
			return wp_parse_args(array('g5core_content'),$post_types);
		}

		public function define_meta_box( $configs ) {
			$prefix                               = G5CORE()->meta_prefix;
			$configs['g5core_content_block_type'] = array(
				'name'      => esc_html__( 'Content Block Type', 'g5-core' ),
				'post_type' => array( $this->get_content_block_post_type() ),
				'layout'    => 'full',
				'context'   => 'side',
				'fields'    => array(
					"{$prefix}content_block_type" => array(
						'id'      => "{$prefix}content_block_type",
						'title'   => esc_html__( 'Select Types', 'g5-core' ),
						'type'    => 'select',
						'options' => G5CORE()->settings()->get_content_block_type(),
						'default' => 'other',
					),
				)
			);

			return $configs;
		}

		/**
		 * Get Content Block Post Type
		 *
		 * @return string
		 */
		public function get_content_block_post_type() {
			return $this->content_block_post_type;
		}

		public function get_xmenu_mega_post_type() {
			return $this->xmenu_mega_post_type;
		}

		/**
		 * Register Post Type
		 *
		 * @param $post_types
		 *
		 * @return mixed
		 */
		public function register_post_type( $post_types ) {

			// Post type Content Block
			$post_types [ $this->content_block_post_type ] = array(
				'label'               => esc_html__( 'Content Block', 'g5-core' ),
				'menu_icon'           => 'dashicons-editor-table',
				'menu_position'       => 35,
				'public'              => is_user_logged_in() ? true : false,
				'publicly_queryable'  => is_user_logged_in() ? true : false,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'supports'            => array(
					'title',
					'editor',
					'author',
					'revisions'
				)
			);

			$post_types [ $this->xmenu_mega_post_type ] = array(
				'label'               => esc_html__( 'Mega Menu', 'g5-core' ),
				'menu_icon'           => 'dashicons-list-view',
				'menu_position'       => 35,
				'public'              => is_user_logged_in() ? true : false,
				'publicly_queryable'  => is_user_logged_in() ? true : false,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => true,
				'supports'            => array(
					'title',
					'editor',
				)
			);


			return $post_types;
		}

		public function add_content_type_filter() {
			global $typenow;
			if ( $typenow === $this->get_content_block_post_type() ) {
				$current = isset( $_REQUEST['content_block_type'] ) ? $_REQUEST['content_block_type'] : '';
				?>
				<select name="content_block_type" id="content_block_type">
					<option value=""><?php esc_html_e( 'All Types', 'g5-core' ) ?></option>
					<?php foreach ( G5CORE()->settings()->get_content_block_type() as $k => $v ): ?>
						<option value="<?php echo esc_attr( $k ) ?>" <?php selected( $k, $current ) ?>><?php echo esc_html( $v ) ?></option>
					<?php endforeach; ?>
				</select>
				<?php
			}
		}

		public function add_content_type_filter_query( $query ) {
			global $pagenow;
			$q_vars = &$query->query_vars;
			if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $this->get_content_block_post_type() ) {

				$content_block_type = isset( $_REQUEST['content_block_type'] ) ? $_REQUEST['content_block_type'] : '';
				if ( $content_block_type !== '' ) {
					$query->query_vars['meta_key']     = G5CORE()->meta_prefix . 'content_block_type';
					$query->query_vars['meta_value']   = $content_block_type;
					$query->query_vars['meta_compare'] = '=';
				}
			}

			return $query;
		}

		public function content_type_posts_columns( $columns ) {
			$columns_new = array(
				'cb'     => '',
				'title'  => '',
				'type'   => esc_html__( 'Type', '' ),
				'author' => '',
				'date'   => ''
			);
			$columns     = wp_parse_args( $columns, $columns_new);
			return $columns;
		}

		public function content_type_column_value( $column, $post_id ) {
			if ( 'type' === $column ) {
				$content_block_types = G5CORE()->settings()->get_content_block_type();
				$content_block_type = get_post_meta($post_id, G5CORE()->meta_prefix . 'content_block_type', true);
				if (isset($content_block_types[$content_block_type])) {
					echo sprintf('<a href="%s">%s</a>',
						esc_url(admin_url('edit.php?post_type=' . $this->get_content_block_post_type() . '&content_block_type='.$content_block_type)),
						$content_block_types[$content_block_type]);
				}
			}
		}


		public function single_template( $single_template ) {
			global $post;
			if ( in_array( $post->post_type, array( $this->content_block_post_type, 'g5core_vc_template', $this->xmenu_mega_post_type, 'elementor_library' ) ) ) {
				$single_template = G5CORE()->locate_template( "single/{$post->post_type}.php" );
			}

			return $single_template;
		}
	}
}