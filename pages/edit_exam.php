<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
  include '../model/managecourse.php';
  include '../model/manageexam.php';

$exam = new Exam;
 if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $exam = getOneExam($id);
    if($exam === null) {
      header("Location:404.php");
    }
  } else {
    header("Location:404.php");
  }

$num_month   = DateTime::createFromFormat('!m', $exam->getExam_month());
$show_month = $num_month->format('F');
$month_year = $show_month.' '.$exam->getExam_year();

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $user_id = $user_session->getUserID();
    $exam_month = isset($_POST["exam_month"]) ? 
          (!empty($_POST["exam_month"]) ? date('m', strtotime(str_replace('/', '-', $_POST['exam_month']))) : "") : "";
    $exam_year = isset($_POST["exam_month"]) ? 
          (!empty($_POST["exam_month"]) ? date('Y', strtotime(str_replace('/', '-', $_POST['exam_month']))) : "") : "";
    
    $exam->setExam_name($_POST['exam_name']);
    $exam->setExam_month($exam_month);
    $exam->setExam_year($exam_year);
    $exam->setDescription($_POST['description']);
    $exam->setRegister_user($user_id);
    updateExam($exam);
    header("Location:view_exam_list.php");
    }
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Create Exam
            <small>Add new exam to the list</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_exam.php"> Exam Management</a></li>
            <li><a href="user_list.php"> Exam List</a></li>
            <li class="active">Create Exam</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Exam Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" id="examForm">
                  <div class="box-body">
                      <input type="hidden" name="exam_id" value="<?php echo $exam->getExam_id(); ?>">
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Name</label>
                      <div class="col-md-5 col-sm-10 col-xs-10">
                        <input type="text" class="form-control" name="exam_name" placeholder="Name of exam" required value="<?php echo $exam->getExam_name(); ?>">
                        <span class="error col-md-12 no-padding"></span>
                        <div class="progress" id="progressBar" style="margin: 5px 0 0 0; display: none;">
                          <div class="progress-bar progress-bar-success progress-bar-striped active"style="width: 100%"></div>
                        </div>                        
                        
                      </div>
                    </div>                 
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Exam For</label>
                      <div class="col-md-5 col-sm-10 col-xs-10 select">
                        <div class='input-group date'>
                            <input type='text' name="exam_month" id="target_date" class="form-control" placeholder="Target Month" value="<?php echo $month_year?>"/>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>                      
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Description</label>
                      <div class="col-md-5 col-sm-10 col-xs-10">
                        
    <textarea class="form-control" placeholder="Exam Description" name="description"><?php echo $exam->getDescription(); ?></textarea>


                    </div>                       
                       
                      </div>
                    </div> 
                                                                        
                    <div class="box-footer">
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-info pull-right" >
                          <i class="fa fa-download"></i>
                          Edit
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
  });
</script>

<!-- moment with locale -->
  <script src="../js/moment-with-locales.min.js"></script>
  <!-- bootstrap datetime picker -->
  <script src="../js/bootstrap-datetimepicker.min.js"></script>  
  <!-- bootstrap chosen -->
  <script src="../js/chosen.jquery.js"></script>  

  <script type="text/javascript">

    $(document).ready(function(){     

      $('.form-information').on('blur', '#target_date', function() {
        var target_date = $(this).val();
        // var target_week = $('#target_week').val();
        // var week_number = $('#target_week').find(':selected').data('week'); 
        updateData(target_date, null, null);       
      })
      .on('change', '#target_week', function() {
        var target_week = $(this).val();
        var week_number = $(this).find(':selected').data('week'); 
        var target_date = $('#target_date').val();
        updateData(target_date, target_week, week_number);   
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

      $('.date').datetimepicker({
        format: 'MMMM YYYY',
        allowInputToggle: true,
        ignoreReadonly: true,
        useCurrent: true,
        showClear: true,
        showClose: true,
        showTodayButton: true
      });      

//      $('.date').data("DateTimePicker").defaultDate(new Date());

      //bootstrap-chosen
      $('.chosen-select').chosen();
      $('.chosen-select-deselect').chosen({ allow_single_deselect: true });        
    });

    </script>


