<?php
  include 'includes/header.php';
  include '../model/manageclass.php'; 
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
//  $list = getAllStudents();
  // $classes = getAllClasses();
  if($user_session->getRole() == 'Admin'){
       $list = getAllStudents();
//     $list = countUnpaidNotification($user_session->getUserID());
  }else{
       $list = getAllStudentUserRole($user_session->getUserID());
  }
  $year = date('Y');
    $month = date('M');
    $week = (int) date('W', strtotime(date('Y-m-d')));
  $date_range = getStartAndEndDate($week, $year);
  $target_week = $date_range['week_start'];
//   if($user_session->getRole() == 'Admin'){
//       $list = getAllUnPaidStudent($target_week);
//  }else{
//        $list = getAllUnPaidUserRole($target_week,$user_session->getUserID());
//  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $user_id = $user_session->getUserID();
    $action = $_POST['action'];
    if($action == 'leave') {
      updateLeaveFlag($user_id, $student_id);
    } elseif($action == 'delete') {
      deleteStudent($user_id, $student_id);
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
            <small>Select any student to make the payment</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php"> Payment Management</a></li>
            <li class="active">Payment &amp; Invoice</li>                        
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Student List of current students</h3>                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Classroom</th>
                          <th>Study Time</th>
                          <th>Enroll Date</th>
                          <th>Next Payment</th>
                          <th>Action</th>
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
                          <td><?php echo "<a href='payment.php?id=" . $id . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo $clazz != null ? $clazz->getClassName() : '<i class="text-red">Unknown</i>' ?></td>
                          <td>
                            <?php 
                              echo $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . dateFormat($clazz->getEndTime(), "g:i A")
                                                  : '<i class="text-red">Unknown</i>'; 
                            ?>
                          </td>
                          <td><?php echo dateFormat($list[$key]['enroll_date'], "d - M - Y"); ?></td>
                          <td><?php echo dateFormat($list[$key]['expire_paymentdate'], "d - M - Y"); ?></td>
                          <td>
                              <a class="btn btn-success btn-icon" href="payment.php?id=<?php echo $id; ?>" role="button"
                                 data-toggle="tooltip" title="Making payment for student.">
                                <i class="fa fa-credit-card"></i>
                              </a>                                                                
                              <a class="btn btn-primary btn-icon" href="invoice_list.php?id=<?php echo $id; ?>" role="button" 
                                 data-toggle="tooltip" title="View all invoices for this student.">
                                <i class="fa fa-list-alt"></i>
                              </a>
                              <a class="btn btn-info btn-icon" href="student_detail.php?id=<?php echo $id; ?>" role="button"
                                 data-toggle="tooltip" title="View Student detail information.">
                                <i class="fa fa-info"></i>
                              </a>                             
                          </td>
                        </tr>
                        <?php $row_num++; } ?>                          
                      </tbody>
                      <tfoot class="center text-nowrap">
                        <tr class="success">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Classroom</th>
                          <th>Study Time</th>
                          <th>Enroll Date</th>
                          <th>Next Payment</th>
                          <th>Action</th>
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
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
          aria-hidden="true" id="btnClose">&times;</button>
        <h4 class="modal-title">Mark this students as leave?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about this ?</p>
      </div>
      <div class="modal-footer">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="leaveForm">
          <input type="hidden" name="student_id" value="" id="l_id" />
          <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-hand-paper-o"></i>
            Cancel
          </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnLeave">
            <i class="fa fa-reply"></i>
            Leave
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

  <script type="text/javascript">

    $(document).ready(function(){

      $('.table-responsive').on('click', '.btn-delete', function() {
        $('#s_id').val($(this).data('id'));
      }).on('click', '.btn-leave', function(e) {
        if($(this).data('leave') == 1) {
          e.stopPropagation();
        } else {
          $('#l_id').val($(this).data('id'));
        }
      });

      $('#btnDelete').click(function() {
        var url = $('deleteForm').attr('action');
        console.log('delete form action ' + url);
        var id = $('#s_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'student_id': id, 'action': 'delete'}, 
          success: function(data) {
            alert(data);
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
        console.log('leave form action ' + url);
        var id = $('#l_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'student_id': id, 'action': 'leave'}, 
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

  </script>