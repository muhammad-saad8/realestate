<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $g5ere_agency G5ERE_Agency
 */
global $g5ere_agency;
if ( ! g5ere_agency_visible( $g5ere_agency ) ) {
	return;
}
$agency_content = $g5ere_agency->get_content();
if (empty($agency_content)) {
	return;
}
?>
<div class="g5ere__single-agency-overview">
	<?php echo wpautop( $agency_content )?>
</div>


