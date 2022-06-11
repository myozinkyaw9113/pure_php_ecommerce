<?php
  session_start();
  require 'config/database.php';
  require 'config/common.php';
  require 'unit/href.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  } elseif (empty($_SESSION['cart'])) {
    header('Location: index.php');
  }

  if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
    # Select this user with SESSION['user_id']
    $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
    $pdo_this_user->execute();
    $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_SESSION['cart'])) {
      echo '<script>alert("Please, make sure to put item in your shopping cart");window.location.href="index.php";</script>';
    } else {
      $phone = $_POST['phone'];
      $address = $_POST['address'];

      $customer_id = $_SESSION['user_id'];
      $total_price = $_POST['total_price'];

      $productId = $_POST['product_id'];

      # Update user data
      $stmt_user_update = $pdo->prepare("UPDATE users SET phone=:phone, address=:address WHERE id=$customer_id");
      $result_user = $stmt_user_update->execute(
        array(
          ':phone' => $phone,
          ':address' => $address
        )
      );

      if ($result_user) {
        # Insert order
        $stmt_order = $pdo->prepare("INSERT INTO orders(customer_id,total_price) VALUES(:customer_id,:total_price)");
        $result_order = $stmt_order->execute(
          array(
            ':customer_id' => $customer_id,
            ':total_price' => $total_price,
          )
        );
        if ($result_order) {
          $orderId = $pdo->lastInsertId();
          foreach ($_SESSION['cart'] as $key => $qty) {
            $product_id = str_replace('pid','',$key);
            # Insert Order Detail
            $stmt_order_detail = $pdo->prepare("INSERT INTO order_detail(order_id,product_id,quantity) VALUES(:order_id,:product_id,:quantity)");
            $result_order_detail = $stmt_order_detail->execute(
              array(
                ':order_id' => $orderId,
                ':product_id' => $product_id,
                ':quantity' => $qty,
              )
            );
            $qtyStmt = $pdo->prepare("SELECT quantity FROM products WHERE id=$product_id");
            $qtyStmt->execute();
            $resultQty = $qtyStmt->fetch(PDO::FETCH_ASSOC);

            $update_qty = $resultQty['quantity'] - $qty;

            $stmt_product_update = $pdo->prepare("UPDATE products SET quantity=:qty WHERE id=:pId");
            $stmt_product_update->execute(
              array(
                ':qty' => $update_qty,
                ':pId' => $product_id,
              )
            );
          }
          if ($result_order_detail) {
            unset($_SESSION['cart']);
            echo '<script>alert("Order has been successfully received");window.location.href="confirm.php"</script>';
          }
        }
      }
    }
  }

?>

<?php
require 'unit/top.php';
require 'unit/header_nav.php';
?>

<style>
  .checkout_banner_area {
    background: url(images/bg1.webp) center no-repeat;
    background-size: cover;
  }
  .checkout_banner_area h1, .checkout_banner_area nav a {
    color: #000;
  }
  input {
    border: none;
    outline: none;
    background-color: transparent;
  }
</style>

<section class="banner-area checkout_banner_area organic-breadcrumb">
  <div class="container">
    <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
      <div class="col-first">
        <h1>Checkout</h1>
        <nav class="d-flex align-items-center">
          <a href="index.php">Home<span><i class='bx bxs-right-arrow' ></i></span></a>
          <a href="checkout.php">Checkout</a>
        </nav>
      </div>
    </div>
  </div>
</section>


<section class="checkout_area section_gap">
  <div class="container">
    <!-- Coupon Area -->
    <form class="row contact_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <div class="billing_details">
      <div class="row">  
        <div class="col-lg-8">
          <h3>Billing Details</h3>
          <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">  
          <div class="col-md-12 form-group p_star">
            <input type="text" class="form-control" name="name" readonly placeholder="Your Name" value="<?php echo escape($loginUser['name']); ?>">
          </div>
          <div class="col-md-12 form-group p_star">
            <input type="email" class="form-control" name="email" readonly placeholder="Your Email" value="<?php echo escape($loginUser['email']); ?>">
          </div>
          <div class="col-md-12 form-group p_star">
            <input type="text" class="form-control" name="phone" placeholder="Your Phone" value="<?php echo escape($loginUser['phone']); ?>">
          </div>
          <div class="col-md-12 form-group p_star">
            <textarea class="form-control" name="address" cols="30" rows="3" placeholder="Your Address"><?php echo escape($loginUser['address']); ?></textarea>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="order_box">
            <h2>Your Order</h2>
            <ul class="list">
              <li><a href="#">Product <span>Total</span></a></li>
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
                <input type="hidden" name="product_id" value="<?php echo escape($result[0]['id']); ?>">
                <li><a href="#"><?php echo escape($result[0]['name']) ?> <span class="middle">x <?php echo $qty; ?></span> <span class="last"><?php echo '$' . escape($result[0]['price']) * $qty; ?></span></a></li>
              <?php
                  }
                } else {
                  echo '<li>No item in your cart</li>';
                }
              ?>
            </ul>
            <ul class="list list_2">
              <?php 
              if (!empty($_SESSION['cart'])) {
              ?>
              <li><a href="#">Total <span><input type="text" class="text-right" name="total_price" value="<?php echo $totalprice; ?>" readonly></span></a></li>
              <?php
              }
              ?>
            </ul>
            <button class="primary-btn w-100" type="submit">Proceed to checkout</button>
          </div>
        </div>
        </div>
    </div>
    </form>
  </div>
</section>

<?php
  require 'unit/footer.php';
  require 'unit/base.php';
?>