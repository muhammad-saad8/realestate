<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $social_shape
 * @var $social_size
 * @var $social_align
 * @var $icon_color
 * @var $icon_hover_color
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Social_Icons
 */
$social_shape = $social_size = $social_align = $icon_color = $icon_hover_color = '';
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';

$atts         = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('social_icons');

$wrapper_classes = array(
	'gel-social-icons',
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
$social_icons = array();
$social_networks = G5CORE()->options()->get_option('social_networks', array());
$social_ids = array();
foreach ($social_networks as $social) {
	$social_ids[] = $social['social_id'];
}
$social_networks = array_combine($social_ids, $social_networks);
foreach ($social_networks as $social_network) {
	if ($social_network['social_link'] !== '') {
		$social_icons[] = $social_network['social_id'];
	}
}
if (count($social_icons) === 0) return;
$icon_classes = array(
	'list-si',
	"si-{$social_size}",
	"si-{$social_align}"
);
if (in_array($social_shape, array('circle', 'circle-outline', 'square', 'square-outline'))) {
	$icon_classes[] = 'si-shape';
} else {
	$icon_classes[] = "si-{$social_shape}";
}
if (in_array($social_shape, array('circle', 'circle-outline'))) {
	$icon_classes[] = 'si-circle';
}
if (in_array($social_shape, array('square', 'square-outline'))) {
	$icon_classes[] = 'si-square';
}
if (in_array($social_shape, array('circle-outline', 'square-outline'))) {
	$icon_classes[] = 'si-outline';
}

$social_icons_class = 'gel-' . uniqid();
$social_icons_css   = '';

if ($icon_color !== '') {
	if (!g5core_is_color($icon_color)) {
		$icon_color = g5core_get_color_from_option($icon_color);
	}
	$icon_color_text = g5core_color_contrast($icon_color);


	if ($icon_hover_color === '') {
		$icon_hover_color = g5core_color_darken($icon_color, '15%');
	}
	else {
		if (!g5core_is_color($icon_hover_color)) {
			$icon_hover_color = g5core_get_color_from_option($icon_hover_color);
		}
	}
}

if ($icon_color !== '') {
	$social_icons_css .= ".{$social_icons_class} li{ color: {$icon_color}}";
	$social_icons_css .= ".{$social_icons_class} li i{ color: {$icon_color_text}}";
	$social_icons_css .= ".{$social_icons_class} li:hover { color: {$icon_hover_color}}";
}
else {
	foreach ($social_icons as $social_id) {
		$social_network = $social_networks[$social_id];
		$social_color       = $social_network['social_color'];
		$social_hover_color = g5core_color_darken($social_color);

		$social_icons_css .= ".{$social_icons_class} li.{$social_id}{ color: {$social_color}}";
		$social_icons_css .= ".{$social_icons_class} li.{$social_id}:hover { color: {$social_hover_color}}";
	}
}

if ($social_icons_css !== '') {
	$icon_classes[] = $social_icons_class;
	G5CORE()->custom_css()->addCss($social_icons_css);
}

$icon_classes = implode(' ', $icon_classes);

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class       = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
	<ul class="<?php echo esc_attr($icon_classes) ?>">
		<?php foreach ($social_icons as $social_id): ?>
			<?php
			$social_network = $social_networks[$social_id];
			if ($social_id === 'social-email') {
				$social_network['social_link'] = 'mailto:' . $social_network['social_link'];
			}
			?>
			<li class="<?php echo esc_attr($social_id) ?> ">
				<a target="_blank"
				   title="<?php echo esc_attr($social_network['social_name']) ?>"
				   href="<?php echo esc_url($social_network['social_link']) ?>">
					<span>
						<i class="<?php echo esc_attr($social_network['social_icon']) ?>"></i>
						<span><?php echo esc_html($social_network['social_name']) ?></span>
					</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>