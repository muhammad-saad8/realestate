<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $time
 * @var $url_redirect
 * @var $background
 * @var $foreground_color
 * @var $background_color
 * @var $number_typography
 * @var $text_typography
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Count_Down
 */
$layout_style = $time = $background = $url_redirect = $foreground_color = $background_color = $number_typography =
$text_typography = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('count_down');

if (empty($time)) {
    return;
}

$wrapper_classes = array(
    'gel-countdown',
    'gel-countdown-' . $layout_style,
    $this->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css)
);

if (($foreground_color !== '') && (!g5core_is_color($foreground_color))) {
    $foreground_color = g5core_get_color_from_option($foreground_color);
}
if (($background_color !== '') && (!g5core_is_color($background_color))) {
    $background_color = g5core_get_color_from_option($background_color);
}

$number_classes = array(
    'gel-countdown-value'
);

if (($layout_style == 'style-02') && ($background !== '')) {
    if (!g5core_is_color($background)) {
        $background = g5core_get_color_from_option($background);
    }
    $custom_color_contract = g5core_color_contrast($background);
    $number_bg_class = uniqid('gel-');
    $number_classes[] = $number_bg_class;
    $section_bg_css = <<<CSS
    .{$number_bg_class}{
        background-color: {$background} !important; ;
        color: {$custom_color_contract};
    }
CSS;
    G5Core()->custom_css()->addCss($section_bg_css);
}

$number_typo_class = g5element_typography_class($number_typography);

if ($number_typo_class !== '') {
    $number_classes[] = $number_typo_class;
}
$number_class = implode(' ', $number_classes);

$text_classes = array(
    'gel-countdown-text'
);
$text_typo_class = g5element_typography_class($text_typography);

if ($text_typo_class !== '') {
    $text_classes[] = $text_typo_class;
}
$text_class = implode(' ', $text_classes);

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$time = mysql2date('Y/m/d H:i:s', $time);
?>
<div class="<?php echo esc_attr($css_class) ?>" data-date-end="<?php echo esc_attr($time); ?>">
    <?php G5ELEMENT()->get_template('count-down/' . $layout_style . '.php', array('number_class' => $number_class,
        'text_class' => $text_class, 'foreground_color' => $foreground_color, 'background_color' => $background_color)); ?>
</div>

