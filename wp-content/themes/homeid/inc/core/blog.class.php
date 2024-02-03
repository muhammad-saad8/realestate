<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (! class_exists('HOMEID_CORE_BLOG')) {
	class HOMEID_CORE_BLOG{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function init() {
			add_filter( 'g5core_default_options_g5blog_options', array($this,'change_default_options'), 11 );

			add_action('g5blog_loop_post_content',array($this,'change_layout'),1);

			add_filter('g5blog_loop_post_meta_args',array($this,'change_loop_post_meta_args'),10,2);

			add_action('g5blog_after_loop_post_thumbnail',array($this,'add_post_cat'),1);

			add_filter('g5blog_config_layout_matrix',array($this,'change_g5blog_config_layout_matrix'));

			add_filter('g5blog_options_post_layout',array($this,'change_post_layout'));

			add_filter('g5blog_shortcode_post_layout',array($this,'change_shortcode_post_layout'));

			add_filter('g5blog_post_layout_has_columns',array($this,'change_post_layout_has_columns'));

			add_filter('g5blog_shortcode_post_slider_layout',array($this,'change_shortcode_post_slider_layout'));

			add_filter('g5blog_image_sizes',array($this,'change_image_sizes'));


			add_action('g5blog_single_meta_top', array($this,'template_single_meta_cat') ,4);

			add_filter('g5blog_single_meta_args',array($this,'change_single_meta_args'));

			add_action('g5blog_after_single',array($this,'change_after_single'),1);

			add_filter('g5blog_single_related_settings',array($this,'change_single_related_settings'));

			add_action('g5blog_before_single_content',array($this,'template_single_meta_cat'),3);

			add_action('template_redirect', array($this,'demo_layout') ,15);
			add_action( 'pre_get_posts', array( $this, 'demo_post_per_pages' ), 15 );


			/**
			 * Layout Grid 04
			 */
			add_action('g5blog_after_loop_post_thumbnail_content_grid_4','g5blog_template_loop_post_meta',5);
			add_action('g5blog_after_loop_post_thumbnail_content_grid_4','g5blog_template_post_title',10);


		}

		public function change_layout($post_layout) {
			remove_action('g5blog_loop_post_content','g5blog_template_loop_post_meta',10);
			add_action('g5blog_loop_post_content','g5blog_template_loop_post_meta',4);
			if ($post_layout !== 'medium-image-2') {
				add_action('g5blog_loop_post_content',array($this,'template_loop_read_more'),20);
			}

			if ($post_layout === 'grid-4') {
				remove_action('g5blog_loop_post_content','g5blog_template_loop_post_meta',4);
				remove_action('g5blog_loop_post_content','g5blog_template_post_title',5);
			}

		}


		public function change_loop_post_meta_args($post_meta,$post_layout){
			if ( in_array($post_layout,array('medium-image','grid','grid-3'))) {
				$post_meta = array(
					'date'    => true,
					'view' => true
				);
			}

			if (in_array($post_layout,array('grid-2','grid-4','medium-image-2'))) {
				$post_meta = array(
					'date'    => true
				);
			}

			return $post_meta;
		}

		public function add_post_cat($post_layout) {
			if ($post_layout === 'medium-image' || $post_layout === 'grid' || $post_layout === 'grid-2' || $post_layout === 'grid-3' || $post_layout === 'grid-4') {
				add_action('g5blog_after_loop_post_thumbnail',array($this,'template_loop_post_cate'));
			}
		}

		public function template_loop_read_more($post_layout) {
			?>
				<?php if ($post_layout === 'large-image'): ?>
					<a class="btn btn-outline btn-dark btn-read-more" href="<?php the_permalink() ?>"><?php esc_html_e('Read more','homeid') ?> <i class="fal fa-long-arrow-right text-accent"></i></a>
				<?php endif; ?>

				<?php if (in_array($post_layout,array('grid','grid-2','grid-4','medium-image','medium-image-2'))): ?>
				<a class="btn btn-link btn-dark btn-read-more" href="<?php the_permalink() ?>"><?php esc_html_e('Read more','homeid') ?> <i class="fal fa-long-arrow-right text-accent"></i></a>
				<?php endif; ?>

				<?php if ($post_layout === 'grid-3'): ?>
				<a class="btn btn-sm btn-primary btn-read-more" href="<?php the_permalink() ?>"><?php esc_html_e('Read more','homeid') ?> <i class="fal fa-long-arrow-right"></i></a>
			    <?php endif; ?>
			<?php
		}

		public function template_loop_post_cate() {
			$cat = $this->get_primary_cat();
			if (is_object($cat) === false) return;
			?>
			<a class="g5blog__term-badge" href="<?php echo esc_url(get_category_link($cat)) ?>" title="<?php echo esc_attr($cat->name) ?>"><?php echo esc_html($cat->name) ?></a>
			<?php
		}



		public function change_post_layout($layout) {

			unset($layout['masonry']);

			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 31,
				),
				'grid-3' => array(
					'label' => esc_html__('Grid 3', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 32,
				),
				'grid-4' => array(
					'label' => esc_html__('Grid 4', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 33,
				),
				'medium-image-2' => array(
					'label' => esc_html__('Medium Image 2', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-medium-image.png'),
					'priority' => 21,
				),

			),$layout);
		}

		public function change_shortcode_post_layout($layout) {
			unset($layout['masonry']);

			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 31,
				),
				'grid-3' => array(
					'label' => esc_html__('Grid 3', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 32,
				),
				'grid-4' => array(
					'label' => esc_html__('Grid 4', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 33,
				),
				'medium-image-2' => array(
					'label' => esc_html__('Medium Image 2', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-medium-image.png'),
					'priority' => 21,
				),
				'list' => array(
					'label' => esc_html__('List', 'homeid'),
					'img' => get_parent_theme_file_uri('assets/images/blog-list.png'),
					'priority' => 50,
				),
			),$layout);
		}



		public function change_shortcode_post_slider_layout($layout) {
			return wp_parse_args(array(
				'grid-2' => array(
					'label' => esc_html__('Grid 2', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 11,
				),
				'grid-3' => array(
					'label' => esc_html__('Grid 3', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 12,
				),
				'grid-4' => array(
					'label' => esc_html__('Grid 4', 'homeid'),
					'img' => G5BLOG()->plugin_url('assets/images/theme-options/blog-grid.png'),
					'priority' => 13,
				),
			),$layout);
		}

		public function change_g5blog_config_layout_matrix($layout_matrix) {
			return wp_parse_args(array(
				'grid-2' => array(
					'layout' => array(
						array('template' => 'grid', 'template_class' => 'g5blog__post-grid g5blog__post-grid-2')
					),
				),
				'grid-3' => array(
					'layout' => array(
						array('template' => 'grid', 'template_class' => 'g5blog__post-grid g5blog__post-grid-3')
					),
				),
				'grid-4' => array(
					'layout' => array(
						array('template' => 'grid-4', 'template_class' => 'g5blog__post-grid g5blog__post-grid-2 g5blog__post-grid-4')
					),
					'placeholder' => 'on'
				),
				'medium-image-2'           => array(
					'layout'             => array(
						array('template' => 'medium-image', 'template_class' => 'g5blog__post-medium-image g5blog__post-medium-image-2'),
					),
					'columns'            => 1,
				),
				'list'           => array(
					'layout'             => array(
						array('template' => 'list'),
					),
					'columns'            => 1,
				),
			),$layout_matrix);
		}


		public function change_post_layout_has_columns($post_layout) {
			return wp_parse_args(array('grid-2','grid-3','grid-4'),$post_layout);
		}


		public function template_single_meta_cat(){
			homeid_get_template('post/entry-cat') ;
		}

		public function change_single_meta_args($args) {
			return array(
				'author'  => true,
				'date'    => true,
				'view' => true,
				'like' => true
			);
		}

		public function change_after_single() {
			remove_action('g5blog_after_single','g5blog_template_author_info',15);
			add_action('g5blog_after_single','g5blog_template_author_info',5);
			remove_action('g5blog_after_single','g5blog_template_single_related',20);
			add_action('g5blog_after_single','g5blog_template_single_related',30);
		}

		public function change_single_related_settings($args) {
			return wp_parse_args(array(
					'post_layout' => 'grid-2',
					'image_size' => '370x220'
			),$args);
		}


		public function get_primary_cat()
		{
			// Primary category from Yoast SEO plugin
			if (class_exists('WPSEO_Primary_Term')) {
				$prim_cat = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true);
				if ($prim_cat) {
					$prim_cat = get_category($prim_cat);
					if (!is_wp_error($prim_cat)) {
						return $prim_cat;
					}
				}
			}

			global $wp_query;
			$prim_cat = $wp_query->get('category_name','');
			if ($prim_cat!== '') {
				$prim_cat = get_category_by_slug($prim_cat);
				if (!is_wp_error($prim_cat)) {
					return $prim_cat;
				}
			}

			$category__in = $wp_query->get('category__in', array());
			if (sizeof($category__in) > 0) {
				$categories = get_the_category();
				for ($i = 0; $i < sizeof($categories); $i++) {
					if (!in_array($categories[$i]->term_id, $category__in)) {
						unset($categories[$i]);
					}
				}
				if (sizeof($categories) > 0) {
					return current($categories);
				}
			}

			// First cat
			return current(get_the_category());
		}



		public function change_image_sizes($image_sizes) {
			return wp_parse_args(array(
				'blog-widget' => '100x80',
			),$image_sizes);
		}

		public function change_default_options($defaults) {
			return wp_parse_args(array(
				'single_post_related_columns_xl' => 2,
				'single_post_related_columns_lg' => 2,
				'single_post_related_columns_md' => 2,
				'single_post_related_columns_sm' => 2,
				'single_post_related_columns' => 1,
				'single_post_navigation_enable' => 'on',
				'single_post_author_info_enable' => 'on',
				'single_post_related_enable' => 'on',
				'single_post_layout' => 'layout-2',

			),$defaults) ;
		}

		public function demo_layout() {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5BLOG' ) ) {
				return;
			}
			$post_layout = isset( $_REQUEST['post_layout'] ) ? $_REQUEST['post_layout'] : '';

			if ( ! empty( $post_layout ) ) {
				$ajax_query                = G5CORE()->cache()->get( 'g5core_ajax_query', array() );
				$ajax_query['post_layout'] = $post_layout;
				G5CORE()->cache()->set( 'g5core_ajax_query', $ajax_query );
			}

			$has_sidebar = homeid_has_sidebar();

			if ( ! empty( $post_layout ) ) {
				switch ( $post_layout ) {
					case 'large-image':
						G5BLOG()->options()->set_option('post_layout','large-image');
						if ($has_sidebar) {
							G5BLOG()->options()->set_option('post_image_size','770x400');
						}
						break;
					case 'grid':
					case 'grid-2':
					case 'grid-3':
					case 'grid-4':
						G5BLOG()->options()->set_option('post_layout',$post_layout);
						G5BLOG()->options()->set_option('post_columns_gutter','30');
						G5BLOG()->options()->set_option('post_columns_xl','3');
						G5BLOG()->options()->set_option('post_columns_lg','3');
						G5BLOG()->options()->set_option('post_columns_md','3');
						G5BLOG()->options()->set_option('post_columns_sm','2');
						G5BLOG()->options()->set_option('post_columns','1');
						G5BLOG()->options()->set_option('post_image_size','370x220');
						if ($has_sidebar) {
							G5BLOG()->options()->set_option('post_columns_xl','2');
							G5BLOG()->options()->set_option('post_columns_lg','2');
							G5BLOG()->options()->set_option('post_columns_md','2');
						}
						break;
					case 'medium-image':
						G5BLOG()->options()->set_option('post_layout','medium-image');
						G5BLOG()->options()->set_option('post_image_size','370x215');
						break;
				}


			}

		}

		public function demo_post_per_pages( $query ) {
			if ( ! function_exists( 'G5CORE' ) || ! function_exists( 'G5BLOG' ) ) {
				return;
			}
			if ( ! is_admin() && $query->is_main_query() ) {
				$post_layout = isset( $_REQUEST['post_layout'] ) ? $_REQUEST['post_layout'] : '';
				if ( empty( $post_layout ) ) {
					return;
				}
				$site_layout = isset( $_REQUEST['site_layout'] ) ? $_REQUEST['site_layout'] : '';
				if ( ! empty( $site_layout ) ) {
					G5CORE()->options()->layout()->set_option( 'site_layout', $site_layout );
				}
				$has_sidebar = homeid_has_sidebar();
				switch ( $post_layout ) {
					case 'grid':
					case 'grid-2':
					case 'grid-3':
					case 'grid-4':
						$query->set( 'posts_per_page', 9 );
						if ( $has_sidebar ) {
							$query->set( 'posts_per_page', 8 );
						}
						break;
					case 'medium-image':
						$query->set( 'posts_per_page', 6 );
						break;
					case 'large-image':
						$query->set( 'posts_per_page', 6 );
						break;
				}
			}

		}

	}
}