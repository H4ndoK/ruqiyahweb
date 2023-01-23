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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bismillah' );

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
define( 'AUTH_KEY',         '*VpZS8-,Dc5aHB>Rm[dctinY,Dlo;,L%nqnDy~Z?zD!lt*PS@;+Jtj0&4&eR*8]s' );
define( 'SECURE_AUTH_KEY',  '(CiStba7H.v:Tg`ERie1l8PW5FwlT|vsGc~Bc+M`YYo)?AO@7hwcP~b,=GdBQc)[' );
define( 'LOGGED_IN_KEY',    'y.)genUSb~|JK;IH({L552bP>%)G29[[W}yN;~G2ls$gpI/9xr__~<t^FWgZ5wIv' );
define( 'NONCE_KEY',        '?ZyInP^%pv%CudG[-I1y=V<0)SheBS4H__O#WgLE!eW7)vWMxNc,K{W4J G*2S~k' );
define( 'AUTH_SALT',        '/}:$gcs{V|/!KX8~$]V[r(ki_EZ%CR)v}VHa`C!V]/18F*g!SC43 i}v,!fZ1}-0' );
define( 'SECURE_AUTH_SALT', 'HY_v:i-/5K:4:LC2*m<km!k,.,2wenLJUQfLZmdDz~eyt4ASw Pn:xz>j;y3b<}V' );
define( 'LOGGED_IN_SALT',   'hgP-fxrE(O;+5JS ?_]A>tu&6>)TgjQ+b#^c3/j6/;N#y>B+EkkB@Vn>a3wE;p!R' );
define( 'NONCE_SALT',       '|YG(eRCrx#mN03?t_RAFkhh#5-FxinUVc]X/%O*/Ks]}x@bqb4gvv.6278jtT`jf' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
