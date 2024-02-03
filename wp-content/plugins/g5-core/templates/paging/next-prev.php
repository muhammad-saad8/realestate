<?php
/**
 * The template for displaying load-more.php
 *
 * @package WordPress
 * @var $settingId
 * @var $pagenum_link
 * @var $isMainQuery
 * @var $paged
 * @var $max_num_pages
 */
//$paged   =  G5CORE()->query()->query_var_paged();
//$max_num_pages = G5CORE()->query()->get_max_num_pages();

$next_classes = array(
    'g5core__paging-button-next'
);
$prev_classes = array(
    'g5core__paging-button-prev'
);

$next_paged = $paged + 1;
$prev_paged = $paged - 1;

if ($paged >=  $max_num_pages) {
    $next_classes[] = 'disable';
}

if ($paged <= 1) {
    $prev_classes[] = 'disable';
}
$next_class = implode(' ', array_filter($next_classes));
$prev_class = implode(' ', array_filter($prev_classes));

$next_link = $isMainQuery ?  get_next_posts_page_link($max_num_pages) : '#';
$prev_link = $isMainQuery ?  get_previous_posts_page_link() : '#';
?>
<div data-items-paging="next-prev" class="g5core__paging next-prev" data-id="<?php echo esc_attr($settingId) ?>">
    <a data-paged="<?php echo esc_attr($prev_paged); ?>" title="<?php esc_attr_e('Prev', 'g5-core') ?>" class="<?php echo esc_attr($prev_class)?>" href="<?php echo esc_url($prev_link); ?>">
        <i class="fas fa-arrow-left"></i>
    </a>
    <a data-paged="<?php echo esc_attr($next_paged); ?>" title="<?php esc_attr_e('Next', 'g5-core') ?>" class="<?php echo esc_attr($next_class)?>" href="<?php echo esc_url($next_link); ?>">
        <i class="fas fa-arrow-right"></i>
    </a>
</div>
