      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Developed by Realmax
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">RACHNA International School</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <form method="post" id="password_form" class="tab-content" action="../model/manageuser.php" id="password_form">
          <h3 class="control-sidebar-heading">Password Settings</h3>

          <input type="hidden" value="change_password" name="action">
          <input type="hidden" value="<?php echo $user_session->getUserID(); ?>" name="user_id">

          <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter current password">
            <span id="cur_pass_err" class="error"></span>
          </div>

          <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter new password">
            <div class="progress password-meter margin-ver" id="password-meter">
              <div class="progress-bar"></div>
            </div>            
            <span id="new_pass_err" class="error"></span>
          </div>

          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter new password again">
            <span id="con_pass_err" class="error"></span>
          </div>
          <div class="form-group">
            <small><span id="message-result" class="success"></span></small>
          </div>
          <div class="form-group">
            <button type="submit" id="btn-password" class="btn btn-warning pull-left">
              <i class="fa fa-refresh"></i>
              <span>Update</span>
            </button>  
          </div> 
        </form>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>      
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <!-- // <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
    <script src="../js/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script> 
    <!-- iCheck 1.0.1 -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>           
    <!-- AdminLTE App -->
    <script src="../js/app.min.js"></script>
    <!-- formvalidation.io -->
    <script src="../js/formValidation.min.js"></script>
    <!-- formvalidation-bootstrap -->
    <script src="../js/framework/bootstrap.min.js"></script>        
    <!-- formvalidation-bootstrap -->
    <script src="../js/mandatoryIcon.min.js"></script>

  </body>
</html>

