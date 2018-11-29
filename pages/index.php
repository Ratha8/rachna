<?php
include 'includes/header.php';
include '../model/manageclass.php';

$list = getAllStudents();
$list1 = getAllClasses();
$list2 = getAllClassesUserRole($user_session->getUserID());
$list3 = getAllClassesReciep($user_session->getUserID());

$user = getAllUsers();
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
            Task List
            <small>List of all tasks in the system</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Task List</li>
        </ol><br>
    </section>
    <?php
    if ($user_session->getRole() == 'Teacher'){
        $row = 1;
        foreach($list2 as $key => $value) {
                            $id = $list2[$key]['class_id'];
//                            $level = getOneLevel($list2[$key]['level_id']);
                        ?>
         <div class="col-lgs-3 col-xs-6 pointer">
                    <!-- small box -->
                    <div class="small-box bg-blue class-box">
                        <div class="inner">
                            <h4><?php echo $list2[$key]['class_name']; ?></h4>
                            <p><?php echo $list2[$key]['teacher_name']; ?></p>
                        </div>
                        <div class="icon icon-fix">
                            <i class="fa fa-credit-card"></i>
                        </div>
                         <a href="room.php?id=<?php echo $id; ?>" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>
                    </div> 
                </div><?php $row++; } ?>
        <?php
    } elseif ($user_session->getRole() == 'Receptionist') {
        ?>
        <section class="content">

            <div class="row">

                <div class="col-lgs-3 col-xs-6 pointer">
                    <!-- small box -->
                    <div class="small-box bg-green class-box">
                        <div class="inner">
                            <h3>Payment</h3>
                            <p>Payment Management</p>
                        </div>
                        <div class="icon icon-fix">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <a href="manage_payment.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>
                    </div> 
                </div><!-- ./col -->
                <div class="col-lgs-3 col-xs-6 pointer">
                    <!-- small box -->

                    <div class="small-box bg-aqua class-box">
                        <div class="inner">
                            <h3>School</h3>
                            <p>School Management</p>
                        </div>
                        <div class="icon icon-fix">
                            <i class="fa fa-building-o"></i>
                        </div>
                        <a href="manage_school.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>
                    </div> 
                </div><!-- ./col -->

                <?php
//                            $row = 1;
//                          foreach($list3 as $key => $value) {
//                            $id = $list3[$key]['student_id'];
                ?>
                <div class="col-lgs-3 col-xs-6 pointer">
                    <!-- small box -->

                    <div class="small-box bg-blue class-box">
                        <div class="inner">
                            <h3>Student</h3>
                            <p>Student Management</p>
                        </div>
                        <div class="icon icon-fix">
                            <i class="fa fa-graduation-cap"></i>
                        </div>

                        <a href="manage_student.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>

                    </div>
                </div>  <?php //$row++; }  ?><!-- ./col -->
                <?php
                if ($user_session->getRole() == 'Admin') {
                    ?>
                    <div class="col-lgs-3 col-xs-6 pointer">
                        <!-- small box -->
                        <div class="small-box bg-red class-box">
                            <div class="inner">
                                <h3>User</h3>
                                <p>User Management</p>
                            </div>
                            <div class="icon icon-fix">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="manage_user.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->            
                <?php } ?>
            </div><!-- /.row -->


            <!-- <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Student List</h3>
                  </div>
                  <div class="box-body">

                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-hover">
                        <thead class="center text-nowrap">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Time Shift</th>
                            <th>Classroom</th>
                            <th>D.O.B</th>
                            <th>Birth Place</th>
                            <th>Religion</th>
                            <th>Nationality</th>
                            <th>Address</th>
                            <th>Enroll Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="center text-nowrap">
            <?php
            foreach ($list as $key => $value) {
                ?>
                                  <tr>
                                    <td><?php echo "<a href='student_detail.php?id=" . $list[$key]['student_id'] . "'>" . $list[$key]['student_id'] . "</a>"; ?></td>
                                    <td><?php echo $list[$key]['student_name']; ?></td>
                                    <td><?php echo $list[$key]['gender']; ?></td>
                                    <td><?php echo $list[$key]['time_shift']; ?></td>
                                    <td><?php echo $list[$key]['class_id']; ?></td>
                                    <td><?php echo dateFormat($list[$key]['dob'], "-"); ?></td>
                                    <td><?php echo $list[$key]['birth_place']; ?></td>
                                    <td><?php echo $list[$key]['religion']; ?></td>
                                    <td><?php echo $list[$key]['nationality']; ?></td>
                                    <td><?php echo $list[$key]['address']; ?></td>
                                    <td><?php echo dateFormat($list[$key]['enroll_date'], "-"); ?></td>
                                    <td>
                                      <form action="delete_class.php" method="post">
                                        <a class="btn btn-primary" href="edit_class.php?id=<?php echo $list[$key]['student_id']; ?>" role="button">
                                          <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <input type="hidden" name="class_id" value="<?php echo $list[$key]['student_id']; ?>">
                                        <button class="btn btn-danger">
                                          <i class="fa fa-trash"></i>
                                        </button>
                                      </form>
                                    </td>
                                  </tr>
            <?php } ?>                          
                        </tbody>
                        <tfoot class="center text-nowrap">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Time Shift</th>
                            <th>Classroom</th>
                            <th>D.O.B</th>
                            <th>Birth Place</th>
                            <th>Religion</th>
                            <th>Nationality</th>
                            <th>Address</th>
                            <th>Enroll Date</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

        </section>

        <?php
    } else {
        ?>
        <section class="content">

            <div class="row">
                <div class="col-lgs-3 col-xs-6 pointer">
                    <!-- small box -->
                    <div class="small-box bg-green class-box">
                        <div class="inner">
                            <h3>Payment</h3>
                            <p>Payment Management</p>
                        </div>
                        <div class="icon icon-fix">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <a href="manage_payment.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>
                    </div> 
                </div><!-- ./col -->
                <div class="col-lgs-3 col-xs-6 pointer">
                    <!-- small box -->

                    <div class="small-box bg-aqua class-box">
                        <div class="inner">
                            <h3>School</h3>
                            <p>School Management</p>
                        </div>
                        <div class="icon icon-fix">
                            <i class="fa fa-building-o"></i>
                        </div>
                        <a href="manage_school.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>
                    </div> 
                </div><!-- ./col -->
                <div class="col-lgs-3 col-xs-6 pointer">
                    <!-- small box -->

                    <div class="small-box bg-blue class-box">
                        <div class="inner">
                            <h3>Student</h3>
                            <p>Student Management</p>
                        </div>
                        <div class="icon icon-fix">
                            <i class="fa fa-graduation-cap"></i>
                        </div>

                        <a href="manage_student.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>

                    </div>
                </div><!-- ./col -->
                <?php
                if ($user_session->getRole() == 'Admin') {
                    ?>
                    <div class="col-lgs-3 col-xs-6 pointer">
                        <!-- small box -->
                        <div class="small-box bg-red class-box">
                            <div class="inner">
                                <h3>User</h3>
                                <p>User Management</p>
                            </div>
                            <div class="icon icon-fix">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="manage_user.php" class="small-box-footer">More Action <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->            
                <?php } ?>
            </div><!-- /.row -->


            <!-- <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Student List</h3>
                  </div>
                  <div class="box-body">

                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-hover">
                        <thead class="center text-nowrap">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Time Shift</th>
                            <th>Classroom</th>
                            <th>D.O.B</th>
                            <th>Birth Place</th>
                            <th>Religion</th>
                            <th>Nationality</th>
                            <th>Address</th>
                            <th>Enroll Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="center text-nowrap">
            <?php
            foreach ($list as $key => $value) {
                ?>
                                  <tr>
                                    <td><?php echo "<a href='student_detail.php?id=" . $list[$key]['student_id'] . "'>" . $list[$key]['student_id'] . "</a>"; ?></td>
                                    <td><?php echo $list[$key]['student_name']; ?></td>
                                    <td><?php echo $list[$key]['gender']; ?></td>
                                    <td><?php echo $list[$key]['time_shift']; ?></td>
                                    <td><?php echo $list[$key]['class_id']; ?></td>
                                    <td><?php echo dateFormat($list[$key]['dob'], "-"); ?></td>
                                    <td><?php echo $list[$key]['birth_place']; ?></td>
                                    <td><?php echo $list[$key]['religion']; ?></td>
                                    <td><?php echo $list[$key]['nationality']; ?></td>
                                    <td><?php echo $list[$key]['address']; ?></td>
                                    <td><?php echo dateFormat($list[$key]['enroll_date'], "-"); ?></td>
                                    <td>
                                      <form action="delete_class.php" method="post">
                                        <a class="btn btn-primary" href="edit_class.php?id=<?php echo $list[$key]['student_id']; ?>" role="button">
                                          <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <input type="hidden" name="class_id" value="<?php echo $list[$key]['student_id']; ?>">
                                        <button class="btn btn-danger">
                                          <i class="fa fa-trash"></i>
                                        </button>
                                      </form>
                                    </td>
                                  </tr>
            <?php } ?>                          
                        </tbody>
                        <tfoot class="center text-nowrap">
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Time Shift</th>
                            <th>Classroom</th>
                            <th>D.O.B</th>
                            <th>Birth Place</th>
                            <th>Religion</th>
                            <th>Nationality</th>
                            <th>Address</th>
                            <th>Enroll Date</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

        </section>
        <?php
    }
    ?>


</div><!-- /.content-wrapper -->

<?php
include 'includes/footer.php';
?>

<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $(".content-wrapper").on("click", ".class-box", function (e) {
            if ($(e.target).is("a, button"))
                return;
            location.href = $(this).find("a").attr("href");
        });
    });

</script>
