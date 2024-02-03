<?php
$header_classes = array(
	'g5core-header-desktop-wrapper',
	'g5core-header-vertical',
	'g5core-header-vertical-large',
	'g5core-header-vertical-left'
);

$menu_classes = 'menu-vertical';
if (G5CORE()->options()->header()->get_option('header_border_enable') === 'on') {
	$menu_classes .= ' navigation-bordered';
}
?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="g5core-header-inner">
		<?php G5CORE()->get_template( 'header/desktop/logo.php' ); ?>
		<div class="menu-vertical-wrapper content-fill">
			<?php G5CORE()->get_template( 'header/customize.php', array(
				'type'     => 'desktop',
				'location' => 'before_menu',
				'classes'  => 'g5core-customize-top',
			) ); ?>
			<?php G5CORE()->get_template( 'header/desktop/menu.php', array(
				'classes' => '',
				'menu_class' => $menu_classes
			) ); ?>
			<?php G5CORE()->get_template( 'header/customize.php', array(
				'type'     => 'desktop',
				'location' => 'after_menu',
				'classes'  => 'g5core-customize-bottom',
			) ); ?>
		</div>
	</div>
</div>