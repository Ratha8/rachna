<?php

  include 'includes/header.php';

  include '../model/managecourse.php';

if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }

//$list = getAllCourses();   

   if($user_session->getRole() == 'Admin'){
       $list = getAllCourses();
  }else{
       $list = getAllCoursesUserRole($user_session->getUserID());
   }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $user_id = $user_session->getUserID();
    deleteCourse($user_id, $course_id);
    header("Location:course_list.php");
  } 
?>



      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>

            Course List

            <small>List all courses</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

            <li><a href="manage_school.php"> School Management</a></li>            

            <li class="active">Course List</li>

          </ol>

        </section>



        <!-- Main content -->

        <section class="content">

          <div class="row">

            <div class="col-xs-12">

              <div class="box">

                <div class="box-header">

                  <h3 class="box-title">List of all available courses in the school</h3>

                  <div class="box-tools col-md-2 col-sm-2 btn-box no-padding">
                    <div class="input-group pull-right">
                     
                      <a href="register_course.php" type="button" class="btn btn-block btn-success btn-sm">

                        <i class="fa fa-plus"></i>&nbsp;

                        <span>Add new Course</span>

                      </a>

                    </div>

                  </div>                 

                </div><!-- /.box-header -->

                <div class="box-body">

                  <div class="table-responsive">

                    <table id="course-list" class="table table-bordered table-hover">

                      <thead>

                        <tr class="danger">

                          <th>No.</th>

                          <th>Name</th>

                          <th>Duration (Month)</th>

                          <th>Register User</th>

                          <th>Register Date</th>

                          <th>Update User</th>

                          <th>Update Date</th>

                          <th>Action</th>

                        </tr>

                      </thead>

                      <tbody>

                        <?php 

                          $row = 1;

                          foreach($list as $key => $value) {

                            $id = $list[$key]['course_id'];

                            $register_user = getUserByUserID($list[$key]['register_user']);

                            $update_user = getUserByUserID($list[$key]['update_user'])

                        ?>

                        <tr>

                          <td><?php echo "<a href='edit_course.php?id=" . $id . "'>" . $row . "</a>"; ?></td>

                          <td><?php echo $list[$key]['course_name']; ?></td>

                          <td><?php echo $list[$key]['duration']; ?></td>

                          <td><?php echo $register_user != null ? $register_user->getUserName() : '<i class="text-red">User not found</i>'; ?></td>

                          <td><?php echo dateFormat($list[$key]['register_date'], "d - M - Y"); ?></td>

                          <td><?php echo $update_user != null ? $update_user->getUserName() : '<i class="text-red">User not found</i>'; ?></td>

                          <td><?php echo dateFormat($list[$key]['update_date'], "d - M - Y"); ?></td>

                          <td>

                            <a class="btn btn-primary" href="edit_course.php?id=<?php echo $id; ?>" 

                              role="button" data-toggle="tooltip" title="Update the course information.">

                              <i class="fa fa-pencil-square-o"></i>

                            </a>

                            <span data-toggle="tooltip" title="Delete this Course." data-placement="top">

                              <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirmDelete" 

                                      data-id="<?php echo $id; ?>">

                                <i class="fa fa-trash"></i>

                              </button>

                            </span>
                          

                          </td>

                        </tr>

                        <?php $row++; } ?>

                      </tbody>

                      <tfoot>

                        <tr class="danger">

                          <th>No.</th>

                          <th>Name</th>

                          <th>Duration</th>

                          <th>Register User</th>

                          <th>Register Date</th>

                          <th>Update User</th>

                          <th>Update Date</th>

                          <th>Action</th>

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

        <h4 class="modal-title">Remove this course?</h4>

      </div>

      <div class="modal-body">

        <p>Are you sure about this ?</p>

      </div>

      <div class="modal-footer">



        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">

          <input type="hidden" name="course_id" value="" id="c_id" />

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

<!-- modal -->

<!--/. Modal Dialog  -->



  <script type="text/javascript">

    $(document).ready(function(){



      $('.table-responsive').on('click', '.btn-delete', function() {

        $('#c_id').val($(this).data('id'));

      });



      $('#btnDelete').click(function() {

        var url = $('deleteForm').attr('action');

        var id = $('#c_id').val();

        $.ajax({

          url: url,

          type: 'POST',

          data: {'course_id': id}, 

          success: function(data) {

            var table = $(data).find('.table-responsive').html();



            $('.table-responsive').html(table);



            $('#course-list').DataTable({

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

      $('#course-list').DataTable({

        "paging": true,

        "lengthChange": false,

        "searching": true,

        "ordering": true,

        "info": true,

        "autoWidth": true

      });

    });



  </script>