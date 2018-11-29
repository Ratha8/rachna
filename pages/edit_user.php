<?php
  include 'includes/header.php';
  
  if($user_session->getRole() !== 'Admin') {
    header("Location:403.php");
  }

$username_err = "";
  $password_err = "";
  $re_password_err = "";
  $role_err = "";
 
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = getUserByUserID($id);
    if($user === null) {
      header("Location:404.php");
    } 
  }

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $temp_user = getUserByUserID($_POST['user_id']);
    $user->setUpdateUser($user_session->getUserID());
    $user->setUserID($_POST['user_id']);
    $user->setRole($_POST['role']);    
    !empty($_POST['username']) ? $user->setUsername($_POST['username']) : $user->setUsername($temp_user->getUsername());
    !empty($_POST['password']) ? $user->setPassword($_POST['password']) : $user->setPassword('');
    $re_password = !empty($_POST['re_password']) ? $_POST['re_password'] : '';

    $st_err = 0;

    if(isset($_POST['change_name'])) {
      // username validation
      if(empty($user->getUsername())){
        $st_err = 1;
        $username_err = "User name is required.";
      }elseif(!preg_match("%^[A-Za-z0-9-_@.]{5,30}$%", $user->getUsername())){
        $st_err = 1;
        $username_err = "User name must be contain only characters between a-Z or 0-9 and symbol _.@";
      }elseif(strlen($user->getUsername()) > 50 || strlen($user->getUsername()) < 5){
        $st_err = 1;
        $username_err = "User name must be between 5 and 50 characters long.";
      }elseif (!empty(getUserByUsername($user->getUsername()))) {
        $st_err = 1;
        $username_err = "This user name already exist.";
      }
    }

    // role validation
    if(empty($user->getRole())){
      $st_err = 1;
      $role_err = "Position is required.";
    }

    if(isset($_POST['change_password'])) {
      // password validation
      if(empty($user->getPassword())){
        $st_err = 1;
        $password_err = "Password is required.";
      } elseif (strlen($user->getPassword()) > 100 || strlen($user->getPassword()) < 8) {
        $st_err = 1;
        $password_err = "Password must be between 5-100 characters";      
      }

      // re password validation
      if(empty($re_password)){
        $st_err = 1;
        $re_password_err = "Confirm password is required.";
      } elseif ($re_password != $user->getPassword()) {
        $st_err = 1;
        $re_password_err = "Password does not match.";      
      }
    }

    if($st_err === 0){
      $password = !empty($user->getPassword()) ? password_hash($user->getPassword(), PASSWORD_BCRYPT) : $temp_user->getPassword();
      $user->setPassword($password);
      updateUser($user);
      $user_session = getUserByUserID($user_session->getUserID());
      $_SESSION["user"] = serialize($user_session);
      header("Location:user_list.php");
    } 
  } 
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit User information
            <small>Add new user to manage school</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage.php"> User Management</a></li>
            <li><a href="user_list.php"> User List</a></li>
            <li class="active">Register User</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">User Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $user->getUserID(); ?>" method="POST" id="userForm">
                  <div class="box-body">
                    <input type="hidden" name="user_id" value="<?php echo $user->getUserID(); ?>">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Username</label>
                          <div class="col-md-10 col-sm-10 col-xs-10">
                            <input type="text" class="form-control" name="username" placeholder="Enter your userame" disabled
                                   value="<?php echo $user->getUsername(); ?>">
                            <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                              <div class="progress-bar progress-bar-success progress-bar-striped active"style="width: 100%"></div>
                            </div> 
                            <span class="error col-md-12 no-padding"><?php echo $username_err;?></span>                                                             
                          </div>                          
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-2 col-sm-2 col-xs-2 control-label no-padding-hori">Change</label>
                          <div class="col-md-2 col-sm-10 col-xs-10">
                            <label class="checkbox-inline no-padding-left">
                              <input name="change_name" type="checkbox" class="flat-red" value="1" id="change_name">
                            </label>
                          </div>                             
                        </div>
                      </div>                                
                    </div>                
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Position</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <select name="role" data-placeholder="Select Position" class="form-control chosen-select" tabindex="2">
                          <option></option>
                          
                          <option value="Receptionist" <?php echo $user->getRole() == 'Receptionist' ? 'selected' : '' ?>>Receptionist</option>
                          <option value="Teacher" <?php echo $user->getRole() == 'Teacher' ? 'selected' : '' ?>>Teacher</option>
                        </select>                       
                        <span class="error col-md-12 no-padding"><?php echo $role_err;?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Change</label>
                      <div class="col-md-2 col-sm-10 col-xs-10">
                        <label class="checkbox-inline no-padding-left">
                          <input name="change_password" type="checkbox" class="flat-red" value="1" id="change_password">
                        </label>
                      </div> 
                    </div>                     
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Password</label>
                      <div class="col-md-5 col-sm-10 col-xs-10">
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" disabled>                        
                        <div class="progress password-meter no-margin" id="passwordMeter">
                          <div class="progress-bar"></div>
                        </div>                               
                        <span class="error col-md-12 no-padding"><?php echo $password_err;?></span>
                      </div>
                    </div> 
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Re Password</label>
                      <div class="col-md-5 col-sm-10 col-xs-10">
                        <input type="password" class="form-control" name="re_password" placeholder="Enter your password again" disabled>                        
                        <span class="error col-md-12 no-padding"><?php echo $re_password_err;?></span>
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
<script>
  $(function() {
    $('.chosen-select').chosen();
    $('.chosen-select-deselect').chosen({ allow_single_deselect: true });

    //Flat Red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });    
  });
