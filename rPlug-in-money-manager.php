<?php

	/**
	* The plugin bootstrap file
	*
	* This file is read by WordPress to generate the plugin information in the plugin
	* admin area. This file also includes all of the dependencies used by the plugin,
	* registers the activation and deactivation functions, and defines a function
	* that starts the plugin.
	*
	* @link              https://github.com/rabiul-islam
	* @since             1.0.0
	* @package           Money_manager
	*
	* @wordpress-plugin
	* Plugin Name:       Money manager
	* Plugin URI:        https://github.com/rabiul-islam
	* Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
	* Version:           1.0.0
	* Author:            Md Rabiul Islam
	* Author URI:        https://www.rabiulislam.info/
	* License:           GPL-2.0+
	* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	* Text Domain:       money-manager
	* Domain Path:       /languages
	*/

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	/**
	* Currently plugin version.
	* Start at version 1.0.0 and use SemVer - https://semver.org
	* Rename this for your plugin and update it as you release new versions.
	*/
	define( 'WOO_SCHEDULE_MANAGER_VERSION', '1.0.0' );

	/**
	* The code that runs during plugin activation.
	* This action is documented in includes/class-woo-schedule-manager-activator.php
	*/
	function activate_woo_schedule_manager() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-schedule-manager-activator.php';
		Woo_Schedule_Manager_Activator::activate();
	}

	/**
	* The code that runs during plugin deactivation.
	* This action is documented in includes/class-woo-schedule-manager-deactivator.php
	*/
	function deactivate_woo_schedule_manager() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-schedule-manager-deactivator.php';
		Woo_Schedule_Manager_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_woo_schedule_manager' );
	register_deactivation_hook( __FILE__, 'deactivate_woo_schedule_manager' );

	/**
	* The core plugin class that is used to define internationalization,
	* admin-specific hooks, and public-facing site hooks.
	*/
	require plugin_dir_path( __FILE__ ) . 'admin/crud-schedule-page-func.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-woo-schedule-manager.php';

	/**
	* Begins execution of the plugin.
	*
	* Since everything within the plugin is registered via hooks,
	* then kicking off the plugin from this point in the file does
	* not affect the page life cycle.
	*
	* @since    1.0.0
	*/ 
	//time zone
	 date_default_timezone_set("Europe/Zurich");   

	// Set session variables
	 //$_SESSION["shipping_type"] = "takeaway";  

	//ajax data
	function schedule_ajax_function(){ 	 
		
		 
	}  



	function run_woo_schedule_manager() { 
		$plugin = new Woo_Schedule_Manager();
		$plugin->run();

	}
	run_woo_schedule_manager();
