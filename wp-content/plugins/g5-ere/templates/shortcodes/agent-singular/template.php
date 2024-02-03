<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $id
 * @var $el_id
 * @var $el_class
 * @var $layout
 * @var $post_image_size
 * @var $post_image_ratio_width
 * @var $post_image_ratio_height
 * @var $animation_style
 * @var $animation_duration
 * @var $animation_delay
 * @var $css_editor
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Agent_Singular
 */
$el_id = $el_class = $id = $layout =
$post_image_size = $post_image_ratio_width = $post_image_ratio_height =
$animation_style = $animation_duration = $animation_delay = $css_editor = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$agent_id = absint($id);
if ($agent_id === 0) return;
$wrapper_classes = array(
	'g5ere__agent-singular',
	"g5ere__agent-singular-{$layout}",
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css)
);


$args = array(
	'post_type' => 'agent',
	'post__in' => array($agent_id)
);
$image_ratio = '';
$image_mode = '';
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
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
$wrapper_attributes = array();
if (!empty($el_id)) {
	$wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}
?>
<div class="<?php echo esc_attr($css_class) ?>" <?php echo implode(' ', $wrapper_attributes) ?>>
	<?php if ($data->have_posts()) : ?>
		<?php while ($data->have_posts()): $data->the_post(); ?>
			<?php G5ERE()->get_template("shortcodes/agent-singular/layout/{$layout}.php", $settings) ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>
<?php
wp_reset_query();