<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       woo-schedule-manager
 * @since      1.0.0
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/admin
 * @author     Md Rabiul Islam <rabiul.islam@selise.ch>
 */
class Woo_Schedule_Manager_Admin
{

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array($this, 'store_manager_menu'));
		add_action('wp_loaded', array($this, 'enqueue_scripts'));
		//echo plugin_dir_url( __FILE__ );

		//transaction ajax add action
		add_action('wp_ajax_schedule_ajax_action', array($this, 'schedule_ajax_function'));
		add_action('wp_ajax_nopriv_schedule_ajax_action', array($this, 'schedule_ajax_function'));


		//cashflow ajax add action
		add_action('wp_ajax_cashflow_ajax_action', array($this, 'cashflow_ajax_function'));
		add_action('wp_ajax_nopriv_cashflow_ajax_action', array($this, 'cashflow_ajax_function'));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-schedule-manager-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-schedule-manager-admin.js', array('jquery'), $this->version, TRUE);
		wp_enqueue_script($this->plugin_name);

		wp_localize_script($this->plugin_name, 'schedule_time_ajax', array('custom_ajax_url' => admin_url('admin-ajax.php')));

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-schedule-manager-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function store_manager_menu()
	{
		add_menu_page('Store Manager', 'Store Manager', 'storeManager', 'storeManager', plugin_dir_url(__FILE__) . '/images/settings_gray.png');
		add_submenu_page('storeManager', "Time", "Account Head", 8, 'account_head', array($this, 'account_head'));

		add_submenu_page('storeManager', "Time", "All Transactions", 8, 'all_transection_page', array($this, 'all_transection_page'));
		add_submenu_page('storeManager', "Time", "Cash Flow", 8, 'cash_flow_page', array($this, 'cash_flow_page'));
		// 3=name, 6=slug 
	}

	public function account_head()
	{
		include_once(plugin_dir_path(__FILE__) . 'partials/add-expense-admin-display.php');
	}

	public function cash_flow_page()
	{
		include_once(plugin_dir_path(__FILE__) . 'partials/cash-flow-page-display.php');
	}
	public function all_transection_page()
	{
		include_once(plugin_dir_path(__FILE__) . 'partials/all-transection-page-display.php');
	}

	public function schedule_time_data_func()
	{
		//get data
		$serialised = get_option('schedule_opening_and_closing_time');
		$data = maybe_unserialize($serialised);
		return $data;
	}



	//transaction ajax data
	public function schedule_ajax_function()
	{
		global $wpdb;
		$select_type_val =  $_POST['select_type_val']; //choose dropdown 
		$table_name = $wpdb->prefix . "accm_account_type";
		$category_array = $wpdb->get_results("SELECT * FROM $table_name where bill_type='$select_type_val'");
		echo '<option>Select ' . $select_type_val . ' Type </option>';
		foreach ($category_array as $category) { ?>
			<option value="<?php echo $category->title ?>"><?php echo $category->title ?></option>
		<?php }
		wp_die();
	}

	//cashflow ajax data
	public function cashflow_ajax_function()
	{
		global $wpdb;
		$select_year_val =  $_POST['select_year_val']; //choose dropdown 
		$table_name = $wpdb->prefix . "accm_transactions";
		$all_transactions_array = $wpdb->get_results("SELECT account_head,
		MAX(CASE WHEN month = 1 THEN amount ELSE 0 END) AS January,
		MAX(CASE WHEN month = 2 THEN amount ELSE 0 END) AS February,
		MAX(CASE WHEN month = 3 THEN amount ELSE 0 END) AS March,
		MAX(CASE WHEN month = 4 THEN amount ELSE 0 END) AS April,
		MAX(CASE WHEN month = 5 THEN amount ELSE 0 END) AS May,
		MAX(CASE WHEN month = 6 THEN amount ELSE 0 END) AS June,
		MAX(CASE WHEN month = 7 THEN amount ELSE 0 END) AS July,
		MAX(CASE WHEN month = 8 THEN amount ELSE 0 END) AS August,
		MAX(CASE WHEN month = 9 THEN amount ELSE 0 END) AS September,
		MAX(CASE WHEN month = 10 THEN amount ELSE 0 END) AS October,
		MAX(CASE WHEN month = 11 THEN amount ELSE 0 END) AS November,
		MAX(CASE WHEN month = 12 THEN amount ELSE 0 END) AS December
		FROM $table_name
		GROUP BY account_head;");

		foreach ($all_transactions_array as $transaction) {
		?>
			<tr>
				<td><?php echo $transaction->account_head; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td><?php echo $transaction->amount; ?></td>
				<td>----</td>
			</tr>
<?php }
		wp_die();
	}
}
