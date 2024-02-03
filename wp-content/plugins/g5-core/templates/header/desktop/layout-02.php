<?php
$header_classes = array(
	'g5core-header-desktop-wrapper',
	'sticky-area'
);
?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="container">
		<div class="g5core-header-inner">
			<?php G5CORE()->get_template( 'header/desktop/logo.php' ); ?>
			<?php G5CORE()->get_template( 'header/desktop/menu.php', array(
				'classes' => 'content-fill content-center',
				'menu_class' => 'main-menu menu-horizontal'
			) ); ?>
			<?php G5CORE()->get_template( 'header/customize.php', array(
				'type'     => 'desktop',
				'location' => 'after_menu',
			) ); ?>
		</div>
	</div>
</div>