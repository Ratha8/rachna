    <?php
      include 'includes/header.php';
      include '../model/manageclass.php';  
      include '../model/managereport.php';
      include '../model/manageexammarks.php';

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
    <style type="text/css">
    	.border-score {
    		height: 30px;
    		border: 1px solid;
    		width: 80px;
    		padding: 3px;
    		float: right;
    		border-radius: 5px;
    		margin-bottom:5px;
    	}
    	.padding-score{
    		padding-left: 20px;
    	}
    	.border-score-lg{
    		width: 115px;
    	}
    	.border-score-md{
    		width: 80px;
    	}
    	.pre-noti-info{
    		font-family: 'Khmer OS Battambang' 'Times New Roman';
    	}
    	.khmer-score{
    		font-family: 'Khmer OS Content','Khmer OS Muol Light';
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
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            </section>        

            <!-- Main content -->
              <section class="notification">
                <div class="row">
                  <div class="col-xs-12">
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                      <div class="col-xs-12">
                        <a href="report_print.php?id=<?php echo $id ?>" target="_blank" class="btn btn-default pull-right">
                          <i class="fa fa-print"></i>&nbsp;Print
                        </a>                  
                      </div>
                    </div>                 
                      <div class="noti-header">
                        <div class="row" id="img">
                          <div class="col-md-6 logo-noti">
                            <div class="col-md-6" style="text-align: center;">
                                <img src="../images/logo.jpg" style="float: none;">
                              <div class="col-md-12">
                                <p class="khmer khmer-score">សាលា អន្តរជាតិ រចនា</p>
                                <p class="en-school"><b>Rachna International </b></p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4 col-md-offset-2 text-right center minus-top-sm">
                            <h4 class="khmer khmer-score">
                              <p>ព្រះរាជាណាចក្រកម្ពុជា</p>
                              <p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
                              <p><span style="font-family:Webdings">🙢🙢🙢🙠🙠🙠</span></p>
                            </h4>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                
                <div class="row pre-noti-info">
                    <h4 class="khmer center">
                      <p​ class="khmer-score">របាយការណ៏លទ្ទផល់នៃការសិក្សា</p>
                      <p class="en-score">Report on Student's Performance</p>
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
                      	<p class="khmer-score" style="padding: 3;text-align: center;"><b>មតិយោបល់ទាំងអស់ត្រូវបានពិនិត្យ</b></p>
                        <p style="text-align: center;">All comment are checked</p>
                      </div>
                      <div class="col-md-7 col-xs-7 border noti-box"​ style="width: 60%;border-bottom: none;margin-bottom: 0;padding-bottom: 0 ">
                        <p class="khmer-score" style="padding: 3;text-align: center;">ពិន្ទុតាមកត្តាវិនិច្ឆ័យៈ</p>
                        <p style="text-align: center;">0 = ខ្សោយបំផុត - 100 = ល្អបំផុត</p>
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
                            <!-- <span class="khmer-score" style="padding-top: 40px;padding-bottom:10px;display: block; ">ចំនុចសំនូមពរសំរាប់គ្រូ:</span>
                            <ul>
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
                          <span class="border-score" style="width: 200px;text-align: center;">
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
                          <?php //echo $countStu; ?>
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
                      		<div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
    	                        <span>វត្តមាន Attendance(10%)</span>
                              <span class="border-score border-score-lg"><?php echo $att?></span><br>
    	                        <span class="padding-score">ភាពយកចិត្តទុកដាក់លើការសិក្សា Attendances on study (5%) </span><span class="border-score-bot"><?php echo $report['attentiveness']?></span><br>
    	                        <span class="padding-score">វិន័យ និង សីលធម៌ Discipline and morality (5%) </span>
                              <span class="border-score-bot"><?php echo $report['discipline']?></span>
                        	</div>
                        	<div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none;  border-bottom: none;padding-bottom: 0;margin-top: 0">
    	                      <span>កិច្ចការផ្ទះ Homework (5%)</span>
                            <span class="border-score border-score-lg"><?php echo $report['homework'];?></span>
    	                    </div>
    	                    <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
    	                      <span>ការចូលរួមសកម្មភាពក្នុងថ្នាក់</span><span class="border-score border-score-lg"><?php echo $report['classwork']; ?></span> <br/> 
    	                      <span>Class Work (5%)</span><br/>
    	                      <span class="padding-score">ការរីកចំតើនលើការអាន  Progress in reading (1%)</span>
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
                            <span class="border-score border-score-lg"><?php echo $report['q1'];;?></span>
    	                    </div>
    	                    <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
    	                      <span>ការប្រលងប្រចាំខែរ សប្តាហ៏ទី ២ Quiz 2 Dictation (10%)</span><span class="border-score border-score-lg"><?php echo $report['q2'];?></span>
    	                    </div>
    	                    <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
    	                      <span>ការប្រលងប្រចាំខែរ សប្តាហ៏ទី ៣ Quiz 3 Oral Test (10%) (5%)</span><span class="border-score border-score-lg"><?php echo $report['q3']; ?></span>
    	                    </div>
    	                    <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; border-bottom: none;padding-bottom: 0;margin-top: 0">
    	                      <span>ការប្រលងប្រចាំខែរ សប្តាហ៏ទី ៤ Final Exam (50%)</span><span class="border-score border-score-lg"><?php echo $report['final'];;?></span>
    	                    </div>
    	                    <div class="col-md-7 col-xs-7 border noti-box" style="width: 100%; border-left: none; bpadding-bottom: 0;margin-top: 0">
    	                      <span>សរុប Total Score (100%)</span><span class="border-score border-score-lg"><?php echo $report['final'];?></span>
    	                    </div>
                      </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <p>សូមចុះហត្ថលេខានិងឱ្យកូនរបស់អ្នកយករបាយការណ៍លទ្ធផលមកសាលាវិញ។ ប្រសិនបើអ្នកមានសំណួរឬកង្វល់សូមសរសេរវា នៅលើផ្នែក "កំណត់សំគាល់" នៃឯកសារនេះឬទូរស័ព្ទមកលេខ 010 47 57 88 ។</p>
                      <p>Please sign and have your child return this progress report to school. If you have any questions or concerns please write them on the "notes" section of this document or call me at 010 47 57 88.</p>
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
            <div class="clearfix"></div>
          </div><!-- /.content-wrapper -->

    <?php
      include 'includes/footer.php';
    ?>      

    <script>

      $(function(){
        //Flat Aero color scheme for iCheck
        $('input[type="checkbox"].minimal-aero, input[type="radio"].minimal-aero').iCheck({
          checkboxClass: 'icheckbox_minimal-aero',
          radioClass: 'iradio_minimal-aero'
        });    

        //Flat Green color scheme for iCheck
        $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
          checkboxClass: 'icheckbox_minimal-green',
          radioClass: 'iradio_minimal-green'
        });

        //Flat Blue color scheme for iCheck
        $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });    

        //Flat Yellow color scheme for iCheck
        $('input[type="checkbox"].minimal-yellow, input[type="radio"].minimal-yellow').iCheck({
          checkboxClass: 'icheckbox_minimal-yellow',
          radioClass: 'iradio_flat-minimal-yellow'
        });

        //Flat Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });           
      });

    </script>