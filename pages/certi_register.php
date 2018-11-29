<?php
  include 'includes/header.php';
  include '../model/managecertificate.php';
  include '../model/manageclass.php';
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
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $class = getOneClass($id);
    $level = getOneLevel($class->getLevelID());
    $getStudentRecords = getAllStudentInClass($id);
    if ($getStudentRecords === null) {
        header("Location:404.php");
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
    $certificate->setDate($date);
    $certificate->setIssueDate($issue_date);
    $certificate->setNo($_POST['no']);
    $certificate->setDetail($_POST['detail']);
    $certificate->setRegisterDate($curr_date);
    $certificate->setTypeMonth($_POST['type_month']);
    $certificate->setMonth($_POST['month']);
    $certificate->setYear($_POST['year']);
    $certificate->setScore($_POST['score']);
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
      }elseif ($certificate->getCertificateType() == 3) {
          header("Location:cert_outstanding.php?id=".$certificate->getCertificateID());
      }else{
         header("Location:cert_compa.php?id=".$certificate->getCertificateID());
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
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']."?id=".$id ?>" method="POST" id="classForm">
                  <input type="hidden" name="id" value="<?php echo $id ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">No</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <input type="text" name="no" class="form-control" placeholder="No" required="" value="001"> 
                        <span class="error col-md-12 no-padding"><?php echo $no_err;?></span>
                      </div>
                    </div>
                       <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Student Name</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                           <select name="student_id" data-placeholder="Please select the Student" class="form-control chosen-select" tabindex="2" required="">
                          <?php
                            foreach ($getStudentRecords as $num =>$value) {
                                  echo  "<option value='" . $getStudentRecords[$num]['student_id'] ."' >" . $getStudentRecords[$num]['student_name'] . "</option>";
                            }
                          ?>
                        </select>
                        <span class="error col-md-12 no-padding"><?php echo $register_user_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_level">Level</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <input type="hidden" name="level_id" class="form-control" placeholder="Level" value="<?php echo $class->getLevelID(); ?>" required="">
                        <input type="text" name="level" class="form-control" placeholder="Level" value="<?php echo $level->getLevelName(); ?>" required=""> 
                        <span class="error col-md-12 no-padding"><?php echo $Level_err;?></span>
                      </div>
                    </div>
                    <div class="form-group" id="type_score">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Score</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <input type="number" name="score" class="form-control" placeholder="Score" id="score" value="00" oninput="getGrade()" required="" min='0' max="100">
                        <span class="error col-md-12 no-padding"><?php echo $score_err;?></span>
                      </div>
                    </div>
                    <div class="form-group" id="type_grade">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Grade</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <input type="text" name="grade" class="form-control" placeholder="Grade" id="grade" value="F" readonly="" required="">
                        <span class="error col-md-12 no-padding"><?php echo $grade_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_date">From</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="date" id="date" class="form-control" placeholder="Date" value="<?php echo date('d/F/Y') ?>" required="">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>               
                        <span class="error col-md-12 no-padding"><?php echo $date_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_iss_date">To</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="iss_date" id="iss_date" class="form-control" placeholder="Issued Date" value="<?php echo date('d/F/Y') ?>" required="">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>               
                        <span class="error col-md-12 no-padding"><?php echo $issue_date_err;?></span>
                      </div>
                    </div> 
                    <div class="form-group" id="cur_date">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_cur_date">Current Date</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="cur_date" id="cur_date_value" class="form-control" placeholder="Current Date" value="<?php echo date('d/F/Y') ?>" required="">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div> 
                      <div class="form-group" id="type_month" style="display: none;">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label">Type Of Month</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <select name="type_month" id="type_month_value" data-placeholder="Please select the Type Month" class="form-control chosen-select" onchange="getMonthType()" required="">
                              <option value="1">Month</option>
                              <option value="2">Trimeter</option>
                              <option value="3">Semester</option>
                              <option value="4">Year</option>
                            </select>
                            <span class="error col-md-12 no-padding"><?php echo $type_month_err;?></span>
                          </div>
                      </div>
                      <div class="form-group" id="month" style="display: none;">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label">Month</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <select name="month" id="value_month" data-placeholder="Please select the Month" class="form-control chosen-select" required="" onchange="getDetail()">
                                <option value = "1">January</option>
                                <option value = "2">February</option>
                                <option value = "3">March</option>
                                <option value = "4">April</option>
                                <option value = "5">May </option>
                                <option value = "6">June</option>
                                <option value = "7">July</option>
                                <option value = "8">August</option>
                                <option value = "9">September</option>
                                <option value = "10">October</option>
                                <option value = "11">November</option>
                                <option value = "12">December</option>
                            </select>
                            <span class="error col-md-12 no-padding"><?php echo $month_err;?></span>
                          </div>
                      </div>
                      <div class="form-group" id="year" style="display: none;">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label">Year</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <input type="text" name="year" id="year_value" class="form-control" placeholder="Year" value="<?php echo date('Y');?>" required="" oninput="getDetail()">
                            <span class="error col-md-12 no-padding"><?php echo $year_err;?></span>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label" id="label_detail">Detail</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <textarea class="form-control no-resize" name="detail" id="detail" placeholder="Cartificate Detail" required="">Part-Time English Program</textarea>
                            <span class="error col-md-12 no-padding"><?php echo $detail_err;?></span>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label">Type Cartificate</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <div class="radio">
                              <label><input type="radio" name="type" value="1" checked="" onclick="getCheck(1)">Part Time Cartificate</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="type" value="2" onclick="getCheck(2)">Full Time Cartificate</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="type" value="3" onclick="getCheck(3)">OutStanding Cartificate</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="type" value="4" onclick="getCheck(4)">Compatibility Cartificate</label>
                            </div>
                            <span class="error col-md-12 no-padding"><?php echo $type_err;?></span>
                          </div>
                      </div>                                                      
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
   function getMonthType(){
    var type_month = $('#type_month_value').val();
    var html = '';
    $('#value_month').empty('');
    if(type_month == 4){
      html =  '<option value = "12">January - December</option>';
      $('#value_month').append(html);
    }else if(type_month == 3){
      html =  '<option value = "1">January - June</option>'+
              '<option value = "7">July - December</option>';
      $('#value_month').append(html);
    }else if(type_month == 2){
      html =  '<option value = "1">January - March</option>'+
              '<option value = "4">April - June</option>'+
              '<option value = "7">July - September</option>'+
              '<option value = "10">October - December</option>';
      $('#value_month').append(html);
    }else{
      html =  '<option value = "1">January</option>'+
              '<option value = "2">February</option>'+
              '<option value = "3">March</option>'+
              '<option value = "4">April</option>'+
              '<option value = "5">May </option>'+
              '<option value = "6">June</option>'+
              '<option value = "7">July</option>'+
              '<option value = "8">August</option>'+
              '<option value = "9">September</option>'+
              '<option value = "10">October</option>'+
              '<option value = "11">November</option>'+
              '<option value = "12">December</option>';
      $('#value_month').append(html);
    }
    getDetail()
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
      if($duration == 1){
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
        $('#month').css("display", "none");
        $('#type_month').css("display", "none");
        $('#year').css("display", "none");
        $('#cur_date').css("display", "block");
        $('#detail').val('Part-Time English Program');
        break;
    case 2:
        $('#year_value').val(year);
        $('#label_level').text('Level');
        $('#label_detail').text('Detail');
        $('#label_date').text('Date');
        $('#label_iss_date').text('Issued Date');
        $('#month').css("display", "none");
        $('#type_month').css("display", "none");
        $('#year').css("display", "none");
        $('#cur_date').css("display", "none");
        $('#detail').val('This certificate shows that the bearer is eligible for study in the next level.');
        break;
    case 3:
        $('#label_level').text('Level');
        $('#label_detail').text('Detail');
        $('#label_date').text('Date');
        $('#label_iss_date').text('Issued Date');
        $('#month').css("display", "block");
        $('#type_month').css("display", "block");
        $('#year').css("display", "block");
        $('#cur_date').css("display", "none");
        $('#detail').val('Is hereby recognized for outstanding '+value_type+'( '+month+' '+getYear+' ) ');
    break;
    default:
        $('#label_level').text('Level');
        $('#label_detail').text('Compatibility Mode');
        $('#label_date').text('Date');
        $('#label_iss_date').text('Issued Date');
        $('#month').css("display", "block");
        $('#type_grade').css("display", "none");
        $('#type_score').css("display", "none");
        $('#type_month').css("display", "block");
        $('#year').css("display", "block");
        $('#cur_date').css("display", "none");
        $('#detail').val('សិស្សឆ្លាត');
        break;
} 
   }
   function getDetail(){
    var monthNames = ["Month","January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                      ];
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
      if( getMonth == 1){
        month = 'January to June';
      }else{
        month = 'July to December';
      }
    }else{
      value_type = '1 Year';
      month = 'January to December';
    }
    $('#detail').val('Is hereby recognized for outstanding '+value_type+'( '+month+' '+getYear+' ) ');
   }

</script>