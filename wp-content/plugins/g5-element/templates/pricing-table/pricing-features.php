<?php
/**
 * @var $pricing_class
 * @var $list_features
 * @var $list_style
 * @var $list_icon
 * @var $desc_typography
 * @var $prefix_list_desc_size
 * @var $prefix_list_desc_color
 * @var $list_align
 * @var $prefix_feature
 */

// List features
$pricing_css = '';
if ($prefix_list_desc_color !== '') {
	if (!g5core_is_color($prefix_list_desc_color)) {
		$prefix_list_desc_color = g5core_get_color_from_option($prefix_list_desc_color);
	}
	$pricing_css = <<<CSS
		.{$pricing_class} .pricing-features .list-bullet{
			color: $prefix_list_desc_color;
		}
CSS;
	G5CORE()->custom_css()->addCss($pricing_css);
}
if (($prefix_list_desc_size !== 'px') && ($prefix_list_desc_size !== 'em') && ($prefix_list_desc_size !== 'rem') && ($prefix_list_desc_size !== '%')) {
	$pricing_css = <<<CSS
		.{$pricing_class} .pricing-features .list-bullet{
			font-size: $prefix_list_desc_size;
		}
CSS;
	G5CORE()->custom_css()->addCss($pricing_css);
}

// List_align
$list_classes = array('pricing-list');
if ($list_align !== '') {
	$list_classes[] = 'pricing-list-' . $list_align;
}

$desc_typography = g5element_typography_class($desc_typography);
$desc_classes    = array('pricing-feature-desc');
if ($desc_typography !== '') {
	$desc_classes[] = $desc_typography;
}
?>

<?php $index = 1; ?>
<ul class="<?php echo esc_attr(join(' ', $list_classes)) ?>">
	<?php foreach ($list_features as $data): ?>
		<?php
		$list_icon_html  = '';
		$feature_classes = array('pricing-feature');
		$list_disable    = isset($data['list_disable']) ? $data['list_disable'] : '';
		if ($list_disable !== '') {
			$feature_classes[] = 'disable';
		};
		if ($list_style === 'list-icon') {
			$prefix_feature = isset($data['prefix_feature']) ? $data['prefix_feature'] : $list_icon;
			if ($prefix_feature !== '') {
				$list_icon_html = '<i class="' . esc_attr($prefix_feature) . '"></i>';
			}
		} else {
			if ($list_style === 'list-number') {
				$list_icon_html = $index . '.';
			}
			$index++;
		}
		?>
		<?php $features = isset($data['feature']) ? $data['feature'] : ''; ?>
		<?php if ($features !== ''): ?>
			<li class="<?php echo esc_attr(join(' ', $feature_classes)) ?>">
				<?php if ($list_icon_html !== ''): ?>
					<span class="list-bullet"><?php echo wp_kses_post($list_icon_html); ?></span>
				<?php endif; ?>
				<span class="<?php echo esc_attr(join(' ', $desc_classes)) ?>">
					<?php echo wp_kses_post($data['feature']); ?>
				</span>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>