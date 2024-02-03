<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $image
 * @var $name
 * @var $price
 * @var $currency_code
 * @var $duration
 * @var $background
 * @var $border_color
 *
 * @var $name_typography
 * @var $price_typography
 * @var $currency_code_typography
 * @var $duration_typography
 *
 * @var $is_featured
 * @var $featured_text
 * @var $featured_item_color
 * @var $featured_text_color
 *
 * @var $list_style
 * @var $list_align
 * @var $list_icon
 * @var $prefix_list_desc_size
 * @var $prefix_list_desc_color
 * @var $desc_typography
 * @var $list_features
 * @var $list_padding_bottom
 *
 * @var $button_title
 * @var $button_style
 * @var $button_shape
 * @var $button_size
 * @var $button_color
 * @var $button_is_3d
 * @var $link
 *
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Pricing_Table
 */
$layout_style = $image = $name = $price = $currency_code = $duration = $background = $border_color
	= $name_typography = $price_typography = $currency_code_typography = $duration_typography
	= $is_featured = $featured_text = $featured_item_color = $featured_text_color
	= $list_style = $list_align = $list_icon
	= $prefix_list_desc_size = $prefix_list_desc_color = $desc_typography = $list_features = $list_padding_bottom
	= $button_title = $button_style = $button_shape = $button_size = $button_color = $button_is_3d = $link
	= $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

G5ELEMENT()->assets()->enqueue_assets_for_shortcode('pricing_table');

$wrapper_classes = array(
	'gel-pricing',
	'gel-pricing-' . $layout_style,
	$this->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

$pricing_class     = 'gel-' . uniqid();
$wrapper_classes[] = $pricing_class;

$pricing_css = '';
if ($background !== '') {
	if (!g5core_is_color($background)) {
		$background = g5core_get_color_from_option($background);
	}
	$pricing_css .= <<<CSS
	.{$pricing_class}{
		background-color: $background;
		}
CSS;
}

if ($border_color !== '') {
	if (!g5core_is_color($border_color)) {
		$border_color = g5core_get_color_from_option($border_color);
	}
	$pricing_css .= <<<CSS
	.{$pricing_class}{
		border-color: $border_color;
	}
	.{$pricing_class}.gel-pricing-style-5 .pricing-name:after {
		background-color: $border_color;
	}
CSS;
}

// Get Image
$image_src = '';
$img_title = '';
if ($image !== '') {
	$image_src = g5core_get_url_by_attachment_id($image, 'full');
	$img_title = get_the_title($image);
}

// Min height
$list_padding_bottom = intval($list_padding_bottom);
if ($list_padding_bottom != 0) {
	$pricing_css .= <<<CSS
	.{$pricing_class} .pricing-list {
    padding-bottom: {$list_padding_bottom}px;
}
CSS;
}

// Is featured?
if ($is_featured === 'on') {
	$wrapper_classes[] = 'is-featured';
	if ($featured_text_color !== '') {
		if (!g5core_is_color($featured_text_color)) {
			$featured_text_color = g5core_get_color_from_option($featured_text_color);
		}
		$pricing_css .= <<<CSS
		.{$pricing_class}.is-featured .pricing-featured-text{
			color: $featured_text_color;
		}
CSS;
	}
	if ($featured_item_color !== '') {
		if (!g5core_is_color($featured_item_color)) {
			$featured_item_color = g5core_get_color_from_option($featured_item_color);
		}
		$pricing_css .= <<<CSS
		.{$pricing_class} .pricing-featured-text{
			background-color: $featured_item_color;
		}
CSS;
	}
}
if ($pricing_css !== '') {
	G5CORE()->custom_css()->addCss($pricing_css);
}

// List features
$list_features   = (array)vc_param_group_parse_atts($list_features);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class       = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>

<div class="<?php echo esc_attr($css_class) ?>">
	<div class="pricing-wrap-top">
		<?php G5ELEMENT()->get_template('pricing-table/pricing-desc.php',
			array(
				'name'            => $name,
				'name_typography' => $name_typography,
				'image_src'       => $image_src,
				'layout_style'    => $layout_style,
				'img_title'       => $img_title
			)
		); ?>

		<?php if ($layout_style !== 'style-3'): ?>
			<?php G5ELEMENT()->get_template('pricing-table/pricing-price.php',
				array(
					'currency_code_typography' => $currency_code_typography,
					'currency_code'            => $currency_code,
					'price_typography'         => $price_typography,
					'price'                    => $price,
					'duration_typography'      => $duration_typography,
					'duration'                 => $duration,
					'layout_style'             => $layout_style
				)
			); ?>
		<?php endif; ?>

		<?php if ($is_featured === 'on' && !empty($featured_text)): ?>
			<div class="pricing-featured-text">
				<span><?php echo esc_html($featured_text) ?></span>
			</div>
		<?php endif; ?>

		<?php if ($layout_style === 'style-2' && $button_title !== ''): ?>
			<div class="pricing-button">
				<?php
				g5element_render_button($button_title, $link, $button_style, $button_shape, $button_size, $button_color, $button_is_3d);
				?>
			</div>
		<?php endif; ?>
	</div>

	<div class="pricing-features">
		<?php G5ELEMENT()->get_template('pricing-table/pricing-features.php',
			array(
				'pricing_class'          => $pricing_class,
				'list_features'          => $list_features,
				'list_style'             => $list_style,
				'list_icon'              => $list_icon,
				'desc_typography'        => $desc_typography,
				'prefix_list_desc_size'  => $prefix_list_desc_size,
				'prefix_list_desc_color' => $prefix_list_desc_color,
				'list_align'             => $list_align,
			)
		); ?>
	</div>

	<?php if ($layout_style === 'style-3'): ?>
		<?php G5ELEMENT()->get_template('pricing-table/pricing-price.php',
			array(
				'currency_code_typography' => $currency_code_typography,
				'currency_code'            => $currency_code,
				'price_typography'         => $price_typography,
				'price'                    => $price,
				'duration_typography'      => $duration_typography,
				'duration'                 => $duration,
			)
		); ?>
	<?php endif; ?>

	<?php if ($layout_style !== 'style-2' && $button_title !== ''): ?>
		<div class="pricing-button">
			<?php
			g5element_render_button($button_title, $link, $button_style, $button_shape, $button_size, $button_color, $button_is_3d);
			?>
		</div>
	<?php endif; ?>
</div>