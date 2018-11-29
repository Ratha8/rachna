<?php
include 'includes/header.php';
include '../model/manageclass.php';
include '../model/managecourse.php';
include '../model/managerank.php';

$rank = new Rank;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $user_session->getUserID();
    $rank->setRank_name($_POST['rank_name']);
    $rank->setYear($_POST['year']);
    $rank->setDescription($_POST['description']);
    $rank->setRegister_user($user_id);
    $rank_id = insertRank($rank);
    header("Location:view_rank_records.php");
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Outstanding Students
            <small>Add new record to the list</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li>Student Ranking</li>
            <li class="active">Create Record</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- Horizontal Form -->
                <form class="form-horizontal" method="POST" id="rankForm">
                    <div class="box box-info">
                        <div class="box-header with-border">

                            <h3 class="box-title">Create Outstanding Record</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Name</label>
                                <div class="col-md-5 col-sm-10 col-xs-10">
                                    <input type="text" class="form-control" name="rank_name" placeholder="Record Title" required>
                                </div>
                            </div>                 
                            <div class="form-group">
                                <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Select Year</label>
                                <div class="col-md-2 col-sm-10 col-xs-10 select">
                                    <div class='input-group date'>
                                        <select name ="year" class="form-control">
                                            <script>
                                                var myDate = new Date();
                                                var year = myDate.getFullYear();
                                                for (var i = 1990; i < year + 2; i++) {
                                                   document.write('<option value="' + i + '" selected>' + i + '</option>');
                                                }
                                            </script>
                                        </select>
                                    </div>                      

                                </div>

                                <!--                                <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">To</label>
                                                                <div class="col-md-2 col-sm-10 col-xs-10 select">
                                                                    <div class='input-group date'>
                                                                        <input type='text' name="end_month" id="target_date" class="form-control" placeholder="Target Month" required=""/>
                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                    </div>                      
                                
                                                                </div>-->
                            </div>
                            <div class="form-group">
                                <label class="col-md-1 col-sm-2 col-xs-2 control-label no-padding-hori">Description</label>
                                <div class="col-md-5 col-sm-10 col-xs-10">

                                    <textarea class="form-control" placeholder="Description (optional)" name="description"></textarea>


                                </div>                       

                            </div>
                        </div> 

                        <div class="box-footer">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <button type="submit" class="btn btn-info pull-right" >
                                    <i class="fa fa-download"></i>
                                    Submit
                                </button>
                            </div>
                        </div><!-- /.box-footer -->                    
                    </div><!-- /.box-body -->
                </form>
            </div><!-- /.box -->
        </div>
    </section><!-- /.content -->
</div><!-- /.row -->
</div><!-- /.content-wrapper -->
<?php
include 'includes/footer.php';
?>

<script src="../js/chosen.jquery.js"></script>
<script>
                                                $(function () {
                                                    $('.chosen-select').chosen();
                                                });
</script>

<!-- moment with locale -->
<script src="../js/moment-with-locales.min.js"></script>
<!-- bootstrap datetime picker -->
<script src="../js/bootstrap-datetimepicker.min.js"></script>  
<!-- bootstrap chosen -->
<script src="../js/chosen.jquery.js"></script>  

<script type="text/javascript">

                                                $(document).ready(function () {

                                                    $('.form-information').on('blur', '#target_date', function () {
                                                        var target_date = $(this).val();
                                                        // var target_week = $('#target_week').val();
                                                        // var week_number = $('#target_week').find(':selected').data('week'); 
                                                        updateData(target_date, null, null);
                                                    })
                                                            .on('change', '#target_week', function () {
                                                                var target_week = $(this).val();
                                                                var week_number = $(this).find(':selected').data('week');
                                                                var target_date = $('#target_date').val();
                                                                updateData(target_date, target_week, week_number);
                                                            });

                                                });

                                                $(function () {
                                                    $('#student-list').DataTable({
                                                        "paging": true,
                                                        "lengthChange": true,
                                                        "searching": true,
                                                        "ordering": true,
                                                        "info": true,
                                                        "autoWidth": false
                                                    });

                                                    $('.date').datetimepicker({
                                                        format: 'MMMM YYYY',
                                                        allowInputToggle: true,
                                                        ignoreReadonly: true,
                                                        useCurrent: true,
                                                        showClear: true,
                                                        showClose: true,
                                                        showTodayButton: true
                                                    });

                                                    $('.date').data("DateTimePicker").defaultDate(new Date());

                                                    //bootstrap-chosen
                                                    $('.chosen-select').chosen();
                                                    $('.chosen-select-deselect').chosen({allow_single_deselect: true});
                                                });

</script>


