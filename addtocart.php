<?php
session_start();
require 'config/database.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
  
    $selectProdcut = $pdo->prepare("SELECT * FROM products WHERE id=$productId");
    $selectProdcut->execute();
    $sProduct = $selectProdcut->fetch(PDO::FETCH_ASSOC);
  
    if ($quantity > $sProduct['quantity']) {
      echo "<script>alert('Not enough item');window.location.href='index.php'</script>";
    } else {
      if (empty($_SESSION['cart']['pid'.$productId])) {
        $qty = $_SESSION['cart']['pid'.$productId] = $quantity;
        echo "<script>alert('This item added to the cart');window.location.href='index.php'</script>";
      } else {
        $qty = $_SESSION['cart']['pid'.$productId] += $quantity;
        echo "<script>alert('This item added puls to the cart');window.location.href='index.php'</script>";
      }
    }
  }
}


  
?>