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
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              for ($i=1; $i < 9; $i++) { 
            ?>
            <tr>
              <td>
                <div class="media">
                <div class="d-flex">
                <img src="images/bg2.jpg" style="width:100px;height:auto;"
                alt="" data-pagespeed-url-hash="1739756765" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                </div>
                <div class="media-body">
                <p>Minimalistic shop for multipurpose use</p>
                </div>
                </div>
              </td>
              <td>
                <h5>$360.00</h5>
              </td>
              <td>
                <div class="product_count">
                  <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                  <button class="increase items-count" type="button"><i class='bx bxs-up-arrow'></i></button>
                  <button class="reduced items-count" type="button"><i class='bx bxs-down-arrow' ></i></button>
                </div>
              </td>
              <td>
                <h5>$720.00</h5>
              </td>
            </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php
  require 'unit/footer.php';
  require 'unit/base.php';
?>