<script type="text/javascript">

  function remoteFormControliCheck(selector, parent, alt) {
    $(selector).on('ifChecked', function() {
      controlElement(parent, true);
      if($(alt).prop('checked') == true) {
        $('#studentForm').formValidation('resetField', 'parent_address');
        $('#parent_address').prop('disabled', true);
      }      
    });

    $(selector).on('ifUnchecked', function () { 
      controlElement(parent, false);
      var checkAlt = $(alt).prop('checked');
      $('#parent_address').prop('disabled', false);
      prevalidateForm('#studentForm');
    });
  }

  function controlElement(parent, bol) {
    $(parent).find('input').prop('disabled', bol);
    $(parent).find('textarea').prop('disabled', bol);
    $(parent).find('.chosen-select').prop('disabled', bol);    
    $('.chosen-select').trigger('chosen:updated');
  }  

  function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    return age;
  } 

  function prevalidateForm(form_id) {
    $('input[type=text], input[type=password], input[type=email], input[type=tel], input[type=radio], input[type=checkbox], textarea, select').each(function(){
      if ($(this).val() != "" || $(this).val().length > 0) {
           $(form_id).formValidation('validateField', $(this).attr('name'));
      } 
    }); 
  }

  function searchStudent(param, condition) {
    $.ajax({
      url: 'search_student.php',
      type: 'POST',
      data: {'param': param, 'condition': condition}, 
      success: function(data) {
        var page_content = $(data).find('.content-wrapper').html();
        $('.content-wrapper').html(page_content);

        $('#search-list').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });       
      },
      complete: function(data) {
        $('#reload').html('<button id="btn-reload" class="btn btn-box-tool"><i class="fa fa-arrow-circle-left"></i><b class="text-green">&nbsp;Back</b></button>'); 
      }
    });   
  }

  function searchContact(param) {
    $.ajax({
      url: 'contact_student.php',
      type: 'POST',
      data: {'param': param}, 
      success: function(data) {
        var page_content = $(data).find('.content-wrapper').html();
        $('.content-wrapper').html(page_content);

        $('#student-list').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });                        
      },
      complete: function(data) {
        $('#reload').html('<button id="btn-reload" class="btn btn-box-tool"><i class="fa fa-arrow-circle-left"></i><b class="text-green">&nbsp;Back</b></button>'); 
      }      
    });
  }  

  function clearMessage(selector, duration) {
    selector.delay(duration).fadeOut('slow', function() {
      selector.html('');
    });      
  }

  $(function () {
    $('input[type="checkbox"].polaris, input[type="radio"].polaris').iCheck({
      checkboxClass: 'icheckbox_polaris',
      radioClass: 'iradio_polaris',
      // increaseArea: '50%' // optional
    });    

    $('input[type="checkbox"].futurico, input[type="radio"].futurico').iCheck({
      checkboxClass: 'icheckbox_futurico',
      radioClass: 'iradio_futurico',
      // increaseArea: '-50%' // optional
    }); 
  });     

  $(document).ready(function() {

    // $('#stu_list').click(function() {
    //   $.ajax({
    //     url: 'student_list.php',
    //     type: 'GET',
    //     success: function(data) {
    //       var page_content = $(data).find('.content-wrapper').html();
    //       $('.content-wrapper').html(page_content);

    //       $('#student-list').DataTable({
    //         "paging": true,
    //         "lengthChange": true,
    //         "searching": true,
    //         "ordering": true,
    //         "info": true,
    //         "autoWidth": false
    //       });                        
    //     },
    //     complete: function(data) {
    //       $('.action').remove();
    //     }      
    //   });
    // });

    var pathURI = window.location.pathname,
        path = pathURI.split('/'),  
        params = window.location.search;

    if(params.length <= 0) {
      $('#en').attr('href', path[path.length - 1] + "?lang=en");
      $('#kh').attr('href', path[path.length - 1] + "?lang=kh");
    } else {
//        alert(params.split('&'));
        if(params.split('&')[1]){
         param = params.split('&')[0].split('=')[0] != "?lang" ? params.split('&')[0] : '';
         param1 = params.split('&')[1].split('=')[1] != "?lang" ? params.split('&')[1] : '';
         param = param + '&' + param1;
        $('#en').attr('href', path[path.length - 1] + param + (param == '' ? '?' : '&') + "lang=en");
        $('#kh').attr('href', path[path.length - 1] + param + (param == '' ? '?' : '&') + "lang=kh");
        
    }else{
         param =  params.split('&')[0].split('=')[0] != "?lang" ?params.split('&')[0] : '';
        $('#en').attr('href', path[path.length - 1] + param + (param == '' ? '?' : '&') + "lang=en");
        $('#kh').attr('href', path[path.length - 1] + param + (param == '' ? '?' : '&') + "lang=kh");  
        }
        
    }

    $('body,html').click(function(e) {
      var target = e.target;
      if ($(target).parents('.control-sidebar').length <= 0 
          && $(target).parents('control-sidebar-bg').length <= 0
          && $(target).data('toggle') != 'control-sidebar' 
          && $(target).attr('class') != 'fa fa-cog'
          && $(target).attr('class') != 'control-sidebar-bg') {
        $('.control-sidebar').removeClass('control-sidebar-open');
      }
    });

    $('#home-logo').click(function() {
      location.href = "index.php";
    })

    $(".content-wrapper").on("click", "tr", function(e) {
      if ($(e.target).is("a, button, th, i, span") || $(e.target).parents('.bootstrap-datetimepicker-widget').length > 0) return;
      url = $(this).find("a").attr("href");
      if(typeof url !== "undefined") {
        location.href = url;
      } 
    }); 

    $(".content-wrapper").on("click", "#btn-reload", function(e) {
      location.reload();
    });    

    $('[name="condition"]').on('ifChecked', function() {
      var placeholder = '';
      if($(this).val() == 1) {
        placeholder = "Search Student...";
      } else {
        placeholder = "Search for contact info...";
      }
      $('#param').attr('placeholder', placeholder);
    });

    $('.sidebar-form').keydown(function(e) {
      if (e.which == 13) {
        var param = $('#param').val();
        var condition = $('[name="condition"]:checked').val();
        condition == 1 ? searchStudent(param) : searchContact(param) ;
      }
    });

    $('#search-btn').click(function() {
      var param = $('#param').val();
      var condition = $('[name="condition"]:checked').val();
      condition == 1 ? searchStudent(param) : searchContact(param) ;
    });    

    // $('#btn-password').click(function() {
    //   var form = $('#password_form');
    //   var url = form.attr('action');
    //   var form_data = form.serialize();
    //   $.ajax({
    //     url: url,
    //     type: 'POST',
    //     data: form_data, 
    //     dataType: 'json', 
    //     success: function(data) {
    //       var current_password = $('#cur_pass_err');
    //       var new_password = $('#new_pass_err');
    //       var confirm_password = $('#con_pass_err');
    //       var message = $('#message-result');

    //       current_password.html(data.cur_pass_err).fadeIn('fast');
    //       new_password.html(data.new_pass_err).fadeIn('fast');
    //       confirm_password.html(data.con_pass_err).fadeIn('fast');
    //       message.html(data.message).fadeIn('fast');

    //       data.cur_pass_err != "" ? clearMessage(current_password, 10000) : null;
    //       data.new_password != "" ? clearMessage(new_password, 10000) : null;
    //       data.con_pass_err != "" ? clearMessage(confirm_password, 10000) : null;

    //       if(data.message != "") {
    //         form.find('input:text, input:password, input:file, select, textarea').val('');
    //         clearMessage(message, 5000);           
    //       }     
    //     },
    //     error: function(xhr, desc, err) {
    //       console.log(xhr);
    //       console.log("Details: " + desc + "\nError:" + err);
    //     }
    //   });      
    // }); 

    $('#password_form')
    // IMPORTANT: on('init.field.fv') must be declared
    // before calling .formValidation(...)
    .on('init.field.fv', function(e, data) {      
      var field  = data.field,        // Get the field name
          $field = data.element,      // Get the field element
          bv     = data.fv;           // FormValidation instance
    
      var $parent = $field.parents('.form-group'),
          $icon = $parent.find('.form-control-feedback[data-fv-icon-for="' + field + '"]');
      $icon.on('click.clearing', function() {
        // Check if the field is valid or not via the icon class
        if ($icon.hasClass('fa-times')) {
          // Clear the field
          $field.val('');
          bv.resetField($field);
          if(data.element.attr('name') === 'new_password') {
            //var score = data.result.score,
            $bar  = $('#password-meter').find('.progress-bar');
            $bar.html('').css('width', '0%').removeClass().addClass('progress-bar');
          }
        }
      });
            
      // Create a span element to show valid message
      // and place it right before the field
      var $span = $('<small/>')
                  .addClass('help-block validMessage')
                  .attr('data-field', field)
                  .insertAfter($field)
                  .hide();

      // Retrieve the valid message via getOptions()
      var message = bv.getOptions(field).validMessage;
      if (message) {
        $span.html(message);
      }
    })
    .formValidation({
      framework: 'bootstrap',
      icon: {
        valid: 'fa fa-check',
        invalid: 'fa fa-times',
        validating: 'fa fa-refresh'
      },
      addOns: {
        i18n: {}
      },
      addOns: {
        mandatoryIcon: {
          icon: 'fa fa-asterisk'
        }
      },
      fields: {
        current_password: {
          verbose: false,
          //threshold: 8,
          validators: {
            notEmpty: {
              message: 'The current password is required!'
            },
            blank: {}
          }
        },
        new_password: {
          validMessage: 'To create a stronger password, please combine at leat one lower case letter, one upper case letter, a number and a symbol.',
          validators: {
            notEmpty: {
              message: 'The new password is required!'
            },
            stringLength: {
              min: 8,
              max: 30,
              message: 'The password must be within 8 and 30 characters long'
            },
            different: {
              field: 'current_password',
              message: 'The current password and new password cannot be the same!'
            },            
            callback: {
              callback: function(value, validator, $field) {
                var score = 0;
                if (value === '') {
                  return {
                    valid: true,
                    score: null
                  };
                }

                // Check the password strength
                score += ((value.length >= 8) ? 1 : -1);                  

                // The password contains uppercase character
                if (/[A-Z]/.test(value)) {
                  score += 1;
                }

                // The password contains uppercase character
                if (/[a-z]/.test(value)) {                                    
                  score += 1;
                }

                // The password contains number
                if (/[0-9]/.test(value)) {
                  score += 1;
                }

                // The password contains special characters
                if (/[!#$%&^~*_@?<>,.;:|]/.test(value)) {
                  score += 1;
                }

                return {
                  valid: true,
                  score: score    
                };
              }
            }
          }
        },
        confirm_password: {
          validators: {
            notEmpty: {
              message: 'The confirm password is required!'
            },
            identical: {
              field: 'new_password',
              message: 'The confirm password does not match!'
            }
          }
        }
      }
    }) 
    .on('success.validator.fv', function(e, data) {
      if (data.field === 'new_password' && data.validator === 'callback') {
        // Get the score
        var score = data.result.score,
            $bar  = $('#password-meter').find('.progress-bar');
            var message = 'Combine symbol, number and capital letter to make it stronger.';

        switch (true) {
          case (score === null || score == 0):
            $bar.html('').css('width', '5%').removeClass().addClass('progress-bar progress-bar-danger');
          break;

          case (score <= 0):
            $bar.html('Not good').css('width', '10%').removeClass().addClass('progress-bar progress-bar-danger');
          break;

          case (score > 0 && score <= 2):
            $bar.html('Weak').css('width', '25%').removeClass().addClass('progress-bar progress-bar-warning');
            $('#password_form').parent().find('[data-field="new_password"]').text(message);
          break;
                          
          case (score > 2 && score <= 3):
            $bar.html('Medium').css('width', '50%').removeClass().addClass('progress-bar progress-bar-info');
            $('#password_form').parent().find('[data-field="new_password"]').text(message);
          break;

          case (score > 3 && score <= 4):
            $bar.html('Good').css('width', '75%').removeClass().addClass('progress-bar progress-bar-primary');
            $('#password_form').parent().find('[data-field="new_password"]').text(message);
          break;

          case (score > 4): 
            $bar.html('Perfect').css('width', '100%').removeClass().addClass('progress-bar progress-bar-success');
            $('#password_form').parent().find('[data-field="new_password"]').text('This password is perfect!');
          break;

          default:
            break;
        }
      }
    })
    .on('success.field.fv', function(e, data) {
      var field  = data.field,        // Get the field name
          $field = data.element;      // Get the field element
          // Show the valid message element
          $field.next('.validMessage[data-field="' + field + '"]').show();
    })
    .on('err.field.fv', function(e, data) {
      var field  = data.field,    // Get the field name
      $field = data.element;      // Get the field element
      // Show the valid message element
      $field.next('.validMessage[data-field="' + field + '"]').hide();
    })
    .on('err.validator.fv', function(e, data) {
      data.element
          .data('fv.messages')
          // Hide all the messages
          .find('.help-block[data-fv-for="' + data.field + '"]').hide()
          // Show only message associated with current validator
          .filter('[data-fv-validator="' + data.validator + '"]').show();      
    })
    .on('success.form.fv', function(e) {
      e.preventDefault();
      var ajaxResponse;
      var $form = $(e.target),
          fv    = $form.data('formValidation');      
      var url = $form.attr('action');

      $.ajax({
        url: url,
        type: 'POST',
        data: $form.serialize(), 
        dataType: 'json', 
        success: function(data) {
          var current_password = $('#cur_pass_err');
          var new_password = $('#new_pass_err');
          var confirm_password = $('#con_pass_err');
          var message = $('#message-result');

          if(data.cur_pass_err != "") {
            fv.updateMessage('current_password', 'blank', data.cur_pass_err)
            .updateStatus('current_password', 'INVALID', 'blank');            
          }

          message.html(data.message).fadeIn('fast');

          if(data.message != "") {
            $form.find('input:text, input:password, input:file, select, textarea').val('');
            $form.formValidation('resetField', 'current_password');
            $form.formValidation('resetField', 'new_password');
            $form.formValidation('resetField', 'confirm_password');       
            $('#new_password').next('.validMessage[data-field="new_password"]').hide();   
            $bar  = $('#password-meter').find('.progress-bar');
            $bar.html('').css('width', '0%').removeClass().addClass('progress-bar');  
            clearMessage(message, 5000);           
          }   
        },
        error: function(xhr, desc, err) {
          console.log(xhr);
          console.log("Details: " + desc + "\nError:" + err);
        }
      });  
    });
    prevalidateForm('#password_form');
  });    
</script>
