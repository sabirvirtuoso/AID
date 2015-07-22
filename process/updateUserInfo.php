<?php
$user_id = $_SESSION['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
//$student_id = $_POST['student_id'];
$batch = $_POST['batch'];
$department = $_POST['department'];
$position = $_POST['position'];
$employer = $_POST['employer'];
$sector = $_POST['sector'];
$city = $_POST['city'];
$country = $_POST['country'];
$nationality = $_POST['nationality'];
$email_primary = $_POST['email_primary'];
$email_alternative = $_POST['email_alternative'];
$phone_primary = $_POST['phone_primary'];
$phone_alternative = $_POST['phone_alternative'];
$mailing_address = $_POST['mailing_address'];
$blood_group = $_POST['blood_group'];
$iut_room_no = $_POST['iut_room_no'];
$interest = $_POST['interest'];
$awards = $_POST['awards'];

unset($_POST['email_primary']);

try {

    if($email_primary=="")
    {
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Sorry! Profile cannot be updated.Please provide your email';
    echo 'FAILURE';
    }
    else
    {
    $sql = "UPDATE user_info
        SET user_id=?, batch=?, department=?, first_name=?, last_name=?, position=?, employer=?, sector=?, nationality=?, email_primary=?, email_alternative=?, phone_primary=?, phone_alternative=?, city=?, country=?, mailing_address=?, blood_group=?, iut_room_no=?, interest=?, awards=? WHERE user_id=?";
    $sth = $dbconn->prepare($sql);
    $sth->bindParam(1, $user_id);
    $sth->bindParam(2, $batch);
    $sth->bindParam(3, $department);
    $sth->bindParam(4, $first_name);
     $sth->bindParam(5, $last_name);
    $sth->bindParam(6, $position);
    $sth->bindParam(7, $employer);
    $sth->bindParam(8, $sector);
    $sth->bindParam(9, $nationality);
    $sth->bindParam(10, $email_primary);
    $sth->bindParam(11, $email_alternative);
    $sth->bindParam(12, $phone_primary);
     $sth->bindParam(13, $phone_alternative);
    $sth->bindParam(14, $city);
    $sth->bindParam(15, $country);
    $sth->bindParam(16, $mailing_address);
     $sth->bindParam(17, $blood_group);
    $sth->bindParam(18, $iut_room_no);
    $sth->bindParam(19, $interest);
      $sth->bindParam(20, $awards);
      $sth->bindParam(21, $user_id);
    $sth->execute();
	$sqllastmodified = 'UPDATE user_info SET last_modified=:last_modified WHERE user_id = :user_id';
    $sthlastmodified = $dbconn->prepare( $sqllastmodified);
    $sthlastmodified->execute(array(':user_id' => $_SESSION['user_id'],':last_modified' => date('m-d-Y')));
    $_SESSION['batch']=$batch;
    echo 'SUCCESS';
    $_SESSION['msg_type'] = 's';
    $_SESSION['msg'] = 'Profile updated successfully';
    }
    } catch (PDOException $e){
    echo $e->getMessage();
   
}

?>