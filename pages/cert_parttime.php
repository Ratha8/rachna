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
      $student = getOneStudent($certificate->getStudentID());    
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
                    <a href="certi_parttime_print.php?id=<?php echo $id ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                  </div>
                </div> 
                <div class="WordSection1 page" style="position: relative;">
                <p class='MsoNormal'>
                  <span style='z-index:"251659767";margin-left:"-4px";margin-top:"0px";position: "absolute";width: "100%"'>
                    <img width='100%' src="../images/certificate/image004.jpg" alt=Border25>
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:280px;'>
                  <span class="text-small">
                      សូមបញ្ជាក់ថា <b style="font-family: 'Khmer OS Muol Light'"> <?php echo $student->getStudentName()?> </b> ភេទ     <?php echo $sexkh?>
                  </span>
                   <span class="text-small-en">
                      This is to certify that <b style="font-size: 14.0pt"> <?php echo $student->getLatinName()?>  </b>            sex:         <?php echo $sex?>
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:310px;'>
                  <span class="text-small">
                      ថ្ងៃខែឆ្នាំកំណើត <b style=";font-family: 'Khmer OS Muol Light'"> <?php echo $dobkh; ?> </b> 
                  </span>
                   <span class="text-small-en">
                      Born on: <b style="font-size: 14.0pt;"> <?php echo $dob; ?> </b> 
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:340px;'>
                   <span class="text-small">
                      បានបញ្ចប់វគ្គសិក្សា <b style="font-family: 'Khmer OS Muol Light'"> ភាសាអង់គ្លេសក្រៅម៉ោង </b> និទ្ទេស <b style="font-family: 'Khmer OS Muol Light'"> <?php echo $gradekh ?> </b></span>
                  <span class="text-small-en">
                      Has successfully completed: <b style="font-size: 12.0pt;"> Part-Time English Program </b>    
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:365px;'>
                  <span class="text-small">
                      ចាប់ផ្តើមពីថ្ងៃទី  <b style="font-family: 'Khmer OS Muol Light'"> <?php echo $s_datekh.' ដល់ '.$e_datekh; ?> </b>
                  </span>
                  <span class="text-small-en">
                      Grade:  <b style="font-size: 14.0pt;"> <?php echo $grade ?> </b> held from           <b style="font-size: 14.0pt;"><?php echo $s_date.' To '.$e_date; ?></b>
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:395px;'>
                  <span class="text-small">
                      មុខវិជ្ជាសិក្សា <b style="font-family: 'Khmer OS Muol Light'"> <?php echo $records->getDetail()?> </b>
                  </span>
                  <span class="text-small-en">
                      The course includes: <b style="font-size: 14.0pt;"> <?php echo $records->getDetail()?> </b>
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:425px;'>
                  <span class="text-small">
                      វិញ្ញាបនប័ត្រនេះចេញអោយសាម៉ីជនប្រើប្រាស់ តាមដែលអាចប្រើបាន ។
                  </span>
                  <span class="text-small-en">
                      This certificate is issued for official purposes.
                  </span>
                </p>
                <p class='MsoNormal MsoNormal-new' style='top:460px;'>
                  <span class="text-sp-no">
                      No:<?php echo $records->getNo();?>
                  </span>
                </p>
                 <p class='MsoNormal MsoNormal-new' style='top:500px;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;">
                    <?php echo $photo;?>
                  </span>
                </p>
                <p class='MsoNormal' style='position:absolute;z-index:251659767;left:80px;top:465px;width:80%;position: absolute;color: #011E6E;text-align: right;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;">
                    Phnom Penh, <?php echo $cur_date?>
                  </span>
                </p>
                <p class='MsoNormal' style='position:absolute;z-index:251659767;left:80px;top:485px;width:80%;position: absolute;color: #011E6E;text-align: right;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;">
                    EXECUTIVE DIRECTOR
                  </span>
                </p>
                <p class='MsoNormal' style='position:absolute;z-index:251659767;left:80px;bottom: 35px;width:80%;position: absolute;color: #011E6E;text-align: right;'>
                  <span style="font-size: 12.0pt;font-family: 'Arno Pro Caption';padding: 5px;width: 100%;display: inline-block;">
                    PHEAN RACHNA
                  </span>
                </p>
              </div>   
              </div>
            </div>       
          </section>
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
      <style type="text/css">
      .MsoNormal-new{
        position:absolute;
        width:100%;
        position: absolute;
      }
      .text-small{
        font-size: 12.0pt;
        font-family: 'Khmer OS Content';
        padding: 5px 5px 5px 30px;
        width: 50%;
        display: inline-block;
        color: #011E6E!important;
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
        text-align: center;
      }
    </style>
      <style type="text/css">
      .page {
        width: 950px;
        min-height: 650px;
        /*min-height: 193mm;*/
        /*padding: 20mm;*/
        margin: 0mm auto;
    }

    .subpage {
        width: 1120px;
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
  {size:841.7pt 595.45pt;
  margin:11.35pt 11.35pt 11.35pt 11.35pt;}
div.WordSection1
  {page:WordSection1;}
-->

      </style>
<?php
  include 'includes/footer.php';
?>      
