<?php
  include 'includes/header.php';
  include '../model/manageclass.php'; 

//  $list = getAllPaidStudent(date('Y-m-d'));
   if($user_session->getRole() == 'Admin'){
       $list = getAllPaidStudent(date('Y-m-d'));
  }else{
       $list = getAllPaidRec((date('Y-m-d')),$user_session->getUserID());
  }
  $classes = getAllClasses();
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Student List
            <small>List all currently paid student</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_student.php"></i> Student Management</a></li>
            <li class="active">Paid List</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of all Paid Student</h3>
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
                          <th>Paid Date</th>
                          <th>Payment Date</th>
                          <th>Next Payment</th>
                          <th>Fee</th>
                          <th>Duration (Month)</th>
                          <th>Receptionist</th>
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
                          <td><?php echo "<a href='student_detail.php?id=" . $id . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo $clazz != null ? $clazz->getClassName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td>
                            <?php 
                              echo $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . dateFormat($clazz->getEndTime(), "g:i A")
                                                  : '<i class="text-red">Unknown</i>'; 
                            ?>
                          </td>
                          <td><?php echo dateFormat($list[$key]['paid_date'], "d - M - Y"); ?></td>
                          <td><?php echo dateFormat($list[$key]['payment_date'], "d - M - Y"); ?></td>
                          <td><?php echo dateFormat($list[$key]['expire_paymentdate'], "d - M - Y"); ?></td>
                          <td>$&nbsp;<?php echo $list[$key]['fee']; ?></td>
                          <td><?php echo $list[$key]['duration']; ?></td>
                          <td>
                            <?php
                              $user = getUserByUserID($list[$key]['register_user']); 
                              echo $user->getUserName(); 
                            ?>
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
                          <th>Paid Date</th>
                          <th>Payment Date</th>
                          <th>Next Payment Date</th>
                          <th>Fee</th>
                          <th>Duration (Month)</th>
                          <th>Receptionist</th>
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