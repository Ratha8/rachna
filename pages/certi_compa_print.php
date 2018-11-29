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
    $class = getOneClass($student->getClassID());
    $certificate = getCertificateByID($id);
    $en_number_arr=array('0','1','2','3','4','5','6','7','8','9' ,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
    $kh_number_arr=array('០','១','២','៣','៤','៥','៦','៧','៨','៩','មករា','កុម្ភះ','មិនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិឆ្ឆិកា','ធ្នូ');
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
      switch ($records->getTypeMonth()) {
        case 1:
            $type_month = 'ខែរ';
            switch ($records->getMonth()) {
              case 1:
                $get_month = 'មករា';
                break;
              case 2:
                $get_month = 'កុម្ភះ';
                break;
              case 3:
                $get_month = 'មិនា';
                break;
              case 4:
                $get_month = 'មេសា';
                break;
              case 5:
                $get_month = 'ឧសភា';
                break;
              case 6:
                $get_month = 'មិថុនា';
                break;
              case 7:
                $get_month = 'កក្កដា';
                break;
              case 8:
               $get_month = 'សីហា';
                break;
              case 9:
                $get_month = 'កញ្ញា';
                break;
              case 10:
                $get_month = 'តុលា';
                break;
              case 11:
                $get_month = 'វិឆ្ឆិកា';
                break;
              default:
                $get_month = 'ធ្នូ';
                break;
            }
          break;
        case 2:
          $type_month = 'ត្រីមាសទី';
          switch ($records->getMonth()) {
              case 1:
                $get_month = '១';
                break;
              case 4:
                $get_month = '២';
                break;
              case 7:
                $get_month = '៣';
                break;
              default:
                $get_month = '៤';
                break;
              }
          break;
        case 3:
          $type_month = 'ឆមាសទី';
          switch ($records->getMonth()) {
              case 1:
                $get_month = '១';
                break;
              default:
                $get_month = '២';
                break;
              }
          break;
        default:
          $type_month = '';
          $get_month = '';
          break;
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
                <img alt="Rachna International School" src="../images/certificate/image003.jpg"></p>
               <br clear="all">
              </p>
              <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 500px;'>
                <b style='font-size:28.0pt;line-height: 150%;font-family:"Khmer OS Muol Light","serif";color:#E36C0A !important'><?php echo $student->getStudentName()?></b>
              </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 575px;'>
                  <span class="blue" style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>កើតថ្ងៃទី</span> 
                  <span class ="orage" style='font-size:15.0pt;line-height:150%;font-family:"Arno Pro Caption","serif"; color:#E36C0A!important'><?php echo str_replace($en_number_arr, $kh_number_arr, dateFormat($student->getDob(), " d M Y"));?></span> 
                  <span class = 'blue' style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>មត្តេយ្យភាសាអង់គ្លេស</span>
                  <span style='font-size:14.0pt;line-height: 150%;font-family:"Elephant","serif";color:red !important'>កំរិត: <?php echo $records->getLevel()?></span>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 610px;'>
                  <span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>ដែលបានខិតខំប្រឹងប្រែងរៀនសូត្រយ៉ាងសកម្មរហូតទទួលបានជ័យលាភី</span>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 630px;'>
                  <span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>ជា</span>
                  <span style='font-size:16.0pt;line-height: 150%;font-family:"Kh MPS Fasthand","serif";'><?php echo $records->getDetail()?></span>
                  <span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>ប្រចាំ <?php echo $type_month.' '.$get_month; ?>  ឆ្នាំសិក្សា <?php echo $records->getYear();?></span>
                </p>
                <p align="right" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%;position: absolute; width: 100%; top: 695px;'>
                  <span style='font-size:10.0pt;font-family:"Kh MPS Fasthand","serif";'>No: <?php echo $records->getNo();?>/RIS</span>
                </p>
                <span style='position:absolute;z-index:251677683; position: absolute; left: 44%; top: 720px;'>
                  <?php echo $photo; ?>
                </span>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:right;line-height:150%;position: absolute; width: 87%; top: 745px;'>
                  <span style='font-size:10.0pt;font-family:"Elephant","serif";'>ភ្នំពេញ,<?php echo str_replace($en_number_arr, $kh_number_arr, dateFormat($records->getDate(), "ថ្ងៃទី d ខែ M ឆ្នាំ Y"));?></span></p>
                <p class="MsoNormal blue" style='margin-bottom:0in;margin-bottom:.0001pt;line-height: normalposition;position: absolute; bottom: 230px;right: 155px'>
                <span style='font-size:12.0pt;font-family:"Khmer OS Muol Light","serif"; color:#002060!important'> <?php echo $class->getTeacherName(); ?></span></p>
                <p class="MsoNormal blue" style='margin-top:0in;margin-right:0in;margin-bottom:0in; margin-left:3.5in;margin-bottom:.0001pt;text-indent:.5in;line-height:normal;position: absolute;  bottom: 200px;;right: 160px'>
                <span style='font-size:12.0pt;font-family:"Elephant","serif";color:#002060!important'>គ្រូបន្ទុកថ្នាក់</span></p>
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
