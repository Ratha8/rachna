<?php

  include 'includes/header.php';

  include '../model/manageclass.php';

   if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  $class_name_err = "";
  $teacher_name_err = "";
  $level_id_err = "";
  $start_time_err = "";
  $end_time_err = "";
  $time_shift_err = "";
  $register_user_err = "";
  $id = null;
  $form = null;
  $level = getAllLevels(); 
  $getTeacher = getAllTeachers($user_session->getUserID());
  $getrecept = getAllReceipt($user_session->getUserID());
  if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $form = getOneClass($id);

    if($form === null) {

      header("Location:404.php");

    }

  } else {

    header("Location:404.php");

  }



  $class = new Classes;



  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $getTeacher = getUserByUserID($_POST['teacher_id']);

    $start_time = empty($_POST['start_time']) ? null : dateFormat($_POST['start_time'], 'H:i');

    $end_time = empty($_POST['end_time']) ? null : dateFormat($_POST['end_time'], 'H:i');

    $class->setClassID($_POST['class_id']);

    $class->setUpdateUser($user_session->getUserID());
    if($user_session->getRole()=='Receptionist'){
        $class->setRegisterUser($user_session->getUserID());
    }  else {
        $class->setRegisterUser($_POST['register_user']);
    }

    $class->setClassName($_POST['class_name']);

    $class->setTeacher_id($_POST['teacher_id']);

    $class->setTeacherName($getTeacher->getUsername());

    $class->setLevelID($_POST['level_id']);

    $class->setStartTime($start_time);

    $class->setEndTime($end_time);   

    $class->setTimeShift($_POST['time_shift']); 

    $st_err = 0;



    // class name validation

    if(empty($class->getClassName())){

      $st_err = 1;

      $class_name_err = "Class name is required.";

    }elseif(strlen($class->getClassName()) >= 150){

      $st_err = 1;

      $class_name_err = "Class name must be within 150 characters long.";

    }



    // teacher name validation

    if(empty($class->getTeacherName())){

      $st_err = 1;

      $teacher_name_err = "Teacher name is required.";

    }elseif(strlen($class->getTeacherName()) >= 150){

      $st_err = 1;

      $teacher_name_err = "Teacher name must be within 150 characters long.";

    }    



    // level_id validation

    if(empty($class->getLevelID())){

      $st_err = 1;

      $level_id_err = "Level is required.";

    }



    // start time validation

    if(empty($class->getStartTime())){

      $st_err = 1;

      $start_time_err = "Start time is required.";

    } 



    // end time validation

    if(empty($class->getEndTime())){

      $st_err = 1;

      $end_time_err = "End time is required.";

    } 



    // time_shift validation

    if(empty($class->getTimeShift())){

      $st_err = 1;

      $time_shift_err = "Time shift is required.";

    }     

    

    if($st_err === 0){

      updateClass($class);

      header("Location:class_list.php");

    } 

  } 

