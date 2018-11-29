<?php

  include 'includes/header.php';
  include '../model/manageclass.php';
  include '../model/manageinvoice.php';
  include '../model/manageexammarks.php';
  include '../model/manageexam.php';
  include '../model/manageattendance.php';

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $student = getOneStudent($id);
    $StudentDate = $student->getLeaveDate();
    if($student === null) {
      header("Location:404.php");
    } else {
      $clazz = getOneClass($student->getClassID());
      $level = $clazz != null ? getOneLevel($clazz->getLevelID()) : null;
      $parents = getParents($student->getStudentID());
      $emergency = getEmergency($student->getStudentID());
      $relationship = $emergency != null ? getOneRelationship($emergency->getRelationship()) : null;
      $parent_mom = null;
      $parent_dad = null;
      $parents_address = null;
      if(count($parents) > 0) {
        foreach ($parents as $key => $value) {
          $parents_address = $parents[$key]['address'];
          if($parents[$key]['relationship'] == 1) {
            $parent_mom = new Parents;
            $parent_mom->setParentID($parents[$key]['parent_id']);
            $parent_mom->setParentName($parents[$key]['parent_name']);
            $parent_mom->setNationality($parents[$key]['nationality']);
            $parent_mom->setPosition($parents[$key]['position']);
            $parent_mom->setContactNumber($parents[$key]['contact_number']);
            $parent_mom->setRelationship($parents[$key]['relationship']);
          } else {
            $parent_dad = new Parents;
            $parent_dad->setParentID($parents[$key]['parent_id']);
            $parent_dad->setParentName($parents[$key]['parent_name']);
            $parent_dad->setNationality($parents[$key]['nationality']);
            $parent_dad->setPosition($parents[$key]['position']);
            $parent_dad->setContactNumber($parents[$key]['contact_number']);
            $parent_dad->setRelationship($parents[$key]['relationship']);
          }
        }
      } 
    }
  } else {
    header("Location:404.php");
  }  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $user_id = $user_session->getUserID();
    $action = $_POST['action'];
    $leaveFlag = $_POST['leaveFlag'];
    $date = date("Y-m-d 00:00:00", strtotime($_POST['date']));
    $month =date('m',strtotime($_POST['date']));
    $year =date('Y',strtotime($_POST['date']));
    if($action == 'leave') {
      updateLeaveFlag($user_id, $student_id,$leaveFlag,$date);
      if($_POST['chack'] == 'false' ){
          updateExamLeaveFlag($student_id,$leaveFlag,$month,$year);
      }
      if($leaveFlag == 1){
          insertStudentLeave($user_id, $student_id,$leaveFlag,$date);
      }else{
          updateStudentLeave($user_id, $student_id,$leaveFlag,$date);
      }
      header("Location:student_detail.php?id=" . $student_id);
    } elseif($action == 'delete') {
      deleteStudent($user_id, $student_id);
      deleteInvoiceStudent($user_id, $student_id);
      deleteStudentMarkID($user_id, $student_id);
      deleteAttendanceStudentID($user_id, $student_id);
      header("Location:student_list.php");
    }
  }  
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new Student
            <small>Register new student</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_student.php"> Student Management</a></li>
            <li><a href="student_list.php"> Student List</a></li>
            <li class="active">Student Detail information</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST"><!-- form start -->
            <!-- Horizontal Form -->
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h2 class="box-title">Student Detail information</h2>
                    <div class="box-tools col-md-8 col-sm-2 btn-box no-padding">                     
                      <div class="input-group pull-right"> 
                          <?php 
                          if($user_session->getRole() !== 'Teacher'){
                          ?>
                        <span>
                          <a href="edit_student.php?id=<?php echo $student->getStudentID() ?>" role="button" class="btn btn-primary btn-icon"
                             data-toggle="tooltip" title="Edit Student information.">
                            <i class="fa fa-pencil-square-o"></i>
                          </a>   
                        </span> 
                        <span>
                          <a class="btn btn-success btn-icon" href="payment.php?id=<?php echo $student->getStudentID(); ?>" role="button"
                             data-toggle="tooltip" title="Making payment for student.">
                            <i class="fa fa-credit-card"></i>
                          </a> 
                        </span>                    
                        <span>
                          <a class="btn btn-info btn-icon" href="invoice_list.php?id=<?php echo $student->getStudentID(); ?>" role="button"
                             data-toggle="tooltip" title="View all invoices for this student.">
                            <i class="fa fa-list-alt"></i>
                          </a>   
                        </span>                      
                        <span data-toggle="tooltip" title="Remove this student." data-placement="top">
                          <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $student->getStudentID(); ?>" 
                                  data-toggle="modal" data-target="#confirmDelete" type="button">
                            <i class="fa fa-trash"></i>
                          </button>
                        </span>
                        <span data-toggle="tooltip" title="<?php echo $student->getLeaveFlag() == 1 ? 'Student already leave school.' : 'Mark as leave.'; ?>" 
                              data-placement="top">
                          <button class="btn btn-icon btn-leave <?php echo $student->getLeaveFlag() == 1 ? 'btn-danger' : 'btn-warning'; ?>" 
                                      data-id="<?php echo $id; ?> " data-leave="<?php echo $student->getLeaveFlag(); ?>"
                                      data-toggle="modal" data-target="#confirmLeave" type="button">
                                <i class="fa fa-user-times"></i>
                              </button>
                        </span>
                          <?php }?>
                      </div>
                    </div>                                                          
                  </div>
                  <div class="box-body">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="box box-danger">
                        <div class="box-header with-border">
                          <h3 class="box-title">Student Information</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          </div>                           
                        </div><!-- /.box-header -->
                        <div class="box-body col-md-9 col-sm-12 col-xs-12">
                          <input type="hidden" value="<?php echo $id; ?>" name="student_id">
                          <div class="form-group">
                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Full Name :</label>
                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">
                              <?php echo $student->getStudentName(); ?>
                            </label>
                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Latin :</label>
                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $student->getLatinName(); ?>

                            </label>

                          </div>                                                           

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Date of Birth :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo dateFormat($student->getDob(), "d F Y") ?>

                            </label>

                                            

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Gender :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'Female') : 'Male'; ?>

                            </label>                      

                          </div>

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Place of Birth :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $student->getBirthPlace(); ?>

                            </label>  

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Age :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo date_diff(date_create($student->getDob()), date_create('now'))->y; ?>

                            </label>  

                          </div>

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Nationality :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $student->getNationality(); ?>

                            </label> 

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Religion :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $student->getReligion(); ?>

                            </label>                       

                          </div>

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Address :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $student->getAddress(); ?>

                            </label>

                          </div>

                        </div><!-- /.box-body -->

                        <div class="col-md-3 col-sm-12 col-xs-12">

                            <?php 

                                                if(!empty($student->getPhoto())){

                                                    $img_url = $student->getPhoto();

                                                }else{

                                                    $img_url = 'no-img.png';

                                                }

                                            ?>

                                    <img src="uploads/<?php echo $img_url;?>" width="200px" height="200px" style="padding: 10px;"/>

                        </div>

                      </div><!-- /.box -->

                    </div>



                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="box box-warning">

                        <div class="box-header with-border">

                          <h3 class="box-title">Emergency Contact</h3>

                          <div class="box-tools pull-right">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                          </div>                          

                        </div><!-- /.box-header -->

                        <div class="box-body">

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Name :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $emergency->getEmergencyName(); ?>

                            </label>

                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Relationship :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $relationship != null ? $relationship->getRelationshipName() : '<i class="text-red">Unknown</i>'; ?>

                            </label>                     

                          </div>  

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Age :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $emergency->getAge(); ?>

                            </label>                            

                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Position :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $emergency->getPosition(); ?>

                            </label>                                                  

                          </div>

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Phone :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $emergency->getContactNumber(); ?>

                            </label>                             

                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Address :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo $emergency->getAddress(); ?>

                            </label>                                                   

                          </div>                          

                        </div><!-- /.box-body -->

                      </div><!-- /.box -->

                    </div>          



                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="box box-success">

                        <div class="box-header with-border">

                          <h3 class="box-title">Level and Course of Study</h3>

                          <div class="box-tools pull-right">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                          </div>                          

                        </div><!-- /.box-header -->

                        <div class="box-body">

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Room :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php 

                                echo $clazz != null ? $clazz->getClassName() 

                                                    : '<i class="text-red">Information is missing! Please consider to update the information.</i>'; 

                              ?>

                            </label>                               

                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Time :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php 

                                echo $clazz != null ? dateFormat($clazz->getStartTime(), 'g:i A') . ' - ' . dateFormat($clazz->getEndTime(), 'g:i A')

                                                    : '<i class="text-red">Information is missing! Please consider to update the information.</i>'; 

                              ?>

                            </label>                                                    

                          </div>  

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Level :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                              <?php 

                                echo $level != null ? $level->getLevelName() 

                                                    : '<i class="text-red">Information is missing! Please consider to update the information.</i>'; 

                                ?>

                            </label>                             

                            <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Switch :</label>

                            <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                               <?php echo $student->getSwitchTime() == 1 ? 'Yes' : 'No'; ?>

                            </label>                                                   

                          </div>

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Enroll Date :</label>

                            <label class="col-md-2 col-sm-10 col-xs-10 control-label left no-style">

                              <?php echo dateFormat($student->getEnrollDate(), "d F Y") ?>

                            </label>                                                 

                          </div>                          

                        </div><!-- /.box-body -->

                      </div><!-- /.box -->

                    </div>                   



                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="box box-primary">

                        <div class="box-header with-border">

                          <h3 class="box-title">About Parents</h3>

                          <div class="box-tools pull-right">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                          </div>                          

                        </div><!-- /.box-header -->

                        <div class="box-body">

                          <?php if($parent_dad != null) {?>

                            <div class="form-group">

                              <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Father :</label>

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_dad->getParentName()) ? 'None' : $parent_dad->getParentName(); ?>

                              </label>                               

                              <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Nationality :</label> 

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_dad->getNationality()) ? 'None' : $parent_dad->getNationality(); ?>

                              </label>                                                     

                            </div>  

                            <div class="form-group">

                              <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Occupation :</label>

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_dad->getPosition()) ? 'None' : $parent_dad->getPosition(); ?>

                              </label>

                              <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Phone :</label>

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_dad->getContactNumber()) ? 'None' : $parent_dad->getContactNumber(); ?>

                              </label>                     

                            </div>

          

                          <?php } ?>

                          <?php if($parent_mom != null) {?>

                            <div class="form-group">

                              <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Mother :</label>

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_mom->getParentName()) ? 'None' : $parent_mom->getParentName(); ?>

                              </label> 

                              <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Nationality :</label>

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_mom->getNationality()) ? 'None' : $parent_mom->getNationality(); ?>

                              </label>                      

                            </div>  

                            <div class="form-group">

                              <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Occupation :</label>

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_mom->getPosition()) ? 'None' : $parent_mom->getPosition(); ?>

                              </label>

                              <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Phone :</label>

                              <label class="col-md-4 col-sm-10 col-xs-10 control-label left no-style">

                                 <?php echo empty($parent_mom->getContactNumber()) ? 'None' : $parent_mom->getContactNumber(); ?>

                              </label>                     

                            </div>                        

                          <?php } ?>    

                          <?php if($parent_mom != null || $parent_dad != null) { ?>

                            <div class="form-group">

                              <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Address :</label>

                              <label class="col-md-10 col-sm-10 col-xs-10 control-label left no-style">

                                <?php echo $parents_address; ?>

                              </label>                      

                            </div>  

                          <?php } else {

                              echo "<p>No information about the parent of this student.</p>";

                            } 

                          ?>                        
                        </div><!-- /.box-body -->
                      </div><!-- /.box -->
                    </div>                 
                  </div>
                </div>
              </div>                   
            </div><!-- /.row -->
          </form>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
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
        <h4 class="modal-title">Remove this Student?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about this ?</p>
      </div>
      <div class="modal-footer">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">
          <input type="hidden" name="student_id" value="" id="s_id" />
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
<!-- modal -->
<!--/. Modal Dialog  -->
<!-- Modal Dialog -->
<div class="modal fade" style="margin-top: 100px;" id="confirmLeave"
  role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="leaveForm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
          aria-hidden="true" id="btnClose">&times;</button>
        <h4 class="modal-title">Do you want to update this students?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about this ?</p>
         <div class="form-group" id="dateHide">
            <label>Select Date Leave</label>
            <input type="checkbox" id="isNews"  name="isNews" />
            <div class='input-group dob' id="leave_flag">
            <input type='text' name="leave_date" id="leave_date" class="form-control dob" placeholder="Date of Leave" readonly value="<?php echo date('d-M-Y');  ?>" >
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
         </div>                 
        
      </div>
      <div class="modal-footer">
          <input type="hidden" name="student_id" value="" id="l_id" />
          <input type="hidden" name="leaveFlag" value="" id="lf_id" />
          <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-hand-paper-o"></i>
            Cancel
          </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal" id="btnLeave">
            <i class="fa fa-reply"></i>
            Leave
          </button>
      </div>
      </form>
      <!--/ modal-footer -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dialog -->
