<?php
include 'includes/header.php';
include '../model/manageclass.php';
include '../model/manageexammarks.php';
include '../model/manageexam.php';

//   $list = getAllClasses();
if ($user_session->getRole() == 'Admin') {
    $list = getAllClasses();
} else {
    $list = getAllClassesUserRole($user_session->getUserID());
}
if(isset($_GET['id'])) {
    $exam_id = $_GET['id'];
   $exam = getOneExam($exam_id);
   if($exam === null) {
     header("Location:404.php");
   }
  } else {
    header("Location:404.php");
  }
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_GET['id'];
    $class_id = $_POST['class_id'];
    $user_id = $user_session->getUserID();
    deleteClassExam($user_id, $exam_id, $class_id);
  } 
  $examLID = getLastExam();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php // var_dump($exam); ?>
            Score Management
        </h1>
        <ol class="breadcrumb no-padding">
            <small>  <i class="fa fa-square" style="color:#dd4b39" aria-hidden="true"></i> Not yet add score<br>
                <i class="fa fa-square" style="color:#3c8dbc" aria-hidden="true"></i> Already add score
            </small>
        </ol>
    </section>

    <!-- Main content -->
    <?php
    if ($user_session->getRole() == 'Teacher') {
        ?>
        <section class="content" id="exam_table"> 
            <div class="row">
                <?php
                foreach ($list as $key => $value) {
                    $id = $list[$key]['class_id'];
                    $clazz = getAllStudentInClass($id);
                    $lexam = getExamClass($exam_id);
                    $room_exam = checkExamMark($id,$lexam[0]['exam_id']);
                    $getExam = getExamMarkID($id,$lexam[0]['exam_id']);
                    $pass = 0;
                    foreach ($getExam as $keys => $value) {
                        if ($getExam[$keys]['total'] > 50) {
                            $pass ++;
                        }
                    }

                    $pass_percent = count($getExam) > 0 ? number_format(($pass * 100) / count($getExam), 2) : number_format(0, 2);

                    if (empty($room_exam)) {
                        ?>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red class-box">
                                <div class="inner pointer">
                                    <h3 class="pre-wrap"><?php echo $list[$key]['class_name']; ?></h3>
                                    <p style="height:50px"> 
                                        Teacher:&nbsp; 
                                        <span class="label label-warning"><?php echo $list[$key]['teacher_name'] ?></span>
                                    </p>
                                </div>
                                <div class="icon icon-fix pointer">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </div>
                                <a href="add_score.php?id=<?php echo $id; ?>&exam_id=<?php echo $exam_id ?>" class="small-box-footer">
                                    Insert Students Score 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                                <div class="info-box bg-red-active pointer">
                                    <span class="info-box-icon center"><i class="fa fa-pencil-square-o icon-pad"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Students</span>
                                        <span class="info-box-number"><?php echo count(getAllStudentInClassLeaveFlag($id)); ?></span>
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
                                    </div><!-- /.info-box-content -->
                                </div>
                            </div>
                            <div style="margin-bottom:10px">
                                <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id?>" data-toggle="modal" data-target="#confirmDelete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div><!-- ./col -->
                        <?php
                    } else {
                        ?>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-light-blue class-box">
                                <div class="inner pointer">
                                    <h3 class="pre-wrap"><?php echo $list[$key]['class_name']; ?></h3>
                                    <p style="height:50px">
                                        Teacher:&nbsp; 
                                        <span class="label label-warning"><?php echo $list[$key]['teacher_name'] ?></span>
                                    </p>
                                </div>
                                <div class="icon icon-fix pointer">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </div>
                                <a href="view_score.php?id=<?php echo $id; ?>&exam_id=<?php echo $exam_id ?>" class="small-box-footer">
                                    View Students Score 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                                <div class="info-box bg-blue pointer">
                                    <span class="info-box-icon center"><i class="fa fa-eye icon-pad"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Students</span>
                                        <span class="info-box-number"><?php echo count($getExam); ?></span>
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
                                    </div><!-- /.info-box-content -->
                                </div>
                            </div>
                            <div style="margin-bottom:10px">
                            <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id?>" data-toggle="modal" data-target="#confirmDelete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div><!-- ./col -->
                        <?php
                    }
                    ?>
                <?php } ?>
            </div><!-- /.row -->
        </section>
        <?php
    } else {
        ?>
        <section class="content" id="exam_table">
            <div class="row">
                <?php
                foreach ($list as $key => $value) {
                    $id = $list[$key]['class_id'];
                    $clazz = getAllStudentInClass($id);
                    $lexam = getExamClass($exam_id);
                    $room_exam = checkExamMark($id,$lexam[0]['exam_id']);
                    $getExam = getExamMarkID($id,$lexam[0]['exam_id']);
                    $pass = 0;
                    foreach ($getExam as $keys => $value) {
                        if ($getExam[$keys]['total'] > 50) {
                            $pass ++;
                        }
                    }

                    $pass_percent = count($getExam) > 0 ? number_format(($pass * 100) / count($getExam), 2) : number_format(0, 2);
                    
                    if (empty($room_exam)) {
                        ?>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red class-box">
                                <div class="inner pointer">
                                    <h3 class="pre-wrap"><?php echo $list[$key]['class_name']; ?></h3>
                                    <p style="height:50px">
                                        Teacher:&nbsp; 
                                        <span class="label label-warning"><?php echo $list[$key]['teacher_name'] ?></span>
                                    </p>
                                </div>
                                <div class="icon icon-fix pointer">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </div>
                                <a href="add_score.php?id=<?php echo $id; ?>&exam_id=<?php echo $exam_id ?>" class="small-box-footer">
                                    Insert Students Score 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                                <div class="info-box bg-red-active pointer">
                                    <span class="info-box-icon center"><i class="fa fa-pencil-square-o icon-pad"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Students</span>
                                        <span class="info-box-number"><?php echo count(getAllStudentInClassLeaveFlag($id)); ?></span>
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
                                    </div><!-- /.info-box-content -->
                                </div>
                            </div>
                            <div style="margin-bottom:10px">
                                <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id?>" data-toggle="modal" data-target="#confirmDelete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div><!-- ./col -->
                        <?php
                    } else {
                        ?>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-light-blue class-box">
                                <div class="inner pointer">
                                    <h3 class="pre-wrap"><?php echo $list[$key]['class_name']; ?></h3>
                                    <p style="height:50px">
                                        Teacher:&nbsp; 
                                        <span class="label label-warning"><?php echo $list[$key]['teacher_name'] ?></span>
                                    </p>
                                </div>
                                <div class="icon icon-fix pointer">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </div>
                                <a href="view_score.php?id=<?php echo $id; ?>&exam_id=<?php echo $exam_id ?>" class="small-box-footer">
                                    View Students Score 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                                <div class="info-box bg-blue pointer">
                                    <span class="info-box-icon center"><i class="fa fa-eye icon-pad"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Students</span>
                                        <span class="info-box-number"><?php echo count($getExam); ?></span>
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
                                    </div><!-- /.info-box-content -->
                                </div>
                            </div>
                            <div style="margin-bottom:10px">
                            <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id?>" data-toggle="modal" data-target="#confirmDelete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div><!-- ./col -->
                        <?php
                    }
                    ?>


                <?php } ?>
            </div><!-- /.row -->
        </section>
    <?php }
    ?>
</div>
<?php
include 'includes/footer.php';
?>
<!-- Modal Dialog -->
<div class="modal fade" style="margin-top: 100px;" id="confirmDelete"
  role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
          aria-hidden="true" id="btnClose">&times;</button>
        <h4 class="modal-title">Remove this Exam?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about this ?</p>
      </div>
      <div class="modal-footer">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">
          <input type="hidden" name="class_id" value="" id="class_id" />
          <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-hand-paper-o"></i>
            Cancel
          </button>
          <button type="submit" class="btn btn-danger" id="btnDelete">
            <i class="fa fa-trash"></i>
            Remove
          </button>
        </form>

      </div>
      <!--/ modal-footer -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dialog -->
</div>
<script type="text/javascript">

    $(document).ready(function () {
        $('#exam_table').on('click', '.btn-delete', function() {
            $('#class_id').val($(this).data('id'));
        });
        $(".content-wrapper").on("click", ".class-box", function (e) {
            if ($(e.target).is("a, button"))
                return;
            location.href = $(this).find("a").attr("href");
        });
    });

</script>