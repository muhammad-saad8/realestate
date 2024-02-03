<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( empty( $author_name ) ) {
	return;
}
?>
<h2 class="g5ere__loop-agent-title">
	<?php echo esc_html( $author_name ) ?>
</h2>