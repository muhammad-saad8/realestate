<?php
/**
 * The template for displaying number-and-unit.tpl.php
 * @var $settings
 * @var $value
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);

$field_class = implode(' ', array_filter($field_classes));
if ($value === '') {
	$color_name = '';
	$color_code = '';
}
else if (g5core_is_color($value)) {
	$color_name = 'custom';
	$color_code = $value;
}
else {
	$color_name = $value;
	$color_code = '';
}
?>
<div class="g5element-vc-color-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<div class="g5element-vc_gel_color-inner">
		<div class="g5element-vc_gel_color-select" data-vc-shortcode="">
			<select class="gel-colored-dropdown vc_colored-dropdown">
				<?php foreach (G5CORE()->settings()->get_color_list() as $key => $title): ?>
					<option value="<?php echo esc_attr($key) ?>" <?php echo $key === '' ? '' : 'class="' . esc_attr($key) . '"' ?><?php selected($key, $color_name) ?>><?php echo esc_html($title) ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="g5element-vc_gel_color-color"<?php echo $color_name !== 'custom' ? ' style="display:none"' : '' ?>>
			<input type="text"
			       maxlength="22"
			       pattern="^((#(([a-fA-F0-9]{6})|([a-fA-F0-9]{3})))|(rgba\(\d+,\d+,\d+,\d?(\.\d+)*\)))$"
			       data-alpha="true"
			       value="<?php echo esc_attr( $color_code ); ?>">
		</div>
	</div>
</div>
