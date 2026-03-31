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
define( 'DB_NAME', 'VANKHANH' );

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
define( 'AUTH_KEY',         'FF(H9I/,*R# |6xQrFb05UhYU+swwT)r=-uTkgWc| }w[*N]3TDv6ovy3&)aDMP*' );
define( 'SECURE_AUTH_KEY',  '|.5;9*u`NZ=+RbOh0_7VCD1`;:Op[y7Z}1i((=%Tp{e_:2zoVxsiI`U$rLjA +;]' );
define( 'LOGGED_IN_KEY',    '+8)|j^qOp]|kR%6FOE>r3fiY]=x=r:eg{$OVF?c(e/x98Oq>kw4,7Z7Vw`h/$G/[' );
define( 'NONCE_KEY',        'w,K#rqH=}Bh$yM(&YUvf.v%yPm<j_dR.7QXs9d,*.m$[TcHw<dikD>jnN8+HIfpW' );
define( 'AUTH_SALT',        'Y<ePa5Qwtd7)fi{Lse,2kf6?TEDEIQ,U,6$O@tF*!7tKnfm?W4ZafJ,}-WT^TRH4' );
define( 'SECURE_AUTH_SALT', '{*d~d={l.j!6;q1i}o9lTRQ<xHeg@)9G*G~8;X})4Itk>mW][-;?%yYcIA PAkP;' );
define( 'LOGGED_IN_SALT',   'J2y3@qV@2a nKOCT;1TTE]%-NJ<H/~+t/~R;)SgXH5)z=28F}W(k^`l`G}yYLX21' );
define( 'NONCE_SALT',       '9Stp6,m8coknj&SUZ[t^Z)hZR%0Wx<3t*@qk~MNN(lYm<Y&rX?Yp?N8E^VjyV]9~' );

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
