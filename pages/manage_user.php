<?php
  include 'includes/header.php';
  include '../model/manageclass.php';   
  include '../model/managecourse.php';   

  if($user_session->getRole() !== 'Admin') {
    header("Location:403.php");
  }

  $user_list = getAllUsers();
  $users = count($user_list);
  
  $rec_list = getAllReceipt();
  $recept = count($rec_list);
  
  $teacher_list = getAllTeachers();
  $teacher  = count($teacher_list);
  
  $receptionist = 0;
  $admin = 0;
  foreach ($user_list as $key => $value) {
    if($user_list[$key]['role'] == 'Receptionist') {
      $receptionist ++;
    } elseif($user_list[$key]['role'] == 'Admin') {
      $admin ++;
    }
  }
  $classes_list = getAllClasses();
  $classes = count($classes_list);
  $total = count(getAllStudents());
  $new_stu = countNewStudent(date('Y-m-d'));
  $old_stu = countOldStudent(date('Y-m-d'));
  $leave_stu = countLeaveStudent(date('Y-m-d'));
  $total_leave = countTotalLeaveStudent(date('Y-m-d'));  
  $notifi = countUnpaidNotification($user_session->getUserID());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            User Management
            <small>List of all tasks</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Management</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Register</h3>
                  <p>
                    Register new user
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="register_user.php" class="small-box-footer">
                  Add new user
                  <i class="fa fa-plus"></i>
                </a>                
                <div class="info-box bg-red pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number"><?php echo $users; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 50%"></div>
                      <div class="progress-bar" style="width: 50%"></div>
                    </div>
                    <span class="progress-description">
                      Admin &nbsp;
                      <span class="label bg-red-active">
                        <strong><?php echo $admin; ?></strong>                       
                      </span>                      
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">List</h3>
                  <p>
                    List user information
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-list-alt"></i>
                </div>
                <a href="user_list.php" class="small-box-footer">
                  List all users 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>                                              
                <div class="info-box bg-blue pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number"><?php echo $users; ?></span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->                                                        
            
            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">List</h3>
                  <p>
                    List Receptionist information
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-list-alt"></i>
                </div>
                <a href="rec_list.php" class="small-box-footer">
                  List all Receptionist
                  <i class="fa fa-arrow-circle-right"></i>
                </a>                                              
                <div class="info-box bg-aqua pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Receptionist</span>
                    <span class="info-box-number"><?php echo $recept; ?></span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->
            
            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">List</h3>
                  <p>
                    List Teacher information
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-list-alt"></i>
                </div>
                  <a href="teacher_list.php" class="small-box-footer">
                  List all Teacher
                  <i class="fa fa-arrow-circle-right"></i>
                </a>                                              
                <div class="info-box bg-purple pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Teacher</span>
                    <span class="info-box-number"><?php echo $teacher; ?></span>
                   
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->
            
          </div><!-- /.row -->
        </section>
      </div>
<?php
    include 'includes/footer.php';
?>

  <script type="text/javascript">

    $(document).ready(function(){
      $(".content-wrapper").on("click", ".class-box", function(e) {
          if ($(e.target).is("a, button")) return;
          location.href = $(this).find("a").attr("href");
      });      
    });

  </script>