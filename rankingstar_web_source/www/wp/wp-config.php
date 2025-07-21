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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rankingstar' );

/** MySQL database username */
define( 'DB_USER', 'rankingstar' );

/** MySQL database password */
define( 'DB_PASSWORD', 'rank2020!' );

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
define( 'AUTH_KEY',         '/e^B7NzuJs7ID7ybUQ{pruVI{B&b23/<~>.D<nX5Hi1;U*7Y-wdcQdk<. .LX?_#' );
define( 'SECURE_AUTH_KEY',  '`0/k@yyq]rs,e=e8$E4u9;G4F$:QzDlvv]]XxlIy&N4_8[J,r0m%+)oTTe%&8I&M' );
define( 'LOGGED_IN_KEY',    'tz31R0p]7~BP>K<zG?.5-)PG/3(v80(J<i{|UM^pYZlrLhPG=$O=,mH5EDs;zi^E' );
define( 'NONCE_KEY',        'afCgohf3:P4vp:O32)gX *<38lg&|[ND <5^z$9S6|M<>-+ Jg+|(M6ps@-JQ*2w' );
define( 'AUTH_SALT',        'VH^MCBs)//=s|IZhf6<Suc[E#b{;1)A(i[YwQZKbD0+U+?UT-P<We!&+1TJyY?*^' );
define( 'SECURE_AUTH_SALT', 'YQ]rL*C%7a7%9^P b~*<8Z7DVS565,15I>#EYE/}~kn|(Upc<npC,~W3Zt:|l3u_' );
define( 'LOGGED_IN_SALT',   'O)RMnC]Y,d~xqQtC2NxzLbUke[upQxg%f%$,N%&t-MujX7dXzGIpz#^ryr`}mMoh' );
define( 'NONCE_SALT',       '*e?E_r1M`B0opZEob=G^587FWNit2i&ud7lS@Aa=F!*3cj^}?2l#V`@%}{Su!u__' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
/* custom security setting */
define('DISALLOW_FILE_EDIT',true);
define('WP_POST_REVISIONS',7);
define('IMAGE_EDIT_OVERWRITE',true);
define('DISABLE_WP_CRON',true);
define('EMPTY_TRASH_DAYS',7);
