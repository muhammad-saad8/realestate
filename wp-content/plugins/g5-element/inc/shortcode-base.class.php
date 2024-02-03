<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5Element_ShortCode_Base')) {
    abstract class G5Element_ShortCode_Base extends WPBakeryShortCode
    {
        /**
         * Find html template for shortcode output.
         */
        protected function findShortcodeTemplate()
        {
            // Check template path in shortcode's mapping settings
            if (!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
                return $this->setTemplate($this->settings['html_template']);
            }
            // Check template in theme directory
            $user_template = vc_shortcodes_theme_templates_dir($this->getFileName() . '.php');
            if (is_file($user_template)) {
                return $this->setTemplate($user_template);
            }

            $template_name = preg_replace('/^g5element_/', '', $this->getFileName());

            $template = apply_filters('g5element_shortcode_template','',$template_name);
            if (is_file($template)) {
                return $this->setTemplate($template);
            }


            $template = G5ELEMENT()->locate_template(str_replace('_', '-', $template_name) . '.php');
            // Check default place
            if (is_file($template)) {
                return $this->setTemplate($template);
            }

            return '';
        }



    }
    abstract class G5Element_ShortCode_Container extends WPBakeryShortCodesContainer {
        /**
         * Find html template for shortcode output.
         */
        protected function findShortcodeTemplate() {
            // Check template path in shortcode's mapping settings
            if ( ! empty( $this->settings['html_template'] ) && is_file( $this->settings( 'html_template' ) ) ) {
                return $this->setTemplate( $this->settings['html_template'] );
            }
            // Check template in theme directory
            $user_template = vc_shortcodes_theme_templates_dir( $this->getFileName() . '.php' );
            if ( is_file( $user_template ) ) {
                return $this->setTemplate( $user_template );
            }
            $template_name = preg_replace('/^g5element_/', '', $this->getFileName());

	        $template = G5ELEMENT()->locate_template(str_replace('_', '-', $template_name) . '.php');

            // Check default place
            if ( is_file( $template ) ) {
                return $this->setTemplate( $template );
            }

            return '';
        }
    }

    abstract class G5Element_ShortCode_Listing_Base extends G5Element_ShortCode_Base {
        public $_atts = array();

        public $_tabs = array();

        public $_query_args = array();

        public $_settings = array();

        public function prepare_display($atts = array(), $query_args = array(), $settings = array()) {
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
                'slider_autoplay_enable' => '',
                'slider_autoplay_timeout' => '',
	            'slider_variable_width' => ''
            ));


            $this->_atts['posts_per_page'] = absint($this->_atts['posts_per_page']) ? absint($this->_atts['posts_per_page']) : 10;
            $this->_atts['columns_gutter'] = absint($this->_atts['columns_gutter']);
            $this->_atts['columns_xl'] = absint($this->_atts['columns_xl']);
            $this->_atts['columns_lg'] = absint($this->_atts['columns_lg']);
            $this->_atts['columns_md'] = absint($this->_atts['columns_md']);
            $this->_atts['columns_sm'] = absint($this->_atts['columns_sm']);
            $this->_atts['columns'] = absint($this->_atts['columns']);
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
		        case 'relevance':
			        $query_args['orderby'] = 'relevance';
			        $query_args['order']   = 'DESC';
			        break;
		        case 'date':
			        $query_args['orderby'] = 'date ID';
			        break;
	        }

            if (!empty($this->_atts['offset'])) {
                $query_args['offset'] = absint($this->_atts['offset']);
            }


            if ($this->_atts['post_paging'] === 'none') {
                $query_args['no_found_rows'] = 1;
            }

            return apply_filters('g5element_shortcode_listing_query_args',$query_args,$atts);
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
                $this->_settings['cate'] = array_filter(explode(',',$this->_atts['cat']),'absint');
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
                $tabs = (array)vc_param_group_parse_atts($this->_atts['tabs']);
                $tabs_args = array();
                foreach ($tabs as $tab) {
                    $tabs_args[] = array(
                        'label' => $tab['label'],
                        'icon' => array(
                            'type' => isset($tab['icon_type']) ? $tab['icon_type'] : '',
                            'icon' => isset($tab['icon_font']) ? $tab['icon_font'] : '',
                            'image' => isset($tab['icon_image']) ? $tab['icon_image'] : '',
                        ),
                        'query_args' => $this->get_query_args($query_args,$tab)
                    );
                }
                $this->_settings['tabs'] = $tabs_args;
            }
        }

    }
}