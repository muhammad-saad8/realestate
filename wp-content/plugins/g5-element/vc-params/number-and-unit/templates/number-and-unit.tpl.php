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
$units = array(
	'px' => 'px',
	'em' => 'em',
	'rem' => 'rem',
	'%' => '%'
);

$number = '';
$unit_value = 'px';

if (preg_match('/^(.*)(rem)$/', $value, $m)) {
	$number = $m[1];
	$unit_value = $m[2];
}
elseif (preg_match('/^(.*)(px|em|\%)$/', $value, $m)) {
	$number = $m[1];
	$unit_value = $m[2];
}

?>
<div class="g5element-vc-number-and-unit-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<div class="g5element-vc_number-and-unit-inner">
        <div class="g5element-number-value">
            <input type="number" name="vc_number-value" value="<?php echo esc_attr($number) ?>" class="g5element-vc-number-and-unit-field">
        </div>
        <select name="g5element-number-unit" id="g5element-number-unit" class="g5element-vc-number-and-unit-field">
            <?php foreach ($units as $key => $title): ?>
                <?php
                $attributes = array();
                if ($key === $unit_value) {
                    $attributes[] = 'selected="selected"';
                }
                ?>
                <option value="<?php echo esc_attr($key) ?>" <?php echo implode(' ', $attributes) ?>><?php echo esc_html($title) ?></option>
            <?php endforeach; ?>
        </select>
	</div>
</div>
