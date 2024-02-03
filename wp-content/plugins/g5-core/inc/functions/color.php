<?php
/**
 * Color Library
 */

/**
 * Convert color to rgba array
 *
 * @param $color
 *
 * @return array
 */
function g5core_color_to_rgba( $color ) {
	if ( preg_match( '/^\#([0-9a-f])([0-9a-f])([0-9a-f])$/i', $color, $matchs ) ) {
		return array(
			hexdec( $matchs[1] . $matchs[1] ),
			hexdec( $matchs[2] . $matchs[2] ),
			hexdec( $matchs[3] . $matchs[3] ),
			1
		);
	}
	if ( preg_match( '/^\#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $matchs ) ) {
		return array(
			hexdec( $matchs[1] ),
			hexdec( $matchs[2] ),
			hexdec( $matchs[3] ),
			1
		);
	}
	if ( preg_match( '/^rgba\((\d{1,3})\,(\d{1,3})\,(\d{1,3}),(.*)\)$/i', $color, $matchs ) ) {
		if ( ( $matchs[1] >= 0 ) && ( $matchs[1] < 256 )
		     && ( $matchs[2] >= 0 ) && ( $matchs[2] < 256 )
		     && ( $matchs[3] >= 0 ) && ( $matchs[3] < 256 )
		     && is_numeric( $matchs[4] ) ) {
			return array(
				intval( $matchs[1] ),
				intval( $matchs[2] ),
				intval( $matchs[3] ),
				intval( $matchs[4] )
			);
		}
	}
	if ( preg_match( '/^rgb\((\d{1,3})\,(\d{1,3})\,(\d{1,3})\)$/i', $color, $matchs ) ) {
		if ( ( $matchs[1] >= 0 ) && ( $matchs[1] < 256 )
		     && ( $matchs[2] >= 0 ) && ( $matchs[2] < 256 )
		     && ( $matchs[3] >= 0 ) && ( $matchs[3] < 256 ) ) {
			return array(
				intval( $matchs[1] ),
				intval( $matchs[2] ),
				intval( $matchs[3] ),
				1
			);
		}
	}

	return array();
}

/**
 * Convert color to rgba color
 *
 * @param $color
 * @param null $opacity
 *
 * @return string
 */
function g5core_color_to_rgba_color($color, $opacity = null) {
	$rgba = g5core_color_to_rgba($color);
	if (empty($rgba)) {
		return $color;
	}
	if ($opacity !== null) {
		$rgba[3] = $opacity;
	}
	return "rgba({$rgba[0]},{$rgba[1]},{$rgba[2]},{$rgba[3]})";
}
/**
 * Convert color to hsla
 *
 * @param $color
 *
 * @return array
 */
function g5core_color_to_hsla( $color ) {
	$rgb = g5core_color_to_rgba( $color );
	if ( empty( $rgb ) ) {
		return array(
			'H' => 0,
			'S' => 0,
			'L' => 0,
			'A' => 0,
		); // Fail to return Black Color
	}

	$R = $rgb[0];
	$G = $rgb[1];
	$B = $rgb[2];

	$HSLA = array();

	$var_R = ( $R / 255 );
	$var_G = ( $G / 255 );
	$var_B = ( $B / 255 );

	$var_Min = min( $var_R, $var_G, $var_B );
	$var_Max = max( $var_R, $var_G, $var_B );
	$del_Max = $var_Max - $var_Min;

	$L = ( $var_Max + $var_Min ) / 2;

	if ( $del_Max == 0 ) {
		$H = 0;
		$S = 0;
	} else {
		if ( $L < 0.5 ) {
			$S = $del_Max / ( $var_Max + $var_Min );
		} else {
			$S = $del_Max / ( 2 - $var_Max - $var_Min );
		}

		$del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
		$del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
		$del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

		if ( $var_R == $var_Max ) {
			$H = $del_B - $del_G;
		} else if ( $var_G == $var_Max ) {
			$H = ( 1 / 3 ) + $del_R - $del_B;
		} else if ( $var_B == $var_Max ) {
			$H = ( 2 / 3 ) + $del_G - $del_R;
		}

		if ( $H < 0 ) {
			$H ++;
		}
		if ( $H > 1 ) {
			$H --;
		}
	}

	$HSLA['H'] = ( $H * 360 );
	$HSLA['S'] = $S;
	$HSLA['L'] = $L;
	$HSLA['A'] = $rgb[3];

	return $HSLA;
}

/**
 * Get color from hsla
 *
 * @param $hsla
 *
 * @return string
 */
function g5core_color_from_hsla( $hsla ) {
	if ( ! is_array( $hsla ) && ( count( $hsla ) != 4 ) ) {
		return '#000'; // Fail to return black to color
	}
	list( $H, $S, $L, $A ) = array( $hsla['H'] / 360, $hsla['S'], $hsla['L'], $hsla['A'] );

	if ( $S == 0 ) {
		$r = $L * 255;
		$g = $L * 255;
		$b = $L * 255;
	} else {

		if ( $L < 0.5 ) {
			$hue_value_2 = $L * ( 1 + $S );
		} else {
			$hue_value_2 = ( $L + $S ) - ( $S * $L );
		}

		$hue_value_1 = 2 * $L - $hue_value_2;

		$r = round( 255 * g5core_color_hue_to_rgb( $hue_value_1, $hue_value_2, $H + ( 1 / 3 ) ) );
		$g = round( 255 * g5core_color_hue_to_rgb( $hue_value_1, $hue_value_2, $H ) );
		$b = round( 255 * g5core_color_hue_to_rgb( $hue_value_1, $hue_value_2, $H - ( 1 / 3 ) ) );

	}

	if ($A < 1) {
		return "rgba({$r},{$g},{$b},{$A})";
	}

	// Convert to hex
	$r = dechex( (int)$r );
	$g = dechex( (int)$g );
	$b = dechex( (int)$b );

	// Make sure we get 2 digits for decimals
	$r = ( strlen( "" . $r ) === 1 ) ? "0" . $r : $r;
	$g = ( strlen( "" . $g ) === 1 ) ? "0" . $g : $g;
	$b = ( strlen( "" . $b ) === 1 ) ? "0" . $b : $b;


	return "#{$r}{$g}{$b}";
}

/**
 * Given a Hue, returns corresponding RGB value
 *
 * @param int $v1
 * @param int $v2
 * @param int $vH
 * @return int
 */
function g5core_color_hue_to_rgb( $v1,$v2,$vH ) {
	if( $vH < 0 ) {
		$vH += 1;
	}

	if( $vH > 1 ) {
		$vH -= 1;
	}

	if( (6*$vH) < 1 ) {
		return ($v1 + ($v2 - $v1) * 6 * $vH);
	}

	if( (2*$vH) < 1 ) {
		return $v2;
	}

	if( (3*$vH) < 2 ) {
		return ($v1 + ($v2-$v1) * ( (2/3)-$vH ) * 6);
	}

	return $v1;

}

/**
 * Adjust hue color
 *
 * @param $color
 * @param $value
 *
 * @return string
 */
function g5core_color_adjust_hue( $color, $value ) {
	$hsla = g5core_color_to_hsla($color);
	$hsla['H'] = $hsla['H'] + $value;
	return g5core_color_from_hsla($hsla);
}

function g5core_color_desaturate( $color, $value ) {
	$hsla = g5core_color_to_hsla($color);
	$hsla['S'] = $hsla['S'] - $value;
	return g5core_color_from_hsla($hsla);
}

/**
 * Get other color for gradient
 *
 * @param $color
 *
 * @return string
 */
function g5core_color_for_gradient( $color ) {
	$hsla = g5core_color_to_hsla($color);
	$hsla['H'] = $hsla['H'] + 333;
	$hsla['S'] = $hsla['S'] - 6.04;
	$hsla['L'] = max( $hsla['L'] - 0.0765, 0 );
	return g5core_color_from_hsla($hsla);
}

/**
 * Check color is dark
 *
 * @param $color
 *
 * @return bool
 */
function g5core_color_is_dark( $color ) {
	$hsl = g5core_color_to_hsla( $color );
	return $hsl['L'] < 0.75;
}

/**
 * Check color is light
 *
 * @param $color
 *
 * @return bool
 */
function g5core_color_is_light( $color ) {
	return ! g5core_color_is_dark( $color );
}

/**
 * Get invert color
 *
 * @param $color
 *
 * @return string
 */
function g5core_color_invert($color) {
	$rgba      = g5core_color_to_rgba( $color );

	$rgba[0] = 255 - $rgba[0];
	$rgba[1] = 255 - $rgba[1];
	$rgba[2] = 255 - $rgba[2];

	if ($rgba[3] < 1) {
		return "rgba({$rgba[0]},{$rgba[1]},{$rgba[2]},{$rgba[3]})";
	}
	// Convert to hex
	$rgba[0] = dechex( $rgba[0] );
	$rgba[1] = dechex( $rgba[1] );
	$rgba[2] = dechex( $rgba[2] );

	$rgba[0] = ( strlen( "" . $rgba[0] ) === 1 ) ? "0" . $rgba[0] : $rgba[0];
	$rgba[1] = ( strlen( "" . $rgba[1] ) === 1 ) ? "0" . $rgba[1] : $rgba[1];
	$rgba[2] = ( strlen( "" . $rgba[2] ) === 1 ) ? "0" . $rgba[2] : $rgba[2];

	return "#{$rgba[0]}{$rgba[1]}{$rgba[2]}";

}

/**
 * Get contract color
 *
 * @param $color
 * @param string $lightColor
 * @param string $darkColor
 *
 * @return string
 */
function g5core_color_contrast( $color, $lightColor = '#fff', $darkColor = '#222' ) {

	return g5core_color_is_dark( $color ) ? $lightColor : $darkColor;
}

/**
 * Lighten color
 *
 * @param $color
 * @param string $step
 *
 * @return string
 */
function g5core_color_lighten( $color, $step = '10%') {
	if ( is_numeric($step) ) {
		$step = $step / 255;
	} else {
		$step = floatval( $step ) / 100;
	}

	$hsla      = g5core_color_to_hsla( $color );
	$hsla['L'] = min( $hsla['L'] + $step, 1 );
	return g5core_color_from_hsla($hsla);
}

/**
 * Darken color
 *
 * @param $color
 * @param string $step
 *
 * @return string
 */
function g5core_color_darken( $color, $step = '10%') {
	if ( is_numeric($step) ) {
		$step = $step / 255;
	} else {
		$step = floatval( $step ) / 100;
	}

	$hsla      = g5core_color_to_hsla( $color );
	$hsla['L'] = max( $hsla['L'] - $step, 0 );

	return g5core_color_from_hsla($hsla);
}

/**
 * Make color adjust base on brightness (darken or lighten)
 *
 * @param $color
 * @param string | int $step
 *
 * @return string
 */
function g5core_color_adjust_brightness( $color, $step = '10%') {
	return g5core_color_is_dark( $color )
		? g5core_color_lighten( $color, $step )
		: g5core_color_darken( $color, $step );
}

/**
 * Check value is color
 *
 * @param $color string
 *
 * @return bool
 */
function g5core_is_color($color) {
	$rgba = g5core_color_to_rgba($color);
	return !empty($rgba);
}