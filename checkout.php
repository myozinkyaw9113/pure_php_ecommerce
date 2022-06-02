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
    <div class="cupon_area">
      <div class="check_title">
        <h2>Have a coupon? <a href="#">Click here to enter your code</a></h2>
      </div>
      <input type="text" placeholder="Enter coupon code">
      <a class="tp_btn" href="#">Apply Coupon</a>
    </div>
    <div class="billing_details">
      <div class="row">
        <div class="col-lg-8">
          <h3>Billing Details</h3>
          <form class="row contact_form" action="#" method="post" novalidate>
            <div class="col-md-6 form-group p_star">
              <input type="text" class="form-control" id="username" name="name">
              <span class="placeholder" data-placeholder="Username"></span>
            </div>
            <div class="col-md-6 form-group p_star">
              <input type="email" class="form-control" id="email" name="email">
              <span class="placeholder" data-placeholder="Email Address"></span>
            </div>
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="number" name="mobile">
              <span class="placeholder" data-placeholder="Phone number"></span>
            </div>
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="add1" name="address">
              <span class="placeholder" data-placeholder="Address"></span>
            </div>
            <div class="col-md-6 form-group p_star">
              <input type="text" class="form-control" id="town" name="town">
              <span class="placeholder" data-placeholder="Town"></span>
            </div>
            <div class="col-md-6 form-group p_star">
              <select class="country_select" name="city">
                <option value="1">City</option>
                <option value="2">City</option>
                <option value="4">City</option>
              </select>
            </div>
            <div class="col-md-12 form-group p_star">
              <select class="country_select">
                <option value="1">Country</option>
                <option value="2">Country</option>
                <option value="4">Country</option>
              </select>
            </div>
          </form>
        </div>
        <div class="col-lg-4">
          <div class="order_box">
            <h2>Your Order</h2>
            <ul class="list">
              <li><a href="#">Product <span>Total</span></a></li>
              <li><a href="#">Fresh Blackberry <span class="middle">x 02</span> <span class="last">$720.00</span></a></li>
              <li><a href="#">Fresh Tomatoes <span class="middle">x 02</span> <span class="last">$720.00</span></a></li>
              <li><a href="#">Fresh Brocoli <span class="middle">x 02</span> <span class="last">$720.00</span></a></li>
            </ul>
            <ul class="list list_2">
              <li><a href="#">Subtotal <span>$2160.00</span></a></li>
              <li><a href="#">Shipping <span>Flat rate: $50.00</span></a></li>
              <li><a href="#">Total <span>$2210.00</span></a></li>
            </ul>
            <a class="primary-btn" href="#">Proceed to checkout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  require 'unit/footer.php';
  require 'unit/base.php';
?>