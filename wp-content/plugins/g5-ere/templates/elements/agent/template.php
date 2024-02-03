<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $element UBE_Element_G5ERE_Agent
 */
$atts = $element->get_settings_for_display();
$wrapper_classes = array(
	'g5element__agent',
);

$element->set_render_attribute('wrapper', array(
	'class'=> $wrapper_classes
));

$query_args      = array(
	'post_type' => 'agent',
);

$post_layout = isset($atts['post_layout']) ? $atts['post_layout'] : 'grid';
$list_item_skin = isset($atts['list_item_skin']) ? $atts['list_item_skin'] : 'skin-list-01';
$post_image_size = isset($atts['post_image_size']) ? $atts['post_image_size'] : 'medium';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';


$settings = array(
	'image_size'  => $post_image_size,
	'image_ratio' => array(
		'width'  => absint( $post_image_ratio_width ),
		'height' => absint( $post_image_ratio_height )
	),
);
if ($post_layout === 'list') {
	$settings['item_skin'] = $list_item_skin;
}

$element->prepare_display($atts, $query_args, $settings);
?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php G5ERE()->listing_agent()->render_content($element->_query_args, $element->_settings); ?>
</div>
