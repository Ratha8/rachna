<?php
function dateFormat($stringDate, $format) {
	$datetime = strtotime($stringDate);
  $myFormatForView = date($format, $datetime);
  return $myFormatForView;
}

// function timeFormat($stringTime, $timeSplit) {
// 	$time = strtotime($stringTime);
//   $myFormatForView = date("g" . $timeSplit . "i A", $time);
//   return $myFormatForView;
// }

function createDate($stringDate, $format) {
	return date_create($stringDate)->format($format);
}

function getTime($stringDate, $format) {
	return strtotime(createDate($stringDate, $format));
}

function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
}


// function getStartAndEndDate($week, $year)
// {
//     $time = strtotime("1 January $year", time());
//     $day = date('w', $time);
//     $time += ((7*$week)+1-$day)*24*3600;
//     $return['week_start'] = date('Y-m-d', $time);
//     $time += 6*24*3600;
//     $return['week_end'] = date('Y-m-d', $time);
//     return $return;
// }

function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}

function containsDecimal($val) {
    if (strpos($val, ".") !== false) {
        return false;
    } else {
      return is_numeric($val);
    }
}

function isDecimal($val) {
    return is_numeric($val) && floor($val) != $val;
}

?>