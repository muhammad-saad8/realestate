<?php
if ( G5CORE()->options()->header()->get_option( 'header_enable' ) !== 'on' ) {
	return;
}
G5CORE()->get_template( 'header/desktop.php' );
G5CORE()->get_template( 'header/mobile.php' );