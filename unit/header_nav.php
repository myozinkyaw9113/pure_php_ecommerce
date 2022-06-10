<?php
    $cart = 0;
    if (isset($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $key => $qty) {
            $cart += $qty;
        }
    }
?>

<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <a class="navbar-brand logo_h" href="php_ecommerce/../index.php"><img style="width:100px;height:auto;" src="images/logo.webp" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item <?php if($link == 'index.php') { echo 'active'; } ?>"><a class="nav-link" href="php_ecommerce/../index.php">Home</a></li>
                        <?php
                            if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
                        ?>

                        <li class="nav-item <?php if($link == 'login.php') { echo 'active'; } ?>"><a class="nav-link" href="php_ecommerce/../login.php">Login</a></li>         
                        
                        <?php
                        } else {
                        ?>
                        
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-underline" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo escape($loginUser['name']); ?></a>
                            <ul class="dropdown-menu">
                                <?php
                                    if ($_SESSION['user_id'] == 1) {
                                ?>
                                <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin Panel</a></li>
                                <?php
                                    }
                                ?>
                                <li class="nav-item"><a class="nav-link" href="php_ecommerce/../logout/logout.php">Logout</a></li>
                            </ul>
                        </li>
                            
                        <?php
                        }
                        ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <li class="nav-item <?php if($link == 'cart.php') { echo 'active'; } ?>">
                                <a href="php_ecommerce/../cart.php" class="cart">
                                    <i class='bx bx-shopping-bag'></i>
                                    <span class="badge px-1 text-bg-warning" style="line-height: 10px;"><?php echo $cart; ?></span>
                                </a>
                                
                            </li>
                        <?php
                            }
                        ?>

                        <?php
                            if ($link == 'index.php') {
                        ?>
                        <li class="nav-item">
                            <button class="search">
                                <i class='bx bx-search-alt-2' id="search"></i>
                            </button>
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="search_input" id="search_input_box">
        <div class="container">
            <form class="d-flex justify-content-between" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="text" name="search" class="form-control" id="search_input" placeholder="Search Here">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>