<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
abstract class G5Core_Elements_Listing_Abstract extends UBE_Abstracts_Elements {
	public $_atts = array();

	public $_tabs = array();

	public $_query_args = array();

	public $_settings = array();

	public function prepare_display($atts = array(), $query_args = array(), $settings = array()) {

		// remove $atts['columns_gutter'] when $atts['columns_gutter'] is null
		if (!isset($atts['columns_gutter'])) {
			unset($atts['columns_gutter']);
		}

		$this->_atts = wp_parse_args($atts, array(
			'post_layout' => '',
			'cate_filter_enable' => '',
			'cate_filter_align' => '',
			'posts_per_page' => 10,
			'post_paging' => 'none',
			'post_animation' => '',
			'item_custom_class' => '',
			'item_skin' => '',
			'cat' => '',
			'tag' => '',
			'ids' => '',
			'offset' => '',
			'orderby' => 'date',
			'order' => 'desc',
			'time_filter' => 'none',
			'meta_key' => '',
			'show' => '',
			'tabs' => '',

			'columns_gutter' => 30,

			'post_columns' => array(
				'xl' => 4,
				'lg' => '',
				'md'=> '',
				'sm' => '',
				'xs' => ''
			),


			'columns_xl' => 1,
			'columns_lg' => 1,
			'columns_md' => 1,
			'columns_sm' => 1,
			'columns' => 1,

			'append_tabs' => '',


			'slider' => false,
			'slider_rows' => 1,
			'slider_pagination_enable' => '',
			'slider_navigation_enable' => '',
			'slider_center_enable' => '',
			'slider_center_padding' => '',
			'slider_auto_height_enable' => 'on',
			'slider_loop_enable' => '',
			'slider_fade_enable' => '',
			'slider_autoplay_enable' => '',
			'slider_autoplay_timeout' => '',
			'slider_variable_width' => ''
		));


		$this->_atts['posts_per_page'] = absint($this->_atts['posts_per_page']) ? absint($this->_atts['posts_per_page']) : 10;
		$this->_atts['columns_gutter'] = absint($this->_atts['columns_gutter']);

		if (!is_array($this->_atts['post_columns'])) {
			$this->_atts['post_columns'] = array(
				'xl' => $this->_atts['post_columns'],
				'lg' => '',
				'md' => '',
				'sm' => '',
				'xs' => ''
			);
		}

		$this->_atts['columns_xl']  = absint($this->_atts['post_columns']['xl']);
		$this->_atts['columns_lg'] = $this->_atts['post_columns']['lg'] == '' ? $this->_atts['columns_xl'] : absint($this->_atts['post_columns']['lg']);
		$this->_atts['columns_md'] = $this->_atts['post_columns']['md'] == '' ? $this->_atts['columns_lg'] : absint($this->_atts['post_columns']['md']);
		$this->_atts['columns_sm'] = $this->_atts['post_columns']['sm'] == '' ? $this->_atts['columns_md'] : absint($this->_atts['post_columns']['sm']);
		$this->_atts['columns'] = $this->_atts['post_columns']['xs'] == '' ? $this->_atts['columns_sm'] : absint($this->_atts['post_columns']['xs']);

		/*$this->_atts['columns_xl'] = absint($this->_atts['columns_xl']);
		$this->_atts['columns_lg'] = absint($this->_atts['columns_lg']);
		$this->_atts['columns_md'] = absint($this->_atts['columns_md']);
		$this->_atts['columns_sm'] = absint($this->_atts['columns_sm']);
		$this->_atts['columns'] = absint($this->_atts['columns']);*/

		$this->_atts['slider_rows'] = absint($this->_atts['slider_rows']) ? absint($this->_atts['slider_rows']) : 1;

		$this->prepare_settings($settings);
		if (!empty($this->_atts['tabs'])) {
			$this->prepare_tabs($query_args);
		} else {
			$this->_query_args = $this->get_query_args($query_args,$this->_atts);
		}

	}

