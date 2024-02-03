<?php
/***
 * Shortcode attributes
 * @var $content
 * @var $atts
 * @var $layout_style
 * @var $content_size
 * @var $content_spacing
 * @var $vertical_alignment
 * @var $left_content_alignment
 * @var $right_content_alignment
 * @var $vertical_mode_device
 * @var $el_id
 * @var $el_class
 * @var $css
 * @var $responsive
 *
 * @var $this WPBakeryShortCode_G5Element_Slider_Container
 */

$layout_style = $content_size = $content_spacing = $vertical_alignment = '';
$left_content_alignment = $right_content_alignment = $vertical_mode_device = '';
$el_class = $el_id = $css = $responsive = '';

$atts                = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('layout_container');

$wrapper_classes = array(
	'gel-layout-container',
	"gel-lc-{$layout_style}",
	"gel-lc-align-{$vertical_alignment}",
	"gel-lc-left-content-{$left_content_alignment}",
	"gel-lc-left-content-{$right_content_alignment}",
	$this->getExtraClass( $el_class ),
	$this->getCSSAnimation( $css_animation ),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);
if ($vertical_mode_device !== '') {
	$wrapper_classes[] = 'gel-lc-vertical-mode-' . $vertical_mode_device;
}

$custom_css_class_name = uniqid('gel-');

$custom_css = '';

if ($content_spacing !== '') {
	$custom_css .= <<<CUSTOM_CSS
	.{$custom_css_class_name} .gel-layout-section + .gel-layout-section {
		margin-left: $content_spacing;
	}
CUSTOM_CSS;
}
if ($content_size !== '' ) {
	if ($layout_style === 'fix_left_content') {
		$custom_css .= <<<CUSTOM_CSS
		.{$custom_css_class_name} .gel-layout-section:first-child {
			flex: 0 0 {$content_size};
		}
		.{$custom_css_class_name} .gel-layout-section:last-child {
			flex: 1 1 auto;
		}
CUSTOM_CSS;
	}
	else {
		$custom_css .= <<<CUSTOM_CSS
		.{$custom_css_class_name} .gel-layout-section:last-child {
			flex: 0 0 {$content_size};
		}
		.{$custom_css_class_name} .gel-layout-section:first-child {
			flex: 1 1 auto;
		}
CUSTOM_CSS;
	}

}
if ($custom_css !== '') {
	$wrapper_classes[] = $custom_css_class_name;
	G5CORE()->custom_css()->addCss($custom_css);
}

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$el_attributes = array();
if (!empty($el_id)) {
	$el_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
$el_attributes[] = 'class="' . esc_attr($css_class) . '"';
?>
<div <?php echo join(' ', $el_attributes)?>>
	<?php g5element_shortcode_content( $content ); ?>
</div>