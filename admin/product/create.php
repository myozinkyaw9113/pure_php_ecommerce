<?php
  session_start();
  require '../../config/database.php';
  require '../loginUser.php';

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
              <h3 class="card-title">Product Upload</h3>
              <a href="../index.php" class="bg-success rounded"><i class='bx bx-arrow-back p-2'></i></a>
            </div>
            
            <div class="card-body">

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">

                <div class="row">

                  <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" class="form-control" id="name" na>
                    <div id="name" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" class="form-control">
                      <option value="">Option</option>
                      <option value="">Option</option>
                      <option value="">Option</option>
                    </select>
                    <div id="name" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                    <div id="description" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-4">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price">
                    <div id="price" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-4">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity">
                    <div id="quantity" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>
                  
                  <div class="col-md-4">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <div id="image" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
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