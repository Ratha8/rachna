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
/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

if (isset($_GET['rank_id'])) 
    {
    $rank_id = $_GET['rank_id'];
    $rank = getOneField($rank_id);
    // $classes = getAllClasses();
    $examID = getTrimExamID(1, 12, $rank->getYear());


    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("templates/outstanding_yearByLevel.xls");
    
   
    $objPHPExcel->getActiveSheet()->setCellValue('F10', $rank->getYear());

    $baseRow = 12;
    $row = 12;

    foreach ($levels as $r => $dataRow) {
        $row = $baseRow + 1;
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
                            'name' => 'Times New Roman'
            )));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':I' . $baseRow);
//            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $row . ':M' . $row);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $levels[$r]['level_name']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'No Record ');
            
        } else {
             $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':I' . $baseRow);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $levels[$r]['level_name']);
            
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray( array(
             'alignment' => array(
             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
             'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ))
    );
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'BDBDBD'),
                            
                        )
                    )
            );
            $objPHPExcel->getActiveSheet()->setCellValue()->getStyle('A' . $baseRow)->applyFromArray(
                    array(
                        'font' => array(
                            'bold' => true,
                            'size' => 22,
                            'name' => 'Times New Roman'
                            
            )));
            $getTrimExamScore = getTopScoreLevelMultiple($classByLevel, $examID);
            if (!empty($getTrimExamScore)) {
            foreach ($getTrimExamScore as $number => $record){
               
            $room = getOneClass($record['room_id']);
            $student = getOneStudent($record['student_id']);
            $sex = $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'F') : 'M';

            $mention = '';
            $totalAll = $record['Total']/12;
             if ($totalAll <= 49) {
                $mention = "F";
            } else if ($totalAll <= 68) {
                $mention = "E";
            } else if ($totalAll <= 78) {
                $mention = "D";
            } else if ($totalAll <= 85) {
                $mention = "C";
            } else if ($totalAll <= 94) {
                $mention = "B";
            } else if ($totalAll >= 95) {
                $mention =  "A";
            }
 
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
            
//            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':M' . $baseRow);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $number+1)
                    ->setCellValue('B' . $row, $student->getStudentName())
                    ->setCellValue('C' . $row, $student->getLatinName())
                    ->setCellValue('D' . $row, $sex)
                    ->setCellValue('E' . $row, dateFormat($student->getDob(), "d-m-Y"))
                    ->setCellValue('F' . $row, round($totalAll, 2))
                    ->setCellValue('G' . $row, $mention);
            $row = $row + 1;
        }
    }  else {
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
                            'name' => 'Times New Roman'
            )));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $baseRow . ':I' . $baseRow);
//            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $row . ':M' . $row);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $baseRow, $levels[$r]['level_name']);
//            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, 'No Record '); 
                
            }
            
    }
    $baseRow = $baseRow + 4;
}


//    $objPHPExcel->getActiveSheet()->removeRow($baseRow - 1, 1);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save(str_replace('.php', '.xls', __FILE__));

    $filename = "outstanding_yearByLevel.xls";
    $file_path = "http://" . $_SERVER['HTTP_HOST'] . "/rachana/pages/" . $filename;
//      var_dump($file_path);
    $contenttype = "application/octet-stream";
    header("Content-Type: " . $contenttype);
    header("Content-Disposition: attachment; filename=\"" . basename("outstanding_yearByLevel-" . $rank->getYear() . ".xls") . "\";");
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