<?php

  include 'includes/header.php';

  include '../model/manageclass.php';

  include '../model/managecourse.php';

  include '../model/managenationality.php';

   if($user_session->getRole() == 'Teacher') {
    header("Location:403.php");
  }

  // student error message

  $student_name_err = "";

  $latin_name_err = "";

  $student_no_err = "";

  $dob_err = "";

  $birth_place_err = "";

  $gender_err = "";

  $nationality_err = "";

  $religion_err = "";

  $address_err = "";



  // emergency error message

  $emc_name_err = "";

  $emc_relationship_err = "";

  $emc_age_err = "";

  $emc_position_err = "";

  $emc_contact_err = "";

  $emc_address_err = "";



  // level error message

  $class_id_err = "";

  $enroll_date_err = "";



  // parent error message

  $father_name_err = "";

  $father_nationality_err = "";

  $father_occupation_err = "";

  $father_contact_err = "";

  $mother_name_err = "";

  $mother_nationality_err = "";

  $mother_occupation_err = "";

  $mother_contact_err = "";

  $parent_address_err = "";


  if($user_session->getRole() == 'Admin'){
        $classes = getAllClasses();
   }else{
        $classes = getAllClassesReciep($user_session->getUserID());
   }
//  $classes = getAllClasses();

  $levels = getAllLevels();

  $course = getAllCourses();

  $nationalities = getAllNationalities();

  $relationships = getAllRelationships();



  $student = new Student;

  $parent_mom = new Parents;

  $parent_dad = new Parents;

  $emergency = new Emergency;

  $id = null;



  if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $student = getOneStudent($id);

    if($student === null) {

      header("Location:404.php");

    } else {

//      $classes = getAllClasses();  

      $parents = getParents($student->getStudentID());

      $emergency = getEmergency($student->getStudentID());

      $parents_address = null;



      if(count($parents) > 0) {

        foreach ($parents as $key => $value) {

          $parents_address = $parents[$key]['address'];

          if($parents[$key]['relationship'] == 1) {

            $parent_mom->setParentID($parents[$key]['parent_id']);

            $parent_mom->setParentName($parents[$key]['parent_name']);

            $parent_mom->setNationality($parents[$key]['nationality']);

            $parent_mom->setPosition($parents[$key]['position']);

            $parent_mom->setContactNumber($parents[$key]['contact_number']);

            $parent_mom->setRelationship($parents[$key]['relationship']);

          } else {

            $parent_dad->setParentID($parents[$key]['parent_id']);

            $parent_dad->setParentName($parents[$key]['parent_name']);

            $parent_dad->setNationality($parents[$key]['nationality']);

            $parent_dad->setPosition($parents[$key]['position']);

            $parent_dad->setContactNumber($parents[$key]['contact_number']);

            $parent_dad->setRelationship($parents[$key]['relationship']);

          }

        }

      } 

    }

  } else {

    header("Location:404.php");

  }  



  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $parent_dad = new Parents;

    $parent_mom = new Parents;

    $user_id = $user_session->getUserID();

    $switch_time = isset($_POST["switch_time"]) ? $_POST['switch_time'] : null;

    $st_err = 0;

    $dob = isset($_POST["dob"]) ? 

          (!empty($_POST["dob"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['dob']))) : "") : "";

    $enroll_date = isset($_POST["enroll_date"]) ? 

                  (!empty($_POST["enroll_date"]) ? date('Y-m-d', strtotime(str_replace('/', '-', $_POST['enroll_date']))) : "") : "";



    $student->setStudentID($_POST['student_id']);

    $student->setStudentName($_POST['student_name']);

    $student->setLatinName($_POST['latin_name']);

    $student->setStudentNo($_POST['student_no']);

    $student->setDob($dob);

    $student->setGender($_POST['gender']);

    $student->setBirthPlace(trim($_POST['birth_place']));

    $student->setNationality($_POST['nationality']);

    $student->setReligion($_POST['religion']);

    $student->setAddress(trim($_POST['address']));

    $student->setClassID($_POST['class_id']);    

    $student->setSwitchTime($switch_time);

    $student->setEnrollDate($enroll_date);

    $student->setUpdateUser($user_id);

    $student->setPhoto($_POST['photo']);



    $emergency->setEmergencyName($_POST['emc_name']);

    $emergency->setRelationship($_POST['emc_relationship']);

    $emergency->setAge($_POST['emc_age']);

    $emergency->setPosition($_POST['emc_position']);

    $emergency->setContactNumber($_POST['emc_contact']);

    $emergency->setAddress(trim($_POST['emc_address']));

    $emergency->setUpdateUser($user_id);



    // student name validation

    if(empty($student->getStudentName())){

      $st_err = 1;

      $student_name_err = "Student name is required.";

    } elseif(strlen($student->getStudentName()) > 100){

      $st_err = 1;

      $student_name_err = "Student name must be within 100 characters long.";

    }



    // student number validation

    if(empty($student->getStudentNo())){

      $st_err = 1;

      $student_no_err = "Student ID number is required.";

    } elseif(strlen($student->getStudentNo()) > 20){

      $st_err = 1;

      $student_no_err = "Student ID number must be within 20 characters long.";

    }    



    // latin name validation

    if(empty($student->getLatinName())){

      $st_err = 1;

      $latin_name_err = "Latin name is required.";

    } elseif(strlen($student->getLatinName()) > 100){

      $st_err = 1;

      $latin_name_err = "Latin name must be within 100 characters long.";

    } elseif(!preg_match("%^[A-Za-z ]{0,100}$%", $student->getLatinName())){

      $st_err = 1;

      $username_err = "Please input only English characters";

    }     



    // date of birth validation

    if(empty($student->getDob())){

      $st_err = 1;

      $dob_err = "Date of birth is required.";

    }



    // gender validation

    if(empty($student->getGender())){

      $st_err = 1;

      $gender_err = "Gender is required.";

    }    



    // birth place validation

    if(empty($student->getBirthPlace())){

      $st_err = 1;

      $birth_place_err = "Birth place is required.";

    } elseif(strlen($student->getBirthPlace()) > 300){

      $st_err = 1;

      $birth_place_err = "Birth place must be within 300 characters long.";

    }



    // nationality validation

    if(empty($student->getNationality())){

      $st_err = 1;

      $nationality_err = "Nationality is required.";

    }   



    // religion validation

    if(empty($student->getReligion())){

      $st_err = 1;

      $religion_err = "Religion is required.";

    }



    // address validation

    if(empty($student->getAddress())){

      $st_err = 1;

      $address_err = "Address is required.";

    } elseif(strlen($student->getAddress()) > 300) {

      $st_err = 1;

      $address_err = "Address must be within 300 characters long.";

    }



    // class id validation

    if(empty($student->getClassID())){

      $st_err = 1;

      $class_id_err = "Classroom is required.";

    }



    // enroll date validation

    if(empty($student->getEnrollDate())){

      $st_err = 1;

      $enroll_date_err = "Enroll date is required.";

    }



    // emergency name validation

    if(empty($emergency->getEmergencyName())){

      $st_err = 1;

      $emc_name_err = "Emergency name is required.";

    } elseif(strlen($emergency->getEmergencyName()) > 150) {

      $st_err = 1;

      $emc_name_err = "Emergency name must be between 150 characters long.";      

    }



    // emergency relationship validation

    if(empty($emergency->getRelationship())){

      $st_err = 1;

      $emc_relationship_err = "Relationship is required.";

    }                        

    

    // emergency age validation

    if(empty($emergency->getAge())){

      $st_err = 1;

      $emc_age_err = "Age is required.";

    } elseif(!containsDecimal($emergency->getAge()) || $emergency->getAge() < 0) {

      $st_err = 1;

      $emc_age_err = "Age must be a valid number.";      

    }



    // emergency position validation

    if(empty($emergency->getPosition())){

      $st_err = 1;

      $emc_position_err = "Position is required.";

    } elseif(strlen($emergency->getPosition()) > 150) {

      $st_err = 1;

      $emc_position_err = "Position must be between 150 characters long.";      

    }



    // emergency contact validation

    if(empty($emergency->getContactNumber())){

      $st_err = 1;

      $emc_contact_err = "Contact number is required.";

    }



    // emergency address validation

    if(empty($emergency->getAddress())){

      $st_err = 1;

      $emc_address_err = "Address is required.";

    } elseif(strlen($emergency->getAddress()) > 300) {

      $st_err = 1;

      $emc_address_err = "Address must be between 300 characters long.";      

    }





    if(isset($_POST['father_relationship'])) {

      $parent_dad = new Parents;

      $parent_dad->setStudentID($student->getStudentID());

      $parent_dad->setParentID($_POST['father_id']);

      $parent_dad->setParentName($_POST['father_name']);

      $parent_dad->setRelationship($_POST['father_relationship']);

      $parent_dad->setNationality($_POST['father_nationality']);

      $parent_dad->setPosition($_POST['father_occupation']);

      $parent_dad->setContactNumber($_POST['father_contact']);

      $parent_dad->setAddress(trim($_POST['parent_address']));

      $parent_dad->setRegisterUser($user_id);



      // father name validation

      if(empty($parent_dad->getParentName())){

        $st_err = 1;

        $father_name_err = "Father's name is required.";

      } elseif(strlen($parent_dad->getParentName()) > 150){

        $st_err = 1;

        $father_name_err = "Father's name must be within 150 characters long.";

      }



      // father nationality validation

      if(empty($parent_dad->getNationality())){

        $st_err = 1;

        $father_nationality_err = "Nationality is required.";

      }



      // father position validaiotn

      if(empty($parent_dad->getPosition())){

        $st_err = 1;

        $father_occupation_err = "Current occupation is required.";

      } elseif (strlen($parent_dad->getParentName()) > 150) {

        $st_err = 1;

        $father_occupation_err = "Occupation must be within 150 characters long.";

      }     



      // father contact number validation

      if(empty($parent_dad->getContactNumber())){

        $st_err = 1;

        $father_contact_err = "Contact number is required.";

      }



      // father address validaiotn

      if(empty($parent_dad->getAddress())){

        $st_err = 1;

        $parent_address_err = "Current address is required.";

      } elseif (strlen($parent_dad->getAddress()) > 300) {

        $st_err = 1;

        $parent_address_err = "Current address must be within 300 characters long.";

      }   

    }



    if(isset($_POST['mother_relationship'])) {

      $parent_mom = new Parents;

      $parent_mom->setStudentID($student->getStudentID());

      $parent_mom->setParentID($_POST['mother_id']);

      $parent_mom->setParentName($_POST['mother_name']);

      $parent_mom->setRelationship($_POST['mother_relationship']);

      $parent_mom->setNationality($_POST['mother_nationality']);

      $parent_mom->setPosition($_POST['mother_occupation']);

      $parent_mom->setContactNumber($_POST['mother_contact']);

      $parent_mom->setAddress(trim($_POST['parent_address']));

      $parent_mom->setRegisterUser($user_id);



      // mother name validation

      if(empty($parent_mom->getParentName())){

        $st_err = 1;

        $mother_name_err = "Mother's name is required.";

      } elseif(strlen($parent_mom->getParentName()) > 150){

        $st_err = 1;

        $mother_name_err = "Mother's name must be within 150 characters long.";

      }



      // mother nationality validation

      if(empty($parent_mom->getNationality())){

        $st_err = 1;

        $mother_nationality_err = "Nationality is required.";

      }



      // mother position validaiotn

      if(empty($parent_mom->getPosition())){

        $st_err = 1;

        $mother_occupation_err = "Current occupation is required.";

      } elseif (strlen($parent_mom->getParentName()) > 150) {

        $st_err = 1;

        $mother_occupation_err = "Occupation must be within 150 characters long.";

      }     



      // mother contact number validation

      if(empty($parent_mom->getContactNumber())){

        $st_err = 1;

        $mother_contact_err = "Contact number is required.";

      }



      // mother address validaiotn

      if(empty($parent_mom->getAddress())){

        $st_err = 1;

        $parent_address_err = "Current address is required.";

      } elseif (strlen($parent_mom->getAddress()) > 300) {

        $st_err = 1;

        $parent_address_err = "Current address must be within 300 characters long.";

      }   

    }



    if($st_err === 0){

      updateStudent($student);

      $emergency->setStudentID($student->getStudentID());

      updateEmergency($emergency);



      if(!empty($parent_dad->getParentID())) {

        updateParent($parent_dad);

      } else {

        $parent_id = isset($_POST["no_dad"]) ? $_POST['no_dad'] : null;

        if(!empty($parent_id)) {

          deleteParent($user_id, $parent_id);

        } elseif(!empty($parent_dad->getRelationship())) {

          insertParent($parent_dad);

        }

      }



      if(!empty($parent_mom->getParentID())) {

        updateParent($parent_mom);

      } else {

        $parent_id = isset($_POST["no_mom"]) ? $_POST['no_mom'] : null;

        if(!empty($parent_id)) {

          deleteParent($user_id, $parent_id);

        } elseif(!empty($parent_mom->getRelationship())) {

          insertParent($parent_mom);

        }

      }
      if (isset($_POST['payment'])) {
            $invoice = new Invoice;
            $invoice->setStart_new($student->getEnrollDate());
            updateInvoiceStudent($invoice);
      }

      header("Location:student_list.php");

    } 

  } 

