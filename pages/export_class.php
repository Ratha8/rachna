<?php
include '../model/manageuser.php';
include '../model/util.php';
include '../model/manageclass.php';  
include'../model/manageexammarks.php';
include'../model/manageexam.php';
include '../model/managestudent.php';


session_start();
ob_start();
if(!$_SESSION['user']) {
   header("Location:../index.php");
} else {
  $user_session = unserialize($_SESSION["user"]);
}
$exam = new Exam; 
$exam_mark = new Exam_marks;
 if($user_session->getRole() == 'Teacher'){
    $classes=getAllClassesUserRole($user_session->getUserID());
  }else{
    $classes = getAllClasses();
  }

$day = date("d");
$month = date("m");
$year = date("y");
/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

if((isset($_GET['room_id'])) && (isset($_GET['exam_id']))) {
   $room_id = $_GET['room_id'];
    $exam_id = $_GET['exam_id'];
    $getStudentMarks = getExamMarkID($room_id,$exam_id);
    $class = getOneClass($room_id);
    $exam = getOneExam($exam_id);
    $exams = getAllExams();
    $level = getOneLevel($class->getLevelID());
    $list = getAllStudentInClass($room_id);

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("templates/export_class.xls");
    
    $objPHPExcel->getActiveSheet()->setCellValue('C8', $class->getTeacherName());
    $objPHPExcel->getActiveSheet()->setCellValue('H8', $level != null ? $level->getLevelName() : '<i class="text-red">Unknown</i>');
    $objPHPExcel->getActiveSheet()->setCellValue('C9', $class->getClassName());
    $objPHPExcel->getActiveSheet()->setCellValue('H9', $exam->getexam_name());
    
    $baseRow = 13;
    $row_num = 1;
    foreach ($getStudentMarks as $r => $dataRow) {
    	$rank_num = $row_num;
    	if($r>0){
    		$rank = ($getStudentMarks[$r-1]['total'] == $getStudentMarks[$r]['total'] ? $rank:$rank_num);
        }else{
        	$rank = 1;
        }
        $row_num++;
        $row = $baseRow + $r;
        $att = 10-($dataRow['absence_a']+$dataRow['absence_p']/2);
        $att < 0 ? $att = 0 : $att;
        $result = ($dataRow['total']<50 ? 'Fail' : 'Pass');
        $student = getOneStudent($dataRow['student_id']);
                            $stay = 'false';
                            for($i=0;$i<COUNT($list);$i++){
                              if($list[$i]['student_id'] == $student->getStudentID()){
                                $stay = 'true';
                              }
                            }
                           if($stay == 'true' ){
                              if($student->getLeaveFlag() == 1){
                                $month = date('m',strtotime(str_replace('-','/', $student->getLeaveDate())));
                                $year = date('Y',strtotime(str_replace('-','/', $student->getLeaveDate())));
                                if(($month == $exam->getExam_month()) AND ($year == $exam->getExam_year())){
                                  $leave = 'danger';
                                }else{
                                  $leave = '';
                                }
                              }else{
                                  $leave = '';
                                }
                            }else{
                              $leave = 'success';
                            }
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('B' . $row)->applyFromArray(
                    array(
                        'font' => array(
                            'bold' => false,
                            'size' => 22,
                            'name' => 'Khmer OS Content',
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )));
              $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('C' . $row .':N'.$row)->applyFromArray(
                    array(
                        'font' => array(
                            'bold' => TRUE,
                            'size' => 20,
                            'name' => 'Times New Roman',       
            )));
              $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('B' . $row .':N'.$row)->applyFromArray( array(
                'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ))
    );
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
                                      ->setCellValue('B'.$row, $student->getStudentName())
                                      ->setCellValue('C'.$row, $dataRow['absence_a'])
                                      ->setCellValue('D'.$row, $dataRow['absence_p'])
                                      ->setCellValue('E'.$row, $att)
                                      ->setCellValue('F'.$row, $dataRow['home_work'])
                                      ->setCellValue('G'.$row, $dataRow['class_work'])
                                      ->setCellValue('H'.$row, $dataRow['quiz1'])
                                      ->setCellValue('I'.$row, $dataRow['quiz2'])
                                      ->setCellValue('J'.$row, $dataRow['quiz3'])
                                      ->setCellValue('K'.$row, $dataRow['final_exam'])
                                      ->setCellValue('L'.$row, $dataRow['total'])
                                      ->setCellValue('M'.$row, $result)
                                      ->setCellValue('N'.$row, $rank);                            
    }
    $f_row = $row+1;
    $s_row = $row+2;
    $t_row = $row+4;
    $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $f_row .':K'.$f_row)->applyFromArray(
      array(
        'font' => array(
          'bold' => FALSE,
          'size' => 22,
          'name' => 'Khmer OS Content','Times New Roman',       
        )));
    $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $s_row .':K'.$s_row)->applyFromArray(
      array(
        'font' => array(
          'bold' => FALSE,
          'size' => 22,
          'name' => 'Khmer OS Content','Times New Roman',       
        )));
    $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $t_row .':K'.$t_row)->applyFromArray(
      array(
        'font' => array(
          'bold' => TRUE,
          'size' => 22,
          'name' => 'Khmer OS Content','Times New Roman',       
        )));
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$f_row, 'ភ្នំពេញថ្ងៃទី '.$day.' ខែ '.$month.' ឆ្នាំ '.$year);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$s_row, 'ការិយាល័យសិក្សាទទួលបន្ទុក');
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$t_row, 'វ៉ា ម៉ូរ៉ា');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save(str_replace('.php', '.xls', __FILE__));

    $filename = "export_class.xls";
    $file_path = "http://" . $_SERVER['HTTP_HOST'] . "/rachana/pages/" . $filename;
    $contenttype = "application/octet-stream";
    header("Content-Type: " . $contenttype);
    header("Content-Disposition: attachment; filename=\"" . basename("export_class-" . $class->getClassName() . ".xls") . "\";");
    header("Pragma: no-cache");
    header("Expires: 0");

    readfile($file_path);
} else {
//      header("Location:404.php");
}



function integerToRoman($integer) {
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array('M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1);

    foreach ($lookup as $roman => $value) {
        // Determine the number of matches
        $matches = intval($integer / $value);

        // Add the same number of characters to the string
        $result .= str_repeat($roman, $matches);

        // Set the integer to be the remainder of the integer and the value
        $integer = $integer % $value;
    }
    // The Roman numeral should be built, return it
    return $result;
}
?>