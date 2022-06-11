<?php
  session_start();
  require '../config/database.php';
  require '../config/common.php';
  require 'loginUser.php';

  if (isset($_POST['search'])) {
    setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
  } else {
    if (empty($_GET['p'])) { 
      unset($_COOKIE['search']);
      setcookie('search',null, -1, '/');
    }
  }

  # Pagination 
  # p = $pageno;
  $p = '';
  if (!empty($_GET['p'])) {
    $p = $_GET['p'];
  } else {
    $p = 1;
  }
  $showrecs = 3;
  $offset = ($p - 1) * $showrecs;

  if (empty($_POST['search']) && empty($_COOKIE['search'])) {
    $pdo_prepare = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
    $pdo_prepare->execute();
    $raw_result = $pdo_prepare->fetchAll();

    $total_pages = ceil(count($raw_result) / $showrecs);

    $pdo_prepare = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$showrecs");
    $pdo_prepare->execute();
    $result = $pdo_prepare->fetchAll();
  } else {
    if (isset($_POST['search'])) {
      $search = $_POST['search'];
    } else {
      $search = $_COOKIE['search'];
    }
    $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY id DESC");
    $pdo_prepare->execute();
    $raw_result = $pdo_prepare->fetchAll();

    $total_pages = ceil(count($raw_result) / $showrecs);

    $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $offset,$showrecs");
    $pdo_prepare->execute();
    $result = $pdo_prepare->fetchAll();
  }

?>

<?php
require 'top.php';
?>

<style>
  table tbody tr.table-data td {
    vertical-align: middle;
  }
</style>

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
              <h3 class="card-title">Prooduct Listing</h3>
              <a href="products/create.php" class="bg-success rounded"><i class='bx bx-list-plus p-2'></i></a>
            </div>
            
            <div class="card-body">
              <table class="table table-bordered align-items-center">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
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
                  $cat_stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$value['category_id']);
                  $cat_stmt->execute();
                  $category = $cat_stmt->fetchAll();
                  ?>
                  <tr class="table-data">
                    <td><?php echo $num++; ?></td>
                    <td><?php echo escape($value['name']); ?></td>
                    <td><img style="width: 70px;height:auto;" src="products/images/<?php echo escape($value['img']) ;?>" alt="<?php echo escape($value['name']); ?>"></td>
                    <td><?php echo escape($value['price']) ;?></td>
                    <td><?php echo escape($value['quantity']) ;?></td>
                    <td><?php echo escape($category[0]['name']) ;?></td>
                    <td>
                      <div class="d-flex gap-1">
                        <a href="products/edit.php?id=<?php echo escape($value['id']); ?>" class="btn-sm btn-warning"><i class='bx bx-edit-alt'></i></a>
                        <a href="products/delete.php?id=<?php echo escape($value['id']); ?>" class="btn-sm btn-danger"><i class='bx bx-trash'></i></a>
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