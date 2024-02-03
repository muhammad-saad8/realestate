<?php
// Do not allow directly accessing this file.
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $element UBE_Element_G5ERE_Properties_Locations
 * @var $item_key
 * @var $taxonomy_filter
 * @var $image_url
 * @var $category_link
 * @var $category_name
 * @var $category_count
 * @var $image_styles
 */


$settings        = $element->get_settings_for_display();
$layout = isset($settings['layout']) ? $settings['layout'] : 'layout-01';
if (!isset($item_key)) {
	$item_key = '';
}

$wrapper_classes = array(
	'g5element__properties-location',
	"wrapper-{$item_key}",
	$layout
);

if ( ! empty( $image_url ) ) {
	$image_wrapper_classes = array(
		'g5core__post-featured-effect',
		'g5core__post-featured'
	);

	$hover_effect = isset( $settings['hover_effect'] ) ? $settings['hover_effect'] : '';
	if ( ! empty( $hover_effect ) ) {
		$image_wrapper_classes[] = 'effect-' . $hover_effect;
	}

	$hover_image_effect = isset($settings['hover_image_effect']) ?  $settings['hover_image_effect'] : '';
	if (!empty($hover_image_effect)) {
		$image_wrapper_classes[] = 'effect-img-' . $hover_image_effect;
	}

	$element->set_render_attribute( 'image_wrapper', array(
		'class' => $image_wrapper_classes
	) );

	$image_classes = array( 'g5ere__property-has-images', 'g5core__entry-thumbnail' );
	$element->set_render_attribute( 'image', array(
		'class' => $image_classes,
		'style' => join( ';', $image_styles ),
	) );
}

$element->set_render_attribute( 'wrapper', array(
	'class' => $wrapper_classes
) );

?>

<div class="g5element__properties-location-wrapper">
	<div <?php $element->print_render_attribute_string( 'wrapper' ) ?>>
		<?php if ( ! empty( $image_url ) ): ?>
			<div <?php $element->print_render_attribute_string( 'image_wrapper' ) ?>>
				<a href="<?php echo esc_url( $category_link ); ?>" title="<?php echo esc_attr( $category_name ); ?>"
				   class="gsf-link"></a>
				<div <?php $element->print_render_attribute_string( 'image' ) ?>>
				</div>
			</div>
		<?php endif; ?>
		<div class="g5ere__property-location-content">
			<h2 class="g5ere__property-locations-title">
				<a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category_name); ?></a>
			</h2>
			<p class="g5ere__property-locations-count"><?php echo esc_html($category_count); ?> <?php esc_html_e('Properties','g5-ere');?></p>
		</div>
	</div>
</div>
