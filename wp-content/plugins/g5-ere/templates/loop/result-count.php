<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $total
 * @var $per_page
 * @var $current
 */
?>
<p class="g5ere__result-count">
	<?php
	if ( 1 === $total ) {
		echo esc_html__( 'Showing the single result', 'g5-ere' );
	} elseif ( $total <= $per_page || - 1 === $per_page ) {
		/* translators: %d: total results */
		printf( _n( 'Showing all %s result', 'Showing all %s results', $total , 'g5-ere' ),'<span>' . $total . '</span>' );
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		/* translators: 1: first result 2: last result 3: total results */
		printf( _nx( 'Showing %1$s&ndash;%2$s of %3$s result', 'Showing %1$s&ndash;%2$s of %3$s results', $total, 'with first and last result', 'g5-ere' ), '<span>' . $first . '</span>', '<span>' . $last . '</span>', '<span>' . $total . '</span>' );
	}
	?>
</p>
