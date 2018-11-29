<?php
  include 'includes/header.php';
  include '../model/manageclass.php';

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $student = getOneStudent($id);
    if($student === null) {
      header("Location:404.php");
    } else { 
      $clazz = getOneClass($student->getClassID());
      $level = $clazz != null ? getOneLevel($clazz->getLevelID()) : null;   
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
            <i class="fa fa-envelope-o text-orange"></i>&nbsp;Notification Envelope Preview
            <small><?php //echo str_pad($invoice->getInvoiceID(), 6, '0', STR_PAD_LEFT); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php"> Payment Management</a></li>
            <li><a href="payment_invoice.php"> Payment &amp; Invoice</a></li>
            <li><a href="upcoming_payment_notification.php">Upcoming Payment Notification</a></li>
            <li class="active">Notification Alert</li>
          </ol>
        </section>        

        <!-- Main content -->
          <section class="notification">
            <div class="row">
              <div class="col-xs-12">
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-xs-12">
                    <a href="notification_print.php?id=<?php echo $id ?>" target="_blank" class="btn btn-default pull-right">
                      <i class="fa fa-print"></i>&nbsp;Print
                    </a>
                    <a  class="btn btn-success pull-right margin-hori" href="payment.php?id=<?php echo $id; ?>" 
                        role="button" data-toggle="tooltip" title="Making payment for this student.">
                      <i class="fa fa-credit-card"></i>&nbsp;Payment
                    </a>                     
                  </div>
                </div>                 
                  <div class="noti-header">
                    <div class="row" id="img">
                      <div class="col-md-6 logo-noti">
                        <img src="../images/logo.jpg">
                        <h3 class="khmer">
                          <p>សាលា អន្តរជាតិ រចនា</p>
                          <p><b>Rachna Internatiol School</b></p>                          
                        </h3>
                      </div>
                      <div class="col-md-4 col-md-offset-2 text-right center minus-top-sm">
                        <h4 class="khmer">
                          <p>ព្រះរាជាណាចក្រកម្ពុជា</p>
                          <p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
                        </h4>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            
            <div class="row pre-noti-info">
                <h4 class="khmer center">
                  <span>លិខិតជូនព័ត៌មានអំពីការបង់ប្រាក់ថ្លៃសិក្សាបន្ត</span>
                </h4> 
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div>
                    <p class="pad-left-xl">
                      សូម​គោរព​ជូនព័ត៌មានចំពោះមាតាបិតា/អាណាព្យាបាលរបស់សិស្សឈ្មោះ&nbsp;
                      <span class="pre-block-noti-lg">
                        <i><b>
                          <?php echo $student->getStudentName(); ?>
                        </b></i>                          
                      </span>
                    </p>
                    <p>
                      ភេទ&nbsp;
                      <span class="block-mini-dot">
                        <i><b>
                          <?php echo $student->getGender() != 1 ? ($student->getGender() != 2 ? 'មិនបញ្ជាក់' : 'ស្រី') : 'ប្រុស'; ?>
                        </b></i>                          
                      </span>
                      រៀនមុខវិជ្ជា&nbsp;
                      <span class="pre-block-noti-md">
                        <i><b>
                          <?php echo $level != null ? $level->getLevelName() : '<span class="text-red">Unkown</span>'; ?>
                        </b></i>                          
                      </span>
                      ម៉ោងសិក្សា&nbsp;
                      <span class="pre-block-noti-sm">
                        <i><b>
                          <?php
                            $start_time = $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") : '<span class="text-red">Unkown</span>';
                            $end_time = $clazz != null ? dateFormat($clazz->getEndTime(), "g:i A") : '<span class="text-red">Unkown</span>';
                            echo $start_time . " - " . $end_time; 
                          ?>
                        </b></i>                          
                      </span>
                      បន្ទប់&nbsp;
                      <span class="pre-block-noti-xs">
                        <i><b>
                          <?php echo $clazz != null ? $clazz->getClassName() : '<span class="text-red">Unkown</span>'; ?>
                        </b></i>                          
                      </span>
                    </p>
                    <p class="pad-left-xl">
                      មេត្តាជ្រាបថាៈសុពលភាពថ្លៃសិក្សារបស់បុត្រធីតារបស់លោកអ្នកនឹងផុតកំណត់ត្រឹមថ្ងៃទី&nbsp;
                      <i class="dot">
                        <b><?php echo dateFormat($student->getExpirePaymentDate(), 'd'); ?></b>&nbsp;
                      </i>
                      ខែ&nbsp;
                      <i class="dot">
                        <b><?php echo dateFormat($student->getExpirePaymentDate(), 'm'); ?></b>&nbsp;
                      </i>
                      ឆ្នាំ&nbsp;
                      <i class="dot">
                        <b><?php echo dateFormat($student->getExpirePaymentDate(), 'Y'); ?></b>&nbsp;
                      </i>។
                    </p>
                    <p class="pad-left-xl">
                      អាស្រ័យដូចបានជំរាបជូនខាងលើសូមលោក លោកស្រីមេត្តាអញ្ជើញមកធ្វើការបង់ថ្លៃសិក្សា តាមកាលបរិច្ឆេទកំណត់ខាងលើ។
                    </p>
                    <p class="pad-left-xl">
                      យើងខ្ញុំសូមថ្លែងអណរគុណយ៉ាងជ្រាលជ្រៅចំពោះការសហការរបស់មាតាបិតា/អាណាព្យាបាលសិស្សទាំងអស់
                    </p>
                    <div class="center">
                      <p>
                        សូមលោក លោកស្រីទទួលនូវការគោរពរាប់អានដ៏ខ្ពង់ខ្ពស់អំពីយើងខ្ញុំ។
                      </p>
                    </div>
                  </div>
                  <div class="plus-top" id="preview">
                    <div class="col-md-7 col-xs-7 border noti-box">
                        <span>សាលាអន្តរជាតិ រចនា សូមជំរាបជូនដល់មាតាបិតា/អាណាព្យាបាលឲ្យបានជ្រាបថា+</span>
                        <ul>
                          <li>
                            ករណីយឺតយ៉ាវលើសពី ៣ ថ្ងៃ សាលានឹងធ្វើការផាកពិន័យចំនួន 0.៥ ដុល្លារ
                          </li>
                          <li>
                            ករណីយឺតយ៉ាវលើសពី ៧ ថ្ងៃ សាលានឹងធ្វើការផាកពិន័យចំនួន ១ ដុល្លារ
                          </li>
                          <li>
                            ករណីយឺតយ៉ាវលើសពី ១០ ថ្ងៃ សាលានឹងធ្វើការផាកពិន័យចំនួន ២ ដុល្លារ
                          </li>
                        </ul>
                        <small>
                          <span class="khmer">
                            <i class="fa fa-hand-o-right"></i>&nbsp;
                            <!-- &#9758;&nbsp; -->
                            រាល់ព័ត៌មានបន្ថែមសូមទំនាក់ទំនងរៀងរាល់ម៉ោងធ្វើការ
                          </span>                      
                        </small>
                        <div class="center big">
                          <p class="no-margin">ទូរស័ព្ទ : 023 64 04 955/ 012 47 57 88/ 010 47 57 88</p>
                        </div>
                    </div>
                    <div class="pull-right center padding-hori stamp">
                      <p>
                        ភ្នំពេញ, ថ្ងៃទី&nbsp;<i class="dot"><b><?php echo date('d'); ?>&nbsp;</b></i>
                        ខែ&nbsp;<i class="dot"><b><?php echo date('m'); ?>&nbsp;</b></i>
                        ឆ្នាំ២០&nbsp;<i class="dot"><b><?php echo date('y'); ?>&nbsp;</b></i><br></p>
                      <p>ការិយាល័យសិក្សា និងគណនេយ្យ</p>
                    </div>
                  </div>
                </div>
            </div>    
          </section>
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->

<?php
  include 'includes/footer.php';
?>      

<script>

  $(function(){
    //Flat Aero color scheme for iCheck
    $('input[type="checkbox"].minimal-aero, input[type="radio"].minimal-aero').iCheck({
      checkboxClass: 'icheckbox_minimal-aero',
      radioClass: 'iradio_minimal-aero'
    });    

    //Flat Green color scheme for iCheck
    $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
      checkboxClass: 'icheckbox_minimal-green',
      radioClass: 'iradio_minimal-green'
    });

    //Flat Blue color scheme for iCheck
    $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });    

    //Flat Yellow color scheme for iCheck
    $('input[type="checkbox"].minimal-yellow, input[type="radio"].minimal-yellow').iCheck({
      checkboxClass: 'icheckbox_minimal-yellow',
      radioClass: 'iradio_flat-minimal-yellow'
    });

    //Flat Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });           
  });

</script>