<?php
  include '../model/manageuser.php';
  include '../model/util.php';
  include '../model/managestudent.php';
  include '../model/manageclass.php';
  include '../model/managecertificate.php';
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
    $records = getCertificateByID($id);
    $student = getOneStudent($records->getStudentID());
    $type = $records->getTypeMonth();
    $year = $records->getYear();
    $duration = $records->getMonth();
    $score = $records->getScore();
    if ($score <= 49)
      $mention = 'F';
    elseif ($score <= 68)
      $mention = 'E';
    elseif ($score <= 78)
      $mention = 'D';
    elseif ($score <= 85)
      $mention = 'C';
    elseif ($score <= 94)
      $mention = 'B';
    elseif ($score >= 95)
      $mention = 'A';
    if($type == 1){
      $getTyepe = '1 month';
      $month_name = date("F", mktime(0, 0, 0, $duration, 15));
      $month_number = $duration;
    }elseif ($type == 2){
      $getTyepe = 'Trimeter';
      if($duration == 1){
        $month_name = 'January to March';
        $month_number = 3;
      }elseif($duration == 4){
        $month_name = 'April to June';
        $month_number = 6;
      }elseif($duration == 7){
        $month_name = 'July to September';
        $month_number = 9;
      }else{
        $month_name = 'October to December';
        $month_number = 12;
      }
    }elseif ($type == 3){
      $getTyepe = 'Semester';
      if($duration == 1){
        $month_name = 'January to June';
        $month_number = 6;
      }else{
        $month_name = 'July to December';
        $month_number = 12;
      }
    }else{
      $getTyepe = '1 Year';
      $month_name = 'January to December';
      $month_number = 12;
    }
    if($student === null) {
      header("Location:404.php");
    } else { 
      $student = getOneStudent($records->getStudentID());    
      if(!empty($student->getPhoto()) && ($student->getPhoto() == 'no-img.jpg')){
        $photo = '<img src="uploads/'.$student->getPhoto().'" style="width: 150px">';
      }else{
        $photo = '<span style="border:1px solid #000000;height:120px;width:100px;display: block;margin-left:45%"></span>';
      }
        $sex = $student->getGender() == 1 ? 'Male' : 'Femal';
      $sexkh = $student->getGender() == 1 ? 'ប្រុស' : 'ស្រី';
      $grade = $records->getGrade();
      $gradekh = $records->getGrade();

      $gradekh = str_replace('A', 'លអរបត្សើរ', $gradekh);
      $gradekh = str_replace('B', 'លអណាស់', $gradekh);
      $gradekh = str_replace('C', 'លអ', $gradekh);
      $gradekh = str_replace('D', 'លអបងគួរ', $gradekh);
      $gradekh = str_replace('E', 'មធ្យម', $gradekh);
      $gradekh = str_replace('F', 'ខ្សោយ', $gradekh);

      $dob = date('F d, Y',strtotime($student->getDob()));
      $dobkh = datekh(date('d-F-Y',strtotime($student->getDob())));
      $s_date = date('d-m-Y',strtotime($records->getDate()));
      $e_date = date('d-m-Y',strtotime($records->getIssueDate()));
      $s_datekh = datekh(date('d-F-Y',strtotime($records->getDate())));
      $e_datekh = datekh(date('d-F-Y',strtotime($records->getIssueDate())));
      $cur_date = date('d/m/Y',strtotime($records->getRegisterDate()));
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
    <title>RACHNA | CERTIFICATE</title>
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
    <style type="text/css">
    	.MsoNormal-new{
    		position:absolute;
    		left:30px;
    		width:95%;
    		position: absolute;
    	}
    	.text-small{
    		font-size: 12.0pt;
    		font-family: 'Khmer OS Content';
    		padding: 5px;
    		width: 50%;
    		display: inline-block;
    		color: #011E6E!important;
        padding-left: 35px; 
    	}
    	.text-big{
    		font-size: 12.0pt;
    		font-family: 'Khmer OS Muol Light';
    		color: #011E6E!important;
    	}
    	.text-small-en{
    		font-size: 14.0pt;
    		font-family: 'Arno Pro Caption';
    		padding: 5px 5px 5px 30px;
    		width: 49%;
    		display: inline-block;
    		color: #011E6E!important;
    	}
    	.text-big-en{
    		font-size: 16.0pt;
    		font-family: 'Arno Pro Caption';
    		color: #011E6E!important;
    	}
    	.text-no{
    		position:absolute;
    		z-index:251659767;
    		top:540px;
    		width:100%;
    		position: absolute;
    		text-align: center;
    	}
    	.text-sp-no{
    		font-size: 12.0pt;
    		font-family: 'Comic Sans MS';
    		padding: 5px;
    		width: 100%;
    		display: inline-block;
    		color: #011E6E!important;
    	}
    </style>
  </head>
  <body>
    <div class="page">
      <div class="subpage">
        <section class="invoice no-margin">
            <div class="row">
              <div class="WordSection1" style="position: relative;">
                <p align="center" class="MsoNormal" id="in-bg" style='text-align:center;'>
                    <img src="../images/certificate/image004.jpg" alt=Border25>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:340px;'>
                  <span class="text-small">
                      សូមបញ្ជាក់ថា <b class="text-big"> <?php echo $student->getStudentName()?> </b> ភេទ     <?php echo $sexkh?>
                  </span>
                   <span class="text-small-en">
                      This is to certify that <b class="text-big-en"> <?php echo $student->getLatinName()?>  </b>            sex:         <?php echo $sex?>
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:375px;'>
                  <span class="text-small">
                      ថ្ងៃខែឆ្នាំកំណើត <b class="text-big"> <?php echo $dobkh; ?> </b> 
                  </span>
                   <span class="text-small-en">
                      Born on: <b style="font-size: 16.0pt;color: #011E6E!important"> <?php echo $dob; ?> </b> 
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:405px;'>
                   <span class="text-small">
                      បានបញ្ចប់វគ្គសិក្សា <b class="text-big"> ភាសាអង់គ្លេសក្រៅម៉ោង </b> និទ្ទេស <b class="text-big"> <?php echo $gradekh ?> </b></span>
                  <span class="text-small-en">
                      Has successfully completed: <b class="text-big-en"> Part-Time English Program </b>    
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:440px;'>
                  <span class="text-small">
                      ចាប់ផ្តើមពីថ្ងៃទី  <b style="font-size: 12.0pt;font-family: 'Khmer OS Muol Light';color: #011E6E!important"> <?php echo $s_datekh.' ដល់ '.$e_datekh; ?>  </b>
                  </span>
                  <span class="text-small-en">
                      Grade:  <b class="text-big-en"> <?php echo $grade ?> </b> held from           <b class="text-big-en"><?php echo $s_date.' To '.$e_date; ?></b>
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:475px;'>
                  <span class="text-small">
                      មុខវិជ្ជាសិក្សា <b class="text-big-en"> <?php echo $records->getDetail()?> </b>
                  </span>
                  <span class="text-small-en">
                      The course includes: <b class="text-big-en"> <?php echo $records->getDetail()?> </b>
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:515px;'>
                  <span class="text-small">
                      វិញ្ញាបនប័ត្រនេះចេញអោយសាម៉ីជនប្រើប្រាស់ តាមដែលអាចប្រើបាន ។
                  </span>
                  <span class="text-small-en">
                      This certificate is issued for official purposes.
                  </span>
                </p>
                <p class='MsoNormal text-no'>
                  <span class="text-sp-no">
                      No:<?php echo $records->getNo();?>
                  </span>
                </p>
                 <p class='MsoNormal' style='position:absolute;z-index:251659767;top:570px;width:100%;position: absolute;text-align: center;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;">
                    <?php echo $photo;?>
                  </span>
                </p>
                <p class='MsoNormal' style='position:absolute;z-index:251659767;padding-right:150px;top:540px;width:100%;position: absolute;text-align: right;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;color: #011E6E!important;">
                    Phnom Penh, <?php echo $cur_date?>
                  </span>
                </p>
                <p class='MsoNormal' style='position:absolute;z-index:251659767;padding-right:150px;top:570px;width:100%;position: absolute;text-align: right;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;color: #011E6E!important;">
                    EXECUTIVE DIRECTOR
                  </span>
                </p>
                <p class='MsoNormal' style='position:absolute;z-index:251659767;bottom: 45px;width:100%;padding-right:150px;position: absolute;text-align: right;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;color: #011E6E!important;">
                    PHEAN RACHNA
                  </span>
                </p>
              </div>
            </div>
        </section>
      </div>
      

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
        width: 297mm;
        height: 210mm;
        margin: 0mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        width: 297mm;
        height: 210mm;
    }
    .invoice{
          background: none;
          padding: 0.16cm;
        }
    #in-bg img{
      /*width: 100%;*/
    }
