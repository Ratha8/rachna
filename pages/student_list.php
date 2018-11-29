<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
  include '../model/manageinvoice.php';
  include '../model/manageexammarks.php';
  include '../model/manageattendance.php';

//  $list = getAllStudents();
  $classes = getAllClasses();

  if($user_session->getRole() == 'Admin'){
       $list = getAllStudents();
  }elseif ($user_session->getRole() == 'Teacher') {
      $list = getAllStudentByTeacher($user_session->getUserID());
  }else{
       $list = getAllStudentUserRole($user_session->getUserID());
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $user_id = $user_session->getUserID();
    $action = $_POST['action'];
    $leaveFlag = $_POST['leaveFlag'];
    $date = date("Y-m-d 00:00:00", strtotime($_POST['date']));
    $month =date('m',strtotime($_POST['date']));
    $year =date('Y',strtotime($_POST['date']));
    if($action == 'leave') {
      updateLeaveFlag($user_id, $student_id,$leaveFlag,$date);
      if($_POST['chack'] == 'false' ){
          updateExamLeaveFlag($student_id,$leaveFlag,$month,$year);
      } 
      if($leaveFlag == 1){
          insertStudentLeave($user_id, $student_id,$leaveFlag,$date);
      }else{
          updateStudentLeave($user_id, $student_id,$leaveFlag,$date);
      }
    }elseif($action == 'delete') {
      deleteStudent($user_id, $student_id);
      deleteInvoiceStudent($user_id, $student_id);
      deleteStudentMarkID($user_id, $student_id);
      // deleteAttendanceStudentID($user_id, $student_id);
    }

    header("Location:student_list.php");

  }     

?>



      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>

            Student List

            <small>List of all current student in school</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

            <li><a href="manage_student.php"></i>Student Management</a></li>

            <li class="active">Student List</a></li>                        

          </ol>

        </section>



        <!-- Main content -->

        <section class="content">

          <div class="row">

            <div class="col-xs-12">

              <div class="box">

                <div class="box-header">

                  <h3 class="box-title">Student List</h3>

                  <div class="box-tools col-md-2 col-sm-2 btn-box no-padding">
                      <?php 
                       if($user_session->getRole() !== 'Teacher') {
                      ?>
                    <div class="input-group pull-right">

                      <a href="register_student.php" type="button" class="btn btn-block btn-success btn-sm">

                        <i class="fa fa-user-plus"></i>&nbsp;

                        <span>Add new Student</span>

                      </a>

                    </div><?php }?>

                  </div>                  

                </div><!-- /.box-header -->

                <div class="box-body">
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="danger">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Classroom</th>
                          <th>Study Time</th>
                          <th>Date of Birth</th>
                          <th>Nationality</th>
                          <th>Enroll Date</th>
                          <th>Address</th>
                          <th class="action">Action</th>
                        </tr>
                      </thead>
                      <tbody class="text-nowrap">
                        <?php 
                          $row_num = 1;
                          foreach($list as $key => $value) {
                            $id = $list[$key]['student_id'];
                            $clazz = getOneClass($list[$key]['class_id']);
                        ?>
                        <tr>
                          <td>
                              <?php 
                              if ($user_session->getRole()=='Teacher') {
                                  echo   $row_num  ; 
                            }else{
                                echo "<a href='student_detail.php?id=" . $id . "'>" . $row_num . "</a>";
                            }
                              ?>
                              
                          </td>
                          <td> <?php 
                          if (!empty($list[$key]['photo'])) {
            echo "<img class='img-circle' src='uploads/{$list[$key]['photo']}' width='40px' height='40px'>";

        } else {

            echo "<img class='img-circle' src='uploads/no-img.png' width ='40px' height = '40px'>";

        }?>

        <?php //echo "<span><img class='img-circle' src='uploads/{$list[$key]['photo']}' width='40px' height='40px' /></span>";?> 

            <?php echo $list[$key]['student_name']; ?></td>

                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>

                          <td><?php echo $clazz != null? $clazz->getClassName() : '<i class="text-red">Unknown</i>'; ?></td>

                          <td>

                            <?php 

                              echo $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . dateFormat($clazz->getEndTime(), "g:i A") 

                                                  : '<i class="text-red">Unknown</i>'; 

                            ?>

                          </td>

                          <td><?php echo dateFormat($list[$key]['dob'], "d - M - Y"); ?></td>

                          <td><?php echo $list[$key]['nationality']; ?></td>

                          <td><?php echo dateFormat($list[$key]['enroll_date'], "d - M - Y"); ?></td>

                          <td><?php echo $list[$key]['address']; ?></td>
                          
                         
                          <td class="action">
                                 <?php 
                          if($user_session->getRole() !== 'Teacher'){
                          ?>
                            <a class="btn btn-primary btn-icon" href="edit_student.php?id=<?php echo $id; ?>" role="button" 

                               data-toggle="tooltip" title="Edit Student Information.">

                              <i class="fa fa-pencil-square-o"></i>

                            </a>

                            <a class="btn btn-info btn-icon" href="student_detail.php?id=<?php echo $id; ?>" role="button"

                               data-toggle="tooltip" title="View Student detail information.">

                              <i class="fa fa-info"></i>

                            </a>        

                            <a class="btn btn-success btn-icon" href="payment.php?id=<?php echo $id; ?>" role="button"

                               data-toggle="tooltip" title="Making payment for student.">

                              <i class="fa fa-credit-card"></i>

                            </a>

                            <span data-toggle="tooltip" title="Remove this student." data-placement="top">

                              <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id; ?>" 

                                      data-toggle="modal" data-target="#confirmDelete">

                                <i class="fa fa-trash"></i>

                              </button>

                            </span> 

                            <span data-toggle="tooltip" title="<?php echo $list[$key]['leave_flag'] == 1 ? 'Student already leave school.' : 'Mark as leave.'; ?>" data-placement="top">

                              <button class="btn btn-icon btn-leave <?php echo $list[$key]['leave_flag'] == 1 ? 'btn-danger' : 'btn-warning'; ?>" 

                                      data-id="<?php echo $id; ?> " data-leave="<?php echo $list[$key]['leave_flag'] ?>"

                                      data-toggle="modal" data-target="#confirmLeave">

                                <i class="fa fa-user-times"></i>

                              </button>

                            </span>                           
                              <?php } ?>
                          </td>

                        </tr>

                        <?php $row_num++; } ?>                          

                      </tbody>

                      <tfoot class="center text-nowrap">

                        <tr class="danger">

                          <th>No.</th>

                          <th>Name</th>

                          <th>Gender</th>

                          <th>Classroom</th>

                          <th>Study Time</th>

                          <th>Date of Birth</th>

                          <th>Nationality</th>

                          <th>Enroll Date</th>

                          <th>Address</th>

                          <th class="action">Action</th>

                        </tr>

                      </tfoot>

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





