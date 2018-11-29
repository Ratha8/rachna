<?php
  include '../model/manageuser.php';
  include '../model/util.php';
  include '../model/managestudent.php';
  include '../model/manageclass.php';
  include '../model/manageinvoice.php';
  include '../model/managesettings.php';
  
  //  if($user_session->getRole() == 'Teacher') {
  //   header("Location:403.php");
  // }
  session_start();
  ob_start();
   $getsetting = getSettings();
  if(!$_SESSION['user']){
     header("Location:../index.php");
  }else{
    $user_session = unserialize($_SESSION["user"]);
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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../css/AdminLTE.min.css">
    <!-- Custom Style for page -->
    <link rel="stylesheet" href="../css/rachna.css"> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="page">
      <?php for($i = 0; $i <= 1; $i++) { ?>
        <div class="subpage">
          <section class="invoice no-margin">
            <div class="row">
              <div class="col-xs-12">
                  <div class="inv-header center border-bottom">
                    <h3 class="khmer">
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
                    </h3>
                    <?php if(isset($getsetting[0]['phone_number']) || !empty($getsetting[0]['phone_number'])){
                            echo '<span class="contact-info">ទូរស័ព្ទ: '.$getsetting[0]['phone_number'].'</span>';
                        }else{
                            echo '<span class="contact-info">ទូរស័ព្ទ: 023 64 04 955/ 010 47 57 88/ 012 47 57 88</span>';
                        }
                        ?>

                    <div class="row">
                      <div class="col-md-12 col-md-offset-1 logo-inv">
                       <?php if(isset($getsetting[0]['logo']) || !empty($getsetting[0]['logo'])){
                            echo '<img src="uploads/logo/'.$getsetting[0]['logo'].'">';
                        }else{
                            echo '<img src="../images/logo.jpg">';
                        }
                        ?>
                      </div>
                    </div>
                    
                    <div class="row margin-ver">
                      <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                      <div class="col-md-4 pull-left border radius s-pad">
                        <span class="center">
                        ប្រាក់​បង់​រួច​មិនអាច​ដកវិញបានទេ<br>
                        <b>NONREFUNDABLE</b>
                        </span>
                      </div>
                      <div class="pull-right s-padding left chk-info">
                        <i class="<?php echo $status == 1 ? 'fa fa-square-o' : 'fa fa-check-square-o'; ?>"></i>&nbsp;សិស្សចាស់បង់ប្រាក់<br>
                        <i class="<?php echo $status == 1 ? 'fa fa-check-square-o' : 'fa fa-square-o'; ?>"></i>&nbsp;សិស្សថ្មីបង់​ប្រាក់​
                      </div>  
                      </div>                
                    </div>
                  </div>
              </div>
            </div>
            
            <div class="row invoice-info">
                <h4 class="khmer center  underline">
                  <span>វិក័យប័ត្របង់ប្រាក់ (ពេញម៉ោងសិក្សា)</span>
                </h4>
                <span class="pull-right minus-top padding">
                  លេខ <span class="text-red dot"><b><?php echo str_pad($invoice->getInvoiceNumber() == '' ? $invoice->getInvoiceID() : $invoice->getInvoiceNumber(), 6, '0', STR_PAD_LEFT); ?></b></span>
                </span> 
                <div class="col-md-12 col-sm-12 col-xs-12 invoice-col">
                  <div>
                    <p>
                        ឈ្មោះ&nbsp;
                        <span class="block-md-dot">
                          <i><b>
                            <?php echo $student->getStudentName(); ?>
                          </b></i>                          
                        </span>
                        អក្សរឡាតាំង&nbsp;
                        <span class="block-md-dot">
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
                      <span class="block-lg-dot">
                        <i><b>
                          <?php echo $invoice->getLevel() != null ? $invoice->getLevel() : '<span class="text-red">Unknown</span>'; ?>
                        </b></i>
                      </span>
                      តម្លៃ&nbsp;
                      <span class="block-lg-dot">
                        <i><b>
                          $&nbsp;<?php echo $invoice->getFee(); ?>
                        </b></i>
                      </span>
                    </p>
                    <p>
                      សិក្សា&nbsp;
                      <span class="block-dot">
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
                      <span class="block-dot">
                        <i><b>
                          <?php echo $invoice->getClassName() != null ? $invoice->getClassName() : '<span class="text-red">Unknown</span>'; ?>
                        </b></i>
                      </span>
                      ច័ន្ទ-សុក្រ 
                    </p>
                    <p>
                      ថ្ងៃចូលសិក្សា​&nbsp;
                      <span class="block-dot">
                        <i><b>
                          <?php echo dateFormat($invoice->getEnrollDate(), 'd - m - y'); ?>
                        </b></i>
                      </span>
                      ថ្ងៃផុតកំណត់&nbsp;
                      <span class="block-dot">
                        <i><b>
                          <?php echo dateFormat($invoice->getExpirePaymentDate(), 'd - m - y'); ?>
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
                  <div class="pull-right center padding-hori signature">
                    <p>
                      ថ្ងៃទី&nbsp;<i class="dot"><b><?php echo dateFormat($invoice->getInvoiceDate(), 'd'); ?>&nbsp;</b></i>
                      ខែ&nbsp;<i class="dot"><b><?php echo dateFormat($invoice->getInvoiceDate(), 'm'); ?>&nbsp;</b></i>
                      ឆ្នាំ&nbsp;<i class="dot"><b><?php echo dateFormat($invoice->getInvoiceDate(), 'Y'); ?>&nbsp;</b></i><br></p>
                    <p>ហត្ថលេខា​និងឈ្មោះអ្នកទទួល</p>
                    <!-- <p class="signature"><i><b><?php echo $user_session->getUsername(); ?></b></i></p> -->
                  </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="radius center back-primary">
                  <h5 class="khmer-simple pad margin">
                    អាសយដ្ឋាន: ផ្ទះលេខ D10 ផ្លូវលេខ 371 ភូមិត្នោតជ្រុំ សង្កាត់ បឹងទំពុន ខ័ណ្ឌ មានជ័យ រាជធានីភ្នំពេញ
                  </h5>
                </div>
              </div>
            </div>        
          </section>
        </div>    
      <?php   
        echo $i == 0 ? '<hr class="no-margin">
                        <small><p class="center no-padding" style="margin:-5px 0px 0px">Developed by Realmax.</p></small>
                        <hr style="margin: -5px 0px 0px">' : ''; 
        } 
      ?>

<style type="text/css">
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        /*min-height: 193mm;*/
        /*padding: 20mm;*/
        margin: 0mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        width: 180mm;
        width: 210mm;
    }
    
    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        html, body {
            width: 210mm;
            height: 297mm;       
            -webkit-print-color-adjust: exact !important;  
        }

        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }

        .subpage {
            padding: 1.5mm 1cm 0mm;
            /*border: 5px red solid;*/
            /*height: 297mm;*/
            width: 180mm;
            width: 210mm;
            /*outline: 2cm #FFEAEA solid;*/
        }        

        .contact-info {
          font-size: 20px;
        }

        .border span {
          font-size: 15px;
        }

        .invoice-col {
          font-size: 17px;
          width: 100%;
        }

        .margin-ver {
          margin: 10px 0px;
        }

        .border span > b {
          font-size: 17px;
          padding: 0px;
        }

        .chk-info {
            font-size: 15px;
        }           

        .minus-top {
            margin-top: -45px;
            font-size: 17px;
        }            

        .padding-hori {
          padding-left: 15px;
          padding-right: 15px;
        }

        /*.print-line-xs-left {
          float: left;
          width: 30%;
          position: relative;
          min-height: 1px;
          padding-right: 15px;
          padding-left: 15px;
        }

        .print-line-xs-right {
          float: left;
          width: 20%;
          position: relative;
          min-height: 1px;
          padding-right: 15px;
          padding-left: 15px;
          text-align: center;
        }*/

        .invoice {
          width: 100%;
          border: 0;
          margin: 10;
          padding: 10;
        }

        .block-mini-dot {
            border-bottom: 1px dotted;
            font-style: italic;
            font-weight: bold;
            line-height: 13px;
            display: inline-block;
            width: 55px;
            text-align: center;
        }         

        .block-dot {
            border-bottom: 1px dotted;
            font-style: italic;
            font-weight: bold;            
            line-height: 13px;
            display: inline-block;
            width: 150px;
            text-align: center;
        }        

        .block-sm-dot {
            border-bottom: 1px dotted;
            font-style: italic;
            font-weight: bold;            
            line-height: 13px;
            display: inline-block;
            width: 75px;
            text-align: center;
        }
        .block-md-dot {
          border-bottom: 1px dotted;
          font-style: italic;
          font-weight: bold;          
          line-height: 13px;
          display: inline-block;
          width: 227px;
          text-align: center;
        }   

        .block-lg-dot {
            display: inline-block;
            font-style: italic;
            font-weight: bold;            
            border-bottom: 1px dotted;
            line-height: 13px;
            width: 283px;
            text-align: center;
        }                

        .border-bottom {
          border-bottom: 1px solid #030303;
        }    

        .margin-ver {
            margin: 3px 0px;
        }        

        .back-primary {
            background-color: #3C8DBC !important;
            color: white !important;
        }        
        
        .s-pad {
          padding: 5px 10px;
        }

        .text-red {
          color: #DD4B39 !important;
        }

        .dot {
          text-decoration: underline dotted !important;
        }

        .signature {
            margin: 0px 0px 45px;
            /*margin: 50px 0px -7px 0px;*/
        }

        hr {
          padding: 0px;
          margin-top: 0px;
          margin-bottom: 0px;
          border-width: 2px 0px 0px;
          border-style: solid black 2px;
        }

        .logo-inv img {
            width: 75px;
            float: left;
        }        

        .logo-inv {
            margin-top: -100px;
        }        

        .col-md-offset-1 {
            margin-left: 10%;
        }        
    }
</style>
    <!-- jQuery -->
    <script src="../js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript">
      $(function(){
        window.print();
      });
    </script>
  </body>
</html>
