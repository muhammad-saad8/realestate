<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $title_typography
 * @var $sub_title_typography
 * @var $el_class
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Page_Title
 */
$layout_style = $el_class = $title_typography = $sub_title_typography = $css_animation = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('page_title');

$wrapper_classes = array(
    'gel-page-title',
    'gel-page-title-' . $layout_style,
    $this->getCSSAnimation($css_animation),
    $this->getExtraClass($el_class),
    vc_shortcode_custom_css_class($css),
);

$title_class = array(
    'page-main-title',
);
$title_typo_class = g5element_typography_class($title_typography);
if ($title_typo_class !== '') {
    $title_class[] = $title_typo_class;
}
$sub_title_class = array(
    'page-sub-title',
);
$sub_title_typo_class = g5element_typography_class($sub_title_typography);
if ($sub_title_typo_class !== '') {
    $sub_title_class[] = $sub_title_typo_class;
}

$page_title = g5core_get_page_title();
$page_subtitle = g5core_get_page_subtitle();

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <div class="page-title-wrap">
        <div class="page-title-content">
            <?php if (!is_singular()): ?>
                <h1 class="<?php echo implode(' ', $title_class); ?>"><?php echo esc_html($page_title); ?></h1>
            <?php else: ?>
                <p class="<?php echo implode(' ', $title_class); ?>"><?php echo esc_html($page_title); ?></p>
            <?php endif; ?>
            <?php if (!empty($page_subtitle)): ?>
                <p class="page-sub-title <?php echo implode(' ', $sub_title_class); ?>"><?php echo esc_html($page_subtitle); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>






