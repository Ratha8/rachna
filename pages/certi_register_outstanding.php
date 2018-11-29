<?php
  include 'includes/header.php';
  include '../model/managecertificate.php';
  include '../model/managelevel.php';
  $student_id_err = "";
  $type_err = "";
  $Level_err = "";
  $grade_err = "";
  $date_err = "";
  $issue_date_err = "";
  $no_err = "";
  $detail_err = "";
  $type_month_err = "";
  $year_err = "";
  $month_err = "";
  $level_id_err = "";
  $score_err = "";
  $register_user_err = "";

  $certificate = new Certificate;
  $user = getAllUsers();
  if(isset($_GET['id']) && isset($_GET['score']) && isset($_GET['type']) && isset($_GET['duration']) && isset($_GET['level']) && isset($_GET['year'] )) {
    $id = $_GET['id'];
    $score = $_GET['score'];
    $type = $_GET['type'];
    $duration = $_GET['duration'];
    $level = $_GET['level'];
    $year = $_GET['year'];
    $getLevel = getOneLevel($level);
    $getStudentRecords = getOneStudent($id);
    if ($score <= 49)
      $mention = 'F';
    elseif ($score <= 68)
      $mention = 'E';
    elseif ($score <= 78)
      $mention = 'D';
    elseif ($score <= 85)
      $mention = 'C';
    elseif ($score <= 94)
      $mention = 'B';
    elseif ($score >= 95)
      $mention = 'A';
    if($type == 1){
      $getTyepe = '1 month';
      $month_name = date("F", mktime(0, 0, 0, $duration, 15));
      $month_number = $duration;
    }elseif ($type == 2){
      $getTyepe = 'Trimeter';
      if($duration == 1){
        $month_name = 'January to March';
        $month_number = 3;
      }elseif($duration == 4){
        $month_name = 'April to June';
        $month_number = 6;
      }elseif($duration == 7){
        $month_name = 'July to September';
        $month_number = 9;
      }else{
        $month_name = 'October to December';
        $month_number = 12;
      }
    }elseif ($type == 3){
      $getTyepe = 'Semester';
      if($duration == 1){
        $month_name = 'January to June';
        $month_number = 6;
      }else{
        $month_name = 'July to December';
        $month_number = 12;
      }
    }else{
      $getTyepe = '1 Year';
      $month_name = 'January to December';
      $month_number = 12;
    }
    if($getStudentRecords === null) {
      header("Location:404.php");
    } else { 
      if(!empty($getStudentRecords->getPhoto())){
        $photo = 'uploads/'.$getStudentRecords->getPhoto();
      }else{
        $photo = '<span></span>';
      }
    }
  } else {
    header("Location:404.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $date = isset($_POST["date"]) ? (!empty($_POST["date"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date']))) : "") : "";
    $issue_date = isset($_POST["iss_date"]) ? (!empty($_POST["iss_date"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['iss_date']))) : "") : "";
    $curr_date = isset($_POST["cur_date"]) ? (!empty($_POST["cur_date"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['cur_date']))) : "") : "";
    $certificate->setUpdateUser($user_session->getUserID());
    $certificate->setRegisterUser($user_session->getUserID());
    $certificate->setStudentID($_POST['student_id']);
    $certificate->setCertificateType($_POST['type']);
    $certificate->setLevel($_POST['level']);
    $certificate->setLevelID($_POST['level_id']);
    $certificate->setGrade($_POST['grade']);
    $certificate->setScore($_POST['score']);
    $certificate->setDate($date);
    $certificate->setIssueDate($issue_date);
    $certificate->setNo($_POST['no']);
    $certificate->setDetail($_POST['detail']);
    $certificate->setTypeMonth($_POST['type_month']);
    $certificate->setMonth($_POST['month']);
    $certificate->setYear($_POST['year']);
    $certificate->setScore($_POST['score']);
    $certificate->setRegisterDate($curr_date);
    
     $st_err = 0;
    if(empty($certificate->getStudentID())){
      $st_err = 1;
      $student_id_err = "Student name is required.";
    }

    if(empty($certificate->getCertificateType())){
      $st_err = 1;
      $type_err = "Type is required.";
    }

    if(empty($certificate->getLevel())){
      $st_err = 1;
      $Level_err = "Level is required.";
    }

    if(empty($certificate->getGrade())){
      $st_err = 1;
      $grade_err = "Grade is required.";
    }

    if(empty($certificate->getDate())){
      $st_err = 1;
      $date_err = "Date is required.";
    }

    if(empty($certificate->getIssueDate())){
      $st_err = 1;
      $issue_date_err = "Issue Date is required.";
    }

    if(empty($certificate->getNo())){
      $st_err = 1;
      $no_err = "No is required.";
    }

    if(empty($certificate->getDetail())){
      $st_err = 1;
      $detail_err = "Detail is required.";
    }

    if(empty($certificate->getLevelID())){
      $st_err = 1;
      $level_err = "Level is required.";
    }

    if(empty($certificate->getMonth())){
      $st_err = 1;
      $month_err = "Month is required.";
    }

    if(empty($certificate->getYear())){
      $st_err = 1;
      $year_err = "Year is required.";
    }

    if(empty($certificate->getTypeMonth())){
      $st_err = 1;
      $type_month_err = "Type Month is required.";
    }

    if(empty($certificate->getScore())){
      $st_err = 1;
      $score_err = "Score is required.";
    }

    if($st_err === 0){
      $certificate = insertCertificate($certificate);
      if($certificate->getCertificateType() == 1){
         header("Location:cert_parttime.php?id=".$certificate->getCertificateID());
      }elseif ($certificate->getCertificateType() == 2) {
         header("Location:cert_fulltime.php?id=".$certificate->getCertificateID());
      }else{
         header("Location:cert_outstanding.php?id=".$certificate->getCertificateID());
      }
    } 
  }
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Student Attendance
            <small>Add new attendance for student</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="cert_class_list.php"> Classroom List</a></li>
            <li class="active">Attendance Student</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']."?id=".$id."&level=".$level."&score=".$score."&duration=".$duration."&year=".$year."&type=".$type."" ?>" method="POST" id="classForm">
                  <input type="hidden" name="id" value="<?php echo $id ?>">
                  <div class="box-body">
                      <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">No</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <input type="text" name="no" class="form-control" placeholder="No" required=""> 
                        <span class="error col-md-12 no-padding"><?php echo $no_err;?></span>
                      </div>
                    </div>
                       <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Student Name</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                           <input type="hidden" class="form-control" name="student_id" value="<?php echo $getStudentRecords->getStudentID()?>" readonly required="">
                          <input type="text" class="form-control" name="student_name" value="<?php echo $getStudentRecords->getStudentName()?>" readonly required=""> 
                        <span class="error col-md-12 no-padding"><?php echo $register_user_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_level">Level</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <input type="hidden" name="level_id" class="form-control" placeholder="Level" value="<?php echo $getLevel->getLevelID(); ?>" required="">
                        <input type="text" name="level" class="form-control" placeholder="Level" value="<?php echo $getLevel->getLevelName(); ?>" required=""> 
                        <span class="error col-md-12 no-padding"><?php echo $Level_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Grade</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <input type="text" class="form-control" name="grade" value="<?php echo $mention?>" readonly required=""> 
                        <input type="hidden" class="form-control" name="score" value="<?php echo $score?>" readonly required=""> 
                        <span class="error col-md-12 no-padding"><?php echo $grade_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_date">Date</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="date" id="date" class="form-control" placeholder="Date" value="<?php echo date('d/F/Y') ?>" required="">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>               
                        <span class="error col-md-12 no-padding"><?php echo $date_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_iss_date">Issued Date</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="iss_date" id="iss_date" class="form-control" placeholder="Issued Date" value="<?php echo date('d/F/Y') ?>" required="">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>               
                        <span class="error col-md-12 no-padding"><?php echo $issue_date_err;?></span>
                      </div>
                    </div> 
                    <div class="form-group" id="cur_date" style="display: none;">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_cur_date">Current Date</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="cur_date" id="cur_date_value" class="form-control" placeholder="Current Date" value="<?php echo date('d/F/Y') ?>" required="">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div> 
                     <div class="form-group">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_detail">Detail</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <textarea class="form-control no-resize" name="detail" id="detail" placeholder="Cartificate Detail"><?php echo 'Is hereby recognized for outstanding '.$getTyepe.'( '.$month_name.' '.$year.' )'; ?></textarea>
                            <span class="error col-md-12 no-padding"><?php echo $detail_err;?></span>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label">Type Cartificate</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <div class="radio">
                              <label><input type="radio" name="type" value="1" onclick="getCheck(1)">Part Time Cartificate</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="type" value="2" onclick="getCheck(2)">Full Time Cartificate</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="type" value="3" checked="" onclick="getCheck(3)">OutStanding Cartificate</label>
                            </div>
                            <span class="error col-md-12 no-padding"><?php echo $type_err;?></span>
                          </div>
                      </div>       
                      <input type="hidden" name="type_month" id='type_month_value' class="form-control" placeholder="No" value="<?php echo $type;?>" readonly=""> 
                      <input type="hidden" name="month" id='value_month' class="form-control" placeholder="No" value="<?php echo $month_number;?>" readonly=""> 
                      <input type="hidden" name="year" id='year_value' class="form-control" placeholder="No" value="<?php echo $year;?>" readonly="">                                             
                    <div class="box-footer">
                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-info pull-right">
                          <i class="fa fa-print" aria-hidden="true"></i>
                          Submit
                        </button>
                      </div>
                    </div><!-- /.box-footer -->                    
                  </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
            </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php
  include 'includes/footer.php';
