<script src="../js/chosen.jquery.js"></script>
<?php
include 'includes/header.php';
include '../model/manageclass.php';
include '../model/manageexam.php';
include '../model/manageexammarks.php';
$exam = new Exam;
$exam_mark = new Exam_marks; //call class name

if ((isset($_GET['id'])) && (isset($_GET['room_id'])) && (isset($_GET['exam_id']))) {
    $id = $_GET['id'];
    $room_id = $_GET['room_id'];
    $exam_id = $_GET['exam_id'];
    $getStudentMarks = getExamMarkID($room_id, $exam_id);
    $checkStudentMarks = getCheckStudentID($id,$room_id,$exam_id);
    $class = getOneClass($room_id);
    $exam = getOneExam($exam_id);
    $exams = getExamClass($exam_id);
    $student = getOneStudent($id);
    $YYYY = date("Y" ,strtotime($student->getEnrollDate()));
    $MM = date("m" ,strtotime($student->getEnrollDate()));
    if ($getStudentMarks === null) {
        header("Location:404.php");
    }else if($checkStudentMarks){
        header("Location:404.php");
    }else if( ($MM > $exam->getExam_month()) && ($YYYY > $exam->getExam_year()) ){
        header("Location:404.php");
    }else {
        $classes = getAllClasses();
        $level = getOneLevel($class->getLevelID());
        $list = getAllStudentInClassOrderById($room_id);
        $getMark = getExamMarkIdOrderById($room_id, $exam_id);
    }
} else {
    header("Location:404.php");
}


//Inserting

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = COUNT($list);
    $user_id = $user_session->getUserID();
    $exam_mark->setExam_id($exam_id);
    $exam_mark->setRegister_user($user_id);

    $exam_mark->setRoom_id($_POST['room_id']);
    $exam_mark->setStudent_id($_POST['student_id']);
    $exam_mark->setAbsence_a($_POST['absence_a']);
    $exam_mark->setAbsence_p($_POST['absence_p']);
    $exam_mark->setHome_work($_POST['home_work']);
    $exam_mark->setClass_work($_POST['class_work']);
    $exam_mark->setQuiz1($_POST['quiz1']);
    $exam_mark->setQuiz2($_POST['quiz2']);
    $exam_mark->setQuiz3($_POST['quiz3']);
    $exam_mark->setFinal_exam($_POST['final_exam']);
    $exam_mark->setTotal($_POST['total']);

    $mark_id = insertExam_marks($exam_mark);

    header('Location: view_score.php?id=' . $_POST["room_id"] . '&exam_id=' . $exam_id);
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
            Add Score for specific student
            <small>Total student in his/her class is <b><?php echo count($list) ?></b></small>
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
                    <div class="box-body">
                        <form method="POST" id="examForm">

                            <div class="container">
                                <h1 class="page-header">Student Information</h1>
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="text-center" style="padding-top: 15px">

                                            <?php
                                            if (!empty($student->getPhoto())) {
                                                $img_url = $student->getPhoto();
                                            } else {
                                                $img_url = 'no-img.png';
                                            }
                                            ?>
                                            <img class='img-circle' src="uploads/<?php echo $img_url; ?>" width="150px" height="150px" />
                                            <?php echo "<a href='student_detail.php?id=" . $student->getStudentID() . "'><h6>View Full Profile</h6></a>"; ?>

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


                            <div class="table-responsive">
                                <table id="student-list" class="table table-bordered table-hover ">
                                    <thead class="center text-nowrap">
                                        <tr class="info">
                                            <th rowspan="4">Name</th>
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
                                        <tr><th rowspan="2" class="danger"> A</th><th rowspan="2" class="success"> P</th></tr> 
                                    </thead>
                                    <tbody id="data-list">
                                        <?php
                                        $records = getOneStudent($id);
                                        ?>

                                    <input type="hidden" name="student_id" value="<?php echo $student->getStudentID() ?>">
                                    <input type="hidden" name="room_id" value="<?php echo $room_id ?>">

                                    <tr>
                                        <td><?php echo $student->getStudentName(); ?></td>
                                        <td><?php echo $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                                        <td><input name="absence_a" type="text" onchange="totalScore()" id="a" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" class="form-control" /></td>
                                        <td><input name="absence_p" type="text" onchange="totalScore()" id="p" value="0" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" class="form-control" /></td>
                                        <td><input name="att" type="text" id="att" value="0" class="form-control" style="border: none;" readonly="true"/></td>

                                        <td><input name="home_work" type="text" onchange="totalScore()" id="home"  onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" value="0" class="form-control"  /></td>
                                        <td><input name="class_work" type="text" onchange="totalScore()" id="class" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" value="0" class="form-control"  /></td>
                                        <td><input name="quiz1" type="text" onchange="totalScore()" id="q1"   onfocus="this.select();" onmouseup="return false;"  onkeypress="return isNumber(event)" maxlength="4" value="0" class="form-control" /></td>
                                        <td><input name="quiz2" type="text" onchange="totalScore()" id="q2"   onfocus="this.select();" onmouseup="return false;"  onkeypress="return isNumber(event)" maxlength="4" value="0" class="form-control" /></td>
                                        <td><input name="quiz3" type="text" onchange="totalScore()" id="q3"   onfocus="this.select();" onmouseup="return false;"  onkeypress="return isNumber(event)" maxlength="4" value="0" class="form-control" /></td>
                                        <td><input name="final_exam" type="text" onchange="totalScore()" id="final" onfocus="this.select();" onmouseup="return false;" onkeypress="return isNumber(event)" maxlength="4" value="0" class="form-control" /></td>
                                        <td><input type="text" name="total" value="0" id="total" class="form-control"  readonly="true"/></td>
                                    </tr>
                                    <?php
                                    ?> 
                                    </tbody>
                                </table>

                                <div class="box-footer pull-right">
                                    <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2"> 
                                        <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Submit</button>
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

<script type="text/javascript">

                                            $(document).ready(function () {

                                                $('.form-information').on('change', '#class_id', function () {
                                                    var id = $(this).val();
                                                    $.ajax({
                                                        url: 'add_score.php?id=' + id,
                                                        type: 'get',
                                                        success: function (data) {
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
                                                $('.chosen-select-deselect').chosen({allow_single_deselect: true});
                                            });

</script>



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



