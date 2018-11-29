<?php
    include 'includes/header.php';
    include '../model/manageclass.php'; 
    if($user_session->getRole() == 'Teacher'){
      header("Location:403.php");
    }

    $year = date('Y');
    $week = (int) date('W', strtotime(date('Y-m-d')));
    $date_range = getStartAndEndDate($week, $year);   

    $target_week = $date_range['week_start'];    


 if($user_session->getRole() == 'Admin'){
        $paid_list = getAllPaidStudentInWeek($target_week);
   }else{
        $paid_list = getAllPaidStudentInWeekRec($target_week,$user_session->getUserID());
   }
    if($user_session->getRole() == 'Admin'){
        $unpaid_list = getAllUnPaidStudent($target_week);
   }else{
        $unpaid_list = getAllUnPaidUserRole($target_week,$user_session->getUserID());
   }
   if($user_session->getRole() == 'Admin'){
        $total = count(getAllStudents());
   }else{
        $total = count(getAllStudentUserRole($user_session->getUserID()));
   }
    $unpaid = count($unpaid_list);
    $paid = count($paid_list);
//    $total = count(getAllStudents());
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Payment Statistic
            <small><?php echo date('Y - M - d'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php"> Payment Management</a></li>
            <li class="active">Payment Statistic</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <!-- DONUT CHART -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">This Week</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                  </div>
                </div>
                <div class="box-body">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <canvas id="pieChart" style="height:250px" 
                        data-paid="<?php echo $paid ?>" 
                        data-unpaid="<?php echo $unpaid ?>" 
                        data-total="<?php echo $total ?>">
                    </canvas>                    
                  </div>                  
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="col-md-4 col-sm-4 col-xs-12 no-padding-left">
                      <i class="fa fa-circle-o text-gray "></i>&nbsp;Total Students:&nbsp;
                      <b class="text-muted"><?php echo $total; ?></b>
                    </span>
                    <span class="col-md-4 col-sm-4 col-xs-12 no-padding-left">
                      <i class="fa fa-circle-o text-Green"></i>&nbsp;Paid Students:&nbsp;
                      <b class="text-green"><?php echo $paid; ?></b><br>
                      <span class="pad-left text-green">
                        Percentage:&nbsp;
                        <span class="label label-success">
                          <strong><?php echo $total > 0 ? number_format(($paid * 100)/$total, 2) : number_format(0, 2); ?></strong>
                          <small><i class="fa fa-percent"></i></small>
                        </span>
                      </span> 
                    </span>
                    <span class="col-md-4 col-sm-4 col-xs-12 no-padding-left">
                      <i class="fa fa-circle-o text-red"></i>&nbsp;Unpaid Studentst:&nbsp;
                      <b class="text-red"><?php echo $unpaid; ?></b><br>
                      <span class="pad-left text-red">
                        Percentage:&nbsp;
                        <span class="label label-danger">
                          <strong><?php echo $total > 0 ? number_format(($unpaid * 100)/$total, 2) : number_format(0, 2); ?></strong>
                          <small><i class="fa fa-percent"></i></small>
                        </span>
                      </span>
                    </span>
                    <hr>
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>
                          <h4>Detail:</h4>
                        </p>
                        <div class="sidebar">
                          <ul class="nav nav-pills nav-stacked">
                            <li>
                              <a href="#">
                                <span class="text-green">Paid Student</span>
                                <span class="pull-right text-green">
                                  <i class="fa fa-angle-up"></i> 
                                  <strong><?php echo $total > 0 ? number_format(($paid * 100)/$total, 2) : number_format(0, 2); ?></strong>
                                  <small><i class="fa fa-percent"></i></small>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                <?php 
                                  if($paid > 0) {
                                    foreach ($paid_list as $key => $value) {  
                                ?>
                                  <li>
                                    <a href="student_detail.php?id=<?php echo $paid_list[$key]['student_id']; ?>">
                                      <span class="text-muted"><?php echo $paid_list[$key]['student_name']; ?></span>
                                    </a>
                                  </li>
                                <?php 
                                    }
                                  }else {
                                      echo "<li>None</li>"; 
                                  }
                                ?>
                              </ul>                        
                            </li>
                            <li>
                              <a href="#">
                                <span class="text-red">Unpaid Student</span> 
                                <span class="pull-right text-red">
                                  <i class="fa fa-angle-down"></i>
                                  <strong><?php echo $total > 0 ? number_format(($unpaid * 100)/$total, 2) : number_format(0, 2); ?></strong>
                                  <small><i class="fa fa-percent"></i></small>                            
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                <?php 
                                  if($unpaid > 0) {
                                    foreach ($unpaid_list as $key => $value) {  
                                ?>
                                  <li>
                                    <a href="student_detail.php?id=<?php echo $unpaid_list[$key]['student_id']; ?>">
                                      <span class="text-muted"><?php echo $unpaid_list[$key]['student_name']; ?></span>
                                    </a>
                                  </li>
                                <?php 
                                    }
                                  }else {
                                      echo "<li>None</li>"; 
                                  }
                                ?>
                              </ul>                          
                            </li>
                          </ul>
                        </div> 
                      </div>
                    </div>                   
                  </div>
                </div><!-- /.box-body -->              
              </div><!-- /.box -->

            </div><!-- /.col (LEFT) -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php
    include 'includes/footer.php';
?>      

    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js"></script>

    <!-- page script -->
    <script>
      $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pie = $("#pieChart");
        var paid = pie.data('paid');
        var unpaid = pie.data('unpaid');
        var total = pie.data('total');

        var pieChartCanvas = pie.get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
          {
            value: unpaid,
            color: "#f56954",
            highlight: "#DD4B39",
            label: "Unpaid Student " + (unpaid*100/total).toFixed(2) + "%"
          },
          {
            value: paid,
            color: "#00a65a",
            highlight: "#008D4C",
            label: "Paid Student " + (paid*100/total).toFixed(2) + "%"
          },
          // {
          //   value: 400,
          //   color: "#f39c12",
          //   highlight: "#f39c12",
          //   label: "Total"
          // },
          // {
          //   value: 600,
          //   color: "#00c0ef",
          //   highlight: "#00c0ef",
          //   label: "Safari"
          // },
          // {
          //   value: 300,
          //   color: "#3c8dbc",
          //   highlight: "#3c8dbc",
          //   label: "Opera"
          // },
          {
            value: (paid + unpaid) == total ? 0 : total - (paid + unpaid),
            color: "#d2d6de",
            highlight: "#E7E7E7",
            label: "Remain Students"
          }
        ];
        var pieOptions = {
          scaleShowLabels : false,
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 25, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);

      });
    </script>