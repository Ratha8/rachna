<?php
  include 'includes/header.php';
  include '../model/managecertificate.php';
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
    $certificate = getCertificateByID($id);
    $en_number_arr=array('0','1','2','3','4','5','6','7','8','9' ,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
    $kh_number_arr=array('០','១','២','៣','៤','៥','៦','៧','៨','៩','មករា','កុម្ភះ','មិនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិឆ្ឆិកា','ធ្នូ');
    if($certificate === null) {
      header("Location:404.php");
    } else { 
      $student = getOneStudent($records->getStudentID());    
      if(!empty($student->getPhoto()) && ($student->getPhoto() == 'no-img.jpg')){
        $photo = '<img src="uploads/'.$student->getPhoto().'" style="width: 150px">';
      }else{
        $photo = '<span style="border:1px solid #000000;height:106px;width:93px;display: block;margin-left:44%"></span>';
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
                    <a href="certi_compa_print.php?id=<?php echo $id ?>" target="_blank" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                  </div>
                </div> 
                <div class="WordSection1" style='text-align:center;'>
              <p align="center" class="MsoNormal" style='text-align:center;'>
                <img alt="Rachna International School" height="1065" src="../images/certificate/image003.jpg" width="727"></p>
               <br clear="all">
              <p align="center" class="MsoNormal" style='text-align:center;line-height:150%; top: 525px;'>
                <b style='font-size:28.0pt;line-height: 150%;font-family:"Khmer OS Muol Light","serif";color:#E36C0A'><?php echo $student->getStudentName()?></b>
              </p>
                <p align="center" class="MsoNormal" style=' text-align:center;line-height:150%; top: 590px;'>
                  <span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>កើតថ្ងៃទី</span>
                  <span style='font-size:12.0pt;line-height:150%;font-family:"Arno Pro Caption","serif"; color:#E36C0A'><?php echo str_replace($en_number_arr, $kh_number_arr, dateFormat($student->getDob(), " d M Y"));?></span> 
                  <span style='font-size:12.0pt; line-height:150%;font-family:"Arno Pro Caption","serif";color:#E36C0A'></span>
                  <span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>មត្តេយ្យភាសាអង់គ្លេស</span>
                  <span style='font-size:14.0pt;line-height: 150%;font-family:"Elephant","serif";color:red'>កំរិត: <?php echo $records->getLevel()?></span>
                </p>
                <p align="center" class="MsoNormal" style='margin-bottom:0in;margin-bottom:.0001pt; text-align:center;line-height:150%; top: 615px;'>
                  <span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>ដែលបានខិតខំប្រឹងប្រែងរៀនសូត្រយ៉ាងសកម្មរហូតទទួលបានជ័យលាភី</span>
                </p>
                <p align="center" class="MsoNormal" style=' text-align:center;line-height:150%; top: 635px;'><span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>ជា</span>
                  <span style='font-size:16.0pt;line-height: 150%;font-family:"Kh MPS Fasthand","serif";'><?php echo $records->getDetail()?></span>
                  <span style='font-size:12.0pt;font-family:"Kh MPS Fasthand"'>ប្រចាំ <?php echo $type_month.' '.$get_month; ?>  ឆ្នាំសិក្សា <?php echo $records->getYear();?></span></p>
              
                <p class="MsoNormal" style='display: block; top: 715px;'>
                  <span style='font-size:10.0pt;font-family:"Kh MPS Fasthand","serif";'>No: <?php echo $records->getNo();?>/RIS</span>
                  <?php echo $photo; ?>
                </p>
                 <p class="MsoNormal" style='padding-right: 90px; line-height:150%; top: 750px;text-align: right;' align="right">
                  <span style='font-size:10.0pt;font-family:"Elephant","serif";'>ភ្នំពេញ,<?php echo str_replace($en_number_arr, $kh_number_arr, dateFormat($records->getDate(), "ថ្ងៃទី d ខែ M ឆ្នាំ Y"));?></span></p>
                <p class="MsoNormal" style='margin: 0 0 0 195px; bottom: 200px;'><span style='font-size:12.0pt;font-family:"Khmer OS Muol Light","serif"; color:#002060'> <?php echo $class->getTeacherName(); ?></span></p>
                <p class="MsoNormal" style='margin: 0 0 0 170px;text-indent:.5in;line-height:normal;  bottom: 170px;''>
                <span style='font-size:11.0pt;font-family:"Khmer OS Content","serif";color:#002060'>គ្រូបន្ទុកថ្នាក់</span></p>
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
