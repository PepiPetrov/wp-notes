<?php
/*
Plugin Name: WP-CRM System - Notes & Email
Plugin URI: https://www.wp-crm.com
Description: WP-CRM System - Notes & Email
Version: 1.0
Author: Premium WordPress Support
Author URI: https://www.wp-crm.com
Text Domain: wp-crm-system-notes-email
*/

if (!defined('WPCRM_BASE_STORE_URL')) {
	define('WPCRM_BASE_STORE_URL', 'https://staging.wp-crm.com'); // To be updated once live
}

if (!class_exists('WPCRM_SYSTEM_SL_Plugin_Updater')) {
	// load our custom updater
	require dirname(__FILE__) . '/EDD_SL_Plugin_Updater.php';
}

function wpcrm_notes_email_updater()
{

	// retrieve our license key from the DB
	$license_key = trim(get_option('wpcrm_notes_email_license_key'));

	// setup the updater
	$edd_updater = new WPCRM_SYSTEM_SL_Plugin_Updater(
		'https://staging.wp-crm.com', // To be updated once live
		__FILE__,
		array(
			'version'   => '1.0',   						// current version number
			'license'   => $license_key,                    // license key (used get_option above to retrieve from DB)
			'item_name' => 'WP-CRM System - Notes & Email', // name of this plugin
			'author'    => 'Premium WordPress Support',     // author of this plugin
		)
	);
}
add_action('admin_init', 'wpcrm_notes_email_updater', 0);
function wpcrm_notes_email_activate_license()
{

	// listen for our activate button to be clicked
	if (isset($_POST['wpcrm_notes_email_activate'])) {

		// run a quick security check
		if (!check_admin_referer('wpcrm_plugin_license_nonce', 'wpcrm_plugin_license_nonce')) {
			return; // get out if we didn't click the Activate button
		}

		// retrieve the license from the database
		$license = trim(get_option('wpcrm_notes_email_license_key'));

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode('WP-CRM System - Notes & Email'), // the name of our product in EDD
			'url'        => home_url(),
		);

		// Call the custom API.
		$response = wp_remote_post(
			WPCRM_BASE_STORE_URL,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params,
			)
		);

		// make sure the response came back okay
		if (is_wp_error($response)) {
			return false;
		}

		// decode the license data
		$license_data = json_decode(wp_remote_retrieve_body($response));

		// $license_data->license will be either "valid" or "invalid"

		update_option('wpcrm_notes_email_license_status', $license_data->license);
	}
}
add_action('admin_init', 'wpcrm_notes_email_activate_license');

function wpcrm_notes_email_deactivate_license()
{

	// listen for our activate button to be clicked
	if (isset($_POST['wpcrm_notes_email_deactivate'])) {

		// run a quick security check
		if (!check_admin_referer('wpcrm_plugin_license_nonce', 'wpcrm_plugin_license_nonce')) {
			return; // get out if we didn't click the Activate button
		}

		// retrieve the license from the database
		$license = trim(get_option('wpcrm_notes_email_license_key'));

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode('WP-CRM System - Notes & Email'), // the name of our product in EDD
			'url'        => home_url(),
		);

		// Call the custom API.
		$response = wp_remote_post(
			WPCRM_BASE_STORE_URL,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params,
			)
		);

		// make sure the response came back okay
		if (is_wp_error($response)) {
			return false;
		}

		// decode the license data
		$license_data = json_decode(wp_remote_retrieve_body($response));

		// $license_data->license will be either "deactivated" or "failed"
		if ($license_data->license == 'deactivated') {
			delete_option('wpcrm_notes_email_license_status');
		}
	}
}
add_action('admin_init', 'wpcrm_notes_email_deactivate_license');

function wpcrm_notes_email_register_option()
{
	// creates our settings in the options table
	register_setting('wpcrm_license_group', 'wpcrm_notes_email_license_key', 'wpcrm_notes_email_sanitize_license');
}
add_action('admin_init', 'wpcrm_notes_email_register_option');

function wpcrm_notes_email_sanitize_license($new)
{
	$old = get_option('wpcrm_notes_email_license_key');
	if ($old && $old != $new) {
		delete_option('wpcrm_notes_email_license_status'); // new license has been entered, so must reactivate
	}
	return $new;
}
add_action('admin_init', 'register_wpcrm_wpcrm_notes_email_settings');

function register_wpcrm_wpcrm_notes_email_settings()
{
	register_setting('wpcrm_notes_email_settings_group', 'wpcrm_notes_email_app_key');
}

// Add notes_email Settings
function wpcrm_notes_email_setting_tab()
{
	global $wpcrm_active_tab; ?>
	<a class="nav-tab <?php echo $wpcrm_active_tab == 'notesemail' ? 'nav-tab-active' : ''; ?>" href="?page=wpcrm-settings&tab=notesemail"><?php _e('Notes & Email', 'wp-crm-system-notes-email'); ?></a>
<?php
}
add_action('wpcrm_system_settings_tab', 'wpcrm_notes_email_setting_tab');

function wpcrm_notes_email_settings_content()
{
	global $wpcrm_active_tab;
	if ($wpcrm_active_tab == 'notesemail') {
		include plugin_dir_path(__FILE__) . 'settings.php';
	}
}
add_action('wpcrm_system_settings_content', 'wpcrm_notes_email_settings_content');

// Add license key settings field
function wpcrm_notes_email_license_field()
{
	include plugin_dir_path(__FILE__) . 'license.php';
}
add_action('wpcrm_system_license_key_field', 'wpcrm_notes_email_license_field');

// Add license key status to Dashboard
function wpcrm_notes_email_dashboard_license($plugins)
{
	// the $plugins parameter is an array of all plugins

	$extra_plugins = array(
		'notes_email' => 'wpcrm_notes_email_license_status',
	);

	// combine the two arrays
	$plugins = array_merge($extra_plugins, $plugins);

	return $plugins;
}
add_filter('wpcrm_system_dashboard_extensions', 'wpcrm_notes_email_dashboard_license');


require_once '/xampp/htdocs/wordpress/wp-content/plugins/wp-crm-notes-email/src/post-type.php';

add_action('init', 'register_type');