?>



      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>

            Update Class Room

            <small>Update Classroom information</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

            <li><a href="manage_school.php">School Management</a></li>

            <li><a href="class_list.php">Classroom List</a></li>

            <li class="active">Edit Class</li>

          </ol>

        </section>


        <!-- Main content -->

        <section class="content">

          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">

               <!-- Horizontal Form -->

              <div class="box box-info">

                <div class="box-header with-border">

                  <h3 class="box-title">Classroom Form</h3>

                </div><!-- /.box-header -->

                <!-- form start -->

                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST" id="classForm">

                  <input type="hidden" name="class_id" value="<?php echo $form->getClassID() ?>">

                  <div class="box-body">

                    <div class="form-group">

                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Class</label>

                      <div class="col-md-5 col-sm-10 col-xs-10">

                        <input type="text" class="form-control" name="class_name" placeholder="Class Room Name" value="<?php echo $form->getClassName(); ?>"/>

                        <span class="error col-md-12 no-padding"><?php echo $class_name_err;?></span>

                      </div>

                    </div>
                    <?php
                    if($user_session->getRole() =='Admin'){?>
                       <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Receptionist</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <!--<input type="text" class="form-control" name="teacher_name" placeholder="Teacher Name">-->
                           <select name="register_user" data-placeholder="Please select the Receptionist" class="form-control chosen-select" tabindex="2">
                          <option></option>
                          <?php
                            foreach ($getrecept as $num =>$value) {
                                $selected = $form->getRegisterUSer() == $getrecept[$num]['user_id']? "selected" : "";
                                  echo  "<option value='" . $getrecept[$num]['user_id'] ."' " . $selected . ">" . $getrecept[$num]['username'] . "</option>";
                            }
                          ?>
                        </select>  
                       <!--<input type="hidden" class="form-control" name="teacher_id" readonly="readonly">-->
                        <span class="error col-md-12 no-padding"><?php echo $register_user_err;?></span>
                      </div>
                    </div>
                   <?php }
                    ?>
                    <div class="form-group">

                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Teacher</label>

                      <div class="col-md-5 col-sm-10 col-xs-10">

                        <!--<input type="text" class="form-control" name="teacher_name" placeholder="Teacher Name" value="<?php echo $form->getTeacherName(); ?>"/>-->       

                        <!--<span class="error col-md-12 no-padding"><?php echo $teacher_name_err;?></span>-->

                        

                        <select name="teacher_id" data-placeholder="Please select the Teacher" class="form-control chosen-select" tabindex="2" >

                          <option></option>

                          <?php

                          

                            foreach ($getTeacher as $key =>$value) {

                                 $selected =  $form->getTeacher_id() == $getTeacher[$key]['user_id'] ? 'selected' : '';
                                echo '<option value="'.$getTeacher[$key]['user_id'].'" '. $selected.'>'.$getTeacher[$key]['username'].'</option>';

                            }

                          ?>

                        </select>

                      </div>

                    </div>

                    <div class="form-group">

                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Level</label>

                      <div class="col-md-5 col-sm-10 col-xs-10 select">

                        <select name="level_id" data-placeholder="Please select the level" class="form-control chosen-select" tabindex="2">

                          <option></option>

                          <?php

                            foreach ($level as $key => $value) {

                              $selected =  $form->getLevelID() == $level[$key]['level_id'] ? 'selected' : '';

                              echo "<option value='" . $level[$key]['level_id'] . "' " . $selected . ">" .

                                    $level[$key]['level_name'] . "</option>";

                            }

                          ?>

                        </select>                       

                        <span class="error col-md-12 no-padding"><?php echo $level_id_err;?></span>

                      </div>

                    </div>

                    <div class="form-group">

                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Start</label>

                      <div class="col-md-5 col-sm-10 col-xs-10 datetime">

                        <div class='input-group date'>

                          <input type='text' name="start_time" class="form-control" placeholder="Start Time" value="<?php echo $form->getStartTime(); ?>"/>

                          <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>

                        </div>                    

                        <span class="error col-md-12 no-padding"><?php echo $start_time_err;?></span>

                      </div>

                    </div>   

                    <div class="form-group">

                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">End</label>

                      <div class="col-md-5 col-sm-10 col-xs-10 datetime">

                        <div class='input-group date'>

                          <input type='text' name="end_time" class="form-control" placeholder="End Time" value="<?php echo $form->getEndTime(); ?>"/>

                          <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>

                        </div>                    

                        <span class="error col-md-12 no-padding"><?php echo $end_time_err;?></span>

                      </div>

                    </div>     

                    <div class="form-group">

                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Shift</label>            

                      <div class="col-md-5 col-sm-10 xs-10">

                        <div class="radio">

                          <label class="no-padding">

                            <input id="morning" name="time_shift" type="radio" class="flat-blue" value="1" <?php echo $form->getTimeShift() == 1 ? 'checked' : '' ?>> 

                            Morning

                          </label>

                        </div>

                        <div class="radio">

                          <label class="no-padding">

                            <input id="afternoon" name="time_shift" type="radio" class="flat-yellow" value="2" <?php echo $form->getTimeShift() == 2 ? 'checked' : '' ?>> 

                            Afternoon

                          </label>

                        </div>

                        <div class="radio">

                          <label class="no-padding">

                            <input id="evening" name="time_shift" type="radio" class="flat-red" value="3" <?php echo $form->getTimeShift() == 3 ? 'checked' : '' ?>> 

                            Evening

                          </label>

                        </div> 

                        <div class="col-md-12 col-md-offset-1">

                          <span class="error"><?php echo $time_shift_err;?></span>  

                        </div>                         

                      </div>                                                                                             

                    </div>                                                      

                    <div class="box-footer">

                      <div class="col-md-6 col-sm-12 col-xs-12">

                        <button type="submit" class="btn btn-info pull-right">

                          <i class="fa fa-refresh"></i>

                          Update

                        </button>

                      </div>

                    </div><!-- /.box-footer -->                    

                  </div><!-- /.box-body -->

                </form>

              </div><!-- /.box -->

            </div>

          </div><!-- /.row -->

        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->

