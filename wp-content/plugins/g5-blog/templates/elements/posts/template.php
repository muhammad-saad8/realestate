<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $element UBE_Element_G5Blog_Posts
 */
$atts = $element->get_settings_for_display();
$wrapper_classes = array(
	'ube__posts',
);

$element->set_render_attribute('wrapper', array(
	'class'=> $wrapper_classes
));

$query_args = array(
);

$post_layout = isset($atts['post_layout']) ? $atts['post_layout'] : 'grid';
$post_image_size = isset($atts['post_image_size']) ? $atts['post_image_size'] : 'medium';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';
$post_image_width = isset($atts['post_image_width']) ? $atts['post_image_width'] : '400';
$excerpt_enable = isset($atts['excerpt_enable']) ? $atts['excerpt_enable'] : 'on';

$settings = array(
	'post_layout' => $post_layout,
	'image_size' => $post_image_size,
	'image_ratio' => array(
		'width' => $post_image_ratio_width,
		'height' => $post_image_ratio_height
	),
	'image_width' => array(
		'width' => intval($post_image_width)
	),
	'excerpt_enable' => $excerpt_enable
);

$element->prepare_display($atts,$query_args,$settings);

?>
<div <?php echo $element->get_render_attribute_string('wrapper') ?>>
	<?php G5BLOG()->listing()->render_content($element->_query_args, $element->_settings); ?>
</div>