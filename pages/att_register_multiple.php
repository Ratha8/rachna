<?php
  include 'includes/header.php';
  include '../model/manageattendance.php';
  include '../model/manageclass.php';

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
    if ($getStudentRecords === null) {
        header("Location:404.php");
      }
    

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$get_count = $_POST['count'];
  	$attDate = isset($_POST["att_date"]) ? (!empty($_POST["att_date"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['att_date']))) : "") : "";
  	for($i=0; $i<$get_count; $i++){
	    $attendance->setUpdateUser($user_session->getUserID());
	    $attendance->setRegisterUser($user_session->getUserID());
	    $attendance->setApproveBy($user_session->getUserID());
	    $attendance->setStudentID($_POST['student_id'.$i]);
	    $attendance->setAttendanceType($_POST['att_type'.$i]);
	    $attendance->setReason($_POST['reason'.$i]);
	    $attendance->setAttendanceDate($attDate);	
	    $id = $_POST['class_id'.$i];

	    insertAttendance($attendance,$id);
      	header("Location:att_view_multiple.php");

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
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="classForm">
                  <!-- <input type="hidden" name="id" value="<?php echo $id ?>"> -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-md-2 col-sm-2 col-xs-2 control-label">Attentance Date</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="att_date" id="att_date" class="form-control" placeholder="Attendance Date" value="">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>               
                        <span class="error col-md-12 no-padding"><?php echo $att_date_err;?></span>
                      </div>
                    </div>  
                    <div class="container">
                    <div class="row clearfix">
                      <div class="col-md-12 column">
                          <table class="table table-bordered table-hover" id="tab_logic">
                              <thead>
                                  <tr >
                                      <th class="text-center">
                                          #
                                      </th>
                                      <th class="text-center">
                                          Class
                                      </th>
                                      <th class="text-center">
                                          Student Name
                                      </th>
                                      <th class="text-center">
                                          Attentance Type
                                      </th>
                                      <th class="text-center">
                                          Reason
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr id='addr0'>
                                      <td>1<input name='count' value='1' type='hidden'></td>
                                      <td class="form-information"><select name="class_id0" id="class_id" data-placeholder="Select Class" class="form-control chosen-select" tabindex="2">
                                        <?php 
                                          foreach($classes as $key => $value) {
                                            echo  "<option value='" . $classes[$key]['class_id'] . 
                                                  "' data-level='" . $classes[$key]['level_id'] . 
                                                  "' data-time='" . dateFormat($classes[$key]['start_time'],'g:i A') . 
                                                  "' >" . $classes[$key]['class_name'] . "</option>";

                                            $opt_class .= "<option value='" . $classes[$key]['class_id'] . 
                                                  "' data-level='" . $classes[$key]['level_id'] . 
                                                  "' data-time='" . dateFormat($classes[$key]['start_time'],'g:i A') . 
                                                  "' >" . $classes[$key]['class_name'] . "</option>";
                                          }
                                        ?>
                                      </select> </td>
                                      <td>
                                       <select name="student_id0" id="student_id" data-placeholder="Please select the Student" class="form-control chosen-select" tabindex="2">
                                       <?php
                                        foreach ($getStudentRecords as $num =>$value) {
                                            echo  "<option value='" . $getStudentRecords[$num]['student_id'] ."' >" . $getStudentRecords[$num]['student_name'] . "</option>";

                                            $opt_student .= "<option value='" . $getStudentRecords[$num]['student_id'] ."' >" . $getStudentRecords[$num]['student_name'] . "</option>";
                                          }
                                          ?>
                                        </select>
                                      </td>
                                      <td><select name="att_type0" data-placeholder="Please select the Type" class="form-control chosen-select" tabindex="2">
                                        <option value="0">Absent (A)</option>
                                        <option value="1">Permission (P)</option>
                                      </select>
                                      </td>
                                      <td><textarea class="form-control no-resize" name="reason0" placeholder="Reason"></textarea></td>
                                  </tr>
                                  <tr id='addr1'></tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-default">Delete Row</a>
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
$(document).ready(function(){  
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
    });
var i=1;
    $("#add_row").click(function(){
      var cols = '';
      var opt_class = "<?php echo $opt_class; ?>";
      var opt_student = "<?php echo $opt_student; ?>";
      cols += "<td>"+ (i+1) +"<input name='count' value='"+ (i+1) +"' type='hidden'></td>";
      cols += '<td class="form-information"><select name="class_id' + i + '" id="class_id_' + i + '" data-placeholder="Select Class" class="form-control chosen-select" tabindex="2">'+opt_class;

      cols += '</select></td>';
      cols += '<td><select id="student_id_'+ i +'" name="student_id' + i + '" data-placeholder="Please select the Student" class="form-control chosen-select" tabindex="2">'+opt_student;

      cols += '</select></td>';
      cols += '<td><select name="att_type' + i + '" data-placeholder="Please select the Type" class="form-control chosen-select" tabindex="2"><option value="0">Absent (A)</option><option value="1">Permission (P)</option></select></td>';
      cols += '<td><textarea class="form-control no-resize" name="reason' + i + '" placeholder="Reason"></textarea></td>';

      $('#addr'+i).html(cols);

      $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
      
      $('.form-information').on('change', '#class_id_'+i, function() {
      	var obj = $(this);
        var id = $(this).val();
        var st_id = obj[0].id.replace("class_id_", "");
        $.ajax({
          url: 'getStudent.php?id=' + id,
          type: 'get',
          success: function(data) {
          	$('#student_id_'+st_id).empty();
          	var result = JSON.parse(data);
          	for(var j=0; j < result.length; j++){
          		$('#student_id_'+st_id).append('<option value=' + result[j].id + '>' + result[j].name + '</option>');
          	}
          }
        });       
      });

      i++; 
  	});
     $("#delete_row").click(function(){
         if(i>1){
         $("#addr"+(i-1)).html('');
         i--;
         }
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