	public function get_query_args($query_args, $atts){
		$query_args = wp_parse_args($query_args,array(
			'post_type'=> 'post',
			'post_status'    => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $this->_atts['posts_per_page'],
			'order' => isset($atts['order']) ? $atts['order'] : 'desc',
			'orderby' => isset($atts['orderby']) ? $atts['orderby'] : 'date'
		));

		switch ( $atts['orderby'] ) {
			case 'menu_order':
				$query_args['orderby'] = 'menu_order title';
				break;
			case 'title':
				$query_args['orderby'] = 'title';
				break;
			case 'relevance':
				$query_args['orderby'] = 'relevance';
				$query_args['order']   = 'DESC';
				break;
			case 'date':
				$query_args['orderby'] = 'date ID';
				break;
			case 'rand':
				$query_args['orderby'] = 'rand';
				break;
		}

		if (!empty($this->_atts['offset'])) {
			$query_args['offset'] = absint($this->_atts['offset']);
		}


		if ($this->_atts['post_paging'] === 'none') {
			$query_args['no_found_rows'] = 1;
		}

		return apply_filters('ube_element_listing_query_args',$query_args,$atts);
	}

	public function prepare_settings($settings) {
		$this->_settings = wp_parse_args($settings,array(
			'post_layout' => $this->_atts['post_layout'],
			'post_columns' => array(
				'xl' => $this->_atts['columns_xl'],
				'lg' => $this->_atts['columns_lg'],
				'md' => $this->_atts['columns_md'],
				'sm' => $this->_atts['columns_sm'],
				'' => $this->_atts['columns'],
			),
			'columns_gutter' => $this->_atts['columns_gutter'],
			'post_paging' => in_array($this->_atts['post_paging'],array('none')) ? '' : $this->_atts['post_paging'],
			'cate_filter_enable' =>    $this->_atts['cate_filter_enable'] === 'on',
			'cate_filter_align' => $this->_atts['cate_filter_align'],
			'post_animation' => $this->_atts['post_animation'],
			'item_skin' => $this->_atts['item_skin'],
			'item_custom_class' => $this->_atts['item_custom_class'],
			'append_tabs' => $this->_atts['append_tabs'],
		));


		if ($this->_atts['cate_filter_enable'] === 'on' && !empty($this->_atts['cat'])) {
			$this->_settings['cate'] = array_filter($this->_atts['cat'],'absint');
		}

		if ($this->_atts['slider']) {
			$slick_options = array(
				'slidesToShow'   => $this->_atts['columns_xl'],
				'slidesToScroll' => $this->_atts['columns_xl'],
				'centerMode'     => $this->_atts['slider_center_enable'] === 'on',
				'centerPadding'  => $this->_atts['slider_center_padding'],
				'arrows'         => $this->_atts['slider_navigation_enable'] === 'on',
				'dots'           => $this->_atts['slider_pagination_enable'] === 'on',
				'infinite'       => $this->_atts['slider_center_enable'] === 'on' ? true :  $this->_atts['slider_loop_enable'] === 'on',
				'fade'          => $this->_atts['slider_fade_enable'] === 'on',
				'adaptiveHeight' => $this->_atts['slider_auto_height_enable'] === 'on',
				'autoplay'       => $this->_atts['slider_autoplay_enable'] === 'on',
				'autoplaySpeed'  => absint($this->_atts['slider_autoplay_timeout']),
				'draggable' => true,
				'responsive'     => array(
					array(
						'breakpoint' => 1200,
						'settings'   => array(
							'slidesToShow'   => $this->_atts['columns_lg'],
							'slidesToScroll' => $this->_atts['columns_lg'],
						)
					),
					array(
						'breakpoint' => 992,
						'settings'   => array(
							'slidesToShow'   => $this->_atts['columns_md'],
							'slidesToScroll' => $this->_atts['columns_md'],
						)
					),
					array(
						'breakpoint' => 768,
						'settings'   => array(
							'slidesToShow'   => $this->_atts['columns_sm'],
							'slidesToScroll' => $this->_atts['columns_sm'],
						)
					),
					array(
						'breakpoint' => 576,
						'settings'   => array(
							'slidesToShow'   => $this->_atts['columns'],
							'slidesToScroll' => $this->_atts['columns'],
						)
					)
				),
			);

			if ($this->_atts['slider_rows'] > 1) {
				$slick_options['rows'] = $this->_atts['slider_rows'];
				$slick_options['slidesPerRow']  = 1;
				$slick_options['slidesToShow'] =  $this->_atts['columns_xl'];
				$slick_options['slidesToScroll'] = 1;

				$slick_options['responsive'] = array(
					array(
						'breakpoint' => 1200,
						'settings'   => array(
							'slidesPerRow'  => 1,
							'slidesToShow'   => $this->_atts['columns_lg'],
							'slidesToScroll' => 1,
						)
					),
					array(
						'breakpoint' => 992,
						'settings'   => array(
							'slidesPerRow'  => 1,
							'slidesToShow'   => $this->_atts['columns_md'],
							'slidesToScroll' => 1,
						)
					),
					array(
						'breakpoint' => 768,
						'settings'   => array(
							'slidesPerRow'  => 1,
							'slidesToShow'   => $this->_atts['columns_sm'],
							'slidesToScroll' => 1,
						)
					),
					array(
						'breakpoint' => 576,
						'settings'   => array(
							'slidesPerRow'  => 1,
							'slidesToShow'   => $this->_atts['columns'],
							'slidesToScroll' => 1,
						)
					)
				);
			}
			$this->_settings['slider_rows'] = $this->_atts['slider_rows'];
			$this->_settings['slick'] = $slick_options;
		}
	}

