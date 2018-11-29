<?php
  include 'includes/header.php';
  include '../model/manageclass.php';   
  include '../model/managecourse.php';  
  
  if($user_session->getRole()== 'Admin'){
      $classes_list = getAllClasses();
  }  else {
      $classes_list = getAllClassesReciep($user_session->getUserID());
}
  $classes = count($classes_list);
  if($user_session->getRole() =='Admin'){
      $total = count(getAllStudents()); 
  }
 else {
      $total = count(getAllStudentUserRole($user_session->getUserID())); 
}
  
  if ($user_session->getRole() == 'Admin'){
      $new_stu = countNewStudent(date('Y-m-d'));
  }
 else {
     $new_stu = countNewStudentUserRole(date('Y-m-d'),$user_session->getUserID()); 
}
  if ($user_session->getRole() == 'Admin'){
       $leave_stu = countLeaveStudent(date('Y-m-d'));
  }
 else {
      $leave_stu = countLeaveStudentUserRole(date('Y-m-d'),$user_session->getUserID()); 
}
  // $old_stu = countOldStudent(date('Y-m-d'));
  // $total_leave = countTotalLeaveStudent(date('Y-m-d'));  
  $notifi = countUnpaidNotification($user_session->getUserID());
  $new_percent = $total > 0 ? number_format(($new_stu * 100)/$total, 2) : number_format(0, 2);
  $leave_percent = $total > 0 ? number_format(($leave_stu * 100)/$total, 2) : number_format(0, 2);
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Student Management
            <small>List of all tasks</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Student Management</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Register</h3>
                  <p>
                    Register new student
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-user-plus"></i>
                </div>
                <a href="register_student.php" class="small-box-footer">
                  Add new student
                  <i class="fa fa-plus"></i>
                </a>                
                <div class="info-box bg-green pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Students</span>
                    <span class="info-box-number"><?php echo $total; ?></span>
                    <div class="progress">
                      <div class="progress-bar bg-lime-active" style="width: <?php echo $new_percent; ?>%"></div>
                      <div class="progress-bar bg-red-active" style="width: <?php echo $leave_percent; ?>%"></div>
                      <div class="progress-bar" style="width: <?php echo 100 - ($new_percent + $leave_percent); ?>%"></div>
                    </div>
                    <span class="progress-description">
                      New &nbsp;
                      <span class="label bg-green-active">
                        <strong><?php echo $new_stu; ?></strong>                       
                      </span>
                      &nbsp;Leave &nbsp;
                      <span class="label bg-red-active">
                        <strong><?php echo $leave_stu; ?></strong>                       
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
                    List student information
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-list-alt"></i>
                </div>
                <a href="student_list.php" class="hide"></a>
                <a href="room_list.php" class="small-box-footer">
                  List by Class 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <a href="month_list.php" class="small-box-footer">
                  List by Month 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <a href="student_list.php" class="small-box-footer">
                  List All Student 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <a href="paid_list.php" class="small-box-footer">
                  List Paid Student 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>                                                
                <div class="info-box bg-blue pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Classes</span>
                    <span class="info-box-number"><?php echo $classes; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                      Total Student &nbsp;
                      <span class="label bg-blue-active">
                        <strong><?php echo $total; ?></strong>                       
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->            

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Contact</h3>
                  <p>
                    List all student contact information
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-phone-square"></i>
                </div>
                <a href="contact_student.php" class="small-box-footer">
                  View contact information list 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>               
                <div class="info-box bg-red pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Students</span>
                    <span class="info-box-number"><?php echo $total; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                      Upcoming Pay&nbsp;
                      <span class="label bg-red-active">
                        <strong><?php echo $notifi; ?></strong>                       
                      </span>
                    </span>
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