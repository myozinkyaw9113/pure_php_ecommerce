<?php 
  session_start();
  require 'config/database.php';
  require 'config/common.php';
  require 'unit/href.php';

  $name = $email = $password = "";
  $nameErr = $emailErr = $passwordErr = $lengthErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || (strlen($_POST['password']) < 8)) {
      
      if (empty($_POST['name'])) {
        $nameErr = "* Name is required";
      }

      if (empty($_POST['email'])) {
        $emailErr = "* Email is required";
      }

      if (empty($_POST['password'])) {
        $passwordErr = "* Password is required";
      }
  
      if (strlen($_POST['password']) < 8) {
        $lengthErr = '* Password must have at least 8 characters.';
      }
      
    } else {
      $name = test_input($_POST["name"]);
      $email = test_input($_POST["email"]);
      $password = test_input($_POST["password"]);

      $selectUser = $pdo->prepare("SELECT * FROM users WHERE email=:email");
      $selectUser->bindValue(':email', $email);
      $selectUser->execute();
      $user = $selectUser->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        echo '<script>alert("Current email is already exist");window.location.href="register.php";</script>';
      } else {
        $sql = "INSERT INTO users(name,email,password) 
                VALUES(:name,:email,:password)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(
          array(
              ':name' => $name,
              ':email'=> $email,
              ':password'=> password_hash($password, PASSWORD_DEFAULT), # echo password_hash('password',PASSWORD_DEFAULT);
          )
        );
        if ($result) {
          echo '<script>alert("Register success, Please login");window.location.href="login.php";</script>';
        }
      }
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" href="img/xfav.png.pagespeed.ic.VVulyR7OLy.webp">

  <meta name="author" content="CodePixar">

  <meta name="description" content="">

  <meta name="keywords" content="">

  <meta charset="UTF-8">

  <title>Ecommerce Shop - Register</title>
  
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="css/1.css" />
  <link rel="stylesheet" href="css/2.css">
  <script nonce="05e890cf-331f-4ae4-8ecd-24d3030acbdb">(function(w,d){!function(a,e,t,r){a.zarazData=a.zarazData||{},a.zarazData.executed=[],a.zaraz={deferred:[]},a.zaraz.q=[],a.zaraz._f=function(e){return function(){var t=Array.prototype.slice.call(arguments);a.zaraz.q.push({m:e,a:t})}};for(const e of["track","set","ecommerce","debug"])a.zaraz[e]=a.zaraz._f(e);a.addEventListener("DOMContentLoaded",(()=>{var t=e.getElementsByTagName(r)[0],z=e.createElement(r),n=e.getElementsByTagName("title")[0];for(n&&(a.zarazData.t=e.getElementsByTagName("title")[0].text),a.zarazData.x=Math.random(),a.zarazData.w=a.screen.width,a.zarazData.h=a.screen.height,a.zarazData.j=a.innerHeight,a.zarazData.e=a.innerWidth,a.zarazData.l=a.location.href,a.zarazData.r=e.referrer,a.zarazData.k=a.screen.colorDepth,a.zarazData.n=e.characterSet,a.zarazData.o=(new Date).getTimezoneOffset(),a.zarazData.q=[];a.zaraz.q.length;){const e=a.zaraz.q.shift();a.zarazData.q.push(e)}z.defer=!0;for(const e of[localStorage,sessionStorage])Object.keys(e).filter((a=>a.startsWith("_zaraz_"))).forEach((t=>{try{a.zarazData["z_"+t.slice(7)]=JSON.parse(e.getItem(t))}catch{a.zarazData["z_"+t.slice(7)]=e.getItem(t)}}));z.referrerPolicy="origin",z.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(a.zarazData))),t.parentNode.insertBefore(z,t)}))}(w,d,0,"script");})(window,document);</script></head>
  <style>
    .login-banner-area {
      background: url(images/bg1.webp) center no-repeat;
      background-size: cover;
    }
    .login-banner-area h1, .login-banner-area nav a {
      color: #000;
    }
  </style>
<body>

<?php require 'unit/header_nav.php'; ?>

<section class="banner-area login-banner-area organic-breadcrumb">
<div class="container">
<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
<div class="col-first">
<h1>Register Page</h1>
<nav class="d-flex align-items-center">
<a href="index.php">Home<span><i class="bx bxs-right-arrow"></i></span></a>
<a href="register.php">Register</a>
</nav>
</div>
</div>
</div>
</section>


<section class="login_box_area section_gap">
<div class="container">
<div class="row">
<div class="col-lg-6">
<div class="login_box_img">
<img class="img-fluid" src="images/bg2.jpg" alt="" data-pagespeed-url-hash="1116997326" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
<div class="hover">
<h4> Our Customer?</h4>
<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
<a class="primary-btn" href="login.php">Already have an account?</a>
</div>
</div>
</div>
<div class="col-lg-6">
    <div class="login_form_inner">
        <h3>Register in to enter</h3>
        <form class="row login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <input name="_token" type="hidden" value="<?php echo $_SESSION['csrf_token']; ?>">
          <div class="col-md-12 form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="Username">
            <span class="text-danger"><?php echo $nameErr; ?></span>
          </div>
          <div class="col-md-12 form-group">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            <span class="text-danger"><?php echo $emailErr; ?></span>
          </div>
          <div class="col-md-12 form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <span class="text-danger"><?php echo $passwordErr; ?></span>
            <span class="text-danger"><?php echo $lengthErr; ?></span>
          </div>
          <div class="col-md-12 form-group">
            <div class="creat_account">
              <input type="checkbox" id="f-option2">
              <label for="f-option2">I aggree to the terms and policy of e-shop</label>
            </div>
          </div>
          <div class="col-md-12 form-group">
            <button type="submit" name="register" class="primary-btn">Register</button>
          </div>
        </form>
    </div>
</div>
</div>
</div>
</section>

<?php
  require 'unit/footer.php';
  require 'unit/base.php';
?>