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
  
  $str_updated = 0;
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $user_session->getUserID();
    $count = COUNT($list);
    for($i=1; $i<=$count; $i++ ){
        
        $exam_mark->setMark_id($_POST['mark_id_'.$i]);
        $exam_mark->setAbsence_a($_POST['absence_a_'.$i]);
        $exam_mark->setAbsence_p($_POST['absence_p_'.$i]);
        $exam_mark->setHome_work($_POST['home_work_'.$i]);
        $exam_mark->setClass_work($_POST['class_work_'.$i]);
        $exam_mark->setQuiz1($_POST['quiz1_'.$i]);
        $exam_mark->setQuiz2($_POST['quiz2_'.$i]);
        $exam_mark->setQuiz3($_POST['quiz3_'.$i]);
        $exam_mark->setFinal_exam($_POST['final_exam_'.$i]);
        $exam_mark->setTotal($_POST['total_'.$i]);
        
        $mark_id = updateExam_marks($exam_mark);
    }
  header('Location: view_score.php?id='.$room_id.'&exam_id='.$exam_id);
  $str_updated = 1;
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
                  </h3>
                  <span class="pull-right"><i class="fa fa-square" style="color:#f2dede" aria-hidden="true"></i> Leave Student</span>
                  <span class="pull-right"><i class="fa fa-square" style="color:#dff0d8" aria-hidden="true"></i> Move Class</span>
                </div><!-- /.box-header -->
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
                          <span class="col-md-3 col-sm-3 col-xs-8 control-span" id="exam" >
                           <?php 
                              echo $exam->getexam_name();
                                //echo $exams[0]['exam_name']
                                        ?>
                          </span>
                        </div> 
                      </div>
                    </div>    
                    <!--<div class="alert alert-success text-center" id="alert">Successfully Updated!</div>-->
                    
                  <form method="POST">
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="info">
                          <th rowspan="2">No.</th>
                          <th rowspan="2">Name</th>
                          <!-- <th rowspan="2">Sex</th> -->
                          <th colspan="2">Absence</th>
                          <th colspan="7">Score</th>
                          <th rowspan="2">Total</th>
                          
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
                           
                            $att = 10-($getStudentMarks[$key]['absence_a']+$getStudentMarks[$key]['absence_p']/2);
                            $student = getOneStudent($getStudentMarks[$key]['student_id']);
                            $stay = 'false';
                            for($i=0;$i<COUNT($list);$i++){
                              if($list[$i]['student_id'] == $student->getStudentID()){
                                $stay = 'true';
                              }
                            }
                            $leave = ($stay == 'true') ? $student->getLeaveFlag() == 1 ? 'danger' : '' : 'success';
                        ?>

                        <tr class="text-nowrap <?php echo $leave ?>">
                            
                          <td><?php echo $row_num; ?></td>
                          <input name="mark_id_<?php echo $row_num ?>" type="hidden" value="<?php echo $getStudentMarks[$key]['mark_id']; ?>" onfocus="this.select();"  class="form-control" style="border: none;" readonly/>
                          <td><?php echo $student->getStudentName();?></td>
                          <!-- <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td> -->
                          <td><input name='absence_a_<?php echo $row_num ?>' type="text" onchange="totalScore(<?php echo $row_num ?>)" id="a_<?php echo $row_num ?>" value="<?php echo $getStudentMarks[$key]['absence_a'] ?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="2" class="form-control" style="border: none; padding:3px"/></td>
                          <td><input name='absence_p_<?php echo $row_num ?>' type="text" onchange="totalScore(<?php echo $row_num ?>)" id="p_<?php echo $row_num ?>" value="<?php echo $getStudentMarks[$key]['absence_p'] ?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="2" class="form-control" style="border: none;padding:3px"/></td>
                          <td><input type="text" id="att_<?php echo $row_num ?>" value="<?php echo $att ?>" class="form-control" style="border: none;" readonly /></td>
                          <td><input name="home_work_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="home_<?php echo $row_num ?>" value="<?php echo $getStudentMarks[$key]['home_work']?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;" /></td>
                          <td><input name="class_work_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="class_<?php echo $row_num ?>" value="<?php echo $getStudentMarks[$key]['class_work']?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                          <td><input name="quiz1_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q1_<?php echo $row_num ?>"    value="<?php echo $getStudentMarks[$key]['quiz1']?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                          <td><input name="quiz2_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q2_<?php echo $row_num ?>"    value="<?php echo $getStudentMarks[$key]['quiz2']?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                          <td><input name="quiz3_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q3_<?php echo $row_num ?>"    value="<?php echo $getStudentMarks[$key]['quiz3']?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                          <td><input name="final_exam_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="final_<?php echo $row_num ?>" value="<?php echo $getStudentMarks[$key]['final_exam']?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                          <td><input name="total_<?php echo $row_num ?>" value="<?php echo $getStudentMarks[$key]['total']?>" id="total_<?php echo $row_num ?>" class="form-control" style="border: none;" readonly/></td>

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

