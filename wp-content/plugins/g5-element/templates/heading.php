<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $subtitle
 * @var $description
 * @var $layout_style
 * @var $limit_width
 * @var $title_typography
 * @var $subtitle_typography
 * @var $description_typography
 * @var $alignment
 * @var $tag_html
 * @var $line_separate_color
 * @var $switch_line_field

 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Heading
 */
$title = $layout_style = $limit_width = $tag_html = $alignment = $title_typography = $switch_line_field = $line_separate_color = '';
$css_animation = $animation_duration = $animation_delay = '';
$subtitle = $description = $icon_size = $el_class = $el_id = $css = $responsive = '';
$subtitle_typography = $description_typography = '';


$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('heading');

if ($title === '') {
	return;
}

$wrapper_classes = array(
	'gel-heading',
	"gel-heading-{$layout_style}",
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
);

switch ($layout_style) {
	case 'style-01':
		$wrapper_classes[] = 'text-left';
		break;
	case 'style-02':
		$wrapper_classes[] = 'text-center';
		break;
	case 'style-03':
		$wrapper_classes[] = 'text-right';
		break;
}

if ($switch_line_field === 'on') {
	$wrapper_classes[] = 'has-line-separator';
}

$title_typography = g5element_typography_class($title_typography);
$subtitle_typography = g5element_typography_class($subtitle_typography);
$description_typography = g5element_typography_class($description_typography);
$title_classes = 'gel-heading-title';
$subtitle_classes = 'gel-heading-subtitle';
$description_classes = 'gel-heading-description';
if (!empty($title_typography)) {
	$title_classes .= " {$title_typography}";
}
if (!empty($subtitle_typography) && $subtitle !== '') {
	$subtitle_classes .= " {$subtitle_typography}";
}
if (!empty($description_typography) && $description !== '') {
	$description_classes .= " {$description_typography}";
}

$heading_custom_class = uniqid('gel-');
$heading_custom_css = '';

if (($switch_line_field === 'on') && ($line_separate_color !== '')) {
	if (!g5core_is_color($line_separate_color)) {
		$line_separate_color = g5core_get_color_from_option($line_separate_color);
	}
	
	$heading_custom_css .= <<<CUSTOM_CSS
	.{$heading_custom_class} .gel-heading-separate{
		background: $line_separate_color;
	}
	.{$heading_custom_class} .gel-heading-separate:before{
		background: $line_separate_color;
	}
	.{$heading_custom_class} .gel-heading-separate:after{
		background: $line_separate_color;
	}
CUSTOM_CSS;
}


if ($limit_width !== '') {
    $limit_width = absint($limit_width);
    if ($limit_width > 0) {
        $heading_custom_css .= <<<CSS
                .{$heading_custom_class} {
                        max-width: {$limit_width}px;
                    }
CSS;
    }
}



if ($heading_custom_css !== '') {
	$wrapper_classes[] = $heading_custom_class;
	G5CORE()->custom_css()->addCss($heading_custom_css);
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$el_attributes = array();
if (!empty($el_id)) {
	$el_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
$el_attributes[] = 'class="' . esc_attr($css_class) . '"';
?>
<div <?php echo join(' ', $el_attributes)?>>
	<?php if($subtitle !== ''): ?>
		<div class="<?php echo esc_attr($subtitle_classes) ?>"><?php echo wp_kses_post($subtitle) ?></div>
	<?php endif; ?>
	<h<?php echo esc_html($tag_html) ?> class="<?php echo esc_attr($title_classes) ?>">
		<?php echo wp_kses_post($title) ?>
	</h<?php echo esc_html($tag_html) ?>>
	<?php if ($switch_line_field === 'on'): ?>
		<div class="gel-heading-separate">
		</div>
	<?php endif;
	if($description !== ''): ?>
		<p class="<?php echo esc_attr($description_classes) ?>"><?php echo wp_kses_post($description) ?></p>
	<?php endif; ?>
</div>