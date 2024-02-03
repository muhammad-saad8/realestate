<?php
$header_style = G5CORE()->options()->header()->get_option( 'header_style' );
$header_responsive_breakpoint = G5CORE()->options()->header()->get_option( 'header_responsive_breakpoint' );
$header_border_enable = G5CORE()->options()->header()->get_option( 'header_border_enable' );
$header_layout = G5CORE()->options()->header()->get_option( 'header_layout' );
$site_header_classes = array(
	'g5core-site-header',
	'header-style-' . $header_style,
	'header-layout-' . $header_layout,
);

$header_attrs = array(
	'data-layout="' . esc_attr($header_style) . '"',
	'data-responsive-breakpoint="' . esc_attr($header_responsive_breakpoint) . '"',
);

$css_classes         = G5CORE()->options()->header()->get_option( 'header_css_classes' );
if ( $css_classes !== '' ) {
	$site_header_classes[] = esc_attr( $css_classes );
}

if ( G5CORE()->options()->header()->get_option( 'header_float' ) === 'on' ) {
	if (G5CORE()->settings()->header_vertical_style($header_style) === false) {
		$site_header_classes[] = 'header-float';
	}
}
if (G5CORE()->settings()->header_vertical_style($header_style) !== false) {
	$site_header_classes[] = 'header-vertical';
}

if ( G5CORE()->options()->header()->get_option( 'header_sticky' ) !== '' ) {
	$site_header_classes[] = 'header-sticky header-sticky-' . G5CORE()->options()->header()->get_option( 'header_sticky' );
}
if ($header_border_enable === 'on') {
	$site_header_classes[] = 'header-border-bottom';
}
?>
<header id="site-header" class="<?php echo join( ' ', $site_header_classes ) ?>" <?php echo join(' ', $header_attrs) ?>>
	<?php if (G5CORE()->settings()->header_vertical_style($header_style) === false): ?>
		<?php G5CORE()->get_template( 'header/top-bar.php', array( 'type' => 'desktop' ) ); ?>
	<?php endif; ?>
	<?php G5CORE()->get_template( 'header/desktop/' . G5CORE()->options()->header()->get_option( 'header_style' ) . '.php' ); ?>
</header>