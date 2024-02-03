<?php
$allow_submit = ere_allow_submit();
global $current_user;
wp_get_current_user();
?>
<header class="g5ere__dashboard-main-header bg-white">
    <div class="container-fluid">
        <nav class="navbar navbar-light py-4 px-3 px-lg-0">
            <h1 class="g5ere__dashboard-page-title mb-0"><?php echo get_the_title(); ?></h1>
            <div class="ml-auto">
				<?php
				if ( $allow_submit ) :
					?>
                    <a href="<?php echo esc_url( ere_get_permalink( 'submit_property' ) ) ?>"
                       class="btn btn-primary g5ere__dashboard-add-listing"><?php
						esc_html_e( 'Add listing', 'g5-ere' )
						?></a>
				<?php
				endif;
				?>
            </div>
        </nav>
    </div>
</header>