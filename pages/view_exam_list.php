<?php
  include 'includes/header.php';
  include '../model/manageexam.php';
    
    $list = getAllExams();
 

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id'];
    $user_id = $user_session->getUserID();
    $action = $_POST['action'];
//    var_dump($_POST);
    if($action == 'delete') {
      deleteExam($user_id, $exam_id);
       deleteStudentExam($user_id, $exam_id);
      header("Location:view_exam_list.php");
    }
    
  } 

//$num_month   = DateTime::createFromFormat('!m', $exam->getExam_month());
//$show_month = $num_month->format('F');
//$month_year = $show_month.' '.$exam->getExam_year();

?>

<style>
  td{
    text-align: center !important;
  }
</style>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View All Exams
            <small>List of all current exams</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_exam.php"></i>Exam Management</a></li>
            <li class="active">Exam List</a></li>                        
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Exam List</h3>
                  <div class="box-tools col-md-2 col-sm-2 btn-box no-padding">
                    <div class="input-group pull-right">
                    <?php 
                    if($user_session->getRole() == 'Admin'){
                      ?>
                      <a href="create_exam.php" type="button" class="btn btn-block btn-success btn-sm">
                        <i class="fa fa-plus-circle"></i>&nbsp;
                        <span>Create new Exam</span>
                      </a><?php } ?>
                    </div>
                  </div>                  
                </div><!-- /.box-header -->

                <!-- /.box-header -->


                <div class="box-body">
                  <div class="table-responsive">
                    <table id="exam-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="danger">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Month/Year</th>
                          <th class="action">Option</th>
                        </tr>
                      </thead>
                      <tbody class="text-nowrap">
                      <?php 
                          $row_num = 1;
                          $num =0;
                          foreach($list as $key => $value) {
                            $id = $list[$key]['exam_id'];
                            $num = $num+1;
                            
                            $num_month   = DateTime::createFromFormat('!m', $list[$key]['exam_month']);
                            $show_month = $num_month->format('F');
                            $month_year = $show_month.' / '.$list[$key]['exam_year'];
                            // $clazz = getOneClass($list[$key]['class_id']);
                        ?>
                        <tr>
                          <td><?php echo $num; ?> </td>
                          <td><a href='#'><?php echo $list[$key]['exam_name']; ?></a></td>
                          <td><?php echo $list[$key]['description']; ?></td>
                          <td><?php echo $month_year?> </td>
                          

                          <td class="action">
                          <?php 
                            if($user_session->getRole() == 'Admin'){
                              ?>
                            <a class="btn btn-primary btn-icon" href="edit_exam.php?id=<?php echo $id; ?>" role="button" 
                               data-toggle="tooltip" title="Edit Exam Information.">
                              <i class="fa fa-pencil-square-o"></i>
                            </a>
                            <span data-toggle="tooltip" title="Remove this exam." data-placement="top">
                              <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $list[$key]['exam_id']; ?>" 
                                      data-toggle="modal" data-target="#confirmDelete">
                                <i class="fa fa-trash"></i>
                              </button>
                            </span>  <?php } ?>
                              <a class="btn btn-primary btn-icon" href="view_exam_class.php?id=<?php echo $id; ?>" role="button" 
                               data-toggle="tooltip" title="View Exam Class">
                              <i class="fa fa-info"></i>
                            </a>
                               <a class="btn btn-warning btn-icon" href="blank_score_student.php?id=<?php echo $id; ?>" role="button" 
                               data-toggle="tooltip" title="Empty Score Students">
                              <i class="fa fa-question"></i>
                            </a>                       
                          </td>
                        </tr>
                        <?php } ?>                 
                      </tbody>
                      <tfoot class="center text-nowrap">
                        <tr class="danger">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Month/Year</th>
                          <th class="action">Option</th>
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
          <input type="hidden" name="exam_id" value="" id="u_id" />
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

 <script type="text/javascript">

    $(document).ready(function(){

      $('.table-responsive').on('click', '.btn-delete', function() {
        $('#u_id').val($(this).data('id'));
      });

      $('#btnDelete').click(function() {
        var url = $('deleteForm').attr('action');
        var id = $('#u_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'exam_id': id, 'action': 'delete'}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();

            $('.table-responsive').html(table);

            $('#exam-list').DataTable({
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
      $('#exam-list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });

  </script>