<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$wrapper_classes = array(
	'g5ere__single-agent-head',
	'g5ere__sah-layout-01',
	'bg-white'
);
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<div class="container">
		<div class="row g5ere__sah-inner">
			<div class="col-xl-5 col-lg-6">
				<div class="g5core__post-featured g5ere__agent-featured">
					<?php g5ere_render_agent_thumbnail_markup( array(
						'image_size'  => 'full',
						'placeholder' => 'on',
						'display_permalink' => false
					) ); ?>
				</div>
			</div>
			<div class="col-xl-7 col-lg-6">
				<div class="g5ere__agent-summary">
					<?php
					/**
					 * Hook: g5ere_single_agent_head_layout_01.
					 *
					 * @see g5ere_template_agent_title
					 * @see g5ere_template_loop_agent_position
					 * @see g5ere_template_loop_agent_agency_has_title
					 * @see g5ere_template_loop_agent_description
					 * @see g5ere_template_agent_meta
					 */
					do_action('g5ere_single_agent_head_layout_01');
					?>
					<div class="g5ere__agent-summary-bottom d-flex flex-wrap align-items-center">
						<?php
						/**
						 * Hook: g5ere_single_agent_head_bottom_layout_01.
						 *
						 * @see g5ere_template_agent_rating
						 * @see g5ere_template_loop_agent_social
						 *
						 */
						do_action('g5ere_single_agent_head_bottom_layout_01');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
