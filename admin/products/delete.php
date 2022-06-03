<?php
    require '../../config/database.php';
    $stmt = $pdo->prepare('SELECT img FROM products WHERE id = :id');
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // <-- filter your data first (see [Data Filtering](#data_filtering)), especially important for INSERT, UPDATE, etc.
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
    $stmt->execute();
    $oldPost = $stmt->fetchAll();

    $checkImg = 'images/'. $oldPost[0]['img'];
    if (file_exists($checkImg)) {
        unlink($checkImg);
        $del_stmt = $pdo->prepare("DELETE FROM products WHERE id=:id");
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // <-- filter your data first (see [Data Filtering](#data_filtering)), especially important for INSERT, UPDATE, etc.
        $del_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $del_stmt->execute();
        header('Location: ../products.php');
    } else {
        $del_stmt = $pdo->prepare("DELETE FROM products WHERE id=:id");
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // <-- filter your data first (see [Data Filtering](#data_filtering)), especially important for INSERT, UPDATE, etc.
        $del_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $del_stmt->execute();
        header('Location: ../products.php');
    }
?>