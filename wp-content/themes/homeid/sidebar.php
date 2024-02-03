<?php
/**
 * The sidebar containing the main widget area
 *
 * @since 1.0
 * @version 1.0
 */
if ( !homeid_has_sidebar()) {
	return;
}

$sidebar_classes = apply_filters('homeid_sidebar_classes', array(
	'primary-sidebar',
	'sidebar',
	'col',
));
?>

<div id="sidebar" class="<?php echo esc_attr(join(' ', $sidebar_classes)); ?>">
	<div class="primary-sidebar-inner">
		<?php do_action('homeid_before_sidebar_content'); ?>
		<?php dynamic_sidebar( homeid_sidebar_primary() ); ?>
		<?php do_action('homeid_after_sidebar_content'); ?>
	</div>
</div><!-- #sidebar -->