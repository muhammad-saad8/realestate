<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $image_size
 * @var $image_ratio
 *
 */
$wrapper_classes = array(
	'g5ere__property-slider-item',
	'd-flex',
	'flex-column'

);

$thumbnail_data = g5core_get_thumbnail_data( array(
	'image_size'  => 'full',
	'placeholder' => 'on'
));

$post_inner_classes = array(
	'g5ere__psi-inner',
	'g5ere__psi-hero',
	'position-relative',
	'text-light',
	'd-flex',
	'align-items-center'
);

$post_inner_attributes = array(
);

if ($thumbnail_data['url'] !== '') {
	$post_inner_attributes[] = sprintf( 'style="background-image:url(%s)"', esc_url( $thumbnail_data['url'] ) );
}

$post_inner_class = implode(' ', $post_inner_classes);
$wrapper_class = implode(' ', $wrapper_classes);
?>
<article <?php post_class($wrapper_class) ?>>
	<div <?php echo join( ' ', $post_inner_attributes ) ?> class="<?php echo esc_attr($post_inner_class)?>">
		<div class="container">
			<div class="g5ere__psi-content">
				<?php
				/**
				 * Hook: g5ere_loop_property_slider_content_layout_04.
				 *
				 * @hooked g5ere_template_loop_property_title - 5
				 * @hooked g5ere_template_loop_property_address - 10
				 * @hooked g5ere_template_loop_property_meta - 15
				 */
				do_action('g5ere_loop_property_slider_content_layout_04');
				?>
				<div class="g5ere__property-bottom">
					<?php
					/**
					 * Hook: g5ere_loop_property_slider_bottom_layout_04.
					 *
					 * @hooked g5ere_template_loop_property_primary_status - 5
					 * @hooked g5ere_template_loop_property_badge_featured -10
					 * @hooked g5ere_template_loop_property_price -15
					 */
					do_action('g5ere_loop_property_slider_bottom_layout_04');
					?>
				</div>
			</div>
		</div>
	</div>
</article>