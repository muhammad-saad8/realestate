<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $avatar
 * @var $name
 * @var $name_typography
 * @var $job
 * @var $job_typography
 * @var $description
 * @var $description_typography
 * @var $our_team_link
 * @var $socials
 * @var $css_animation
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Our_Team
 */

$layout_style = $avatar = $name = $name_typography = $job = $job_typography = $description =
$description_typography = $our_team_link = $socials = $css_animation = $el_class = $css = $responsive = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('our_team');

$socials = (array)vc_param_group_parse_atts($socials);

$wrapper_classes = array(
	'gel-our-team',
	'gel-our-team-' . $layout_style,
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css)
);
$avatar_class = array(
	'gel-our-team-avatar'
);
if ($layout_style == 'style-01') {
	$avatar_class[] = 'gel-our-team-avatar-circle';
}
$avatar_src = g5core_get_url_by_attachment_id($avatar, $size = 'full');

$name_class = array(
	'gel-our-team-name',
);
$name_typo_class = g5element_typography_class($name_typography);
if ($name_typo_class !== '') {
	$name_class[] = $name_typo_class;
}

$job_class = array(
	'gel-our-team-job',
);
$job_typo_class = g5element_typography_class($job_typography);
if ($job_typo_class !== '') {
	$job_class[] = $job_typo_class;
}

$description_class = array(
	'gel-our-team-description',
);
$description_typo_class = g5element_typography_class($description_typography);
if ($description_typo_class !== '') {
	$description_class[] = $description_typo_class;
}

$our_team_links = g5element_build_link($our_team_link);

$social_networks = G5CORE()->options()->get_option('social_networks');
$social_networks_configs = array();
if (is_array($social_networks)) {
	foreach ($social_networks as $social_network) {
		$social_networks_configs[$social_network['social_id']] = $social_network;
	}
}
$social_attributes = array(
	'class' => 'gel-our-team-social',
);

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
	<?php if (!empty($avatar_src)): ?>
		<div class="<?php echo implode(' ', $avatar_class); ?>">
			<img alt="<?php echo esc_attr($name); ?>" src="<?php echo esc_url($avatar_src) ?>">
			<?php if (!empty($socials) && $layout_style === 'style-02') : ?>
				<div class="gel-our-team-socials">
					<?php foreach ($socials as $data) {
						$social_network = $social_networks_configs[$data['social_icons']];
						$link = isset($data['social_link']) ? $data['social_link'] : '';
						$title_link = g5element_build_link($link, $social_attributes);
						$link = vc_build_link($link);
						if (empty($link['url']))
							continue;
						?>
						<?php echo wp_kses_post($title_link['before']) ?>
						<i class="<?php echo esc_attr($social_network['social_icon']) ?>"></i>
						<?php echo wp_kses_post($title_link['after']) ?>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if (!empty($name) || !empty($job) || !empty($description) || !empty($socials)): ?>
		<div class="gel-our-team-inner">
			<?php if (!empty($name)): ?>
				<h4 class="<?php echo esc_attr(implode(' ', $name_class)); ?>">
					<?php echo wp_kses_post($our_team_links['before'])  ?>
					<?php echo esc_html($name); ?>
					<?php echo wp_kses_post($our_team_links['after']) ?>
				</h4>
			<?php endif; ?>
			<?php if (!empty($job)): ?>
				<p class="<?php echo esc_attr(implode(' ', $job_class)); ?>"><?php echo esc_html($job); ?></p>
			<?php endif; ?>
			<?php if (!empty($description)): ?>
				<p class="<?php echo esc_attr(implode(' ', $description_class)); ?>"><?php echo esc_html($description); ?></p>
			<?php endif; ?>
			<?php if (!empty($socials) && $layout_style === 'style-01') : ?>
				<div class="gel-our-team-socials">
					<?php foreach ($socials as $data) {
						$social_network = $social_networks_configs[$data['social_icons']];
						$link = isset($data['social_link']) ? $data['social_link'] : '';
						$title_link = g5element_build_link($link, $social_attributes);
						$link = vc_build_link($link);
						if (empty($link['url']))
							continue;
						?>
						<?php echo wp_kses_post($title_link['before']) ?>
						<i class="<?php echo esc_attr($social_network['social_icon']) ?>"></i>
						<?php echo wp_kses_post($title_link['after'])?>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>