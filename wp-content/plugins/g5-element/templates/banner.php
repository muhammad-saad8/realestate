<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $image
 * @var $banner_title
 * @var $title_typography
 * @var $banner_description
 * @var $description_typography
 * @var $hover_effect
 * @var $hover_image_effect
 * @var $size_mode
 * @var $hover_mode
 * @var $width
 * @var $height
 * @var $banner_btn_title
 * @var $link
 * @var $button_style
 * @var $button_shape
 * @var $button_size
 * @var $button_color
 * @var $button_is_3d
 * @var $content
 * @var $css_animation
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_G5Element_Banner
 */

$layout_style = $image = $banner_title = $title_typography = $banner_description = $description_typography =
$hover_effect = $hover_image_effect = $size_mode = $hover_mode = $width = $height = $banner_btn_title = $link =
$button_style = $button_shape = $button_size = $button_color = $button_is_3d = $css_animation = $el_class = $css = $responsive = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

G5ELEMENT()->assets()->enqueue_assets_for_shortcode( 'banner' );

$wrapper_classes = array(
	'gel-banner',
	'gel-banner-' . $layout_style,
	$this->getExtraClass( $el_class ),
	$this->getCSSAnimation( $css_animation ),
	vc_shortcode_custom_css_class( $css )
);

if ( $hover_mode !== '' ) {
	$wrapper_classes[] = 'gel-banner-' . $hover_mode;
}

if ( $hover_image_effect !== '' || $hover_effect !== '' ) {
	$wrapper_classes[] = 'gel-image-effectr-wrap';
}

$hover_classes = array(
	'gel-image-effect',
	$hover_effect,
);

if ( ! empty( $hover_image_effect ) ) {
	$hover_classes[] = 'gel-image-effect-img-' . $hover_image_effect;
}

$title_class      = array(
	'gel-banner-title',
);
$title_typo_class = g5element_typography_class( $title_typography );
if ( $title_typo_class !== '' ) {
	$title_class[] = $title_typo_class;
}

$description_class      = array(
	'gel-banner-description',
);
$description_typo_class = g5element_typography_class( $description_typography );
if ( $description_typo_class !== '' ) {
	$description_class[] = $description_typo_class;
}

$title_link = g5element_build_link( $link );

$banner_class      = uniqid( 'gel-' );
$banner_bg_css     = '';
$banner_bg_attributes = array();
$banner_bg_classes = array(
	'gel-banner-bg',
	'gel-effect-content'
);
if ( ! empty( $image ) ) {
	$image_src = '';
	$image_arr = wp_get_attachment_image_src( $image, 'full' );
	$img_width = $img_height = '';
	if ( is_array( $image_arr ) && ! empty( $image_arr[0] ) ) {
		$image_src  = $image_arr[0];
		$img_width  = isset( $image_arr[1] ) ? intval( $image_arr[1] ) : 0;
		$img_height = isset( $image_arr[2] ) ? intval( $image_arr[2] ) : 0;
	}

	if ( empty( $image_src ) ) {
		$image_src  = G5CORE()->plugin_url( 'assets/images/default-thumbnail.png' );
		$img_width  = 420;
		$img_height = 420;
	}


	$image_size_percent = $size_mode;
	if ( $size_mode != 'custom' ) {
		if ( $size_mode === 'original' && intval( $img_width ) != 0 ) {
			$image_size_percent = ( $img_height / $img_width ) * 100;
		}
	} else {

		$height             = (float) $height;
		$width              = (float) $width;
		$image_size_percent = ( $height / $width ) * 100;
	}


	$image_lazy_load_enable = G5CORE()->options()->get_option( 'image_lazy_load_enable' );
	if ( $image_lazy_load_enable === 'on' ) {
		$banner_bg_classes[] = 'g5core__ll-background';
		$banner_bg_attributes[] = sprintf('data-bg="%s"',$image_src);
	}
	$banner_bg_css = <<<CSS
	    .{$banner_class} .gel-banner-bg {
	        background-image: url('{$image_src}');
	        padding-bottom: {$image_size_percent}%;
	    }
CSS;


}

$banner_bg_attributes[] = sprintf('class="%s"', join(' ', $banner_bg_classes));
G5Core()->custom_css()->addCss( $banner_bg_css );
$wrapper_classes[] = $banner_class;
$class_to_filter   = implode( ' ', array_filter( $wrapper_classes ) );
$css_class         = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
?>
<?php if ( ! empty( $image ) ): ?>
	<div class="<?php echo esc_attr( $css_class ) ?>">
		<div class="gel-effect-bg-image <?php echo join( ' ', $hover_classes ); ?>">
			<div <?php echo join(' ', $banner_bg_attributes)?>>
				<?php if ( ( empty( $banner_title ) || ( $layout_style === 'style-07' ) ) ):
					echo $title_link['before'];
					echo $title_link['after'];
				endif; ?>
			</div>
		</div>
		<?php if ( $layout_style == 'style-07' && ! empty( $content ) ): ?>
			<div class="gel-banner-content">
				<?php echo wpb_js_remove_wpautop( $content, true ); ?>
			</div>
		<?php else: ?>
			<div class="gel-banner-content">
				<?php if ( ! empty( $banner_title ) ): ?>
					<h4 class="<?php echo implode( ' ', $title_class ); ?>">
						<?php echo $title_link['before'] ?>
						<?php echo wp_kses_post( $banner_title ); ?>
						<?php echo $title_link['after'] ?>
					</h4>
				<?php endif; ?>
				<?php if ( ! empty( $banner_description ) ): ?>
					<p class="<?php echo implode( ' ', $description_class ); ?>"><?php echo wp_kses_post( $banner_description ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $banner_btn_title ) ): ?>
					<div class="gel-banner-action">
						<?php g5element_render_button( $banner_btn_title, $link, $button_style, $button_shape, $button_size, $button_color, $button_is_3d ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>