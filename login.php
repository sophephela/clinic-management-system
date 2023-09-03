<?php include('connect.php');include('pages/alerts.php'); ?>

<link rel="stylesheet" href="popup_style.css">
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<title>Login Panel</title>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="#">
<meta name="keywords" content="Admin , Responsive">


<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css">

<link rel="stylesheet" type="text/css" href="files/assets/icon/icofont/css/icofont.css">

<link rel="stylesheet" type="text/css" href="files/assets/css/style.css">
</head>
<body class="fix-menu">


<section class="login-block">

<div class="container-fluid">
<div class="row">
<div class="col-sm-12">



<div class="auth-box card" >
  <div class="text-center">
<image class="profile-img" src="uploadImage/Logo/hoslogo.jpg" style="width: 60%"></image>
</div> 
<div class="card-block" >
 
<div class="row m-b-20">
<div class="col-md-12">
<h5 class="text-center txt-primary">Sign In</h5>
</div>
</div>
  <form method="POST" action="pages/save_user_client.php">
    <div class="form-group form-primary">
      <select name="user" class="form-control" required="">
        <option value="" selected disabled>-- Select One --</option>
        <option value="admin">Admin</option>
        <option value="doctor">Doctor</option>
        <option value="pharmacy">Pharmacy</option>
          <option value="patient">Patient</option>
      </select>
      <span class="form-bar"></span>
    </div>
    <div class="form-group form-primary">
      <input type="email" name="email" class="form-control" required="" placeholder="Email">
      <span class="form-bar"></span>
    </div>
    <div class="form-group form-primary">
      <input type="password" name="password" class="form-control" required="" placeholder="Password">
      <span class="form-bar"></span>
    </div>
    <div class="row m-t-25 text-left">
      <div class="col-12">
        <div class="forgot-phone text-right f-right">
          <a href="forgot_password.php" class="text-right f-w-600"> Forgot Password?</a>
        </div>
      </div>
    </div>
    <div class="row m-t-30">
      <div class="col-md-12">
        <button type="submit" name="btn_login" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">LOGIN</button>
      </div>
    </div>
  </form>


</div>
</div>


</div>

</div>
</div>
</div>
</section>

<script type="text/javascript" src="files/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="files/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="files/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="files/bower_components/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<script type="text/javascript" src="files/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="files/bower_components/modernizr/js/css-scrollbars.js"></script>

<script type="text/javascript" src="files/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="files/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="files/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="files/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="files/assets/js/common-pages.js"></script>


</body>

<!-- for any PHP, Codeignitor or Laravel work contact me at mayuri.infospace@gmail.com -->
</html>
