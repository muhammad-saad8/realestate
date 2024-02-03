<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $layout
 * @var $agent_info
 */
?>
<div class="g5ere__widget-contact-agent-content">
	<?php
		G5ERE()->get_template("widgets/contact-agent/{$layout}.php", array('agent_info' => $agent_info) );
		g5ere_template_agent_contact_form($agent_info);
	?>
</div>

