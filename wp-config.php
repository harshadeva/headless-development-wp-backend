<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'blog_wp' );

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

define('JWT_AUTH_SECRET_KEY', '*b|p^9k{LUr$Ibj<O9+L23443b');

define('JWT_AUTH_CORS_ENABLE', true);

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
define( 'AUTH_KEY',         'gl6MYY#G;$s;Zt~S8}%7-x:]7C1)?]B[L6smcYs5p6mM}*,`WJ@3OSob]VPdLxo-' );
define( 'SECURE_AUTH_KEY',  ';L*KwP@g*b|p^9k{LUr$Ibj<O9+Lp+gYM]~d(9:NIDe~7q?z:_nAdVcE!r! R^xS' );
define( 'LOGGED_IN_KEY',    'FID%,Xno*@-8u7kL0a;e`z/0~s n<J]VR*maK6Ut%3w/kb}7Jpgn.yR<?+j`;+wD' );
define( 'NONCE_KEY',        'N;etCl(T({E;u!3robWytZ>!(CgeT4s4}p|Od=|Wqk%dR2tmbhTQ5,g0G8V6ZUg>' );
define( 'AUTH_SALT',        'ukt8W}[mW0`qA7qoa$?-G(z[YS~zKQg~zL`)7Iq|+]f Z{wf~Ie^F`K*Je,2N_;u' );
define( 'SECURE_AUTH_SALT', 'sAXt`Ao%soFs;@mOLmI},S!8DnZ<wqpc~KA={nCuMAk]kB|Dnt#qrRaoa7|7y/Wk' );
define( 'LOGGED_IN_SALT',   '>z*1#aJi<O/M7MAyV;QuOk)`79I`.kGC{6r[W@o+W92%a_1+>bx9]NNGz90$ct(M' );
define( 'NONCE_SALT',       '<zYJ/-0(;1{Lb;^Swi}}}<JHOfNt^5LVsHI:4Gf(Rq<!h6uA#J}WaMpRl} =9hJ?' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
