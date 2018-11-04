<?php
/**
 * Plugin Name: GermanSuPress-Payment for Pay.jp
 * Plugin URI:  https://XXX.io
 * Description: Add Payment function by Pay.jp to ALL WordPress site.
 * Author:      Tomohide Miya(A4Next inc.)
 * Author URI:  https://xxx.io
 * Version:     0.0.1
 * Text Domain: gp-payment-for-payjp
 * Domain Path: /i18n
 *
 * @copyright   2018 Tomohide Miya All rights reserved.
 */

define( 'A4N_PAY_VERSION',              '1.0.0' );
define( 'A4N_PAY_REQUIRED_WP_VERSION',  '4.8' );
define( 'A4N_PAY_PLUGIN',               __FILE__ );
define( 'A4N_PAY_PLUGIN_BASENAME',      plugin_basename( A4N_PAY_PLUGIN ) );
define( 'A4N_PAY_PLUGIN_NAME',          trim( dirname( A4N_PAY_PLUGIN_BASENAME ), '/' ) );
define( 'A4N_PAY_PLUGIN_DIR',           untrailingslashit( dirname( A4N_PAY_PLUGIN ) ) );
require_once A4N_PAY_PLUGIN_DIR . '/config/settings.php';

register_activation_hook( __FILE__,     array( 'A4N_PAY', 'a4n_activate' ) );
register_deactivation_hook( __FILE__,   array( 'A4N_PAY', 'a4n_deactivate' ) );

require_once A4N_PAY_PLUGIN_DIR . '/app/admin/admin.php';
require_once A4N_PAY_PLUGIN_DIR . '/vendor/autoload.php';
require_once A4N_PAY_PLUGIN_DIR . '/app/services/payjp-interface.php';
require_once A4N_PAY_PLUGIN_DIR . '/app/shortcodes/shortcodes.php';
require_once A4N_PAY_PLUGIN_DIR . '/app/rest/a4n_rest_controller.php';
