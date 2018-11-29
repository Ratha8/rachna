<?php
    include 'includes/header.php';
    include '../model/manageclass.php'; 
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
    // $week = weekOfMonth(date('2016-03-21'));

    // $week = getWeeks('2016-03-21', 'sunday');

    // echo "week " . $week;
    
    $year = date('Y');
    $month = date('M');
    $week = (int) date('W', strtotime(date('Y-m-d')));

    // $ddate = "2012-10-18";
    // $date = new DateTime($ddate);
    // $week = $date->format("W");
    // echo "Weeknummer: ". $week;

    // $month = "2";
    // $year = "2016";

    // echo "week number is : " . date('W');

    $beg = (int) date('W', strtotime("first monday of $year-$month"));
    $end = (int) date('W', strtotime("last monday of $year-$month"));
    // $beg = (int) date('W', strtotime(date_create($year . '-' . 1)->modify('first day of this month')->format('Y-m-d')));
    // $end = (int) date('W', strtotime("last day of $year-$month"));

    $number_of_week = range($beg, $end);

    // $week_number = 0;
    // $target_week = getStartAndEndDate($number_of_week[$week_number], $year);
    // $target_date = $target_week['week_start'];

    // $date_range = getStartAndEndDate($number_of_week[$week_number], $year);  
    $date_range = getStartAndEndDate($week, $year); 

    $target_date = date('Y-m-d');
    $target_week = $date_range['week_start'];
       if($user_session->getRole() == 'Admin'){
       $list = getAllPaidStudentInWeek($target_week);
  }else{
        $list = getAllPaidStudentInWeekRec($target_week,$user_session->getUserID());
  }
//    $list = getAllPaidStudentInWeek($target_week);
    $classes = getAllClasses();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $target_date = empty($_POST['target_date']) ? date('Y-m-d') : date('Y-m-d', strtotime($_POST['target_date']));
      $week_number = empty($_POST['week_number']) ? 0 : $_POST['week_number'];
      $year = date('Y', strtotime($target_date));
      $month = date('M', strtotime($target_date));

      $beg = (int) date('W', strtotime("first monday of $year-$month"));
      $end = (int) date('W', strtotime("last monday of $year-$month"));
      
      $number_of_week = range($beg, $end);  
      $date_range = getStartAndEndDate($number_of_week[$week_number], $year);   

      $target_week = empty($_POST['target_week']) ? $date_range['week_start'] : date('Y-m-d', strtotime($_POST['target_week']));

