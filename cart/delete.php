<?php
    session_start();
    require '../config/database.php';
    $getpid = $pdo->prepare("SELECT * FROM cart WHERE id=".$_GET['id']);
    $getpid->execute();
    $result = $getpid->fetch(PDO::FETCH_ASSOC); 
    $pid  = $result['product_id'];
    unset($_SESSION['cart']['pid'.$pid]); // SESSION QTY UNSET

    $pdo_statement = $pdo->prepare("DELETE FROM cart WHERE id=".$_GET['id']);
    $result = $pdo_statement->execute();
    if ($result) {
        echo "<script>alert('Cart Item successfully deleted...');window.location.href='../cart.php';</script>";
    } else {
        echo "<script>alert('Cart Item to delete is fail!');window.location.href='../cart.php';</script>";
    }
?>