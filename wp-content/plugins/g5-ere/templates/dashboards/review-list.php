<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $comments
 */
?>
<ol class="comment-list g5ere__review-list list-unstyled border-0">
	<?php foreach ( $comments as $comment ) {
		G5ERE()->get_template( 'dashboards/loop/review-item.php', array( 'comment' => $comment ) );
	}
	?>
</ol>
