<?php
  session_start();
  require '../../config/database.php';
  require '../../config/common.php';
  require '../loginUser.php';

  # Pagination 
  # p = $pageno;
  $p = '';
  if (!empty($_GET['p'])) {
    $p = $_GET['p'];
  } else {
    $p = 1;
  }
  $showrecs = 10;
  $offset = ($p - 1) * $showrecs;

  $pdo_prepare = $pdo->prepare("SELECT * FROM order_detail WHERE order_id=".$_GET['id']);
  $pdo_prepare->execute();
  $raw_result = $pdo_prepare->fetchAll();

  $total_pages = ceil(count($raw_result) / $showrecs);

  $pdo_prepare = $pdo->prepare("SELECT * FROM order_detail WHERE order_id=".$_GET['id']." LIMIT $offset,$showrecs");
  $pdo_prepare->execute();
  $result = $pdo_prepare->fetchAll();

?>

<?php
require '../top.php';
?>

<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="../../dist/css/adminlte.min.css">

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
              <h3 class="card-title">Order Detail Listing</h3>
              <a href="../orders.php" class="bg-success rounded"><i class='bx bx-arrow-back p-2'></i></a>
            </div>
            
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  if ($result) {
                    $num = 1;
                    foreach ($result as $value) { 
                  ?>
                  <?php
                    $product_stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                    $product_stmt->execute();
                    $product = $product_stmt->fetchAll();
                  ?>
                  <tr>
                    <td><?php echo $num++; ?></td>
                    <td><?php echo escape($product[0]['name']) ;?></td>
                    <td><?php echo escape($value['quantity']); ?></td>
                    <td><?php echo escape($value['order_date']) ;?></td>
                  <?php
                    }
                  ?>

                  <?php
                  } else {
                  ?>
                    <tr>
                      <td colspan="5" class="text-center">No record yet!</td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&p=1"><i class='bx bx-chevrons-left'></i></a></li>
                <li class="page-item <?php if($p <= 1){ echo 'disabled'; } ?>">
                  <a class="page-link" href="<?php if($p <= 1){ echo '#'; }else{ echo '?id='.$_GET['id'].'&p='.($p-1); } ?>"><i class='bx bxs-chevron-left' ></i></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">C</a></li>
                <li class="page-item <?php if($p >= $total_pages){ echo 'disabled'; } ?>">
                  <a class="page-link" href="<?php if($p >= $total_pages){ echo '#'; }else{ echo '?id='.$_GET['id'].'&p='.($p+1); } ?>"><i class='bx bxs-chevron-right' ></i></a>
                </li>
                <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&p=<?php echo $total_pages; ?>"><i class='bx bxs-chevrons-right' ></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
  <!-- /.content -->

<?php require '../base.php'; ?>