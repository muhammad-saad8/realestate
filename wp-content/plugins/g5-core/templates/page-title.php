<?php
/**
 * The template for displaying page-title
 */
$page_title_enable = G5CORE()->options()->page_title()->get_option('page_title_enable');
if ($page_title_enable !== 'on') {
	return;
}

$breadcrumb_enable = G5CORE()->options()->page_title()->get_option('breadcrumb_enable');
$content_block = G5CORE()->options()->page_title()->get_option('page_title_content_block');
$layout = G5CORE()->options()->page_title()->get_option('page_title_layout');

$wrapper_classes = array(
	'g5core-page-title',
	"page-title-layout-{$layout}"
);
$wrapper_classes[] = empty($content_block) ? 'g5core-page-title-default' : 'g5core-page-title-content-block';
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
	<?php if (!empty($content_block)): ?>
		<div class="container">
			<?php echo g5core_get_content_block($content_block); ?>
		</div>
	<?php else: ?>
		<?php $page_title = g5core_get_page_title(); ?>
		<?php $page_subtitle = g5core_get_page_subtitle(); ?>
		<div class="container">
			<div class="page-title-inner">
				<div class="page-title-content">
					<?php if (!is_singular()): ?>
						<h1 class="page-main-title"><?php echo esc_html($page_title);?></h1>
					<?php else: ?>
						<p class="page-main-title"><?php echo esc_html($page_title);?></p>
					<?php endif; ?>
					<?php if(!empty($page_subtitle)): ?>
						<p class="page-sub-title"><?php echo esc_html($page_subtitle); ?></p>
					<?php endif; ?>
				</div>
                <?php
	                if ($breadcrumb_enable === 'on') {
		                G5CORE()->breadcrumbs()->get_breadcrumbs();
	                }
                 ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php do_action('g5core_after_page_title') ?>