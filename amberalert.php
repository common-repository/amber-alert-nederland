<?php
/*
Plugin Name: Amber Alert
Plugin URI: http://wordpress.org/extend/plugins/amberalert/
Description: Amber Alert Nederland popup: shows only a few times a year a popup when children are missing 
Author: Edward de Leau
Author URI: http://edward.de.leau.net
Version: 0.0.2
License: GPLv2
*/
ini_set('display_errors',1);
error_reporting(E_ALL & ~E_STRICT);

/**
 * To run when this plugin is activated
 * {@link http://codex.wordpress.org/Function_Reference/register_activation_hook}
 */
register_activation_hook( __FILE__ , 'amber_alert__client_install');
function amber_alert__client_install() {
	global $wp_version;
	if (version_compare($wp_version, "3.1", "<")) {
		deactivate_plugins(basename( __FILE__ ));
		wp_die("This plugin requires WordPress version 3.1 or higher");
	}
	if (version_compare(phpversion(), "5.3.0", "<")) {
		deactivate_plugins(basename( __FILE__ ));
		wp_die("This plugin requires at least PHP version 5.3.0, your version: " . PHP_VERSION . "\n".
				"Please ask your hosting company to bring your PHP version up to date.");
	}
	$amber = get_option('amberalert_client_options');
	$amber['FINAL'] = false;
	update_option('amberalert_client_options', $amber);	
}

/**
 * To run when this plugin is deactivated
 * {@link http://codex.wordpress.org/Function_Reference/register_deactivation_hook}
 */
register_deactivation_hook( __FILE__ ,'amber_alert__client_uninstall');
function amber_alert__client_uninstall() {
	$amber = get_option('amberalert_client_options');
	$amber['FINAL'] = false;
	update_option('amberalert_client_options', $amber);
}

/**
 * To run when the plugin is deinstalled: no database stuff on client side
 */
if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__, 'amber_alert__client_uninstall_hook');
function amber_alert__client_uninstall_hook()
{
	delete_option('amberalert_client_options');
}

/**
 * load specific configuration and run with extra php check to not fail on
 * older PHP versions
 */
if (version_compare(phpversion(), "5.3.0", ">=")) {
	add_action('plugins_loaded','Runamber_alert_',5);
	function Runamber_alert_() {
		require_once dirname( __FILE__  ) . '/includes/client/class-load-configuration.php';

	}
}
