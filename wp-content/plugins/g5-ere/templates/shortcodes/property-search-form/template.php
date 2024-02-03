<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $search_form
 * @var $el_id
 * @var $el_class
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Property_Search_Form
 */

$search_form =
$el_id = $el_class =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$wrapper_classes = array(
	'g5element__property-search-form',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css)
);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
$wrapper_attributes = array();
if (!empty($el_id)) {
	$wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
	<?php g5ere_template_search_form($search_form) ?>
</div>


