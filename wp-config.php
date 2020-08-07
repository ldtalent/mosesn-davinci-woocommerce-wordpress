<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecommerce' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ilZWF,Z[ZDroOE&Qs+iQ(.+U*,,e6L/8%]{JG{#1oF>3nu}Kr{?~pThar7;-HCF[' );
define( 'SECURE_AUTH_KEY',  'waVa#t/P5j|w^nRNIBoNMA#WG2S0=KDks|)a]EfVm`vt{S7Z,!|B{F/T-sGGK?}0' );
define( 'LOGGED_IN_KEY',    'rCWLEB,_bz93?5*A3*6Xf2ch!c>yua@aSs}ERUVY&u*oy9)eS1dKa;_T}Rvh=[={' );
define( 'NONCE_KEY',        'j%Ay!F+_*@Kht2_o}Pm~Aw-ghg&zhX>4A`!lx1E94A Mh(m]>ZK2O|==w$3jX0>J' );
define( 'AUTH_SALT',        'w1$RrISBeb4TGBR%6nZVL]o^(L<]ZY$y>d)kM;J#:@PnO4w|7yfdp,FobGFl5A>-' );
define( 'SECURE_AUTH_SALT', '7go*~Gm.8v 0uKg/|@%&$YBCg54}%0}Kegc{d:h%j>4eM0zMqUR!=zxu$* 8gr}D' );
define( 'LOGGED_IN_SALT',   'jDNpM%[qhWdOJIXN*04y8 or8D,p86^Pvjh<-FpI>Bw:5B+F9eo}D3+Dfw-@-$:#' );
define( 'NONCE_SALT',       'J4ddfyU5Sh3R_5!qJ65{jM;WhE)ZQA[TaK(skwY}0:>+MWn6]Vz3{Qd6S./`D w-' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
