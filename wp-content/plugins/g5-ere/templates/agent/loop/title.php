<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $agent_link
 * @var $agent_name
 */
?>
<h3 class="g5ere__loop-agent-title">
	<a title="<?php echo esc_attr($agent_name)?>" href="<?php echo esc_url($agent_link)?>"><?php echo esc_html($agent_name)?></a>
</h3>