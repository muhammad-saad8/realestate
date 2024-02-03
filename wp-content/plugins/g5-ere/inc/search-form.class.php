<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5ERE_Search_Form')) {
	class G5ERE_Search_Form {
		public $id = '';

		public $prefix = '';

		public $data = null;

		public $search_style = '';

		public $search_fields = '';

		public $search_tabs = '';

		public $price_range_slider = 'on';

		public $size_range_slider = '';

		public $land_area_range_slider = '';

		public $other_features = 'on';

		public $advanced_filters = 'on';

		public $submit_button_position = 'on';


		public function __construct($id) {
			$this->id = $id;
			$search_forms = G5ERE()->options()->get_option('search_forms');
			if (is_array($search_forms)) {
				foreach ($search_forms as $search_form) {
					if (isset($search_form['id']) && ($search_form['id'] === $id)) {
						$this->data = $search_form;
						$this->search_style= $this->get_search_style();
						$this->search_tabs = $this->get_search_tabs();
						$this->price_range_slider = $this->get_price_range_slider();
						$this->size_range_slider = $this->get_size_range_slider();
						$this->land_area_range_slider = $this->get_land_area_range_slider();
						$this->other_features = $this->get_other_features();
						$this->advanced_filters = $this->get_advanced_filters();
						$this->submit_button_position = $this->get_submit_button_position();
						$this->search_fields = $this->get_search_fields();
						$this->prefix = uniqid('g5ere__sf-');
						break;
					}
				}
			}
		}

		public function __isset( $name ) {
			return is_array($this->data) && isset($this->data[$name]);
		}

		public function __get( $name ) {
			return $this->get_value($name);
		}

		private function get_value($name,$default = '') {
			return is_array($this->data) && isset($this->data[$name]) ? $this->data[$name] : $default;
		}

		public function get_search_style() {
			return $this->get_value('search_style');
		}

		public function get_search_tabs() {
			return $this->get_value('search_tabs');
		}

		public function get_search_fields() {
			$search_fields = $this->get_value('search_fields');
			if (is_array($search_fields)) {
				foreach ($search_fields as $k => $v) {
					if (isset($search_fields[$k]['__no_value__'])) {
						unset($search_fields[$k]['__no_value__']);
					}

					if ($this->price_range_slider === 'on') {
						if (isset($search_fields[$k]['min-price'])) {
							unset($search_fields[$k]['min-price']);
						}

						if (isset($search_fields[$k]['max-price'])) {
							unset($search_fields[$k]['max-price']);
						}
					}

					if ($this->size_range_slider === 'on') {
						if (isset($search_fields[$k]['min-size'])) {
							unset($search_fields[$k]['min-size']);
						}

						if (isset($search_fields[$k]['max-size'])) {
							unset($search_fields[$k]['max-size']);
						}
					}

					if ($this->land_area_range_slider === 'on') {
						if (isset($search_fields[$k]['min-land'])) {
							unset($search_fields[$k]['min-land']);
						}

						if (isset($search_fields[$k]['max-land'])) {
							unset($search_fields[$k]['max-land']);
						}
					}

				/*	if ($this->search_tabs === 'on') {
						if (isset($search_fields[$k]['status'])) {
							unset($search_fields[$k]['status']);
						}
					}*/
				}
			}
			return $search_fields;

		}

		public function get_get_search_fields_mobile() {
			$search_fields = $this->search_fields;
			$fields = array();

			if (isset($search_fields['top']) && is_array($search_fields['top'])) {
				$fields = wp_parse_args($search_fields['top'], $fields);
			}

			if (isset($search_fields['bottom']) && is_array($search_fields['bottom'])) {
				$fields = wp_parse_args($search_fields['bottom'], $fields);
			}


			if ($this->search_tabs === 'on' || $this->search_tabs === 'on-all-status') {
				if (!isset($fields['status'])) {
					$fields = wp_parse_args($fields,array('status' => esc_html__('Status','g5-ere')));
				}
			}

			if (isset($fields['keyword'])) {
				unset($fields['keyword']);
			}
			return $fields;
		}


		public function get_price_range_slider() {
			return $this->get_value('price_range_slider','on');
		}

		public function get_size_range_slider() {
			return $this->get_value('size_range_slider');
		}

		public function get_land_area_range_slider() {
			return $this->get_value('land_area_range_slider');
		}

		public function get_other_features() {
			return $this->get_value('other_features','on');
		}

		public function get_advanced_filters() {
			return $this->get_value('advanced_filters','on');
		}


		public function get_submit_button_position() {
			return $this->get_value('submit_button_position','top');
		}


	}
}
