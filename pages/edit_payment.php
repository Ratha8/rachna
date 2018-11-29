<?php
  include 'includes/header.php';
  include '../model/manageclass.php';
  include '../model/managecourse.php';
  include '../model/manageinvoice.php';
   if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  $fee_err = "";
  $duration_err = "";
  $start_new_err = "";
  $expire_new_err = "";
  $payment_date_err = "";
  $invoice_number_err = "";

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $invoice = getOneInvoice($id);
    if($invoice === null) {
      header("Location:404.php");
    } else {
      $course = getAllCourses(); 
      $student = getOneStudent($invoice->getStudentID());
      $lastStudentDate = $student->getExpirePaymentDate();
    }
  } else {
    header("Location:404.php");
  } 

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $user_session->getUserID();
    $st_err = 0;

    $invoice_id = $_POST['invoice_id'];
    $fee = $_POST['fee'];
    $duration = $_POST['duration'];
    $id = $_POST['student_id'];
     $invoice_number = $_POST['invoice_number'];
    $invoice_date = isset($_POST['payment_date']) ?
            (!empty($_POST['payment_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['payment_date']))) : "") : "";
    $start_new = isset($_POST["start_new"]) ?
            (!empty($_POST["start_new"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['start_new']))) : "") : "";
    $expire_new = isset($_POST["expire_new"]) ?
            (!empty($_POST["expire_new"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['expire_new']))) : "") : "";

    $student->setStudentID($id);
    $student->setUpdateUser($user_id);
    $student->setFee($fee);
    $student->setDuration($duration); 
    $student->setStart_new($start_new);
    $student->setExpire_new($expire_new);
    // fee validation
    if(empty($student->getFee())){
      $st_err = 1;
      $fee_err = "Payment fee is required.";
    } elseif(!is_numeric($student->getFee()) || $student->getFee() < 0) {
      $st_err = 1;
      $fee_err = "Payment must be a valid number";
    } elseif(strlen($student->getFee()) > 7) {
      $st_err = 1;
      $fee_err = "Please only input number within 7 digits";
    }

    // duration validation
    if(empty($student->getDuration())){
      $st_err = 1;
      $duration_err = "Course duration is required.";
    }

    if(empty($invoice_number)){
      $st_err = 1;
      $invoice_number_err = "Invoice Number is required.";
     }

    if(empty($invoice_date)){
      $st_err = 1;
      $invoice_date_err = "Invoice Date is required.";
    }

    if($st_err === 0) {
      $student->setExpirePaymentDate($student->getPaymentDate());
      $lastInvoiceID = getStudentPaymentLastID($id);
      $lastInvoceDate = getStudentPaymentDate($id);
      
      if($lastInvoceDate[0] > $lastStudentDate){
        updateExpirePayment($student);
        $student = updatePaymentStudent($student);
        
        $invoice = new Invoice;
        $invoice->setInvoiceID($invoice_id);
        $invoice->setStudentID($student->getStudentID());
        $invoice->setReceptionist($user_session->getUsername());
        $invoice->setDuration($student->getDuration());
        $invoice->setFee($student->getFee());
        $invoice->setStart_new($student->getStart_new());
        $invoice->setExpire_new($student->getExpire_new());
        $invoice->setExpirePaymentDate($student->getExpirePaymentDate());
        $invoice->setUpdateUser($user_id);    
        $invoice->setInvoiceNumber($invoice_number);
        $invoice->setInvoiceDate($invoice_date);

        updateInvoice($invoice);
      }else{
        $invoice = new Invoice;
        $invoice->setInvoiceID($invoice_id);
        $invoice->setStudentID($student->getStudentID());
        $invoice->setReceptionist($user_session->getUsername());
        $invoice->setDuration($student->getDuration());
        $invoice->setFee($student->getFee());
        $invoice->setStart_new($student->getStart_new());
        $invoice->setExpire_new($student->getExpire_new());
        $invoice->setExpirePaymentDate($student->getExpirePaymentDate());
        $invoice->setUpdateUser($user_id); 
        $invoice->setInvoiceNumber($invoice_number);
        $invoice->setInvoiceDate($invoice_date);

        updateInvoice($invoice);
      
        $lastInvoceDate = getStudentPaymentDate($id);
        $newStudent = New Student;
        $newStudent->setFee($lastInvoceDate[1]);
        $newStudent->setDuration($lastInvoceDate[2]); 
        $newStudent->setStart_new($lastInvoceDate[3]);
        $newStudent->setExpire_new($lastInvoceDate[4]);
        $newStudent->setExpirePaymentDate($lastInvoceDate[0]);
        $newStudent->setStudentID($id);
          
          updateStudentPayment($newStudent);
      }
      
//      var_dump($invoice);
      header("Location:invoice.php?id=" . $invoice_id);
    } 
  } 
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Update Payment
            <small>
              Edit payment information for
              <a href="student_detail.php?id=<?php echo $student->getStudentID(); ?>">
                 <?php echo $student->getStudentName(); ?>
              </a>
            </small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php"> Payment Management</a></li>
            <li><a href="payment_invoice.php"> Payment &amp; Invoice</a></li>
            <li class="active"> Update Payment</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] .'?id=' . $invoice->getInvoiceID(); ?>" method="POST" id="paymentForm">
            <!-- Horizontal Form -->
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h2 class="box-title">Payment Form</h2>
                  </div>
                  <div class="box-body"> 
                    <input type="hidden" name="student_id" value="<?php echo $student->getStudentID() ?>">
                    <input type="hidden" name="invoice_id" value="<?php echo $invoice->getInvoiceID() ?>">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 col-sm-3 col-xs-3 control-label">Invoice Number</label>
                          <div class="col-md-8 col-sm-10 col-xs-10"> 
                             <input class="form-control" name="invoice_number" placeholder="Invoice Number" value="<?php echo $invoice->getInvoiceNumber() == ''? $invoice->getInvoiceID() : $invoice->getInvoiceNumber() ?>">
                             <span class="error col-md-12 no-padding"><?php echo $invoice_number_err;?></span>
                          </div>
                          <label class="col-md-4 col-sm-2 col-xs-2 control-label">Pay for</label>
                          <div class="col-md-8 col-sm-10 col-xs-10 select">
                            <select name="duration" id="class_id" data-placeholder="Select course duration" class="form-control chosen-select" tabindex="2">
                              <option></option>
                              <?php 
                                foreach($course as $key => $value) {
                                  $selected = $course[$key]['duration'] == $invoice->getDuration() ? 'selected' : '';
                                  echo "<option value='" . $course[$key]['duration'] . "' " . $selected . ">" .
                                               $course[$key]['course_name'] . "</option>";
                                  }
                              ?>                                  
                            </select>
                            <span class="error col-md-12 no-padding"><?php echo $duration_err;?></span>
                          </div>  
                        </div>
                          <label class="col-md-4 col-sm-2 col-xs-2 control-label">Start Date</label>
                                        <div class="col-md-8 col-sm-10 col-xs-10 datetime-plus">
                                            <div class='input-group date'>
                                                <input type='text' name="start_new" id="start" class="form-control" placeholder="Start Date" readonly  value=" <?php echo dateFormat($invoice->getStart_new(),'d/F/Y');?> ">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-4 col-sm-3 col-xs-3 control-label">Payment Date</label>
                          <div class="col-md-8 col-sm-10 col-xs-10"> 
                            <div class='input-group date'>
                              <input type='text' name="payment_date" id="payment_date" class="form-control" placeholder="Payment Date" 
                                                       value="<?php echo dateFormat($invoice->getInvoiceDate(),'d/F/Y');?>">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <span class="error col-md-12 no-padding"><?php echo $payment_date_err;?></span>
                            </div>
                            <span class="error col-md-12 no-padding"><?php echo $fee_err;?></span>
                          </div>
                          <label class="col-md-4 col-sm-3 col-xs-3 control-label">Paid Fee</label>
                          <div class="col-md-8 col-sm-10 col-xs-10">
                            <input class="form-control" name="fee" placeholder="Payment Fee" value="<?php echo $invoice->getFee(); ?>">
                            <span class="error col-md-12 no-padding"><?php echo $fee_err;?></span>
                          </div>
                        </div>
                          <label class="col-md-3 col-sm-4 col-xs-3 control-label"> Expire</label>
                                        <div class="col-md-8 col-sm-10 col-xs-10 datetime-plus">
                                            <div class='input-group date'>
                                                <input type='text' name="expire_new" id="expire" class="form-control" placeholder="Expire Date" readonly 
                                                      value="<?php echo dateFormat($invoice->getExpire_new(), 'd/F/Y'); ?>"  
                                                >
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                      </div>                                
                    </div>        
                    <div class="box-footer">
                      <div class="col-md-12 col-md-offset-1 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2 no-padding">
                        <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i>&nbsp;Update</button>
                      </div>
                    </div>                  
                  </div>
                </div>
              </div>                   
            </div><!-- /.row -->
          </form>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php
  include 'includes/footer.php';
