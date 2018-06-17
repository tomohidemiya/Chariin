<?php
/**
 * Plugin Name: GermanSuPress-Payment for Pay.jp
 * Plugin URI:  https://XXX.io
 * Description: Add Payment function of Pay.jp to your WordPress site.
 * Author:      Tomohide Miya
 * Author URI:  https://xxx.io
 * Version:     0.0.1
 * Text Domain: gp-payment-for-payjp
 * Domain Path: /i18n
 *
 * @copyright   2018 Tomohide Miya All rights reserved.
 */

// constのdefine
define( 'GP3_VERSION',              '1.0.0' );
define( 'GP3_REQUIRED_WP_VERSION',  '4.8' );
define( 'GP3_PLUGIN',               __FILE__ );
define( 'GP3_PLUGIN_BASENAME',      plugin_basename( GP3_PLUGIN ) );
define( 'GP3_PLUGIN_NAME',          trim( dirname( GP3_PLUGIN_BASENAME ), '/' ) );
define( 'GP3_PLUGIN_DIR',           untrailingslashit( dirname( GP3_PLUGIN ) ) );
require_once GP3_PLUGIN_DIR . '/settings.php';

register_activation_hook( __FILE__,     array( 'GP3', 'gp3_activate' ) );
register_deactivation_hook( __FILE__,   array( 'GP3', 'gp3_deactivate' ) );

require_once GP3_PLUGIN_DIR . '/admin/admin.php';
require_once GP3_PLUGIN_DIR . '/vendor/autoload.php';
require_once GP3_PLUGIN_DIR . '/includes/payjp-interface.php';
require_once GP3_PLUGIN_DIR . '/shortcode/shortcodes.php';
require_once GP3_PLUGIN_DIR . '/rest/gp4_rest_controller.php';
