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
define('DB_NAME', 'document_management_system');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         'XxvqZby&dzZaayQ/W s!iRSX6d@$2Zy!sER/#pmp=f E}H2N9~u!dFR?k@DIMx1,');
define('SECURE_AUTH_KEY',  '4eS ns9#^q]R7]S6z>n*({o?yDn_N@:-*oij1& J}#r;#vI,;{%TG<JdPab8uz^(');
define('LOGGED_IN_KEY',    '2q)Eaixqhc(AS</H60TbW.n)hz/c7VGBM2cW-d` :I#5!ihg2k^@4icRYhLYM3oF');
define('NONCE_KEY',        '2R91wvelm:!T^d`a@j7j*!]eWjdD7 P,;;_H=?0KOqNC,iK.[_hPJ;rsP8&2 qsR');
define('AUTH_SALT',        'E=V*/e;^r~GaH|&X(}EmtQs%t%S;5_|!~S>Ap*]6cnKB=XS(j/A~x=<0uRI@lkHa');
define('SECURE_AUTH_SALT', 'dyYsNU48P]*~_$VHwaQ,akLEyoof&s#%=M$x-rIYC%( 92!Q~isfV&!CvX$hxl2t');
define('LOGGED_IN_SALT',   'U;RXq9Re`rJVXXn1(F)N9kJW;&#.L)Y?.r:N3I5^Uk|Q4@3*g6.4d>,POD9S3bXW');
define('NONCE_SALT',       'BezS6S.nQb 5wyCkyf@li1S!{@*^tQ9_lT_)-:h!y1F@?A* ]&5>Ek!eg$3JOf|o');

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
define('WP_DEBUG', false);
define('FS_METHOD', 'direct');

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
