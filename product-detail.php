<?php
  session_start();
  require 'config/database.php';
  require 'config/common.php';

  if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
    # Select this user with SESSION['user_id']
    $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
    $pdo_this_user->execute();
    $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC); 
  }

  # Get Detail Product
  if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // <-- filter your data first (see [Data Filtering](#data_filtering)), especially important for INSERT, UPDATE, etc.
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
    $stmt->execute();
    $detailProduct = $stmt->fetchAll();
  }

  $categoryId = $detailProduct[0]['category_id'];

  # Get Category
  $pdo_prepare = $pdo->prepare("SELECT * FROM categories WHERE id=$categoryId");
  $pdo_prepare->execute();
  $category = $pdo_prepare->fetchAll();  

?>

<?php
  require 'unit/top.php';
  require 'unit/header_nav.php';
?>

<style>
  .product_banner_area {
    background: url(images/bg1.webp) center no-repeat;
    background-size: cover;
  }
  .product_banner_area h1, .product_banner_area nav a {
      color: #000;
  }
</style>

<section class="banner-area product_banner_area organic-breadcrumb">
  <div class="container">
    <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
      <div class="col-first">
        <h1>Product Details Page</h1>
        <nav class="d-flex align-items-center">
          <a href="index.php">Home<span><i class='bx bxs-right-arrow' ></i></span></a>
          <a href="#">Shop<span><i class='bx bxs-right-arrow' ></i></span></a>
          <a href="product.php">product-details</a>
        </nav>
      </div>
    </div>
  </div>
</section>


