<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $items
 * @var $item_typography
 * @var $link
 * @var $icon_list
 * @var $icon_style
 * @var $shape_bullet
 * @var $icon_style_list
 * @var $el_class
 * @var $css
 * @var $values
 * @var $start_auto_number
 * @var $list_style_type
 * @var $icon_style_item
 * @var $color_list_type
 * @var $css_animation
 * @var $text_align
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_List
 */
$layout_style = $items = $title = $item_typography = $icon_list = $icon_style = $values = $shape_bullet = $icon_style_list = $link =
$el_class = $css = $list_style_type = $start_auto_number = $color_list_type = $css_animation = $text_align = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('list');

$wrapper_classes = array(
    'gel-list',
    'gel-list-' . $layout_style,
    $this->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css),
);

if ($layout_style === 'style-03') {
    $wrapper_classes[] = $text_align;
}

if (($start_auto_number !== '') && ($list_style_type !== 'icon_list') && ($shape_bullet !== 'none-type')) {
    $auto_number = (int)$start_auto_number - 1;
    $class_numbered = uniqid('gel-');
    $custom_start_number = '';
    $custom_start_number .= <<<CUSTOM_CSS
	.{$class_numbered} ul{
		counter-reset: item $auto_number;
	}

CUSTOM_CSS;
    if ($custom_start_number !== '') {
        $wrapper_classes[] = $class_numbered;
        G5CORE()->custom_css()->addCss($custom_start_number);
    }
}


if (($color_list_type !== '') && ($shape_bullet !== 'none-type')) {
    if (!g5core_is_color($color_list_type)) {
        $color_list_type = g5core_get_color_from_option($color_list_type);
    }

    $class_color_style = uniqid('gel-');
    $list_custom_css = '';
    $list_custom_css .= <<<CUSTOM_CSS
	.{$class_color_style} .item-list:before{
		color: $color_list_type !important;
	}
	.{$class_color_style} .list-type{
		color: $color_list_type !important;
	}
CUSTOM_CSS;
    if ($list_custom_css !== '') {
        $wrapper_classes[] = $class_color_style;
        G5CORE()->custom_css()->addCss($list_custom_css);
    }
}
$values = (array)vc_param_group_parse_atts($values);

$item_class = array(
    'gel-list-item',
);
$item_typo_class = g5element_typography_class($item_typography);
if ($item_typo_class !== '') {
    $item_class[] = $item_typo_class;
}

//css class list type
if ($list_style_type === 'style_list') {
    $css_class_list_type = $shape_bullet;
} else {
    $css_class_list_type = $list_style_type;
}
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <ul class="content-list <?php echo esc_attr($css_class_list_type) ?>">
        <?php foreach ($values as $data): ?>
            <?php
            // icon html
            $icon_html = '';
            $icon_class = '';
            if ($list_style_type === 'icon_list') {
                $icon_style_item = isset($data['icon_style_item']) ? $data['icon_style_item'] : '';
                $icon_class = empty($icon_style_item) ? $icon_style_list : $icon_style_item;
                $icon_html = '<i class="' . esc_attr($icon_class) . '"></i>';
            }
            //link
            $link = isset($data['link']) ? $data['link'] : '';
            $icon_box_link = g5element_build_link($link);
            ?>
            <?php $items = isset($data['items']) ? $data['items'] : ''; ?>
            <?php if (!empty($items)): ?>
                <li class="item-list <?php echo implode(' ', $item_class); ?>">
                    <?php if ($list_style_type === 'icon_list'): ?>
                        <span class="list-type"><?php echo wp_kses_post($icon_html) ?></span>
                    <?php endif; ?>
                    <?php echo $icon_box_link['before'] ?>
                    <?php echo wp_kses_post($data['items']) ?>
                    <?php echo $icon_box_link['after'] ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
