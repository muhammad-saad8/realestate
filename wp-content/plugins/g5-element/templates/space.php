<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $spacing
 * @var $spacing_lg
 * @var $spacing_md
 * @var $spacing_sm
 * @var $spacing_xs
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Space
 */
$spacing = $spacing_lg = $spacing_md = $spacing_sm = $spacing_xs = '';
$atts    = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('space');

$wrapper_classes = array(
	'gel-space'
);

$el_class_name = 'gel-' . md5(json_encode($atts));

if ( G5CORE()->custom_css()->existsCssKey( $el_class_name ) ) {
	$wrapper_classes[] = $el_class_name;
}
else {
	$space_css = '';

	if ( $spacing !== '' ) {
		$space_css .= <<<CSS
		.{$el_class_name}{
			height: {$spacing}px;
		}
CSS;
	}

	if ( $spacing_lg !== '' ) {
		$space_css .= <<<CSS
	    @media (max-width: 1199px) {
	        .{$el_class_name}{
				height: {$spacing_lg}px;
			}
	    }
CSS;
	}
	if ( $spacing_md !== '' ) {
		$space_css .= <<<CSS
		@media (max-width: 991px) {
			.{$el_class_name}{
				height: {$spacing_md}px;
			}
		}
CSS;
	}
	if ( $spacing_sm !== '' ) {
		$space_css .= <<<CSS
		@media (max-width: 767px) {
			.{$el_class_name}{
				height: {$spacing_sm}px;
			}
        }
CSS;
	}

	if ( $spacing_xs !== '' ) {
		$space_css .= <<<CSS
		@media (max-width: 575px) {
			.{$el_class_name}{
				height: {$spacing_xs}px;
			}
		}
CSS;
	}

	if ( $space_css !== '' ) {
		$wrapper_classes[] = $el_class_name;
		G5CORE()->custom_css()->addCss($space_css, $el_class_name);
	}
}

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
?>
<div class="<?php echo esc_attr( $css_class ); ?>"></div>