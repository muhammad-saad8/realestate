<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $settingId
 * @var $pagenum_link
 * @var $post_type
 * @var $taxonomy
 * @var $cate
 * @var $current_cat
 * @var $append_tabs
 * @var $cat_align
 */
$args = array(
    'hide_empty'	=> 1,
    'taxonomy' => $taxonomy
);
if (is_array($cate)){
    $args['include'] = $cate;
	$args['orderby'] = 'include';
}

$prettyTabsOptions =  array(
    'more_text' => esc_html__( 'More', 'g5-core' ),
    'append_tabs' => $append_tabs
);

$wrapper_classes = array(
		'g5core__cate-filer',
		'g5core__pretty-tabs'
);

if ($cat_align !== '') {
	$wrapper_classes[] = "g5core__cate-filer-{$cat_align}";
}

$wrapper_class = implode(' ', apply_filters('g5core_cate_filter_classes',$wrapper_classes, $post_type));
$categories = get_categories( apply_filters('g5core_cat_filter_args',$args, $taxonomy ) );
$cate_link = trailingslashit(get_post_type_archive_link($post_type));
?>
<ul data-items-cate class="<?php echo esc_attr($wrapper_class)?>" data-id="<?php echo esc_attr($settingId) ?>" data-pretty-tabs-options="<?php echo esc_attr(json_encode($prettyTabsOptions)) ?>">
    <li class="<?php echo esc_attr($current_cat == -1 ? ' active' : '') ?>">
        <a href="<?php echo esc_url($cate_link); ?>" data-id="-1" title="<?php esc_attr_e('All','g5-core')?>"><?php esc_html_e('All', 'g5-core') ?></a>
    </li>
    <?php foreach ($categories as $category): ?>
        <li class="<?php echo esc_attr($current_cat == $category->cat_ID ? ' active' : '') ?>">
            <a href="<?php echo esc_url(trailingslashit(get_term_link($category)))?>"
               title="<?php echo esc_attr($category->name)?>"
               data-id="<?php echo esc_attr($category->cat_ID)?>"
               data-name="<?php echo esc_attr($category->slug)?>"
            ><?php echo esc_html($category->name)?></a>
        </li>
    <?php endforeach; ?>
</ul>
