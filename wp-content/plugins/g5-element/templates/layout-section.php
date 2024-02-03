<?php
/***
 * Shortcode attributes
 * @var $content
 * @var $atts
 * @var $this WPBakeryShortCode_G5Element_Slider_Container
 */
$atts                = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('layout_section');

$wrapper_classes = array(
	'gel-layout-section'
);

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
?>
<div class="<?php echo esc_attr( $css_class ) ?>">
	<?php g5element_shortcode_content( $content ); ?>
</div>