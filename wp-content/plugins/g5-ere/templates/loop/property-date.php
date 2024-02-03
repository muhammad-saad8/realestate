<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$property_create_time = get_the_time('U');
$current_time = current_time('timestamp');
$time_ago = human_time_diff($property_create_time, $current_time);

?>
<div class="g5ere__property-date" data-toggle="tooltip" title="<?php echo esc_attr(get_the_date(get_option('date_format')))?>">
	<i class="fal fa-clock mr-1"></i> <span><?php echo sprintf(_x(' %s ago', '%s = human-readable time difference', 'g5-ere'), $time_ago); ?></span>
</div>
