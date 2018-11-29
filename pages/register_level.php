<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
   if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  $level_name_err = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $level = new Level;
    $level->setRegisterUser($user_session->getUserID());
    $level->setLevelName($_POST['level_name']);
    $st_err = 0;

    // level name validation
    if(empty($level->getLevelName())){
      $st_err = 1;
      $level_name_err = "Level name is required.";
    }elseif(strlen($level->getLevelName()) >= 100){
      $st_err = 1;
      $level_name_err = "Level name must be within 100 characters long.";
    }

    if($st_err === 0){
      $level_id = insertLevel($level);
      header("Location:level_list.php");
    } 
  } 
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new Level
            <small>Add new study level for school</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_school.php"> School Management</a></li>
            <li><a href="level_list.php"> Level List</a></li>
            <li class="active">Register Level</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Level of Study Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" id="levelForm">
                  <div class="box-body">
                    <div class="form-group level">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label">Name</label>
                      <div class="col-md-5 col-sm-10 col-xs-10">
                        <div class="input-group">
                          <input type="text" class="form-control" name="level_name" placeholder="Level Name">
                          <div class="input-group-btn">
                            <button type="submit"class="btn btn-info">Submit</button>
                          </div>
                        </div>
                        <span class="error col-md-12 no-padding"><?php echo $level_name_err;?></span>
                      </div>
                    </div>                                                                       
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
    $('#levelForm')
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
        level_name: {
          validators: {
            notEmpty: {
              message: 'The level name is required'
            },
            stringLength: {
              max: 30,
              trim: true,
              message: 'The level name must be between 30 characters long'
            }             
          }
        }
      }
    });
    prevalidateForm('#levelForm'); 
  });
</script>
