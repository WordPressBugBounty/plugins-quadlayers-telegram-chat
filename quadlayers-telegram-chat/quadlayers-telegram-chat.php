<?php

/**
 * Plugin Name:             Telegram Button
 * Plugin URI:              https://quadlayers.com/products/telegram-chat/
 * Description:             Telegram Button allows your visitors to contact you or your team through Telegram chat with a single click.
 * Version:                 3.2.7
 * Text Domain:             quadlayers-telegram-chat
 * Author:                  QuadLayers
 * Author URI:              https://quadlayers.com
 * License:                 GPLv3
 * Domain Path:             /languages
 * Request at least:        4.7
 * Tested up to:            6.9
 * Requires PHP:            5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

define( 'QLTGM_PLUGIN_NAME', 'Telegram Button' );
define( 'QLTGM_PLUGIN_VERSION', '3.2.7' );
define( 'QLTGM_PLUGIN_FILE', __FILE__ );
define( 'QLTGM_PLUGIN_DIR', __DIR__ . DIRECTORY_SEPARATOR );
define( 'QLTGM_PREFIX', 'qltgm' );
define( 'QLTGM_DOMAIN', QLTGM_PREFIX );
define( 'QLTGM_WORDPRESS_URL', 'https://wordpress.org/plugins/quadlayers-telegram-chat/' );
define( 'QLTGM_REVIEW_URL', 'https://wordpress.org/support/plugin/quadlayers-telegram-chat/reviews/?filter=5#new-post' );
define( 'QLTGM_GROUP_URL', 'https://www.facebook.com/groups/quadlayers' );

/**
 * Load composer autoload
 */
require_once __DIR__ . '/vendor/autoload.php';
/**
 * Load vendor_packages packages
 */
require_once __DIR__ . '/vendor_packages/wp-i18n-map.php';
require_once __DIR__ . '/vendor_packages/wp-dashboard-widget-news.php';
require_once __DIR__ . '/vendor_packages/wp-plugin-table-links.php';
require_once __DIR__ . '/vendor_packages/wp-notice-plugin-promote.php';
require_once __DIR__ . '/vendor_packages/wp-plugin-suggestions.php';
require_once __DIR__ . '/vendor_packages/wp-plugin-install-tab.php';
require_once __DIR__ . '/vendor_packages/wp-plugin-feedback.php';
/**
 * Load plugin classes
 */
require_once __DIR__ . '/lib/helpers.php';
require_once __DIR__ . '/lib/class-plugin.php';

register_activation_hook(
	QLTGM_PLUGIN_FILE,
	function () {
		do_action( 'qltgm_activation' );
	}
);
