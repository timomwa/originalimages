<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'original_images');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'XG7lMB`&^2>_:@=9c$P&b0)!iGEd;?s}ly9kCdJRfyS^f#TP=_pag9&?%f*]p (l');
define('SECURE_AUTH_KEY',  '>fXgST$Z5`lBz`1PxeUI/I}OK[kg=D[0^bX)l[@J^|bM?(OO^VRt,Qh+1l4{RacV');
define('LOGGED_IN_KEY',    ')XO_tLd$ZgWWBE>>y,vPd]+3GMh a;=WOofy]s^FPCnh/<d0p<`ylC#^Ck&A<D/ ');
define('NONCE_KEY',        'QaEse^5yQ_USEIMR=;?.TpZ6Uhz%Q{#wy0,Y%M)_U&Pji~6|g4GIs_FsQHy}^Ap$');
define('AUTH_SALT',        'DDMa^blU g-WCfh%8y` jlP0rxl24C!#NN{^xA2&x{4ZL4`mo?Gw!crkG=T^rwu)');
define('SECURE_AUTH_SALT', 'ck> (JZt+7Nm eySxY#xoloJ`Aun3FtR2,pS7X3(lQugbO%c{1#g^~@pM8xcU$1D');
define('LOGGED_IN_SALT',   'C}}S7`mw ;dfNr^Qx?#!{stHBb%%jAAS1rG[[1;pcUME>?bEbZXsFWcbY$FIh,=N');
define('NONCE_SALT',       'G^cffObu)_YHOkP.3>mBYR&SLjaXY@A[oEfX,j4ZTqcWUTk)(Z@QPAubJ+E.{7Xd');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'oi_blog_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
