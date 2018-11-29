<?php
include 'includes/header.php';
include '../model/managerank.php';

if ((isset($_GET['rank_id']))) {

    $rank_id = $_GET['rank_id'];
    $rank = getOneField($rank_id);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View All Records
            <small>Outstanding Students</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Rank Records</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green class-box">
                    <div class="inner pointer">
                        <h3 class="pre-wrap">Top of The Month</h3>
                        <hr style="margin-top: 5px;">
                        <p><?php
                            echo '<b>Title:</b> '.$rank->getRank_name();
                            $valDesc = $rank->getDescription();
                            if ($valDesc == NULL || $valDesc == "" || empty($valDesc)) {
                                echo '<div><b>Description: </b><small>No Description</small></div>';
                            } else {
                                echo '<div><b>Description: </b>' . $valDesc . '</div>';
                            }
                            ?>
                        </p>
                        <p class="center">
                            <span class="label label-warning"><?php echo $rank->getYear(); ?></span>
                        </p>                  
                    </div>
                    <div class="icon icon-fix pointer">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <a href="view_rank.php?rank_id=<?php echo $rank_id ?>" class="small-box-footer">
                        View Records

                    </a>    
                </div>
            </div><!-- ./col -->

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green class-box">
                    <div class="inner pointer">
                        <h3 class="pre-wrap">Top of Trimester</h3>
                        <hr style="margin-top: 5px;">
                        <p><?php
                            echo '<b>Title:</b> '.$rank->getRank_name();
                            $valDesc = $rank->getDescription();
                            if ($valDesc == NULL || $valDesc == "" || empty($valDesc)) {
                                echo '<div><b>Description: </b><small>No Description</small></div>';
                            } else {
                                echo '<div><b>Description: </b>' . $valDesc . '</div>';
                            }
                            ?>
                        </p>
                        <p class="center">
                            <span class="label label-warning"><?php echo $rank->getYear(); ?></span>
                        </p>                 
                    </div>
                    <div class="icon icon-fix pointer">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <a href="view_rank_trim.php?rank_id=<?php echo $rank_id ?>" class="small-box-footer">
                        View Records

                    </a>                

                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green class-box">
                    <div class="inner pointer">
                        <h3 class="pre-wrap">Top of Semester</h3>
                       <hr style="margin-top: 5px;">
                        <p><?php
                            echo '<b>Title:</b> '.$rank->getRank_name();
                            $valDesc = $rank->getDescription();
                            if ($valDesc == NULL || $valDesc == "" || empty($valDesc)) {
                                echo '<div><b>Description: </b><small>No Description</small></div>';
                            } else {
                                echo '<div><b>Description: </b>' . $valDesc . '</div>';
                            }
                            ?>
                        </p>
                        <p class="center">
                            <span class="label label-warning"><?php echo $rank->getYear(); ?></span>
                        </p>                 
                    </div>
                    <div class="icon icon-fix pointer">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <a href="view_rank_sem.php?rank_id=<?php echo $rank_id ?>" class="small-box-footer">
                        View Records

                    </a>                

                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green class-box">
                    <div class="inner pointer">
                        <h3 class="pre-wrap">Top of The Year</h3>
                        <hr style="margin-top: 5px;">
                        <p><?php
                            echo '<b>Title:</b> '.$rank->getRank_name();
                            $valDesc = $rank->getDescription();
                            if ($valDesc == NULL || $valDesc == "" || empty($valDesc)) {
                                echo '<div><b>Description: </b><small>No Description</small></div>';
                            } else {
                                echo '<div><b>Description: </b>' . $valDesc . '</div>';
                            }
                            ?>
                        </p>
                        <p class="center">
                            <span class="label label-warning"><?php echo $rank->getYear(); ?></span>
                        </p>                
                    </div>
                    <div class="icon icon-fix pointer">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <a href="view_rank_1y.php?rank_id=<?php echo $rank_id ?>" class="small-box-footer">
                        View Records

                    </a>                

                </div>
            </div>

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