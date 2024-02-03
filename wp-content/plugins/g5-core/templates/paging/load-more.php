<?php
/**
 * The template for displaying load-more.php
 *
 * @var $settingId
 * @var $pagenum_link
 * @var $isMainQuery
 * @var $paged
 * @var $max_num_pages
 */
//$paged =  G5CORE()->query()->query_var_paged();
//$max_num_pages = G5CORE()->query()->get_max_num_pages();
$next_link = $isMainQuery ?  get_next_posts_page_link($max_num_pages) : '#';
$paged = intval($paged) + 1;
if ($paged > $max_num_pages) return;
$spin_color = apply_filters('g5core_paging_load_more_spin_color','#fff');

$css_classes = apply_filters('g5core_paging_load_more_css_class',array(
	'no-animation',
	'btn',
	'btn-icon',
	'btn-icon-left'
));

$css_class = implode(' ', $css_classes);
?>
<div data-items-paging="load-more" class="g5core__paging load-more" data-id="<?php echo esc_attr($settingId) ?>">
    <a data-paged="<?php echo esc_attr($paged); ?>" data-style="zoom-in" data-spinner-size="20" data-spinner-color="<?php echo esc_attr($spin_color); ?>" class="<?php echo esc_attr($css_class);?>" href="<?php echo esc_url($next_link); ?>">
        <i class="fas fa-plus"></i> <?php esc_html_e('More', 'g5-core') ?>
    </a>
</div>
