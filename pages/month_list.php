<?php
  include 'includes/header.php';
  include '../model/manageclass.php';  
 
  $target_date = date('Y-m-d');
  
  $classes = getAllClasses();
   if($user_session->getRole() == 'Admin'){
    $list = getAllStudentInMonth(date('Y-m-d'));
    $new_stu = countNewStudent(date('Y-m-d'));
    $old_stu = countOldStudent(date('Y-m-d'));
    $leave_stu = countLeaveStudent(date('Y-m-d'));
    $total_leave = countTotalLeaveStudent(date('Y-m-d'));
    $total = countAllStudent(date('Y-m-d'));
  }elseif ($user_session->getRole() == 'Teacher') {
    $list = getAllStudentInMonthByTeacher(date('Y-m-d'),$user_session->getUserID());
    $new_stu = countNewStudentByTeacher(date('Y-m-d'),$user_session->getUserID());
    $old_stu = countOldStudentByTeacher(date('Y-m-d'),$user_session->getUserID());
    $leave_stu = countLeaveStudentByTeacher(date('Y-m-d'),$user_session->getUserID());
    $total_leave = countTotalLeaveStudentByTeacher(date('Y-m-d'),$user_session->getUserID());
    $total = countAllStudentByTeacher(date('Y-m-d'),$user_session->getUserID());
  }else{
    $list = getAllStudentInMonth_Rec(date('Y-m-d'),$user_session->getUserID());
    $new_stu = countNewStudentByRec(date('Y-m-d'),$user_session->getUserID());
    $old_stu = countOldStudentByRec(date('Y-m-d'),$user_session->getUserID());
    $leave_stu = countLeaveStudentByRec(date('Y-m-d'),$user_session->getUserID());
    $total_leave = countTotalLeaveStudentByRec(date('Y-m-d'),$user_session->getUserID());
    $total = countAllStudentUserRole(date('Y-m-d'),$user_session->getUserID());
  }
 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
    $target_date = date('Y-m-d', strtotime($_POST['target_date']));
    if($user_session->getRole() == 'Admin'){
    $type = $_POST['type'];
    $list = $_POST['type'] != 1 ? ($_POST['type'] != 2 ? ($_POST['type'] != 3 ? ($_POST['type'] != 4 ? getLeaveStudent($target_date) : 
            getOldStudent($target_date) ) : getNewStudent($target_date)) : getTotalLeaveStudent($target_date)) : getAllStudentInMonth($target_date);
    $total = countAllStudent($target_date);
    $new_stu = countNewStudent($target_date);
    $old_stu = countOldStudent($target_date);
    $leave_stu = countLeaveStudent($target_date);
    $total_leave = countTotalLeaveStudent($target_date);
    
    }elseif ($user_session->getRole() == 'Teacher'){
    $type = $_POST['type'];
    $list = $_POST['type'] != 1 ? ($_POST['type'] != 2 ? ($_POST['type'] != 3 ? ($_POST['type'] != 4 ? getLeaveStudentByTeacher($target_date,$user_session->getUserID()) : 
            getOldStudentByTeacher($target_date,$user_session->getUserID()) ) : getNewStudentByTeacher($target_date,$user_session->getUserID())) : getTotalLeaveStudentByTeacher($target_date,$user_session->getUserID())) : getAllStudentInMonthByTeacher($target_date,$user_session->getUserID());
    $new_stu = countNewStudentByTeacher($target_date,$user_session->getUserID());
    $old_stu = countOldStudentByTeacher($target_date,$user_session->getUserID());
    $leave_stu = countLeaveStudentByTeacher($target_date,$user_session->getUserID());
    $total_leave = countTotalLeaveStudentByTeacher($target_date,$user_session->getUserID());
    $total = countAllStudentByTeacher($target_date,$user_session->getUserID());
   
    } else {
    $type = $_POST['type'];
    $list = $_POST['type'] != 1 ? ($_POST['type'] != 2 ? ($_POST['type'] != 3 ? ($_POST['type'] != 4 ? getLeaveStudentByRec($target_date,$user_session->getUserID()) : 
            getOldStudentByRec($target_date,$user_session->getUserID()) ) : getNewStudentByRec($target_date,$user_session->getUserID())) : getTotalLeaveStudentByRec($target_date,$user_session->getUserID())) : getAllStudentInMonth_Rec($target_date,$user_session->getUserID());
    $new_stu= countNewStudentByRec($target_date,$user_session->getUserID());
    $old_stu = countOldStudentByRec($target_date,$user_session->getUserID());
    $leave_stu = countLeaveStudentByRec($target_date,$user_session->getUserID());
    $total_leave = countTotalLeaveStudentByRec($target_date,$user_session->getUserID());
    $total = countAllStudentUserRole($target_date,$user_session->getUserID());         
            
    } 
  }
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Student List
            <small>List all current students in <b id="now"><?php echo dateFormat($target_date, 'F Y') ?></b>.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_student.php"><i class="fa fa-home"></i> Student Management</a></li>
            <li class="active">Monthly Student List</li>
          </ol>
        </section>

        <!-- Main content -->
        
       
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title" id="box-date">List of Student in &nbsp; <?php echo dateFormat($target_date, 'F Y') ?></h3>
                    <div class="box-tools col-md-8 col-sm-2 btn-box no-padding">                     
                      <div class="input-group pull-right">      
                        <!-- <input type="hidden" value="<?php echo dateFormat($target_date, 'Y-m-d'); ?>" id="target-date"> -->
                        <span>
                          <a role="button" href="export_excel.php?date=<?php echo dateFormat($target_date, 'Y-m-d'); ?>" class="btn btn-success btn-icon"
                             data-toggle="tooltip" title="Export this table to excel." id="export-pdf">
                            <i class="fa fa-file-excel-o"></i>
                          </a>   
                        </span>                   
                      </div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row information form-information">
                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                      <div class="form-group">
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                          <i class="fa fa-calendar-check-o">&nbsp;Target Date</i>
                          <i class="i-split">:</i>
                        </label>
                        <div class="col-md-3 col-sm-9 col-xs-8">
                          <div class='input-group date'>
                            <input type='text' name="target_date" id="target_date" class="form-control" placeholder="Target Date"/>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>                           
                      </div> 
                    </div>
                  </div> 
                  <hr>
                  <div class="row"id="student-info">
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-light-blue">
                          <i class="fa fa-users">&nbsp;Total Student</i>
                          <i class="i-split">:</i>
                        </label>
                        <span class="col-md-2 col-sm-3 col-xs-8 control-span text-light-blue" id="info-total">
                          <?php echo "<span class='pointer' data-type='1'> " . $total . " </span>&nbsp;<i class='text-orange pointer' data-type='2'>(Leave : " . $total_leave . ")</i>"; ?>
                        </span>
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-green">
                          <i class="fa fa-user-plus">&nbsp;New</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-2 col-sm-3 col-xs-8 control-span text-green pointer" id="inf0-new" data-type='3'>
                          <?php echo $new_stu; ?>
                        </span>
                      </div>   
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-muted">
                          <i class="fa fa-user">&nbsp;Old</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-2 col-sm-3 col-xs-8 control-span text-muted pointer" id="inf0-old" data-type='4'>
                          <?php echo $old_stu; ?>
                        </span>
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-red">
                          <i class="fa fa-user-times">&nbsp;Leave</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-2 col-sm-3 col-xs-8 control-span text-red pointer" id="inf0-leave" data-type='5'>
                          <?php echo $leave_stu; ?>
                        </span>
                      </div>   
                    <div class="col-md-12">
                      <div class="box box-info">
                        <div class="box-header">
                          <h3 class="box-title">Color Note:</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          </div>
                        </div>
                        <div class="box-body">
                          <span class="text-muted col-md-2 col-sm-3 col-xs-12"><i class="fa fa-square"></i>&nbsp;Old Student</span>
                          <span class="text-Green col-md-2 col-sm-3 col-xs-12"><i class="fa fa-square"></i>&nbsp;New Student</span>
                          <span class="text-orange col-md-2 col-sm-3 col-xs-12"><i class="fa fa-square"></i>&nbsp;Leave Student</span>
                          <span class="text-red col-md-3 col-sm-3 col-xs-12"><i class="fa fa-square"></i>&nbsp;Leave Student (current month)</span>
                          <span class="text-blue col-md-12 col-sm-12 col-xs-12">
                            <i class="fa fa-info-circle text-aqua"></i>&nbsp;Total Student&nbsp;=&nbsp; 
                            <i class="text-muted">Old Student</i>&nbsp;+&nbsp; 
                            <i class="text-green">New Student</i>&nbsp;+&nbsp; 
                            <i class="text-orange">Leave Student</i>
                          </span>
                        </div>
                      </div>
                    </div> 
                  </div>    
               
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Sex</th>
                          <th>Classroom</th>
                          <th>Study Time</th>
                          <th>Start Date</th>
                          <th>Date of Birth</th>
                          <th>Age</th>
                          <th>Nationality</th>
                          <th>Currently Address</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="data-list">
                        <?php
                          // if(!is_null($list)) {
                            $row_num = 1;
                            foreach($list as $key => $value) {
                              $id = $list[$key]['student_id'];
                              $parents = getParents($id);
                              $emergency = getOneEmergency($id);
                              $clazz = getOneClass($list[$key]['class_id'])
                              // $result = count($parents);
                        ?>
                        <tr class="text-nowrap">
                          <td><?php
                          if ($user_session->getRole()=='Teacher') {
                               echo   $row_num  ;
                            }else{
                                echo "<a href='student_detail.php?id=" . $id . "'>" . $row_num . "</a>"; 
                            }
                          ?></td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo $clazz != null ? $clazz->getClassName() : '<i class="text-red">Unknown</i>' ; ?></td>
                          <td>
                            <?php 
                              echo $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . dateFormat($clazz->getEndTime(), "g:i A")
                                                  : '<i class="text-red">Unknown</i>'; 
                            ?>
                          </td>                          
                          <td><?php echo dateFormat($list[$key]['enroll_date'], "d - M - Y"); ?></td>
                          <td><?php echo dateFormat($list[$key]['dob'], "d - M - Y"); ?></td>
                          <td><?php echo date_diff(date_create($list[$key]['dob']), date_create('now'))->y; ?></td>
                          <td><?php echo $list[$key]['nationality']; ?></td>
                          <td><?php echo $list[$key]['address']; ?></td>
                          <td>
                            <?php 
                              $first_day = getTime($target_date, 'Y-m-01');
                              $last_day = getTime($target_date, 'Y-m-t');
                              $enroll_date = getTime($list[$key]['enroll_date'], 'Y-m-d');
                              $leave_date = getTime($list[$key]['leave_date'], 'Y-m-d');
                              $leave = $list[$key]['leave_date'];

                              if($enroll_date >= $first_day && $enroll_date <= $last_day && empty($leave)) {
                                echo "<i class='text-green'>New</i>";
                              } else if($enroll_date < $first_day && empty($leave)) {
                                echo "<i class='text-muted'>Old</i>";
                              } else if(!empty($leave)) {
                                if($leave_date >= $first_day && $leave_date <= $last_day) {
                                  echo "<i class='text-red'>Leave</i>";
                                } else {
                                  echo "<i class='text-orange'>Leave</i>";
                                }
                              }
                            ?></td>
                        </tr>
                        <?php $row_num++; } ?> 
                      </tbody>
                    </table>
                  </div>

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
  <!-- moment with locale -->
  <script src="../js/moment-with-locales.min.js"></script>
  <!-- bootstrap datetime picker -->
  <script src="../js/bootstrap-datetimepicker.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){     

      $('.form-information').on('blur', '#target_date', function() {
        var target_date = $(this).val();
        $.ajax({
          url: 'month_list.php',
          type: 'POST',
          data: {'target_date': target_date, 'type': 1}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();
            var info = $(data).find('#student-info').html();
            var date = $(data).find('#box-date').html();
            var target = $(data).find('#now').html();
            var t_d = $(data).find('#export-pdf').attr('href');

            $('.table-responsive').html(table);
            $('#student-info').html(info);
            $('#box-date').html(date);
            $('#now').html(target);
            $('#export-pdf').attr('href', t_d);

            $('#student-list').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false
            });
          }
        });       
      });

      $('#student-info').on('click', '.pointer', function() {
        var target_date = $('#target_date').val();
        var type = $(this).data('type');
        $.ajax({
          url: 'month_list.php',
          type: 'POST',
          data: {'target_date': target_date, 'type': type}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();
            var info = $(data).find('#student-info').html();
            var date = $(data).find('#box-date').html();
            var target = $(data).find('#now').html();

            $('.table-responsive').html(table);
            $('#student-info').html(info);
            $('#box-date').html(date);
            $('#now').html(target);

            $('#student-list').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false
            });
          }
        });       
      });

      // $('#export-pdf').click(function() {
      //   // var page = document.documentElement.innerHTML;
      //   // $(page).find('.warapper').html($('.content-wrapper').html());
      //   // var content = page;
      //   var target_date = $('#target-date').val();
      //   alert(target_date);
      //   $.ajax({
      //     url: 'generateHTML.php',
      //     type: 'POST',
      //     data: {'target_date': target_date}, 
      //     success: function(data) {
      //     },
      //     error: function(xhr, desc, err) {
      //       console.log(xhr);
      //       console.log("Details: " + desc + "\nError:" + err);
      //     }
      //   });        
      // });

    });

    function currentDate() {
      var now = new Date();
      var month = now.getMonth();
      // var day = d.getDate();
      var output = now.getFullYear();

      switch(month) {
        case 0: output = "January " + output;
                break;
        case 1: output = "February " + output;
                break;
        case 2: output = "March " + output;
                break;
        case 3: output = "April " + output;
                break;
        case 4: output = "May " + output;
                break;
        case 5: output = "June " + output;
                break;
        case 6: output = "July " + output;
                break;
        case 7: output = "August " + output;
                break;
        case 8: output = "September " + output;
                break;
        case 9: output = "October " + output;
                break;
        case 10: output = "November " + output;
                break;
        case 11: output = "December " + output;
                break;                                                                                              
      }
      return output;
    }

    $(function () {
      $('.date').datetimepicker({
        format: 'MMMM YYYY',
        allowInputToggle: true,
        ignoreReadonly: true,
        useCurrent: true,
        showClear: true,
        showClose: true,
        showTodayButton: true
      }); 

      $('.date').data("DateTimePicker").defaultDate(new Date());

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