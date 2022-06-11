<?php
  session_start();
  require 'config/database.php';
  require 'config/common.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }

  // session_destroy();
  // print_r($_SESSION['cart']);
  // die();

  if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
    # Select this user with SESSION['user_id']
    $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
    $pdo_this_user->execute();
    $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC);
  }

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
              if (!empty($_SESSION['cart'])) {
                $totalprice = 0;
                foreach ($_SESSION['cart'] as $key => $qty) {
                  $product_id = str_replace('pid','',$key);

                  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=$product_id");
                  $stmt->execute();
                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  $totalprice += $result[0]['price'] * $qty; 
            ?>
            <tr>
              <td>
                <div class="media">
                <div class="d-flex">
                  <a href="product-detail.php?id=<?php echo $result[0]['id']; ?>"><img src="admin/products/images/<?php echo escape($result[0]['img']) ?>" style="width:100px;height:auto;"
                  alt=""></a>
                </div>
                <div class="media-body">
                <p><?php echo escape($result[0]['name']) ?></p>
                </div>
                </div>
              </td>
              <td>
                <h5><?php echo '$' . escape($result[0]['price']) * $qty; ?></h5>
              </td>
              <td>
                <div class="product_count">
                  <input type="text" value="<?php echo $qty ?>" readonly>
                </div>
              </td>
              <td>
              <a href="cart/delete.php?id=<?php echo $product_id; ?>" class="primary-btn p-0 px-3"><i class='bx bx-trash'></i></a>
              </td>
            </tr>
            <?php
                }  
              } else {
            ?>
            <tr>
              <td colspan="4">No item</td>
            </tr>
            <?php
              }
            ?>
          </tbody>
          <?php
            if (!empty($_SESSION['cart'])) {
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
            <tr>
              <td colspan="4">
                <div class="cupon_text d-flex align-items-center justify-content-end">
                  <a href="cart/cart-clear.php" class="gray_btn">Clear All</a>
                  <a class="gray_btn" href="index.php">Continue Shopping</a>
                  <a class="primary-btn" style="border-radius:0;line-height:40px;" href="checkout.php">Checkout</a>
                </div>
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