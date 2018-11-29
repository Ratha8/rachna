<script src="../js/chosen.jquery.js"></script>
<?php
include 'includes/header.php';
include '../model/manageclass.php';
include '../model/manageexam.php';
include '../model/manageexammarks.php';
$exam = new Exam;
$exam_mark = new Exam_marks; //call class name

if ((isset($_GET['id'])) && (isset($_GET['exam_id']))) {
    $room_id = $_GET['id'];
    $exam_id = $_GET['exam_id'];
    $getStudentMarks = getExamMarkID($room_id, $exam_id);
    $class = getOneClass($room_id);
    $exam = getOneExam($exam_id);
    $ExamMonth = $exam->getExam_month();
    $ExamYear = $exam->getExam_year();
    $exams = getExamClass($exam_id);
    if ($getStudentMarks === null) {
        header("Location:404.php");
    } else {
        $classes = getAllClasses();
        $level = getOneLevel($class->getLevelID());
        $list = getAllStudentInClassOrderByIdOnRegis($room_id, $ExamMonth, $ExamYear);
        $getMark = getExamMarkIdOrderById($room_id, $exam_id);
        for ($i = 0; $i < COUNT($list); $i++) {
            $getStudentID['studentID'][] = $list[$i]['student_id'];
        }
        $getStudentID['studentMarkID'][] = '';
        for ($i = 0; $i < COUNT($getMark); $i++) {
            $getStudentID['studentMarkID'][] = $getMark[$i]['student_id'];
        }
        $result = array_diff($getStudentID['studentID'], $getStudentID['studentMarkID']);

    }
} else {
    header("Location:404.php");
}
//Inserting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = COUNT($result);
    $user_id = $user_session->getUserID();
    $exam_mark->setExam_id($_POST['exam_id']);
    $exam_mark->setRegister_user($user_id);
    for ($i = 1; $i <= $count; $i++) {
        $exam_mark->setRoom_id($_POST['room_id']);
        $exam_mark->setStudent_id($_POST['student_id_' . $i]);
        $exam_mark->setAbsence_a($_POST['absence_a_' . $i]);
        $exam_mark->setAbsence_p($_POST['absence_p_' . $i]);
        $exam_mark->setHome_work($_POST['home_work_' . $i]);
        $exam_mark->setClass_work($_POST['class_work_' . $i]);
        $exam_mark->setQuiz1($_POST['quiz1_' . $i]);
        $exam_mark->setQuiz2($_POST['quiz2_' . $i]);
        $exam_mark->setQuiz3($_POST['quiz3_' . $i]);
        $exam_mark->setFinal_exam($_POST['final_exam_' . $i]);
        $exam_mark->setTotal($_POST['total_' . $i]);

        $mark_id = insertExam_marks($exam_mark);
    }
    header('Location: view_score.php?id=' . $_POST["room_id"] . '&exam_id=' . $_POST["exam_id"]);
}
?>

