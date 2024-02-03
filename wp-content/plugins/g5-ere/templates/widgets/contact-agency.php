<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="g5ere__widget-contact-agent-content">
	<?php
		G5ERE()->get_template("widgets/contact-agency/{$layout}.php");
		g5ere_template_agency_contact_form();
	?>
</div>
