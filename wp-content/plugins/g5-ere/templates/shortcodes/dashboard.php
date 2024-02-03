<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$wrapper_classes = array(
	'g5element__dashboards',
);
$paid_submission_type                = ere_get_option( 'paid_submission_type', 'no' );
$enable_submit_property_via_frontend = ere_get_option( 'enable_submit_property_via_frontend', 1 );
$user_can_submit                     = ere_get_option( 'user_can_submit', 1 );
$is_agent                            = ere_is_agent();
$middle_wrapper_class                = array( 'g5element__dashboards-middle' );
$middle_left_class                   = array( 'g5element__dashboards-middle-left', 'item' );
$middle_right_class                  = array( 'g5element__dashboards-middle-right', 'item' );
if ( $paid_submission_type == 'per_package' && $enable_submit_property_via_frontend == 1 && ( $is_agent || $user_can_submit == 1 ) ) {
	$middle_wrapper_class[] = 'row';
	$middle_left_class[]    = 'col-md-8';
	$middle_right_class[]   = 'col-md-4';
}

?>
<div class="g5element__dashboards">
	<?php do_action( 'g5ere_dashboard_section_before' ) ?>
	<div class="<?php echo implode( ' ', array_filter( $middle_wrapper_class ) ) ?>">
		<div class="<?php echo implode( ' ', array_filter( $middle_left_class ) ) ?>">
			<div class="card card-body g5ere__dashboards-review-section">
				<h2 class="card-title">
					<?php esc_html_e( 'Recent Reviews', 'g5-ere' ) ?>
				</h2>
				<?php
				$current_user_id = get_current_user_id();
				$recent_comments = g5ere_get_user_comments_limit( $current_user_id, 3, 0 );
				if ( $recent_comments ):
					G5ERE()->get_template( 'dashboards/review-list.php', array( 'comments' => $recent_comments ) );
				else:?>
					<div class="ere-message alert alert-warning"><?php esc_html_e( 'You don\'t have any review listed.', 'g5-ere' ); ?></div>
				<?php endif;
				?>
			</div>

		</div>
		<?php
		if ( $paid_submission_type == 'per_package' && $enable_submit_property_via_frontend == 1 && ( $is_agent || $user_can_submit == 1 ) ):?>
			<div class="<?php echo implode( ' ', array_filter( $middle_right_class ) ) ?>">
				<div class="card g5ere__dashboards-package-section">
					<div class="card-body">
						<h2 class="card-title">
							<?php esc_html_e( 'My Package', 'g5-ere' ) ?>
						</h2>
						<?php ere_get_template( 'widgets/my-package/my-package.php' ); ?>
					</div>

				</div>
			</div>
		<?php endif;
		?>
	</div>
	<?php do_action( 'g5ere_dashboard_section_after' ) ?>
</div>
