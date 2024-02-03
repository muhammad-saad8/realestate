<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $values
 * @var $title
 * @var $description
 * @var $image
 * @var $switch_show_tooltip_arrow
 * @var $el_class
 * @var $css
 * @var $switch_icon_animation
 * @var $tooltip_padding
 * @var $title_spacing
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Heading
 */
$image = $title = $description = $icon_font = $x_position = $y_position =
$values = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode( 'counter' );

$wrapper_classes = array(
	'g5element-image-marker',
	$this->getExtraClass( $el_class ),
	vc_shortcode_custom_css_class( $css ),
);

if ( $switch_show_tooltip_arrow !== 'off' ) {
	$wrapper_classes[] = 'g5element-marker-tooltip-arrow';
}
if ( $switch_icon_animation !== 'off' ) {
	$wrapper_classes[] = 'g5element-marker-animate-icon';
}
$wrapper_class = implode( ' ', array_filter( $wrapper_classes ) );
$values        = (array) vc_param_group_parse_atts( $values );

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
if ( ! g5core_is_color( $color_icon ) ) {
	$color_icon = g5core_get_color_from_option( $color_icon );
}
$icon_custom_css = <<<CUSTOM_CSS
	.g5element-pointer-icon i{	
		color: $color_icon !important;
	}
CUSTOM_CSS;
if ( $icon_custom_css !== '' ) {
	G5CORE()->custom_css()->addCss( $icon_custom_css );
}
if ( $title_spacing !== '' ) {
	$title_spacing    = $title_spacing . 'px';
	$title_custom_css = <<<CUSTOM_CSS
	.g5element-image-marker .tooltip-inner h5{	
		margin-bottom: $title_spacing!important;
	}
CUSTOM_CSS;
	if ( $title_custom_css !== '' ) {
		G5CORE()->custom_css()->addCss( $title_custom_css );
	}
}


if ( ! g5core_is_color( $background_color ) ) {
	$background_color = g5core_get_color_from_option( $background_color );
}
if ( $background_color !== '' ) {
	$tooltip_custom_css = <<<CUSTOM_CSS
	.g5element-image-marker .tooltip-inner{	
		background-color: $background_color !important;	
	}
	.g5element-image-marker .bs-tooltip-top .arrow::before{	
		border-top-color: $background_color !important;
	}
CUSTOM_CSS;
	if ( $tooltip_custom_css !== '' ) {
		G5CORE()->custom_css()->addCss( $tooltip_custom_css );
	}
}
if ( $tooltip_padding !== '' ) {
	$padding            = ( intval( $tooltip_padding ) / 2 ) . 'px';
	$tooltip_custom_css = <<<CUSTOM_CSS
	.g5element-image-marker .tooltip-inner{	
		padding: $padding!important;
	}
CUSTOM_CSS;
	if ( $tooltip_custom_css !== '' ) {
		G5CORE()->custom_css()->addCss( $tooltip_custom_css );
	}
}


$title_typo_class       = g5element_typography_class( $title_typography );
$description_typo_class = g5element_typography_class( $description_typography );
$image_src              = '';
$image_title            = '';
if ( ! $image ) {
	return;
}
$image_html = wp_get_attachment_image($image,'full',false,array(
	'class' => 'g5element-marker-image'
));

?>
<div class="<?php echo esc_attr( $css_class ) ?>">
	<?php
	echo $image_html;
	foreach ( $values as $value ) {
		$description = isset( $value['description'] ) ? '<p class="' . $description_typo_class . '">' . esc_html( $value['description'] ) . '</div>' : '';
		$title       = isset( $value['title'] ) ? '<h5 class="' . $title_typo_class . '">' . esc_html( $value['title'] ) . '</h5>' : '';
		$_data       = "0";
		if ( ( $title !== '' ) || ( $description !== '' ) ) {
			$_data = sprintf( '%s%s',
				$title,
				$description );
		}
		$left = $value['x_position'];
		$top  = $value['y_position'];

		$link_url = '#';
		if ( isset( $value['link'] ) ) {
			$link_url = $value['link'];
		}
		$link = g5element_build_link( $link_url );

		?>
		<div class="g5element-image-pointer"
		     style="left:<?php echo $left ?>%;top:<?php echo $top ?>%;"
		     title="<?php echo esc_attr( $_data ) ?>" data-toggle="tooltip">
			<?php echo $link['before'] ?>
			<div class="g5element-pointer-icon">
				<i class="fal fa-plus"></i>
			</div>
			<?php echo $link['after'] ?>
		</div>
		<?php
	}
	?>
</div>


