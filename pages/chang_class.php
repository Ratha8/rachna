<?php
  include 'includes/header.php';
  include '../model/manageclass.php';  
//  include'../model/managestudent.php';
 
  $student = new Student; 
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $class = getOneClass($id);
    if($student === null) {
     header("Location:404.php");
    } else {
      $classes = getAllClasses();
      $getrec= getAllUsers();
       $level = getOneLevel($class->getLevelID());
       $list = getAllStudentInClass($id);
    }
  } else {
    header("Location:404.php");
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $user_id = $user_session->getUserID();
      $count = COUNT($list);
//      $count = COUNT($_POST);
//      var_dump($_POST);
   for($i=0; $i<$count; $i++ ){
     $student->setStudentID($_POST['student_id_'.$i]);
     $student->setClassID($_POST['class_id_'.$i]);
     $student->setRegisterUSer($_POST['register_user_'.$i]);
     
      updateClassStudent($student);
   }
  
    header('Location: Student_class.php');
  } 
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Student List
            
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
                  <h3 class="box-title">Change student's Class  &nbsp;
                    <strong><?php //echo $class->getClassName(); ?></strong>
                  </h3>
                  <span class="pull-right"><i class="fa fa-square" style="color:#f2dede" aria-hidden="true"></i> Leave Student</span>
                  <span class="pull-right"><i class="fa fa-square" style="color:#dff0d8" aria-hidden="true"></i> Move Class</span>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row information form-information">
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
                            
                            
                          <div class="col-md-4 col-sm-3 col-xs-8 control-span">
                             <?php echo $class->getClassName() ?>
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
                <form method="POST" id="examForm">
                    <input type="hidden" value="<?php echo $id; ?>" name="student_id">
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="info">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Sex</th>
                          <th>Date of Birth</th>
                          <th>Class</th>
                          <th>User</th>
                        </tr>
                   
                      </thead>

                      <tbody id="data-list">
                        <?php 
                           $row_num = 1;
                          foreach($list as $key => $value) {
                            $leave = $list[$key]['leave_flag'] == 1 ? 'danger' : '';
                        ?>

                        <tr class="text-nowrap <?php echo $leave ?>">
                            <td>
                          <?php 
                            if ($user_session->getRole()=='Admin') {
                               echo   $row_num  ; 
                            }
                          ?>
                          </td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo dateFormat($list[$key]['dob'], "d - M - Y"); ?></td>
                          <td>
                              <input type="hidden" value="<?php echo $list[$key]['student_id']; ?>" name="student_id_<?php echo $key?>" >
                              <select name="class_id_<?php echo $key?>" id="class_id" data-placeholder="Select Class" class="form-control chosen-select" tabindex="2">
                              <option></option>
                              <?php 
                                foreach($classes as $num => $value) {
                                  $selected = $classes[$num]['class_id'] === $class->getClassID() ? "selected" : "";
                                  echo  "<option value='" . $classes[$num]['class_id'] ."' " . $selected . ">" . $classes[$num]['class_name'] . "</option>";
                                }
                              ?>
                            </select>
                          </td>
                          <td>
                           <select name="register_user_<?php echo $key?>" data-placeholder="Please select the Receipt" class="form-control chosen-select" tabindex="2" >
                          <option></option>
                          <?php
                            foreach ($getrec as $num =>$value) {
                                $selected = $getrec[$num]['user_id'] === $list[$key]['register_user'] ? "selected" : "";
                                  echo  "<option value='" . $getrec[$num]['user_id'] ."' " . $selected . ">" . $getrec[$num]['username'] . "</option>";
                            }
                          ?>
                        </select>   
                          </td>
                        </tr>
                          <?php $row_num++;}?> 
                      </tbody>
                    </table>
                  </div>
                  <div class="box-footer pull-right">
                      <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2"> 
                         
                        <button type="submit" class="btn btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update</button>
                      </div>
                    </div>  
                </form> 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php
    include 'includes/footer.php';
?>

  <!-- bootstrap chosen -->
  <script src="../js/chosen.jquery.js"></script>

  <script type="text/javascript">
    $(function () {
      $('#student-list').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false
      });

      //bootstrap-chosen
      $('.chosen-select').chosen();
      $('.chosen-select-deselect').chosen({ allow_single_deselect: true });      
    });

  </script>

