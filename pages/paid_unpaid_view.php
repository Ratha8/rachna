<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
  
  if($user_session->getRole() == 'Admin'){
       $classes = getAllClasses();
  }elseif ($user_session->getRole() == 'Teacher') {
      header("Location:404.php");
  }else{
       $classes = getAllClassesReciep($user_session->getUserID());
  }
//   $classes = getAllClasses();
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $class = getOneClass($id);
    if($class === null) {
      header("Location:404.php");
    } else {
      $level = getOneLevel($class->getLevelID());
      $list = getAllStudentInClass($id);
      $year = date('Y');
      if(isset($_POST['date'])){
        $year = $_POST['date'];
      }
    }
  } else {
    header("Location:404.php");
  }
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="row information form-information">
        <section class="content-header">
          <h1>
            Paid and Unpaid Student List
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="paid_unpaid_class_list.php"> Paid and Unpaid Class List</a></li>
            <li class="active">Paid and UnpaidStudent List</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title" id="info-className">Student List of Class <?php echo $class->getClassName(); ?>&nbsp;|&nbsp;
                    <strong>
                      <small>Current Date:&nbsp;<span><?php echo date('d F Y'); ?></span></small>
                    </strong>
                  </h3>
                  <span class="pull-right" style="text-align:center;color:#F10533;padding: 5px;"><i class="fa fa-times" aria-hidden="true"></i> : UnPaid</span>
                  <span class="pull-right" style="text-align:center;color:#09B992;padding: 5px;"><i class="fa fa-check" aria-hidden="true"></i> : Paid</span>
                  <span class="pull-right" style="text-align:center;color:#3c8dbc;padding: 5px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"> : Leave</i></span>
                </div><!-- /.box-header -->
                <div class="box-body">
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                          <i class="fa fa-user">&nbsp;Teacher</i>
                          <i class="i-split">:</i>
                        </label>
                        <span class="col-md-4 col-sm-3 col-xs-8 control-span" id="info-teacher">
                          <?php echo $class->getTeacherName(); ?>
                        </span>
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                          <i class="fa fa-graduation-cap">&nbsp;Level</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-4 col-sm-3 col-xs-8 control-span" id="info-level">
                          <?php echo $level != null ? $level->getLevelName() : '<i class="text-red">Unknown</i>'; ?>
                        </span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                        <div class="form-group">
                          <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                            <i class="fa fa-home">&nbsp;Room</i>
                            <i class="i-split">:</i>
                          </label>
                          <span class="col-md-4 col-sm-3 col-xs-8 control-span" id="info-teacher">
                            <?php echo $class->getClassName(); ?>
                          </span>
                          <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                            <i class="fa fa-clock-o">&nbsp;Time:</i>&nbsp;
                            <i class="i-split">:</i>
                          </label> 
                          <span class="col-md-4 col-sm-3 col-xs-8 control-span" id="info-time">
                            <?php echo dateFormat($class->getStartTime(), "g:i A") . ' - ' . dateFormat($class->getEndTime(), "g:i A");  ?>
                          </span>
                        </div> 
                      </div>
                    </div>    
                     <div class="box-header">
                        <form method="POST" action="" style="padding-top: 20px">
                          <div class="form-group col-md-12">
                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Select Date:</label>
                            <div class="col-md-3 col-sm-10 col-xs-10 select">
                              <div class="input-group date">
                                  <input type="text" name="date" id="target_date" class="form-control" placeholder="Select Date" value="<?php echo $year?>">
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
                          <th rowspan="3">Jan</th>
                          <th rowspan="3">Feb</th>
                          <th rowspan="3">Mar</th>
                          <th rowspan="3">Apr</th>
                          <th rowspan="3">May</th>
                          <th rowspan="3">Jun</th>
                          <th rowspan="3">Jul</th>
                          <th rowspan="3">Aug</th>
                          <th rowspan="3">Sep</th>
                          <th rowspan="3">Oct</th>
                          <th rowspan="3">Nov</th>
                          <th rowspan="3">Dec</th>
                        </tr>
                      </thead>
                      <tbody id="data-list">
                        <?php 
                          $row_num = 1;
                          foreach($list as $key => $value) {
                            $leave = $list[$key]['leave_flag'] == 1 ? 'danger' : '';
                            $listInvoice =getPaymentByYear($year,$list[$key]['student_id']);
                            $listLeaveStudents = getAllStudentLeaveByID($year,$list[$key]['student_id']);
                        ?>
                        <tr class="text-nowrap <?php echo $leave ?>">
                          <td>
                          <?php
                            if ($user_session->getRole()=='Teacher') {
                               echo   $row_num  ;
                            }else{
                                echo "<a href='invoice_list_paid.php?id=" . $list[$key]['student_id'] . "'>" . $row_num . "</a>"; 
                            }
                          ?>
                          </td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td style="text-align: center;"><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'F') : 'M'; ?></td>
                          <?php 
                            $rr = array();
                            $rr_leave = array();
                            for($j=0;$j<COUNT($listInvoice);$j++){
                              $i = $listInvoice[$j]['month'];
                              for($k=0;$k<$listInvoice[$j]['duration'];$k++){
                                  $rr[] = $i+$k;
                              }
                            }
                            for($z=0;$z<COUNT($listLeaveStudents);$z++){
                              $i = $listLeaveStudents[$z]['leave_month'];
                              if($listLeaveStudents[$z]['duration'] >= 0){
                                for($k=0;$k<$listLeaveStudents[$z]['duration'];$k++){
                                  $rr_leave[] = $i+$k;
                                }
                              }else{
                                $duration = 12 - $listLeaveStudents[$z]['leave_month'];
                                for($k=0;$k<=$duration;$k++){
                                  $rr_leave[] = $i+$k;
                                }
                              }
                            }
                            for ($i=1; $i <= 12 ; $i++) {
                              $td = '<td style="text-align:center;color:#F10533"><i class="fa fa-times" aria-hidden="true"></i></td>';
                              foreach ($rr_leave as $keys => $values) {
                                if($i == $values){
                                  $td = '<td style="text-align:center;color:#3c8dbc"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></td>';
                                }
                              }
                              foreach ($rr as $rr_key => $rr_value) {
                                 if($i == $rr_value){
                                    $td = '<td style="text-align:center;color:#09B992"><i class="fa fa-check" aria-hidden="true"></i></td>';
                                    }
                                  }
                              echo $td;
                            }
                          ?>
                        </tr>
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
  <!-- bootstrap chosen -->
  <script src="../js/chosen.jquery.js"></script>
  <!-- moment with locale -->
  <script src="../js/moment-with-locales.min.js"></script>
  <!-- bootstrap datetime picker -->
  <script src="../js/bootstrap-datetimepicker.min.js"></script>
  
  <script type="text/javascript">
    $(function () {
      // $('#student-list').DataTable({
      //   "paging": true,
      //   "lengthChange": true,
      //   "searching": true,
      //   "ordering": true,
      //   "info": true,
      //   "autoWidth": false
      // });

       $('.date').datetimepicker({
        format: 'YYYY',
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