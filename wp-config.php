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

define( 'DB_NAME', "attsoft_ewthopscan" );



/** MySQL database username */

define( 'DB_USER', "attsoft_ewthopscan" );



/** MySQL database password */

define( 'DB_PASSWORD', "attsoft_ewthopscan" );

//we are using mongodb

/** MySQL hostname */

define( 'DB_HOST', "localhost" );



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

define( 'AUTH_KEY',         'UF*bh)H}=U|11Px6*-&yL0+(lI/z[2ggKED~T%n(xxHb/t0^B8$EgiutB.7nL%&0' );

define( 'SECURE_AUTH_KEY',  '0eW)hn,0//)s+wTas7I8ABur:n?v}3>m_1/+B[0i+oyr!,[/jz8e;V3BCng(Rri*' );

define( 'LOGGED_IN_KEY',    'JLE3L,6|#.v[5`Gg/y2Y5>Dl95-3z35JMcD#S1_JvSIUfvE3cN `mK`8HeM~9z<c' );

define( 'NONCE_KEY',        'SPKTNKN:wDx#?K,:d2Z+SF-/9Zaq99{)GBJ7qlK!N@@d[vGd.+^0DzMP)N_ff_o{' );

define( 'AUTH_SALT',        '@=@nbBqC=#6^<XQP<vu3TraRT2l4XAo7)b$}l?8<m5#;BL~u/C^Y]|8v:@MD3-[;' );

define( 'SECURE_AUTH_SALT', 's*D>M!x9WywOKr@binxF,.J_rP<DJ:b_wN6GwHP2fYJ_/k=V]wvj]S|WirBu(|JB' );

define( 'LOGGED_IN_SALT',   'D+D2YLQ^X%b3eNk0(TVyM)]R5MdB(q`u;vXfCcQ{{K@q[YsI!mUt=}|M#AY^? @N' );

define( 'NONCE_SALT',       'K_U^w^&ex4q0g#Ao <a;T]erwCU8iZ:)*iB2zkL{4e%WYj=OT.E![]YTxte)x@:*' );



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

define( 'WP_DEBUG', true );



/* That's all, stop editing! Happy publishing. */



/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

