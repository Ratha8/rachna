<?php
  include 'includes/header.php';
  include '../model/manageinvoice.php';
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $invoice = getOneInvoice($id);
    if($invoice === null) {
      header("Location:404.php");
    } else {
      $student = getOneStudent($invoice->getStudentID());
      $first_day = getTime(date('d-m-Y'), 'Y-m-01');
      $last_day = getTime(date('d-m-Y'), 'Y-m-t');
      $enroll_date = getTime($student->getEnrollDate(), 'Y-m-d');
      if($enroll_date >= $first_day && $enroll_date <= $last_day) {
        $status = 1;
      } else {
        $status = 0;
      }       
    }
  } else {
    header("Location:404.php");
  }

?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Invoice
            <small>#<?php echo str_pad($invoice->getInvoiceID(), 6, '0', STR_PAD_LEFT); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php">Payment Management</a></li>
            <li><a href="payment_invoice.php">Payment &amp; Invoice</a></li>
            <li><a href="invoice_list.php?id=<?php echo $student->getStudentID(); ?>">Invoice List</a></li>
            <li class="active">Invoice Preview</li>
          </ol>
        </section>

        <!-- Main content -->
          <section class="invoice">
            <div class="row">
              <div class="col-xs-12">
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-xs-12">
                    <a href="invoice_print.php?id=<?php echo $id ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                  </div>
                </div>                
                  <div class="inv-header center border-bottom">
                    <h2 class="khmer">
                      <?php if(isset($getsetting[0]['school_name_kh']) || !empty($getsetting[0]['school_name_kh'])){
                            echo "<p>".$getsetting[0]['school_name_kh']."</p>";
                        }else{
                            echo '<p>សាលា អន្តរជាតិ រចនា</p>';
                        }
                        if(isset($getsetting[0]['school_name_en']) || !empty($getsetting[0]['school_name_en'])){
                            echo "<p><b>".$getsetting[0]['school_name_en']."</b></p>";
                        }else{
                            echo '<p><b>Rachna Internatiol School</b></p>';
                        }
                        ?>
                    </h2>
                    <div class="row">
                      <div class="col-md-2 col-logo-left pre-logo-inv">
                        <?php if(isset($getsetting[0]['logo']) || !empty($getsetting[0]['logo'])){
                            echo '<img src="uploads/logo/'.$getsetting[0]['logo'].'">';
                        }else{
                            echo '<img src="../images/logo.jpg">';
                        }
                        ?>
                        <div class="col-md-2">
                          <p>សាលា អន្តរជាតិ រចនា</p>
                        </div>
                        
                      </div>
                      
                    </div>
                    
                    <div class="row margin-ver">
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                      <div class="col-md-3 pull-left border pre radius m-pad">
                        <span class="center">
                        ប្រាក់​បង់​រួច​មិនអាច​ដកវិញបានទេ<br>
                        <b>NONREFUNDABLE</b>
                        </span>
                      </div>
                      <div class="pull-right s-padding left pre-chk-info">
                        <i class="<?php echo $status == 1 ? 'fa fa-square-o' : 'fa fa-check-square-o'; ?>"></i>&nbsp;សិស្សចាស់បង់ប្រាក់<br>
                        <i class="<?php echo $status == 1 ? 'fa fa-check-square-o' : 'fa fa-square-o'; ?>"></i>&nbsp;សិស្សថ្មីបង់​ប្រាក់​
                      </div>  
                      </div>                
                    </div>
                  </div>
              </div>
            </div>
            
            <div class="row invoice-info">
                <h3 class="khmer center  underline">
                  <span>វិក័យប័ត្របង់ប្រាក់ (ពេញម៉ោងសិក្សា)</span>
                </h3>
                <span class="pull-right pre-minus-top padding">
                  លេខ <span class="text-red dot"><b><?php echo str_pad($invoice->getInvoiceNumber() == '' ? $invoice->getInvoiceID() : $invoice->getInvoiceNumber(), 6, '0', STR_PAD_LEFT); ?></b></span>
                </span> 
                <div class="col-md-12 col-sm-12 col-xs-12 invoice-body">
                  <div>
                    <p>
                        ឈ្មោះ&nbsp;
                        <span class="pre-md-dot">
                          <i><b>
                            <?php echo $student->getStudentName(); ?>
                          </b></i>                          
                        </span>
                        អក្សរឡាតាំង&nbsp;
                        <span class="pre-md-dot">
                          <i><b>
                            <?php echo ucwords(strtolower($student->getLatinName())); ?>
                          </b></i>
                        </span>
                        ភេទ&nbsp;
                        <span class="block-mini-dot">
                          <i><b>
                            <?php echo $student->getGender() != 1 ? ($student->getGender() != 2 ? 'មិនបញ្ជាក់' : 'ស្រី') : 'ប្រុស'; ?>
                          </b></i>
                        </span>
                    </p>
                    <p>
                      មុខវិជ្ជាសិក្សា&nbsp;
                      <span class="pre-lg-dot">
                        <i><b>
                          <?php echo $invoice->getLevel() != null ? $invoice->getLevel() : '<span class="text-red">Unknown</span>'; ?>
                        </b></i>
                      </span>
                      តម្លៃ&nbsp;
                      <span class="pre-lg-dot">
                        <i><b>
                          $&nbsp;<?php echo $invoice->getFee(); ?>
                        </b></i>
                      </span>
                    </p>
                    <p>
                      សិក្សា&nbsp;
                      <span class="pre-dot">
                        <i><b>
                          <?php 
                            $start_time = $invoice->getStartTime() != null ? dateFormat($invoice->getStartTime(), "g:i A") : '<span class="text-red">Unknown</span>';
                            $end_time = $invoice->getEndTime() != null ? dateFormat($invoice->getEndTime(), "g:i A") : '<span class="text-red">Unknown</span>';
                            echo $start_time . " - " . $end_time; 
                          ?>
                        </b></i>
                      </span>
                      ពេល&nbsp;                
                      <i class="<?php echo $invoice->getTimeShift() == 1 ? 'fa fa-check-square-o' :'fa fa-square-o'?>"></i>&nbsp;ព្រឹក
                      <i class="<?php echo $invoice->getTimeShift() == 2 ? 'fa fa-check-square-o' :'fa fa-square-o'?>"></i>&nbsp;រសៀល   
                      <i class="<?php echo $invoice->getTimeShift() == 3 ? 'fa fa-check-square-o' :'fa fa-square-o'?>"></i>&nbsp;ល្ងាច                
                      &nbsp;បន្ទប់&nbsp;
                      <span class="pre-dot">
                        <i><b>
                          <?php echo $invoice->getClassName() != null ? $invoice->getClassName() : '<span class="text-red">Unknown</span>'; ?>
                        </b></i>
                      </span>
                      ច័ន្ទ-សុក្រ 
                    </p>
                    <p>
                      ថ្ងៃចូលសិក្សា​&nbsp;
                      <span class="pre-dot">
                        <i><b>
                          <?php echo dateFormat($invoice->getStart_new(), 'd - m - y'); ?>
                        </b></i>
                      </span>
                      ថ្ងៃផុតកំណត់&nbsp;
                      <span class="pre-dot">
                        <i><b>
                          <?php echo dateFormat($invoice->getExpire_new(), 'd - m - y'); ?>
                        </b></i>
                      </span>
                      រយៈពេលសិក្សា&nbsp;
                      <span class="block-sm-dot">
                        <i><b>
                          (<?php echo $invoice->getDuration(); ?> ខែ)
                        </b></i>
                      </span>
                    </p>
                  </div>
                  <div class="pull-right center padding-hori pre-signature">
                    <p>
                      ថ្ងៃទី&nbsp;<i class="dot"><b><?php echo dateFormat($invoice->getInvoiceDate(), 'd'); ?>&nbsp;</b></i>
                      ខែ&nbsp;<i class="dot"><b><?php echo dateFormat($invoice->getInvoiceDate(), 'm'); ?>&nbsp;</b></i>
                      ឆ្នាំ&nbsp;<i class="dot"><b><?php echo dateFormat($invoice->getInvoiceDate(), 'Y'); ?>&nbsp;</b></i><br></p>
                    <p>ហត្ថលេខា​និងឈ្មោះអ្នកទទួល</p>
                    <!-- <p class="pre-signature"><i><b><?php echo $user_session->getUsername(); ?></b></i></p> -->
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="radius center back-primary">
                  <h4 class="khmer-simple pad margin">
                    អាសយដ្ឋាន: ផ្ទះលេខ D10 ផ្លូវលេខ 371 ភូមិត្នោតជ្រុំ សង្កាត់ បឹងទំពុន ខ័ណ្ឌ មានជ័យ រាជធានីភ្នំពេញ
                  </h4>
                </div>
              </div>
            </div>        
          </section>
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->

<?php
  include 'includes/footer.php';
?>      
