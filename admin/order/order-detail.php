<?php
  session_start();
  require '../../config/database.php';
?>

<?php
  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: ../../login.php');
  }

  if ($_SESSION) {
    if ($_SESSION['user_id'] != 1) {
    header('Location: ../../index.php');
    }
  }


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
              <h3 class="card-title">Order Detail</h3>
              <a href="../orders.php" class="bg-success rounded"><i class='bx bx-arrow-back p-2'></i></a>
            </div>
            
            <div class="card-body">

                <div class="row p-3">
  
                    <div class="col-md-8">
                    
                    <?php for($i=0;$i<10;$i++) {
                    ?>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                        Ratione earum quo voluptatum, corrupti obcaecati nulla veniam dolor
                        fugiat id quasi ducimus, doloremque hic eaque omnis blanditiis. 
                        Rerum distinctio numquam quasi.
                    <?php
                    }
                    ?>
                    
                    </div>

                    <div class="col-md-4">
                    
                        <div class="row">

                        <?php
                        for ($i=0; $i < 11; $i++) { 
                        ?>
                        <div class="col-md-4 mb-3 text-center">
                            <img style="height:100px;width:auto;" src="../products/images/tshit1.png" alt="">
                        </div>
                        <?php
                            }
                        ?>

                        </div>

                    </div>

                </div>
              
            </div>

          </div>
        </div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
  <!-- /.content -->

 <?php require '../base.php'; ?>
 <script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>