<?php
include 'invoices.php';
function insertInvoice($invoice){

    $conn = getConnection();

    $sql = "INSERT INTO T_Invoice(
                invoice_number,
                student_id,
                class_name,
                receptionist,
                duration,
                level,
                time_shift,
                start_time,
                end_time,
                fee,
                invoice_date,
                enroll_date,
                expire_paymentdate,
                register_user,
                update_user,
                start_new,
                expire_new)
            VALUES(
                :invoice_number,
                :student_id,
                :class_name,
                :receptionist,
                :duration,
                :level,
                :time_shift,
                :start_time,
                :end_time,
                :fee,
                :invoice_date,
                :enroll_date,
                :expire_paymentdate,
                :user_id,
                :user_id,
                :start_new,
                :expire_new
                )";
    $invoice_date = $invoice->getInvoiceDate();
    $invoice_number = $invoice->getInvoiceNumber();
    $student_id = $invoice->getStudentID();
    $class_name = $invoice->getClassName();
    $receptionist = $invoice->getReceptionist();
    $duration = $invoice->getDuration();
    $level = $invoice->getLevel();
    $time_shift = $invoice->getTimeShift();
    $start_time = $invoice->getStartTime();
    $end_time = $invoice->getEndTime();
    $fee = $invoice->getFee();
    $enroll_date = $invoice->getEnrollDate();
    $expire_paymentdate = $invoice->getExpirePaymentDate();
    $register_user = $invoice->getRegisterUser();
    $start_new = $invoice->getStart_new();
    $expire_new = $invoice->getExpire_new();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':invoice_date', $invoice_date);
    $stmt->bindParam(':invoice_number', $invoice_number);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':class_name', $class_name);
    $stmt->bindParam(':receptionist', $receptionist);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':time_shift', $time_shift);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':fee', $fee);
    $stmt->bindParam(':enroll_date', $enroll_date);
    $stmt->bindParam(':expire_paymentdate', $expire_paymentdate);
    $stmt->bindParam(':user_id', $register_user);
    $stmt->bindParam(':start_new', $start_new);
    $stmt->bindParam(':expire_new', $expire_new);
    $stmt->execute();   
    $lastid = $conn->lastInsertId();
    return $lastid;
}



function getAllInvoices(){
    $sql = "SELECT 
                invoice_id,
                student_id,
                class_name,
                receptionist,
                duration,
                level,
                time_shift,
                start_time,
                end_time,
                fee,
                invoice_date,
                enroll_date,
                expire_paymentdate,
                register_user,
                register_date,
                update_user,
                update_date,
                start_new,
                expire_new
            FROM T_Invoice
            WHERE del_flag = 0 ORDER BY invoice_id DESC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}



function getAllInvoicesUserRole($user){
    $sql = "SELECT 
                invoice_id,
                student_id,
                class_name,
                receptionist,
                duration,
                level,
                time_shift,
                start_time,
                end_time,
                fee,
                invoice_date,
                enroll_date,
                expire_paymentdate,
                register_user,
                register_date,
                update_user,
                update_date,
                start_new,
                expire_new
            FROM T_Invoice
            WHERE del_flag = 0 AND register_user= :user ORDER BY invoice_id DESC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;
}
function getAllStudentInvoices($student_id) {
    $sql = "SELECT 
                invoice_id,
                invoice_number,
                student_id,
                class_name,
                receptionist,
                duration,
                level,
                time_shift,
                start_time,
                end_time,
                fee,
                invoice_date,
                enroll_date,
                expire_paymentdate,
                register_user,
                register_date,
                update_user,
                update_date,
                start_new,
                expire_new
            FROM T_Invoice
            WHERE del_flag = 0 
            AND student_id = :student_id
            ORDER BY invoice_id DESC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();  
    $result = $stmt->fetchAll();
    return $result;    
}