<?php

  include 'includes/footer.php';

?>



<script src="../js/chosen.jquery.js"></script>

<script src="../js/moment-with-locales.min.js"></script>

<script src="../js/bootstrap-datetimepicker.min.js"></script>



<script>



  $(document).ready(function() {



    var TIME_PATTERN = /^(0?[1-9]|1[012])(:[0-5]\d) [APap][mM]$/;



    $('#classForm')

      // IMPORTANT: You must declare .on('init.field.fv')

      // before calling .formValidation(options)

      .on('init.field.fv', function(e, data) {

      // data.fv      --> The FormValidation instance

      // data.field   --> The field name

      // data.element --> The field element



      var $parent = data.element.parents('.form-group'),

          $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + data.field + '"]');



          // You can retrieve the icon element by

          // $icon = data.element.data('fv.icon');



          $icon.on('click.clearing', function() {

          // Check if the field is valid or not via the icon class

          if ($icon.hasClass('fa-times')) {

            // Clear the field

            data.fv.resetField(data.element);

          }

      });

    })        

    .formValidation({

      framework: 'bootstrap',

      icon: {

        valid: 'fa fa-check',

        invalid: 'fa fa-times',

        validating: 'fa fa-refresh'

      },

      excluded: ':disabled',

      addOns: {

        mandatoryIcon: {

          icon: 'fa fa-asterisk'

        }

      },            

      fields: {

        class_name: {

          validators: {

            notEmpty: {

              message: 'The class name is required'

            },

            stringLength: {

              max: 25,

              trim: true,

              message: 'The class name must be between 25 characters long'

            }                                    

          }

        },

        level_id: {

          validators: {

            notEmpty: {

              message: 'Level is require'

            }                

          }

        },

        start_time: {

          validators: {

            notEmpty: {

              message: 'Start time is require'

            },

            // regexp: {

            //   regexp: TIME_PATTERN,

            //   message: 'The start time must be in this format 00:00 PM/AM'

            // },

            callback: {

              message: 'The start time must be earlier then the end one',

              callback: function(value, validator, $field) {

                var endTime = validator.getFieldElements('end_time').val();

                if (endTime === '' || !TIME_PATTERN.test(endTime)) {

                  return true;

                }



                // var startHour    = parseInt(value.split(':')[0], 10),

                //     startMinutes = parseInt(value.split(':')[1], 10),

                //     startPeriod  = value.split(' ')[1],

                //     endHour      = parseInt(endTime.split(':')[0], 10),

                //     endMinutes   = parseInt(endTime.split(':')[1], 10),

                //     endPeriod    = endTime.split(' ')[1]; 



                var start_time = new Date(Date.parse(moment().format('Y/MM/D ') + value)),

                    end_time = new Date(Date.parse(moment().format('Y/MM/D ') + endTime));                  



                // if (startHour < endHour || (startHour == endHour && startMinutes < endMinutes)) {

                //   // The end time is also valid

                //   // So, we need to update its status

                //   validator.updateStatus('end_time', validator.STATUS_VALID, 'callback');

                //   return true;

                // }



                if(start_time < end_time) {

                  return true;

                }

                return false;

              }                          

            }

          }

        },

        end_time: {

          validators: {

            notEmpty: {

              message: 'End time is require'

            },

            // regexp: {

            //   regexp: TIME_PATTERN,

            //   message: 'The start time must be in this format 00:00 PM/AM'

            // },

            callback: {

              message: 'The end time must be later then the start one',

              callback: function(value, validator, $field) {

                var startTime = validator.getFieldElements('start_time').val();

                if (startTime == '' || !TIME_PATTERN.test(startTime)) {

                  return true;

                }



                // var startHour    = parseInt(startTime.split(':')[0], 10),

                //     startMinutes = parseInt(startTime.split(':')[1], 10),

                //     startPeriod  = startTime.split(' ')[1],

                //     endHour      = parseInt(value.split(':')[0], 10),

                //     endMinutes   = parseInt(value.split(':')[1], 10),

                //     endPeriod    = value.split(' ')[1]; 



                var start_time = new Date(Date.parse(moment().format('Y/MM/D ') + startTime)),

                    end_time = new Date(Date.parse(moment().format('Y/MM/D ') + value));



                // if (endHour > startHour || (endHour == startHour && endMinutes > startMinutes)) {

                //   // The start time is also valid

                //   // So, we need to update its status

                //   validator.updateStatus('start_time', validator.STATUS_VALID, 'callback');

                //   return true;

                // }



                if(start_time < end_time) {

                  return true;

                }

                return false;

              }

            }                          

          }

        },

        time_shift: {

          validators: {

            notEmpty: {

              message: 'Time shift is require'

            }                

          }

        },                  

        teacher_name: {

          validators: {

            notEmpty: {

              message: 'The teacher name is required'

            },

            regexp: {

              regexp: "^[a-zA-Z0-9\u1780-\u17F9 ]*$",

              message: 'Please input only characters and number'

            },               

            stringLength: {

              max: 100,

              trim: true,

              message: 'The teacher name must be between 100 characters long'

            }                                    

          }

        }

      }

    })

    .find('input[name="time_shift"]')

    // Called when the radios/checkboxes are changed

    .on('ifChanged', function(e) {

      // Get the field name

      var field = $(this).attr('name');

      $('#classForm').formValidation('revalidateField', field);

    })

    .end();

    prevalidateForm('#classForm');

  });



  $(function () {

    $('.date').datetimepicker({

      format: 'hh:mm a',

      allowInputToggle: true

    })

    .on('dp.change dp.show', function(e) {

      // Revalidate the time field

      $('#classForm').formValidation('revalidateField', 'start_time');

      $('#classForm').formValidation('revalidateField', 'end_time');

    });



    //Flat Yellow color scheme for iCheck

    $('input[type="checkbox"].flat-yellow, input[type="radio"].flat-yellow').iCheck({

      checkboxClass: 'icheckbox_flat-yellow',

      radioClass: 'iradio_flat-yellow'

    });    



    //Flat Blue color scheme for iCheck

    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({

      checkboxClass: 'icheckbox_flat-blue',

      radioClass: 'iradio_flat-blue'

    });       



    //Flat Red color scheme for iCheck

    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({

      checkboxClass: 'icheckbox_flat-red',

      radioClass: 'iradio_flat-red'

    }); 



    $('.chosen-select').chosen();

  });



</script>