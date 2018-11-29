<?php
  include '../model/manageuser.php';
  include '../model/util.php';
  include '../model/managestudent.php';
  include '../model/manageclass.php';

  session_start();
  ob_start();
  if(!$_SESSION['user']){
     header("Location:../index.php");
  }else{
    $user_session = unserialize($_SESSION["user"]);
  }

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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rachna | Invoice</title>
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
        <div class="subpage">
          <section class="invoice no-margin">
            <div class="row">
              <div class="col-xs-12">
                  <div class="noti-header">
                    <div class="row">
                      <div class="col-md-6 logo-noti" style="border: 1px solid">
                        <img src="../images/logo.jpg">
                        <h4 class="khmer">
                          <p>សាលា អន្តរជាតិ រចនា</p>
                          <p><b>Rachna Internatiol School</b></p>                          
                        </h4>
                      </div>
                      <div class="col-md-9 col-md-offset-2 text-right center minus-top-sm">
                        <h5 class="khmer">
                          <p>ព្រះរាជាណាចក្រកម្ពុជា</p>
                          <p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
                        </h5>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            
            <div class="row noti-info">
                <h5 class="khmer center">
                  <span>លិខិតជូនព័ត៌មានអំពីការបង់ប្រាក់ថ្លៃសិក្សាបន្ត</span>
                </h5> 
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div>
                    <p class="pad-left-lg">
                      សូម​គោរព​ជូនព័ត៌មានចំពោះមាតាបិតា/អាណាព្យាបាលរបស់សិស្សឈ្មោះ&nbsp;
                      <span class="block-noti-lg">
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
                      <span class="block-noti-md">
                        <i><b>
                          <?php echo $level != null ? $level->getLevelName() : '<span class="text-red">Unkown</span>'; ?>
                        </b></i>                          
                      </span>
                      ម៉ោងសិក្សា&nbsp;
                      <span class="block-noti-sm">
                        <i><b>
                          <?php
                            $start_time = $clazz != null ? dateFormat($clazz->getStartTime(), "g:i A") : '<span class="text-red">Unkown</span>';
                            $end_time = $clazz != null ? dateFormat($clazz->getEndTime(), "g:i A") : '<span class="text-red">Unkown</span>';
                            echo $start_time . " - " . $end_time; 
                          ?>
                        </b></i>                          
                      </span>
                      បន្ទប់&nbsp;
                      <span class="block-noti-xs">
                        <i><b>
                          <?php echo $clazz != null ? $clazz->getClassName() : '<span class="text-red">Unkown</span>'; ?>
                        </b></i>                          
                      </span>
                    </p>
                    <p class="pad-left-lg">
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
                    <p class="pad-left-lg">
                      អាស្រ័យដូចបានជំរាបជូនខាងលើសូមលោក លោកស្រីមេត្តាអញ្ជើញមកធ្វើការបង់ថ្លៃសិក្សា តាមកាលបរិច្ឆេទកំណត់ខាងលើ។
                    </p>
                    <p class="pad-left-lg">
                      យើងខ្ញុំសូមថ្លែងអណរគុណយ៉ាងជ្រាលជ្រៅចំពោះការសហការរបស់មាតាបិតា/អាណាព្យាបាលសិស្សទាំងអស់
                    </p>
                    <div class="center">
                      <p>
                        សូមលោក លោកស្រីទទួលនូវការគោរពរាប់អានដ៏ខ្ពង់ខ្ពស់អំពីយើងខ្ញុំ។
                      </p>
                    </div>
                  </div>
                  <div class="plus-top">
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
        </div>    
        <!-- <hr> -->



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
        /*width: 210mm;*/
        /*min-height: 297mm;*/
        /*min-height: 193mm;*/
        width: 210mm;
        height: 148mm;
        /*padding: 20mm;*/
        margin: 0mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        /*width: 180mm;*/
        height: 143mm;
        width: 210mm;
    }
    
    @page {
        size: A5 landscape;
        margin: 0;    
    }

    @media print {
        html, body {
            /*width: 210mm;*/
            /*height: 297mm;*/
            width: 210mm;
            height: 148mm;
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
            padding: 0mm 1cm 0mm;
            /*border: 5px red solid;*/
            /*height: 297mm;*/
            /*width: 180mm;*/
            /*height: 143mm;*/
            /*width: 210mm;*/
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
            width: 157px;
            text-align: center;
        }        

        .block-sm-dot {
            border-bottom: 1px dotted;
            font-style: italic;
            font-weight: bold;            
            line-height: 13px;
            display: inline-block;
            width: 72px;
            text-align: center;
        }

        .block-md-dot {
          border-bottom: 1px dotted;
          font-style: italic;
          font-weight: bold;          
          line-height: 13px;
          display: inline-block;
          width: 232px;
          text-align: center;
        }   

        .block-lg-dot {
            display: inline-block;
            font-style: italic;
            font-weight: bold;            
            border-bottom: 1px dotted;
            line-height: 13px;
            width: 287px;
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
            /*margin: 0px 0px 55px;*/
            margin: 50px 0px -7px 0px;
        }

        .stamp {
          margin: 0px 0px 100px 0px;
        }

        hr {
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

        .logo-inv img {
          width: 85px;
          float: left;
        }

        .logo-noti img {
          float: left;
          width: 55px;
          margin: -5px 15px 5px 0px;
        }

        .noti-header {
            margin: 55px 0px 0px;
        }

        .minus-top-sm {
            margin-top: -75px;
        }       

        .text-right {
            margin-left: 70%;
        }  

        .col-md-offset-1 {
            margin-left: 10%;
        }        

        .noti-info {
          font-size: 12.5px;
        }

        .block-noti-lg {
          border-bottom: dotted 1px;
          line-height: 10px;
          display: inline-block;
          width: 270px;
          text-align: center; 
        }

        .block-noti-md {
          border-bottom: dotted 1px;
          line-height: 10px;  
          display: inline-block;
          width: 237px;
          text-align: center;
        }

        .block-noti-sm {
            border-bottom: dotted 1px;
            line-height: 10px;
            display: inline-block;
            width: 125px;
            text-align: center;
        }

        .block-noti-xs {
            border-bottom: dotted 1px;
            line-height: 10px;
            display: inline-block;
            width: 83px;
            text-align: center;
        }        

        .noti-box {
          font-size: 10px !important;
          padding: 7px;
          margin-top: 15px;
          width: 55%;
        }

        .noti-box span {
          font-size: 10px !important;
        }

        .noti-box ul {
          padding-left: 25px;
          margin: 0px 0px 3px 0px;
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
    <!-- AdminLTE App -->
    <script src="../js/app.min.js"></script>
  </body>
</html>
