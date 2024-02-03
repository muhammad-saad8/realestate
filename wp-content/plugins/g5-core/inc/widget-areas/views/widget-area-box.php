<?php
/**
 * The template for displaying widget-area-box.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
?>
<div id="g5core-add-widget">
	<div class="sidebar-name">
		<h3><?php esc_html_e('Create Widget Area', 'g5-core'); ?></h3>
	</div>
	<div class="sidebar-description">
		<form id="addWidgetAreaForm" action="" method="post">
			<div class="widget-content">
				<input id="g5core-add-widget-input" name="g5core-add-widget-input" type="text" class="regular-text" required="required"
				       title="<?php echo esc_attr(esc_html__('Name','g5-core')); ?>"
				       placeholder="<?php echo esc_attr(esc_html__('Name','g5-core')); ?>" />
			</div>
			<div class="widget-control-actions">
				<?php wp_nonce_field('g5core_add_sidebar_action', 'g5core_add_sidebar_nonce') ?>
				<input class="g5core-sidebar-add-sidebar button button-primary button-hero" type="submit" value="<?php echo esc_attr(esc_html__('Create Widget Area', 'g5-core')); ?>" />
			</div>
		</form>
	</div>
</div>