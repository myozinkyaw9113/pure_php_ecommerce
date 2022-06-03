<?php
    require '../../config/database.php';
    $pdo_statement = $pdo->prepare("DELETE FROM categories WHERE id=".$_GET['id']);
    $result = $pdo_statement->execute();
    if ($result) {
        echo "<script>alert('Task successfully deleted...');window.location.href='../category.php';</script>";
    } else {
        echo "<script>alert('Task to delete is fail!');window.location.href='../category.php';</script>";
    }
?>