<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
  
      if($user_session->getRole() == 'Admin'){
       $classes = getAllClasses();
  }elseif ($user_session->getRole() == 'Teacher') {
      $classes = getAllClassesUserRole($user_session->getUserID());
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
            Student List
            <small>Total student in this class is <b id="CountStudent"><?php echo count($list) ?></b></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_school.php"> School Management</a></li>
            <li><a href="class_list.php"> Classroom List</a></li>
            <li class="active">Student List</li>
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
                          <div class="col-md-4 col-sm-3 col-xs-8 no-padding">
                            <select name="class_id" id="class_id" data-placeholder="Select Class" class="form-control chosen-select" tabindex="2">
                              <option></option>
                              <?php 
                                foreach($classes as $key => $value) {
                                  $selected = $classes[$key]['class_id'] === $class->getClassID() ? "selected" : "";
                                  echo  "<option value='" . $classes[$key]['class_id'] . 
                                        "' data-level='" . $classes[$key]['level_id'] . 
                                        "' data-time='" . dateFormat($classes[$key]['start_time'],'g:i A') . 
                                        "' " . $selected . ">" . $classes[$key]['class_name'] . "</option>";
                                }
                              ?>
                            </select>                          
                          </div> 
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
                    <div class="box-body">
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th rowspan="3">No.</th>
                          <th rowspan="3">Name</th>
                          <th rowspan="3">Sex</th>
                          <th rowspan="3">Start Date</th>
                          <th rowspan="3">Price/1 Month</th>
                          <th rowspan="3">Date of Birth</th>
                          <th rowspan="3">Age</th>
                          <th rowspan="3">Place of Birth</th>
                          <th rowspan="3">Nationality</th>
                          <th rowspan="3">Religion</th>
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
                        <tr class="warning">
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
                            $parents = getParents($list[$key]['student_id']);
                            $emergency = getOneEmergency($list[$key]['student_id']);
                            $result = count($parents);
                            $relationship = getOneRelationship($emergency->getRelationship());
                            $leave = $list[$key]['leave_flag'] == 1 ? 'danger' : '';
                           
                        ?>
                        <tr class="text-nowrap <?php echo $leave ?>">
                    
                          <td>
                          <?php
                            if ($user_session->getRole()=='Teacher') {
                               echo   $row_num  ;
                            }else{
                                echo "<a href='student_detail.php?id=" . $list[$key]['student_id'] . "'>" . $row_num . "</a>"; 
                            }
                          
                          ?>
                          </td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo dateFormat($list[$key]['enroll_date'], "d - M - Y"); ?></td>
                          <td>$ <?php echo $list[$key]['fee']; ?></td>
                          <td><?php echo dateFormat($list[$key]['dob'], "d - M - Y"); ?></td>
                          <td><?php echo date_diff(date_create($list[$key]['dob']), date_create('now'))->y; ?></td>
                          <td><?php echo $list[$key]['birth_place']; ?></td>
                          <td><?php echo $list[$key]['nationality']; ?></td>
                          <td><?php echo $list[$key]['religion']; ?></td>
                          <td><?php echo $list[$key]['address']; ?></td>
                       
                          <?php 
                          if (!empty($result)){
                            if($result > 1) {
                              foreach($parents as $key => $value) {
                                  
                                echo "<td>" . $parents[$key]['parent_name'] . "</td>";
                                echo "<td>" . $parents[$key]['nationality'] . "</td>";
                                echo "<td>" . $parents[$key]['position'] . "</td>";
                                echo "<td>" . $parents[$key]['contact_number'] . "</td>";
                              }
                            } else {
                              foreach($parents as $key => $value) {
                                if($parents[$key]['relationship'] === 1) {
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";                                  
                                  echo "<td>" . $parents[$key]['parent_name'] . "</td>";
                                  echo "<td>" . $parents[$key]['nationality'] . "</td>";
                                  echo "<td>" . $parents[$key]['position'] . "</td>";
                                  echo "<td>" . $parents[$key]['contact_number'] . "</td>";
                                } else {
                                  echo "<td>" . $parents[$key]['parent_name'] . "</td>";
                                  echo "<td>" . $parents[$key]['nationality'] . "</td>";
                                  echo "<td>" . $parents[$key]['position'] . "</td>";
                                  echo "<td>" . $parents[$key]['contact_number'] . "</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>";
                                  echo "<td>None</td>"; 
                                }
                              }
                            }
                          }else {
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
                          <td><?php echo $relationship != null ? $relationship->getRelationshipName() : '<i class="text-red">Unknown</i>' ?></td>
                          <td><?php echo $emergency->getContactNumber(); ?></td>
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

  <script type="text/javascript">

    $(document).ready(function(){  
        

      $('.form-information').on('change', '#class_id', function() {
        var id = $(this).val();
        $.ajax({
          url: 'room.php?id=' + id,
          type: 'get',
          success: function(data) {
            var table = $(data).find('.table-responsive').html();
            var information = $(data).find('.form-information').html();
            var teacher = $(information).find('#info-teacher').html();
            var level = $(information).find('#info-level').html();
            var time = $(information).find('#info-time').html(); 
            var ClassName = $(information).find('#info-className').html();
            var CountStudent = $(information).find('#CountStudent').html();

            
            $('.table-responsive').html(table);
            $('#info-teacher').html(teacher);
            $('#info-level').html(level);
            $('#info-time').html(time);
            $('#info-className').html(ClassName);
            $('#CountStudent').html(CountStudent);


            $('.chosen-select').chosen();
            $('#student-list').DataTable({
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
      $('#student-list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });

      //bootstrap-chosen
      $('.chosen-select').chosen();
      $('.chosen-select-deselect').chosen({ allow_single_deselect: true });      
    });

  </script>