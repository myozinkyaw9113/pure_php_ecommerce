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

  # Select all categories
  $pdo_categories = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC"); 
  $pdo_categories->execute();
  $categories = $pdo_categories->fetchAll();

  $name = $description = $price = $quantity = "";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['create']) {
      $name = $_POST['name'];
      $categoryId = $_POST['category_id'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $quantity = $_POST['quantity'];

      $file = 'images/'.basename($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);

      if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'gif') {
          echo "<script>alert('Image must be png,jpg,jpeg,gif')</script>";
      } else { 
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $stmt = $pdo->prepare("INSERT INTO products(name,category_id,description,img,price,quantity) 
                       VALUES (:name,:category_id,:description,:img,:price,:quantity)");
        $result = $stmt->execute(
            array(
                ':name' => $name,
                ':category_id'=>$categoryId,
                ':description'=>$description,
                ':img'=>$image,
                ':price' => $price,
                ':quantity' => $quantity
            )
        );
        if ($result) {
          echo "<script>alert('Successfully added');window.location.href='../products.php';</script>";
        }
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
              <h3 class="card-title">Product Upload</h3>
              <a href="../products.php" class="bg-success rounded"><i class='bx bx-arrow-back p-2'></i></a>
            </div>
            
            <div class="card-body">

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="row">

                  <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" class="form-control" name="name">
                    <div id="name" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                      <option selected>Select category</option>
                      <?php 
                        for ($i=0; $i < count($categories); $i++) { 
                      ?>
                      <option value="<?php echo escape($categories[$i]['id']); ?>">
                        <?php echo escape($categories[$i]['name']); ?>
                      </option>
                      <?php
                        }
                      ?>
                    </select>
                    <div id="name" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                    <div id="description" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-4">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <div id="image" class="form-text mb-3">We'll never share your email with anyone else.</div>
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

                </div>
                
                <input type="submit" name="create" class="btn btn-primary" value="Upload">
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