<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ovoads.com
 * @since             1.0.0
 * @package           Ovoads
 *
 * @wordpress-plugin
 * Plugin Name:       Ovoads
 * Plugin URI:        https://ovosolution.com/plugins/ovoads
 * Description:       Let's create your own ads.Ovoads gives you to create and manage your own ads.
 * Version:           1.0.0
 * Requires at least: 4.7
 * Tested up to:      6.4
 * Author:            Ovosolution
 * Author URI:        https://ovosolution.com
 * Text Domain:       ovoads
 * Domain Path:       /languages
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

use Ovoads\Hook\Hook;
use Ovoads\Includes\Activator;

require_once __DIR__.'/vendor/autoload.php';

define('OVOADS_PLUGIN_VERSION', ovoads_system_details()['version']);
define('OVOADS_ROOT', plugin_dir_path(__FILE__));

include_once(ABSPATH . 'wp-includes/pluggable.php');


$activator = new Activator();
register_activation_hook( __FILE__, [$activator, 'activate']);
register_deactivation_hook( __FILE__, [$activator, 'deactivate']);

$system = ovoads_system_instance();
$system->bootMiddleware();
$system->handleRequestThroughRouter();

$hook = new Hook;
$hook->init();