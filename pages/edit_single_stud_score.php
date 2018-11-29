<?php
include 'includes/header.php';
  include '../model/manageclass.php';  
  include'../model/manageexammarks.php';
  include'../model/manageexam.php';

$exam = new Exam;
$exam_mark = new Exam_marks;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $getStudentMarks = getOneExamMark($id);

    if ($getStudentMarks === null) {
        header("Location:404.php");
    } else {
        $student = getOneStudent($getStudentMarks->getStudent_id());
        $class = getOneClass($getStudentMarks->getRoom_id());
        $exam = getOneExam($getStudentMarks->getExam_id());
        $level = getOneLevel($class->getLevelID());

        $moveExamID=$getStudentMarks->getExam_id();
        $moveClassID=$student->getClassID();
        $moveClassName = getOneClass($moveClassID);
        $moveStudentID = $student->getStudentID();
        $record = moveCheckMark($moveClassID,$moveExamID);
        $typeID = false; 
        if(!empty($record)){
            foreach ($record as $new) {
                if($new['student_id'] == $moveStudentID){
                    $typeID = true;
                }
            }
            if($typeID == true){
                $movetype = '#confirmMove2';
            }else{
                $movetype = '#confirmMove1';
            }
        }else{
            $movetype = '#confirmMove3';
        }
        
    }
} else {
    header("Location:404.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_mark->setMark_id($_POST['mark_id']);
    $exam_mark->setAbsence_a($_POST['absence_a']);
    $exam_mark->setAbsence_p($_POST['absence_p']);
    $exam_mark->setHome_work($_POST['home_work']);
    $exam_mark->setClass_work($_POST['class_work']);
    $exam_mark->setQuiz1($_POST['quiz1']);
    $exam_mark->setQuiz2($_POST['quiz2']);
    $exam_mark->setQuiz3($_POST['quiz3']);
    $exam_mark->setFinal_exam($_POST['final_exam']);
    $exam_mark->setTotal($_POST['total']);
    $action = $_POST['action'];
    $markID = $_POST['mark_id'];
    $userID = $user_session->getUserID();
    $getStudentMarks = getOneExamMark($markID);
    $student = getOneStudent($getStudentMarks->getStudent_id());
    $classID = $student->getClassID();
    $moveExamID=$getStudentMarks->getExam_id();
   if($action == 'move'){
        moveStudentMark($userID,$markID,$classID);
    }else{
        updateExam_marks($exam_mark);
        header('Location: edit_single_stud_score.php?id='.$_POST['mark_id']);
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Score
            <small>for student <?php echo $student->getStudentName(); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_student.php"> Student Management</a></li>
            <li><a href="student_list.php"> Student List</a></li>
            <li class="active">Student Detail information</li>
        </ol>
    </section>

    <!-- Main content -->
    

    <section class="content">
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST"><!-- form start -->
            <!-- Horizontal Form -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-info">
                        <div class="container-new">
                            <div class="box-header">
                                <h1 class="page-header">Student Information  
                                <span class="input-group pull-right">
                                <!--<i class="fa fa-file-text"></i>&nbsp;&nbsp;
                                 <a href="register_student_report.php?id=<?php echo $id ?>">Report</a> -->
                                </h1>  
                            </span>
                            </div>
                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="text-center" style="padding-top: 15px">
                                       
                                       <?php 
                                                if(!empty($student->getPhoto())){
                                                    $img_url = $student->getPhoto();
                                                }else{
                                                    $img_url = 'no-img.png';
                                                }
                                            ?>
                                    <img class='img-circle' src="uploads/<?php echo $img_url;?>" width="150px" height="150px" />
                                        <?php echo "<a href='student_detail.php?id=" .$student->getStudentID(). "'><h6>View Full Profile</h6></a>"; ?>

                          </div>
                                </div>
                                <!-- INFO pull-right -->
                                <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                                    <div class="box-body"> 
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Name :</label>
                                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">
                                                <?php echo $student->getStudentName(); ?> 
                                            </label>                               
                                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Sex :</label>
                                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">
                                                <?php echo $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'Female') : 'Male'; ?>
                                            </label>                                                    
                                        </div> 

                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Room :</label>
                                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                                <?php echo $class->getClassName() ?>

                                            </label>                               
                                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Exam :</label>
                                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">
                                                <?php echo $exam->getExam_name() ?>
                                            </label>                                                    
                                        </div>  
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Level :</label>
                                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">
                                                <?php
                                                echo $level != null ? $level->getLevelName() : '<i class="text-red">Information is missing! Please consider to update the information.</i>';
                                                ?>
                                            </label>                             
                                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Switch :</label>
                                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">
                                                <?php echo $student->getSwitchTime() == 1 ? 'Yes' : 'No'; ?>
                                            </label>                                                   
                                        </div>                         
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body" style="padding-top: 25px;">
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="table-responsive">
                                    <table id="student-list" class="table table-bordered table-hover">
                                        <thead class="center text-nowrap">
                                            <tr class="info">
                                                <th rowspan="2">Full Name</th>
                                                <th rowspan="2">Sex</th>
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
                                            $a = $getStudentMarks->getAbsence_a();
                                            $p = $getStudentMarks->getAbsence_p();
                                            $att = 10 - ($a + $p / 2);
                                            $att < 0 ? $att = 0 : $att;

                                            ?>

                                            <tr>
                                                <!-- LINK -->       <td><?php echo $student->getStudentName(); ?></td>
                                                <td><?php echo $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                                                
                                        <input type="hidden"  name="mark_id" value="<?php echo $getStudentMarks->getMark_id(); ?>"/>
                                        <td><input name="absence_a" type="text" onchange="totalScore()" id="a" value="<?php echo $getStudentMarks->getAbsence_a(); ?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" class="form-control" /></td>
                                        <td><input name="absence_p" type="text" onchange="totalScore()" id="p" value="<?php echo $getStudentMarks->getAbsence_p(); ?>" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" class="form-control" /></td>
                                        <td><input name="att" type="text" id="att" value="<?php echo $att ?>" class="form-control" style="border: none;" readonly="true"/></td>

                                        <td><input name="home_work" type="text" onchange="totalScore()" id="home"  onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $getStudentMarks->getHome_work(); ?>" class="form-control"  /></td>
                                        <td><input name="class_work" type="text" onchange="totalScore()" id="class" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $getStudentMarks->getClass_work(); ?>" class="form-control"  /></td>
                                        <td><input name="quiz1" type="text" onchange="totalScore()" id="q1"   onfocus="this.select();" onmouseup="return false;"  onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $getStudentMarks->getQuiz1(); ?>" class="form-control" /></td>
                                        <td><input name="quiz2" type="text" onchange="totalScore()" id="q2"   onfocus="this.select();" onmouseup="return false;"  onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $getStudentMarks->getQuiz2(); ?>" class="form-control" /></td>
                                        <td><input name="quiz3" type="text" onchange="totalScore()" id="q3"   onfocus="this.select();" onmouseup="return false;"  onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $getStudentMarks->getQuiz3(); ?>" class="form-control" /></td>
                                        <td><input name="final_exam" type="text" onchange="totalScore()" id="final" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" value="<?php echo $getStudentMarks->getFinal_exam(); ?>" class="form-control" /></td>
                                        <td><input type="text" name="total" value="<?php echo $getStudentMarks->getTotal(); ?>" id="total" class="form-control"  readonly="true"/></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <div class="box-footer pull-right">
                                    <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2">
                                        <?php  
                                        $oldClassID = $class->getClassID();
                                        $newClassID = $moveClassName->getClassID();
                                            if(($user_session->getRole() !=='Teacher') && ($newClassID !== $oldClassID)){?>
                                        <button class="btn btn-success btn-icon btn-move" data-id="<?php echo $id; ?>" 
                                  data-toggle="modal" data-target="<?php echo $movetype?>" type="button"><i class="fa fa-arrows"></i>&nbsp;&nbsp;Move</button>
                                               <?php }?>
                                        <button type="submit" class="btn btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update</button>
                                        <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id; ?>" 
                                  data-toggle="modal" data-target="#confirmDelete" type="button"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>
                                    </div>
                                </div>
                            </div>  

                        </div>
                    </div>
                </div>                   

            </div><!-- /.row -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'includes/footer.php';
?>
<!-- Modal Dialog -->
<div class="modal fade" style="margin-top: 100px;" id="confirmDelete"
  role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
          aria-hidden="true" id="btnClose">&times;</button>
        <h4 class="modal-title">Delete Student Scores</h4>
      </div>
      <div class="modal-body">
        <p>Do you want to remove this student mark ?</p>
      </div>
      <div class="modal-footer">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">
          <input type="hidden" name="mark_id" value="" id="m_id" />
          <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-hand-paper-o"></i>
            Cancel
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnDelete">
            <i class="fa fa-trash"></i>
            Remove
          </button>
        </form>
      </div>
      <!--/ modal-footer -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dialog -->
</div>
<!-- modal -->
<!-- Modal Dialog -->
<div class="modal fade" style="margin-top: 100px;" id="confirmMove1"
  role="dialog" aria-labelledby="confirmMoveDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
          aria-hidden="true" id="btnClose">&times;</button>
        <h4 class="modal-title">Move Student Scores</h4>
      </div>
      <div class="modal-body">
        <p>Do you want to move this student mark to current Class?</p>
      </div>
      <div class="modal-footer">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="moveForm">
          <input type="hidden" name="mark_id" value="" id="m_id" />
          <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-hand-paper-o"></i>
            Cancel
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnMove">
            <i class="fa fa-arrows"></i>
            Move
          </button>
        </form>
      </div>
      <!--/ modal-footer -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dialog -->
</div>
<!-- Modal Dialog -->
<div class="modal fade" style="margin-top: 100px;" id="confirmMove2"
  role="dialog" aria-labelledby="confirmMoveDeleteLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Replace Student Score</h4>
              </div>
              <div class="modal-body">
                <p>Student Score Already Have!!</p>
                <p><strong>Do you want to replace ?</strong></p>
              </div>
              <div class="modal-footer">
              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="replaceForm">
              <input type="hidden" name="mark_id" value="" id="m_id" />
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id='btnReplace'>Replace</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
  <!-- /modal-dialog -->
</div>
<!-- Modal Dialog -->
<div class="modal fade" style="margin-top: 100px;" id="confirmMove3"
  role="dialog" aria-labelledby="confirmMoveDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Move Student Scores</h4>
              </div>
              <div class="modal-body">
                <p>Please Insert Score for Students</p>
                <p>ROOM: <strong><?php echo $moveClassName->getClassName(); ?></strong></p>
                <p>EXAM: <strong><?php echo $exam->getExam_name();?></strong></p>
              </div>
              <div class="modal-footer">
              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="insertForm">
              <input type="hidden" name="mark_id" value="" id="m_id" />
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnInsertAuto">Insert Auto</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
  <!-- /modal-dialog -->
</div>
<!-- modal -->
<script src="../js/chosen.jquery.js"></script>
<script>
    $(document).ready(function () {
        $('.content').on('click', '.btn-delete', function () {
            $('#m_id').val($(this).data('id'));
            $('#r_id').val($(this).data('r_id'));
            $('#e_id').val($(this).data('e_id'));
        });
        $('.content').on('click', '.btn-move', function () {
            $('#m_id').val($(this).data('id'));
        });
        $('#btnDelete').click(function () {
            var url  = $('#deleteForm').attr('action');
            var id   = $('#m_id').val();
            
            $.ajax({
                url: 'cmd.php?action=delete&mark_id='+id,
                type: 'POST',
//                data: {'mark_id': id,'action': 'delete'},
                dataType: 'json',
                success: function (data) {
                    $(location).attr('href', 'view_score.php?id='+data.roomID+'&exam_id='+data.examID);
                }
            });
        });

        $('#btnMove').click(function () {
            var url = $('#moveForm').attr('action');
            var id = $('#m_id').val();
            $.ajax({
                url : "cmd.php?action=move&mark_id="+id,
                type :'POST',
//                date : {'mark_id': id, 'action': 'move'},
                dataType: 'json',
                success: function (data) {
//                    console.log(data);
//                    alert('test');
                   $(location).attr('href', 'view_exam_class.php?id='+data.examID);
                }
            });
        });

        $('#btnReplace').click(function () {
            var url = $('#replaceForm').attr('action');
            var id = $('#m_id').val();
            $.ajax({
                url: "cmd.php?action=replace&mark_id="+id,
                type: 'POST',
                dataType: 'json',
//                data: {'mark_id': id, 'action': 'replace'},
                success: function (data) {
//                    alert(data)
                   $(location).attr('href', 'view_exam_class.php?id='+data.examID);
                }
            });
        });

        $('#btnInsertAuto').click(function () {
            var url = $('#insertForm').attr('action');
            var id = $('#m_id').val();
            $.ajax({
                url: "cmd.php?action=insert&mark_id="+id,
                type: 'POST',
                dataType: 'json',
//                data: {'mark_id': id, 'action': 'insert'},
                success: function (data) {
//                    alert('test');
                    $(location).attr('href', 'view_exam_class.php?id='+data.examID);
                }
            });
        });
    });

</script>

<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 45 || charCode > 57 || charCode == 47)) {
            return false;
        }
        return true;
    }