//      $list = getAllPaidStudentInWeek($target_week);
            if($user_session->getRole() == 'Admin'){
       $list = getAllPaidStudentInWeek($target_week);
  }else{
        $list = getAllPaidStudentInWeekRec($target_week,$user_session->getUserID());
  }
    }    
   
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Paid Student List
            <small>List all paid student in a week</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php"> Payment Management</a></li>
            <li class="active">Paid List</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title" id="date-range">
                    List of Paid Student from 
                    <!-- <small> -->
                      <!-- <b> -->
                      <?php 
                        // $date_range = getStartAndEndDate($number_of_week[$week_number], $year);
                        echo date('d F Y', strtotime($date_range['week_start'])) . " to " . date('d F Y', strtotime($date_range['week_end'])); 
                      ?>
                      <!-- </b> -->
                    <!-- </small> -->
                  </h3>
                </div><!-- /.box-header -->
                <div class="box-body">

                  <div class="row information form-information">
                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding information">  
                      <div class="form-group">
                        <label class="col-md-2 col-sm-3 col-xs-4 control-label">
                          <i class="fa fa-calendar-check-o">&nbsp;Target Date</i>
                          <i class="i-split">:</i>
                        </label>
                        <div class="col-md-3 col-sm-9 col-xs-8">
                          <div class='input-group date'>
                            <input type='text' name="target_date" id="target_date" class="form-control" placeholder="Target Month"/>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>    
                        <div class="col-md-3 col-sm-9 col-xs-8">
                          <div class='input-group' id="week">
                            <select name="target_week" id="target_week" data-placeholder="Select Week" class="form-control chosen-select" tabindex="2">
                              <option></option>
                              <?php 
                                for($i = 0; $i < count($number_of_week); $i++) {
                                  $week_day = getStartAndEndDate($number_of_week[$i], date('Y', strtotime($target_date)));
                                  $selected = $week_day['week_start'] == $target_week ? " selected " : "";
                                  echo  "<option value='" . $week_day['week_start'] . "' " . $selected .
                                        "data-week='" . $i . "'" .
                                        ">" . date('d M',strtotime($week_day['week_start'])) . 
                                        " - " . date('d M',strtotime($week_day['week_end'])) . "</option>";                                  
                                } 
                              ?>
                            </select> 
                          </div>
                        </div> 
                      </div> 
                    </div>
                  </div> 
                  <hr>
                  <div class="table-responsive">
                    <table id="student-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Classroom</th>
                          <th>Study Time</th>
                          <th>Paid Date</th>
                          <th>Payment Date</th>
                          <th>Next Payment</th>
                          <th>Fee</th>
                          <th>Duration (Month)</th>
                          <th>Receptionist</th>
                        </tr>
                      </thead>
                      <tbody class="text-nowrap">
                        <?php 
                          $row_num = 1;
                          foreach($list as $key => $value) {
                            $id = $list[$key]['student_id'];
                            $clazz = getOneClass($list[$key]['class_id']);
                        ?>
                        <tr>
                          <td><?php echo "<a href='student_detail.php?id=" . $list[$key]['student_id'] . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo $list[$key]['student_name']; ?></td>
                          <td><?php echo $list[$key]['gender'] != 1 ? ($list[$key]['gender'] != 2 ? 'Other' : 'Female') : 'Male'; ?></td>
                          <td><?php echo $clazz != null ? $clazz->getClassName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td>
                            <?php 
                              echo $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") . " - " . dateFormat($clazz->getEndTime(), "g:i A") 
                                                  : '<i class="text-red">Unknown</i>'; 
                            ?>
                          </td>
                          <td><?php echo dateFormat($list[$key]['paid_date'], 'd - M - Y'); ?></td>
                          <td><?php echo dateFormat($list[$key]['payment_date'], "d - M - Y"); ?></td>
                          <td><?php echo dateFormat($list[$key]['expire_paymentdate'], "d - M - Y"); ?></td>
                          <td>$&nbsp;<?php echo $list[$key]['fee']; ?></td>
                          <td><?php echo $list[$key]['duration']; ?></td>
                          <td>
                            <?php
                              $user = getUserByUserID($list[$key]['register_user']); 
                              echo $user->getUserName(); 
                            ?>
                          </td>
                        </tr>
                        <?php $row_num++; } ?>                          
                      </tbody>
                      <tfoot class="center text-nowrap">
                        <tr class="success">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Classroom</th>
                          <th>Study Time</th>
                          <th>Paid Date</th>
                          <th>Payment Date</th>
                          <th>Next Payment Date</th>
                          <th>Fee</th>
                          <th>Duration (Month)</th>
                          <th>Receptionist</th>
                        </tr>
                      </tfoot>
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

      $('.date').data("DateTimePicker").defaultDate(new Date());

      //bootstrap-chosen
      $('.chosen-select').chosen();
      $('.chosen-select-deselect').chosen({ allow_single_deselect: true });        
    });

    function updateData(target_date, target_week, week_number) {
      console.log("target date : " + target_date);
      console.log("target week : " + target_week);
      console.log("week_number : " + week_number);
      $.ajax({
        url: 'weekly_paid_list.php',
        type: 'POST',
        data: {'target_date': target_date, 'target_week': target_week, 'week_number': week_number}, 
        success: function(data) {
          var table = $(data).find('.table-responsive').html();
          var info = $(data).find('#week').html();
          var range = $(data).find('#date-range').html();

          $('.table-responsive').html(table);
          $('#week').html(info);
          $('#date-range').html(range);

          $('#student-list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
          });

          $('.chosen-select').chosen();
          $('.chosen-select-deselect').chosen({ allow_single_deselect: true });    
          $('#target_week').trigger('chosen:updated')     
        }
      });       
    }

  </script>