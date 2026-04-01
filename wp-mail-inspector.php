<?php
/**
 * Plugin Name: WP Mail Inspector
 * Description: Logs all wp_mail() activity
 * Author: Logic Net - Michał Bryja
 * Version: 1.0
 */

if (!defined('ABSPATH'))
    exit;

define('WMI_PATH', plugin_dir_path(__FILE__));
define('WMI_URL', plugin_dir_url(__FILE__));

/**
 * Load required files for activation
 */
require_once WMI_PATH . 'includes/class-database.php';

/**
 * Activation hook
 */
register_activation_hook(__FILE__, function () {
    \WMI\Database::install();
});
register_activation_hook(__FILE__, ['\WMI\Plugin', 'activate']);
register_deactivation_hook(__FILE__, ['\WMI\Plugin', 'deactivate']);
/**
 * Load plugin core
 */
require_once WMI_PATH . 'includes/class-plugin.php';

/**
 * Init plugin
 */
function wmi_init()
{
    return \WMI\Plugin::instance();
}

wmi_init();