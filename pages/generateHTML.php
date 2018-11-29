<?php
  include '../model/manageuser.php';
  include '../model/util.php';
  include '../model/managestudent.php';
  include '../model/manageclass.php';  
  require_once("../library/html2pdf.class.php");

  ob_start();

  $target_date = date('Y-m-d');
  $classes = getAllClasses();
  $total = countAllStudent(date('Y-m-d'));
  $new_stu = countNewStudent(date('Y-m-d'));
  $old_stu = countOldStudent(date('Y-m-d'));
  $leave_stu = countLeaveStudent(date('Y-m-d'));
  $total_leave = countTotalLeaveStudent(date('Y-m-d'));
  $list = getAllStudentInMonth(date('Y-m-d'));
  $server = "http://" . $_SERVER['HTTP_HOST'] . "/rachana";
  // $server = "http://" . $_SERVER['DOCUMENT_ROOT'] . "rachana";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_date = date('Y-m-d', strtotime($_POST['target_date']));
    $list = getAllStudentInMonth($target_date);
    $total = countAllStudent($target_date);
    $new_stu = countNewStudent($target_date);
    $old_stu = countOldStudent($target_date);
    $leave_stu = countLeaveStudent($target_date);
    $total_leave = countTotalLeaveStudent($target_date);
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo $server . '/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo $server . '/css/font-awesome.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo $server . '/css/AdminLTE.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo $server . '/css/rachna.css'; ?>"> 
  </head>
  <body>
      <div class="wrapper">
        <section class="content-header">
          <h1>
            Student List
            <small>List all current students in <b><?php echo dateFormat($target_date, 'F Y') ?></b>.</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">List of Student in &nbsp; <?php echo dateFormat($target_date, 'F Y') ?></h3>
                </div>
                <div class="box-body">
                  <div class="row information">
                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                      <div class="form-group">
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                          <i>&nbsp;Target Date</i>
                          <i class="i-split">:</i>
                        </label>
                        <div class="col-md-3 col-sm-9 col-xs-8">
                          <div class='input-group'>
                            <input type='text' name="target_date" class="form-control" placeholder="Target Date"/>
                          </div>
                        </div>                           
                      </div> 
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                      <label class="col-md-2 col-sm-3 col-xs-4 control-label text-light-blue">
                        <i>&nbsp;Total Student</i>
                        <i class="i-split">:</i>
                      </label>
                      <span class="col-md-2 col-sm-3 col-xs-8 control-span text-light-blue">
                        <?php 
                          echo "<span class='pointer' data-type='1'> " . $total . 
                               " </span>&nbsp;<i class='text-orange pointer' data-type='2'>(Leave : " . $total_leave . ")</i>"; 
                        ?>
                      </span>
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-green">
                          <i>&nbsp;New</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-2 col-sm-3 col-xs-8 control-span text-green pointer" data-type='3'>
                          <?php echo $new_stu; ?>
                        </span>
                      </div>   
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-muted">
                          <i>&nbsp;Old</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-2 col-sm-3 col-xs-8 control-span text-muted pointer" data-type='4'>
                          <?php echo $old_stu; ?>
                        </span>
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label text-red">
                          <i>&nbsp;Leave</i>
                          <i class="i-split">:</i>
                        </label>        
                        <span class="col-md-2 col-sm-3 col-xs-8 control-span text-red pointer" data-type='5'>
                          <?php echo $leave_stu; ?>
                        </span>
                      </div>   
                    <div class="col-md-12">
                      <div class="box box-info">
                        <div class="box-header">
                          <h3 class="box-title">Color Note:</h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i></i></button>
                          </div>
                        </div>
                        <div class="box-body">
                          <span class="text-muted col-md-2 col-sm-3 col-xs-12"><i></i>&nbsp;Old Student</span>
                          <span class="text-Green col-md-2 col-sm-3 col-xs-12"><i></i>&nbsp;New Student</span>
                          <span class="text-orange col-md-2 col-sm-3 col-xs-12"><i></i>&nbsp;Leave Student</span>
                          <span class="text-red col-md-3 col-sm-3 col-xs-12"><i></i>&nbsp;Leave Student (current month)</span>
                          <span class="text-blue col-md-12 col-sm-12 col-xs-12">
                            <i class="text-aqua"></i>&nbsp;Total Student&nbsp;=&nbsp; 
                            <i class="text-muted">Old Student</i>&nbsp;+&nbsp; 
                            <i class="text-green">New Student</i>&nbsp;+&nbsp; 
                            <i class="text-orange">Leave Student</i>
                          </span>
                        </div>
                      </div>
                    </div> 
                  </div>    
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
  </body>
</html>

<?php
  file_put_contents('report.html', ob_get_contents());
?>