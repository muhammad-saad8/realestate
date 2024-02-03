<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 */
$wrapper_classes = array(
	'comments-area',
	'g5ere__review-wrap'
);

if ( ! empty( $custom_class ) ) {
	$wrapper_classes[] = $custom_class;
}

$rating_data = g5ere_get_rating_data();
$review_data =  g5ere_get_review_data();
$wrapper_class = implode( ' ', $wrapper_classes );
?>
<div id="comments" class="<?php echo esc_attr( $wrapper_class ) ?>">
	<?php

	if ( $rating_data ) {
		G5ERE()->get_template( 'global/review/rating.php', $rating_data );
	}

	if ( have_comments() ) {
		G5ERE()->get_template( 'global/review/list.php' );
	}

	if ($review_data) {
		G5ERE()->get_template( 'global/review/form.php', $review_data );
	}


	?>
</div>

