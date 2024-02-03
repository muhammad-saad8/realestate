<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5Element_ShortCode')) {
    class G5Element_ShortCode
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init()
        {
            $this->includes();
            // Auto Loader Class
            spl_autoload_register(array($this, 'autoload_class_file'));

            // vc learn map
            add_action('vc_before_mapping', array($this, 'vc_lean_map'));

        }

        /**
         * Auto Loader Class
         *
         * @param $class_name
         */
        public function autoload_class_file($class)
        {
            $shortcode = preg_replace('/^WPBakeryShortCode_g5element_/', '', $class);
            if ($shortcode !== $class) {
                $shortcode = strtolower($shortcode);
                $file_name = str_replace('_', '-', $shortcode);
                G5ELEMENT()->load_file(apply_filters('g5element_autoload_class_path',G5ELEMENT()->plugin_dir("shortcodes/{$file_name}.php"),$shortcode,$file_name));
            }
        }

        public function includes() {
        }

        /**
         * Get Shortcodes category name
         *
         * @return string
         */
        public function get_category_name()
        {
            $current_theme = wp_get_theme();
            return $current_theme['Name'] . ' Shortcodes';
        }

        /**
         * Get List Shortcodes
         *
         * @return array
         */
        private function get_shortcodes()
        {
            return apply_filters('g5element_shortcodes_list', array(
                'banner',
                'button',
                'breadcrumbs',
	            'client_logo',
                'counter',
                'count_down',
                'google_map',
	            'map_box',
                'heading',
                'icon_box',
	            'image_box',
	            'layout_section',
	            'layout_container',
	            'list',
                'our_team',
                'page_title',
                'pricing_table',
                'slider_container',
                'social_icons',
                'space',
                'testimonial',
                'video',
                'gallery',
                'gallery_slider',
	            'image_marker',
	            'bullet_one_page_scroll_navigation'
            ));
        }

        public function vc_lean_map() {
            $shorcodes = $this->get_shortcodes();
            foreach ($shorcodes as $key) {
	            $vc_map_config = apply_filters('g5element_vc_lean_map_config',G5ELEMENT()->plugin_dir('vc-lean-map/' . str_replace('_', '-', $key) . '.php'),$key);
	            vc_lean_map('g5element_' . $key, null, $vc_map_config);
            }
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_narrow_category($args = array())
        {
            $category = array();
            $categories = get_categories(array('hide_empty' => '1'));
            if (is_array($categories)) {
                foreach ($categories as $cat) {
                    $category[$cat->name] = $cat->slug;
                }
            }
            $default = array(
                'type' => 'g5element_selectize',
                'heading' => esc_html__('Narrow Category', 'g5-element'),
                'param_name' => 'category',
                'value' => $category,
                'multiple' => true,
                'description' => esc_html__('Enter categories by names to narrow output (Note: only listed categories will be displayed, divide categories with linebreak (Enter)).', 'g5-element'),
                'std' => ''
            );
            $default = array_merge($default, $args);
            return $default;
        }

        /**
         * @param array $array
         * @return array
         */
        public function switch_array_key_value($array = array())
        {
            $result = array();
            foreach ($array as $key => $value) {
                $result[$value] = $key;
            }
            return $result;
        }

        /**
         * @return array
         */
        public function get_toggle()
        {
            return array(
                esc_html__('On', 'g5-element') => '1',
                esc_html__('Off', 'g5-element') => '0'
            );
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_title($args = array())
        {
            $default = array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'g5-element'),
                'param_name' => 'title'
            );
            $default = array_merge($default, $args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_pagination($args = array())
        {
            $default = array(
                'type' => 'g5element_switch',
                'heading' => esc_html__('Show pagination control', 'g5-element'),
                'param_name' => 'dots',
                'std' => '',
            );
            $default = array_merge($default, $args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_navigation($args = array())
        {
            $default = array(
                'type' => 'g5element_switch',
                'heading' => esc_html__('Show navigation control', 'g5-element'),
                'param_name' => 'nav',
                'std' => '',
            );
            $default = array_merge($default, $args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_autoplay_enable($args = array())
        {
            $default = array(
                'type' => 'g5element_switch',
                'heading' => esc_html__('Autoplay Enable', 'g5-element'),
                'param_name' => 'autoplay',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            );
            $default = array_merge($default, $args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_autoplay_timeout($args = array())
        {
            $default = array(
                'type' => 'g5element_number',
                'heading' => esc_html__('Autoplay Timeout', 'g5-element'),
                'param_name' => 'autoplay_timeout',
                'std' => '5000',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'autoplay', 'value' => 'on')
            );
            $default = array_merge($default, $args);
            return $default;
        }

        public function get_column_responsive($dependency = array())
        {
            $responsive = array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Large Devices', 'g5-element'),
                    'description' => esc_html__('Browser Width >= 1200px', 'g5-element'),
                    'param_name' => 'columns',
                    'value' => $this->get_post_columns(),
                    'std' => 3,
                    'group' => esc_html__('Responsive', 'g5-element'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Medium Devices', 'g5-element'),
                    'param_name' => 'columns_md',
                    'description' => esc_html__('Browser Width < 1200px', 'g5-element'),
                    'value' => $this->get_post_columns(),
                    'std' => 2,
                    'group' => esc_html__('Responsive', 'g5-element'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Small Devices', 'g5-element'),
                    'param_name' => 'columns_sm',
                    'description' => esc_html__('Browser Width < 992px', 'g5-element'),
                    'value' => $this->get_post_columns(),
                    'std' => 2,
                    'group' => esc_html__('Responsive', 'g5-element'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Extra Small Devices', 'g5-element'),
                    'param_name' => 'columns_xs',
                    'description' => esc_html__('Browser Width < 768px', 'g5-element'),
                    'value' => $this->get_post_columns(),
                    'std' => 1,
                    'group' => esc_html__('Responsive', 'g5-element'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Extra Extra Small Devices', 'g5-element'),
                    'param_name' => 'columns_mb',
                    'description' => esc_html__('Browser Width < 576px', 'g5-element'),
                    'value' => $this->get_post_columns(),
                    'std' => 1,
                    'group' => esc_html__('Responsive', 'g5-element'),
                    'dependency' => $dependency
                )
            );
            return $responsive;
        }

	    /**
	     * Get Post Columns
	     *
	     * @param bool $inherit
	     * @return array|mixed|void
	     */
	    public function get_post_columns($inherit = false)
	    {
		    return array(
			    '1' => '1',
			    '2' => '2',
			    '3' => '3',
			    '4' => '4',
			    '5' => '5',
			    '6' => '6'
		    );
	    }

    }
}