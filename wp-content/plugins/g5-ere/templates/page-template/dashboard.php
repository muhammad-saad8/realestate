<?php
// Do not allow directly accessing this file.
/**
 * Template Name: Dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! is_user_logged_in() ) {
	global $wp;
	$current_url = home_url( $wp->request );
	wp_redirect( ere_get_permalink( 'login' ) . '?redirect_to='.urlencode($current_url) );

} else {
	G5ERE()->get_template( 'header.php' );
	?>
    <div class="g5ere__page-wrapper g5ere__page-dashboard-wrapper">
        <div class="d-flex flex-wrap flex-xl-nowrap">
            <div class="g5ere__db-sidebar py-3">
				<?php ere_get_template( 'global/dashboard-menu.php' ); ?>
            </div>
            <div class="g5ere__page-content">
				<?php G5ERE()->get_template( 'header/dashboard-header.php' ); ?>
                <main id="content" class="g5ere__page-main">
                    <div class="container-fluid p-xl-5">
						<?php
						while ( have_posts() ) : the_post();
							the_content();
						endwhile; // End of the loop.
						?>
                    </div>
                </main>
            </div>
        </div>
    </div>
	<?php
}
G5ERE()->get_template( 'footer.php' );