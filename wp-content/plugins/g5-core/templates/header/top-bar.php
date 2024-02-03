<?php
/**
 * @var $type desktop | mobile
 */

if (G5CORE()->options()->header()->get_option("top_bar_{$type}_enable") !== 'on') {
	return;
}
$top_bar_items = G5CORE()->options()->header()->get_option("top_bar_{$type}_items");


foreach ($top_bar_items as $key => $value) {
	unset($top_bar_items[$key]['__no_value__']);
}
if (!isset($top_bar_items['left']) || !isset($top_bar_items['right']) || (empty($top_bar_items['left']) && empty($top_bar_items['right']))) {
	return;
}

$top_bar_classes = array('g5core-top-bar', "g5core-top-bar-{$type}");
if (G5CORE()->options()->header()->get_option("top_bar_{$type}_border_bottom")) {
	$top_bar_classes[] = "top-bar-{$type}-border-bottom";
}
?>
<div class="<?php echo join(' ', $top_bar_classes)?>">
	<div class="container">
		<div class="g5core-top-bar-inner">
			<?php if (!empty($top_bar_items['left'])): ?>
				<div class="g5core-top-bar-left">
					<?php foreach ($top_bar_items['left'] as $key => $value): ?>
						<div class="g5core-top-bar-item g5core-tbi-<?php echo esc_attr($key) ?>">
							<?php G5CORE()->get_template( 'header/top-bar/' . $key . '.php', array(
								'type' => $type
							)); ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if (!empty($top_bar_items['right'])): ?>
				<div class="g5core-top-bar-right">
					<?php foreach ($top_bar_items['right'] as $key => $value): ?>
						<div class="g5core-top-bar-item g5core-tbi-<?php echo esc_attr($key) ?>">
							<?php G5CORE()->get_template( 'header/top-bar/' . $key . '.php', array(
								'type' => $type
							)); ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>