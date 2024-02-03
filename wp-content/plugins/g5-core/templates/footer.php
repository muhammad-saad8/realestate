<?php
if ( G5CORE()->options()->footer()->get_option( 'footer_enable' ) !== 'on' ) {
	return;
}
$content_block = G5CORE()->options()->footer()->get_option( 'footer_content_block' );
if ( $content_block === '' ) {
	return;
}

$footer_layout  = G5CORE()->options()->footer()->get_option( 'footer_layout', 'boxed' );
$footer_classes = array(
	'g5core-site-footer',
	'footer-layout-' . $footer_layout,
);

if ( G5CORE()->options()->footer()->get_option( 'footer_fixed_enable' ) === 'on' ) {
	$footer_classes[] = 'g5core-site-footer-fixed';
}
?>
<footer id="site-footer" class="<?php echo join( ' ', $footer_classes ) ?>">
	<div class="container">
		<?php echo g5core_get_content_block( $content_block ); ?>
	</div>
</footer>