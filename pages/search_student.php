<?php
  include 'includes/header.php';
  include '../model/manageclass.php';  

  $list = getAllStudents();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $param = $_POST['param'];

    if(empty($param)) {
      $list = getAllStudents();
    } else {
      $list = searchStudent($param);
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
            <li class="active">Student List</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Student's emergency contact information
                  </h3>
                  <div class="box-tools pull-right" id="reload"></div>                    
                </div><!-- /.box-header -->
                <div class="box-body">

                  <div class="table-responsive">
                    <table id="search-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th rowspan="3">No.</th>
                          <th rowspan="3">Name</th>
                          <th rowspan="3">Latin Name</th>
                          <th rowspan="3">Sex</th>
                          <th rowspan="3">Classroom</th>
                          <th rowspan="3">Study Time</th>
                          <th rowspan="3">Date of Birth</th>
                          <th rowspan="3">Nationality</th>
                          <th rowspan="3">Currently Address</th>
                          <th scope="colgroup" colspan="8">Parent</th>
                          <th colspan="3">Emergency</th>
                        </tr>
                        <tr class="info">
                          <th colspan="4">Father</th>
                          <th colspan="4">Mother</th>
                          <th scope="col" rowspan="2">Name</th>
                          <th scope="col" rowspan="2">Relationship</th>
                          <th scope="col" rowspan="2">Phone No.</th>
                        </tr>
                        <tr class="danger">
                          <th>Name</th>
                          <th>Nationality</th>
                          <th>Current Occupation</th>
                          <th>Phone No.</th>
                          <th>Name</th>
                          <th>Nationality</th>
                          <th>Current Occupation</th>
                          <th>Phone No.</th>
                        </tr>
                      </thead>
                      <tbody id="data-list">
                        <?php 
                          $row_num = 1;
                          foreach($list as $key => $value) {
                            $id = $list[$key]['student_id'];
                            $clazz = getOneClass($list[$key]['class_id']);
                            $parents = getParents($id);
                            $emergency = getOneEmergency($id);
                            $relationship = getOneRelationship($emergency->getRelationship());
                            $result = count($parents);
                        ?>
                        <tr class="text-nowrap">
                          <td><?php echo "<a href='student_detail.php?id=" . $id . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['latin_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo $clazz != null ? $clazz->getClassName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td>
                            <?php 
                              echo $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . dateFormat($clazz->getEndTime(), "g:i A")
                                                  : '<i class="text-red">Unknown</i>'; 
                            ?>
                          </td>
                          <td><?php echo dateFormat($list[$key]['dob'], "d - M - Y"); ?></td>
                          <td><?php echo $list[$key]['nationality']; ?></td>
                          <td><?php echo $list[$key]['address']; ?></td>
                          <?php 
                            if($result > 1) {
                              foreach($parents as $key => $value) {
                                echo "<td>" . $parents[$key]['parent_name'] . "</td>";
                                echo "<td>" . $parents[$key]['nationality'] . "</td>";
                                echo "<td>" . $parents[$key]['position'] . "</td>";
                                echo "<td>" . $parents[$key]['contact_number'] . "</td>";
                              }
                            } elseif($result != 0) {
                              foreach($parents as $keys => $value) {
                                if($parents[$keys]['relationship'] === 1) {
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>" . $parents[$keys]['parent_name'] . "</td>";
                                  echo "<td>" . $parents[$keys]['nationality'] . "</td>";
                                  echo "<td>" . $parents[$keys]['position'] . "</td>";
                                  echo "<td>" . $parents[$keys]['contact_number'] . "</td>";
                                } else {
                                  echo "<td>" . $parents[$keys]['parent_name'] . "</td>";
                                  echo "<td>" . $parents[$keys]['nationality'] . "</td>";
                                  echo "<td>" . $parents[$keys]['position'] . "</td>";
                                  echo "<td>" . $parents[$keys]['contact_number'] . "</td>";
                                  echo "<td>None</td>";
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
      $('#search-list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });    
    });

  </script>