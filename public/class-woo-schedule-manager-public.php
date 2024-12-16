<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       woo-schedule-manager
 * @since      1.0.0
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/public
 * @author     Md Rabiul Islam <rabiul.islam@selise.ch>
 */
class Woo_Schedule_Manager_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version; 
		add_action('wp_loaded',array($this,'enqueue_scripts'));  
		//add html in before checkout form
 
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Schedule_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Schedule_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-schedule-manager-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Schedule_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Schedule_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
 

		wp_register_script($this->plugin_name.'_frontend', plugin_dir_url(__FILE__). 'js/woo-schedule-manager-public.js', array('jquery'), $this->version, TRUE); 
        wp_enqueue_script($this->plugin_name.'_frontend');

		wp_localize_script($this->plugin_name.'_frontend', 'schedule_time_ajax', array('custom_ajax_url' => admin_url('admin-ajax.php')));


	}

	 


 


}
