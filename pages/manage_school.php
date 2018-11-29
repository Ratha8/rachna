<?php
  include 'includes/header.php';
  include '../model/manageclass.php';   
  include '../model/managecourse.php';   
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  $classes_list = getAllClasses();
  $level_list = getAllLevels();
  $course_list = getAllcourses();
  $levels = count($level_list);
  $classes = count($classes_list);
  $courses = count($course_list);
  $total = count(getAllStudents());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            School Management
            <small>List of all tasks</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">School Management</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-light-blue class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Classroom</h3>
                  <p>
                    List all available classroom
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-university"></i>
                </div>
                <a href="class_list.php" class="small-box-footer">
                  View classroom list 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
             
                <a href="register_class.php" class="small-box-footer">
                  Add new classroom
                  <i class="fa fa-plus"></i>
                </a>               
                <div class="info-box bg-light-blue pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Classes</span>
                    <span class="info-box-number"><?php echo $classes; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                      Total Student &nbsp;
                      <span class="label bg-light-blue-active">
                        <strong><?php echo $total; ?></strong>                       
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-teal class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Level</h3>
                  <p>
                    List all available level in school
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-bar-chart"></i>
                </div>
                <a href="level_list.php" class="small-box-footer">
                  View level list 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                
                <a href="register_level.php" class="small-box-footer">
                  Add new level
                  <i class="fa fa-plus"></i>
                </a>
                  
                  
                <div class="info-box bg-teal pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Levels</span>
                    <span class="info-box-number"><?php echo $levels; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                      Total Student &nbsp;
                      <span class="label bg-teal-active">
                        <strong><?php echo $total; ?></strong>                       
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->            

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Course</h3>
                  <p>
                    List all available course
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-clock-o"></i>
                </div>
                <a href="course_list.php" class="small-box-footer">
                  View course list 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <a href="register_course.php" class="small-box-footer">
                  Add new course
                  <i class="fa fa-plus"></i>
                </a>              
                <div class="info-box bg-aqua pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Courses</span>
                    <span class="info-box-number"><?php echo $courses; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                      Total Student &nbsp;
                      <span class="label bg-light-blue-active">
                        <strong><?php echo $total; ?></strong>                       
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