	public function prepare_tabs($query_args) {
		if (!empty($this->_atts['tabs'])) {
			$tabs = (array)$this->_atts['tabs'];
			$tabs_args = array();
			foreach ($tabs as $tab) {
				$product_tab_icon_type = isset($tab['product_tab_icon_type']) ? $tab['product_tab_icon_type'] : '';

				$product_tab_image = isset($tab['product_tab_image']) ? $tab['product_tab_image'] : '';
				$product_tab_image_id = $product_tab_image_url = '';
				if (is_array($product_tab_image)) {
					$product_tab_image_id = isset($product_tab_image['id']) ? $product_tab_image['id'] : '';
					$product_tab_image_url = isset($product_tab_image['url']) ? $product_tab_image['url'] : '';
				}
				$product_tab_icon = isset($tab['product_tab_icon'])  ? $tab['product_tab_icon'] : '';
				$product_tab_icon_html = '';
				if (!empty($product_tab_icon) && ($product_tab_icon_type === 'icon')) {
					ob_start();
					Icons_Manager::render_icon( $product_tab_icon);
					$product_tab_icon_html = ob_get_clean();
				}
				$tabs_args[] = array(
					'label' => $tab['product_tab_title'],
					'icon' => array(
						'type' => $product_tab_icon_type,
						'icon_html' => $product_tab_icon_html,
						'image' => !empty($product_tab_image_id) ? $product_tab_image_id : $product_tab_image_url
					),
					'query_args' => $this->get_query_args($query_args,$tab)
				);
			}
			$this->_settings['tabs'] = $tabs_args;
		}
	}


	protected function register_slider_section_controls() {
		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__( 'Slider Options', 'g5-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control('slider_rows',[
			'label' => esc_html__('Slide Rows','g5-core' ),
			'type' => Controls_Manager::NUMBER,
			'default' => 1
		]);

