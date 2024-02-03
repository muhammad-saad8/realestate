<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Agency
 */
$post_layout = $item_skin = $list_item_skin = $item_custom_class =
$columns_gutter = $posts_per_page = $offset = $post_paging = $post_animation =
$el_id = $el_class =
$columns_xl = $columns_lg = $columns_md = $columns_sm = $columns =
$post_image_size = $post_image_ratio_width = $post_image_ratio_height =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts        = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$wrapper_classes = array(
	'g5element__agency',
	$this->getExtraClass( $el_class ),
	$this->getCSSAnimation( $css_animation ),
	vc_shortcode_custom_css_class( $css )
);
$query_args            = array(
	'taxonomy' => 'agency'
);

$settings = array(
	'image_size'  => $post_image_size,
	'image_ratio' => array(
		'width'  => absint( $post_image_ratio_width ),
		'height' => absint( $post_image_ratio_height )
	),
);

if ( $post_layout === 'list' ) {
	$settings['item_skin'] = $list_item_skin;
}
$this->prepare_display( $atts, $query_args, $settings );
$class_to_filter    = implode( ' ', array_filter( $wrapper_classes ) );
$css_class          = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
?>
<div class="<?php echo esc_attr( $css_class ) ?>" <?php echo implode( ' ', $wrapper_attributes ) ?>>
	<?php G5ERE()->listing_agency()->render_content( $this->_query_args, $this->_settings ); ?>
</div>
