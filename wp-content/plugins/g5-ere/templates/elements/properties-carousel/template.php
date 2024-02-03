<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $element UBE_Element_G5ERE_Properties
 */
$atts = $element->get_settings_for_display();
$wrapper_classes = array(
	'g5element__properties-carousel',
);

$element->set_render_attribute('wrapper', array(
	'class'=> $wrapper_classes
));

$query_args = array(
	'post_type' => 'property',
);

$post_image_size = isset($atts['post_image_size']) ? $atts['post_image_size'] : 'medium';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';
$taxonomy_filter_enable = isset($atts['taxonomy_filter_enable']) ? $atts['taxonomy_filter_enable'] : '';
$taxonomy_filter_align = isset($atts['taxonomy_filter_align']) ? $atts['taxonomy_filter_align'] : '';
$taxonomy_filter = isset($atts['taxonomy_filter']) ? $atts['taxonomy_filter'] : 'property-status';
$property_status = isset($atts['property_status']) ? $atts['property_status'] : '';
$property_type = isset($atts['property_type']) ?  $atts['property_type'] : '';
$property_label = isset($atts['property_label']) ?  $atts['property_label'] : '';

$settings = array(
	'post_layout' => 'grid',
	'image_size' => $post_image_size,
	'image_ratio' => array(
		'width' => absint($post_image_ratio_width),
		'height' => absint($post_image_ratio_height)
	),
	'cate_filter_enable' =>    $taxonomy_filter_enable === 'on',
	'cate_filter_align' => $taxonomy_filter_align,
	'taxonomy' => $taxonomy_filter
);

if ($taxonomy_filter_enable === 'on') {
	if (($taxonomy_filter === 'property-status') && !empty($property_status)) {
		$settings['cate'] = array_filter(explode(',',$property_status),'absint');
	}

	if (($taxonomy_filter === 'property-type') && !empty($property_type)) {
		$settings['cate'] = array_filter(explode(',',$property_type),'absint');
	}

	if (($taxonomy_filter === 'property-label') && !empty($property_label)) {
		$settings['cate'] = array_filter(explode(',',$property_label),'absint');
	}
}
$atts['slider'] = true;
$element->prepare_display($atts, $query_args, $settings);
?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php G5ERE()->listing()->render_content($element->_query_args, $element->_settings); ?>
</div>
