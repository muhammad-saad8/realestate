<?php
/**
 * The template for displaying dashboard
 *
 * @var $current_page
 */
$pages_settings = G5CORE()->dashboard()->get_config_pages();
$current_theme = wp_get_theme();
?>
<?php if (G5CORE()->dashboard()->plugins()->do_plugin_install()): ?>
    <script type="text/javascript">
        window.location = "admin.php?page=g5core_plugins";
    </script>
<?php endif; ?>

<div class="g5core-dashboard wrap">
    <h2 class="screen-reader-text"><?php printf(esc_html__('%s Dashboard', 'g5-core'), $current_theme['Name']) ?></h2>
	<?php G5CORE()->get_plugin_template("inc/dashboard/templates/tab.php", array(
		'current_page' => $current_page
	)) ?>
	<div class="g5core-dashboard-content">
		<?php G5CORE()->get_plugin_template("inc/dashboard/templates/{$current_page}.php") ?>
	</div>
</div>

