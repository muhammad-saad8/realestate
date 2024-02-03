<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$enable_comments_reviews = absint(ere_get_option( 'enable_comments_reviews_property', 0 ));
if ($enable_comments_reviews === 0) {
	return;
}
$title = __( 'Rating & Reviews', 'g5-ere' );
if ($enable_comments_reviews === 1) {
	$title = __( 'Reviews', 'g5-ere' );
}
?>
<?php if (comments_open() || get_comments_number()): ?>
	<div class="g5ere__single-block g5ere__property-block g5ere__property-block-review card">
	    <div class="card-header">
	        <h2><?php echo esc_html($title); ?></h2>
	    </div>
	    <div class="card-body">
		    <?php comments_template(); ?>
	    </div>
	</div>
<?php endif;