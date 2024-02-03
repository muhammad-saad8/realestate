<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Bullet_One_Page_Scroll_Navigation
 */
$values = $dots_position = '';
$atts   = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$values = (array) vc_param_group_parse_atts( $values );
G5ELEMENT()->assets()->enqueue_assets_for_shortcode( 'bullet_one_page_scroll_navigation' );

$wrapper_classes = array(
	'nav',
	'g5element-nav',
	'bullet-one-page-scroll-navigation',
	'nav-dark',
);
if ( ! empty( $dots_position ) ) {
	$wrapper_classes[] = "alignment-{$dots_position}";
}


$wrapper_class = implode( ' ', array_filter( $wrapper_classes ) );

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

?>
<nav id="g5element-main-nav" class="<?php echo esc_attr( $css_class ) ?>">
	<?php
	foreach ( $values as $value ):
		$skin = isset( $value['skin'] ) ? $value['skin'] : 'dark';
		?>
        <a href="#<?php echo esc_attr( $value['section_id'] ) ?>" data-skin="<?php echo esc_attr( $skin ) ?>"
           title="<?php echo esc_attr( isset( $value['section_title'] ) ? $value['section_title'] : '' ) ?>"
           class="nav-link"></a>
	<?php endforeach; ?>
</nav>

