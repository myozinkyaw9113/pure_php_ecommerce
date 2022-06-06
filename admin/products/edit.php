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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    if ($_FILES['image']['name'] != null) {
      $stmt = $pdo->prepare("SELECT * FROM products WHERE id =$id");
      $stmt->execute();
      $oldPost = $stmt->fetchAll();

      $checkImg = 'images/'. $oldPost[0]['img'];

      $newfile = 'images/'.basename($_FILES['image']['name']);
      $imageType = pathinfo($newfile,PATHINFO_EXTENSION);
      
      if (file_exists($checkImg)) {
        unlink($checkImg);
        
        if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'gif') {
          echo "<script>alert('Image must be png,jpg,jpeg,gif')</script>";
        } else {
          $newImage = $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'],$newfile);

          $stmt = $pdo->prepare("UPDATE products SET 
          name='$name',category_id='$categoryId',description='$description',img='$newImage',price='$price',quantity='$quantity' WHERE id='$id'");
          $result = $stmt->execute();
          if ($result) {
              echo "<script>alert('Successfully Update');window.location.href='../products.php';</script>";
          }
        } 
      } else {
        $newImage = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$newfile);

        $stmt = $pdo->prepare("UPDATE products SET 
        name='$name',category_id='$categoryId',description='$description',img='$newImage',price='$price',quantity='$quantity' WHERE id='$id'");
        $result = $stmt->execute();
        if ($result) {
            echo "<script>alert('Successfully Update');window.location.href='../products.php';</script>";
        }
      }
    } else {
      $stmt = $pdo->prepare("UPDATE products SET 
      name='$name',category_id='$categoryId',description='$description',price='$price',quantity='$quantity' WHERE id='$id'");
      $result = $stmt->execute();
      if ($result) {
        echo "<script>alert('Successfully Update');window.location.href='../products.php';</script>";
      }
    }

  } else {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // <-- filter your data first (see [Data Filtering](#data_filtering)), especially important for INSERT, UPDATE, etc.
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
    $stmt->execute();
    $oldPost = $stmt->fetchAll();
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
              <h3 class="card-title">Product Edit</h3>
              <a href="../products.php" class="bg-success rounded"><i class='bx bx-arrow-back p-2'></i></a>
            </div>
            
            <div class="card-body">

              <?php
                foreach ($oldPost as $value) {
              ?>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="id" value="<?php echo escape($value['id']); ?>">
                <div class="row">

                  <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" class="form-control" name="name" value="<?php echo escape($value['name']); ?>">
                    <div id="name" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                      <option selected>Select category</option>
                      <?php 
                        for ($i=0; $i < count($categories); $i++) { 
                      ?>
                      <option value="<?php echo escape($categories[$i]['id']); ?>" <?php if (escape($value['category_id']) == escape($categories[$i]['id'])) { echo 'selected'; } ?>>
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
                    <textarea name="description" id="description" cols="30" rows="3" class="form-control">
                      <?php echo escape($value['description']); ?>
                    </textarea>
                    <div id="description" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo escape($value['price']); ?>">
                    <div id="price" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo escape($value['quantity']); ?>">
                    <div id="quantity" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <div id="image" class="form-text mb-3">We'll never share your email with anyone else.</div>
                  </div>

                  <div class="col-md-4 text-right">
                    <img src="images/<?php echo escape($value['img']); ?>" style="width:100px;height:auto;" alt="<?php echo escape($value['name']); ?>">
                  </div>

                </div>
                
                <button type="submit" name="update" class="btn btn-primary">Update</button>
              </form>
              <?php
                }
              ?>
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