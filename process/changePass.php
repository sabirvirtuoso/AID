<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$oldpass=$_POST['old_pass'];
$newpass=$_POST['new_pass'];
$confpass=$_POST['new_pass_conf'];




$sql = 'SELECT password FROM user_info WHERE student_id = :student_id';
$sth = $dbconn->prepare($sql);
$sth->execute(array(':student_id' => $_SESSION['student_id']));
$result = $sth->fetch(PDO::FETCH_ASSOC);
$dbPass = $result['password'];




if (md5($oldpass) == $dbPass) {

    if($newpass==$confpass&&$newpass!=""&&$confpass!="") {
        try {
            $sql = 'UPDATE user_info SET password = :pass WHERE student_id = :student_id';
            $sth = $dbconn->prepare($sql);
            $sth->execute(array(':student_id' => $_SESSION['student_id'],':pass' => md5($newpass)));
            
            $sql2 = 'UPDATE user_meta SET force_pass_change = false WHERE user_id = :user_id';
            $sth2 = $dbconn->prepare($sql2);
            $sth2->execute(array(':user_id' => $_SESSION['user_id']));

            $_SESSION['msg_type'] = 's';
            $_SESSION['msg'] = 'Password Changed Successfully';
            header('location:index.php?page=profile');
            exit();
        }catch(PDOException $e) {
            echo $e->getMessage();

        }
    }

    else {
        $_SESSION['msg_type'] = 'e';
        $_SESSION['msg'] = 'Passwords do not match';
        header('location:index.php?page=profileEditSelf');
        exit();
    }
} else {
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Wrong Password or Empty Password';
    header('location:index.php?page=profileEditSelf');
    exit();
}





?>
