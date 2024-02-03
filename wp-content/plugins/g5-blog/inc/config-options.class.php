<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5Blog_Config_Options')) {
    class G5Blog_Config_Options
    {
        /*
         * loader instances
         */
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init()
        {
            add_filter('gsf_option_config', array($this, 'define_options'), 100);
            add_filter('gsf_meta_box_config', array($this, 'define_meta_box'));
            add_filter('g5core_admin_bar_theme_options', array($this, 'admin_bar_theme_options'), 100);

            add_action('pre_get_posts', array($this, 'pre_get_posts'));
            add_action('template_redirect', array($this, 'change_search_page_setting'));
            add_action('template_redirect', array($this, 'change_single_setting'));

            add_filter( 'g5core_default_options_g5core_options', array($this,'change_default_options') );
        }

        public function admin_bar_theme_options($admin_bar_theme_options) {
	        $admin_bar_theme_options['g5blog_options'] = array(
		        'title' => esc_html__('Blog','g5-blog'),
		        'permission' => 'manage_options',
	        );
	        return $admin_bar_theme_options;
        }

        public function define_options($configs)
        {
            $configs['g5blog_options'] = array(
                'layout' => 'inline',
                'page_title' => esc_html__('Blog Options', 'g5-blog'),
                'menu_title' => esc_html__('Blog', 'g5-blog'),
                'option_name' => 'g5blog_options',
                'parent_slug' => 'g5core_options',
                'permission' => 'manage_options',
                'section' => array(
                    $this->config_section_archive(),
                    $this->config_section_single(),
                    $this->config_section_search()
                )
            );
            return $configs;
        }



        public function config_section_archive()
        {
            return array(
                'id' => 'section_archive',
                'title' => esc_html__('Archive Listing', 'g5-blog'),
                'icon' => 'dashicons dashicons-category',
                'fields' => array(
                    'category_filter_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'category_filter_enable',
                        'title' => esc_html__('Category Filter Enable', 'g5-blog'),
                        'subtitle' => esc_html__('Turn On this option if you want to enable category filter', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'category_filter_enable','' ),
                    )),

                    'category_filter_align' => array(
	                    'id' => 'category_filter_align',
	                    'title' => esc_html__('Category Filter Align','g5-blog'),
	                    'subtitle' => esc_html__('Specify your category filter align','g5-blog'),
	                    'type' => 'button_set',
	                    'options' => G5CORE()->settings()->get_category_filter_align(),
	                    'default' => G5BLOG()->options()->get_default('category_filter_align', ''),
	                    'required' => array('category_filter_enable','=','on')
                    ),

                    'append_tabs' =>  array(
                        'id' => 'append_tabs',
                        'title' => esc_html__('Append Categories','g5-blog'),
                        'subtitle' => esc_html__('Change where the categories are attached (Selector, htmlString, Array, Element, jQuery object)','g5-blog'),
                        'type' => 'text',
                        'default' => G5BLOG()->options()->get_default( 'append_tabs','' ),
                        'required' => array('category_filter_enable','=','on')
                    ),
                    'post_layout' => array(
                        'id' => 'post_layout',
                        'title' => esc_html__('Post Layout', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post layout', 'g5-blog'),
                        'type' => 'image_set',
                        'options' => G5BLOG()->settings()->get_post_layout(),
                        'default' => G5BLOG()->options()->get_default( 'post_layout','large-image' ),
                    ),
                    'item_custom_class' => array(
	                    'id' => 'item_custom_class',
	                    'title' => esc_html__('Item Css Classes', 'g5-blog'),
	                    'subtitle' => esc_html__('Add custom css classes to item', 'g5-blog'),
	                    'type' => 'text'
                    ),
                    'excerpt_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'excerpt_enable',
                        'title' => esc_html__('Show Excerpt', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'excerpt_enable','on' ),
                    )),
                    'post_columns_gutter' => array(
                        'id' => 'post_columns_gutter',
                        'title' => esc_html__('Post Columns Gutter', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your horizontal space between post.', 'g5-blog'),
                        'type' => 'select',
                        'options' => G5CORE()->settings()->get_post_columns_gutter(),
                        'default' => G5BLOG()->options()->get_default( 'post_columns_gutter','30' ),
                        'required' => array("post_layout", 'in', G5BLOG()->settings()->get_post_layout_has_columns())
                    ),
                    'post_columns_group' => array(
                        'id' => 'post_columns_group',
                        'title' => esc_html__('Post Columns', 'g5-blog'),
                        'type' => 'group',
                        'required' => array('post_layout', 'in', G5BLOG()->settings()->get_post_layout_has_columns()),
                        'fields' => array(
                            'post_columns_row_1' => array(
                                'id' => 'post_columns_row_1',
                                'type' => 'row',
                                'col' => 3,
                                'fields' => array(
                                    'post_columns_xl' => array(
                                        'id' => 'post_columns_xl',
                                        'title' => esc_html__('Extra Large Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on extra large devices (>= 1200px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'post_columns_xl','3' ),
                                        'layout' => 'full',
                                    ),
                                    'post_columns_lg' => array(
                                        'id' => 'post_columns_lg',
                                        'title' => esc_html__('Large Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on large devices (>= 992px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'post_columns_lg','3' ),
                                        'layout' => 'full',
                                    ),
                                    'post_columns_md' => array(
                                        'id' => 'post_columns_md',
                                        'title' => esc_html__('Medium Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on medium devices (>= 768px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'post_columns_md','2' ),
                                        'layout' => 'full',
                                    ),
                                )
                            ),
                            'post_columns_row_2' => array(
                                'id' => 'post_columns_row_2',
                                'type' => 'row',
                                'col' => 3,
                                'fields' => array(
                                    'post_columns_sm' => array(
                                        'id' => 'post_columns_sm',
                                        'title' => esc_html__('Small Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on small devices (< 768px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'post_columns_sm','2' ),
                                        'layout' => 'full',
                                    ),
                                    'post_columns' => array(
                                        'id' => 'post_columns',
                                        'title' => esc_html__('Extra Small Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on extra small devices (< 576px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'post_columns','1' ),
                                        'layout' => 'full',
                                    )
                                )
                            )
                        )
                    ),
                    'post_image_size' => array(
                        'id' => 'post_image_size',
                        'title' => esc_html__('Image size', 'g5-blog'),
                        'subtitle' => esc_html__('Enter your post image size', 'g5-blog'),
                        'desc' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-blog'),
                        'type' => 'text',
                        'default' => G5BLOG()->options()->get_default( 'post_image_size','full' ),
                        'required' => array('post_layout', 'not in', array('masonry')),
                    ),
                    'post_image_width' => array(
                        'id' => 'post_image_width',
                        'title' => esc_html__('Image width', 'g5-blog'),
                        'subtitle' => esc_html__('Enter your post image width', 'g5-blog'),
                        'type' => 'dimension',
                        'height' => false,
                        'default' => G5BLOG()->options()->get_default( 'post_image_width', array(
                            'width' => '400'
                        )),
                        'required' => array('post_layout', 'in', array('masonry')),
                    ),

                    'post_image_ratio' => array(
                        'id'       => 'post_image_ratio',
                        'title'    => esc_html__('Image Ratio', 'g5-blog'),
                        'subtitle' => esc_html__('Enter image ratio', 'g5-blog'),
                        'type'     => 'dimension',
                        'required' => array(
                            array('post_image_size', '=', 'full'),
                            array('post_layout', 'not in', array('masonry','large-image')),
                        )
                    ),

                    'posts_per_page' => array(
                        'id' => 'posts_per_page',
                        'title' => esc_html__('Posts Per Page', 'g5-blog'),
                        'subtitle' => esc_html__('Enter number of posts per page you want to display.', 'g5-blog'),
                        'type' => 'text',
                        'default' => G5BLOG()->options()->get_default( 'posts_per_page','' ),
                        'input_type' => 'number',
                    ),
                    'post_paging' => array(
                        'id' => 'post_paging',
                        'title' => esc_html__('Post Paging', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post paging mode', 'g5-blog'),
                        'type' => 'select',
                        'options' => G5CORE()->settings()->get_post_paging_mode(),
                        'default' => G5BLOG()->options()->get_default( 'post_paging','pagination' ),
                    ),
                    'post_animation' => array(
                        'id'       => 'post_animation',
                        'title'    => esc_html__('Animation', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post animation', 'g5-blog'),
                        'type'     => 'select',
                        'options'  => G5CORE()->settings()->get_animation(),
                        'default'  => G5BLOG()->options()->get_default('post_animation','none')
                    )
                )
            );
        }

        public function config_section_search()
        {
            return array(
                'id' => 'section_search',
                'title' => esc_html__('Search Listing', 'g5-blog'),
                'icon' => 'dashicons dashicons-search',
                'fields' => array(
                    'custom_search_listing_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'custom_search_listing_enable',
                        'title' => esc_html__('Custom Search Listing', 'g5-blog'),
                        'subtitle' => esc_html__('Turn On this option if you want to enable custom search listing', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'custom_search_listing_enable','' ),
                    )),
                    'search_post_layout' => array(
                        'id' => 'search_post_layout',
                        'title' => esc_html__('Post Layout', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post layout', 'g5-blog'),
                        'type' => 'image_set',
                        'options' => G5BLOG()->settings()->get_post_layout(),
                        'default' => G5BLOG()->options()->get_default( 'search_post_layout','large-image' ),
                        'required' => array('custom_search_listing_enable', '=', 'on')
                    ),
                    'search_post_columns_gutter' => array(
                        'id' => 'search_post_columns_gutter',
                        'title' => esc_html__('Post Columns Gutter', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your horizontal space between post.', 'g5-blog'),
                        'type' => 'select',
                        'options' => G5CORE()->settings()->get_post_columns_gutter(),
                        'default' => G5BLOG()->options()->get_default( 'search_post_columns_gutter','30' ),
                        'required' => array(
                            array("custom_search_listing_enable", '=', 'on'),
                            array('search_post_layout', 'in', G5BLOG()->settings()->get_post_layout_has_columns())
                        )
                    ),
                    'search_post_columns_group' => array(
                        'id' => 'search_post_columns_group',
                        'title' => esc_html__('Post Columns', 'g5-blog'),
                        'type' => 'group',
                        'required' => array(
                            array("custom_search_listing_enable", '=', 'on'),
                            array('search_post_layout', 'in', G5BLOG()->settings()->get_post_layout_has_columns())
                        ),
                        'fields' => array(
                            'search_post_columns_row_1' => array(
                                'id' => 'search_post_columns_row_1',
                                'type' => 'row',
                                'col' => 3,
                                'fields' => array(
                                    'search_post_columns_xl' => array(
                                        'id' => 'search_post_columns_xl',
                                        'title' => esc_html__('Extra Large Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on extra large devices (>= 1200px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'search_post_columns_xl','3' ),
                                        'layout' => 'full',
                                    ),
                                    'search_post_columns_lg' => array(
                                        'id' => 'search_post_columns_lg',
                                        'title' => esc_html__('Large Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on large devices (>= 992px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'search_post_columns_lg','3' ),
                                        'layout' => 'full',
                                    ),
                                    'search_post_columns_md' => array(
                                        'id' => 'search_post_columns_md',
                                        'title' => esc_html__('Medium Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on medium devices (>= 768px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'search_post_columns_md','2' ),
                                        'layout' => 'full',
                                    ),
                                )
                            ),
                            'search_post_columns_row_2' => array(
                                'id' => 'search_post_columns_row_2',
                                'type' => 'row',
                                'col' => 3,
                                'fields' => array(
                                    'search_post_columns_sm' => array(
                                        'id' => 'search_post_columns_sm',
                                        'title' => esc_html__('Small Devices ', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on small devices (< 768px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'search_post_columns_sm','2' ),
                                        'layout' => 'full',
                                    ),
                                    'search_post_columns' => array(
                                        'id' => 'search_post_columns',
                                        'title' => esc_html__('Extra Small Devices ', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on extra small devices (< 576px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'search_post_columns','1' ),
                                        'layout' => 'full',
                                    )
                                )
                            )
                        )
                    ),
                    'search_post_image_size' => array(
                        'id' => 'search_post_image_size',
                        'title' => esc_html__('Image size', 'g5-blog'),
                        'subtitle' => esc_html__('Enter your post image size', 'g5-blog'),
                        'desc' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-blog'),
                        'type' => 'text',
                        'default' => G5BLOG()->options()->get_default( 'search_post_image_size','full' ),
                        'required' => array(
                            array("custom_search_listing_enable", '=', 'on'),
                            array('search_post_layout', 'not in', array('masonry')),
                        )
                    ),
                    'search_post_image_width' => array(
                        'id' => 'search_post_image_width',
                        'title' => esc_html__('Image width', 'g5-blog'),
                        'subtitle' => esc_html__('Enter your post image width', 'g5-blog'),
                        'type' => 'dimension',
                        'height' => false,
                        'default' => array(
                            'width' => '400'
                        ),
                        'required' => array(
                            array("custom_search_listing_enable", '=', 'on'),
                            array('search_post_layout', 'in', array('masonry')),
                        )
                    ),
                    'search_posts_per_page' => array(
                        'id' => 'search_posts_per_page',
                        'title' => esc_html__('Posts Per Page', 'g5-blog'),
                        'subtitle' => esc_html__('Enter number of posts per page you want to display.', 'g5-blog'),
                        'type' => 'text',
                        'input_type' => 'number',
                        'required' => array('custom_search_listing_enable', '=', 'on'),
                        'default' => G5BLOG()->options()->get_default( 'search_posts_per_page','' )
                    ),
                    'search_post_paging' => array(
                        'id' => 'search_post_paging',
                        'title' => esc_html__('Post Paging', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post paging mode', 'g5-blog'),
                        'type' => 'select',
                        'options' => G5CORE()->settings()->get_post_paging_mode(),
                        'default' => G5BLOG()->options()->get_default( 'search_post_paging','pagination' ),
                        'required' => array('custom_search_listing_enable', '=', 'on')
                    ),
                )
            );
        }

        public function config_section_single()
        {
            return array(
                'id' => 'section_single',
                'title' => esc_html__('Single Blog', 'g5-blog'),
                'icon' => 'dashicons dashicons-edit',
                'fields' => array(
                    'single_post_layout' => array(
                        'id' => 'single_post_layout',
                        'title' => esc_html__('Post Layout', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post layout', 'g5-blog'),
                        'type' => 'image_set',
                        'options' => G5BLOG()->settings()->get_single_post_layout(),
                        'default' => G5BLOG()->options()->get_default( 'single_post_layout','layout-1' )
                    ),
                    'single_post_tag_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'single_post_tag_enable',
                        'title' => esc_html__('Tags', 'g5-blog'),
                        'subtitle' => esc_html__('Turn Off this option if you want to hide tags on single blog', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'single_post_tag_enable','on' )
                    )),
                    'single_post_share_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'single_post_share_enable',
                        'title' => esc_html__('Share', 'g5-blog'),
                        'subtitle' => esc_html__('Turn Off this option if you want to hide share on single blog', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'single_post_share_enable','on' )
                    )),
                    'single_post_navigation_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'single_post_navigation_enable',
                        'title' => esc_html__('Navigation', 'g5-blog'),
                        'subtitle' => esc_html__('Turn Off this option if you want to hide navigation on single blog', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'single_post_navigation_enable','on' )
                    )),
                    'single_post_author_info_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'single_post_author_info_enable',
                        'title' => esc_html__('Author Info', 'g5-blog'),
                        'subtitle' => esc_html__('Turn Off this option if you want to hide author info area on single blog', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'single_post_author_info_enable','on' )
                    )),
                    $this->config_group_single_post_related()
                )
            );
        }

        public function config_group_single_post_related()
        {
            return array(
                'id' => 'group_single_related_posts',
                'title' => esc_html__('Related Posts', 'g5-blog'),
                'type' => 'group',
                'toggle_default' => false,
                'fields' => array(
                    'single_post_related_enable' => G5CORE()->fields()->get_config_toggle(array(
                        'id' => 'single_post_related_enable',
                        'title' => esc_html__('Related Posts', 'g5-blog'),
                        'subtitle' => esc_html__('Turn Off this option if you want to hide related posts area on single blog', 'g5-blog'),
                        'default' => G5BLOG()->options()->get_default( 'single_post_related_enable','' )
                    )),
                    'single_post_related_algorithm' => array(
                        'id' => 'single_post_related_algorithm',
                        'title' => esc_html__('Related Posts Algorithm', 'g5-blog'),
                        'subtitle' => esc_html__('Specify the algorithm of related posts', 'g5-blog'),
                        'type' => 'select',
                        'options' => G5BLOG()->settings()->get_single_post_related_algorithm(),
                        'default' => G5BLOG()->options()->get_default( 'single_post_related_algorithm','cat' ),
                        'required' => array('single_post_related_enable', '=', 'on')
                    ),

                    'single_post_related_post_layout' => array(
	                    'id' => 'single_post_related_post_layout',
	                    'title' => esc_html__('Post Layout', 'g5-blog'),
	                    'subtitle' => esc_html__('Specify your post layout', 'g5-blog'),
	                    'type' => 'image_set',
	                    'options' => G5BLOG()->settings()->get_post_layout(),
	                    'default' => G5BLOG()->options()->get_default( 'single_post_related_post_layout','grid' ),
	                    'required' => array('single_post_related_enable', '=', 'on')
                    ),
                    'single_post_related_item_custom_class' => array(
	                    'id' => 'single_post_related_item_custom_class',
	                    'title' => esc_html__('Item Css Classes', 'g5-blog'),
	                    'subtitle' => esc_html__('Add custom css classes to item', 'g5-blog'),
	                    'type' => 'text',
	                    'required' => array('single_post_related_enable', '=', 'on')
                    ),
                    'single_post_related_excerpt_enable' => G5CORE()->fields()->get_config_toggle(array(
	                    'id' => 'single_post_related_excerpt_enable',
	                    'title' => esc_html__('Show Excerpt', 'g5-blog'),
	                    'default' => G5BLOG()->options()->get_default( 'single_post_related_excerpt_enable','' ),
	                    'required' => array('single_post_related_enable', '=', 'on')
                    )),

                    'single_post_related_per_page' => array(
                        'id' => 'single_post_related_per_page',
                        'title' => esc_html__('Posts Per Page', 'g5-blog'),
                        'subtitle' => esc_html__('Enter number of posts per page you want to display', 'g5-blog'),
                        'type' => 'text',
                        'input_type' => 'number',
                        'default' => G5BLOG()->options()->get_default( 'single_post_related_per_page','6' ),
                        'required' => array('single_post_related_enable', '=', 'on')
                    ),
                    'single_post_related_columns_gutter' => array(
                        'id' => 'single_post_related_columns_gutter',
                        'title' => esc_html__('Post Columns Gutter', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your horizontal space between post.', 'g5-blog'),
                        'type' => 'select',
                        'options' => G5CORE()->settings()->get_post_columns_gutter(),
                        'default' => G5BLOG()->options()->get_default( 'single_post_related_columns_gutter','30' ),
                        'required' => array('single_post_related_enable', '=', 'on'),
                    ),
                    'single_post_related_columns_group' => array(
                        'id' => 'single_post_related_columns_group',
                        'title' => esc_html__('Post Columns', 'g5-blog'),
                        'type' => 'group',
                        'required' => array('single_post_related_enable', '=', 'on'),
                        'fields' => array(
                            'post_columns_row_1' => array(
                                'id' => 'post_columns_row_1',
                                'type' => 'row',
                                'col' => 3,
                                'fields' => array(
                                    'single_post_related_columns_xl' => array(
                                        'id' => 'single_post_related_columns_xl',
                                        'title' => esc_html__('Extra Large Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on extra large devices (>= 1200px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'single_post_related_columns_xl','3' ),
                                        'layout' => 'full',
                                    ),
                                    'single_post_related_columns_lg' => array(
                                        'id' => 'single_post_related_columns_lg',
                                        'title' => esc_html__('Large Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on large devices (>= 992px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'single_post_related_columns_lg','3' ),
                                        'layout' => 'full',
                                    ),
                                    'single_post_related_columns_md' => array(
                                        'id' => 'single_post_related_columns_md',
                                        'title' => esc_html__('Medium Devices', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on medium devices (>= 768px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'single_post_related_columns_md','2' ),
                                        'layout' => 'full',
                                    ),
                                )
                            ),
                            'post_columns_row_2' => array(
                                'id' => 'post_columns_row_2',
                                'type' => 'row',
                                'col' => 3,
                                'fields' => array(
                                    'single_post_related_columns_sm' => array(
                                        'id' => 'single_post_related_columns_sm',
                                        'title' => esc_html__('Small Devices ', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on small devices (< 768px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'single_post_related_columns_sm','2' ),
                                        'layout' => 'full',
                                    ),
                                    'single_post_related_columns' => array(
                                        'id' => 'single_post_related_columns',
                                        'title' => esc_html__('Extra Small Devices ', 'g5-blog'),
                                        'desc' => esc_html__('Specify your post columns on extra small devices (< 576px)', 'g5-blog'),
                                        'type' => 'select',
                                        'options' => G5CORE()->settings()->get_post_columns(),
                                        'default' => G5BLOG()->options()->get_default( 'single_post_related_columns','1' ),
                                        'layout' => 'full',
                                    )
                                )
                            ),
                        )
                    ),

                    'single_post_related_post_image_size' => array(
	                    'id' => 'single_post_related_post_image_size',
	                    'title' => esc_html__('Image size', 'g5-blog'),
	                    'subtitle' => esc_html__('Enter your post image size', 'g5-blog'),
	                    'desc' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'g5-blog'),
	                    'type' => 'text',
	                    'default' => G5BLOG()->options()->get_default( 'single_post_related_post_image_size','full' ),
	                    'required' => array(
		                    array('single_post_related_enable', '=', 'on'),
		                    array('single_post_related_post_layout', 'not in', array('masonry')),
	                    )
                    ),

                    'single_post_related_post_image_width' => array(
	                    'id' => 'single_post_related_post_image_width',
	                    'title' => esc_html__('Image width', 'g5-blog'),
	                    'subtitle' => esc_html__('Enter your post image width', 'g5-blog'),
	                    'type' => 'dimension',
	                    'height' => false,
	                    'default' => G5BLOG()->options()->get_default( 'single_post_related_post_image_width', array(
		                    'width' => '400'
	                    )),
	                    'required' => array(
		                    array('single_post_related_enable', '=', 'on'),
		                    array('single_post_related_post_layout', 'in', array('masonry')),
	                    )
                    ),
                    'single_post_related_post_image_ratio' => array(
	                    'id'       => 'single_post_related_post_image_ratio',
	                    'title'    => esc_html__('Image Ratio', 'g5-blog'),
	                    'subtitle' => esc_html__('Enter image ratio', 'g5-blog'),
	                    'type'     => 'dimension',
	                    'required' => array(
		                    array('single_post_related_enable', '=', 'on'),
		                    array('single_post_related_post_image_size', '=', 'full'),
		                    array('single_post_related_post_layout', 'not in', array('masonry','large-image')),
	                    )
                    ),

                    'single_post_related_paging' => array(
                        'id' => 'single_post_related_paging',
                        'title' => esc_html__('Post Paging', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post paging mode', 'g5-blog'),
                        'type' => 'select',
                        'options' => G5CORE()->settings()->get_post_paging_small_mode(),
                        'default' => G5BLOG()->options()->get_default( 'single_post_related_paging','slider' ),
                        'required' => array('single_post_related_enable', '=', 'on'),
                    ),
                ));
        }

        public function define_meta_box($configs)
        {
            $prefix = G5BLOG()->meta_prefix;
            $configs['g5blog_meta'] = array(
                'name' => esc_html__('Post Settings', 'g5-blog'),
                'post_type' => array('post'),
                'layout' => 'inline',
                'fields' => array(
                    "{$prefix}format_video_embed" => array(
                        'id' => "{$prefix}format_video_embed",
                        'title' => esc_html__('Featured Video/Audio Code', 'g5-blog'),
                        'subtitle' => esc_html__('Paste YouTube, Vimeo video URL then player automatically will be generated.', 'g5-blog'),
                        'type' => 'textarea'
                    ),
                    "{$prefix}format_audio_embed" => array(
                        'id' => "{$prefix}format_audio_embed",
                        'title' => esc_html__('Featured Video/Audio Code', 'g5-blog'),
                        'subtitle' => esc_html__('Paste YouTube, Vimeo audio URL then player automatically will be generated.', 'g5-blog'),
                        'type' => 'textarea'
                    ),
                    "{$prefix}format_gallery_images" => array(
                        'id' => "{$prefix}format_gallery_images",
                        'title' => esc_html__('Featured Gallery', 'g5-blog'),
                        'subtitle' => esc_html__('Select images for featured gallery. (Apply for post format gallery)', 'g5-blog'),
                        'type' => 'gallery'
                    ),
                    "{$prefix}format_link_url" => array(
                        'id' => "{$prefix}format_link_url",
                        'title' => esc_html__('Featured Link', 'g5-blog'),
                        'subtitle' => esc_html__('Enter featured link. (Apply for post format link)', 'g5-blog'),
                        'type' => 'text'
                    ),
                    "{$prefix}single_post_layout" => array(
                        'id' => "{$prefix}single_post_layout",
                        'title' => esc_html__('Post Layout', 'g5-blog'),
                        'subtitle' => esc_html__('Specify your post layout', 'g5-blog'),
                        'type' => 'image_set',
                        'options' => G5BLOG()->settings()->get_single_post_layout(true),
                        'default' => ''
                    ),
                )
            );

            return $configs;
        }

        public function pre_get_posts($query)
        {
            if (!is_admin() && $query->is_main_query()) {
                $paged = G5CORE()->query()->query_var_paged();
                if (is_home() || is_search() || is_tag() || is_category() || $query->is_post_type_archive( 'post' )) {
	                $posts_per_page = G5BLOG()->options()->get_option('posts_per_page');
                    if (is_search()) {
                        $custom_search_listing_enable = G5BLOG()->options()->get_option('custom_search_listing_enable');
                        if ($custom_search_listing_enable === 'on') {
                            $search_posts_per_page = G5BLOG()->options()->get_option('search_posts_per_page');
                            if (!empty($search_posts_per_page)) {
                                $posts_per_page = $search_posts_per_page;
                            }
                        }
                    }
                    if (!empty($posts_per_page)) {
                        $query->set('posts_per_page', $posts_per_page);
                    }
                }


                $posts_per_page = intval($query->get('posts_per_page'));
                if (!empty($query->get('offset'))) {
                    $offset = !empty($query->get('original_offset')) ? $query->get('original_offset') : $query->get('offset');
                    $query->set('original_offset', $offset);
                    if ($paged > 1) {
                        $query->set('offset', intval($offset) + (($paged - 1) * $posts_per_page));
                    }
                }
            }
        }

        public function change_search_page_setting()
        {
            $custom_search_listing_enable = G5BLOG()->options()->get_option('custom_search_listing_enable');
            if ($custom_search_listing_enable === 'on') {
                $settings = array(
                    'post_layout',
                    'post_columns_gutter',
                    'post_columns_xl',
                    'post_columns_lg',
                    'post_columns_md',
                    'post_columns_sm',
                    'post_columns',
                    'post_image_size',
                    'post_image_width',
                    'post_paging'
                );

                foreach ($settings as $setting) {
                    $v = G5BLOG()->options()->get_option("search_{$setting}");
                    G5BLOG()->options()->set_option($setting, $v);
                }

            }
        }

        public function change_single_setting() {
            if (is_singular('post')) {
                $single_post_layout = isset($_REQUEST['single_post_layout']) ? $_REQUEST['single_post_layout'] : '';
                if (array_key_exists($single_post_layout,G5BLOG()->settings()->get_single_post_layout())) {
                    G5BLOG()->options()->set_option('single_post_layout',$single_post_layout);
                }


                $prefix = G5BLOG()->meta_prefix;
                $single_post_layout = get_post_meta(get_the_ID(),"{$prefix}single_post_layout",true);
                if (!empty($single_post_layout)) {
                    G5BLOG()->options()->set_option('single_post_layout',$single_post_layout);
                }
            }

        }

        public function change_default_options($defaults) {
            return wp_parse_args(array(
                'post_single__page_title_enable' => 'off'
            ),$defaults) ;
        }
    }
}