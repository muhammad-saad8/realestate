<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'realestate' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/QFxD8 Rv*Vm+nyJ^%]Oq(|jNplk>L.!=S&%]ejz]T0`CB8O!eOzMA_GUG&JCj]p' );
define( 'SECURE_AUTH_KEY',  'P>9+X@j)1alj#5u?m,<qz33?pcK,&az$=4u4%2[8VcJ_quo}jIalf[gKCgo.&6P.' );
define( 'LOGGED_IN_KEY',    'dRAp13xJqb1)6S,J~K3Qr=oPnsIa?vJw}L6ENO+Q_:;<;#@QPm`w/fDn]F=llXL ' );
define( 'NONCE_KEY',        '~C]av_q RUCX^/+/l}d^:TaBP.Ut4+H_Fb[? 1/gxx[YP;0Yc[*,.NT{.tF%vHWJ' );
define( 'AUTH_SALT',        'Tar}l;/tCU6[KzA#d^el)A{/24tibQKcX&VL_#7i&`CWH5G)Ugj.r_v@xM7<SxDu' );
define( 'SECURE_AUTH_SALT', '*}d2gkS7Ag&,HfvU&LoXF<P2`k9pT<8?fg5YsBE,CRI*[&zBo$_q:QC0vw.M, _z' );
define( 'LOGGED_IN_SALT',   '_7k01HaWj0LKNgu=,30F.|+)f}V95ZxY26QR9Y`yI>BwXaYZ6cRII18[mF5t+VwA' );
define( 'NONCE_SALT',       ' @7vj^W-$WZQcB;$ZqkDg(=+pYSLiO~P5Ox 9y1<<5-A~NO(pQ#sN>Y{{9MK);b;' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
