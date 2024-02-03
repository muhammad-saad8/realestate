<?php
/**
 * The template for displaying system-report
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */

$settings = G5CORE()->dashboard()->system_status()->get_settings();
?>
<div class="g5core-box g5core-copy-system-status">
	<div class="g5core-box-head">
		<?php esc_html_e('Get System Report', 'g5-core') ?>
	</div>
	<ul class="g5core-system-status-list g5core-clearfix">
		<li class="g5core-clearfix g5core-system-status-info">
			<div class="g5core-clearfix g5core-system-info">
				<div class="g5core-label"><a href="#" class="button-primary g5core-debug-report"><?php esc_html_e('Get System Report', 'g5-core') ?></a></div>
				<div class="g5core-info"><?php esc_html_e('Click the button to produce a report, then copy and paste into your support ticket.', 'g5-core') ?></div>
			</div>
			<div class="g5core-system-report">
				<textarea rows="20" id="system-report" name="system-report"></textarea>
				<a href="javascript:;" class="button-primary g5core-copy-system-report"><?php esc_html_e('Copy for Support', 'g5-core') ?></a>
			</div>
		</li>
	</ul>
</div>
<?php foreach ($settings as $setting): ?>
	<div class="g5core-box">
		<?php if (isset($setting['label']) && (!empty($setting['label']))): ?>
			<div class="g5core-box-head">
				<?php echo esc_html($setting['label']) ?>
			</div>
		<?php endif; ?>
		<?php if (isset($setting['fields']) && is_array($setting['fields'])): ?>
			<ul class="g5core-system-status-list g5core-clearfix">
				<?php foreach ($setting['fields'] as $field): ?>
					<?php if (isset($field['content']) && !empty($field['content'])): ?>
						<li class="g5core-clearfix">
							<?php if (isset($field['label']) && !empty($field['label'])): ?>
								<div class="g5core-label"><?php echo wp_kses_post($field['label']) ?></div>
							<?php endif; ?>
							<div class="g5core-info">
								<?php
								$icons = 'dashicons-editor-help';
								if (isset($field['content']['status'])) {
									if ($field['content']['status'] === false) {
										$icons = 'dashicons-dismiss';
									}
								}
								if (isset($field['content']['html'])) {
									$field['content'] = $field['content']['html'];
								}
								?>
								<?php if (isset($field['help']) && !empty($field['help'])): ?>
									<a href="#" class="g5core-help g5core-tooltip dashicons <?php echo esc_attr($icons) ?>" title="<?php echo esc_attr($field['help']) ?>"></a>
								<?php endif; ?>
								<?php echo wp_kses_post($field['content']); ?>
							</div>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
<?php endforeach; ?>