?>



      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>

            Update Student information

            <small>

              Update the information of

              <a href="student_detail.php?id=<?php echo $student->getStudentID(); ?>">

                <?php echo $student->getStudentName(); ?>

              </a> 

            </small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

            <li><a href="manage_student.php"> Student Management</a></li>

            <li><a href="student_list.php"> Student List</a></li>

            <li class="active">Edit student</li>

          </ol>

        </section>



        <!-- Main content -->

        <section class="content">

          <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST" id="studentForm" enctype="multipart/form-data"><!-- form start -->

            <!-- Horizontal Form -->

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="box box-info">

                  <div class="box-header with-border">

                    <h2 class="box-title">Student Form</h2>

                  </div>

                  <div class="box-body">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="box box-danger">

                        <div class="box-header with-border">

                          <h3 class="box-title">Student Information</h3>

                        </div><!-- /.box-header -->

                        <div class="box-body">

                          <input type="hidden" value="<?php echo $id; ?>" name="student_id">

                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Full Name</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <input type="text" class="form-control" name="student_name" placeholder="Full Name"

                                         value="<?php echo $student->getStudentName(); ?>" >

                                  <span class="error col-md-12 no-padding"><?php echo $student_name_err;?></span>

                                </div>                            

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Latin</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <input type="text" class="form-control" name="latin_name" placeholder="Latin Name"

                                         value="<?php echo $student->getLatinName(); ?>" >

                                  <span class="error col-md-12 no-padding"><?php echo $latin_name_err;?></span>

                                </div>                             

                              </div>

                            </div>                                

                          </div>   



                          <div class="row">

                            <div class="col-md-4">

                              <div class="form-group">

                                <label class="col-md-6 col-sm-2 col-xs-2 control-label">Date of Birth</label>

                                <div class="col-md-6 col-sm-10 col-xs-10 datetime-plus">

                                  <div class='input-group dob'>

                                    <input type='text' name="dob" id="dob" class="form-control dob" placeholder="Date of Birth" readonly

                                           value="<?php echo dateFormat($student->getDob(), 'd/M/Y'); ?>" >

                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                  </div>

                                  <span class="error col-md-12 no-padding"><?php echo $dob_err;?></span>

                                </div>                            

                              </div>

                            </div>

                            <div class="col-md-2">

                              <div class="form-group">

                                <label class="col-md-6 col-sm-2 col-xs-2 control-label">Age</label>

                                <div class="col-md-6 col-sm-10 col-xs-10">

                                  <input type="text" class="form-control" disabled id="age" placeholder="Age">                        

                                </div>                              

                              </div>

                            </div>   

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Gender</label>

                                <div class="col-md-4 col-sm-10 col-xs-10 select">

                                  <select name="gender" data-placeholder="Select Gender" class="form-control chosen-select" tabindex="2">

                                    <option></option>

                                    <option value="1" <?php echo $student->getGender() == 1 ? 'selected' : ''; ?> >Male</option>

                                    <option value="2" <?php echo $student->getGender() == 2 ? 'selected' : ''; ?> >Female</option>

                                    <option value="3" <?php echo $student->getGender() == 3 ? 'selected' : ''; ?> >Other</option>

                                  </select>                          

                                  <span class="error col-md-12 no-padding"><?php echo $gender_err;?></span>

                                </div>

                              </div>

                            </div>                                                          

                          </div>



                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Place of Birth</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <textarea class="form-control no-resize" name="birth_place" placeholder="Place of Birth"><?php echo trim($student->getBirthPlace()); ?></textarea>

                                  <span class="error col-md-12 no-padding"><?php echo $birth_place_err;?></span>

                                </div>                      

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">ID</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <input type="text" class="form-control" name="student_no" placeholder="Student ID number"

                                         value="<?php echo $student->getStudentNo(); ?>" >

                                  <span class="error col-md-12 no-padding"><?php echo $student_no_err;?></span>

                                </div>                         

                              </div>

                            </div>                                

                          </div>                         



                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Nationality</label>

                                <div class="col-md-8 col-sm-10 col-xs-10 select">

                                  <select name="nationality" data-placeholder="Select Nationality" class="form-control chosen-select" tabindex="2">

                                    <option></option>

                                    <?php 

                                      foreach ($nationalities as $key => $value) {

                                        $selected = strcasecmp($nationalities[$key]['nationality_name'], $student->getNationality()) == 0 ? 'selected' : '';

                                        echo  "<option value='" . $nationalities[$key]['nationality_name'] . "' " . $selected . ">" .

                                              $nationalities[$key]['nationality_name'] . "</option>";

                                      }

                                    ?>

                                  </select>                              

                                  <span class="error col-md-12 no-padding"><?php echo $nationality_err;?></span>      

                                </div>                      

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Religion</label>

                                <div class="col-md-8 col-sm-10 col-xs-10 select">

                                  <select name="religion" data-placeholder="Select the Religion" class="form-control chosen-select" tabindex="2">

                                    <option><?php echo $student->getReligion(); ?></option>

                                    <option value="Buddhism" <?php echo strcasecmp($student->getReligion(), 'Buddhism') == 0 ? ' selected' : ''; ?> >

                                      Buddhism

                                    </option>

                                    <option value="Christianity" <?php echo strcasecmp($student->getReligion(), 'Christianity') == 0 ? ' selected' : ''; ?> >

                                      Christianity

                                    </option>

                                    <option value="Islam" <?php echo strcasecmp($student->getReligion(), 'Islam') == 0 ? ' selected' : ''; ?> >

                                      Islam

                                    </option>

                                    <option value="Hinduism" <?php echo strcasecmp($student->getReligion(), 'Hinduism') == 0 ? ' selected' : ''; ?> >

                                      Hinduism

                                    </option>

                                    <option value="Folk religion" <?php echo strcasecmp($student->getReligion(), 'Folk religion') == 0 ? ' selected' : ''; ?> >

                                      Folk religion

                                    </option>

                                    <option value="Other" <?php echo strcasecmp($student->getReligion(), 'Other') == 0 ? ' selected' : ''; ?> >

                                      Other

                                    </option>

                                    <option value="None" <?php echo strcasecmp($student->getReligion(), 'None') == 0 ? ' selected' : ''; ?> >

                                      None

                                    </option>

                                  </select>

                                  <span class="error col-md-12 no-padding"><?php echo $religion_err;?></span>    

                                </div>                          

                              </div>

                            </div>                                

                          </div>



                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label">Address</label>

                            <div class="col-md-4 col-sm-10 col-xs-10">

                              <textarea class="form-control no-resize" name="address" placeholder="Current Address"><?php echo ($student->getAddress()); ?></textarea>

                              <span class="error col-md-10 no-padding"><?php echo $address_err;?></span>

                            </div>

                          </div>           

                        </div><!-- /.box-body -->

                      </div><!-- /.box -->

                    </div>



                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="box box-warning collapsed-box">

                        <div class="box-header with-border">

                          <h3 class="box-title">Emergency Contact</h3>

                          <div class="box-tools pull-right">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

                          </div>                          

                        </div><!-- /.box-header -->

                        <div class="box-body">

                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Name</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <input type="text" class="form-control" name="emc_name" placeholder="Emergency Name"

                                         value="<?php echo $emergency->getEmergencyName(); ?>" >

                                  <span class="error col-md-12 no-padding"><?php echo $emc_name_err;?></span>

                                </div>                            

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Relationship</label>

                                <div class="col-md-8 col-sm-10 col-xs-10 select">

                                  <select name="emc_relationship" data-placeholder="Select the Relationship" class="form-control chosen-select" tabindex="2">

                                    <option></option>

                                    <?php 

                                      foreach ($relationships as $key => $value) {

                                        $selected = $relationships[$key]['relationship_id'] == $emergency->getRelationship() ? 'selected' : '';

                                        echo  "<option value='" . $relationships[$key]['relationship_id'] . "' " . $selected . 

                                              ">" . $relationships[$key]['relationship_name'] . "</option>";

                                      }

                                    ?>

                                  </select>

                                  <span class="error col-md-12 no-padding"><?php echo $emc_relationship_err;?></span>

                                </div>                            

                              </div>

                            </div>                                

                          </div>



                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Age</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <div class="col-md-3 no-padding">

                                    <input type="number" class="form-control age" name="emc_age" placeholder="Age"

                                           value="<?php echo $emergency->getAge(); ?>" >

                                  </div>

                                  <span class="error col-md-12 no-padding"><?php echo $emc_age_err;?></span>

                                </div>                           

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Position</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <input type="text" class="form-control" name="emc_position" placeholder="Position"

                                         value="<?php echo $emergency->getPosition(); ?>" >

                                  <span class="error col-md-12 no-padding"><?php echo $emc_position_err;?></span>

                                </div>                           

                              </div>

                            </div>                                

                          </div>



                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Phone</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <input type="tel" class="form-control phone" name="emc_contact"

                                         value="<?php echo $emergency->getContactNumber(); ?>" >

                                  <span class="error col-md-12 no-padding"><?php echo $emc_contact_err;?></span>

                                </div>                           

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Address</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <textarea class="form-control no-resize" name="emc_address" placeholder="Adress"><?php echo $emergency->getAddress(); ?></textarea>

                                  <span class="error col-md-12 no-padding"><?php echo $emc_address_err;?></span>

                                </div>                           

                              </div>

                            </div>                                

                          </div>

                         

                        </div><!-- /.box-body -->

                      </div><!-- /.box -->

                    </div>          



                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="box box-success collapsed-box">

                        <div class="box-header with-border">

                          <h3 class="box-title">Level and Course of Study</h3>

                          <div class="box-tools pull-right">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

                          </div>                          

                        </div><!-- /.box-header -->

                        <div class="box-body">

                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Room</label>

                                <div class="col-md-8 col-sm-10 col-xs-10 select">

                                  <select name="class_id" id="class_id" data-placeholder="Select the Classroom" class="form-control chosen-select" tabindex="2">

                                    <option></option>

                                    <?php 

                                      foreach($classes as $key => $value) {

                                        $level = '';

                                        $selected = $student->getClassID() == $classes[$key]['class_id'] ? 'selected' : '';

                                        $shift =  $classes[$key]['time_shift'] != 1 ? ($classes[$key]['time_shift'] != 2 ? "&nbsp;<i class='text-red'>(E)</i>" 

                                                  : "&nbsp;<i class='text-yellow'>(A)</i>" ) : "&nbsp;<i class='text-blue'>(M)</i>"  ;

                                        foreach ($levels as $keys => $value) {

                                          if($classes[$key]['level_id'] == $levels[$keys]['level_id']) {

                                            $level = $levels[$keys]['level_name'];

                                          }

                                        }

                                        echo "<option value='" . $classes[$key]['class_id'] . "' " . $selected . " " .

                                             "data-level='" . $level . 

                                             "' data-time='" . dateFormat($classes[$key]['start_time'], 'g:i A') .

                                             " - " . dateFormat($classes[$key]['end_time'], 'g:i A') . 

                                             "'>" . $classes[$key]['class_name'] . $shift . "</option>";

                                      }

                                    ?>

                                  </select>

                                  <span class="error col-md-12 no-padding"><?php echo $class_id_err;?></span>

                                </div>                          

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Time</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <div class='input-group time'>

                                    <input type='text' name="study_time" id="study_time" readonly class="form-control" placeholder="Study Time"/>

                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>

                                  </div>

                                </div>                           

                              </div>

                            </div>                                

                          </div>



                          <div class="row">

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-4 col-sm-2 col-xs-2 control-label">Level</label>

                                <div class="col-md-8 col-sm-10 col-xs-10">

                                  <input type="text" class="form-control" readonly name="level" id="level" placeholder="Level">

                                </div>                           

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="form-group">

                                <label class="col-md-2 col-sm-2 col-xs-2 control-label">Switch</label>

                                <div class="col-md-2 col-sm-10 col-xs-10">

                                  <label class="checkbox-inline no-padding-left">

                                    <input name="switch_time" type="checkbox" class="flat-green" value="1"

                                    <?php echo $student->getSwitchTime() == 1 ? 'checked' : ''; ?> >

                                  </label>

                                </div>                         

                              </div>

                            </div>                                

                          </div>



                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label">Enroll Date</label>

                            <div class="col-md-4 col-sm-10 col-xs-10 datetime">

                              <div class='input-group date'>

                                <input type='text' name="enroll_date" class="form-control" placeholder="Enroll Time" readonly

                                       value="<?php echo dateFormat($student->getEnrollDate(), 'd/M/Y'); ?>" >

                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                              </div>      

                              <span class="error col-md-12 no-padding"><?php echo $enroll_date_err;?></span>

                            </div>                      

                          </div> 



                        </div><!-- /.box-body -->

                      </div><!-- /.box -->

                    </div>                   



                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="box box-primary collapsed-box">

                        <div class="box-header with-border">

                          <h3 class="box-title">About Parents</h3>

                          <div class="box-tools pull-right">

                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

                          </div>                          

                        </div><!-- /.box-header -->

                        <div class="box-body">

                          <div id="father" data-disabled="<?php echo empty($parent_dad->getParentID())? 1 : 0 ?>">

                            <input type="hidden" name="father_relationship" value="2">

                            <input type="hidden" name="father_id" value="<?php echo $parent_dad->getParentID(); ?>">

                            <div class="row">

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-4 col-sm-2 col-xs-2 control-label">Father</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10">

                                    <input type="text" class="form-control" name="father_name" placeholder="Father's Name"

                                           value="<?php echo $parent_dad->getParentName(); ?>" >

                                    <span class="error col-md-12 no-padding"><?php echo $father_name_err;?></span>

                                  </div>                           

                                </div>

                              </div>

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-2 col-sm-2 col-xs-2 control-label">Nationality</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10 select">

                                    <select name="father_nationality" data-placeholder="Select Nationality" class="form-control chosen-select" tabindex="2">

                                      <option></option>

                                      <?php 

                                        foreach ($nationalities as $key => $value) {

                                          $selected = strcasecmp($parent_dad->getNationality(), $nationalities[$key]['nationality_name']) == 0? 'selected' : '';

                                          echo  "<option value='" . $nationalities[$key]['nationality_name'] . "' " . $selected . ">" .

                                                $nationalities[$key]['nationality_name'] . "</option>";

                                        }

                                      ?>

                                    </select>

                                    <span class="error col-md-12 no-padding"><?php echo $father_nationality_err;?></span>

                                  </div>                         

                                </div>

                              </div>                                

                            </div>



                            <div class="row">

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-4 col-sm-2 col-xs-2 control-label">Occupation</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10">

                                    <input type="text" class="form-control" name="father_occupation" placeholder="Current Occupation"

                                           value="<?php echo $parent_dad->getPosition(); ?>" >

                                    <span class="error col-md-12 no-padding"><?php echo $father_occupation_err;?></span>

                                  </div>                           

                                </div>

                              </div>

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-2 col-sm-2 col-xs-2 control-label">Phone</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10">

                                    <input type="tel" class="form-control phone" name="father_contact" placeholder="Phone Number"

                                           value="<?php echo $parent_dad->getContactNumber(); ?>" >

                                    <span class="error col-md-12 no-padding"><?php echo $father_contact_err;?></span>

                                  </div>                         

                                </div>

                              </div>                                

                            </div>



                          </div><!-- End of Father -->

                          <!-- Usability control for father form -->     

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label">None</label>

                            <div class="col-md-1 col-sm-10 col-xs-10">

                              <label class="checkbox-inline no-padding-left">

                                <input id="no_dad" name="no_dad" value="<?php echo $parent_dad->getParentID(); ?>" type="checkbox" class="flat-blue" 

                                       <?php echo empty($parent_dad->getParentID()) ? 'checked' : ''; ?> >

                              </label>

                            </div>                      

                          </div><!-- End of usability control-->             

                          <hr class="danger">

                          <div id="mother" data-disabled="<?php echo empty($parent_mom->getParentID())? 1 : 0 ?>" >

                            <input type="hidden" name="mother_relationship" value="1">

                            <input type="hidden" name="mother_id" value="<?php echo $parent_mom->getParentID(); ?>">

                            <div class="row">

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-4 col-sm-2 col-xs-2 control-label">Mother</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10">

                                    <input type="text" class="form-control" name="mother_name" placeholder="Mother's Name"

                                           value="<?php echo $parent_mom->getParentName(); ?>" >

                                    <span class="error col-md-12 no-padding"><?php echo $mother_name_err;?></span>

                                  </div>                           

                                </div>

                              </div>

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-2 col-sm-2 col-xs-2 control-label">Nationality</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10 select">

                                    <select name="mother_nationality" data-placeholder="Select Nationality" class="form-control chosen-select" tabindex="2">

                                      <option></option>

                                      <?php 

                                        foreach ($nationalities as $key => $value) {

                                          $selected = strcasecmp($parent_mom->getNationality(), $nationalities[$key]['nationality_name']) == 0? 'selected' : '';

                                          echo  "<option value='" . $nationalities[$key]['nationality_name'] . "' " . $selected . ">" .

                                                $nationalities[$key]['nationality_name'] . "</option>";

                                        }

                                      ?>

                                    </select>

                                    <span class="error col-md-12 no-padding"><?php echo $mother_nationality_err;?></span>

                                  </div>                        

                                </div>

                              </div>                                

                            </div> 



                            <div class="row">

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-4 col-sm-2 col-xs-2 control-label">Occupation</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10">

                                    <input type="text" class="form-control" name="mother_occupation" placeholder="Current Occupation"

                                           value="<?php echo $parent_mom->getPosition(); ?>" >

                                    <span class="error col-md-12 no-padding"><?php echo $mother_occupation_err;?></span>

                                  </div>                           

                                </div>

                              </div>

                              <div class="col-md-6">

                                <div class="form-group">

                                  <label class="col-md-2 col-sm-2 col-xs-2 control-label">Phone</label>

                                  <div class="col-md-8 col-sm-10 col-xs-10">

                                    <input type="tel" class="form-control phone" name="mother_contact" placeholder="Phone Number"

                                           value="<?php echo $parent_mom->getContactNumber(); ?>" >

                                    <span class="error col-md-12 no-padding"><?php echo $mother_contact_err;?></span>

                                  </div>                         

                                </div>

                              </div>                                

                            </div>

                        

                          </div><!-- End of Mother -->

                          <!-- Usability control for mother form -->

                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label">None</label>

                            <div class="col-md-1 col-sm-10 col-xs-10">

                              <label class="checkbox-inline no-padding-left">

                                <input id="no_mom" name="no_mom" value="<?php echo $parent_mom->getParentID(); ?>" type="checkbox" class="flat-blue" 

                                      <?php echo empty($parent_mom->getParentID())? 'checked' : ''; ?> >

                              </label>

                            </div>                      

                          </div>     

                          

                          <hr>



                          <div class="form-group">

                            <label class="col-md-2 col-sm-2 col-xs-2 control-label">Address</label>

                            <div class="col-md-4 col-sm-10 col-xs-10">

                              <textarea class="form-control no-resize" name="parent_address" id="parent_address" placeholder="Current Address"><?php echo $parents_address; ?></textarea>

                              <span class="error col-md-10 no-padding"><?php echo $parent_address_err;?></span>

                            </div>                      

                          </div>                        

                        </div><!-- /.box-body -->

                      </div><!-- /.box -->

                    </div>  

                      

                     <div class="col-md-12 col-sm-12 col-xs-12">

                                <div class="box box-info">

                                    <div class="box-header with-border">

                                        <h3 class="box-title">Photo</h3>

                                        <div class="box-tools pull-right">

                                            <!-- <label class="no-padding-left no-style">None&nbsp;

                                              <input name="payment" type="checkbox" class="flat-red" value="1" id="payment">

                                            </label> -->

                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                                        </div>                          

                                    </div><!-- /.box-header -->  

                                    <div class="row">

                                        <div class="photo" style="margin-left:200px;" width='300px'>

                                            <?php 

                                                if(!empty($student->getPhoto())){

                                                    $img_url = $student->getPhoto();

                                                }else{

                                                    $img_url = 'no-img.png';

                                                }

                                            ?>

                                            <img src="uploads/<?php echo $img_url?>" class="img-responsive" style="width: 300px;">

                                            <input type="file" name="newimg" style="margin-top: 10px; margin-bottom: 10px;" >

                                            <input type="hidden" name="photo" value="<?php echo $img_url?>">

                                        </div>    

                                    </div>

                                </div>

                            </div>





                    <div class="box-footer">

                      <div class="col-md-12 col-md-offset-2 col-sm-12 col-sm-offset-2 col-xs-12 col-xs-offset-2">

                        <button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i>&nbsp;Update</button>

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

