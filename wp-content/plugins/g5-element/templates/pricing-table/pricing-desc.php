<?php
/**
 * @var $name
 * @var $name_typography
 * @var $image_src
 * @var $img_title
 */
?>
<?php
$name_typography = g5element_typography_class($name_typography);
$name_classes    = array('pricing-name');
if ($name_typography !== '') {
	$name_classes[] = $name_typography;
}
?>

<div class="pricing-desc">
	<?php if ($layout_style === 'style-1' || $layout_style === 'style-2'): ?>
		<?php if (!empty($name)): ?>
			<span class="<?php echo esc_attr(join(' ', $name_classes)) ?>">
				<?php echo esc_html($name) ?>
			</span>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (!empty($image_src)): ?>
		<div class="pricing-image">
			<img src="<?php echo esc_url($image_src) ?>"<?php echo ($img_title !== '' ? sprintf(' alt="%s"', esc_attr($img_title)) : '')  ?>>
		</div>
	<?php endif; ?>

	<?php if ($layout_style === 'style-3' ||$layout_style === 'style-4' || $layout_style === 'style-5'): ?>
		<?php if (!empty($name)): ?>
			<span class="<?php echo esc_attr(join(' ', $name_classes)) ?>">
				<?php echo esc_html($name) ?>
			</span>
		<?php endif; ?>
	<?php endif; ?>
</div>
