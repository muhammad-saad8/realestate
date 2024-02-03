<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $reviews_per_page
 */
$wrapper_classes = array(
	'g5element__reviews',
	'g5ere__review-wrap',
);

$current_user_id = get_current_user_id();
$number_reviews  = g5ere_get_user_comments_count( $current_user_id );
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} else {
	$paged = 1;
}
$limit = 5;
if ( ! empty( $reviews_per_page ) ) {
	$limit = absint( $reviews_per_page );
}
$offset                = $limit * ( $paged - 1 );
$numbPage              = ceil( $number_reviews / $limit );
$comments              = g5ere_get_user_comments_limit( $current_user_id, $limit, $offset );
$current_count_comment = count( $comments );
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
	<?php if ( $number_reviews > 0 ): ?>
		<div class="card card-body border-0 comments-list-wrap g5ere__review-list-wrap">
			<h3 class="card-title comments-title g5ere__review-title">
	            <span>
	                <?php if ( $current_count_comment == 0 ) {
		                esc_html_e( 'No Reviews', 'g5-ere' );
	                } elseif ( $current_count_comment == 1 ) {
		                esc_html_e( 'One Review', 'g5-ere' );
	                } else {
		                printf( __( '%s Reviews', 'g5-ere' ), $current_count_comment );
	                } ?>

	            </span>
			</h3>
			<?php G5ERE()->get_template( 'dashboards/review-list.php', array( 'comments' => $comments ) ); ?>
		</div>
	<?php else: ?>
		<div class="ere-message alert alert-warning"><?php esc_html_e( 'You don\'t have any review listed.', 'g5-ere' ); ?></div>
	<?php endif; ?>
	<?php ere_get_template( 'global/pagination.php', array( 'max_num_pages' => $numbPage ) ); ?>
</div>
