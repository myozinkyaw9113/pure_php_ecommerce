<?php
  session_start();
  require '../config/database.php';
  require '../config/common.php';
  require 'loginUser.php';

  $current_date = date('Y-m-d');
  $fromdate = date('Y-m-d', strtotime($current_date.'+1 day'));
  $todate = date('Y-m-d', strtotime($current_date.'-1 month'));
  $pdo_prepare = $pdo->prepare("SELECT * FROM orders WHERE order_date<:fromdate AND order_date>=:todate ORDER BY id DESC");
  $pdo_prepare->execute(
    array(
      ':fromdate' => $fromdate,
      ':todate' => $todate,
    )
  );
  $result = $pdo_prepare->fetchAll();

?>

<?php
require 'top.php';
?>

  <!-- Content Header (Page header) -->
  <div class="content-header">
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="d-flex justify-content-between gap-2 align-items-center p-3" style="border-bottom:1px solid #ddd;">
              <h3 class="card-title">Monthly Report</h3>
            </div>
            
            <div class="card-body">
                <table id="monthlyReport" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Customers</th>
                            <th>Total Amount</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($result as $value) { 
                            $customerId = $value['customer_id'];
                            $pdo_prepare = $pdo->prepare("SELECT * FROM users WHERE id=$customerId");
                            $pdo_prepare->execute();
                            $customer = $pdo_prepare->fetchAll();
                        ?>

                        <tr>
                            <td><?php echo escape($customer[0]['name']); ?></td>
                            <td><?php echo '$' . escape($value['total_price']); ?></td>
                            <td><?php echo escape($value['order_date']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
          
            <div class="card-footer clearfix">
              
            </div>
          </div>
        </div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
  <!-- /.content -->

<?php require 'base.php'; ?>
<script>
    $(document).ready(function () {
        $('#monthlyReport').DataTable();
    });
</script>