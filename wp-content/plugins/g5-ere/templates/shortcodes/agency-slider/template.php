<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $posts_per_page
 * @var $sorting
 * @var $agency
 * @var $ids
 * @var $item_skin
 *
 * @var $show
 * @var $slider_pagination_enable
 * @var $slider_navigation_enable
 * @var $slider_auto_height_enable
 * @var $slider_loop_enable
 * @var $slider_autoplay_enable
 * @var $slider_autoplay_timeout
 * @var $columns_gutter
 * @var $post_animation
 * @var $post_image_size
 * @var $post_image_ratio_width
 * @var $post_image_ratio_height
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $item_custom_class
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_agent_Slider
 */

$posts_per_page = $columns_gutter = $agency = $item_custom_class = $show = $ids = $item_skin =
$el_id = $el_class = $sorting = $columns_xl = $columns_lg = $columns_md = $columns_sm = $columns = $post_animation =
$slider_rows = $slider_pagination_enable = $slider_navigation_enable = $slider_center_enable = $slider_center_padding = $slider_auto_height_enable = $slider_loop_enable = $slider_autoplay_enable = $slider_autoplay_timeout =
$post_image_size = $post_image_ratio_width = $post_image_ratio_height =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts           = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$wrapper_classes = array(
	'g5element__agency g5element__agency-carousel',
	"g5element__agency-carousel-{$item_skin}",
	$this->getExtraClass( $el_class ),
	$this->getCSSAnimation( $css_animation ),
	vc_shortcode_custom_css_class( $css ),
);

$query_args = array(
	'taxonomy' => 'agency'
);

$settings = array(
	'post_layout' => 'grid',
	'image_size'  => $post_image_size,
	'image_ratio' => array(
		'width'  => absint( $post_image_ratio_width ),
		'height' => absint( $post_image_ratio_height )
	),
);

$atts['slider'] = true;
$this->prepare_display( $atts, $query_args, $settings );
$class_to_filter    = implode( ' ', array_filter( $wrapper_classes ) );
$css_class          = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
?>
<div class="<?php echo esc_attr( $css_class ) ?>" <?php echo implode( ' ', $wrapper_attributes ) ?>>
	<?php G5ERE()->listing_agency()->render_content(  $this->_query_args, $this->_settings ); ?>
</div>
