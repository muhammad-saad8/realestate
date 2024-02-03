<?php
/**
 * @var $cur_menu
 * @var $max_num_pages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $current_user;
wp_get_current_user();
$user_login = $current_user->user_login;
$user_id    = $current_user->ID;
global $wp;
$current_url = home_url( $wp->request ) . '/';
$categories  = g5ere_get_category_dashboard_menu();
$menus       = g5ere_get_dashboard_menu();
?>
<div class="g5ere__dashboard-sidebar-content bg-white">
    <nav class="navbar navbar-expand-xl navbar-light d-block px-0" role="navigation">
        <div class="d-flex w-100 pt-xl-3 g5ere__dashboard-sidebar-top">
            <div class="navbar-brand d-inline-flex align-items-center">
				<?php
				$logo_default = G5CORE()->options()->header()->get_option( 'logo' );
				$logo_default = isset( $logo['url'] ) ? $logo['url'] : '';
				$logo         = G5ERE()->options()->get_option( 'dashboard_logo' );
				$logo         = isset( $logo['url'] ) ? $logo['url'] : '';
				$max_height   = G5ERE()->options()->get_option( 'dashboard_max_height' );
				if ( $logo != '' ) {
					$logo_url = $logo;
				} else {
					$logo_url = $logo_default;
				}
				$logo_title = esc_attr( get_bloginfo( 'name', 'display' ) ) . '-' . get_bloginfo( 'description', 'display' );
				?>
				<?php if ( ! empty( $logo_url ) ): ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       title="<?php echo esc_attr( $logo_title ) ?>" class="navbar-brand">
                        <img class="site-logo" src="<?php echo esc_url( $logo_url ) ?>"
                             style="max-height:<?php echo esc_html( $max_height['height'] ) ?>px;"
                             alt="<?php echo esc_attr( $logo_title ) ?>">
                    </a>
				<?php else: ?>
                    <div class="site-branding-text">
						<?php if ( is_front_page() ) : ?>
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                                      rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
                            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                                     rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif; ?>
                    </div><!-- .site-branding-text -->
				<?php endif; ?>
            </div>
            <div class="ml-auto d-flex align-items-center">
                <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse"
                        data-target="#g5ere__dashboard-sidebar-navbar-collapse"
                        aria-controls="g5ere__dashboard-sidebar-navbar-collapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <i class="fal fa-bars"></i>
                </button>
            </div>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse w-100" id="g5ere__dashboard-sidebar-navbar-collapse">
            <div class="g5ere__dashboard-sidebar-container w-100">
                <ul class="list-group list-group-flush w-100 mb-3 pb-3">
					<?php foreach ( $categories as $key => $value ): ?>
                        <li class="list-group-item">
                            <h5 class="mb-3 text-uppercase px-3 sidebar-section-title"><?php echo esc_html( $value ) ?></h5>
                            <ul class="list-group">
								<?php foreach ( $menus as $menu ):
									if ( $menu['cat'] == $key ):
											?>
                                            <li class="list-group-item border-0 px-3 sidebar-item <?php if ( strpos( $current_url, $menu['url'] ) !== false )
												echo 'active' ?>">
                                                <a href="<?php echo esc_url( $menu['url'] ); ?>"
                                                   class="sidebar-link d-flex align-items-center">
                                                <span class="sidebar-item-icon d-inline-block mr-3">
                                                   <?php echo wp_kses_post( $menu['icon'] ) ?>
                                                </span>
                                                    <span class="sidebar-item-text"><?php echo esc_html( $menu['label'] ); ?></span>
													<?php if ( $menu['number'] !== false ): ?>
                                                        <span class="sidebar-item-number ml-auto"><?php echo esc_html( $menu['number'] ); ?></span>
													<?php endif; ?>

                                                </a>
                                            </li>
										<?php
									endif;
								endforeach; ?>
                            </ul>
                        </li>
					<?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>