<?php
$header_classes = array(
	'g5core-mobile-header-wrapper',
	'sticky-area'
);
if (G5CORE()->options()->header()->get_option('top_bar_mobile_border_bottom') === 'on') {
	$header_classes[] = 'border-bottom';
}
?>
<div class="<?php echo join( ' ', $header_classes ) ?>">
	<div class="container">
		<div class="g5core-mobile-header-inner content-fill">
			<?php G5CORE()->get_template( 'header/mobile/menu-toggle.php', array(
					'classes' => 'content-left width-50'
			) ); ?>
			<?php G5CORE()->get_template( 'header/mobile/logo.php' ); ?>
			<?php G5CORE()->get_template( 'header/customize.php', array(
				'type'     => 'mobile',
				'location' => 'header_mobile',
				'classes'  => 'content-right width-50'
			) ); ?>
		</div>
	</div>
</div>