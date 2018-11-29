<?php
  include 'includes/header.php';
  include '../model/manageclass.php';    
  include '../model/manageexam.php';  

    $exam = new Exam();
    $list = getAllClasses();
    $exam = getLastExam();
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
              View Score
            <small>Choose classroom to view score</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="manage_Score.php"> View Score Management</a></li>
            <li class="active">Classroom List</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <?php 
              foreach ($list as $key => $value) {
                $id = $list[$key]['class_id'];
                $clazz = getAllStudentInClass($id);
                $leave = 0;
                foreach ($clazz as $keys => $value) {
                  if($clazz[$keys]['leave_flag'] == 1) {
                    $leave ++;
                  }
                }

                $leave_percent = count($clazz) > 0 ? number_format(($leave * 100)/count($clazz), 2) : number_format(0, 2);
            ?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap"><?php echo $list[$key]['class_name']; ?></h3>
                  <p>
                    Home Room Teacher:&nbsp; 
                    <span class="label label-warning"><?php echo $list[$key]['teacher_name'] ?></span>
                  </p>
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-graduation-cap"></i>
                </div>
                  <a href="00_view_score.php?id=<?php echo $id; ?>&exam_id=<?php echo $exam[0]['exam_id']?>" class="small-box-footer">
                    
                  View Student in class 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <div class="info-box bg-blue pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Students</span>
                    <span class="info-box-number"><?php echo count($clazz); ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $leave_percent ?>%"></div>
                    </div>
                    <span class="progress-description">
                      leave &nbsp;
                      <?php echo $leave; ?>&nbsp;
                      <span class="label label-danger">
                        <strong><?php echo $leave_percent; ?></strong>
                        <i class="fa fa-percent"></i>                        
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->
            <?php } ?>
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