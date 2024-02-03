<?php
$header_classes = array(
	'g5core-header-desktop-wrapper',
	'g5core-header-vertical',
	'g5core-header-vertical-large',
	'g5core-header-vertical-right'
);

$menu_classes = 'menu-vertical menu-vertical-right';
if (G5CORE()->options()->header()->get_option('header_border_enable') === 'on') {
	$menu_classes .= ' navigation-bordered';
}
?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="g5core-header-inner">
		<?php G5CORE()->get_template( 'header/desktop/logo.php' ); ?>
		<?php G5CORE()->get_template( 'header/customize.php', array(
			'type'     => 'desktop',
			'location' => 'before_menu',
		) ); ?>
		<?php G5CORE()->get_template( 'header/desktop/menu.php', array(
			'classes' => '',
			'menu_class' => $menu_classes
		) ); ?>
		<?php G5CORE()->get_template( 'header/customize.php', array(
			'type'     => 'desktop',
			'location' => 'after_menu',
		) ); ?>
	</div>
</div>