<?php
    include 'includes/header.php';
    include '../model/manageclass.php';  
    include'../model/managereport.php';
    include'../model/manageexammarks.php';

$report = new Report;
$exam_mark = new Exam_marks;
$getStudent= $_GET['student'];
$getMonth = $_GET['month'];
$getYear= $_GET['year'];
if(!empty($getStudent) && !empty($getMonth) && !empty($getYear)){
	switch ($getMonth) {
		case 1:
			$examID = getTrimExamID(1, 3, $getYear);
			$for = 3;
			break;
		
		case 2:
			$examID = getTrimExamID(5, 6, $getYear);
			$for = 3;
			break;
		
		case 3:
			$examID = getTrimExamID(7, 9, $getYear);
			$for = 3;
			break;
		
		case 4:
			$examID = getTrimExamID(10, 12, $getYear);
			$for = 3;
			break;
		case 5:
			$examID = getTrimExamID(1, 6, $getYear);
			$for = 6;
			break;
		case 6:
			$examID = getTrimExamID(7, 12, $getYear);
			$for = 6;
			break;
		case 7:
			$examID = getTrimExamID(1, 12, $getYear);
			$for = 12;
			break;
		
		default:
			$examID = getTrimExamID(1, 12, $getYear);
            $for = 0;
			break;
	}
	if(COUNT($examID) <= 0){
		header("Location:404.php"); 
	}else{
		$student = getOneStudent($getStudent);
		$score = getReportTrimScore($examID , $getStudent);	
	}
	
	if($score === null) {
		header("Location:404.php");
	}else{
		$class = getOneClass($student->getClassID());
        $level = getOneLevel($class->getLevelID());
		$a = $score['absence_a'];
		$p = $score['absence_p'];
		$homework =$score['home_work']/$for;
		$classwork =$score['class_work']/$for;
		$q1 =$score['quiz1']/$for;
		$q2 =$score['quiz2']/$for;
		$q3 =$score['quiz3']/$for;
		$final = $score['Total']/$for;
	}
}else{
	header("Location:404.php");
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}else{
    $id = $getMonth;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $markID = $id;
    $userID = $user_session->getUserID();
    $student = getOneStudent($getStudent);
    $report->setStudentID($student->getStudentID());
    $report->setMarkID($id);
    $report->setAttentiveness($_POST['as']);
    $report->setDiscipline($_POST['dm']);
    $report->setReading($_POST['reading']);
    $report->setWriting($_POST['writing']);
    $report->setSpeaking($_POST['speaking']);
    $report->setListening($_POST['listening']);
    $report->setMemory($_POST['speaking']);
    $report->setLastResult($_POST['last_result']);
    $report->setAttendance($_POST['att']);
    $report->setHomeWork($_POST['home_work']);
    $report->setClassWork($_POST['class_work']);
    $report->setQuiz1($_POST['q1']);
    $report->setQuiz2($_POST['q2']);
    $report->setQuiz3($_POST['q3']);
    $report->setFinal($_POST['final']);
    $report->setRegisterUSer($userID);

    
    $classID = $student->getClassID();
    $lastID = insertReport($report);
    header('Location: student_report.php?id='.$lastID);
    
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
            <li class="active">Student Report</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="POST" id="reportForm">
            <!-- Horizontal Form -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-info">
                        <div class="container">
                            <h1 class="page-header">Student Information</h1>
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
                                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Level :</label>
                                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">
                                                <?php
                                                echo $level != null ? $level->getLevelName() : '<i class="text-red">Information is missing! Please consider to update the information.</i>';
                                                ?>
                                            </label>                                                   
                                        </div>                          
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body" style="padding-top: 25px;">
                          <?php
                            $att = 10 - ($a + $p / 2);
                            $att < 0 ? $att = 0 : $att;
                        ?>
                            <div class="col-md-9 col-sm-12 col-xs-12"> 
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">Attendance(10%)</label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                    <input class="form-control" name="att" placeholder="Name of exam" required="" type="text" value="<?php echo $att/$for ?>" readonly>
                                    <span class="error col-md-12 no-padding"></span>
                                    <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                                      <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%"></div>
                                    </div>
                                    <label class="col-md-6 col-sm-6 col-xs-6 control-label no-padding-hori">Attentiveness on study (5%)</label>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control" name="as" placeholder="Name of exam" required="" type="text" value="0">
                                    </div>
                                    <label class="col-md-6 col-sm-6 col-xs-6 control-label no-padding-hori">Discipline and monlity (5%)</label>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control" name="dm" placeholder="Name of exam" required="" type="text" value="0">
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">Home Work (5%)</label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                    <input class="form-control" name="home_work" placeholder="Name of exam" required="" type="text" value="<?php echo number_format((float)$homework, 2,'.',''); ?>" readonly>
                                    <span class="error col-md-12 no-padding"></span>
                                    <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                                      <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%"></div>
                                    </div>
                                    <label class="col-md-6 col-sm-6 col-xs-6 control-label no-padding-hori">Progress in reading (1%)</label>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control" name="reading" placeholder="Name of exam" required="" type="text" value="0">
                                    </div>
                                    <label class="col-md-6 col-sm-6 col-xs-6 control-label no-padding-hori">Progress in writing (1%)</label>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control" name="writing" placeholder="Name of exam" required="" type="text" value="0">
                                    </div>
                                    <label class="col-md-6 col-sm-6 col-xs-6 control-label no-padding-hori">Progress in speaking (1%)</label>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control" name="speaking" placeholder="Name of exam" required="" type="text" value="0">
                                    </div>
                                    <label class="col-md-6 col-sm-6 col-xs-6 control-label no-padding-hori">Progress in listening (1%)</label>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control" name="listening" placeholder="Name of exam" required="" type="text" value="0">
                                    </div>
                                    <label class="col-md-6 col-sm-6 col-xs-6 control-label no-padding-hori">Development on memory (1%)</label>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control" name="memory" placeholder="Name of exam" required="" type="text" value="0">
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">Class Work (5%)</label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                    <input class="form-control" name="class_work" placeholder="Name of exam" required="" type="text" value="<?php echo number_format((float)$classwork, 2,'.',''); ?>" readonly>
                                    <span class="error col-md-12 no-padding"></span>
                                    <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                                      <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%"></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">Quiz 1 Reading Test (10%)</label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                    <input class="form-control" name="q1" placeholder="Name of exam" required="" type="text" value="<?php echo number_format((float)$q1, 2,'.',''); ?>" readonly>
                                    <span class="error col-md-12 no-padding"></span>
                                    <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                                      <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%"></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">Quiz 2 Dictation (10%)</label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                    <input class="form-control" name="q2" placeholder="Name of exam" required="" type="text" value="<?php echo number_format((float)$q2, 2,'.',''); ?>" readonly>
                                    <span class="error col-md-12 no-padding"></span>
                                    <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                                      <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%"></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">Quiz 3 Oral Test (10%) (5%)</label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                    <input class="form-control" name="q3" placeholder="Name of exam" required="" type="text" value="<?php echo number_format((float)$q3, 2,'.',''); ?>" readonly>
                                    <span class="error col-md-12 no-padding"></span>
                                    <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                                      <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%"></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">Final Exam (50%) </label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                    <input class="form-control" name="final" placeholder="Final exam" required="" type="text" value="<?php echo number_format((float)$final, 2,'.',''); ?>" readonly>
                                    <span class="error col-md-12 no-padding"></span>
                                    <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                                      <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: 100%"></div>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 col-sm-3 col-xs-3 control-label no-padding-hori">លទ្ធផលធៀបនឹងខែមុនៈ </label>
                                  <div class="col-md-9 col-sm-10 col-xs-10">
                                      <select name="last_result">
                                          <option value="0"> អន់ជាង  </option>
                                          <option value="1"> ល្អដដែល </option>
                                          <option value="2"> ប្រសើរជាង </option>
                                      </select>
                                    </div>
                                </div>
                                <div class="box-footer pull-right">
                                    <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2"> 
                                        <button type="submit" class="btn btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Submit</button>
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
<script src="../js/chosen.jquery.js"></script>

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