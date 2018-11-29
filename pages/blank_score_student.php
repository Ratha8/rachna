<?php
include 'includes/header.php';
include '../model/manageclass.php';
include '../model/manageexammarks.php';
include '../model/manageexam.php';

$exam_id = $_GET['id'];

if ($user_session->getRole() == 'Admin') {
    $list = getAllClasses();
} else {
    $list = getAllClassesUserRole($user_session->getUserID());
}

if (($exam_id === null) || (empty($exam_id))) {
    header("Location:create_exam.php");
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Score Management<br>
            <small>List of all students not yet or forgotten to insert score</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            $countExam = 0;
            foreach ($list as $key => $value) {
                $id = $list[$key]['class_id'];
                $exam = getOneExam($exam_id);
                $month = $exam->getExam_month();
                $year = $exam->getExam_year();
                $studentRecords = getAllStudentInClassNoneLeave($id,$month,$year);
                $room_exam = checkExamMark($id, $exam_id);
                $getExam = countNoneScore($id, $exam_id,$month,$year);
                $notInserted = count($studentRecords) - count($getExam);
                if($notInserted <0){
                    $notInserted = 0;
                }
                $pass = 0;
                    foreach ($getExam as $keys => $value) {
                        if ($getExam[$keys]['total'] > 50) {
                            $pass ++;
                        }
                    }

                    $pass_percent = count($getExam) > 0 ? number_format(($pass * 100) / count($getExam), 2) : number_format(0, 2);
                if (!empty($room_exam)) {
                    ?>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red class-box">
                            <div class="inner pointer">
                                <h3 class="pre-wrap"><?php echo $list[$key]['class_name']; ?></h3>
                                <p>
                                    Teacher:&nbsp; 
                                    <span class="label label-warning"><?php echo $list[$key]['teacher_name'] ?></span>
                                </p>
                            </div>
                            <div class="icon icon-fix pointer">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                            </div>
                            <a href="add_new_score.php?id=<?php echo $id; ?>&exam_id=<?php echo $exam_id ?>" class="small-box-footer">
                                Insert Student Score
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                            <div class="info-box bg-red-active pointer inner" >
                                    Total Students: &nbsp;
                                    <span class="label label-warning"><?php echo count($studentRecords); ?></span>
                                    <br>No score Students: &nbsp;
                                    <span class="label label-warning"><?php echo $notInserted; ?></span>
                                    <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $pass_percent ?>%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Pass &nbsp;
                                            <?php echo $pass; ?>&nbsp;
                                            <span class="label label-danger">
                                                <strong><?php echo $pass_percent; ?></strong>
                                                <i class="fa fa-percent"></i>                        
                                            </span>
                                        </span>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                    </div><!-- ./col -->
                    <?php
                    $countExam++;
                } elseif (empty($room_exam)) {
                    echo '';
                }
            }
            if($countExam == 0){
                echo '<div class="text-center well well-lg"> Each room for this exam has not inserted score yet. Click <a href="view_exam_class.php?id='.$exam_id.'"> here </a> to insert.</div>';
            }
            ?>
        </div><!-- /.row -->
    </section>
</div>
<?php
include 'includes/footer.php';
?>

<script type="text/javascript">

    $(document).ready(function () {
        $(".content-wrapper").on("click", ".class-box", function (e) {
            if ($(e.target).is("a, button"))
                return;
            location.href = $(this).find("a").attr("href");
        });
    });

</script>