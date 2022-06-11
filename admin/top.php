<?php
  if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
    # Select this user with SESSION['user_id']
    $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
    $pdo_this_user->execute();
    $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC);
  }
?>

<style>
  .active {
    background-color: #FF7700;
  }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <?php 
        if ($link != 'orders.php' && $link != 'create.php' && $link != 
          'edit.php' && $link != 'weekly_report.php' && $link != 'monthly_report.php' 
          && $link != 'best_seller.php' && $link != 'royal_customer.php') {
      ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="input-group input-group-sm">
              <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit" name="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <?php
        }
      ?>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link p-3">
      <i class='bx bxs-shopping-bags pl-2 pr-4'></i>
      <span>
        Ecommerce-Shop
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel d-flex">
          <!-- <a href="#" class="d-block">
            <i class='bx bxs-user text-white' ></i>
            <span><?php # echo $loginUser['name']; ?></span>
          </a> -->
          <a href="#" class="brand-link p-0 py-3">
            <i class='bx bxs-user pl-3 pr-4' style="color:#ddd;"></i>
            <span>
              <?php echo $loginUser['name']; ?>
            </span>
          </a>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php if ($link == 'dashboard.php') { echo 'active'; } ?>">
              <i class='bx bxs-dashboard' ></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="products.php" class="nav-link <?php if ($link == 'products.php') { echo 'active'; } ?>">
              <i class='bx bx-store-alt'></i>
              <p>
                Products
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="category.php" class="nav-link <?php if ($link == 'category.php') { echo 'active'; } ?>">
              <i class='bx bx-category' ></i>
              <p>
                Category
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="orders.php" class="nav-link <?php if ($link == 'orders.php') { echo 'active'; } ?>">
              <i class='bx bx-store-alt'></i>
              <p>
                Orders
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class='bx bxs-report'></i>
              <p>
              Report
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_report.php" class="nav-link <?php if ($link == 'weekly_report.php') { echo 'active bg-primary '; } ?>">
                  <i class='bx bx-calendar-week nav-icon'></i>
                  <p>Weekly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link <?php if ($link == 'monthly_report.php') { echo 'active bg-primary '; } ?>">
                  <i class='bx bx-calendar-week nav-icon'></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="royal_customer.php" class="nav-link <?php if ($link == 'royal_customer.php') { echo 'active bg-primary '; } ?>">
                  <i class='bx bx-user-check nav-icon'></i>
                  <p>Royal Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_seller.php" class="nav-link <?php if ($link == 'best_seller.php') { echo 'active bg-primary '; } ?>">
                  <i class='bx bx-cart-add nav-icon'></i>
                  <p>Best Seller Item</p> 
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">