</div>
<!-- modal -->
<!--/. Modal Dialog  -->
<script src="../js/chosen.jquery.js"></script>
<!-- moment with locale -->
<script src="../js/moment-with-locales.min.js"></script>
<!-- bootstrap datetime picker -->
<script src="../js/bootstrap-datetimepicker.min.js"></script>
<!-- intl tel input -->
<script src="../js/intlTelInput.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<script>  
  $(document).ready(function() {
     $('#isNews').change(function () {
        $("#leave_date").prop('disabled', this.checked);
    });
    $('#isNews').prop('checked', true);
    $('#isNews').trigger('change');
    
    $('.content').on('click', '.btn-delete', function() {

        $('#s_id').val($(this).data('id'));
    })
    .on('click', '.btn-leave', function(e) {
      if($(this).data('leave') == 1) {
            $('#l_id').val($(this).data('id'));
            $('#lf_id').val(0);
            // $('#dateHide').css('display','none');
        } else {
          $('#l_id').val($(this).data('id'));
          $('#lf_id').val(1);
          // $('#dateHide').css('display','block');
        }
    });
      $('#btnDelete').click(function() {
        var url = $('#deleteForm').attr('action');
        console.log('delete form action ' + url);
        var id = $('#s_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'student_id': id, 'action': 'delete'}, 
          success: function(data) {
            $(location).attr('href','student_list.php');      
          }
        }); 

      });
      $('#btnLeave').click(function() {
        var url = $('#leaveForm').attr('action');
        var id = $('#l_id').val();
        var date = $('#leave_date').val();
        var leaveFlag = $('#lf_id').val();
        var chack = $('#isNews')[0].checked;
        $.ajax({
          url: url,
          type: 'POST',
          data: {'student_id': id, 'action': 'leave', 'leaveFlag': leaveFlag, 'date':date ,'chack':chack}, 
          success: function(data) {
            var content = $(data).find('.content').html();
            $('.content').html(content);     
          },
          error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
          }
        }); 
      });      
  });
 $(function () {
        $('.dob').datetimepicker({
            format: 'YYYY/MM/DD',
            extraFormats: ['dd/MM/yyyy', 'dd-MM-yyyy', 'DD/MMM/YYYY'],
            allowInputToggle: true,
            ignoreReadonly: true,
//            maxDate: new Date(),
            useCurrent: true,
            showClear: true,
            showClose: true,
            showTodayButton: true
        }).on('dp.change dp.show', function (e) {
            // Revalidate the dob field

//            $('#studentForm').formValidation('revalidateField', 'dob');

        });
});

</script>



