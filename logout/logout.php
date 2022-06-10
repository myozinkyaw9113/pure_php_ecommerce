<?php
    session_start();
    unset($_SESSION['user_id'],$_SESSION['logged_in']);
    header('Location: ../login.php');
?>