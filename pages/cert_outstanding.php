<?php
  include 'includes/header.php';
  include '../model/managecertificate.php';
  // include '../model/managelevel.php';
  include '../model/manageclass.php';
  // include '../model/managesettings.php';
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $records = getCertificateByID($id);
    $student = getOneStudent($records->getStudentID());
    $class = getOneClass($student->getClassID());
    $type = $records->getTypeMonth();
    $year = $records->getYear();
    $duration = $records->getMonth();
    if ($records->getScore() <= 49)
      $mention = 'F';
    elseif ($records->getScore() <= 68)
      $mention = 'E';
    elseif ($records->getScore() <= 78)
      $mention = 'D';
    elseif ($records->getScore() <= 85)
      $mention = 'C';
    elseif ($records->getScore() <= 94)
      $mention = 'B';
    elseif ($records->getScore() >= 95)
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
    if($records === null) {
      header("Location:404.php");
    } else { 
      if(!empty($student->getPhoto()) && ($student->getPhoto() == 'no-img.jpg') ){
        $photo = '<img src="uploads/'.$student->getPhoto().'" style="width: 120px">';
      }else{
        $photo = '<span style="border:1px solid #000000;height:120px;width:100px;display: block;margin-left:44%"></span>';
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
            Student Name
            <small>#<?php echo $student->getStudentName(); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Certificate Preview</li>
          </ol>
        </section>

        <!-- Main content -->
          <section class="certificate">
            <div class="row">
              <div class="col-xs-12">
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-xs-12">
                    <a href="certi_outstanding_print.php?id=<?php echo $id ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                  </div>
                </div> 
                <div class="WordSection1" style='text-align:center;'>
              <p align="center" class="MsoNormal" style='text-align:center;'>
                <img alt="Rachna International School" height="1065" src="../images/certificate/image002.jpg" width="727"></p>
               <br clear="all">
                <!-- <p align="center" class="MsoNormal" style='top: 265px;'>
                  <img alt="Rachna International School" src="../images/certificate/image007.png">
                </p> -->
              <p align="center" class="MsoNormal" style='text-align:center; top: 400px;'>
                <span style='font-size:12.0pt;line-height:115%;font-family:"Elephant","serif"; color:black'>This is to certify that</span>
              </p>
              <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; line-height:150%; top: 480px;'>
                <b style='font-size:26.0pt;line-height:150%;font-family:"Elephant","serif";color:#C00000'><?php echo $student->getLatinName()?></b>
              </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; line-height:150%; top: 590px;'><b>
                  <b><span style='font-size:15.0pt;font-family:"Arno Pro Caption","serif";color:#002060'>Is the outstanding student of Full-Time English Program</span></b>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; line-height:150%; top: 615px;'>
                  <span style='font-size:12.0pt;font-family:"Elephant","serif";color:#C00000'>Level: <?php echo $records->getLevel()?></span>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; line-height:150%;top: 635px;'>
                <span style='font-size:12.0pt;line-height:150%;font-family:"Elephant","serif";color:#C00000'>Grade: <?php echo $records->getGrade()?></span></p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; line-height:normal; top: 700px;'><b><span style='font-size:15.0pt; font-family:"Arno Pro Caption","serif";color:#002060'><?php echo $records->getDetail()?></span></b></p>
                <p class="MsoNormal" style='padding-right: 65px; line-height:150%; top: 730px;text-align: right;' align="right">
                  <span style='font-size:10.0pt;font-family:"Elephant","serif"; color:#002060'>Date: <?php echo dateFormat($records->getDate(), "F d, Y");?></span></p>
                <p class="MsoNormal" style='padding-right: 65px;line-height: normalposition; top: 820px;text-align: right;' align="right" >
                  <span style='font-size:10.0pt;font-family:"Elephant","serif"; color:#002060'>……………………..<br><?php echo $class->getTeacherName(); ?></span></p>
                <table align="left" cellpadding="0" cellspacing="0" style="position: absolute; top: 800px;margin: 0 0 0 50px;">
                  <tr>
                    <td height="43" width="32"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><img height="149" src="../images/certificate/image006.png" width="179"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td style="text-align: center;">
                      <span style='font-size:10.0pt;font-family:"Elephant","serif";color:#002060'>Issued Date</span><br>
                      <span style='font-size:10.0pt;font-family:"Elephant","serif";color:#002060'><?php echo dateFormat($records->getIssueDate(), "F d, Y");?></span><br>
                      <span style='font-size:10.0pt;font-family:"Elephant","serif";color:#002060'>No: <?php echo $records->getNo();?>/RIS</span>
                    </td>
                  </tr>
                </table>
                <span class="MsoNormal" style='display: block; top: 820px;'>
                  <?php echo $photo; ?>
                </span>
                <p class="MsoNormal" style='margin: 0 0 0 195px; bottom: 100px;'><span style='font-size:12.0pt;font-family:"Elephant","serif"; color:#002060'> Mrs. Phean Rachna</span></p>
                <p class="MsoNormal" style='margin: 0 0 0 170px;text-indent:.5in;line-height:normal;  bottom: 75px;''>
                <span style='font-size:12.0pt;font-family:"Elephant","serif";color:#002060'>School Director</span></p>
              </div>   
              </div>
            </div>       
          </section>
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
      <style type="text/css">
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
        .WordSection1{
          width: 772px;
          display: block;
          margin: 0 auto;
          height: 1100px;
        }
        .MsoNormal{
          width: 772px;
          position: absolute;
          text-align: center;
        }
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
            width: 180mm;
            width: 210mm;
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
<?php
  include 'includes/footer.php';
?>      
