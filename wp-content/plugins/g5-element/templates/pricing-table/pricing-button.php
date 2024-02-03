<?php
/**
 *
 * @var $pricing_class
 * @var $custom_onclick
 * @var $custom_onclick_code
 * @var $button_style
 * @var $button_full_width
 * @var $button_size
 * @var $button_text
 * @var $link
 * @var $button_background ,
 * @var $button_text_typography
 * @var $button_hover_color
 * @var $button_text_hover_color
 */

$button_class = 'btn';
// Button style
if ($button_style === 'rounded') {
	$button_class .= ' btn-rounded';
} elseif ($button_style === 'round') {
	$button_class .= ' btn-round';
}

// Button style
if ($button_size === 'small') {
	$button_class .= ' btn-sm';
} elseif ($button_size === 'medium') {
	$button_class .= ' btn-md';
} elseif ($button_size === 'large') {
	$button_class .= ' btn-lg';
}

if ($button_full_width !== '') {
	$button_class .= ' btn-block';
}

$pricing_css = '';
// Button Background
if ($button_background !== '') {
	$pricing_css = <<<CSS
	.{$pricing_class} .pricing-button .btn{
		background-color: $button_background;
		border-color: $button_background;
	}
CSS;
}
G5CORE()->custom_css()->addCss($pricing_css);

// Button Hover
if ($button_hover_color !== '') {
	$pricing_css = <<<CSS
	.{$pricing_class} .pricing-button .btn:hover{
		background-color: $button_hover_color;
	}
CSS;
	G5CORE()->custom_css()->addCss($pricing_css);
}
if ($button_text_hover_color !== '') {
	$pricing_css = <<<CSS
	.{$pricing_class} .pricing-button .btn:hover{
		color: $button_text_hover_color;
	}
CSS;
	G5CORE()->custom_css()->addCss($pricing_css);
}


// Parse link
$link     = ('||' === $link) ? '' : $link;
$link     = vc_build_link($link);
$use_link = false;
if (!empty($link['url'])) {
	$use_link = true;
	$a_href   = $link['url'];
	$a_title  = $link['title'];
	$a_target = $link['target'];
	$a_rel    = $link['rel'];
}

$link_attributes = array();
if ($use_link) {
	$link_attributes[] = 'href="' . esc_url(trim($a_href)) . '"';
	if (empty($a_title)) {
		$a_title = $title;
	}
	$link_attributes[] = 'title="' . esc_attr(trim($a_title)) . '"';
	if (!empty($a_target)) {
		$link_attributes[] = 'target="' . esc_attr(trim($a_target)) . '"';
	}

	if (!empty($a_rel)) {
		$link_attributes[] = 'rel="' . esc_attr(trim($a_rel)) . '"';
	}
}
if ($custom_onclick === 'on' && $custom_onclick_code !== '') {
	$link_attributes[] = 'onclick="' . esc_attr($custom_onclick_code) . '"';
}

$button_text_typography = g5element_typography_class($button_text_typography);
$button_classes         = array($button_class);
if ($button_text_typography !== '') {
	$button_classes[] = $button_text_typography;
}

?>

<div class="pricing-button">
	<?php if (($use_link) && (!empty($button_text))): ?>
		<a class="<?php echo esc_attr(join(' ', $button_classes)) ?>" <?php echo implode(' ', $link_attributes) ?>>
			<?php echo esc_html($button_text) ?>
		</a>
	<?php endif; ?>
</div>
