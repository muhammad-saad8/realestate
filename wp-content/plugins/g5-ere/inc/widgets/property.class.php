<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5ERE_Widget_Property')) {
	class G5ERE_Widget_Property extends GSF_Widget {
		public function __construct() {
			$this->widget_cssclass = 'g5ere__widget-property';
			$this->widget_id = 'g5ere_widget_property';
			$this->widget_name = esc_html__('G5Plus: Property', 'g5-ere');
			$this->widget_description = esc_html__( 'Display list property', 'g5-ere' );
			$this->settings = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'title'   => esc_html__('Title', 'g5-ere'),
						'type'    => 'text',
						'default' => esc_html__( 'Recent Property', 'g5-ere' ),
					),
					array(
						'id'      => 'source',
						'type'    => 'select',
						'title'   => esc_html__('Source', 'g5-ere'),
						'default' => 'recent',
						'options' => array(
							'random'   => esc_html__('Random', 'g5-ere'),
							'featured'  => esc_html__('Featured', 'g5-ere'),
							'recent'   => esc_html__('Recent', 'g5-ere'),
							'oldest'   => esc_html__('Oldest', 'g5-ere'),
						)
					),
					array(
						'id'         => 'posts_per_page',
						'type'       => 'text',
						'input_type' => 'number',
						'title'      => esc_html__('Number of property to show:', 'g5-ere'),
						'default'    => '4',
					),
					'item_skin'           => array(
						'id'       => 'item_skin',
						'title'    => esc_html__( 'Item Skin', 'g5-ere' ),
						'subtitle' => esc_html__( 'Specify your property item skin', 'g5-ere' ),
						'type'     => 'image_set',
						'options'  => G5ERE()->settings()->get_widget_property_skins(),
						'default'  => 'skin-01',
					),
					array(
						'id' => 'post_image_size',
						'title' => esc_html__('Image size', 'g5-ere'),
						'subtitle' => esc_html__('Enter your image size', 'g5-ere'),
						'desc' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-ere'),
						'type' => 'text',
						'default' => 'thumbnail',
					),
					G5CORE()->fields()->get_config_toggle(array(
						'id'       => 'carousel_enable',
						'title'    => esc_html__('Carousel Mode', 'g5-ere'),
						'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'g5-ere'),
						'default'  => '',
					)),

				)
			);
			parent::__construct();
		}

		public function widget( $args, $instance ) {
			if ($this->get_cached_widget($instance)) {
				return;
			}

			extract($args, EXTR_SKIP);
			$source = (!empty($instance['source'])) ? $instance['source'] : 'recent';
			$posts_per_page = (!empty($instance['posts_per_page'])) ? absint($instance['posts_per_page']) : 4;
			$item_skin = (!empty($instance['item_skin'])) ? $instance['item_skin'] : 'skin-01';
			$post_image_size = (!empty($instance['post_image_size'])) ? $instance['post_image_size'] : 'thumbnail';
			$carousel_enable = (!empty($instance['carousel_enable'])) ? $instance['carousel_enable'] : '';

			$query_args = array(
				'posts_per_page'      => $posts_per_page,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'post_type'           => 'property',
				'tax_query' => array(
					'relation' => 'AND',
				),
				'meta_query' => array()
			);

			switch ($source) {
				case 'random' :
					$query_args['orderby'] = 'rand';
					$query_args['order'] = 'DESC';
					break;
				case 'featured':
					$query_args['meta_query'][] = array(
						'key'     => ERE_METABOX_PREFIX . 'property_featured',
						'value'   => 1,
						'compare' => '=',
					);
					break;
				case 'recent':
					$query_args['orderby'] = 'date';
					$query_args['order'] = 'DESC';
					break;
				case 'oldest':
					$query_args['orderby'] = 'date';
					$query_args['order'] = 'ASC';
					break;
			}

			$the_query = new WP_Query($query_args);

			$slick_options = array(
				'slidesToShow'   => 1,
				'slidesToScroll' => 1,
				'arrows'         => false,
				'dots'           => true,
				'draggable' => true,
			);

			$wrapper_classes = array(
				'g5ere__widget-property-list'
			);

			$wrapper_attributes = array();

			if ($carousel_enable === 'on') {
				$wrapper_classes[] = 'slick-slider';
				$wrapper_classes[] = 'g5core__gutter-0';
				$wrapper_attributes[] = "data-slick-options='" . esc_attr(json_encode($slick_options)) . "'";
			}
			$wrapper_class = implode(' ', $wrapper_classes);
			ob_start();
			$this->widget_start($args,$instance);
			?>
			<div class="<?php echo esc_attr($wrapper_class)?>" <?php echo join(' ', $wrapper_attributes)?>>

				<?php
					while ($the_query->have_posts()) {
						$the_query->the_post();
						G5ERE()->get_template("widgets/property/{$item_skin}.php",array(
							'image_size' => $post_image_size
						));
					}
				?>
			</div>
			<?php
			wp_reset_postdata();
			$this->widget_end($args);
			echo $this->cache_widget( $instance, ob_get_clean() ); // WPCS: XSS ok.
		}

	}
}