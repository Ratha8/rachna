<?php
include 'includes/header.php';
include '../model/manageattendance.php';
include '../model/manageclass.php';
include '../model/managerank.php';

$student_id_err = "";
$att_date_err = "";
$aprove_by_err = "";
$att_type_err = "";
$reason_err = "";
$register_user_err = ""; 


if($user_session->getRole() == 'Admin'){
	$classes = getAllClasses();
}elseif ($user_session->getRole() == 'Teacher') {
	$classes = getAllClassesUserRole($user_session->getUserID());
}else{
	$classes = getAllClassesReciep($user_session->getUserID());
}

$attendance = new Attendance;
$user = getAllUsers();
$getStudentRecords = getAllStudentInClass(1);
$ID = $_GET['id'];
if ($getStudentRecords === null) {
	header("Location:404.php");
}elseif ($ID === null) {
	header("Location:404.php");
}
$exam = getOneField($ID);
$year = $exam->getYear();
if($year === null){
	header("Location:404.php");
}
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Stuents Report
            <small>Output Report for student</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Student Report</li>
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
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="classForm">
                  <!-- <input type="hidden" name="id" value="<?php echo $id ?>"> -->
                  <div class="box-body form-information">
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Report Type</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                      	<select name="report_type" id="report_type" class="form-control chosen-select" tabindex="1">
                        	<option value="1">January-March</option>
                        	<option value="2">April-June</option>
                        	<option value="3">July-September</option>
                        	<option value="4">October-December</option>
                        	<option value="5">January-June</option>
                        	<option value="6">July-December</option>
                        	<option value="7">January-December</option>
                        </select>
                      </div>
                    </div> 
                    <div class="form-group">
                    	<label class="col-md-2 col-sm-2 col-xs-2 control-label">Class</label>
                    	<div class="col-md-5 col-sm-10 col-xs-10 select">
                    		<select name="class_id" id="class_id" data-placeholder="Select Class" class="form-control chosen-select" tabindex="2">
                    			<?php 
                    			foreach($classes as $key => $value) {
                    				echo  "<option value='" . $classes[$key]['class_id'] .
                    					"' data-level='" . $classes[$key]['level_id'] . 
                                        "' data-time='" . dateFormat($classes[$key]['start_time'],'g:i A') . 
                                        "' >" . $classes[$key]['class_name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Student</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <select name="student_id" id="student_id" data-placeholder="Please select the Student" class="form-control chosen-select" tabindex="2">
                                       <?php
                                        foreach ($getStudentRecords as $num =>$value) {
                                            echo  "<option value='" . $getStudentRecords[$num]['student_id'] ."' >" . $getStudentRecords[$num]['student_name'] . "</option>";
                                          }
                                          ?>
                                        </select>
                      </div>
                    </div>                                                  
                    <div class="box-footer">
                      <div class="col-md-6 col-sm-12 col-xs-12" id="link">
                      	<a href="register_student_reports.php?student=1&month=1&year=<?php echo $year ?>" class="">Get Student Report</a>
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
$(document).ready(function(){
		var studentID = $('#student_id').val();
      	var month = $('#report_type').val();
      	var year = '<?php echo $year ?>';
      	$('#link').html('<a href="register_student_reports.php?student='+studentID+'&month='+month+'&year='+year+'">SUBMIT</a>');
      $('.form-information').on('change', '#class_id', function() {
        var id = $(this).val();
        $.ajax({
          url: 'getStudent.php?id=' + id,
          type: 'get',
          success: function(data) {
          	var $student_id = $('#student_id');
          	$student_id.empty();
          	var result = JSON.parse(data);
          	for(var i=0; i < result.length; i++){
          		$student_id.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
          	}
            
          }
        });       
      });
      $('.form-information').on('change', '#class_id', function() {
      	var studentID = $('#student_id').val();
      	var month = $('#report_type').val();
      	var year = '<?php echo $year ?>';
      	$('#link').html('<a href="register_student_reports.php?student='+studentID+'&month='+month+'&year='+year+'">SUBMIT</a>');
      });
      $('.form-information').on('change', '#student_id', function() {
      	var studentID = $(this).val();
      	var month = $('#report_type').val();
      	var year = '<?php echo $year ?>';
      	$('#link').html('<a href="register_student_reports.php?student='+studentID+'&month='+month+'&year='+year+'">SUBMIT</a>');
      });
      $('.form-information').on('change', '#report_type', function() {
      	var month = $(this).val();
      	var studentID = $('#student_id').val();
      	var year = '<?php echo $year ?>' ;
      	$('#link').html('<a href="register_student_reports.php?student='+studentID+'&month='+month+'&year='+year+'">SUBMIT</a>');
      });
    });

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