<!--
 /* Font Definitions */
 @font-face
  {font-family:"Cambria Math";
  panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
  {font-family:Calibri;
  panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
  {font-family:DaunPenh;
  panose-1:2 0 5 0 0 0 0 2 0 4;}
@font-face
  {font-family:"Limon R1";}
@font-face
  {font-family:"Khmer OS Muol Light";
  panose-1:2 0 5 0 0 0 0 2 0 4;}
@font-face
  {font-family:"Arno Pro Caption";
  panose-1:0 0 0 0 0 0 0 0 0 0;}
@font-face
  {font-family:Tacteing;}
@font-face
  {font-family:"Comic Sans MS";
  panose-1:3 15 7 2 3 3 2 2 2 4;}
@font-face
  {font-family:"Baskerville Old Face";
  panose-1:2 2 6 2 8 5 5 2 3 3;}
@font-face
  {font-family:BatangChe;}
@font-face
  {font-family:"Swis721 Blk BT";}
@font-face
  {font-family:"Khmer OS Content";
  panose-1:2 0 5 0 0 0 0 2 0 4;}
@font-face
  {font-family:Tahoma;
  panose-1:2 11 6 4 3 5 4 4 2 4;}
@font-face
  {font-family:"\@BatangChe";}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
  {margin:0in;
  margin-bottom:.0001pt;
  font-size:12.0pt;
  font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
  {mso-style-link:"Header Char";
  margin:0in;
  margin-bottom:.0001pt;
  font-size:12.0pt;
  font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
  {mso-style-link:"Footer Char";
  margin:0in;
  margin-bottom:.0001pt;
  font-size:12.0pt;
  font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
  {mso-style-link:"Balloon Text Char";
  margin:0in;
  margin-bottom:.0001pt;
  font-size:8.0pt;
  font-family:"Tahoma","sans-serif";}
p.MsoNoSpacing, li.MsoNoSpacing, div.MsoNoSpacing
  {mso-style-link:"No Spacing Char";
  margin:0in;
  margin-bottom:.0001pt;
  font-size:11.0pt;
  font-family:"Calibri","sans-serif";}
span.BalloonTextChar
  {mso-style-name:"Balloon Text Char";
  mso-style-link:"Balloon Text";
  font-family:"Tahoma","sans-serif";}
span.HeaderChar
  {mso-style-name:"Header Char";
  mso-style-link:Header;}
span.FooterChar
  {mso-style-name:"Footer Char";
  mso-style-link:Footer;}
span.NoSpacingChar
  {mso-style-name:"No Spacing Char";
  mso-style-link:"No Spacing";
  font-family:"Calibri","sans-serif";}
 /* Page Definitions */
 @page WordSection1
  {
    size:landscape;
    margin: 0.16cm;

  }
div.WordSection1
  {page:WordSection1;}
-->
   @page {
        size: landscape;
        margin: 0;
    }
    @media print {
        html, body {
            width: 290mm;
            height: 190mm;       
            -webkit-print-color-adjust: exact !important;  
        }
        .page {
            width: 290mm;
            height: 190mm;
            margin: 0 0 0 0.16cm;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
        .subpage {
            margin: 0 0 0 0.16cm;
            width: 290mm;
            height: 190mm;
        }
        #in-bg img{
          width: 100%;
        }
        .MsoNormal span{
          color: #011E6E;
        }
    }
</style>
<style type="text/css" media="print">
  @page {  }
</style>
    <!-- jQuery -->
    <script src="../js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript">

      $(function(){
        window.print();
      });
    </script>
    </div>
  </body>
</html>
