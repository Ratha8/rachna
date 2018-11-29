<?php

include 'model/manageuser.php';
session_start();
if(isset($_SESSION['user'])){
   header("Location:pages/index.php");
}

$err = "";
  if ($_SERVER["REQUEST_METHOD"]== "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $err = checkUserExistFrm($username, $password);
    if($err===''){
      header("Location:pages/index.php");
    }
  }
?>

<!DOCTYPE html>
<html id="login">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rachna International School | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="/favicon.ico">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <!-- Google Webfont -->
    <link href='https://fonts.googleapis.com/css?family=Moul' rel='stylesheet' type='text/css'>
    <!-- Custom Style for page -->
    <link rel="stylesheet" href="css/rachna.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <!-- <div class="login-logo-form">
        <a href="../../index2.html">
          <b>Rachna International School</b>
          <img src="images/logo.jpg">
        </a>
      </div> -->
      <!-- /.login-logo -->
      <div class="login-box-body">
        <div class="login-logo-form">
          <a href="../../index2.html">
            <!-- <b>Rachna International School</b> -->
            <img src="images/logo.jpg">
          </a>
        </div>        
        <p class="login-box-msg"><strong>Sign in to manage your system</strong></p>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          <div class="form-group has-feedback">
            <input name="username" type="text" class="form-control" placeholder="Username">
            <span class="fa fa-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password"type="password" class="form-control" placeholder="Password">
            <span class="fa fa-lock form-control-feedback"></span>
          </div>
          <span class="error"> <?php print_r($err)?></span>
          <div class="row">
            <!-- <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div> -->
            <div class="col-md-4 col-sm-4 col-xs-4">
              <button type="submit" class="btn bg-olive btn-block btn-flat btn-width"><i class="fa fa-sign-in"></i>&nbsp;Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="js/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
