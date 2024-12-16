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
  
 
 global $wpdb; 
 $table_name = $wpdb->prefix."accm_account_type";
 $expense_array = $wpdb->get_results( "SELECT * FROM $table_name" );

 
if(isset($_GET['edit'])){  
	$id = $_GET['edit']; 
	$edit_expense_array = $wpdb->get_results( "SELECT * FROM $table_name Where id='$id'" );
	foreach($edit_expense_array as $row){
		$title =  $row->title;
		$bill_type =  $row->bill_type;
	}  
}

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap schedule_time_admin"> 
 <h1 id="add-new-user">Add New Account Head</h1>
  <form method="post" name="createexpense" class="validate" novalidate="novalidate">
    <table class="form-table" role="presentation">
      <tbody>
      <tr class="form-field">
          <th scope="row">
            <label for="bill_type">Type</label>
          </th>
          <td>
            <select name="bill_type">
              <option value="income" <?php if($bill_type=='income'){ ?> selected="selected"<?php }?>>Income</option>
              <option value="expense" <?php if($bill_type=='expense'){ ?> selected="selected"<?php }?>>Expense</option>
              <!--<option value="others" <?php if($bill_type=='others'){ ?> selected="selected"<?php }?>>Others</option>-->
            </select> 
          </td>
        </tr>
        <tr class="form-field">
          <th scope="row">
            <label for="title">Account Head </label>
          </th>
          <td>
            <input name="title" type="name" id="title"  <?php if(isset($title)){ ?> value="<?php echo $title; ?> <?php } ?>"/>
          </td>
        </tr>
        <tr class="form-field">
          <th scope="row">
            <input type="submit" name="nbr_expense_type_submit" class="button button-primary" value="Save" style="width:auto">
          </th>
          <td></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="wp-list-table widefat fixed striped table-view-list pages">
    
    <thead>
      <tr> 
        <th>Account Head</th>
        <th>Type</th> 
        <th>Action</th> 
      </tr>
    </thead>
    <tbody id="the-list">
		<?php 
		foreach($expense_array as $expense){
		?>
    <tr>  
      <td><?php echo $expense->title; ?></td> 
      <td><?php echo $expense->bill_type; ?></td>  
      <td><a href="?page=account_head&account=new&edit=<?php echo $expense->id; ?>" class="button button-primary">Edit</a> <a href="?page=account_head&account=new&delete=<?php echo $expense->id; ?>" class="button button-delete">Delete</a></td>
    </tr>
	  <?php } ?>
    </tbody>
    <tfoot>
      <tr></tr>
    </tfoot>
  </table>  
    
</div>
<!--schedule_time_admin close-->