?>

<!-- bootstrap chosen -->
<script src="../js/chosen.jquery.js"></script>
<script src="../js/moment-with-locales.min.js"></script>
<!-- bootstrap datetime picker -->
<script src="../js/bootstrap-datetimepicker.min.js"></script>
<script>
   $(function () {
        $('.date').datetimepicker({
            format: 'DD/MMMM/YYYY',
            allowInputToggle: true,
            ignoreReadonly: true,
            useCurrent: true,
            showClear: true,
            showClose: true,
            showTodayButton: true
        }).on('dp.change dp.show', function (e) {
        });
    
  });  

   function getGrade(){
      var score = $('#score').val();
      var mention = 0;
      if(score <= 49){
        mention = 'F';
      }else if(score <= 68){
        mention = 'E';
      }else if(score <= 78){
        mention = 'D';
      }else if(score <= 85){
        mention = 'C';
      }else if(score <= 94){
        mention = 'B';
      }else{
        mention = 'A';
      }
      $('#grade').val(mention);
   }
   function getCheck($id){
    var monthNames = ["Month","January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
    var year = new Date().getFullYear();
    var getType = $('#type_month_value').val();
    var getMonth = $('#value_month').val();
    var getYear = $('#year_value').val();
    var value_type = '';
    var month = '';
    if(getType == 1){
      value_type = '1 Month';
      month = monthNames[getMonth];
    }else if(getType == 2){
      value_type = 'Trimeter';
      if(getMonth == 1){
        month = 'January to March';
      }else if(getMonth == 4){
        month = 'April to June';
      }else if( getMonth == 7){
        month = 'July to September';
      }else{
        month = 'October to December';
      }
    }else if(getType == 3){
      value_type = 'Semester';
      if(getMonth == 1){
        month = 'January to June';
      }else{
        month = 'July to December';
      }
    }else{
      value_type = '1 Year';
      month = 'January to December';
    }
    switch($id) {
    case 1:
        $('#year_value').val(year);
        $('#label_level').text('Course');
        $('#label_detail').text('Completed');
        $('#label_date').text('From');
        $('#label_iss_date').text('To');
        $('#cur_date').css("display", "block");
        $('#detail').val('Part-Time English Program');
        break;
    case 2:
        $('#year_value').val(year);
        $('#label_level').text('Level');
        $('#label_detail').text('Detail');
        $('#label_date').text('Date');
        $('#label_iss_date').text('Issued Date');
        $('#cur_date').css("display", "none");
        $('#detail').val('This certificate shows that the bearer is eligible for study in the next level.');
        break;
    default:
        $('#label_level').text('Level');
        $('#label_detail').text('Detail');
        $('#label_date').text('Date');
        $('#label_iss_date').text('Issued Date');
        $('#cur_date').css("display", "none");
        $('#detail').val('Is hereby recognized for outstanding '+value_type+'( '+month+' '+getYear+' ) ');
        break;
} 
   }

</script>