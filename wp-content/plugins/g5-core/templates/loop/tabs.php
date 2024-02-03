<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $tabs
 * @var $append_tabs
 * @var $cat_align
 */
$prettyTabsOptions = array(
    'more_text' => esc_html__( 'More', 'g5-core' ),
    'append_tabs' => $append_tabs
);
$wrapper_classes = array(
	'g5core__cate-filer',
	'g5core__pretty-tabs'
);

if ($cat_align !== '') {
	$wrapper_classes[] = "g5core__cate-filer-{$cat_align}";
}

$wrapper_class = implode(' ', $wrapper_classes);

?>
<ul data-items-tabs class="<?php echo esc_attr($wrapper_class)?>" data-pretty-tabs-options="<?php echo esc_attr(json_encode($prettyTabsOptions)) ?>">
    <?php $index = 1; ?>
    <?php foreach ($tabs as $tab): ?>
        <?php
        $label = isset($tab['label']) ? $tab['label'] : '';
        $settingId = isset($tab['settingId']) ? $tab['settingId'] : '';
        $icon_html =  '';
        $icon = isset($tab['icon']) ? $tab['icon'] : '';
        if (is_array($icon)) {
            $icon_type = isset($icon['type']) ? $icon['type'] : '';
            if ($icon_type === 'icon') {
	            $icon_html = isset($icon['icon_html']) ? $icon['icon_html'] : '';
                $icon_font = isset($icon['icon']) ? $icon['icon'] : '';
                if ($icon_font !== '') {
                    $icon_html = sprintf('<i class="%s"></i>', $icon_font);
                }
            } elseif ($icon_type === 'image') {
                $image = isset($icon['image']) ? $icon['image'] : '';
                if ($image !== '') {
                    $image_id = preg_replace('/[^\d]/', '', $image);
                    $icon_html = wp_get_attachment_image($image_id,'thumbnail');
                }
            }
        }
        ?>
        <li class="<?php echo esc_attr($index == 1 ? 'active' : '');?>">
            <a data-id="<?php echo esc_attr($settingId)?>" href="#" title="<?php echo esc_attr($label)?>"><?php echo wp_kses_post($icon_html)?><?php echo esc_html($label); ?></a>
        </li>
        <?php $index++; ?>
    <?php endforeach; ?>
</ul>
