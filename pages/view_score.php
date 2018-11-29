<?php
  include 'includes/header.php';
  include '../model/manageclass.php';  
  include'../model/manageexammarks.php';
  include'../model/manageexam.php';


  $exam = new Exam; 
  $exam_mark = new Exam_marks; //call class name
  
  if((isset($_GET['id'])) && (isset($_GET['exam_id']))) {
    $room_id = $_GET['id'];
    $exam_id = $_GET['exam_id'];
    $getStudentMarks = getExamMarkID($room_id,$exam_id);
    $class = getOneClass($room_id);
    $exam = getOneExam($exam_id);
    $exams = getAllExams();
    if($getStudentMarks === null) {
     header("Location:404.php");
    } else {
      $classes = getAllClasses();
      $level = getOneLevel($class->getLevelID());
      $list = getAllStudentInClass($room_id);
    }
  } else {
    header("Location:404.php");
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    header('Location: edit_score.php?id='.$room_id.'&exam_id='.$exam_id);
  } 
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Student List
            <small>Total student in this class is <b><?php echo count($getStudentMarks) ?></b></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_school.php"> School Management</a></li>
            <li><a href="class_list.php"> Classroom List</a></li>
            <li class="active">Student List</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Click on student's name to edit score  &nbsp;
                    <strong><?php //echo $class->getClassName(); ?></strong>
                  </h3>
                  <span class="pull-right"><i class="fa fa-square" style="color:#f2dede" aria-hidden="true"></i> Leave Student</span>
                  <span class="pull-right"><i class="fa fa-square" style="color:#dff0d8" aria-hidden="true"></i> Move Class</span>
                </div><!-- /.box-header -->
                <span class="input-group pull-right">
                       <a role="button" href="export_class.php?room_id=<?php echo $room_id; ?>&exam_id=<?php echo $exam_id ?>" class="btn btn-success btn-icon"
                             data-toggle="tooltip" title="Export this table to excel." id="export-pdf">
                            <i class="fa fa-file-excel-o"></i>
                          </a>  
                        </span>
                <div class="box-body">
                    <div class="row information form-information">
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                          <i class="fa fa-user">&nbsp;Teacher</i>
                          <i class="i-split">:</i>
                        </label>
                        <span class="col-md-4 col-sm-3 col-xs-8 control-span" id="info-teacher">
                          <?php echo $class->getTeacherName(); ?>
                        </span>
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                          <i class="fa fa-graduation-cap">&nbsp;Level</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-4 col-sm-3 col-xs-8 control-span" id="info-level">
                          <?php echo $level != null ? $level->getLevelName() : '<i class="text-red">Unknown</i>'; ?>
                        </span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                        <div class="form-group">
                          <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                            <i class="fa fa-home">&nbsp;Room</i>
                            <i class="i-split">:</i>
                          </label>
                            
                            
                          <div class="col-md-4 col-sm-3 col-xs-8 control-span">
                              <?php echo $class->getClassName() ?>
                          </div> 
                          <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                            <i class="fa fa-clock-o">&nbsp;Exam </i>&nbsp;
                            <i class="i-split">:</i>
                          </label> 
                             <input type="hidden" name="exam_id" value="<?php echo $exams[0]['exam_id'] ?>"/>
                          <span class="col-md-3 col-sm-3 col-xs-8 control-span" id="exam" >
                           
                              <?php 
                              echo $exam->getexam_name();
                                ?>
                          </span>
                        </div> 
                      </div>
                    </div>    
                <form method="POST" id="examForm">
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="info">
                          <th rowspan="2">No.</th>
                          <th rowspan="2">Name</th>
                          <th colspan="2">Absence</th>
                          <th colspan="7">Score</th>
                          <th rowspan="2">Total</th>
                          <th rowspan="2">Result</th>
                          <th rowspan="2">Rank</th>
                        </tr>
                        <tr>
                          <th rowspan="2" class="danger">A</th>
                          <th rowspan="2" class="success">P</th>
                          <th rowspan="2" class="warning">Att 10%</th>
                          <th rowspan="2" class="warning">Home 5%</th>
                          <th rowspan="2" class="warning">Class 5%</th>
                          <th rowspan="2" class="warning">Q1, 10%</th>
                          <th rowspan="2" class="warning">Q2, 10%</th>
                          <th rowspan="2" class="warning">Q3, 10%</th>
                          <th rowspan="2" class="warning">Final, 50%</th>
                        </tr> 
                      </thead>

                      <tbody id="data-list">
                        <?php 
                          $row_num = 1;
                          foreach($getStudentMarks as $key=>$value) {
                            $rank_num = $row_num;
                            if($key>0){
                                $rank = ($getStudentMarks[$key-1]['total'] == $getStudentMarks[$key]['total'] ? $rank:$rank_num);
                            }else{
                                $rank = 1;
                            }
                            $att = 10-($getStudentMarks[$key]['absence_a']+$getStudentMarks[$key]['absence_p']/2);
                            $att < 0 ? $att = 0 : $att;
                            $result = ($getStudentMarks[$key]['total']<50 ? 'Fail' : 'Pass');
                            $student = getOneStudent($getStudentMarks[$key]['student_id']);
                            $stay = 'false';
                            for($i=0;$i<COUNT($list);$i++){
                              if($list[$i]['student_id'] == $student->getStudentID()){
                                $stay = 'true';
                              }
                            }
                           if($stay == 'true' ){
                              if($student->getLeaveFlag() == 1){
                                $month = date('m',strtotime(str_replace('-','/', $student->getLeaveDate())));
                                $year = date('Y',strtotime(str_replace('-','/', $student->getLeaveDate())));
                                if(($month == $exam->getExam_month()) AND ($year == $exam->getExam_year())){
                                  $leave = 'danger';
                                }else{
                                  $leave = '';
                                }
                              }else{
                                  $leave = '';
                                }
                            }else{
                              $leave = 'success';
                            }
                        ?>
                        <tr class="text-nowrap <?php echo $leave ?>">
                          <td><?php echo $row_num; ?></td>
                          <td><?php echo "<a href='edit_single_stud_score.php?id=" .$getStudentMarks[$key]['mark_id']. "'>".$student->getStudentName()."</a>";?></td>
                          <?php 
                                echo "<td>".$getStudentMarks[$key]['absence_a']."</td>";
                                echo "<td>".$getStudentMarks[$key]['absence_p']."</td>";
                                echo "<td>".$att."</td>";
                                echo "<td>".$getStudentMarks[$key]['home_work']."</td>";
                                echo "<td>".$getStudentMarks[$key]['class_work']."</td>";
                                echo "<td>".$getStudentMarks[$key]['quiz1']."</td>";
                                echo "<td>".$getStudentMarks[$key]['quiz2']."</td>";
                                echo "<td>".$getStudentMarks[$key]['quiz3']."</td>";
                                echo "<td>".$getStudentMarks[$key]['final_exam']."</td>";
                                echo "<td>".$getStudentMarks[$key]['total']."</td>";
                                echo "<td>".$result."</td>";
                                echo "<td>".$rank."</td>";
                          ?>
                        </tr>
                        <?php $row_num++; } ?> 
                      </tbody>
                    </table>
                  </div>
                  <div class="box-footer pull-right">
                      <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2"> 
                        <button type="submit" class="btn btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update</button>
                      </div>
                    </div>  
                </form> 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php
    include 'includes/footer.php';
?>

  <!-- bootstrap chosen -->
  <script src="../js/chosen.jquery.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){     

      $('.form-information').on('change', '#class_id', function() {
        var id = $(this).val();
        $.ajax({
          url: 'view_score.php?id=' + id,
          type: 'get',
          success: function(data) {
            var table = $(data).find('.table-responsive').html();
            var information = $(data).find('.form-information').html();
            var teacher = $(information).find('#info-teacher').html();
            var level = $(information).find('#info-level').html();
            var time = $(information).find('#info-time').html(); 

            
            $('.table-responsive').html(table);
            $('#info-teacher').html(teacher);
            $('#info-level').html(level);
            $('#info-time').html(time);


            $('.chosen-select').chosen();
            $('#student-list').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false
            });
          }
          // ,
          // error: function(xhr, desc, err) {
          //   console.log(xhr);
          //   console.log("Details: " + desc + "\nError:" + err);
          // }
        });       
      });

    });


    $(function () {
      $('#student-list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });

      //bootstrap-chosen
      $('.chosen-select').chosen();
      $('.chosen-select-deselect').chosen({ allow_single_deselect: true });      
    });

  </script>

