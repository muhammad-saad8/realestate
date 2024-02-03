<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $element UBE_Element_G5ERE_Properties_Slider
 */
$atts            = $element->get_settings_for_display();
$layout          = isset( $atts['layout'] ) ? $atts['layout'] : 'layout-01';
$wrapper_classes = array(
	'g5element__properties-slider',
	$layout
);

$element->set_render_attribute( 'wrapper', array(
	'class' => $wrapper_classes
) );

$query_args = array(
	'post_type' => 'property',
);

$post_image_size         = isset( $atts['post_image_size'] ) ? $atts['post_image_size'] : 'medium';
$post_image_ratio_width  = isset( $atts['post_image_ratio_width'] ) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset( $atts['post_image_ratio_height'] ) ? $atts['post_image_ratio_height'] : '';


$image_ratio        = '';
$image_ratio_width  = absint( $post_image_ratio_width );
$image_ratio_height = absint( $post_image_ratio_height );

if ( ( $image_ratio_width > 0 ) && ( $image_ratio_height > 0 ) ) {
	$image_ratio = "{$image_ratio_width}x{$image_ratio_height}";
}

$slider_pagination_enable  = isset( $atts['slider_pagination_enable'] ) ? $atts['slider_pagination_enable'] : 'on';
$slider_navigation_enable  = isset( $atts['slider_navigation_enable'] ) ? $atts['slider_navigation_enable'] : '';
$slider_loop_enable        = isset( $atts['slider_loop_enable'] ) ? $atts['slider_loop_enable'] : '';
$slider_auto_height_enable = isset( $atts['slider_auto_height_enable'] ) ? $atts['slider_auto_height_enable'] : 'on';
$slider_autoplay_enable    = isset( $atts['slider_autoplay_enable'] ) ? $atts['slider_autoplay_enable'] : '';
$slider_autoplay_timeout   = isset( $atts['slider_autoplay_timeout'] ) ? $atts['slider_autoplay_timeout'] : 5000;

$slick_options = array(
	'slidesToShow'   => 1,
	'slidesToScroll' => 1,
	'arrows'         => $slider_navigation_enable === 'on',
	'dots'           => $slider_pagination_enable === 'on',
	'infinite'       => $slider_loop_enable === 'on',
	'adaptiveHeight' => $slider_auto_height_enable === 'on',
	'autoplay'       => $slider_autoplay_enable === 'on',
	'autoplaySpeed'  => absint( $slider_autoplay_timeout ),
	'draggable'      => true,
);

$settings = array(
	'image_size'  => $post_image_size,
	'image_ratio' => $image_ratio,
);

$atts['slider'] = true;
$element->prepare_display( $atts, $query_args, $settings );
$the_query = new WP_Query( $element->_query_args );

$height         = isset( $atts['height'] ) ? $atts['height'] : array(
	'xl' => '',
	'lg' => '',
	'md' => '',
	'sm' => '',
	'xs' => ''
);
$_height_mode = (isset($height['xl']) && $height['xl'] == '-1') ? 'full-screen' : 'custom';
$_height = (($_height_mode === 'custom') && isset($height['xl'])) ? $height['xl'] : '';

$height_options = array(
	'height_mode' => $_height_mode,
	'height' => $_height,
	'responsive' => array(
	)
);

if (isset($height['lg']) && ($height['lg'] !== '')) {
	$_height_mode_lg = (isset($height['lg']) && $height['lg'] == '-1') ? 'full-screen' : 'custom';
	$_height_lg = (($_height_mode_lg === 'custom') && isset($height['lg'])) ? $height['lg'] : '';
	$height_options['responsive'][] = array(
		'breakpoint' => 1200,
		'settings'   => array(
			'height_mode'   => $_height_mode_lg,
			'height' => $_height_lg
		)
	);
}

if (isset($height['md']) && ($height['md'] !== '')) {
	$_height_mode_md = (isset($height['md']) && $height['md'] == '-1') ? 'full-screen' : 'custom';
	$_height_md = (($_height_mode_md === 'custom') && isset($height['md'])) ? $height['md'] : '';
	$height_options['responsive'][] = array(
		'breakpoint' => 992,
		'settings'   => array(
			'height_mode'   => $_height_mode_md,
			'height' => $_height_md
		)
	);
}

if (isset($height['sm']) && ($height['sm'] !== '')) {
	$_height_mode_sm = (isset($height['sm']) && $height['sm'] == '-1') ? 'full-screen' : 'custom';
	$_height_sm = (($_height_mode_sm === 'custom') && isset($height['sm'])) ? $height['sm'] : '';
	$height_options['responsive'][] = array(
		'breakpoint' => 768,
		'settings'   => array(
			'height_mode'   => $_height_mode_sm,
			'height' => $_height_sm
		)
	);
}

if (isset($height['xs']) && ($height['xs'] !== '')) {
	$_height_mode_xs = (isset($height['xs']) && $height['sm'] == '-1') ? 'full-screen' : 'custom';
	$_height_xs = (($_height_mode_xs === 'custom') && isset($height['xs'])) ? $height['xs'] : '';
	$height_options['responsive'][] = array(
		'breakpoint' => 576,
		'settings'   => array(
			'height_mode'   => $_height_mode_xs,
			'height' => $_height_xs
		)
	);
}



?>
<div <?php $element->print_render_attribute_string( 'wrapper' ) ?>>
	<?php if ( $the_query->have_posts() ): ?>
		<div id="<?php echo esc_attr( uniqid( 'g5ere__psi' ) ) ?>" data-toggle="g5ere__psh"
		     data-g5ere__psh-options="<?php echo esc_attr( json_encode( $height_options ) ) ?>"
		     class="g5element__properties-slider-inner g5core__gutter-0 slick-slider"
		     data-slick-options="<?php echo esc_attr( json_encode( $slick_options ) ) ?>">
			<?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
				<?php G5ERE()->get_template( "shortcodes/properties-slider/layout/{$layout}.php", $settings ) ?>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
