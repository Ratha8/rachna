<?php
  include 'includes/header.php';
  include '../model/managecertificate.php';
  // include '../model/managesettings.php';
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $records = getCertificateByID($id);
    $certificate = getCertificateByID($id);
    if($certificate === null) {
      header("Location:404.php");
    } else { 
      $student = getOneStudent($records->getStudentID());    
      if(!empty($student->getPhoto()) && ($student->getPhoto() == 'no-img.jpg')){
        $photo = '<img src="uploads/'.$student->getPhoto().'" style="width: 150px">';
      }else{
        $photo = '<span style="border:1px solid #000000;height:106px;width:93px;display: block;margin-left:44%"></span>';
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
            <li><a href="manage_payment.php">Payment Management</a></li>
            <li><a href="payment_invoice.php">Payment &amp; Invoice</a></li>
            <li><a href="invoice_list.php?id=<?php echo $student->getStudentID(); ?>">Invoice List</a></li>
            <li class="active">Invoice Preview</li>
          </ol>
        </section>

        <!-- Main content -->
          <section class="certificate">
            <div class="row">
              <div class="col-xs-12">
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-xs-12">
                    <a href="certi_fulltime_print.php?id=<?php echo $id ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                  </div>
                </div> 
                <div class="WordSection1" style='text-align:center;'>
              <p align="center" class="MsoNormal" style='text-align:center;'>
                <img alt="Rachna International School" height="1065" src="../images/certificate/image001.jpg" width="727"></p>
               <br clear="all">
                <!-- <p align="center" class="MsoNormal" style='text-align:center; top: 265px;'>
                  <img alt="Rachna International School" src="../images/certificate/image002.png">
                </p> -->
              <p align="center" class="MsoNormal" style='text-align:center; top: 400px;'>
                <span style='font-size:12.0pt;line-height:115%;font-family:"Elephant","serif"; color:black'>This is to certify that</span>
              </p>
              <p align="center" class="MsoNormal" style='text-align:center;line-height:150%; top: 480px;'>
                <b style='font-size:26.0pt;line-height: 150%;font-family:"Elephant","serif";color:#E36C0A'><?php echo $student->getLatinName()?></b>
              </p>
                <p align="center" class="MsoNormal" style=' text-align:center;line-height:150%; top: 590px;'><b>
                  <span style='font-size:15.0pt; line-height:150%;font-family:"Arno Pro Caption","serif";color:#002060'>born on</span></b> 
                  <span style='font-size:15.0pt;line-height:150%;font-family:"Arno Pro Caption","serif"; color:#E36C0A'><?php echo dateFormat($student->getDob(), "F d, Y, ");?></span> <b>
                  <span style='font-size:15.0pt; line-height:150%;font-family:"Arno Pro Caption","serif";color:#E36C0A'></span></b><b>
                  <span style='font-size:15.0pt;line-height:150%;font-family:"Arno Pro Caption","serif"; color:#002060'>has successfully completed</span></b>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%; top: 615px;'>
                  <span style='font-size:12.0pt;line-height: 150%;font-family:"Elephant","serif";color:#E36C0A'>Level: <?php echo $records->getLevel()?></span>
                </p>
                <p align="center" class="MsoNormal" style=' text-align:center;line-height:150%; top: 635px;'><span style='font-size:12.0pt;line-height: 150%;font-family:"Elephant","serif";color:red'>Grade: <?php echo $records->getGrade()?></span></p>
                <p align="center" class="MsoNormal" style=' text-align:center;line-height:normal; top: 710px;'><b><span style='font-size:15.0pt; font-family:"Arno Pro Caption","serif";color:#002060'><?php echo $records->getDetail()?></span></b></p>
                <table align="left" cellpadding="0" cellspacing="0" style="position: absolute; bottom: 85px;margin: 0 0 0 50px;">
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
                <span class="MsoNormal" style='display: block; top: 810px;'>
                  <?php echo $photo; ?>
                </span>
                <p class="MsoNormal" style='margin: 0 0 0 195px; bottom: 100px;'><span style='font-size:12.0pt;font-family:"Elephant","serif"; color:#002060'> Mrs. Phean Rachna</span></p>
                <p class="MsoNormal" style='margin: 0 0 0 170px;text-indent:.5in;line-height:normal;  bottom: 70px;''>
                <span style='font-size:12.0pt;font-family:"Elephant","serif";color:#002060'>School Director</span></p>
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
        
      </style>
<?php
  include 'includes/footer.php';
?>      
