<?php
define( 'WP_CACHE', true ); // Added by WP Rocket

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
define( 'DB_NAME', 'rma' );

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
define( 'AUTH_KEY',         'y*NMD+RkNG.3RA*apA(PBj}$SQ+&W@bi+9N&Y:ARia12r!tRUjd~&[e81$4C<>];' );
define( 'SECURE_AUTH_KEY',  '9grPJu)-fBY~#g;>%`U+ewKZmWj>L~_HuA0GreN@,1bb$-gq-_5`7nlr>bt2!j_t' );
define( 'LOGGED_IN_KEY',    ' O$>R?I094A_%GJZcKBLk3)i]0;^-YOW,r+[t)}OjplHk>z=9vb.Y.558l#~6M<.' );
define( 'NONCE_KEY',        'T1Ht]Zy_[ s9fj-}2W[m.uY)oLS6Rjzp#{dkF>#NUB@mN%#%6]qK6j(aM@E@?!U~' );
define( 'AUTH_SALT',        '-9y0W(&sax!s/c;SBox(CgdGdxR,}cA~a=[3cw@``0-#%yeH:ptv.m4ct`>$n6X;' );
define( 'SECURE_AUTH_SALT', 'IbVU$za^-gi4:2Cj-Z6cz(Grz9X?GZAG?N.}M8i,0?6E/N_m@uR3ml!43~n[Fp]q' );
define( 'LOGGED_IN_SALT',   'Tyad[N(cjIhG.iy2)?|}U rr4;[`Qt9v;({m1b&RL%]Rk.AB;i`XvuSI m4dYI9_' );
define( 'NONCE_SALT',       ';`p~b;7N*Udv0B[adz)N$cPxR_@k^ioiPnx]Fc~Yl~q`#PI&b.o:.H-3zc)&>F{r' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_tpnpoce08m_';

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
