<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
global $post;
$post_id = $post->ID;
$post_algorithm = G5BLOG()->options()->get_option('single_post_related_algorithm');
$posts_per_page = intval(G5BLOG()->options()->get_option('single_post_related_per_page'));
$columns_gutter = intval(G5BLOG()->options()->get_option('single_post_related_columns_gutter'));
$columns_xl = intval(G5BLOG()->options()->get_option('single_post_related_columns_xl'));
$columns_lg = intval(G5BLOG()->options()->get_option('single_post_related_columns_lg'));
$columns_md = intval(G5BLOG()->options()->get_option('single_post_related_columns_md'));
$columns_sm = intval(G5BLOG()->options()->get_option('single_post_related_columns_sm'));
$columns = intval(G5BLOG()->options()->get_option('single_post_related_columns'));
$post_paging = G5BLOG()->options()->get_option('single_post_related_paging');
$post_layout = G5BLOG()->options()->get_option('single_post_related_post_layout');
$excerpt_enable = G5BLOG()->options()->get_option('single_post_related_excerpt_enable');
$image_size = G5BLOG()->options()->get_option('single_post_related_post_image_size');
$post_image_width = G5BLOG()->options()->get_option('single_post_related_post_image_width');
$image_ratio = G5BLOG()->options()->get_option('single_post_related_post_image_ratio');
$item_custom_class = G5BLOG()->options()->get_option('single_post_related_item_custom_class');
$query_args = array(
    'ignore_sticky_posts' => true,
    'posts_per_page' => $posts_per_page,
    'post__not_in' => array($post_id)
);


switch ($post_algorithm) {
    case 'cat':
        $query_args['category__in'] = wp_get_post_categories($post_id);
        break;
    case 'tag':
        $query_args['tag__in'] = wp_get_object_terms($post_id, 'post_tag', array( 'fields' => 'ids' ) );
        break;
    case 'author':
        $query_args['author'] = $post->post_author;
        break;
    case 'cat-tag':
        $query_args['category__in'] = wp_get_post_categories($post_id);
        $query_args['tag__in']      = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
        break;
    case 'cat-tag-author':
        $query_args['author']       = $post->post_author;
        $query_args['category__in'] = wp_get_post_categories( $post_id );
        $query_args['tag__in']      = wp_get_object_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
        break;
    case 'random':
        $query_args['orderby'] = 'rand';
        break;
}

$settings = array(
	'post_layout' => 'grid',
	'columns_gutter' => $columns_gutter,
	'post_paging' => $post_paging !== 'slider' ? $post_paging : '',
	'post_animation' => 'none',
	'image_ratio' => $image_ratio,
	'image_width' => array(
		'width' => intval($post_image_width)
	),
);


$post_columns = array(
	'xl' =>  $columns_xl,
	'lg' =>  $columns_lg,
	'md' =>  $columns_md,
	'sm' =>  $columns_sm,
	''   =>  $columns,
);

if ($post_paging !== 'slider') {
    $settings['post_columns'] = $post_columns;
} else {
    $settings['slick'] = g5blog_get_slick_config(array(
	    'arrows' => false,
	    'dots' => true,
	    'columns' => $post_columns
    ));
}

$settings = apply_filters('g5blog_single_related_settings',$settings);


if (!empty($post_layout)) {
	$settings['post_layout'] = $post_layout;
}

if (!empty($item_custom_class)) {
	$settings['item_custom_class'] = $item_custom_class;
}

$settings['excerpt_enable'] = $excerpt_enable;

if (!empty($image_size)) {
	$settings['image_size'] = $image_size;
}

G5CORE()->query()->query_posts($query_args);
if (!G5CORE()->query()->have_posts()) {
	G5CORE()->query()->reset_query();
	return;
}


?>
<div class="g5blog__single-related-wrap">
    <h4 class="g5blog__block-title"><span><?php esc_html_e('Related Post', 'g5-blog'); ?></span></h4>
    <?php G5BLOG()->listing()->render_content($query_args, $settings); ?>
</div>