function getOneInvoice($invoice_id) {
    $sql = "SELECT 
                invoice_id,
                invoice_number,
                student_id,
                class_name,
                receptionist,
                duration,
                level,
                time_shift,
                start_time,
                end_time,
                fee,
                invoice_date,
                enroll_date,
                expire_paymentdate,
                register_user,
                register_date,
                update_user,
                update_date,
                start_new,
                expire_new
            FROM T_Invoice
            WHERE del_flag = 0 
            AND invoice_id = :invoice_id
            ORDER BY invoice_date ASC";
    $conn = getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':invoice_id', $invoice_id);
    $stmt->execute();  
    $result = $stmt->fetch();
    $invoice = null;
    if (!empty($result)){
        $invoice = new Invoice;
        $invoice->setInvoiceID($result['invoice_id']);
        $invoice->setInvoiceNumber($result['invoice_number']);
        $invoice->setStudentID($result['student_id']);
        $invoice->setClassName($result['class_name']);
        $invoice->setReceptionist($result['receptionist']);
        $invoice->setDuration($result['duration']);
        $invoice->setLevel($result['level']);
        $invoice->setTimeShift($result['time_shift']);
        $invoice->setStartTime($result['start_time']);
        $invoice->setEndTime($result['end_time']);
        $invoice->setFee($result['fee']);
        $invoice->setInvoiceDate($result['invoice_date']);
        $invoice->setEnrollDate($result['enroll_date']);       
        $invoice->setExpirePaymentDate($result['expire_paymentdate']);
        $invoice->setRegisterUser($result['register_user']);
        $invoice->setUpdateUser($result['update_user']);
        $invoice->setRegisterDate($result['register_date']);
        $invoice->setUpdateDate($result['update_date']);
        $invoice->setStart_new($result['start_new']);
        $invoice->setExpire_new($result['expire_new']);
    }
    return $invoice;      
}



function deleteInvoice($user_id, $invoice_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Invoice 
                    SET 
                        del_flag = 1,
                        update_user = :user_id,
                        update_date = CURDATE()
                    WHERE 
                        invoice_id = :invoice_id";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':invoice_id',$invoice_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}



function deleteInvoiceStudent($user_id, $student_id){
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Invoice 
                    SET 
                        del_flag = 1,
                        update_user = :user_id,
                        update_date = CURDATE()
                    WHERE 
                        student_id = :student_id";
    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':student_id',$student_id);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->execute();
}


function updateInvoice($invoice) {
    $conn = getConnection();
    $sql = $sql =  "UPDATE 
                        T_Invoice 
                    SET 
                        invoice_number =:invoice_number,
                        invoice_date =:invoice_date,
                        fee = :fee,
                        duration = :duration,
                        receptionist = :receptionist,
                        expire_paymentdate = :expire_paymentdate,
                        update_user = :user_id,
                        update_date = CURDATE(),
                        start_new = :start_new,
                        expire_new = :expire_new
                    WHERE 
                        invoice_id = :invoice_id";

    $invoice_id = $invoice->getInvoiceID();
    $invoice_number = $invoice->getInvoiceNumber();
    $invoice_date = $invoice->getInvoiceDate();
    $duration = $invoice->getDuration();
    $expire_paymentdate = $invoice->getExpire_new();
    $update_user = $invoice->getUpdateUser();
    $fee = $invoice->getFee();
    $start_new= $invoice->getStart_new();
    $expire_new= $invoice->getExpire_new();
    $receptionist = $invoice->getReceptionist();

    $stmt = getConnection()->prepare($sql);
    $stmt->bindParam(':invoice_id', $invoice_id);
    $stmt->bindParam(':invoice_date', $invoice_date);
    $stmt->bindParam(':invoice_number', $invoice_number);
    $stmt->bindParam(':fee', $fee);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':expire_paymentdate', $expire_paymentdate);
    $stmt->bindParam(':start_new', $start_new);
    $stmt->bindParam(':expire_new', $expire_new);
    $stmt->bindParam(':receptionist', $receptionist);
    $stmt->bindParam(':user_id', $update_user);        
    $stmt->execute();    
}



?>