



<!--DELETE THIS PAGE-->





<?php
include 'includes/header.php';
include '../model/manageclass.php';
include '../model/manageexammarks.php';
include '../model/manageexam.php';
include '../model/managerank.php';

//   $list = getAllClasses();
if ($user_session->getRole() == 'Admin') {
    $list = getAllClasses();
} else {
    $list = getAllClassesUserRole($user_session->getUserID());
}
if(isset($_GET['rank_id'])) {
    $rank_id = $_GET['rank_id'];
}
$examLID = getLastExam();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Select Class to see student's ranks
        </h1>
    </section>

    <!-- Main content -->

        <section class="content">
            <div class="row">
                <?php
                foreach ($list as $key => $value) {
                    $id = $list[$key]['class_id'];
                    $clazz = getAllStudentInClass($id);
                    $lexam = getLastExam();
                    
                    $room_exam = checkExamMark($id,$lexam[0]['exam_id']);
                    
                    $leave = 0;
                    foreach ($clazz as $keys => $value) {
                        if ($clazz[$keys]['leave_flag'] == 1) {
                            $leave ++;
                        }
                    }

                    $leave_percent = count($clazz) > 0 ? number_format(($leave * 100) / count($clazz), 2) : number_format(0, 2);
                    

                        ?>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-light-blue class-box">
                                <div class="inner pointer">
                                    <h3 class="pre-wrap"><?php echo $list[$key]['class_name']; ?></h3>
                                    <p>
                                        Home Room Teacher:&nbsp; 
                                        <span class="label label-warning"><?php echo $list[$key]['teacher_name'] ?></span>
                                    </p>
                                </div>
                                <div class="icon icon-fix pointer">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </div>
                                <a href="view_rank_by_date.php?class_id=<?php echo $id; ?>&rank_id=<?php echo $rank_id ?>" class="small-box-footer">
                                    View Students Score 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                                <div class="info-box bg-blue pointer">
                                    <span class="info-box-icon center"><i class="fa fa-eye icon-pad"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Students</span>
                                        <span class="info-box-number"><?php echo count($clazz); ?></span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $leave_percent ?>%"></div>
                                        </div>
                                        <span class="progress-description">
                                            leave &nbsp;
                                            <?php echo $leave; ?>&nbsp;
                                            <span class="label label-danger">
                                                <strong><?php echo $leave_percent; ?></strong>
                                                <i class="fa fa-percent"></i>                        
                                            </span>
                                        </span>
                                    </div><!-- /.info-box-content -->
                                </div>
                            </div>
                        </div><!-- ./col -->
                       


                <?php } 
                
                if($lexam==null){
                     header("Location: create_exam.php?createexam=1");
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