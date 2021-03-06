<?php
include 'includes/header.php';
include '../model/manageclass.php';
include '../model/managerank.php';
include '../model/manageexam.php';
include '../model/manageexammarks.php';

 if($user_session->getRole() == 'Teacher'){
        $classes=getAllClassesUserRole($user_session->getUserID());
  }else{
    $classes = getAllClasses();
   
  }

if ((isset($_GET['rank_id']))) {
    $rank_id = $_GET['rank_id'];
    $rank = getOneField($rank_id);
    $selectMonth = isset($_POST['month']) ? $_POST['month'] : 1;
} else {
    header("Location:404.php");
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Outstanding Student in Month
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_school.php"> School Management</a></li>
            <li><a href="class_list.php"> Classroom List</a></li>
            <li class="active">Student List</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="text-center">TOP STUDENT OF TRIMESTER <?php echo $rank->getRank_name() ?></h3>
                        <span class="input-group pull-right">
                        <a role="button" href="outstanding_trim.php?rank_id=<?php echo $rank_id ; ?>&month=<?php echo $selectMonth ?>" class="btn btn-success btn-icon"
                             data-toggle="tooltip" title="Export Outstanding Students." id="export-pdf">
                            <i class="fa fa-file-excel-o"></i>
                        </a> 
                        </span>
                        <form method="POST" action="" style="padding-top: 20px">
                            <div class="col-md-2"><h5>Select Trimester: </h5></div>
                            <div class='col-md-3'>
                                <select class="form-control" name="month">
                                    <option value='1' <?php echo $selectMonth == 1 ? 'selected' : '' ?>>January-March</option>
                                    <option value='4' <?php echo $selectMonth == 4 ? 'selected' : '' ?>>April-June</option>
                                    <option value='7' <?php echo $selectMonth == 7 ? 'selected' : '' ?>>July-September</option>
                                    <option value='10' <?php echo $selectMonth == 10 ? 'selected' : '' ?>>October-December</option>
                                </select> 
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-primary" name="submit" type="submit" value="Go">  
                            </div>
                        </form>                       

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form method="GET" id="examForm">
                            <div class="table-responsive">
                                <table id="student-list" class="table table-bordered table-hover">
                                    <thead class="center text-nowrap">
                                        <tr class="info">
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Name in Khmer</th>
                                            <th rowspan="2">Name in English</th>
                                            <th rowspan="2">Sex</th>
                                            <th rowspan="2">Date of Birth</th>
                                            <th rowspan="2">Total</th>
                                            <th rowspan="2">Mention</th>
                                            <th rowspan="2">Photo</th>
                                            <th colspan="2" rowspan="2">Check</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $getMonth = $selectMonth;
                                        $row_num = 1;
                                        $examID = getTrimExamID($selectMonth, $selectMonth + 2, $rank->getYear());
                                        $where = '';
                                        if ($examID == NULL) {
                                            echo '<td colspan="10" class="text-center">NO RECORD FOR ' . $getMonth . '/' . $rank->getYear() . '</td>';
                                        } else {
                                            foreach ($classes as $key => $value) {
                  
                                                $getTrimExamScore = getTopTrimScore($examID, $value['class_id']);
                                                
                                                echo '<td colspan="20" class="warning" id="class"><b>' . integerToRoman($row_num) . '- ' . $value['class_name'] . '</b></td>';
                                                if (!empty($getTrimExamScore)) {
                                                    foreach ($getTrimExamScore as $number => $record) {
                                                        $mention = "";
                                                        $totalAll = $record['Total']/3;
                                                        if ($totalAll <= 49) {$mention = '<font style="color:red">F</font>';}
                                                            elseif ($totalAll <= 68) {$mention ='E';}
                                                            elseif ($totalAll <= 78) {$mention = 'D';}
                                                            elseif ($totalAll <= 85) {$mention = 'C';}
                                                            elseif ($totalAll <=94) {$mention = 'B';}
                                                            elseif ($totalAll >=95) {$mention = '<font style="color:green">A</font>';}
                                                        $number = $number + 1;
                                                        $student = getOneStudent($record['student_id']);
                                                        $room = getOneClass($record['room_id']);
                                                        $sex = $student->getGender() != 1 ? ($student->getGender() != 2 ? 'Other' : 'Female') : 'Male';
                                                        
                                                        echo "<tr></tr>";
                                                        echo "<td>" . $number . "</td>";
                                                         if ($user_session->getRole()=='Teacher') {
                                                        echo "<td><a href='student_detail.php?id=" . $student->getStudentID() . "'>" . $student->getStudentName() . "</a></td>";
                                                    }else{
                                                         echo "<td>" . $student->getStudentName() . "</td>";
                                                    }
                                                        echo "<td>" . $student->getLatinName() . "</td>";
                                                        echo "<td>" . $sex . "</td>";
                                                        echo "<td>" . dateFormat($student->getDob(), "d F Y") . "</td>";
                                                        echo "<td>" . round($totalAll, 2) . "</td>";
                                                        echo "<td>" . $mention . "</td>";
                                                        if(!empty($student->getPhoto())){
                                                        echo "<td><img src='uploads/" . $student->getPhoto() . "' width='40px' height='40px' class='img-circle'></td>";
                                                        }else {
                                                            echo "<td><img src='uploads/no-img.png' width='40px' height='40px' class='img-circle'></td>";
                                                        }
                                                        echo '<td>
                                                            <a class="btn btn-link btn-icon" href="certi_register_outstanding.php?id='.$student->getStudentID().'&level='.$classes[$key]['level_id'].'&score='.$totalAll.'&duration='.$getMonth.'&year='.$rank->getYear().'&type=2" role="button" 
                               data-toggle="tooltip" title="Download Student Certificate">
                              <i class="fa fa-file-pdf-o"></i>
                            </a></td>';
                                                        echo "<tr></tr>";
                                                    }
                                                } else {
                                                    echo "<tr></tr>";
                                                    echo "<td colspan='10' class='text-center' style ='color: gray'><small>No Record Found</small></td>";
                                                    echo "<tr></tr>";
                                                }
                                                $row_num++;
                                            }
                                        }
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </form> 
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<style>
    td#class{
        text-align: left !important;
    }
    td{
        text-align: center;
    }
</style>
<?php
include 'includes/footer.php';

//FUNCTION CONVERT INTEGER TO ROMAN NUMBER
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

<!-- moment with locale -->
<script src="../js/moment-with-locales.min.js"></script>
<!-- bootstrap datetime picker -->
<script src="../js/bootstrap-datetimepicker.min.js"></script>  
<!-- bootstrap chosen -->
<script src="../js/chosen.jquery.js"></script>  
