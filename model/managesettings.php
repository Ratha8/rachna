<?php

include 'setting.php';

function getSettings() {
    $sql = "SELECT 
                id,
                school_name_en,
                school_name_kh,
                phone_number,
                email,
                website,
                address,
                logo,
                register_user,
                register_date,
                update_user,
                update_date
            FROM T_Settings
            WHERE id = 1";

    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
}

function updateSetting($setting) {
    var_dump($setting);
    $conn = getConnection();
    $sql = "UPDATE  
                T_Settings 
            SET
                school_name_en = :school_name_en,
                school_name_kh = :school_name_kh,
                phone_number = :phone_number,
                email = :email,
                website = :website,
                address = :address,
                logo = :logo,
                update_user = :update_user,
                update_date = CURRENT_TIMESTAMP
            WHERE 
                id = 1";

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];

        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Working With File Extension
        $file_ext = explode('.', $file_name);
        $file_fname = explode('.', $file_name);

        $file_fname = strtolower(current($file_fname));
        $file_ext = strtolower(end($file_ext));
        $allowed = array('jpg', 'png', 'jpeg');


        if (in_array($file_ext, $allowed)) {

            if ($file_error === 0) {
                if ($file_size <= 5000000) {
                    $file_name_new = $file_fname . uniqid('', true) . '.' . $file_ext;
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $file_destination = 'uploads/logo/' . $file_name_new;
                    // echo $file_destination;
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        echo " uploaded";
                    } else {
                        echo "some error in uploading file" . mysql_error();
                    }
                }
            }
        } else {
            $file_name_new = $setting->getLogo();
        }
    }
    
    $school_kh = $setting->getSchoolNameKhmer();
    $school_en = $setting->getSchoolNameEnglish();
    $phone = $setting->getPhoneNumber();
    $email = $setting->getEmail();
    $website = $setting->getWebsite();
    $address = $setting->getAddress();
    $update_user = $setting->getUpdateUser();
    $id = $setting->getID();

    $stmt = $conn->prepare($sql);


    $stmt->bindParam(':school_name_en', $school_en);
    $stmt->bindParam(':school_name_kh', $school_kh);
    $stmt->bindParam(':phone_number', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':website', $website);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':logo', $file_name_new);
    $stmt->bindParam(':update_user', $update_user);
    $stmt->execute();
}

?>