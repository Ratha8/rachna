<?php
include '../model/manageuser.php';
include '../model/managestudent.php';
include '../model/managesettings.php';
include '../model/util.php';

session_start();
ob_start();
$getsetting = getSettings();
if(!$_SESSION['user']) {
   header("Location:../index.php");
} else {
  $user_session = unserialize($_SESSION["user"]);
}

mb_internal_encoding("UTF-8");
$notifi = countUnpaidNotification($user_session->getUserID());
$list_notifi = unpaidNotification($user_session->getUserID());

header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['lang'])) {
  $lang = $_GET['lang'];

  // register the session and set the cookie
  $_SESSION['lang'] = $lang;

  setcookie('lang', $lang, time() + (3600 * 24 * 30));
} else if(isSet($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
} else if(isSet($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
} else {
  $lang = 'en';
}

switch ($lang) {
  case 'en':
  $lang_file = 'en.php';
  break;

  case 'kh':
  $lang_file = 'kh.php';
  break;

  default:
  $lang_file = 'en.php';

}

include_once $lang_file;
?>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="/favicon.ico">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Bootstrap chosen -->
    <link rel="stylesheet" href="../css/bootstrap-chosen.css">
    <!-- Bootstrap datetime picker -->
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/all.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- intl tel input -->
    <link rel="stylesheet" href="../css/intlTelInput.css">    
    <!-- flag icon -->
    <link rel="stylesheet" href="../css/flag-icon.min.css">     
    <!-- data table -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">    
    <!-- formvalidation.io -->
    <link rel="stylesheet" href="../css/formValidation.min.css">     
    <!-- Theme style -->
    <link rel="stylesheet" href="../css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="../css/skins/_all-skins.min.css">
    <!-- Google Webfont -->
    <link href='https://fonts.googleapis.com/css?family=Moul' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Kantumruy:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Khmer' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <!-- Custom Style for page -->
    <link rel="stylesheet" href="../css/rachna.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
     <?php
    if ($user_session->getRole() == 'Teacher') {
        ?>
      <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>RIS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg khmer">
              <?php if(isset($getsetting[0]['school_name_kh']) || !empty($getsetting[0]['school_name_kh'])){
                  echo $getsetting[0]['school_name_kh'];
              }else{
                echo 'សាលាអន្តរជាតិរចនា';
              }
?>
          </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <?php 
                  if($user_session->getRole() == 'Admin') {
                ?>
                <li class="bg-red">
                  <a href="manage_user.php">
                    <i class="fa fa-users"></i>
                    <!-- <b>User Management</b> -->
                    <b><?php echo $lang['USER_MANAGEMENT']; ?></b>
                  </a>
                </li>
                <?php } ?>                                
              </ul>
            </div><!-- /.navbar-collapse -->

                              
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li>
                <a href="" id="kh">
                  <span class="flag-icon flag-icon-kh"></span>
                </a>
              </li>
              <li>
                <a href="" id="en">
                  <span class="flag-icon flag-icon-gb"></span>
                </a>
              </li>              
              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <?php 
                    if($notifi > 0) {
                      echo "<span class='label label-danger'>" . $notifi . "</span>";
                    }
                  ?>
                  <!-- <span class="label label-danger"><?php echo $notifi ?></span> -->
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $notifi ?> notifications</li>
                  <?php 
                    $count = 0;
                    echo "<li><ul class='menu'>";
                    foreach($list_notifi as $key => $value) {
                      $emergency = getOneEmergency($list_notifi[$key]['student_id']);
                      $count++; 
                      echo  "<li><a class='col-md-10 -no-padding' href='notification_alert.php?id=" . $list_notifi[$key]['student_id'] . 
                            "'><i class='fa fa-users text-aqua'></i> " . $list_notifi[$key]['student_name'] . 
                            "<br>Contact number:&nbsp;<span class='label label-danger'>" . $emergency->getContactNumber() . "</span>" .
                            "</a><a target='_blank' href='notification_print.php?id=" . $list_notifi[$key]['student_id'] . 
                            "' role='button' class='col-md-2 btn btn-a'><i class='fa fa-print'></i></a></li>";
                      if($count > 5) {
                        echo "</ul></li><li class='footer'><a href='upcoming_payment_notification.php'>View All</a></li>";
                        break; 
                      }
                    }
                    if($count <= 5) {
                      echo "</ul></li>";
                    }
                  ?>

                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 <?php if(isset($getsetting[0]['logo']) || !empty($getsetting[0]['logo'])){
                            echo '<img src="uploads/logo/'.$getsetting[0]['logo'].'" class="user-image" alt="User Image">';
                        }else{
                            echo '<img src="../images/logo.jpg" class="user-image" alt="User Image">';
                        }
                  ?>
                  <span class="hidden-xs"><?php echo $user_session->getUsername(); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <?php if(isset($getsetting[0]['logo']) || !empty($getsetting[0]['logo'])){
                            echo '<img src="uploads/logo/'.$getsetting[0]['logo'].'" class="img-circle" alt="User Image">';
                        }else{
                            echo '<img src="../images/logo.jpg" class="img-circle" alt="User Image">';
                        }
                  ?>
                    <p class="khmer">
                        <?php if(isset($getsetting[0]['school_name_kh']) || !empty($getsetting[0]['school_name_kh'])){
                            echo $getsetting[0]['school_name_kh'];
                        }else{
                            echo 'សាលាអន្តរជាតិរចនា';
                        }
                        ?>
                      <small><?php if(isset($getsetting[0]['school_name_en']) || !empty($getsetting[0]['school_name_en'])){
                            echo $getsetting[0]['school_name_en'];
                        }else{
                            echo 'RACHNA INTERNATIONAL SCHOOL';
                        }
                        ?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="../logout.php" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i>&nbsp;Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
         <?php
    } else {
        ?>
      <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>RIS</b></span>
          <!-- logo for regular state and mobile devices -->
         <span class="logo-lg khmer">
              <?php if(isset($getsetting[0]['school_name_kh']) || !empty($getsetting[0]['school_name_kh'])){
                  echo $getsetting[0]['school_name_kh'];
              }else{
                echo 'សាលាអន្តរជាតិរចនា';
              }
?>
              
          </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="bg-green">
                  <a href="manage_payment.php">
                    <i class="fa fa-credit-card"></i>
                    <!-- <b>Payment Management</b>  -->
                    <b><?php echo $lang['PAYMENT_MANAGEMENT']; ?></b> 
                    <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="bg-aqua">
                  <a href="manage_school.php">
                    <i class="fa fa-building-o"></i>
                    <!-- <b>School Management</b> -->
                    <b><?php echo $lang['SCHOOL_MANAGEMENT']; ?></b>
                  </a>
                </li>
                <li class="bg-blue">
                  <a href="manage_student.php">
                    <i class="fa fa-graduation-cap"></i>
                    <!-- <b>Student Management</b> -->
                    <b><?php echo $lang['STUDENT_MANAGEMENT']; ?></b>
                  </a>
                </li>
                <?php 
                  if($user_session->getRole() == 'Admin') {
                ?>
                <li class="bg-red">
                  <a href="manage_user.php">
                    <i class="fa fa-users"></i>
                    <!-- <b>User Management</b> -->
                    <b><?php echo $lang['USER_MANAGEMENT']; ?></b>
                  </a>
                </li>
                
                <?php } ?>                                
              </ul>
            </div><!-- /.navbar-collapse -->

                              
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li>
                <a href="" id="kh">
                  <span class="flag-icon flag-icon-kh"></span>
                </a>
              </li>
              <li>
                <a href="" id="en">
                  <span class="flag-icon flag-icon-gb"></span>
                </a>
              </li>              
              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <?php 
                    if($notifi > 0) {
                      echo "<span class='label label-danger'>" . $notifi . "</span>";
                    }
                  ?>
                  <!-- <span class="label label-danger"><?php echo $notifi ?></span> -->
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $notifi ?> notifications</li>
                  <?php 
                    $count = 0;
                    echo "<li><ul class='menu'>";
                    foreach($list_notifi as $key => $value) {
                      $emergency = getOneEmergency($list_notifi[$key]['student_id']);
                      $count++; 
                      echo  "<li><a class='col-md-10 -no-padding' href='notification_alert.php?id=" . $list_notifi[$key]['student_id'] . 
                            "'><i class='fa fa-users text-aqua'></i> " . $list_notifi[$key]['student_name'] . 
                            "<br>Contact number:&nbsp;<span class='label label-danger'>" . $emergency->getContactNumber() . "</span>" .
                            "</a><a target='_blank' href='notification_print.php?id=" . $list_notifi[$key]['student_id'] . 
                            "' role='button' class='col-md-2 btn btn-a'><i class='fa fa-print'></i></a></li>";
                      if($count > 5) {
                        echo "</ul></li><li class='footer'><a href='upcoming_payment_notification.php'>View All</a></li>";
                        break; 
                      }
                    }
                    if($count <= 5) {
                      echo "</ul></li>";
                    }
                  ?>

                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                   <?php if(isset($getsetting[0]['logo']) || !empty($getsetting[0]['logo'])){
                            echo '<img src="uploads/logo/'.$getsetting[0]['logo'].'" class="user-image" alt="User Image">';
                        }else{
                            echo '<img src="../images/logo.jpg" class="user-image" alt="User Image">';
                        }
                  ?>
                  
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $user_session->getUsername(); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <?php if(isset($getsetting[0]['logo']) || !empty($getsetting[0]['logo'])){
                            echo '<img src="uploads/logo/'.$getsetting[0]['logo'].'" class="img-circle" alt="User Image">';
                        }else{
                            echo '<img src="../images/logo.jpg" class="img-circle" alt="User Image">';
                        }
                  ?>
                    <p class="khmer">
                        <?php if(isset($getsetting[0]['school_name_kh']) || !empty($getsetting[0]['school_name_kh'])){
                            echo $getsetting[0]['school_name_kh'];
                        }else{
                            echo 'សាលាអន្តរជាតិរចនា';
                        }
                        ?>
                      <small><?php if(isset($getsetting[0]['school_name_en']) || !empty($getsetting[0]['school_name_en'])){
                            echo $getsetting[0]['school_name_en'];
                        }else{
                            echo 'RACHNA INTERNATIONAL SCHOOL';
                        }
                        ?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="../logout.php" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i>&nbsp;Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
    <?php } ?>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="image-logo">
              <!--<img src="../images/logo.jpg" class="img-circle pointer" alt="User Image" id="home-logo">-->
                <?php if(isset($getsetting[0]['logo']) || !empty($getsetting[0]['logo'])){
                            echo '<img src="uploads/logo/'.$getsetting[0]['logo'].'" class="img-circle pointer" alt="User Image" id="home-logo">';
                        }else{
                            echo '<img src="../images/logo.jpg" class="img-circle pointer" alt="User Image" id="home-logo">';
                        }
                  ?>
            </div>
          </div>
          <div class="sidebar-form-radio">
            <div class="input-group">
              <b><?php echo $lang['SEARCH'] ?>:</b>&nbsp;
              <label class="checkbox-inline no-padding-left">
                <input name="condition" type="radio" class="futurico" value="1" checked>&nbsp;Student
              </label>
              <label class="checkbox-inline no-padding-left">
                <input name="condition" type="radio" class="futurico" value="2">&nbsp;Contact
              </label>              
            </div>
          </div>

          <div class="sidebar-form">
            <div class="input-group">
              <input type="text" name="param" id="param" class="form-control" placeholder="Search Student...">
              <span class="input-group-btn">
                <button type="button" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>             
              </span>
            </div>
          </div>
          <!-- </form> -->
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          	<?php 
          		if($user_session->getRole() == 'Admin'){
          	?>
          		<!-- Admin Sidebar -->
          		<ul class="sidebar-menu">
          			<!-- Payment Management Menu -->
          			<li class="treeview">
		              <a href="#"><i class="fa fa-credit-card text-green"></i> <span><?php echo $lang['PAYMENT_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li>
		                  <a href="weekly_paid_list.php">
		                    <i class="fa fa-credit-card-alt text-green"></i>
		                    <span><?php echo $lang['PAID_STUDENT']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="unpaid_list.php">
		                    <i class="fa fa-credit-card-alt text-red"></i>
		                    <span><?php echo $lang['UNPAID_STUDENT']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="payment_invoice.php">
		                    <i class="fa fa-credit-card text-aqua"></i>
		                    <span><?php echo $lang['PAYMENT_INVOICE']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="invoice_history.php">
		                    <i class="fa fa-newspaper-o text-purple"></i>
		                    <span><?php echo $lang['INVOICE_HISTORY']; ?></span>
		                  </a>
		                </li>                
		                <li>
		                  <a href="student_chart.php">
		                    <i class="fa fa-pie-chart text-orange"></i>
		                    <span><?php echo $lang['PAYMENT_STATISTIC']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="paid_unpaid_class_list.php">
		                    <i class="fa fa-money" aria-hidden="true"></i>
		                    <span><?php echo $lang['PAYMENT_PIAD_UNPAID']; ?></span>
		                  </a>
		                </li>
		              </ul>
		            </li>
		            <!-- School Management Menu -->
		            <li class="treeview">
		              <a href="#"><i class="fa fa-building-o text-aqua"></i> <span><?php echo $lang['SCHOOL_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li>
		                
		                  <a href="register_class.php">
		                    <i class="fa fa-plus text-light-blue"></i>
		                    <span><?php echo $lang['ADD_CLASS']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="class_list.php">
		                    <i class="fa fa-list-ul"></i>
		                    <span><?php echo $lang['CLASS_LIST']; ?></span>
		                  </a>
		                </li>
		                <li>
		                
		                  <a href="register_level.php">
		                    <i class="fa fa-plus text-teal"></i>
		                    <span><?php echo $lang['ADD_LEVEL']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="level_list.php">
		                    <i class="fa fa-list-ul"></i>
		                    <span><?php echo $lang['LEVEL_LIST']; ?></span>
		                  </a>
		                </li>                
		                <li>
		                
		                  <a href="register_course.php">
		                    <i class="fa fa-plus text-aqua"></i>
		                    <span><?php echo $lang['ADD_COURSE']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="course_list.php">
		                    <i class="fa fa-list-ul"></i>
		                    <span><?php echo $lang['COURSE_LIST']; ?></span>
		                  </a>
		                </li>
		              </ul>
		            </li>   
		            <!-- Student Management Menu -->
		            <li class="treeview">
		            	<a href="#"><i class="fa fa-graduation-cap text-blue"></i> <span><?php echo $lang['STUDENT_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              	<ul class="treeview-menu">
		                	<li><a href="register_student.php"><i class="fa fa-user-plus text-green"></i> <span><?php echo $lang['ADD_STUDENT']; ?></span></a></li>
		                	<li class="treeview">
		                  		<a href="#" id="stu_list"><i class="fa fa-list-alt text-blue"></i> <span><?php echo $lang['STUDENT_LIST']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
			                  	<ul class="treeview-menu">
				                    <li><a href="room_list.php"><i class="fa fa-list text-light-blue"></i> <span><?php echo $lang['BY_CLASS']; ?></span></a></li>
				                    <li><a href="month_list.php"><i class="fa fa-list text-aqua"></i> <span><?php echo $lang['BY_MONTH']; ?></span></a></li>
				                    <li><a href="student_list.php"><i class="fa fa-list text-teal"></i> <span><?php echo $lang['BY_STUDENT']; ?></span></a></li>
				                    <li><a href="paid_list.php"><i class="fa fa-list text-olive"></i> <span><?php echo $lang['BY_PAID']; ?></span></a></li>
			                  	</ul>
			                </li>
                      <li class="treeview">
                          <a href="#" id="stu_list"><i class="fa fa fa-calendar"></i> <span><?php echo $lang['STUDENT_ATTENDANCE']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <li><a href="att_view_multiple.php"><i class="fa fa-list text-light-blue"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_VIEW']; ?></span></a></li>
                            <li><a href="att_register_multiple.php"><i class="fa fa-list text-aqua"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_ALL']; ?></span></a></li>
                            <li><a href="att_class_list.php"><i class="fa fa-list text-teal"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_CLASS']; ?></span></a></li>
                          </ul>
                      </li>
			                <li><a href="contact_student.php"><i class="fa fa-phone-square text-red"></i> <span><?php echo $lang['CONTACT']; ?></span></a></li>
			                <li><a href="Student_class.php"><i class="fa fa-pencil-square-o text-light-blue"></i> <span><?php echo $lang['CHANGE_CLASS']; ?></span></a></li>
		              	</ul>
		            </li>
		            <!-- Score Management Menu -->
		            <li class="treeview">
		              <a href="#"><i class="fa fa-pencil-square-o text-yellow"></i> <span><?php echo $lang['SCORE_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li><a href="room_add_score.php"><i class="fa fa-plus-circle  text-Purple"></i> <span><?php echo $lang['ADD_SCORE']; ?></span></a></li>
		                
		              </ul>
		            </li>
		            <!-- Exam Management Menu -->
		            <li class="treeview">
		              <a href="#"><i class="fa fa-calendar text-fuchsia"></i> <span><?php echo $lang['EXAM_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li><a href="create_exam.php"><i class="fa fa-asterisk text-teal"></i> <span><?php echo $lang['CREATE_EXAM']; ?></span></a></li>
		                <li><a href="view_exam_list.php"><i class="fa fa-list text-pink"></i> <span><?php echo $lang['VIEW_EXAM']; ?></span></a></li>
		              </ul>
		            </li>
		            <!-- Student Rank Management Menu -->
		            <li class="treeview">
		                <a href="#"><i class="fa fa-trophy text-Olive"></i> <span><?php echo $lang['STUDENT_RANK']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li><a href="create_rank.php"><i class="fa fa-plus-circle text-Purple"></i> <span><?php echo $lang['CREATE_RANK']; ?></span></a></li>
		                <li><a href="view_rank_records.php"><i class="fa fa-eye text-green"></i> <span><?php echo $lang['VIEW_RANK_RECORD']; ?></span></a></li>
		                <li><a href="view_rank_records_level.php"><i class="fa fa-eye text-blue"></i> <span><?php echo $lang['VIEW_RANK_LEVEL']; ?></span></a></li>
		              </ul>
		            </li>
                <!-- Student Certificate -->
                <li class="treeview">
                    <a href="cert_class_list.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span><?php echo $lang['STUDENT_CERTIFICATE']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                </li>
		            <!-- User Management Menu -->
		            <li class="treeview">
		              <a href="#"><i class="fa fa-users text-red"></i> <span><?php echo $lang['USER_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li><a href="register_user.php"><i class="fa fa-user-plus text-red"></i> <span><?php echo $lang['ADD_USER']; ?></span></a></li>
		                <li><a href="user_list.php"><i class="fa fa-list-alt text-blue"></i> <span><?php echo $lang['USER_LIST']; ?></span></a></li>
		                <li><a href="teacher_list.php"><i class="fa fa-list-alt text-blue"></i> <span><?php echo $lang['TEACHER_LIST']; ?></span></a></li>
		                <li><a href="rec_list.php"><i class="fa fa-list-alt text-blue"></i> <span><?php echo $lang['REC_LIST']; ?></span></a></li>
		              </ul>
		            </li>
		            <!-- Setting Management Menu -->
		            <li class="treeview">
		             	<a href="settings.php"><i class="fa fa-cogs"></i> 
		              		<span><?php echo $lang['SETTING_MANAGEMENT']; ?></span> 
		              		<i class="fa fa-angle-left pull-right"></i>
		             	</a>
		            </li>
          		</ul>
          		<!-- End Admin Sidebar -->
          	<?php
          		}else if($user_session->getRole() == 'Receptionist'){
          	?>
          		<!-- Receptionist Sidebar -->
          		<ul class="sidebar-menu">
          			<!-- Payment Management Menu -->
          			<li class="treeview">
		              <a href="#"><i class="fa fa-credit-card text-green"></i> <span><?php echo $lang['PAYMENT_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li>
		                  <a href="weekly_paid_list.php">
		                    <i class="fa fa-credit-card-alt text-green"></i>
		                    <span><?php echo $lang['PAID_STUDENT']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="unpaid_list.php">
		                    <i class="fa fa-credit-card-alt text-red"></i>
		                    <span><?php echo $lang['UNPAID_STUDENT']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="payment_invoice.php">
		                    <i class="fa fa-credit-card text-aqua"></i>
		                    <span><?php echo $lang['PAYMENT_INVOICE']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="invoice_history.php">
		                    <i class="fa fa-newspaper-o text-purple"></i>
		                    <span><?php echo $lang['INVOICE_HISTORY']; ?></span>
		                  </a>
		                </li>                
		                <li>
		                  <a href="student_chart.php">
		                    <i class="fa fa-pie-chart text-orange"></i>
		                    <span><?php echo $lang['PAYMENT_STATISTIC']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="paid_unpaid_class_list.php">
		                    <i class="fa fa-money" aria-hidden="true"></i>
		                    <span><?php echo $lang['PAYMENT_PIAD_UNPAID']; ?></span>
		                  </a>
		                </li>
		              </ul>
		            </li>
		            <!-- School Management Menu -->
		            <li class="treeview">
		              <a href="#"><i class="fa fa-building-o text-aqua"></i> <span><?php echo $lang['SCHOOL_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li>
		                
		                  <a href="register_class.php">
		                    <i class="fa fa-plus text-light-blue"></i>
		                    <span><?php echo $lang['ADD_CLASS']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="class_list.php">
		                    <i class="fa fa-list-ul"></i>
		                    <span><?php echo $lang['CLASS_LIST']; ?></span>
		                  </a>
		                </li>
		                <li>
		                
		                  <a href="register_level.php">
		                    <i class="fa fa-plus text-teal"></i>
		                    <span><?php echo $lang['ADD_LEVEL']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="level_list.php">
		                    <i class="fa fa-list-ul"></i>
		                    <span><?php echo $lang['LEVEL_LIST']; ?></span>
		                  </a>
		                </li>                
		                <li>
		                
		                  <a href="register_course.php">
		                    <i class="fa fa-plus text-aqua"></i>
		                    <span><?php echo $lang['ADD_COURSE']; ?></span>
		                  </a>
		                </li>
		                <li>
		                  <a href="course_list.php">
		                    <i class="fa fa-list-ul"></i>
		                    <span><?php echo $lang['COURSE_LIST']; ?></span>
		                  </a>
		                </li>
		              </ul>
		            </li>
		            <!-- Student Management Menu -->
		            <li class="treeview">
		            	<a href="#"><i class="fa fa-graduation-cap text-blue"></i> <span><?php echo $lang['STUDENT_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              	<ul class="treeview-menu">
		                	<li><a href="register_student.php"><i class="fa fa-user-plus text-green"></i> <span><?php echo $lang['ADD_STUDENT']; ?></span></a></li>
		                	<li class="treeview">
		                  		<a href="#" id="stu_list"><i class="fa fa-list-alt text-blue"></i> <span><?php echo $lang['STUDENT_LIST']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
			                  	<ul class="treeview-menu">
				                    <li><a href="room_list.php"><i class="fa fa-list text-light-blue"></i> <span><?php echo $lang['BY_CLASS']; ?></span></a></li>
				                    <li><a href="month_list.php"><i class="fa fa-list text-aqua"></i> <span><?php echo $lang['BY_MONTH']; ?></span></a></li>
				                    <li><a href="student_list.php"><i class="fa fa-list text-teal"></i> <span><?php echo $lang['BY_STUDENT']; ?></span></a></li>
				                    <li><a href="paid_list.php"><i class="fa fa-list text-olive"></i> <span><?php echo $lang['BY_PAID']; ?></span></a></li>
			                  	</ul>
			                </li>
                      <li class="treeview">
                          <a href="#" id="stu_list"><i class="fa fa fa-calendar"></i> <span><?php echo $lang['STUDENT_ATTENDANCE']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <li><a href="att_view_multiple.php"><i class="fa fa-list text-light-blue"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_VIEW']; ?></span></a></li>
                            <li><a href="att_register_multiple.php"><i class="fa fa-list text-aqua"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_ALL']; ?></span></a></li>
                            <li><a href="att_class_list.php"><i class="fa fa-list text-teal"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_CLASS']; ?></span></a></li>
                          </ul>
                      </li>
			                <li><a href="contact_student.php"><i class="fa fa-phone-square text-red"></i> <span><?php echo $lang['CONTACT']; ?></span></a></li>
		              	</ul>
		            </li>
		            <!-- Student Rank Management Menu -->
		            <li class="treeview">
		                <a href="#"><i class="fa fa-trophy text-Olive"></i> <span><?php echo $lang['STUDENT_RANK']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
			            <ul class="treeview-menu">
			            	<li><a href="view_rank_records.php"><i class="fa fa-eye text-green"></i> <span><?php echo $lang['VIEW_RANK_RECORD']; ?></span></a></li>
			                <li><a href="view_rank_records_level.php"><i class="fa fa-eye text-blue"></i> <span><?php echo $lang['VIEW_RANK_LEVEL']; ?></span></a></li>
			             </ul>
		            </li>
                <!-- Student Certificate -->
                <li class="treeview">
                    <a href="cert_class_list.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span><?php echo $lang['STUDENT_CERTIFICATE']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                </li>
          		</ul>
          		<!-- End Admin Sidebar -->
          	<?php
          		}else if($user_session->getRole() == 'Teacher'){
          	?>
          		<!-- Teacher Sidebar -->
          		<ul class="sidebar-menu">
          			<!-- Student Management Menu -->
		            <li class="treeview">
		            	<a href="#"><i class="fa fa-graduation-cap text-blue"></i> <span><?php echo $lang['STUDENT_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              	<ul class="treeview-menu">
		                	<li class="treeview">
		                  		<a href="#" id="stu_list"><i class="fa fa-list-alt text-blue"></i> <span><?php echo $lang['STUDENT_LIST']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
			                  	<ul class="treeview-menu">
				                    <li><a href="room_list.php"><i class="fa fa-list text-light-blue"></i> <span><?php echo $lang['BY_CLASS']; ?></span></a></li>
				                    <li><a href="month_list.php"><i class="fa fa-list text-aqua"></i> <span><?php echo $lang['BY_MONTH']; ?></span></a></li>
				                    <li><a href="student_list.php"><i class="fa fa-list text-teal"></i> <span><?php echo $lang['BY_STUDENT']; ?></span></a></li>
				                    <li><a href="paid_list.php"><i class="fa fa-list text-olive"></i> <span><?php echo $lang['BY_PAID']; ?></span></a></li>
			                  	</ul>
			                </li>
                      <li class="treeview">
                          <a href="#" id="stu_list"><i class="fa fa fa-calendar"></i> <span><?php echo $lang['STUDENT_ATTENDANCE']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <li><a href="att_view_multiple.php"><i class="fa fa-list text-light-blue"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_VIEW']; ?></span></a></li>
                            <li><a href="att_register_multiple.php"><i class="fa fa-list text-aqua"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_ALL']; ?></span></a></li>
                            <li><a href="att_class_list.php"><i class="fa fa-list text-teal"></i> <span><?php echo $lang['STUDENT_ATTENDANCE_CLASS']; ?></span></a></li>
                          </ul>
                      </li>
			                <li><a href="contact_student.php"><i class="fa fa-phone-square text-red"></i> <span><?php echo $lang['CONTACT']; ?></span></a></li>
		              	</ul>
		            </li>
		            <!-- Score Management Menu -->
		            <li class="treeview">
		              <a href="#"><i class="fa fa-pencil-square-o text-yellow"></i> <span><?php echo $lang['SCORE_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li><a href="room_add_score.php"><i class="fa fa-plus-circle  text-Purple"></i> <span><?php echo $lang['ADD_SCORE']; ?></span></a></li>
		                
		              </ul>
		            </li>
		            <!-- Exam Management Menu -->
		            <li class="treeview">
		              <a href="#"><i class="fa fa-calendar text-fuchsia"></i> <span><?php echo $lang['EXAM_MANAGEMENT']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li><a href="view_exam_list.php"><i class="fa fa-list text-pink"></i> <span><?php echo $lang['VIEW_EXAM']; ?></span></a></li>
		              </ul>
		            </li>
		            <!-- Student Rank Management Menu -->
		            <li class="treeview">
		                <a href="#"><i class="fa fa-trophy text-Olive"></i> <span><?php echo $lang['STUDENT_RANK']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
		              <ul class="treeview-menu">
		                <li><a href="view_rank_records.php"><i class="fa fa-eye text-green"></i> <span><?php echo $lang['VIEW_RANK_RECORD']; ?></span></a></li>
		                <li><a href="view_rank_records_level.php"><i class="fa fa-eye text-blue"></i> <span><?php echo $lang['VIEW_RANK_LEVEL']; ?></span></a></li>
		              </ul>
		            </li>
                <!-- Student Certificate -->
                <li class="treeview">
                    <a href="cert_class_list.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span><?php echo $lang['STUDENT_CERTIFICATE']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                </li>
          		</ul>
          		<!-- End Teacher Sidebar -->
          	<?php	
          		}
          	?>
          	<!-- End Sidebar Menu -->
             
          <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>