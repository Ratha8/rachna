<?php

include '../model/manageuser.php';
include '../model/util.php';
include '../model/managestudent.php';
include '../model/manageclass.php';
include '../model/managerank.php';
include '../model/manageexam.php';
include '../model/manageexammarks.php';

session_start();
ob_start();
if(!$_SESSION['user']) {
 header("Location:../index.php");
} else {
  $user_session = unserialize($_SESSION["user"]);
}
if($user_session->getRole() == 'Teacher'){
   $levels=getAllLevelsTeacher($user_session->getUserID());
}else{
    $levels = getAllLevels();
}
$day = date("d");
$month = date("m");
$year = date("y");
/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

if (isset($_GET['rank_id'])) 
{
    $rank_id = $_GET['rank_id'];
    $rank = getOneField($rank_id);
    // $classes = getAllClasses();
    $selectMonth = isset($_GET['month']) ? $_GET['month'] : 1;
    $examID = getExamID($selectMonth, $rank->getYear());


    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("templates/outstandingByLevel.xls");
    
    switch ($selectMonth){
     case 1:
     $selectMonth = 'មករា';
     break;
     case 2:
     $selectMonth = 'កុម្ភះ';
     break;

     case 3:
     $selectMonth = 'មិនា';
     break;

     case 4:
     $selectMonth = 'មេសា';
     break;

     case 5:
     $selectMonth = 'ឧសភា';
     break;

     case 6:
     $selectMonth = 'មិថុនា';
     break;

     case 7:
     $selectMonth = 'កក្កដា';
     break;

     case 8:
     $selectMonth = 'សីហា';
     break;

     case 9:
     $selectMonth = 'កញ្ញា';
     break;

     case 10:
     $selectMonth = 'តុលា';
     break;

     case 11:
     $selectMonth = 'វិច្ឆិកា';
     break;

     case 12:
     $selectMonth = 'ធ្នូ';
     break;

 }
 $objPHPExcel->getActiveSheet()->setCellValue('F10', $selectMonth);
 $objPHPExcel->getActiveSheet()->setCellValue('H10', $rank->getYear());

 $baseRow = 10;
 $row = 11;
 foreach ($levels as $r => $dataRow) {
    $row = $row + 2;
    $baseRow = $baseRow + 2;
    if($user_session->getRole() == 'Teacher'){
        $classByLevel = getAllClassByLevelByTeacher($dataRow['level_id'],$user_session->getUserID());
    }else{
        $classByLevel = getAllClassByLevel($dataRow['level_id']);
    }
    if (empty($classByLevel)) {
        $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow)->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'BDBDBD'),
                )
            )
        );
        $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow.':I'.$baseRow)->applyFromArray(
                    array(
                        'borders' => array(
                          'allborders' => array(
                              'style' => PHPExcel_Style_Border::BORDER_THIN
                          )
                      )
                    )
            );
        $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray( 
            array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            )
        );
        $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray(
            array(
                'font' => array(
                    'bold' => true,
                    'size' => 22,
                    'name' => 'Centaur'
                )));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':I' . $baseRow);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $row . ':I' . $row);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $levels[$r]['level_name']);
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'No Record ');
    } else {
        $getTopScore = getTopScoreLevel($classByLevel,$examID->getExam_id());
        if(empty($getTopScore)){
            $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BDBDBD'),
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow.':I'.$baseRow)->applyFromArray(
                    array(
                        'borders' => array(
                          'allborders' => array(
                              'style' => PHPExcel_Style_Border::BORDER_THIN
                          )
                      )
                    )
            );
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray( array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ))
        );
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true,
                        'size' => 22,
                        'name' => 'Centaur'
                    )));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':I' . $baseRow);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $row . ':I' . $row);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $levels[$r]['level_name']);
        }  else {
           $room = getOneClass($getTopScore[0]['room_id']);
           $student = getOneStudent($getTopScore[0]['student_id']);
           if (empty($student)){
               $objPHPExcel->getActiveSheet()->getStyle('A' . $baseRow)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BDBDBD'),
                    )
                )
            );

               $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray( array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ))
           );
               $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true,
                        'size' => 22,
                        'name' => 'Centaur'
                    )));

               $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':I' . $baseRow);
               $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $row . ':I' . $row);
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $levels[$r]['level_name']);
           }
           else {
            $sex = $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'F') : 'M';
            $mention = '';
            if ($getTopScore[0]['total'] <= 49) {
                $mention = "F";
            } else if ($getTopScore[0]['total'] <= 68) {
                $mention = "E";
            } else if ($getTopScore[0]['total'] <= 78) {
                $mention = "D";
            } else if ($getTopScore[0]['total'] <= 85) {
                $mention = "C";
            } else if ($getTopScore[0]['total'] <= 94) {
                $mention = "B";
            } else if ($getTopScore[0]['total'] >= 95) {
                $mention = "A";
            }

            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BDBDBD'),

                    ),
                )
            );
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow.':I'.$baseRow)->applyFromArray(
                array(
                    'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
                )
            );
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true,
                        'size' => 22,
                        'name' => 'Centaur'

                    )));
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray( array(
               'alignment' => array(
                   'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                   'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
               ))
        );

            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('B' . $row)->applyFromArray(
                array(
                    'font' => array(
                        'bold' => false,
                        'size' => 22,
                        'name' => 'Khmer OS Content',
                    )));
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('C' . $row . ':M' . $row)->applyFromArray(
                array(
                    'font' => array(
                        'bold' => false,
                        'size' => 22,
                        'name' => 'Times New Roman',
                    )));
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $row . ':I' . $row)->applyFromArray(
                array(
                    'borders' => array(
                      'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                  )
                )
            );
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':I' . $baseRow);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $levels[$r]['level_name'])
            ->setCellValue('A' . $row, 'I')
            ->setCellValue('B' . $row, $student->getStudentName())
            ->setCellValue('C' . $row, $student->getLatinName())
            ->setCellValue('D' . $row, $sex)
            ->setCellValue('E' . $row, dateFormat($student->getDob(), "d-m-Y"))
            ->setCellValue('F' . $row, $getTopScore[0]['total'])
            ->setCellValue('G' . $row, $mention);
        }
    }

}
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
$objPHPExcel->getActiveSheet()->setCellValue('G'.$f_row, 'ភ្នំពេញថ្ងៃទី '.$day.' ខែ '.$month.' ឆ្នាំ '.$year);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$s_row, 'ការិយាល័យសិក្សាទទួលបន្ទុក');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$t_row, 'វ៉ា ម៉ូរ៉ា');

//    $objPHPExcel->getActiveSheet()->removeRow($baseRow - 1, 1);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));

$filename = "outstanding_level.xls";
$file_path = "http://" . $_SERVER['HTTP_HOST'] . "/rachana/pages/" . $filename;
//      var_dump($file_path);
$contenttype = "application/octet-stream";
header("Content-Type: " . $contenttype);
header("Content-Disposition: attachment; filename=\"" . basename("outstandingByLevel-" . $selectMonth . ".xls") . "\";");
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