<style>
    .table-text-center th, .table-text-center td {
        text-align: center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student List
            <small>Total student in this class is <b><?php echo count($list) ?></b></small>
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

                        <h3 class="box-title">Add Score For Class <?php echo $class->getClassName(); ?>&nbsp;|&nbsp;
                            <strong>
                                <small>Current Date:&nbsp;<span><?php echo date('d F Y'); ?></span></small>
                            </strong>
                        </h3>
                        <span class="pull-right"><i class="fa fa-square" style="color:#f2dede" aria-hidden="true"></i> Leave Student</span>
                        <span class="pull-right"><i class="fa fa-square" style="color:#dff0d8" aria-hidden="true"></i> Move Class</span>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form method="POST" id="examForm">
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
                                        <input type="hidden" name="room_id" value="<?php echo $class->getClassID() ?>"/>
                                        <span class="col-md-4 col-sm-3 col-xs-8 control-span" id="info-level">
                                            <?php echo $class->getClassName() ?>
                                        </span>
                                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                                            <i class="fa fa-clock-o">&nbsp;&nbsp;Exam </i>&nbsp;
                                            <i class="i-split">:</i>
                                        </label>
                                        <input type="hidden" name="exam_id" value="<?php echo $exams[0]['exam_id'] ?>"/>
                                        <span class="col-md-3 col-sm-3 col-xs-8 control-span " id="exam" >  
                                            <?php echo $exams[0]['exam_name']; ?>
                                        </span>
                                    </div> 
                                </div>
                            </div>     
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover ">
                                    <thead class="center text-nowrap">
                                        <tr class="info">
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Name</th>           
                                            <th rowspan="2">Gender</th>        
                                            <th colspan="2">Absence</th>
                                            <th rowspan="2">Att 10%</th>
                                            <th rowspan="2">Home 5%</th>
                                            <th rowspan="2">Class 5%</th>
                                            <th rowspan="2">Q1, 10%</th>
                                            <th rowspan="2">Q2, 10%</th>
                                            <th rowspan="2">Q3, 10%</th>
                                            <th rowspan="2">Final, 50%</th>
                                            <th rowspan="2">Total</th>
                                        </tr>
                                        <tr><th rowspan="2" class="danger"> A</th>
                                            <th rowspan="2" class="success"> P</th>
                                        </tr> 
                                    </thead>
                                    <tbody id="data-list">
                                        <?php
                                        $row_num = 1;
                                        foreach ($result as $record) {
                                            $records = getOneStudent($record);
                                            if($records->getLeaveflag() == 1){
                                                $month = date('m',strtotime(str_replace('-','/', $records->getLeaveDate())));
                                                $year = date('Y',strtotime(str_replace('-','/', $records->getLeaveDate())));
                                                if(($month == $exam->getExam_month()) AND ($year == $exam->getExam_year())){
                                                  $leave = 'danger';
                                                }else{
                                                  $leave = '';
                                                }
                                                if(($month >= $exam->getExam_month()) AND ($year >= $exam->getExam_year())){ ?>
                                                     <tr class="text-nowrap <?php echo $leave?>">
                                                <td><?php echo $row_num; ?></td>
                                        <input name="student_id_<?php echo $row_num ?>" type="hidden" value="<?php echo $records->getStudentID() ?>" />
                                        <input name="room_id_<?php echo $row_num ?>" type="hidden" value="<?php echo $room_id ?>" />
                                        <input name="exam_id_<?php echo $row_num ?>" type="hidden" value="<?php echo $exam_id ?>" />
                                        <td><input type="button" onclick="location.href = 'add_single_stud_score.php?id=<?php echo $records->getStudentID() ?>&exam_id=<?php echo $exam_id; ?>&room_id=<?php echo $room_id; ?>';" value="<?php echo $records->getStudentName() ?>" style="
                                                   background:none!important;
                                                   color:#007bb6;
                                                   border:none; 
                                                   padding:0!important;
                                                   font: inherit;
                                                   cursor: pointer;" /></td>
                                        <td><?php echo $records->getGender() != 1 ? ($records->getGender() != 2 ? 'Other' : 'Female') : 'Male'; ?></td> 
                                        <td><input name='absence_a_<?php echo $row_num ?>' type="text" onchange="totalScore(<?php echo $row_num ?>)" id="a_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="2" class="form-control" style="border: none; padding:3px"/></td>
                                        <td><input name='absence_p_<?php echo $row_num ?>' type="text" onchange="totalScore(<?php echo $row_num ?>)" id="p_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="2" class="form-control" style="border: none;padding:3px"/></td>
                                        <td><input type="text" id="att_<?php echo $row_num ?>" value="10" class="form-control" style="border: none;" readonly /></td>
                                        <td><input name="home_work_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="home_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;" /></td>
                                        <td><input name="class_work_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="class_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="quiz1_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q1_<?php echo $row_num ?>"    value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="quiz2_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q2_<?php echo $row_num ?>"    value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="quiz3_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q3_<?php echo $row_num ?>"    value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="final_exam_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="final_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="total_<?php echo $row_num ?>" value="10" id="total_<?php echo $row_num ?>" class="form-control" style="border: none;" readonly/></td>

                                        </tr>
                                            <?php   $row_num++;  }
                                            }else{ ?>
                                                 <tr class="text-nowrap <?php // echo $leave           ?>">
                                                <td><?php echo $row_num; ?></td>
                                        <input name="student_id_<?php echo $row_num ?>" type="hidden" value="<?php echo $records->getStudentID() ?>" />
                                        <input name="room_id_<?php echo $row_num ?>" type="hidden" value="<?php echo $room_id ?>" />
                                        <input name="exam_id_<?php echo $row_num ?>" type="hidden" value="<?php echo $exam_id ?>" />
                                        <td><input type="button" onclick="location.href = 'add_single_stud_score.php?id=<?php echo $records->getStudentID() ?>&exam_id=<?php echo $exam_id; ?>&room_id=<?php echo $room_id; ?>';" value="<?php echo $records->getStudentName() ?>" style="
                                                   background:none!important;
                                                   color:#007bb6;
                                                   border:none; 
                                                   padding:0!important;
                                                   font: inherit;
                                                   cursor: pointer;" /></td>
                                        <td><?php echo $records->getGender() != 1 ? ($records->getGender() != 2 ? 'Other' : 'Female') : 'Male'; ?></td> 
                                        <td><input name='absence_a_<?php echo $row_num ?>' type="text" onchange="totalScore(<?php echo $row_num ?>)" id="a_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="2" class="form-control" style="border: none; padding:3px"/></td>
                                        <td><input name='absence_p_<?php echo $row_num ?>' type="text" onchange="totalScore(<?php echo $row_num ?>)" id="p_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="2" class="form-control" style="border: none;padding:3px"/></td>
                                        <td><input type="text" id="att_<?php echo $row_num ?>" value="10" class="form-control" style="border: none;" readonly /></td>
                                        <td><input name="home_work_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="home_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;" /></td>
                                        <td><input name="class_work_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="class_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="quiz1_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q1_<?php echo $row_num ?>"    value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="quiz2_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q2_<?php echo $row_num ?>"    value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="quiz3_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="q3_<?php echo $row_num ?>"    value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="final_exam_<?php echo $row_num ?>" type="text" onchange="totalScore(<?php echo $row_num ?>)" id="final_<?php echo $row_num ?>" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="5" class="form-control" style="border: none;"/></td>
                                        <td><input name="total_<?php echo $row_num ?>" value="10" id="total_<?php echo $row_num ?>" class="form-control" style="border: none;" readonly/></td>

                                        </tr>
                                            
                                           
                                        <?php
                                         $row_num++;
                                        }
                                    }
                                    ?> 
                                    </tbody>
                                </table>

                                <div class="box-footer pull-right">
                                    <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2"> 
                                        <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                                    </div>
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
<script>
                                        function totalScore(id) {
                                            var A, P, ATT, HOME, CLASS, Q1, Q2, Q3, FINAL, result;
                                            A = parseFloat($("#a_" + id).val());
                                            if (isNaN(A) || A < 1) {
                                                A = 0;
                                                $("#a_" + id).val(0);
                                            }
                                            P = parseFloat($("#p_" + id).val());
                                            if (isNaN(P) || P < 1) {
                                                P = 0;
                                                $("#p_" + id).val(0);
                                            }
                                            ATT = 10 - (A + (P / 2));
                                            if (ATT < 1 || isNaN(ATT)) {
                                                ATT = 0;
                                            }
                                            $("#att_" + id).val(ATT);
                                            HOME = parseFloat($('#home_' + id).val());
                                            CLASS = parseFloat($('#class_' + id).val());
                                            Q1 = parseFloat($('#q1_' + id).val());
                                            Q2 = parseFloat($('#q2_' + id).val());
                                            Q3 = parseFloat($('#q3_' + id).val());
                                            FINAL = parseFloat($('#final_' + id).val());
                                            //validation
                                            if (isNaN(FINAL) || FINAL < 1) {
                                                FINAL = 0;
                                                $("#final_" + id).val(0);
                                            } else if (FINAL > 50) {
                                                FINAL = 50;
                                                $("#final_" + id).val(50);
                                            }
                                            if (isNaN(CLASS) || CLASS < 1) {
                                                CLASS = 0;
                                                $("#class_" + id).val(0);
                                            } else if (CLASS > 5) {
                                                CLASS = 5;
                                                $("#class_" + id).val(5);
                                            }
                                            if (isNaN(HOME) || HOME < 1) {
                                                HOME = 0;
                                                $("#home_" + id).val(0);
                                            } else if (HOME > 5) {
                                                HOME = 5;
                                                $("#home_" + id).val(5);
                                            }
                                            if (isNaN(Q1) || Q1 < 1) {
                                                Q1 = 0;
                                                $("#q1_" + id).val(0);
                                            } else if (Q1 > 10) {
                                                Q1 = 10;
                                                $("#q1_" + id).val(10);
                                            }
                                            if (isNaN(Q2) || Q2 < 1) {
                                                Q2 = 0;
                                                $("#q2_" + id).val(0);
                                            } else if (Q2 > 10) {
                                                Q2 = 10;
                                                $("#q2_" + id).val(10);
                                            }
                                            if (isNaN(Q3) || Q3 < 1) {
                                                Q3 = 0;
                                                $("#q3_" + id).val(0);
                                            } else if (Q3 > 10) {
                                                Q3 = 10;
                                                $("#q3_" + id).val(10);
                                            }
                                            result = ATT + HOME + CLASS + Q1 + Q2 + Q3 + FINAL;
                                            if (result < 1 || isNaN(result)) {
                                                result = 0;

                                            }
                                            $('#total_' + id).val(result);
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
