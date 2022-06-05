<?php
    session_start();
    require 'config/database.php';
    require 'config/common.php';
    require 'unit/href.php';

    if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
        # Select this user with SESSION['user_id']
        $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
        $pdo_this_user->execute();
        $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC);
    }

    # Pagination 
    # p = $pageno;
    $p = '';
    if (!empty($_GET['p'])) {
        $p = $_GET['p'];
    } else {
        $p = 1;
    }
    $showrecs = 8;
    $offset = ($p - 1) * $showrecs;

    $pdo_prepare = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
    $pdo_prepare->execute();
    $categoryResult = $pdo_prepare->fetchAll();
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $categoryId = $_POST['category_id'];

        $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId ORDER BY id DESC");
        $pdo_prepare->execute();
        $raw_result = $pdo_prepare->fetchAll();

        $total_pages = ceil(count($raw_result) / $showrecs);

        $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId ORDER BY id DESC LIMIT $offset,$showrecs");
        $pdo_prepare->execute();
        $productResult = $pdo_prepare->fetchAll();
    }

?>

<?php
require 'unit/top.php';
require 'unit/header_nav.php';
?>

<style>
    .category_banner_area {
      background: url(images/bg1.webp) center no-repeat;
      background-size: cover;
    }
    .category_banner_area h1, .category_banner_area nav a {
        color: #000;
    }

    .searchCategory {
        color: #000;
        border: none;
        outline: none;
        padding: 1rem 1rem;
        background-color: transparent;
    }
</style>

<section class="banner-area category_banner_area organic-breadcrumb">

    <div class="container">

        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">

            <div class="col-first">

                <h1>Shop Category page</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span><i class='bx bx-right-arrow'></i></span></a>
                    <a href="#">Shop<span><i class='bx bx-right-arrow'></i></span></a>
                    <a href="category.php">Fashon Category</a>
                </nav>

            </div>

        </div>

    </div>

</section>

<div class="container pb-5">

    <div class="row">

        <div class="col-xl-2 col-lg-3 col-md-4">

            <div class="sidebar-categories">

                <div class="head">Browse Categories</div>
                <ul class="main-categories p-0">

                    <?php 
                        for ($i=0; $i < count($categoryResult); $i++) { 
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

                        <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <li class="main-nav-list" style="border-bottom: 1px solid #bbb;">
                            <input type="hidden" value="<?php echo escape($categoryResult[$i]['id']); ?>" name="category_id">
                            <input type="submit" value="<?php echo escape($categoryResult[$i]['name']) . '(?)'; ?>" class="lnr lnr-arrow-right w-100 d-flex searchCategory">
                        </li>

                    </form>

                    <?php
                        }
                    ?>

                </ul>

            </div>

        </div>

        <div class="col-xl-10 col-lg-9 col-md-8">

            <div class="filter-bar d-flex flex-wrap align-items-center">

                <div class="sorting">
                    <select>
                    <option value="1">Default sorting</option>
                    <option value="1">Default sorting</option>
                    <option value="1">Default sorting</option>
                    </select>
                </div>

                <div class="sorting mr-auto">
                    <select>
                    <option value="1">Show 12</option>
                    <option value="1">Show 12</option>
                    <option value="1">Show 12</option>
                    </select>
                </div>

                <div class="pagination">
                    <a href="#" href="?p=1" class="prev-arrow">
                        <i class='bx bx-chevrons-left'></i>
                    </a>
                    <a class="active <?php if($p <= 1){ echo 'disabled'; } ?>" href="<?php if($p <= 1){ echo '#'; }else{ echo '?p='.($p-1); } ?>">
                        <i class='bx bxs-chevron-left' ></i>
                    </a>
                    <a href="#">C</a>
                    <a class="<?php if($p >= $total_pages){ echo 'disabled'; } ?>" href="<?php if($p >= $total_pages){ echo '#'; }else{ echo '?p='.($p+1); } ?>" class="<?php if($p >= $total_pages){ echo 'disabled'; } ?>">
                        <i class='bx bxs-chevron-right' ></i>
                    </a>
                    <a href="?p=<?php echo $total_pages; ?>" class="next-arrow">
                        <i class='bx bxs-chevrons-right' ></i>
                    </a>
                </div>

            </div>


            <section class="lattest-product-area pb-40 category-list">

                <div class="row"> 

                    <?php 
                        if (empty($productResult)) {
                            echo '
                            <h3 class="p-0 m-5">Please, click anything from <u>Browse category</u> to search for you a individual result.
                            </br>
                            <b>If clicking result is blank, It is empty in your category search.</b>
                            </h3>';
                        } else {
                    ?>

                    <?php 
                        foreach ($productResult as $key => $value) {
                    ?>

                    <div class="col-lg-4 col-md-6">

                        <div class="single-product">

                            <img style="height:120px;width:auto;" class="img-fluid" src="admin/products/images/<?php echo escape($value['img']); ?>" alt="#">

                            <div class="product-details">
                                <h6><?php echo escape($value['name']); ?></h6>
                                <div class="price">
                                    <h6><?php echo '$' . escape($value['price']) - 0.5; ?></h6>
                                    <h6 class="l-through"><?php echo '$' . escape($value['price']); ?></h6>
                                </div>
                                <div class="prd-bottom">
                                    <a href="" class="social-info">
                                        <span><i class='bx bx-shopping-bag' ></i></span>
                                        <p class="hover-text">add to bag</p>
                                    </a>
                                    <a href="" class="social-info">
                                        <span><i class='bx bx-heart' ></i></span>
                                        <p class="hover-text">Wishlist</p>
                                    </a>
                                    <a href="" class="social-info">
                                        <span><i class='bx bx-sync' ></i></span>
                                        <p class="hover-text">compare</p>
                                    </a>
                                    <a href="" class="social-info">
                                        <span><i class='bx bx-move'></i></span>
                                        <p class="hover-text">view more</p>
                                    </a>
                                </div>
                                
                            </div>

                        </div>

                    </div>

                    <?php
                            }
                        }
                    ?>

                </div>
                
            </section>

        </div>

    </div>

</div>

<?php
  require 'unit/footer.php';
  require 'unit/base.php';
?>