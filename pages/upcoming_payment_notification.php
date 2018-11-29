<?php
  include 'includes/header.php';
  include '../model/manageclass.php';  
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  $list = unpaidNotification($user_session->getUserID());
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Upcoming payment list
            <small>List all upcoming payment of students.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php"> Payment Management</a></li>
            <li><a href="payment_invoice.php"> Payment &amp; Invoice</a></li>
            <li class="active">Upcoming Payment list</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Upcoming student payment list&nbsp;|&nbsp;
                    <strong>
                      <small>Current Date:&nbsp;<?php echo date('d F Y'); ?></small>
                    </strong>
                  </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">

                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th rowspan="2">No.</th>
                          <th rowspan="2">Name</th>
                          <th rowspan="2">Sex</th>
                          <th rowspan="2">Classroom</th>
                          <th rowspan="2">Study Time</th>
                          <!-- <th rowspan="2">Enroll Date</th> -->
                          <th rowspan="2">Address</th>
                          <th rowspan="2">Expire Date</th>
                          <th colspan="3">Emergency</th>
                          <th rowspan="2">Action</th>
                        </tr>
                        <tr class="info">
                          <th scope="col" rowspan="1">Name</th>
                          <th scope="col" rowspan="1">Relationship</th>
                          <th scope="col" rowspan="1">Phone No.</th>
                        </tr>
                      </thead>
                      <tbody id="data-list">
                        <?php 
                          $row_num = 1;
                          foreach($list as $key => $value) {
                            $id = $list[$key]['student_id'];
                            $parents = getParents($id);
                            $emergency = getOneEmergency($id);
                            $relationship = getOneRelationship($emergency->getRelationship()); 
                            $clazz = getOneClass($list[$key]['class_id']);
                            $result = count($parents);
                        ?>
                        <tr class="text-nowrap">
                          <td><?php echo "<a href='notification_alert.php?id=" . $id . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo $clazz != null ? $clazz->getClassName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td>
                            <?php 
                              echo $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . dateFormat($clazz->getEndTime(), "g:i A")
                                                  : '<i class="text-red">Unknown</i>'; 
                            ?>
                          </td>
                          <!-- <td><?php echo dateFormat($list[$key]['enroll_date'], "d - M - Y"); ?></td> -->
                          <td><?php echo $list[$key]['address']; ?></td>
                          <td><?php echo dateFormat($list[$key]['expire_paymentdate'], 'd-M-Y'); ?></td>
                          <td><?php echo $emergency->getEmergencyName(); ?></td>
                          <td><?php echo $relationship != null ? $relationship->getRelationshipName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td><?php echo $emergency->getContactNumber(); ?></td>
                          <td>
                            <a class="btn btn-default btn-icon" target="_blank" href="notification_print.php?id=<?php echo $id; ?>" 
                               role="button" data-toggle="tooltip" title="Print this payment notification.">
                              <i class="fa fa-print"></i>
                            </a>
                            <a class="btn btn-info" href="student_detail.php?id=<?php echo $id; ?>" 
                               role="button" data-toggle="tooltip" title="View detail information of this student.">
                              <i class="fa fa-info-circle"></i>
                            </a>
                            <a class="btn btn-success" href="payment.php?id=<?php echo $id; ?>" 
                               role="button" data-toggle="tooltip" title="Making payment for this student.">
                              <i class="fa fa-credit-card"></i>
                            </a>                                                        
                          </td>
                        </tr>
                        <?php $row_num++; } ?> 
                      </tbody>
                    </table>
                  </div>
                    </div>
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

  <script type="text/javascript">

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