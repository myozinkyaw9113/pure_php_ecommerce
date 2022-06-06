<?php
  session_start();
  require '../../config/database.php';
  require '../../config/common.php';
  require '../loginUser.php';
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

  $name = $description = "";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['upload']) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $stmt = $pdo->prepare("INSERT INTO categories(name,description) 
                          VALUES (:name,:description)");
      $result = $stmt->execute(
        array(
          ':name' => $name,
          ':description'=> $description,
        )
      );
      if ($result) {
        echo "<script>alert('Successfully added');window.location.href='../category.php';</script>";
      }
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
              <h3 class="card-title">Category Upload</h3>
              <a href="../category.php" class="bg-success rounded"><i class='bx bx-arrow-back p-2'></i></a>
            </div>
            
            <div class="card-body">

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="row">

                  <div class="col-md-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" class="form-control" name="name">
                    <div id="name" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>


                  <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea type="text" col="30" rows="5" name="description" id="description" class="form-control"></textarea>
                    <div id="description" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                </div>
                
                <input type="submit" name="upload" class="btn btn-primary" value="Upload">
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