<?php
  session_start();
  require '../config/database.php';
  require '../config/common.php';
  require 'loginUser.php';

  # Pagination 
  # p = $pageno;
  $p = '';
  if (!empty($_GET['p'])) {
    $p = $_GET['p'];
  } else {
    $p = 1;
  }
  $showrecs = 1;
  $offset = ($p - 1) * $showrecs;

  $pdo_prepare = $pdo->prepare("SELECT * FROM orders ORDER BY id DESC");
  $pdo_prepare->execute();
  $raw_result = $pdo_prepare->fetchAll();

  $total_pages = ceil(count($raw_result) / $showrecs);

  $pdo_prepare = $pdo->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT $offset,$showrecs");
  $pdo_prepare->execute();
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
            <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid #ddd;">
              <h3 class="card-title">Order Table</h3>
            </div>
            
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Customer ID</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th style="width: 40px">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  if ($result) {
                    $num = 1;
                    foreach ($result as $value) { 
                  ?>
                  <?php
                    $user_stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['customer_id']);
                    $user_stmt->execute();
                    $user = $user_stmt->fetchAll();
                  ?>
                  <tr>
                    <td><?php echo $num++; ?></td>
                    <td><?php echo escape($user[0]['name']) ;?></td>
                    <td><?php echo '$' . escape($value['total_price']); ?></td>
                    <td><?php echo escape($value['order_date']) ;?></td>
                    <td>
                      <div class="d-flex gap-1">
                        <a href="order/order-detail.php?id=<?php echo escape($value['id']) ; ?>" class="btn-sm btn-warning"><i class='bx bx-show'></i></a>
                      </div>
                    </td>
                  </tr>
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
                <li class="page-item"><a class="page-link" href="?p=1"><i class='bx bx-chevrons-left'></i></a></li>
                <li class="page-item <?php if($p <= 1){ echo 'disabled'; } ?>">
                  <a class="page-link" href="<?php if($p <= 1){ echo '#'; }else{ echo '?p='.($p-1); } ?>"><i class='bx bxs-chevron-left' ></i></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">C</a></li>
                <li class="page-item <?php if($p >= $total_pages){ echo 'disabled'; } ?>">
                  <a class="page-link" href="<?php if($p >= $total_pages){ echo '#'; }else{ echo '?p='.($p+1); } ?>"><i class='bx bxs-chevron-right' ></i></a>
                </li>
                <li class="page-item"><a class="page-link" href="?p=<?php echo $total_pages; ?>"><i class='bx bxs-chevrons-right' ></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
  <!-- /.content -->

<?php require 'base.php'; ?>