?>

<!-- bootstrap chosen -->
<script src="../js/chosen.jquery.js"></script>

<script src="../js/moment-with-locales.min.js"></script>

<!-- bootstrap datetime picker -->

<script src="../js/bootstrap-datetimepicker.min.js"></script>

<!-- intl tel input -->

<script src="../js/intlTelInput.min.js"></script>

<!-- iCheck 1.0.1 -->

<script src="../plugins/iCheck/icheck.min.js"></script>


<script>  

  $(document).ready(function() {
    $('#paymentForm')
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
    .find('[name="duration"]').chosen({
      width: '100%'
    })
    // Revalidate the color when it is changed
    .change(function(e) {
      $('#paymentForm').formValidation('revalidateField', 'duration');
    }).end()        
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
        fee: {
          validators: {
            notEmpty: {
              message: 'The fee is required'
            },
            greaterThan: {
              value: 1,
              message: 'The value cannot be 0'
            },            
            numeric: {
              message: 'The value is not a number',
              decimalSeparator: '.'                                      
            },
            stringLength: {
              max: 7,
              trim: true,
              message: 'Please input the number within 7 digit.'
            }            
          }
        },
        duration: {
          validators: {
            notEmpty: {
              message: 'Duration is require'
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
    prevalidateForm('#paymentForm');
    $("#start").blur(function(){
         var months = [
                'January', 'February', 'March', 'April', 'May',
                'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ];
            var getStartDate = $('#start').val();
            var pay_month = $('#class_id :selected').val();
            getStartDate = getStartDate.split("/");
            var month = parseInt(monthNameToNum(getStartDate[1])+ parseInt(pay_month));
            var timeStartSate = month + "/" + getStartDate[0] + "/" + getStartDate[2];
            var getExpireDay = getStartDate[0];
             if(month > 12){
                var getExpireMonth = monthNumToName(month-12);
                var getExpireYear = parseInt(getStartDate[2])+1;
            }else{
                var getExpireMonth = monthNumToName(new Date(timeStartSate).getMonth()+1);
                var getExpireYear = new Date(timeStartSate).getFullYear();
            }
            var getExpireDate = getExpireDay +'/'+getExpireMonth+'/'+getExpireYear;
            $('#expire').val(getExpireDate);

            function monthNumToName(monthnum) {
                return months[monthnum - 1] || '';
            }
            function monthNameToNum(monthname) {
                var month = months.indexOf(monthname);
                if(month=>0){
                    month = month + 1;
                }else{
                    month = 0;
                }
                return month;
            }
    });
     $("#class_id").change(function () {
            var months = [
                'January', 'February', 'March', 'April', 'May',
                'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ];
            var getStartDate = $('#start').val();
            var pay_month = $('#class_id :selected').val();
            getStartDate = getStartDate.split("/");
            var month = parseInt(monthNameToNum(getStartDate[1])+ parseInt(pay_month));
            var timeStartSate = month + "/" + getStartDate[0] + "/" + getStartDate[2];
            var getExpireDay = getStartDate[0];
             if(month > 12){
                var getExpireMonth = monthNumToName(month-12);
                var getExpireYear = parseInt(getStartDate[2])+1;
            }else{
                var getExpireMonth = monthNumToName(new Date(timeStartSate).getMonth()+1);
                var getExpireYear = new Date(timeStartSate).getFullYear();
            }
            var getExpireDate = getExpireDay +'/'+getExpireMonth+'/'+getExpireYear;
            $('#expire').val(getExpireDate);

            function monthNumToName(monthnum) {
                return months[monthnum - 1] || '';
            }
            function monthNameToNum(monthname) {
                var month = months.indexOf(monthname);
                if(month=>0){
                    month = month + 1;
                }else{
                    month = 0;
                }
                return month;
            }
        });
    
  });  
   $(function () {
        //bootstrap-datetime-picker
        $('.date').datetimepicker({
            format: 'DD/MMMM/YYYY',
            allowInputToggle: true,
            ignoreReadonly: true,
            useCurrent: true,
            showClear: true,
            // minDate: new Date(),
            showClose: true,
            showTodayButton: true
        }).on('dp.change dp.show', function (e) {
            // Revalidate the dob field
//                $('#paymentForm').formValidation('revalidateField', 'start');
//                $('#paymentForm').formValidation('revalidateField', 'expire');
        });
    
  });  

</script>