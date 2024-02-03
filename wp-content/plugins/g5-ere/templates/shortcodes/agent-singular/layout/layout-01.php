<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $image_size
 * @var $image_ratio
 * @var $image_mode
 *
 */
$thumbnail_data = g5ere_get_agent_thumbnail_data(array(
	'image_size' => $image_size,
));
?>
<div class="row g5ere__agent-singular-inner">
	<?php if ($thumbnail_data['url'] !== ''): ?>
        <div class="col-xl-5 col-lg-6">
	            <div class="g5core__post-featured g5ere__agent-featured">
				<?php g5ere_render_agent_thumbnail_markup(array(
					'image_size' => $image_size,
					'image_ratio' => $image_ratio,
					'image_mode' => $image_mode,
				)); ?>
            </div>
        </div>
	<?php endif; ?>
    <div class="col-xl-7 col-lg-6">
        <div class="g5ere__agent-singular-summary">
	        <?php
	        /**
	         * Hook: g5ere_agent_singular_summary_overview.
	         *
	         * @see g5ere_template_loop_agent_title - 5
	         * @see g5ere_template_loop_agent_position - 10
	         * @see g5ere_template_loop_agent_agency_has_title - 15
	         * @see g5ere_template_loop_agent_description - 20
	         */
	        do_action('g5ere_agent_singular_summary_overview');
	        ?>

	        <div class="g5ere__ass-meta">
		        <?php
		        /**
		         * Hook: g5ere_agent_singular_summary_info.
		         *
		         * @see g5ere_template_loop_agent_phone_has_title - 5
		         * @see g5ere_template_loop_agent_office_number_has_title - 10
		         * @see g5ere_template_loop_agent_email_has_title - 15
		         * @see g5ere_template_loop_agent_website_has_title - 20
		         */
		        do_action('g5ere_agent_singular_summary_info');
		        ?>
	        </div>
	        <div class="g5ere__ass-bottom g5ere__loop-agent-social-circle d-flex flex-wrap align-items-center">
		        <?php
		        /**
		         * Hook: g5ere_agent_singular_summary_bottom.
		         *
		         * @see g5ere_template_agent_rating - 5
		         * @see g5ere_template_loop_agent_social - 10
		         */
		        do_action('g5ere_agent_singular_summary_bottom');
		        ?>
	        </div>
        </div>
    </div>
</div>
