<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 * @var $count
 */
?>
<div class="g5ere__loop-agent-property">
    <a title="<?php g5core_the_title_attribute() ?>" href="<?php g5core_the_permalink() ?>"><span
                class="g5ere__lap-count mr-2"><?php echo esc_attr($count) ?></span><span><?php echo esc_html__('Listed Properties', 'g5-ere') ?></span><i
                class="far fa-long-arrow-right ml-2"></i></a>
</div>