<script>



  //initialize plug-in

  $(function () {



    //bootstrap-datetime-picker

    $('.dob').datetimepicker({

      format: 'DD/MMM/YYYY',

      allowInputToggle: true,

      ignoreReadonly: true,

      maxDate: new Date(),

      useCurrent: true,

      showClear: true,

      showClose: true,

      showTodayButton: true

    });



    $('.date').datetimepicker({

      format: 'DD/MMM/YYYY',

      allowInputToggle: true,

      ignoreReadonly: true,

      useCurrent: true,

      showClear: true,

      showClose: true,

      showTodayButton: true

    });    



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

    $('.chosen-select-deselect').chosen({ allow_single_deselect: true });



  });



  $(document).ready(function() {



    remoteFormControliCheck('#no_dad', '#father', '#no_mom');

    remoteFormControliCheck('#no_mom', '#mother', '#no_dad');



    $('#mother').data('disabled') == 1 ? controlElement('#mother', true) : null;

    $('#father').data('disabled') == 1 ? controlElement('#father', true) : null;



    $('#mother').data('disabled') == 1 && $('#father').data('disabled') == 1 ? 

    $('#parent_address').prop('disabled', true) : $('#parent_address').prop('disabled', false);



    $("#age").val(getAge($('#dob').val()));



    $('#dob').blur(function() {

      $("#age").val(getAge($(this).val()));

    });





    $('#study_time').val($('#class_id').find(':selected').data('time'));

    $('#level').val($('#class_id').find(':selected').data('level'));



    $('#class_id').change(function() {

      var time = $(this).find(':selected').data('time');

      var level = $(this).find(':selected').data('level')

      var option = $(this).prop('selectedIndex');

      $('#study_time').val(time);

      $('#level').val(level);

    });



    $('#studentForm') 

    // IMPORTANT: You must declare .on('init.field.fv')

    // before calling .formValidation(options)

    .on('init.field.fv', function(e, data) {

    // data.fv      --> The FormValidation instance

    // data.field   --> The field name

    // data.element --> The field element

      var field  = data.field,        // Get the field name

          $field = data.element,      // Get the field element

          bv     = data.fv;           // FormValidation instance   

      var $parent = $field.parents('.form-group'),

          $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + field + '"]');



      // You can retrieve the icon element by

      // $icon = data.element.data('fv.icon');



      $icon.on('click.clearing', function() {

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

    .on('ifChanged', function(e) {

      $('#studentForm').formValidation('resetField', 'father_name');

      $('#studentForm').formValidation('resetField', 'father_nationality');

      $('#studentForm').formValidation('resetField', 'father_occupation');

      $('#studentForm').formValidation('resetField', 'father_contact');

    })

    .end()

    .find('#no_mom')

    // Called when the radios/checkboxes are changed

    .on('ifChanged', function(e) {

      $('#studentForm').formValidation('resetField', 'mother_name');

      $('#studentForm').formValidation('resetField', 'mother_nationality');

      $('#studentForm').formValidation('resetField', 'mother_occupation');

      $('#studentForm').formValidation('resetField', 'mother_contact');

    })    

    .end()

    .on('err.validator.fv', function(e, data) {

      data.element

          .data('fv.messages')

          // Hide all the messages

          .find('.help-block[data-fv-for="' + data.field + '"]').hide()

          // Show only message associated with current validator

          .filter('[data-fv-validator="' + data.validator + '"]').show();

    });

    prevalidateForm('#studentForm');



  });



</script>