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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'derekweb_leap' );

/** MySQL database username */
define( 'DB_USER', 'derekweb_leap' );

/** MySQL database password */
define( 'DB_PASSWORD', "leapleap" );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'UP+DmmYCI0BZ537aXiAgbg4RDqJaBz5WTapsn9BGHSjPA5dfsLYjS/mcxUiuWaWZyDzDx2HW9HCoEnAFMWEvew==');
define('SECURE_AUTH_KEY',  'HsjvO7dQ+A4ZY7C+2OWAmaAqJYnmkQEuyZQsl2cP25tqHJ+pu3LhWQYGcbPvrxnuIztL7e/ib5+Crep5u8rhWA==');
define('LOGGED_IN_KEY',    'FSqej5YAgRkvdWmrmDjwfPBhvXhLeOamm9JZWXIHHG7pVYHiJYr1Zm7hdneGc0AOpR1+2K5abds3QVv7abimaQ==');
define('NONCE_KEY',        'Z2xcbl+lILtPEzJ1HJva5P8OoCEnZNN3f91M4n+DK+8rOvVN7rxzrSr2qjlwfHEyQbowq3P0/xcX2V9GCCSAOw==');
define('AUTH_SALT',        '/VlRwkFYxEwKZQjg4Ruwb57wAzesX0rdYUxhNSfPiAX1Oq2r3fn/aSphoDbfGToKtArq3O2DXFg1zZO9GtNJiw==');
define('SECURE_AUTH_SALT', 'k7rjpWLbYCVssyZk5e3UTwG2dI65JeglBfHN+MaEIeKqs6MrhwHjyjh9tnTdV6J40MEJ7WcrGA3WwkQMK25SKA==');
define('LOGGED_IN_SALT',   'oNDCh9+wF8zsOxYBEXaViuOdV7j2chHvviJ9xxii6ZyDSw00lbDwysNH9+ExhJvBEk6lbQvcsnF+v/3mXKP8GQ==');
define('NONCE_SALT',       '3ZcWZD356VbPeO8nVP9n9FfYpDxGLjguSJm0+btBk91nGjLxMYxPKyCKTICFr0/euy5dqrs9q6oGTEV8vxTYMQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';



@include_once('/var/lib/sec/wp-settings.php'); // Added by SiteGround WordPress management system

