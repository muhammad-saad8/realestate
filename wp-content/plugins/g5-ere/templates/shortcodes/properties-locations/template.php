<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * Shortcode attributes

 * @var $layout
 * @var $atts
 * @var $el_id
 * @var $el_class
 * @var $css
 * @var $image
 * @var $height_mode
 * @var $banner_class
 * @var $hover_effect
 * @var $hover_image_effect
 * @var $height
 * @var $property_neighborhood
 * @var $property_city
 * @var $property_state
 * @var $width
 * @var $filter_taxonomy
 *

 * Shortcode class
 * @var $this WPBakeryShortCode_G5element_Properties_Locations
 */

$el_id = $el_class = $image = $banner_class = $width  = $height =

$layout = $height_mode = $property_neighborhood = $property_city = $property_state = $filter_taxonomy = $hover_effect = $hover_image_effect =  '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'g5element__properties-location',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$layout,
);

switch ($filter_taxonomy) {
	case "property-city":
		$category_property = get_term_by( 'term_id', $property_city, 'property-city', 'OBJECT' );
		break;
	case "property-state":
		$category_property = get_term_by( 'term_id', $property_state, 'property-state', 'OBJECT' );
		break;
	default:
		$category_property = get_term_by( 'term_id', $property_neighborhood, 'property-neighborhood', 'OBJECT' );
}

$banner_class = 'g5_property-id-' . random_int(1000, 9999);

if (!empty($image)) {
	$image_src = '';
	$image_arr = wp_get_attachment_image_src( $image, 'full' );
	$img_width = $img_height = $height_size = '';
	if ( is_array( $image_arr )) {
		$image_src = isset($image_arr[0]) ? $image_arr[0] : '';
		$img_width = isset($image_arr[1]) ? intval($image_arr[1]) : 0;
		$img_height = isset($image_arr[2]) ? intval($image_arr[2]) : 0;
	} else {
		$img_width = $img_height = 300;
	}
	if ($height_mode != 'custom') {
		if ($height_mode === 'original' && intval($img_width) != 0) {
			$height_mode = ($img_height / $img_width) * 100;
		}
		$image_bg_css = <<<CSS
			.{$banner_class} {
				background-image: url('{$image_src}');
				padding-bottom: {$height_mode}%;
			    background-size: cover;
			}
CSS;
	} else {
		$height_size = ($height / $width) * 100;
		$height = str_replace('|', '', $height);
		$image_bg_css = <<<CSS
			.{$banner_class} {
				background-image: url('{$image_src}');
				padding-bottom: {$height_size}%;
			    background-size: cover;
			}
CSS;
	}
	GSF()->customCss()->addCss($image_bg_css);
}


$class_to_filter    = implode( ' ', array_filter( $wrapper_classes ) );
$css_class          = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts );
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$property_locations_inner = array(
	'g5ere__property-location-content',
);
$property_location_inner = join( ' ', $property_locations_inner );

$image_classes = array(
	'g5core__post-featured-effect',
	'g5core__post-featured'
);

if (!empty($hover_effect)) {
	$image_classes[] =  'effect-' . $hover_effect;
}

if (!empty($hover_image_effect)) {
	$image_classes[] = 'effect-img-' . $hover_image_effect;
}

?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
	<?php $cate_link = get_term_link($category_property, $filter_taxonomy); ?>
	<?php if (!empty($image)): ?>
	<div class="<?php echo implode(' ', $image_classes) ?>">
		<a href="<?php echo esc_url($cate_link); ?>" title="<?php echo esc_attr($category_property->name); ?>" class="gsf-link"></a>
		<div class="g5ere__property-has-images g5core__entry-thumbnail <?php echo esc_attr($banner_class); ?>">
		</div>
	</div>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $property_location_inner ); ?>">
		<?php if (!empty($category_property->name)): ?>
			<h2 class="g5ere__property-locations-title">
				<a href="<?php echo esc_url($cate_link); ?>"><?php echo esc_html($category_property->name); ?></a>
			</h2>
			<p class="g5ere__property-locations-count"><?php echo esc_html($category_property->count); ?> <?php esc_html_e('Properties','g5-ere');?></p>
		<?php endif; ?>
	</div>
</div>




