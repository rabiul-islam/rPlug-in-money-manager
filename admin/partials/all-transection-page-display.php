<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       woo-schedule-manager
 * @since      1.0.0
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/admin/partials
 */
//$data_controller = new Woo_Schedule_Manager_Admin($plugin_name='', $version='');

global $wpdb;
$table_name = $wpdb->prefix . "accm_transactions";
$wpdb->query('DELETE FROM ' . $table_name . ' WHERE order_id > 0');



global $woocommerce, $order;
// $EmptyTestArray = array_filter($transactions);
$orders = wc_get_orders(array(
	'limit' => -1,
	'type' => 'shop_order',
	'status' => array('wc-completed'),
	'orderby' => 'date',
	'order' => 'DESC',
));

// print_r($orders);



// Loop through each WC_Order object
foreach ($orders as $order) {
	$order_id = $order->get_id();
	$cost_of_goods = $order->get_meta('_wc_cog_order_total_cost');
	$shipping_cost = $order->get_shipping_total();
	$shipping_tax = $order->get_shipping_tax();
	$status = $order->get_status();
	$currency = get_woocommerce_currency_symbol();
	$amount	= $order->get_total();
	$transaction_date = date('Y-m-d', strtotime($order->get_date_created()));
	$need_save = 0;
	// print_r($order);
	$insert_array = array(
		'type'			=> 'income',
		'order_id' 		=> $order_id,
		'status'		=> $status,
		'amount' 		=> $amount,
		'shipping_cost' => $shipping_cost,
		'cost_of_goods'	=> $cost_of_goods,
		'account_head'	=> 'Sale',
		'transaction_date' => $transaction_date,
		'created_at' 	=> date('Y-m-d'),
		'updated_at' 	=> date('Y-m-d')
	);

	$success = $wpdb->insert($table_name, $insert_array);

	// foreach ($transactions as $transaction) {
	// 	if ($transaction->order_id != $order_id) {
	// 		// $need_save == 1;
	// 		//echo $order_id;echo '</br>'; 
	// 		$insert_array = array(
	// 			'type'			=> 'income',
	// 			'order_id' 		=> $order_id,
	// 			'status'		=> $status,
	// 			'amount' 		=> $amount,
	// 			'shipping_cost' => $shipping_cost,
	// 			'cost_of_goods'	=> $cost_of_goods,
	// 			'account_head'	=> 'Sale',
	// 			'transaction_date' => $transaction_date,
	// 			'created_at' 	=> date('Y-m-d'),
	// 			'updated_at' 	=> date('Y-m-d')
	// 		);

	// 		$success = $wpdb->insert($table_name, $insert_array);
	// 	}
	// }
	// if (empty($EmptyTestArray)) {
	// 	$need_save = 1;
	// }
	// if ($need_save == 1) {
	// 	$insert_array = array(
	// 		'type'			=> 'income',
	// 		'order_id' 		=> $order_id,
	// 		'status'		=> $status,
	// 		'amount' 		=> $amount,
	// 		'shipping_cost' => $shipping_cost,
	// 		'cost_of_goods'	=> $cost_of_goods,
	// 		'account_head'	=> 'Sale',
	// 		'transaction_date' => $transaction_date,
	// 		'created_at' 	=> date('Y-m-d'),
	// 		'updated_at' 	=> date('Y-m-d')
	// 	);

	// 	$success = $wpdb->insert($table_name, $insert_array);
	// }
}

$transactions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY transaction_date DESC");
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap schedule_time_admin">
	<?php if ($_GET['transaction']) { ?>
		<h2> <?php echo __('Transection'); ?><a href="?page=all_transection_page" class="button-primary">
				< Back</a>
		</h2>
		<table class="wp-list-table widefat striped table-view-list pages">
			<form method="post" id="schedule_form_id" autocomplete="off">
				<tbody>
					<tr class="form-field">
						<th> <?php echo __('Type'); ?> </th>
						<td>
							<select id="select_type_id" name="bill_type">
								<option value="expense">Expense</option>
								<option value="income">Income</option>
							</select>
						</td>
					</tr>
					<tr class="form-field">
						<th>Account Head</th>
						<td>
							<select id="account_head" name="account_head">
								<?php
								$table_name = $wpdb->prefix . "accm_account_type";
								$category_array = $wpdb->get_results("SELECT * FROM $table_name where bill_type='expense'");
								foreach ($category_array as $category) { ?>
									<option value="<?php echo $category->title ?>"><?php echo $category->title ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr class="form-field">
						<th> <?php echo __('Description'); ?> </th>
						<td>
							<textarea name="descriptions"></textarea>
						</td>
					</tr>
					<tr class="form-field">
						<th> <?php echo __('Amount'); ?> </th>
						<td>
							<input type="text" name="amount" required placeholder="Amount Enter here" />
						</td>
					</tr>
					<tr class="form-field">
						<th> <?php echo __('Date'); ?> </th>
						<td>
							<input type="text" id="datepicker" name="transaction_date" required placeholder="Date Enter here" />

						</td>
					</tr>
					<tr class="form-field">
						<td colspan="3">
							<input class="button-primary  schedule_submit_btn" type="submit" name="all_transactions_submit_btn" value="<?php echo __('Save'); ?>">
						</td>
					</tr>
				</tbody>
			</form>
		</table>
	<?php } else { ?>
		<div><a href="?page=all_transection_page&transaction=new" class="button-primary">Add New Transaction</a></div>
		<h2>All Transaction </h2>
		<table class="wp-list-table widefat fixed striped table-view-list pages">

			<thead>
				<tr>
					<th>Order Id</th>
					<th>Transaction Date</th>
					<th>Account Head</th>
					<th>Category</th>
					<th>Amount (<?php echo get_woocommerce_currency_symbol(); ?>)</th>
				</tr>
			</thead>
			<tbody id="the-list">
				<!--custom-->
				<?php
				$key = 1;
				foreach ($transactions as $transaction) {
					$color = $transaction->type == 'expense' ? 'red;' : 'blue;';
				?>
					<tr>
						<td>
							<?php
							if ($transaction->order_id == 0) {
								echo '---';
							} else { ?>
								<a target="_blank" href="?page=wc-orders&action=edit&id=<?php echo $transaction->order_id; ?>">
									<?php echo $transaction->order_id; ?>
								</a>
							<?php
							}
							?>
						</td>
						<td><?php echo date('Y-m-d', strtotime($transaction->transaction_date)); ?></td>
						<td><?php echo $transaction->account_head; ?></td>
						<td><?php echo $transaction->type; ?></td>
						<td><span style="color: <?php echo $color; ?>"><?php echo $transaction->amount; ?></span></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>

</div> <!--schedule_time_admin close-->


<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script>
	$(function() {
		$("#datepicker").datepicker();
	});
</script>