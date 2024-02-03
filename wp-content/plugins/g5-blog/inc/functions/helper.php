<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

function g5blog_post_types_active() {
    if (isset($GLOBALS['g5blog_post_types_active'])) {
        return $GLOBALS['g5blog_post_types_active'];
    }

    $out = array();
    $all_post_types = get_post_types(array(
        'public' => true,
        'exclude_from_search' => false,
    ), 'objects');
    foreach ($all_post_types as $pt_name => $pt) {
        if ($pt_name === 'attachment') {
            continue;
        }

        $out[$pt_name] = array(
            'label' => $pt->label,
            'icon'  => $pt->menu_icon === NULL ? 'dashicons-admin-post' : $pt->menu_icon,
        );
    }
    $out = apply_filters('g5blog_post_types_active', $out);
    $GLOBALS['g5blog_post_types_active'] = $out;
    return $out;
}

function g5blog_is_admin_post($screen = null) {
    if ( ! ( $screen instanceof WP_Screen ) )
    {
        if ( !function_exists( 'get_current_screen' ) ) {
            require_once ABSPATH . '/wp-admin/includes/screen.php';
        }
        $screen = get_current_screen();
    }
    return 'post' == $screen->base && ($screen->post_type == 'post');
}



function g5blog_truncate_text($text, $length) {
    $text = strip_tags($text, '<img />');
    $length = abs((int)$length);
    if (strlen($text) > $length) {
        $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
    }
    return $text;
}
function g5blog_single_layout_class($classes) {
    if (is_singular('post')) {
        $single_post_layout = G5BLOG()->options()->get_option('single_post_layout');
        $classes[] = 'g5blog__single-' . $single_post_layout;
        if (in_array($single_post_layout,array('layout-1','layout-2','layout-3','layout-4'))) {
            $classes[] = 'g5blog__single-featured-align-wide';
        }
    }
    return $classes;
}
add_filter('body_class', 'g5blog_single_layout_class');


function g5blog_vc_map_add_narrow_category($args = array())
{
    $category = array();
    $categories = get_categories(array('hide_empty' => '1'));
    if (is_array($categories)) {
        foreach ($categories as $cat) {
            $category[$cat->name] = $cat->term_id;
        }
    }
    $default = array(
        'type' => 'g5element_selectize',
        'heading' => esc_html__('Narrow Category', 'g5-blog'),
        'param_name' => 'cat',
        'value' => $category,
        'multiple' => true,
        'description' => esc_html__('Enter categories by names to narrow output.', 'g5-blog'),
        'std' => ''
    );
    $default = array_merge($default, $args);
    return $default;
}

function g5blog_vc_map_add_narrow_tag($args = array())
{
    $tag = array();
    $tags = get_tags(array('hide_empty' => '1'));
    if (is_array($tags)) {
        foreach ($tags as $tg) {
            $tag[$tg->name] = $tg->term_id;
        }
    }
    $default = array(
        'type' => 'g5element_selectize',
        'heading' => esc_html__('Narrow Tag', 'g5-blog'),
        'param_name' => 'tag',
        'value' => $tag,
        'multiple' => true,
        'description' => esc_html__('Enter tags by names to narrow output.', 'g5-blog'),
        'std' => ''
    );
    $default = array_merge($default, $args);
    return $default;
}


function g5blog_vc_map_add_filter()
{
    return array(
        g5blog_vc_map_add_narrow_category(array(
            'group' => esc_html__('Posts Filter', 'g5-blog')
        )),
        g5blog_vc_map_add_narrow_tag(array(
            'group' => esc_html__('Posts Filter', 'g5-blog')
        )),
        array(
            'type' => 'autocomplete',
            'heading' => esc_html__('Narrow Post', 'g5-blog'),
            'param_name' => 'ids',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'unique_values' => true,
                'display_inline' => true
            ),
            'save_always' => true,
            'group' => esc_html__('Posts Filter', 'g5-blog'),
            'description' => esc_html__('Enter List of Posts', 'g5-blog'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Order by', 'g5-blog'),
            'param_name' => 'orderby',
            'value' => array(
                esc_html__('Date', 'g5-blog') => 'date',
                esc_html__('Order by post ID', 'g5-blog') => 'ID',
                esc_html__('Author', 'g5-blog') => 'author',
                esc_html__('Title', 'g5-blog') => 'title',
                esc_html__('Last modified date', 'g5-blog') => 'modified',
                esc_html__('Post/page parent ID', 'g5-blog') => 'parent',
                esc_html__('Number of comments', 'g5-blog') => 'comment_count',
                esc_html__('Menu order/Page Order', 'g5-blog') => 'menu_order',
                esc_html__('Meta value', 'g5-blog') => 'meta_value',
                esc_html__('Meta value number', 'g5-blog') => 'meta_value_num',
                esc_html__('Random order', 'g5-blog') => 'rand',
            ),
            'group' => esc_html__('Posts Filter', 'g5-blog'),
            'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'g5-blog')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Time Filter', 'g5-blog'),
            'param_name' => 'time_filter',
            'value' => array(
                esc_html__('No Filter', 'g5-blog') => 'none',
                esc_html__('Today Posts', 'g5-blog') => 'today',
                esc_html__('Today + Yesterday Posts', 'g5-blog') => 'yesterday',
                esc_html__('This Week Posts', 'g5-blog') => 'week',
                esc_html__('This Month Posts', 'g5-blog') => 'month',
                esc_html__('This Year Posts', 'g5-blog') => 'year'
            ),
            'group' => esc_html__('Posts Filter', 'g5-blog')
        ),
        array(
            'type' => 'g5element_button_set',
            'heading' => esc_html__('Sorting', 'g5-blog'),
            'param_name' => 'order',
            'value' => array(
                esc_html__('Descending', 'g5-blog') => 'DESC',
                esc_html__('Ascending', 'g5-blog') => 'ASC',
            ),
            'std' => 'DESC',
            'group' => esc_html__('Posts Filter', 'g5-blog'),
            'description' => esc_html__('Select sorting order.', 'g5-blog'),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__('Meta key', 'g5-blog'),
            'param_name' => 'meta_key',
            'description' => esc_html__('Input meta key for grid ordering.', 'g5-blog'),
            'group' => esc_html__('Posts Filter', 'g5-blog'),
            'dependency' => array(
                'element' => 'orderby',
                'value' => array('meta_value', 'meta_value_num'),
            ),
        )
    );
}

function g5blog_get_slick_config($args = array()) {
	if (function_exists('g5core_get_slick_config')) {
		return g5core_get_slick_config($args);
	}
	return array();
}