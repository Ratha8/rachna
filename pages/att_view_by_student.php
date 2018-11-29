<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
  include '../model/manageattendance.php';
  if($user_session->getRole() == 'Admin'){
    $classes = getAllClasses();
  }elseif ($user_session->getRole() == 'Teacher') {
      $classes = getAllClassesUserRole($user_session->getUserID());
  }else{
       $classes = getAllClassesReciep($user_session->getUserID());
  }
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $student = getOneStudent($id);
    if($student === null) {
      header("Location:404.php");
    } else {
      $from = date('Y-m-01');
      $to = date('Y-m-t');
      $monthF = date('Y-M-01');
      $monthT = date('Y-M-t');
      if(isset($_GET['from'])){
        $from = date("Y-m-d",strtotime($_GET['from']));
        $to = date("Y-m-d",strtotime($_GET['to']));
        $monthF = date("Y-M-d",strtotime($_GET['from']));
        $monthT = date("Y-M-d",strtotime($_GET['to']));
      }
      $records = getAttendanceByStudentFromDate($id,$from,$to);
    }
  } else {
    header("Location:404.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['submit'] == 'Go'){
      if(isset($_POST['date'])){
        $id = $_POST['id'];
         $from = date("Y-m-d",strtotime($_POST['date']));
        $to = date("Y-m-d",strtotime($_POST['to_date']));
        $monthF = $_POST['date'];
        $monthT = $_POST['to_date'];
      }
      $records = getAttendanceByStudentFromDate($id,$from,$to);
    }else{
      $id = $_POST['attendance_id'];
      $action = $_POST['action'];
      if($action == 'delete'){
        deleteAttendance($user_id, $id);
      }
    }
    
  }
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="row information form-information">
      <section class="content-header">
        <h1>
          Student Attendance List
        </h1>
        <ol class="breadcrumb">
          <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="att_class_list.php"> Students Attendance</a></li>
          <li> Attendance List</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-success">
              <div class="box-header">
                  <h3 class="box-title" id="info-className">Student Name <?php echo $student->getStudentName(); ?>&nbsp;|&nbsp; 
                  <strong>
                    <small>Current Date:&nbsp;<span><?php echo date('d F Y'); ?></span></small>
                  </strong>
                  </h3>
                </div><!-- /.box-header -->
             
                    <div class="box-header">
                        <form method="POST" action="" style="padding-top: 20px">
                          <div class="form-group col-md-12">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">From</label>
                            <div class="col-md-3 col-sm-10 col-xs-10 select">
                              <div class="input-group date">
                                  <input type="text" name="date" id="from_date" class="form-control" placeholder="From Date" 
                                  value="<?php echo $monthF; ?>">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>                      
                            </div>
                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">To</label>
                            <div class="col-md-3 col-sm-10 col-xs-10 select">
                              <div class="input-group date">
                                  <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" 
                                  value="<?php echo $monthT; ?>">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>                      
                            </div>
                            <div class="col-md-2">
                              <input class="btn btn-primary" name="submit" value="Go" type="submit">  
                            </div>
                          </div>
                        </form>
                    </div>   
                    <div class="box-body">
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th rowspan="3">No.</th>
                          <th rowspan="3">Name</th>
                          <th rowspan="3">Sex</th>
                          <th rowspan="3">Date</th>
                          <th rowspan="3">Attendent</th>
                          <th rowspan="3">Reason</th>
                          <th rowspan="3">Action</th>
                        </tr>
                      </thead>
                      <tbody id="data-list">
                        <?php 
                          $row_num = 1;
                          foreach($records as $key => $value) {
                        ?>
                        <tr class="text-nowrap <?php echo $leave ?>">
                          <td>
                          <?php
                            if ($user_session->getRole()=='Teacher') {
                               echo   $row_num  ;
                            }else{
                                echo "<a href='student_detail.php?id=" . $records[$key]['student_id'] . "'>" . $row_num . "</a>"; 
                            }
                          ?>
                          </td>
                          <td><?php echo $student->getStudentName(); ?></td>
                          <td><?php echo $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td style="text-align: center;"><?php echo date('d-F-Y', strtotime($value['att_date'])); ?></td>
                          <td style="text-align: center;"><?php echo $value['att_type'] == 0 ? 'A' : 'P' ?></td>
                          <td style="text-align: center;"><?php echo $value['reason']?></td>
                          <td style="text-align: center;">
                             <a class="btn btn-primary" href="att_update.php?id=<?php echo $value['att_id']; ?>" 
                              role="button" data-toggle="tooltip" title="View Student list of this class.">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <span data-toggle="tooltip" title="Remove this student." data-placement="top">
                              <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $records[$key]['att_id']; ?>" 
                                      data-toggle="modal" data-target="#confirmDelete" type="button">
                                <i class="fa fa-trash"></i>
                              </button>
                            </span>    
                          </td>
                        <?php $row_num++;}?>  
                      </tbody>
                    </table>
                  </div>
                   </div>  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          <!-- /.row -->
        </section><!-- /.content -->
       
       </div>
      </div> 
      
      <!-- /.content-wrapper -->
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
          <h4 class="modal-title">Delete Student Attendance</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this ?</p>
        </div>
        <div class="modal-footer">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">
            <input type="hidden" name="att_id" value="" id="att_id" />
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
  <!-- moment with locale -->
  <script src="../js/moment-with-locales.min.js"></script>
  <!-- bootstrap datetime picker -->
  <script src="../js/bootstrap-datetimepicker.min.js"></script>  
  <!-- bootstrap chosen -->
  <script src="../js/chosen.jquery.js"></script> 

  <script type="text/javascript">
    $(function () { 
       $('.date').datetimepicker({
        format: 'YYYY-MMM-DD',
        allowInputToggle: true,
        ignoreReadonly: true,
        useCurrent: true,
        showClear: true,
        showClose: true,
        showTodayButton: true
      });
      //bootstrap-chosen
      $('.chosen-select').chosen();
      $('.chosen-select-deselect').chosen({ allow_single_deselect: true });      
    });
    $(document).ready(function() {
      $('.content').on('click', '.btn-delete', function() {
          $('#att_id').val($(this).data('id'));
      });
      $('#btnDelete').click(function() {
        var url = $('#deleteForm').attr('action');
        var typeID = <?php echo $id ?>;
        var typefrom = <?php echo $from ?>;
        var typeto = <?php echo $to ?>;
        var id = $('#att_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'attendance_id': id, 'action': 'delete'}, 
          success: function(data) {
            $(location).attr('href','att_view_by_student.php?id='+typeID+'&from='+typefrom+'&to='+typeto);
          }
        }); 
      });
    });
  </script>