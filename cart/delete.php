<?php
    session_start();
    unset($_SESSION['cart']['pid'.$_GET['id']]); 
    echo "<script>alert('Cart Item successfully removed...');window.location.href='../cart.php';</script>";
?>