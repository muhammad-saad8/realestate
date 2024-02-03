<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/helper.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/property.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/search-forms.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/vc.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template-hooks.php' ) );

G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template-agent.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template-agent-hooks.php' ) );

G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template-agency.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template-agency-hooks.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template-author.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/template-author-hooks.php' ) );

G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/agency.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/agent.php' ) );
G5ERE()->load_file( G5ERE()->plugin_dir( 'inc/functions/dashboard.php' ) );