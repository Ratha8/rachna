<?php
  include 'includes/header.php'; 

  if($user_session->getRole() !== 'Admin') {
    header("Location:403.php");
  }

  $list = getAllTeachers();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['user_id'];
    $user_id = $user_session->getUserID();
    deleteUser($id, $user_id);
    header("Location:teacher_list.php");
  }     
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            User List
            <small>List of all users in the system</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_user.php"></i> User Management</a></li>
            <li class="active">User List</a></li>                        
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List all available users</h3>
                  <div class="box-tools col-md-2 col-sm-2 btn-box no-padding">
                    <div class="input-group pull-right">
                      <a href="register_user.php" type="button" class="btn btn-block btn-success btn-sm">
                        <i class="fa fa-user-plus"></i>&nbsp;
                        <span>Add new User</span>
                      </a>
                    </div>
                  </div>                  
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table id="user-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="danger">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Add by</th>
                          <th>Add Date</th>
                          <th>Update by</th>
                          <th>Last Update</th>
                          
                        </tr>
                      </thead>
                      <tbody class="text-nowrap">
                        <?php 
                          $row_num = 1;

                          foreach($list as $key => $value) {
                        ?>
                        <tr>
                          <td><?php echo "<a href='edit_user.php?id=" . $list[$key]['user_id'] . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo $list[$key]['username']; ?></td>
                          <td><?php echo $list[$key]['role']; ?></td>
                          <td>
                            <?php
                              $user = getUserByUserID($list[$key]['register_user']); 
                              echo $user->getUsername(); 
                            ?>
                          </td>
                          <td><?php echo dateFormat($list[$key]['register_date'], "d - M - Y"); ?></td>
                          <td>
                            <?php
                              $user = getUserByUserID($list[$key]['update_user']); 
                              echo $user->getUsername(); 
                            ?>
                          </td>
                          <td><?php echo dateFormat($list[$key]['update_date'], "d - M - Y"); ?></td>
                       
                        </tr>
                        <?php $row_num++; } ?>                          
                      </tbody>
                      <tfoot class="center text-nowrap">
                        <tr class="danger">
                          <th>No.</th>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Add by</th>
                          <th>Add Date</th>
                          <th>Update by</th>
                          <th>Last Update</th>
                          
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


<!-- modal -->
<!--/. Modal Dialog  -->

  <script type="text/javascript">

    $(document).ready(function(){

      $('.table-responsive').on('click', '.btn-delete', function() {
        $('#u_id').val($(this).data('id'));
      });

      $('#btnDelete').click(function() {
        var url = $('deleteForm').attr('action');
        console.log('delete form action ' + url);
        var id = $('#u_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'user_id': id}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();

            $('.table-responsive').html(table);

            $('#user-list').DataTable({
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
      $('#user-list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });

  </script>