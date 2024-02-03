<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<a class="btn btn-outline btn-dark btn-read-more" href="<?php the_permalink() ?>"><?php esc_html_e('Read more','homeid') ?> <i class="fal fa-long-arrow-right text-accent"></i></a>