</script>
<!-- Catculate attendance -->
<script>
    function attendance() {
        var A, P, result;
        A = parseFloat(document.getElementById("a").value);
        P = parseFloat(document.getElementById("p").value);
        result = 10 - (A + (P / 2));
        if (result < 1) {
            result = 0;
        }
        document.getElementById("att").value = result;
    }
</script>
<!-- Catculate total, result and rank -->
<script>
    function totalScore(id) {
//    alert(id);
        var A, P, ATT, HOME, CLASS, Q1, Q2, Q3, FINAL, result;
        A = parseFloat($("#a").val());
        if (isNaN(A) || A < 1) {
            A = 0;
            $("#a").val(0);
        }
        P = parseFloat($("#p").val());
        if (isNaN(P) || P < 1) {
            P = 0;
            $("#p").val(0);
        }
        ATT = 10 - (A + (P / 2));
        if (ATT < 1 || isNaN(ATT)) {
            ATT = 0;
        }
        $("#att").val(ATT);
        HOME = parseFloat($('#home').val());
        CLASS = parseFloat($('#class').val());
        Q1 = parseFloat($('#q1').val());
        Q2 = parseFloat($('#q2').val());
        Q3 = parseFloat($('#q3').val());
        FINAL = parseFloat($('#final').val());

//validation
        if (isNaN(FINAL) || FINAL < 1) {
            FINAL = 0;
            $("#final").val(0);
        } else if (FINAL > 50) {
            FINAL = 50;
            $("#final").val(50);
        }
        if (isNaN(CLASS) || CLASS < 1) {
            CLASS = 0;
            $("#class").val(0);
        } else if (CLASS > 5) {
            CLASS = 5;
            $("#class").val(5);
        }
        if (isNaN(HOME) || HOME < 1) {
            HOME = 0;
            $("#home").val(0);
        } else if (HOME > 5) {
            HOME = 5;
            $("#home").val(5);
        }
        if (isNaN(Q1) || Q1 < 1) {
            Q1 = 0;
            $("#q1").val(0);
        } else if (Q1 > 10) {
            Q1 = 10;
            $("#q1").val(10);
        }
        if (isNaN(Q2) || Q2 < 1) {
            Q2 = 0;
            $("#q2").val(0);
        } else if (Q2 > 10) {
            Q2 = 10;
            $("#q2").val(10);
        }
        if (isNaN(Q3) || Q3 < 1) {
            Q3 = 0;
            $("#q3").val(0);
        } else if (Q3 > 10) {
            Q3 = 10;
            $("#q3").val(10);
        }
        result = ATT + HOME + CLASS + Q1 + Q2 + Q3 + FINAL;
//    alert(result);
        if (result < 1 || isNaN(result)) {
            result = 0;

        }
        $('#total').val(result);


        if (result < 50) {
            $('#result').val("Fail");
        } else if (result >= 50)
            $('#result').val("Pass");
    }
</script>                         