<?php
  session_start();
  require 'unit/href.php';
  require 'config/database.php';
  require 'config/common.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }

  if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
    # Select this user with SESSION['user_id']
    $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
    $pdo_this_user->execute();
    $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC);
  }

  require 'unit/top.php';
  require 'unit/header_nav.php';
?>

<style>
  .confirm_banner_area {
    background: url(images/bg1.webp) center no-repeat;
    background-size: cover;
  }
  .confirm_banner_area h1, .confirm_banner_area nav a {
    color: #000;
  }
</style>

<section class="banner-area confirm_banner_area organic-breadcrumb">
  <div class="container">
    <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
      <div class="col-first">
        <h1>Confirmation</h1>
        <nav class="d-flex align-items-center">
          <a href="index.php">Home<span><i class='bx bxs-right-arrow' ></i></span></a>
          <a href="confirm.php">Confirmation</a>
        </nav>
      </div>
    </div>
  </div>
</section>


<section class="order_details section_gap">
<div class="container">

<?php if (empty($_SESSION['cart'])) { ?>
<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
<div class="row order_d_inner">
<div class="col-lg-4">
<div class="details_item">
<h4>Order Info</h4>
<ul class="list">
<li><a href="#"><span>Order number</span> : 60235</a></li>
<li><a href="#"><span>Date</span> : Los Angeles</a></li>
<li><a href="#"><span>Total</span> : USD 2210</a></li>
<li><a href="#"><span>Payment method</span> : Check payments</a></li>
</ul>
</div>
</div>
<div class="col-lg-4">
<div class="details_item">
<h4>Billing Address</h4>
<ul class="list">
<li><a href="#"><span>Street</span> : 56/8</a></li>
<li><a href="#"><span>City</span> : Los Angeles</a></li>
<li><a href="#"><span>Country</span> : United States</a></li>
<li><a href="#"><span>Postcode </span> : 36952</a></li>
</ul>
</div>
</div>
<div class="col-lg-4">
<div class="details_item">
<h4>Shipping Address</h4>
<ul class="list">
<li><a href="#"><span>Street</span> : 56/8</a></li>
<li><a href="#"><span>City</span> : Los Angeles</a></li>
<li><a href="#"><span>Country</span> : United States</a></li>
<li><a href="#"><span>Postcode </span> : 36952</a></li>
</ul>
</div>
</div>
</div>
<div class="order_details_table">
<h2>Order Details</h2>
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th scope="col">Product</th>
<th scope="col">Quantity</th>
<th scope="col">Total</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<p>Pixelstore fresh Blackberry</p>
</td>
<td>
<h5>x 02</h5>
</td>
<td>
<p>$720.00</p>
</td>
</tr>
<tr>
<td>
<p>Pixelstore fresh Blackberry</p>
</td>
<td>
<h5>x 02</h5>
</td>
<td>
<p>$720.00</p>
</td>
</tr>
<tr>
<td>
<p>Pixelstore fresh Blackberry</p>
</td>
<td>
<h5>x 02</h5>
</td>
<td>
<p>$720.00</p>
</td>
</tr>
<tr>
<td>
<h4>Subtotal</h4>
</td>
<td>
<h5></h5>
</td>
<td>
<p>$2160.00</p>
</td>
</tr>
<tr>
<td>
<h4>Shipping</h4>
</td>
<td>
<h5></h5>
</td>
<td>
<p>Flat rate: $50.00</p>
</td>
</tr>
<tr>
<td>
<h4>Total</h4>
</td>
<td>
<h5></h5>
</td>
<td>
<p>$2210.00</p>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<?php } else { ?>
  <div class="d-flex justify-content-center align-item-center gap-4">
    <h3 class="title_confirmation mb-0 mt-3">Not item purchased, Please go to</h3>
    <a href="index.php" class="primary-btn">Home Page</a>
  </div>
<?php } ?>

</div>
</section>

<?php
  require 'unit/footer.php';
  require 'unit/base.php';
?>