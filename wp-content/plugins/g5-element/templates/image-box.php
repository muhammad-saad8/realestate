<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $title
 * @var $content
 * @var $icon_image
 * @var $icon_image_hover
 * @var $link
 * @var $description_typography
 * @var $title_typography
 * @var $el_class
 * @var $hover_effect
 * @var $hover_image_effect
 * @var $border_image
 * @var $img_size
 * @var $img_width
 * @var $css
 * @var $switch_show_button
 * @var $button_size
 * @var $button_style
 * @var $button_shape
 * @var $button_color
 * @var $text_button
 * @var $css_animation
 * @var $button_is_3d
 * @var $img_style
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Image_Box
 */

$layout_style = $title = $switch_show_button = $text_button = $css_animation = $description_typography = $title_typography = '';
$hover_effect = $hover_image_effect = $icon_image = $icon_image_hover = $link = $el_class = $css = $border_image = $img_size = $img_width = $button_is_3d =
$button_size = $button_style = $button_shape = $button_color = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('image_box');

$wrapper_classes = array(
    'gel-image-box',
    $img_style,
    $border_image,
    'gel-image-box-' . $layout_style,
    $this->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css),
);

if ($hover_image_effect !== '' || $hover_effect !== '') {
	$wrapper_classes[] = 'gel-image-effectr-wrap';
}

$hover_classes = array(
	'gel-effect-bg-image',
	'gel-image-effect',
	'gel-image-hover-' . $hover_effect,
);

if (!empty($hover_image_effect)) {
	$hover_classes[] = 'gel-image-effect-img-' .  $hover_image_effect;
}

if ($img_size !== 'custom') {
	$wrapper_classes[] = $img_size;
} else {
	$img_width = absint($img_width);
	if ($img_width > 0) {
		$img_width_class = uniqid('gel-image-box-');
		$img_width_css = <<<CSS
			.{$img_width_class} .image {
			      -ms-flex: 0 0 {$img_width}px;
				  flex: 0 0 {$img_width}px;
				  max-width: {$img_width}px;
			 }
CSS;
		G5Core()->custom_css()->addCss($img_width_css);
		$wrapper_classes[] = $img_width_class;
	}
}




$title_class = array(
    'title',
);
$title_typo_class = g5element_typography_class($title_typography);
if ($title_typo_class !== '') {
    $title_class[] = $title_typo_class;
}
$description_class = array(
    'description',
);
$description_typo_class = g5element_typography_class($description_typography);
if ($description_typo_class !== '') {
    $description_class[] = $description_typo_class;
}

$img_box_link = g5element_build_link($link);


// img html
$icon_html = '';
$icon_hover_html = '';
if (!empty($icon_image)) {
    $icon_image_id = preg_replace('/[^\d]/', '', $icon_image);
	$icon_html = wp_get_attachment_image($icon_image_id,'full',false,array('class' => 'gel-effect-content'));
}

if (!empty($icon_image_hover)) {
	$icon_image_hover_id = preg_replace('/[^\d]/', '', $icon_image_hover);
	$icon_hover_html = wp_get_attachment_image($icon_image_hover_id,'full');
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);

?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php G5ELEMENT()->get_template("image-box/{$layout_style}.php", array(
        'title_class' => $title_class,
        'img_box_link' => $img_box_link,
        'title' => $title,
        'content' => $content,
        'description_class' => $description_class,
        'switch_show_button' => $switch_show_button,
        'text_button' => $text_button,
        'icon_html' => $icon_html,
        'icon_hover_html' => $icon_hover_html,
        'link' => $link,
        'button_size' => $button_size,
        'button_style' => $button_style,
        'button_shape' => $button_shape,
        'button_color' => $button_color,
        'button_is_3d' => $button_is_3d,
        'hover_effect' => $hover_effect,
        'hover_image_effect' => $hover_image_effect,
        'hover_classes' => $hover_classes,
    )); ?>
</div>