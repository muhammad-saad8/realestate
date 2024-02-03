<?php
/**
 * The template for displaying dashboard tab
 *
 * @var $current_page
 */
$pages_settings = G5CORE()->dashboard()->get_config_pages();
?>
<div class="g5core-dashboard-tab-wrapper">
	<ul class="g5core-dashboard-tab">
		<?php foreach ($pages_settings as $key => $value): ?>
			<?php
			$href = isset($value['link']) ? $value['link'] :  admin_url("admin.php?page=g5core_{$key}");
			?>
			<li class="<?php echo esc_attr(($current_page === $key) ? 'active' : '') ?>">
				<a href="<?php echo esc_url($href) ?>"><?php echo esc_html($value['menu_title']) ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>