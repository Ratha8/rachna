<?php
  include 'includes/header.php';
  include '../model/managecourse.php';
   if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  $course_name_err = "";
  $duration_err = "";
  $course = new Course;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course->setRegisterUser($user_session->getUserID());
    $course->setUpdateUser($user_session->getUserID());
    $course->setCourseName($_POST['course_name']);
    $course->setDuration($_POST['duration']);
    $st_err = 0;

    // course name validation
    if(empty($course->getCourseName())){
      $st_err = 1;
      $course_name_err = "The course name is required.";
    }elseif(strlen($course->getCourseName()) >= 150){
      $st_err = 1;
      $course_name_err = "The course name must be within 150 characters long.";
    }
    
    if(empty($course->getDuration())){
      $st_err = 1;
      $duration_err = "The duration is required.";
    } elseif(!containsDecimal($course->getDuration())) {
      $st_err = 1;
      $duration_err = "The duration must be a valid number.";
    }

    if($st_err === 0){
      $course_id = insertCourse($course);
      header("Location:course_list.php");
    } 
  } 
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new Course
            <small>Add new course for school</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="manage_school.php"> School Management</a></li>
            <li><a href="course_list.php"> Course List</a></li>
            <li class="active">Add Course</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Course Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" id="courseForm">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Name</label>
                      <div class="col-md-5 col-sm-10 col-xs-10">
                        <input type="text" class="form-control" name="course_name" placeholder="Course Name">
                        <span class="error col-md-12 no-padding"><?php echo $course_name_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Duration</label>
                      <div class="col-md-5 col-sm-10 col-xs-10">
                        <input type="text" class="form-control" name="duration" placeholder="Input duration">
                        <span class="error col-md-12 no-padding"><?php echo $duration_err;?></span>
                      </div>                       
                    </div>
                    <div class="box-footer">
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-info pull-right">
                          <i class="fa fa-download"></i>
                          Submit
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

<script>

  $(document).ready(function() {
    $('#courseForm')
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
      addOns: {
        mandatoryIcon: {
          icon: 'fa fa-asterisk'
        }
      },            
      fields: {
        duration: {
          validators: {
            notEmpty: {
              message: 'The duration is required'
            },
            greaterThan: {
              value: 1,
              message: 'The value cannot be 0'
            }, 
            integer: {
              message: 'The number canot contain any . or ,'                                    
            },
            numeric: {
              message: 'The value is not a number'                                    
            }
          }
        },
        course_name: {
          validators: {
            notEmpty: {
              message: 'The course name is required'
            },
            stringLength: {
              max: 150,
              trim: true,
              message: 'The course name must be between 150 characters long'
            },
            regexp: {
              regexp: "^[a-zA-Z0-9\u1780-\u17F9 ]*$",
              message: 'Please input only characters and number'
            }                                                
          }
        }
      }
    })
    .on('err.validator.fv', function(e, data) {
      data.element
          .data('fv.messages')
          // Hide all the messages
          .find('.help-block[data-fv-for="' + data.field + '"]').hide()
          // Show only message associated with current validator
          .filter('[data-fv-validator="' + data.validator + '"]').show();
    }); 
    prevalidateForm('#courseForm');
  });

</script>