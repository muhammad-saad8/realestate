<?php
$header_classes = array(
	'g5core-header-desktop-wrapper',
	'sticky-area'
);
?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="container">
		<div class="g5core-header-inner">
			<?php G5CORE()->get_template( 'header/customize.php', array(
				'type'     => 'desktop',
				'location' => 'before_logo',
				'classes' => 'width-50 content-left',
			) ); ?>
			<?php G5CORE()->get_template( 'header/desktop/logo.php', array('classes' => 'logo-center') ); ?>
			<?php G5CORE()->get_template( 'header/desktop/menu.php', array(
				'menu_class' => 'main-menu menu-horizontal',
				'classes' => 'width-50 content-right'
			) ); ?>
		</div>
	</div>
</div>