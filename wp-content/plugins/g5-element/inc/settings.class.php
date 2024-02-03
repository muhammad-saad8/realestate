<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists(' G5Element_Settings')) {
    class  G5Element_Settings
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function get_gallery_layout()
        {
            $config = apply_filters('g5element_settings_gallery_layout', array(
                'grid' => array(
                    'label' => esc_html__('Grid', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/gallery-layout-grid.png'),
                ),
                'masonry' => array(
                    'label' => esc_html__('Masonry', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/gallery-layout-masonry.png'),
                ),
                'masonry-2' => array(
                    'label' => esc_html__('Masonry 2', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/gallery-layout-masonry-02.png'),
                ),
                'justified' => array(
                    'label' => esc_html__('Justified', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/gallery-layout-justified.jpg'),
                ),
                'metro-1' => array(
                    'label' => esc_html__('Metro 01', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/gallery-layout-metro-01.png')
                ),
                'metro-2' => array(
                    'label' => esc_html__('Metro 02', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/gallery-layout-metro-02.png')
                ),
                'metro-3' => array(
                    'label' => esc_html__('Metro 03', 'g5-element'),
                    'img' => G5ELEMENT()->plugin_url('assets/images/gallery-layout-metro-03.png')
                ),

            ));
            return $config;
        }

	    public function get_hover_effect() {
		    return apply_filters('g5element_image_hover_effect',array(
			    '' => esc_html__('None', 'g5-element'),
			    'symmetry' => esc_html__('Symmetry', 'g5-element'),
			    'suprema' => esc_html__('Suprema', 'g5-element'),
			    'layla' => esc_html__('Layla', 'g5-element'),
			    'bubba' => esc_html__('Bubba', 'g5-element'),
			    'jazz' => esc_html__('Jazz', 'g5-element'),
			    'flash' => esc_html__('Flash', 'g5-element'),
			    'ming' => esc_html__('Ming', 'g5-element'),
		    ));
	    }

	    public function get_hover_effect_image() {
		    return apply_filters('g5element_image_hover_effect_image',array(
			    '' => esc_html__('None', 'g5-element'),
			    'zoom-in' => esc_html__('Zoom In', 'g5-element'),
			    'zoom-out' => esc_html__('Zoom Out', 'g5-element'),
			    'slide-left' => esc_html__('Slide Left', 'g5-element'),
			    'slide-right' => esc_html__('Slide Right', 'g5-element'),
			    'slide-top' => esc_html__('Slide Top', 'g5-element'),
			    'slide-bottom' => esc_html__('Slide Bottom', 'g5-element'),
			    'rotate' => esc_html__('Rotate', 'g5-element'),
		    ));
	    }

    }
}