<!-- Modal Dialog -->



<div class="modal fade" style="margin-top: 100px;" id="confirmDelete"

  role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"

          aria-hidden="true" id="btnClose">&times;</button>

        <h4 class="modal-title">Remove this Student?</h4>

      </div>

      <div class="modal-body">

        <p>Are you sure about this ?</p>

      </div>

      <div class="modal-footer">



        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">

          <input type="hidden" name="student_id" value="" id="s_id" />

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

<!--/. Modal Dialog  -->



<!-- Modal Dialog -->



<div class="modal fade" style="margin-top: 100px;" id="confirmLeave"
  role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="leaveForm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
          aria-hidden="true" id="btnClose">&times;</button>
        <h4 class="modal-title">Do you want to update this students?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about this ?</p>
         <div class="form-group" id="dateHide">
            <label>Select Date Leave</label>
            <input type="checkbox" id="isNews"  name="isNews" />
            <div class='input-group dob' id="leave_flag">
            <input type='text' name="leave_date" id="leave_date" class="form-control dob" placeholder="Date of Leave" readonly value="<?php echo date('d-M-Y');  ?>" >
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
         </div>                 
        
      </div>
      <div class="modal-footer">
          <input type="hidden" name="student_id" value="" id="l_id" />
          <input type="hidden" name="leaveFlag" value="" id="lf_id" />
          <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-hand-paper-o"></i>
            Cancel
          </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnLeave">
            <i class="fa fa-reply"></i>
            Leave
          </button>
      </div>
      </form>
      <!--/ modal-footer -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dialog -->
</div>

<!-- modal -->

<!--/. Modal Dialog  -->


<script src="../js/chosen.jquery.js"></script>

<!-- moment with locale -->

<script src="../js/moment-with-locales.min.js"></script>

<!-- bootstrap datetime picker -->

<script src="../js/bootstrap-datetimepicker.min.js"></script>

<!-- intl tel input -->

<script src="../js/intlTelInput.min.js"></script>

<!-- iCheck 1.0.1 -->

<script src="../plugins/iCheck/icheck.min.js"></script>


  <script type="text/javascript">
    $(document).ready(function(){
     $('#isNews').change(function () {
        $("#leave_date").prop('disabled', this.checked);
    });
    $('#isNews').prop('checked', true);
    $('#isNews').trigger('change');
    
      $('.table-responsive').on('click', '.btn-delete', function() {
        $('#s_id').val($(this).data('id'));
      }).on('click', '.btn-leave', function(e) {
        if($(this).data('leave') == 1) {
//          e.stopPropagation();
            $('#l_id').val($(this).data('id'));
            $('#lf_id').val(0);
        } else {
          $('#l_id').val($(this).data('id'));
          $('#lf_id').val(1);
        }
      });

      $('#btnDelete').click(function() {
        var url = $('deleteForm').attr('action');
        var id = $('#s_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'student_id': id, 'action': 'delete'}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();
            $('.table-responsive').html(table);
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
  $('#btnLeave').click(function() {
        var url = $('leaveForm').attr('action');
        var date = $('#leave_date').val();
        var id = $('#l_id').val();
        var leaveFlag = $('#lf_id').val();
        var chack = $('#isNews')[0].checked;
        $.ajax({
          url: url,
          type: 'POST',
          data: {'student_id': id, 'action': 'leave', 'leaveFlag': leaveFlag,'date':date ,'chack':chack}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();
            $('.table-responsive').html(table);
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
    });
 $(function () {
        $('.dob').datetimepicker({
            format: 'YYYY/MM/DD',
            extraFormats: ['dd/MM/yyyy', 'dd-MM-yyyy', 'DD/MMM/YYYY'],
            allowInputToggle: true,
            ignoreReadonly: true,
//            maxDate: new Date(),
            useCurrent: true,
            showClear: true,
            showClose: true,
            showTodayButton: true
        }).on('dp.change dp.show', function (e) {
            // Revalidate the dob field

//            $('#studentForm').formValidation('revalidateField', 'dob');

        });
});

  </script>