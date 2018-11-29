  <?php
    include '../model/manageuser.php';
    include '../model/util.php';
    include '../model/managestudent.php';
    include '../model/manageclass.php';
    include '../model/managereport.php';
    include '../model/manageexammarks.php';


    session_start();
    ob_start();
    if(!$_SESSION['user']){
       header("Location:../index.php");
    }else{
      $user_session = unserialize($_SESSION["user"]);
    }

     if(isset($_GET['id'])) {
      $id = $_GET['id'];
      $report = getOneReport($id);
      $student = getOneStudent($report['student_id']);
      $class = getOneClass($student->getClassID());
      $level = getOneLevel($class->getLevelID());
      $exam = getOneExamMark($report['mark_id']);
      // $countStu = COUNT(countStuMarkByID($exam->getExam_id(),$class->getClassID()));
      if($report === null) {
        header("Location:404.php");
      } else { 
        // $clazz = getOneClass($report->getClassID());
        // $level = $clazz != null ? getOneLevel($clazz->getLevelID()) : null;   
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

      <style type="text/css">
      p{
        margin: 0px;
      }
      .page{
        font-family: 'Khmer OS Content','Khmer OS Muol Light';
      }
      .border-score {
        height: 30px;
        border: 1px solid;
        width: 60px;
        padding: 3px;
        float: right;
        border-radius: 5px;
        margin-bottom:5px;
      }
      #preview .padding-score{
        padding-left: 5px;
      }
      #preview .noti-box span.padding-score,
      #preview .noti-box span.border-score-bot{
        font-size: 10pt !important;
      
      }
      .border-score-lg{
        width: 80px;
      }
      .border-score-md{
        width: 60px;
      }
      .pre-noti-info{
        font-family: 'Khmer OS Battambang' 'Times New Roman';
      }
      .khmer-score{
        font-family: 'Khmer OS Muol Light';
      }
      .khmer1-score{

      }
      .en-school{
        font-family: 'Lucida Handwriting';
      }
      .en-score{
        font-family: 'Times New Roman';
      }
      .border-score{
        text-align: center;
      }
      .pre-block-noti-md{
        width: 240px;
      }
      .text-center{
        text-align: center;
      }
      .col-md-4{
        width: 33.33%;
        float: left;
      }
      .col-md-12{
        width: 100%;
      }
      .border-score-bot{
        border-bottom: 1px solid #000;
        padding: 0 30px;
        margin: 0 10px;
        font-weight: bolder;
      }
      #preview .noti-box span{
        font-size: 13px !important;
      }
      .fz-13{
        font-size: 14px;
      }
      .fz-10pt{
        font-size: 10pt;
      }
      .pre-noti-info{
        font-size: 9pt;
      }
      .pd-br-5px{
        padding-bottom: 5px;
      }
  </style>
    </head>
    <body>
      <div class="page">
          <div class="subpage">
            <section class="invoice no-margin">
              <div class="row">
                <div class="col-xs-12" style="padding-left: 5px;padding-right: 5px">
                    <div class="noti-header">
                      <div class="row">
                      <div class="col-md-6 logo-noti" style="width: 50%;display: inline-block;">
                        <div class="col-md-9" style="width: 80%;text-align: center;">
                          <div class="col-md-12" style="width: 100%;">
                            <p style="height: auto;display: inline-block;"><img src="../images/logo.jpg"></p>
                            <p class="khmer khmer-score">សាលា អន្តរជាតិ រចនា</p>
                            <p class="en-school" style="font-size: 9pt;"><b>Rachna International School </b></p>
                          </div>
                        </div>
                      </div>
                       <div class="col-md-6 col-md-offset-2 text-right center minus-top-sm" style="float: right;margin: 0px;display: inline-block;">
                        <h4 class="khmer khmer-score">
                          <p class="pd-br-5px">ព្រះរាជាណាចក្រកម្ពុជា</p>
                          <p class="pd-br-5px">ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
                          <p><span style="font-family:Webdings">🙢🙢🙢🙠🙠🙠</span></p>
                        </h4>
                      </div>
                      </div>
                    </div>
                </div>
              </div>

              <div class="row pre-noti-info">
                <h4 class="khmer center" style="margin-top: -20px">
                  <p​ class="khmer-score fz-10pt">របាយការណ៏លទ្ទផល់នៃការសិក្សា</p>
                  <p class="en-score fz-10pt">Report on Student's Performance</p>
                </h4> 
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div style="border: 1px solid #000">
                        <p class="pad-left-xl" style="border-bottom: 1px solid #000; padding: 5px 30px;margin: 0;">
                          ឈ្មោះគ្រូ (Teacher’s Name):  &nbsp;
                          <b>
                              <?php echo $class->getTeacherName(); ?>
                            </b>
                        </p>
                        <p class="pad-left-xl" style="border-bottom: 1px solid #000; padding: 5px 30px;width: 59%;margin: 0;display: inline-block; ">
                          ឈ្មោះសិស្ស (Student’s Name):  &nbsp;
                          <b>
                              <?php echo $student->getStudentName(); ?>
                            </b>
                        </p>
                        <p class="pad-left-xl" style="border-left: 1px solid #000;border-bottom: 1px solid #000;padding: 5px 30px;width: 40%;margin: 0;display: inline-block; ">
                          ខែ Month:&nbsp;<b>
                             
                            </b>
                        </p>
                        <p class="pad-left-xl" style="padding: 5px 30px; width: 59%;margin: 0;display: inline-block;">
                          កំរិត Level:&nbsp;<b>
                              <?php
                                echo $level != null ? $level->getLevelName() : '<i class="text-red">Information is missing! 
                                </i>';
                                                ?>
                            </b>
                        </p>
                        <p class="pad-left-xl" style="border-left: 1px solid #000; padding: 5px 30px;width: 40%;margin: 0;display: inline-block; ">
                          ម៉ោង Time:&nbsp;
                          <b>
                            </b>
                        </p>
                      </div>
                    <div id="preview">
                    <div class="col-md-7 col-xs-7 border noti-box"​ style="width: 40%;border-bottom: none;margin-bottom: 0;padding-bottom: 0 ">
                        <p style="padding: 3;text-align: center;font-size: 10pt;"><b>មតិយោបល់ទាំងអស់ត្រូវបានពិនិត្យ</b><br><span>All comment are checked</span></p>
                        <p style="text-align: center;"></p>
                      </div>
                      <div class="col-md-7 col-xs-7 border noti-box"​ style="width: 60%;border-bottom: none;border-left:none;margin-bottom: 0;padding-bottom: 0 ">
                        <p style="padding: 3;text-align: center;">ពិន្ទុតាមកត្តាវិនិច្ឆ័យៈ<br><span>0 = ខ្សោយបំផុត - 100 = ល្អបំផុត</span></p>
                      </div>
                    <div style="width:40%;float: left;">
                      <div class="col-md-7 col-xs-7 border noti-box"​ style="width: 100%; margin-top: 0">
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <!-- <span class="khmer-score" style="padding-top: 40px;padding-bottom:10px;display: block; ">ចំនុចសំនូមពរសំរាប់គ្រូ:</span> -->
                          <!-- <ul>
                            <li>
                              ពង្រឹងវិន័យក្នុងម៉ោងសិក្សា
                            </li>
                            <li>
                              ជំរុញការអានអោយបានលឺ និងការបញ្ចេញសំលេងអោយកានិតែច្បាស់
                            </li>
                            <li>
                              ហៅឡើងអានលើក្តាខៀនអោយបានច្រើន
                            </li>
                            <li>
                              តាមដាននូវសកម្មភាពជាប្រចាំជៀសវាងការបង្ករបញ្ហាចំពោះសិស្សដទៃ
                            </li>
                            <li>
                              ណែនាំពីសីលធម៏ក្នុងការនិយាយស្តីអោយបានត្រឹមត្រូវ
                            </li>
                            <li>
                              ណែនាំបន្ថែមអោយមានទំលាប់ល្អក្នុងការថែរក្សារសម្ភារះសិក្សា
                            </li>
                            <li>
                              ជំរុញអោយមានភាពក្លាហានតាមរួះចូលរួមសកម្មភាពជាក្រុម
                            </li>
                            <li>
                              ជំរុញភាពចងចាំដោយហៅឡើងសួរផ្ទាល់មាត់អោយបានច្រើន
                            </li>
                            <li>
                              បង្កើនការណែនាំតំរង់ទិសពីរបើបសរសេរស្របតាមបទដ្ឋាន
                            </li>
                            <li>
                              ពង្រីងលើការសរសេរអោយបានកាន់តែស្អាត
                            </li>
                            <li>
                              លើកទឹកចិត្តអោយចង់មករើននិងចូលរួមសកម្មភាពសិក្សា
                            </li>
                           </ul>
                          <span class="khmer-score" style="padding-top:10px;padding-bottom:10px;display: block;">ចំនុចសំនូមពរសំរាប់មារាបិតាសិស្ស:</span>
                          <ul> 
                            <li>
                              ជួយជំរុញអោយសរសេរកិច្ចការផ្ទះជាប្រចាំ
                            </li>
                            <li>
                              ជួយសួរនាំពីលទ្ឋផលសិក្សារមកពីសាលាអោយបានទៀងទាត់
                            </li>
                            <li>
                              ជួយរៀបចំ ត្រួតពិនិត្យសម្ភារះសិក្សាមុនពេលមកសាលារៀន
                            </li>
                            <li>
                              ជួយណែរនាំអោយមានទំលាប់ល្អក្នុងការប្រើប្រាស់សម្ភារះសិក្សា
                            </li>
                            <li>
                              ជួយណែរនាំការនិយាយស្តីប្រកបដោយសីលធម៏
                            </li>
                            <li>
                              ជួយរៀបចំការស្លៀកពាក់ខោអាវអោយបានសមរម្យ
                            </li>
                            <li>
                              ជួយណែនាំអោយកាត់បន្ថយការចូលចិត្តលេង
                            </li>
                            <li>
                              ជុំរុញអោយមករៀនទៀងទាត់
                            </li>
                          </ul> -->
                      </div>
                       <div class="col-md-7 col-xs-7 border noti-box"​ style="width: 100%; margin-top: 0;border-top: none;">
                          <span>លទ្ធផលធៀបនឹងខែមុនៈ</span><br>
                          <?php 
                            if($report['result_last'] == 0){
                              echo '<span><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp; អន់ជាង  
                              <i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp; ល្អដដែល   
                              <i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp; ប្រសើរជាង</span>';
                            }else if($report['result_last'] == 1){
                              echo '<span><i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp; អន់ជាង  
                              <i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp; ល្អដដែល   
                              <i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp; ប្រសើរជាង</span>';
                            }else{
                              echo '<span><i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp; អន់ជាង  
                              <i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp; ល្អដដែល   
                              <i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp; ប្រសើរជាង</span>';
                            }
                          ?>
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box"​ style="width: 100%; margin-top: 0;border-top: none;">
                            <span>លទ្ឋផល់ប្រចាំខែ</span>
                          <span class="border-score" style="width: 150px;text-align: center;">
                            <?php 
                              if( $report['final'] < 50){
                                echo '<i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp;ជាប់  
                                <i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;ធ្លាក់';
                              }else{
                                echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;ជាប់  
                                <i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp;ធ្លាក់';
                              }
                            ?>
                          </span><br>
                          <span>Result of </span> 
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box"​ style="width: 100%; margin-top: 0;border-top: none;">
                          <span>ចំណាត់ថ្នាក់ Rank</span><span class="border-score" style="width: 150px;text-align: center;">
                            /
                          <?php //echo $countStu ?>
                          </span>
                        </div>
                    </div>
                     <div style="width:60%;float: right;">
                      <?php
                        // $a = $exam->getAbsence_a();
                        // $p = $exam->getAbsence_p();
                        // $att = 10 - ($a + $p / 2);
                        $att = $report['att'];
                        $att < 0 ? $att = 0 : $att;
                      ?>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 5px;margin-top: 0">
                            <span>វត្តមាន Attendance(10%)</span><span class="border-score border-score-lg"><?php echo $att?></span><br>
                            <span class="padding-score">ភាពយកចិត្តទុកដាក់លើការសិក្សា​</span><!-- Attentiveness on study (5%) -->
                            <span class="border-score-bot"><?php echo $report['attentiveness']?></span><br>
                            <span class="padding-score">វិន័យ និង សីលធម៏ Discipline and monlity (5%)</span>
                            <span class="border-score-bot"><?php echo $report['discipline']?></span>
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none;  border-bottom: none;padding-bottom: 0;margin-top: 0">
                          <span>កិច្ចការផ្ទះ Homework (5%)</span>
                          <span class="border-score border-score-lg"><?php echo $report['homework']; ?></span>
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 5px;margin-top: 0">
                          <span>ការចូលរួមសកម្មភាពក្នុងថ្នាក់</span><span class="border-score border-score-lg"><?php echo $report['classwork'];?></span> <br/> 
                          <span>Class Work (5%)</span><br/>
                          <span class="padding-score">ការរីកចំតើនលើការអាន Progress in reading (1%)</span>
                          <span class="border-score-bot"><?php echo $report['reading']?></span><br/>
                          <span class="padding-score">ការរីកចំរើនលើការសរសេរ Progress in writing (1%)</span>
                          <span class="border-score-bot"><?php echo $report['writing']?></span><br/>
                          <span class="padding-score">ការរីកចំរើនលើការនិយាយ Progress in speaking (1%)</span>
                          <span class="border-score-bot"><?php echo $report['speaking']?></span><br/> 
                          <span class="padding-score">ការរីកចំរើនលើការស្តាប់ Progress in listening (1%)</span>
                          <span class="border-score-bot"><?php echo $report['listening']?></span><br/> 
                          <span class="padding-score">ការរីកចំរើនលើភាពចងចាំ Development on memory (1%)</span>
                          <span class="border-score-bot"><?php echo $report['memory']?></span><br/> 
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
                          <span>ការប្រលងប្រចាំខែរ សប្តាហ៏ទី ១ Quiz 1 Reading Test (10%)</span>
                          <span class="border-score border-score-lg"><?php echo $report['q1'];?></span>
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
                          <span>ការប្រលងប្រចាំខែរ សប្តាហ៏ទី ២ Quiz 2 Dictation (10%)</span>
                          <span class="border-score border-score-lg"><?php echo $report['q2'];?></span>
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
                          <span>ការប្រលងប្រចាំខែរ សប្តាហ៏ទី ៣ Quiz 3 Oral Test (10%) (5%)</span>
                          <span class="border-score border-score-lg"><?php echo $report['q3']; ?></span>
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
                          <span>ការប្រលងប្រចាំខែរ សប្តាហ៏ទី 4 Final Exam (50%)</span><span class="border-score border-score-lg"><?php echo $report['final'];?></span>
                        </div>
                        <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; bpadding-bottom: 0;margin-top: 0;padding-bottom: 0;">
                          <span>សរុប Total Score (100%)</span><span class="border-score border-score-lg"><?php echo $report['final']; ?></span>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                      <p class="fz-13">សូមចុះហត្ថលេខានិងឱ្យកូនរបស់អ្នកយករបាយការណ៍លទ្ធផលមកសាលាវិញ។ ប្រសិនបើអ្នកមានសំណួរឬកង្វល់សូមសរសេរវា នៅលើផ្នែក "កំណត់សំគាល់" នៃឯកសារនេះឬទូរស័ព្ទមកលេខ 010 47 57 88 ។</p>
                      <p class="fz-13">Please sign and have your child return this progress report to school. If you have any questions or concerns please write them on the "notes" section of this document or call me at 010 47 57 88.</p>
                      <p class="text-right">អរគុណ Thank you!</p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="col-md-4">
                        <p style="height: 30px;"></p>
                        <p class="text-center">___________________</p>
                        <p class="text-center">Student’s Signature</p>
                      </div>
                      <div class="col-md-4">
                        <p style="height: 30px;"></p>
                        <p class="text-center">___________________</p>
                        <p class="text-center">Parents Signature</p>
                      </div>
                      <div class="col-md-4">
                        <p style="height: 30px;"></p>
                        <p class="text-center">___________________</p>
                        <p class="text-center">Teacher’s Signature</p>
                      </div>
                      <div class="col-md-12">
                        <p style="height: 150px;"></p>
                        <p class="text-center">___________________</p>
                        <p class="text-center">Director Signature</p>
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
          size: A4;
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
