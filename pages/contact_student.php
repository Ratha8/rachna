<?php
  include 'includes/header.php';
  include '../model/manageclass.php';  

  // $list = getAllStudents();

    if($user_session->getRole() == 'Admin'){

       $list = getAllStudents();
  }elseif ($user_session->getRole() == 'Teacher') {
      $list = getAllStudentByTeacher($user_session->getUserID());
  }else{
       $list = getAllStudentUserRole($user_session->getUserID());
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $param = $_POST['param'];

    if(empty($param)) {
      $list = getAllStudents();
    } else {
      $list = searchContact($param);
    }
  }
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Student List
            <small>List all students and contact information.</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_student.php"> Student Management</a></li>
            <li class="active">Student contact information</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Student's emergency contact information
                    <!-- <strong>
                      <small>Current Date:&nbsp;<span id="now"></span></small>
                    </strong> -->
                  </h3>
                  <div class="box-tools pull-right" id="reload"></div> 
                </div><!-- /.box-header -->
                <div class="box-body">
     
                  <div class="row">
                    <div class="col-md-12">


                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th rowspan="3">No.</th>
                          <th rowspan="3">Name</th>
                          <th rowspan="3">Latin Name</th>
                          <th rowspan="3">Sex</th>
                          <th rowspan="3">Classroom</th>
                          <th rowspan="3">Currently Address</th>
                          <th scope="colgroup" colspan="6">Parent</th>
                          <th colspan="3">Emergency</th>
                        </tr>
                        <tr class="info">
                          <th colspan="3">Father</th>
                          <th colspan="3">Mother</th>
                          <th scope="col" rowspan="2">Name</th>
                          <th scope="col" rowspan="2">Relationship</th>
                          <th scope="col" rowspan="2">Phone No.</th>
                        </tr>
                        <tr class="danger">
                          <th>Name</th>
                          <th>Nationality</th>
                          <th>Phone No.</th>
                          <th>Name</th>
                          <th>Nationality</th>
                          <th>Phone No.</th>
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
                          <td><?php echo "<a href='student_detail.php?id=" . $id . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['latin_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo $clazz != null ? $clazz->getClassName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td><?php echo $list[$key]['address']; ?></td>
                          <?php 
                            if($result > 1) {
                              foreach($parents as $keys => $value) {
                                echo "<td>" . $parents[$keys]['parent_name'] . "</td>";
                                echo "<td>" . $parents[$keys]['nationality'] . "</td>";
                                echo "<td>" . $parents[$keys]['contact_number'] . "</td>";
                              }
                            } elseif($result != 0) {
                              foreach($parents as $keys => $value) {
                                if($parents[$keys]['relationship'] === 1) {
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>" . $parents[$keys]['parent_name'] . "</td>";
                                  echo "<td>" . $parents[$keys]['nationality'] . "</td>";
                                  echo "<td>" . $parents[$keys]['contact_number'] . "</td>";
                                } else {
                                  echo "<td>" . $parents[$keys]['parent_name'] . "</td>";
                                  echo "<td>" . $parents[$keys]['nationality'] . "</td>";
                                  echo "<td>" . $parents[$keys]['contact_number'] . "</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>"; 
                                }
                              }
                            } else {
                              echo "<td>None</td>";
                              echo "<td>None</td>";
                              echo "<td>None</td>";
                              echo "<td>None</td>"; 
                              echo "<td>None</td>";
                              echo "<td>None</td>";
                            }
                          ?>
                          <td><?php echo $emergency->getEmergencyName(); ?></td>
                          <td><?php echo $relationship != null ? $relationship->getRelationshipName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td><?php echo $emergency->getContactNumber(); ?></td>
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