<div class="product_image_area">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <div class="s_Product_carousel">
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/products/images/<?php echo escape($detailProduct[0]['img']) ?>" alt="" data-pagespeed-url-hash="371695269" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/products/images/<?php echo escape($detailProduct[0]['img']) ?>" alt="" data-pagespeed-url-hash="371695269" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/products/images/<?php echo escape($detailProduct[0]['img']) ?>" alt="" data-pagespeed-url-hash="371695269" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
          </div>
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($detailProduct[0]['name']); ?></h3>
          <h2><?php echo '$' . escape($detailProduct[0]['price']) - 0.5; ?> </h2>
          <h2 style="text-decoration: line-through;"><?php echo '$' . escape($detailProduct[0]['price']); ?></h2>
          
          <ul class="list">
            <li><a href="#"><span>Category</span> : <?php echo escape($category[0]['name']); ?></a></li>
            <li>
              <a href="#">
                <span>Availibility</span> : 
                <b class="<?php if ($detailProduct[0]['quantity'] == 0) { echo 'text-danger'; } ?>">
                  <?php if ($detailProduct[0]['quantity'] > 0) {
                  echo 'In Stock';
                  } else {
                    echo 'Out Of Stock';
                  }
                  ?>
                </b>
              </a>
            </li>
          </ul>
          <p><?php echo escape($detailProduct[0]['description']); ?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
            <button class="increase items-count" type="button"><i class='bx bxs-up-arrow' ></i></button>
            <button class="reduced items-count" type="button"><i class='bx bxs-down-arrow' ></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
            <a class="icon_btn" href="#"><i class='bx bx-diamond' ></i></a>
            <a class="icon_btn" href="#"><i class='bx bx-heart' ></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<section class="product_description_area">
  <div class="container">
    <!-- Tab -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Specification</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Comments</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Reviews</a>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">

      <!-- Description tab -->
      <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
        <p>
          Beryl Cook is one of Britain’s most talented and amusing artists .Beryl’s pictures feature women of all shapes
          and sizes enjoying themselves .Born between the two world wars, Beryl Cook eventually left Kendrick School in
          Reading at the age of 15, where she went to secretarial school and then into an insurance office. After moving to
          London and then Hampton.</p>
        </p>
      </div>
      
      <!-- Specification tag -->
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <td>
                  <h5>Width</h5>
                </td>
                <td>
                  <h5>128mm</h5>
                </td>
              </tr>
              <tr>
                <td>
                  <h5>Height</h5>
                </td>
                <td>
                  <h5>508mm</h5>
                </td>
              </tr>
              <tr>
                <td>
                  <h5>Depth</h5>
                </td>
                <td>
                  <h5>85mm</h5>
                </td>
              </tr>
              <tr>
                <td>
                  <h5>Weight</h5>
                </td>
                <td>
                  <h5>52gm</h5>
                </td>
              </tr>
              <tr>
                <td>
                  <h5>Quality checking</h5>
                </td>
                <td>
                  <h5>yes</h5>
                </td>
              </tr>
              <tr>
                <td>
                  <h5>Freshness Duration</h5>
                </td>
                <td>
                  <h5>03days</h5>
                </td>
              </tr>
              <tr>
                <td>
                  <h5>When packeting</h5>
                </td>
                <td>
                  <h5>Without touch of hand</h5>
                </td>
              </tr>
              <tr>
                <td>
                  <h5>Each Box contains</h5>
                </td>
                <td>
                  <h5>60pcs</h5>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Comments tag-->
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
      <div class="row">
      <div class="col-lg-6">
      <div class="comment_list">
      <div class="review_item">
      <div class="media">
      <div class="d-flex">
      <img src="img/product/review-1.png" alt="" data-pagespeed-url-hash="221112997" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
      </div>
      <div class="media-body">
      <h4>Blake Ruiz</h4>
      <h5>12th Feb, 2018 at 05:56 pm</h5>
      <a class="reply_btn" href="#">Reply</a>
      </div>
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo</p>
      </div>
      <div class="review_item reply">
      <div class="media">
      <div class="d-flex">
      <img src="img/product/review-2.png" alt="" data-pagespeed-url-hash="515612918" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
      </div>
      <div class="media-body">
      <h4>Blake Ruiz</h4>
      <h5>12th Feb, 2018 at 05:56 pm</h5>
      <a class="reply_btn" href="#">Reply</a>
      </div>
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo</p>
      </div>
      <div class="review_item">
      <div class="media">
      <div class="d-flex">
      <img src="img/product/review-3.png" alt="" data-pagespeed-url-hash="810112839" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
      </div>
      <div class="media-body">
      <h4>Blake Ruiz</h4>
      <h5>12th Feb, 2018 at 05:56 pm</h5>
      <a class="reply_btn" href="#">Reply</a>
      </div>
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo</p>
      </div>
      </div>
      </div>
      <div class="col-lg-6">
      <div class="review_box">
      <h4>Post a comment</h4>
      <form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate>
      <div class="col-md-12">
      <div class="form-group">
      <input type="text" class="form-control" id="name" name="name" placeholder="Your Full name">
      </div>
      </div>
      <div class="col-md-12">
      <div class="form-group">
      <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
      </div>
      </div>
      <div class="col-md-12">
      <div class="form-group">
      <input type="text" class="form-control" id="number" name="number" placeholder="Phone Number">
      </div>
      </div>
      <div class="col-md-12">
      <div class="form-group">
      <textarea class="form-control" name="message" id="message" rows="1" placeholder="Message"></textarea>
      </div>
      </div>
      <div class="col-md-12 text-right">
      <button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
      </div>
      </form>
      </div>
      </div>
      </div>
      </div>

      <!-- Review tab -->
      <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
      <div class="row">
      <div class="col-lg-6">
      <div class="row total_rate">
      <div class="col-6">
      <div class="box_total">
      <h5>Overall</h5>
      <h4>4.0</h4>
      <h6>(03 Reviews)</h6>
      </div>
      </div>
      <div class="col-6">
      <div class="rating_list">
      <h3>Based on 3 Reviews</h3>
      <ul class="list">
      <li><a href="#">5 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
      <li><a href="#">4 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
      <li><a href="#">3 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
      <li><a href="#">2 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
      <li><a href="#">1 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
      </ul>
      </div>
      </div>
      </div>
      <div class="review_list">
      <div class="review_item">
      <div class="media">
      <div class="d-flex">
      <img src="img/product/review-1.png" alt="" data-pagespeed-url-hash="221112997" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
      </div>
      <div class="media-body">
      <h4>Blake Ruiz</h4>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      </div>
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo</p>
      </div>
      <div class="review_item">
      <div class="media">
      <div class="d-flex">
      <img src="img/product/review-2.png" alt="" data-pagespeed-url-hash="515612918" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
      </div>
      <div class="media-body">
      <h4>Blake Ruiz</h4>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      </div>
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo</p>
      </div>
      <div class="review_item">
      <div class="media">
      <div class="d-flex">
      <img src="img/product/review-3.png" alt="" data-pagespeed-url-hash="810112839" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
      </div>
      <div class="media-body">
      <h4>Blake Ruiz</h4>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      <i class="fa fa-star"></i>
      </div>
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
      dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo</p>
      </div>
      </div>
      </div>
      <div class="col-lg-6">
      <div class="review_box">
      <h4>Add a Review</h4>
      <p>Your Rating:</p>
      <ul class="list">
      <li><a href="#"><i class="fa fa-star"></i></a></li>
      <li><a href="#"><i class="fa fa-star"></i></a></li>
      <li><a href="#"><i class="fa fa-star"></i></a></li>
      <li><a href="#"><i class="fa fa-star"></i></a></li>
      <li><a href="#"><i class="fa fa-star"></i></a></li>
      </ul>
      <p>Outstanding</p>
      <form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate>
      <div class="col-md-12">
      <div class="form-group">
      <input type="text" class="form-control" id="name" name="name" placeholder="Your Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Full name'">
      </div>
      </div>
      <div class="col-md-12">
      <div class="form-group">
      <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
      </div>
      </div>
      <div class="col-md-12">
      <div class="form-group">
      <input type="text" class="form-control" id="number" name="number" placeholder="Phone Number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'">
      </div>
      </div>
      <div class="col-md-12">
      <div class="form-group">
      <textarea class="form-control" name="message" id="message" rows="1" placeholder="Review" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Review'"></textarea></textarea>
      </div>
      </div>
      <div class="col-md-12 text-right">
      <button type="submit" value="submit" class="primary-btn">Submit Now</button>
      </div>
      </form>
      </div>
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

