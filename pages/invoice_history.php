<?php
  include 'includes/header.php';
  include '../model/manageinvoice.php'; 
 if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }
  
  if($user_session->getRole() == 'Admin'){
      $list = getAllInvoices();
  }  else {
      $list = getAllInvoicesUserRole($user_session->getUserID());
}
  

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoice_id = $_POST['invoice_id'];
    $user_id = $user_session->getUserID();
    $invoice = getOneInvoice($invoice_id);
    $id = $invoice->getStudentID();
    deleteInvoice($user_id, $invoice_id);
    $lastInvoiceID = getStudentPaymentLastID($id);
    $student = getOneInvoice($lastInvoiceID[0]);
    if($student == NULL){
          $student = getOneStudent($invoice->getStudentID());
           $student = getOneStudent($id);
          $student->setExpirePaymentDate($student->getEnrollDate());
          $student->setStart_new($student->getEnrollDate());
          $student->setExpire_new($student->getEnrollDate());
    }
    changeExpireDate($student);
    header("Location:invoice_history.php");
  }     
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Invoice History
            <small>List of all invoices</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="manage_payment.php"></i>Payment Management</a></li>
            <li class="active">Invoice History</a></li>                        
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Invoice List of current month</h3>                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table id="invoice-list" class="table table-bordered table-hover">
                      <thead class="center text-nowrap">
                        <tr class="success">
                          <th>No.</th>
                          <th>Invoice Number</th>
                          <th>Invoice Date</th>
                          <th>Student Name</th>
                          <th>Amount Spent</th>
                          <th>Expire Date</th>
                          <th>Receptionist</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody class="text-nowrap">
                        <?php 
                          $row_num = 1;
                          foreach($list as $key => $value) {
                            $id = $list[$key]['invoice_id'];
                            $student = getOneStudent($list[$key]['student_id']);
                            $invoice_number = $list[$key]['invoice_id'];
                            if(!empty($list[$key]['invoice_number'])){
                              $invoice_number = $list[$key]['invoice_number'];
                            }
                        ?>
                        <tr>
                          <td><?php echo "<a href='invoice.php?id=" . $id . "'>" . $row_num . "</a>"; ?></td>
                          <td><?php echo str_pad($invoice_number, 6, '0', STR_PAD_LEFT); ?></td>
                          <td><?php echo dateFormat($list[$key]['invoice_date'], "d - M - Y"); ?></td>
                          <td><?php echo $student != null ? $student->getStudentName() : '<i class="text-red">Unknown</i>'; ?></td>
                          <td>$&nbsp;<?php echo number_format($list[$key]['fee'], 2); ?></td>
                          <td><?php echo dateFormat($list[$key]['expire_paymentdate'], "d - M - Y"); ?></td>
                          <td><?php echo $list[$key]['receptionist']; ?></td>
                          <td>                               
                            <a class="btn btn-default btn-icon" target="_blank" href="invoice_print.php?id=<?php echo $id; ?>" role="button" 
                               data-toggle="tooltip" title="Print this invoice.">
                              <i class="fa fa-print"></i>
                            </a>
                            <a class="btn btn-warning btn-icon" href="invoice.php?id=<?php echo $id; ?>" role="button"
                               data-toggle="tooltip" title="Preview this invoice.">
                              <i class="fa fa-search"></i>
                            </a>
                                                          
                            <span data-toggle="tooltip" title="Delete this invoice?" data-placement="top">
                              <button class="btn btn-danger btn-icon btn-delete" data-id="<?php echo $id; ?>"
                                      data-toggle="modal" data-target="#confirmDelete">
                                <i class="fa fa-trash"></i>
                              </button>   
                            </span>                            
                           
                          </td>
                        </tr>
                        <?php $row_num++; } ?>                          
                      </tbody>
                      <tfoot class="center text-nowrap">
                        <tr class="success">
                          <th>No.</th>
                          <th>Invoice Number</th>
                          <th>Invoice Date</th>
                          <th>Student Name</th>
                          <th>Amount Spent</th>
                          <th>Expire Date</th>
                          <th>Receptionist</th>
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
        <h4 class="modal-title">Remove this invoice?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure about this ?</p>
      </div>
      <div class="modal-footer">

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="deleteForm">
          <input type="hidden" name="invoice_id" value="" id="i_id" />
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
        $('#i_id').val($(this).data('id'));
      });

      $('#btnDelete').click(function() {
        var url = $('deleteForm').attr('action');
        // var student_id = $('#s_id').val();
        var id = $('#i_id').val();
        $.ajax({
          url: url,
          type: 'POST',
          data: {'invoice_id': id}, 
          success: function(data) {
            var table = $(data).find('.table-responsive').html();

            $('.table-responsive').html(table);

            $('#invoice-list').DataTable({
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
      $('#invoice-list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });

  </script>