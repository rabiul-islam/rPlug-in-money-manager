<?php
error_reporting(1);


if (isset($_GET['delete'])) {
	$table_name = $wpdb->prefix . "accm_account_type";
	$id = $_GET['delete'];
	$wpdb->query(
		'DELETE  FROM $table_name
		 WHERE id = "' . $id . '"'
	);
	$location = '?page=account_head&account=new';
	echo '<script type="text/javascript">window.location.href = "' . $location . '"</script>';
}
if (isset($_GET['delete_transection'])) {
	$table_name = $wpdb->prefix . "accm_transactions";
	$id = $_GET['delete_transection'];
	$wpdb->query(
		'DELETE  FROM $table_name
		 WHERE id = "' . $id . '"'
	);
	$location = '?page=all_transection_page';
	echo '<script type="text/javascript">window.location.href = "' . $location . '"</script>';
}

//nbr_expense_type_submit  submit
if (isset($_POST['nbr_expense_type_submit'])) {
	$title 		= $_POST['title'];
	$bill_type 	= $_POST['bill_type'];
	$insert_array = array(
		'title' => $title,
		'bill_type' => $bill_type,
		'created_at' => date('Y-m-d'),
		'updated_at' => date('Y-m-d'),
	);
	$table_name = $wpdb->prefix . "accm_account_type";
	$success = $wpdb->insert($table_name, $insert_array);
}



//schedule submit
if (isset($_POST['all_transactions_submit_btn'])) {

	$bill_type = $_POST['bill_type'];
	$account_head = $_POST['account_head'];
	$descriptions = $_POST['descriptions'];
	$amount = $_POST['amount'];
	$transaction_date = $_POST['transaction_date'];

	$insert_array = array(
		'type' => $bill_type,
		'status' => 'Custom',
		'account_head' => $account_head,
		'descriptions' => $descriptions,
		'amount' => $amount,
		'transaction_date' => date("Y-m-d", strtotime($transaction_date)),
		'created_at' => date('Y-m-d'),
		'updated_at' => date('Y-m-d')
	);

	$table_name = $wpdb->prefix . "accm_transactions";
	$success = $wpdb->insert($table_name, $insert_array);
	//alert message
	$msg = 'success';
}


function getExpenseTypeBYID($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "accm_account_type";
	$expense_array = $wpdb->get_results("SELECT * FROM $table_name Where id='$id'");
	foreach ($expense_array as $row) {
		echo $row->title;
	}
}
