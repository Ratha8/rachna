<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
  include '../model/manageattendance.php';
      $from = date("Y-m-01");
      $to = date("Y-m-t");
      $monthF = date('Y-M-01');
      $monthT = date('Y-M-t');
      if(isset($_POST['date'])){
        $from = date("Y-m-d",strtotime($_POST['date']));
        $to = date("Y-m-d",strtotime($_POST['to_date']));
        $monthF = $_POST['date'];
        $monthT = $_POST['to_date'];
      }
      if($user_session->getRole() == 'Admin'){
        $records = getAttendanceOnlyDate($from,$to);
      }elseif ($user_session->getRole() == 'Teacher') {
        $records = getAttendanceOnlyDateTech($from,$to);
      }else{
        $records = getAttendanceOnlyDateRe($from,$to);
      }
      // $records = getAttendanceOnlyDate($from,$to);
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
                  <h3 class="box-title" id="info-className">Student List &nbsp;|&nbsp;
                  <strong>
                    <small>Current Date:&nbsp;<span><?php echo date('d F Y'); ?></span></small>
                  </strong>
                  </h3>
                </div><!-- /.box-header -->
                    <div class="box-header">
                        <form method="POST" action="" style="padding-top: 20px">
                          <div class="form-group col-md-12">
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
                            <span class="input-group pull-right">
                              <a role="button" href="export_att.php?from_date=<?php echo $from ; ?>&to_date=<?php echo $to ; ?>" class="btn btn-success btn-icon" data-toggle="tooltip" title="" id="export-pdf" data-original-title="Export Student Attendance.">
                                <i class="fa fa-file-excel-o"></i>
                              </a> 
                            </span>
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
                          <th rowspan="3">Class</th>
                          <th rowspan="3">Teacher</th>
                          <th rowspan="3">Attendent(A)</th>
                          <th rowspan="3">Attendent(P)</th>
                          <th rowspan="3">Action</th>
                        </tr>
                      </thead>
                      <tbody id="data-list">
                        <?php 
                          
                          $row_num = 1;
                          foreach($records as $key => $value) {
                            $student = getOneStudent($records[$key]['student_id']);
                            $class = getOneClass($student->getClassID());
                            $att_a = getAttendanceByAbsentFromDate($records[$key]['student_id'],$from,$to);
                            $att_p = getAttendanceByPermessionFromDate($records[$key]['student_id'],$from,$to);
                           
                        ?>
                        <tr class="text-nowrap <?php echo $leave ?>">
                          <td>
                          <?php
                            if ($user_session->getRole()=='Teacher') {
                               echo   $row_num  ;
                            }else{
                                echo "<a href='att_view_by_student.php?id=" . $records[$key]['student_id'] . "&from=".$from."&to=".$to."'>" . $row_num . "</a>"; 
                            }
                          ?>
                          </td>
                          <td><?php echo $student->getStudentName(); ?></td>
                          <td><?php echo $class->getClassName()?></td>
                          <td><?php echo $class->getTeacherName()?></td>
                          <td style="text-align: center;"><?php echo COUNT($att_a) ?></td>
                          <td style="text-align: center;"><?php echo COUNT($att_p) ?></td>
                          <td style="text-align: center;">
                             <a class="btn btn-primary" href="att_view_by_student.php?id=<?php echo $records[$key]['student_id']; ?>&from=<?php echo $from?>&to=<?php echo $to?>" 
                              role="button" data-toggle="tooltip" title="View Student list of this class.">
                              <i class="fa fa-list" aria-hidden="true"></i>
                            </a>   
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
  </script>