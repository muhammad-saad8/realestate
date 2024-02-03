<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $element UBE_Element_G5ERE_Agent_Slider
 */
$atts = $element->get_settings_for_display();

$wrapper_classes = array(
	'g5element__agent-carousel',
	"g5element__agent-carousel-{$atts['item_skin']}",
);

$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));


$post_image_size = isset($atts['post_image_size']) ? $atts['post_image_size'] : 'medium';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';

$query_args = array(
	'post_type' => 'agent',
);

$settings = array(
	'post_layout' => 'grid',
	'image_size' => $post_image_size,
	'image_ratio' => array(
		'width' => absint($post_image_ratio_width),
		'height' => absint($post_image_ratio_height)
	),
);

$atts['slider'] = true;

$element->prepare_display($atts, $query_args, $settings);


?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php G5ERE()->listing_agent()->render_content($element->_query_args, $element->_settings); ?>
</div>