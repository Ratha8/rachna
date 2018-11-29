<?php
  include 'includes/header.php';
  include '../model/manageattendance.php';
  $student_id_err = "";
  $att_date_err = "";
  $aprove_by_err = "";
  $att_type_err = "";
  $reason_err = "";
  $register_user_err = ""; 

    $user = getAllUsers();
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $getAttByID = getAttendanceByID($id);
      $getStudentRecords = getAllStudentInClass($getAttByID['room_id']);
      if ($getAttByID === null) {
          header("Location:404.php");
        }
    } else {
        header("Location:404.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
      $attendance = new Attendance;
      $id = $_POST['id'];
      $attendance->setID($id);
      $attendance->setRegisterUser($user_session->getUserID());
      $attendance->setStudentID($_POST['student_id']);
      $attendance->setAttendanceType($_POST['att_type']);
      $attendance->setReason($_POST['reason']);
      $attDate = isset($_POST["att_date"]) ? (!empty($_POST["att_date"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['att_date']))) : "") : "";
      $attendance->setAttendanceDate($attDate);
      $st_err = 0;
      if(empty($attendance->getStudentID())){
        $st_err = 1;
        $student_id_err = "Student name is required.";
      }

      if(empty($attendance->getAttendanceDate())){
        $st_err = 1;
        $att_date_err = "Attendance Date is required.";
      }
      if($attendance->getAttendanceType() == 1){
        if(empty($attendance->getReason())){
          $st_err = 1;
          $reason_err = "Attendance Reason is required.";
        }
      }
      if($st_err === 0){
        updateAttendance($attendance);
        header("Location:att_update.php?id=".$id);
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
            <li><a href="att_class_list.php"> Classroom List</a></li>
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
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Student</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                           <select name="student_id" data-placeholder="Please select the Student" class="form-control chosen-select" tabindex="2">
                          <?php
                            foreach ($getStudentRecords as $num =>$value) {
                                $selected = $getAttByID['student_id'] == $getStudentRecords[$num]['student_id']? "selected" : "";
                                echo  "<option value='" . $getStudentRecords[$num]['student_id'] ."' ".$selected.">" . $getStudentRecords[$num]['student_name'] . "</option>";
                            }
                          ?>
                        </select>
                        <span class="error col-md-12 no-padding"><?php echo $register_user_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Attendance Type</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                          <select name="att_type" data-placeholder="Please select the Type" class="form-control chosen-select" tabindex="2">
                          <option value="0" <?php echo $getAttByID['att_type'] == 0 ? "selected" : ""?>>Absent (A)</option>
                          <option value="1" <?php echo $getAttByID['att_type'] == 1 ? "selected" : ""?>>Permission (P)</option>
                        </select>
                        <span class="error col-md-12 no-padding"><?php echo $att_type_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Attentance Date</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">

                        <div class='input-group date'>
                            <input type='text' name="att_date" id="att_date" class="form-control" placeholder="Attendance Date" value="<?php echo dateFormat($getAttByID['att_date'], "d/F/Y") ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>               
                        <span class="error col-md-12 no-padding"><?php echo $att_date_err;?></span>
                      </div>
                    </div> 
                     <div class="form-group">
                        <label class="col-md-2 col-sm-2 col-xs-2 control-label">Reason</label>
                          <div class="col-md-5 col-sm-10 col-xs-10">
                            <textarea class="form-control no-resize" name="reason" placeholder="Reason"><?php echo $getAttByID['reason'] ?></textarea>
                            <span class="error col-md-12 no-padding"><?php echo $reason_err;?></span>
                          </div>
                      </div>                                                      
                    <div class="box-footer">
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-info pull-right">
                          <i class="fa fa-download"></i>
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

</script>