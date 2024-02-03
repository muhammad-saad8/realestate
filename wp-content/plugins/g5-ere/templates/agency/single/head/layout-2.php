<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $g5ere_agency G5ERE_Agency
 */
global $g5ere_agency;
if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return false;
}
$wrapper_classes = array(
	'g5ere__single-agency-head',
	'g5ere__sach-layout-2',
);
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<div class="g5core__post-featured g5ere__agency-featured">
		<?php $g5ere_agency->render_thumbnail_markup( array(
			'image_size'  => 'full',
			'image_mode' => 'image',
			'placeholder' => 'on',
			'display_permalink' => false
		) ); ?>
	</div>
	<div class="g5ere__agency-summary">
		<?php
		/**
		 * Hook: g5ere_single_agency_head_layout_2.
		 *
		 * @see g5ere_template_agency_title
		 * @see g5ere_template_loop_agency_address
		 * @see g5ere_template_agency_meta
		 * @see g5ere_template_loop_agency_social_has_title
		 */
		do_action('g5ere_single_agency_head_layout_2');
		?>
	</div>
</div>