		$this->add_control(
			'slider_pagination_enable',
			[
				'label' => esc_html__( 'Show Pagination', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-core' ),
				'label_off' => esc_html__( 'Hide', 'g5-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);


		$this->add_control(
			'slider_navigation_enable',
			[
				'label' => esc_html__( 'Show Navigation', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-core' ),
				'label_off' => esc_html__( 'Hide', 'g5-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_center_enable',
			[
				'label' => esc_html__( 'Center Mode', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'g5-core' ),
				'label_off' => esc_html__( 'Disable', 'g5-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_center_padding',
			[
				'label' => esc_html__('Center Padding','g5-core' ),
				'description' => esc_html__('Side padding when in center mode (px/%)','g5-blog'),
				'type' => Controls_Manager::TEXT,
				'default' => '50px',
				'condition' => [
					'slider_center_enable' => 'on',
				],
			]);


		$this->add_control(
			'slider_auto_height_enable',
			[
				'label' => esc_html__( 'Auto Height Enable', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'g5-core' ),
				'label_off' => esc_html__( 'Disable', 'g5-core' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);

		$this->add_control(
			'slider_loop_enable',
			[
				'label' => esc_html__( 'Loop Mode', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'g5-core' ),
				'label_off' => esc_html__( 'Disable', 'g5-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_fade_enable',
			[
				'label' => esc_html__( 'Fade Enable', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'g5-core' ),
				'label_off' => esc_html__( 'Disable', 'g5-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_autoplay_enable',
			[
				'label' => esc_html__( 'Autoplay Enable', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'g5-core' ),
				'label_off' => esc_html__( 'Disable', 'g5-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'slider_autoplay_timeout',
			[
				'label' => esc_html__('Autoplay Timeout','g5-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'slider_autoplay_enable' => 'on',
				],
			]);

		$this->end_controls_section();
	}

	protected function register_item_custom_class_controls() {
		$this->add_control(
			'item_custom_class',
			[
				'label' => esc_html__( 'Item Css Classes', 'g5-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Add custom css classes to item','g5-core'),
				'default' => '',
			]
		);
	}

	protected function register_columns_gutter_controls() {
		$this->add_control(
			'columns_gutter',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Columns Gutter','g5-core'),
				'description' => esc_html__('Specify your horizontal space between item.','g5-core'),
				'options' => G5CORE()->settings()->get_post_columns_gutter(),
				'default' => '30',
			]
		);
	}

	protected function register_columns_controls() {
		$this->add_control(
			'post_columns',
			[
				'type' => UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE,
				'label' => esc_html__('Columns','g5-core'),
				'data_type' => 'select',
				'options' => G5CORE()->settings()->get_post_columns(),
				'default'     => '4',
				'condition' => [
					'post_layout' => 'grid',
				],
			]
		);
	}

	protected function register_post_count_control() {
		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Posts Per Page', 'g5-core' ),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Enter number of posts per page you want to display. Default 10', 'g5-core'),
				'default' => '',
			]
		);
	}

	protected function register_post_offset_control() {
		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Offset Posts', 'g5-core' ),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Start the count with an offset. If you have a block that shows 4 posts before this one, you can make this one start from the 5\'th post (by using offset 4)', 'g5-core'),
				'default' => '',
			]
		);
	}

	protected function register_post_paging_controls() {
		$this->add_control(
			'post_paging',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Post Paging','g5-core'),
				'description' => esc_html__('Specify your post paging mode', 'g5-core'),
				'options' => G5CORE()->settings()->get_shortcode_post_paging(),
				'default' => 'none',
			]
		);
	}

	protected function register_post_animation_controls() {
		$this->add_control(
			'post_animation',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Animation','g5-core'),
				'description' => esc_html__('Specify your product animation', 'g5-core'),
				'options' => G5CORE()->settings()->get_animation(),
				'default' => 'none',
			]
		);
	}

	protected function register_cate_filter_controls() {
		$this->add_control(
			'cate_filter_enable',
			[
				'label' => esc_html__( 'Category Filter', 'g5-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'g5-core' ),
				'label_off' => esc_html__( 'Hide', 'g5-core' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'cate_filter_align',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Category Filter Align','g5-core'),
				'options' => G5CORE()->settings()->get_category_filter_align(),
				'default' => '',
				'condition' => [
					'cate_filter_enable' => 'on',
				],
			]
		);

		$this->add_control(
			'append_tabs',
			[
				'label' => esc_html__( 'Append Categories', 'g5-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Change where the categories are attached (Selector, htmlString, Array, Element, jQuery object)', 'g5-core' ),
				'default' => '',
				'condition' => [
					'cate_filter_enable' => 'on',
				],
			]
		);
	}

	protected function register_image_size_section_controls() {
		$this->start_controls_section(
			'section_image_size',
			[
				'label' => esc_html__( 'Image Size', 'g5-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_image_size',
			[
				'label' => esc_html__( 'Image size', 'g5-core' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 300x400).', 'g5-core'),
				'default' => 'medium',
				'condition' => [
					'post_layout!' => ['masonry'],
				],
			]
		);



		$this->add_control(
			'post_image_ratio_width',
			[
				'label' => esc_html__( 'Image Ratio Width', 'g5-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'condition' => [
					'post_image_size' => ['full'],
				],
			]
		);

		$this->add_control(
			'post_image_ratio_height',
			[
				'label' => esc_html__( 'Image Ratio Height', 'g5-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'condition' => [
					'post_image_size' => ['full'],
				],
			]
		);

		$this->add_control(
			'post_image_width',
			[
				'label' => esc_html__( 'Image Width', 'g5-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '400',
				'condition' => [
					'post_layout' => ['masonry'],
				],
			]
		);

		$this->end_controls_section();
	}



}