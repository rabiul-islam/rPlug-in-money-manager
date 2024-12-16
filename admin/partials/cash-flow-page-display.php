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


if (isset($_GET['year'])) {
  $select_year = $_GET['year'];
} else {
  $select_year = date('Y');
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
$table_name = $wpdb->prefix . "accm_transactions";
$transactions = $wpdb->get_results("SELECT t1.type, t1.account_head,
    SUM(CASE WHEN t1.month = 1 THEN t1.total ELSE 0 END) AS January,
    SUM(CASE WHEN t1.month = 2 THEN t1.total ELSE 0 END) AS February,
    SUM(CASE WHEN t1.month = 3 THEN t1.total ELSE 0 END) AS March,
    SUM(CASE WHEN t1.month = 4 THEN t1.total ELSE 0 END) AS April,
    SUM(CASE WHEN t1.month = 5 THEN t1.total ELSE 0 END) AS May,
    SUM(CASE WHEN t1.month = 6 THEN t1.total ELSE 0 END) AS June,
    SUM(CASE WHEN t1.month = 7 THEN t1.total ELSE 0 END) AS July,
    SUM(CASE WHEN t1.month = 8 THEN t1.total ELSE 0 END) AS August,
    SUM(CASE WHEN t1.month = 9 THEN t1.total ELSE 0 END) AS September,
    SUM(CASE WHEN t1.month = 10 THEN t1.total ELSE 0 END) AS October,
    SUM(CASE WHEN t1.month = 11 THEN t1.total ELSE 0 END) AS November,
    SUM(CASE WHEN t1.month = 12 THEN t1.total ELSE 0 END) AS December
    FROM (SELECT type, account_head, SUM(amount) AS total, DATE_FORMAT(transaction_date, '%m') AS month
    FROM $table_name where YEAR(transaction_date)= '$select_year' GROUP BY MONTH(transaction_date), account_head ORDER BY MONTH(transaction_date) DESC) t1
    GROUP BY t1.account_head order by t1.type DESC");

// total income
$total_income_01 = 0;
$total_income_02 = 0;
$total_income_03 = 0;
$total_income_04 = 0;
$total_income_05 = 0;
$total_income_06 = 0;
$total_income_07 = 0;
$total_income_08 = 0;
$total_income_08 = 0;
$total_income_10 = 0;
$total_income_11 = 0;
$total_income_12 = 0;

// total expense
$total_expense_01 = 0;
$total_expense_02 = 0;
$total_expense_03 = 0;
$total_expense_04 = 0;
$total_expense_05 = 0;
$total_expense_06 = 0;
$total_expense_07 = 0;
$total_expense_08 = 0;
$total_expense_08 = 0;
$total_expense_10 = 0;
$total_expense_11 = 0;
$total_expense_12 = 0;

foreach ($transactions as $transaction) {
  if ($transaction->type == 'income') {
    $total_income_01 += $transaction->January;
    $total_income_02 += $transaction->February;
    $total_income_03 += $transaction->March;
    $total_income_04 += $transaction->April;
    $total_income_05 += $transaction->May;
    $total_income_06 += $transaction->June;
    $total_income_07 += $transaction->July;
    $total_income_08 += $transaction->August;
    $total_income_09 += $transaction->September;
    $total_income_10 += $transaction->October;
    $total_income_11 += $transaction->November;
    $total_income_12 += $transaction->December;
  }
  if ($transaction->type == 'expense') {
    $total_expense_01 += $transaction->January;
    $total_expense_02 += $transaction->February;
    $total_expense_03 += $transaction->March;
    $total_expense_04 += $transaction->April;
    $total_expense_05 += $transaction->May;
    $total_expense_06 += $transaction->June;
    $total_expense_07 += $transaction->July;
    $total_expense_08 += $transaction->August;
    $total_expense_09 += $transaction->September;
    $total_expense_10 += $transaction->October;
    $total_expense_11 += $transaction->November;
    $total_expense_12 += $transaction->December;
  }
}
?>

<div class="wrap schedule_time_admin">
  <h2>CashFLow</h2>
  <select id="select_year_id" name="year">
    <?php
    for ($i = date('Y'); $i > 2021; $i--) { ?>
      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php
    }
    ?>
  </select>


  <div class="cash_flow_wrapper">
    <div>
      <canvas id="myChart"></canvas>
    </div>
    </br>
    </br>
    <h2>All List</h2>
    <table class="wp-list-table widefat fixed striped table-view-list pages">
      <thead>
        <tr>
          <th>Category</th>
          <th>January</th>
          <th>February</th>
          <th>March</th>
          <th>April</th>
          <th>May</th>
          <th>June</th>
          <th>July</th>
          <th>August</th>
          <th>September</th>
          <th>October</th>
          <th>Novembr</th>
          <th>December</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody id="cashflow_ajax_results">
        <?php
        foreach ($transactions as $transaction) {
          $color = $transaction->type == 'income' ? 'blue' : 'red';
        ?>
          <tr>
            <td><?php echo $transaction->account_head; ?></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->January; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->February; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->March; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->April; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->May; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->June; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->July; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->August; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->September; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->October; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->November; ?></span></td>
            <td><span style="color: <?php echo $color; ?>"><?php echo $transaction->December; ?></span></td>
            <td>
              ---
            </td>
          </tr>
        <?php } ?>
        <tr>
          <th>Income</th>
          <th><?php echo $total_income_01; ?></th>
          <th><?php echo $total_income_02; ?></th>
          <th><?php echo $total_income_03; ?></th>
          <th><?php echo $total_income_04; ?></th>
          <th><?php echo $total_income_05; ?></th>
          <th><?php echo $total_income_06; ?></th>
          <th><?php echo $total_income_07; ?></th>
          <th><?php echo $total_income_08; ?></th>
          <th><?php echo $total_income_09; ?></th>
          <th><?php echo $total_income_10; ?></th>
          <th><?php echo $total_income_11; ?></th>
          <th><?php echo $total_income_12; ?></th>
          <th></th>
        </tr>
        <tr>
          <th>Expense</th>
          <th><?php echo $total_expense_01; ?></th>
          <th><?php echo $total_expense_02; ?></th>
          <th><?php echo $total_expense_03; ?></th>
          <th><?php echo $total_expense_04; ?></th>
          <th><?php echo $total_expense_05; ?></th>
          <th><?php echo $total_expense_06; ?></th>
          <th><?php echo $total_expense_07; ?></th>
          <th><?php echo $total_expense_08; ?></th>
          <th><?php echo $total_expense_09; ?></th>
          <th><?php echo $total_expense_10; ?></th>
          <th><?php echo $total_expense_11; ?></th>
          <th><?php echo $total_expense_12; ?></th>
          <th></th>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th>Profit</th>
          <th><?php echo $total_income_01 - $total_expense_01; ?></th>
          <th><?php echo $total_income_02 - $total_expense_02; ?></th>
          <th><?php echo $total_income_03 - $total_expense_03; ?></th>
          <th><?php echo $total_income_04 - $total_expense_04; ?></th>
          <th><?php echo $total_income_05 - $total_expense_05; ?></th>
          <th><?php echo $total_income_06 - $total_expense_06; ?></th>
          <th><?php echo $total_income_07 - $total_expense_07; ?></th>
          <th><?php echo $total_income_08 - $total_expense_08; ?></th>
          <th><?php echo $total_income_09 - $total_expense_09; ?></th>
          <th><?php echo $total_income_10 - $total_expense_10; ?></th>
          <th><?php echo $total_income_11 - $total_expense_11; ?></th>
          <th><?php echo $total_income_12 - $total_expense_12; ?></th>
          <th></th>
        </tr>
      </tfoot>
    </table>



    <!-- chart.js------>
    <script>
      const ctx = document.getElementById('myChart');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', ],
          datasets: [{
              label: 'Income',
              data: [
                <?php echo $total_income_01; ?>,
                <?php echo $total_income_02; ?>,
                <?php echo $total_income_03; ?>,
                <?php echo $total_income_04; ?>,
                <?php echo $total_income_05; ?>,
                <?php echo $total_income_06; ?>,
                <?php echo $total_income_07; ?>,
                <?php echo $total_income_08; ?>,
                <?php echo $total_income_09; ?>,
                <?php echo $total_income_10; ?>,
                <?php echo $total_income_11; ?>,
                <?php echo $total_income_12; ?>
              ],
              borderWidth: 1
            },
            {
              label: 'Expense',
              data: [
                <?php echo $total_expense_01; ?>,
                <?php echo $total_expense_02; ?>,
                <?php echo $total_expense_03; ?>,
                <?php echo $total_expense_04; ?>,
                <?php echo $total_expense_05; ?>,
                <?php echo $total_expense_06; ?>,
                <?php echo $total_expense_07; ?>,
                <?php echo $total_expense_08; ?>,
                <?php echo $total_expense_09; ?>,
                <?php echo $total_expense_10; ?>,
                <?php echo $total_expense_11; ?>,
                <?php echo $total_expense_12; ?>
              ],
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>

  </div>
</div> <!--schedule_time_admin close-->