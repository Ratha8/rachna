<?php
  include 'includes/header.php';  
  include '../model/manageinvoice.php'; 
 if($user_session->getRole() == 'Teacher') {
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
  $unpaid = count($unpaid_list);
  $paid = count($paid_list);
//  $list_invoices = getAllInvoices();
  if($user_session->getRole() == 'Admin'){
        $list_invoices = getAllInvoices();
   }else{
        $list_invoices = getAllInvoicesUserRole($user_session->getUserID());
   }

  if($user_session->getRole() == 'Admin'){
        $total = count(getAllStudents());
   }else{
        $total = count(getAllStudentUserRole($user_session->getUserID()));
   }
  
//  $total = count(getAllStudents());
  $invoices = count($list_invoices);
  
  $total_income = 0;
  foreach ($list_invoices as $key => $value) {
    $total_income += $list_invoices[$key]['fee'];
  }  
  $notifi = countUnpaidNotification($user_session->getUserID());
  $paid_percent = $total > 0 ? number_format(($paid * 100)/$total, 2) : number_format(0, 2);
  $unpaid_percent = $total > 0 ? number_format(($unpaid * 100)/$total, 2) : number_format(0, 2);
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Payment Management
            <small>List of all tasks</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Payment Management</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Paid</h3>
                  <p>
                    List all paid student by week
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-credit-card-alt"></i>
                </div>
                <a href="weekly_paid_list.php" class="small-box-footer">
                  View more info 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <div class="info-box bg-green pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Students</span>
                    <span class="info-box-number"><?php echo $total; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $paid_percent ?>%"></div>
                    </div>
                    <span class="progress-description">
                      Paid &nbsp;
                      <?php echo $paid; ?>&nbsp;
                      <span class="label bg-green-active">
                        <strong><?php echo $paid_percent; ?></strong>
                        <i class="fa fa-percent"></i>                        
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Unpaid</h3>
                  <p>
                    List all unpaid student by week&nbsp; 
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                   
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-credit-card-alt"></i>
                </div>
                <a href="unpaid_list.php" class="small-box-footer">
                  View more info 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <div class="info-box bg-red pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Students</span>
                    <span class="info-box-number"><?php echo $total; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: <?php echo $unpaid_percent ?>%"></div>
                    </div>
                    <span class="progress-description">
                      Unpaid &nbsp;
                      <?php echo $unpaid; ?>
                      <span class="label bg-red-active">
                        <strong><?php echo $unpaid_percent; ?></strong>
                        <i class="fa fa-percent"></i>                        
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->        

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Payment</h3>
                  <p>
                    Making Payment for student
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-credit-card"></i>
                </div>
                <a href="payment_invoice.php" class="small-box-footer">
                  View more info 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <div class="info-box bg-aqua pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Students</span>
                    <span class="info-box-number"><?php echo $total; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                      Upcoming Pay&nbsp;
                      <span class="label bg-aqua-active">
                        <strong><?php echo $notifi; ?></strong>                     
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->    

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Invoice</h3>
                  <p>
                    List of invoice history 
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-newspaper-o"></i>
                </div>
                <a href="invoice_history.php" class="small-box-footer">
                  View more info 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <div class="info-box bg-purple pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Invoices</span>
                    <span class="info-box-number"><?php echo $invoices; ?></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                      Total Income&nbsp;
                      <span class="label bg-purple-active">
                        <strong>$&nbsp;<?php echo $total_income; ?></strong>                       
                      </span>
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col --> 

            <div class="col-lgs-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-orange class-box">
                <div class="inner pointer">
                  <h3 class="pre-wrap">Statistic</h3>
                  <p>
                    Weekly Payment Statistic Chart&nbsp; 
                  </p>
                  <p class="center">
                    <span class="label label-warning"><?php echo date('d F Y'); ?></span>
                  </p>                  
                </div>
                <div class="icon icon-fix pointer">
                  <i class="fa fa-pie-chart"></i>
                </div>
                <a href="student_chart.php" class="small-box-footer">
                  View more info 
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
                <div class="info-box bg-orange pointer">
                  <span class="info-box-icon center"><i class="fa fa-users icon-pad"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Student</span>
                    <span class="info-box-number"><?php echo $total; ?></span>
                    <div class="progress">
                      <div class="progress-bar bg-green" style="width: <?php echo $paid_percent ?>%"></div>
                      <div class="progress-bar bg-red" style="width: <?php echo $unpaid_percent ?>%"></div>
                      <div class="progress-bar" style="width: <?php echo 100 - ($paid_percent + $unpaid_percent) ?>%"></div>
                    </div>
                    <span class="progress-description">
                      Paid &nbsp;
                      <span class="label label-success">
                        <strong><?php echo $paid; ?></strong>                       
                      </span>
                      &nbsp;Unpaid &nbsp;
                      <span class="label label-danger">
                        <strong><?php echo $unpaid; ?></strong>                       
                      </span>                      
                    </span>                  
                  </div><!-- /.info-box-content -->
                </div>
              </div>
            </div><!-- ./col -->                                      

          </div><!-- /.row -->
        </section>
      </div>
<?php
    include 'includes/footer.php';
?>

  <script type="text/javascript">

    $(document).ready(function(){
      $(".content-wrapper").on("click", ".class-box", function(e) {
          if ($(e.target).is("a, button")) return;
          location.href = $(this).find("a").attr("href");
      });      
    });

  </script>