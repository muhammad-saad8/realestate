<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $agent_info
 */

if (!isset($agent_info)) {
	$agent_info       = g5ere_get_agent_info_by_property();
}

if ($agent_info === false) {
	return;
}

?>
<div class="g5ere__property-contact-agent">
	<?php
	/**
	 * @hooked g5ere_template_single_property_contact_info
	 */
	do_action( 'g5ere_single_property_contact_agent', $agent_info );

	G5ERE()->get_template( 'global/contact-form.php', array(
		'email' => $agent_info['email'],
		'phone' => $agent_info['phone']
	) );

	?>
</div>
