<?php
  session_start();
  require 'config/database.php';
  require 'config/common.php';

  // session_destroy();
  // print_r($_SESSION['cart']);
  // die();

  if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
    # Select this user with SESSION['user_id']
    $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
    $pdo_this_user->execute();
    $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC);
  }

  $sessionUserId = $_SESSION['user_id'];
  $pdo_prepare = $pdo->prepare("SELECT * FROM cart WHERE customer_id=$sessionUserId ORDER BY id DESC");
  $pdo_prepare->execute();
  $cartResult = $pdo_prepare->fetchAll();

?>

<?php
require 'unit/href.php';
require 'unit/top.php';
require 'unit/header_nav.php';
?>

<style>
  .cart_banner_area {
    background: url(images/bg1.webp) center no-repeat;
    background-size: cover;
  }
  .cart_banner_area h1, .cart_banner_area nav a {
    color: #000;
  }

  input.quantity {
    border: 1px solid #bbb;
    outline: 1px solid #bbb;
  }

</style>


<section class="banner-area cart_banner_area organic-breadcrumb">
  <div class="container">
    <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
      <div class="col-first">
        <h1>Shopping Cart</h1>
        <nav class="d-flex align-items-center">
          <a href="index.php">Home<span><i class='bx bx-right-arrow'></i></span></a>
          <a href="cart.php">Cart</a>
        </nav>
      </div>
    </div>
  </div>
</section>


<section class="cart_area">
  <div class="container">
    <div class="cart_inner">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (empty($cartResult)) {
            ?>
            <tr>
              <td>No cart item</td>
            </tr>
            <?php
              } else {
              $totalprice = 0;
              foreach ($cartResult as $value) {
                $totalprice += $value['total_price']; 
            ?>
            <?php
              $productId = $value['product_id'];
              $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE id=$productId");
              $pdo_prepare->execute();
              $productResult = $pdo_prepare->fetchAll();
            ?>
            <tr>
              <td>
                <div class="media">
                <div class="d-flex">
                  <a href="product-detail.php?id=<?php echo escape($value['product_id']); ?>"><img src="admin/products/images/<?php echo escape($productResult[0]['img']) ?>" style="width:100px;height:auto;"
                  alt=""></a>
                </div>
                <div class="media-body">
                <p><?php echo escape($productResult[0]['name']) ?></p>
                </div>
                </div>
              </td>
              <td>
                <h5><?php echo '$' . escape($productResult[0]['price']) * escape($value['quantity']); ?></h5>
              </td>
              <td>
                <div class="product_count">
                  <input type="number" name="quantity" class="quantity" min="1" value="<?php echo escape($value['quantity']) ?>">
                </div>
              </td>
              <td>
              <a href="cart/delete.php?id=<?php echo escape($value['id']); ?>" class="btn btn-danger p-2"><i class='bx bx-trash'></i></a>
              </td>
            </tr>
            <?php
                } 
              }
            ?>
          </tbody>
          <?php
          if (count($cartResult) > 0) {
          ?>
          <tfoot>
            <tr>
              <td colspan="3">
                Total : 
              </td>
              <td>
                <?php
                  echo '$' . $totalprice;
                ?>
              </td>
            </tr>
          </tfoot>
          <?php
          }
          ?>
        </table>
      </div>
    </div>
  </div>
</section>

<?php
  require 'unit/footer.php';
  require 'unit/base.php';
?>