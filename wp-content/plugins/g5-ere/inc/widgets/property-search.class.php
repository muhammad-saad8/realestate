<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5ERE_Widget_Property_Search')) {
	class G5ERE_Widget_Property_Search extends GSF_Widget {
		public function __construct()
		{
			$this->widget_cssclass = 'g5ere__widget-property-search';
			$this->widget_id = 'g5ere_widget_property_search';
			$this->widget_name = esc_html__('G5Plus: Property Search', 'g5-ere');
			$this->widget_description = esc_html__( 'Display a property search form', 'g5-ere' );
			$this->settings = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'title'   => esc_html__('Title', 'g5-ere'),
						'type'    => 'text',
						'default' => esc_html__( 'Property Search', 'g5-ere' ),
					),
					array(
						'id'      => 'search_fields',
						'title'   => esc_html__( 'Search Fields', 'g5-ere' ),
						'type'    => 'sortable',
						'options' => G5ERE()->settings()->get_widget_search_form_fields(),
						'default' => array('keyword','type','status','bedrooms','bathrooms','min-price','max-price')
					),
					array(
						'id'       => 'price_range_slider',
						'title'    => esc_html__( 'Price Range Slider', 'g5-ere' ),
						'desc'     => esc_html__( 'If enabled, min and max price dropdown fields will not show', 'g5-ere' ),
						'type'     => 'button_set',
						'options'  => array(
							'on'  => esc_html__( 'Enable', 'g5-ere' ),
							'off' => esc_html__( 'Disable', 'g5-ere' )
						),
						'default'  => 'on',
					),
					array(
						'id'       => 'size_range_slider',
						'title'    => esc_html__( 'Size Range Slider', 'g5-ere' ),
						'desc'     => esc_html__( 'If enabled, min and max area dropdown fields will not show', 'g5-ere' ),
						'type'     => 'button_set',
						'options'  => array(
							'on'  => esc_html__( 'Enable', 'g5-ere' ),
							'off' => esc_html__( 'Disable', 'g5-ere' )
						),
						'default'  => 'off',
					),
					array(
						'id'       => 'land_area_range_slider',
						'title'    => esc_html__( 'Land Area Range Slider', 'g5-ere' ),
						'desc'     => esc_html__( 'If enabled, min and max land area dropdown fields will not show', 'g5-ere' ),
						'type'     => 'button_set',
						'options'  => array(
							'on'  => esc_html__( 'Enable', 'g5-ere' ),
							'off' => esc_html__( 'Disable', 'g5-ere' )
						),
						'default'  => 'off',
					),
					array(
						'id'       => 'other_features',
						'title'    => esc_html__( 'Other Features', 'g5-ere' ),
						'desc' => esc_html__( 'Enable or disable other features in searches', 'g5-ere' ),
						'type'     => 'button_set',
						'options'  => array(
							'on'  => esc_html__( 'Enable', 'g5-ere' ),
							'off' => esc_html__( 'Disable', 'g5-ere' )
						),
						'default'  => 'on',
					),
				)
			);
			parent::__construct();
		}
		function widget( $args, $instance ) {
			if ($this->get_cached_widget($instance)) {
				return;
			}
			extract($args, EXTR_SKIP);
			$search_fields = (!empty($instance['search_fields'])) ? $instance['search_fields'] : array('keyword','type','status','bedrooms','bathrooms','min-price','max-price');
			$price_range_slider = (!empty($instance['price_range_slider'])) ? $instance['price_range_slider'] : 'on';
			$size_range_slider = (!empty($instance['size_range_slider'])) ? $instance['size_range_slider'] : 'off';
			$land_area_range_slider = (!empty($instance['land_area_range_slider'])) ? $instance['land_area_range_slider'] : 'off';
			$other_features = (!empty($instance['other_features'])) ? $instance['other_features'] : 'on';
			unset($search_fields['sort_order']);
			if ($price_range_slider === 'on') {
				unset($search_fields['min-price']);
				unset($search_fields['max-price']);
				$search_fields['price-range'] = 'price-range';
			}

			if ($size_range_slider === 'on') {
				unset($search_fields['min-size']);
				unset($search_fields['max-size']);
				$search_fields['size-range'] = 'size-range';
			}

			if ($land_area_range_slider === 'on') {
				unset($search_fields['min-land']);
				unset($search_fields['max-land']);
				$search_fields['land-range'] = 'land-range';
			}


			ob_start();
			$this->widget_start($args,$instance);
			G5ERE()->get_template('widgets/property-search.php',array(
				'search_fields' => $search_fields,
				'price_range_slider' => $price_range_slider === 'on',
				'size_range_slider' => $size_range_slider === 'on',
				'land_area_range_slider' => $land_area_range_slider === 'on',
				'other_features' => $other_features === 'on',
				'prefix' => uniqid('g5ere__sf-')
			));
			$this->widget_end($args);
			echo $this->cache_widget( $instance, ob_get_clean() ); // WPCS: XSS ok.
		}
	}
}