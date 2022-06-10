<?php
    session_start();
    unset($_SESSION['cart']); 
    echo "<script>alert('All of the cart item removed...');window.location.href='../cart.php';</script>";
?>