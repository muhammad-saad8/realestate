<?php
/**
 * The template for displaying number-responsive.tpl.php
 * @var $settings
 * @var $value
 * @var $size_types
 */
$field_classes = array(
	'wpb_vc_param_value',
	$settings['param_name'],
	"{$settings['type']}_field"
);
$data = explode('|', $value);
$field_class = implode(' ', array_filter($field_classes));
?>
<div class="g5element-vc-number-responsive-wrapper">
	<input type="hidden" name="<?php echo esc_attr($settings['param_name']) ?>"
	       class="<?php echo esc_attr($field_class) ?>" value="<?php echo esc_attr($value) ?>">
	<div class="g5element-vc_number-responsive-inner">
        <?php foreach ($size_types as $key => $size) : ?>
            <div class="vc_screen-size vc_screen-size-<?php echo esc_attr($key) ?>">
                <?php $icon = '';
                $index = array_search($key, array_keys($size_types));
                switch ($key) {
                    case 'md':
                        $icon = 'landscape-tablets';
                        break;
                    case 'sm':
                        $icon = 'portrait-tablets';
                        break;
                    case 'xs':
                        $icon = 'landscape-smartphones';
                        break;
                    default:
                    case 'lg':
                        $icon = 'default';
                        break;
                }?>
                <label title="<?php echo esc_attr($size) ?>" for="vc_number-<?php echo esc_attr($key);?>"><i
                        class="vc-composer-icon vc-c-icon-layout_<?php echo esc_attr($icon) ?>"></i></label>
                <input type="number" name="vc_number-<?php echo esc_attr($key);?>" id="vc_number-<?php echo esc_attr($key);?>" value="<?php echo esc_attr($data[$index]) ?>" class="g5element-vc-number-responsive-field">
            </div>
        <?php endforeach; ?>
	</div>
</div>
