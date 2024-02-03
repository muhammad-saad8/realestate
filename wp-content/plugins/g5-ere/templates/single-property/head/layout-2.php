<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$wrapper_classes = array(
	'g5ere__single-property-head',
	'g5ere__sph-layout-2',
	'bg-white',
	'pb-0'
);
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<?php g5ere_template_single_property_breadcrumbs() ?>
	<div class="container">
		<div class="g5ere__sph-inner">
			<?php
			/**
			 * Hook: g5ere_single_property_head_layout_2.
			 *
			 * @hooked g5ere_template_single_property_gallery - 10
			 */
			do_action('g5ere_single_property_head_layout_2');
			?>
		</div>
	</div>
</div>
