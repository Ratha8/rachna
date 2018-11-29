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
        $photo = '<img height="106" src="uploads/'.$student->getPhoto().'" width="93">';
      }else{
        $photo = '<span style="display:block;border:1px solid #000;height:120px;width:100px"></span>';
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
  </head>
  <body>
    <div class="page">
      <div class="subpage">
        <section class="invoice no-margin">
            <div class="row">
              <div class="WordSection1" style='text-align:center;'>
              <p align="center" class="MsoNormal" id="in-bg" style='text-align:center;'>
                <img alt="Rachna International School" src="../images/certificate/image001.jpg"></p>
               <br clear="all">
              </p>
              <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 450px;'>
                <b class ="orage" style='font-size:26.0pt;line-height: 150%;font-family:"Elephant","serif";color:#E36C0A!important'><?php echo $student->getLatinName()?></b>
              </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 555px;'>
                  <b class="blue" style='font-size:15.0pt; line-height:150%;font-family:"Arno Pro Caption","serif";color:#002060!important'>born on</b> 
                  <span class ="orage" style='font-size:15.0pt;line-height:150%;font-family:"Arno Pro Caption","serif"; color:#E36C0A!important'><?php echo dateFormat($student->getDob(), "F d, Y, ");?></span>
                  <b class = 'blue' style='font-size:12.0pt;line-height:150%;font-family:"Arno Pro Caption","serif"; color:#002060!important'>has successfully completed</b>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 595px;'>
                  <span style='font-size:12.0pt;line-height: 150%;font-family:"Elephant","serif";color:#E36C0A !important'>
                    Level: <?php echo $records->getLevel()?>
                  </span>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 620px;'><span style='font-size:12.0pt;line-height: 150%;font-family:"Elephant","serif";color:red!important'>Grade: <?php echo $records->getGrade()?></span></p>
                <p align="center" class="MsoNormal blue" style='margin-bottom:0in;margin-bottom:.0001pt;padding-left: 40px; text-align:center;line-height:normal;position: absolute; width: 720px; top: 680px;'><b><span style='font-size:15.0pt; font-family:"Arno Pro Caption","serif";color:#002060!important;font-weight: bold;'><?php echo $records->getDetail()?></span></b></p>
                <table align="left" cellpadding="0" cellspacing="0" style="position: absolute; bottom: 150px;left: 40px;">
                  <tr>
                    <td height="43" width="32"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><img height="149" src="../images/certificate/image006.png" width="179"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>
                      <span style='font-size:13.0pt;font-family:"Elephant","serif";color:#002060!important'>Issued Date</span><br>
                      <span style='font-size:13.0pt;font-family:"Elephant","serif";color:#002060!important'><?php echo dateFormat($records->getIssueDate(), "F d, Y");?></span><br>
                      <span style='font-size:13.0pt;font-family:"Elephant","serif";color:#002060!important'>No: <?php echo $records->getNo();?>/RIS</span>
                    </td>
                  </tr>
                </table>
                <span style='position:absolute;z-index:251677683; margin-top:17px;position: absolute; left: 43%; top: 745px;'>
                  <?php echo $photo; ?>
                </span>
                <p class="MsoNormal blue" style='margin-bottom:0in;margin-bottom:.0001pt;line-height: normalposition;position: absolute; bottom: 140px;right: 195px'>
                <span style='font-size:12.0pt;font-family:"Elephant","serif"; color:#002060!important'> Mrs. Phean Rachna</span></p>
                <p class="MsoNormal blue" style='margin-top:0in;margin-right:0in;margin-bottom:0in; margin-left:3.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;position: absolute;  bottom: 120px;;right: 200px'>
                <span style='font-size:12.0pt;font-family:"Elephant","serif";color:#002060!important'>School Director</span></p>
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
        width: 210mm;
        height: 297mm;
        margin: 0mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        width: 210mm;
        height: 297mm;
    }
    .invoice{
          background: none;
          padding: 0.51cm 0.59cm;
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
           {font-family:"Arno Pro Caption";
           panose-1:0 0 0 0 0 0 0 0 0 0;}
        @font-face
           {font-family:"Khmer OS Muol Light";
           panose-1:2 0 5 0 0 0 0 2 0 4;}
        @font-face
           {font-family:Algerian;
           panose-1:4 2 7 5 4 10 2 6 7 2;}
        @font-face
           {font-family:Elephant;}
        @font-face
           {font-family:"Lucida Handwriting";
           panose-1:3 1 1 1 1 1 1 1 1 1;}
        @font-face
           {font-family:"Arno Pro Smbd Caption";
           panose-1:0 0 0 0 0 0 0 0 0 0;}
        /* Style Definitions */
        p.MsoNormal, li.MsoNormal, div.MsoNormal
           {margin-top:0in;
           margin-right:0in;
           margin-bottom:10.0pt;
           margin-left:0in;
           line-height:115%;
           font-size:11.0pt;
           font-family:"Calibri","sans-serif";}
        .MsoChpDefault
           {font-family:"Calibri","sans-serif";}
        .MsoPapDefault
           {margin-bottom:10.0pt;
           line-height:115%;}
        @page WordSection1
           {size:595.35pt 841.95pt;
           margin:36.85pt 42.55pt 36.85pt 42.55pt;}
        div.WordSection1
           {page:WordSection1;}
        -->
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
            width: 210mm;
            height: 297mm;
            margin: 0cm 0cm 0cm 0cm;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }

        .subpage {
            padding: 0cm 0cm 0cm 0.5cm;
            width: 210mm;
            height: 297mm;
        }     

        h1 {
          color: rgba(0, 0, 0, 0);
          text-shadow: 0 0 0 #ccc;
        }

        @media print and (-webkit-min-device-pixel-ratio:0) {
          h1 {
            color: #000;
            -webkit-print-color-adjust: exact;
          }
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
    </div>
  </body>
</html>
