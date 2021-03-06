<?php
include 'includes/header.php';
include '../model/managerank.php';

$list = getAllRanks();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rank_id = $_POST['rank_id'];
    $user_id = $user_session->getUserID();
    $action = $_POST['action'];
    if ($action == 'delete') {
        deleteRank($user_id, $rank_id);
        header("Location:view_rank_records.php");
    }
}
?>

<style>
    td{
        text-align: center !important;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View All Records
            <small>List of all current records</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_record.php">Student Ranking</a></li>
            <li class="active">Rank List</a></li>                        
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Rank List</h3>
                        <div class="box-tools col-md-2 col-sm-2 btn-box no-padding">
                            <div class="input-group pull-right">
                                <?php 
                                if($user_session->getRole() == 'Admin'){
                                    ?>
                                <a href="create_rank.php" type="button" class="btn btn-block btn-success btn-sm">
                                    <i class="fa fa-plus-circle"></i>&nbsp;
                                    <span>Create new Record</span>
                                </a> <?php } ?>
                            </div>
                        </div>                  
                    </div><!-- /.box-header -->

                    <!-- /.box-header -->


                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="rank-list" class="table table-bordered table-hover">
                                <thead class="center text-nowrap">
                                    <tr class="danger">
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th class="action">Option</th>
                                    </tr>
                                </thead>
                                <tbody class="text-nowrap">
                                    <?php
                                    $row_num = 1;
                                    $num = 0;
                                    foreach ($list as $key => $value) {
                                        $id = $list[$key]['rank_id'];
                                        $num = $num + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $num; ?> </td>
                                            <td><a href='view_rank_by_date.php?rank_id=<?php echo $id ?>'><?php echo $list[$key]['rank_name']; ?></a></td>
                                            <td><?php echo $list[$key]['description']; ?></td>
                                            <td><?php echo $list[$key]['year'] ?> </td>


                                            <td class="action">
                                            <?php 
                                            if($user_session->getRole() == 'Admin'){?>
                                                <a class="btn btn-success btn-icon" href="student_reports.php?id=<?php echo $id; ?>" role="button" 
                                                   data-toggle="tooltip" title="Edit Rank Information.">
                                                    <i class="fa fa-file-text"></i>
                                                </a>
                                                <a class="btn btn-primary btn-icon" href="edit_rank.php?id=<?php echo $id; ?>" role="button" 
                                                   data-toggle="tooltip" title="Edit Rank Information.">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                                <span data-toggle="tooltip" title="Remove this rank." data-placement="top">
                                                    <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id; ?>" 
                                                            data-toggle="modal" data-target="#confirmDelete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </span> <?php } ?>                                                   

                                            </td>
                                        </tr>
                                    <?php } ?>                 
                                </tbody>
                                <tfoot class="center text-nowrap">
                                    <tr class="danger">
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Month/Year</th>
                                        <th class="action">Option</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

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
                <h4 class="modal-title">Remove this Record?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure about this ?</p>
            </div>
            <div class="modal-footer">

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">
                    <input type="hidden" name="rank_id" value="" id="u_id" />
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fa fa-hand-paper-o"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnDelete">
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

        $('.table-responsive').on('click', '.btn-delete', function () {
            $('#u_id').val($(this).data('id'));
        });

        $('#btnDelete').click(function () {
            var url = $('deleteForm').attr('action');
            var id = $('#u_id').val();
            $.ajax({
                url: url,
                type: 'POST',
                data: {'rank_id': id, 'action': 'delete'},
                success: function (data) {
                    var table = $(data).find('.table-responsive').html();

                    $('.table-responsive').html(table);

                    $('#rank-list').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    });
                }
            });
        });

    });

    $(function () {
        $('#rank-list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });

</script>