<script>
function totalScore(id) {
//    alert(id);
  var   A, P, ATT, HOME, CLASS, Q1, Q2, Q3, FINAL,result; 
  A = parseFloat($("#a_"+id).val());if(isNaN(A) || A < 1){ A=0; $("#a_"+id).val(0);}
  P = parseFloat($("#p_"+id).val());if(isNaN(P) || P < 1){P=0; $("#p_"+id).val(0);}
    ATT = 10-(A+(P/2));
    if (ATT<1 || isNaN(ATT)) {
          ATT = 0;
        }
    $("#att_"+id).val(ATT);
    HOME = parseFloat($('#home_'+id).val());
    CLASS = parseFloat($('#class_'+id).val());
    Q1 = parseFloat($('#q1_'+id).val());
    Q2 = parseFloat($('#q2_'+id).val());
    Q3 = parseFloat($('#q3_'+id).val());
    FINAL = parseFloat($('#final_'+id).val());
//validation
    if(isNaN(FINAL) || FINAL < 1){FINAL = 0; $("#final_"+id).val(0);}else if(FINAL > 50){FINAL = 50; $("#final_"+id).val(50);}
    if(isNaN(CLASS) || CLASS < 1){CLASS =0; $("#class_"+id).val(0);}else if(CLASS > 5){CLASS = 5; $("#class_"+id).val(5);}
    if(isNaN(HOME) || HOME < 1){HOME=0; $("#home_"+id).val(0);}else if(HOME > 5){HOME = 5; $("#home_"+id).val(5);}
    if(isNaN(Q1) || Q1 < 1){Q1=0; $("#q1_"+id).val(0);}else if(Q1 > 10){Q1 =10; $("#q1_"+id).val(10);}
    if(isNaN(Q2) || Q2 < 1){Q2=0; $("#q2_"+id).val(0);}else if(Q2 > 10){Q2 =10; $("#q2_"+id).val(10);}
    if(isNaN(Q3) || Q3 < 1){Q3=0; $("#q3_"+id).val(0);}else if(Q3 > 10){Q3 =10; $("#q3_"+id).val(10);}
    result = ATT+HOME+CLASS+Q1+Q2+Q3+FINAL; 
//    alert(result);
    if (result<1 || isNaN(result)) {
      result = 0;
      
    }
    $('#total_'+id).val(result);
//  document.getElementById("total_"+id).value = result;
}
</script>

<!-- INPUT ONLY NUMBER -->
<script>
function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 45 || charCode > 57 || charCode === 47)) {
      return false;
  }
  return true;
}
</script>




<!--<script>
    
    window.onload = function() {
        if(<?php //echo $str_updated?> == 0){
  document.getElementById('alert').style.display = 'none';}
  else{
      document.getElementById('alert').style.display = 'inline';}
};

</script>         -->
                         
                         