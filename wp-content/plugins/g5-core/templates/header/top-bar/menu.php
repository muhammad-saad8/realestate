<?php
if (!has_nav_menu('top-menu')) return;
?>
<?php if (has_nav_menu('top-menu')): ?>
	<?php wp_nav_menu(array(
		'theme_location' => 'top-menu',
		'menu_class' => 'top-menu menu-horizontal',
		'container' => '',
	)); ?>
<?php endif; ?>