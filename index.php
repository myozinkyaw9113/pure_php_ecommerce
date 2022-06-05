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

    # Show Lastest 8 items 
    $pdo_latest_items = $pdo->prepare("SELECT * FROM products LIMIT 0,9"); 
    $pdo_latest_items->execute();
    $latestItems = $pdo_latest_items->fetchAll();

?>

<?php 
    require 'unit/href.php';
    require 'unit/top.php';
    require 'unit/header_nav.php';
?>

<section class="banner-area">
<div class="container">
<div class="row fullscreen align-items-center justify-content-start">
<div class="col-lg-12">
<div class="active-banner-slider owl-carousel">

<div class="row single-slide align-items-center d-flex">
<div class="col-lg-5 col-md-6">
<div class="banner-content">
<h1>Nike New <br>Collection!</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
<div class="add-bag d-flex align-items-center">
<a class="add-btn" href=""><span class="lnr lnr-cross"></span></a>
<span class="add-text text-uppercase">Add to Bag</span>
</div>
</div>
</div>
<div class="col-lg-7">
<div class="banner-img">
<img class="img-fluid" src="https://preview.colorlib.com/theme/karma/img/banner/xbanner-img.png.pagespeed.ic.xt3MuruiIf.webp" alt="">
</div>
</div>
</div>

<div class="row single-slide">
<div class="col-lg-5">
<div class="banner-content">
<h1>Nike New <br>Collection!</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
<div class="add-bag d-flex align-items-center">
<a class="add-btn" href=""><span class="lnr lnr-cross"></span></a>
<span class="add-text text-uppercase">Add to Bag</span>
</div>
</div>
</div>
<div class="col-lg-7">
<div class="banner-img">
<img class="img-fluid" src="https://preview.colorlib.com/theme/karma/img/banner/xbanner-img.png.pagespeed.ic.xt3MuruiIf.webp" alt="">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>


<section class="features-area section_gap">
<div class="container">
<div class="row features-inner">

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="single-features">
<div class="f-icon">
<img src="images/lorry.webp" alt="">
</div>
<h6>Free Delivery</h6>
<p>Free Shipping on all order</p>
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="single-features">
<div class="f-icon">
<img src="images/return_policy.png" alt="">
</div>
<h6>Return Policy</h6>
<p>Free Shipping on all order</p>
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="single-features">
<div class="f-icon">
<img src="images/support.webp" alt="">
</div>
<h6>24/7 Support</h6>
<p>Free Shipping on all order</p>
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="single-features">
<div class="f-icon">
<img src="images/lorry.webp" alt="">
</div>
<h6>Secure Payment</h6>
<p>Free Shipping on all order</p>
</div>
</div>
</div>
</div>
</section>


<section class="owl-carousel active-product-area section_gap">

    <div class="single-product-slider">
        
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Latest Products</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore
                        magna aliqua.</p>
                    </div>
                </div>
            </div>

            <div class="row">

            <?php 
                for ($i=0; $i < count($latestItems); $i++) { 
            ?>

            <div class="col-lg-3 col-md-6">
                <div class="single-product">
                    <img class="img-fluid" style="width:auto;height:150px;" src="admin/products/images/<?php echo escape($latestItems[$i]['img']); ?>" alt="">
                    <div class="product-details">
                        <h6><?php echo escape($latestItems[$i]['name']); ?></h6>
                        <div class="price">
                            <h6><?php echo '$' . escape($latestItems[$i]['price']) - 0.5; ?></h6>
                            <h6 class="l-through"><?php echo '$'. escape($latestItems[$i]['price']); ?></h6> <!-- Discount -->
                        </div>
                        <div class="prd-bottom">
                            <a href="" class="social-info">
                                <span><i class='bx bx-shopping-bag' ></i></span>
                                <p class="hover-text">add to bag</p>
                            </a>
                            <a href="" class="social-info">
                                <span><i class='bx bx-heart'></i></span>
                                <p class="hover-text">Wishlist</p>
                            </a>
                            <a href="" class="social-info">
                                <span><i class='bx bx-sync' ></i></span>
                                <p class="hover-text">compare</p>
                            </a>
                            <a href="product-detail.php?id=<?php echo escape($latestItems[$i]['id']); ?>" class="social-info">
                                <span><i class='bx bx-move' ></i></span>
                                <p class="hover-text">view more</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                }
            ?>

            </div>

        </div>
        
    </div>

    <div class="single-product-slider">
        
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Latest Products</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore
                        magna aliqua.</p>
                    </div>
                </div>
            </div>

            <div class="row">

            <?php 
                for ($i=0; $i < count($latestItems); $i++) { 
            ?>

            <div class="col-lg-3 col-md-6">
                <div class="single-product">
                    <img class="img-fluid" style="width:auto;height:150px;" src="admin/products/images/<?php echo escape($latestItems[$i]['img']); ?>" alt="">
                    <div class="product-details">
                        <h6><?php echo escape($latestItems[$i]['name']); ?></h6>
                        <div class="price">
                            <h6><?php echo '$' . escape($latestItems[$i]['price']) - 0.5; ?></h6>
                            <h6 class="l-through"><?php echo '$'. escape($latestItems[$i]['price']); ?></h6> <!-- Discount -->
                        </div>
                        <div class="prd-bottom">
                            <a href="" class="social-info">
                                <span><i class='bx bx-shopping-bag' ></i></span>
                                <p class="hover-text">add to bag</p>
                            </a>
                            <a href="" class="social-info">
                                <span><i class='bx bx-heart'></i></span>
                                <p class="hover-text">Wishlist</p>
                            </a>
                            <a href="" class="social-info">
                                <span><i class='bx bx-sync' ></i></span>
                                <p class="hover-text">compare</p>
                            </a>
                            <a href="product-detail.php?id=<?php echo escape($latestItems[$i]['id']); ?>" class="social-info">
                                <span><i class='bx bx-move' ></i></span>
                                <p class="hover-text">view more</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                }
            ?>


            </div>
        </div>
    </div>

</section>

<?php 
    require 'unit/footer.php';
    require 'unit/base.php';
?>