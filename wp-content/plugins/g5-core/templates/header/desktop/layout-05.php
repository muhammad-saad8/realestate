<?php
$header_classes = array(
	'g5core-header-desktop-wrapper'
);

$navigation_class = array('g5core-header-navigation', 'sticky-area');
if (G5CORE()->options()->header()->get_option('navigation_border_enable') === 'on') {
	$navigation_class[] = 'navigation-bordered navigation-bordered-top';
}
?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="g5core-header-above">
		<div class="container">
			<div class="g5core-header-inner">
				<?php G5CORE()->get_template( 'header/desktop/logo.php' ); ?>
				<?php G5CORE()->get_template( 'header/customize.php', array(
					'type'     => 'desktop',
					'location' => 'after_logo',
					'classes' => 'content-fill content-right'
				) ); ?>
			</div>
		</div>
	</div>
	<div class="<?php echo join(' ', $navigation_class)?>">
		<div class="container">
			<div class="g5core-header-inner">
				<?php G5CORE()->get_template( 'header/customize.php', array(
					'type'     => 'desktop',
					'location' => 'before_menu',
					'classes' => 'width-50'
				) ); ?>
				<?php G5CORE()->get_template( 'header/desktop/menu.php', array(
						'classes' => 'content-fill content-center',
						'menu_class' => 'main-menu menu-horizontal'
				) ); ?>
				<?php G5CORE()->get_template( 'header/customize.php', array(
					'type'     => 'desktop',
					'location' => 'after_menu',
					'classes' => 'width-50 content-right'
				) ); ?>
			</div>
		</div>
	</div>
</div>