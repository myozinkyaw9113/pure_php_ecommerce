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

    $pdo_prepare = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
    $pdo_prepare->execute();
    $categoryResult = $pdo_prepare->fetchAll();

    if (isset($_POST['search'])) {
        setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
      } else {
        if (empty($_GET['p'])) { 
          unset($_COOKIE['search']);
          setcookie('search',null, -1, '/');
        }
      }
    
      # Pagination 
      # p = $pageno;
      $p = '';
      if (!empty($_GET['p'])) {
        $p = $_GET['p'];
      } else {
        $p = 1;
      }
      $showrecs = 9;
      $offset = ($p - 1) * $showrecs;
    
    if (empty($_POST['search']) && empty($_COOKIE['search'])) {
        if (isset($_GET['name'])) {
            $categoryName = $_GET['name'];
    
            foreach($categoryResult as $value) {
                if ($value['name'] == $categoryName) {
                    $categoryId = $value['id'];
                }
            }
    
            $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id DESC");
            $pdo_prepare->execute();
            $raw_result = $pdo_prepare->fetchAll();
        
            $total_pages = ceil(count($raw_result) / $showrecs);
        
            $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id DESC LIMIT $offset,$showrecs");
            $pdo_prepare->execute();
            $result = $pdo_prepare->fetchAll();
        } else {
            $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
            $pdo_prepare->execute();
            $raw_result = $pdo_prepare->fetchAll();
        
            $total_pages = ceil(count($raw_result) / $showrecs);
        
            $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $offset,$showrecs");
            $pdo_prepare->execute();
            $result = $pdo_prepare->fetchAll();
        }
    } else {
        if (isset($_POST['search'])) {
          $search = $_POST['search'];
        } else {
          $search = $_COOKIE['search'];
        }
        $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search%' AND quantity > 0 ORDER BY id DESC");
        $pdo_prepare->execute();
        $raw_result = $pdo_prepare->fetchAll();
    
        $total_pages = ceil(count($raw_result) / $showrecs);
    
        $pdo_prepare = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$search%' AND quantity > 0 ORDER BY id DESC LIMIT $offset,$showrecs");
        $pdo_prepare->execute();
        $result = $pdo_prepare->fetchAll();
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
    
    a.active-category {
        color: #FF8A03;
    }

</style>

<section class="banner-area category_banner_area organic-breadcrumb">

    <div class="container">

        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">

            <div class="col-first">

                <h1>Welcome <?php if (isset($_SESSION['user_id'])) { echo escape($loginUser['name']); } ?></h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home</a>
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
                        foreach ($categoryResult as $category) { 
                    ?>
                    <?php
                    $prod_stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=".$category['id']);
                    $prod_stmt->execute();
                    $prod_count = $prod_stmt->fetchAll();
                    ?>

                        <li class="main-nav-list" style="border-bottom: 1px solid #bbb;">
                            <a class="<?php if (isset($_GET['name'])) { if ($_GET['name'] == $category['name']) { echo 'active-category'; } } ?>" href="?name=<?php echo $category['name']; ?>">
                                <?php echo $category['name']; ?>
                                (<?php echo count($prod_count) ?>)
                            </a>
                        </li>

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
                    <a href="?p=1" class="prev-arrow">
                        <i class='bx bx-chevrons-left'></i>
                    </a>
                    <a class="<?php if($p <= 1){ echo 'disabled'; } ?>" href="<?php if($p <= 1){ echo '#'; }else{ echo '?p='.($p-1); } ?>">
                        <i class='bx bxs-chevron-left' ></i>
                    </a>
                    <a href="#" class="active"><?php echo $p; ?></a>
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
                        if (empty($result)) {
                            echo '<h3 class="p-0 m-5">Non Products</h3>';
                        } else {
                    ?>

                    <?php 
                        foreach ($result as $value) {
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
                                    <form action="addtocart.php" method="POST" class="d-flex"> 
                                        <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo escape($value['id']); ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <div class="social-info p-0">
                                            <button type="submit" class="p-0" style="border:none;outline:none;background-color:transparent;">
                                                <span><i class='bx bx-shopping-bag' ></i></span>
                                                <p class="hover-text w-auto">add to bag</p>
                                            </button>
                                        </div>
                                        <a href="product-detail.php?id=<?php echo escape($value['id']); ?>" class="social-info">
                                            <span><i class='bx bx-move'></i></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </form>
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