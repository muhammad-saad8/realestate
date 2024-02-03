<?php
/**
 * @var $type desktop | mobile
 * @var $location before_menu | after_menu | before_logo | after_logo | header_mobile
 * @var $classes
 */
$customize_classes = array(
	'g5core-header-customize',
	'g5core-header-customize-' . $location
);
if (isset($classes) && !empty($classes)) {
	$customize_classes[] = $classes;
}
$customizes = G5CORE()->options()->header()->get_option("{$location}_customize");
unset($customizes['sort_order']);
if (count($customizes) === 0) {
	$customize_classes[] = 'no-items';
}
?>
<div class="<?php echo join(' ', $customize_classes)?>">
	<div class="g5core-header-customize-inner">
		<?php foreach ($customizes as $key => $value): ?>
			<?php if (!in_array($key, array_keys(G5CORE()->settings()->get_header_customize()))) { continue; } ?>
			<div class="g5core-header-customize-item g5core-hc-<?php echo esc_attr($key)?>">
				<?php G5CORE()->get_template("header/customize/{$key}.php", array(
					'type' => $type,
					'location' => $location
				)) ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>