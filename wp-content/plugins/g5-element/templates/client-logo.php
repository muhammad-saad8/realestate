<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $logo_effect
 * @var $image
 * @var $link
 * @var $image_hover
 * @var $opacity
 * @var $opacity_hover
 *
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $custom_onclick
 * @var $custom_onclick_code
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Client_Logo
 */

$logo_effect = $image = $link = $image_hover = $opacity = $opacity_hover = $css_animation = $animation_duration
	= $animation_delay = $el_class = $css = $custom_onclick = $custom_onclick_code = $responsive = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('client_logo');

$wrapper_classes    = array(
	'gel-client-logo',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
$wrapper_classes[]  = 'gel-client-logo-' . $logo_effect;
$wrapper_attributes = array();
$wrapper_styles     = array();

$image_src = '';
if ($image !== '') {
	$image_arr = wp_get_attachment_image_src($image, 'full');
	if (sizeof($image_arr) > 0 && !empty($image_arr[0])) {
		$image_src = $image_arr[0];
	}
}

if (empty($image) || empty($image_src)) return;

$opacity       = $opacity / 100;
$opacity_hover = $opacity_hover / 100;

$client_logo_class = 'gel-' . uniqid();
$wrapper_classes[] = $client_logo_class;

$client_logo_css = '';
if ($logo_effect == 'faded-effect') {
	$client_logo_css = <<<CSS
		.{$client_logo_class} .image {
			opacity: {$opacity};
		}
		.{$client_logo_class}:hover .image{
			opacity: {$opacity_hover};
		}
CSS;
}

G5CORE()->custom_css()->addCss($client_logo_css);

$link = g5element_build_link($link);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class       = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>

<div class="<?php echo esc_attr($css_class) ?>">
	<div class="gel-client-logo-inner">
		<?php echo $link['before'] ?>
		<div class="image">
			<?php echo wp_get_attachment_image($image,'full') ?>
		</div>
		<?php if (!empty($image_hover) && in_array($logo_effect,array('scaleup-effect','moveup-effect'))): ?>
			<div class="image-hover">
				<?php echo wp_get_attachment_image($image_hover,'full') ?>
			</div>
		<?php endif; ?>
		<?php echo $link['after'] ?>
	</div>
</div>