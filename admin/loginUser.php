<?php
    if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
        header('Location: ../login.php');
    }

    if ($_SESSION) {
        if ($_SESSION['user_id'] != 1) {
        header('Location: ../index.php');
        }
    }

    $url = $_SERVER['PHP_SELF'];
    $url_array = explode('/',$url);
    $link = end($url_array);
?>