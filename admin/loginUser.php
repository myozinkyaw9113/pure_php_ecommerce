<?php
    if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
        header('Location: ../login.php');
    }

    if ($_SESSION) {
        if ($_SESSION['user_id'] != 1) {
        header('Location: ../index.php');
        }
    }
    
    if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
        # Select this user with SESSION['user_id']
        $pdo_this_user = $pdo->prepare("SELECT * FROM users WHERE id=".$_SESSION['user_id']); 
        $pdo_this_user->execute();
        $loginUser = $pdo_this_user->fetch(PDO::FETCH_ASSOC);
    }
?>