<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
$agency_toolbar = G5ERE()->options()->get_option( 'agency_toolbar' );

$agency_toolbar_mobile = G5ERE()->options()->get_option( 'agency_toolbar_mobile' );
if ( ! is_array( $agency_toolbar ) && ! is_array( $agency_toolbar_mobile ) ) {
	return;
}

$agency_toolbar_left  = ( ! isset( $agency_toolbar['left'] ) || ! is_array( $agency_toolbar['left'] ) || ( count( $agency_toolbar['left'] ) === 0 ) ) ? false : $agency_toolbar['left'];
$agency_toolbar_right = ( ! isset( $agency_toolbar['right'] ) || ! is_array( $agency_toolbar['right'] ) || ( count( $agency_toolbar['right'] ) === 0 ) ) ? false : $agency_toolbar['right'];

$agency_toolbar_mobile_left  = ( ! isset( $agency_toolbar_mobile['left'] ) || ! is_array( $agency_toolbar_mobile['left'] ) || ( count( $agency_toolbar_mobile['left'] ) === 0 ) ) ? false : $agency_toolbar_mobile['left'];
$agency_toolbar_mobile_right = ( ! isset( $agency_toolbar_mobile['right'] ) || ! is_array( $agency_toolbar_mobile['right'] ) || ( count( $agency_toolbar_mobile['right'] ) === 0 ) ) ? false : $agency_toolbar_mobile['right'];

if ( ! $agency_toolbar_left && ! $agency_toolbar_right && ! $agency_toolbar_mobile_left && ! $agency_toolbar_mobile_right ) {
	return;
}

unset( $agency_toolbar_left['__no_value__'] );
unset( $agency_toolbar_right['__no_value__'] );
unset( $agency_toolbar_mobile_left['__no_value__'] );
unset( $agency_toolbar_mobile_right['__no_value__'] );
$agency_toolbar_layout = G5ERE()->options()->get_option( 'agency_toolbar_layout' );
$wrapper_classes      = array(
	'g5ere__toolbar',
	$agency_toolbar_layout
);

$wrapper_class = join( ' ', $wrapper_classes );

?>
<div class="<?php echo esc_attr( $wrapper_class ) ?>">
    <div class="g5ere__toolbar-inner">
		<?php if ( $agency_toolbar_left || $agency_toolbar_right ): ?>
            <div class="g5ere__toolbar-desktop">
                <div class="container">
                    <div class="g5ere__toolbar-content-inner">
						<?php if ( $agency_toolbar_left ): ?>
                            <div class="g5ere__toolbar-left">
                                <ul class="g5ere__toolbar-list">
									<?php foreach ( $agency_toolbar_left as $k => $v ): ?>
                                        <li><?php G5ERE()->get_template( "agency/loop/toolbar/{$k}.php", array( 'query_args' => $query_args ) ) ?></li>
									<?php endforeach; ?>
                                </ul>
                            </div>
						<?php endif; ?>
						<?php if ( $agency_toolbar_right ): ?>
                            <div class="g5ere__toolbar-right">
                                <ul class="g5ere__toolbar-list">
									<?php foreach ( $agency_toolbar_right as $k => $v ): ?>
                                        <li><?php G5ERE()->get_template( "agency/loop/toolbar/{$k}.php" ) ?></li>
									<?php endforeach; ?>
                                </ul>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>
		<?php if ( $agency_toolbar_mobile_left || $agency_toolbar_mobile_right ): ?>
            <div class="g5ere__toolbar-mobile">
                <div class="container">
                    <div class="g5ere__toolbar-content-inner">
						<?php if ( $agency_toolbar_mobile_left ): ?>
                            <div class="g5ere__toolbar-left">
                                <ul class="g5ere__toolbar-list">
									<?php foreach ( $agency_toolbar_mobile_left as $k => $v ): ?>
                                        <li><?php G5ERE()->get_template( "agency/loop/toolbar/{$k}.php", array( 'query_args' => $query_args ) ) ?></li>
									<?php endforeach; ?>
                                </ul>
                            </div>
						<?php endif; ?>
						<?php if ( $agency_toolbar_mobile_right ): ?>
                            <div class="g5ere__toolbar-right">
                                <ul class="g5ere__toolbar-list">
									<?php foreach ( $agency_toolbar_mobile_right as $k => $v ): ?>
                                        <li><?php G5ERE()->get_template( "agency/loop/toolbar/{$k}.php" ) ?></li>
									<?php endforeach; ?>
                                </ul>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>
    </div>
</div>
