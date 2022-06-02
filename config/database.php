<?php

# Database Connection

$servername = "localhost";
$username = "root"; # username
$password = "";     # password

try {
  $pdo = new PDO("mysql:host=$servername;dbname=php_ecommerce", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>