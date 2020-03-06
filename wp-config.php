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
define('DB_NAME', 'music');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '8krg}eH[j4V}>-{<al$p[$)(z_wP0.#?5aN:ZEHMrZ1`pYKfo QU$5~Tz;WqV`K}');
define('SECURE_AUTH_KEY',  'i _RRow<_RL[~>,*(.kia[f%lLB8=Qfg]Zba6c}c^r?JV3u@==E-Y4[s>r.F5%rU');
define('LOGGED_IN_KEY',    'k|ijv/1I}@D]`I9L;!S:F`uBnsa9|-/T0[W6k:>iA]rpz=y*+C42O+u;egEwENJn');
define('NONCE_KEY',        '@IlvLAs6]S3^0_8q1)2;bg nppB%WbvcI{]^KbS^{=H>0*)^1aQP3&uv99Dh[qc2');
define('AUTH_SALT',        '*&#}EOzL{{WrM=5^{,zFtZ&kB0RGG3d!;Z-g/hCtNqXgL]VHc42M;lE%{|w)~}*i');
define('SECURE_AUTH_SALT', 'xp$) +,4=x7+mNX{1xzre=l5Dgl /TC?n9`%zE<tXFfq0MgwERR;<l$|>zU|qXNF');
define('LOGGED_IN_SALT',   '(2:DgM}T6m@9VG1+lft$jb_sz|DRk^bD IFEdXxO?-)BEUM`0#cl0+$(&<2_^:c|');
define('NONCE_SALT',       'e+Wnlv:Og<OlRV:$^*D[;b) :kH;>Q%s>,qtaHCur<,oS>^o /2Mo%iDbPd~XBy/');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
 * @link https://codex.wordpress.org/Debugging_in_WordPress */
 @ini_set ('upload_max_size' , '700');
 
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
