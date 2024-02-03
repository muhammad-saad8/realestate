<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$wrapper_classes = array(
	'g5ere__single-property-head',
	'g5ere__sph-layout-5',
	'position-relative',
	'bg-white',
	'pb-0'
);
$wrapper_class   = implode( ' ', $wrapper_classes );
?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
	<?php g5ere_template_single_property_breadcrumbs() ?>
	<div class="g5ere__sph-inner">
		<?php g5ere_template_single_property_featured_image(); ?>
		<div class="container">
			<?php
			/**
			 * Hook: g5ere_single_property_head_layout_5.
			 *
			 * @see g5ere_template_property_action_meta_open
			 * @see g5ere_template_property_action
			 * @see g5ere_template_property_meta
			 * @see g5ere_template_tag_div_close
			 */
			do_action( 'g5ere_single_property_head_layout_5' );
			?>
		</div>
	</div>
</div>
