<?php
include 'includes/header.php';
//include '../model/managesettings.php';

 if($user_session->getRole() !== 'Admin') {
    header("Location:403.php");
  }
// student error message
$school_name_kh_err = "";
$school_name_en_err = "";
$phone_number_err = "";
$email_err = "";

$address_err = "";

// $getsettings = getSettings();

$setting = new Setting;
$getsetting = getSettings();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $user_session->getUserID();
    $st_err = 0;

    $setting->setSchoolNameKhmer($_POST['school_name_kh']);
    $setting->setSchoolNameEnglish($_POST['school_name_en']);
    $setting->setPhoneNumber($_POST['phone_number']);
    $setting->setEmail($_POST['email']);
    $setting->setWebsite($_POST['website']);
    $setting->setAddress($_POST['address']);
    $setting->setLogo($_POST['logo']);
    $setting->setRegisterUser($user_id);
    
    // school name validation
    if (empty($setting->getSchoolNameKhmer())) {
        $st_err = 1;
        $school_name_kh_err = "School name is required.";
    } 
    // school name validation
    if (empty($setting->getSchoolNameEnglish())) {
        $st_err = 1;
        $school_name_en_err = "School name is required.";
    } 
    // phone number validation
    if (empty($setting->getPhoneNumber())) {
        $st_err = 1;
        $phone_number_err = "Phone number is required.";
    } 
    // email name validation
    if (empty($setting->getEmail())) {
        $st_err = 1;
        $email_err = "Email is required.";
    } 
    
    // adress name validation
    if (empty($setting->getAddress())) {
        $st_err = 1;
        $address_err = "Adress is required.";
    } 

    if ($st_err === 0) {
        updateSetting($setting);
        
        header("Location:settings.php");
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Settings
            <small>Update Information School</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="studentForm" enctype="multipart/form-data"><!-- form start -->
            <!-- Horizontal Form -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h2 class="box-title">School Information Form</h2>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">School Information</h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        </div>                          
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">School Name Khmer</label>
                                                    <div class="col-md-8 col-sm-10 col-xs-10">
                                                        <input type="text" class="form-control" name="school_name_kh" placeholder="School Name Khmer" value="<?php echo $getsetting[0]['school_name_kh']; ?>">
                                                        <span class="error col-md-12 no-padding"><?php echo $school_name_kh_err; ?></span>
                                                    </div>                            
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">School Name English</label>
                                                    <div class="col-md-8 col-sm-10 col-xs-10">
                                                        <input type="text" class="form-control" name="school_name_en" placeholder="School Name English" value="<?php echo $getsetting[0]['school_name_en']; ?>">
                                                        <span class="error col-md-12 no-padding"><?php echo $school_name_en_err; ?></span>
                                                    </div>                             
                                                </div>
                                            </div>                                
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">Phone number</label>
                                                    <div class="col-md-8 col-sm-10 col-xs-10">
                                                        <input type="text" class="form-control" name="phone_number" placeholder="Phone number" value="<?php echo $getsetting[0]['phone_number'] ?>">
                                                        <span class="error col-md-12 no-padding"><?php echo $phone_number_err; ?></span>
                                                    </div>                            
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">Email</label>
                                                    <div class="col-md-8 col-sm-10 col-xs-10">
                                                        <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $getsetting[0]['email'] ?>">
                                                        <span class="error col-md-12 no-padding"><?php echo $email_err; ?></span>
                                                    </div>                             
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-2 col-sm-2 col-xs-2 control-label">Web Site</label>
                                                    <div class="col-md-8 col-sm-10 col-xs-10">
                                                        <input type="text" class="form-control" name="website" placeholder="Website" value="<?php echo $getsetting[0]['website'] ?>">
                                                       
                                                    </div>                             
                                                </div>
                                            </div>   
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 col-sm-2 col-xs-2 control-label">Address</label>
                                            <div class="col-md-8 col-sm-10 col-xs-10">
                                                <textarea class="form-control no-resize" name="address" placeholder="Current Address"><?php echo $getsetting[0]['address'] ?></textarea>
                                                <span class="error col-md-12 no-padding"><?php echo $address_err; ?></span>
                                            </div>
                                        </div> 


                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>          

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Logo</h3>
          
                                    </div><!-- /.box-header -->  
                                    <div class="row">
                                        <div class="photo" style="margin-left:200px;">
                                            <img src="uploads/logo/<?php echo $getsetting[0]['logo'] ?>" width='200px'  height='200px' >
                                            <input type="file" name="image" style="margin-top: 10px; margin-bottom: 10px;">
                                            <input type="hidden" name="logo" value="<?php echo $getsetting[0]['logo'] ?>">
                                        </div> 
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-download"></i>&nbsp;Submit</button>
                                </div>
                            </div>                  
                        </div>
                    </div>
                </div>                   

            </div><!-- /.row -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include 'includes/footer.php';
?>

<!-- bootstrap chosen -->
<script src="../js/chosen.jquery.js"></script>
<!-- moment with locale -->
<script src="../js/moment-with-locales.min.js"></script>
<!-- bootstrap datetime picker -->
<script src="../js/bootstrap-datetimepicker.min.js"></script>
<!-- intl tel input -->
<script src="../js/intlTelInput.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../plugins/iCheck/icheck.min.js"></script>

<script>

    $(document).ready(function () {

        $('#payment').on('ifChecked', function () {
            $('#duration').prop('disabled', false);
            $('[name="fee"]').prop('disabled', false);
            $('.chosen-select').trigger('chosen:updated');
            $('#expire_payment').addClass('hide').find('[name="expire_paymentdate"]').prop('disabled', true);
            prevalidateForm('#studentForm');
        }).on('ifUnchecked', function () {
            $('#duration').prop('disabled', true);
            $('[name="fee"]').prop('disabled', true);
            $('.chosen-select').trigger('chosen:updated');
            $('#expire_payment').removeClass('hide').find('[name="expire_paymentdate"]').prop('disabled', false);
        });

        remoteFormControliCheck('#no_dad', '#father', '#no_mom');
        remoteFormControliCheck('#no_mom', '#mother', '#no_dad');

        $('#dob').blur(function () {
            $("#age").val(getAge($(this).val()));
        });

        $('#class_id').change(function () {
            var time = $(this).find(':selected').data('time');
            var level = $(this).find(':selected').data('level')
            var option = $(this).prop('selectedIndex');
            $('#study_time').val(time);
            $('#level').val(level);
        });

        $('#studentForm')
                // IMPORTANT: You must declare .on('init.field.fv')
                // before calling .formValidation(options)
                .on('init.field.fv', function (e, data) {
                    // data.fv      --> The FormValidation instance
                    // data.field   --> The field name
                    // data.element --> The field element
                    var field = data.field, // Get the field name
                            $field = data.element, // Get the field element
                            bv = data.fv;           // FormValidation instance   
                    var $parent = $field.parents('.form-group'),
                            $icon = $parent.find('.form-control-feedback[data-fv-icon-for="' + field + '"]');

                    // You can retrieve the icon element by
                    // $icon = data.element.data('fv.icon');

                    $icon.on('click.clearing', function () {
                        // Check if the field is valid or not via the icon class
                        if ($icon.hasClass('fa-times')) {
                            // Clear the field
                            $field.val('');
                            bv.resetField(data.element);
                        }
                    });
                })
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'fa fa-check',
                        invalid: 'fa fa-times',
                        validating: 'fa fa-refresh'
                    },
                    excluded: ':disabled',
                    addOns: {
                        mandatoryIcon: {
                            icon: 'fa fa-asterisk'
                        }
                    },
                    fields: {
                        student_name: {
                            validators: {
                                notEmpty: {
                                    message: 'The student name is required'
                                },
                                stringLength: {
                                    max: 30,
                                    trim: true,
                                    message: 'The student name must be between 30 characters long'
                                }
                            }
                        },
                        latin_name: {
                            validators: {
                                notEmpty: {
                                    message: 'The latin name is required'
                                },
                                stringLength: {
                                    max: 30,
                                    trim: true,
                                    message: 'The latin name must be between 30 characters long'
                                },
                                regexp: {
                                    regexp: "^[a-zA-Z ]*$",
                                    message: 'Please input only English characters'
                                },
                            }
                        },
                        student_no: {
                            validators: {
                                notEmpty: {
                                    message: 'The student id number is required'
                                },
                                stringLength: {
                                    max: 20,
                                    trim: true,
                                    message: 'The student id number must be between 20 characters long'
                                }
                            }
                        },
                        dob: {
                            validators: {
                                notEmpty: {
                                    message: 'The date of birth is require'
                                }
                            }
                        },
                        gender: {
                            validators: {
                                notEmpty: {
                                    message: 'The gender is require'
                                }
                            }
                        },
                        birth_place: {
                            validators: {
                                notEmpty: {
                                    message: 'The place of birth is require'
                                },
                                stringLength: {
                                    max: 300,
                                    trim: true,
                                    message: 'The place of birth must be between 300 characters long'
                                }
                            }
                        },
                        nationality: {
                            validators: {
                                notEmpty: {
                                    message: 'The nationality is require'
                                }
                            }
                        },
                        religion: {
                            validators: {
                                notEmpty: {
                                    message: 'The religion is require'
                                }
                            }
                        },
                        address: {
                            validators: {
                                notEmpty: {
                                    message: 'The address is require'
                                },
                                stringLength: {
                                    max: 300,
                                    trim: true,
                                    message: 'The current must be between 300 characters long'
                                }
                            }
                        },
                        emc_name: {
                            validators: {
                                notEmpty: {
                                    message: 'The emergency name is require'
                                },
                                stringLength: {
                                    max: 150,
                                    trim: true,
                                    message: 'The emergency name must be between 150 characters long'
                                }
                            }
                        },
                        emc_relationship: {
                            validators: {
                                notEmpty: {
                                    message: 'The emergency relationship is require'
                                }
                            }
                        },
                        emc_age: {
                            validators: {
                                notEmpty: {
                                    message: 'The emergency age is require'
                                },
                                greaterThan: {
                                    value: 1,
                                    message: 'The value cannot be 0'
                                },
                                integer: {
                                    message: 'The number canot contain any . or ,'
                                },
                                numeric: {
                                    message: 'The value is not a number'
                                }
                            }
                        },
                        emc_position: {
                            validators: {
                                notEmpty: {
                                    message: 'The emergency position is require'
                                },
                                stringLength: {
                                    max: 150,
                                    trim: true,
                                    message: 'The emergency position must be between 150 characters long'
                                }
                            }
                        },
                        emc_contact: {
                            validators: {
                                notEmpty: {
                                    message: 'The emergency contact number is require'
                                }
                            }
                        },
                        emc_address: {
                            validators: {
                                notEmpty: {
                                    message: 'The emergency address is require'
                                },
                                stringLength: {
                                    max: 300,
                                    trim: true,
                                    message: 'The emergency address must be between 300 characters long'
                                }
                            }
                        },
                        class_id: {
                            validators: {
                                notEmpty: {
                                    message: 'The classroom is require'
                                }
                            }
                        },
                        enroll_date: {
                            validators: {
                                notEmpty: {
                                    message: 'The enroll date is require'
                                }
                            }
                        },
                        expire_paymentdate: {
                            validators: {
                                notEmpty: {
                                    message: 'The expire date is require'
                                }
                            }
                        },
                        father_name: {
                            validators: {
                                notEmpty: {
                                    message: 'The father name is require'
                                },
                                stringLength: {
                                    max: 150,
                                    trim: true,
                                    message: 'The father name must be between 150 characters long'
                                }
                            }
                        },
                        father_nationality: {
                            validators: {
                                notEmpty: {
                                    message: 'The nationality is require'
                                }
                            }
                        },
                        father_occupation: {
                            validators: {
                                notEmpty: {
                                    message: 'The occupation is require'
                                },
                                stringLength: {
                                    max: 150,
                                    trim: true,
                                    message: 'The occupation must be between 150 characters long'
                                }
                            }
                        },
                        father_contact: {
                            validators: {
                                notEmpty: {
                                    message: 'The contact number is require'
                                }
                            }
                        },
                        mother_name: {
                            validators: {
                                notEmpty: {
                                    message: 'The mother name is require'
                                },
                                stringLength: {
                                    max: 150,
                                    trim: true,
                                    message: 'The mother name must be between 150 characters long'
                                }
                            }
                        },
                        mother_nationality: {
                            validators: {
                                notEmpty: {
                                    message: 'The nationality is require'
                                }
                            }
                        },
                        mother_occupation: {
                            validators: {
                                notEmpty: {
                                    message: 'The occupation is require'
                                },
                                stringLength: {
                                    max: 150,
                                    trim: true,
                                    message: 'The occupation must be between 150 characters long'
                                }
                            }
                        },
                        mother_contact: {
                            validators: {
                                notEmpty: {
                                    message: 'The contact number is require'
                                }
                            }
                        },
                        parent_address: {
                            validators: {
                                notEmpty: {
                                    message: 'The address is require'
                                },
                                stringLength: {
                                    max: 300,
                                    trim: true,
                                    message: 'The address must be between 300 characters long'
                                }
                            }
                        },
                        fee: {
                            validators: {
                                notEmpty: {
                                    message: 'The fee is required'
                                },
                                greaterThan: {
                                    value: 1,
                                    message: 'The value cannot be 0'
                                },
                                numeric: {
                                    message: 'The value is not a number',
                                    decimalSeparator: '.'
                                },
                                stringLength: {
                                    max: 7,
                                    trim: true,
                                    message: 'Please input the number within 7 digit.'
                                }
                            }
                        },
                        duration: {
                            validators: {
                                notEmpty: {
                                    message: 'Duration is require'
                                }
                            }
                        }
                    }
                })
                .find('#no_dad')
                // Called when the radios/checkboxes are changed
                .on('ifChanged', function (e) {
                    $('#studentForm').formValidation('resetField', 'father_name');
                    $('#studentForm').formValidation('resetField', 'father_nationality');
                    $('#studentForm').formValidation('resetField', 'father_occupation');
                    $('#studentForm').formValidation('resetField', 'father_contact');
                })
                .end()
                .find('#no_mom')
                // Called when the radios/checkboxes are changed
                .on('ifChanged', function (e) {
                    $('#studentForm').formValidation('resetField', 'mother_name');
                    $('#studentForm').formValidation('resetField', 'mother_nationality');
                    $('#studentForm').formValidation('resetField', 'mother_occupation');
                    $('#studentForm').formValidation('resetField', 'mother_contact');
                })
                .end()
                .find('#payment')
                // Called when the radios/checkboxes are changed
                .on('ifChanged', function (e) {
                    $('#studentForm').formValidation('resetField', 'duration');
                    $('#studentForm').formValidation('resetField', 'fee');
//                    $('#studentForm').formValidation('resetField', 'start');
//                    $('#studentForm').formValidation('resetField', 'expire');
                    $('#studentForm').formValidation('resetField', 'expire_paymentdate');
                })
                .end()
                .on('err.validator.fv', function (e, data) {
                    data.element
                            .data('fv.messages')
                            // Hide all the messages
                            .find('.help-block[data-fv-for="' + data.field + '"]').hide()
                            // Show only message associated with current validator
                            .filter('[data-fv-validator="' + data.validator + '"]').show();
                });
        prevalidateForm('#studentForm');

    });


    //initialize plug-in
    $(function () {

        //bootstrap-datetime-picker
        $('.dob').datetimepicker({
            format: 'DD/MMM/YYYY',
            extraFormats: ['dd/MM/yyyy', 'dd-MM-yyyy', 'DD/MMM/YYYY'],
            allowInputToggle: true,
            ignoreReadonly: true,
            maxDate: new Date(),
            useCurrent: true,
            showClear: true,
            showClose: true,
            showTodayButton: true
        }).on('dp.change dp.show', function (e) {
            // Revalidate the dob field
            $('#studentForm').formValidation('revalidateField', 'dob');
        });

        $('.date').datetimepicker({
            
            format: 'DD/MMM/YYYY',
            allowInputToggle: true,
            ignoreReadonly: true,
            useCurrent: true,
            showClear: true,
            showClose: true,
            showTodayButton: true
        }).on('dp.change dp.show', function (e) {
            // Revalidate the dob field
            $('#studentForm').formValidation('revalidateField', 'enroll_date');
            $('#studentForm').formValidation('revalidateField', 'expire_paymentdate');
        });
        ;             

        //Flat Green color scheme for iCheck
        $('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

        //Flat Blue color scheme for iCheck
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        //Flat Red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        //intl-tel-input
        $('.phone').intlTelInput({
            utilsScript: '../js/utils.js',
            allowExtensions: true,
            nationalMode: false,
            // autoHideDialCode: false,
            autoFormat: true,
            autoPlaceholder: true,
            preferredCountries: ['kh', 'jp', 'us']
        });

        //bootstrap-chosen
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({allow_single_deselect: true});
    });

</script>