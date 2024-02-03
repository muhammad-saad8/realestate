<?php
$header_classes = array(
	'g5core-header-desktop-wrapper',
	'g5core-header-vertical',
	'g5core-header-vertical-mini',
	'g5core-header-vertical-left'
);
?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="g5core-header-inner">
		<?php G5CORE()->get_template( 'header/desktop/logo.php', array(
			'classes' => 'content-top'
		) ); ?>
		<div class="g5core-header-vertical-mini-center">
			<?php G5CORE()->get_template( 'header/desktop/menu-popup-button.php' ); ?>
		</div>
		<?php G5CORE()->get_template( 'header/customize.php', array(
			'type'     => 'desktop',
			'location' => 'after_menu',
			'classes' => 'content-bottom content-center'
		) ); ?>
	</div>
</div>