<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $element UBE_Element_G5ERE_Agent_Singular
 */
$atts = $element->get_settings_for_display();


$agent_id = absint($atts['ids']);
if ($agent_id === 0) return;



$wrapper_classes = array(
	'g5ere__agent-singular',
	"g5ere__agent-singular-{$atts{'post_layout'}}",
);

$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));

$args = array(
	'post_type' => 'agent',
	'post__in' => array($agent_id)
);
$image_ratio = '';
$image_mode = '';

$post_image_size = isset($atts['post_image_size']) ? $atts['post_image_size'] : 'medium';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';

if (isset($post_image_ratio_width) && isset($post_image_ratio_height)) {
	$image_ratio_custom_width = intval($post_image_ratio_width);
	$image_ratio_custom_height = intval($post_image_ratio_height);
	if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
		$image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
	}
}
$settings = array(
	'image_size' => $post_image_size,
	'image_ratio' => $image_ratio,
	'image_mode' => $image_mode,
);

$data = new WP_Query($args);


if (!empty($el_id)) {
	$wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
?>
	<div <?php $element->print_render_attribute_string('wrapper') ?>>
		<?php if ($data->have_posts()) : ?>
			<?php while ($data->have_posts()): $data->the_post(); ?>
				<?php G5ERE()->get_template("shortcodes/agent-singular/layout/{$atts{'post_layout'}}.php", $settings) ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
<?php
wp_reset_query();