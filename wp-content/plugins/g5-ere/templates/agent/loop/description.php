<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $description
 */
?>
<div class="g5ere__loop-agent-description">
	<?php echo wp_kses_post($description) ?>
</div>
