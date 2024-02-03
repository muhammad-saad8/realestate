<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$index = 0;
$sidebars = G5Core_Widget_Areas::getInstance()->get_widget_areas();

?>
<div class="wrap g5core-sidebars-wrap">
	<h1><?php echo esc_html__('Sidebars Management','g5-core') ?></h1>
	<div class="g5core-sidebars-row">
		<div class="g5core-sidebars-col-left">
			<?php include G5CORE()->plugin_dir('inc/widget-areas/views/widget-area-box.php'); ?>
		</div>
		<div class="g5core-sidebars-col-right">
			<table class="wp-list-table widefat fixed striped table-view-list">
				<thead>
				<tr>
					<th style="width: 50px">#</th>
					<th><?php echo esc_html__('Name','g5-core') ?></th>
					<th style="width: 100px"></th>
				</tr>
				</thead>
				<tbody>
				<?php if ($sidebars): ?>
					<?php foreach ($sidebars as $k => $v): $index++; ?>
						<tr>
							<td><?php echo esc_html($index) ?></td>
							<td><?php echo esc_html($v) ?></td>
							<td>
								<button type="button" class="button button-small button-secondary g5core-sidebars-remove-item"
								        data-id="<?php echo esc_attr($k) ?>">
									<?php echo esc_html__('Remove','g5-core') ?>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="3">
							<?php echo esc_html__('No Sidebars defined','g5-core') ?>
						</td>
					</tr>
				<?php endif; ?>


				</tbody>
			</table>
		</div>
	</div>
</div>
