<?php
  include 'includes/header.php';
  include '../model/manageclass.php';

    if($user_session->getRole() == 'Admin'){
        $list = getAllClasses();
   }else{
        $list = getAllClassesReciep($user_session->getUserID());
   }
   
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['class_id'];
    $user_id = $user_session->getUserID();
    deleteClass($user_id, $course_id);
    header("Location:class_list.php");
  }   
?>
<!-- Content Wrapper. Contains page content -->
      
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Classroom List
            <small>List of all Classrooms</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_school.php">School Management</a></li>
            <li class="active">Classroom List</li>
          </ol>
        </section>

        <!-- Main content -->

          <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-warning">
                <div class="box-header">
                  <h3 class="box-title">List of all available classrooms</h3>                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table id="class-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="danger">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Teacher</th>
                          <th>Level</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Time Shift</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $row = 1;
                          foreach($list as $key => $value) {
                            $id = $list[$key]['class_id'];
                            $level = getOneLevel($list[$key]['level_id']);
                            $techer = getUserByUserID($list[$key]['teacher_id']);
                            if(isset($techer)){
                              $techerName = $techer->getUsername();
                            }else{
                              $techerName = '<i class="text-red">Unknown</i>';
                            }
                        ?>
                        <tr class="center text-nowrap">
                          <td><?php echo  $row; ?></td>
                          <td><?php echo $list[$key]['class_name']; ?></td>
                          <td><?php echo  $techerName ?></td>
                          <td><?php echo $level != null ? $level->getLevelName() : '<i class="text-red">Unknown</i>'; ?> </td>
                          <td><?php echo dateFormat($list[$key]['start_time'], "g:i A"); ?></td>
                          <td><?php echo dateFormat($list[$key]['end_time'], "g:i A"); ?></td>
                          <td><?php echo $list[$key]['time_shift'] != 1 ? ($list[$key]['time_shift'] != 2 ? 'Evening' : 'Afternoon' ) : 'Morning'; ?></td>
                         <td>
                            <a class="btn btn-success" href="certi_register.php?id=<?php echo $id; ?>" 
                              role="button" data-toggle="tooltip" title="Output Student Certificate of this class.">
                              <i class="fa fa-file-pdf-o"></i>
                            </a>    
                          </td> 
                        </tr>
                        <?php $row++; } ?>
                      </tbody>
                      <tfoot class="center text-nowrap">
                        <tr class="danger">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Teacher</th>
                          <th>Level</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Time Shift</th>
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
        <h4 class="modal-title">Remove this classroom?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about this ?</p>
      </div>
      <div class="modal-footer">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">
          <input type="hidden" name="class_id" value="" id="c_id" />
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

<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){

      $('.table-responsive').on('click', '.btn-delete', function() {
        $('#c_id').val($(this).data('id'));
      });

      $('#btnDelete').click(function() {
        var url = $('deleteForm').attr('action');
        var id = $('#c_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'class_id': id}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();

            $('.table-responsive').html(table);

            $('#class-list').DataTable({
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
      $('#class-list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });

  </script>