</script>

<script>
$(document).ready(function() {

  $('#change_name').on('ifChecked', function() {
    $("[name='username']").prop('disabled', false);
    prevalidateForm('#userForm');
  }).on('ifUnchecked', function () {
    $("[name='username']").prop('disabled', true);
    $("[name='username']").closest('.form-group').removeClass('has-warning');
  });

  $('#change_password').on('ifChecked', function() {
    $("[name='password']").prop('disabled', false);
    $("[name='re_password']").prop('disabled', false);
    prevalidateForm('#userForm');
  }).on('ifUnchecked', function () {
    $("[name='password']").prop('disabled', true);
    $("[name='re_password']").prop('disabled', true);
    $bar  = $('#passwordMeter').find('.progress-bar');
    $bar.html('').css('width', '0%').removeClass().addClass('progress-bar');    
  });    

  $('#userForm')
  // IMPORTANT: You must declare .on('init.field.fv')
  // before calling .formValidation(options)
  .on('init.field.fv', function(e, data) {
  // data.fv      --> The FormValidation instance
  // data.field   --> The field name
  // data.element --> The field element
    var field  = data.field,        // Get the field name
        $field = data.element,      // Get the field element
        bv     = data.fv;           // FormValidation instance   
    var $parent = $field.parents('.form-group'),
        $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + field + '"]');


    // You can retrieve the icon element by
    // $icon = data.element.data('fv.icon');

    $icon.on('click.clearing', function() {
      // Check if the field is valid or not via the icon class
      if ($icon.hasClass('fa-times')) {
        // Clear the field
        $field.val('');
        bv.resetField(data.element);
        if(data.element.attr('name') === 'password') {
          //var score = data.result.score,
          $bar  = $('#passwordMeter').find('.progress-bar');
          $bar.html('').css('width', '0%').removeClass().addClass('progress-bar');
        }          
      }
    });
    // Create a span element to show valid message
    // and place it right before the field
    var $span = $('<small/>').addClass('help-block validMessage')
                             .attr('data-field', field)
                             .insertAfter($field).hide();

    // Retrieve the valid message via getOptions()
    var message = bv.getOptions(field).validMessage;
    if (message) {
      $span.html(message);
    }    
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
      username: {
        verbose: false,
        validators: {
          notEmpty: {
            message: 'The username is required'
          },
          stringLength: {
            max: 50,
            min: 5,
            trim: true,
            message: 'The username must be between 5 to 50 characters long'
          },         
          regexp: {
            regexp: "^[a-zA-Z0-9_./@]*$",
            message: 'The full name can consist of alphabetical characters and special sign (_ @ .) only'
          },
          remote: {
            delay: 500,
            type: 'POST',
            async: true,
            data: {'action': 'validate_user'},
            url: '../model/manageuser.php',
            crossDomain: true,
            name: 'username',
          }                                                 
        }
      },
      role: {
        validators: {
          notEmpty: {
            message: 'Position is require'
          }                
        }
      },
      password: {
        validMessage: 'Combine symbol, number and capital letter to make it stronger.',
        validators: {
          notEmpty: {
            message: 'The password is required'
          },
          stringLength: {
            max: 100,
            min: 8,
            trim: true,                            
            message: 'The password must be between 8 to 100 characters long'
          },
          callback: {
            callback: function(value, validator, $field) {
              var score = 0;
              if (value === '') {
                return {
                  valid: true,
                  score: null
                };
              }
                                                                   
              // Check the password strength
              score += ((value.length >= 8) ? 1 : -1);

              // The password contains uppercase character
              if (/[A-Z]/.test(value)) {
                score += 1;
              }

              // The password contains uppercase character
              if (/[a-z]/.test(value)) {                                    
                score += 1;
              }

              // The password contains number
              if (/[0-9]/.test(value)) {
                score += 1;
              }

              // The password contains special characters
              if (/[!#$%&^~*_@?<>,.;:|]/.test(value)) {
                score += 1;
              }

              return {
                valid: true,
                score: score    
              };
            }
          }          
        }
      },
      re_password: {
        validators: {
          notEmpty: {
            message: 'The confirm password is require'
          },
          identical: {
            field: 'password',
            message: 'The password does not match!'
          }
        }
      }
    }
  })
  .on('success.validator.fv', function(e, data) {
              
    // The password passes the callback validator
    if (data.field === 'password' && data.validator === 'callback') {
      // Get the score  
      var score = data.result.score,
          $bar  = $('#passwordMeter').find('.progress-bar');                  
      var message = 'Combine symbol, number and capital letter to make it stronger.';
                  
      switch (true) {
        case (score === null || score == 0):
          $bar.html('').css('width', '5%').removeClass().addClass('progress-bar progress-bar-danger');
        break;

        case (score <= 0):
          $bar.html('Not good').css('width', '10%').removeClass().addClass('progress-bar progress-bar-danger');
        break;

        case (score > 0 && score <= 2):
          $bar.html('Very weak').css('width', '25%').removeClass().addClass('progress-bar progress-bar-warning');
          $('#userForm').parent().find('[data-field="password"]').text(message);
        break;
                            
        case (score > 2 && score <= 3):
          $bar.html('Medium').css('width', '50%').removeClass().addClass('progress-bar progress-bar-info');
          $('#userForm').parent().find('[data-field="password"]').text(message);
        break;

        case (score > 3 && score <= 4):
          $bar.html('Good').css('width', '75%').removeClass().addClass('progress-bar progress-bar-primary');
          $('#userForm').parent().find('[data-field="password"]').text(message);
        break;

        case (score > 4):
          $bar.html('Perfect').css('width', '100%').removeClass().addClass('progress-bar progress-bar-success');
          $('#userForm').parent().find('[data-field="password"]').text('This password is perfect!');
        break;

        default: break;
      }
    }
              
    // username remote validator
              
    // data.field --> The field name
    // data.element --> The field element
    // data.result --> The result returned by the validator
    // data.validator --> The validator name
              
    if (data.field === 'username' && data.validator === 'remote') {
      if(data.result.available === false || data.result.available === 'false') {
        $field = data.element.closest('.form-group')

        var fv = $('#userForm').data('formValidation');
        fv.updateStatus('username', 'INVALID', 'remote');    

        $field
        // add has-warning class
        .removeClass('has-error').addClass('has-warning')
        // change to warning icon
        .find('i[data-fv-icon-for="username"]').removeClass('fa-check').addClass('fa-info-circle')
        $field
        // Show message
        .find('small[data-fv-validator="remote"][data-fv-for="username"]').show();

        $('#userForm').find('button[type="submit"]').prop('disabled', true);
      } else {
        $field = data.element.closest('.form-group')

        $field     
        // remove has-warning class
        .removeClass('has-warning')
        // remove warning icon
        .find('i[data-fv-icon-for="username"]').removeClass('fa-info-circle')      
        $field  
        // Show message
        .find('small[data-fv-validator="remote"][data-fv-for="username"]').show()        
      }
    }                
  })
  .on('err.validator.fv', function(e, data) {    
    // username          
    if (data.field === 'username') {
      data.element.closest('.form-group').removeClass('has-warning');
    }
    data.element
        .data('fv.messages')
        // Hide all the messages
        .find('.help-block[data-fv-for="' + data.field + '"]').hide()
        // Show only message associated with current validator
        .filter('[data-fv-validator="' + data.validator + '"]').show();    
  })
  .on('success.field.fv', function(e, data) {
    //alert(data.element.attr('data-fv-field'));    
    var field  = data.field,        // Get the field name
        $field = data.element;      // Get the field element
    // Show the valid message element
    if(field !== 'role') {
      $field.next('.validMessage[data-field="' + field + '"]').show();
    }
  })
  .on('err.field.fv', function(e, data) {
    var field  = data.field,        // Get the field name
    $field = data.element;      // Get the field element
  
    // hide the valid message element
    $field.next('.validMessage[data-field="' + field + '"]').hide();
  })
  .on('status.field.fv', function(e, data) {
    if (data.field === 'username') {        
      (data.status === 'VALIDATING')? $('#progressBar').show(): $('#progressBar').hide();
    }
  })
  .find('#change_name')
  // Called when the radios/checkboxes are changed
  .on('ifChanged', function(e) {
    $('#userForm').formValidation('resetField', 'username');
  })
  .end()
  .find('#change_password')
  // Called when the radios/checkboxes are changed
  .on('ifChanged', function(e) {
    $('#userForm').formValidation('resetField', 'password');
    $('#userForm').formValidation('resetField', 're_password');
  })    
  .end();
  prevalidateForm('#userForm');
});
</script>