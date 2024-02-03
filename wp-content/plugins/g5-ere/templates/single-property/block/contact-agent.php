<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$agent_info       = g5ere_get_agent_info_by_property();
if ($agent_info === false) {
	return;
}
?>
<div class="g5ere__single-block g5ere__property-block g5ere__property-block-contact-agent card">
	<div class="card-header">
		<h2><?php echo esc_html__( 'Contact Agent', 'g5-ere' ) ?></h2>
	</div>
	<div class="card-body">
		<?php
		$hide_contact_information_if_not_login = absint(ere_get_option( 'hide_contact_information_if_not_login', 0 )) ;
		if (($hide_contact_information_if_not_login === 1) && !is_user_logged_in()) {
			G5ERE()->get_template( 'global/contact-not-login.php' );
		} else {
			G5ERE()->get_template( 'single-property/block/data/contact-agent.php',array('agent_info' => $agent_info) );
		}
		?>
	</div>
</div>
