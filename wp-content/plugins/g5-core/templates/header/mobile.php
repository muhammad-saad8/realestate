<?php
$header_style = G5CORE()->options()->header()->get_option( 'mobile_header_style' );
$header_float = G5CORE()->options()->header()->get_option( 'mobile_header_float_enable' );
$header_sticky = G5CORE()->options()->header()->get_option( 'mobile_header_sticky' );

$site_header_classes = array(
	'g5core-mobile-header',
	'header-style-' . $header_style,
);

if ($header_float === 'on') {
	$site_header_classes[] = 'header-float';
}

$css_classes         = G5CORE()->options()->header()->get_option( 'mobile_header_css_classes' );
if ( $css_classes !== '' ) {
	$site_header_classes[] = esc_attr( $css_classes );
}

$header_attrs = array();
if ( $header_sticky !== '' ) {
	$site_header_classes[] = 'header-sticky header-sticky-' . esc_attr($header_sticky);
	$header_attrs[] = sprintf('data-sticky="%s"',esc_attr($header_sticky));
}
?>
<header id="site-mobile-header" class="<?php echo join( ' ', $site_header_classes ) ?>" <?php echo join(' ', $header_attrs) ?>>
	<?php G5CORE()->get_template( 'header/top-bar.php', array( 'type' => 'mobile') ); ?>
	<?php G5CORE()->get_template( 'header/mobile/' . $header_style . '.php' ); ?>
	<?php add_action('wp_footer', array(G5CORE()->templates(), 'menu_mobile')) ?>
</header>