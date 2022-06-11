<?php
  session_start();
  require '../config/database.php';
  require '../config/common.php';
  require 'loginUser.php';

  $stmt_order_detail = $pdo->prepare("SELECT * FROM order_detail WHERE quantity >= 10 ORDER BY id DESC");
  $stmt_order_detail->execute();
  $order_detail_result = $stmt_order_detail->fetchAll();

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
              <h3 class="card-title">Best Selling Products</h3>
            </div>
            
            <div class="card-body">
                <table id="bestSeller" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($order_detail_result as $value) { 
                          $stmt_product = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                          $stmt_product->execute();
                          $best_seller_product = $stmt_product->fetchAll();
                        ?>

                        <tr>
                            <td><?php echo escape($best_seller_product[0]['name']); ?></td>
                            <td><?php echo escape($value['quantity']); ?></td>
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
        $('#bestSeller').DataTable();
    });
</script>