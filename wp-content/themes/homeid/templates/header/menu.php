<?php
/**
 * Menu navigation template
 *
 * @since 1.0
 * @version 1.0
 */

if ( has_nav_menu( 'primary' ) ) : ?>
	<div class="site-navigation">
		<div class="site-menu">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'primary',
				'container_id' => 'main-menu',
				'menu_class' => 'main-menu menu-horizontal'
			));
			?>
		</div><!-- .main-menu -->
	</div> <!-- /.site-navigation -->
<?php endif; ?>